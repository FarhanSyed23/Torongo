<?php
/**
 * Colors Sidebar Options for our theme.
 *
 * @package     Astra Addon
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2020, Brainstorm Force
 * @link        https://www.brainstormforce.com
 * @since       1.4.3
 */

// Block direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bail if Customizer config base class does not exist.
if ( ! class_exists( 'Astra_Customizer_Config_Base' ) ) {
	return;
}

/**
 * Customizer Sanitizes
 *
 * @since 1.4.3
 */
if ( ! class_exists( 'Astra_Customizer_Colors_Sidebar' ) ) {

	/**
	 * Register General Customizer Configurations.
	 */
	class Astra_Customizer_Colors_Sidebar extends Astra_Customizer_Config_Base {

		/**
		 * Register General Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: SideBar Color & Background Section heading
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[sidebar-color-background-heading-divider]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'section'  => 'section-sidebars',
					'title'    => __( 'Colors & Background', 'astra-addon' ),
					'priority' => 23,
					'settings' => array(),
				),

				/**
				 * Option: SideBar Background Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[sidebar-background-group]',
					'default'   => astra_get_option( 'sidebar-background-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Background', 'astra-addon' ),
					'section'   => 'section-sidebars',
					'transport' => 'postMessage',
					'priority'  => 23,
				),

				/**
				 * Option: SideBar Content Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[sidebar-content-group]',
					'default'   => astra_get_option( 'sidebar-content-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Content', 'astra-addon' ),
					'section'   => 'section-sidebars',
					'transport' => 'postMessage',
					'priority'  => 23,
				),

				// Option: Sidebar Background.
				array(
					'control'  => 'ast-background',
					'name'     => 'sidebar-bg-obj',
					'type'     => 'sub-control',
					'priority' => 7,
					'parent'   => ASTRA_THEME_SETTINGS . '[sidebar-background-group]',
					'section'  => 'section-sidebars',
					'default'  => astra_get_option( 'sidebar-bg-obj' ),
					'label'    => __( 'Background', 'astra-addon' ),
				),

				// Option: Widget Title Color.
				array(
					'type'      => 'sub-control',
					'tab'       => __( 'Normal', 'astra-addon' ),
					'priority'  => 8,
					'parent'    => ASTRA_THEME_SETTINGS . '[sidebar-content-group]',
					'section'   => 'section-sidebars',
					'control'   => 'ast-color',
					'default'   => '',
					'transport' => 'postMessage',
					'name'      => 'sidebar-widget-title-color',
					'title'     => __( 'Title Color', 'astra-addon' ),
				),

				// Option: Text Color.
				array(
					'type'      => 'sub-control',
					'tab'       => __( 'Normal', 'astra-addon' ),
					'priority'  => 9,
					'parent'    => ASTRA_THEME_SETTINGS . '[sidebar-content-group]',
					'section'   => 'section-sidebars',
					'control'   => 'ast-color',
					'default'   => '',
					'transport' => 'postMessage',
					'name'      => 'sidebar-text-color',
					'title'     => __( 'Text Color', 'astra-addon' ),
				),

				// Option: Link Color.
				array(
					'type'     => 'sub-control',
					'tab'      => __( 'Normal', 'astra-addon' ),
					'priority' => 10,
					'parent'   => ASTRA_THEME_SETTINGS . '[sidebar-content-group]',
					'section'  => 'section-sidebars',
					'control'  => 'ast-color',
					'default'  => '',
					'name'     => 'sidebar-link-color',
					'title'    => __( 'Link Color', 'astra-addon' ),
				),

				// Option: Link Hover Color.
				array(
					'type'      => 'sub-control',
					'tab'       => __( 'Hover', 'astra-addon' ),
					'priority'  => 11,
					'parent'    => ASTRA_THEME_SETTINGS . '[sidebar-content-group]',
					'section'   => 'section-sidebars',
					'control'   => 'ast-color',
					'default'   => '',
					'transport' => 'postMessage',
					'name'      => 'sidebar-link-h-color',
					'title'     => __( 'Link Color', 'astra-addon' ),
				),

			);

			return array_merge( $configurations, $_configs );
		}
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
new Astra_Customizer_Colors_Sidebar();
