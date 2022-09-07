<?php
/**
 * Plugin Name: Astra Pro
 * Plugin URI: https://wpastra.com/
 * Description: This plugin is an add-on for the Astra WordPress Theme. It offers premium features & functionalities that enhance your theming experience at next level.
 * Version: 2.5.0
 * Author: Brainstorm Force
 * Author URI: https://www.brainstormforce.com
 * Text Domain: astra-addon
 *
 * @package Astra Addon
 */

if ( 'astra' !== get_template() ) {
	return;
}

/**
 * Set constants.
 */
define( 'ASTRA_EXT_FILE', __FILE__ );
define( 'ASTRA_EXT_BASE', plugin_basename( ASTRA_EXT_FILE ) );
define( 'ASTRA_EXT_DIR', plugin_dir_path( ASTRA_EXT_FILE ) );
define( 'ASTRA_EXT_URI', plugins_url( '/', ASTRA_EXT_FILE ) );
define( 'ASTRA_EXT_VER', '2.5.0' );
define( 'ASTRA_EXT_TEMPLATE_DEBUG_MODE', false );


/**
 * Minimum Version requirement of the Astra Theme.
 * This will display the notice askinng user to update the theme to latest version.
 */
define( 'ASTRA_THEME_MIN_VER', '2.4.4' );

// 'ast-container' has 20px left, right padding. For pixel perfect added ( twice ) 40px padding to the 'ast-container'.
// E.g. If width set 1200px then with padding left ( 20px ) & right ( 20px ) its 1240px for 'ast-container'. But, Actual contents are 1200px.
define( 'ASTRA_THEME_CONTAINER_PADDING', 20 );
define( 'ASTRA_THEME_CONTAINER_PADDING_TWICE', ( 20 * 2 ) );
define( 'ASTRA_THEME_CONTAINER_BOX_PADDED_PADDING', 40 );
define( 'ASTRA_THEME_CONTAINER_BOX_PADDED_PADDING_TWICE', ( 40 * 2 ) );

/**
 * Update Astra Addon
 */
require_once ASTRA_EXT_DIR . 'classes/class-astra-addon-update.php';
require_once ASTRA_EXT_DIR . 'classes/astra-addon-update-functions.php';
require_once ASTRA_EXT_DIR . 'classes/class-astra-addon-background-updater.php';

/**
 * Extensions
 */
require_once ASTRA_EXT_DIR . 'classes/class-astra-theme-extension.php';

/**
 * Load deprecated functions
 */
require_once ASTRA_EXT_DIR . 'classes/deprecated/deprecated-functions.php';

/**
 * Brainstorm Updater.
 */
require_once ASTRA_EXT_DIR . 'class-brainstorm-update-astra-addon.php';
