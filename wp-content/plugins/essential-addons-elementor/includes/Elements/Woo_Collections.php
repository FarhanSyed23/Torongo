<?php
namespace Essential_Addons_Elementor\Pro\Elements;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Scheme_Typography;
use \Elementor\Utils;
use \Elementor\Widget_Base;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

class Woo_Collections extends Widget_Base
{

    use \Essential_Addons_Elementor\Traits\Helper;
    use \Essential_Addons_Elementor\Pro\Traits\Helper;

    public function get_name()
    {
        return 'eael-woo-collections';
    }

    public function get_title()
    {
        return esc_html__('Woo Product Collections', 'essential-addons-elementor');
    }

    public function get_icon()
    {
        return 'eaicon-woo-product-collections';
    }

    public function get_categories()
    {
        return ['essential-addons-elementor'];
    }

    public function get_keywords()
    {
        return [
            'woo product collections',
            'ea woo product collections',
            'woocommerce product collections',
            'ea woocommerce product collections',
            'ecommerce product collections',
            'woocommerce',
            'product list',
            'woo',
            'product feed',
            'ecommerce',
            'ea',
            'essential addons',
        ];
    }

    public function get_custom_help_url()
    {
        return 'https://essential-addons.com/elementor/docs/ea-woo-product-collections/';
    }

    protected function _register_controls()
    {
        /**
         * General Settings
         */
        $this->start_controls_section(
            'eael_woo_collections_section_general',
            [
                'label' => esc_html__('General', 'essential-addons-elementor'),
            ]
        );

        if (!apply_filters('eael/active_plugins', 'woocommerce/woocommerce.php')) {
            $this->add_control(
                'ea_woo_collections_woo_required',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => __('<strong>WooCommerce</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=woocommerce&tab=search&type=term" target="_blank">WooCommerce</a> first.', 'essential-addons-for-elementor-lite'),
                    'content_classes' => 'eael-warning',
                ]
            );
        }

