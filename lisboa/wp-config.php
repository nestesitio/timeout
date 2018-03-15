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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
 //Added by WP-Cache Manager
// define('WP_HOME','https://www.timeoutmarket.com');
// define('WP_SITEURL','https://www.timeoutmarket.com');

define( 'WPCACHEHOME', '/home/timeoutmarket/public_html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager

if(gethostbyname(gethostname()) == '127.0.1.1'){
    define('DB_NAME', 'timeout');
}elseif(gethostbyname(gethostname()) == '109.71.42.92'){
   define('DB_NAME', 'nsitio_timeout'); 
}elseif(gethostbyname(gethostname()) == '130.185.87.17' || gethostbyname(gethostname()) == '130.185.87.86'){
   define('DB_NAME', 'loadhtlc_timeout1701'); 
}elseif(gethostbyname(gethostname()) == '72.10.50.238'){
    define('DB_NAME', 'timeoutm_timeoutv6');
}else{
   define('DB_NAME', 'timeoutm_timeoutv5');
}

/** MySQL database username */
if(gethostbyname(gethostname()) == '127.0.1.1'){
    define('DB_USER', 'root');
}elseif(gethostbyname(gethostname()) == '109.71.42.92'){
    define('DB_USER', 'nsitio_timeout');
}elseif(gethostbyname(gethostname()) == '130.185.87.17' || gethostbyname(gethostname()) == '130.185.87.86'){
    define('DB_USER', 'loadhtlc_ricardo');
}else{
   define('DB_USER', 'timeoutm_hotel');
}

/** MySQL database password */
//define('DB_PASSWORD', 'Hotelfasano123');
if(gethostbyname(gethostname()) == '127.0.1.1'){
    define('DB_PASSWORD', '1500lisboa');
}elseif(gethostbyname(gethostname()) == '130.185.87.17' || gethostbyname(gethostname()) == '130.185.87.86'){
    define('DB_PASSWORD', '1500lisboa');
}elseif(gethostbyname(gethostname()) == '72.10.50.238'){
    define('DB_PASSWORD', 'Hotelfasano123');
}else{
   define('DB_PASSWORD', '48484040a');
}
/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
