<?php

namespace Essential_Addons_Elementor\Pro\Traits;

use \Elementor\Controls_Manager;

trait Helper
{
    use \Essential_Addons_Elementor\Template\Woocommerce\Checkout\Woo_Checkout_Helper;
    /**
     * Get all product tags
     *
     * @return array
     */
    public function eael_get_woo_product_tags()
    {
        if (!apply_filters('eael/active_plugins', 'woocommerce/woocommerce.php')) {
            return [];
        }

        $options = [];
        $tags = get_terms('product_tag', array('hide_empty' => true));

        foreach ($tags as $tag) {
            $options[$tag->term_id] = $tag->name;
        }

        return $options;
    }

    /**
     * Get all product attributes
     *
     * @return array
     */
    public function eael_get_woo_product_atts()
    {

        if (!apply_filters('eael/active_plugins', 'woocommerce/woocommerce.php')) {
            return [];
        }

        $options = [];
        $taxonomies = wc_get_attribute_taxonomies();

        foreach ($taxonomies as $tax) {
            $terms = get_terms('pa_' . $tax->attribute_name);

            if (!empty($terms)) {
                foreach ($terms as $term) {
                    $options[$term->term_id] = $tax->attribute_label . ': ' . $term->name;
                }
            }
        }

        return $options;
    }

    /**
     * Get all registered menus.
     *
     * @return array of menus.
     */
    public function eael_get_menus()
    {
        $menus = wp_get_nav_menus();
        $options = [];

        if (empty($menus)) {
            return $options;
        }

        foreach ($menus as $menu) {
            $options[$menu->term_id] = $menu->name;
        }

        return $options;
    }

    public function get_page_template_options($type = '')
    {

        $page_templates = $this->eael_get_page_templates($type);

        $options[-1] = __('Select', 'essential-addons-elementor');

        if (count($page_templates)) {
            foreach ($page_templates as $id => $name) {
                $options[$id] = $name;
            }
        } else {
            $options['no_template'] = __('No saved templates found!', 'essential-addons-elementor');
        }

        return $options;
    }

