<?php
/**
 * WooCommerce hooks and filters.
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ===================================================================
   CURRENCY SYMBOL & FORMAT — frontend shows "$2,900.00 (CAD)" with the
   currency code styled smaller; admin price field labels still read
   "Regular price ($ CAD)" so the editor knows which currency they're in.
   =================================================================== */

add_filter( 'woocommerce_currency_symbol', function ( $symbol, $currency ) {
	if ( 'CAD' !== $currency ) {
		return $symbol;
	}
	// Admin (non-AJAX) renders the symbol as plain text inside field labels.
	// Frontend renders inside <bdi> markup where we append (CAD) separately.
	return ( is_admin() && ! wp_doing_ajax() ) ? '$ CAD' : '$';
}, 10, 2 );

add_filter( 'woocommerce_price_format', function ( $format, $currency_pos ) {
	if ( 'CAD' !== get_woocommerce_currency() ) {
		return $format;
	}
	if ( is_admin() && ! wp_doing_ajax() ) {
		return $format;
	}
	return $format . ' (CAD)';
}, 10, 2 );

/**
 * Wrap the trailing " (CAD)" produced by woocommerce_price_format with a
 * styled span on server-rendered prices (shop loop, PDP, related, etc.).
 * Block-based pages (cart/checkout) ignore HTML in the JS-side formatter,
 * so we only inject the span once HTML is being assembled in PHP.
 */
add_filter( 'woocommerce_get_price_html', function ( $price_html ) {
	return str_replace( ' (CAD)', '<span class="sf-currency-code">(CAD)</span>', $price_html );
}, 99 );

/**
 * Append " (CAD)" as the currency suffix on every Store API response
 * (block-based cart & checkout). The Store API formats prices via
 * CurrencyFormatter which derives prefix/suffix from currency position
 * only and exposes no filter, so we walk the dispatched response and
 * patch any object whose currency_code is CAD.
 */
add_filter( 'rest_post_dispatch', function ( $response, $server, $request ) {
	if ( ! ( $response instanceof WP_REST_Response ) ) {
		return $response;
	}
	if ( strpos( (string) $request->get_route(), '/wc/store/' ) === false ) {
		return $response;
	}
	$data = $response->get_data();
	$response->set_data( sf_apply_cad_suffix_recursive( $data ) );
	return $response;
}, 10, 3 );

/**
 * Walk an arbitrarily nested mix of arrays and stdClass objects, and on
 * any node that has currency_code === 'CAD', force currency_suffix to
 * " (CAD)". Returns the same shape it received (array → array, object →
 * object) so JSON encoding stays identical apart from the patched suffix.
 */
function sf_apply_cad_suffix_recursive( $data ) {
	if ( is_array( $data ) ) {
		if ( isset( $data['currency_code'] ) && 'CAD' === $data['currency_code'] && array_key_exists( 'currency_suffix', $data ) ) {
			$data['currency_suffix'] = ' (CAD)';
		}
		foreach ( $data as $k => $v ) {
			if ( is_array( $v ) || is_object( $v ) ) {
				$data[ $k ] = sf_apply_cad_suffix_recursive( $v );
			}
		}
		return $data;
	}
	if ( is_object( $data ) ) {
		if ( isset( $data->currency_code ) && 'CAD' === $data->currency_code && property_exists( $data, 'currency_suffix' ) ) {
			$data->currency_suffix = ' (CAD)';
		}
		foreach ( $data as $k => $v ) {
			if ( is_array( $v ) || is_object( $v ) ) {
				$data->{$k} = sf_apply_cad_suffix_recursive( $v );
			}
		}
		return $data;
	}
	return $data;
}

/* ===================================================================
   SHOP / ARCHIVE SETTINGS
   =================================================================== */

add_filter( 'loop_shop_columns', function () { return 3; } );
add_filter( 'loop_shop_per_page', function () { return 12; } );

// Remove default wrapper
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', function () {
	echo '<main class="sf-main"><div class="sf-container sf-shop-container">';
}, 10 );

add_action( 'woocommerce_after_main_content', function () {
	echo '</div></main>';
}, 10 );

