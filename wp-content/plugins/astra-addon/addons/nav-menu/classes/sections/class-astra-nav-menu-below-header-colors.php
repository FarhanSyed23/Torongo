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

if ( ! class_exists( 'Astra_Nav_Menu_Below_Header_Colors' ) ) {

	/**
	 * Register Mega Menu Customizer Configurations.
	 */
	class Astra_Nav_Menu_Below_Header_Colors extends Astra_Customizer_Config_Base {

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
				 * Option: Below Header Menus Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-megamenu-group]',
					'default'   => astra_get_option( 'below-header-megamenu-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Mega Menu Colum Heading', 'astra-addon' ),
					'section'   => 'section-below-header',
					'transport' => 'postMessage',
					'priority'  => 136,
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
				),

				// Option: Megamenu Heading Color.
				array(
					'type'      => 'sub-control',
					'priority'  => 12,
					'tab'       => __( 'Normal', 'astra-addon' ),
					'parent'    => ASTRA_THEME_SETTINGS . '[below-header-megamenu-group]',
					'control'   => 'ast-color',
					'section'   => 'section-below-header',
					'transport' => 'postMessage',
					'name'      => 'below-header-megamenu-heading-color',
					'default'   => astra_get_option( 'below-header-megamenu-heading-color' ),
					'title'     => __( 'Color', 'astra-addon' ),
				),

				// Option: Megamenu Heading Hover Color.
				array(
					'type'      => 'sub-control',
					'priority'  => 12,
					'tab'       => __( 'Hover', 'astra-addon' ),
					'parent'    => ASTRA_THEME_SETTINGS . '[below-header-megamenu-group]',
					'control'   => 'ast-color',
					'section'   => 'section-below-header',
					'transport' => 'postMessage',
					'name'      => 'below-header-megamenu-heading-h-color',
					'default'   => astra_get_option( 'below-header-megamenu-heading-h-color' ),
					'title'     => __( 'Color', 'astra-addon' ),
				),

				/**
				 * Option: Sticky Header Below Mega Menu Column Color Group
				 */
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[sticky-header-below-mega-menus-colors]',
					'default'         => astra_get_option( 'sticky-header-below-mega-menus-colors' ),
					'type'            => 'control',
					'control'         => 'ast-settings-group',
					'title'           => __( 'Mega Menu Column Heading', 'astra-addon' ),
					'section'         => 'section-sticky-header',
					'transport'       => 'postMessage',
					'priority'        => 130,
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),

				// Option: Megamenu Heading Color.
				array(
					'type'      => 'sub-control',
					'tab'       => __( 'Normal', 'astra-addon' ),
					'priority'  => 12,
					'parent'    => ASTRA_THEME_SETTINGS . '[sticky-header-below-mega-menus-colors]',
					'control'   => 'ast-color',
					'section'   => 'section-below-header',
					'transport' => 'postMessage',
					'name'      => 'sticky-below-header-megamenu-heading-color',
					'default'   => astra_get_option( 'sticky-below-header-megamenu-heading-color' ),
					'title'     => __( 'Color', 'astra-addon' ),
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
				),

				// Option: Megamenu Heading Hover Color.
				array(
					'type'      => 'sub-control',
					'tab'       => __( 'Hover', 'astra-addon' ),
					'priority'  => 12,
					'parent'    => ASTRA_THEME_SETTINGS . '[sticky-header-below-mega-menus-colors]',
					'control'   => 'ast-color',
					'section'   => 'section-below-header',
					'transport' => 'postMessage',
					'name'      => 'sticky-below-header-megamenu-heading-h-color',
					'default'   => astra_get_option( 'sticky-below-header-megamenu-heading-h-color' ),
					'title'     => __( 'Color', 'astra-addon' ),
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
				),
			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;
		}
	}
}

new Astra_Nav_Menu_Below_Header_Colors();

