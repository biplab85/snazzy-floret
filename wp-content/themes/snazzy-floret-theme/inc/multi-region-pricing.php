<?php
/**
 * Snazzy Floret — Multi-region per-product pricing.
 *
 * Three independent prices are stored per product:
 *   - Bangladesh (BDT) — reuses WooCommerce's native _regular_price / _sale_price.
 *   - Canada      (CAD) — _regular_price_cad / _sale_price_cad.
 *   - Global/USD  (USD) — _regular_price_usd / _sale_price_usd.
 *
 * The visitor's country is resolved by sf_detect_country() (geolocation.php).
 * Frontend price reads, currency code, and currency symbol are all swapped to
 * match the active region. Orders are stamped with the region used at checkout.
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

/**
 * Region map keyed by ISO country code.
 *
 * `suffix` is appended to `_regular_price` / `_sale_price` to read the
 * regional meta. BD has empty suffix because it uses the native WC fields.
 *
 * @return array<string,array{region:string,currency:string,symbol:string,suffix:string}>
 */
function sf_region_config() {
	return array(
		'BD' => array(
			'region'   => 'bdt',
			'currency' => 'BDT',
			'symbol'   => '৳',
			'suffix'   => '',
		),
		'CA' => array(
			'region'   => 'cad',
			'currency' => 'CAD',
			'symbol'   => '$(CAD)',
			'suffix'   => '_cad',
		),
		'US' => array(
			'region'   => 'usd',
			'currency' => 'USD',
			'symbol'   => '$',
			'suffix'   => '_usd',
		),
	);
}

/**
 * Region config for the current visitor.
 */
function sf_active_region() {
	static $cached = null;
	if ( null !== $cached ) {
		return $cached;
	}
	$country = function_exists( 'sf_detect_country' ) ? sf_detect_country() : 'BD';
	$map     = sf_region_config();
	$cached  = isset( $map[ $country ] ) ? $map[ $country ] : $map['US'];
	return $cached;
}

/**
 * Should regional pricing be applied to this request?
 *
 * Frontend, AJAX, and the customer-facing Store API are filtered. Admin
 * pages, admin REST (wc/v3), and cron stay raw so editing/automation isn't
 * disturbed.
 */
function sf_should_apply_regional_pricing() {
	if ( is_admin() && ! wp_doing_ajax() ) {
		return false;
	}
	if ( wp_doing_cron() ) {
		return false;
	}
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		// The block-based cart/checkout fetches via /wc/store/v1/. Allow it.
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) $_SERVER['REQUEST_URI'] : '';
		return false !== strpos( $uri, '/wc/store/' );
	}
	return true;
}

/**
 * Does this product have its own pricing for the active region?
 *
 * Defined as: a non-empty regional regular price exists. We treat regional
 * pricing as all-or-nothing per product per region — if regional regular is
 * set, regional sale stands on its own (no fallback to the BDT sale).
 */
function sf_product_has_regional_price( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return false;
	}
	$region = sf_active_region();
	if ( '' === $region['suffix'] ) {
		return false;
	}
	$val = $product->get_meta( '_regular_price' . $region['suffix'], true );
	return ( '' !== $val && null !== $val && false !== $val );
}

/**
 * Resolve a regional price for a given product.
 *
 * Rules:
 *   - If region is BD (no suffix) → native value.
 *   - If product has a regional regular price set → use the regional value
 *     for both regular and sale; missing regional sale means "no sale in this
 *     region" (returns empty), NOT a fallback to the BDT sale.
 *   - If product has no regional regular price set → fall back to the native
 *     value entirely so BDT pricing carries through.
 *
 * @param WC_Product $product      Product or variation.
 * @param string     $type         'regular' | 'sale'.
 * @param mixed      $native_value Value WC would have returned (BDT base).
 * @return mixed
 */
function sf_regional_price( $product, $type, $native_value ) {
	if ( ! $product instanceof WC_Product ) {
		return $native_value;
	}
	$region = sf_active_region();
	if ( '' === $region['suffix'] ) {
		return $native_value;
	}
	if ( ! sf_product_has_regional_price( $product ) ) {
		return $native_value;
	}
	$key = '_' . $type . '_price' . $region['suffix'];
	$val = $product->get_meta( $key, true );
	// Regional regular always exists here; regional sale may legitimately be empty.
	if ( 'sale' === $type && ( '' === $val || null === $val || false === $val ) ) {
		return '';
	}
	return $val;
}

/* ---------------------------------------------------------------------------
 * Admin: extra price fields on the product edit screen (simple products).
 * Hooked into the existing "General" pricing block — no layout changes.
 * -------------------------------------------------------------------------- */

