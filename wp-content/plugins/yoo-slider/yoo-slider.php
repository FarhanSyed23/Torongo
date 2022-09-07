<?php

/*
* Plugin Name: Yoo Slider
* Description: All-in-One WordPress slider solution! Slide your images, videos or any html content on your website with few clicks.
* Author: yooslider
* Author URI: http://yooslider.com
* License: GPL2
* Version: 1.0.3
* Tested up to: 5.4.1
*/


/* Prevent direct call */
if ( !defined( 'WPINC' ) ) {
    wp_die( __('Direct call are not allowed!') );
}

global $wp_version;
if( !version_compare( $wp_version, 4.0, ">=" )) {
    wp_die( __('Error: Plugin requires WordPress >= 4.0 installation!') );
}
if(function_exists('gks_activation_hook')) {
    wp_die( __('Error: Please uninstall other versions of Yoo Slider before installing this package!') );
} else {
//Load configs

    require_once(dirname(__FILE__) . '/gks-config.php');
    if (GKS_LICENSE_TYPE == GKS_LICENSE_TYPE_LIFETIME) {
        require_once(GKS_CLASSES_DIR_PATH . '/GKSLicenseManager.php');
    } else {
        require_once(GKS_CLASSES_DIR_PATH . '/GKSLicenseManagerRecurring.php');
    }

    require_once(GKS_CLASSES_DIR_PATH . '/GKSNotificationManager.php');
    require_once(GKS_CLASSES_DIR_PATH . '/gks-ajax.php');
    if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
      require_once(GKS_CLASSES_DIR_PATH . '/premium/gks-premium-ajax.php');
    }
    require_once(GKS_CLASSES_DIR_PATH . '/GKSHelper.php');
    require_once(GKS_CLASSES_DIR_PATH . '/GKSDbInitializer.php');

    if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
      require_once(dirname(__FILE__).'/plugin-update-checker/plugin-update-checker.php');

      $licenseManager = new GKSLicenseManager();
      $licenseKey = $licenseManager->getKey();

      function gks_updates_response_filter( $info, $response = null ) {
          $info->icons = array(
              '1x' => GKS_IMAGES_URL . '/general/yoo-slider-128x128.png',
              '2x' => GKS_IMAGES_URL . '/general/yoo-slider-256x256.png',
          );
          return $info;
      }

      if (!empty($licenseKey)) {
          $updateChecker = Puc_v4_Factory::buildUpdateChecker(
              GKS_API_URL.'?action=check_update&key='.$licenseKey,
              __FILE__,
              GKS_PLUGIN_SLAG
          );

          $updateChecker->addResultFilter('gks_updates_response_filter');
      }
    }

//Register activation & deactivation hooks
    register_activation_hook(__FILE__, 'gks_activation_hook');
    register_uninstall_hook( __FILE__, 'gks_uninstall_hook');
    register_deactivation_hook( __FILE__, 'gks_deactivation_hook');


//Register action hooks
    add_action('init', 'gks_init_action');
    add_action('admin_enqueue_scripts', 'gks_admin_enqueue_scripts_action');
    add_action('wp_enqueue_scripts', 'gks_wp_enqueue_scripts_action');
    add_action('admin_menu', 'gks_admin_menu_action');
    add_action('admin_head', 'gks_admin_head_action');
    add_action('admin_footer', 'gks_admin_footer_action');

    if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
      add_action( 'admin_notices', 'gks_license_admin_notices' );
      add_filter( 'plugin_action_links', 'gks_action_links', 10, 2 );
      add_action( 'in_plugin_update_message-yoo-slider-premium/yoo-slider-premium.php', 'gks_plugin_update_message', 10, 2 );
    }

//Register gks shortcode handlers
    add_filter('the_content', 'gks_handle_wp_content', 99999999);

    if (GKS_NATIVE_DO_SHORTCODE) {
        add_shortcode('yooslider', 'gks_render_shortcode');
    } else {
        add_filter('the_content', 'gks_handle_shortcodes', 99999999);
    }

//Register Ajax actions
    add_action('wp_ajax_gks_get_slider', 'wp_ajax_gks_get_slider');
    add_action('wp_ajax_gks_save_slider', 'wp_ajax_gks_save_slider');
    add_action('wp_ajax_gks_get_options', 'wp_ajax_gks_get_options');
    add_action('wp_ajax_gks_save_options', 'wp_ajax_gks_save_options');

    if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
      add_action('wp_ajax_gks_activate_license', 'wp_ajax_gks_activate_license');
      add_action('wp_ajax_gks_enable_website', 'wp_ajax_gks_enable_website');
      add_action('wp_ajax_gks_disable_website', 'wp_ajax_gks_disable_website');
      add_action('wp_ajax_gks_make_from_template', 'wp_ajax_gks_make_from_template');
    }