// Remove default sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Remove default result count & ordering from the loop (we place them in custom toolbar)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/* ===================================================================
   SHOP FILTERS — Server-side query modifications
   =================================================================== */

/**
 * Filter by stock status (availability).
 */
function sf_filter_by_availability( $query ) {
	if ( ! is_admin() && $query->is_main_query() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$availability = isset( $_GET['filter_availability'] ) ? sanitize_text_field( wp_unslash( $_GET['filter_availability'] ) ) : '';
		if ( $availability ) {
			$statuses = array_map( 'sanitize_title', explode( ',', $availability ) );
			$meta_query = $query->get( 'meta_query' );
			if ( ! is_array( $meta_query ) ) {
				$meta_query = array();
			}
			$meta_query[] = array(
				'key'     => '_stock_status',
				'value'   => $statuses,
				'compare' => 'IN',
			);
			$query->set( 'meta_query', $meta_query );
		}
	}
}
add_action( 'pre_get_posts', 'sf_filter_by_availability' );

/**
 * When the user explicitly filters for out-of-stock products, bypass the
 * global "Hide out of stock items" setting so the results actually show.
 */
function sf_show_outofstock_when_filtered( $args ) {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$availability = isset( $_GET['filter_availability'] ) ? sanitize_text_field( wp_unslash( $_GET['filter_availability'] ) ) : '';
	if ( $availability && false !== strpos( $availability, 'outofstock' ) ) {
		if ( isset( $args['meta_query'] ) && is_array( $args['meta_query'] ) ) {
			foreach ( $args['meta_query'] as $key => $clause ) {
				if ( isset( $clause['key'] ) && '_stock_status' === $clause['key'] && isset( $clause['value'] ) && 'outofstock' === $clause['value'] && isset( $clause['compare'] ) && 'NOT IN' === $clause['compare'] ) {
					unset( $args['meta_query'][ $key ] );
				}
			}
		}
	}
	return $args;
}
add_filter( 'woocommerce_product_query_meta_query', 'sf_show_outofstock_when_filtered', 20 );

/**
 * Filter by product attribute (fabric).
 */
function sf_filter_by_fabric( $query ) {
	if ( ! is_admin() && $query->is_main_query() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$fabric = isset( $_GET['filter_fabric'] ) ? sanitize_text_field( wp_unslash( $_GET['filter_fabric'] ) ) : '';
		if ( $fabric ) {
			$slugs     = array_map( 'sanitize_title', explode( ',', $fabric ) );
			$tax_query = $query->get( 'tax_query' );
			if ( ! is_array( $tax_query ) ) {
				$tax_query = array();
			}
			$tax_query[] = array(
				'taxonomy' => 'pa_fabric',
				'field'    => 'slug',
				'terms'    => $slugs,
				'operator' => 'IN',
			);
			$query->set( 'tax_query', $tax_query );
		}
	}
}
add_action( 'pre_get_posts', 'sf_filter_by_fabric' );

/* ===================================================================
   PRODUCT CARD — COMPLETE RESTRUCTURE
   =================================================================== */

// Remove ALL default WooCommerce card elements — we rebuild from scratch
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

/**
 * Returns the list of in-stock sizes (35-42 range) assigned to a product.
 *
 * @param int $product_id Product ID.
 * @return array List of integer sizes.
 */
function sf_get_available_sizes( $product_id ) {
	$terms = wp_get_object_terms( $product_id, 'pa_size', array( 'fields' => 'names' ) );
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return array();
	}
	$sizes = array();
	foreach ( $terms as $t ) {
		$n = intval( $t );
		if ( $n >= 35 && $n <= 42 ) {
			$sizes[] = $n;
		}
	}
	sort( $sizes );
	return $sizes;
}

