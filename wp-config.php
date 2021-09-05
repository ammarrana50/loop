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
define( 'DB_NAME', 'loop_test' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'MmCIK97x)LR_waO4G{>6R3Lzv?4$MWOnPAvc|tIw37!=SYCi1T:.2c-=xk<@4sC3' );
define( 'SECURE_AUTH_KEY',  'KXf`ft7)uZp9Kp,;1g%)`bjZK}0OV-TU2,8K`TIQFO*,X8T_Wah3{F>V00w>C5&Y' );
define( 'LOGGED_IN_KEY',    '4isjos,vFJxGeoYTq7$teuU[O8IJ$[lBZFt2+cqxCaymjuo!Tx>b#gVym4/b]qiS' );
define( 'NONCE_KEY',        'aW ~ONvu~}rl=vtny :wu2+[~64xG@6($pFbM}VOzjf_jPM Fe6+m0bhWO,9v<&6' );
define( 'AUTH_SALT',        'S<8@B@|:WPM6}05F`0kL;g_6|W :=fi2Uo|-C?M%<lwi_BgAdwsPuAnPi!NlKy9A' );
define( 'SECURE_AUTH_SALT', 'PpjiaTke#5*7GmkA_&8I>@Ht@9!|sz8E_H@8QAEBZd-tw%P>^L.&c~23ghrqQmrj' );
define( 'LOGGED_IN_SALT',   'w|;d`q&Dc1+EJ7kfNB07)MelV,s->~^}M?:DkSj]5&VIKjJ=Xi!(G`4nx<(8m;:~' );
define( 'NONCE_SALT',       '!&P(DriKJ[uNcQb+}]>l]&e![z$5a`#D~0(h9H`EU%oaj-o}]Ez}Qw2r}({|*+61' );

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
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', true);
/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
