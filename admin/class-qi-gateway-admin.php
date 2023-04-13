<?php
/**
 * Qi-Gateway admin page class
 * 
 * define the hooks and settings for admin page
 *
 * @package    Qi_Gateway
 * @subpackage Qi_Gateway/admin
 * @author     Mahmood Abbas <contact@mahmoodshakir.com>
 * @since      1.0.0
 */
class Qi_Gateway_Admin
{

    public function add_menu_page_to_admin()
    {
        add_menu_page(__('Qi Logs', 'qi-gateway'), __('Qi Logs', 'qi-gateway'), 'manage_options', 'qi-logs.php', array($this, 'qi_admin_page'));
        add_action( 'admin_enqueue_scripts', array($this, 'qi_admin_scripts'));

    }

    public function qi_admin_page()
    {
        include "partials/bills-statistics.php";
        include "partials/files-table.php";
    }

    public function qi_admin_scripts(){
        wp_enqueue_style( 'qi-gateway-css', plugin_dir_url(__FILE__) . 'assets/css/admin-style.css' );
        wp_enqueue_script( 'qi-gateway-js', plugin_dir_url(__FILE__) . 'assets/js/qi-gateway.js' );
    }
}