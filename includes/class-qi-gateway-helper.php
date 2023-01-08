<?php
/**
 *
 * A list of helpers methods for qi gateway
 *
 * @package    Qi_Gateway
 * @subpackage Qi_Gateway/includes
 * @author     Mahmood Abbas <contact@mahmoodshakir.com>
 */
defined('ABSPATH') || exit;

class Qi_Gateway_Helper
{
    /**
     * Request helper method to make http requests
     *
     * @param string $url
     * @param string $method
     * @param array $body
     * @param array $headers
     * @since 1.0.0
     * @return array|WP_Error
     */
    static function Request($url, $method, $body, $headers = [])
    {
        $headers = array_merge(array(
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
        ), $headers);

        $args = array(
            'method' => $method,
            'headers' => $headers,
            'data_format' => 'body',
        );

        if ($method !== 'GET') $args['body'] = json_encode($body);
        // login
        return wp_remote_request($url, $args);
    }

    /**
     * show error message in admin panel
     *
     * @param string $text
     * @since 1.0.0
     * @return void
     */
    static function showError($text)
    {
        add_action('admin_notices', function () use ($text) {
            ?>
            <div class="error notice">
                <p><?php echo $text ?></p>
            </div>
            <?php
        });
    }

    /**
     * Logger method to log all requests and responses
     * 
     * @param string $order_id
     * @param string $operation
     * @param string $status
     * @param null $card_holder
     * @param null $card_number
     * @param null $currency
     * @param null $amount
     * @since 1.0.0
     * @return void
     */
    static function Logger($order_id, $operation, $status, $card_holder = null, $card_number = null, $currency = null, $amount = null)
    {
        global $wpdb;

        $wpdb->insert("{$wpdb->base_prefix}qi_logs", [
            'order_id' => $order_id,
            'operation' => $operation,
            'status' => $status,
            'cardHolder' => $card_holder,
            'maskedCardNumber' => $card_number,
            'currency' => $currency,
            'amount' => $amount,
            'create_date' => gmdate('Y-m-d H:i:s'),
        ]);


    }
}