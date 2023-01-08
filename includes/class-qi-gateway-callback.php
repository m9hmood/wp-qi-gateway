<?php
/**
 * Payment gateway callback handling class
 *
 * @package    Qi_Gateway
 * @subpackage Qi_Gateway/includes
 * @author     Mahmood Abbas <contact@mahmoodshakir.com>
 */
class Qi_Gateway_Callback
{
    /**
     * Check order status by token
     *
     * @throws \Exception
     */
    public function check_order_by_token()
    {
        if (isset($_GET['authToken']) && !empty($_GET['authToken'])) {
            $this->handleAuthToken();
        }

        if (isset($_GET['orderToken']) && !empty($_GET['orderToken'])) {
            $this->handleOrderToken();
        }
    }

    /**
     * Handle auth token
     *
     * @throws \Exception
     */
    private function handleAuthToken()
    {
        // get order by transToken
        $orders = wc_get_orders(array('_qi_order_token' => $_GET['authToken']));
        // check order is exist or not
        if (count($orders) === 0) {
                echo '<div style="width: 90%; margin: 5px auto; background: gainsboro; padding: 10px; text-align: center; border-radius: 5px;">';
                echo __('sorry, we couldn\'t find the order', 'qi-gateway');
                echo '</div>';
                return;
        }

        // get transiction id
        $order_transaction_id = $orders[0]->get_meta('_qi_order_transactionId');
        // get order id
        $order_id = $orders[0]->get_id();

        // set secret key in header
        $headers = array(
            'Authorization' => $this->getPaymentGatewaySettings()->settings['key'],
        );

        try {
            $response = Qi_Gateway_Helper::Request(API_DOMAIN . '/transactions/business/' . $order_transaction_id . '/' . $order_id, 'GET', array(), $headers);
            $response_data = json_decode($response->getBody(), true);

            if ($response_data['data']['QIGatewayResponse'] === 'SUCCESS') {
                $orders[0]->update_status('processing');
                Qi_Gateway_Helper::Logger(
                    $order_id,
                    QiCustomerOperations::Payment,
                    QiOperationStatus::Success,
                    $response_data['data']['cardHolder'],
                    $response_data['data']['maskedCardNumber'],
                    $response_data['data']['currency'],
                    $response_data['data']['amount']
                );
                echo '<div style="width: 90%; margin: 5px auto; background: gainsboro; padding: 10px; text-align: center; border-radius: 5px;">';
                echo __('Order Status has been set to paid', 'qi-gateway');
                echo '</div>';
            } else {
                $orders[0]->update_status('failed');
                Qi_Gateway_Helper::Logger($order_id, QiCustomerOperations::Payment, QiOperationStatus::Fail);
                echo '<div style="width: 90%; margin: 5px auto; background: gainsboro; padding: 10px; text-align: center; border-radius: 5px;">';
                echo __('Payment Failed', 'qi-gateway');
                echo '</div>';
            }
        } catch (\Exception $e) {
            // log error and display message
            Qi_Gateway_Helper::Logger($order_id, QiCustomerOperations::Payment, QiOperationStatus::Error, $e->getMessage());
            echo '<div style="width: 90%; margin: 5px auto; background: gainsboro; padding: 10px; text-align: center; border-radius: 5px;">';
            echo __('An error occurred while processing the payment', 'qi-gateway');
            echo '</div>';
        }
    }

    /**
     * Handle order token
     */
    private function handleOrderToken()
    {
        $order = wc_get_order($_GET['orderToken']);
        
        if ($order) {
            echo '<div style="width: 90%; margin: 5px auto; background: gainsboro; padding: 10px; text-align: center; border-radius: 5px;">';
            echo $order->get_meta('_qi_order_token');
            echo '</div>';
        } else {
            echo '<div style="width: 90%; margin: 5px auto; background: gainsboro; padding: 10px; text-align: center; border-radius: 5px;">';
            echo __('Sorry, we couldn\'t find the order', 'qi-gateway');
            echo '</div>';
        }
    }

    /**
     * Get payment gateway settings
     *
     * @return WC_Payment_Gateway
     */
    private function getPaymentGatewaySettings()
    {
        $payment_gateways = WC_Payment_Gateways::instance();
        return $payment_gateways->payment_gateways()['qi-gateway'];
    }
}
