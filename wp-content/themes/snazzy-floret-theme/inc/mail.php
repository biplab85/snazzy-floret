<?php
/**
 * Snazzy Floret — SMTP (Mailtrap) + PDF invoice attachment.
 *
 * Reads credentials from constants defined in wp-config.php:
 *
 *   define( 'SF_SMTP_HOST', 'sandbox.smtp.mailtrap.io' );
 *   define( 'SF_SMTP_PORT', 2525 );
 *   define( 'SF_SMTP_USER', 'xxxxxxxxxxxx' );
 *   define( 'SF_SMTP_PASS', 'xxxxxxxxxxxx' );
 *   define( 'SF_SMTP_FROM', 'orders@snazzyfloret.com' );
 *   define( 'SF_SMTP_FROM_NAME', 'Snazzy Floret' );
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Route wp_mail() through Mailtrap SMTP.
 */
function sf_configure_smtp( $phpmailer ) {
	if ( ! defined( 'SF_SMTP_HOST' ) || ! SF_SMTP_HOST ) {
		return;
	}
	$phpmailer->isSMTP();
	$phpmailer->Host       = SF_SMTP_HOST;
	$phpmailer->Port       = defined( 'SF_SMTP_PORT' ) ? (int) SF_SMTP_PORT : 2525;
	$phpmailer->SMTPAuth   = true;
	$phpmailer->Username   = SF_SMTP_USER;
	$phpmailer->Password   = SF_SMTP_PASS;
	$phpmailer->SMTPSecure = ( 465 === (int) $phpmailer->Port ) ? 'ssl' : 'tls';
	if ( defined( 'SF_SMTP_FROM' ) && SF_SMTP_FROM ) {
		$phpmailer->setFrom( SF_SMTP_FROM, defined( 'SF_SMTP_FROM_NAME' ) ? SF_SMTP_FROM_NAME : 'Snazzy Floret' );
	}
}
add_action( 'phpmailer_init', 'sf_configure_smtp' );

/**
 * Force the From header (Mailtrap rejects mismatched domains otherwise).
 */
function sf_mail_from( $email ) {
	return defined( 'SF_SMTP_FROM' ) && SF_SMTP_FROM ? SF_SMTP_FROM : $email;
}
function sf_mail_from_name( $name ) {
	return defined( 'SF_SMTP_FROM_NAME' ) && SF_SMTP_FROM_NAME ? SF_SMTP_FROM_NAME : $name;
}
add_filter( 'wp_mail_from', 'sf_mail_from' );
add_filter( 'wp_mail_from_name', 'sf_mail_from_name' );

/**
 * Attach the generated invoice PDF to WooCommerce order emails sent to the
 * customer (processing, completed, on-hold).
 */
function sf_attach_invoice_to_email( $attachments, $email_id, $order ) {
	$customer_emails = array( 'customer_processing_order', 'customer_completed_order', 'customer_on_hold_order', 'customer_invoice' );
	if ( ! in_array( $email_id, $customer_emails, true ) || ! is_a( $order, 'WC_Order' ) ) {
		return $attachments;
	}
	$upload_dir = wp_upload_dir();
	$file       = trailingslashit( $upload_dir['basedir'] ) . 'sf-orders/order-' . $order->get_id() . '.pdf';
	if ( ! file_exists( $file ) && function_exists( 'sf_generate_order_pdf' ) ) {
		sf_generate_order_pdf( $order->get_id() );
	}
	if ( file_exists( $file ) ) {
		$attachments[] = $file;
	}
	return $attachments;
}
add_filter( 'woocommerce_email_attachments', 'sf_attach_invoice_to_email', 10, 3 );

/**
 * Make sure the PDF exists *before* WooCommerce sends the customer email
 * (the order is created, then email fires — generation is hooked at the
 * same priority, so we re-run it as a safety net).
 */
function sf_ensure_pdf_before_email( $order_id ) {
	if ( function_exists( 'sf_generate_order_pdf' ) ) {
		$upload_dir = wp_upload_dir();
		$file       = trailingslashit( $upload_dir['basedir'] ) . 'sf-orders/order-' . $order_id . '.pdf';
		if ( ! file_exists( $file ) ) {
			sf_generate_order_pdf( $order_id );
		}
	}
}
add_action( 'woocommerce_order_status_processing', 'sf_ensure_pdf_before_email', 5 );
add_action( 'woocommerce_order_status_on-hold', 'sf_ensure_pdf_before_email', 5 );
add_action( 'woocommerce_order_status_completed', 'sf_ensure_pdf_before_email', 5 );
