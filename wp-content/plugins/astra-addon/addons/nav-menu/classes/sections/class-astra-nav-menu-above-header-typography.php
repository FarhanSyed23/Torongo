<?php
/**
 * Mega Menu Options configurations.
 *
 * @package     Astra Addon
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2020, Brainstorm Force
 * @link        https://www.brainstormforce.com
 * @since       1.6.0
 */

// Block direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bail if Customizer config base class does not exist.
if ( ! class_exists( 'Astra_Customizer_Config_Base' ) ) {
	return;
}

if ( ! class_exists( 'Astra_Nav_Menu_Above_Header_Typography' ) ) {

	/**
	 * Register Mega Menu Customizer Configurations.
	 */
	class Astra_Nav_Menu_Above_Header_Typography extends Astra_Customizer_Config_Base {

		/**
		 * Register Mega Menu Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.6.0
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Above Header Submenu Typography Styling
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-typography-megamenu-styling]',
					'default'   => astra_get_option( 'above-header-typography-megamenu-styling' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Mega Menu Column Heading', 'astra-addon' ),
					'section'   => 'section-above-header',
					'transport' => 'postMessage',
					'priority'  => 132,
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
				),

				// Option: Above Megamenu Header Menu Font Family.
				array(
					'name'      => 'above-header-megamenu-heading-font-family',
					'parent'    => ASTRA_THEME_SETTINGS . '[above-header-typography-megamenu-styling]',
					'type'      => 'sub-control',
					'control'   => 'ast-font',
					'section'   => 'section-above-header',
					'font_type' => 'ast-font-family',
					'default'   => astra_get_option( 'above-header-megamenu-heading-font-family' ),
					'title'     => __( 'Family', 'astra-addon' ),
					'connect'   => ASTRA_THEME_SETTINGS . '[above-header-megamenu-heading-font-weight]',
				),

				// Option: Above Megamenu Header Menu Font Size.
				array(
					'name'        => 'above-header-megamenu-heading-font-size',
					'parent'      => ASTRA_THEME_SETTINGS . '[above-header-typography-megamenu-styling]',
					'transport'   => 'postMessage',
					'title'       => __( 'Size', 'astra-addon' ),
					'type'        => 'sub-control',
					'responsive'  => false,
					'control'     => 'ast-responsive',
					'section'     => 'section-above-header',
					'default'     => astra_get_option( 'above-header-megamenu-heading-font-size' ),
					'input_attrs' => array(
						'min' => 0,
					),
					'units'       => array(
						'px' => 'px',
						'em' => 'em',
					),
				),

				// Option: Above Megamenu Header Menu Font Weight.
				array(
					'name'              => 'above-header-megamenu-heading-font-weight',
					'parent'            => ASTRA_THEME_SETTINGS . '[above-header-typography-megamenu-styling]',
					'type'              => 'sub-control',
					'control'           => 'ast-font',
					'section'           => 'section-above-header',
					'font_type'         => 'ast-font-weight',
					'default'           => astra_get_option( 'above-header-megamenu-heading-font-weight' ),
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_font_weight' ),
					'title'             => __( 'Weight', 'astra-addon' ),
					'connect'           => 'above-header-megamenu-heading-font-family',
				),

				// Option: Above Megamenu Header Menu Text Transform.
				array(
					'name'      => 'above-header-megamenu-heading-text-transform',
					'parent'    => ASTRA_THEME_SETTINGS . '[above-header-typography-megamenu-styling]',
					'type'      => 'sub-control',
					'section'   => 'section-above-header',
					'control'   => 'ast-select',
					'title'     => __( 'Text Transform', 'astra-addon' ),
					'transport' => 'postMessage',
					'default'   => astra_get_option( 'above-header-megamenu-heading-text-transform' ),
					'choices'   => array(
						''           => __( 'Inherit', 'astra-addon' ),
						'none'       => __( 'None', 'astra-addon' ),
						'capitalize' => __( 'Capitalize', 'astra-addon' ),
						'uppercase'  => __( 'Uppercase', 'astra-addon' ),
						'lowercase'  => __( 'Lowercase', 'astra-addon' ),
					),
				),
			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;
		}
	}
}

new Astra_Nav_Menu_Above_Header_Typography();

