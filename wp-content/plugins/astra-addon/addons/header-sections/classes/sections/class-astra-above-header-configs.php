<?php
/**
 * Above Header - Layout Options for our theme.
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


if ( ! class_exists( 'Astra_Above_Header_Configs' ) ) {

	/**
	 * Register Header Layout Customizer Configurations.
	 */
	class Astra_Above_Header_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Header Layout Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$sections = apply_filters(
				'astra_header_section_elements',
				array(
					''          => __( 'None', 'astra-addon' ),
					'menu'      => __( 'Menu', 'astra-addon' ),
					'search'    => __( 'Search', 'astra-addon' ),
					'text-html' => __( 'Text / HTML', 'astra-addon' ),
					'widget'    => __( 'Widget', 'astra-addon' ),
				),
				'above-header'
			);

			$_config = array(

				/**
				 * Option: Above Header Layout
				 */

				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-layout]',
					'section'  => 'section-above-header',
					'type'     => 'control',
					'control'  => 'ast-radio-image',
					'default'  => astra_get_option( 'above-header-layout' ),
					'priority' => 1,
					'title'    => __( 'Layout', 'astra-addon' ),
					'choices'  => array(
						'disabled'              => array(
							'label' => __( 'Disabled', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"> <g> <g> <path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/> </g> </g> <path fill="#0085BA" d="M60.25,19.5c-11.581,0-21,9.419-21,21c0,11.578,9.419,21,21,21c11.578,0,21-9.422,21-21 C81.25,28.919,71.828,19.5,60.25,19.5z M42.308,40.5c0-9.892,8.05-17.942,17.942-17.942c4.412,0,8.452,1.6,11.578,4.249 L46.557,52.078C43.908,48.952,42.308,44.912,42.308,40.5z M60.25,58.439c-4.385,0-8.407-1.579-11.526-4.201l25.265-25.265 c2.622,3.12,4.201,7.141,4.201,11.526C78.189,50.392,70.142,58.439,60.25,58.439z"/> </svg>',
						),
						'above-header-layout-1' => array(
							'label' => __( 'Layout 1', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><path fill="#0085BA" d="M116.701,80.797H3.799c-1.958,0-3.549-1.593-3.549-3.55V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.957,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.658,80.797,116.701,80.797z M3.799,1.979 c-0.979,0-1.775,0.795-1.775,1.774v73.494c0,0.979,0.796,1.774,1.775,1.774h112.902c0.979,0,1.773-0.795,1.773-1.774V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g><line fill="none" stroke="#0085BA" stroke-miterlimit="10" x1="0.25" y1="21.342" x2="119.535" y2="21.342"/><g><g><path fill="#0085BA" d="M116.701,80.797H3.799c-1.958,0-3.549-1.593-3.549-3.55V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.957,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.658,80.797,116.701,80.797z M3.799,1.979 c-0.979,0-1.775,0.795-1.775,1.774v73.494c0,0.979,0.796,1.774,1.775,1.774h112.902c0.979,0,1.773-0.795,1.773-1.774V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g><g><g><g><path fill="#0085BA" d="M61.41,13.6H14.52c-0.98,0-1.774-0.794-1.774-1.774s0.794-1.774,1.774-1.774h46.89 c0.98,0,1.773,0.794,1.773,1.774S62.389,13.6,61.41,13.6z"/></g></g><g><ellipse fill="#0085BA" cx="79.872" cy="11.826" rx="2.228" ry="2.188"/><ellipse fill="#0085BA" cx="88.422" cy="11.826" rx="2.228" ry="2.188"/><ellipse fill="#0085BA" cx="96.974" cy="11.826" rx="2.227" ry="2.188"/><ellipse fill="#0085BA" cx="105.525" cy="11.826" rx="2.229" ry="2.188"/></g></g></svg>',
						),
						'above-header-layout-2' => array(
							'label' => __( 'Layout 2', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><path fill="#0085BA" d="M116.701,80.797H3.799c-1.958,0-3.549-1.593-3.549-3.55V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.957,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.658,80.797,116.701,80.797z M3.799,1.979 c-0.979,0-1.775,0.795-1.775,1.774v73.494c0,0.979,0.796,1.774,1.775,1.774h112.902c0.979,0,1.773-0.795,1.773-1.774V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g><line fill="none" stroke="#0085BA" stroke-miterlimit="10" x1="0.25" y1="21.342" x2="119.535" y2="21.342"/><g><g><path fill="#0085BA" d="M116.701,80.797H3.799c-1.958,0-3.549-1.593-3.549-3.55V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.957,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.658,80.797,116.701,80.797z M3.799,1.979 c-0.979,0-1.775,0.795-1.775,1.774v73.494c0,0.979,0.796,1.774,1.775,1.774h112.902c0.979,0,1.773-0.795,1.773-1.774V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g><g><g><g><path fill="#0085BA" d="M83.695,13.6h-46.89c-0.98,0-1.774-0.794-1.774-1.774s0.794-1.774,1.774-1.774h46.89 c0.98,0,1.773,0.794,1.773,1.774S84.674,13.6,83.695,13.6z"/></g></g></g></svg>',
						),
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-layout-section-1-divider]',
					'type'     => 'control',
					'required' => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '!=', 'disabled' ),
					'control'  => 'ast-divider',
					'section'  => 'section-above-header',
					'title'    => __( 'Section 1', 'astra-addon' ),
					'priority' => 5,
					'settings' => array(),
				),

				/**
				 *  Section: Section
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-section-1]',
					'default'  => astra_get_option( 'above-header-section-1' ),
					'type'     => 'control',
					'required' => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '!=', 'disabled' ),
					'control'  => 'select',
					'section'  => 'section-above-header',
					'priority' => 35,
					'choices'  => $sections,
				),

				/**
				 * Option: Text/HTML
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-section-1-html]',
					'section'   => 'section-above-header',
					'type'      => 'control',
					'control'   => 'textarea',
					'transport' => 'postMessage',
					'default'   => astra_get_option( 'above-header-section-1-html' ),
					'priority'  => 50,
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '!=', 'disabled' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '==', 'text-html' ),
						),
					),
					'partial'   => array(
						'selector'            => '.ast-above-header-section-1 .user-select  .ast-custom-html',
						'container_inclusive' => false,
						'render_callback'     => array( 'Astra_Customizer_Header_Sections_Partials', '_render_above_header_section_1_html' ),
					),
					'title'     => __( 'Text/HTML', 'astra-addon' ),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-layout-section-2-divider]',
					'type'     => 'control',
					'control'  => 'ast-divider',
					'required' => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '==', 'above-header-layout-1' ),
					'section'  => 'section-above-header',
					'title'    => __( 'Section 2', 'astra-addon' ),
					'priority' => 55,
					'settings' => array(),
				),

				/**
				 * Option: Section 2
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-section-2]',
					'type'     => 'control',
					'control'  => 'select',
					'required' => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '==', 'above-header-layout-1' ),
					'section'  => 'section-above-header',
					'priority' => 60,
					'default'  => astra_get_option( 'above-header-section-2' ),
					'choices'  => $sections,
				),

				/**
				 * Option: Text/HTML
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-section-2-html]',
					'type'      => 'control',
					'control'   => 'textarea',
					'transport' => 'postMessage',
					'section'   => 'section-above-header',
					'default'   => astra_get_option( 'above-header-section-2-html' ),
					'priority'  => 75,
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '!=', 'disabled' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '==', 'text-html' ),
						),
					),
					'partial'   => array(
						'selector'            => '.ast-above-header-section-2 .user-select .ast-custom-html',
						'container_inclusive' => false,
						'render_callback'     => array( 'Astra_Customizer_Header_Sections_Partials', '_render_above_header_section_2_html' ),
					),
					'title'     => __( 'Text/HTML', 'astra-addon' ),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[section-ast-above-header-border]',
					'type'     => 'control',
					'control'  => 'ast-divider',
					'required' => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '!=', 'disabled' ),
					'section'  => 'section-above-header',
					'priority' => 80,
					'settings' => array(),
				),

				/**
				 * Option: Above Header Height
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[above-header-height]',
					'section'     => 'section-above-header',
					'priority'    => 84,
					'transport'   => 'postMessage',
					'title'       => __( 'Height', 'astra-addon' ),
					'default'     => 40,
					'required'    => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '!=', 'disabled' ),
					'type'        => 'control',
					'control'     => 'ast-slider',
					'suffix'      => '',
					'input_attrs' => array(
						'min'  => 30,
						'step' => 1,
						'max'  => 600,
					),
				),

				/**
				 * Option: Above Header Bottom Border
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[above-header-divider]',
					'section'     => 'section-above-header',
					'priority'    => 85,
					'transport'   => 'postMessage',
					'required'    => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '!=', 'disabled' ),
					'default'     => astra_get_option( 'above-header-divider' ),
					'title'       => __( 'Bottom Border', 'astra-addon' ),
					'type'        => 'control',
					'control'     => 'ast-slider',
					'input_attrs' => array(
						'min'  => 0,
						'step' => 1,
						'max'  => 600,
					),
				),

				/**
				 * Option: Above Header Bottom Border Color
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-divider-color]',
					'type'      => 'control',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'default'   => '',
					'required'  => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '!=', 'disabled' ),
					'section'   => 'section-above-header',
					'priority'  => 90,
					'title'     => __( 'Bottom Border Color', 'astra-addon' ),
				),

				/**
				 * Option: Header Styling
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-typography-menu-styling-heading]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'required' => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '!=', 'disabled' ),
					'section'  => 'section-above-header',
					'title'    => __( 'Typography', 'astra-addon' ),
					'priority' => 132,
					'settings' => array(),
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
				),

				/**
				 * Option: Above Header Menu Typography Styling
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-typography-menu-styling]',
					'default'   => astra_get_option( 'above-header-typography-menu-styling' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Menu', 'astra-addon' ),
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

				/**
				 * Option: Above Header Submenu Typography Styling
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-typography-submenu-styling]',
					'default'   => astra_get_option( 'above-header-typography-submenu-styling' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Submenu', 'astra-addon' ),
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

				/**
				 * Option: Header Styling
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-colors-and-background]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'required' => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '!=', 'disabled' ),
					'section'  => 'section-above-header',
					'title'    => __( 'Colors and background', 'astra-addon' ),
					'priority' => 131,
					'settings' => array(),
				),

				/**
				 * Option: Above Header Content Section Styling
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-background-styling]',
					'default'   => astra_get_option( 'above-header-background-styling' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Background', 'astra-addon' ),
					'section'   => 'section-above-header',
					'transport' => 'postMessage',
					'priority'  => 131,
					'required'  => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '!=', 'disabled' ),
				),

				/**
				 * Option: Above Header Menus Styling
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-menu-colors]',
					'default'   => astra_get_option( 'above-header-menu-colors' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Menu', 'astra-addon' ),
					'section'   => 'section-above-header',
					'transport' => 'postMessage',
					'priority'  => 131,
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
				),

				/**
				 * Option: Above Header Menus Styling
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-submenu-colors]',
					'default'   => astra_get_option( 'above-header-submenu-colors' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Submenu', 'astra-addon' ),
					'section'   => 'section-above-header',
					'transport' => 'postMessage',
					'priority'  => 131,
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
				),

				/**
				 * Option: Above Header Content Section Styling
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-content-section-styling]',
					'default'   => astra_get_option( 'above-header-content-section-styling' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Content', 'astra-addon' ),
					'section'   => 'section-above-header',
					'transport' => 'postMessage',
					'priority'  => 131,
					'required'  => array(
						'conditions' => array(
							array(
								ASTRA_THEME_SETTINGS . '[above-header-section-1]',
								'==',
								array( 'search', 'widget', 'text-html', 'edd' ),
							),
							array(
								ASTRA_THEME_SETTINGS . '[above-header-section-2]',
								'==',
								array( 'search', 'widget', 'text-html', 'edd' ),
							),
						),
						'operator'   => 'OR',
					),
				),

				/**
				 * Option: Above Header Submenu Border Divier
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-submenu-border-divider]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'title'    => __( 'Submenu', 'astra-addon' ),
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
					'section'  => 'section-above-header',
					'priority' => 95,
					'settings' => array(),
				),

				/**
				 * Option: Submenu Container Animation
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-submenu-container-animation]',
					'default'  => astra_get_option( 'above-header-submenu-container-animation' ),
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'section-above-header',
					'priority' => 95,
					'title'    => __( 'Submenu Container Animation', 'astra-addon' ),
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
					'choices'  => array(
						''           => __( 'Default', 'astra-addon' ),
						'slide-down' => __( 'Slide Down', 'astra-addon' ),
						'slide-up'   => __( 'Slide Up', 'astra-addon' ),
						'fade'       => __( 'Fade', 'astra-addon' ),
					),
				),

				/**
				 * Option: Submenu Border
				 */
				array(
					'name'           => ASTRA_THEME_SETTINGS . '[above-header-submenu-border]',
					'type'           => 'control',
					'control'        => 'ast-border',
					'transport'      => 'postMessage',
					'required'       => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
					'section'        => 'section-above-header',
					'default'        => astra_get_option( 'above-header-submenu-border' ),
					'title'          => __( 'Container Border', 'astra-addon' ),
					'linked_choices' => true,
					'priority'       => 95,
					'choices'        => array(
						'top'    => __( 'Top', 'astra-addon' ),
						'right'  => __( 'Right', 'astra-addon' ),
						'bottom' => __( 'Bottom', 'astra-addon' ),
						'left'   => __( 'Left', 'astra-addon' ),
					),
				),

				/**
				 * Option: Submenu Border Color
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-submenu-border-color]',
					'type'      => 'control',
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
					'control'   => 'ast-color',
					'default'   => astra_get_option( 'above-header-submenu-border-color' ),
					'priority'  => 95,
					'transport' => 'postMessage',
					'section'   => 'section-above-header',
					'title'     => __( 'Border Color', 'astra-addon' ),
				),

				/**
				 * Option: Submenu Divider
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-submenu-item-border]',
					'type'      => 'control',
					'control'   => 'checkbox',
					'transport' => 'postMessage',
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
					'section'   => 'section-above-header',
					'default'   => astra_get_option( 'above-header-submenu-item-border' ),
					'title'     => __( 'Submenu Divider', 'astra-addon' ),
					'priority'  => 95,
				),

				/**
				 * Option: Submenu Border Color
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-submenu-item-b-color]',
					'type'      => 'control',
					'required'  => array(
						ASTRA_THEME_SETTINGS . '[above-header-submenu-item-border]',
						'==',
						true,
					),
					'control'   => 'ast-color',
					'default'   => astra_get_option( 'above-header-submenu-item-b-color' ),
					'priority'  => 95,
					'transport' => 'postMessage',
					'section'   => 'section-above-header',
					'title'     => __( 'Divider Color', 'astra-addon' ),
				),

				/**
				 * Option: Mobile Menu Label Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-mobile-menu-divider]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '!=', '' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '!=', '' ),
						),
						'operator'   => 'OR',
					),

					'section'  => 'section-above-header',
					'title'    => __( 'Mobile Header', 'astra-addon' ),
					'priority' => 100,
					'settings' => array(),
				),

				/**
				 * Option: Display Above Header on Mobile
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-on-mobile]',
					'type'     => 'control',
					'control'  => 'checkbox',
					'default'  => astra_get_option( 'above-header-on-mobile' ),
					'section'  => 'section-above-header',
					'title'    => __( 'Display on Mobile Devices', 'astra-addon' ),
					'priority' => 101,
				),

				/**
				 * Option: Merged with primary header menu
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[above-header-merge-menu]',
					'default'     => astra_get_option( 'above-header-merge-menu' ),
					'type'        => 'control',
					'control'     => 'checkbox',
					'required'    => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
					'section'     => 'section-above-header',
					'title'       => __( 'Merge Menu on Mobile Devices', 'astra-addon' ),
					'description' => __( 'You can merge menu with primary menu in mobile devices by enabling this option.', 'astra-addon' ),
					'priority'    => 101,
				),

				/**
				 * Option: Swap section on mobile devices
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-swap-mobile]',
					'type'     => 'control',
					'control'  => 'checkbox',
					'required' => array( ASTRA_THEME_SETTINGS . '[above-header-layout]', '==', 'above-header-layout-1' ),
					'section'  => 'section-above-header',
					'default'  => astra_get_option( 'above-header-section-swap-mobile' ),
					'title'    => __( 'Swap Sections on Mobile Devices', 'astra-addon' ),
					'priority' => 101,
				),

				/**
				 * Option: Mobile Menu Alignment
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[above-header-menu-align]',
					'default'  => astra_get_option( 'above-header-menu-align' ),
					'section'  => 'section-above-header',
					'priority' => 101,
					'title'    => __( 'Layout', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-radio-image',
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-section-1]', '!=', '' ),
							array( ASTRA_THEME_SETTINGS . '[above-header-section-2]', '!=', '' ),
						),
						'operator'   => 'OR',
					),
					'choices'  => array(
						'inline' => array(
							'label' => __( 'Inline', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="60.5px" height="81px" viewBox="0 0 60.5 81" enable-background="new 0 0 60.5 81" xml:space="preserve"><g><g><g><path fill="#0085BA" d="M51.602,12.975H40.884c-0.493,0-0.892-0.429-0.892-0.959c0-0.529,0.396-0.959,0.892-0.959h10.718 c0.496,0,0.896,0.432,0.896,0.959C52.496,12.546,52.098,12.975,51.602,12.975z"/></g></g><g><g><path fill="#0085BA" d="M51.602,17.205H40.884c-0.493,0-0.892-0.429-0.892-0.959c0-0.529,0.396-0.959,0.892-0.959h10.718 c0.496,0,0.896,0.432,0.896,0.959C52.496,16.775,52.098,17.205,51.602,17.205z"/></g></g><g><g><path fill="#0085BA" d="M51.602,21.435H40.884c-0.493,0-0.892-0.429-0.892-0.959c0-0.529,0.396-0.959,0.892-0.959h10.718 c0.496,0,0.896,0.432,0.896,0.959C52.496,21.004,52.098,21.435,51.602,21.435z"/></g></g></g><g><path fill="#0085BA" d="M25.504,20.933c0,1.161-0.794,2.099-1.773,2.099H9.777c-0.979,0-1.773-0.938-1.773-2.099V11.56 c0-1.16,0.795-2.1,1.773-2.1H23.73c0.979,0,1.772,0.94,1.772,2.1L25.504,20.933L25.504,20.933z"/></g><g><path fill="#0085BA" d="M56.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h52.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C60.25,79.204,58.657,80.796,56.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.774,1.773,1.774h52.902c0.979,0,1.773-0.797,1.773-1.774V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></svg>',
						),
						'stack'  => array(
							'label' => __( 'Stack', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="60.5px" height="81px" viewBox="0 0 60.5 81" enable-background="new 0 0 60.5 81" xml:space="preserve"><g><path fill="#0085BA" d="M56.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h52.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C60.25,79.204,58.657,80.796,56.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.774,1.773,1.774h52.902c0.979,0,1.773-0.797,1.773-1.774V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g><g><g><g><path fill="#0085BA" d="M35.607,29.821H24.889c-0.493,0-0.892-0.429-0.892-0.959c0-0.529,0.396-0.959,0.892-0.959h10.718 c0.496,0,0.896,0.432,0.896,0.959C36.502,29.392,36.104,29.821,35.607,29.821z"/></g></g><g><g><path fill="#0085BA" d="M35.607,34.051H24.889c-0.493,0-0.892-0.429-0.892-0.959c0-0.529,0.396-0.959,0.892-0.959h10.718 c0.496,0,0.896,0.432,0.896,0.959C36.502,33.621,36.104,34.051,35.607,34.051z"/></g></g><g><g><path fill="#0085BA" d="M35.607,38.281H24.889c-0.493,0-0.892-0.429-0.892-0.959c0-0.529,0.396-0.959,0.892-0.959h10.718 c0.496,0,0.896,0.432,0.896,0.959C36.502,37.85,36.104,38.281,35.607,38.281z"/></g></g></g><g><path fill="#0085BA" d="M39,20.933c0,1.161-0.794,2.099-1.773,2.099H23.273c-0.979,0-1.773-0.938-1.773-2.099V11.56 c0-1.16,0.795-2.1,1.773-2.1h13.954c0.979,0,1.771,0.94,1.771,2.1L39,20.933L39,20.933z"/></g></svg>',
						),
					),
				),

				/**
				 * Option: Mobile Menu Label
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[above-header-menu-label]',
					'type'      => 'control',
					'control'   => 'text',
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[above-header-on-mobile]', '==', true ),
							array( ASTRA_THEME_SETTINGS . '[above-header-merge-menu]', '!=', true ),
						),
					),
					'section'   => 'section-above-header',
					'default'   => astra_get_option( 'above-header-menu-label' ),
					'transport' => 'postMessage',
					'priority'  => 101,
					'title'     => __( 'Menu Label', 'astra-addon' ),
				),
			);

			return array_merge( $configurations, $_config );
		}

	}
}

new Astra_Above_Header_Configs();
