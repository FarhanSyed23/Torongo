<?php
/**
 * Below Header - Layout Options for our theme.
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

if ( ! class_exists( 'Astra_Below_Header_Configs' ) ) {

	/**
	 * Register below header Configurations.
	 */
	class Astra_Below_Header_Configs extends Astra_Customizer_Config_Base {

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
					'none'      => __( 'None', 'astra-addon' ),
					'menu'      => __( 'Menu', 'astra-addon' ),
					'search'    => __( 'Search', 'astra-addon' ),
					'text-html' => __( 'Text / HTML', 'astra-addon' ),
					'widget'    => __( 'Widget', 'astra-addon' ),
				),
				'below-header'
			);

			$_config = array(

				/**
				 * Option: Below Header Layout
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-layout]',
					'section'  => 'section-below-header',
					'default'  => astra_get_option( 'below-header-layout' ),
					'priority' => 5,
					'title'    => __( 'Layout', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-radio-image',
					'choices'  => array(
						'disabled'              => array(
							'label' => __( 'Disabled', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"> <g> <g> <path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/> </g> </g> <path fill="#0085BA" d="M60.25,19.5c-11.581,0-21,9.419-21,21c0,11.578,9.419,21,21,21c11.578,0,21-9.422,21-21 C81.25,28.919,71.828,19.5,60.25,19.5z M42.308,40.5c0-9.892,8.05-17.942,17.942-17.942c4.412,0,8.452,1.6,11.578,4.249 L46.557,52.078C43.908,48.952,42.308,44.912,42.308,40.5z M60.25,58.439c-4.385,0-8.407-1.579-11.526-4.201l25.265-25.265 c2.622,3.12,4.201,7.141,4.201,11.526C78.189,50.392,70.142,58.439,60.25,58.439z"/> </svg>',
						),
						'below-header-layout-1' => array(
							'label' => __( 'Layout 1', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M60.434,31.931c0,0.979-0.715,1.773-1.598,1.773h-44.9c-0.884,0-1.599-0.794-1.599-1.773 s0.715-1.774,1.599-1.774h44.9C59.719,30.157,60.434,30.952,60.434,31.931z"/></g></g></g><g><ellipse fill="#0085BA" cx="80.618" cy="31.931" rx="2.202" ry="2.188"/><ellipse fill="#0085BA" cx="89.066" cy="31.931" rx="2.199" ry="2.188"/><ellipse fill="#0085BA" cx="97.516" cy="31.931" rx="2.199" ry="2.188"/><ellipse fill="#0085BA" cx="105.963" cy="31.931" rx="2.2" ry="2.188"/></g></g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.958,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.957,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.658,80.796,116.701,80.796z M3.798,1.979 c-0.979,0-1.774,0.795-1.774,1.774v73.494c0,0.979,0.795,1.774,1.774,1.774h112.901c0.979,0,1.775-0.795,1.775-1.774V3.753 c0-0.979-0.798-1.774-1.775-1.774H3.798z"/></g></g><line fill="none" x1="249.583" y1="-4.833" x2="249.583" y2="6"/><g><rect x="0.25" y="22.842" fill="#0085BA" width="119.285" height="1"/></g></svg>',
						),
						'below-header-layout-2' => array(
							'label' => __( 'Layout 2', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M99.299,31.931c0,0.979-0.715,1.773-1.598,1.773H22.8c-0.884,0-1.599-0.794-1.599-1.773 s0.715-1.774,1.599-1.774h74.901C98.584,30.157,99.299,30.952,99.299,31.931z"/></g></g></g></g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.958,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.957,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.658,80.796,116.701,80.796z M3.798,1.979 c-0.979,0-1.774,0.795-1.774,1.774v73.494c0,0.979,0.795,1.774,1.774,1.774h112.901c0.979,0,1.775-0.795,1.775-1.774V3.753 c0-0.979-0.798-1.774-1.775-1.774H3.798z"/></g></g><line fill="none" x1="249.583" y1="-4.833" x2="249.583" y2="6"/><g><rect x="0.25" y="22.842" fill="#0085BA" width="119.285" height="1"/></g></svg>',
						),
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-layout-section-1-divider]',
					'type'     => 'control',
					'control'  => 'ast-divider',
					'required' => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '!=', 'disabled' ),
					'section'  => 'section-below-header',
					'title'    => __( 'Section 1', 'astra-addon' ),
					'priority' => 10,
					'settings' => array(),
				),

				/**
				 * Option: Section 1
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-section-1]',
					'section'  => 'section-below-header',
					'type'     => 'control',
					'required' => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '!=', 'disabled' ),
					'control'  => 'select',
					'default'  => astra_get_option( 'below-header-section-1' ),
					'priority' => 15,
					'choices'  => $sections,
				),

				/**
				 * Option: Text/HTML
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-section-1-html]',
					'section'   => 'section-below-header',
					'default'   => astra_get_option( 'below-header-section-1-html' ),
					'priority'  => 20,
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '!=', 'disabled' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'text-html' ),
						),
					),
					'title'     => __( 'Text/HTML', 'astra-addon' ),
					'type'      => 'control',
					'control'   => 'textarea',
					'transport' => 'postMessage',
					'partial'   => array(
						'selector'            => '.below-header-section-1 .user-select .ast-custom-html',
						'container_inclusive' => false,
						'render_callback'     => array( 'Astra_Customizer_Header_Sections_Partials', '_render_below_header_section_1' ),
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-layout-section-2-divider]',
					'section'  => 'section-below-header',
					'title'    => __( 'Section 2', 'astra-addon' ),
					'priority' => 30,
					'required' => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '==', 'below-header-layout-1' ),
					'type'     => 'control',
					'control'  => 'ast-divider',
					'settings' => array(),
				),

				/**
				 * Option: Section 2
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-section-2]',
					'default'  => astra_get_option( 'below-header-section-2' ),
					'section'  => 'section-below-header',
					'priority' => 35,
					'required' => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '==', 'below-header-layout-1' ),
					'type'     => 'control',
					'control'  => 'select',
					'choices'  => $sections,
				),

				/**
				 * Option: Text/HTML
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-section-2-html]',
					'section'   => 'section-below-header',
					'type'      => 'control',
					'control'   => 'textarea',
					'transport' => 'postMessage',
					'default'   => astra_get_option( 'below-header-section-2-html' ),
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '==', 'below-header-layout-1' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'text-html' ),
						),
					),
					'partial'   => array(
						'selector'            => '.below-header-section-2 .user-select .ast-custom-html',
						'container_inclusive' => false,
						'render_callback'     => array( 'Astra_Customizer_Header_Sections_Partials', '_render_below_header_section_2' ),
					),
					'priority'  => 40,
					'title'     => __( 'Text/HTML', 'astra-addon' ),
				),

				/**
				 * Option: Below Header Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-layout-options-separator-divider]',
					'section'  => 'section-below-header',
					'priority' => 50,
					'required' => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '!=', 'disabled' ),
					'type'     => 'control',
					'control'  => 'ast-divider',
					'settings' => array(),
				),

				/**
				 * Option: Below Header Height
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[below-header-height]',
					'section'     => 'section-below-header',
					'transport'   => 'postMessage',
					'default'     => astra_get_option( 'below-header-height' ),
					'priority'    => 54,
					'required'    => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '!=', 'disabled' ),
					'title'       => __( 'Height', 'astra-addon' ),
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
				 * Option: Below Header Height
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[below-header-separator]',
					'section'     => 'section-below-header',
					'priority'    => 55,
					'transport'   => 'postMessage',
					'default'     => astra_get_option( 'below-header-separator' ),
					'title'       => __( 'Bottom Border', 'astra-addon' ),
					'type'        => 'control',
					'required'    => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '!=', 'disabled' ),
					'control'     => 'ast-slider',
					'input_attrs' => array(
						'min'  => 0,
						'step' => 1,
						'max'  => 600,
					),
				),

				/**
				 * Option: Bottom Border Color
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-bottom-border-color]',
					'transport' => 'postMessage',
					'default'   => '',
					'type'      => 'control',
					'required'  => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '!=', 'disabled' ),
					'control'   => 'ast-color',
					'section'   => 'section-below-header',
					'priority'  => 60,
					'title'     => __( 'Bottom Border Color', 'astra-addon' ),
				),

				/**
				 * Option: Below Header Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-submenu-border-divider]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'title'    => __( 'Submenu', 'astra-addon' ),
					'section'  => 'section-below-header',
					'priority' => 75,
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
					'settings' => array(),
				),

				// Option: Submenu Container Animation.
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-submenu-container-animation]',
					'default'  => astra_get_option( 'below-header-submenu-container-animation' ),
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'section-below-header',
					'priority' => 75,
					'title'    => __( 'Submenu Container Animation', 'astra-addon' ),
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
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
					'name'           => ASTRA_THEME_SETTINGS . '[below-header-submenu-border]',
					'default'        => astra_get_option( 'below-header-submenu-border' ),
					'type'           => 'control',
					'control'        => 'ast-border',
					'transport'      => 'postMessage',
					'priority'       => 75,
					'required'       => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
					'section'        => 'section-below-header',
					'title'          => __( 'Container Border', 'astra-addon' ),
					'linked_choices' => true,
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
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-submenu-border-color]',
					'type'      => 'control',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'priority'  => 75,
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
					'default'   => astra_get_option( 'below-header-submenu-border-color' ),
					'section'   => 'section-below-header',
					'title'     => __( 'Border Color', 'astra-addon' ),
				),

				/**
				 * Option: Submenu Divider
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-submenu-item-border]',
					'default'   => astra_get_option( 'below-header-submenu-item-border' ),
					'type'      => 'control',
					'control'   => 'checkbox',
					'transport' => 'postMessage',
					'priority'  => 75,
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
					'section'   => 'section-below-header',
					'title'     => __( 'Submenu Divider', 'astra-addon' ),
				),

				/**
				 * Option: Submenu Divider Color
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-submenu-item-b-color]',
					'type'      => 'control',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'priority'  => 75,
					'required'  => array(
						ASTRA_THEME_SETTINGS . '[below-header-submenu-item-border]',
						'==',
						true,
					),
					'default'   => astra_get_option( 'below-header-submenu-item-b-color' ),
					'section'   => 'section-below-header',
					'title'     => __( 'Divider Color', 'astra-addon' ),
				),

				// Option: Submenu Container Animation.
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-submenu-container-animation]',
					'default'  => astra_get_option( 'below-header-submenu-container-animation' ),
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'section-below-header',
					'priority' => 75,
					'title'    => __( 'Container Animation', 'astra-addon' ),
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
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
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-mobile-typography-divider]',
					'section'  => 'section-below-header',
					'type'     => 'control',
					'required' => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '!=', 'disabled' ),
					'control'  => 'ast-heading',
					'priority' => 137,
					'title'    => __( 'Typography', 'astra-addon' ),
					'settings' => array(),
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
							array(
								ASTRA_THEME_SETTINGS . '[below-header-section-1]',
								'==',
								array( 'search', 'text-html', 'widget' ),
							),
							array(
								ASTRA_THEME_SETTINGS . '[below-header-section-2]',
								'==',
								array( 'search', 'text-html', 'widget' ),
							),
						),
						'operator'   => 'OR',
					),
				),

				/**
				 * Option: Below Header Header Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-menu-typography-styling]',
					'default'   => astra_get_option( 'below-header-menu-typography-styling' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Menu', 'astra-addon' ),
					'section'   => 'section-below-header',
					'transport' => 'postMessage',
					'priority'  => 137,
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
				),

				/**
				 * Option: Below Header Header Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-submenu-typography-styling]',
					'default'   => astra_get_option( 'below-header-submenu-typography-styling' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Submenu', 'astra-addon' ),
					'section'   => 'section-below-header',
					'transport' => 'postMessage',
					'priority'  => 137,
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
				),

				/**
				 * Option: Below Header Header Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-content-typography-styling]',
					'default'   => astra_get_option( 'below-header-content-typography-styling' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Content', 'astra-addon' ),
					'section'   => 'section-below-header',
					'transport' => 'postMessage',
					'priority'  => 137,
					'required'  => array(
						'conditions' => array(
							array(
								ASTRA_THEME_SETTINGS . '[below-header-section-1]',
								'==',
								array( 'search', 'text-html', 'widget' ),
							),
							array(
								ASTRA_THEME_SETTINGS . '[below-header-section-2]',
								'==',
								array( 'search', 'text-html', 'widget' ),
							),
						),
						'operator'   => 'OR',
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-mobile-colors-divider]',
					'section'  => 'section-below-header',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'priority' => 136,
					'title'    => __( 'Colors and Background', 'astra-addon' ),
					'settings' => array(),
					'required' => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '!=', 'disabled' ),
				),

				/**
				 * Option: Below Header Header Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-background-group]',
					'default'   => astra_get_option( 'below-header-background-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Background', 'astra-addon' ),
					'section'   => 'section-below-header',
					'transport' => 'postMessage',
					'priority'  => 136,
					'required'  => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '!=', 'disabled' ),
				),

				/**
				 * Option: Below Header Menus Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-menus-group]',
					'default'   => astra_get_option( 'below-header-menus-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Menu', 'astra-addon' ),
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

				/**
				 * Option: Below Header Menus Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-submenus-group]',
					'default'   => astra_get_option( 'below-header-submenus-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Submenu', 'astra-addon' ),
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

				/**
				 * Option: Below Header Menus Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-content-group]',
					'default'   => astra_get_option( 'below-header-content-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Content', 'astra-addon' ),
					'section'   => 'section-below-header',
					'transport' => 'postMessage',
					'priority'  => 136,
					'required'  => array(
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
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-mobile-menu-divider]',
					'section'  => 'section-below-header',
					'type'     => 'control',
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '!=', 'none' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '!=', 'none' ),
						),
						'operator'   => 'OR',
					),
					'control'  => 'ast-heading',
					'priority' => 100,
					'title'    => __( 'Mobile Header', 'astra-addon' ),
					'settings' => array(),
				),

				/**
				 * Option: Display Below Header on Mobile
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-on-mobile]',
					'type'     => 'control',
					'control'  => 'checkbox',
					'default'  => astra_get_option( 'below-header-on-mobile' ),
					'section'  => 'section-below-header',
					'title'    => __( 'Display on Mobile Devices', 'astra-addon' ),
					'priority' => 105,
				),

				/**
				 * Option: Merged with primary header menu
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[below-header-merge-menu]',
					'type'        => 'control',
					'control'     => 'checkbox',
					'required'    => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '==', 'menu' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '==', 'menu' ),
						),
						'operator'   => 'OR',
					),
					'default'     => astra_get_option( 'below-header-merge-menu' ),
					'section'     => 'section-below-header',
					'title'       => __( 'Merge Menu on Mobile Devices', 'astra-addon' ),
					'description' => __( 'You can merge menu with primary menu in mobile devices by enabling this option.', 'astra-addon' ),
					'priority'    => 105,
				),
				/**
				 * Option: Swap section on mobile devices
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-swap-mobile]',
					'default'  => astra_get_option( 'below-header-section-swap-mobile' ),
					'type'     => 'control',
					'control'  => 'checkbox',
					'required' => array( ASTRA_THEME_SETTINGS . '[below-header-layout]', '==', 'below-header-layout-1' ),
					'section'  => 'section-below-header',
					'title'    => __( 'Swap Sections on Mobile Devices', 'astra-addon' ),
					'priority' => 105,
				),

				/**
				 * Option: Mobile Menu Alignment
				 */

				array(
					'name'     => ASTRA_THEME_SETTINGS . '[below-header-menu-align]',
					'section'  => 'section-below-header',
					'type'     => 'control',
					'control'  => 'ast-radio-image',
					'default'  => astra_get_option( 'below-header-menu-align' ),
					'priority' => 105,
					'required' => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-section-1]', '!=', 'none' ),
							array( ASTRA_THEME_SETTINGS . '[below-header-section-2]', '!=', 'none' ),
						),
						'operator'   => 'OR',
					),
					'title'    => __( 'Layout', 'astra-addon' ),
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
					'name'      => ASTRA_THEME_SETTINGS . '[below-header-menu-label]',
					'section'   => 'section-below-header',
					'type'      => 'control',
					'control'   => 'text',
					'transport' => 'postMessage',
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[below-header-on-mobile]', '==', true ),
							array( ASTRA_THEME_SETTINGS . '[below-header-merge-menu]', '!=', true ),
						),
					),
					'priority'  => 105,
					'default'   => astra_get_option( 'below-header-menu-label' ),
					'title'     => __( 'Menu Label', 'astra-addon' ),
				),
			);

			return array_merge( $configurations, $_config );
		}
	}
}

new Astra_Below_Header_Configs();


