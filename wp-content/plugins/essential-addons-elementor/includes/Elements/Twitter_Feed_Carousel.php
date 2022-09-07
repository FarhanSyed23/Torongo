<?php
namespace Essential_Addons_Elementor\Pro\Elements;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit;
}
// If this file is called directly, abort.

class Twitter_Feed_Carousel extends Widget_Base
{
	use \Essential_Addons_Elementor\Traits\Helper;

    public function get_name()
    {
        return 'eael-twitter-feed-carousel';
    }

    public function get_title()
    {
        return esc_html__('Twitter Feed Carousel', 'essential-addons-elementor');
    }

    public function get_icon()
    {
        return 'eaicon-twitter-feed-carousel';
    }

    public function get_categories()
    {
        return ['essential-addons-elementor'];
    }

    public function get_keywords()
    {
        return [
            'twitter feed',
            'ea twitter feed carousel',
            'social media',
            'carousel',
            'twitter marketing',
            'twitter embed',
            'twitter feed slider',
            'ea',
            'essential addons'
        ];
    }

    public function get_custom_help_url()
    {
		return 'https://essential-addons.com/elementor/docs/twitter-feed-carousel/';
	}

    protected function _register_controls()
    {
        $this->start_controls_section(
            'eael_section_twitter_feed_carousel_acc_settings',
            [
                'label' => esc_html__('Account Settings', 'essential-addons-elementor'),
            ]
        );

        $this->add_control(
            'eael_twitter_feed_ac_name',
            [
                'label' => esc_html__('Account Name', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => '@wpdevteam',
                'label_block' => false,
                'description' => esc_html__('Use @ sign with your account name.', 'essential-addons-elementor'),

            ]
        );

        $this->add_control(
            'eael_twitter_feed_hashtag_name',
            [
                'label' => esc_html__('Hashtag Name', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'description' => esc_html__('Remove # sign from your hashtag name.', 'essential-addons-elementor'),

            ]
        );

        $this->add_control(
            'eael_twitter_feed_consumer_key',
            [
                'label' => esc_html__('Consumer Key', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => 'wwC72W809xRKd9ySwUzXzjkmS',
                'description' => '<a href="https://apps.twitter.com/app/" target="_blank">Get Consumer Key.</a> Create a new app or select existing app and grab the <b>consumer key.</b>',
            ]
        );

        $this->add_control(
            'eael_twitter_feed_consumer_secret',
            [
                'label' => esc_html__('Consumer Secret', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => 'rn54hBqxjve2CWOtZqwJigT3F5OEvrriK2XAcqoQVohzr2UA8h',
                'description' => '<a href="https://apps.twitter.com/app/" target="_blank">Get Consumer Secret.</a> Create a new app or select existing app and grab the <b>consumer secret.</b>',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_twitter_feed_carousel_layout_settings',
            [
                'label' => esc_html__('Layout Settings', 'essential-addons-elementor'),
            ]
        );

        $this->add_control(
            'eael_twitter_feed_content_length',
            [
                'label' => esc_html__('Content Length', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => false,
                'default' => '400',
            ]
        );

        $this->add_control(
            'eael_twitter_feed_post_limit',
            [
                'label' => esc_html__('Post Limit', 'essential-addons-elementor'),
                'type' => Controls_Manager::NUMBER,
                'label_block' => false,
                'default' => 10,
            ]
        );

        $this->add_control(
            'eael_twitter_feed_media',
            [
                'label' => esc_html__('Show Media Elements', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'essential-addons-elementor'),
                'label_off' => __('no', 'essential-addons-elementor'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_twitter_feed_carousel_card_settings',
            [
                'label' => esc_html__('Card Settings', 'essential-addons-elementor'),
            ]
        );

        $this->add_control(
            'eael_twitter_feed_show_avatar',
            [
                'label' => esc_html__('Show Avatar', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'essential-addons-elementor'),
                'label_off' => __('no', 'essential-addons-elementor'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->add_control(
            'eael_twitter_feed_avatar_style',
            [
                'label' => __('Avatar Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'circle' => 'Circle',
                    'square' => 'Square',
                ],
                'default' => 'circle',
                'prefix_class' => 'eael-social-feed-avatar-',
                'condition' => [
                    'eael_twitter_feed_show_avatar' => 'true',
                ],
            ]
        );

        $this->add_control(
            'eael_twitter_feed_show_date',
            [
                'label' => esc_html__('Show Date', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'essential-addons-elementor'),
                'label_off' => __('no', 'essential-addons-elementor'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->add_control(
            'eael_twitter_feed_show_read_more',
            [
                'label' => esc_html__('Show Read More', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'essential-addons-elementor'),
                'label_off' => __('no', 'essential-addons-elementor'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->add_control(
            'eael_twitter_feed_show_icon',
            [
                'label' => esc_html__('Show Icon', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'essential-addons-elementor'),
                'label_off' => __('no', 'essential-addons-elementor'),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_twitter_feed_carousel_settings',
            [
                'label' => __('Carousel Settings', 'essential-addons-elementor'),
            ]
        );

        $this->add_control(
            'carousel_effect',
            [
                'label' => __('Effect', 'essential-addons-elementor'),
                'description' => __('Sets transition effect', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => __('Slide', 'essential-addons-elementor'),
                    'fade' => __('Fade', 'essential-addons-elementor'),
                    'cube' => __('Cube', 'essential-addons-elementor'),
                    'coverflow' => __('Coverflow', 'essential-addons-elementor'),
                    'flip' => __('Flip', 'essential-addons-elementor'),
                ],
            ]
        );

        $this->add_responsive_control(
            'items',
            [
                'label' => __('Visible Items', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 3],
                'tablet_default' => ['size' => 2],
                'mobile_default' => ['size' => 1],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'condition' => [
                    'carousel_effect' => ['slide', 'coverflow']
                ]
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label' => __('Items Gap', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 10],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'condition' => [
                    'carousel_effect' => ['slide', 'coverflow']
                ]
            ]
        );

        $this->add_control(
            'slider_speed',
            [
                'label' => __('Slider Speed', 'essential-addons-elementor'),
                'description' => __('Duration of transition between slides (in ms)', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 400],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 3000,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Autoplay Speed', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 2000],
                'range' => [
                    'px' => [
                        'min' => 500,
                        'max' => 5000,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => __('Pause On Hover', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'navigation_heading',
            [
                'label' => __('Navigation', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'arrows',
            [
                'label' => __('Arrows', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'dots',
            [
                'label' => __('Dots', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'essential-addons-elementor'),
                'label_off' => __('No', 'essential-addons-elementor'),
                'return_value' => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style (Twitter Feed Card Style)
         * -------------------------------------------
         */
        $this->start_controls_section(
            'eael_section_twitter_feed_carousel_card_style_settings',
            [
                'label' => esc_html__('Card Style', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'eael_twitter_feed_card_bg_color',
            [
                'label' => esc_html__('Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-twitter-feed-item-inner' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'eael_twitter_feed_card_container_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-twitter-feed-item-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .eael-twitter-feed-item-content' => 'padding: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'eael_twitter_feed_card_border',
                'label' => esc_html__('Border', 'essential-addons-elementor'),
                'selector' => '{{WRAPPER}} .eael-twitter-feed-item-inner',
            ]
        );

        $this->add_control(
            'eael_twitter_feed_card_border_radius',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-twitter-feed-item-inner' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'eael_twitter_feed_card_shadow',
                'selector' => '{{WRAPPER}} .eael-twitter-feed-item-inner',
            ]
        );

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style (Twitter Feed Typography Style)
         * -------------------------------------------
         */
        $this->start_controls_section(
            'eael_section_twitter_feed_carousel_card_typo_settings',
            [
                'label' => esc_html__('Color &amp; Typography', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'eael_twitter_feed_title_heading',
            [
                'label' => esc_html__('Title Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'eael_twitter_feed_title_color',
            [
                'label' => esc_html__('Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-twitter-feed-item .eael-twitter-feed-item-author' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_twitter_feed_title_typography',
                'selector' => '{{WRAPPER}} .eael-twitter-feed-item .eael-twitter-feed-item-author',
            ]
        );
        // Content Style
        $this->add_control(
            'eael_twitter_feed_content_heading',
            [
                'label' => esc_html__('Content Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'eael_twitter_feed_content_color',
            [
                'label' => esc_html__('Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-twitter-feed-item .eael-twitter-feed-item-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_twitter_feed_content_typography',
                'selector' => '{{WRAPPER}} .eael-twitter-feed-item .eael-twitter-feed-item-content p',
            ]
        );

        // Content Link Style
        $this->add_control(
            'eael_twitter_feed_content_link_heading',
            [
                'label' => esc_html__('Link Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'eael_twitter_feed_content_link_color',
            [
                'label' => esc_html__('Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-twitter-feed-item .eael-twitter-feed-item-content a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_twitter_feed_content_link_hover_color',
            [
                'label' => esc_html__('Hover Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-twitter-feed-item .eael-twitter-feed-item-content a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_twitter_feed_content_link_typography',
                'selector' => '{{WRAPPER}} .eael-twitter-feed-item .eael-twitter-feed-item-content a',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Arrows
         */
        $this->start_controls_section(
            'section_arrows_style',
            [
                'label' => __('Arrows', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'arrows' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrow',
            [
                'label' => __('Choose Arrow', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'default' => 'fa fa-angle-right',
                'options' => [
                    'fa fa-angle-right' => __('Angle', 'essential-addons-elementor'),
                    'fa fa-angle-double-right' => __('Double Angle', 'essential-addons-elementor'),
                    'fa fa-chevron-right' => __('Chevron', 'essential-addons-elementor'),
                    'fa fa-chevron-circle-right' => __('Chevron Circle', 'essential-addons-elementor'),
                    'fa fa-arrow-right' => __('Arrow', 'essential-addons-elementor'),
                    'fa fa-long-arrow-right' => __('Long Arrow', 'essential-addons-elementor'),
                    'fa fa-caret-right' => __('Caret', 'essential-addons-elementor'),
                    'fa fa-caret-square-o-right' => __('Caret Square', 'essential-addons-elementor'),
                    'fa fa-arrow-circle-right' => __('Arrow Circle', 'essential-addons-elementor'),
                    'fa fa-arrow-circle-o-right' => __('Arrow Circle O', 'essential-addons-elementor'),
                    'fa fa-toggle-right' => __('Toggle', 'essential-addons-elementor'),
                    'fa fa-hand-o-right' => __('Hand', 'essential-addons-elementor'),
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_size',
            [
                'label' => __('Arrows Size', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => '22'],
                'range' => [
                    'px' => [
                        'min' => 15,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-button-next, {{WRAPPER}} .swiper-container .swiper-button-prev' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'left_arrow_position',
            [
                'label' => __('Align Left Arrow', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 40,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'right_arrow_position',
            [
                'label' => __('Align Right Arrow', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 40,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_arrows_style');

        $this->start_controls_tab(
            'tab_arrows_normal',
            [
                'label' => __('Normal', 'essential-addons-elementor'),
            ]
        );

        $this->add_control(
            'arrows_bg_color_normal',
            [
                'label' => __('Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-button-next, {{WRAPPER}} .swiper-container .swiper-button-prev' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_normal',
            [
                'label' => __('Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-button-next, {{WRAPPER}} .swiper-container .swiper-button-prev' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'arrows_border_normal',
                'label' => __('Border', 'essential-addons-elementor'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .swiper-container .swiper-button-next, {{WRAPPER}} .swiper-container .swiper-button-prev',
            ]
        );

        $this->add_control(
            'arrows_border_radius_normal',
            [
                'label' => __('Border Radius', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-button-next, {{WRAPPER}} .swiper-container .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_arrows_hover',
            [
                'label' => __('Hover', 'essential-addons-elementor'),
            ]
        );

        $this->add_control(
            'arrows_bg_color_hover',
            [
                'label' => __('Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-button-next:hover, {{WRAPPER}} .swiper-container .swiper-button-prev:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_hover',
            [
                'label' => __('Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-button-next:hover, {{WRAPPER}} .swiper-container .swiper-button-prev:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_border_color_hover',
            [
                'label' => __('Border Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-button-next:hover, {{WRAPPER}} .swiper-container .swiper-button-prev:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'arrows_padding',
            [
                'label' => __('Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-button-next, {{WRAPPER}} .swiper-container .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Dots
         */
        $this->start_controls_section(
            'section_dots_style',
            [
                'label' => __('Dots', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'dots' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label' => __('Position', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'absolute' => __('Inside', 'essential-addons-elementor'),
                    'initial' => __('Outside', 'essential-addons-elementor'),
                ],
				'default' => 'initial',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination' => 'position: {{VALUE}}'
				]
            ]
        );

        $this->add_responsive_control(
            'dots_size',
            [
                'label' => __('Size', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 40,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_spacing',
            [
                'label' => __('Spacing', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'size_units' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_dots_style');

        $this->start_controls_tab(
            'tab_dots_normal',
            [
                'label' => __('Normal', 'essential-addons-elementor'),
            ]
        );

        $this->add_control(
            'dots_color_normal',
            [
                'label' => __('Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-pagination-bullet' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_dot_color_normal',
            [
                'label' => __('Active Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dots_border_normal',
                'label' => __('Border', 'essential-addons-elementor'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .swiper-container .swiper-pagination-bullet',
            ]
        );

        $this->add_control(
            'dots_border_radius_normal',
            [
                'label' => __('Border Radius', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_padding',
            [
                'label' => __('Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'allowed_dimensions' => 'vertical',
                'placeholder' => [
                    'top' => '',
                    'right' => 'auto',
                    'bottom' => '',
                    'left' => 'auto',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-pagination-bullets' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dots_hover',
            [
                'label' => __('Hover', 'essential-addons-elementor'),
            ]
        );

        $this->add_control(
            'dots_color_hover',
            [
                'label' => __('Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_border_color_hover',
            [
                'label' => __('Border Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-container .swiper-pagination-bullet:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render()
    {
		$settings = $this->get_settings();
		
		$this->add_render_attribute('eael-twitter-feed-carousel-wrap', [
			'data-items' => $settings['items']['size'],
			'data-items-tablet' => $settings['items_tablet']['size'],
			'data-items-mobile' => $settings['items_mobile']['size'],
			'data-margin' => $settings['margin']['size'],
			'data-margin-tablet' => $settings['margin_tablet']['size'],
			'data-margin-mobile' => $settings['margin_mobile']['size'],
			'data-effect' => $settings['carousel_effect'],
			'data-speed' => $settings['slider_speed']['size'],
			'data-autoplay' => ($settings['autoplay'] == 'yes' && !empty($settings['autoplay_speed']['size'])) ? $settings['autoplay_speed']['size'] : '0',
			'data-pause-on-hover' => ($settings['pause_on_hover'] == 'yes' ? 'true' : 'false'),
			'data-dots' => '1',
		]);

		echo '<div class="eael-twitter-feed eael-twitter-feed-carousel swiper-container eael-twitter-feed-' . $this->get_id() . '" ' . $this->get_render_attribute_string('eael-twitter-feed-carousel-wrap') . '>
			<div class="swiper-wrapper">
				' . $this->twitter_feed_render_items($this->get_id(), $settings, 'swiper-slide') . '
			</div>';
			
			if($settings['dots'] == 'yes') {
				echo '<div class="swiper-pagination swiper-pagination-' . esc_attr($this->get_id()) . '"></div>';
			}

			if($settings['arrows'] == 'yes') {
				if ($settings['arrow']) {
					$pa_next_arrow = $settings['arrow'];
					$pa_prev_arrow = str_replace("right", "left", $settings['arrow']);
				} else {
					$pa_next_arrow = 'fa fa-angle-right';
					$pa_prev_arrow = 'fa fa-angle-left';
				}

				echo '<div class="swiper-button-next swiper-button-next-' . esc_attr($this->get_id()) . '">
					<i class="' . esc_attr($pa_next_arrow) . '"></i>
				</div>
				<div class="swiper-button-prev swiper-button-prev-' . esc_attr($this->get_id()) . '">
					<i class="' . esc_attr($pa_prev_arrow) . '"></i>
				</div>';
			}
		echo '</div>';
    }
}