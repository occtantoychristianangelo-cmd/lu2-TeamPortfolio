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
define( 'DB_NAME', 'teamportfolio' );

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
define( 'AUTH_KEY',         'i^]lZj-2Pehp,}.)PUUT-yn_GZEQ(sA_VvAq[8GaChvU)eYn1r~{un@r:C<Va2lz' );
define( 'SECURE_AUTH_KEY',  '=h1pxQ&o$5??6#zTbm]|4G{+5i#3!P>,^1mvO{k0Sw{:q.kqwY+NO=Q,l~mdTww$' );
define( 'LOGGED_IN_KEY',    'c:*8_>tg00A)].?+@aRQfr?HayFy92M,t27YsWY4HVGF~+&@;<k+J7sbg %%)wEX' );
define( 'NONCE_KEY',        'msvh0^k3})s)-r (z8B8, {leZP)73;W3^Ib+3_O5{B&]2Zmh3ry!u5E-=d1,nYg' );
define( 'AUTH_SALT',        'Bc&L4Qv]rwvZf!c+H!S^/y=ctQ6e[?p)v}as}]OA(n!ecCln.q.-P+uAjKdmqj t' );
define( 'SECURE_AUTH_SALT', '!Z@B~1un!8xKZp0)2H%%3$L`KQ3^`IP-;paB].Dnue_==saQKujMRF^wylxP}!@y' );
define( 'LOGGED_IN_SALT',   '7zQqN=.i$5O;]Tf^MiSm&kS]u$x1Fq7Kx|/6B8[Hn/n!> P..T5NCM<gv^PASR0;' );
define( 'NONCE_SALT',       '{e(UWL*PrFTC=[t3)nm+gZNPMdh8hKd5@k4#-N) /}a81Ox$mks-qNe_STM.3Vgi' );

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
