<?php
/**
 * Advanced Footer Options for our theme.
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

if ( ! class_exists( 'Astra_Advanced_Footer_Configs' ) ) {

	/**
	 * Register Advanced Footer Customizer Configurations.
	 */
	class Astra_Advanced_Footer_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Advanced Footer Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_config = array(
				/**
				 * Option: Footer Widgets Layout
				 */
				array(
					'name'    => ASTRA_THEME_SETTINGS . '[footer-adv]',
					'default' => astra_get_option( 'footer-adv' ),
					'type'    => 'control',
					'control' => 'ast-radio-image',
					'title'   => __( 'Layout', 'astra-addon' ),
					'section' => 'section-footer-adv',
					'choices' => array(
						'disabled' => array(
							'label' => __( 'Disable', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"> <g> <g> <path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/> </g> </g> <path fill="#0085BA" d="M60.25,19.5c-11.581,0-21,9.419-21,21c0,11.578,9.419,21,21,21c11.578,0,21-9.422,21-21 C81.25,28.919,71.828,19.5,60.25,19.5z M42.308,40.5c0-9.892,8.05-17.942,17.942-17.942c4.412,0,8.452,1.6,11.578,4.249 L46.557,52.078C43.908,48.952,42.308,44.912,42.308,40.5z M60.25,58.439c-4.385,0-8.407-1.579-11.526-4.201l25.265-25.265 c2.622,3.12,4.201,7.141,4.201,11.526C78.189,50.392,70.142,58.439,60.25,58.439z"/> </svg>',
						),
						'layout-1' => array(
							'label' => __( 'Layout 1', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549 h112.902c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g></g></g><g><path fill="#0085BA" d="M111.064,70c0,1.657-1.354,3-3.023,3H12.458c-1.669,0-3.023-1.343-3.023-3V58.25c0-1.656,1.354-3,3.023-3 h95.583c1.67,0,3.023,1.344,3.023,3V70z"/></g></g><g><rect x="0.607" y="48" fill="#0085BA" width="119.285" height="1"/></g></svg>',
						),
						'layout-2' => array(
							'label' => __( 'Layout 2', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g></g></g><g><path fill="#0085BA" d="M57.064,70c0,1.657-1.354,3-3.023,3H12.458c-1.669,0-3.023-1.343-3.023-3V58.25c0-1.656,1.354-3,3.023-3 h41.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M111.064,70c0,1.657-1.354,3-3.023,3H66.457c-1.668,0-3.022-1.343-3.022-3V58.25c0-1.656,1.354-3,3.022-3 h41.584c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><rect x="0.607" y="48" fill="#0085BA" width="119.285" height="1"/></g></svg>',
						),
						'layout-3' => array(
							'label' => __( 'Layout 3', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g></g></g><g><path fill="#0085BA" d="M38.064,70c0,1.657-1.354,3-3.023,3H12.458c-1.669,0-3.023-1.343-3.023-3V58.25c0-1.656,1.354-3,3.023-3 h22.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M111.064,70c0,1.657-1.354,3-3.023,3H85.458c-1.669,0-3.022-1.343-3.022-3V58.25c0-1.656,1.354-3,3.022-3 h22.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M74.564,70c0,1.657-1.354,3-3.023,3H48.958c-1.669,0-3.022-1.343-3.022-3V58.25c0-1.656,1.354-3,3.022-3 h22.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><rect x="0.607" y="48" fill="#0085BA" width="119.285" height="1"/></g></svg>',
						),
						'layout-4' => array(
							'label' => __( 'Layout 4', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g></g></g><g><path fill="#0085BA" d="M28.064,70c0,1.657-1.354,3-3.023,3H12.458c-1.669,0-3.023-1.343-3.023-3V58.25c0-1.656,1.354-3,3.023-3 h12.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M55.731,70c0,1.657-1.354,3-3.023,3H40.125c-1.669,0-3.023-1.343-3.023-3V58.25c0-1.656,1.354-3,3.023-3 h12.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M83.397,70c0,1.657-1.354,3-3.023,3H67.791c-1.669,0-3.022-1.343-3.022-3V58.25c0-1.656,1.354-3,3.022-3 h12.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M111.064,70c0,1.657-1.354,3-3.023,3H95.458c-1.669,0-3.022-1.343-3.022-3V58.25c0-1.656,1.354-3,3.022-3 h12.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><rect x="0.607" y="48" fill="#0085BA" width="119.285" height="1"/></g></svg>',
						),
						'layout-5' => array(
							'label' => __( 'Layout 5', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g></g></g><g><path fill="#0085BA" d="M23.064,70c0,1.657-1.354,3-3.023,3h-7.583c-1.669,0-3.023-1.343-3.023-3V58.25c0-1.656,1.354-3,3.023-3 h7.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M45.064,70c0,1.657-1.354,3-3.023,3h-7.583c-1.669,0-3.023-1.343-3.023-3V58.25c0-1.656,1.354-3,3.023-3 h7.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M67.064,70c0,1.657-1.354,3-3.023,3h-7.583c-1.669,0-3.023-1.343-3.023-3V58.25c0-1.656,1.354-3,3.023-3 h7.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M89.064,70c0,1.657-1.354,3-3.023,3h-7.583c-1.669,0-3.023-1.343-3.023-3V58.25c0-1.656,1.354-3,3.023-3 h7.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M111.064,70c0,1.657-1.354,3-3.023,3h-7.583c-1.669,0-3.023-1.343-3.023-3V58.25c0-1.656,1.354-3,3.023-3 h7.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><rect x="0.607" y="48" fill="#0085BA" width="119.285" height="1"/></g></svg>',
						),
						'layout-6' => array(
							'label' => __( 'Layout 6', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g></g></g><g><path fill="#0085BA" d="M54.064,70c0,1.657-1.354,3-3.023,3H12.458c-1.669,0-3.023-1.343-3.023-3V58.25c0-1.656,1.354-3,3.023-3 h38.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M83.064,70c0,1.657-1.354,3-3.023,3H64.457c-1.668,0-3.022-1.343-3.022-3V58.25c0-1.656,1.354-3,3.022-3 h15.584c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M111.064,70c0,1.657-1.354,3-3.023,3H92.457c-1.668,0-3.022-1.343-3.022-3V58.25c0-1.656,1.354-3,3.022-3 h15.584c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><rect x="0.607" y="48" fill="#0085BA" width="119.285" height="1"/></g></svg>',
						),
						'layout-7' => array(
							'label' => __( 'Layout 7', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g></g></g><g><path fill="#0085BA" d="M54.064,70c0,1.657-1.354,3-3.023,3H12.458c-1.669,0-3.023-1.343-3.023-3v-5.75c0-1.656,1.354-3,3.023-3 h38.583c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M83.064,70c0,1.657-1.354,3-3.023,3H64.457c-1.668,0-3.021-1.343-3.021-3v-5.75c0-1.656,1.354-3,3.021-3 h15.584c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><path fill="#0085BA" d="M111.064,70c0,1.657-1.354,3-3.023,3H92.457c-1.668,0-3.021-1.343-3.021-3v-5.75c0-1.656,1.354-3,3.021-3 h15.584c1.67,0,3.023,1.344,3.023,3V70z"/></g><g><rect x="0.607" y="48" fill="#0085BA" width="119.286" height="1"/></g><g><path fill="#0085BA" d="M109.197,56.563H11.304c-0.979,0-1.774-0.672-1.774-1.5s0.795-1.5,1.774-1.5h97.895 c0.979,0,1.772,0.672,1.772,1.5S110.176,56.563,109.197,56.563z"/></g></svg>',
						),
					),
				),

				/**
				 * Option: Footer Widgets Width
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[footer-adv-layout-width]',
					'default'  => astra_get_option( 'footer-adv-layout-width' ),
					'type'     => 'control',
					'control'  => 'select',
					'section'  => 'section-footer-adv',
					'title'    => __( 'Width', 'astra-addon' ),
					'choices'  => array(
						'full'    => __( 'Full Width', 'astra-addon' ),
						'content' => __( 'Content Width', 'astra-addon' ),
					),
					'required' => array( ASTRA_THEME_SETTINGS . '[footer-adv]', '!=', 'disabled' ),
				),

				/**
				 * Footer Widgets Padding
				 *
				 * @since 1.2.0 Updated to support responsive spacing param
				 */
				array(
					'name'           => ASTRA_THEME_SETTINGS . '[footer-adv-area-padding]',
					'default'        => astra_get_option( 'footer-adv-area-padding' ),
					'type'           => 'control',
					'transport'      => 'postMessage',
					'control'        => 'ast-responsive-spacing',
					'section'        => 'section-footer-adv',
					'title'          => __( 'Padding', 'astra-addon' ),
					'linked_choices' => true,
					'unit_choices'   => array( 'px', 'em', '%' ),
					'choices'        => array(
						'top'    => __( 'Top', 'astra-addon' ),
						'right'  => __( 'Right', 'astra-addon' ),
						'bottom' => __( 'Bottom', 'astra-addon' ),
						'left'   => __( 'Left', 'astra-addon' ),
					),
					'required'       => array( ASTRA_THEME_SETTINGS . '[footer-adv]', '!=', 'disabled' ),
				),
			);

			return array_merge( $configurations, $_config );
		}

	}
}

new Astra_Advanced_Footer_Configs();