add_action( 'woocommerce_product_options_pricing', 'sf_admin_add_regional_price_fields' );
function sf_admin_add_regional_price_fields() {
	echo '<div class="options_group sf-regional-prices">';

	woocommerce_wp_text_input(
		array(
			'id'          => '_regular_price_cad',
			'label'       => __( 'Canada regular price', 'snazzy-floret' ) . ' ($)',
			'data_type'   => 'price',
			'desc_tip'    => true,
			'description' => __( 'Price shown to visitors from Canada (CAD).', 'snazzy-floret' ),
		)
	);
	woocommerce_wp_text_input(
		array(
			'id'        => '_sale_price_cad',
			'label'     => __( 'Canada sale price', 'snazzy-floret' ) . ' ($)',
			'data_type' => 'price',
		)
	);
	woocommerce_wp_text_input(
		array(
			'id'          => '_regular_price_usd',
			'label'       => __( 'Global / USD regular price', 'snazzy-floret' ) . ' ($)',
			'data_type'   => 'price',
			'desc_tip'    => true,
			'description' => __( 'Price shown to all visitors outside Bangladesh and Canada (USD).', 'snazzy-floret' ),
		)
	);
	woocommerce_wp_text_input(
		array(
			'id'        => '_sale_price_usd',
			'label'     => __( 'Global / USD sale price', 'snazzy-floret' ) . ' ($)',
			'data_type' => 'price',
		)
	);

	echo '</div>';
}

add_action( 'woocommerce_admin_process_product_object', 'sf_admin_save_regional_price_fields' );
function sf_admin_save_regional_price_fields( $product ) {
	$keys = array(
		'_regular_price_cad',
		'_sale_price_cad',
		'_regular_price_usd',
		'_sale_price_usd',
	);
	foreach ( $keys as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			$raw = wp_unslash( $_POST[ $key ] );
			$val = ( '' === $raw ) ? '' : wc_format_decimal( $raw );
			$product->update_meta_data( $key, $val );
		}
	}
}

/* ---------------------------------------------------------------------------
 * Admin: extra price fields on each variation (variable products).
 * -------------------------------------------------------------------------- */

add_action( 'woocommerce_variation_options_pricing', 'sf_admin_add_variation_regional_price_fields', 10, 3 );
function sf_admin_add_variation_regional_price_fields( $loop, $variation_data, $variation ) {
	$vid = $variation->ID;

	woocommerce_wp_text_input(
		array(
			'id'            => "_regular_price_cad_{$loop}",
			'name'          => "_regular_price_cad[{$loop}]",
			'value'         => get_post_meta( $vid, '_regular_price_cad', true ),
			'label'         => __( 'CA regular ($)', 'snazzy-floret' ),
			'data_type'     => 'price',
			'wrapper_class' => 'form-row form-row-first',
		)
	);
	woocommerce_wp_text_input(
		array(
			'id'            => "_sale_price_cad_{$loop}",
			'name'          => "_sale_price_cad[{$loop}]",
			'value'         => get_post_meta( $vid, '_sale_price_cad', true ),
			'label'         => __( 'CA sale ($)', 'snazzy-floret' ),
			'data_type'     => 'price',
			'wrapper_class' => 'form-row form-row-last',
		)
	);
	woocommerce_wp_text_input(
		array(
			'id'            => "_regular_price_usd_{$loop}",
			'name'          => "_regular_price_usd[{$loop}]",
			'value'         => get_post_meta( $vid, '_regular_price_usd', true ),
			'label'         => __( 'USD regular ($)', 'snazzy-floret' ),
			'data_type'     => 'price',
			'wrapper_class' => 'form-row form-row-first',
		)
	);
	woocommerce_wp_text_input(
		array(
			'id'            => "_sale_price_usd_{$loop}",
			'name'          => "_sale_price_usd[{$loop}]",
			'value'         => get_post_meta( $vid, '_sale_price_usd', true ),
			'label'         => __( 'USD sale ($)', 'snazzy-floret' ),
			'data_type'     => 'price',
			'wrapper_class' => 'form-row form-row-last',
		)
	);
}

add_action( 'woocommerce_save_product_variation', 'sf_admin_save_variation_regional_price_fields', 10, 2 );
function sf_admin_save_variation_regional_price_fields( $variation_id, $loop ) {
	$keys = array(
		'_regular_price_cad',
		'_sale_price_cad',
		'_regular_price_usd',
		'_sale_price_usd',
	);
	foreach ( $keys as $key ) {
		if ( isset( $_POST[ $key ][ $loop ] ) ) {
			$raw = wp_unslash( $_POST[ $key ][ $loop ] );
			$val = ( '' === $raw ) ? '' : wc_format_decimal( $raw );
			update_post_meta( $variation_id, $key, $val );
		}
	}
}

/* ---------------------------------------------------------------------------
 * Frontend: swap product prices to the active region.
 * -------------------------------------------------------------------------- */

