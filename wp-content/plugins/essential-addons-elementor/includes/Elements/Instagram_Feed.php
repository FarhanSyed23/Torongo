<?php
namespace Essential_Addons_Elementor\Pro\Elements;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit;
} // If this file is called directly, abort.

class Instagram_Feed extends Widget_Base
{
    use \Essential_Addons_Elementor\Pro\Traits\Helper;

    public function get_name()
    {
        return 'eael-instafeed';
    }

    public function get_title()
    {
        return esc_html__('Instagram Feed', 'essential-addons-elementor');
    }

    public function get_icon()
    {
        return 'eaicon-instagram-feed';
    }

    public function get_categories()
    {
        return ['essential-addons-elementor'];
    }

    public function get_keywords()
    {
        return [
            'instagram',
            'instagram feed',
            'ea instagram feed',
            'instagram gallery',
            'ea instagram gallery',
            'social media',
            'social feed',
            'ea social feed',
            'instagram embed',
            'ea',
            'essential addons'
        ];
    }

    public function get_custom_help_url()
    {
		return 'https://essential-addons.com/elementor/docs/instagram-feed/';
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
            'font-awesome-4-shim'
        ];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'eael_section_instafeed_settings_account',
            [
                'label' => esc_html__('Instagram Account Settings', 'essential-addons-elementor'),
            ]
        );

        $this->add_control(
            'eael_instafeed_access_token',
            [
                'label' => esc_html__('Access Token', 'essential-addons-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('4507625822.ba4c844.2608ae40c33d40fe97bffdc9bed8c9c7', 'essential-addons-elementor'),
                'description' => '<a href="http://www.jetseotools.com/instagram-access-token/" class="eael-btn" target="_blank">Get Access Token</a>', 'essential-addons-elementor',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_instafeed_settings_content',
            [
                'label' => esc_html__('Feed Settings', 'essential-addons-elementor'),
            ]
        );

        $this->add_control(
            'eael_instafeed_sort_by',
            [
                'label' => esc_html__('Sort By', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'essential-addons-elementor'),
                    'most-recent' => esc_html__('Most Recent', 'essential-addons-elementor'),
                    'least-recent' => esc_html__('Least Recent', 'essential-addons-elementor'),
                    'most-liked' => esc_html__('Most Likes', 'essential-addons-elementor'),
                    'least-liked' => esc_html__('Least Likes', 'essential-addons-elementor'),
                    'most-commented' => esc_html__('Most Commented', 'essential-addons-elementor'),
                    'least-commented' => esc_html__('Least Commented', 'essential-addons-elementor'),
                ],
            ]
        );

        $this->add_control(
            'eael_instafeed_image_count',
            [
                'label' => esc_html__('Max Visible Images', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 12,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ]
        );

        $this->add_control(
            'eael_instafeed_image_resolution',
            [
                'label' => esc_html__('Image Resolution', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'low_resolution',
                'options' => [
                    'thumbnail' => esc_html__('Thumbnail (150x150)', 'essential-addons-elementor'),
                    'low_resolution' => esc_html__('Low Res (306x306)', 'essential-addons-elementor'),
                    'standard_resolution' => esc_html__('Standard (612x612)', 'essential-addons-elementor'),
                ],
            ]
        );

        $this->add_control(
            'eael_instafeed_force_square',
            [
                'label' => esc_html__('Force Square Image?', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'eael_instafeed_sq_image_size',
            [
                'label' => esc_html__('Image Dimension (px)', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 300,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-instafeed-square-img .eael-instafeed-item img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; object-fit: cover;',
                ],
                'condition' => [
                    'eael_instafeed_force_square' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_instafeed_settings_general',
            [
                'label' => esc_html__('General Settings', 'essential-addons-elementor'),
            ]
        );

        $this->add_control(
            'eael_instafeed_layout',
            [
                'label' => esc_html__('Layout', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'overlay',
                'options' => [
                    'card' => esc_html__('Card', 'essential-addons-elementor'),
                    'overlay' => esc_html__('Overlay', 'essential-addons-elementor'),
                ],
            ]
        );

        $this->add_control(
            'eael_instafeed_card_style',
            [
                'label' => esc_html__('Card Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'outer',
                'options' => [
                    'inner' => esc_html__('Content Inner', 'essential-addons-elementor'),
                    'outer' => esc_html__('Content Outer', 'essential-addons-elementor'),
                ],
                'condition' => [
                    'eael_instafeed_layout' => 'card',
                ],
            ]
        );
        
        $this->add_control(
            'eael_instafeed_overlay_style',
            [
                'label' => esc_html__('Overlay Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'simple',
                'options' => [
                    'simple' => esc_html__('Simple', 'essential-addons-elementor'),
                    'basic' => esc_html__('Basic', 'essential-addons-elementor'),
                    'standard' => esc_html__('Standard', 'essential-addons-elementor'),
                ],
                'condition' => [
                    'eael_instafeed_layout' => 'overlay',
                ],
            ]
        );

        $this->add_responsive_control(
            'eael_instafeed_columns',
            [
                'label' => esc_html__('Number of Columns', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'eael-col-4',
                'options' => [
                    'eael-col-1' => esc_html__('1 Column', 'essential-addons-elementor'),
                    'eael-col-2' => esc_html__('2 Columns', 'essential-addons-elementor'),
                    'eael-col-3' => esc_html__('3 Columns', 'essential-addons-elementor'),
                    'eael-col-4' => esc_html__('4 Columns', 'essential-addons-elementor'),
                    'eael-col-5' => esc_html__('5 Columns', 'essential-addons-elementor'),
                    'eael-col-6' => esc_html__('6 Columns', 'essential-addons-elementor'),
                ],
                'prefix_class' => 'instafeed-gallery%s-',
            ]
        );

        $this->add_control(
            'eael_instafeed_pagination_heading',
            [
                'label' => __('Pagination', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'eael_instafeed_pagination',
            [
                'label' => esc_html__('Enable Load More?', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
			'loadmore_text',
			[
				'label'     => __( 'Label', 'essential-addons-elementor' ),
				'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Load More', 'essential-addons-elementor' ),
                'condition' => [
                    'eael_instafeed_pagination' => 'yes'
                ]
			]
		);

        $this->add_control(
            'eael_instafeed_caption_heading',
            [
                'label' => __('Link & Content', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'eael_instafeed_caption',
            [
                'label' => esc_html__('Display Caption', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'eael_instafeed_likes',
            [
                'label' => esc_html__('Display Like', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'eael_instafeed_comments',
            [
                'label' => esc_html__('Display Comments', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        
        $this->add_control(
            'eael_instafeed_date',
            [
                'label' => esc_html__('Display Date', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'eael_instafeed_link',
            [
                'label' => esc_html__('Enable Link', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'eael_instafeed_link_target',
            [
                'label' => esc_html__('Open in new window?', 'essential-addons-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'eael_instafeed_link' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_instafeed_styles_general',
            [
                'label' => esc_html__('Instagram Feed Styles', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'eael_instafeed_spacing',
            [
                'label' => esc_html__('Padding Between Images', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eael-instafeed-item-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'eael_instafeed_box_border',
                'label' => esc_html__('Border', 'essential-addons-elementor'),
                'selector' => '{{WRAPPER}} .eael-instafeed-item-inner',
            ]
        );

        $this->add_control(
            'eael_instafeed_box_border_radius',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .eael-instafeed-item-inner' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_instafeed_styles_content',
            [
                'label' => esc_html__('Color &amp; Typography', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'eael_instafeed_overlay_color',
            [
                'label' => esc_html__('Overlay Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(137,12,255,0.75)',
                'selectors' => [
                    '{{WRAPPER}} .eael-instafeed-caption' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_instafeed_like_comments_heading',
            [
                'label' => __('Icon Styles', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'eael_instafeed_icon_color',
            [
                'label' => esc_html__('Icon Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-instafeed-caption i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_instafeed_caption_style_heading',
            [
                'label' => __('Caption Styles', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'eael_instafeed_caption_color',
            [
                'label' => esc_html__('Caption Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-instafeed-caption' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_instafeed_caption_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .eael-instafeed-caption',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_load_more_btn',
            [
                'label' => __('Load More Button Style', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'eael_instafeed_load_more_btn_padding',
            [
                'label' => esc_html__('Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-load-more-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'eael_instafeed_load_more_btn_margin',
            [
                'label' => esc_html__('Margin', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .eael-load-more-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_instafeed_load_more_btn_typography',
                'selector' => '{{WRAPPER}} .eael-load-more-button',
            ]
        );

        $this->start_controls_tabs('eael_instafeed_load_more_btn_tabs');

        // Normal State Tab
        $this->start_controls_tab('eael_instafeed_load_more_btn_normal', ['label' => esc_html__('Normal', 'essential-addons-elementor')]);

        $this->add_control(
            'eael_instafeed_load_more_btn_normal_text_color',
            [
                'label' => esc_html__('Text Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eael-load-more-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_cta_btn_normal_bg_color',
            [
                'label' => esc_html__('Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#29d8d8',
                'selectors' => [
                    '{{WRAPPER}} .eael-load-more-button' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'eael_instafeed_load_more_btn_normal_border',
                'label' => esc_html__('Border', 'essential-addons-elementor'),
                'selector' => '{{WRAPPER}} .eael-load-more-button',
            ]
        );

        $this->add_control(
            'eael_instafeed_load_more_btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-load-more-button' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'eael_instafeed_load_more_btn_shadow',
                'selector' => '{{WRAPPER}} .eael-load-more-button',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab('eael_instafeed_load_more_btn_hover', ['label' => esc_html__('Hover', 'essential-addons-elementor')]);

        $this->add_control(
            'eael_instafeed_load_more_btn_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eael-load-more-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_instafeed_load_more_btn_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#27bdbd',
                'selectors' => [
                    '{{WRAPPER}} .eael-load-more-button:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_instafeed_load_more_btn_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-load-more-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]

        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'eael_instafeed_load_more_btn_hover_shadow',
                'selector' => '{{WRAPPER}} .eael-load-more-button:hover',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        // print_r($settings);
        $classes = implode(' ', [
            ($settings['eael_instafeed_force_square'] == 'yes') ? "eael-instafeed-square-img" : "",
            'eael-instafeed-' . $settings['eael_instafeed_layout'],
            'eael-instafeed-' . $settings['eael_instafeed_layout'] . '-' . $settings["eael_instafeed_{$settings['eael_instafeed_layout']}_style"]
        ]);
        $settings_var = [
            'eael_instafeed_access_token' => $settings['eael_instafeed_access_token'],
            'eael_instafeed_image_count' => $settings['eael_instafeed_image_count'],
            'eael_instafeed_sort_by' => $settings['eael_instafeed_sort_by'],
            'eael_instafeed_image_resolution' => $settings['eael_instafeed_image_resolution'],
            'eael_instafeed_layout' => $settings['eael_instafeed_layout'],
            'eael_instafeed_card_style' => $settings['eael_instafeed_card_style'],
            'eael_instafeed_overlay_style' => $settings['eael_instafeed_overlay_style'],
            'eael_instafeed_date' => $settings['eael_instafeed_date'],
            'eael_instafeed_likes' => $settings['eael_instafeed_likes'],
            'eael_instafeed_comments' => $settings['eael_instafeed_comments'],
            'eael_instafeed_caption' => $settings['eael_instafeed_caption'],
            'eael_instafeed_link' => $settings['eael_instafeed_link'],
            'eael_instafeed_link_target' => $settings['eael_instafeed_link_target']
        ];

        echo '<div id="eael-instafeed-' . esc_attr($this->get_id()) . '" class="eael-instafeed ' . $classes . '">
            ' . $this->instafeed_render_items() . '
        </div>
        <div class="clearfix"></div>';

        if (($settings['eael_instafeed_pagination'] == 'yes')) {
            echo '<div class="eael-load-more-button-wrap">
                <button class="eael-load-more-button" id="eael-load-more-btn-' . $this->get_id() . '" data-settings="' . http_build_query($settings_var) . '" data-page="1" data-loadmore-text="'.$settings['loadmore_text'].'">
                    <div class="eael-btn-loader button__loader"></div>
                    <span>'.$settings['loadmore_text'].'</span>
                </button>
            </div>';
        }

        if (\Elementor\Plugin::instance()->editor->is_edit_mode()) {
            echo '<script type="text/javascript">
                jQuery(document).ready(function($) {
                    $(".eael-instafeed").each(function() {
                        var $node_id = "' . $this->get_id() . '",
                        $gallery = $(this),
                        $scope = $(".elementor-element-"+$node_id+""),
                        $settings = {
                            itemSelector: ".eael-instafeed-item",
                            percentPosition: true,
                            masonry: {
                                columnWidth: ".eael-instafeed-item",
                            }
                        };
                        
                        // init isotope
                        $instagram_gallery = $(".eael-instafeed", $scope).isotope($settings);
                    
                        // layout gal, while images are loading
                        $instagram_gallery.imagesLoaded().progress(function() {
                            $instagram_gallery.isotope("layout");
                        });

                        $(".eael-instafeed-item", $gallery).resize(function() {
                            $instagram_gallery.isotope("layout");
                        });
                    });
                });
            </script>';
        }
    }
}
