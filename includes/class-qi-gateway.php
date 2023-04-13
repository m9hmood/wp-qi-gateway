<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Qi_Gateway
 * @subpackage Qi_Gateway/includes
 * @author     Mahmood Abbas <contact@mahmoodshakir.com>
 */
class Qi_Gateway
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Qi_Gateway_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('QI_GATEWAY_VERSION')) {
            $this->version = QI_GATEWAY_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'qi-gateway';

        $this->load_dependencies();
        $this->set_locale();
        $this->set_filters();
        $this->set_callback();
        $this->set_admin_page();
        $this->add_woocommerce_gateway();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Qi_Gateway_Loader. Orchestrates the hooks of the plugin.
     * - Qi_Gateway_i18n. Defines internationalization functionality.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-qi-gateway-loader.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-qi-gateway-i18n.php';
        /**
         * The class responsible for defining helper methods
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-qi-gateway-helper.php';
        /**
         * The class responsible for defining new woocommerce gateway
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-qi-gateway-woocommerce.php';
        /**
         * The class responsible adding for custom filters for wordpress
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-qi-gateway-filters.php';
        /**
         * The class responsible adding for add adming page for wordpress
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-qi-gateway-admin.php';
        /**
         * The class responsible adding for Qi callback for wordpress
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-qi-gateway-callback.php';

        $this->loader = new Qi_Gateway_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Qi_Gateway_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new Qi_Gateway_i18n();
        $plugin_i18n->load_plugin_textdomain();
    }

    /**
     * Register All filters for the plugin
     * @since 1.0.0
     */
    private function set_filters()
    {
        $plugin_filters = new Qi_Gateway_Filters();
        $this->loader->add_filter('woocommerce_order_data_store_cpt_get_orders_query', $plugin_filters, 'add_qi_meta_to_query', 10, 2);

    }

    /**
     * Register callback method for the plugin
     * @since 1.2.0
     */
    private function set_callback(){
        $plugin_filters = new Qi_Gateway_Callback();
        $this->loader->add_filter('send_headers', $plugin_filters, 'check_order_by_token');
    }

    /**
     * Register a new payment gateway for woocommerce.
     * @access   private
     * @since    1.0.0
     */
    private function add_woocommerce_gateway()
    {
        add_filter('woocommerce_payment_gateways', function ($methods) {
            $methods[] = 'Qi_Gateway_WC';
            return $methods;
        });

    }

    /**
     * Register admin page for Qi Gateway Logs
     * @access private
     * @since 1.3.0
     */
    private function set_admin_page(){
        $plugin_admin = new Qi_Gateway_Admin();
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_menu_page_to_admin');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Qi_Gateway_Loader    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function get_version()
    {
        return $this->version;
    }


}
