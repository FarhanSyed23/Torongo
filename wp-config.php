<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'torongo' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'o/ecMcA%MX=EzV,![vJD7<:P(U^P2UddV`HXw`E3aVgXxB??gEa]+-f^^AYf{4TK' );
define( 'SECURE_AUTH_KEY',  'TQ>_G,uIhw!>EJC`q~_Jcam{(9/a:yK@*v6?6Oo(c~PXZ_6?9B[6x%01.@F<24gD' );
define( 'LOGGED_IN_KEY',    '3*L0)VNnw/Q>99eubGYg6T=3 IbY$!Xz:.U+~eyZWwBAt6nmTO-;{Kr __kA00Rn' );
define( 'NONCE_KEY',        '-axoyl$R:CJ/j7J-Pl,jE-a|w9pg_J9YJ>2QcV#+tSRCMfD<CvC:^NIvabgWj{_W' );
define( 'AUTH_SALT',        ';n 8^?U?Y+$Fu.FIXcp0vTj5ZA;,Q`v2vC2*<h7BMqj[eu),s;>;|A5i*K8RS|y[' );
define( 'SECURE_AUTH_SALT', '9|#`kp/`jj#yT6<lN&}HeYd}0YRR`DVawN91NDC 4:AfGvxiG%~U HLJIdWrgMR,' );
define( 'LOGGED_IN_SALT',   'Ac=H5&t%yY>NFydBxZJw_%8i#g24I,80N:g~`ad~};Zx9r%<R1x1C_SqIMw BtOt' );
define( 'NONCE_SALT',       'PmgWj$}o/r3}cY!CZY&Xj *(n%}qEn.J^oCpv)UQw6-ydy+zJ-/x0Y6/_cRG,Qrz' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
