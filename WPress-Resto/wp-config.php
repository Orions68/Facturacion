<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wpresstest' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'Anubis@68' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Dt0yziFWHai~@MsD[R?#|F~Ex]/FXK?RS*ez4>:TI3K_mO%q8vZ}x:}9A3/Ix?CW' );
define( 'SECURE_AUTH_KEY',  '<dVg&4__LUrE8qPEC?|X}HvXjd#(#r@Fh_!sjX}&ANw39oijr!a}Ke_>cT[OeD(:' );
define( 'LOGGED_IN_KEY',    'o0*R9j*M>}}9vHvl=[@*P}c+7iX;WA4YW&[~:TQ{&#g47hqX9g(B{.c3q}/8_t}<' );
define( 'NONCE_KEY',        '3!mTTcMqOI*[V_mh{uiyD6,l4@n]zM2G,f$ sCk^qYKX?@Zp~1R-0c1{fucJE.1g' );
define( 'AUTH_SALT',        '-2WPa-DN,#,6R:WIyA*5cBJ-r#CfvzE$|I0y2]:O:cJd*N.++<lTvR888<gkOP$X' );
define( 'SECURE_AUTH_SALT', '*2Kf7_f{#)sFwz{ QPE~Lx?~}Y$SVsug|UKx0a*Pc<[$`El6@+XVGe?,#f)wb/Iy' );
define( 'LOGGED_IN_SALT',   'BV7gucgnx.o4z?)sqv@s(&@`5.>v< V<7gWglyDEWrU|q)Vs)W>_QN}Ov|Azw;Zx' );
define( 'NONCE_SALT',       '_6EtKq(g0-dH%+`;-r)8IZxyZ 0f%dvvb0?xi[*8}|jW/+)tff[j-<ITfM|}wd:K' );

/**#@-*/

/**
 * WordPress database table prefix.
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
define( 'WP_MEMORY_LIMIT', '128M' );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
