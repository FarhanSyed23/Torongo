<?php
/**
 * Sticky Header Colors Options for our theme.
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

if ( ! class_exists( 'Astra_Sticky_Header_Colors_Bg_Configs' ) ) {

	/**
	 * Register Sticky Header  ColorsCustomizer Configurations.
	 */
	class Astra_Sticky_Header_Colors_Bg_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Sticky Header Colors Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$defaults = Astra_Theme_Options::defaults();

			$_config = array(

				array(
					'name'       => 'sticky-header-bg-color-responsive',
					'default'    => $defaults['sticky-header-bg-color-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Normal', 'astra-addon' ),
					'priority'   => 6,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-header-colors]',
					'section'    => 'section-sticky-header',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'title'      => __( 'Background Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
				),

				/**
				* Option: Site Title Color
				*/
				array(
					'name'       => 'sticky-header-color-site-title-responsive',
					'default'    => $defaults['sticky-header-color-site-title-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Normal', 'astra-addon' ),
					'priority'   => 7,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-header-colors]',
					'section'    => 'section-sticky-header',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'title'      => __( 'Site Title Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'required'   => array(
						ASTRA_THEME_SETTINGS . '[display-site-title]',
						'==',
						true,
					),
				),

				/**
				* Option: Site Title Hover Color
				*/
				array(
					'name'       => 'sticky-header-color-h-site-title-responsive',
					'default'    => $defaults['sticky-header-color-h-site-title-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Hover', 'astra-addon' ),
					'priority'   => 8,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-header-colors]',
					'section'    => 'section-sticky-header',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'title'      => __( 'Site Title Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'required'   => array(
						ASTRA_THEME_SETTINGS . '[display-site-title]',
						'==',
						true,
					),
				),

				/**
				* Option: Site Tagline Color
				*/
				array(
					'name'       => 'sticky-header-color-site-tagline-responsive',
					'default'    => $defaults['sticky-header-color-site-tagline-responsive'],
					'type'       => 'sub-control',
					'priority'   => 8,
					'tab'        => __( 'Normal', 'astra-addon' ),
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-header-colors]',
					'section'    => 'section-sticky-header',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'title'      => __( 'Site Tagline Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'connect'    => ASTRA_THEME_SETTINGS . '[sticky-header-color-site-tagline-responsive]',
					'required'   => array(
						ASTRA_THEME_SETTINGS . '[display-site-tagline]',
						'==',
						true,
					),
				),

				/**
				* Option: Primary Menu Color
				*/
				array(
					'name'       => 'sticky-header-menu-color-responsive',
					'default'    => $defaults['sticky-header-menu-color-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Normal', 'astra-addon' ),
					'priority'   => 6,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-menus-colors]',
					'section'    => 'section-sticky-header',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'title'      => __( 'Link / Text Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
				),
				/**
				* Option: Menu Background Color
				*/
				array(
					'name'       => 'sticky-header-menu-bg-color-responsive',
					'default'    => $defaults['sticky-header-menu-bg-color-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Normal', 'astra-addon' ),
					'priority'   => 7,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-menus-colors]',
					'section'    => 'section-sticky-header',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'title'      => __( 'Background Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
				),

				/**
				* Option: Menu Hover Color
				*/
				array(
					'name'       => 'sticky-header-menu-h-color-responsive',
					'default'    => $defaults['sticky-header-menu-h-color-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Hover', 'astra-addon' ),
					'priority'   => 6,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-menus-colors]',
					'section'    => 'section-sticky-header',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'title'      => __( 'Link Active / Hover Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'connect'    => ASTRA_THEME_SETTINGS . '[sticky-header-menu-h-color-responsive]',
				),
				/**
				* Option: Menu Link / Hover Background Color
				*/
				array(
					'name'       => 'sticky-header-menu-h-a-bg-color-responsive',
					'default'    => $defaults['sticky-header-menu-h-a-bg-color-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Hover', 'astra-addon' ),
					'priority'   => 7,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-menus-colors]',
					'section'    => 'section-sticky-header',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'title'      => __( 'Link Active / Hover Background Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
				),
				/**
				* Option: Primary Menu Color
				*/
				array(
					'name'       => 'sticky-header-submenu-color-responsive',
					'default'    => $defaults['sticky-header-submenu-color-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Normal', 'astra-addon' ),
					'priority'   => 9,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-submenu-colors]',
					'section'    => 'section-sticky-header',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'title'      => __( 'Link / Text Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'connect'    => ASTRA_THEME_SETTINGS . '[sticky-header-submenu-color-responsive]',
				),
				/**
				* Option: SubMenu Background Color
				*/
				array(
					'name'       => 'sticky-header-submenu-bg-color-responsive',
					'default'    => $defaults['sticky-header-submenu-bg-color-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Normal', 'astra-addon' ),
					'priority'   => 10,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-submenu-colors]',
					'section'    => 'section-sticky-header',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'title'      => __( 'Background Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
				),
				/**
				* Option: Menu Hover Color
				*/
				array(
					'name'       => 'sticky-header-submenu-h-color-responsive',
					'default'    => $defaults['sticky-header-submenu-h-color-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Hover', 'astra-addon' ),
					'priority'   => 9,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-submenu-colors]',
					'section'    => 'section-sticky-header',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'title'      => __( 'Link Active / Hover Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'connect'    => ASTRA_THEME_SETTINGS . '[sticky-header-submenu-h-color-responsive]',
				),
				/**
				* Option: SubMenu Link / Hover Background Color
				*/
				array(
					'name'       => 'sticky-header-submenu-h-a-bg-color-responsive',
					'default'    => $defaults['sticky-header-submenu-h-a-bg-color-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Hover', 'astra-addon' ),
					'priority'   => 10,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-submenu-colors]',
					'section'    => 'section-sticky-header',
					'control'    => 'ast-responsive-color',
					'transport'  => 'postMessage',
					'title'      => __( 'Link Active / Hover Background Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'connect'    => ASTRA_THEME_SETTINGS . '[sticky-header-submenu-h-a-bg-color-responsive]',
				),
				/**
				 * Option: Content Section Text color.
				 */
				array(
					'name'       => 'sticky-header-content-section-text-color-responsive',
					'default'    => $defaults['sticky-header-content-section-text-color-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Normal', 'astra-addon' ),
					'priority'   => 20,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-outside-item-colors]',
					'section'    => 'section-sticky-header',
					'transport'  => 'postMessage',
					'control'    => 'ast-responsive-color',
					'title'      => __( 'Text Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
				),

				/**
				 * Option: Content Section Link color.
				 */
				array(
					'name'       => 'sticky-header-content-section-link-color-responsive',
					'default'    => $defaults['sticky-header-content-section-link-color-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Normal', 'astra-addon' ),
					'priority'   => 21,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-outside-item-colors]',
					'section'    => 'section-sticky-header',
					'transport'  => 'postMessage',
					'control'    => 'ast-responsive-color',
					'title'      => __( 'Link Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'connect'    => ASTRA_THEME_SETTINGS . '[sticky-header-content-section-link-color-responsive]',
				),

				/**
				 * Option: Content Section Link Hover color.
				 */
				array(
					'name'       => 'sticky-header-content-section-link-h-color-responsive',
					'default'    => $defaults['sticky-header-content-section-link-h-color-responsive'],
					'type'       => 'sub-control',
					'tab'        => __( 'Hover', 'astra-addon' ),
					'priority'   => 22,
					'parent'     => ASTRA_THEME_SETTINGS . '[sticky-header-primary-outside-item-colors]',
					'section'    => 'section-sticky-header',
					'transport'  => 'postMessage',
					'control'    => 'ast-responsive-color',
					'title'      => __( 'Link Color', 'astra-addon' ),
					'responsive' => true,
					'rgba'       => true,
					'connect'    => ASTRA_THEME_SETTINGS . '[sticky-header-content-section-link-h-color-responsive]',
				),
			);

			return array_merge( $configurations, $_config );
		}

	}
}

new Astra_Sticky_Header_Colors_Bg_Configs();



