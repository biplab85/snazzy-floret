<?php
/**
 * Snazzy Floret — Visitor country detection.
 *
 * Detects the visitor's country and memoises the result in a 7-day cookie so
 * subsequent requests skip the geolocation lookup. Supports a ?sf_country=XX
 * query override for testing (e.g. visiting ?sf_country=CA forces Canada).
 *
 * Only the countries explicitly supported by the theme's currency logic are
 * honoured; everything else falls back to BD.
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

/**
 * Countries supported for display localisation.
 *
 * @return array<int,string>
 */
function sf_supported_countries() {
	return array( 'BD', 'CA', 'US' );
}

/**
 * Is the given ISO code supported?
 */
function sf_is_supported_country( $code ) {
	return in_array( strtoupper( (string) $code ), sf_supported_countries(), true );
}

/**
 * Normalise an ISO country code to the theme's internal code.
 * WC/MaxMind return "GB" for the United Kingdom; the theme displays "UK".
 */
function sf_normalise_country_code( $code ) {
	$code = strtoupper( (string) $code );
	if ( 'GB' === $code ) {
		return 'UK';
	}
	return $code;
}

/**
 * Persist the detected country to a cookie so future requests don't re-run
 * the geolocation lookup.
 */
function sf_persist_country_cookie( $code ) {
	if ( headers_sent() ) {
		return;
	}
	setcookie(
		'sf_country',
		$code,
		time() + ( 7 * DAY_IN_SECONDS ),
		defined( 'COOKIEPATH' ) ? COOKIEPATH : '/',
		defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '',
		is_ssl(),
		false
	);
	$_COOKIE['sf_country'] = $code;
}

/**
 * Detect the visitor's country. Returns one of the codes in
 * sf_supported_countries(). Defaults to 'BD'.
 */
function sf_detect_country() {
	static $cached = null;
	if ( null !== $cached ) {
		return $cached;
	}

	// 1. Query override (useful for testing / manual switch).
	if ( isset( $_GET['sf_country'] ) ) {
		$override = sf_normalise_country_code( sanitize_text_field( wp_unslash( $_GET['sf_country'] ) ) );
		if ( sf_is_supported_country( $override ) ) {
			sf_persist_country_cookie( $override );
			$cached = $override;
			return $cached;
		}
	}

	// 2. Cookie — already detected in a previous request.
	if ( ! empty( $_COOKIE['sf_country'] ) ) {
		$cookie = sf_normalise_country_code( sanitize_text_field( wp_unslash( $_COOKIE['sf_country'] ) ) );
		if ( sf_is_supported_country( $cookie ) ) {
			$cached = $cookie;
			return $cached;
		}
	}

	// 3. IP-based geolocation via WooCommerce.
	if ( class_exists( 'WC_Geolocation' ) ) {
		$ip   = WC_Geolocation::get_ip_address();
		$data = WC_Geolocation::geolocate_ip( $ip, true );
		if ( ! empty( $data['country'] ) ) {
			$cc = strtoupper( $data['country'] );
			if ( 'BD' === $cc ) {
				$resolved = 'BD';
			} elseif ( 'CA' === $cc ) {
				$resolved = 'CA';
			} else {
				$resolved = 'US';
			}
			sf_persist_country_cookie( $resolved );
			$cached = $resolved;
			return $cached;
		}
	}

	// 4. Fallback — shop's home market.
	$cached = 'BD';
	return $cached;
}
