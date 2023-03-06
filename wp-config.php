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
define( 'DB_NAME', 'GoStore' );

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
define( 'AUTH_KEY',         '0mI7Zp~Jc@Z|xpr!qoCML*b}t`_cy(>=HZ6Xh,#+T3m^;|^LO2FV&p)WWC<k}I[~' );
define( 'SECURE_AUTH_KEY',  ']#/Jfytqr8{O}-t@LS::PND_qu3<hBbf7.@|y((4EbTrNSfYn:7{>tlsgaZO:4U7' );
define( 'LOGGED_IN_KEY',    'Ne>}1ud)oG||BD%jz_|)6v>%QkYpP2/oC>M#Nj:&3]mp3?V V;:kl<{*rm=evp!9' );
define( 'NONCE_KEY',        'Dx+[AxPa%0L&ZGimNE E|k-i%@E^)c~H/$8~.m:Ltyg,[I5N([M^ZdoG]yHu11WP' );
define( 'AUTH_SALT',        '[4TRc9I5x6lJ,cRo%l9]|yv=VomLMu+})@]y-x)ZPgu{mg$:x>zsqmV:^nSkx</L' );
define( 'SECURE_AUTH_SALT', ')8,QJ[ReCRl|d{Ff_mly$9FRc|yhinjqR[pdI`X%J8GfY7&h^d}Q,8 QX {wp.[ ' );
define( 'LOGGED_IN_SALT',   '@:En/[mY,m]FYqamva%$$8V;`Zy^zG|n?#TvHIIPAE/>xHuCVur6YuK/m(].uEZZ' );
define( 'NONCE_SALT',       '~ha`oNVTKR:9}T,x%i[hLvzh/Wtdf$4(>>7w,JgldR,.|t 01wOnj&&0QM)M4Y=l' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_GoStore';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
