<?php
/**
 * Shop Options for our theme.
 *
 * @package     Astra Addon
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2020, Brainstorm Force
 * @link        https://www.brainstormforce.com
 * @since       Astra 1.4.3
 */

// Block direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bail if Customizer config base class does not exist.
if ( ! class_exists( 'Astra_Customizer_Config_Base' ) ) {
	return;
}

if ( ! class_exists( 'Astra_Woocommerce_Shop_Configs' ) ) {

	/**
	 * Register Woocommerce Shop Layout Configurations.
	 */
	class Astra_Woocommerce_Shop_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Woocommerce Shop Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Choose Product Style
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-style]',
					'default'  => astra_get_option( 'shop-style' ),
					'type'     => 'control',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'Layout', 'astra-addon' ),
					'control'  => 'ast-radio-image',
					'priority' => 10,
					'choices'  => array(
						'shop-page-grid-style' => array(
							'label' => __( 'Grid View', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g></g><g><g><path fill="#0586BB" d="M93.548,38.73c0,0.977-0.823,1.77-1.84,1.77H28.79c-1.016,0-1.838-0.793-1.838-1.77V20.037 c0-0.977,0.822-1.77,1.838-1.77h62.918c1.017,0,1.84,0.793,1.84,1.77V38.73z"/></g><g><path fill="#0586BB" d="M91.846,53.198H28.655c-0.807,0-1.456-0.692-1.456-1.541s0.649-1.541,1.456-1.541h63.191 c0.805,0,1.454,0.692,1.454,1.541C93.301,52.506,92.65,53.198,91.846,53.198z"/></g><g><path fill="#0586BB" d="M87.941,62.732H32.766c-0.808,0-1.456-0.691-1.456-1.541s0.648-1.541,1.456-1.541h55.177 c0.808,0,1.457,0.691,1.457,1.541S88.75,62.732,87.941,62.732z"/></g></g></g></svg>',
						),
						'shop-page-list-style' => array(
							'label' => __( 'List View', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M0.25,77.247V3.753c0-1.957,1.593-3.549,3.549-3.549h112.902c1.957,0,3.549,1.592,3.549,3.549v73.494 c0,1.957-1.592,3.549-3.549,3.549H3.799C1.843,80.796,0.25,79.204,0.25,77.247z M3.799,1.979c-0.979,0-1.773,0.795-1.773,1.774 v73.494c0,0.976,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.793,1.773-1.772V3.753c0-0.977-0.795-1.774-1.773-1.774H3.799 z"/></g></g></g><g><g><g><path fill="#0085BA" d="M99.371,42.385h-31.36c-0.874,0-1.583-0.708-1.583-1.582c0-0.873,0.709-1.582,1.583-1.582h31.36 c0.873,0,1.58,0.709,1.58,1.582C100.951,41.677,100.243,42.385,99.371,42.385z"/></g><g><path fill="#0085BA" d="M99.371,31.667h-31.36c-0.874,0-1.583-0.708-1.583-1.582c0-0.873,0.709-1.582,1.583-1.582h31.36 c0.873,0,1.58,0.709,1.58,1.582S100.243,31.667,99.371,31.667z"/></g><g><path fill="#0085BA" d="M99.371,53.104H75.012c-0.875,0-1.584-0.709-1.584-1.582s0.709-1.582,1.584-1.582h24.359 c0.873,0,1.58,0.709,1.58,1.582S100.243,53.104,99.371,53.104z"/></g></g><g><path fill="#0085BA" d="M53.611,59.336c0,1.217-0.987,2.203-2.204,2.203H21.753c-1.217,0-2.204-0.986-2.204-2.203v-37.67 c0-1.217,0.987-2.205,2.204-2.205h29.654c1.217,0,2.204,0.987,2.204,2.205V59.336z"/></g></g></g></svg>',
						),
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-box-styling]',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'Product Styling', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-heading',
					'priority' => 75,
					'settings' => array(),
				),

				/**
				 * Option: Content Alignment
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[shop-product-align]',
					'default'   => astra_get_option( 'shop-product-align' ),
					'type'      => 'control',
					'transport' => 'postMessage',
					'control'   => 'select',
					'section'   => 'woocommerce_product_catalog',
					'priority'  => 80,
					'title'     => __( 'Content Alignment', 'astra-addon' ),
					'choices'   => array(
						'align-left'   => __( 'Left', 'astra-addon' ),
						'align-center' => __( 'Center', 'astra-addon' ),
						'align-right'  => __( 'Right', 'astra-addon' ),
					),
				),

				/**
				 * Option: Box shadow
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[shop-product-shadow]',
					'default'     => astra_get_option( 'shop-product-shadow' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'control'     => 'ast-slider',
					'title'       => __( 'Box Shadow', 'astra-addon' ),
					'section'     => 'woocommerce_product_catalog',
					'suffix'      => '',
					'priority'    => 85,
					'input_attrs' => array(
						'min'  => 0,
						'step' => 1,
						'max'  => 5,
					),
				),

				/**
				 * Option: Box hover shadow
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[shop-product-shadow-hover]',
					'default'     => astra_get_option( 'shop-product-shadow-hover' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'control'     => 'ast-slider',
					'title'       => __( 'Box Hover Shadow', 'astra-addon' ),
					'section'     => 'woocommerce_product_catalog',
					'suffix'      => '',
					'priority'    => 90,
					'input_attrs' => array(
						'min'  => 0,
						'step' => 1,
						'max'  => 5,
					),
				),

				/**
				 * Option: Product Hover Style
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-hover-style]',
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'woocommerce_product_catalog',
					'default'  => astra_get_option( 'shop-hover-style' ),
					'priority' => 90,
					'title'    => __( 'Product Image Hover Style', 'astra-addon' ),
					'choices'  => apply_filters(
						'astra_woo_shop_hover_style',
						array(
							''     => __( 'None', 'astra-addon' ),
							'swap' => __( 'Swap Images', 'astra-addon' ),
						)
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-button-divider]',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'Button', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-heading',
					'priority' => 110,
					'settings' => array(),
				),

				/**
				 * Option: Vertical Padding
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[shop-button-v-padding]',
					'default'     => astra_get_option( 'shop-button-v-padding' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'section'     => 'woocommerce_product_catalog',
					'title'       => __( 'Vertical Padding', 'astra-addon' ),
					'control'     => 'ast-slider',
					'priority'    => 110,
					'input_attrs' => array(
						'min'  => 1,
						'step' => 1,
						'max'  => 200,
					),
				),

				/**
				 * Option: Horizontal Padding
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[shop-button-h-padding]',
					'default'     => astra_get_option( 'shop-button-h-padding' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'section'     => 'woocommerce_product_catalog',
					'priority'    => 110,
					'title'       => __( 'Horizontal Padding', 'astra-addon' ),
					'control'     => 'ast-slider',
					'input_attrs' => array(
						'min'  => 1,
						'step' => 1,
						'max'  => 200,
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-pagination-divider]',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'Pagination', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-heading',
					'priority' => 140,
					'settings' => array(),
				),

				/**
				 * Option: Shop Pagination
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-pagination]',
					'default'  => astra_get_option( 'shop-pagination' ),
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'woocommerce_product_catalog',
					'priority' => 145,
					'title'    => __( 'Shop Pagination', 'astra-addon' ),
					'choices'  => array(
						'number'   => __( 'Number', 'astra-addon' ),
						'infinite' => __( 'Infinite Scroll', 'astra-addon' ),
					),
				),

				/**
				 * Option: Shop Pagination Style
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[shop-pagination-style]',
					'default'   => astra_get_option( 'shop-pagination-style' ),
					'type'      => 'control',
					'transport' => 'postMessage',
					'control'   => 'select',
					'section'   => 'woocommerce_product_catalog',
					'required'  => array( ASTRA_THEME_SETTINGS . '[shop-pagination]', '==', 'number' ),
					'priority'  => 150,
					'title'     => __( 'Shop Pagination Style', 'astra-addon' ),
					'choices'   => array(
						'default' => __( 'Default', 'astra-addon' ),
						'square'  => __( 'Square', 'astra-addon' ),
						'circle'  => __( 'Circle', 'astra-addon' ),
					),
				),

				/**
				 * Option: Event to Trigger Infinite Loading
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[shop-infinite-scroll-event]',
					'default'     => astra_get_option( 'shop-infinite-scroll-event' ),
					'type'        => 'control',
					'control'     => 'select',
					'section'     => 'woocommerce_product_catalog',
					'description' => __( 'Infinite Scroll cannot be previewed in the Customizer.', 'astra-addon' ),
					'required'    => array( ASTRA_THEME_SETTINGS . '[shop-pagination]', '==', 'infinite' ),
					'priority'    => 155,
					'title'       => __( 'Event to Trigger Infinite Loading', 'astra-addon' ),
					'choices'     => array(
						'scroll' => __( 'Scroll', 'astra-addon' ),
						'click'  => __( 'Click', 'astra-addon' ),
					),
				),

				/**
				 * Option: Read more text
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[shop-load-more-text]',
					'default'   => astra_get_option( 'shop-load-more-text' ),
					'type'      => 'control',
					'transport' => 'postMessage',
					'section'   => 'woocommerce_product_catalog',
					'priority'  => 160,
					'title'     => __( 'Load More Text', 'astra-addon' ),
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[shop-pagination]', '==', 'infinite' ),
							array( ASTRA_THEME_SETTINGS . '[shop-infinite-scroll-event]', '==', 'click' ),
						),
					),
					'control'   => 'text',
					'partial'   => array(
						'selector'            => '.ast-shop-pagination-infinite .ast-shop-load-more',
						'container_inclusive' => false,
						'render_callback'     => array( 'Astra_Customizer_Ext_WooCommerce_Partials', '_render_shop_load_more' ),
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-meta-divider]',
					'section'  => 'woocommerce_product_catalog',
					'type'     => 'control',
					'control'  => 'ast-divider',
					'priority' => 29,
					'settings' => array(),
				),

				/**
				 * Option: Display Page Title
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-page-title-display]',
					'default'  => astra_get_option( 'shop-page-title-display' ),
					'type'     => 'control',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'Display Page Title', 'astra-addon' ),
					'priority' => 29,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Display Breadcrumb
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-breadcrumb-display]',
					'default'  => astra_get_option( 'shop-breadcrumb-display' ),
					'type'     => 'control',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'Display Breadcrumb', 'astra-addon' ),
					'priority' => 29,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Display Toolbar
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-toolbar-display]',
					'default'  => astra_get_option( 'shop-toolbar-display' ),
					'type'     => 'control',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'Display Toolbar', 'astra-addon' ),
					'priority' => 29,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-filters-off-canvas-divider]',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'Off Canvas Sidebar', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-heading',
					'priority' => 195,
					'settings' => array(),
				),

				/**
				 * Option: Display Off Canvas On Click Of
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-off-canvas-trigger-type]',
					'default'  => astra_get_option( 'shop-off-canvas-trigger-type' ),
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'woocommerce_product_catalog',
					'priority' => 200,
					'title'    => __( 'Trigger for Off Canvas Sidebar', 'astra-addon' ),
					'choices'  => array(
						'disable'      => __( 'Disable', 'astra-addon' ),
						'link'         => __( 'Link', 'astra-addon' ),
						'button'       => __( 'Button', 'astra-addon' ),
						'custom-class' => __( 'Custom Class', 'astra-addon' ),
					),
				),

				/**
				 * Option: Filter Button Text
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-filter-trigger-link]',
					'default'  => astra_get_option( 'shop-filter-trigger-link' ),
					'type'     => 'control',
					'section'  => 'woocommerce_product_catalog',
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[shop-off-canvas-trigger-type]', '==', 'button' ),
							array( ASTRA_THEME_SETTINGS . '[shop-off-canvas-trigger-type]', '==', 'link' ),
						),
						'operator'   => 'OR',
					),
					'priority' => 205,
					'title'    => __( 'Off Canvas Button/Link Text', 'astra-addon' ),
					'control'  => 'text',
				),

				/**
				 * Option: Custom Class
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-filter-trigger-custom-class]',
					'default'  => astra_get_option( 'shop-filter-trigger-custom-class' ),
					'type'     => 'control',
					'section'  => 'woocommerce_product_catalog',
					'required' => array( ASTRA_THEME_SETTINGS . '[shop-off-canvas-trigger-type]', '==', 'custom-class' ),
					'priority' => 210,
					'title'    => __( 'Custom Class', 'astra-addon' ),
					'control'  => 'text',
				),

				/**
				 * Option: Display Active Filters
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-active-filters-display]',
					'default'  => astra_get_option( 'shop-active-filters-display' ),
					'type'     => 'control',
					'section'  => 'woocommerce_product_catalog',
					'required' => array( ASTRA_THEME_SETTINGS . '[shop-off-canvas-trigger-type]', '!=', 'disable' ),
					'title'    => __( 'Display Active Filters', 'astra-addon' ),
					'priority' => 215,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-quick-view-divider]',
					'section'  => 'woocommerce_product_catalog',
					'type'     => 'control',
					'control'  => 'ast-divider',
					'priority' => 190,
					'settings' => array(),
				),

				/**
				 * Option: Enable Quick View
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-quick-view-enable]',
					'default'  => astra_get_option( 'shop-quick-view-enable' ),
					'type'     => 'control',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'Quick View', 'astra-addon' ),
					'control'  => 'select',
					'priority' => 190,
					'choices'  => array(
						'disabled'       => __( 'Disabled', 'astra-addon' ),
						'on-image'       => __( 'On Image', 'astra-addon' ),
						'on-image-click' => __( 'On Image Click', 'astra-addon' ),
						'after-summary'  => __( 'After Summary', 'astra-addon' ),
					),
				),

				/**
				 * Option: Stick Quick View
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[shop-quick-view-stick-cart]',
					'default'     => astra_get_option( 'shop-quick-view-stick-cart' ),
					'type'        => 'control',
					'section'     => 'woocommerce_product_catalog',
					'title'       => __( 'Stick Add to Cart Button', 'astra-addon' ),
					'description' => __( 'If contents of the popup is larger then the button will stick at the end of the popup.', 'astra-addon' ),
					'control'     => 'checkbox',
					'priority'    => 190,
					'required'    => array( ASTRA_THEME_SETTINGS . '[shop-quick-view-enable]', '!=', 'disabled' ),
				),
			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;

		}
	}
}


new Astra_Woocommerce_Shop_Configs();





