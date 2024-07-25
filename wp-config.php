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
define( 'DB_NAME', 'wordpress-books-bitcoin-widget' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



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
define( 'AUTH_KEY',         '3wGajiS47LQSRnUTjAXqg8h0Y7GSVUemHR6Gj9jBklECtWFDBiBBnUWyGnBO6Va9' );
define( 'SECURE_AUTH_KEY',  'WvTohWnC00HTGwPc24YVNoW5lLrJ02IGk9oHEJAiMwz2OJo0SZxUM6oaPF5m9QOf' );
define( 'LOGGED_IN_KEY',    'AQm44p9vLio9kUSw9gyuaGU0nkXXLvQdFw4APOk3ePkQPo7JESgqUllWZuABHYml' );
define( 'NONCE_KEY',        'kFRV2Oq1xph0iYCIBHO0YADNUjOVICZUemk3bIE9FdEo6mrEejWmLHmMUCXcjg6j' );
define( 'AUTH_SALT',        'eE50YsVzAN8a78w2jbPFwRiIhZzMXJsfSCD4wjWQ9ozMq0abv1RFaSOo3UqLmbJr' );
define( 'SECURE_AUTH_SALT', 'hMZIWlEbTtV0LmBsiGB2NvUVukexsRgczjWEPBc0Bl73QLgjsW3m9RIMpm1gQIiH' );
define( 'LOGGED_IN_SALT',   'wSXIh7q5x66H4U6CXCHBWo4gHvALFc6vKVtmwwCb6sKIMXDa4Y6TA2KifphwrAcI' );
define( 'NONCE_SALT',       'dBHHdV1TUSKB9xQxWgxm0wrAfAR6enfXIkShKBJUCyHoxSgGLTe6MfqLwvfPEzvx' );

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

define('WP_HOME', 'http://localhost:8000');
define('WP_SITEURL', 'http://localhost:8000');
