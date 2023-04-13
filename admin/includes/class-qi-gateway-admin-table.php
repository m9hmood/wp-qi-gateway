<?php
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}
/**
 * Define the admin page table class for logs
 * 
 * @package Qi_Gateway
 * @subpackage Qi_Gateway/admin
 * @author Mahmood Abbas <contact@mahmoodshakir.com>
 * @since 1.0.0
 * @see WP_List_Table
 * @see https://developer.wordpress.org/reference/classes/wp_list_table/
 */
class QI_GATEWAY_ADMIN_TABLE extends WP_List_Table
{

    function __construct()
    {
        global $status, $page;

        //Set parent defaults
        parent::__construct(array(
            'singular' => 'log', //singular name of the listed records
            'plural' => 'logs', //plural name of the listed records
            'ajax' => false        //does this table support ajax?
        ));
    }

    function column_default($item, $column_name)
    {
        if ($column_name === 'status') {
            $status = $item->$column_name === 'success' ? __('success', 'qi-gateway') : __('failed', 'qi-gateway');
            if ($item->$column_name === 'success') return "<span style='color: green;font-weight: bold'>{$status}</span>";
            if ($item->$column_name === 'failed') return "<span style='color: red;font-weight: bold'>{$status}</span>";
        }
        if($column_name === "operation"){
           return $item->$column_name === 'create order' ? __('create order', 'qi-gateway') : __('order payment', 'qi-gateway');
        }
        return $item->$column_name;
    }

    function get_columns()
    {
        return $columns = array(
            'id' => __('ID'),
            'order_id' => __('Order Id', 'qi-gateway'),
            'operation' => __('Operation', 'qi-gateway'),
            'status' => __('Status'),
            'cardHolder' => __('Card Holder', 'qi-gateway'),
            'maskedCardNumber' => __('Card Number', 'qi-gateway'),
            'currency' => __('Currency', 'qi-gateway'),
            'amount' => __('Amount', 'qi-gateway'),
            'create_date' => __('Create Date', 'qi-gateway')
        );
    }


    function prepare_items()
    {
        global $wpdb;
        /**
         * remove _wp_http_referer and _wpnonce to avoid url length issues
         *
         * _wp_http_referer and _wpnonce is added by wordpress wp_list_table class
         */
        if (!empty($_GET['_wp_http_referer'])) {
            wp_redirect(remove_query_arg(array('_wp_http_referer', '_wpnonce'), stripslashes($_SERVER['REQUEST_URI'])));
            exit;
        }

        $table_name = $wpdb->prefix . "qi_logs";
        $query = "SELECT * FROM $table_name";

        $order_by = !empty($_GET["orderby"]) ? esc_sql($_GET["orderby"]) : 'DESC';
        $order = !empty($_GET["order"]) ? esc_sql($_GET["order"]) : '';
        $paged = !empty($_GET["paged"]) ? esc_sql($_GET["paged"]) : '';
        $search = !empty($_GET["s"]) ? esc_sql($_GET["s"]) : '';

		$query .= ' ORDER BY create_date DESC';
        
        if (empty($paged) || !is_numeric($paged) || $paged <= 0) {
            $paged = 1;
        }
        /**
         * add search query to sql command when search value is not equal null
         */
        if (!empty($search) & !empty($search)) {
            $query .= " WHERE order_id LIKE '{$search}' ";
        }

        // get total items count from database
        $total_items = $wpdb->query($query);
        // set how many items you want to show in the table
        $per_page = 10;


        if (!empty($paged) && !empty($per_page)) {
            $offset = ($paged - 1) * $per_page;
            $query .= ' LIMIT ' . (int)$offset . ',' . (int)$per_page;
        }
        /**
         * set pagination bar settings
         */
        $total_pages = ceil($total_items / $per_page);
        $this->set_pagination_args(array(
            "total_items" => $total_items,
            "total_pages" => $total_pages,
            "per_page" => $per_page,
        ));

        // set table columns
        $columns = $this->get_columns();

        // set table headers
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);

        // set table items
        $this->items = $wpdb->get_results($query);
    }

}
