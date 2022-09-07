<?php
/**
 * Shop Options for our theme.
 *
 * @package     Astra Addon
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2020, Brainstorm Force
 * @link        https://www.brainstormforce.com
 * @since       Astra 1.6.10
 */

// Block direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bail if Customizer config base class does not exist.
if ( ! class_exists( 'Astra_Customizer_Config_Base' ) ) {
	return;
}

if ( ! class_exists( 'Astra_Edd_Single_Colors_Configs' ) ) {

	/**
	 * Register Easy Digital Downloads Shop Single Color Layout Configurations.
	 */
	class Astra_Edd_Single_Colors_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Easy Digital Downloads Shop Single Color Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.6.10
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Single Product Title Color
				 */
				array(
					'name'      => 'edd-single-product-title-color',
					'parent'    => ASTRA_THEME_SETTINGS . '[edd-single-product-colors]',
					'section'   => 'section-edd-single',
					'default'   => '',
					'type'      => 'sub-control',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'required'  => array( ASTRA_THEME_SETTINGS . '[edd-single-product-structure]', 'contains', 'title' ),
					'title'     => __( 'Product Title Color', 'astra-addon' ),
				),

				/**
				 * Single Product Content Color
				 */
				array(
					'name'      => 'edd-single-product-content-color',
					'parent'    => ASTRA_THEME_SETTINGS . '[edd-single-product-colors]',
					'section'   => 'section-edd-single',
					'default'   => '',
					'type'      => 'sub-control',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'title'     => __( 'Product Content Color', 'astra-addon' ),
				),

				/**
				 * Single Product Breadcrumb Color
				 */
				array(
					'name'      => 'edd-single-product-navigation-color',
					'parent'    => ASTRA_THEME_SETTINGS . '[edd-single-product-colors]',
					'section'   => 'section-edd-single',
					'default'   => '',
					'type'      => 'sub-control',
					'control'   => 'ast-color',
					'required'  => array( ASTRA_THEME_SETTINGS . '[disable-edd-single-product-nav]', '!=', 1 ),
					'transport' => 'postMessage',
					'title'     => __( 'Product Navigation Color', 'astra-addon' ),
				),
			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;

		}
	}
}


new Astra_Edd_Single_Colors_Configs();





