<?php
/**
 * Blog Pro General Options for our theme.
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
if ( ! class_exists( 'Astra_Customizer_Colors_Archive' ) ) {

	/**
	 * Register General Customizer Configurations.
	 */
	class Astra_Customizer_Colors_Archive extends Astra_Customizer_Config_Base {

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
				 * Option: Blog Color Section heading
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[blog-color-heading-divider]',
					'type'     => 'control',
					'control'  => 'ast-heading',
					'section'  => 'section-blog',
					'title'    => __( 'Colors and Background', 'astra-addon' ),
					'priority' => 125,
					'settings' => array(),
				),

				/**
				 * Option: Blog / Archive Color Group
				 */
				array(
					'name'      => ASTRA_THEME_SETTINGS . '[blog-content-color-group]',
					'default'   => astra_get_option( 'blog-content-color-group' ),
					'type'      => 'control',
					'control'   => 'ast-settings-group',
					'title'     => __( 'Content', 'astra-addon' ),
					'section'   => 'section-blog',
					'transport' => 'postMessage',
					'priority'  => 130,
				),

				// Option: Divider.
				array(
					'control'  => 'ast-divider',
					'default'  => '',
					'name'     => 'divider-blog-archive',
					'type'     => 'sub-control',
					'parent'   => ASTRA_THEME_SETTINGS . '[blog-content-color-group]',
					'section'  => 'section-blog',
					'title'    => __( 'Archive Summary Box', 'astra-addon' ),
					'tab'      => __( 'Normal', 'astra-addon' ),
					'section'  => 'section-blog',
					'priority' => 11,
					'settings' => array(),
				),

				// Option: Archive Summary Box Background Color.
				array(
					'name'        => 'archive-summary-box-bg-color',
					'default'     => '',
					'tab'         => __( 'Normal', 'astra-addon' ),
					'priority'    => 11,
					'type'        => 'sub-control',
					'parent'      => ASTRA_THEME_SETTINGS . '[blog-content-color-group]',
					'section'     => 'section-blog',
					'transport'   => 'postMessage',
					'control'     => 'ast-color',
					'title'       => __( 'Background Color', 'astra-addon' ),
					'description' => __( 'This background color will not work on full-width layout.', 'astra-addon' ),
				),

				// Option: Archive Summary Box Title Color.
				array(
					'type'      => 'sub-control',
					'tab'       => __( 'Normal', 'astra-addon' ),
					'priority'  => 11,
					'parent'    => ASTRA_THEME_SETTINGS . '[blog-content-color-group]',
					'section'   => 'section-blog',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'name'      => 'archive-summary-box-title-color',
					'default'   => '',
					'title'     => __( 'Title Color', 'astra-addon' ),
				),

				// Option: Archive Summary Box Description Color.
				array(
					'type'      => 'sub-control',
					'tab'       => __( 'Normal', 'astra-addon' ),
					'priority'  => 11,
					'parent'    => ASTRA_THEME_SETTINGS . '[blog-content-color-group]',
					'section'   => 'section-blog',
					'control'   => 'ast-color',
					'transport' => 'postMessage',
					'name'      => 'archive-summary-box-text-color',
					'default'   => '',
					'title'     => __( 'Description Color', 'astra-addon' ),
				),

				// Option: Blog / Archive Post Title Color.
				array(
					'type'      => 'sub-control',
					'tab'       => __( 'Normal', 'astra-addon' ),
					'priority'  => 10,
					'parent'    => ASTRA_THEME_SETTINGS . '[blog-content-color-group]',
					'section'   => 'section-blog',
					'control'   => 'ast-color',
					'default'   => '',
					'transport' => 'postMessage',
					'name'      => 'page-title-color',
					'title'     => __( 'Post Title Color', 'astra-addon' ),
				),

				// Option: Post Meta Color.
				array(
					'type'      => 'sub-control',
					'tab'       => __( 'Normal', 'astra-addon' ),
					'priority'  => 10,
					'parent'    => ASTRA_THEME_SETTINGS . '[blog-content-color-group]',
					'section'   => 'section-blog',
					'control'   => 'ast-color',
					'default'   => '',
					'transport' => 'postMessage',
					'name'      => 'post-meta-color',
					'title'     => __( 'Meta Color', 'astra-addon' ),
				),

				// Option: Post Meta Link Color.
				array(
					'type'      => 'sub-control',
					'tab'       => __( 'Normal', 'astra-addon' ),
					'priority'  => 10,
					'parent'    => ASTRA_THEME_SETTINGS . '[blog-content-color-group]',
					'section'   => 'section-blog',
					'control'   => 'ast-color',
					'default'   => '',
					'transport' => 'postMessage',
					'name'      => 'post-meta-link-color',
					'title'     => __( 'Meta Link Color', 'astra-addon' ),
				),

				// Option: Post Meta Link Hover Color.
				array(
					'type'      => 'sub-control',
					'tab'       => __( 'Hover', 'astra-addon' ),
					'priority'  => 12,
					'parent'    => ASTRA_THEME_SETTINGS . '[blog-content-color-group]',
					'section'   => 'section-blog',
					'control'   => 'ast-color',
					'default'   => '',
					'transport' => 'postMessage',
					'name'      => 'post-meta-link-h-color',
					'title'     => __( 'Meta Link Color', 'astra-addon' ),
				),
			);

			return array_merge( $configurations, $_configs );
		}
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
new Astra_Customizer_Colors_Archive();
