<?php
/**
 * Easy Digital Downloads General Options for our theme.
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2020, Astra
 * @link        https://wpastra.com/
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

if ( ! class_exists( 'Astra_Edd_General_Configs' ) ) {

	/**
	 * Register Easy Digital Downloads General Layout Configurations.
	 */
	class Astra_Edd_General_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Easy Digital Downloads General Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.6.10
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Divider
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[edd-header-cart-icon-divider]',
					'section'   => 'section-edd-general',
					'title'     => __( 'Header Cart Icon', 'astra-addon' ),
					'type'      => 'control',
					'control'   => 'ast-heading',
					'priority'  => 30,
					'settings'  => array(),
					'separator' => false,
				),

				/**
				 * Option: Header Cart Icon
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[edd-header-cart-icon]',
					'default'  => astra_get_option( 'edd-header-cart-icon' ),
					'type'     => 'control',
					'section'  => 'section-edd-general',
					'title'    => __( 'Icon', 'astra-addon' ),
					'control'  => 'select',
					'priority' => 35,
					'choices'  => array(
						'default' => __( 'Default', 'astra-addon' ),
						'cart'    => __( 'Cart', 'astra-addon' ),
						'bag'     => __( 'Bag', 'astra-addon' ),
						'basket'  => __( 'Basket', 'astra-addon' ),
					),
				),

				/**
				 * Option: Icon Style
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[edd-header-cart-icon-style]',
					'default'   => astra_get_option( 'edd-header-cart-icon-style' ),
					'type'      => 'control',
					'transport' => 'postMessage',
					'section'   => 'section-edd-general',
					'title'     => __( 'Style', 'astra-addon' ),
					'control'   => 'select',
					'priority'  => 40,
					'choices'   => array(
						'none'    => __( 'None', 'astra-addon' ),
						'outline' => __( 'Outline', 'astra-addon' ),
						'fill'    => __( 'Fill', 'astra-addon' ),
					),
				),

				/**
				 * Option: Background color
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[edd-header-cart-icon-color]',
					'default'   => astra_get_option( 'edd-header-cart-icon-color' ),
					'type'      => 'control',
					'control'   => 'ast-color',
					'required'  => array( ASTRA_THEME_SETTINGS . '[edd-header-cart-icon-style]', '!=', 'none' ),
					'title'     => __( 'Color', 'astra-addon' ),
					'transport' => 'postMessage',
					'section'   => 'section-edd-general',
					'priority'  => 45,
				),

				/**
				 * Option: Border Radius
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[edd-header-cart-icon-radius]',
					'default'     => astra_get_option( 'edd-header-cart-icon-radius' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'section'     => 'section-edd-general',
					'required'    => array( ASTRA_THEME_SETTINGS . '[edd-header-cart-icon-style]', '!=', 'none' ),
					'title'       => __( 'Border Radius', 'astra-addon' ),
					'control'     => 'ast-slider',
					'priority'    => 47,
					'input_attrs' => array(
						'min'  => 0,
						'step' => 1,
						'max'  => 200,
					),
				),

				/**
				 * Option: Header cart total
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[edd-header-cart-total-display]',
					'default'  => astra_get_option( 'edd-header-cart-total-display' ),
					'type'     => 'control',
					'section'  => 'section-edd-general',
					'title'    => __( 'Display Cart Totals', 'astra-addon' ),
					'priority' => 50,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Cart Title
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[edd-header-cart-title-display]',
					'default'  => astra_get_option( 'edd-header-cart-title-display' ),
					'type'     => 'control',
					'section'  => 'section-edd-general',
					'title'    => __( 'Display Cart Title', 'astra-addon' ),
					'priority' => 55,
					'control'  => 'checkbox',
				),
			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;

		}
	}
}


new Astra_Edd_General_Configs();





