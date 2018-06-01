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
define('DB_NAME', 'angelesc_wpmain');

/** MySQL database username */
define('DB_USER', 'angelesc_wpuser');

/** MySQL database password */
define('DB_PASSWORD', '#ccXGa4]*NJz');

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
define('AUTH_KEY',         'f%$$p9uBwL<Mp{KJgfK`[zb?hNT0Se:/zM6].ZY?4{]HY[QmRE4=i6z9;XRX4B;U');
define('SECURE_AUTH_KEY',  'au{[BWXlbuzi98GA*8JT(DkQ^9{.0gxLJO(aX:19rgb}^!tEc;CJz7.eEa(RjP$d');
define('LOGGED_IN_KEY',    '$h|_a~P~MX6vuN{DQ}0g24?^5qsPeCv EEhgW|k#BTF,e; D?r-6EsO#!J6ELfsG');
define('NONCE_KEY',        '/K{KQ&gIn,W2g{#p3R=&JY/xizwt]u[U?k$F}_:gV7Kdh+^3MJ-Na2d~L?h{W#@f');
define('AUTH_SALT',        '}UIgv]r4)y+-N8hk)8K^X&8*sOue2tBA{elf`Wx%,zp(q@9CU6nG#cgXnSymKJe.');
define('SECURE_AUTH_SALT', '+Wl3YSL@Xs`,Y_{;X92_3`(6P,sKvST|v(@0+Q%~ONxL+]uqYao!.qiR( wsp&42');
define('LOGGED_IN_SALT',   'uC#{+ yYtwGu&>VECgjT*9.LehL)D/Z3we[kKa9:^K<TJe`K;udhR>qvk7<53*NU');
define('NONCE_SALT',       '$@DKdbAv2$v3dl;!;pyAo7G6z9t%Za79ZNBoz11?!Gd-[vb1M3gPV1OarFpz2tkn');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'acg_';

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
//Disable File Edits
define('DISALLOW_FILE_EDIT', true);