<?php
/*
Plugin Name: Lkc Elementor Widgets
Version: 1.0.0
Plugin URI: https://resize.rs/
Description: Custom Lkc elementor widgets.
Author: LKC TEAM
Author URI: https://resize.rs/
*/

use Elementor\Widgets_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!defined('LKC_PLUGIN_FILE')) {
    define('LKC_PLUGIN_FILE', __FILE__);
}

class Lkc_Elementor_Widgets
{

    /**
     * Plugin Version
     *
     * @since 1.0.0
     *
     * @var string The plugin version.
     */
    const VERSION = '1.0.0';

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     *
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.5.11';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     *
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '6.0';

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     * The single instance of the class.
     */
    protected static $instance = null;

    public static function get_instance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */

    protected function __construct()
    {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);

            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);

            return;
        }

        $this->enqueue_widgets();

        // Register Widget Categories
        add_action('elementor/elements/categories_registered', [$this, 'register_widget_categories']);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_missing_main_plugin()
    {

        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
        /* 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'lkc-elementor-widgets'),
            '<strong>' . esc_html__('Lkc Elementor Widgets', 'lkc-elementor-widgets') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'lkc-elementor-widgets') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_elementor_version()
    {

        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
        /* 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'lkc-elementor-widgets'),
            '<strong>' . esc_html__('Lkc Elementor Widgets', 'lkc-elementor-widgets') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'lkc-elementor-widgets') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_minimum_php_version()
    {

        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
        /* 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'lkc-elementor-widgets'),
            '<strong>' . esc_html__('Lkc Elementor Widgets', 'lkc-elementor-widgets') . '</strong>',
            '<strong>' . esc_html__('PHP', 'lkc-elementor-widgets') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }

    /**
     * Enqueues basic widgets for registration
     *
     * @return void
     */
    public function enqueue_widgets()
    {
        //Require widget files
        $this->require_widget_files();
		
        // Register Basic Widgets
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);

        // Register Basic Widget Styles
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_widget_styles']);
    }

    /**
     * Require basic widget files
     *
     * @return void
     */
    public function require_widget_files()
    {

    }

    /**
     * Registers basic widgets
     *
     * @param Widgets_Manager $widget_manager
     *
     * @return void
     */
    public function register_widgets(Widgets_Manager $widget_manager)
    {

    }

    /**
     * Enqueues basic widget styles
     *
     * @return void
     */
    public function enqueue_widget_styles()
    {
        wp_enqueue_style(
            'lkc-elementor-widgets-stylesheet',
            plugins_url('/assets/css/lkc-elementor-widgets.css', LKC_PLUGIN_FILE)
        );
    }

    /**
     * Register custom categories
     *
     * @void
     */
    public function register_widget_categories($elements_manager)
    {
        $elements_manager->add_category(
            'lkc',
            array(
                'title' => esc_html__('LKC', 'lkc'),
                'icon' => 'fa fa-plug',
            )
        );
    }

}


add_action('init', 'lkc_elementor_init');
function lkc_elementor_init()
{
    Lkc_Elementor_Widgets::get_instance();
}

