<?php
namespace Essential_Addons_Elementor\Pro\Elements;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Widget_Base;

class Post_Block extends Widget_Base
{
    use \Essential_Addons_Elementor\Traits\Helper;
    use \Essential_Addons_Elementor\Pro\Template\Content\Post_Block;

    public function get_name()
    {
        return 'eael-post-block';
    }

    public function get_title()
    {
        return __('Post Block', 'essential-addons-elementor');
    }

    public function get_icon()
    {
        return 'eaicon-post-block';
    }

    public function get_categories()
    {
        return ['essential-addons-elementor'];
    }

    public function get_keywords()
    {
        return [
            'post block',
            'ea postblock',
            'ea post block',
            'post layout',
            'flex layout',
            'post grid',
            'post showcase',
            'portfolio',
            'gallery',
            'ea',
            'essential addons'
        ];
    }

    public function get_custom_help_url()
    {
		return 'https://essential-addons.com/elementor/docs/post-block/';
	}

    protected function _register_controls()
    {

        /**
         * Query And Layout Controls!
         * @source includes/elementor-helper.php
         */
        $this->eael_query_controls();
        $this->eael_layout_controls();

        $this->start_controls_section(
            'eael_section_post_block_hover_card',
            [
                'label' => __('Hover Card Style', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'eael_post_block_hover_animation',
            [
                'label' => esc_html__('Animation', 'essential-addons-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'fade-in',
                'options' => [
                    'none' => esc_html__('None', 'essential-addons-elementor'),
                    'fade-in' => esc_html__('FadeIn', 'essential-addons-elementor'),
                    'zoom-in' => esc_html__('ZoomIn', 'essential-addons-elementor'),
                    'slide-up' => esc_html__('SlideUp', 'essential-addons-elementor'),
                ],
            ]
        );

        $this->add_control(
            'eael_post_block_bg_hover_icon_new',
            [
                'label' => __('Post Hover Icon', 'essential-addons-elementor'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'eael_post_block_bg_hover_icon',
                'default' => [
                    'value' => 'fas fa-long-arrow-alt-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'eael_post_block_hover_animation!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'eael_post_block_hover_bg_color',
            [
                'label' => __('Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0, .75)',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-block-item .eael-entry-overlay' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .eael-post-block.post-block-style-overlay .eael-entry-wrapper' => 'background-color: {{VALUE}} !important;',
                ],

            ]
        );

        $this->add_control(
            'eael_post_block_hover_icon_color',
            [
                'label' => __('Icon Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-block-item .eael-entry-overlay > i' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'grid_style!' => 'post-block-style-overlay',
                ],
            ]
        );

        $this->add_responsive_control(
            'eael_post_block_hover_icon_fontsize',
            [
                'label' => __('Icon size', 'essential-addons-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => 'px',
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 18,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-block-item .eael-entry-overlay > i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eael-post-block-item .eael-entry-overlay .eael-post-block-hover-svg-icon' => 'width:{{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'grid_style!' => 'post-block-style-overlay',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_post_block_style',
            [
                'label' => __('Post Block Style', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'eael_post_block_bg_color',
            [
                'label' => __('Post Background Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eael-post-block-item' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'grid_style!' => 'post-block-style-overlay',
                ],

            ]
        );

        /*$this->add_control(
        'eael_thumbnail_overlay_color',
        [
        'label' => __( 'Thumbnail Overlay Color', 'essential-addons-elementor' ),
        'type' => Controls_Manager::COLOR,
        'default' => 'rgba(0,0,0, .5)',
        'selectors' => [
        '{{WRAPPER}} .eael-entry-overlay, {{WRAPPER}} .eael-post-block.post-block-style-overlay .eael-entry-wrapper' => 'background-color: {{VALUE}}'
        ]

        ]
        );*/

        $this->add_responsive_control(
            'eael_post_block_spacing',
            [
                'label' => esc_html__('Spacing Between Items', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eael-post-block-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'eael_post_block_border',
                'label' => esc_html__('Border', 'essential-addons-elementor'),
                'selector' => '{{WRAPPER}} .eael-post-block-item',
            ]
        );

        $this->add_control(
            'eael_post_block_border_radius',
            [
                'label' => esc_html__('Border Radius', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .eael-post-block-item' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'eael_post_block_box_shadow',
                'selector' => '{{WRAPPER}} .eael-post-block-item',
            ]
        );

        $this->add_responsive_control(
            'eael_post_content_box_padding',
            [
                'label' => esc_html__('Content Box Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0px {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .eael-entry-footer' => 'padding: 0px {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'grid_style!' => 'post-block-style-overlay',
                ],
            ]
        );

        $this->add_responsive_control(
            'eael_post_overlay_content_box_padding',
            [
                'label' => esc_html__('Content Box Padding', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'grid_style' => 'post-block-style-overlay',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'eael_section_typography',
            [
                'label' => __('Color & Typography', 'essential-addons-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'eael_post_block_title_style',
            [
                'label' => __('Title Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'eael_post_block_title_color',
            [
                'label' => __('Title Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#303133',
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-title, {{WRAPPER}} .eael-entry-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'eael_post_block_title_hover_color',
            [
                'label' => __('Title Hover Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#23527c',
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-title:hover, {{WRAPPER}} .eael-entry-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'eael_post_block_title_alignment',
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
                    '{{WRAPPER}} .eael-entry-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_post_block_title_typography',
                'label' => __('Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eael-entry-title > a',
            ]
        );

        $this->add_responsive_control(
            'eael_post_title_spacing',
            [
                'label' => esc_html__('Title Spacing', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'eael_post_block_excerpt_style',
            [
                'label' => __('Excerpt Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'eael_post_block_excerpt_color',
            [
                'label' => __('Excerpt Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-grid-post-excerpt p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'eael_post_block_excerpt_alignment',
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
                    '{{WRAPPER}} .eael-grid-post-excerpt p' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_post_block_excerpt_typography',
                'label' => __('Excerpt Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-grid-post-excerpt p',
            ]
        );

        $this->add_responsive_control(
            'eael_post_excerpt_spacing',
            [
                'label' => esc_html__('Excerpt Spacing', 'essential-addons-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .eael-grid-post-excerpt p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'content_height',
			[
				'label' => esc_html__( 'Content Height', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units'	=> ['px', '%', 'em'],
				'range' => [
					'px' => [ 'max' => 300 ],
					'%'	=> [ 'max'	=> 100 ]
				],
				'selectors' => [
					'{{WRAPPER}} .eael-post-block-item .eael-entry-wrapper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'eael_post_block_meta_style',
            [
                'label' => __('Meta Style', 'essential-addons-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'eael_post_block_meta_color',
            [
                'label' => __('Meta Color', 'essential-addons-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-meta, .eael-entry-meta a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'eael_post_block_meta_alignment_footer',
            [
                'label' => __('Meta Alignment', 'essential-addons-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-footer' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'meta_position' => 'meta-entry-footer',
                ],
            ]
        );

        $this->add_responsive_control(
            'eael_post_block_meta_alignment_header',
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
                    'justify' => [
                        'title' => __('Justified', 'essential-addons-elementor'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-entry-meta' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'meta_position' => 'meta-entry-header',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'eael_post_block_meta_typography',
                'label' => __('Meta Typography', 'essential-addons-elementor'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .eael-entry-meta > div, {{WRAPPER}} .eael-entry-meta > span',
            ]
        );

        $this->end_controls_section();

        /**
         * Read More Button Style Controls
         */
        $this->eael_read_more_button_style();

        /**
         * Load More Button Style Controls!
         */
        $this->eael_load_more_button_style();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $settings = $this->fix_old_query($settings);
        $args = $this->eael_get_query_args($settings);

        $settings = [
            'post_type' => $settings['post_type'],
            'eael_show_image' => $settings['eael_show_image'],
            'image_size' => $settings['image_size'],
            'eael_show_title' => $settings['eael_show_title'],
            'eael_show_excerpt' => $settings['eael_show_excerpt'],
            'eael_show_meta' => $settings['eael_show_meta'],
            'meta_position' => $settings['meta_position'],
            'eael_excerpt_length' => $settings['eael_excerpt_length'],
            'grid_style' => $settings['grid_style'],
            'post_block_hover_animation' => $settings['eael_post_block_hover_animation'],
            'show_read_more_button' => $settings['eael_show_read_more_button'],
            'read_more_button_text' => $settings['read_more_button_text'],
            'eael_post_block_bg_hover_icon' => (isset($settings['__fa4_migrated']['eael_post_block_bg_hover_icon_new']) || empty($settings['eael_post_block_bg_hover_icon'])) ? $settings['eael_post_block_bg_hover_icon_new']['value'] : $settings['eael_post_block_bg_hover_icon'],
            'show_load_more' => $settings['show_load_more'],
            'show_load_more_text' => $settings['show_load_more_text'],
            'expanison_indicator'   => $settings['excerpt_expanison_indicator'],
            'eael_show_avatar'  => $settings['eael_show_avatar'],
            'eael_show_author'  => $settings['eael_show_author'],
            'eael_show_date'    => $settings['eael_show_date']
        ];

        $this->add_render_attribute(
            'eael-post-block-wrapper',
            [
                'id' => 'eael-post-block-' . esc_attr($this->get_id()),
                'class' => [
                    'eael-post-block',
                    $settings['grid_style']
                ],
            ]
        );

        $this->add_render_attribute(
            'eael-post-block-wrap-inner',
            [
                'class' => ['eael-post-block-grid', 'eael-post-appender', 'eael-post-appender-' . esc_attr($this->get_id())],
            ]
        );

        echo '<div ' . $this->get_render_attribute_string('eael-post-block-wrapper') . '>
		    <div ' . $this->get_render_attribute_string('eael-post-block-wrap-inner') . '>
                ' . self::render_template_($args, $settings) . '
		    </div>
		</div>';

        if ('yes' == $settings['show_load_more']) {
            if ($args['posts_per_page'] != '-1') {
                echo '<div class="eael-load-more-button-wrap">
					<button class="eael-load-more-button" id="eael-load-more-btn-' . $this->get_id() . '" data-widget="' . $this->get_id() . '" data-class="' . get_class($this) . '" data-args="' . http_build_query($args) . '" data-settings="' . http_build_query($settings) . '" data-page="1">
						<div class="eael-btn-loader button__loader"></div>
						<span>' . esc_html__($settings['show_load_more_text'], 'essential-addons-elementor') . '</span>
					</button>
				</div>';
            }
        }
    }
}
