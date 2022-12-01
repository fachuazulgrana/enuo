<?php
define( 'WP_AUTO_UPDATE_CORE', 'minor' );// This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress website is not managed by WordPress Toolkit anymore.
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
define( 'DB_NAME', "oasystec_enuo" );

/** MySQL database username */
define( 'DB_USER', "oasystec_admin" );

/** MySQL database password */
define( 'DB_PASSWORD', "ciclon.7710" );

/** MySQL hostname */
define( 'DB_HOST', "localhost" );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',         'jjsuwecvohsu14p9vxckhackvjgg0kmk6epwxt01wllynprueoldvau66g39ctis' );
define( 'SECURE_AUTH_KEY',  '3b0m4hstdgk14ys2wudzmzzvbejfv9kcpuiivg0j6xilwnjb3i1s7eqrkkfchaxl' );
define( 'LOGGED_IN_KEY',    'jwidcyqcl6qwp3ozh095xbulsirqzjrf5h0vu3eqjcdksdwlvjkhth4g8nxhee5l' );
define( 'NONCE_KEY',        'bdq2la5xkx0x8xwrl6ht97fwefiudcgvbbbd2kzwzns5zdbcntid7l7erdn7dg1t' );
define( 'AUTH_SALT',        'xpvy7ibaueb0jy0atro7to0dil3xwnvoms4oxa4czjl5rhcxgexn6mcscbv09le7' );
define( 'SECURE_AUTH_SALT', 'f7yoa0etjvtmdv3fufthmruupspx0owaqa1hhyvfu2zvojzq1vz9yp0vprsdvuel' );
define( 'LOGGED_IN_SALT',   'qqxtwanep00xhurboth2ivhttoj1zbetmnegpsaw9cmsofngvheragbvcbbz5qfb' );
define( 'NONCE_SALT',       'cf1eykkpxdyf2iqwdjrpsfmdh4ig38ijwh5a0tzl8buo7pnkelievewq0uam6opn' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'en0722_';

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