//for logged in and not logged in users
    add_action('wp_ajax_nopriv_gks_load_tiles', 'wp_ajax_gks_load_tiles');
    add_action('wp_ajax_gks_load_tiles', 'wp_ajax_gks_load_tiles');

//Global vars
    $gks_slider;

//Registered installation/uninstallation/activation/deactivation hooks
    function gks_activation_hook()
    {
        $GKSDbInitializer = new GKSDbInitializer();
        if ($GKSDbInitializer->needsConfiguration()) {
            $GKSDbInitializer->configure();
        }
        $GKSDbInitializer->checkForChanges();

        if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
          $licenseManager = new GKSLicenseManager();
          $key = $licenseManager->getKey();
          if (!empty($key)) {
              $website = $licenseManager->getWebsite();
              $licenseManager->enableWebsite($key, $website);
          }
        }
    }

    function gks_uninstall_hook(){
        delete_option(GKS_VALIDATOR_FLAG);
        delete_option(GKS_LAST_VALIDATED_AT);
        delete_option(GKS_LICENSE_OPTION_KEY);
        delete_option(GKS_SAMPLE_IMG_ID);
    }

    function gks_deactivation_hook(){

        if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
          $licenseManager = new GKSLicenseManager();
          $key = $licenseManager->getKey();
          $website = $licenseManager->getWebsite();
          $licenseManager->disableWebsite($key, $website);
        }
    }

    function gks_plugin_update_message( $data, $response ) {
        global $licenseManager;
        $info = $licenseManager->getPluginUpdateMessageInfo($licenseManager->getKey());
        if ($info && !empty($info['update_message']) && ($info['status'] == GKSLicenseManager::STATUS_EXPIRING || $info['status'] == GKSLicenseManager::STATUS_EXPIRED || $info['status'] == GKSLicenseManager::STATUS_INVALID)) {
            printf($info['update_message']);
        }
    }


    function gks_action_links($links, $file)
    {
        if ( $file == plugin_basename( __FILE__ ) ) {
            global $licenseManager;
            $info = $licenseManager->getPluginUpdateMessageInfo($licenseManager->getKey());
            if ($info && !empty($info['action_links'])) {
                foreach ($info['action_links'] as $link) {
                    array_push( $links, $link );
                }
            }
        }

        return $links;
    }

    function gks_add_query_arg($args, $context = null) {
        if (empty($context)) {
            return add_query_arg($args);
        }
        return add_query_arg($args, $context);
    }

    function gks_remove_query_arg($args, $context = null) {
        if (empty($context)) {
            return remove_query_arg($args);
        }
        return remove_query_arg($args, $context);
    }

//Registered hook actions
    function gks_init_action()
    {
        global $wp_version;
        if ( version_compare( $wp_version, '5.0.0', '>=' ) ) {
            wp_register_script(
                'gks-shortcode-block-script',
                GKS_JS_URL.'/gks-shortcode-block.js',
                array( 'wp-blocks', 'wp-element' )
            );

            wp_register_style(
                'gks-shortcode-block',
                GKS_CSS_URL.'/gks-admin-editor-block.css',
                array( 'wp-edit-blocks' ),
                filemtime( plugin_dir_path( __FILE__ ) . 'css/gks-admin-editor-block.css' )
            );

            register_block_type( 'yooslider/yooslider-block', array(
                'editor_script' => 'gks-shortcode-block-script',
                'editor_style' => 'gks-shortcode-block',
            ) );
        }
        ob_start();
        global $gksParams;
        $gksParams = $_GET;
        $urlContext = isset($_GET['grid_url']) ? sanitize_text_field($_GET['grid_url']) : null;
        if (!empty($urlContext)) {
            global $gksUrlContext;
            $gksUrlContext = $urlContext;
            $query = explode( '?', $urlContext, 2 );
            $params = $_GET;
            if (isset($query[1])) {
                $query = $query[1];
                $np = array();
                wp_parse_str($query, $np);
                $np = urlencode_deep( $np );
                $params = array_merge($np, $params);
            }
            foreach ($params as $k => $v) {
                $gksParams[$k] = $v;
                $gksUrlContext = gks_add_query_arg(array($k => $v), $gksUrlContext);
            }
            $gksUrlContext = gks_remove_query_arg(array('action', 'grid_url'), $gksUrlContext);
        }
    }

    function gks_admin_enqueue_scripts_action($hook)
    {
        wp_register_style('gks-admin-shared', GKS_CSS_URL . '/gks-admin-shared.css');
        wp_enqueue_style('gks-admin-shared');

        if (stripos($hook, GKS_PLUGIN_SLAG) !== false) {
            gks_enqueue_admin_csss();
            gks_enqueue_admin_scripts();
        }
    }

    function gks_wp_enqueue_scripts_action()
    {
        gks_enqueue_front_scripts();
        gks_enqueue_front_csss();
    }

    function gks_admin_menu_action()
    {
        gks_setup_admin_menu_buttons();
    }

    function gks_admin_head_action()
    {
        gks_include_inline_scripts();
        gks_setup_media_buttons();
    }

    function gks_admin_footer_action()
    {
        gks_include_inline_htmls();
    }