        $this->add_control(
            'eael_woo_collections_type',
            [
                'label'       => esc_html__('Collection Type', 'essential-addons-elementor'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'category',
                'label_block' => false,
                'options'     => [
                    'category'   => esc_html__('Cateogry', 'essential-addons-elementor'),
                    'tags'       => esc_html__('Tags', 'essential-addons-elementor'),
                    'attributes' => esc_html__('Attributes', 'essential-addons-elementor'),
                ],
            ]
        );

        $this->add_control(
            'eael_woo_collections_category',
            [
                'label'       => esc_html__('Cateogry', 'essential-addons-elementor'),
                'type'        => Controls_Manager::SELECT,
                'label_block' => false,
                'options'     => $this->eael_woocommerce_product_categories_by_id(),
                'condition'   => [
                    'eael_woo_collections_type' => 'category',
                ],
            ]
        );

        $this->add_control(
            'eael_woo_collections_tags',
            [
                'label'       => esc_html__('Tag', 'essential-addons-elementor'),
                'type'        => Controls_Manager::SELECT,
                'label_block' => false,
                'options'     => $this->eael_get_woo_product_tags(),
                'condition'   => [
                    'eael_woo_collections_type' => 'tags',
                ],
            ]
        );

        $this->add_control(
            'eael_woo_collections_attributes',
            [
                'label'       => esc_html__('Attribute', 'essential-addons-elementor'),
                'type'        => Controls_Manager::SELECT,
                'label_block' => false,
                'options'     => $this->eael_get_woo_product_atts(),
                'condition'   => [
                    'eael_woo_collections_type' => 'attributes',
                ],
            ]
        );

        $this->add_control(
            'eael_woo_collections_bg_img',
            [
                'label'     => __('Background Image', 'essential-addons-elementor'),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'eael_woo_collections_subtitle',
            [
                'label'     => __('Subtitle', 'essential-addons-elementor'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Collections', 'essential-addons-elementor'),
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /**
         * Style: General
         */
        $this->start_controls_section(
            'eael_woo_collections_section_style_general',
            [
                'label' => esc_html__('General', 'essential-addons-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'eael_woo_collections_overlay_bg',
            [
                'label'     => __('Overlay Background', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#0000004d',
                'selectors' => [
                    '{{WRAPPER}} .eael-woo-collections-overlay' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'eael_woo_collections_overlay_bg_hover',
            [
                'label'     => __('Overlay Background Hover', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#00000080',
                'selectors' => [
                    '{{WRAPPER}} .eael-woo-collections-overlay:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'eael_woo_collections_overlay_content_hr',
            [
                'label'       => esc_html__('Horizontal Align', 'essential-addons-elementor'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'eael-woo-collections-overlay-left',
                'label_block' => false,
                'options'     => [
                    'eael-woo-collections-overlay-left'   => esc_html__('Left', 'essential-addons-elementor'),
                    'eael-woo-collections-overlay-center' => esc_html__('Center', 'essential-addons-elementor'),
                    'eael-woo-collections-overlay-right'  => esc_html__('Right', 'essential-addons-elementor'),
                ],
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'eael_woo_collections_overlay_content_vr',
            [
                'label'       => esc_html__('Vertical Align', 'essential-addons-elementor'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'eael-woo-collections-overlay-inner-bottom',
                'label_block' => false,
                'options'     => [
                    'eael-woo-collections-overlay-inner-top'    => esc_html__('Top', 'essential-addons-elementor'),
                    'eael-woo-collections-overlay-inner-middle' => esc_html__('Middle', 'essential-addons-elementor'),
                    'eael-woo-collections-overlay-inner-bottom' => esc_html__('Bottom', 'essential-addons-elementor'),
                ],
            ]
        );

        $this->add_control(
            'eael_woo_collections_bg_hover_effect',
            [
                'label'       => esc_html__('Image Hover Effect', 'essential-addons-elementor'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'eael-woo-collections-bg-hover-zoom-in',
                'label_block' => false,
                'options'     => [
                    'eael-woo-collections-bg-hover-none'     => esc_html__('None', 'essential-addons-elementor'),
                    'eael-woo-collections-bg-hover-zoom-in'  => esc_html__('ZoomIn', 'essential-addons-elementor'),
                    'eael-woo-collections-bg-hover-zoom-out' => esc_html__('ZoomOut', 'essential-addons-elementor'),
                    'eael-woo-collections-bg-hover-blur'     => esc_html__('Blur', 'essential-addons-elementor'),
                ],
                'separator'   => 'before',
            ]
        );

        $this->end_controls_section();

        /**
         * Style: General
         */
        $this->start_controls_section(
            'eael_woo_collections_section_style_typography',
            [
                'label' => esc_html__('Typography', 'essential-addons-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'eael_woo_collections_title_typography',
                'label'    => __('Title', 'essential-addons-elementor'),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eael-woo-collections-overlay-inner h2',
            ]
        );

        $this->add_control(
            'eael_woo_collections_title_color',
            [
                'label'     => __('Title Color', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-woo-collections-overlay-inner h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'eael_woo_collections_title_color_hover',
            [
                'label'     => __('Title Color Hover', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-woo-collections:hover .eael-woo-collections-overlay-inner h2' => 'color: {{VALUE}}',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'eael_woo_collections_span_typography',
                'label'     => __('Subtitle', 'essential-addons-elementor'),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .eael-woo-collections-overlay-inner span',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'eael_woo_collections_span_color',
            [
                'label'     => __('Subtitle Color', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-woo-collections-overlay-inner span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'eael_woo_collections_title_span_hover',
            [
                'label'     => __('Subtitle Color Hover', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .eael-woo-collections:hover .eael-woo-collections-overlay-inner span' => 'color: {{VALUE}}',
                ],
                'separator' => 'after',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings();

        if (!apply_filters('eael/active_plugins', 'woocommerce/woocommerce.php')) {
            return;
        }

        if ($settings['eael_woo_collections_type'] == 'category' && $settings['eael_woo_collections_category']) {
            $term = get_term($settings['eael_woo_collections_category']);
        } else if ($settings['eael_woo_collections_type'] == 'tags' && $settings['eael_woo_collections_tags']) {
            $term = get_term($settings['eael_woo_collections_tags']);
        } else if ($settings['eael_woo_collections_type'] == 'attributes' && $settings['eael_woo_collections_attributes']) {
            $term = get_term($settings['eael_woo_collections_attributes']);
        }

        $link = (!is_wp_error($term) && isset($term)) ? get_term_link($term) : '#';
        $name = (!is_wp_error($term) && isset($term)) ? $term->name : __('Collection Name', 'essential-addons-elementor');

        $this->add_render_attribute('eael-woo-collections-bg', [
            'class' => ['eael-woo-collections-bg', $settings['eael_woo_collections_bg_hover_effect']],
            'src'   => $settings['eael_woo_collections_bg_img']['url'],
            'alt'   => esc_attr(get_post_meta($settings['eael_woo_collections_bg_img']['id'], '_wp_attachment_image_alt', true)),
        ]);

        echo '<div class="eael-woo-collections">
            <a href="' . $link . '">
				<img ' . $this->get_render_attribute_string('eael-woo-collections-bg') . '>
				<div class="eael-woo-collections-overlay ' . $settings['eael_woo_collections_overlay_content_hr'] . '">
					<div class="eael-woo-collections-overlay-inner ' . $settings['eael_woo_collections_overlay_content_vr'] . '">
						<span>' . sprintf(esc_html__('%s', 'essential-addons-elementor'), ($settings['eael_woo_collections_subtitle'] ?: '')) . '</span>
						<h2>' . sprintf(esc_html__('%s', 'essential-addons-elementor'), $name) . '</h2>
					</div>
				</div>
			</a>
		</div>';
    }
}