// --- IMAGE AREA (opens before title) ---
add_action( 'woocommerce_before_shop_loop_item_title', 'sf_card_image_open', 5 );
function sf_card_image_open() {
	global $product;
	$link = get_permalink( $product->get_id() );
	echo '<div class="sf-card__image-wrap">';
	echo '<a href="' . esc_url( $link ) . '" class="sf-card__image-link">';
	echo wp_get_attachment_image( $product->get_image_id(), 'sf-product-card', false, array( 'class' => 'sf-card__img', 'loading' => 'lazy' ) );
	echo '</a>';

	// Out-of-stock overlay — only when the product is actually out of stock.
	if ( ! $product->is_in_stock() ) {
		echo '<div class="sf-card__oos-overlay" aria-hidden="true">';
		echo '<span class="sf-card__oos-pill">';
		echo '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>';
		echo esc_html__( 'Out of Stock', 'snazzy-floret' );
		echo '</span>';
		echo '</div>';
	}

	// Badges
	echo '<div class="sf-card__badges">';
	if ( $product->is_on_sale() ) {
		$regular = (float) $product->get_regular_price();
		$sale    = (float) $product->get_sale_price();
		if ( $regular > 0 ) {
			$percent = round( ( ( $regular - $sale ) / $regular ) * 100 );
			echo '<span class="sf-card__badge sf-card__badge--sale">' . esc_html( $percent . '% Off' ) . '</span>';
		}
	}
	$created = strtotime( $product->get_date_created() );
	if ( $created && ( time() - $created ) < ( 30 * DAY_IN_SECONDS ) ) {
		echo '<span class="sf-card__badge sf-card__badge--new">' . esc_html__( 'New', 'snazzy-floret' ) . '</span>';
	}
	echo '</div>';

	// Quick View button
	echo '<button class="sf-quick-view-btn" data-product-id="' . esc_attr( $product->get_id() ) . '" aria-label="' . esc_attr__( 'Quick view', 'snazzy-floret' ) . '">';
	echo '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
	echo '</button>';

	echo '</div>'; // close .sf-card__image-wrap
}

// Remove old custom hooks if present
remove_action( 'woocommerce_before_shop_loop_item_title', 'sf_product_new_badge', 15 );

// --- INFO AREA ---
add_action( 'woocommerce_shop_loop_item_title', 'sf_card_info_open', 1 );
function sf_card_info_open() {
	echo '<div class="sf-card__info">';
}

add_action( 'woocommerce_shop_loop_item_title', 'sf_card_category', 5 );
function sf_card_category() {
	global $product;
	$terms = get_the_terms( $product->get_id(), 'product_cat' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$cat = $terms[0];
		echo '<span class="sf-card__category">' . esc_html( $cat->name ) . '</span>';
	}
}

add_action( 'woocommerce_shop_loop_item_title', 'sf_card_title', 10 );
function sf_card_title() {
	global $product;
	echo '<h2 class="sf-card__title"><a href="' . esc_url( get_permalink( $product->get_id() ) ) . '">' . esc_html( get_the_title() ) . '</a></h2>';
}

add_action( 'woocommerce_after_shop_loop_item_title', 'sf_card_price', 10 );
function sf_card_price() {
	global $product;
	echo '<div class="sf-card__price">' . wp_kses_post( $product->get_price_html() ) . '</div>';
}

add_action( 'woocommerce_after_shop_loop_item_title', 'sf_card_hover_actions', 15 );
function sf_card_hover_actions() {
	global $product;
	echo '<div class="sf-card__hover-actions">';
	if ( $product->is_in_stock() ) {
		echo '<a href="' . esc_url( $product->add_to_cart_url() ) . '" class="sf-card__add-btn" data-product_id="' . esc_attr( $product->get_id() ) . '" aria-label="' . esc_attr__( 'Add to cart', 'snazzy-floret' ) . '">';
		echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>';
		echo esc_html__( 'Add to Cart', 'snazzy-floret' );
		echo '</a>';
	} else {
		echo '<span class="sf-card__sold-out">' . esc_html__( 'Sold Out', 'snazzy-floret' ) . '</span>';
	}
	echo '</div>';
}

add_action( 'woocommerce_after_shop_loop_item', 'sf_card_info_close', 20 );
function sf_card_info_close() {
	echo '</div>'; // close .sf-card__info
}

/* ===================================================================
   MULTI-SIZE ADD TO CART (AJAX)
   =================================================================== */

/**
 * AJAX endpoint: add a single product with multiple (size, qty) entries.
 * Each size becomes its own cart line item via cart_item_data uniqueness.
 */
