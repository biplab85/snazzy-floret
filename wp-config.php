<?php
/**
 * The base configuration for WordPress
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 * @package WordPress
 */

// ** Database settings ** //
define( 'DB_NAME', 'snazzy_floret' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

/**
 * Authentication unique keys and salts.
 */
define( 'AUTH_KEY',         '687e211ac0c7c2e4b2dff97ac72d464a42846acf107edb1e340b4acfe99b7a53' );
define( 'SECURE_AUTH_KEY',  '3629fc6375e5063fcf496cc198fec83ed1e361a1a075c109026a237442cb0717' );
define( 'LOGGED_IN_KEY',    '51514d5237565f9acdd9a56d9090c2c965228db8c766a74193345232695f7b03' );
define( 'NONCE_KEY',        '71cb5f9a48dc25b86782853d40fe228aec68b0384ad9c5aea20837ae67b994e3' );
define( 'AUTH_SALT',        'f9b82bd5dc17c8eba8c90a5be246a48e4804d7014408af013497ac8f3c149623' );
define( 'SECURE_AUTH_SALT', '6baab9e9dc7df899d05fc1d01af957e7726b3bca2b6cb7cdb5e14a25c3fa852d' );
define( 'LOGGED_IN_SALT',   '9569429e4c8f4835b8b3e472eec90fee6bb1e6a0c733120da657b33dfa3998ba' );
define( 'NONCE_SALT',       '93f41f9de652c7a3bcc7093293049a725022c9b254e27c9bb2c99903ca67a4db' );

/**
 * WordPress database table prefix.
 */
$table_prefix = 'wp_';

/**
 * WordPress debugging mode.
 */
define( 'WP_DEBUG', false );
define( 'WP_MEMORY_LIMIT', '512M' );

/** Mailtrap SMTP (sandbox). */
define( 'SF_SMTP_HOST',      'sandbox.smtp.mailtrap.io' );
define( 'SF_SMTP_PORT',      2525 );
define( 'SF_SMTP_USER',      '07a5dd5ce2694b' );
define( 'SF_SMTP_PASS',      'be45f4e9074d45' );
define( 'SF_SMTP_FROM',      'orders@snazzyfloret.com' );
define( 'SF_SMTP_FROM_NAME', 'Snazzy Floret' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
