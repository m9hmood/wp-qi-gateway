<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://mahmoodshakir.com/
 * @since             1.0.0
 * @package           Qi_Gateway
 *
 * @wordpress-plugin
 * Plugin Name:       Qi Gateway: UnOfficial Advanced Gateway Plugin
 * Plugin URI:        https://qi.mahmoodshaki.com/
 * Description:       Add Qi Card as payment method for Wordpress easily.
 * Version:           1.3.1
 * Author:            Mahmood A.Shakir
 * Author URI:        https://mahmoodshaki.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       qi-gateway
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require_once "enums/qi-gateway-enums.php";

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('QI_GATEWAY_VERSION', '1.3.1');


/**
 * Api URL
 */
define('API_DOMAIN', 'https://api.pay.qi.iq/api/v0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-qi-gateway-activator.php
 */
function activate_qi_gateway()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-qi-gateway-activator.php';
    Qi_Gateway_Activator::activate();

}


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-qi-gateway-deactivator.php
 */
function deactivate_qi_gateway()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-qi-gateway-deactivator.php';
    Qi_Gateway_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_qi_gateway');
register_deactivation_hook(__FILE__, 'deactivate_qi_gateway');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-qi-gateway.php';


/**
 * Update checker for plugin
 *
 * @since 1.0.0
 */
if (is_admin()) {
    if (!class_exists('Puc_v4_Factory')) {
        require_once plugin_dir_path(__FILE__) . 'includes/libraries/plugin-update-checker-4.9/plugin-update-checker.php';
        $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
            'https://plugins.mahmoodshakir.com/qi.json',
            __FILE__, //Full path to the main plugin file or functions.php.
            'qi-gateway'
        );
    }
    if(!class_exists('Qi_Gateway_Disclaimer')) {
        require_once "includes/class-qi-gateway-disclaimer.php";
        Qi_Gateway_Disclaimer::init();
    }
}


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_qi_gateway()
{
    if (class_exists('WC_Payment_Gateway')) {
        $plugin = new Qi_Gateway();
        $plugin->run();
    } else {
        add_action('admin_notices', function () {
            ?>
            <div class="error notice">
                <p><?php echo __('Sorry, you need to install Woocommerce plugin to use Qi Gateway') ?></p>
            </div>
            <?php
        });
    }
}

add_filter('plugins_loaded', 'run_qi_gateway');
