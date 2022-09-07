<?php
/**
 * Sticky Header Options for our theme.
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

if ( ! class_exists( 'Astra_Sticky_Header_Configs' ) ) {

	/**
	 * Register Sticky Header Customizer Configurations.
	 */
	class Astra_Sticky_Header_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Sticky Header Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_config = array(

				/**
				 * Option: Sticky Header Above Divider
				 */
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[divider-section-sticky-above-header]',
					'type'            => 'control',
					'control'         => 'ast-heading',
					'section'         => 'section-sticky-header',
					'title'           => __( 'Above Header Colors', 'astra-addon' ),
					'settings'        => array(),
					'priority'        => 60,
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),

				/**
				 * Option: Sticky Header Above Color Group
				 */
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[sticky-header-above-header-colors]',
					'default'         => astra_get_option( 'sticky-header-above-header-colors' ),
					'type'            => 'control',
					'control'         => 'ast-settings-group',
					'title'           => __( 'Header', 'astra-addon' ),
					'section'         => 'section-sticky-header',
					'transport'       => 'postMessage',
					'priority'        => 60,
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),
				/**
				 * Option: Sticky Header Above Menu Color Group
				 */
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[sticky-header-above-menus-colors]',
					'default'         => astra_get_option( 'sticky-header-above-menus-colors' ),
					'type'            => 'control',
					'control'         => 'ast-settings-group',
					'title'           => __( 'Menu', 'astra-addon' ),
					'section'         => 'section-sticky-header',
					'transport'       => 'postMessage',
					'priority'        => 60,
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),
				/**
				 * Option: Sticky Header Above Menu Color Group
				 */
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[sticky-header-above-submenus-colors]',
					'default'         => astra_get_option( 'sticky-header-above-submenus-colors' ),
					'type'            => 'control',
					'control'         => 'ast-settings-group',
					'title'           => __( 'Submenu', 'astra-addon' ),
					'section'         => 'section-sticky-header',
					'transport'       => 'postMessage',
					'priority'        => 65,
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),
				/**
				 * Option: Sticky Header Above Color Group
				 */
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[sticky-header-above-outside-item-colors]',
					'default'         => astra_get_option( 'sticky-header-above-outside-item-colors' ),
					'type'            => 'control',
					'control'         => 'ast-settings-group',
					'title'           => __( 'Content', 'astra-addon' ),
					'section'         => 'section-sticky-header',
					'transport'       => 'postMessage',
					'priority'        => 75,
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),

				/**
				* Option: Sticky Header Primary Divider
				*/
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[divider-section-sticky-primary-header]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'section'  => 'section-sticky-header',
					'title'    => __( 'Primary Header Colors', 'astra-addon' ),
					'settings' => array(),
					'priority' => 80,
				),

				/**
				 * Option: Sticky Header primary Color Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[sticky-header-primary-header-colors]',
					'default'   => astra_get_option( 'sticky-header-primary-header-colors' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Header', 'astra-addon' ),
					'section'   => 'section-sticky-header',
					'transport' => 'postMessage',
					'priority'  => 85,
				),
				/**
				 * Option: Sticky Header primary Color Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[sticky-header-primary-menus-colors]',
					'default'   => astra_get_option( 'sticky-header-primary-menus-colors' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Menu', 'astra-addon' ),
					'section'   => 'section-sticky-header',
					'transport' => 'postMessage',
					'priority'  => 90,
				),

				/**
				 * Option: Sticky Header primary Color Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[sticky-header-primary-submenu-colors]',
					'default'   => astra_get_option( 'sticky-header-primary-submenu-colors' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Submenu', 'astra-addon' ),
					'section'   => 'section-sticky-header',
					'transport' => 'postMessage',
					'priority'  => 95,
				),

				/**
				 * Option: Sticky Header primary Color Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[sticky-header-primary-outside-item-colors]',
					'default'   => astra_get_option( 'sticky-header-primary-outside-item-colors' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Outside Item', 'astra-addon' ),
					'section'   => 'section-sticky-header',
					'transport' => 'postMessage',
					'priority'  => 105,
				),

				/**
				 * Option: Sticky Header Below Divider
				 */
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[divider-section-sticky-below-header]',
					'type'            => 'control',
					'control'         => 'ast-heading',
					'section'         => 'section-sticky-header',
					'title'           => __( 'Below Header Colors', 'astra-addon' ),
					'settings'        => array(),
					'priority'        => 110,
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),

				/**
				 * Option: Sticky Header Below Color Group
				 */
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[sticky-header-below-header-colors]',
					'default'         => astra_get_option( 'sticky-header-below-header-colors' ),
					'type'            => 'control',
					'control'         => 'ast-settings-group',
					'title'           => __( 'Header', 'astra-addon' ),
					'section'         => 'section-sticky-header',
					'transport'       => 'postMessage',
					'priority'        => 115,
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),
				/**
				 * Option: Sticky Header Below Color Group
				 */
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[sticky-header-below-menus-colors]',
					'default'         => astra_get_option( 'sticky-header-below-menus-colors' ),
					'type'            => 'control',
					'control'         => 'ast-settings-group',
					'title'           => __( 'Menu', 'astra-addon' ),
					'section'         => 'section-sticky-header',
					'transport'       => 'postMessage',
					'priority'        => 120,
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),
				/**
				 * Option: Sticky Header Below Submenu Color Group
				 */
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[sticky-header-below-submenus-colors]',
					'default'         => astra_get_option( 'sticky-header-below-submenus-colors' ),
					'type'            => 'control',
					'control'         => 'ast-settings-group',
					'title'           => __( 'Submenu', 'astra-addon' ),
					'section'         => 'section-sticky-header',
					'transport'       => 'postMessage',
					'priority'        => 125,
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),

				/**
				 * Option: Sticky Header Header Content Color Group
				 */
				array(
					'name'            => ASTRA_THEME_SETTINGS . '[sticky-header-below-header-content-colors]',
					'default'         => astra_get_option( 'sticky-header-below-header-content-colors' ),
					'type'            => 'control',
					'control'         => 'ast-settings-group',
					'title'           => __( 'Content', 'astra-addon' ),
					'section'         => 'section-sticky-header',
					'transport'       => 'postMessage',
					'priority'        => 135,
					'required'        => array(
						'conditions' => array(
							array(
								ASTRA_THEME_SETTINGS . '[below-header-section-1]',
								'==',
								array( 'search', 'widget', 'text-html', 'edd' ),
							),
							array(
								ASTRA_THEME_SETTINGS . '[below-header-section-2]',
								'==',
								array( 'search', 'widget', 'text-html', 'edd' ),
							),
						),
						'operator'   => 'OR',
					),
					'active_callback' => 'Astra_Sticky_Header_Configs::is_header_section_active',
				),
				/**
				 * Option: Stick Primary Header
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[header-main-stick]',
					'default'  => astra_get_option( 'header-main-stick' ),
					'type'     => 'control',
					'section'  => 'section-sticky-header',
					'title'    => __( 'Stick Primary Header', 'astra-addon' ),
					'priority' => 10,
					'control'  => 'checkbox',
				),
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[different-sticky-logo]',
					'default'  => astra_get_option( 'different-sticky-logo' ),
					'type'     => 'control',
					'section'  => 'section-sticky-header',
					'title'    => __( 'Different Logo for Sticky Header?', 'astra-addon' ),
					'priority' => 15,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Sticky header logo selector
				 */
				array(
					'name'           => ASTRA_THEME_SETTINGS . '[sticky-header-logo]',
					'default'        => astra_get_option( 'sticky-header-logo' ),
					'type'           => 'control',
					'control'        => 'image',
					'section'        => 'section-sticky-header',
					'priority'       => 15,
					'title'          => __( 'Sticky Logo', 'astra-addon' ),
					'library_filter' => array( 'gif', 'jpg', 'jpeg', 'png', 'ico' ),
					'required'       => array( ASTRA_THEME_SETTINGS . '[different-sticky-logo]', '==', 1 ),
				),

				/**
				 * Option: Different retina logo
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[different-sticky-retina-logo]',
					'default'  => false,
					'type'     => 'control',
					'section'  => 'section-sticky-header',
					'title'    => __( 'Different Logo for retina devices?', 'astra-addon' ),
					'priority' => 20,
					'control'  => 'checkbox',
					'required' => array( ASTRA_THEME_SETTINGS . '[different-sticky-logo]', '==', 1 ),
				),

				/**
				 * Option: Sticky header logo selector
				 */
				array(
					'name'           => ASTRA_THEME_SETTINGS . '[sticky-header-retina-logo]',
					'default'        => astra_get_option( 'sticky-header-retina-logo' ),
					'type'           => 'control',
					'control'        => 'image',
					'section'        => 'section-sticky-header',
					'priority'       => 20,
					'title'          => __( 'Sticky Retina Logo', 'astra-addon' ),
					'library_filter' => array( 'gif', 'jpg', 'jpeg', 'png', 'ico' ),
					'required'       => array( ASTRA_THEME_SETTINGS . '[different-sticky-retina-logo]', '==', 1 ),
				),

				/**
				 * Option: Sticky header logo width
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[sticky-header-logo-width]',
					'default'     => astra_get_option( 'sticky-header-logo-width' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'control'     => 'ast-responsive-slider',
					'section'     => 'section-sticky-header',
					'priority'    => 25,
					'title'       => __( 'Sticky Logo Width', 'astra-addon' ),
					'input_attrs' => array(
						'min'  => 50,
						'step' => 1,
						'max'  => 600,
					),
					'required'    => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[different-sticky-logo]', '==', 1 ),
							array( ASTRA_THEME_SETTINGS . '[different-sticky-retina-logo]', '==', 1 ),
						),
						'operator'   => 'OR',
					),
				),

				/**
				 * Option: Shrink Primary Header
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[header-main-shrink]',
					'default'     => astra_get_option( 'header-main-shrink' ),
					'type'        => 'control',
					'section'     => 'section-sticky-header',
					'title'       => __( 'Enable Shrink Effect', 'astra-addon' ),
					'priority'    => 35,
					'control'     => 'checkbox',
					'description' => __( 'It will shrink the sticky header height, logo, and menu size. Sticky header will display in a compact size.', 'astra-addon' ),
				),

				/**
				 * Option: Hide on scroll
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[sticky-hide-on-scroll]',
					'default'  => astra_get_option( 'sticky-hide-on-scroll' ),
					'type'     => 'control',
					'section'  => 'section-sticky-header',
					'title'    => __( 'Hide When Scrolling Down', 'astra-addon' ),
					'priority' => 35,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Enable disable mobile header
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[sticky-header-style]',
					'default'  => astra_get_option( 'sticky-header-style' ),
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'section-sticky-header',
					'priority' => 40,
					'title'    => __( 'Select Animation', 'astra-addon' ),
					'choices'  => array(
						'none'  => __( 'None', 'astra-addon' ),
						'slide' => __( 'Slide', 'astra-addon' ),
						'fade'  => __( 'Fade', 'astra-addon' ),
					),
					'required' => array( ASTRA_THEME_SETTINGS . '[sticky-hide-on-scroll]', '!=', 1 ),
				),

				/**
				 * Option: Sticky Header Display On
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[sticky-header-on-devices]',
					'default'  => astra_get_option( 'sticky-header-on-devices' ),
					'type'     => 'control',
					'section'  => 'section-sticky-header',
					'priority' => 50,
					'title'    => __( 'Enable On', 'astra-addon' ),
					'control'  => 'select',
					'choices'  => array(
						'desktop' => __( 'Desktop', 'astra-addon' ),
						'mobile'  => __( 'Mobile', 'astra-addon' ),
						'both'    => __( 'Desktop + Mobile', 'astra-addon' ),
					),
				),

				/**
				 * Option: Sticky Header Button Colors Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[sticky-header-button-color-divider]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'section'  => 'section-sticky-header',
					'title'    => __( 'Header Button', 'astra-addon' ),
					'settings' => array(),
					'priority' => 55,
					'required' => array(
						array( ASTRA_THEME_SETTINGS . '[header-main-rt-section]', '==', 'button' ),
						array( ASTRA_THEME_SETTINGS . '[header-main-rt-section-button-style]', '===', 'custom-button' ),
					),
				),
				/**
				 * Group: Theme Button Colors Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[sticky-header-button-color-group]',
					'default'   => astra_get_option( 'sticky-header-button-color-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Colors', 'astra-addon' ),
					'section'   => 'section-sticky-header',
					'transport' => 'postMessage',
					'priority'  => 55,
					'required'  => array(
						array( ASTRA_THEME_SETTINGS . '[header-main-rt-section]', '==', 'button' ),
						array( ASTRA_THEME_SETTINGS . '[header-main-rt-section-button-style]', '===', 'custom-button' ),
					),
				),
				/**
				 * Group: Theme Button Border Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[sticky-header-button-border-group]',
					'default'   => astra_get_option( 'sticky-header-button-border-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Border', 'astra-addon' ),
					'section'   => 'section-sticky-header',
					'transport' => 'postMessage',
					'priority'  => 55,
					'required'  => array(
						array( ASTRA_THEME_SETTINGS . '[header-main-rt-section]', '==', 'button' ),
						array( ASTRA_THEME_SETTINGS . '[header-main-rt-section-button-style]', '===', 'custom-button' ),
					),
				),

				/**
				* Option: Button Text Color
				*/
				array(
					'name'      => 'header-main-rt-sticky-section-button-text-color',
					'transport' => 'postMessage',
					'default'   => astra_get_option( 'header-main-rt-sticky-section-button-text-color' ),
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[sticky-header-button-color-group]',
					'section'   => 'section-sticky-header',
					'tab'       => __( 'Normal', 'astra-addon' ),
					'control'   => 'ast-color',
					'priority'  => 10,
					'title'     => __( 'Text Color', 'astra-addon' ),
				),

				/**
				* Option: Button Text Hover Color
				*/
				array(
					'name'      => 'header-main-rt-sticky-section-button-text-h-color',
					'default'   => astra_get_option( 'header-main-rt-sticky-section-button-text-h-color' ),
					'transport' => 'postMessage',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[sticky-header-button-color-group]',
					'section'   => 'section-sticky-header',
					'tab'       => __( 'Hover', 'astra-addon' ),
					'control'   => 'ast-color',
					'priority'  => 10,
					'title'     => __( 'Text Color', 'astra-addon' ),
				),

				/**
				* Option: Button Background Color
				*/
				array(
					'name'      => 'header-main-rt-sticky-section-button-back-color',
					'default'   => astra_get_option( 'header-main-rt-sticky-section-button-back-color' ),
					'transport' => 'postMessage',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[sticky-header-button-color-group]',
					'section'   => 'section-sticky-header',
					'tab'       => __( 'Normal', 'astra-addon' ),
					'control'   => 'ast-color',
					'priority'  => 10,
					'title'     => __( 'Background Color', 'astra-addon' ),
				),

				/**
				* Option: Button Button Hover Color
				*/
				array(
					'name'      => 'header-main-rt-sticky-section-button-back-h-color',
					'default'   => astra_get_option( 'header-main-rt-sticky-section-button-back-h-color' ),
					'transport' => 'postMessage',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[sticky-header-button-color-group]',
					'section'   => 'section-sticky-header',
					'tab'       => __( 'Hover', 'astra-addon' ),
					'control'   => 'ast-color',
					'priority'  => 10,
					'title'     => __( 'Background Color', 'astra-addon' ),
				),
				// Option: Custom Menu Button Border.
				array(
					'type'           => 'control',
					'control'        => 'ast-responsive-spacing',
					'name'           => ASTRA_THEME_SETTINGS . '[header-main-rt-sticky-section-button-padding]',
					'section'        => 'section-sticky-header',
					'transport'      => 'postMessage',
					'linked_choices' => true,
					'priority'       => 55,
					'required'       => array( ASTRA_THEME_SETTINGS . '[header-main-rt-section-button-style]', '===', 'custom-button' ),
					'default'        => astra_get_option( 'header-main-rt-sticky-section-button-padding' ),
					'title'          => __( 'Padding', 'astra-addon' ),
					'choices'        => array(
						'top'    => __( 'Top', 'astra-addon' ),
						'right'  => __( 'Right', 'astra-addon' ),
						'bottom' => __( 'Bottom', 'astra-addon' ),
						'left'   => __( 'Left', 'astra-addon' ),
					),
				),

				/**
				* Option: Button Border Size
				*/
				array(
					'type'           => 'sub-control',
					'parent'         => ASTRA_THEME_SETTINGS . '[sticky-header-button-border-group]',
					'section'        => 'section-sticky-header',
					'control'        => 'ast-border',
					'name'           => 'header-main-rt-sticky-section-button-border-size',
					'transport'      => 'postMessage',
					'linked_choices' => true,
					'priority'       => 10,
					'default'        => astra_get_option( 'header-main-rt-sticky-section-button-border-size' ),
					'title'          => __( 'Width', 'astra-addon' ),
					'choices'        => array(
						'top'    => __( 'Top', 'astra-addon' ),
						'right'  => __( 'Right', 'astra-addon' ),
						'bottom' => __( 'Bottom', 'astra-addon' ),
						'left'   => __( 'Left', 'astra-addon' ),
					),
				),

				/**
				* Option: Button Border Color
				*/
				array(
					'name'      => 'header-main-rt-sticky-section-button-border-color',
					'default'   => astra_get_option( 'header-main-rt-sticky-section-button-border-color' ),
					'transport' => 'postMessage',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[sticky-header-button-border-group]',
					'section'   => 'section-sticky-header',
					'control'   => 'ast-color',
					'priority'  => 12,
					'title'     => __( 'Color', 'astra-addon' ),
				),

				/**
				* Option: Button Border Hover Color
				*/
				array(
					'name'      => 'header-main-rt-sticky-section-button-border-h-color',
					'default'   => astra_get_option( 'header-main-rt-sticky-section-button-border-h-color' ),
					'transport' => 'postMessage',
					'type'      => 'sub-control',
					'parent'    => ASTRA_THEME_SETTINGS . '[sticky-header-button-border-group]',
					'section'   => 'section-sticky-header',
					'control'   => 'ast-color',
					'priority'  => 14,
					'title'     => __( 'Hover Color', 'astra-addon' ),
				),

				/**
				* Option: Button Border Radius
				*/
				array(
					'name'        => 'header-main-rt-sticky-section-button-border-radius',
					'default'     => astra_get_option( 'header-main-rt-sticky-section-button-border-radius' ),
					'type'        => 'sub-control',
					'parent'      => ASTRA_THEME_SETTINGS . '[sticky-header-button-border-group]',
					'section'     => 'section-sticky-header',
					'control'     => 'ast-slider',
					'transport'   => 'postMessage',
					'priority'    => 16,
					'title'       => __( 'Border Radius', 'astra-addon' ),
					'input_attrs' => array(
						'min'  => 0,
						'step' => 1,
						'max'  => 100,
					),
				),

			);

			return array_merge( $configurations, $_config );
		}

		/**
		 * Is Header Section addon active.
		 * Decide if the Above & Below option should be visible in Sticky Header depending on Header Section addon.
		 *
		 * @return boolean  True - If the option should be displayed, False - If the option should be hidden.
		 */
		public static function is_header_section_active() {
			$status = false;
			if ( Astra_Ext_Extension::is_active( 'header-sections' ) ) {
				$status = true;
			}
			return $status;
		}

	}
}

new Astra_Sticky_Header_Configs();



