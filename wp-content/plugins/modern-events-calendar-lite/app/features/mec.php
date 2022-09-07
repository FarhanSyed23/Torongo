<?php
/** no direct access **/
defined('MECEXEC') or die();

/**
 * Webnus MEC class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_feature_mec extends MEC_base
{
    /**
     * @var MEC_factory
     */
    public $factory;

    /**
     * @var MEC_db
     */
    public $db;

    /**
     * @var MEC_main
     */
    public $main;

    /**
     * @var MEC_notifications
     */
    public $notifications;
    public $settings;
    public $page;
    public $PT;

    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        // Import MEC Factory
        $this->factory = $this->getFactory();

        // Import MEC DB
        $this->db = $this->getDB();

        // Import MEC Main
        $this->main = $this->getMain();

        // Import MEC Notifications
        $this->notifications = $this->getNotifications();

        // MEC Settings
        $this->settings = $this->main->get_settings();
    }

    /**
     * Initialize calendars feature
     * @author Webnus <info@webnus.biz>
     */
    public function init()
    {
        $this->factory->action('admin_menu', array($this, 'menus'));
        $this->factory->action('admin_menu', array($this, 'support_menu'), 21);
        $this->factory->action('init', array($this, 'register_post_type'));
        $this->factory->action('add_meta_boxes', array($this, 'register_meta_boxes'), 1);

        $this->factory->action('parent_file', array($this, 'mec_parent_menu_highlight'));
        $this->factory->action('submenu_file', array($this, 'mec_sub_menu_highlight'));

        $this->factory->action('current_screen', array($this, 'booking_badge'));
        $this->factory->action('current_screen', array($this, 'events_badge'));

        // Google recaptcha
        $this->factory->filter('mec_grecaptcha_include', array($this, 'grecaptcha_include'));

        // Google Maps API
        $this->factory->filter('mec_gm_include', array($this, 'gm_include'));

        $this->factory->filter('manage_mec_calendars_posts_columns', array($this, 'filter_columns'));
        $this->factory->action('manage_mec_calendars_posts_custom_column', array($this, 'filter_columns_content'), 10, 2);

        $this->factory->action('save_post', array($this, 'save_calendar'), 10);

        // BuddyPress Integration
        $this->factory->action('mec_booking_confirmed', array($this->main, 'bp_add_activity'), 10);
        $this->factory->action('mec_booking_verified', array($this->main, 'bp_add_activity'), 10);
        $this->factory->action('bp_register_activity_actions', array($this->main, 'bp_register_activity_actions'), 10);

        // Mailchimp Integration
        $this->factory->action('mec_booking_verified', array($this->main, 'mailchimp_add_subscriber'), 10);

        // Campaign Monitor Integration
        $this->factory->action('mec_booking_verified', array($this->main, 'campaign_monitor_add_subscriber'), 10);

        // MailerLite Integration
        $this->factory->action('mec_booking_verified', array($this->main, 'mailerlite_add_subscriber'), 10);

        // Constant Contact Integration
        $this->factory->action('mec_booking_verified', array($this->main, 'constantcontact_add_subscriber'), 10);

        // Active Campaign Integration
        $this->factory->action('mec_booking_verified', array($this->main, 'active_campaign_add_subscriber'), 10);

        // MEC Notifications
        $this->factory->action('mec_booking_completed', array($this->notifications, 'email_verification'), 10);
        $this->factory->action('mec_booking_completed', array($this->notifications, 'booking_notification'), 11);
        $this->factory->action('mec_booking_completed', array($this->notifications, 'admin_notification'), 12);
        $this->factory->action('mec_booking_confirmed', array($this->notifications, 'booking_confirmation'), 10, 2);
        $this->factory->action('mec_booking_canceled', array($this->notifications, 'booking_cancellation'), 12);
        $this->factory->action('mec_fes_added', array($this->notifications, 'new_event'), 50, 3);
        $this->factory->action('mec_after_publish_admin_event', array($this->notifications, 'new_event'), 10,3);
        $this->factory->action('mec_event_published', array($this->notifications, 'user_event_publishing'), 10, 3);

        $this->page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : 'MEC-settings';

        // MEC Post Type Name
        $this->PT = $this->main->get_main_post_type();

        // Disable Block Editor
        $gutenberg_status = (!isset($this->settings['gutenberg']) or (isset($this->settings['gutenberg']) and $this->settings['gutenberg'])) ? true : false;
        if($gutenberg_status)
        {
            $this->factory->filter('gutenberg_can_edit_post_type', array($this, 'gutenberg'), 10, 2);
            $this->factory->filter('use_block_editor_for_post_type', array($this, 'gutenberg'), 10, 2);
        }

        // Export Settings
        $this->factory->action('wp_ajax_download_settings', array($this, 'download_settings'));

        // Import Settings
        $this->factory->action('wp_ajax_import_settings', array($this, 'import_settings'));

        // License Activation
        $this->factory->action('wp_ajax_activate_license', array($this, 'activate_license'));

        // Close Notification
        $this->factory->action('wp_ajax_close_notification', array($this, 'close_notification'));

        // Close Custom Text Notification
        $this->factory->action('wp_ajax_close_cmsg_notification', array($this, 'close_cmsg_notification'));

        // Close Custom Text Notification
        $this->factory->action('wp_ajax_report_event_dates', array($this, 'report_event_dates'));

        // Scheduler Cronjob
        $schedule = $this->getSchedule();
        $this->factory->action('mec_scheduler', array($schedule, 'cron'));

        $syncSchedule = $this->getSyncSchedule();
        $this->factory->action('mec_syncScheduler', array($syncSchedule, 'sync'));

        // Dashborad Metaboxes
        add_action('wp_dashboard_setup', array($this, 'dashboard_widgets'));
    }

    /* Activate License */
    public function activate_license()
    {
        // Current User is not Permitted
        if(!current_user_can('manage_options')) $this->main->response(array('success'=>0, 'code'=>'ADMIN_ONLY'));

        if(!wp_verify_nonce($_REQUEST['nonce'], 'mec_settings_nonce'))
        {
            exit();
        }

        $options = get_option('mec_options');

        $options['product_name'] = $_REQUEST['content']['LicenseTypeJson'];
        $options['purchase_code'] = $_REQUEST['content']['PurchaseCodeJson'];
        update_option( 'mec_options' , $options);

        $verify = NULL;
        if($this->getPRO())
        {
            $envato = $this->getEnvato();
            $verify = $envato->get_MEC_info('dl');
        }

        if(!is_null($verify))
        {
            $LicenseStatus = 'success';
        }
        else
        {
            $LicenseStatus = __('Activation failed. Please check your purchase code or license type.<br><b>Note: Your purchase code should match your licesne type.</b>' , 'modern-events-calendar-lite') . '<a style="text-decoration: underline; padding-left: 7px;" href="https://webnus.net/dox/modern-events-calendar/auto-update-issue/" target="_blank">'  . __('Troubleshooting' , 'modern-events-calendar-lite') . '</a>';
        }

        echo $LicenseStatus;
        wp_die();
    }

    /* Download MEC settings */
    public function download_settings()
    {
        // Current User is not Permitted
        if(!current_user_can('manage_options')) $this->main->response(array('success'=>0, 'code'=>'ADMIN_ONLY'));

        if(!wp_verify_nonce($_REQUEST['nonce'], 'mec_settings_download'))
        {
            exit();
        }

        $content = get_option('mec_options');
        $content = json_encode($content, true);

        header('Content-type: application/txt');
        header('Content-Description: MEC Settings');
        header('Content-Disposition: attachment; filename="mec_options_backup_' . date( 'd-m-Y' ) . '.json"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
        print_r($content);
        wp_die();
    }

    /* Close addons notification */
    public function close_notification()
    {
        // Current User is not Permitted
        if(!current_user_can('manage_options')) $this->main->response(array('success'=>0, 'code'=>'ADMIN_ONLY'));

        if(!wp_verify_nonce( $_REQUEST['nonce'], 'mec_settings_nonce'))
        {
            exit();
        }
        update_option('mec_addons_notification_option', 'open');
        wp_die();
    }

    /* Close addons notification */
    public function close_cmsg_notification()
    {
        // Current User is not Permitted
        if(!current_user_can('manage_options')) $this->main->response(array('success'=>0, 'code'=>'ADMIN_ONLY'));

        if(!wp_verify_nonce( $_REQUEST['nonce'], 'mec_settings_nonce'))
        {
            exit();
        }
        update_option('mec_custom_msg_close_option', 'open');
        wp_die();
    }


    /* Report Event Dates */
    public function report_event_dates()
    {
        // Current User is not Permitted
        if(!current_user_can('manage_options')) $this->main->response(array('success'=>0, 'code'=>'ADMIN_ONLY'));

        if(!wp_verify_nonce($_REQUEST['nonce'], 'mec_settings_nonce'))
        {
            exit();
        }

        $event_id = $_POST['event_id'];
        $feature_class = new MEC_feature_mec();

        $booking_options = get_post_meta($event_id, 'mec_booking', true);
        $bookings_all_occurrences = isset($booking_options['bookings_all_occurrences']) ? $booking_options['bookings_all_occurrences'] : 0;

        if($event_id != 'none')
        {
            $dates = $feature_class->db->select("SELECT `tstart`, `tend` FROM `#__mec_dates` WHERE `post_id`='".$event_id."' LIMIT 100");
            $occurrence = reset($dates)->tstart;

            $date_format = (isset($this->settings['booking_date_format1']) and trim($this->settings['booking_date_format1'])) ? $this->settings['booking_date_format1'] : 'Y-m-d';
            if(get_post_meta($event_id, 'mec_repeat_type', true) === 'custom_days') $date_format .= ' '.get_option('time_format');

            echo '<select name="mec-report-event-dates" class="mec-reports-selectbox mec-reports-selectbox-dates" onchange="mec_event_attendees('.$event_id.', this.value);">';
            echo '<option value="none">'.esc_html__( "Select Date" , "mec").'</option>';

            if($bookings_all_occurrences)
            {
                echo '<option value="all">'.esc_html__( "All" , "mec").'</option>';
            }

            foreach($dates as $date)
            {
                $start = array(
                    'date' => date('Y-m-d', $date->tstart),
                    'hour' => date('h', $date->tstart),
                    'minutes' => date('i', $date->tstart),
                    'ampm' => date('A', $date->tstart),
                );

                $end = array(
                    'date' => date('Y-m-d', $date->tend),
                    'hour' => date('h', $date->tend),
                    'minutes' => date('i', $date->tend),
                    'ampm' => date('A', $date->tend),
                );

                echo '<option value="'.$date->tstart.'" '.($occurrence == $date->tstart ? 'class="selected-day"' : '').'>'.strip_tags($this->main->date_label($start, $end, $date_format)).'</option>';
            }

            echo '</select>';
        }
        else
        {
            echo '';
        }

        wp_die();
    }

    /* Import MEC settings */
    public function import_settings()
    {
        // Current User is not Permitted
        if(!current_user_can('manage_options')) $this->main->response(array('success'=>0, 'code'=>'ADMIN_ONLY'));

        if(!wp_verify_nonce($_REQUEST['nonce'], 'mec_settings_nonce'))
        {
            exit();
        }

        $options = $_REQUEST['content'];
        if($options == 'No-JSON')
        {
            echo '<div class="mec-message-import-error">' . esc_html__('Your option is not in JSON format. Please insert correct options in this field and try again.' , 'modern-events-calendar-lite') . '</div>';
            exit();
        }
        else
        {
            if(empty($options))
            {
                echo '<div class="mec-message-import-error">' . esc_html__('Your options field can not be empty!' , 'modern-events-calendar-lite') . '</div>';
                exit;
            }
            else
            {
                update_option('mec_options' , $options);
                echo '<div class="mec-message-import-success">' . esc_html__('Your options imported successfuly.', 'modern-events-calendar-lite') . '</div>';
            }
        }

        wp_die();
    }

    /**
     * highlighting menu when click on taxonomy
     * @author Webnus <info@webnus.biz>
     * @param string $parent_file
     * @return string
     */
    public function mec_parent_menu_highlight($parent_file)
    {
        global $current_screen;

        $taxonomy = $current_screen->taxonomy;
        $post_type = $current_screen->post_type;

        // Don't do amything if the post type is not our post type
        if($post_type != $this->PT) return $parent_file;

        switch($taxonomy)
        {
            case 'mec_category':
            case 'post_tag':
            case 'mec_label':
            case 'mec_location':
            case 'mec_organizer':
            case 'mec_speaker':

                $parent_file = 'mec-intro';
                break;

            default:
                //nothing
                break;
        }

        return $parent_file;
    }

    public function mec_sub_menu_highlight($submenu_file)
    {
        global $current_screen;

        $taxonomy = $current_screen->taxonomy;
        $post_type = $current_screen->post_type;

        // Don't do amything if the post type is not our post type
        if($post_type != $this->PT) return $submenu_file;

        switch($taxonomy)
        {
            case 'mec_category':

                $submenu_file = 'edit-tags.php?taxonomy=mec_category&post_type='.$this->PT;
                break;
            case 'post_tag':

                $submenu_file = 'edit-tags.php?taxonomy=post_tag&post_type='.$this->PT;
                break;
            case 'mec_label':

                $submenu_file = 'edit-tags.php?taxonomy=mec_label&post_type='.$this->PT;
                break;
            case 'mec_location':

                $submenu_file = 'edit-tags.php?taxonomy=mec_location&post_type='.$this->PT;
                break;
            case 'mec_organizer':

                $submenu_file = 'edit-tags.php?taxonomy=mec_organizer&post_type='.$this->PT;
                break;
            case 'mec_speaker':

                $submenu_file = 'edit-tags.php?taxonomy=mec_speaker&post_type='.$this->PT;
                break;
            default:
                //nothing
                break;
        }

        return $submenu_file;
    }

    /**
     * Add the support menu
     * @author Webnus <info@webnus.biz>
     */
    public function support_menu()
    {
        add_submenu_page('mec-intro', __('MEC - Support', 'modern-events-calendar-lite'), __('Support', 'modern-events-calendar-lite'), 'manage_options', 'MEC-support', array($this, 'support_page'));
    }

    /**
     * Add the calendars menu
     * @author Webnus <info@webnus.biz>
     */
    public function menus()
    {
        global $submenu;
        unset($submenu['mec-intro'][2]);

        remove_menu_page('edit.php?post_type=mec-events');
        remove_menu_page('edit.php?post_type=mec_calendars');
        do_action('before_mec_submenu_action');

        add_submenu_page('mec-intro', __('Add Event', 'modern-events-calendar-lite'), __('Add Event', 'modern-events-calendar-lite'), 'edit_posts', 'post-new.php?post_type='.$this->PT);
        add_submenu_page('mec-intro', __('Tags', 'modern-events-calendar-lite'), __('Tags', 'modern-events-calendar-lite'), 'edit_others_posts', 'edit-tags.php?taxonomy=post_tag&post_type='.$this->PT);
        add_submenu_page('mec-intro', $this->main->m('taxonomy_categories', __('Categories', 'modern-events-calendar-lite')), $this->main->m('taxonomy_categories', __('Categories', 'modern-events-calendar-lite')), 'edit_others_posts', 'edit-tags.php?taxonomy=mec_category&post_type='.$this->PT);
        add_submenu_page('mec-intro', $this->main->m('taxonomy_labels', __('Labels', 'modern-events-calendar-lite')), $this->main->m('taxonomy_labels', __('Labels', 'modern-events-calendar-lite')), 'edit_others_posts', 'edit-tags.php?taxonomy=mec_label&post_type='.$this->PT);
        add_submenu_page('mec-intro', $this->main->m('taxonomy_locations', __('Locations', 'modern-events-calendar-lite')), $this->main->m('taxonomy_locations', __('Locations', 'modern-events-calendar-lite')), 'edit_others_posts', 'edit-tags.php?taxonomy=mec_location&post_type='.$this->PT);
        add_submenu_page('mec-intro', $this->main->m('taxonomy_organizers', __('Organizers', 'modern-events-calendar-lite')), $this->main->m('taxonomy_organizers', __('Organizers', 'modern-events-calendar-lite')), 'edit_others_posts', 'edit-tags.php?taxonomy=mec_organizer&post_type='.$this->PT);

        // Speakers Menu
        if(isset($this->settings['speakers_status']) and $this->settings['speakers_status'])
        {
            add_submenu_page('mec-intro', $this->main->m('taxonomy_speakers', __('Speakers', 'modern-events-calendar-lite')), $this->main->m('taxonomy_speakers', __('Speakers', 'modern-events-calendar-lite')), 'edit_others_posts', 'edit-tags.php?taxonomy=mec_speaker&post_type='.$this->PT);
        }

        add_submenu_page('mec-intro', __('Shortcodes', 'modern-events-calendar-lite'), __('Shortcodes', 'modern-events-calendar-lite'), 'edit_others_posts', 'edit.php?post_type=mec_calendars');
        add_submenu_page('mec-intro', __('MEC - Settings', 'modern-events-calendar-lite'), __('Settings', 'modern-events-calendar-lite'), 'manage_options', 'MEC-settings', array($this, 'page'));
        add_submenu_page('mec-intro', __('MEC - Addons', 'modern-events-calendar-lite'), __('Addons', 'modern-events-calendar-lite'), 'manage_options', 'MEC-addons', array($this, 'addons'));
        if(isset($this->settings['booking_status']) and $this->settings['booking_status'])
        {
            add_submenu_page('mec-intro', __('MEC - Report', 'modern-events-calendar-lite'), __('Report', 'modern-events-calendar-lite'), 'manage_options', 'MEC-report', array($this, 'report'));
        }
        if (!$this->getPRO()) add_submenu_page('mec-intro', __('MEC - Go Pro', 'modern-events-calendar-lite'), __('Go Pro', 'modern-events-calendar-lite'), 'manage_options', 'MEC-go-pro', array($this, 'go_pro'));
        do_action('after_mec_submenu_action');
    }

    /**
     * Register post type of calendars/custom shortcodes
     * @author Webnus <info@webnus.biz>
     *
     */
    public function register_post_type()
    {
        $elementor = class_exists('MEC_Shortcode_Builder') && did_action('elementor/loaded') ? true : false;

        register_post_type('mec_calendars',
            array(
                'labels'=>array
                (
                    'name'=>__('Shortcodes', 'modern-events-calendar-lite'),
                    'singular_name'=>__('Shortcode', 'modern-events-calendar-lite'),
                    'add_new'=>__('Add Shortcode', 'modern-events-calendar-lite'),
                    'add_new_item'=>__('Add New Shortcode', 'modern-events-calendar-lite'),
                    'not_found'=>__('No shortcodes found!', 'modern-events-calendar-lite'),
                    'all_items'=>__('All Shortcodes', 'modern-events-calendar-lite'),
                    'edit_item'=>__('Edit shortcodes', 'modern-events-calendar-lite'),
                    'not_found_in_trash'=>__('No shortcodes found in Trash!', 'modern-events-calendar-lite')
                ),
                'public'=>$elementor,
                'show_in_nav_menus'=>false,
                'show_in_admin_bar'=>$elementor,
                'show_ui'=>true,
                'has_archive'=>false,
                'exclude_from_search'=>true,
                'publicly_queryable'=>$elementor,
                'show_in_menu'=>'mec-intro',
                'supports'=>array('title')
            )
        );

        do_action('mec_register_post_type');
    }

    /**
     * Filter columns of calendars/custom shortcodes
     * @author Webnus <info@webnus.biz>
     * @param array $columns
     * @return array
     */
    public function filter_columns($columns)
    {
        $columns['shortcode'] = __('Shortcode', 'modern-events-calendar-lite');
        return $columns;
    }

    /**
     * Filter column content of calendars/custom shortcodes
     * @author Webnus <info@webnus.biz>
     * @param string $column_name
     * @param int $post_id
     */
    public function filter_columns_content($column_name, $post_id)
    {
        if($column_name == 'shortcode')
        {
            echo '[MEC id="'.$post_id.'"]';
        }
    }

    /**
     * Register meta boxes of calendars/custom shortcodes
     * @author Webnus <info@webnus.biz>
     */
    public function register_meta_boxes()
    {
        // Fix conflict between Ultimate GDPR and niceSelect
        $screen = get_current_screen();
        if ( $screen->id == 'mec_calendars' ) remove_all_actions('acf/input/admin_head');

		add_meta_box('mec_calendar_display_options', __('Display Options', 'modern-events-calendar-lite'), array($this, 'meta_box_display_options'), 'mec_calendars', 'normal', 'high');
        add_meta_box('mec_calendar_filter', __('Filter Options', 'modern-events-calendar-lite'), array($this, 'meta_box_filter'), 'mec_calendars', 'normal', 'high');
        add_meta_box('mec_calendar_shortcode', __('Shortcode', 'modern-events-calendar-lite'), array($this, 'meta_box_shortcode'), 'mec_calendars', 'side');
        add_meta_box('mec_calendar_search_form', __('Search Form', 'modern-events-calendar-lite'), array($this, 'meta_box_search_form'), 'mec_calendars', 'side');
    }

    /**
     * Save calendars/custom shortcodes
     * @author Webnus <info@webnus.biz>
     * @param int $post_id
     * @return void
     */
    public function save_calendar($post_id)
    {
        // Check if our nonce is set.
        if(!isset($_POST['mec_calendar_nonce'])) return;

        // Verify that the nonce is valid.
        if(!wp_verify_nonce(sanitize_text_field($_POST['mec_calendar_nonce']), 'mec_calendar_data')) return;

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if(defined('DOING_AUTOSAVE') and DOING_AUTOSAVE) return;

        $terms = isset($_POST['mec_tax_input']) ? $_POST['mec_tax_input'] : array();

        $categories = (isset($terms['mec_category']) and is_array($terms['mec_category'])) ? implode(',', $terms['mec_category']) : '';
        $locations = (isset($terms['mec_location']) and is_array($terms['mec_location'])) ? implode(',', $terms['mec_location']) : '';
        $organizers = (isset($terms['mec_organizer']) and is_array($terms['mec_organizer'])) ? implode(',', $terms['mec_organizer']) : '';
        $labels = (isset($terms['mec_label']) and is_array($terms['mec_label'])) ? implode(',', $terms['mec_label']) : '';
        $tags = (isset($terms['mec_tag'])) ? explode(',', trim($terms['mec_tag'])) : '';
        $authors = (isset($terms['mec_author']) and is_array($terms['mec_author'])) ? implode(',', $terms['mec_author']) : '';

        // Fox tags
        if(is_array($tags) and count($tags) == 1 and trim($tags[0]) == '') $tags = array();
        if(is_array($tags))
        {
            $tags = array_map('trim', $tags);
            $tags = implode(',', $tags);
        }

        update_post_meta($post_id, 'label', $labels);
        update_post_meta($post_id, 'category', $categories);
        update_post_meta($post_id, 'location', $locations);
        update_post_meta($post_id, 'organizer', $organizers);
        update_post_meta($post_id, 'tag', $tags);
        update_post_meta($post_id, 'author', $authors);

        do_action('mec_shortcode_filters_save' , $post_id , $terms );

        $mec = isset($_POST['mec']) ? $_POST['mec'] : array();

        foreach($mec as $key=>$value) update_post_meta($post_id, $key, $value);
    }

    /**
     * Show content of filter meta box
     * @author Webnus <info@webnus.biz>
     * @param object $post
     */
    public function meta_box_filter($post)
    {
        $path = MEC::import('app.features.mec.meta_boxes.filter', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Show content of shortcode meta box
     * @author Webnus <info@webnus.biz>
     * @param object $post
     */
    public function meta_box_shortcode($post)
    {
        $path = MEC::import('app.features.mec.meta_boxes.shortcode', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Show content of search form meta box
     * @author Webnus <info@webnus.biz>
     * @param object $post
     */
    public function meta_box_search_form($post)
    {
        $path = MEC::import('app.features.mec.meta_boxes.search_form', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Show content of display options meta box
     * @author Webnus <info@webnus.biz>
     * @param object $post
     */
    public function meta_box_display_options($post)
    {
        $path = MEC::import('app.features.mec.meta_boxes.display_options', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Show content of skin options meta box
     * @author Webnus <info@webnus.biz>
     * @param object $post
     */
    public function meta_box_skin_options($post)
    {
        $path = MEC::import('app.features.mec.meta_boxes.skin_options', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Get Addons page
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function go_pro()
    {
        $this->display_go_pro();
    }

    /**
     * Show go_pro page
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function display_go_pro()
    {
        $path = MEC::import('app.features.mec.go-pro', true, true);
        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Get Addons page
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function addons()
    {
        $this->display_addons();
    }

    /**
     * Show Addons page
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function display_addons()
    {
        $path = MEC::import('app.features.mec.addons', true, true);
        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Get Report page
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function report()
    {
        $this->display_report();
    }

    /**
     * Show report page
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function display_report()
    {
        $path = MEC::import('app.features.mec.report', true, true);
        ob_start();
        include $path;
        do_action('mec_display_report_page', $path);
        echo $output = ob_get_clean();
    }

    /**
     * Show support page
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function display_support()
    {
        $path = MEC::import('app.features.mec.support-page', true, true);
        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * support page
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function support_page()
    {
        $this->display_support();
    }

    /**
     * Show content settings menu
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function page()
    {
        $tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'MEC-settings';

        if($tab == 'MEC-customcss') $this->styles();
        elseif($tab == 'MEC-ie') $this->import_export();
        elseif($tab == 'MEC-notifications') $this->notifications();
        elseif($tab == 'MEC-messages') $this->messages();
        elseif($tab == 'MEC-styling') $this->styling();
        elseif($tab == 'MEC-single') $this->single();
        elseif($tab == 'MEC-booking') $this->booking();
        elseif($tab == 'MEC-modules') $this->modules();
        else $this->settings();
    }

    /**
     * Show content of settings tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function settings()
    {
        $path = MEC::import('app.features.mec.settings', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Show content of styles tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function styles()
    {
        $path = MEC::import('app.features.mec.styles', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Show content of styling tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function styling()
    {
        $path = MEC::import('app.features.mec.styling', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Show content of single tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function single()
    {
        $path = MEC::import('app.features.mec.single', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Show content of booking tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function booking()
    {
        $path = MEC::import('app.features.mec.booking', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Show content of modules tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function modules()
    {
        $path = MEC::import('app.features.mec.modules', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Show content of import/export tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function import_export()
    {
        $path = MEC::import('app.features.mec.ie', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Show content of notifications tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function notifications()
    {
        $path = MEC::import('app.features.mec.notifications', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Show content of messages tab
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function messages()
    {
        $path = MEC::import('app.features.mec.messages', true, true);

        ob_start();
        include $path;
        echo $output = ob_get_clean();
    }

    /**
     * Whether to include google recaptcha library
     * @author Webnus <info@webnus.biz>
     * @param boolean $grecaptcha_include
     * @return boolean
     */
    public function grecaptcha_include($grecaptcha_include)
    {
        // Don't include the library if google recaptcha is not enabled
        if(!$this->main->get_recaptcha_status()) return false;

        return $grecaptcha_include;
    }

    /**
     * Whether to include google map library
     * @author Webnus <info@webnus.biz>
     * @param boolean $gm_include
     * @return boolean
     */
    public function gm_include($gm_include)
    {
        // Don't include the library if google Maps API is set to don't load
        if(isset($this->settings['google_maps_dont_load_api']) and $this->settings['google_maps_dont_load_api']) return false;

        return $gm_include;
    }

    /**
     * Single Event Display Method
     * @param string $skin
     * @param int $value
     * @return string
     */
    public function sed_method_field($skin, $value = 0, $image_popup = 0)
    {
        $image_popup_html = '<div class="mec-form-row mec-image-popup-wrap mec-switcher">
            <div class="mec-col-4">
                <label for="mec_skin_'.$skin.'_image_popup">'.__('Display content\'s images as Popup', 'modern-events-calendar-lite').'</label>
            </div>
            <div class="mec-col-4">
                <input type="hidden" name="mec[sk-options]['.$skin.'][image_popup]" value="0" />
                <input type="checkbox" name="mec[sk-options]['.$skin.'][image_popup]" id="mec_skin_'.$skin.'_image_popup" value="1"';

            if($image_popup == 1) $image_popup_html .= 'checked="checked"';

            $image_popup_html .= '/><label for="mec_skin_'.$skin.'_image_popup"></label>
            </div>
        </div>';

        return '<div class="mec-form-row mec-sed-method-wrap">
            <div class="mec-col-4">
                <label for="mec_skin_'.$skin.'_sed_method">'.__('Single Event Display Method', 'modern-events-calendar-lite').'</label>
            </div>
            <div class="mec-col-4">
                <input type="hidden" name="mec[sk-options]['.$skin.'][sed_method]" value="'.$value.'" id="mec_skin_'.$skin.'_sed_method_field" />
                <ul class="mec-sed-methods" data-for="#mec_skin_'.$skin.'_sed_method_field">
                    <li data-method="0" class="'.(!$value ? 'active' : '').'">'.__('Separate Window', 'modern-events-calendar-lite').'</li>
                    <li data-method="m1" class="'.($value === 'm1' ? 'active' : '').'">'.__('Modal Popup', 'modern-events-calendar-lite').'</li>
                </ul>
            </div>
        </div>' . $image_popup_html;
    }

    /**
     * Disable Gutenberg Editor for MEC Post Types
     * @param boolean $status
     * @param string $post_type
     * @return bool
     */
    public function gutenberg($status, $post_type)
    {
        if(in_array($post_type, array($this->PT, $this->main->get_book_post_type(), $this->main->get_shortcode_post_type()))) return false;
        return $status;
    }

    /**
     * Show Booking Badge.
     * @param object $screen
     * @return void
     */
    public function booking_badge($screen)
    {
        $user_id = get_current_user_id();
        $user_last_view_date = get_user_meta($user_id, 'user_last_view_date', true);
        $count = 0;

        if(!trim($user_last_view_date))
        {
            update_user_meta($user_id, 'user_last_view_date', date('YmdHis', current_time('timestamp', 0)));
            return;
        }

        $args = array(
            'post_type' => $this->main->get_book_post_type(),
            'post_status' => 'any',
            'meta_query' => array(
                array(
                    'key' => 'mec_book_date_submit',
                    'value' => $user_last_view_date,
                    'compare' => '>=',
                ),
            ),
        );

        $query = new WP_Query($args);
        if($query->have_posts())
        {
            while($query->have_posts())
            {
                $query->the_post();
                $count += 1;
            }
        }

        if($count != 0)
        {
            if(isset($screen->id) and $screen->id == 'edit-mec-books')
            {
                update_user_meta($user_id, 'user_last_view_date', date('YmdHis', current_time('timestamp', 0)));
                return;
            }

            // Append Booking Badge To Booking Menu.
            global $menu;

            $badge = ' <span class="update-plugins count-%%count%%"><span class="plugin-count">%%count%%</span></span>';
            $menu_item = wp_list_filter($menu, array(2 =>'edit.php?post_type='.$this->main->get_book_post_type()));
            if(is_array($menu_item) and count($menu_item))
            {
                $menu[key($menu_item)][0] .= str_replace('%%count%%', esc_attr($count), $badge);
            }
        }
    }

    /**
     * Show Events Badge.
     * @param object $screen
     * @return void
     */
    public function events_badge($screen)
    {
        if(!current_user_can('administrator') and !current_user_can('editor')) return;

        $user_id = get_current_user_id();
        $user_last_view_date_events = get_user_meta($user_id, 'user_last_view_date_events', true);
        $count = 0;

        if(!trim($user_last_view_date_events))
        {
            update_user_meta($user_id, 'user_last_view_date_events', date('YmdHis', current_time('timestamp', 0)));
            return;
        }

        $args = array(
            'post_type' => $this->main->get_main_post_type(),
            'post_status' => 'any',
            'meta_query' => array(
                array(
                    'key' => 'mec_event_date_submit',
                    'value' => $user_last_view_date_events,
                    'compare' => '>=',
                ),
            ),
        );

        $query = new WP_Query($args);
        if($query->have_posts())
        {
            while($query->have_posts())
            {
                $query->the_post();
                $count += 1;
            }
        }

        if($count != 0)
        {
            if(isset($screen->id) and $screen->id == 'edit-mec-events')
            {
                update_user_meta($user_id, 'user_last_view_date_events', date('YmdHis', current_time('timestamp', 0)));
                return;
            }

            // Append Events Badge To Event Menu.
            global $menu;

            $badge = ' <span class="update-plugins count-%%count%%"><span class="plugin-count">%%count%%</span></span>';
            $menu_item = wp_list_filter($menu, array(2 =>'mec-intro'));
            if(is_array($menu_item) and count($menu_item))
            {
                $menu[key($menu_item)][0] .= str_replace('%%count%%', esc_attr($count), $badge);
            }
        }
    }

    /**
     * Add MEC metaboxes in WordPress dashboard
     * @author Webnus <info@webnus.biz>
     */
    public function dashboard_widgets()
    {
        add_meta_box(
            'mec_widget_news_features',
            __('Modern Events Calendar', 'modern-events-calendar-lite'),
            array($this, 'widget_news'),
            'dashboard',
            'normal',
            'high'
        );

        if($this->getPRO())
        {
            add_meta_box(
                'mec_widget_total_bookings',
                __('Total Bookings', 'modern-events-calendar-lite'),
                array($this, 'widget_total_bookings'),
                'dashboard',
                'normal',
                'high'
            );
        }
    }

    /**
     * MEC render metabox in WordPress dashboard
     * @author Webnus <info@webnus.biz>
     */
    public function widget_news()
    {
        // Head Section
        echo '<div class="mec-metabox-head-wrap">
            <div class="mec-metabox-head-version">
                <img src="'.plugin_dir_url(__FILE__ ) . '../../assets/img/ico-mec-vc.png" />
                <p>'.($this->getPRO() ? __('Modern Events Calendar', 'modern-events-calendar-lite') : __('Modern Events Calendar (Lite)', 'modern-events-calendar-lite')).'</p>
                <a href="'.esc_html__(admin_url( 'post-new.php?post_type=mec-events' )).'" class="button"><span aria-hidden="true" class="dashicons dashicons-plus"></span> Create New Event</a>
            </div>
            <div class="mec-metabox-head-button"></div>
            <div style="clear:both"></div>
        </div>';

        // Upcoming Events
        $upcoming_events = $this->main->get_upcoming_events(3);
        echo '<div class="mec-metabox-upcoming-wrap"><h3 class="mec-metabox-feed-head">'.esc_html__('Upcoming Events' , 'modern-events-calendar-lite').'</h3><ul>';
        foreach($upcoming_events as $date => $content)
        {
            foreach($content as $array_id => $array_content)
            {
                $location_id = $array_content->data->meta['mec_location_id'];
                $event_title = $array_content->data->title;
                $event_link  = $array_content->data->permalink;
                $event_date  = $this->main->date_i18n(get_option('date_format'), $array_content->date['start']['date']);
                $location = get_term($location_id, 'mec_location');

                $locationName = '';
                if(isset($location->name)) $locationName = $location->name;
                echo '<li>
                    <span aria-hidden="true" class="dashicons dashicons-calendar-alt"></span>
                    <div class="mec-metabox-upcoming-event">
                        <a href="'.$event_link.'" target="">'.$event_title.'</a>
                        <div class="mec-metabox-upcoming-event-location">'.$locationName.'</div>
                    </div>
                    <div class="mec-metabox-upcoming-event-date">'.$event_date.'</div>
                    <div style="clear:both"></div>
                </li>';
            }
        }

        echo '</ul></div>';

        $data_url = 'https://webnus.net/wp-json/wninfo/v1/posts';
        if(function_exists('file_get_contents') && ini_get('allow_url_fopen'))
        {
            $ctx = stream_context_create(array('http'=>
                array(
                    'timeout' => 20,
                )
            ));

            $get_data = file_get_contents($data_url, false, $ctx);
            if($get_data !== false and !empty($get_data))
            {
                $obj = json_decode($get_data);
            }
        }
        elseif(function_exists('curl_version'))
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20); //timeout in seconds
            curl_setopt($ch, CURLOPT_URL, $data_url);

            $result = curl_exec($ch);
            curl_close($ch);
            $obj = json_decode($result);
        }
        else
        {
            $obj = '';
        }

        // News
        if(!empty($obj))
        {
            echo '<h3 class="mec-metabox-feed-head">'.esc_html__('News & Updates' , 'modern-events-calendar-lite').'</h3><div class="mec-metabox-feed-content"><ul>';
            foreach($obj as $key => $value)
            {
                echo '<li>
                    <a href="'.$value->link.'" target="_blank">'.$value->title.'</a>
                    <p>'.$value->content.'</p>
                </li>';
            }

            echo '</ul></div>';
        }

        // Links
        echo '<div class="mec-metabox-footer"><a href="https://webnus.net/blog/" target="_blank">'.esc_html__('Blog', 'modern-events-calendar-lite').'<span aria-hidden="true" class="dashicons dashicons-external"></span></a><a href="https://webnus.net/dox/modern-events-calendar/" target="_blank">'.esc_html__('Help', 'modern-events-calendar-lite').'<span aria-hidden="true" class="dashicons dashicons-external"></span></a>';
        if($this->getPRO()) echo '<a href="https://webnus.net/mec-purchase" target="_blank">'.esc_html__('Go Pro', 'modern-events-calendar-lite').'<span aria-hidden="true" class="dashicons dashicons-external"></span></a>';
        echo '</div>';
    }

    public function widget_total_bookings()
    {
        wp_enqueue_script('mec-chartjs-script', $this->main->asset('js/chartjs.min.js'));
        $current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        ?>
        <div class="w-row <?php echo (($current_page == 'dashboard') ? 'mec-dashboard-widget-total-bookings' : ''); ?>">
            <div class="w-col-sm-12">
                <div class="w-box total-bookings">
                    <div class="w-box-head">
                        <?php echo esc_html__('Total Bookings', 'modern-events-calendar-lite'); ?>
                    </div>
                    <div class="w-box-content">
                        <?php
                        $start = isset($_GET['start']) ? sanitize_text_field($_GET['start']) : date('Y-m-d', strtotime('-15 days'));
                        $end = isset($_GET['end']) ? sanitize_text_field($_GET['end']) : date('Y-m-d');
                        $type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'daily';
                        $chart = isset($_GET['chart']) ? sanitize_text_field($_GET['chart']) : 'bar';

                        $periods = $this->main->get_date_periods($start, $end, $type);

                        $stats = '';
                        $labels = '';
                        foreach($periods as $period)
                        {
                            $posts_ids = $this->db->select("SELECT `ID` FROM `#__posts` WHERE `post_type`='".$this->main->get_book_post_type()."' AND `post_date`>='".$period['start']."' AND `post_date`<='".$period['end']."'", 'loadColumn');

                            if(count($posts_ids)) $total_sells = $this->db->select("SELECT SUM(`meta_value`) FROM `#__postmeta` WHERE `meta_key`='mec_price' AND `post_id` IN (".implode(',', $posts_ids).")", 'loadResult');
                            else $total_sells = 0;

                            $labels .= '"'.$period['label'].'",';
                            $stats .= $total_sells.',';
                        }

                        $currency = $this->main->get_currency_sign();
                        ?>
                        <ul>
                            <li><a href="<?php echo add_query_arg(array(
                                'start' => date('Y-m-01'),
                                'end' => date('Y-m-t'),
                                'type' => 'daily',
                                'chart' => $chart,
                            )); ?>"><?php _e('This Month', 'modern-events-calendar-lite'); ?></a></li>
                            <li><a href="<?php echo add_query_arg(array(
                                'start' => date('Y-m-01', strtotime('-1 Month')),
                                'end' => date('Y-m-t', strtotime('-1 Month')),
                                'type' => 'daily',
                                'chart' => $chart,
                            )); ?>"><?php _e('Last Month', 'modern-events-calendar-lite'); ?></a></li>
                            <li><a href="<?php echo add_query_arg(array(
                                'start' => date('Y-01-01'),
                                'end' => date('Y-12-31'),
                                'type' => 'monthly',
                                'chart' => $chart,
                            )); ?>"><?php _e('This Year', 'modern-events-calendar-lite'); ?></a></li>
                            <li><a href="<?php echo add_query_arg(array(
                                'start' => date('Y-01-01', strtotime('-1 Year')),
                                'end' => date('Y-12-31', strtotime('-1 Year')),
                                'type' => 'monthly',
                                'chart' => $chart,
                            )); ?>"><?php _e('Last Year', 'modern-events-calendar-lite'); ?></a></li>
                        </ul>
                        <form class="mec-sells-filter" method="GET" action="">
                            <?php if($current_page != 'dashboard'): ?><input type="hidden" name="page" value="mec-intro" /><?php endif; ?>
                            <input type="text" class="mec_date_picker" name="start" placeholder="<?php esc_attr_e('Start Date', 'modern-events-calendar-lite'); ?>" value="<?php echo $start; ?>" />
                            <input type="text" class="mec_date_picker" name="end" placeholder="<?php esc_attr_e('End Date', 'modern-events-calendar-lite'); ?>" value="<?php echo $end; ?>" />
                            <select name="type">
                                <option value="daily" <?php echo $type == 'daily' ? 'selected="selected"' : ''; ?>><?php _e('Daily', 'modern-events-calendar-lite'); ?></option>
                                <option value="monthly" <?php echo $type == 'monthly' ? 'selected="selected"' : ''; ?>><?php _e('Monthly', 'modern-events-calendar-lite'); ?></option>
                                <option value="yearly" <?php echo $type == 'yearly' ? 'selected="selected"' : ''; ?>><?php _e('Yearly', 'modern-events-calendar-lite'); ?></option>
                            </select>
                            <select name="chart">
                                <option value="bar" <?php echo $chart == 'bar' ? 'selected="selected"' : ''; ?>><?php _e('Bar', 'modern-events-calendar-lite'); ?></option>
                                <option value="line" <?php echo $chart == 'line' ? 'selected="selected"' : ''; ?>><?php _e('Line', 'modern-events-calendar-lite'); ?></option>
                            </select>
                            <button type="submit"><?php _e('Filter', 'modern-events-calendar-lite'); ?></button>
                        </form>
                        <?php
                        echo '<canvas id="mec_total_bookings_chart" width="600" height="300"></canvas>';
                        echo '<script type="text/javascript">
                            jQuery(document).ready(function()
                            {
                                var ctx = document.getElementById("mec_total_bookings_chart");
                                var mecSellsChart = new Chart(ctx,
                                {
                                    type: "'.$chart.'",
                                    data:
                                    {
                                        labels: ['.trim($labels, ', ').'],
                                        datasets: [
                                        {
                                            label: "'.esc_js(sprintf(__('Total Sells (%s)', 'modern-events-calendar-lite'), $currency)).'",
                                            data: ['.trim($stats, ', ').'],
                                            backgroundColor: "rgba(159, 216, 255, 0.3)",
                                            borderColor: "#36A2EB",
                                            borderWidth: 1
                                        }]
                                    }
                                });
                            });
                        </script>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function widget_print()
    {
        $start_year = $min_start_year = $this->db->select("SELECT MIN(cast(meta_value as unsigned)) AS date FROM `#__postmeta` WHERE `meta_key`='mec_start_date'", 'loadResult');
        $end_year = $max_end_year = $this->db->select("SELECT MAX(cast(meta_value as unsigned)) AS date FROM `#__postmeta` WHERE `meta_key`='mec_end_date'", 'loadResult');
        $current_month = current_time('m');
        ?>
        <div class="w-row">
            <div class="w-col-sm-12">
                <div class="w-box total-bookings print-events">
                    <div class="w-box-head">
                        <?php echo esc_html__('Print Calendar', 'modern-events-calendar-lite'); ?>
                    </div>
                    <div class="w-box-content">
                        <form method="GET" action="<?php echo home_url(); ?>" target="_blank">
                            <input type="hidden" name="method" value="mec-print">
                            <select name="mec-year" title="<?php esc_attr('Year', 'modern-events-calendar-lite'); ?>">
                                <?php for($i = $start_year; $i <= $end_year; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo ($i == date('Y', current_time('timestamp', 0))) ? 'selected="selected"' : ''; ?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <select name="mec-month" title="<?php esc_attr('Month', 'modern-events-calendar-lite'); ?>">
                                <?php for($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo ($i < 10 ? '0'.$i : $i); ?>" <?php echo ($current_month == $i ? 'selected="selected"' : ''); ?>><?php echo $this->main->date_i18n('F', mktime(0, 0, 0, $i, 10)); ?></option>
                                <?php endfor; ?>
                            </select>
                            <button type="submit"><?php _e('Display Events', 'modern-events-calendar-lite'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
