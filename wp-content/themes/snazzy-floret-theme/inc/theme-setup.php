<?php
/**
 * Theme Setup - Registers theme supports, menus, sidebars, and image sizes.
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function sf_theme_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Custom image sizes
	add_image_size( 'sf-hero', 1920, 900, true );
	add_image_size( 'sf-product-card', 600, 750, true );
	add_image_size( 'sf-product-thumb', 300, 375, true );
	add_image_size( 'sf-category-thumb', 600, 600, true );

	// Register navigation menus.
	register_nav_menus( array(
		'primary'    => esc_html__( 'Primary Menu', 'snazzy-floret' ),
		'footer'     => esc_html__( 'Footer Menu', 'snazzy-floret' ),
		'categories' => esc_html__( 'Category Menu', 'snazzy-floret' ),
	) );

	// HTML5 support
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Custom logo support
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 250,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// WooCommerce support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Wide alignment for block editor
	add_theme_support( 'align-wide' );

	// Responsive embeds
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'sf_theme_setup' );

/**
 * Register widget areas.
 */
function sf_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'snazzy-floret' ),
		'id'            => 'shop-sidebar',
		'description'   => esc_html__( 'Sidebar for shop and product pages.', 'snazzy-floret' ),
		'before_widget' => '<div id="%1$s" class="sf-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="sf-widget__title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'snazzy-floret' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'First footer column.', 'snazzy-floret' ),
		'before_widget' => '<div id="%1$s" class="sf-footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="sf-footer-widget__title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'snazzy-floret' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Second footer column.', 'snazzy-floret' ),
		'before_widget' => '<div id="%1$s" class="sf-footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="sf-footer-widget__title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'snazzy-floret' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Third footer column.', 'snazzy-floret' ),
		'before_widget' => '<div id="%1$s" class="sf-footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="sf-footer-widget__title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'sf_widgets_init' );
