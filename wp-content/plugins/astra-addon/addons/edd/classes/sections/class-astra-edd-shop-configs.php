<?php
/**
 * Shop Options for our theme.
 *
 * @package     Astra Addon
 * @author      Brainstorm Force
 * @copyright   Copyright (c) 2020, Brainstorm Force
 * @link        https://www.brainstormforce.com
 * @since       Astra 1.6.10
 */

// Block direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bail if Customizer config base class does not exist.
if ( ! class_exists( 'Astra_Customizer_Config_Base' ) ) {
	return;
}

if ( ! class_exists( 'Astra_Edd_Shop_Configs' ) ) {

	/**
	 * Register Easy Digital Downloads Shop Layout Configurations.
	 */
	class Astra_Edd_Shop_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Easy Digital Downloads Shop Layout Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.6.10
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			$_configs = array(

				/**
				 * Option: Choose Product Style
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[edd-archive-style]',
					'default'  => astra_get_option( 'edd-archive-style' ),
					'type'     => 'control',
					'section'  => 'section-edd-archive',
					'title'    => __( 'Layout', 'astra-addon' ),
					'control'  => 'ast-radio-image',
					'priority' => 5,
					'choices'  => array(
						'edd-archive-page-grid-style' => array(
							'label' => __( 'Grid View', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M116.701,80.796H3.799c-1.957,0-3.549-1.592-3.549-3.549V3.753c0-1.957,1.592-3.549,3.549-3.549h112.902 c1.956,0,3.549,1.592,3.549,3.549v73.494C120.25,79.204,118.657,80.796,116.701,80.796z M3.799,1.979 c-0.979,0-1.773,0.797-1.773,1.774v73.494c0,0.979,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.797,1.773-1.772V3.753 c0-0.979-0.795-1.774-1.773-1.774H3.799z"/></g></g></g><g><g><path fill="#0586BB" d="M93.548,38.73c0,0.977-0.823,1.77-1.84,1.77H28.79c-1.016,0-1.838-0.793-1.838-1.77V20.037 c0-0.977,0.822-1.77,1.838-1.77h62.918c1.017,0,1.84,0.793,1.84,1.77V38.73z"/></g><g><path fill="#0586BB" d="M91.846,53.198H28.655c-0.807,0-1.456-0.692-1.456-1.541s0.649-1.541,1.456-1.541h63.191 c0.805,0,1.454,0.692,1.454,1.541C93.301,52.506,92.65,53.198,91.846,53.198z"/></g><g><path fill="#0586BB" d="M87.941,62.732H32.766c-0.808,0-1.456-0.691-1.456-1.541s0.648-1.541,1.456-1.541h55.177 c0.808,0,1.457,0.691,1.457,1.541S88.75,62.732,87.941,62.732z"/></g></g></g></svg>',
						),
						'edd-archive-page-list-style' => array(
							'label' => __( 'List View', 'astra-addon' ),
							'path'  => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" role="img" id="Layer_1" x="0px" y="0px" width="120.5px" height="81px" viewBox="0 0 120.5 81" enable-background="new 0 0 120.5 81" xml:space="preserve"><g><g><g><g><path fill="#0085BA" d="M0.25,77.247V3.753c0-1.957,1.593-3.549,3.549-3.549h112.902c1.957,0,3.549,1.592,3.549,3.549v73.494 c0,1.957-1.592,3.549-3.549,3.549H3.799C1.843,80.796,0.25,79.204,0.25,77.247z M3.799,1.979c-0.979,0-1.773,0.795-1.773,1.774 v73.494c0,0.976,0.795,1.772,1.773,1.772h112.902c0.979,0,1.773-0.793,1.773-1.772V3.753c0-0.977-0.795-1.774-1.773-1.774H3.799 z"/></g></g></g><g><g><g><path fill="#0085BA" d="M99.371,42.385h-31.36c-0.874,0-1.583-0.708-1.583-1.582c0-0.873,0.709-1.582,1.583-1.582h31.36 c0.873,0,1.58,0.709,1.58,1.582C100.951,41.677,100.243,42.385,99.371,42.385z"/></g><g><path fill="#0085BA" d="M99.371,31.667h-31.36c-0.874,0-1.583-0.708-1.583-1.582c0-0.873,0.709-1.582,1.583-1.582h31.36 c0.873,0,1.58,0.709,1.58,1.582S100.243,31.667,99.371,31.667z"/></g><g><path fill="#0085BA" d="M99.371,53.104H75.012c-0.875,0-1.584-0.709-1.584-1.582s0.709-1.582,1.584-1.582h24.359 c0.873,0,1.58,0.709,1.58,1.582S100.243,53.104,99.371,53.104z"/></g></g><g><path fill="#0085BA" d="M53.611,59.336c0,1.217-0.987,2.203-2.204,2.203H21.753c-1.217,0-2.204-0.986-2.204-2.203v-37.67 c0-1.217,0.987-2.205,2.204-2.205h29.654c1.217,0,2.204,0.987,2.204,2.205V59.336z"/></g></g></g></svg>',
						),
					),
				),

				/**
				 * Option: EDD Archive Post override-heading to display notice
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]',
					'type'        => 'control',
					'control'     => 'ast-sortable',
					'section'     => 'section-edd-archive',
					'default'     => astra_get_option( 'edd-archive-product-structure' ),
					'priority'    => 30,
					'title'       => __( 'Product Structure', 'astra-addon' ),
					'description' => __( 'The Image option cannot be sortable if the Product Style is selected to the List Style ', 'astra-addon' ),
					'choices'     => array(
						'image'      => __( 'Image', 'astra-addon' ),
						'title'      => __( 'Title', 'astra-addon' ),
						'price'      => __( 'Price', 'astra-addon' ),
						'short_desc' => __( 'Short Description', 'astra-addon' ),
						'add_cart'   => __( 'Add To Cart', 'astra-addon' ),
						'category'   => __( 'Category', 'astra-addon' ),
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[edd-archive-box-styling-divider]',
					'section'  => 'section-edd-archive',
					'title'    => __( 'Product Styling', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-heading',
					'priority' => 75,
					'settings' => array(),
				),

				/**
				 * Option: Content Alignment
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[edd-archive-product-align]',
					'default'   => astra_get_option( 'edd-archive-product-align' ),
					'type'      => 'control',
					'transport' => 'postMessage',
					'control'   => 'select',
					'section'   => 'section-edd-archive',
					'priority'  => 80,
					'title'     => __( 'Content Alignment', 'astra-addon' ),
					'choices'   => array(
						'align-left'   => __( 'Left', 'astra-addon' ),
						'align-center' => __( 'Center', 'astra-addon' ),
						'align-right'  => __( 'Right', 'astra-addon' ),
					),
				),

				/**
				 * Option: Box shadow
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[edd-archive-product-shadow]',
					'default'     => astra_get_option( 'edd-archive-product-shadow' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'control'     => 'ast-slider',
					'title'       => __( 'Box Shadow', 'astra-addon' ),
					'section'     => 'section-edd-archive',
					'suffix'      => '',
					'priority'    => 85,
					'input_attrs' => array(
						'min'  => 0,
						'step' => 1,
						'max'  => 5,
					),
				),

				/**
				 * Option: Box hover shadow
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[edd-archive-product-shadow-hover]',
					'default'     => astra_get_option( 'edd-archive-product-shadow-hover' ),
					'type'        => 'control',
					'transport'   => 'postMessage',
					'control'     => 'ast-slider',
					'title'       => __( 'Box Hover Shadow', 'astra-addon' ),
					'section'     => 'section-edd-archive',
					'suffix'      => '',
					'priority'    => 90,
					'input_attrs' => array(
						'min'  => 0,
						'step' => 1,
						'max'  => 5,
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[edd-archive-button-divider]',
					'section'  => 'section-edd-archive',
					'title'    => __( 'Button', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-heading',
					'priority' => 110,
					'settings' => array(),
				),

				/**
				 * Option: Vertical Padding
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[edd-archive-button-v-padding]',
					'default'           => astra_get_option( 'edd-archive-button-v-padding' ),
					'type'              => 'control',
					'transport'         => 'postMessage',
					'section'           => 'section-edd-archive',
					'title'             => __( 'Vertical Padding', 'astra-addon' ),
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_number_n_blank' ),
					'control'           => 'ast-slider',
					'priority'          => 110,
					'input_attrs'       => array(
						'min'  => 1,
						'step' => 1,
						'max'  => 200,
					),
				),

				/**
				 * Option: Horizontal Padding
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[edd-archive-button-h-padding]',
					'default'           => astra_get_option( 'edd-archive-button-h-padding' ),
					'type'              => 'control',
					'transport'         => 'postMessage',
					'section'           => 'section-edd-archive',
					'priority'          => 110,
					'title'             => __( 'Horizontal Padding', 'astra-addon' ),
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_number_n_blank' ),
					'control'           => 'ast-slider',
					'input_attrs'       => array(
						'min'  => 1,
						'step' => 1,
						'max'  => 200,
					),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[edd-archive-meta-divider]',
					'section'  => 'section-edd-archive',
					'type'     => 'control',
					'control'  => 'ast-divider',
					'priority' => 29,
					'settings' => array(),
				),

				/**
				 * Option: Display Page Title
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[edd-archive-page-title-display]',
					'default'  => astra_get_option( 'edd-archive-page-title-display' ),
					'type'     => 'control',
					'section'  => 'section-edd-archive',
					'title'    => __( 'Display Page Title', 'astra-addon' ),
					'priority' => 29,
					'control'  => 'checkbox',
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[edd-archive-colors-heading]',
					'section'  => 'section-edd-archive',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'title'    => __( 'Colors', 'astra-addon' ),
					'priority' => 230,
					'settings' => array(),
				),

				/**
				 * Option: EDD Archive Page Color Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[edd-archive-colors]',
					'default'   => astra_get_option( 'edd-archive-colors' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Product', 'astra-addon' ),
					'section'   => 'section-edd-archive',
					'transport' => 'postMessage',
					'priority'  => 231,
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[edd-archive-typo-heading]',
					'section'  => 'section-edd-archive',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'title'    => __( 'Typography', 'astra-addon' ),
					'priority' => 232,
					'settings' => array(),
				),

				/**
				 * Option: EDD Product Title Typography
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[edd-archive-product-title-typo]',
					'default'   => astra_get_option( 'edd-archive-product-title-typo' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Product Title', 'astra-addon' ),
					'section'   => 'section-edd-archive',
					'transport' => 'postMessage',
					'priority'  => 233,
				),

				/**
				 * Option: EDD Product Price Typography
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[edd-archive-product-price-typo]',
					'default'   => astra_get_option( 'edd-archive-product-price-typo' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Product Price', 'astra-addon' ),
					'section'   => 'section-edd-archive',
					'transport' => 'postMessage',
					'priority'  => 233,
				),

				/**
				 * Option: EDD Product Content Typography
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[edd-archive-product-content-typo]',
					'default'   => astra_get_option( 'edd-archive-product-content-typo' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Product Content', 'astra-addon' ),
					'section'   => 'section-edd-archive',
					'transport' => 'postMessage',
					'required'  => array(
						'conditions' => array(
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'category' ),
							array( ASTRA_THEME_SETTINGS . '[edd-archive-product-structure]', 'contains', 'structure' ),
						),
						'operator'   => 'OR',
					),
					'priority'  => 233,
				),
			);

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;

		}
	}
}


new Astra_Edd_Shop_Configs();





