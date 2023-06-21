<?php
/**
 *
 * define the hooks and settings of woocommerce payment gateway
 *
 * @package    Qi_Gateway
 * @subpackage Qi_Gateway/includes
 * @author     Mahmood Abbas <contact@mahmoodshakir.com>
 * @since      1.0.0
 */

defined('ABSPATH') || exit;

class Qi_Gateway_WC extends WC_Payment_Gateway
{
    /**
     * @since 1.0.0
     * @var string
     */
    public $title;
    /**
     * @since 1.0.0
     * @var string
     */
    public $description;
    /**
     * Private Key
     *
     * @since 1.0.0
     * @var string
     */
    private $key;
    /**
     * store currency
     *
     * @since 1.0.0
     * @var boolean
     */
    private $currency;

    /**
     * Define the core functionality of the plugin and add Qi to woocommerce gateways.
     *.
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->id = 'qi-gateway';
        $this->method_title = __('Qi Gateway', 'qi-gateway');
        $this->method_description = __('Have your customers pay with Qi-Card or MasterQi.', 'qi-gateway');
        $this->supports = array(
            'products',
        );
        // Load form fields
        $this->init_form_fields();
        // Load the settings.
        $this->init_settings();
        // Define user set variables
        $this->title = $this->get_option('title') ? $this->get_option('title') : 'Qi Service';
        $this->description = $this->get_option('description');
        $this->enabled = $this->get_option('enabled');
        $this->key = $this->get_option('key');
        $this->currency = $this->get_option('currency');

        if (empty($this->key)) {
            Qi_Gateway_Helper::showError(__('Qi Gateway was disabled, You must set Secret Key from  settings', 'qi-gateway'));
            $this->enabled = "no";
            $this->update_option('enabled', 'no');
        }
        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        add_filter('woocommerce_thankyou_order_received_text', array($this, 'order_received_text'), 10, 2);

    }

    /**
     * initial settings fields for the gateway
     *
     * @since 1.0.0
     */
    public function init_form_fields()
    {
        $this->form_fields = array(
            'enabled' => array(
                'title' => __('Enable', 'qi-gateway'),
                'label' => __('Enable Qi Gateway', 'qi-gateway'),
                'type' => 'checkbox',
                'default' => 'no',
            ),
            'title' => array(
                'title' => __('Title', 'qi-gateway'),
                'label' => __('Payment Option Title', 'qi-gateway'),
                'type' => 'text',
                'default' => 'Qi Gateway',
            ),
            'description' => array(
                'title' => __('Description', 'qi-gateway'),
                'type' => 'textarea',
                'description' => __('This description is what user see when choose qi gateway', 'qi-gateway'),
                'default' => __('Pay via Qi with your QiCard or MasterQi'),
            ),
            'key' => array(
                'title' => __('Secret Key', 'qi-gateway'),
                'type' => 'text',
            ),
            'currency' => array(
                'title' => __('Currency', 'qi-gateway'),
                'type' => 'select',
                'options' => array(
                    'IQD' => 'IQD',
                    'USD' => 'USD',
                )
            ),
        );
    }

    /**
     * Customize order received text for woocommerce when customer use qi gateway.
     *
     * @since    1.0.0
     */
    public function order_received_text($text, $order)
    {
        if ($order->get_payment_method() === 'qi-gateway') {
            echo __('Dear Mr/Mrs.', 'qi-gateway') . PHP_EOL . $order->get_billing_first_name() . '<br />';
            echo __('An invoice has been created for your order, please pay the bill through Qi platform', 'qi-gateway') . '<br />';
            echo '<a href="https://pay.qi.iq?authToken=' . $order->get_meta('_qi_order_token') . '" class="button wc-qi-button">' . __("Pay Bill", "qi") . '</a>';
        } else {
            echo $text;
        }
    }

    /**
     * on choose pay using qi gateway crate bill for user order and change the status
     * of the order to pending and store Qi meta in the order
     *
     * @param int $order_id
     * @return array|void
     * @since 1.0.0
     */
    public function process_payment($order_id)
    {
        global $woocommerce;
        $order = wc_get_order($order_id);

        if (!$this->validate_phone_number($order->get_billing_phone())) {
            wc_add_notice(__('Error: Invalid phone number', 'qi-gateway'), 'error');
            return;
        }

        // create qi bill
        $request = $this->create_bill($order);

        // decode request response
        $response = json_decode(wp_remote_retrieve_body($request), true);
        $statusCode = wp_remote_retrieve_response_code($request);

        /**
         * handle request status code
         * 201 - order has been created
         * 400 - order has issues
         * default - something wrong
         */
        switch ($statusCode) {
            case 201:
                echo 1;
                // update order status to pending
                $order->update_status('pending', __('Awaiting bill payment', 'qi-gateway'));
                // store qi meta data
                add_post_meta($order->get_id(), "_qi_order_token", $response['data']['token']);
                add_post_meta($order->get_id(), "_qi_order_transactionId", $response['data']['transactionId']);
                add_post_meta($order->get_id(), "_qi_order_3dSecureId", $response['data']['3DSecureId']);
                add_post_meta($order->get_id(), "_qi_order_number", $order->get_order_number());
                // add log
                Qi_Gateway_Helper::Logger($order_id, QiCustomerOperations::CREATE, QiOperationStatus::SUCCESS, $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(), '', get_woocommerce_currency(), $order->get_total());
                // empty cart
                $woocommerce->cart->empty_cart();
                return array(
                    'result' => 'success',
                    'redirect' => $this->get_return_url($order),
                );
            case 400:
                echo 2;
                wc_add_notice(__($response['message'], 'qi-gateway'), 'error');
                Qi_Gateway_Helper::Logger($order_id, QiCustomerOperations::CREATE, QiOperationStatus::FAIL, $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(), '', get_woocommerce_currency(), $order->get_total());
                break;
            default:
                wc_add_notice(__('Something Wrong, Please try again later.', 'qi-gateway') . $statusCode, 'error');
                Qi_Gateway_Helper::Logger($order_id, QiCustomerOperations::CREATE, QiOperationStatus::FAIL, $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(), '', get_woocommerce_currency(), $order->get_total());
                break;
        }
    }

    /**
     * validate mobile number with specific rules: mobile should contain 07[x] and length should be 11
     *
     * @param string $mobileNo
     * @return bool
     * @since    1.2.2
     */
    private function validate_phone_number(string $mobileNo): bool
    {
        if (!preg_match_all('/07[3-9][0-9]/', $mobileNo)) {
            return false;
        }
        if (strlen($mobileNo) !== 11) {
            return false;
        }
        return true;
    }

    /**
     * Create bill in Qi Gateway for the order
     * @param WC_Order $order
     * @return array|WP_Error
     */
    private function create_bill(WC_Order $order)
    {
        $amount = $order->get_total() + 0;
        // request body for creating new bill for qi
        $args = array(
            'order' => array(
                'amount' => $amount,
                'currency' => $this->currency,
                'orderId' => strval($order->get_id())
            ),
            'timestamp' => date(DateTime::ATOM),
            'successUrl' => get_site_url(),
            'failureUrl' => get_site_url(),
            'cancelUrl' => get_site_url()
        );
        // add Authorization to request header
        $headers = array(
            'Authorization' => $this->key,
        );
        return Qi_Gateway_Helper::Request(API_DOMAIN . '/transactions/business/token', 'POST', $args, $headers);
    }
}
