<?php
/**
 * Snazzy Floret Theme Functions
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Theme constants
define( 'SF_THEME_DIR', get_template_directory() );
define( 'SF_THEME_URI', get_template_directory_uri() );
define( 'SF_THEME_VERSION', wp_get_theme()->get( 'Version' ) );

// Theme setup: supports, menus, sidebars, image sizes
require_once SF_THEME_DIR . '/inc/theme-setup.php';

// Enqueue scripts and styles
require_once SF_THEME_DIR . '/inc/enqueue.php';

// WooCommerce hooks and filters
if ( class_exists( 'WooCommerce' ) ) {
	require_once SF_THEME_DIR . '/inc/woocommerce.php';
	require_once SF_THEME_DIR . '/inc/order-pdf.php';
	require_once SF_THEME_DIR . '/inc/mail.php';
	require_once SF_THEME_DIR . '/inc/geolocation.php';
}

// Security: role restrictions, wp-admin access, hardening
require_once SF_THEME_DIR . '/inc/security.php';

// Customizer: hero slider, homepage settings
require_once SF_THEME_DIR . '/inc/customizer.php';

// Customizer: About page dynamic content
require_once SF_THEME_DIR . '/inc/about-customizer.php';

// Hero Slider Manager: dedicated "Hero" admin screen + frontend data source
require_once SF_THEME_DIR . '/inc/hero-admin.php';

// Testimonials Manager: dedicated "Testimonials" admin screen + frontend data
require_once SF_THEME_DIR . '/inc/testimonials-admin.php';

/**
 * Custom body classes.
 */
function sf_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'sf-home';
	}
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_shop() || is_product_category() || is_product_tag() ) {
			$classes[] = 'sf-shop';
		}
		if ( is_product() ) {
			$classes[] = 'sf-product';
		}
		if ( is_cart() ) {
			$classes[] = 'sf-cart';
		}
		if ( is_checkout() ) {
			$classes[] = 'sf-checkout';
		}
		if ( is_account_page() ) {
			$classes[] = 'sf-account';
		}
	}
	return $classes;
}
add_filter( 'body_class', 'sf_body_classes' );

/**
 * Disable the default WordPress emoji scripts.
 */
function sf_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'sf_disable_emojis' );

/**
 * Disable block editor CSS on frontend (we handle our own styles).
 */
function sf_remove_block_css() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-blocks-style' );
	wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'sf_remove_block_css', 100 );

/**
 * Add custom favicon.
 */
function sf_favicon() {
	$favicon_url = SF_THEME_URI . '/assets/images/favicon.png';
	echo '<link rel="icon" type="image/png" href="' . esc_url( $favicon_url ) . '">' . "\n";
	echo '<link rel="apple-touch-icon" href="' . esc_url( $favicon_url ) . '">' . "\n";
}
add_action( 'wp_head', 'sf_favicon' );

/**
 * Estimate reading time for a blog post (200 wpm).
 *
 * @param string $content Post content (raw HTML).
 * @return string Human-friendly reading time, e.g. "3 min read".
 */
function sf_blog_reading_time( $content ) {
	$words   = str_word_count( wp_strip_all_tags( (string) $content ) );
	$minutes = max( 1, (int) ceil( $words / 200 ) );
	/* translators: %d is the number of minutes. */
	return sprintf( _n( '%d min read', '%d min read', $minutes, 'snazzy-floret' ), $minutes );
}





























