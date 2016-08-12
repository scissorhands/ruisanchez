<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ximicamp_dbruisanchez');

/** MySQL database username */
define('DB_USER', 'ximicamp_usruis');

/** MySQL database password */
define('DB_PASSWORD', '1q0p2w9o!');

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
define('AUTH_KEY',         '7lX.a]tRw+-qF@5gT`uh`km#:`L- g`T93|jBF4e9L |2Zy0wG+G{BSrz{>R&&O0');
define('SECURE_AUTH_KEY',  ']P[mtc%c?q+S@R8:?B$DN8%Cs4%D=?3fJzNSW{p)%%-+0(3gj}_0UkLmcB+^Qj7n');
define('LOGGED_IN_KEY',    'pu^S{ F^JK#p;.HQUG<8-@eO9s<Y&&n-pr^-6@9NS<Ce%}k+ekjVe3^WYVQ|+K#(');
define('NONCE_KEY',        'mH]mZc[*0m-h:ZHba0/%ia_#{1w+OgLr/~{l0sID.mg+zKJN/=A+P@]Augl]].LB');
define('AUTH_SALT',        '0nQ;@nSqjXSZ*/mfR&?s@B6)I+ZPe/+L`k}=i3kx~Y`[I~/GV;@8C59:oKa>qU&=');
define('SECURE_AUTH_SALT', 'Gy5|G} YV{Vlz+<0-q_a|@Wy;K>%D7QMx`R_u64_4[-35Px`:-$(j4A! g--tkDL');
define('LOGGED_IN_SALT',   'b]bnUj]R+Ecea~T?@vCct,;vBv.<O.RD_04]Tca@{7|3$LJUB*8Wm=av2Z0}c2-b');
define('NONCE_SALT',       'R7SA}%^c&K(FD6klc[GvI6dXjQ2ROV pO#JX,>o0vu32jn[430Dl,_/fMZh4R_-y');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
