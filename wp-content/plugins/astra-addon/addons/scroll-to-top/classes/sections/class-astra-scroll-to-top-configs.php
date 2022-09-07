<?php
/**
 * Scroll To Top Options for our theme.
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

if ( ! class_exists( 'Astra_Scroll_To_Top_Configs' ) ) {

	/**
	 * Register Scroll To Top Customizer Configurations.
	 */
	class Astra_Scroll_To_Top_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Scroll To Top Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Scroll to Top Display On
				 */
				array(
					'name'    => ASTRA_THEME_SETTINGS . '[scroll-to-top-on-devices]',
					'default' => astra_get_option( 'scroll-to-top-on-devices' ),
					'type'    => 'control',
					'control' => 'select',
					'section' => 'section-scroll-to-top',
					'title'   => __( 'Display On', 'astra-addon' ),
					'choices' => array(
						'desktop' => __( 'Desktop', 'astra-addon' ),
						'mobile'  => __( 'Mobile', 'astra-addon' ),
						'both'    => __( 'Desktop + Mobile', 'astra-addon' ),
					),
				),

				/**
				 * Option: Scroll to Top Position
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[scroll-to-top-icon-position]',
					'default'   => astra_get_option( 'scroll-to-top-icon-position' ),
					'type'      => 'control',
					'control'   => 'select',
					'transport' => 'postMessage',
					'section'   => 'section-scroll-to-top',
					'title'     => __( 'Position', 'astra-addon' ),
					'choices'   => array(
						'right' => __( 'Right', 'astra-addon' ),
						'left'  => __( 'Left', 'astra-addon' ),
					),
				),

				/**
				 * Option: Scroll To Top Icon Size
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[scroll-to-top-icon-size]',
					'default'   => astra_get_option( 'scroll-to-top-icon-size' ),
					'type'      => 'control',
					'control'   => 'number',
					'transport' => 'postMessage',
					'section'   => 'section-scroll-to-top',
					'title'     => __( 'Icon Size', 'astra-addon' ),
				),

				/**
				 * Option: Scroll To Top Radius
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[scroll-to-top-icon-radius]',
					'default'   => astra_get_option( 'scroll-to-top-icon-radius' ),
					'type'      => 'control',
					'control'   => 'ast-slider',
					'transport' => 'postMessage',
					'section'   => 'section-scroll-to-top',
					'title'     => __( 'Border Radius', 'astra-addon' ),
				),

				/**
				 * Option: Scroll On Top Colors Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[scroll-on-top-color-divider]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'section'  => 'section-scroll-to-top',
					'title'    => __( 'Colors', 'astra-addon' ),
					'settings' => array(),
				),

				array(
					'name'      => ASTRA_THEME_SETTINGS . '[scroll-on-top-color-group]',
					'default'   => astra_get_option( 'scroll-on-top-color-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Icon', 'astra-addon' ),
					'section'   => 'section-scroll-to-top',
					'transport' => 'postMessage',
				),

				/**
				 * Option: Icon Color
				 */
				array(
					'name'      => 'scroll-to-top-icon-color',
					'default'   => '',
					'type'      => 'sub-control',
					'priority'  => 1,
					'parent'    => ASTRA_THEME_SETTINGS . '[scroll-on-top-color-group]',
					'section'   => 'section-scroll-to-top',
					'tab'       => __( 'Normal', 'astra-addon' ),
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'title'     => __( 'Icon Color', 'astra-addon' ),
				),

				// Check Astra_Control_Color is exist in the theme.
				/**
				 * Option: Icon Background Color
				 */
				array(
					'name'      => 'scroll-to-top-icon-bg-color',
					'default'   => '',
					'type'      => 'sub-control',
					'priority'  => 1,
					'parent'    => ASTRA_THEME_SETTINGS . '[scroll-on-top-color-group]',
					'section'   => 'section-scroll-to-top',
					'tab'       => __( 'Normal', 'astra-addon' ),
					'transport' => 'postMessage',
					'control'   => 'ast-color',
					'title'     => __( 'Background Color', 'astra-addon' ),
				),

				/**
				 * Option: Icon Hover Color
				 */
				array(
					'name'      => 'scroll-to-top-icon-h-color',
					'default'   => '',
					'type'      => 'sub-control',
					'priority'  => 1,
					'parent'    => ASTRA_THEME_SETTINGS . '[scroll-on-top-color-group]',
					'section'   => 'section-scroll-to-top',
					'tab'       => __( 'Hover', 'astra-addon' ),
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'title'     => __( 'Icon Color', 'astra-addon' ),
				),

				// Check Astra_Control_Color is exist in the theme.
				/**
				 * Option: Link Hover Background Color
				 */

				array(
					'name'      => 'scroll-to-top-icon-h-bg-color',
					'default'   => '',
					'type'      => 'sub-control',
					'priority'  => 1,
					'parent'    => ASTRA_THEME_SETTINGS . '[scroll-on-top-color-group]',
					'section'   => 'section-scroll-to-top',
					'tab'       => __( 'Hover', 'astra-addon' ),
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'title'     => __( 'Background Color', 'astra-addon' ),
				),

			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;
		}
	}
}

new Astra_Scroll_To_Top_Configs();


