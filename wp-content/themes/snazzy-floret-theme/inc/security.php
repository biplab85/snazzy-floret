<?php
/**
 * Security - Role restrictions, wp-admin access control, hardening.
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Redirect non-admin users away from wp-admin.
 * Allow AJAX requests to pass through.
 */
function sf_redirect_non_admin() {
	if ( is_admin() && ! current_user_can( 'manage_options' ) && ! wp_doing_ajax() ) {
		wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
		exit;
	}
}
add_action( 'admin_init', 'sf_redirect_non_admin' );

/**
 * Hide admin bar for non-admin users.
 */
function sf_hide_admin_bar() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return false;
	}
	return true;
}
add_filter( 'show_admin_bar', 'sf_hide_admin_bar' );

/**
 * Force customer role on new registrations.
 */
function sf_force_customer_role( $customer_id ) {
	$user = new WP_User( $customer_id );
	$user->set_role( 'customer' );
}
add_action( 'woocommerce_created_customer', 'sf_force_customer_role' );

/**
 * Prevent role escalation via profile update.
 */
function sf_prevent_role_escalation( $user_id ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		$user = new WP_User( $user_id );
		if ( ! in_array( 'customer', $user->roles, true ) && ! in_array( 'administrator', $user->roles, true ) ) {
			$user->set_role( 'customer' );
		}
	}
}
add_action( 'profile_update', 'sf_prevent_role_escalation' );

/**
 * Remove WordPress version from head.
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Disable XML-RPC.
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Disable author archives to prevent user enumeration.
 */
function sf_disable_author_archives() {
	if ( is_author() ) {
		wp_safe_redirect( home_url(), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'sf_disable_author_archives' );

/**
 * Keep ?ver= on asset URLs — essential for cache-busting when theme files change.
 * (Previous implementation stripped it, which caused stale CSS after edits.)
 */

/**
 * Redirect customers to My Account after login (not wp-admin).
 */
function sf_login_redirect( $redirect_to, $requested_redirect_to, $user ) {
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		if ( in_array( 'customer', $user->roles, true ) || in_array( 'subscriber', $user->roles, true ) ) {
			return wc_get_page_permalink( 'myaccount' );
		}
	}
	return $redirect_to;
}
add_filter( 'login_redirect', 'sf_login_redirect', 10, 3 );
