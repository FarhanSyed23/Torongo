<?php
namespace Essential_Addons_Elementor\Pro\Elements;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class Post_List extends Widget_Base
{
    use \Essential_Addons_Elementor\Traits\Helper;
    use \Essential_Addons_Elementor\Pro\Traits\Helper;
    use \Essential_Addons_Elementor\Pro\Template\Content\Post_List;

    protected $all_terms = [];

    protected $tax_query = [];

    public function get_name()
    {
        return 'eael-post-list';
    }

    public function get_title()
    {
        return __('Smart Post List', 'essential-addons-elementor');
    }

    public function get_icon()
    {
        return 'eaicon-smart-post-list';
    }

    public function get_categories()
    {
        return ['essential-addons-elementor'];
    }

    public function get_keywords()
    {
        return [
            'smart post list',
            'ea smart post list',
            'ea post list',
            'ea post grid',
            'ea smart post grid',
            'blog post',
            'bloggers',
            'blog',
            'featured post',
            'ea',
            'essential addons',
        ];
    }

    public function get_custom_help_url()
    {
        return 'https://essential-addons.com/elementor/docs/smart-post-list/';
    }

    public function get_style_depends()
    {
        return [
            'font-awesome-5-all',
            'font-awesome-4-shim',
        ];
    }

    public function get_script_depends()
    {
        return [
            'font-awesome-4-shim',
        ];
    }