function sf_add_sizes_to_cart() {
	check_ajax_referer( 'sf_add_sizes', 'nonce' );

	$product_id = isset( $_POST['product_id'] ) ? absint( wp_unslash( $_POST['product_id'] ) ) : 0;
	$items_raw  = isset( $_POST['items'] ) ? wp_unslash( $_POST['items'] ) : '';
	$items      = json_decode( $items_raw, true );

	if ( ! $product_id || empty( $items ) || ! is_array( $items ) ) {
		wp_send_json_error( __( 'Invalid request.', 'snazzy-floret' ) );
	}

	$product = wc_get_product( $product_id );
	if ( ! $product || ! $product->is_purchasable() ) {
		wp_send_json_error( __( 'Product not available.', 'snazzy-floret' ) );
	}

	$available = sf_get_available_sizes( $product_id );
	if ( empty( $available ) ) {
		wp_send_json_error( __( 'No sizes available for this product.', 'snazzy-floret' ) );
	}

	$added = 0;
	foreach ( $items as $it ) {
		$size = isset( $it['size'] ) ? intval( $it['size'] ) : 0;
		$qty  = isset( $it['qty'] ) ? max( 1, intval( $it['qty'] ) ) : 1;
		if ( ! in_array( $size, $available, true ) ) {
			continue;
		}
		$cart_item_data = array( 'sf_size' => $size );
		$key = WC()->cart->add_to_cart( $product_id, $qty, 0, array(), $cart_item_data );
		if ( $key ) {
			$added++;
		}
	}

	if ( ! $added ) {
		wp_send_json_error( __( 'Could not add any sizes to cart.', 'snazzy-floret' ) );
	}

	WC()->cart->calculate_totals();

	wp_send_json_success( array(
		'added' => $added,
		'count' => WC()->cart->get_cart_contents_count(),
		'total' => WC()->cart->get_cart_total(),
	) );
}
add_action( 'wp_ajax_sf_add_sizes_to_cart', 'sf_add_sizes_to_cart' );
add_action( 'wp_ajax_nopriv_sf_add_sizes_to_cart', 'sf_add_sizes_to_cart' );

/**
 * Display the chosen size in cart, mini-cart and checkout.
 */
function sf_display_size_in_cart( $item_data, $cart_item ) {
	if ( ! empty( $cart_item['sf_size'] ) ) {
		$item_data[] = array(
			'key'     => __( 'Size', 'snazzy-floret' ),
			'value'   => esc_html( $cart_item['sf_size'] ),
			'display' => '',
		);
	}
	return $item_data;
}
add_filter( 'woocommerce_get_item_data', 'sf_display_size_in_cart', 10, 2 );

/**
 * Persist the chosen size onto the order line item.
 */
function sf_save_size_to_order_item( $item, $cart_item_key, $values, $order ) {
	if ( ! empty( $values['sf_size'] ) ) {
		$item->add_meta_data( __( 'Size', 'snazzy-floret' ), $values['sf_size'], true );
	}
}
add_action( 'woocommerce_checkout_create_order_line_item', 'sf_save_size_to_order_item', 10, 4 );

/**
 * Render an "Edit Size" button in the cart row, after the product name.
 * Uses a hidden JSON blob with the product's available sizes for the popover.
 */
function sf_cart_size_edit_button( $cart_item, $cart_item_key ) {
	if ( ! is_cart() ) {
		return;
	}
	$product_id = isset( $cart_item['product_id'] ) ? absint( $cart_item['product_id'] ) : 0;
	if ( ! $product_id ) {
		return;
	}
	$current   = isset( $cart_item['sf_size'] ) ? intval( $cart_item['sf_size'] ) : 0;
	$available = sf_get_available_sizes( $product_id );
	if ( empty( $available ) ) {
		return;
	}
	$all = range( 35, 42 );
	?>
	<div class="sf-cart-size-edit"
		data-key="<?php echo esc_attr( $cart_item_key ); ?>"
		data-product="<?php echo esc_attr( $product_id ); ?>"
		data-current="<?php echo esc_attr( $current ); ?>"
		data-available="<?php echo esc_attr( wp_json_encode( $available ) ); ?>"
		data-all="<?php echo esc_attr( wp_json_encode( $all ) ); ?>"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'sf_update_size' ) ); ?>"
	>
		<button type="button" class="sf-cart-size-edit__btn" aria-label="<?php esc_attr_e( 'Edit size', 'snazzy-floret' ); ?>">
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
		</button>
	</div>
	<?php
}
add_action( 'woocommerce_after_cart_item_name', 'sf_cart_size_edit_button', 20, 2 );

