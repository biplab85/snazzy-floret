<?php
/**
 * Snazzy Floret — Display-only currency conversion.
 *
 * WooCommerce is configured with BDT as its base currency. This module does
 * NOT change that (which would cascade into tax zones, shipping, and payment
 * gateways). Instead, it filters the formatted price HTML everywhere it's
 * rendered for front-end users, converting the numeric amount to the target
 * currency for the visitor's detected country and swapping the symbol.
 *
 * Orders are still persisted and charged in BDT.
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

/**
 * Country → display currency & symbol.
 */
function sf_country_currency_map() {
	return array(
		'BD' => array( 'currency' => 'BDT', 'symbol' => '৳' ),
		'US' => array( 'currency' => 'USD', 'symbol' => '$' ),
	);
}

/**
 * BDT → target currency multipliers.
 *
 * Hardcoded reference rates; override via the `sf_exchange_rates` filter or
 * refresh periodically from a feed. Production installs should plug a cached
 * API call into this filter.
 */
function sf_exchange_rates() {
	return apply_filters(
		'sf_exchange_rates',
		array(
			'BDT' => 1.0,
			'USD' => 0.00836,
		)
	);
}

/**
 * Currency metadata for the current visitor.
 */
function sf_active_currency_meta() {
	$country = function_exists( 'sf_detect_country' ) ? sf_detect_country() : 'BD';
	$map     = sf_country_currency_map();
	return isset( $map[ $country ] ) ? $map[ $country ] : $map['BD'];
}

/**
 * Should the current request have its prices converted?
 *
 * We only convert for user-facing requests when the target currency differs
 * from BDT. Admin, REST, and cron contexts keep the native BDT output.
 */
function sf_should_convert_prices() {
	if ( is_admin() && ! wp_doing_ajax() ) {
		return false;
	}
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return false;
	}
	if ( wp_doing_cron() ) {
		return false;
	}
	$meta = sf_active_currency_meta();
	return 'BDT' !== $meta['currency'];
}

/**
 * Convert any numeric amounts embedded in a WC-formatted price HTML fragment
 * to the active display currency. Leaves markup intact — only the numeric
 * value and the leading/trailing ৳ are rewritten.
 */
function sf_convert_price_html( $html ) {
	if ( ! is_string( $html ) || '' === $html ) {
		return $html;
	}
	if ( ! sf_should_convert_prices() ) {
		return $html;
	}
	// Idempotency guard: the filter chain can hit the same string twice
	// (e.g. `woocommerce_cart_total` + `woocommerce_cart_totals_order_total_html`).
	// Once converted, the BDT symbol is gone — skip further passes.
	if ( false === strpos( $html, '৳' ) ) {
		return $html;
	}

	$meta   = sf_active_currency_meta();
	$rates  = sf_exchange_rates();
	$rate   = isset( $rates[ $meta['currency'] ] ) ? (float) $rates[ $meta['currency'] ] : 1.0;
	$symbol = $meta['symbol'];

	// Pass 1: convert each <bdi>…</bdi> grouping. WooCommerce wraps every
	// formatted price in <bdi>, so strike-through sale prices (two <bdi>
	// blocks) all get converted.
	$html = preg_replace_callback(
		'#<bdi\b[^>]*>(.*?)</bdi>#is',
		function ( $m ) use ( $rate, $symbol ) {
			$plain = html_entity_decode( wp_strip_all_tags( $m[1] ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
			if ( ! preg_match( '/([\d,]+(?:\.\d+)?)/', $plain, $nm ) ) {
				return $m[0];
			}
			$num       = (float) str_replace( ',', '', $nm[1] );
			$converted = $num * $rate;
			return '<bdi>' . esc_html( $symbol . number_format( $converted, 2, '.', ',' ) ) . '</bdi>';
		},
		$html
	);

	// Pass 2: catch any remaining plain-text amounts (screen-reader-only text
	// like "Original price was: 5,200.00৳.", accessible announcements, etc.).
	$html = preg_replace_callback(
		'/৳\s*([\d,]+(?:\.\d+)?)|([\d,]+(?:\.\d+)?)\s*৳/u',
		function ( $m ) use ( $rate, $symbol ) {
			$raw       = '' !== $m[1] ? $m[1] : $m[2];
			$num       = (float) str_replace( ',', '', $raw );
			$converted = $num * $rate;
			return $symbol . number_format( $converted, 2, '.', ',' );
		},
		$html
	);

	return $html;
}

/* ---------------------------------------------------------------------------
 * Hook conversion into every front-end price rendering context.
 * -------------------------------------------------------------------------- */

// Product HTML — shop loop, PDP, related products, quick view.
add_filter( 'woocommerce_get_price_html', 'sf_convert_price_html', 99 );

// Cart rows & totals.
add_filter( 'woocommerce_cart_item_price', 'sf_convert_price_html', 99 );
add_filter( 'woocommerce_cart_item_subtotal', 'sf_convert_price_html', 99 );
add_filter( 'woocommerce_cart_subtotal', 'sf_convert_price_html', 99 );
add_filter( 'woocommerce_cart_totals_order_total_html', 'sf_convert_price_html', 99 );
add_filter( 'woocommerce_cart_totals_fee_html', 'sf_convert_price_html', 99 );
add_filter( 'woocommerce_cart_shipping_method_full_label', 'sf_convert_price_html', 99 );
add_filter( 'woocommerce_cart_totals_coupon_html', 'sf_convert_price_html', 99 );
add_filter( 'woocommerce_cart_total', 'sf_convert_price_html', 99 );

// Checkout order review & final order summary.
add_filter( 'woocommerce_get_formatted_order_total', 'sf_convert_price_html', 99 );
add_filter( 'woocommerce_order_formatted_line_subtotal', 'sf_convert_price_html', 99 );