//Registered hook filters
    function gks_mce_external_plugins_filter($pluginsArray)
    {
        return gks_register_tinymce_plugin($pluginsArray);
    }

    function gks_mce_buttons_filter($buttons)
    {
        return gks_register_tc_buttons($buttons);
    }

//Shortcode Hanlders
    function gks_render_shortcode($attributes)
    {
        if (!@$attributes['id']) {
          return;
        }

        ob_start();

        require_once(GKS_FRONT_VIEWS_DIR_PATH . "/gks-front.php");

        //Prepare render data
        global $gks_slider;
        $gks_slider = GKSHelper::getSliderWithId($attributes['id']);
        gks_Front::render();

        $result = ob_get_clean();
        return $result;
    }

    function gks_do_shortcode($shortcode)
    {
        $shortcode = str_replace('[yooslider]', '', $shortcode);
        $shortcode = str_replace('[/yooslider]', '', $shortcode);
        $shortcode = str_replace('[yooslider', '', $shortcode);
        $shortcode = str_replace(']', '', $shortcode);

        $atts = shortcode_parse_atts($shortcode);
        return gks_render_shortcode($atts);
    }

    function gks_handle_wp_content($content){
        return $content;
    }

    function gks_handle_shortcodes($content)
    {
        /* Regex pattern for the follwoing cases:
        [shortcode]
        [shortcode=value]
        [shortcode key=value]
        [shortcode=value]Text[/shortcode]
        [shortcode key1=value1 key2=value2]Text[shortcode] */

        $pattern = "\[yooslider(.*?)?\](?:(.+?)?\[\/yooslider\])?";

        if (preg_match_all('/' . $pattern . '/s', $content, $matches)) {
            foreach ($matches[0] as $shortcode) {
                $replacement = gks_do_shortcode($shortcode);
                $content = str_replace($shortcode, $replacement, $content);
            }
        }

        return $content;
    }

    function gks_get_content_yoosliders()
    {
        /* Regex pattern for the follwoing cases:
        [shortcode]
        [shortcode=value]
        [shortcode key=value]
        [shortcode=value]Text[/shortcode]
        [shortcode key1=value1 key2=value2]Text[shortcode] */

        global $post;
        $content = @$post->post_content;
        $sliders = array();

        $pattern = "\[yooslider(.*?)?\](?:(.+?)?\[\/yooslider\])?";
        if (preg_match_all('/' . $pattern . '/s', $content, $matches)) {
            foreach ($matches[0] as $shortcode) {
              $shortcode = str_replace('[yooslider]', '', $shortcode);
              $shortcode = str_replace('[/yooslider]', '', $shortcode);
              $shortcode = str_replace('[yooslider', '', $shortcode);
              $shortcode = str_replace(']', '', $shortcode);

              $atts = shortcode_parse_atts($shortcode);
              if (@$atts['id']) {
                $sliders[] = $atts['id'];
              }
            }
        }

        return $sliders;
    }

