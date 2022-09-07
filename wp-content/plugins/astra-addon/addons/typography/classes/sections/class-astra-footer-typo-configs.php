<?php
/**
 * Section [Footer] options for astra theme.
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

if ( ! class_exists( 'Astra_Footer_Typo_Configs' ) ) {

	/**
	 * Register below header Configurations.
	 */
	class Astra_Footer_Typo_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Fotter typography Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Footer Bar typo Section heading
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[footer-bar-typography-heading-divider]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'section'  => 'section-footer-small',
					'title'    => __( 'Typography', 'astra-addon' ),
					'priority' => 47,
					'required' => array( ASTRA_THEME_SETTINGS . '[footer-sml-layout]', '!=', 'disabled' ),
					'settings' => array(),
				),

				/**
				 * Option: Footer Bar Typography Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[footer-bar-typography-group]',
					'default'   => astra_get_option( 'footer-bar-typography-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Content', 'astra-addon' ),
					'section'   => 'section-footer-small',
					'transport' => 'postMessage',
					'priority'  => 47,
					'required'  => array( ASTRA_THEME_SETTINGS . '[footer-sml-layout]', '!=', 'disabled' ),
				),

				/**
				 * Option: Footer Content Font Family
				 */
				array(
					'name'      => 'font-family-footer-content',
					'control'   => 'ast-font',
					'font_type' => 'ast-font-family',
					'title'     => __( 'Family', 'astra-addon' ),
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[footer-bar-typography-group]',
					'section'   => 'section-footer-small',
					'default'   => astra_get_option( 'font-family-footer-content' ),
					'connect'   => ASTRA_THEME_SETTINGS . '[font-weight-footer-content]',
				),

				/**
				 * Option: Footer Content Font Size
				 */
				array(
					'name'        => 'font-size-footer-content',
					'default'     => astra_get_option( 'font-size-footer-content' ),
					'title'       => __( 'Size', 'astra-addon' ),
					'transport'   => 'postMessage',
					'type'        => 'sub-control',
					'parent'      => ASTRA_THEME_SETTINGS . '[footer-bar-typography-group]',
					'section'     => 'section-footer-small',
					'control'     => 'ast-responsive',
					'input_attrs' => array(
						'min' => 0,
					),
					'units'       => array(
						'px' => 'px',
						'em' => 'em',
					),
				),

				/**
				 * Option: Footer Content Font Weight
				 */
				array(
					'name'              => 'font-weight-footer-content',
					'type'              => 'sub-control',
					'parent'            => ASTRA_THEME_SETTINGS . '[footer-bar-typography-group]',
					'section'           => 'section-footer-small',
					'control'           => 'ast-font',
					'font_type'         => 'ast-font-weight',
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_font_weight' ),
					'title'             => __( 'Weight', 'astra-addon' ),
					'default'           => astra_get_option( 'font-weight-footer-content' ),
					'connect'           => 'font-family-footer-content',
				),

				/**
				 * Option: Footer Content Text Transform
				 */
				array(
					'name'      => 'text-transform-footer-content',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[footer-bar-typography-group]',
					'section'   => 'section-footer-small',
					'title'     => __( 'Text Transform', 'astra-addon' ),
					'control'   => 'ast-select',
					'default'   => astra_get_option( 'text-transform-footer-content' ),
					'transport' => 'postMessage',
					'choices'   => array(
						''           => __( 'Inherit', 'astra-addon' ),
						'none'       => __( 'None', 'astra-addon' ),
						'capitalize' => __( 'Capitalize', 'astra-addon' ),
						'uppercase'  => __( 'Uppercase', 'astra-addon' ),
						'lowercase'  => __( 'Lowercase', 'astra-addon' ),
					),
				),

				/**
				 * Option: Footer Content Line Height
				 */
				array(
					'name'              => 'line-height-footer-content',
					'type'              => 'sub-control',
					'parent'            => ASTRA_THEME_SETTINGS . '[footer-bar-typography-group]',
					'section'           => 'section-footer-small',
					'default'           => '',
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_number_n_blank' ),
					'title'             => __( 'Line Height', 'astra-addon' ),
					'transport'         => 'postMessage',
					'control'           => 'ast-slider',
					'suffix'            => '',
					'input_attrs'       => array(
						'min'  => 1,
						'step' => 0.01,
						'max'  => 5,
					),
				),
			);

			return array_merge( $configurations, $_configs );
		}
	}
}

new Astra_Footer_Typo_Configs();


