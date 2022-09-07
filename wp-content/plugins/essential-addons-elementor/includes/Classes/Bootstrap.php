<?php

namespace Essential_Addons_Elementor\Pro\Classes;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class Bootstrap
{
    use \Essential_Addons_Elementor\Traits\Shared;
    use \Essential_Addons_Elementor\Pro\Traits\Library;
    use \Essential_Addons_Elementor\Pro\Traits\Core;
    use \Essential_Addons_Elementor\Pro\Traits\Extender;
    use \Essential_Addons_Elementor\Pro\Traits\Enqueue;
    use \Essential_Addons_Elementor\Pro\Traits\Helper;
    use \Essential_Addons_Elementor\Pro\Classes\WPML\Eael_WPML;

    // instance container
    private static $instance = null;

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
        // mark pro version is enabled
        add_filter('eael/pro_enabled', '__return_true');

        // injecting pro elements
        add_filter('eael/registered_elements', array($this, 'inject_new_elements'));
        add_filter('eael/registered_extensions', array($this, 'inject_new_extensions'));
        add_filter('eael/post_args', [$this, 'eael_post_args']);

        // register hooks
        $this->register_hooks();

        // license
        $this->eael_plugin_licensing();
    }

    public function register_hooks()
    {
        // Extender filters
        add_filter('add_eael_progressbar_layout', [$this, 'add_progressbar_pro_layouts']);
        add_filter('fancy_text_style_types', [$this, 'fancy_text_style_types']);
        add_filter('eael_ticker_options', [$this, 'eael_ticker_options']);
        add_filter('eael_progressbar_rainbow_wrap_class', [$this, 'progress_bar_rainbow_class'], 10, 2);
        add_filter('eael_progressbar_circle_fill_wrap_class', [$this, 'progress_bar_circle_fill_class'], 10, 2);
        add_filter('eael_progressbar_half_circle_wrap_class', [$this, 'progressbar_half_circle_wrap_class'], 10, 2);
        add_filter('eael_progressbar_general_style_condition', [$this, 'progressbar_general_style_condition']);
        add_filter('eael_progressbar_line_fill_stripe_condition', [$this, 'progressbar_line_fill_stripe_condition']);
        add_filter('eael_circle_style_general_condition', [$this, 'circle_style_general_condition']);
        add_filter('eael_pricing_table_styles', [$this, 'add_pricing_table_styles']);
        add_filter('pricing_table_subtitle_field_for', [$this, 'pricing_table_subtitle_field']);
        add_filter('eael/advanced-data-table/table_html/database', [$this, 'advanced_data_table_database_html'], 10, 1);
        add_filter('eael/advanced-data-table/table_html/integration/google_sheets', [$this, 'advanced_data_table_google_sheets_integration'], 10, 1);
        add_filter('eael/advanced-data-table/table_html/integration/tablepress', [$this, 'advanced_data_table_tablepress_integration'], 10, 1);
        add_filter('eael/event-calendar/integration', [$this, 'event_calendar_eventon_integration'], 10, 2);
        add_filter('eael_team_member_style_presets_condition', [$this, 'eael_team_member_presets_condition']);

        //Extended actions
        add_action('eael_section_data_table_enabled', [$this, 'data_table_sorting']);
        add_action('eael_ticker_custom_content_controls', [$this, 'eael_ticker_custom_contents']);
        add_action('render_content_ticker_custom_content', [$this, 'content_ticker_custom_content']);
        add_action('add_progress_bar_control', [$this, 'progress_bar_box_control'], 10, 3);
        add_action('add_eael_progressbar_block', [$this, 'add_box_progress_bar_block'], 10, 3);
        add_action('add_pricing_table_settings_control', [$this, 'pricing_table_header_image_control']);
        add_action('pricing_table_currency_position', [$this, 'pricing_table_style_2_currency_position']);
        add_action('add_pricing_table_style_block', [$this, 'add_pricing_table_pro_styles'], 10, 6);
        add_action('add_admin_license_markup', [$this, 'add_admin_licnes_markup_html'], 10, 5);
        add_action('eael_premium_support_link', [$this, 'add_eael_premium_support_link'], 10, 5);
        add_action('eael_additional_support_links', [$this, 'add_eael_additional_support_links'], 10, 5);
        add_action('eael_manage_license_action_link', [$this, 'add_manage_linces_action_link'], 10, 5);
        add_action('eael_creative_button_pro_controls', [$this, 'add_creative_button_controls'], 10, 1);
        add_action('eael_creative_button_style_pro_controls', [$this, 'add_creative_button_style_pro_controls'], 10, 5);
        add_action('wp_ajax_eael_ajax_post_search', [$this, 'ajax_post_search']);
        add_action('wp_ajax_nopriv_eael_ajax_post_search', [$this, 'ajax_post_search']);
        add_action('eael/team_member_circle_controls', [$this, 'add_team_member_circle_presets']);
        add_action('eael/team_member_social_botton_markup', [$this, 'add_team_member_social_bottom_markup']);
        add_action('eael/advanced-data-table/source/control', [$this, 'advanced_data_table_source_control'], 10, 1);
        add_action('eael/event-calendar/source/control', [$this, 'event_calendar_source_control'], 10, 1);
        add_action('eael/event-calendar/activation-notice', [$this, 'event_calendar_activation_notice'], 10, 1);

        add_filter('eael/woo-checkout/layout', [$this,'eael_woo_checkout_layout']);
	    add_action('eael_add_woo_checkout_pro_layout', [$this, 'add_woo_checkout_pro_layout'], 10, 2);
	    add_action('eael_woo_checkout_pro_enabled_general_settings', [$this, 'add_woo_checkout_tabs_data']);
	    add_action('eael_woo_checkout_pro_enabled_tabs_styles', [$this, 'add_woo_checkout_tabs_styles']);
	    add_action('eael_woo_checkout_pro_enabled_tabs_styles', [$this, 'add_woo_checkout_section_styles']);
	    add_action('eael_woo_checkout_pro_enabled_steps_btn_styles', [$this, 'add_woo_checkout_steps_btn_styles']);

        add_action( 'wp_ajax_eael_woo_checkout_post_code_validate', [$this, 'eael_woo_checkout_post_code_validate']);
        add_action( 'wp_ajax_nopriv_eael_woo_checkout_post_code_validate', [$this, 'eael_woo_checkout_post_code_validate']);

        // ajax
        add_action('wp_ajax_mailchimp_subscribe', [$this, 'mailchimp_subscribe_with_ajax']);
        add_action('wp_ajax_nopriv_mailchimp_subscribe', [$this, 'mailchimp_subscribe_with_ajax']);
        add_action('wp_ajax_instafeed_load_more', [$this, 'instafeed_render_items']);
        add_action('wp_ajax_nopriv_instafeed_load_more', [$this, 'instafeed_render_items']);
        add_action('wp_ajax_connect_remote_db', [$this, 'eael_connect_remote_db']);

        // localize script
        add_filter('eael/localize_objects', [$this, 'eael_script_localizer']);

        // pro scripts
        add_action('eael/after_enqueue_scripts', [$this, 'enqueue_scripts']);

        // admin script
        add_action('admin_enqueue_scripts', [$this, 'eael_admin_scripts']);

        //WPML integration
        add_action('wpml_elementor_widgets_to_translate', [$this, 'eael_translatable_widgets']);

        if (is_admin()) {
            // Core
            add_filter('plugin_action_links_' . EAEL_PRO_PLUGIN_BASENAME, array($this, 'insert_plugin_links'));
        }
    }

    // Later it'll be hookable from lite version
    public function inject_new_extensions($extensions)
    {
        return array_merge_recursive($extensions, $GLOBALS['eael_pro_config']['extensions']);
    }

    public function inject_new_elements($elements)
    {
        return array_merge_recursive($elements, $GLOBALS['eael_pro_config']['elements']);
    }

}
