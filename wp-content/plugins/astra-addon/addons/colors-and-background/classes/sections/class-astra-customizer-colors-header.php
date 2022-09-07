<?php
/**
 * Colors Header Options for our theme.
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
if ( ! class_exists( 'Astra_Customizer_Colors_Header' ) ) {

	/**
	 * Register General Customizer Configurations.
	 */
	class Astra_Customizer_Colors_Header extends Astra_Customizer_Config_Base {

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
					'name'      => ASTRA_THEME_SETTINGS . '[site-identity-title-color-group]',
					'default'   => astra_get_option( 'site-identity-title-color-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Colors', 'astra-addon' ),
					'section'   => 'title_tagline',
					'transport' => 'postMessage',
					'priority'  => 8,
					'required'  => array(
						ASTRA_THEME_SETTINGS . '[display-site-title]',
						'==',
						true,
					),
				),

				// Option: Site Title Color.
				array(
					'name'      => 'header-color-site-title',
					'parent'    => ASTRA_THEME_SETTINGS . '[site-identity-title-color-group]',
					'section'   => 'title_tagline',
					'type'      => 'sub-control',
					'control'   => 'ast-color',
					'default'   => '',
					'transport' => 'postMessage',
					'title'     => __( 'Title Color', 'astra-addon' ),
					'tab'       => __( 'Normal', 'astra-addon' ),
				),

				// Option: Site Title Hover Color.
				array(
					'name'      => 'header-color-h-site-title',
					'parent'    => ASTRA_THEME_SETTINGS . '[site-identity-title-color-group]',
					'section'   => 'title_tagline',
					'type'      => 'sub-control',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'default'   => '',
					'title'     => __( 'Title Color', 'astra-addon' ),
					'tab'       => __( 'Hover', 'astra-addon' ),
				),

				// Option: Site Tagline Color.
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[header-color-site-tagline]',
					'type'      => 'control',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'default'   => '',
					'title'     => __( 'Tagline Color', 'astra-addon' ),
					'section'   => 'title_tagline',
					'required'  => array(
						ASTRA_THEME_SETTINGS . '[display-site-tagline]',
						'==',
						true,
					),
					'priority'  => 15,
				),

				/**
				 * Option: Primary Header color and background divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[primary-header-colors-and-background-divider]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'section'  => 'section-header',
					'title'    => __( 'Color', 'astra-addon' ),
					'priority' => 71,
					'settings' => array(),
				),

				array(
					'name'      => ASTRA_THEME_SETTINGS . '[primary-header-background-group]',
					'default'   => astra_get_option( 'primary-header-background-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Background', 'astra-addon' ),
					'section'   => 'section-header',
					'transport' => 'postMessage',
					'priority'  => 71,
				),

				array(
					'name'       => 'header-bg-obj-responsive',
					'parent'     => ASTRA_THEME_SETTINGS . '[primary-header-background-group]',
					'section'    => 'section-header',
					'type'       => 'sub-control',
					'control'    => 'ast-responsive-background',
					'transport'  => 'postMessage',
					'data_attrs' => array(
						'name' => 'header-bg-obj-responsive',
					),
					'default'    => $defaults['header-bg-obj-responsive'],
					'label'      => __( 'Background', 'astra-addon' ),
				),
			);

			return array_merge( $configurations, $_configs );
		}
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
new Astra_Customizer_Colors_Header();
