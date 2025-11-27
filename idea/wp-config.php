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
define( 'DB_NAME', 'hamg9221_wp854' );

/** Database username */
define( 'DB_USER', 'hamg9221_wp854' );

/** Database password */
define( 'DB_PASSWORD', 'gl[p4Sb45]' );

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
define( 'AUTH_KEY',         '37t8rijuqvr45c3tgnwkiyn6phmbkewpkf2ax5j5qap0aaevyzu6n7kzvmwvq2st' );
define( 'SECURE_AUTH_KEY',  'atd6hgjwkyl6fwiksvned00l2alh9tgkorr3nfce1wtoaemrhnlqpr6cwux8il8k' );
define( 'LOGGED_IN_KEY',    'me7ozexsfeznvuy6exh95ay8dervuy7kh71gk8lg4gmkn9mpcw6oqxvslo8xwdwd' );
define( 'NONCE_KEY',        'ldaib6q88zitbcku79txzfbmcxqhbxg7askqwhkxmdt6bbfmauq9xunms0a4foug' );
define( 'AUTH_SALT',        'zp9l7j9gzeypxkgsbivo38sripb28rmvwwh2blyrt8sjebqpfif6loabgvbz9ohq' );
define( 'SECURE_AUTH_SALT', 'c2ma7wwp9nfpudarorxj5fhnn8ls0gg77csrmhtwgfo7rtsfdz1gtotwutc3p5bd' );
define( 'LOGGED_IN_SALT',   'dyhtgkimfhtnpavno0ub4vhqewf6gc0zji2oy4cmpfhyvsbhsafjcg9btxbuafr3' );
define( 'NONCE_SALT',       'lvxwbdbt784xub0owivyfn8vbtdfdrenxn86ycafxfygwtrihs9blg9juaw9t8ke' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wpyx_';

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
