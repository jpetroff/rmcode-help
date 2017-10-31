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

define('LOCAL', 1);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/Users/john/rmsource/rmcode-help/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'rmhelp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '|QBGBFL%l(/|3%>[CVrzVR]5E &HGHSXFH!rbNjlA-fm}p?2vRqL)CJ$Wmx~dTd>');
define('SECURE_AUTH_KEY',  ',;qtw-h@ti70Mng(*hC<9PBDrQM3V,xSV#w],JpK;Ye5Uo<x4t2`$0>1oe_cCRc=');
define('LOGGED_IN_KEY',    'MqD fU4KNxy/;p(/W!.V(i!Xfy=5>Hwsb:F],&O (<%.EJWLGr3V6Hml:x,mhs/+');
define('NONCE_KEY',        'L*|&&28W]Le)!`FQSbGgzZFA=$&xAAeq3D?N`mSC-ADP0Ub3NJ~BE95yxdX/>Wq>');
define('AUTH_SALT',        ',(S;zPF}!-N`0DKQi+C=n>]flVF)u5Y0(vR?D0dJ7S~j P*4N{?{WY=Ad**xuUEN');
define('SECURE_AUTH_SALT', ']R`[7o63HYoK_h=1@|Zr9y8ISY|V0(|gkqJ$D{:dZbj]~%*ha#T,>D*ySn5[q|jR');
define('LOGGED_IN_SALT',   '&xyDka8o/q%9G<-Ct<vO_hKlI1qU:O2S15EYM<c$,Atv;fU9b/]PMGi{%8T)}bqf');
define('NONCE_SALT',       '`]}_I4*J5ztfBk`/Uk}-JF{{c}_Hd=1pNbEWVn2Uj@Yj}Aq|+ihQv@2?e,M`/i3#');

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
