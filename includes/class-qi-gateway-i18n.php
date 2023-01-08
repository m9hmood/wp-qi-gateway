<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Qi_Gateway
 * @subpackage Qi_Gateway/includes
 * @author     Mahmood Abbas <contact@mahmoodshakir.com>
 */
class Qi_Gateway_i18n
{
    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain('qi-gateway', false, dirname(plugin_basename(__FILE__)) . '/../languages/');
    }
}
