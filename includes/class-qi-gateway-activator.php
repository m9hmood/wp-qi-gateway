<?php


/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Qi_Gateway
 * @subpackage Qi_Gateway/includes
 * @author     Mahmood Abbas <contact@mahmoodshakir.com>
 */
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

class Qi_Gateway_Activator
{

    /**
     * Initialize the plugin table on plugin activation 
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . "qi_logs";
        $sql = "CREATE TABLE $table_name (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          order_id varchar(255) NOT NULL,
          operation varchar(255) NOT NULL,
          status varchar(255) NOT NULL,
          cardHolder varchar(255),
          maskedCardNumber varchar(255),
          currency varchar(255),
          amount varchar(255),
          create_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";
        dbDelta($sql);
    }
}
