<?php

/**
 * Fired during plugin activation.
 * Display A Disclaimer on activate the plugin
 *
 * @since      1.3.1
 * @package    Qi_Gateway
 * @subpackage Qi_Gateway/includes
 * @author     Mahmood Abbas <contact@mahmoodshakir.com>
 */
class Qi_Gateway_Disclaimer
{
    /**
     * Initialize the class and set its properties.
     * @since    1.3.1
     * @access   public
     * @return   void
     */
    public static function init(){
        add_action('admin_notices', array('Qi_Gateway_Disclaimer', 'display_disclaimer'));
        add_action('wp_ajax_qi_gateway_accept_action', array('Qi_Gateway_Disclaimer', 'accept_action_callback'));
        add_action('wp_ajax_qi_gateway_reject_action', array('Qi_Gateway_Disclaimer', 'reject_action_callback'));
    }
    /**
     * Display a disclaimer on plugin activation
     * @since    1.3.1
     * @access   public
     * @return   void
     */
    public static function display_disclaimer()
    {
        $activated = get_option('qi_gateway_disclaimer_accepted', false);
        if (!$activated) {
            // This is the first activation, so show the modal
            ?>
            <div id="qi-gateway-disclaimer" style="display: none">
                <div id="qi-gateway-content">
                    <h2>Disclaimer Of Qi Gateway: UnOfficial Advanced Gateway Plugin</h2>
                    This plugin, Qi Gateway: UnOfficial Advanced Gateway, is provided on an "as is" and "as available"
                    basis, without any representations, warranties or conditions of any kind, whether express or
                    implied, including, but not limited to, representations, warranties or conditions of
                    merchantability, fitness for a particular purpose, title, non-infringement, and those arising from a
                    course of dealing, usage, or trade practice.
                    <br/>
                    In no event will the developer of this plugin be liable for any damages whatsoever, including, but
                    not limited to, direct, indirect, special, incidental, consequential, or punitive damages, arising
                    out of or in connection with the use, inability to use, or performance of this plugin. This
                    includes, but is not limited to, damages resulting from the use of this plugin to engage in hacking
                    or other illegal activities.
                    <br/>
                    The developer of this plugin will not be liable for any loss of profits, loss of business, business
                    interruption, loss of business opportunity, or loss of data.
                    <br/>
                    By using this plugin, you agree to the above disclaimer and accept all risks and liabilities that
                    may arise from your use of this plugin
                    <p>
                        <button id="qi-card-accept-button">Accept</button>
                        <button id="qi-card-reject-button">Reject</button>
                    </p>
                </div>
            </div>
            <?php
        }
    }
    /**
     * On Accept the disclaimer through ajax callback update the option
     * @since    1.3.1
     * @access   public
     * @return   void
     */
    public static function accept_action_callback()
    {
        update_option("qi_gateway_disclaimer_accepted", true);
        wp_die();
    }
    /**
     * On Reject the disclaimer through ajax callback deactivate the plugin 
     * @since    1.3.1
     * @access   public
     * @return   void
     */
    public static function reject_action_callback()
    {
        $plugin_file = plugin_dir_path(__DIR__) . 'qi-gateway.php';
        deactivate_plugins($plugin_file);
        wp_die();
    }

}