/**
 * AJAX: change a cart item's size. Removes the old line and adds a new one
 * with the same quantity, preserving the cart_item_data['sf_size'] uniqueness.
 */
function sf_update_cart_item_size() {
	check_ajax_referer( 'sf_update_size', 'nonce' );

	$cart_key = isset( $_POST['cart_key'] ) ? sanitize_text_field( wp_unslash( $_POST['cart_key'] ) ) : '';
	$new_size = isset( $_POST['size'] ) ? intval( $_POST['size'] ) : 0;

	if ( ! $cart_key || ! $new_size ) {
		wp_send_json_error( __( 'Invalid request.', 'snazzy-floret' ) );
	}

	$cart  = WC()->cart;
	$items = $cart->get_cart();
	if ( ! isset( $items[ $cart_key ] ) ) {
		wp_send_json_error( __( 'Cart item not found.', 'snazzy-floret' ) );
	}

	$item       = $items[ $cart_key ];
	$product_id = $item['product_id'];
	$qty        = $item['quantity'];
	$available  = sf_get_available_sizes( $product_id );
	if ( ! in_array( $new_size, $available, true ) ) {
		wp_send_json_error( __( 'Selected size is not available.', 'snazzy-floret' ) );
	}

	$cart->remove_cart_item( $cart_key );
	$new_key = $cart->add_to_cart( $product_id, $qty, 0, array(), array( 'sf_size' => $new_size ) );
	$cart->calculate_totals();

	if ( ! $new_key ) {
		wp_send_json_error( __( 'Could not update size.', 'snazzy-floret' ) );
	}

	wp_send_json_success( array(
		'count' => $cart->get_cart_contents_count(),
		'total' => $cart->get_cart_total(),
	) );
}
add_action( 'wp_ajax_sf_update_cart_item_size', 'sf_update_cart_item_size' );
add_action( 'wp_ajax_nopriv_sf_update_cart_item_size', 'sf_update_cart_item_size' );

/* ===================================================================
   SINGLE PRODUCT
   =================================================================== */

// Remove tabs — use accordion style instead
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

// Related products
function sf_related_products_args( $args ) {
	$args['posts_per_page'] = 3;
	$args['columns']        = 3;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'sf_related_products_args' );

/* ===================================================================
   AJAX ADD TO CART
   =================================================================== */

function sf_ajax_add_to_cart() {
	check_ajax_referer( 'sf_ajax_nonce', 'nonce' );

	$product_id = absint( $_POST['product_id'] );
	$quantity   = absint( $_POST['quantity'] ?? 1 );

	if ( WC()->cart->add_to_cart( $product_id, $quantity ) ) {
		WC_AJAX::get_refreshed_fragments();
	} else {
		wp_send_json_error( array(
			'message' => __( 'Could not add to cart.', 'snazzy-floret' ),
		) );
	}
	wp_die();
}
add_action( 'wp_ajax_sf_add_to_cart', 'sf_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_sf_add_to_cart', 'sf_ajax_add_to_cart' );

