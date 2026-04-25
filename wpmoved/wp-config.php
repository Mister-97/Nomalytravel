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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u394640813_chyhd' );

/** Database username */
define( 'DB_USER', 'u394640813_XtRwq' );

/** Database password */
define( 'DB_PASSWORD', 'K1yMrDBFBC' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          ';)8RNJ]^!~{vc`A~-+Vc*fH,QI/^y!}yj_g4yY6>Sw1BT(rO9=&]plz:$Kf):Z&A' );
define( 'SECURE_AUTH_KEY',   '@q,OO6t#k.)]u5=y*!]!uS$mvy#Z^x.~/TU}_15^D?&Q.T8YCt1jx/u*WtW UjH=' );
define( 'LOGGED_IN_KEY',     '.XY^8NnuYg}a5iXT!Ou#(uQ^hdOu^4uENlICN(h<#x<;aS`6>hsei%>NvA8`+;a,' );
define( 'NONCE_KEY',         '?LRI+Pp(:c?wBF5mXfdmI(+pN)D-?~lr.876l)b]ra^a}C.u]o*|BsXV$G;Uj]5P' );
define( 'AUTH_SALT',         'Rx~y}VvPTO)R%1*_`!Kd(j6`qm*[Hs2LVs|aXZ8:Rc,kQWobU}D9_b!.+#a8KUy;' );
define( 'SECURE_AUTH_SALT',  '>y[tZiR4+g:3W{*}n3aaOjJ=xQJ1au VZ#&;.~jM-0o+W*+7}yZYzhHLL;j(A0SN' );
define( 'LOGGED_IN_SALT',    'V^Qc#X5nNxhs!9.h4gB)*&cem9#V1)en3FlZpKd)>9ed)%h 6NTIZLr$%KK$$>3c' );
define( 'NONCE_SALT',        'XE*U)kYs9Gi)67!o>}[Xn59TN7m3!MqSw%R!f2VnPVOE&y)wt= l1K-f|3D/Tky:' );
define( 'WP_CACHE_KEY_SALT', '$VRwSh3`,y%hC&Be=8/|.{x(scf/P}*K$,@MEb%2Dc@fk:y@C*dR^5)A1X[l%J Y' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'd4e5fb4511fb1597b3f9ffec6e5f4977' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
