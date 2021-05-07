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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'wordpress' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'i&9!`|U;Zry0`}>%TEY-G.2YiXe~YuG,Aj`<2R;[J?<-H[]+lVi:LzB+}xr]>=p]' );
define( 'SECURE_AUTH_KEY',   'StiCUf?:.;gYs%_S%3sncLV} pBT4NHX4np*J y@, 4?(p&( jK{]:CW4il`+]*l' );
define( 'LOGGED_IN_KEY',     '~f+omJo&R|g|PfX;*D7j+rHl=i{<fS^B=Q~yc4^[/M<gx^Q(y%gV1zFrvm`^w%kR' );
define( 'NONCE_KEY',         'X(orsj5Kc><otO$MtM@7SY*Z;57=Txe{]b>esoR<Q~#7E TI/QgEh6R$9EBv:c4.' );
define( 'AUTH_SALT',         '|,O[W?3)d;Arp2@%>,764BMJqt2Gemn^:AtpAbR0@?x.HR>{exW6m:Vwg?Q%y}H1' );
define( 'SECURE_AUTH_SALT',  'b.p9ZPvRJ}8bL,/.n=LQ96[9.?(^6%9{)HHrtt]< GkF%]}R)`taq)dSQRZL_!8E' );
define( 'LOGGED_IN_SALT',    '82jRXa|5vL`(}o=nN@jU5VZz59Zd4ri)/+_WkqKT-w2*iU3<y:GKgR;~Nz!m,hm+' );
define( 'NONCE_SALT',        'OS(+eIJt41X8 T=X)L|a??G*R6@WSi^H{@=k(vgD;w90 KH*V4L1*8^]P}gx4^](' );
define( 'WP_CACHE_KEY_SALT', '<[Ew<Bf-[.3s[}viL.^JUu^$kDq8A3#mK[aD=8tqFeX+{3vGXi$> ~8km7YXrL2u' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


define( 'JETPACK_DEV_DEBUG', True );
define( 'WP_DEBUG', False );
define( 'DISALLOW_FILE_EDIT', True );
define( 'FORCE_SSL_ADMIN', False );
define( 'SAVEQUERIES', False );
define( 'WP_ALLOW_MULTISITE', true );
define( 'WP_HOME', 'http://vccw.test' );
define( 'WP_SITEURL', 'http://vccw.test' );
//define( 'WP_MEMORY_LIMIT', '256M' );

// Additional PHP code in the wp-config.php
// These lines are inserted by VCCW.
// You can place additional PHP code here!
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
