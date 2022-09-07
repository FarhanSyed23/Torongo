<?php

namespace Essential_Addons_Elementor\Pro\Traits;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Utils;

trait Extender
{
    use \Essential_Addons_Elementor\Traits\Helper;

    public function add_progressbar_pro_layouts($options)
    {

        $options['layouts']['line_rainbow']     = __('Line Rainbow', 'essential-addons-elementor');
        $options['layouts']['circle_fill']      = __('Circle Fill', 'essential-addons-elementor');
        $options['layouts']['half_circle_fill'] = __('Half Circle Fill', 'essential-addons-elementor');
        $options['layouts']['box']              = __('Box', 'essential-addons-elementor');
        $options['conditions']                  = [];

        return $options;
    }

    public function fancy_text_style_types($options)
    {
        $options['styles']['style-2'] = __('Style 2', 'essential-addons-elementor');
        $options['conditions']        = [];

        return $options;
    }

    public function eael_ticker_options($options)
    {
        $options['options']['custom'] = __('Custom', 'essential-addons-elementor');
        $options['conditions']        = [];

        return $options;
    }

    public function data_table_sorting($obj)
    {
        $obj->add_control(
            'eael_section_data_table_enabled',
            [
                'label'        => __('Enable Table Sorting', 'essential-addons-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'essential-addons-elementor'),
                'label_off'    => esc_html__('No', 'essential-addons-elementor'),
                'return_value' => 'true',
            ]
        );
    }

    public function eael_ticker_custom_contents($obj)
    {
        /**
         * Content Ticker Custom Content Settings
         */
        $obj->start_controls_section(
            'eael_section_ticker_custom_content_settings',
            [
                'label'     => __('Custom Content Settings', 'essential-addons-elementor'),
                'condition' => [
                    'eael_ticker_type' => 'custom',
                ],
            ]
        );

        $obj->add_control(
            'eael_ticker_custom_contents',
            [
                'type'        => Controls_Manager::REPEATER,
                'seperator'   => 'before',
                'default'     => [
                    ['eael_ticker_custom_content' => 'Ticker Custom Content'],
                ],
                'fields'      => [
                    [
                        'name'        => 'eael_ticker_custom_content',
                        'label'       => esc_html__('Content', 'essential-addons-elementor'),
                        'type'        => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default'     => esc_html__('Ticker custom content', 'essential-addons-elementor'),
                    ],
                    [
                        'name'          => 'eael_ticker_custom_content_link',
                        'label'         => esc_html__('Button Link', 'essential-addons-elementor'),
                        'type'          => Controls_Manager::URL,
                        'label_block'   => true,
                        'default'       => [
                            'url'         => '#',
                            'is_external' => '',
                        ],
                        'show_external' => true,
                    ],
                ],
                'title_field' => '{{eael_ticker_custom_content}}',
            ]
        );

        $obj->end_controls_section();
    }

    public function content_ticker_custom_content($settings)
    {
        if ('custom' === $settings['eael_ticker_type']) {
            foreach ($settings['eael_ticker_custom_contents'] as $content):
                $target   = $content['eael_ticker_custom_content_link']['is_external'] ? 'target="_blank"' : '';
                $nofollow = $content['eael_ticker_custom_content_link']['nofollow'] ? 'rel="nofollow"' : '';
                ?>
			                <div class="swiper-slide">
			                    <div class="ticker-content">
			                        <?php if (!empty($content['eael_ticker_custom_content_link']['url'])): ?>
			                            <a <?php echo $target; ?> <?php echo $nofollow; ?>
			                                    href="<?php echo esc_url($content['eael_ticker_custom_content_link']['url']); ?>"
			                                    class="ticker-content-link"><?php echo _e($content['eael_ticker_custom_content'],
                    'essential-addons-elementor') ?></a>
			                        <?php else: ?>
                            <p><?php echo _e($content['eael_ticker_custom_content'],
                'essential-addons-elementor') ?></p>
                        <?php endif;?>
                    </div>
                </div>
            <?php
endforeach;
        }
    }

    public function progress_bar_rainbow_class(array $wrap_classes, array $settings)
    {
        if ($settings['progress_bar_layout'] == 'line_rainbow') {
            $wrap_classes[] = 'eael-progressbar-line-rainbow';
        }

        return $wrap_classes;
    }

    public function progress_bar_circle_fill_class(array $wrap_classes, array $settings)
    {
        if ($settings['progress_bar_layout'] == 'circle_fill') {
            $wrap_classes[] = 'eael-progressbar-circle-fill';
        }

        return $wrap_classes;
    }

    public function progressbar_half_circle_wrap_class(array $wrap_classes, array $settings)
    {
        if ($settings['progress_bar_layout'] == 'half_circle_fill') {
            $wrap_classes[] = 'eael-progressbar-half-circle-fill';
        }
        return $wrap_classes;
    }

    public function progress_bar_box_control($obj)
    {
        /**
         * Style Tab: General(Box)
         */
        $obj->start_controls_section(
            'progress_bar_section_style_general_box',
            [
                'label'     => __('General', 'essential-addons-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'progress_bar_layout' => 'box',
                ],
            ]
        );

        $obj->add_control(
            'progress_bar_box_alignment',
            [
                'label'   => __('Alignment', 'essential-addons-elementor'),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'title' => __('Left', 'essential-addons-elementor'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'essential-addons-elementor'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'essential-addons-elementor'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
            ]
        );

        $obj->add_control(
            'progress_bar_box_width',
            [
                'label'      => __('Width', 'essential-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 100,
                        'max'  => 500,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 140,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .eael-progressbar-box' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $obj->add_control(
            'progress_bar_box_height',
            [
                'label'      => __('Height', 'essential-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 100,
                        'max'  => 500,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .eael-progressbar-box' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $obj->add_control(
            'progress_bar_box_bg_color',
            [
                'label'     => __('Background Color', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .eael-progressbar-box' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );

        $obj->add_control(
            'progress_bar_box_fill_color',
            [
                'label'     => __('Fill Color', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000',
                'selectors' => [
                    '{{WRAPPER}} .eael-progressbar-box-fill' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );

        $obj->add_control(
            'progress_bar_box_stroke_width',
            [
                'label'      => __('Stroke Width', 'essential-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .eael-progressbar-box' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
                'separator'  => 'before',
            ]
        );

        $obj->add_control(
            'progress_bar_box_stroke_color',
            [
                'label'     => __('Stroke Color', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#eee',
                'selectors' => [
                    '{{WRAPPER}} .eael-progressbar-box' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $obj->end_controls_section();
    }

    public function add_box_progress_bar_block(array $settings, $obj, array $wrap_classes)
    {
        if ($settings['progress_bar_layout'] == 'box') {
            $wrap_classes[] = 'eael-progressbar-box';

            $obj->add_render_attribute('eael-progressbar-box', [
                'class'         => $wrap_classes,
                'data-layout'   => $settings['progress_bar_layout'],
                'data-count'    => $settings['progress_bar_value_type'] == 'static' ? $settings['progress_bar_value']['size'] : $settings['progress_bar_value_dynamic'],
                'data-duration' => $settings['progress_bar_animation_duration']['size'],
            ]);

            $obj->add_render_attribute('eael-progressbar-box-fill', [
                'class' => 'eael-progressbar-box-fill',
                'style' => '-webkit-transition-duration:' . $settings['progress_bar_animation_duration']['size'] . 'ms;-o-transition-duration:' . $settings['progress_bar_animation_duration']['size'] . 'ms;transition-duration:' . $settings['progress_bar_animation_duration']['size'] . 'ms;',
            ]);

            echo '<div class="eael-progressbar-box-container ' . $settings['progress_bar_box_alignment'] . '">
				<div ' . $obj->get_render_attribute_string('eael-progressbar-box') . '>
	                <div class="eael-progressbar-box-inner-content">
	                    ' . ($settings['progress_bar_title'] ? sprintf('<%1$s class="%2$s">',
                $settings['progress_bar_title_html_tag'],
                'eael-progressbar-title') . $settings['progress_bar_title'] . sprintf('</%1$s>',
                $settings['progress_bar_title_html_tag']) : '') . '
	                    ' . ($settings['progress_bar_show_count'] === 'yes' ? '<span class="eael-progressbar-count-wrap"><span class="eael-progressbar-count">0</span><span class="postfix">' . __('%',
                'essential-addons-for-elementor-lite') . '</span></span>' : '') . '
	                </div>
	                <div ' . $obj->get_render_attribute_string('eael-progressbar-box-fill') . '></div>
	            </div>
            </div>';
        }
    }

    public function progressbar_general_style_condition($conditions)
    {
        return array_merge($conditions, ['circle_fill', 'half_circle_fill', 'box']);
    }

    public function progressbar_line_fill_stripe_condition($conditions)
    {
        return array_merge($conditions, ['progress_bar_layout' => 'line']);
    }

    public function circle_style_general_condition($conditions)
    {
        return array_merge($conditions, ['circle_fill', 'half_circle_fill']);
    }

    public function add_pricing_table_styles($options)
    {
        $options['styles']['style-3'] = esc_html__('Pricing Style 3', 'essential-addons-elementor');
        $options['styles']['style-4'] = esc_html__('Pricing Style 4', 'essential-addons-elementor');
        $options['conditions']        = [];

        return $options;
    }

    public function add_creative_button_controls($obj)
    {
        // Content Controls
        $obj->start_controls_section(
            'eael_section_creative_button_content',
            [
                'label' => esc_html__('Button Content', 'essential-addons-elementor'),
            ]
        );

        $obj->start_controls_tabs('eael_creative_button_content_separation');

        $obj->start_controls_tab(
            'button_primary_settings',
            [
                'label' => __('Primary', 'essential-addons-elementor'),
            ]
        );

        $obj->add_control(
            'creative_button_text',
            [
                'label'       => __('Button Text', 'essential-addons-elementor'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'Click Me!',
                'placeholder' => __('Enter button text', 'essential-addons-elementor'),
                'title'       => __('Enter button text here', 'essential-addons-elementor'),
            ]
        );

        $obj->add_control(
            'eael_creative_button_icon_new',
            [
                'label'            => esc_html__('Icon', 'essential-addons-elementor'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'eael_creative_button_icon',
                'condition'        => [
                    'creative_button_effect!' => ['eael-creative-button--tamaya'],
                ],
            ]
        );

        $obj->add_control(
            'eael_creative_button_icon_alignment',
            [
                'label'     => esc_html__('Icon Position', 'essential-addons-elementor'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left'  => esc_html__('Before', 'essential-addons-elementor'),
                    'right' => esc_html__('After', 'essential-addons-elementor'),
                ],
                'condition' => [
                    'creative_button_effect!' => ['eael-creative-button--tamaya'],
                ],
            ]
        );

        $obj->add_control(
            'eael_creative_button_icon_indent',
            [
                'label'     => esc_html__('Icon Spacing', 'essential-addons-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-creative-button-icon-right' => 'margin-left: {{SIZE}}px;',
                    '{{WRAPPER}} .eael-creative-button-icon-left'  => 'margin-right: {{SIZE}}px;',
                    '{{WRAPPER}} .eael-creative-button--shikoba i' => 'left: {{SIZE}}%;',
                ],
                'condition' => [
                    'creative_button_effect!' => ['eael-creative-button--tamaya'],
                ],
            ]
        );

        $obj->end_controls_tab();

        $obj->start_controls_tab(
            'button_secondary_settings',
            [
                'label' => __('Secondary', 'essential-addons-elementor'),
            ]
        );

        $obj->add_control(
            'creative_button_secondary_text',
            [
                'label'       => __('Button Secondary Text', 'essential-addons-elementor'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'Go!',
                'placeholder' => __('Enter button secondary text', 'essential-addons-elementor'),
                'title'       => __('Enter button secondary text here', 'essential-addons-elementor'),
            ]
        );

        $obj->end_controls_tab();

        $obj->end_controls_tabs();

        $obj->add_control(
            'creative_button_link_url',
            [
                'label'         => esc_html__('Link URL', 'essential-addons-elementor'),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'default'       => [
                    'url'         => '#',
                    'is_external' => '',
                ],
                'show_external' => true,
            ]
        );

        $obj->end_controls_section();
    }

    public function add_creative_button_style_pro_controls($obj)
    {
        $obj->add_control(
            'creative_button_effect',
            [
                'label'   => esc_html__('Set Button Effect', 'essential-addons-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'eael-creative-button--default',
                'options' => [
                    'eael-creative-button--default' => esc_html__('Default', 'essential-addons-elementor'),
                    'eael-creative-button--winona'  => esc_html__('Winona', 'essential-addons-elementor'),
                    'eael-creative-button--ujarak'  => esc_html__('Ujarak', 'essential-addons-elementor'),
                    'eael-creative-button--wayra'   => esc_html__('Wayra', 'essential-addons-elementor'),
                    'eael-creative-button--tamaya'  => esc_html__('Tamaya', 'essential-addons-elementor'),
                    'eael-creative-button--rayen'   => esc_html__('Rayen', 'essential-addons-elementor'),
                    'eael-creative-button--pipaluk' => esc_html__('Pipaluk', 'essential-addons-elementor'),
                    'eael-creative-button--moema'   => esc_html__('Moema', 'essential-addons-elementor'),
                    'eael-creative-button--wave'    => esc_html__('Wave', 'essential-addons-elementor'),
                    'eael-creative-button--aylen'   => esc_html__('Aylen', 'essential-addons-elementor'),
                    'eael-creative-button--saqui'   => esc_html__('Saqui', 'essential-addons-elementor'),
                    'eael-creative-button--wapasha' => esc_html__('Wapasha', 'essential-addons-elementor'),
                    'eael-creative-button--nuka'    => esc_html__('Nuka', 'essential-addons-elementor'),
                    'eael-creative-button--antiman' => esc_html__('Antiman', 'essential-addons-elementor'),
                    'eael-creative-button--quidel'  => esc_html__('Quidel', 'essential-addons-elementor'),
                    'eael-creative-button--shikoba' => esc_html__('Shikoba', 'essential-addons-elementor'),
                ],
            ]
        );

        $obj->start_controls_tabs('eael_creative_button_typography_separation');

        $obj->start_controls_tab('button_primary_typography', [
            'label' => __('Primary', 'essential-addons-elementor'),
        ]);

        $obj->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'eael_creative_button_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eael-creative-button .cretive-button-text',
            ]
        );

        $obj->add_responsive_control(
            'eael_creative_button_icon_size',
            [
                'label'      => esc_html__('Icon Size', 'essential-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'default'    => [
                    'size' => 30,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 500,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .eael-creative-button i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .eael-creative-button img' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $obj->end_controls_tab();

        $obj->start_controls_tab('button_secondary_typography', [
            'label' => __('Secondary', 'essential-addons-elementor'),
        ]);

        $obj->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'eael_creative_button_secondary_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eael-creative-button--rayen::before, {{WRAPPER}} .eael-creative-button--winona::after',
            ]
        );

        $obj->end_controls_tab();

        $obj->end_controls_tabs();

        $obj->add_responsive_control(
            'eael_creative_button_alignment',
            [
                'label'       => esc_html__('Button Alignment', 'essential-addons-elementor'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => true,
                'options'     => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'essential-addons-elementor'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__('Center', 'essential-addons-elementor'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__('Right', 'essential-addons-elementor'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'     => '',
                'selectors'   => [
                    '{{WRAPPER}} .eael-creative-button-wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $obj->add_responsive_control(
            'eael_creative_button_width',
            [
                'label'      => esc_html__('Width', 'essential-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 500,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .eael-creative-button' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $obj->add_responsive_control(
            'eael_creative_button_padding',
            [
                'label'      => esc_html__('Button Padding', 'essential-addons-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-creative-button'                                      => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--winona::after'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--winona > span'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--tamaya::before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--rayen::before'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--rayen > span'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--saqui::after'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $obj->start_controls_tabs('eael_creative_button_tabs');

        $obj->start_controls_tab('normal', ['label' => esc_html__('Normal', 'essential-addons-elementor')]);

        $obj->add_control(
            'eael_creative_button_text_color',
            [
                'label'     => esc_html__('Text Color', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-creative-button'                                      => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--tamaya::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--tamaya::after'  => 'color: {{VALUE}};',
                ],
            ]
        );

        $obj->add_control(
            'eael_creative_button_background_color',
            [
                'label'     => esc_html__('Background Color', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .eael-creative-button'                                      => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--ujarak:hover'   => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--wayra:hover'    => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--tamaya::before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--tamaya::after'  => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--rayen:hover'    => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--pipaluk::after' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--wave:hover'     => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--aylen::before'  => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--nuka::before'   => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--nuka::after'    => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--antiman::after' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--quidel::after'  => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $obj->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'eael_creative_button_border',
                'selector' => '{{WRAPPER}} .eael-creative-button',
            ]
        );

        $obj->add_control(
            'eael_creative_button_border_radius',
            [
                'label'     => esc_html__('Border Radius', 'essential-addons-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-creative-button'         => 'border-radius: {{SIZE}}px;',
                    '{{WRAPPER}} .eael-creative-button::before' => 'border-radius: {{SIZE}}px;',
                    '{{WRAPPER}} .eael-creative-button::after'  => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $obj->end_controls_tab();

        $obj->start_controls_tab('eael_creative_button_hover',
            ['label' => esc_html__('Hover', 'essential-addons-elementor')]);

        $obj->add_control(
            'eael_creative_button_hover_text_color',
            [
                'label'     => esc_html__('Text Color', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-creative-button:hover'                               => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--winona::after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--saqui::after'  => 'color: {{VALUE}};',
                ],
            ]
        );

        $obj->add_control(
            'eael_creative_button_hover_background_color',
            [
                'label'     => esc_html__('Background Color', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f54',
                'selectors' => [
                    '{{WRAPPER}} .eael-creative-button:hover'                                     => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--ujarak::before'      => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--wayra:hover::before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--tamaya:hover'        => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--rayen::before'       => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--wave::before'        => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--wave:hover::before'  => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--aylen::after'        => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--saqui:hover'         => 'color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--nuka:hover::after'   => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--quidel:hover::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $obj->add_control(
            'eael_creative_button_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .eael-creative-button:hover'                                 => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--wapasha::before' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--antiman::before' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--pipaluk::before' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .eael-creative-button.eael-creative-button--quidel::before'  => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $obj->end_controls_tab();

        $obj->end_controls_tabs();
    }

    public function pricing_table_subtitle_field($options)
    {
        return array_merge($options, ['style-3', 'style-4']);
    }

    public function pricing_table_header_image_control($obj)
    {
        /**
         * Condition: 'eael_pricing_table_style' => 'style-4'
         */
        $obj->add_control(
            'eael_pricing_table_style_4_image',
            [
                'label'     => esc_html__('Header Image', 'essential-addons-elementor'),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'selectors' => [
                    '{{WRAPPER}} .eael-pricing-image' => 'background-image: url({{URL}});',
                ],
                'condition' => [
                    'eael_pricing_table_style' => 'style-4',
                ],
            ]
        );
    }

    public function pricing_table_style_2_currency_position($obj)
    {
        /**
         * Condition: 'eael_pricing_table_style' => 'style-3'
         */
        $obj->add_control(
            'eael_pricing_table_style_3_price_position',
            [
                'label'       => esc_html__('Pricing Position', 'essential-addons-elementor'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'bottom',
                'label_block' => false,
                'options'     => [
                    'top'    => esc_html__('On Top', 'essential-addons-elementor'),
                    'bottom' => esc_html__('At Bottom', 'essential-addons-elementor'),
                ],
                'condition'   => [
                    'eael_pricing_table_style' => 'style-3',
                ],
            ]
        );
    }

    public function add_pricing_table_pro_styles($settings, $obj, $pricing, $target, $nofollow, $featured_class)
    {

        if ('style-3' === $settings['eael_pricing_table_style']): ?>
            <div class="eael-pricing style-3">
                <div class="eael-pricing-item <?php echo esc_attr($featured_class); ?>">
                    <?php if ('top' === $settings['eael_pricing_table_style_3_price_position']): ?>
                        <div class="eael-pricing-tag on-top">
                            <span class="price-tag"><?php echo $pricing; ?></span>
                            <span class="price-period"><?php echo $settings['eael_pricing_table_period_separator']; ?><?php echo $settings['eael_pricing_table_price_period']; ?></span>
                        </div>
                    <?php endif;?>
                    <div class="header">
                        <h2 class="title"><?php echo $settings['eael_pricing_table_title']; ?></h2>
                        <span class="subtitle"><?php echo $settings['eael_pricing_table_sub_title']; ?></span>
                    </div>
                    <div class="body">
                        <?php $obj->render_feature_list($settings, $obj);?>
                    </div>
                    <?php if ('bottom' === $settings['eael_pricing_table_style_3_price_position']): ?>
                        <div class="eael-pricing-tag">
                            <span class="price-tag"><?php echo $pricing; ?></span>
                            <span class="price-period"><?php echo $settings['eael_pricing_table_period_separator']; ?><?php echo $settings['eael_pricing_table_price_period']; ?></span>
                        </div>
                    <?php endif;?>
                    <div class="footer">
                        <a href="<?php echo esc_url($settings['eael_pricing_table_btn_link']['url']); ?>" <?php echo $target; ?> <?php echo $nofollow; ?>
                           class="eael-pricing-button">
                            <?php if ('left' == $settings['eael_pricing_table_button_icon_alignment']): ?>
                                <?php if (empty($settings['eael_pricing_table_button_icon']) || isset($settings['__fa4_migrated']['eael_pricing_table_button_icon_new'])) {?>
                                    <i class="<?php echo esc_attr($settings['eael_pricing_table_button_icon_new']['value']); ?> fa-icon-left"></i>
                                <?php } else {?>
                                    <i class="<?php echo esc_attr($settings['eael_pricing_table_button_icon']); ?> fa-icon-left"></i>
                                <?php }?>
                                <?php echo $settings['eael_pricing_table_btn']; ?>
                            <?php elseif ('right' == $settings['eael_pricing_table_button_icon_alignment']): ?>
                                <?php echo $settings['eael_pricing_table_btn']; ?>
                                <?php if (empty($settings['eael_pricing_table_button_icon']) || isset($settings['__fa4_migrated']['eael_pricing_table_button_icon_new'])) {?>
                                    <i class="<?php echo esc_attr($settings['eael_pricing_table_button_icon_new']['value']); ?> fa-icon-right"></i>
                                <?php } else {?>
                                    <i class="<?php echo esc_attr($settings['eael_pricing_table_button_icon']); ?> fa-icon-right"></i>
                                <?php }?>
                            <?php endif;?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif;
        if ('style-4' === $settings['eael_pricing_table_style']): ?>
            <div class="eael-pricing style-4">
                <div class="eael-pricing-item <?php echo esc_attr($featured_class); ?>">
                    <div class="eael-pricing-image">
                        <div class="eael-pricing-tag">
                            <span class="price-tag"><?php echo $pricing; ?></span>
                            <span class="price-period"><?php echo $settings['eael_pricing_table_period_separator']; ?><?php echo $settings['eael_pricing_table_price_period']; ?></span>
                        </div>
                    </div>
                    <div class="header">
                        <h2 class="title"><?php echo $settings['eael_pricing_table_title']; ?></h2>
                        <span class="subtitle"><?php echo $settings['eael_pricing_table_sub_title']; ?></span>
                    </div>
                    <div class="body">
                        <?php $obj->render_feature_list($settings, $obj);?>
                    </div>
                    <div class="footer">
                        <a href="<?php echo esc_url($settings['eael_pricing_table_btn_link']['url']); ?>" <?php echo $target; ?> <?php echo $nofollow; ?>
                           class="eael-pricing-button">
                            <?php if ('left' == $settings['eael_pricing_table_button_icon_alignment']): ?>
                                <?php if (empty($settings['eael_pricing_table_button_icon']) || isset($settings['__fa4_migrated']['eael_pricing_table_button_icon_new'])) {?>
                                    <i class="<?php echo esc_attr($settings['eael_pricing_table_button_icon_new']['value']); ?> fa-icon-left"></i>
                                <?php } else {?>
                                    <i class="<?php echo esc_attr($settings['eael_pricing_table_button_icon']); ?> fa-icon-left"></i>
                                <?php }?>
                                <?php echo $settings['eael_pricing_table_btn']; ?>
                            <?php elseif ('right' == $settings['eael_pricing_table_button_icon_alignment']): ?>
                                <?php echo $settings['eael_pricing_table_btn']; ?>
                                <?php if (empty($settings['eael_pricing_table_button_icon']) || isset($settings['__fa4_migrated']['eael_pricing_table_button_icon_new'])) {?>
                                    <i class="<?php echo esc_attr($settings['eael_pricing_table_button_icon_new']['value']); ?> fa-icon-right"></i>
                                <?php } else {?>
                                    <i class="<?php echo esc_attr($settings['eael_pricing_table_button_icon']); ?> fa-icon-right"></i>
                                <?php }?>
                            <?php endif;?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif;
    }

    public function add_admin_licnes_markup_html()
    {
        ?>
        <div class="eael-admin-block eael-admin-block-license">
            <header class="eael-admin-block-header">
                <div class="eael-admin-block-header-icon">
                    <img src="<?php echo EAEL_PRO_PLUGIN_URL . 'assets/admin/images/icon-automatic-updates.svg'; ?>"
                         alt="essential-addons-automatic-update">
                </div>
                <h4 class="eael-admin-title"><?php _e('Automatic Update', 'essential-addons-elementor');?></h4>
            </header>
            <div class="eael-admin-block-content">
                <?php do_action('eael_licensing');?>
            </div>
        </div>
        <?php
}

    public function add_eael_premium_support_link()
    {
        ?>
        <p><?php echo _e('Stuck with something? Get help from live chat or support ticket.',
            'essential-addons-elementor'); ?></p>
        <a href="https://wpdeveloper.net" class="ea-button" target="_blank"><?php echo _e('Initiate a Chat',
            'essential-addons-elementor'); ?></a>
        <?php
}

    public function add_eael_additional_support_links()
    {
        ?>
        <div class="eael-admin-block eael-admin-block-community">
            <header class="eael-admin-block-header">
                <div class="eael-admin-block-header-icon">
                    <img src="<?php echo EAEL_PRO_PLUGIN_URL . 'assets/admin/images/icon-join-community.svg'; ?>"
                         alt="join-essential-addons-community">
                </div>
                <h4 class="eael-admin-title">Join the Community</h4>
            </header>
            <div class="eael-admin-block-content">
                <p><?php echo _e('Join the Facebook community and discuss with fellow developers and users. Best way to connect with people and get feedback on your projects.',
            'essential-addons-elementor'); ?></p>

                <a href="https://www.facebook.com/groups/essentialaddons" class="review-flexia ea-button"
                   target="_blank"><?php echo _e('Join Facebook Community', 'essential-addons-elementor'); ?></a>
            </div>
        </div>
        <?php
}

    public function add_manage_linces_action_link()
    {
        printf(__('<a href="%s" target="_blank">Manage License</a>', 'essential-addons-elementor'),
            'https://wpdeveloper.net/account');
    }

    public function eael_team_member_presets_condition($options)
    {
        return [];
    }

    public function add_team_member_circle_presets($obj)
    {
        $obj->add_responsive_control(
            'eael_team_members_image_height',
            [
                'label'      => esc_html__('Image Height', 'essential-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => '100',
                    'unit' => '%',
                ],
                'range'      => [
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'size_units' => ['%', 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-team-item figure img' => 'height:{{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'eael_team_members_preset!' => 'eael-team-members-circle',
                ],
            ]
        );

        $obj->add_responsive_control(
            'eael_team_members_circle_image_width',
            [
                'label'      => esc_html__('Image Width', 'essential-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 150,
                    'unit' => 'px',
                ],
                'range'      => [
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-team-item.eael-team-members-circle figure img' => 'width:{{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'eael_team_members_preset' => 'eael-team-members-circle',
                ],
            ]
        );

        $obj->add_responsive_control(
            'eael_team_members_circle_image_height',
            [
                'label'      => esc_html__('Image Height', 'essential-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 150,
                    'unit' => 'px',
                ],
                'range'      => [
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-team-item.eael-team-members-circle figure img' => 'height:{{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'eael_team_members_preset' => 'eael-team-members-circle',
                ],
            ]
        );
    }

    public function add_team_member_social_bottom_markup($settings)
    {
        ?>
        <p class="eael-team-text"><?php echo $settings['eael_team_member_description']; ?></p>
        <?php if (!empty($settings['eael_team_member_enable_social_profiles'])): ?>
            <ul class="eael-team-member-social-profiles">
                <?php foreach ($settings['eael_team_member_social_profile_links'] as $item): ?>
                    <?php if (!empty($item['social'])): ?>
                        <?php $target = $item['link']['is_external'] ? ' target="_blank"' : '';?>
                        <li class="eael-team-member-social-link">
                            <a href="<?php echo esc_attr($item['link']['url']); ?>"<?php echo $target; ?>><i
                                        class="<?php echo esc_attr($item['social']); ?>"></i></a>
                        </li>
                    <?php endif;?>
                <?php endforeach;?>
            </ul>
        <?php endif;
    }

    // Advanced Data Table
    public function advanced_data_table_source_control($wb)
    {
        // database
        $wb->add_control(
            'ea_adv_data_table_source_database_query_type',
            [
                'label'     => esc_html__('Select Query', 'essential-addons-elementor'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'table' => 'Table',
                    'query' => 'MySQL Query',
                ],
                'default'   => 'table',
                'condition' => [
                    'ea_adv_data_table_source' => 'database',
                ],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_database_table',
            [
                'label'     => esc_html__('Select Table', 'essential-addons-elementor'),
                'type'      => Controls_Manager::SELECT,
                'options'   => $this->eael_list_db_tables(),
                'condition' => [
                    'ea_adv_data_table_source'                     => 'database',
                    'ea_adv_data_table_source_database_query_type' => 'table',
                ],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_database_query',
            [
                'label'       => esc_html__('MySQL Query', 'essential-addons-elementor'),
                'type'        => Controls_Manager::TEXTAREA,
                'placeholder' => 'e.g. SELECT * FROM `table`',
                'condition'   => [
                    'ea_adv_data_table_source'                     => 'database',
                    'ea_adv_data_table_source_database_query_type' => 'query',
                ],
            ]
        );

        // remote
        $wb->add_control(
            'ea_adv_data_table_source_remote_host',
            [
                'label'     => __('Host', 'essential-addons-elementor'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'ea_adv_data_table_source'                  => 'remote',
                    'ea_adv_data_table_source_remote_connected' => false,
                ],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_remote_username',
            [
                'label'     => __('Username', 'essential-addons-elementor'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'ea_adv_data_table_source'                  => 'remote',
                    'ea_adv_data_table_source_remote_connected' => false,
                ],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_remote_password',
            [
                'label'      => __('Password', 'essential-addons-elementor'),
                'type'       => Controls_Manager::TEXT,
                'input_type' => 'password',
                'condition'  => [
                    'ea_adv_data_table_source'                  => 'remote',
                    'ea_adv_data_table_source_remote_connected' => false,
                ],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_remote_database',
            [
                'label'     => __('Database', 'essential-addons-elementor'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'ea_adv_data_table_source'                  => 'remote',
                    'ea_adv_data_table_source_remote_connected' => false,
                ],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_remote_connect',
            [
                'label'     => __('Connect DB', 'essential-addons-for-elementor-lite'),
                'type'      => Controls_Manager::BUTTON,
                'text'      => __('Connect', 'essential-addons-elementor'),
                'event'     => 'ea:advTable:connect',
                'condition' => [
                    'ea_adv_data_table_source'                  => 'remote',
                    'ea_adv_data_table_source_remote_connected' => false,
                ],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_remote_disconnect',
            [
                'label'     => __('Disconnect DB', 'essential-addons-for-elementor-lite'),
                'type'      => Controls_Manager::BUTTON,
                'text'      => __('Disconnect', 'essential-addons-elementor'),
                'event'     => 'ea:advTable:disconnect',
                'condition' => [
                    'ea_adv_data_table_source'                  => 'remote',
                    'ea_adv_data_table_source_remote_connected' => true,
                ],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_remote_connected',
            [
                'type'    => Controls_Manager::HIDDEN,
                'default' => false,
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_remote_tables',
            [
                'type'    => Controls_Manager::HIDDEN,
                'default' => [],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_dynamic_th_width',
            [
                'type'    => Controls_Manager::HIDDEN,
                'default' => [],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_remote_query_type',
            [
                'label'     => esc_html__('Select Query', 'essential-addons-elementor'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'table' => 'Table',
                    'query' => 'MySQL Query',
                ],
                'default'   => 'table',
                'condition' => [
                    'ea_adv_data_table_source'                  => 'remote',
                    'ea_adv_data_table_source_remote_connected' => true,
                ],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_remote_table',
            [
                'label'     => esc_html__('Select Table', 'essential-addons-elementor'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [],
                'condition' => [
                    'ea_adv_data_table_source'                   => 'remote',
                    'ea_adv_data_table_source_remote_connected'  => true,
                    'ea_adv_data_table_source_remote_query_type' => 'table',
                ],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_remote_query',
            [
                'label'       => esc_html__('MySQL Query', 'essential-addons-elementor'),
                'type'        => Controls_Manager::TEXTAREA,
                'placeholder' => 'e.g. SELECT * FROM `table`',
                'condition'   => [
                    'ea_adv_data_table_source'                   => 'remote',
                    'ea_adv_data_table_source_remote_connected'  => true,
                    'ea_adv_data_table_source_remote_query_type' => 'query',
                ],
            ]
        );

        // google sheet
        $wb->add_control(
            'ea_adv_data_table_source_google_api_key',
            [
                'label'     => __('API Key', 'essential-addons-elementor'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'ea_adv_data_table_source' => 'google',
                ],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_google_sheet_id',
            [
                'label'     => __('Sheet ID', 'essential-addons-elementor'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'ea_adv_data_table_source' => 'google',
                ],
            ]
        );

        $wb->add_control(
            'ea_adv_data_table_source_google_table_range',
            [
                'label'     => __('Table Range', 'essential-addons-elementor'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'ea_adv_data_table_source' => 'google',
                ],
            ]
        );

        // tablepress
        if (apply_filters('eael/active_plugins', 'tablepress/tablepress.php')) {
            $wb->add_control(
                'ea_adv_data_table_source_tablepress_table_id',
                [
                    'label'     => esc_html__('Table ID', 'essential-addons-elementor'),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => $this->eael_list_tablepress_tables(),
                    'condition' => [
                        'ea_adv_data_table_source' => 'tablepress',
                    ],
                ]
            );
        } else {
            $wb->add_control(
                'ea_adv_data_table_tablepress_required',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => __('<strong>TablePress</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=TablePress&tab=search&type=term" target="_blank">TablePress</a> first.',
                        'essential-addons-for-elementor-lite'),
                    'content_classes' => 'eael-warning',
                    'condition'       => [
                        'ea_adv_data_table_source' => 'tablepress',
                    ],
                ]
            );
        }
    }

    public function event_calendar_source_control($obj)
    {
        if (apply_filters('eael/active_plugins', 'eventON/eventon.php')) {
            $obj->start_controls_section(
                'eael_event_calendar_eventon_section',
                [
                    'label'     => __('EventON', 'essential-addons-for-elementor'),
                    'condition' => [
                        'eael_event_calendar_type' => 'eventon',
                    ],
                ]
            );

            $obj->add_control(
                'eael_eventon_calendar_fetch',
                [
                    'label'       => __('Get Events', 'essential-addons-for-elementor'),
                    'type'        => Controls_Manager::SELECT,
                    'label_block' => true,
                    'default'     => ['all'],
                    'options'     => [
                        'all'        => __('All', 'essential-addons-for-elementor'),
                        'date_range' => __('Date Range', 'essential-addons-for-elementor'),
                    ],
                ]
            );

            $obj->add_control(
                'eael_eventon_calendar_start_date',
                [
                    'label'     => __('Start Date', 'essential-addons-for-elementor'),
                    'type'      => Controls_Manager::DATE_TIME,
                    'default'   => date('Y-m-d H:i', current_time('timestamp', 0)),
                    'condition' => [
                        'eael_eventon_calendar_fetch' => 'date_range',
                    ],
                ]
            );

            $obj->add_control(
                'eael_eventon_calendar_end_date',
                [
                    'label'     => __('End Date', 'essential-addons-for-elementor'),
                    'type'      => Controls_Manager::DATE_TIME,
                    'default'   => date('Y-m-d H:i', strtotime("+6 months", current_time('timestamp', 0))),
                    'condition' => [
                        'eael_eventon_calendar_fetch' => 'date_range',
                    ],
                ]
            );

            $obj->add_control(
                'eael_eventon_calendar_post_tag',
                [
                    'label'       => __('Event Tag', 'essential-addons-for-elementor'),
                    'type'        => Controls_Manager::SELECT2,
                    'multiple'    => true,
                    'label_block' => true,
                    'default'     => [],
                    'options'     => $this->eael_get_tags(['taxonomy' => 'post_tag', 'hide_empty' => false]),
                ]
            );

            $taxonomies = $this->eael_get_taxonomies_by_post(['object_type' => 'ajde_events']);
            unset($taxonomies['event_location'], $taxonomies['post_tag'], $taxonomies['event_organizer']);
            foreach ($taxonomies as $taxonomie) {
                $key = 'eael_eventon_calendar_' . $taxonomie;
                $obj->add_control(
                    $key,
                    [
                        'label'       => ucwords(str_replace('_', ' ', $taxonomie)),
                        'type'        => Controls_Manager::SELECT2,
                        'multiple'    => true,
                        'label_block' => true,
                        'default'     => [],
                        'options'     => $this->eael_get_tags(['taxonomy' => $taxonomie, 'hide_empty' => false]),
                    ]
                );
            }

            $obj->add_control(
                'eael_eventon_calendar_event_location',
                [
                    'label'       => __('Event Location', 'essential-addons-for-elementor'),
                    'type'        => Controls_Manager::SELECT2,
                    'multiple'    => true,
                    'label_block' => true,
                    'default'     => [],
                    'options'     => $this->eael_get_tags(['taxonomy' => 'event_location', 'hide_empty' => false]),
                ]
            );

            $obj->add_control(
                'eael_eventon_calendar_event_organizer',
                [
                    'label'       => __('Event Organizer', 'essential-addons-for-elementor'),
                    'type'        => Controls_Manager::SELECT2,
                    'multiple'    => true,
                    'label_block' => true,
                    'default'     => [],
                    'options'     => $this->eael_get_tags(['taxonomy' => 'event_organizer', 'hide_empty' => false]),
                ]
            );

            $obj->add_control(
                'eael_eventon_calendar_max_result',
                [
                    'label'   => __('Max Result', 'essential-addons-for-elementor'),
                    'type'    => Controls_Manager::NUMBER,
                    'min'     => 1,
                    'default' => 100,
                ]
            );

            $obj->end_controls_section();
        }
    }

    public function event_calendar_activation_notice($obj)
    {
        if (!apply_filters('eael/active_plugins', 'eventON/eventon.php')) {
            $obj->add_control(
                'eael_eventon_warning_text',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => __('<strong>EventON</strong> is not installed/activated on your site. Please install and activate <a href="https://codecanyon.net/item/eventon-wordpress-event-calendar-plugin/1211017" target="_blank">EventON</a> first.',
                        'essential-addons-for-elementor'),
                    'content_classes' => 'eael-warning',
                    'condition'       => [
                        'eael_event_calendar_type' => 'eventon',
                    ],
                ]
            );
        }
    }

    public function advanced_data_table_database_html($settings)
    {
        global $wpdb;

        $html    = '';
        $results = [];

        // suppress error
        $wpdb->suppress_errors = true;

        // collect data
        if ($settings['ea_adv_data_table_source'] == 'database') {
            if ($settings['ea_adv_data_table_source_database_query_type'] == 'table') {
                $table   = $settings["ea_adv_data_table_source_database_table"];
                $results = $wpdb->get_results("SELECT * FROM $table", ARRAY_A);
            } else {
                if (empty($settings['ea_adv_data_table_source_database_query'])) {
                    return;
                }

                $results = $wpdb->get_results($settings['ea_adv_data_table_source_database_query'], ARRAY_A);
            }

            if (is_wp_error($results)) {
                return $results->get_error_message();
            }
        } else {
            if ($settings['ea_adv_data_table_source'] == 'remote') {
                if (empty($settings['ea_adv_data_table_source_remote_host']) || empty($settings['ea_adv_data_table_source_remote_username']) || empty($settings['ea_adv_data_table_source_remote_password']) || empty($settings['ea_adv_data_table_source_remote_database'])) {
                    return;
                }

                if ($settings['ea_adv_data_table_source_remote_connected'] == false) {
                    return;
                }

                $conn = new \mysqli($settings['ea_adv_data_table_source_remote_host'],
                    $settings['ea_adv_data_table_source_remote_username'],
                    $settings['ea_adv_data_table_source_remote_password'],
                    $settings['ea_adv_data_table_source_remote_database']);

                if ($conn->connect_error) {
                    return "Failed to connect to MySQL: " . $conn->connect_error;
                } else {
                    if ($settings['ea_adv_data_table_source_remote_query_type'] == 'table') {
                        $table = $settings['ea_adv_data_table_source_remote_table'];
                        $query = $conn->query("SELECT * FROM $table");

                        if ($query) {
                            $results = $query->fetch_all(MYSQLI_ASSOC);
                        }
                    } else {
                        if ($settings['ea_adv_data_table_source_remote_query']) {
                            $query = $conn->query($settings['ea_adv_data_table_source_remote_query']);

                            if ($query) {
                                $results = $query->fetch_all(MYSQLI_ASSOC);
                            }
                        }
                    }

                    $conn->close();
                }
            }
        }

        if (!empty($results)) {
            $html .= '<thead><tr>';
            foreach (array_keys($results[0]) as $key => $th) {
                $style = isset($settings['ea_adv_data_table_dynamic_th_width']) && isset($settings['ea_adv_data_table_dynamic_th_width'][$key]) ? ' style="width:' . $settings['ea_adv_data_table_dynamic_th_width'][$key] . '"' : '';
                $html .= '<th' . $style . '>' . $th . '</th>';
            }
            $html .= '</tr></thead>';

            $html .= '<tbody>';
            foreach ($results as $tr) {
                $html .= '<tr>';
                foreach ($tr as $td) {
                    $html .= '<td>' . $td . '</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</tbody>';
        }

        // enable error reporting
        $wpdb->suppress_errors = false;

        return $html;
    }

    public function advanced_data_table_google_sheets_integration($settings)
    {
        if (empty($settings['ea_adv_data_table_source_google_api_key']) || empty($settings['ea_adv_data_table_source_google_sheet_id']) || empty($settings['ea_adv_data_table_source_google_table_range'])) {
            return;
        }

        $html       = '';
        $connection = wp_remote_get("https://sheets.googleapis.com/v4/spreadsheets/{$settings['ea_adv_data_table_source_google_sheet_id']}/values/{$settings['ea_adv_data_table_source_google_table_range']}?key={$settings['ea_adv_data_table_source_google_api_key']}");

        if (!is_wp_error($connection)) {
            $connection = json_decode(wp_remote_retrieve_body($connection), true);

            if (isset($connection['values'])) {
                $results = $connection['values'];
            }
        }

        if (!empty($results)) {
            $html .= '<thead><tr>';
            foreach ($results[0] as $key => $th) {
                $style = isset($settings['ea_adv_data_table_dynamic_th_width']) && isset($settings['ea_adv_data_table_dynamic_th_width'][$key]) ? ' style="width:' . $settings['ea_adv_data_table_dynamic_th_width'][$key] . '"' : '';
                $html .= '<th' . $style . '>' . $th . '</th>';
            }
            $html .= '</tr></thead>';

            array_shift($results);

            $html .= '<tbody>';
            foreach ($results as $tr) {
                $html .= '<tr>';
                foreach ($tr as $td) {
                    $html .= '<td>' . $td . '</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</tbody>';
        }

        return $html;
    }

    public function advanced_data_table_tablepress_integration($settings)
    {
        if (empty($settings['ea_adv_data_table_source_tablepress_table_id'])) {
            return;
        }

        $html           = '';
        $results        = [];
        $tables_opt     = get_option('tablepress_tables', '{}');
        $tables_opt     = json_decode($tables_opt, true);
        $tables         = $tables_opt['table_post'];
        $table_id       = $tables[$settings['ea_adv_data_table_source_tablepress_table_id']];
        $table_data     = get_post_field('post_content', $table_id);
        $results        = json_decode($table_data, true);
        $table_settings = get_post_meta($table_id, '_tablepress_table_options', true);
        $table_settings = json_decode($table_settings, true);

        if (!empty($results)) {
            if (!empty($table_settings) && isset($table_settings['table_head']) && $table_settings['table_head'] == true) {
                $html .= '<thead><tr>';
                foreach ($results[0] as $key => $th) {
                    $style = isset($settings['ea_adv_data_table_dynamic_th_width']) && isset($settings['ea_adv_data_table_dynamic_th_width'][$key]) ? ' style="width:' . $settings['ea_adv_data_table_dynamic_th_width'][$key] . '"' : '';
                    $html .= '<th' . $style . '>' . $th . '</th>';
                }
                $html .= '</tr></thead>';

                array_shift($results);
            }

            $html .= '<tbody>';
            foreach ($results as $tr) {
                $html .= '<tr>';
                foreach ($tr as $td) {
                    $html .= '<td>' . $td . '</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</tbody>';
        }

        return $html;
    }

    public function event_calendar_eventon_integration($data, $settings)
    {
        if (!function_exists('EVO') || $settings['eael_event_calendar_type'] != 'eventon') {
            return $data;
        }

        $default_attr                = EVO()->calendar->get_supported_shortcode_atts();
        $default_attr['event_count'] = $settings['eael_eventon_calendar_max_result'];

        if ($settings['eael_eventon_calendar_fetch'] == 'date_range') {
            $default_attr['focus_end_date_range']   = strtotime($settings['eael_eventon_calendar_end_date']);
            $default_attr['focus_start_date_range'] = strtotime($settings['eael_eventon_calendar_start_date']);
        }

        $cat_arr = $this->eael_get_taxonomies_by_post(['object_type' => 'ajde_events']);

        foreach ($cat_arr as $key => $cat) {

            $cat_id = 'eael_eventon_calendar_' . $key;

            if (!empty($settings[$cat_id])) {
                if ($cat == 'post_tag') {
                    $cat = 'event_tag';
                }
                $default_attr[$cat] = implode(',', $settings[$cat_id]);
            }
        }

        EVO()->calendar->shortcode_args = $default_attr;
        $content                        = EVO()->evo_generator->_generate_events();
        $events                         = $content['data'];

        if (!empty($events)) {
            $data = [];
            foreach ($events as $key => $event) {
                $event_id    = $event['ID'];
                $date_format = 'Y-m-d';
                $all_day     = 'yes';
                $featured    = get_post_meta($event_id, '_featured', true);

                $end = date($date_format, ($event['event_end_unix'] + 86400));
                if (get_post_meta($event_id, 'evcal_allday', true) === 'no') {
                    $date_format .= ' H:i';
                    $all_day = '';
                    $end     = date($date_format, $event['event_end_unix']);
                }

                $data[] = [
                    'id'               => $event_id,
                    'title'            => !empty($event['event_title']) ? html_entity_decode($event['event_title'],
                        ENT_QUOTES) : __('No Title', 'essential-addons-for-elementor'),
                    'description'      => $content = get_post_field('post_content', $event_id),
                    'start'            => date($date_format, $event['event_start_unix']),
                    'end'              => $end,
                    'borderColor'      => '#6231FF',
                    'textColor'        => $settings['eael_event_global_text_color'],
                    'color'            => ($featured == 'yes') ? $settings['eael_event_on_featured_color'] : $settings['eael_event_global_bg_color'],
                    'url'              => ($settings['eael_event_details_link_hide'] !== 'yes') ? get_the_permalink($key) : '',
                    'allDay'           => $all_day,
                    'external'         => 'on',
                    'nofollow'         => 'on',
                    'eventHasComplete' => get_post_meta($event_id, '_completed', true),
                    'hideEndDate'      => get_post_meta($event_id, 'evo_hide_endtime', true),
                ];
            }
        }
        return $data;
    }

	/**
	 * Woo Checkout Layout
	 */
	public function eael_woo_checkout_layout($layout) {
		if (apply_filters('eael/pro_enabled', false)) {
			$layout['multi-steps'] = __('Multi Steps', 'essential-addons-elementor');
			$layout['split'] = __('Split', 'essential-addons-elementor');
		}else{
			$layout['multi-steps'] = __('Multi Steps', 'essential-addons-elementor');
			$layout['split'] = __('Split (Pro)', 'essential-addons-elementor');
		}
		return $layout;
	}

	/**
	 * Woo Checkout Layout Template
	 */
	public function add_woo_checkout_pro_layout($checkout, $settings) {
		if ($settings['ea_woo_checkout_layout'] == 'split') {
			echo self::woo_checkout_render_split_template_($checkout, $settings);
		}elseif ($settings['ea_woo_checkout_layout'] == 'multi-steps') {
			echo self::woo_checkout_render_multi_steps_template_($checkout, $settings);
		}
	}

	/**
	 * Woo Checkout Tab Data Settings
	 */
	public function add_woo_checkout_tabs_data($obj) {

		$obj->add_control(
			'ea_woo_checkout_tabs_settings',
			[
				'label' => __( 'Tabs Label', 'essential-addons-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'ea_woo_checkout_layout!' => 'default',
				],
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tab_login_text',
			[
				'label' => __( 'Login', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Login', 'essential-addons-elementor' ),
				'condition' => [
					'ea_woo_checkout_layout!' => 'default',
				],
				'description' => 'To preview the changes in Login tab, turn on the Settings from \'Login\' section below.',
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tab_coupon_text',
			[
				'label' => __( 'Coupon', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Coupon', 'essential-addons-elementor' ),
				'condition' => [
					'ea_woo_checkout_layout!' => 'default',
				],
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tab_billing_shipping_text',
			[
				'label' => __( 'Billing & Shipping', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Billing & Shipping', 'essential-addons-elementor' ),
				'condition' => [
					'ea_woo_checkout_layout!' => 'default',
				],
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tab_payment_text',
			[
				'label' => __( 'Payment', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Payment', 'essential-addons-elementor' ),
				'condition' => [
					'ea_woo_checkout_layout!' => 'default',
				],
			]
		);

		$obj->add_control(
			'ea_woo_checkout_tabs_btn_settings',
			[
				'label' => __( 'Previous/Next Label', 'essential-addons-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'ea_woo_checkout_layout!' => 'default',
				],
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tabs_btn_next_text',
			[
				'label' => __( 'Next', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Next', 'essential-addons-elementor' ),
				'condition' => [
					'ea_woo_checkout_layout!' => 'default',
				],
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tabs_btn_prev_text',
			[
				'label' => __( 'Previous', 'essential-addons-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Previous', 'essential-addons-elementor' ),
				'condition' => [
					'ea_woo_checkout_layout!' => 'default',
				],
			]
		);
	}

	/**
	 * Woo Checkout Layout
	 */
	public function add_woo_checkout_tabs_styles($obj) {

		$obj->start_controls_section(
			'ea_section_woo_checkout_tabs_styles',
			[
				'label' => esc_html__( 'Tabs', 'essential-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ea_woo_checkout_layout!' => 'default',
				],
			]
		);

		$obj->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ea_section_woo_checkout_tabs_typo',
				'selector' => '{{WRAPPER}} .ea-woo-checkout.layout-split .layout-split-container .info-area .split-tabs li, {{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs .ms-tab',
				'fields_options' => [
					'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 16 ] ]
				],
			]
		);

		$obj->start_controls_tabs( 'ea_woo_checkout_tabs_tabs');
		$obj->start_controls_tab( 'ea_woo_checkout_tabs_tab_normal', [ 'label' => esc_html__( 'Normal', 'essential-addons-elementor' ) ] );

		$obj->add_control(
			'ea_woo_checkout_tabs_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f4f6fc',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-split .layout-split-container .info-area .split-tabs' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'ea_woo_checkout_layout' => 'split',
				],
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tabs_color',
			[
				'label' => esc_html__( 'Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#404040',
				'selectors' => [
					'{{WRAPPER}} .split-tabs li, {{WRAPPER}} .ms-tabs li' => 'color: {{VALUE}};',
				],
			]
		);

		$obj->end_controls_tab();

		$obj->start_controls_tab( 'ea_woo_checkout_tabs_tab_active', [ 'label' => esc_html__( 'Active', 'essential-addons-elementor' ) ] );

		$obj->add_control(
			'ea_woo_checkout_tabs_bg_color_active',
			[
				'label' => esc_html__( 'Background Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7866ff',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-split .layout-split-container .info-area .split-tabs li.active' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'ea_woo_checkout_layout' => 'split',
				],
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tabs_color_active',
			[
				'label' => esc_html__( 'Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-split .layout-split-container .info-area .split-tabs li.active' => 'color: {{VALUE}};',
				],
				'condition' => [
					'ea_woo_checkout_layout' => 'split',
				],
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tabs_ms_color_active',
			[
				'label' => esc_html__( 'Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7866ff',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs li.completed' => 'color: {{VALUE}};',
				],
				'condition' => [
					'ea_woo_checkout_layout' => 'multi-steps',
				],
			]
		);
		$obj->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'ea_woo_checkout_tabs_box_shadow',
				'separator' => 'before',
				'selector' => '{{WRAPPER}} .ea-woo-checkout.layout-split .layout-split-container .info-area .split-tabs li.active',
				'condition' => [
					'ea_woo_checkout_layout' => 'split',
				],
			]
		);

		$obj->end_controls_tab();
		$obj->end_controls_tabs();

		$obj->add_responsive_control(
			'ea_woo_checkout_tabs_border_radius',
			[
				'label' => __( 'Border Radius', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 05,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .split-tabs, {{WRAPPER}} .split-tab li.active' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'ea_woo_checkout_layout' => 'split',
				],
			]
		);
		$obj->add_responsive_control(
			'ea_woo_checkout_tabs_padding',
			[
				'label' => esc_html__( 'Padding', 'essential-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '17',
					'right' => '17',
					'bottom' => '17',
					'left' => '17',
					'unit' => 'px',
					'isLinked' => true,
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-split .layout-split-container .info-area .split-tabs li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'ea_woo_checkout_layout' => 'split',
				],
			]
		);

		$obj->add_responsive_control(
			'ea_woo_checkout_tabs_bottom_gap',
			[
				'label' => esc_html__( 'Bottom Gap', 'essential-addons-for-elementor-lite' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs' => 'margin: 0 0 {{SIZE}}{{UNIT}} 0;',
				],
				'condition' => [
					'ea_woo_checkout_layout' => 'multi-steps',
				],
			]
		);
		// multi steps
		$obj->add_control(
			'ea_woo_checkout_tabs_steps',
			[
				'label' => __( 'Steps', 'essential-addons-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'ea_woo_checkout_layout' => 'multi-steps',
				],
			]
		);
		$obj->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ea_section_woo_checkout_tabs_steps_typo',
				'selector' => '{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs li:before',
				'fields_options' => [
					'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 12 ] ]
				],
				'condition' => [
					'ea_woo_checkout_layout' => 'multi-steps',
				],
			]
		);
		$obj->start_controls_tabs( 'ea_woo_checkout_tabs_steps_tabs',
			[
				'condition' => [
					'ea_woo_checkout_layout' => 'multi-steps',
				],
			]
		);
		$obj->start_controls_tab( 'ea_woo_checkout_tabs_steps_tab_normal', [ 'label' => esc_html__( 'Normal', 'essential-addons-elementor' ) ] );
		$obj->add_control(
			'ea_woo_checkout_tabs_steps_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d3c9f7',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs li:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tabs_steps_color',
			[
				'label' => esc_html__( 'Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7866FF',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs li:before' => 'color: {{VALUE}};',
				],
			]
		);
		$obj->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'ea_woo_checkout_tabs_steps_border',
				'selector' => '{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs li:before',
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tabs_steps_connector_color',
			[
				'label' => esc_html__( 'Connector Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d3c9f7',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs li:after' => 'background-color: {{VALUE}};',
				],
			]
		);
		$obj->end_controls_tab();
		$obj->start_controls_tab( 'ea_woo_checkout_tabs_steps_tab_active', [ 'label' => esc_html__( 'Active', 'essential-addons-elementor' ) ] );
		$obj->add_control(
			'ea_woo_checkout_tabs_steps_bg_color_active',
			[
				'label' => esc_html__( 'Background Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7866ff',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs li.completed:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tabs_steps_color_active',
			[
				'label' => esc_html__( 'Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs li.completed:before' => 'color: {{VALUE}};',
				],
			]
		);
		$obj->add_control(
			'ea_woo_checkout_tabs_steps_connector_color_active',
			[
				'label' => esc_html__( 'Connector Color', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7866ff',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs li.completed:after' => 'background-color: {{VALUE}};',
				],
			]
		);
		$obj->end_controls_tab();
		$obj->end_controls_tabs();
		$obj->add_responsive_control(
			'ea_woo_checkout_tabs_steps_size',
			[
				'label' => __( 'Size', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 25,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs li:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs li:after' => 'top: calc(({{SIZE}}{{UNIT}}/2) - 2px);',
				],
				'condition' => [
					'ea_woo_checkout_layout' => 'multi-steps',
				],
			]
		);
		$obj->add_responsive_control(
			'ea_woo_checkout_tabs_steps_border_radius',
			[
				'label' => __( 'Border Radius', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs li:before' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'ea_woo_checkout_layout' => 'multi-steps',
				],
			]
		);

		$obj->end_controls_section();
	}

	/**
	 * Woo Checkout section
	 */
	public function add_woo_checkout_section_styles($obj) {

		$obj->start_controls_section(
			'ea_section_woo_checkout_section_styles',
			[
				'label' => esc_html__( 'Section', 'essential-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ea_woo_checkout_layout' => 'multi-steps',
				],
			]
		);
		$obj->add_control(
			'ea_woo_checkout_section_bg_color',
			[
				'label' => esc_html__( 'Background', 'essential-addons-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ms-tabs-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$obj->add_responsive_control(
			'ea_woo_checkout_section_border_radius',
			[
				'label' => __( 'Border Radius', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 05,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ms-tabs-content' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$obj->add_responsive_control(
			'ea_woo_checkout_section_padding',
			[
				'label' => esc_html__( 'Padding', 'essential-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '25',
					'right' => '25',
					'bottom' => '25',
					'left' => '25',
					'unit' => 'px',
					'isLinked' => true,
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ms-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$obj->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'ea_woo_checkout_section_box_shadow',
				'separator' => 'before',
				'selector' => '{{WRAPPER}} .ea-woo-checkout.layout-multi-steps .layout-multi-steps-container .ms-tabs-content-wrap .ms-tabs-content',
			]
		);

		$obj->end_controls_section();
	}

	/**
	 * Woo Checkout Tab Data Style
	 */
	public function add_woo_checkout_steps_btn_styles($obj) {

		$obj->start_controls_section(
			'ea_section_woo_checkout_steps_btn_styles',
			[
				'label' => esc_html__( 'Previous/Next Button', 'essential-addons-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ea_woo_checkout_layout!' => 'default',
				],
			]
		);

		$obj->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ea_woo_checkout_steps_btn_typo',
				'selector' => '{{WRAPPER}} .steps-buttons button',
			]
		);
		$obj->start_controls_tabs( 'ea_woo_checkout_steps_btn_tabs' );
		$obj->start_controls_tab( 'ea_woo_checkout_steps_btn_tab_normal', [ 'label' => __( 'Normal', 'essential-addons-for-elementor-lite' ), ] );

		$obj->add_control(
			'ea_woo_checkout_steps_btn_bg_color',
			[
				'label' => __( 'Background Color', 'essential-addons-for-elementor-lite' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7866ff',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout .steps-buttons button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$obj->add_control(
			'ea_woo_checkout_steps_btn_color',
			[
				'label' => __( 'Color', 'essential-addons-for-elementor-lite' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout .steps-buttons button' => 'color: {{VALUE}};',
				],
			]
		);

		$obj->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'ea_woo_checkout_steps_btn_border',
				'selector' => '{{WRAPPER}} .ea-woo-checkout .steps-buttons button',
			]
		);

		$obj->end_controls_tab();

		$obj->start_controls_tab( 'ea_woo_checkout_steps_btn_tab_hover', [ 'label' => __( 'Hover', 'essential-addons-for-elementor-lite' ), ] );

		$obj->add_control(
			'ea_woo_checkout_steps_btn_bg_color_hover',
			[
				'label' => __( 'Background Color', 'essential-addons-for-elementor-lite' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7866ff',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout .steps-buttons button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$obj->add_control(
			'ea_woo_checkout_steps_btn_color_hover',
			[
				'label' => __( 'Color', 'essential-addons-for-elementor-lite' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout .steps-buttons button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$obj->add_control(
			'ea_woo_checkout_steps_btn_border_color_hover',
			[
				'label' => __( 'Border Color', 'essential-addons-for-elementor-lite' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout .steps-buttons button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'ea_section_woo_checkout_steps_btn_border_border!' => '',
				],
			]
		);

		$obj->end_controls_tab();
		$obj->end_controls_tabs();

		$obj->add_control(
			'ea_woo_checkout_steps_btn_border_radius',
			[
				'label' => __( 'Border Radius', 'essential-addons-for-elementor-lite' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '5',
					'right' => '5',
					'bottom' => '5',
					'left' => '5',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .ea-woo-checkout .steps-buttons button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$obj->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'ea_woo_checkout_steps_btn_box_shadow',
				'selector' => '{{WRAPPER}} .ea-woo-checkout .steps-buttons button',
			]
		);
		$obj->add_responsive_control(
			'ea_woo_checkout_steps_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'essential-addons-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '13',
					'right' => '20',
					'bottom' => '13',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .steps-buttons button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$obj->add_responsive_control(
			'ea_woo_checkout_steps_btn_align',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],
					'space-between' => [
						'title' => __( 'Justified', 'elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .steps-buttons' => 'justify-content: {{VALUE}};',
				],
			]
		);
		$obj->add_responsive_control(
			'ea_woo_checkout_steps_btn_gap',
			[
				'label' => __( 'Gap', 'essential-addons-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .steps-buttons button:first-child' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2);',
					'{{WRAPPER}} .steps-buttons button:last-child' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2);',
				],
			]
		);

		$obj->end_controls_section();
	}
}