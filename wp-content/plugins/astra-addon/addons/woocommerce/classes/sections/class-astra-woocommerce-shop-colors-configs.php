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

if ( ! class_exists( 'Astra_Woocommerce_Shop_Colors_Configs' ) ) {

	/**
	 * Register Blog Single Layout Configurations.
	 */
	class Astra_Woocommerce_Shop_Colors_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Blog Single Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: WooCommerce Shop Colors Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[woo-shop-color-divider]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'colors', 'astra-addon' ),
					'settings' => array(),
					'priority' => 228,
					'required' => array( ASTRA_THEME_SETTINGS . '[shop-product-structure]', 'contains', 'title' ),
				),

				/**
				 * Group: WooCommerce Shop Colors Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[shop-color-group]',
					'default'   => astra_get_option( 'shop-color-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Colors', 'astra-addon' ),
					'section'   => 'woocommerce_product_catalog',
					'transport' => 'postMessage',
					'required'  => array( ASTRA_THEME_SETTINGS . '[shop-product-structure]', 'contains', 'title' ),
					'priority'  => 228,
				),

				/**
				 * Shop Product Title Color
				 */
				array(
					'name'      => 'shop-product-title-color',
					'default'   => '',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[shop-color-group]',
					'section'   => 'woocommerce_product_catalog',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'title'     => __( 'Product Title Color', 'astra-addon' ),
				),

				/**
				 * Shop Product Price Color
				 */
				array(
					'name'      => 'shop-product-price-color',
					'default'   => '',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[shop-color-group]',
					'section'   => 'woocommerce_product_catalog',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'title'     => __( 'Product Price Color', 'astra-addon' ),
				),

				/**
				 * Shop Product Content Color
				 */
				array(
					'name'      => 'shop-product-content-color',
					'default'   => '',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[shop-color-group]',
					'section'   => 'woocommerce_product_catalog',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'title'     => __( 'Product Content Color', 'astra-addon' ),
				),
			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;

		}
	}
}


new Astra_Woocommerce_Shop_Colors_Configs();