    protected function _register_controls()
    {
        $this->eael_query_controls();
        $this->post_list_layout_controls();

        /**
         * Post List Controls!
         */
        $this->start_controls_section(
            'eael_section_post_list_featured_post_layout',
            [
                'label' => __('Featured Post Settings', 'essential-addons-elementor'),
                'condition' => [
                    'eael_post_list_featured_area' => 'yes',
                    'eael_post_list_layout_type' => 'default',
                ],
            ]
        );

        $this->add_control(
            'featured_posts',
            [
                'label' => __('Featured Post', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => false,
                'options' => $this->eael_get_all_types_post(),
                'default' => array(),
                'condition' => [
                    'eael_post_list_featured_area' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'featured_page_divider',
            [
                'type' => Controls_Manager::RAW_HTML,
                'label_block' => false,
                'raw' => '<br>',
                'condition' => [
                    'post_type' => 'page',
                ],
            ]
        );
        $this->add_control(
            'featured_page',
            [
                'label' => __('Featured Page', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => $this->eael_get_pages(),
                'condition' => [
                    'post_type' => 'page',
                    'eael_post_list_featured_area' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'eael_post_list_featured_height',
            [
                'label' => esc_html__('Featured Post Min Height', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 450,
                ],
                'range' => [
                    'px' => [
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-featured-wrap' => 'min-height: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_responsive_control(
            'eael_post_list_featured_width',
            [
                'label' => esc_html__('Featured Post Width', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    '%' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-featured-wrap' => 'flex: 0 0 {{SIZE}}%;',
                ],
            ]
        );
        $this->add_responsive_control(
            'eael_post_list_list_width',
            [
                'label' => esc_html__('List Area Width', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 70,
                ],
                'range' => [
                    '%' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-posts-wrap' => 'flex: 0 0 {{SIZE}}%;',
                ],
            ]
        );
        $this->add_control(
            'eael_post_list_featured_meta',
            [
                'label' => __('Show Meta', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'eael_post_list_featured_title',
            [
                'label' => __('Show Title', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'eael_post_list_featured_excerpt',
            [
                'label' => __('Show Excerpt', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'eael_post_list_featured_excerpt_length',
            [
                'label' => __('Excerpt Words', 'essential-addons-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => '8',
                'condition' => [
                    'eael_post_list_featured_excerpt' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_post_list_post_layout',
            [
                'label' => __('List Post Settings', 'essential-addons-elementor'),
            ]
        );
        $this->add_control(
            'eael_post_list_columns',
            [
                'label' => esc_html__('Post List Column(s)', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'col-2',
                'label_block' => false,
                'options' => [
                    'col-1' => esc_html__('1 Column', 'essential-addons-elementor'),
                    'col-2' => esc_html__('2 Columns', 'essential-addons-elementor'),
                    'col-3' => esc_html__('3 Columns', 'essential-addons-elementor'),
                ],
                'prefix_class' => 'eael-post-list-',
            ]
        );
        $this->add_control(
            'eael_post_list_post_feature_image',
            [
                'label' => __('Show Featured Image', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'eael_post_list_post_meta',
            [
                'label' => __('Show Meta', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'eael_post_list_post_title',
            [
                'label' => __('Show Title', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'eael_post_list_title_tag',
            [
                'label' => __('Title Tag', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h2' => __('h1', 'essential-addons-elementor'),
                    'h2' => __('h2', 'essential-addons-elementor'),
                    'h3' => __('h3', 'essential-addons-elementor'),
                    'h4' => __('h4', 'essential-addons-elementor'),
                    'h5' => __('h5', 'essential-addons-elementor'),
                    'h6' => __('h6', 'essential-addons-elementor'),
                    'p' => __('p', 'essential-addons-elementor'),
                    'span' => __('span', 'essential-addons-elementor'),
                    'div' => __('div', 'essential-addons-elementor'),
                ],
                'condition' => [
                    'eael_post_list_post_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'eael_post_list_post_excerpt',
            [
                'label' => __('Show Excerpt', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'eael_post_list_post_excerpt_length',
            [
                'label' => __('Excerpt Words', 'essential-addons-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => '12',
                'condition' => [
                    'eael_post_list_post_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'eael_post_list_excerpt_expanison_indicator',
            [
                'label' => esc_html__('Expanison Indicator', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => esc_html__('...', 'essential-addons-elementor'),
                'condition' => [
                    'eael_post_list_post_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'eael_show_read_more_button',
            [
                'label' => __('Show Read More', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'essential-addons-elementor'),
                'label_off' => __('Hide', 'essential-addons-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'eael_post_list_post_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'eael_post_list_read_more_text',
            [
                'label' => esc_html__('Label Text', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => esc_html__('Read More', 'essential-addons-elementor'),
                'condition' => [
                    'eael_post_list_post_excerpt' => 'yes',
                    'eael_show_read_more_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'eael_post_list_author_meta',
            [
                'label' => __('Show Author Meta', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
                'condition' => [
                    'eael_post_list_layout_type' => 'advanced',
                ],
            ]
        );

        $this->add_control(
            'eael_post_list_post_cat',
            [
                'label' => __('Show Category', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
                'condition' => [
                    'eael_post_list_layout_type' => 'advanced',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_post_list_style',
            [
                'label' => __('Post List Style', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'eael_post_list_container_bg_color',
            [
                'label' => esc_html__('Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'eael_post_list_container_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'eael_post_list_container_margin',
            [
                'label' => esc_html__('Margin', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'eael_post_list_container_border',
                'label' => esc_html__('Border', 'essential-addons-elementor'),
                'selector' => '{{WRAPPER}} .eael-post-list-container',
            ]
        );
        $this->add_control(
            'eael_post_list_container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'eael_post_list_container_shadow',
                'selector' => '{{WRAPPER}} .eael-post-list-container',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_post_list_topbar_style',
            [
                'label' => __('Topbar Style', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'eael_post_list_topbar' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'eael_post_list_topbar_border',
                'label' => esc_html__('Topbar Border', 'essential-addons-elementor'),
                'selector' => '{{WRAPPER}} .eael-post-list-header',
            ]
        );
        $this->add_control(
            'eael_section_post_list_topbar_tag_style',
            [
                'label' => esc_html__('Title Tag', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'eael_section_post_list_topbar_bg_color',
            [
                'label' => __('Title Tag Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#e23a47',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-header .header-title .title' => 'background-color: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            'eael_section_post_list_topbar_color',
            [
                'label' => __('Title Tag Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-header .header-title .title' => 'color: {{VALUE}}',
                ],

            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_section_post_list_topbar_tag_typo',
                'label' => __('Tag Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-post-list-header .header-title .title',
            ]
        );
        $this->add_control(
            'eael_section_post_list_topbar_category_style',
            [
                'label' => esc_html__('Category Filter', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_section_post_list_topbar_category_typo',
                'label' => __('Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-post-list-header .post-categories a',
            ]
        );
        $this->add_control(
            'eael_section_post_list_topbar_category_background_color',
            [
                'label' => __('Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-header .post-categories a' => 'background-color: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            'eael_section_post_list_topbar_category_color',
            [
                'label' => __('Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#5a5a5a',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-header .post-categories a' => 'color: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            'eael_section_post_list_topbar_category_active_background_color',
            [
                'label' => __('Active Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-header .post-categories a.active, {{WRAPPER}} .eael-post-list-header .post-categories a:hover' => 'background-color: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            'eael_section_post_list_topbar_category_active_color',
            [
                'label' => __('Active Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#F56A6A',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-header .post-categories a.active, {{WRAPPER}} .eael-post-list-header .post-categories a:hover' => 'color: {{VALUE}}',
                ],

            ]
        );
        $this->add_responsive_control(
            'eael_section_post_list_topbar_category_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-header .post-categories a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'eael_section_post_list_topbar_category_margin',
            [
                'label' => esc_html__('Margin', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-header .post-categories a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_post_list_navigation_style',
            [
                'label' => __('Navigation Style', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'eael_post_list_pagination' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'eael_section_post_list_nav_icon_color',
            [
                'label' => __('Icon Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#222',
                'selectors' => [
                    '{{WRAPPER}} .post-list-pagination .btn-next-post' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .post-list-pagination .btn-prev-post' => 'color: {{VALUE}}',
                ],

            ]
        );
        $this->add_control(
            'eael_section_post_list_nav_icon_bg_color',
            [
                'label' => __('Icon Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .post-list-pagination .btn-next-post' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .post-list-pagination .btn-prev-post' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'eael_section_post_list_nav_icon_hover_color',
            [
                'label' => __('Icon Hover Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .post-list-pagination .btn-next-post:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .post-list-pagination .btn-prev-post:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'eael_section_post_list_nav_icon_hover_bg_color',
            [
                'label' => __('Icon Background Hover Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#222',
                'selectors' => [
                    '{{WRAPPER}} .post-list-pagination .btn-next-post:hover' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .post-list-pagination .btn-prev-post:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'eael_section_post_list_nav_icon_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-list-pagination .btn-next-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .post-list-pagination .btn-prev-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'eael_section_post_list_nav_icon_margin',
            [
                'label' => esc_html__('Margin', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-list-pagination .btn-next-post' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .post-list-pagination .btn-prev-post' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'eael_section_post_list_nav_icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-list-pagination .btn-next-post' => 'border-radius: {{SIZE}}px;',
                    '{{WRAPPER}} .post-list-pagination .btn-prev-post' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'eael_post_list_featured_typography',
            [
                'label' => __('Featured Post Style', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'eael_post_list_layout_type' => 'default',
                ],
            ]
        );
        $this->add_control(
            'eael_post_list_featured_title_settings',
            [
                'label' => __('Title Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'eael_post_list_featured_title_color',
            [
                'label' => __('Title Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-featured-wrap .featured-content .eael-post-list-title, {{WRAPPER}} .eael-post-list-featured-wrap .featured-content .eael-post-list-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'eael_post_list_featured_title_hover_color',
            [
                'label' => __('Title Hover Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#92939b',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-featured-wrap .featured-content .eael-post-list-title:hover, {{WRAPPER}} .eael-post-list-featured-wrap .featured-content .eael-post-list-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'eael_post_list_featured_title_alignment',
            [
                'label' => __('Title Alignment', 'essential-addons-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-featured-wrap .featured-content .eael-post-list-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_post_list_featured_title_typography',
                'label' => __('Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eael-post-list-featured-wrap .featured-content .eael-post-list-title, {{WRAPPER}} .eael-post-list-featured-wrap .featured-content .eael-post-list-title a',
            ]
        );
        $this->add_control(
            'eael_post_list_featured_excerpt_style',
            [
                'label' => __('Excerpt Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'eael_post_list_featured_excerpt_color',
            [
                'label' => __('Excerpt Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f8f8f8',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-featured-wrap .featured-content p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'eael_post_list_featured_excerpt_alignment',
            [
                'label' => __('Excerpt Alignment', 'essential-addons-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-featured-wrap .featured-content p' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_post_list_featured_excerpt_typography',
                'label' => __('Excerpt Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-post-list-featured-wrap .featured-content p',
            ]
        );
        $this->add_control(
            'eael_post_list_featured_meta_style',
            [
                'label' => __('Meta Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'eael_post_list_featured_meta_color',
            [
                'label' => __('Meta Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-featured-wrap .featured-content .meta' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'eael_post_list_featured_meta_alignment',
            [
                'label' => __('Meta Alignment', 'essential-addons-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-featured-wrap .featured-content .meta' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_post_list_featured_meta_typography',
                'label' => __('Date Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-post-list-featured-wrap .featured-content .meta',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'eael_post_list_typography',
            [
                'label' => __('Post Style', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'eael_post_list_thumbnail_settings',
            [
                'label' => __('Thumbnail Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'eael_post_list_layout_type' => 'advanced',
                ],
            ]
        );

        $this->add_control(
            'thumbnail_margin_bottom',
            [
                'label' => esc_html__('Thumbnail Space', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-thumbnail' => 'margin-bottom: {{SIZE}}px;',
                ],
                'condition' => [
                    'eael_post_list_layout_type' => 'advanced',
                ],
            ]
        );

        $this->add_control(
            'eael_post_list_title_settings',
            [
                'label' => __('Title Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'eael_post_list_title_color',
            [
                'label' => __('Title Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#222',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-content .eael-post-list-title, {{WRAPPER}} .eael-post-list-content .eael-post-list-title a' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_control(
            'eael_post_list_title_hover_color',
            [
                'label' => __('Title Hover Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#e65a50',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-content .eael-post-list-title:hover, {{WRAPPER}} .eael-post-list-content .eael-post-list-title a:hover' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'eael_post_list_title_alignment',
            [
                'label' => __('Title Alignment', 'essential-addons-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-content .eael-post-list-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_post_list_title_typography',
                'label' => __('Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eael-post-list-content .eael-post-list-title, {{WRAPPER}} .eael-post-list-content .eael-post-list-title a',
            ]
        );
        $this->add_control(
            'eael_post_list_excerpt_style',
            [
                'label' => __('Excerpt Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'eael_post_list_excerpt_color',
            [
                'label' => __('Excerpt Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#4d4d4d',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-content p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'eael_post_list_excerpt_alignment',
            [
                'label' => __('Excerpt Alignment', 'essential-addons-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-content p' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_post_list_excerpt_typography',
                'label' => __('Excerpt Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-post-list-content p',
            ]
        );
        $this->add_control(
            'eael_post_list_meta_style',
            [
                'label' => __('Meta Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'eael_post_list_meta_color',
            [
                'label' => __('Meta Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#aaa',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-content .meta' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'eael_post_list_meta_alignment',
            [
                'label' => __('Meta Alignment', 'essential-addons-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-content .meta' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_post_list_meta_typography',
                'label' => __('Meta Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-post-list-content .meta',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'card_style_section',
            [
                'label' => __('Card Style', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'eael_post_list_layout_type' => 'advanced',
                ],
            ]
        );

        $this->start_controls_tabs('post_list_advanced_card_style');

        $this->start_controls_tab(
            'post_list_advanced_card_normal',
            [
                'label' => esc_html__('Normal', 'essential-addons-elementor'),
            ]
        );

        $this->add_responsive_control(
            'card_box_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-post .eael-post-list-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'card_background_normal',
                'label' => __('Background', 'essential-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-post-inner:after',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'card_border_normal',
                'label' => esc_html__('Border', 'essential-addons-elementor'),
                'selector' => '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-post-inner:after',
            ]
        );

        $this->add_responsive_control(
            'card_box_border_radius_normal',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-post-inner:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow_normal',
                'selector' => '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-post-inner:after',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'post_list_advanced_card_hover',
            [
                'label' => esc_html__('Hover', 'essential-addons-elementor'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'card_background_hover',
                'label' => __('Background', 'essential-addons-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-post:hover .eael-post-list-post-inner:after',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'card_border_hover',
                'label' => esc_html__('Border', 'essential-addons-elementor'),
                'selector' => '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-post:hover .eael-post-list-post-inner:after',
            ]
        );

        $this->add_control(
            'card_box_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-post:hover .eael-post-list-post-inner:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow_hover',
                'selector' => '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-post:hover .eael-post-list-post-inner:after',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'author_meta_style_section',
            [
                'label' => __('Author Meta', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'eael_post_list_layout_type' => 'advanced',
                    'eael_post_list_author_meta!' => '',
                ],
            ]
        );

        $this->add_control(
            'author_photo_heading',
            [
                'label' => esc_html__('Author Photo', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'author_image_size',
            [
                'label' => esc_html__('Image Size', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 44,
                ],
                'range' => [
                    '%' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-post .boxed-meta .author-meta .author-photo' => 'flex-basis:{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eael-post-list-post .boxed-meta .author-meta .author-photo' => 'width:{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-posts-wrap .eael-post-list-post .eael-post-list-content .boxed-meta .author-meta .author-photo' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'author_image_margin',
            [
                'label' => esc_html__('Margin', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-post .boxed-meta .author-meta .author-photo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'author_name_heading',
            [
                'label' => esc_html__('Author Name', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_name_typography',
                'label' => __('Title Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-post .eael-post-list-content .boxed-meta .author-info h5',
            ]
        );

        $this->add_control(
            'author_meta_name_color',
            [
                'label' => esc_html__('Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-post .eael-post-list-content .boxed-meta .author-info h5 > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'author_name_margin',
            [
                'label' => esc_html__('Margin', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-post .eael-post-list-content .boxed-meta .author-info h5' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'author_meta_date_heading',
            [
                'label' => esc_html__('Date', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_meta_date_typography',
                'label' => __('Date Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-posts-wrap .eael-post-list-post .eael-post-list-content .boxed-meta .author-meta .author-info > a p',
            ]
        );

        $this->add_control(
            'post_list_author_meta_date_color',
            [
                'label' => esc_html__('Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-posts-wrap .eael-post-list-post .eael-post-list-content .boxed-meta .author-meta .author-info a > p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'category_style_section',
            [
                'label' => __('Category Style', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'eael_post_list_layout_type' => 'advanced',
                    'eael_post_list_post_cat!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'label' => __('Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-content .boxed-meta .meta-categories .meta-cats-wrap a',
            ]
        );

        $this->add_responsive_control(
            'category_margin',
            [
                'label' => esc_html__('Margin', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-content .boxed-meta .meta-categories .meta-cats-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'category_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-content .boxed-meta .meta-categories .meta-cats-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'category_box_shadow',
                'selector' => '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-content .boxed-meta .meta-categories .meta-cats-wrap',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'form_style_section',
            [
                'label' => __('Form Style', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'eael_post_list_layout_type' => 'advanced',
                    'eael_enable_ajax_post_search!' => '',
                ],
            ]
        );
        $this->add_responsive_control(
            'post_list_form_width',
            [
                'label' => esc_html__('Form Width', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 470,
                ],
                'range' => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-header .post-list-ajax-search-form form' => 'width: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'post_list_form_border_color',
                'label' => esc_html__('Border', 'essential-addons-elementor'),
                'selector' => '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-header .post-list-ajax-search-form form input',
            ]
        );
        $this->add_control(
            'post_list_form_button_color',
            [
                'label' => __('Search Icon Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eael-post-list-container.layout-advanced .eael-post-list-header .post-list-ajax-search-form form i.fa-search' => 'color: {{VALUE}}',
                ],

            ]
        );
        $this->end_controls_section();

        /**
         * Read More Button Style Controls
         */
        $this->eael_read_more_button_style();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = $this->fix_old_query($settings);
        $args = $this->eael_get_query_args($settings);
        $data_settings = [
            'eael_post_list_post_feature_image' => $settings['eael_post_list_post_feature_image'],
            'eael_post_list_post_meta' => $settings['eael_post_list_post_meta'],
            'eael_post_list_post_title' => $settings['eael_post_list_post_title'],
            'eael_post_list_post_excerpt' => $settings['eael_post_list_post_excerpt'],
            'eael_post_list_post_excerpt_length' => $settings['eael_post_list_post_excerpt_length'],
            'eael_post_list_featured_area' => $settings['eael_post_list_featured_area'],
            'eael_post_list_featured_meta' => $settings['eael_post_list_featured_meta'],
            'eael_post_list_featured_title' => $settings['eael_post_list_featured_title'],
            'eael_post_list_featured_excerpt' => $settings['eael_post_list_featured_excerpt'],
            'eael_post_list_featured_excerpt_length' => $settings['eael_post_list_featured_excerpt_length'],
            'featured_posts' => $settings['featured_posts'],
            'eael_post_list_pagination' => $settings['eael_post_list_pagination'],
            'eael_post_list_layout_type' => $settings['eael_post_list_layout_type'],
            'eael_post_list_post_cat' => $settings['eael_post_list_post_cat'],
            'eael_post_list_author_meta' => $settings['eael_post_list_author_meta'],
            'eael_post_list_title_tag' => $settings['eael_post_list_title_tag'],
            'eael_show_read_more_button' => $settings['eael_show_read_more_button'],
            'eael_post_list_read_more_text' => $settings['eael_post_list_read_more_text'],
        ];

        $this->add_render_attribute(
            'post-list-wrapper-attribute',
            [
                'class' => ['eael-post-list-container'],
            ]
        );

        if ($settings['eael_post_list_layout_type']) {
            $this->add_render_attribute('post-list-wrapper-attribute', 'class', "layout-{$settings['eael_post_list_layout_type']}");
        }

        echo '<div ' . $this->get_render_attribute_string('post-list-wrapper-attribute') . '>';
        if ($settings['eael_post_list_topbar'] === 'yes') {
            echo '<div class="eael-post-list-header">';
            if (!empty($settings['eael_post_list_topbar_title'])) {
                echo '<div class="header-title">
                            <h2 class="title">' . esc_html__($settings['eael_post_list_topbar_title'], 'essential-addons-elementor') . '</h2>
                        </div>';
            }

            if ($settings['eael_post_list_terms'] === 'yes') {
                echo '<div class="post-categories" data-widget="' . $this->get_id() . '" data-class="' . get_class($this) . '" data-args="' . http_build_query($args) . '" data-settings="' . http_build_query($data_settings) . '" data-page="1">
                            <a href="javascript:;" data-taxonomy="all" data-id="" class="active post-list-filter-item post-list-cat-' . $this->get_id() . '">' . __($settings['eael_post_list_topbar_term_all_text'], 'essential-addons-elementor') . '</a>';

                if (!empty($args['tax_query'])) {
                    foreach ($args['tax_query'] as $taxonomy) {
                        if (!empty($taxonomy['terms'])) {
                            foreach ($taxonomy['terms'] as $term_id) {
                                $term = get_term($term_id, $taxonomy['taxonomy']);
                                if (is_object($term)) {
                                    echo '<a href="javascript:;" data-taxonomy="' . $taxonomy['taxonomy'] . '" data-id="' . $term_id . '" class="post-list-filter-item post-list-cat-' . $this->get_id() . '">' . $term->name . '</a>';
                                }
                            }
                        }
                    }
                }
                echo '</div>';
            }

            if ($settings['eael_post_list_layout_type'] == 'advanced' && $settings['eael_enable_ajax_post_search'] == 'yes') {
                $postType = $settings['post_type'] == 'by_id' ? 'any' : $settings['post_type'];

                echo '<div class="post-list-ajax-search-form">
                            <form action="" id="post-list-search-form-' . $this->get_id() . '" autocomplete="off">
                                <input type="hidden" name="post_type" value="' . ($postType) . '">
                                <input type="text" value="" placeholder="' . __('Search', 'essential-addons-elementor') . '" name="search_key" id="search_field">
                                ' . wp_nonce_field('eael_ajax_post_search_nonce_action', 'eael_ajax_post_search_nonce') . '
                                <i class="fa fa-search"></i>
                            </form>
                            <div class="result-posts-wrapper"></div>
                        </div>';
            }
            echo '</div>';
        }

        echo '<div class="eael-post-list-wrap eael-post-appender eael-post-appender-' . $this->get_id() . '">
                ' . self::render_template_($args, $settings) . '
            </div>
		</div>';

        if ($settings['eael_post_list_pagination'] === 'yes') {
            $eael_post_list_pagination_prev_icon = (isset($settings['__fa4_migrated']['eael_post_list_pagination_prev_icon_new']) || empty($settings['eael_post_list_pagination_prev_icon']) ? $settings['eael_post_list_pagination_prev_icon_new']['value'] : $settings['eael_post_list_pagination_prev_icon']);
            $eael_post_list_pagination_next_icon = (isset($settings['__fa4_migrated']['eael_post_list_pagination_next_icon_new']) || empty($settings['eael_post_list_pagination_next_icon']) ? $settings['eael_post_list_pagination_next_icon_new']['value'] : $settings['eael_post_list_pagination_next_icon']);

            echo '<div class="post-list-pagination" data-widget="' . $this->get_id() . '" data-class="' . get_class($this) . '" data-args="' . http_build_query($args) . '" data-settings="' . http_build_query($data_settings) . '" data-page="1">
                <button class="btn btn-prev-post" id="post-nav-prev-' . $this->get_id() . '" disabled="true">
                    <span class="' . $eael_post_list_pagination_prev_icon . '"></span>
                </button>
                <button class="btn btn-next-post" id="post-nav-next-' . $this->get_id() . '">
                    <span class="' . $eael_post_list_pagination_next_icon . '"></span>
                </button>
			</div>';
        }
    }
}
