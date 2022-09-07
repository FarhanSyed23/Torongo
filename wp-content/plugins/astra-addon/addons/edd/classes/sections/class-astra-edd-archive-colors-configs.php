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

if ( ! class_exists( 'Astra_Edd_Archive_Colors_Configs' ) ) {

	/**
	 * Register Blog Single Layout Configurations.
	 */
	class Astra_Edd_Archive_Colors_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Blog Single Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.6.10
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Shop Product Title Color
				 */
				array(
					'name'      => 'edd-archive-product-title-color',
					'parent'    => ASTRA_THEME_SETTINGS . '[edd-archive-colors]',
					'section'   => 'section-edd-archive',
					'default'   => '',
					'type'      => 'sub-control',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'required'  => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'title' ),
					'title'     => __( 'Product Title Color', 'astra-addon' ),
				),

				/**
				 * Shop Product Price Color
				 */
				array(
					'name'      => 'edd-archive-product-price-color',
					'parent'    => ASTRA_THEME_SETTINGS . '[edd-archive-colors]',
					'section'   => 'section-edd-archive',
					'default'   => '',
					'type'      => 'sub-control',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'required'  => array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'price' ),
					'title'     => __( 'Product Price Color', 'astra-addon' ),
				),

				/**
				 * Shop Product Content Color
				 */
				array(
					'name'      => 'edd-archive-product-content-color',
					'parent'    => ASTRA_THEME_SETTINGS . '[edd-archive-colors]',
					'section'   => 'section-edd-archive',
					'default'   => '',
					'type'      => 'sub-control',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'title'     => __( 'Product Content Color', 'astra-addon' ),
				),
			);
			return array_merge( $configurations, $_configs );
		}
	}
}

new Astra_Edd_Archive_Colors_Configs();
