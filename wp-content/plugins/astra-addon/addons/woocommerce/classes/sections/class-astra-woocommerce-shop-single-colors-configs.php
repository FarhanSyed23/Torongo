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

if ( ! class_exists( 'Astra_Woocommerce_Shop_Single_Colors_Configs' ) ) {

	/**
	 * Register Woocommerce Shop Single Color Layout Configurations.
	 */
	class Astra_Woocommerce_Shop_Single_Colors_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Woocommerce Shop Single Color Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: WooCommerce single page Colors Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[woo-single-page-divider]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'section'  => 'section-woo-shop-single',
					'title'    => __( 'colors', 'astra-addon' ),
					'settings' => array(),
					'priority' => 80,
					'required' => array( ASTRA_THEME_SETTINGS . '[shop-product-structure]', 'contains', 'title' ),
				),

				/**
				 * Group: WooCommerce single page Colors Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[woo-single-page-color-group]',
					'default'   => astra_get_option( 'woo-single-page-color-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Colors', 'astra-addon' ),
					'section'   => 'section-woo-shop-single',
					'transport' => 'postMessage',
					'required'  => array( ASTRA_THEME_SETTINGS . '[single-product-structure]', 'contains', 'title' ),
					'priority'  => 80,
				),

				/**
				 * Single Product Title Color
				 */
				array(
					'name'      => 'single-product-title-color',
					'default'   => '',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[woo-single-page-color-group]',
					'section'   => 'section-woo-shop-single',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'title'     => __( 'Title Color', 'astra-addon' ),
				),

				/**
				 * Single Product Price Color
				 */
				array(
					'name'      => 'single-product-price-color',
					'default'   => '',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[woo-single-page-color-group]',
					'section'   => 'section-woo-shop-single',
					'title'     => __( 'Price Color', 'astra-addon' ),
				),

				/**
				 * Single Product Content Color
				 */
				array(
					'name'      => 'single-product-content-color',
					'default'   => '',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[woo-single-page-color-group]',
					'section'   => 'section-woo-shop-single',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'title'     => __( 'Content Color', 'astra-addon' ),
				),

				/**
				 * Single Product Breadcrumb Color
				 */
				array(
					'name'      => 'single-product-breadcrumb-color',
					'default'   => '',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[woo-single-page-color-group]',
					'section'   => 'section-woo-shop-single',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'title'     => __( 'Breadcrumb Color', 'astra-addon' ),
				),
			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;

		}
	}
}


new Astra_Woocommerce_Shop_Single_Colors_Configs();