function sf_cart_count_fragment( $fragments ) {
	$fragments['.sf-header__cart-count'] = '<span class="sf-header__cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'sf_cart_count_fragment' );

/* ===================================================================
   MINI CART DRAWER — AJAX get contents & remove item
   =================================================================== */

function sf_get_cart_drawer() {
	check_ajax_referer( 'sf_ajax_nonce', 'nonce' );

	$cart  = WC()->cart;
	$count = $cart->get_cart_contents_count();
	$items = array();

	foreach ( $cart->get_cart() as $cart_key => $cart_item ) {
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_key );
		if ( ! $_product || ! $_product->exists() ) {
			continue;
		}
		$thumb_id  = $_product->get_image_id();
		$thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'thumbnail' ) : wc_placeholder_img_src( 'thumbnail' );
		$price_html = $cart->get_product_price( $_product );
		$items[]   = array(
			'key'   => $cart_key,
			'name'  => wp_trim_words( $_product->get_name(), 5 ),
			'price' => $price_html,
			'qty'   => $cart_item['quantity'],
			'image' => $thumb_url,
			'link'  => $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '',
			'size'  => ! empty( $cart_item['sf_size'] ) ? (string) $cart_item['sf_size'] : '',
		);
	}

	wp_send_json_success( array(
		'count'    => $count,
		'items'    => $items,
		'subtotal' => $cart->get_cart_subtotal(),
		'cart_url'     => wc_get_cart_url(),
		'checkout_url' => wc_get_checkout_url(),
		'shop_url'     => get_permalink( wc_get_page_id( 'shop' ) ),
	) );
}
add_action( 'wp_ajax_sf_get_cart_drawer', 'sf_get_cart_drawer' );
add_action( 'wp_ajax_nopriv_sf_get_cart_drawer', 'sf_get_cart_drawer' );

function sf_remove_cart_item() {
	check_ajax_referer( 'sf_ajax_nonce', 'nonce' );

	$cart_key = sanitize_text_field( $_POST['cart_key'] );
	if ( WC()->cart->remove_cart_item( $cart_key ) ) {
		WC_AJAX::get_refreshed_fragments();
	} else {
		wp_send_json_error( array( 'message' => __( 'Could not remove item.', 'snazzy-floret' ) ) );
	}
	wp_die();
}
add_action( 'wp_ajax_sf_remove_cart_item', 'sf_remove_cart_item' );
add_action( 'wp_ajax_nopriv_sf_remove_cart_item', 'sf_remove_cart_item' );

/* ===================================================================
   SALE FLASH — Replace "Sale!" with percentage
   =================================================================== */

add_filter( 'woocommerce_sale_flash', '__return_empty_string' );

/* ===================================================================
   QUICK VIEW AJAX
   =================================================================== */