    // Get all WordPress registered widgets
    public function get_registered_sidebars()
    {
        global $wp_registered_sidebars;
        $options = [];

        if (!$wp_registered_sidebars) {
            $options[''] = __('No sidebars were found', 'essential-addons-elementor');
        } else {
            $options['---'] = __('Choose Sidebar', 'essential-addons-elementor');

            foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) {
                $options[$sidebar_id] = $sidebar['name'];
            }
        }
        return $options;
    }

    public function eael_get_block_pass_protected_form($widget_id, $settings)
    {
        echo '<div class="eael-password-protected-content-fields">';
        echo '<form method="post">';
        echo '<input type="password" name="protection_password_' . $widget_id . '" class="eael-password" placeholder="' . $settings['protection_password_placeholder'] . '">';
        echo '<input type="submit" value="' . $settings['protection_password_submit_btn_txt'] . '" class="eael-submit">';
        echo '</form>';
        if (isset($_POST['protection_password_' . $widget_id]) && ($settings['protection_password'] !== $_POST['protection_password_' . $widget_id])) {
            echo sprintf(__('<p class="protected-content-error-msg">%s</p>', 'essential-addons-elementor'), $settings['password_incorrect_message']);
        }
        echo '</div>';
    }

    /**
     * @param Widget_Base $widget
     */
    public function add_exclude_controls()
    {
        $this->add_control(
            'post__not_in',
            [
                'label' => __('Exclude', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->eael_get_all_types_post(),
                'label_block' => true,
                'post_type' => '',
                'multiple' => true,
                'condition' => [
                    'post_type!' => 'by_id',
                ],
            ]
        );
    }

    protected function post_list_layout_controls()
    {

        $this->start_controls_section(
            'eael_section_post_list_layout',
            [
                'label' => __('Layout Settings', 'essential-addons-elementor'),
            ]
        );

        if ($this->get_name() === 'eael-post-list') {

            $this->add_control(
                'eael_post_list_layout_type',
                [
                    'label' => __('Layout Type', 'essential-addons-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'default' => __('Default', 'essential-addons-elementor'),
                        'advanced' => __('Advance', 'essential-addons-elementor'),
                    ],
                    'default' => 'default',
                ]
            );

            $this->add_control(
                'eael_enable_ajax_post_search',
                [
                    'label' => __('Enable Ajax Post Search', 'essential-addons-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'false',
                    'label_on' => __('Yes', 'essential-addons-elementor'),
                    'label_off' => __('No', 'essential-addons-elementor'),
                    'return_value' => 'yes',
                    'condition' => [
                        'post_type!'    => 'by_id',
                        'eael_post_list_layout_type' => 'advanced',
                    ],
                ]
            );
        }

        $this->add_control(
            'eael_post_list_topbar',
            [
                'label' => __('Show Top Bar', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'eael_post_list_topbar_title',
            [
                'label' => esc_html__('Title Text', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => esc_html__('Recent Posts', 'essential-addons-elementor'),
                'condition' => [
                    'eael_post_list_topbar' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'eael_post_list_topbar_term_all_text',
            [
                'label' => esc_html__('Change All Text', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => esc_html__('All', 'essential-addons-elementor'),
                'condition' => [
                    'eael_post_list_topbar' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'eael_post_list_terms',
            [
                'label' => __('Show Category Filter', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
                'condition' => [
                    'eael_post_list_topbar' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'eael_post_list_pagination',
            [
                'label' => __('Show Navigation', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'eael_post_list_pagination_prev_icon_new',
            [
                'label' => esc_html__('Prev Post Icon', 'essential-addons-elementor'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'eael_adv_accordion_icon',
                'default' => [
                    'value' => 'fas fa-angle-left',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'eael_post_list_pagination' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'eael_post_list_pagination_next_icon_new',
            [
                'label' => esc_html__('Next Post Icon', 'essential-addons-elementor'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'eael_adv_accordion_icon',
                'default' => [
                    'value' => 'fas fa-angle-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'eael_post_list_pagination' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'eael_post_list_featured_area',
            [
                'label' => __('Show Featured Post', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );

        $this->end_controls_section();

    }

    // Get Mailchimp list
    public function eael_mailchimp_lists()
    {
        $lists = [];
        $api_key = get_option('eael_save_mailchimp_api');

        $response = wp_remote_get('https://' . substr($api_key, strpos($api_key, '-') + 1) . '.api.mailchimp.com/3.0/lists/?fields=lists.id,lists.name&count=1000', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode('user:' . $api_key),
            ],
        ]);

        if (!is_wp_error($response)) {
            $response = json_decode(wp_remote_retrieve_body($response));

            if (!empty($response) && !empty($response->lists)) {
                $lists = ['' => 'Select One'];

                for ($i = 0; $i < count($response->lists); $i++) {
                    $lists[$response->lists[$i]->id] = $response->lists[$i]->name;
                }
            }
        }

        return $lists;
    }

    // Subscribe to Mailchimp list
    public function mailchimp_subscribe_with_ajax()
    {
        if (!isset($_POST['fields'])) {
            return;
        }

        $api_key = $_POST['apiKey'];
        $list_id = $_POST['listId'];

        parse_str($_POST['fields'], $settings);

        $merge_fields = array(
            'FNAME' => !empty($settings['eael_mailchimp_firstname']) ? $settings['eael_mailchimp_firstname'] : '',
            'LNAME' => !empty($settings['eael_mailchimp_lastname']) ? $settings['eael_mailchimp_lastname'] : '',
        );

        $response = wp_remote_post('https://' . substr($api_key, strpos($api_key, '-') + 1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($settings['eael_mailchimp_email'])), [
            'method' => 'PUT',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode('user:' . $api_key),
            ],
            'body' => json_encode([
                'email_address' => $settings['eael_mailchimp_email'],
                'status' => 'subscribed',
                'merge_fields' => $merge_fields,
            ]),
        ]);

        if (!is_wp_error($response)) {
            $response = json_decode(wp_remote_retrieve_body($response));

            if (!empty($response)) {
                if ($response->status == 'subscribed') {
                    wp_send_json([
                        'status' => 'subscribed'
                    ]);
                } else {
                    wp_send_json([
                        'status' => $response->title
                    ]);
                }
            }
        }
    }

    public function ajax_post_search()
    {
        if (!isset($_POST['_nonce']) && !wp_verify_nonce($_POST['_nonce'], 'eael_ajax_post_search_nonce_action')) {
            return;
        }

        $html  = '';
        $args = array(
            'post_type' => esc_attr($_POST['post_type']),
            'post_status' => 'publish',
            's' => esc_attr($_POST['key']),
        );

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $html .= '<div class="ajax-search-result-post">
                    <h6><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h6>
                </div>';
            }
        }

        echo $html;
        die();
    }

    public function instafeed_render_items()
    {   
        // check if ajax request
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'instafeed_load_more') {
            // check ajax referer
            check_ajax_referer('essential-addons-elementor', 'security');
            
            // init vars
            $page = $_REQUEST['page'];
            parse_str($_REQUEST['settings'], $settings);
        } else {
            // init vars
            $page = 0;
            $settings = $this->get_settings();
        }

        $key = 'eael_instafeed_' . str_replace('.', '_', $settings['eael_instafeed_access_token']);
        $html = '';

        if (get_transient($key) === false) {
            $instagram_data = wp_remote_retrieve_body(wp_remote_get('https://api.instagram.com/v1/users/self/media/recent/?access_token=' . $settings['eael_instafeed_access_token']));
            set_transient($key, $instagram_data, 1800);
        } else {
            $instagram_data = get_transient($key);
        }

        $instagram_data = json_decode($instagram_data, true);

        if (empty($instagram_data['data'])) {
            return;
        }

        if (empty($settings['eael_instafeed_image_count']['size'])) {
            return;
        }

        switch ($settings['eael_instafeed_sort_by']) {
            case 'most-recent':
                usort($instagram_data['data'], function($a, $b) {
                    return $a['created_time'] < $b['created_time'];
                });
                break;

            case 'least-recent':
                usort($instagram_data['data'], function($a, $b) {
                    return $a['created_time'] > $b['created_time'];
                });
                break;

            case 'most-liked':
                usort($instagram_data['data'], function ($a, $b) {
                    return $a['likes']['count'] <= $b['likes']['count'];
                });
                break;

            case 'least-liked':
                usort($instagram_data['data'], function ($a, $b) {
                    return $a['likes']['count'] >= $b['likes']['count'];
                });
                break;

            case 'most-commented':
                usort($instagram_data['data'], function ($a, $b) {
                    return $a['comments']['count'] <= $b['comments']['count'];
                });
                break;

            case 'least-commented':
                usort($instagram_data['data'], function ($a, $b) {
                    return $a['comments']['count'] >= $b['comments']['count'];
                });
                break;
        }

        if ($items = $instagram_data['data']) {
            $items = array_splice($items, ($page * $settings['eael_instafeed_image_count']['size']), $settings['eael_instafeed_image_count']['size']);

            foreach ($items as $item) {
                if ('yes' === $settings['eael_instafeed_link']) {
                    $target = ($settings['eael_instafeed_link_target']) ? 'target=_blank' : 'target=_self';
                } else {
                    $item['link'] = '#';
                    $target = '';
                }

                if($settings['eael_instafeed_layout'] == 'overlay') {
                    $html .= '<a href="' . $item['link'] . '" ' . esc_attr($target) . ' class="eael-instafeed-item">
                        <div class="eael-instafeed-item-inner">
                            <img class="eael-instafeed-img" src="' . $item['images'][$settings['eael_instafeed_image_resolution']]['url'] . '" width="' . $item['images'][$settings['eael_instafeed_image_resolution']]['width'] . '" height="' . $item['images'][$settings['eael_instafeed_image_resolution']]['height'] . '">

                            <div class="eael-instafeed-caption">
                                <div class="eael-instafeed-caption-inner">';
                                    if ($settings['eael_instafeed_overlay_style'] == 'simple' || $settings['eael_instafeed_overlay_style'] == 'standard') {
                                        $html .= '<div class="eael-instafeed-icon">
                                            <i class="fab fa-instagram" aria-hidden="true"></i>
                                        </div>';
                                    } else if ($settings['eael_instafeed_overlay_style'] == 'basic') {
                                        if ($settings['eael_instafeed_caption'] && !empty($item['caption']['text'])) {
                                            $html .= '<p class="eael-instafeed-caption-text">' . substr($item['caption']['text'], 0, 60) . '...</p>';
                                        }
                                    }
                                    
                                    $html .= '<div class="eael-instafeed-meta">';
                                        if ($settings['eael_instafeed_overlay_style'] == 'basic' && $settings['eael_instafeed_date']) {
                                            $html .= '<span class="eael-instafeed-post-time"><i class="far fa-clock" aria-hidden="true"></i> ' . date("d M Y", $item['created_time']) . '</span>';
                                        }
                                        if ($settings['eael_instafeed_overlay_style'] == 'standard') {
                                            if ($settings['eael_instafeed_caption'] && !empty($item['caption']['text'])) {
                                                $html .= '<p class="eael-instafeed-caption-text">' . substr($item['caption']['text'], 0, 60) . '...</p>';
                                            }
                                        }
                                        if ($settings['eael_instafeed_likes']) {
                                            $html .= '<span class="eael-instafeed-post-likes"><i class="far fa-heart" aria-hidden="true"></i> ' . $item['likes']['count'] . '</span>';
                                        }
                                        if ($settings['eael_instafeed_comments']) {
                                            $html .= '<span class="eael-instafeed-post-comments"><i class="far fa-comments" aria-hidden="true"></i> ' . $item['comments']['count'] . '</span>';
                                        }
                                    $html .= '</div>';
                                $html .= '</div>
                            </div>
                        </div>
                    </a>';
                } else {
                    $html .= '<div class="eael-instafeed-item">
                        <div class="eael-instafeed-item-inner">
                            <header class="eael-instafeed-item-header clearfix">
                                <div class="eael-instafeed-item-user clearfix">
                                    <a href="//www.instagram.com/' . $item['user']['username'] . '"><img src="' . $item['user']['profile_picture'] . '" alt="' . $item['user']['username'] . '" class="eael-instafeed-avatar"></a>
                                    <a href="//www.instagram.com/' . $item['user']['username'] . '"><p class="eael-instafeed-username">' . $item['user']['full_name'] . '</p></a>
                                </div>
                                <span class="eael-instafeed-icon"><i class="fab fa-instagram" aria-hidden="true"></i></span>';

                                if ($settings['eael_instafeed_date'] && $settings['eael_instafeed_card_style'] == 'outer') {
                                    $html .= '<span class="eael-instafeed-post-time"><i class="far fa-clock" aria-hidden="true"></i> ' . date("d M Y", $item['created_time']) . '</span>';
                                }
                            $html .= '</header>
                            <a href="' . $item['link'] . '" ' . esc_attr($target) . ' class="eael-instafeed-item-content">
                                <img class="eael-instafeed-img" src="' . $item['images'][$settings['eael_instafeed_image_resolution']]['url'] . '">';

                                if ($settings['eael_instafeed_card_style'] == 'inner' && $settings['eael_instafeed_caption'] && !empty($item['caption']['text'])) {
                                    $html .= '<div class="eael-instafeed-caption">
                                        <div class="eael-instafeed-caption-inner">
                                            <div class="eael-instafeed-meta">
                                                <p class="eael-instafeed-caption-text">' . substr($item['caption']['text'], 0, 60) . '...</p>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            $html .= '</a>
                            <footer class="eael-instafeed-item-footer">
                                <div class="clearfix">';
                                    if ($settings['eael_instafeed_likes']) {
                                        $html .= '<span class="eael-instafeed-post-likes"><i class="far fa-heart" aria-hidden="true"></i> ' . $item['likes']['count'] . '</span>';
                                    }
                                    if ($settings['eael_instafeed_comments']) {
                                        $html .= '<span class="eael-instafeed-post-comments"><i class="far fa-comments" aria-hidden="true"></i> ' . $item['comments']['count'] . '</span>';
                                    }
                                    if ($settings['eael_instafeed_card_style'] == 'inner' && $settings['eael_instafeed_date']) {
                                        $html .= '<span class="eael-instafeed-post-time"><i class="far fa-clock" aria-hidden="true"></i> ' . date("d M Y", $item['created_time']) . '</span>';
                                    }
                                $html .= '</div>';
                                
                                if ($settings['eael_instafeed_card_style'] == 'outer' && $settings['eael_instafeed_caption'] && !empty($item['caption']['text'])) {
                                    $html .= '<p class="eael-instafeed-caption-text">' . substr($item['caption']['text'], 0, 60) . '...</p>';
                                }
                            $html .= '</footer>
                        </div>
                    </div>';
                }       
            }
        }

        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'instafeed_load_more') {
            wp_send_json([
                'num_pages' => ceil(count($instagram_data['data']) / $settings['eael_instafeed_image_count']['size']),
                'html' => $html
            ]);
        }

        return $html;
    }

    /**
     * Get post tags with id or slug
     * 
     * @param string $type
     */
    public function eael_post_type_tags($type = 'term_id')
    {
        $options = [];
        
        $tags = get_tags([
            'hide_empty'    => true
        ]);

        if(!empty($tags) && !is_wp_error($tags)) {
            foreach($tags as $tag) {
                $options[$tag->{$type}] = $tag->name;
            }
        }

        return $options;
    }

    public function eael_eael_learndash_post_taxonomy($taxonomy, $type = 'term_id')
    {
        $options = [];

        if( taxonomy_exists($taxonomy) ) {
            $tags = get_terms([
                'taxonomy'   => $taxonomy,
                'hide_empty' => false
            ]);
    
            if (!empty($tags) && !is_wp_error($tags)) {
                foreach ($tags as $tag) {
                    $options[$tag->{$type}] = $tag->name;
                }
            }
        }
        
        return $options;
    }

    public function eael_user_roles()
    {
        global $wp_roles;
        $all = $wp_roles->roles;
        $all_roles = array();
        if (!empty($all)) {
            foreach ($all as $key => $value) {
                $all_roles[$key] = $all[$key]['name'];
            }
        }
        return $all_roles;
    }

    public function eael_list_db_tables()
    {
        global $wpdb;

        $result = [];
        $tables = $wpdb->get_results('show tables', ARRAY_N);

        if($tables) {
            $tables = wp_list_pluck($tables, 0);

            foreach ($tables as $table) {
                $result[$table] = $table;
            }
        }

        return $result;
    }
    
    public function eael_list_tablepress_tables()
    {
        $result = [];
        $tables = \TablePress::$model_table->load_all(true);

        if($tables) {
            foreach ($tables as $table) {
                $table = \TablePress::$model_table->load($table, false, false);
	            $result[$table['id']] = $table['name'];
            }
        }

        return $result;
    }

    public function eael_connect_remote_db() {
        // check ajax referer
        check_ajax_referer('essential-addons-elementor', 'security');

        $result = [
            'connected' => false,
            'tables' => []
        ];

        if(empty($_REQUEST['host']) || empty($_REQUEST['username']) || empty($_REQUEST['password']) || empty($_REQUEST['database'])) {
            wp_send_json($result);
        }

        $conn = new \mysqli($_REQUEST['host'], $_REQUEST['username'], $_REQUEST['password'], $_REQUEST['database']);

        if ($conn->connect_error) {
            wp_send_json($result);
        } else {
            $query = $conn->query("show tables");
            
            if($query) {
                $tables = $query->fetch_all();

                $result['connected'] = true;
                $result['tables'] = wp_list_pluck($tables, 0);
            }

            $conn->close();
        }

        wp_send_json($result);
    }



	/**
	 * Show the split layout.
	 */
	public static function woo_checkout_render_split_template_($checkout, $settings) {

		$ea_woo_checkout_btn_next_data = $settings['ea_woo_checkout_tabs_btn_next_text'];

		?>
        <div class="layout-split-container">
            <div class="info-area">
                <ul class="split-tabs">
					<?php
					$step1_class = 'first active';
					$enable_login_reminder = false;

					if( (\Elementor\Plugin::$instance->editor->is_edit_mode() && 'yes' === $settings['ea_section_woo_login_show']) || (!is_user_logged_in() && 'yes' === get_option( 'woocommerce_enable_checkout_login_reminder'))){
						$enable_login_reminder = true;
						$step1_class = '';
						?>
                        <li id="step-0" data-step="0" class="split-tab first active"><?php echo
                                $settings['ea_woo_checkout_tab_login_text']; ?></li>
						<?php
					}
					?>
                    <li id="step-1" class="split-tab <?php echo $step1_class; ?>" data-step="1" ><?php echo
                        $settings['ea_woo_checkout_tab_coupon_text']; ?></li>
                    <li id="step-2" class="split-tab" data-step="2"><?php echo $settings['ea_woo_checkout_tab_billing_shipping_text']; ?></li>
                    <li id="step-3" class="split-tab last" data-step="3"><?php echo $settings['ea_woo_checkout_tab_payment_text']; ?></li>
                </ul>

                <div class="split-tabs-content">
                    <?php
                    // If checkout registration is disabled and not logged in, the user cannot checkout.
                    if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
                        echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
                        return;
                    }
                    ?>

                    <?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>

                    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

                        <?php if ( $checkout->get_checkout_fields() ) : ?>

                            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                            <div class="col2-set" id="customer_details">
                                <div class="col-1">
                                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                                </div>

                                <div class="col-2">
                                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                                </div>
                            </div>

                            <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

                        <?php endif; ?>

                        <div class="woo-checkout-payment">
                            <h3 id="payment-title" class="woo-checkout-section-title"><?php esc_html_e( 'Payment Methods', 'essential-addons-for-elementor-lite' ); ?></h3>

                            <?php woocommerce_checkout_payment(); ?>
                        </div>

                    </form>

                    <?php do_action('woocommerce_after_checkout_form', $checkout); ?>

                    <div class="steps-buttons">
                        <button class="ea-woo-checkout-btn-prev"><?php echo $settings['ea_woo_checkout_tabs_btn_prev_text']; ?></button>
                        <button class="ea-woo-checkout-btn-next" data-text="<?php echo htmlspecialchars(json_encode
                        ($ea_woo_checkout_btn_next_data), ENT_QUOTES, 'UTF-8'); ?>" ><?php echo $settings['ea_woo_checkout_tabs_btn_next_text']; ?></button>
                        <button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="ea_place_order" value="Place order" data-value="Place order" style="display:none;">Place order</button>
                    </div>
                </div>
            </div>

            <div class="table-area">
                <div class="ea-woo-checkout-order-review">
					<?php self::checkout_order_review_default($settings); ?>
                </div>
            </div>
        </div>
	<?php }

    /**
     * validate woocommerce post code
     *
     * @since  3.6.4
     */
    public function eael_woo_checkout_post_code_validate () {
        $data = $_POST['data'];
        $validate = true;
        if (isset($data['postcode'])) {

            $format = wc_format_postcode($data['postcode'], $data['country']);
            if ('' !== $format && !\WC_Validation::is_postcode($data['postcode'], $data['country'])) {
                $validate = false;
            }
        }
        wp_send_json($validate);
    }

	/**
	 * Show the multi step layout.
	 */
	public static function woo_checkout_render_multi_steps_template_($checkout, $settings) {

		$ea_woo_checkout_btn_next_data = $settings['ea_woo_checkout_tabs_btn_next_text'];
		?>
        <div class="layout-multi-steps-container">
            <ul class="ms-tabs">
				<?php
				$step1_class = 'first active';
				$enable_login_reminder = false;

				if( (\Elementor\Plugin::$instance->editor->is_edit_mode() && 'yes' === $settings['ea_section_woo_login_show']) || (!is_user_logged_in() && 'yes' === get_option( 'woocommerce_enable_checkout_login_reminder'))){
					$enable_login_reminder = true;
					$step1_class = '';
					?>
                    <li class="ms-tab first active" id="step-0" data-step="0"><?php echo
						$settings['ea_woo_checkout_tab_login_text']; ?></li>
					<?php
				}
				?>
                <li class="ms-tab <?php echo $step1_class; ?>" id="step-1" data-step="1"><?php echo $settings['ea_woo_checkout_tab_coupon_text']; ?></li>
                <li class="ms-tab" id="step-2" data-step="2"><?php echo $settings['ea_woo_checkout_tab_billing_shipping_text']; ?></li>
                <li class="ms-tab last" id="step-3" data-step="3"><?php echo $settings['ea_woo_checkout_tab_payment_text']; ?></li>
            </ul>

            <div class="ms-tabs-content-wrap">
                <div class="ms-tabs-content">
					<?php
					// If checkout registration is disabled and not logged in, the user cannot checkout.
					if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
						echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
						return;
					}
					?>

					<?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>

                    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

						<?php if ( $checkout->get_checkout_fields() ) : ?>

							<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                            <div class="col2-set" id="customer_details">
                                <div class="col-1">
									<?php do_action( 'woocommerce_checkout_billing' ); ?>
                                </div>

                                <div class="col-2">
									<?php do_action( 'woocommerce_checkout_shipping' ); ?>
                                </div>
                            </div>

							<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

						<?php endif; ?>

                        <div class="woo-checkout-payment">
                            <h3 id="payment-title" class="woo-checkout-section-title"><?php esc_html_e( 'Payment Methods', 'essential-addons-for-elementor-lite' ); ?></h3>

							<?php woocommerce_checkout_payment(); ?>
                        </div>

                    </form>

					<?php do_action('woocommerce_after_checkout_form', $checkout); ?>

                    <div class="steps-buttons">
                        <button class="ea-woo-checkout-btn-prev"><?php echo $settings['ea_woo_checkout_tabs_btn_prev_text']; ?></button>
                        <button class="ea-woo-checkout-btn-next" data-text="<?php echo htmlspecialchars(json_encode
						($ea_woo_checkout_btn_next_data), ENT_QUOTES, 'UTF-8'); ?>" ><?php echo $settings['ea_woo_checkout_tabs_btn_next_text']; ?></button>
                        <button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="ea_place_order" value="Place order" data-value="Place order" style="display:none;">Place order</button>
                    </div>
                </div>

                <div class="table-area">
                    <div class="ea-woo-checkout-order-review">
						<?php self::checkout_order_review_default($settings); ?>
                    </div>
                </div>
            </div>
        </div>
	<?php }
}


