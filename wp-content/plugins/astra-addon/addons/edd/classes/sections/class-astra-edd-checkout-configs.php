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

if ( ! class_exists( 'Astra_Edd_Checkout_Configs' ) ) {

	/**
	 * Register Easy Digital Downloads Checkout Layout Configurations.
	 */
	class Astra_Edd_Checkout_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Easy Digital Downloads Checkout Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.6.10
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Display Coupon on Checkout Page
				 */
				array(
					'name'    => ASTRA_THEME_SETTINGS . '[edd-checkout-coupon-display]',
					'default' => astra_get_option( 'edd-checkout-coupon-display' ),
					'type'    => 'control',
					'section' => 'section-edd-checkout-page',
					'title'   => __( 'Display Apply Coupon Field', 'astra-addon' ),
					'control' => 'checkbox',
				),

				/*
				 * Option: Distraction free Checkout.
				 */
				array(
					'name'    => ASTRA_THEME_SETTINGS . '[edd-distraction-free-checkout]',
					'default' => astra_get_option( 'edd-distraction-free-checkout' ),
					'type'    => 'control',
					'section' => 'section-edd-checkout-page',
					'title'   => __( 'Distraction Free Checkout', 'astra-addon' ),
					'control' => 'checkbox',
				),

				/**
				 * Option: Checkout Content Width
				 */
				array(
					'name'    => ASTRA_THEME_SETTINGS . '[edd-checkout-content-width]',
					'default' => astra_get_option( 'edd-checkout-content-width' ),
					'type'    => 'control',
					'control' => 'select',
					'section' => 'section-edd-checkout-page',
					'title'   => __( 'Checkout Form Width', 'astra-addon' ),
					'choices' => array(
						'default' => __( 'Default', 'astra-addon' ),
						'custom'  => __( 'Custom', 'astra-addon' ),
					),
				),

				/**
				 * Option: Enter Width
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[edd-checkout-content-max-width]',
					'default'     => 1200,
					'type'        => 'control',
					'transport'   => 'postMessage',
					'control'     => 'ast-slider',
					'required'    => array( ASTRA_THEME_SETTINGS . '[edd-checkout-content-width]', '==', 'custom' ),
					'section'     => 'section-edd-checkout-page',
					'title'       => __( 'Custom Width', 'astra-addon' ),
					'suffix'      => '',
					'input_attrs' => array(
						'min'  => 768,
						'step' => 1,
						'max'  => 1920,
					),
				),
			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;

		}
	}
}


new Astra_Edd_Checkout_Configs();





