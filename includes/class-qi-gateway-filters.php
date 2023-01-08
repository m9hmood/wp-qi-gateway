<?php
/**
 *
 * Define the payment gateway filters for woocommerce;
 *
 * @package    Qi_Gateway
 * @subpackage Qi_Gateway/includes
 * @author     Mahmood Abbas <contact@mahmoodshakir.com>
 */
class Qi_Gateway_Filters
{
    /**
     * Handle a custom 'qi_order_number' query var to get orders with the 'qi_order_number' meta.
     * @param array $query - Args for WP_Query.
     * @param array $query_vars - Query vars from WC_Order_Query.
     * @return array modified $query
     */
    public function add_qi_meta_to_query($query, $query_vars)
    {
        if (!empty($query_vars['_qi_order_token'])) {
            $query['meta_query'][] = array(
                'key' => '_qi_order_token',
                'value' => esc_attr($query_vars['_qi_order_token']),
            );
        }
        return $query;
    }

}