<?php
/**
 * Section Button options for astra theme.
 *
 * @package     Astra Addon
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2020, Brainstorm Force
 * @link        https://www.brainstormforce.com
 * @since       1.0.0
 */

// Block direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bail if Customizer config base class does not exist.
if ( ! class_exists( 'Astra_Customizer_Config_Base' ) ) {
	return;
}

if ( ! class_exists( 'Astra_Button_Typo_Configs' ) ) {

	/**
	 * Register below header Configurations.
	 */
	class Astra_Button_Typo_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Button typography Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Button Styling
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[button-typography-styling-divider]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'section'  => 'section-buttons',
					'title'    => __( 'Typography', 'astra-addon' ),
					'priority' => 25,
					'settings' => array(),
				),

				array(
					'name'      => ASTRA_THEME_SETTINGS . '[button-text-typography]',
					'default'   => astra_get_option( 'button-text-typography' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Button Text', 'astra-addon' ),
					'section'   => 'section-buttons',
					'transport' => 'postMessage',
					'priority'  => 25,
				),

				/**
				 * Option: Button Font Family
				 */
				array(
					'name'      => 'font-family-button',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[button-text-typography]',
					'section'   => 'section-buttons',
					'control'   => 'ast-font',
					'font_type' => 'ast-font-family',
					'title'     => __( 'Family', 'astra-addon' ),
					'default'   => astra_get_option( 'font-family-button' ),
					'connect'   => ASTRA_THEME_SETTINGS . '[font-weight-button]',
					'priority'  => 1,
				),

				/**
				 * Option: Button Font Size
				 */
				array(
					'name'        => 'font-size-button',
					'transport'   => 'postMessage',
					'title'       => __( 'Size', 'astra-addon' ),
					'type'        => 'sub-control',
					'parent'      => ASTRA_THEME_SETTINGS . '[button-text-typography]',
					'section'     => 'section-buttons',
					'control'     => 'ast-responsive',
					'default'     => astra_get_option( 'font-size-button' ),
					'input_attrs' => array(
						'min' => 0,
					),
					'units'       => array(
						'px' => 'px',
						'em' => 'em',
					),
				),

				/**
				 * Option: Button Font Weight
				 */
				array(
					'name'              => 'font-weight-button',
					'type'              => 'sub-control',
					'parent'            => ASTRA_THEME_SETTINGS . '[button-text-typography]',
					'section'           => 'section-buttons',
					'control'           => 'ast-font',
					'font_type'         => 'ast-font-weight',
					'title'             => __( 'Weight', 'astra-addon' ),
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_font_weight' ),
					'default'           => astra_get_option( 'font-weight-button' ),
					'connect'           => 'font-family-button',
					'priority'          => 2,
				),

				/**
				 * Option: Button Text Transform
				 */
				array(
					'name'      => 'text-transform-button',
					'transport' => 'postMessage',
					'default'   => astra_get_option( 'text-transform-button' ),
					'title'     => __( 'Text Transform', 'astra-addon' ),
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[button-text-typography]',
					'section'   => 'section-buttons',
					'control'   => 'ast-select',
					'priority'  => 3,
					'choices'   => array(
						''           => __( 'Inherit', 'astra-addon' ),
						'none'       => __( 'None', 'astra-addon' ),
						'capitalize' => __( 'Capitalize', 'astra-addon' ),
						'uppercase'  => __( 'Uppercase', 'astra-addon' ),
						'lowercase'  => __( 'Lowercase', 'astra-addon' ),
					),
				),

			);

			return array_merge( $configurations, $_configs );
		}
	}
}

new Astra_Button_Typo_Configs();


