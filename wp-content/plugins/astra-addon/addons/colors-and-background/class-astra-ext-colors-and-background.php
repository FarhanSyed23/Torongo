<?php
/**
 * Colors & Background Extension
 *
 * @package Astra Addon
 */

define( 'ASTRA_EXT_COLORS_DIR', ASTRA_EXT_DIR . 'addons/colors-and-background/' );
define( 'ASTRA_EXT_COLORS_URI', ASTRA_EXT_URI . 'addons/colors-and-background/' );

if ( ! class_exists( 'Astra_Ext_Colors_And_Background' ) ) {

	/**
	 * Colors & Background Initial Setup
	 *
	 * @since 1.0.0
	 */
	class Astra_Ext_Colors_And_Background {

		/**
		 * Member Variable
		 *
		 * @var object instance
		 */
		private static $instance;

		/**
		 *  Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor function that initializes required actions and hooks
		 */
		public function __construct() {
			require_once ASTRA_EXT_COLORS_DIR . 'classes/class-astra-ext-colors-loader.php';

			// Include front end files.
			if ( ! is_admin() ) {

				require_once ASTRA_EXT_COLORS_DIR . 'classes/dynamic-css/class-astra-addon-colors-dynamic-css.php';

				// Check Header Sections is activated.
				if ( Astra_Ext_Extension::is_active( 'header-sections' ) ) {
					// Dynamic css dependent on Header Sections.
					require_once ASTRA_EXT_COLORS_DIR . 'classes/dynamic-css/header-sections-dynamic.css.php';
				}
			}

		}
	}

	/**
	 *  Kicking this off by calling 'get_instance()' method
	 */
	Astra_Ext_Colors_And_Background::get_instance();

}