function sf_quick_view() {
	check_ajax_referer( 'sf_ajax_nonce', 'nonce' );

	$product_id = absint( $_POST['product_id'] );
	$product    = wc_get_product( $product_id );

	if ( ! $product ) {
		wp_send_json_error( array( 'message' => __( 'Product not found.', 'snazzy-floret' ) ) );
	}

	$image_id   = $product->get_image_id();
	$gallery    = $product->get_gallery_image_ids();
	$terms      = get_the_terms( $product_id, 'product_cat' );
	$cat_name   = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
	$link       = get_permalink( $product_id );
	$in_stock   = $product->is_in_stock();

	ob_start();
	?>
	<div class="sf-qv__gallery">
		<div class="sf-qv__main-image">
			<?php echo wp_get_attachment_image( $image_id, 'sf-product-card', false, array( 'class' => 'sf-qv__img' ) ); ?>
		</div>
		<?php if ( ! empty( $gallery ) ) : ?>
		<div class="sf-qv__thumbs">
			<button class="sf-qv__thumb is-active" data-img="<?php echo esc_url( wp_get_attachment_image_url( $image_id, 'sf-product-card' ) ); ?>">
				<?php echo wp_get_attachment_image( $image_id, 'sf-product-thumb' ); ?>
			</button>
			<?php foreach ( array_slice( $gallery, 0, 4 ) as $gal_id ) : ?>
			<button class="sf-qv__thumb" data-img="<?php echo esc_url( wp_get_attachment_image_url( $gal_id, 'sf-product-card' ) ); ?>">
				<?php echo wp_get_attachment_image( $gal_id, 'sf-product-thumb' ); ?>
			</button>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
	<div class="sf-qv__details">
		<?php if ( $cat_name ) : ?>
			<span class="sf-qv__category"><?php echo esc_html( $cat_name ); ?></span>
		<?php endif; ?>
		<h2 class="sf-qv__title"><?php echo esc_html( $product->get_name() ); ?></h2>
		<div class="sf-qv__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
		<?php if ( $product->get_short_description() ) : ?>
			<div class="sf-qv__desc"><?php echo wp_kses_post( $product->get_short_description() ); ?></div>
		<?php endif; ?>
		<?php if ( $in_stock ) : ?>
			<div class="sf-qv__stock sf-qv__stock--in">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
				<?php esc_html_e( 'In Stock', 'snazzy-floret' ); ?>
			</div>
		<?php else : ?>
			<div class="sf-qv__stock sf-qv__stock--out"><?php esc_html_e( 'Out of Stock', 'snazzy-floret' ); ?></div>
		<?php endif; ?>
		<div class="sf-qv__actions">
			<?php if ( $in_stock ) : ?>
				<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="sf-btn sf-btn--primary sf-qv__add-btn" data-product_id="<?php echo esc_attr( $product_id ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
					<?php esc_html_e( 'Add to Cart', 'snazzy-floret' ); ?>
				</a>
			<?php endif; ?>
			<a href="<?php echo esc_url( $link ); ?>" class="sf-btn sf-btn--outline sf-qv__view-btn">
				<?php esc_html_e( 'View Full Details', 'snazzy-floret' ); ?>
			</a>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_sf_quick_view', 'sf_quick_view' );
add_action( 'wp_ajax_nopriv_sf_quick_view', 'sf_quick_view' );

/* ===================================================================
   QUICK VIEW MODAL — output in footer
   =================================================================== */

function sf_quick_view_modal() {
	if ( ! is_woocommerce() && ! is_front_page() && ! is_shop() ) {
		return;
	}
	?>
	<div class="sf-quick-view-modal" id="sf-quick-view-modal" aria-hidden="true">
		<div class="sf-qv__overlay"></div>
		<div class="sf-qv__container">
			<button class="sf-qv__close" aria-label="<?php esc_attr_e( 'Close quick view', 'snazzy-floret' ); ?>">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
			</button>
			<div class="sf-qv__content" id="sf-qv-content">
				<div class="sf-qv__loading">
					<div class="sf-qv__spinner"></div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'wp_footer', 'sf_quick_view_modal' );

/* ===================================================================
   CHECKOUT — Mandatory account creation for guests
   =================================================================== */

/**
 * Force WooCommerce blocks checkout to show + require account creation
 * for guest users. Only affects the checkout page; logged-in users see
 * no password fields.
 */
function sf_force_guest_account_creation_settings( $value, $option = '' ) {
	if ( is_user_logged_in() ) {
		return $value;
	}
	return 'yes';
}
add_filter( 'pre_option_woocommerce_enable_signup_and_login_from_checkout', 'sf_force_guest_account_creation_settings' );
add_filter( 'pre_option_woocommerce_enable_guest_checkout', function ( $v ) {
	return 'no'; // Guests must register.
} );
add_filter( 'pre_option_woocommerce_enable_checkout_login_reminder', function ( $v ) {
	return 'yes';
} );
add_filter( 'pre_option_woocommerce_registration_generate_password', function ( $v ) {
	return 'no'; // Show password field instead of auto-generating.
} );
add_filter( 'pre_option_woocommerce_enable_myaccount_registration', function ( $v ) {
	return 'yes';
} );
add_filter( 'woocommerce_checkout_registration_required', '__return_true' );
add_filter( 'woocommerce_checkout_registration_enabled', '__return_true' );

/**
 * Ensure new accounts created at checkout get the safe "customer" role only.
 * Prevents capability escalation regardless of submitted data.
 */
function sf_force_customer_role_on_checkout_signup( $customer_id ) {
	if ( ! $customer_id ) {
		return;
	}
	$user = get_user_by( 'id', $customer_id );
	if ( ! $user ) {
		return;
	}
	$user->set_role( 'customer' );
}
add_action( 'woocommerce_created_customer', 'sf_force_customer_role_on_checkout_signup', 99 );

/**
 * Strip any role / capability params posted via checkout to block
 * privilege escalation attempts.
 */
function sf_strip_role_from_checkout_post( $data ) {
	unset( $_POST['role'], $_POST['user_role'], $_POST['wp_capabilities'] );
	return $data;
}
add_filter( 'woocommerce_checkout_posted_data', 'sf_strip_role_from_checkout_post' );

