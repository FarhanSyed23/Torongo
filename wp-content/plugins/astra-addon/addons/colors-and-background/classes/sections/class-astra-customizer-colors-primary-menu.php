<?php
/**
 * Colors Primary Menu Options for our theme.
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
if ( ! class_exists( 'Astra_Customizer_Colors_Primary_Menu' ) ) {

	/**
	 * Register General Customizer Configurations.
	 */
	class Astra_Customizer_Colors_Primary_Menu extends Astra_Customizer_Config_Base {

		/**
		 * Register General Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$defaults = Astra_Theme_Options::defaults();

			$_configs = array(

				array(
					'name'     => ASTRA_THEME_SETTINGS . '[primary-menu-colors-divider]',
					'section'  => 'section-primary-menu',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'title'    => __( 'Colors', 'astra-addon' ),
					'priority' => 69,
					'settings' => array(),
				),

				array(
					'name'      => ASTRA_THEME_SETTINGS . '[primary-menu-colors]',
					'default'   => astra_get_option( 'primary-menu-colors' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Menu', 'astra-addon' ),
					'section'   => 'section-primary-menu',
					'transport' => 'postMessage',
					'priority'  => 70,
				),

				array(
					'name'      => ASTRA_THEME_SETTINGS . '[primary-submenu-colors]',
					'default'   => astra_get_option( 'primary-submenu-colors' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Submenu', 'astra-addon' ),
					'section'   => 'section-primary-menu',
					'transport' => 'postMessage',
					'priority'  => 70,
				),

				// Option: Primary Menu Color.
				array(
					'type'       => 'sub-control',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'tab'        => __( 'Normal', 'astra-addon' ),
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-menu-colors]',
					'section'    => 'section-primary-menu',
					'name'       => 'primary-menu-color-responsive',
					'default'    => $defaults['primary-menu-color-responsive'],
					'title'      => __( 'Link / Text Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'priority'   => 7,
				),

				// Option: Menu Background image, color.
				array(
					'type'       => 'sub-control',
					'control'    => 'ast-responsive-background',
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-menu-colors]',
					'section'    => 'section-primary-menu',
					'default'    => $defaults['primary-menu-bg-obj-responsive'],
					'name'       => 'primary-menu-bg-obj-responsive',
					'tab'        => __( 'Normal', 'astra-addon' ),
					'data_attrs' => array( 'name' => 'primary-menu-bg-obj-responsive' ),
					'label'      => __( 'Background', 'astra-addon' ),
					'priority'   => 9,
				),

				// Option: Submenu Color.
				array(
					'type'       => 'sub-control',
					'control'    => 'ast-responsive-color',
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-submenu-colors]',
					'section'    => 'section-primary-menu',
					'transport'  => 'postMessage',
					'tab'        => __( 'Normal', 'astra-addon' ),
					'name'       => 'primary-submenu-color-responsive',
					'default'    => $defaults['primary-submenu-color-responsive'],
					'title'      => __( 'Link / Text Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'priority'   => 13,
				),

				// Option: Submenu Background Color.
				array(
					'type'       => 'sub-control',
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-submenu-colors]',
					'section'    => 'section-primary-menu',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'tab'        => __( 'Normal', 'astra-addon' ),
					'name'       => 'primary-submenu-bg-color-responsive',
					'default'    => $defaults['primary-submenu-bg-color-responsive'],
					'title'      => __( 'Background Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'priority'   => 15,
				),

				// Option: Menu Hover Color.
				array(
					'type'       => 'sub-control',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'name'       => 'primary-menu-h-color-responsive',
					'tab'        => __( 'Hover', 'astra-addon' ),
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-menu-colors]',
					'section'    => 'section-primary-menu',
					'default'    => $defaults['primary-menu-h-color-responsive'],
					'title'      => __( 'Link Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'priority'   => 19,
				),

				// Option: Menu Hover Background Color.
				array(
					'name'       => 'primary-menu-h-bg-color-responsive',
					'type'       => 'sub-control',
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-menu-colors]',
					'section'    => 'section-primary-menu',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'tab'        => __( 'Hover', 'astra-addon' ),
					'default'    => $defaults['primary-menu-h-bg-color-responsive'],
					'title'      => __( 'Background Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'priority'   => 21,
				),

				// Option: Submenu Hover Color.
				array(
					'type'       => 'sub-control',
					'control'    => 'ast-responsive-color',
					'tab'        => __( 'Hover', 'astra-addon' ),
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-submenu-colors]',
					'section'    => 'section-primary-menu',
					'transport'  => 'postMessage',
					'name'       => 'primary-submenu-h-color-responsive',
					'default'    => $defaults['primary-submenu-h-color-responsive'],
					'title'      => __( 'Link Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'priority'   => 25,
				),

				// Option: Submenu Hover Background Color.
				array(
					'type'       => 'sub-control',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-submenu-colors]',
					'section'    => 'section-primary-menu',
					'tab'        => __( 'Hover', 'astra-addon' ),
					'name'       => 'primary-submenu-h-bg-color-responsive',
					'default'    => $defaults['primary-submenu-h-bg-color-responsive'],
					'title'      => __( 'Background Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'priority'   => 27,
				),

				// Option: Active Menu Color.
				array(
					'type'       => 'sub-control',
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-menu-colors]',
					'section'    => 'section-primary-menu',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'tab'        => __( 'Active', 'astra-addon' ),
					'name'       => 'primary-menu-a-color-responsive',
					'default'    => $defaults['primary-menu-a-color-responsive'],
					'title'      => __( 'Link Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'priority'   => 31,
				),

				// Option: Active Menu Background Color.
				array(
					'type'       => 'sub-control',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'name'       => 'primary-menu-a-bg-color-responsive',
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-menu-colors]',
					'section'    => 'section-primary-menu',
					'default'    => $defaults['primary-menu-a-bg-color-responsive'],
					'title'      => __( 'Background Color', 'astra-addon' ),
					'tab'        => __( 'Active', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'priority'   => 33,
				),

				// Option: Active Submenu Color.
				array(
					'type'       => 'sub-control',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-submenu-colors]',
					'section'    => 'section-primary-menu',
					'tab'        => __( 'Active', 'astra-addon' ),
					'name'       => 'primary-submenu-a-color-responsive',
					'default'    => $defaults['primary-submenu-a-color-responsive'],
					'title'      => __( 'Link Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'priority'   => 37,
				),

				// Option: Active Submenu Background Color.
				array(
					'type'       => 'sub-control',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-submenu-colors]',
					'section'    => 'section-primary-menu',
					'tab'        => __( 'Active', 'astra-addon' ),
					'name'       => 'primary-submenu-a-bg-color-responsive',
					'default'    => $defaults['primary-submenu-a-bg-color-responsive'],
					'title'      => __( 'Background Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'priority'   => 39,
				),
			);

			return array_merge( $configurations, $_configs );
		}
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
new Astra_Customizer_Colors_Primary_Menu();