add_filter( 'woocommerce_product_get_regular_price', 'sf_filter_regular_price', 10, 2 );
add_filter( 'woocommerce_product_variation_get_regular_price', 'sf_filter_regular_price', 10, 2 );
function sf_filter_regular_price( $price, $product ) {
	if ( ! sf_should_apply_regional_pricing() ) {
		return $price;
	}
	return sf_regional_price( $product, 'regular', $price );
}

add_filter( 'woocommerce_product_get_sale_price', 'sf_filter_sale_price', 10, 2 );
add_filter( 'woocommerce_product_variation_get_sale_price', 'sf_filter_sale_price', 10, 2 );
function sf_filter_sale_price( $price, $product ) {
	if ( ! sf_should_apply_regional_pricing() ) {
		return $price;
	}
	return sf_regional_price( $product, 'sale', $price );
}

add_filter( 'woocommerce_product_get_price', 'sf_filter_active_price', 10, 2 );
add_filter( 'woocommerce_product_variation_get_price', 'sf_filter_active_price', 10, 2 );
function sf_filter_active_price( $price, $product ) {
	if ( ! sf_should_apply_regional_pricing() ) {
		return $price;
	}
	if ( ! sf_product_has_regional_price( $product ) ) {
		return $price;
	}
	$region  = sf_active_region();
	$regular = $product->get_meta( '_regular_price' . $region['suffix'], true );
	$sale    = $product->get_meta( '_sale_price' . $region['suffix'], true );
	return ( '' !== $sale && null !== $sale && false !== $sale ) ? $sale : $regular;
}

/* Variable-product price range: filter the per-variation prices used by the
 * "From $X" range and the variations dropdown. */

add_filter( 'woocommerce_variation_prices_regular_price', 'sf_filter_variation_prices_regular', 10, 3 );
function sf_filter_variation_prices_regular( $price, $variation, $parent ) {
	if ( ! sf_should_apply_regional_pricing() ) {
		return $price;
	}
	return sf_regional_price( $variation, 'regular', $price );
}

add_filter( 'woocommerce_variation_prices_sale_price', 'sf_filter_variation_prices_sale', 10, 3 );
function sf_filter_variation_prices_sale( $price, $variation, $parent ) {
	if ( ! sf_should_apply_regional_pricing() ) {
		return $price;
	}
	return sf_regional_price( $variation, 'sale', $price );
}

add_filter( 'woocommerce_variation_prices_price', 'sf_filter_variation_prices_active', 10, 3 );
function sf_filter_variation_prices_active( $price, $variation, $parent ) {
	if ( ! sf_should_apply_regional_pricing() ) {
		return $price;
	}
	if ( ! sf_product_has_regional_price( $variation ) ) {
		return $price;
	}
	$region  = sf_active_region();
	$regular = $variation->get_meta( '_regular_price' . $region['suffix'], true );
	$sale    = $variation->get_meta( '_sale_price' . $region['suffix'], true );
	return ( '' !== $sale && null !== $sale && false !== $sale ) ? $sale : $regular;
}

// Variation prices are aggressively cached by WC. Add the region to the
// cache hash so each region gets its own cached range.
add_filter( 'woocommerce_get_variation_prices_hash', 'sf_filter_variation_prices_hash', 10, 3 );
function sf_filter_variation_prices_hash( $hash, $product, $for_display ) {
	if ( sf_should_apply_regional_pricing() ) {
		$region            = sf_active_region();
		$hash['sf_region'] = $region['region'];
	}
	return $hash;
}

/* ---------------------------------------------------------------------------
 * Currency code & symbol: switch to the active region.
 * -------------------------------------------------------------------------- */

add_filter( 'woocommerce_currency', 'sf_filter_currency', 10, 1 );
function sf_filter_currency( $currency ) {
	if ( ! sf_should_apply_regional_pricing() ) {
		return $currency;
	}
	$region = sf_active_region();
	return $region['currency'];
}

add_filter( 'woocommerce_currency_symbol', 'sf_filter_currency_symbol', 10, 2 );
function sf_filter_currency_symbol( $symbol, $currency ) {
	// Symbols are mapped per currency, not per visitor region, so order pages
	// and PDFs always render the correct symbol for the order's stored currency
	// — even if the viewer is in a different region.
	$by_currency = array(
		'BDT' => '৳',
		'CAD' => '$(CAD)',
		'USD' => '$',
	);
	return $by_currency[ $currency ] ?? $symbol;
}

/* ---------------------------------------------------------------------------
 * Order: record which region & country the customer used at checkout.
 * -------------------------------------------------------------------------- */

add_action( 'woocommerce_checkout_create_order', 'sf_stamp_order_region', 10, 1 );
function sf_stamp_order_region( $order ) {
	if ( ! sf_should_apply_regional_pricing() ) {
		return;
	}
	$region  = sf_active_region();
	$country = function_exists( 'sf_detect_country' ) ? sf_detect_country() : '';
	$order->update_meta_data( '_sf_region', $region['region'] );
	$order->update_meta_data( '_sf_country', $country );
}
