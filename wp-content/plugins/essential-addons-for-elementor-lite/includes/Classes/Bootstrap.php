<?php

namespace Essential_Addons_Elementor\Classes;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

use Essential_Addons_Elementor\Classes\WPDeveloper_Dashboard_Widget;

class Bootstrap
{
    use \Essential_Addons_Elementor\Traits\Library;
    use \Essential_Addons_Elementor\Traits\Shared;
    use \Essential_Addons_Elementor\Traits\Core;
    use \Essential_Addons_Elementor\Traits\Helper;
    use \Essential_Addons_Elementor\Traits\Generator;
    use \Essential_Addons_Elementor\Traits\Enqueue;
    use \Essential_Addons_Elementor\Traits\Admin;
    use \Essential_Addons_Elementor\Traits\Elements;
    use \Essential_Addons_Elementor\Classes\WPML\Eael_WPML;

    // instance container
    private static $instance = null;

    // dev mode
    public $dev_mode;

    // request unique identifier
    protected $request_uid = null;

    // registered elements container
    public $registered_elements;

    // registered extensions container
    public $registered_extensions;

    // transient elements container
    public $transient_elements;

    // transient elements container
    public $transient_extensions;

    // additional settings
    public $additional_settings;

    // identify whether pro is enabled
    public $pro_enabled;

    // localize objects
    public $localize_objects;

    /**
     * Singleton instance
     *
     * @since 3.0.0
     */
    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Constructor of plugin class
     *
     * @since 3.0.0
     */
    private function __construct()
    {
        // dev mode
        add_filter('eael/dev_mode', [$this, 'dev_mode']);

        // before init hook
        do_action('eael/before_init');

        // search for pro version
        $this->pro_enabled = apply_filters('eael/pro_enabled', false);

        // elements classmap
        $this->registered_elements = apply_filters('eael/registered_elements', $GLOBALS['eael_config']['elements']);

        // extensions classmap
        $this->registered_extensions = apply_filters('eael/registered_extensions', $GLOBALS['eael_config']['extensions']);

        // additional settings
        $this->additional_settings = apply_filters('eael/additional_settings', [
            'quick_tools' => true,
        ]);

        // initialize transient container
        $this->transient_elements   = [];
        $this->transient_extensions = [];

        // start plugin tracking
        if (!$this->pro_enabled) {
            $this->start_plugin_tracking();
        }

        // register extensions
        $this->register_extensions();

        // register hooks
        $this->register_hooks();
    }

    protected function dev_mode()
    {
        return $_SERVER["REMOTE_ADDR"] == "127.0.0.1";
    }

    protected function register_hooks()
    {
        // Core
        add_action('init', [$this, 'i18n']);
        add_filter('eael/active_plugins', [$this, 'active_plugins'], 10, 1);
        add_filter('wpml_elementor_widgets_to_translate', [$this, 'eael_translatable_widgets']);
        add_action('elementor/editor/after_save', array($this, 'save_global_values'), 10, 2);

        // Generator
        add_action('wp', [$this, 'generate_request_uid']);
        add_action('elementor/frontend/before_render', array($this, 'collect_transient_elements'));
        add_action('elementor/frontend/before_enqueue_scripts', array($this, 'generate_frontend_scripts'));

        // Enqueue
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('elementor/editor/before_enqueue_scripts', array($this, 'editor_enqueue_scripts'));

        // Ajax
        add_action('wp_ajax_load_more', array($this, 'eael_load_more_ajax'));
        add_action('wp_ajax_nopriv_load_more', array($this, 'eael_load_more_ajax'));

        add_action('wp_ajax_facebook_feed_load_more', [$this, 'facebook_feed_render_items']);
        add_action('wp_ajax_nopriv_facebook_feed_load_more', [$this, 'facebook_feed_render_items']);

        add_action('wp_ajax_woo_checkout_update_order_review', [$this, 'woo_checkout_update_order_review']);
        add_action('wp_ajax_nopriv_woo_checkout_update_order_review', [$this, 'woo_checkout_update_order_review']);

        // Elements
        add_action('elementor/elements/categories_registered', array($this, 'register_widget_categories'));
        add_action('elementor/widgets/widgets_registered', array($this, 'register_elements'));
        add_filter('elementor/editor/localize_settings', [$this, 'promote_pro_elements']);
        add_action('wp_footer', array($this, 'render_global_html'));

        add_filter('eael/event-calendar/source', [$this, 'eael_event_calendar_source']);
        add_action('eael/advanced-data-table/source/control', [$this, 'advanced_data_table_source_control']);
        add_filter('eael/advanced-data-table/table_html/integration/ninja', [$this, 'advanced_data_table_ninja_integration'], 10, 1);

        //rank math support
        add_filter( 'rank_math/researches/toc_plugins', [$this, 'eael_toc_rank_math_support']);
        // Admin
        if (is_admin()) {
            // Admin
            if (!$this->pro_enabled) {
                // TODO: you have to call admin_notice for pro also.
            }
            $this->admin_notice(); // this line of code

            // dashboard feed
            WPDeveloper_Dashboard_Widget::instance();

            add_action('admin_menu', array($this, 'admin_menu'));
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
            add_action('wp_ajax_save_settings_with_ajax', array($this, 'save_settings'));
            add_action('wp_ajax_clear_cache_files_with_ajax', array($this, 'clear_cache_files'));

            // Core
            add_filter('plugin_action_links_' . EAEL_PLUGIN_BASENAME, array($this, 'insert_plugin_links'));
            add_filter('plugin_row_meta', array($this, 'insert_plugin_row_meta'), 10, 2);

            // removed activation redirection temporarily
            // add_action('admin_init', array($this, 'redirect_on_activation'));

            if (!did_action('elementor/loaded')) {
                add_action('admin_notices', array($this, 'elementor_not_loaded'));
            }

        }

        if (current_user_can('manage_options')) {
            add_action('admin_bar_menu', [$this, 'admin_bar'], 900);
        }

        // On Editor - Register WooCommerce frontend hooks before the Editor init.
        // Priority = 5, in order to allow plugins remove/add their wc hooks on init.
        if (!empty($_REQUEST['action']) && 'elementor' === $_REQUEST['action'] && is_admin()) {
            add_action('init', [$this, 'register_wc_hooks'], 5);
        }
    }
}