//Internal functionality
    function gks_setup_admin_menu_buttons()
    {
        add_menu_page(GKS_PLUGIN_NAME, GKS_PLUGIN_NAME, 'edit_posts', GKS_PLUGIN_SLAG, "gks_admin_sliders_page", 'dashicons-slides');
        add_submenu_page(GKS_PLUGIN_SLAG, GKS_SUBMENU_SLIDER_TITLE, GKS_SUBMENU_SLIDER_TITLE, 'edit_posts', GKS_PLUGIN_SLAG, 'gks_admin_sliders_page');
        if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
          //add_submenu_page(GKS_PLUGIN_SLAG, GKS_SUBMENU_TEMPLATES_SLUG, GKS_SUBMENU_TEMPLATES_TITLE, 'edit_posts', GKS_SUBMENU_TEMPLATES_SLUG, 'gks_admin_templates_page');
          add_submenu_page(GKS_PLUGIN_SLAG, GKS_SUBMENU_LICENSE_SLUG, GKS_SUBMENU_LICENSE_TITLE, 'edit_posts', GKS_SUBMENU_LICENSE_SLUG, 'gks_admin_license_page');
        }
    }

    function gks_admin_page()
    {
        $canUse = GKS_PKG_TYPE == GKS_PKG_TYPE_FREE || gks_check_for_license();
        if (!$canUse) {
            wp_redirect(admin_url('admin.php?page='.GKS_SUBMENU_LICENSE_SLUG));
        } else {
            global $gks_adminPageType;
            require_once(GKS_ADMIN_VIEWS_DIR_PATH . '/gks-admin.php');
        }
    }

    function gks_admin_sliders_page(){
        global $gks_adminPageType;
        $gks_adminPageType = GKSLayoutType::SLIDER;
        gks_admin_page();
    }

    function gks_admin_templates_page(){
        include_once(GKS_ADMIN_VIEWS_DIR_PATH."/premium/gks-admin-templates.php");
    }

    function gks_check_for_license()
    {
        $licenseManager = new GKSLicenseManager();
        return $licenseManager->canUse();
    }

    function gks_admin_license_page()
    {
        require_once(GKS_ADMIN_VIEWS_DIR_PATH . '/premium/gks-license.php');
    }

    function gks_license_admin_notices() {
        $licenseManager = new GKSLicenseManager();
        $notificationManager = new GKSNotificationManager();
        $key = $licenseManager->getKey();
        if ($key != '') {
            $licenseManager->validateKey($key);
            $notificationManager->showAll();
            $notificationManager->dismissAll();
        }
    }

    function gks_setup_media_buttons()
    {
        global $typenow;
        // check user permissions
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        // verify the post type
        if (!in_array($typenow, array('post', 'page')))
            return;

        // check if WYSIWYG is enabled
        if (get_user_option('rich_editing') == 'true') {
            add_filter("mce_external_plugins", "gks_mce_external_plugins_filter");
            add_filter('mce_buttons', 'gks_mce_buttons_filter');
        }
    }

    function gks_register_tinymce_plugin($pluginsArray)
    {
        $pluginsArray['gks_tc_buttons'] = GKS_JS_URL . "/gks-tc-buttons.js";
        return $pluginsArray;
    }

    function gks_register_tc_buttons($buttons)
    {
        array_push($buttons, "gks_insert_tc_button");
        return $buttons;
    }

    function gks_include_inline_scripts()
    {
        ?>
        <script type="text/javascript">

            <?php
            $gks_shortcodes = GKSHelper::tcButtonShortcodes();
            ?>

            gks_shortcodes = [];
            <?php foreach($gks_shortcodes as $gks_shortcode): ?>
            gks_shortcodes.push({
                "id": "<?php echo $gks_shortcode->id ?>",
                "title": "<?php echo $gks_shortcode->title ?>",
                "shortcode": "<?php echo $gks_shortcode->shortcode ?>"
            });
            <?php endforeach; ?>


            jQuery(document).ready(function () {
            });
        </script>
        <?php
    }

    function gks_include_inline_htmls()
    {
        ?>

        <?php
    }

    function gks_enqueue_admin_scripts()
    {
        wp_enqueue_script("jquery");
        wp_enqueue_script("jquery-ui-core");
        wp_enqueue_script("jquery-ui-sortable");
        wp_enqueue_script("jquery-ui-autocomplete");
        wp_enqueue_script("jquery-ui-dialog");

        //Enqueue JS files
        wp_enqueue_script('gks-helper', GKS_JS_URL . '/gks-helper.js', array('jquery'), "", false);
        wp_enqueue_script('gks-main-admin', GKS_JS_URL . '/gks-main-admin.js', array('jquery'), "", true);
        if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
          wp_enqueue_script('gks-main-admin-premium', GKS_JS_URL . '/premium/gks-main-admin-premium.js', array('jquery'), "", true);
        }

        wp_enqueue_script('gks-ajax-admin', GKS_JS_URL . '/gks-ajax-admin.js', array('jquery'), "", true);

        wp_register_script('jquery-accordion', GKS_JS_URL . "/jquery/jquery.accordion.js", array('jquery'), "", true);
        wp_enqueue_script('jquery-accordion');

        wp_register_script('jquery-tooltipster', GKS_JS_URL . "/jquery/jquery.tooltipster.min.js", array('jquery'), "", true);
        wp_enqueue_script('jquery-tooltipster');

        wp_register_script('jquery-caret', GKS_JS_URL . "/jquery/jquery.caret.min.js", array('jquery'), "", true);
        wp_enqueue_script('jquery-caret');

        wp_register_script('jquery-tageditor', GKS_JS_URL . "/jquery/jquery.tageditor.min.js", array('jquery'), "", true);
        wp_enqueue_script('jquery-tageditor');

        wp_register_script('jquery-multipleselect', GKS_JS_URL . "/jquery/jquery.multipleselect.js", array('jquery'), "", true);
        wp_enqueue_script('jquery-multipleselect');

        wp_register_script('gks-nouislider', GKS_JS_URL . "/nouislider.js", array('jquery'), "", true);
        wp_enqueue_script('gks-nouislider');

        wp_enqueue_media();
        wp_enqueue_script('wp-color-picker');
    }

    function gks_enqueue_admin_csss()
    {
        //Enqueue CSS files

        wp_register_style('gks-main-admin-common', GKS_CSS_URL . '/gks-main-admin-common.css');
        wp_enqueue_style('gks-main-admin-common');

        wp_register_style('gks-main-admin', GKS_CSS_URL . '/gks-main-admin.css');
        wp_enqueue_style('gks-main-admin');

        wp_register_style('gks-tc-buttons', GKS_CSS_URL . '/gks-tc-buttons.css');
        wp_enqueue_style('gks-tc-buttons');

        wp_register_style('gks-tooltipster', GKS_CSS_URL . '/tooltipster/tooltipster.css');
        wp_enqueue_style('gks-tooltipster');

        wp_register_style('gks-tooltipster-theme', GKS_CSS_URL . '/tooltipster/themes/tooltipster-shadow.css');
        wp_enqueue_style('gks-tooltipster-theme');

        wp_register_style('gks-accordion', GKS_CSS_URL . '/accordion/accordion.css');
        wp_enqueue_style('gks-accordion');

        wp_register_style('gks-tageditor', GKS_CSS_URL . '/tageditor/tageditor.css');
        wp_enqueue_style('gks-tageditor');

        wp_register_style('gks-multipleselect', GKS_CSS_URL . '/multipleselect/multipleselect.css');
        wp_enqueue_style('gks-multipleselect');

        wp_enqueue_style('wp-color-picker');

        wp_register_style('gks-font-awesome', GKS_CSS_URL . '/fontawesome/font-awesome.css');
        wp_enqueue_style('gks-font-awesome');

        wp_register_style('gks-nouislider', GKS_CSS_URL . '/nouislider.css');
        wp_enqueue_style('gks-nouislider');
    }

    function gks_enqueue_front_scripts()
    {
        //Enqueue JS files
        wp_enqueue_script("jquery-ui-dialog");

        wp_enqueue_script('gks-main-front', GKS_JS_URL . '/gks-main-front.js', array('jquery'));
        if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
          wp_enqueue_script('gks-main-front-premium', GKS_JS_URL . '/premium/gks-main-front-premium.js', array('jquery'));
        }
        wp_enqueue_script('gks-helper', GKS_JS_URL . '/gks-helper.js', array('jquery'));
        wp_enqueue_script('gks-froogaloop2-min', GKS_JS_URL . '/froogaloop2.min.js');

        wp_enqueue_script('gks-owl-carousel', GKS_JS_URL . '/viewer/owl-carousel/owl.carousel.js');

        if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
          wp_enqueue_script('gks-lightgallery', GKS_JS_URL . '/premium/gks-lightgallery.js');
          wp_enqueue_script('gks-lg-fullscreen', GKS_JS_URL . '/premium/lightgallery-modules/lg-fullscreen.js');
          wp_enqueue_script('gks-lg-thumbnail', GKS_JS_URL . '/premium/lightgallery-modules/lg-thumbnail.js');
          wp_enqueue_script('gks-lg-video', GKS_JS_URL . '/premium/lightgallery-modules/lg-video.js');
          wp_enqueue_script('gks-lg-autoplay', GKS_JS_URL . '/premium/lightgallery-modules/lg-autoplay.js');
          wp_enqueue_script('gks-lg-zoom', GKS_JS_URL . '/premium/lightgallery-modules/lg-zoom.js');
          wp_enqueue_script('gks-lg-hash', GKS_JS_URL . '/premium/lightgallery-modules/lg-hash.js');
          wp_enqueue_script('gks-lg-share', GKS_JS_URL . '/premium/lightgallery-modules/lg-share.js');
          wp_enqueue_script('gks-lg-pager', GKS_JS_URL . '/premium/lightgallery-modules/lg-pager.js');
        }

        if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
          wp_enqueue_script('gks-thumbnail-scroller', GKS_JS_URL . '/viewer/thumbnail-scroller/scroller.js');
        }

        wp_enqueue_script('gks-user-scripts',  GKS_JS_URL . '/gks-user-scripts.js');

        $sliders = gks_get_content_yoosliders();
        foreach ($sliders as $sliderId) {
          $gks_slider = GKSHelper::getSliderWithId($sliderId);
          if (!$gks_slider) {
            continue;
          }

          wp_add_inline_script( 'gks-user-scripts', $gks_slider->options[GKSOption::kCustomJS] );
        }
    }

    function gks_enqueue_front_csss()
    {
        //Enqueue CSS files
        wp_enqueue_style('gks-tc-buttons', GKS_CSS_URL . '/gks-tc-buttons.css');
        wp_enqueue_style('gks-font-awesome', GKS_CSS_URL . '/fontawesome/font-awesome.css');
        wp_enqueue_style('gks-owl-carousel', GKS_CSS_URL . '/viewer/owl-carousel/assets/owl.carousel.css');
        wp_enqueue_style('gks-owl-layout', GKS_CSS_URL . '/viewer/owl-carousel/layout.css');
        wp_enqueue_style('gks-owl-animate', GKS_CSS_URL . '/viewer/owl-carousel/animate.css');

        if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
          wp_enqueue_style('gks-owl-animations', GKS_CSS_URL . '/premium/gks-owl-animations.css');
          wp_enqueue_style('gks-lightgallery', GKS_CSS_URL . '/premium/lightgallery/css/lightgallery.css');
          wp_enqueue_style('gks-lg-transitions', GKS_CSS_URL . '/premium/lightgallery/css/lg-transitions.css');
          wp_enqueue_style('gks-captions', GKS_CSS_URL . '/premium/gks-captions.css');
          wp_enqueue_style('gks-thumbnail-scroller', GKS_CSS_URL . '/premium/thumbnail-scroller/scroller.css');
          wp_enqueue_style('gks-lg-styles', GKS_CSS_URL . '/premium/gks-lg-styles.css');
        }

        wp_enqueue_style('gks-main-front', GKS_CSS_URL . '/gks-main-front.css');

        $sliders = gks_get_content_yoosliders();
        foreach ($sliders as $sliderId) {
          $gks_slider = GKSHelper::getSliderWithId($sliderId);
          if (!$gks_slider) {
            continue;
          }

          if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM) {
            if ($gks_slider->options[GKSOption::kFont] && !empty($gks_slider->options[GKSOption::kFont])) {
              wp_enqueue_style('gks-default-google-fonts-' . $gks_slider->id, "https://fonts.googleapis.com/css?family=" . $gks_slider->options[GKSOption::kFont] . ":normal,bold,italic");
            }

            if($gks_slider->options[GKSOption::kTileTitleFont] && !empty($gks_slider->options[GKSOption::kTileTitleFont])) {
              wp_enqueue_style('gks-title-google-fonts-' . $gks_slider->id, "https://fonts.googleapis.com/css?family=" . $gks_slider->options[GKSOption::kTileTitleFont] . ":normal,bold,italic");
            }
          }

          $licenseManager = new GKSLicenseManager();
    			$css = $licenseManager->css($gks_slider, true);

          $userStylesHandle = 'gks-user-styles-' . $sliderId;
          wp_register_style($userStylesHandle, false);
          wp_enqueue_style($userStylesHandle);
          wp_add_inline_style( $userStylesHandle, $gks_slider->options[GKSOption::kCustomCSS]);

          $cssHandle = 'gks-custom-styles-' . $sliderId;
          wp_register_style($cssHandle, false);
          wp_enqueue_style($cssHandle);
          wp_add_inline_style( $cssHandle, $css);
        }
    }
}
