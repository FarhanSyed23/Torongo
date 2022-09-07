<?php
/**
 * Sticky Header - Header Sections Options for our theme.
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

if ( ! class_exists( 'Astra_Sticky_Header_Sections_Configs' ) ) {

	/**
	 * Register Sticky Header - Header Sections Customizer Configurations.
	 */
	class Astra_Sticky_Header_Sections_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Sticky Header - Header Sections Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_config = array(
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[header-above-stick]',
					'default'         => astra_get_option( 'header-above-stick' ),
					'type'            => 'control',
					'section'         => 'section-sticky-header',
					'title'           => __( 'Stick Above Header', 'astra-addon' ),
					'priority'        => 5,
					'control'         => 'checkbox',
					'required'        => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '!=', 'disabled' ),
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[header-below-stick]',
					'default'         => astra_get_option( 'header-below-stick' ),
					'type'            => 'control',
					'section'         => 'section-sticky-header',
					'title'           => __( 'Stick Below Header', 'astra-addon' ),
					'priority'        => 14,
					'control'         => 'checkbox',
					'required'        => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '!=', 'disabled' ),
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),

				/**
				 * Header Button - Sticky
				 */
				array(
					'name'     => 'section-header-button-sticky',
					'type'     => 'section',
					'priority' => 10,
					'title'    => __( 'Sticky Header Button', 'astra-addon' ),
					'section'  => 'section-header-button',
				),
			);

			return array_merge( $configurations, $_config );
		}

	}
}

new Astra_Sticky_Header_Sections_Configs();



