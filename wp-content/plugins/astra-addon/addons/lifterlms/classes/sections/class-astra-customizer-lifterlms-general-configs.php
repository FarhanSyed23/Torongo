<?php
/**
 * LifterLMS General Options for our theme.
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

/**
 * Customizer Sanitizes
 *
 * @since 1.4.3
 */
if ( ! class_exists( 'Astra_Customizer_Lifterlms_General_Configs' ) ) {

	/**
	 * Register General Customizer Configurations.
	 */
	class Astra_Customizer_Lifterlms_General_Configs extends Astra_Customizer_Config_Base {

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
				 * Option: Shop Columns
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[llms-course-grid]',
					'default'     => array(
						'desktop' => 3,
						'tablet'  => 2,
						'mobile'  => 1,
					),
					'type'        => 'control',
					'control'     => 'ast-responsive-slider',
					'section'     => 'section-lifterlms-general',
					'title'       => __( 'Course Columns', 'astra-addon' ),
					'priority'    => 5,
					'input_attrs' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 6,
					),
				),

				/**
				 * Option: Shop Columns
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[llms-membership-grid]',
					'default'     => array(
						'desktop' => 3,
						'tablet'  => 2,
						'mobile'  => 1,
					),
					'type'        => 'control',
					'control'     => 'ast-responsive-slider',
					'section'     => 'section-lifterlms-general',
					'title'       => __( 'Membership Columns', 'astra-addon' ),
					'priority'    => 5,
					'input_attrs' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 6,
					),
				),

				/**
				 * Option: Enable Header Profile Link
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[lifterlms-profile-link-enabled]',
					'default'  => astra_get_option( 'lifterlms-profile-link-enabled' ),
					'type'     => 'control',
					'control'  => 'checkbox',
					'section'  => 'section-lifterlms-general',
					'title'    => __( 'Enable Header Profile Link', 'astra-addon' ),
					'priority' => 5,
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[lifterlms-distraction-free-checkout-divider]',
					'section'  => 'section-lifterlms-general',
					'title'    => __( 'Checkout', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-divider',
					'priority' => 10,
					'settings' => array(),
				),

				/**
				 * Option: Distraction Free Checkout
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[lifterlms-distraction-free-checkout]',
					'default'  => astra_get_option( 'lifterlms-distraction-free-checkout' ),
					'type'     => 'control',
					'control'  => 'checkbox',
					'section'  => 'section-lifterlms-general',
					'title'    => __( 'Distraction Free Checkout', 'astra-addon' ),
					'priority' => 10,
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[lifterlms-my-account-vertical-divider]',
					'section'  => 'section-lifterlms-general',
					'title'    => __( 'My Account', 'astra-addon' ),
					'type'     => 'control',
					'control'  => 'ast-divider',
					'priority' => 15,
					'settings' => array(),
				),

				/**
				 * Option: Enable Vertical Tab
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[lifterlms-my-account-vertical]',
					'default'  => astra_get_option( 'lifterlms-my-account-vertical' ),
					'type'     => 'control',
					'control'  => 'checkbox',
					'section'  => 'section-lifterlms-general',
					'title'    => __( 'Display Tabs Vertically', 'astra-addon' ),
					'priority' => 15,
				),

			);

			return array_merge( $configurations, $_configs );
		}
	}
}

/**
 * Kicking this off by calling 'get_instance()' method
 */
new Astra_Customizer_Lifterlms_General_Configs();
