<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mescam' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'UB=2Sy?P0PW3e~@O!9qb~R=,T/<h%~8|xlCJoFt%7lP{#g<4{nB0y>p2qfhnwQf}' );
define( 'SECURE_AUTH_KEY',  'l8.[MGKO-*/u?)F=!`3%Ka{Q?{m WN V^W#}7B`oA rJSIJHh-{D32s/vSIaK{6j' );
define( 'LOGGED_IN_KEY',    '4I)dz<hcVwyz5&P^x}9ccO$Tc}0P49LU$[w~;;^AWU&8N%MAYU^&fue/;VAn0)I&' );
define( 'NONCE_KEY',        'r6c}8{-?3;M9uZNITQW1=g})I|C%NWiSqXO}ySZ!rnUpr~AlX*cXq+v8m:g(IQyy' );
define( 'AUTH_SALT',        '%ND,K?&#nDWO.Oi{/nQl-xL3)hr}k/`kd @eO!+N1IpO.v8TI3gvP[bwh[8c<UI-' );
define( 'SECURE_AUTH_SALT', 'cphgJVD/~L.TJ?ioMLll.?dtXm8BznH/K A2^i@xy>&N|#YpJ$Y(jjdy2XT]SRt0' );
define( 'LOGGED_IN_SALT',   '3zXo@oFv9o[O>2Je1UdB#t`6p}z%bw_2h,8SWI$g]i! _%]s>ituCB9a!XKhM+J^' );
define( 'NONCE_SALT',       'mntjplbLt:/gl^y/?m9V+[x/sM>Kb!)+-],n9/foXZ,+6p1=Q;))T_NA2=pVR^v#' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
