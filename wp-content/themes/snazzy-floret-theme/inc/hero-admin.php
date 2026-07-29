<?php
/**
 * Hero Slider Manager — dedicated admin screen.
 *
 * Adds a top-level "Hero" menu in wp-admin where an administrator can create,
 * edit, delete, enable/disable and reorder an unlimited number of hero sliders.
 * Each slider holds a background image, title, description, 2-3 CTA buttons and
 * its own list of featured products (no fixed limit per slider).
 *
 * Data lives in the `sf_hero_sliders` option as an ordered array — array order
 * is the display order.
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Option key holding the ordered slider list. */
const SF_HERO_OPTION = 'sf_hero_sliders';

/** Allowed CTA button styles. */
function sf_hero_button_styles() {
	return array(
		'primary' => __( 'Primary (filled)', 'snazzy-floret' ),
		'outline' => __( 'Outline', 'snazzy-floret' ),
		'ghost'   => __( 'Ghost (subtle)', 'snazzy-floret' ),
	);
}

/** Maximum CTA buttons per slider. */
function sf_hero_max_buttons() {
	return 3;
}

/**
 * Blank slider used when the admin adds a new one.
 *
 * @return array
 */
function sf_hero_empty_slider() {
	return array(
		'active'           => 1,
		'image_id'         => 0,
		'image_url'        => '',
		'image_mobile_id'  => 0,  // Optional portrait crop for phones.
		'image_mobile_url' => '',
		'show_content' => 1, // Master switch for the tag / title / accent / description block.
		'tag'          => '',
		'title'        => '',
		'title_em'     => '',
		'desc'         => '',
		'show_buttons' => 1, // Master switch for the CTA button row.
		'buttons'      => array(), // Buttons are optional — add them only if wanted.
		'products'     => array(),
	);
}

/**
 * Seed data — migrated from the existing Customizer slides so the new screen
 * opens with the site's current hero content instead of an empty list.
 *
 * @return array
 */
function sf_hero_default_sliders() {
	$legacy = function_exists( 'sf_get_hero_slides' ) ? sf_get_hero_slides() : array();
	$out    = array();

	foreach ( $legacy as $slide ) {
		$buttons = array(
			array(
				'text'  => ! empty( $slide['btn'] ) ? $slide['btn'] : __( 'Explore Collection', 'snazzy-floret' ),
				'url'   => isset( $slide['link'] ) ? $slide['link'] : '',
				'style' => 'primary',
			),
			array(
				'text'  => __( 'View All', 'snazzy-floret' ),
				'url'   => '',
				'style' => 'ghost',
			),
		);

		$out[] = array(
			'active'       => 1,
			'image_id'     => 0,
			'image_url'    => isset( $slide['image'] ) ? $slide['image'] : '',
			'show_content' => 1,
			'tag'          => isset( $slide['tag'] ) ? $slide['tag'] : '',
			'title'        => isset( $slide['title'] ) ? $slide['title'] : '',
			'title_em'     => isset( $slide['title_em'] ) ? $slide['title_em'] : '',
			'desc'         => isset( $slide['desc'] ) ? $slide['desc'] : '',
			'show_buttons' => 1,
			'buttons'      => $buttons,
			'products'     => array(),
		);
	}

	return $out;
}

/**
 * Resolve a slider image URL (attachment first, raw URL fallback).
 *
 * @param array  $slider Slider data.
 * @param string $size   Image size.
 * @param string $key    Which image: 'image' (desktop) or 'image_mobile'.
 * @return string
 */
function sf_hero_image_url( $slider, $size = 'full', $key = 'image' ) {
	$id_key  = $key . '_id';
	$url_key = $key . '_url';

	if ( ! empty( $slider[ $id_key ] ) ) {
		$url = wp_get_attachment_image_url( (int) $slider[ $id_key ], $size );
		if ( $url ) {
			return $url;
		}
	}
	return ! empty( $slider[ $url_key ] ) ? $slider[ $url_key ] : '';
}

/**
 * Optional phone-sized background. Empty when the admin has not set one, in
 * which case the desktop image is used at every width.
 *
 * @param array  $slider Slider data.
 * @param string $size   Image size.
 * @return string
 */
function sf_hero_mobile_image_url( $slider, $size = 'full' ) {
	return sf_hero_image_url( $slider, $size, 'image_mobile' );
}

/**
 * Get the sliders in display order.
 *
 * @param bool $active_only Return only enabled sliders that have a background.
 * @return array
 */
function sf_hero_get_sliders( $active_only = false ) {
	$sliders = get_option( SF_HERO_OPTION, null );

	if ( ! is_array( $sliders ) ) {
		$sliders = sf_hero_default_sliders();
	}

	/*
	 * Fill in any key a slider saved before a newer field existed. Missing keys
	 * inherit the blank-slider defaults, so section switches added later read as
	 * "shown" for existing sliders rather than silently hiding their content.
	 */
	$defaults = sf_hero_empty_slider();
	$sliders  = array_map(
		static function ( $slider ) use ( $defaults ) {
			return is_array( $slider ) ? wp_parse_args( $slider, $defaults ) : $defaults;
		},
		$sliders
	);

	if ( $active_only ) {
		$sliders = array_values(
			array_filter(
				$sliders,
				static function ( $slider ) {
					return ! empty( $slider['active'] ) && '' !== sf_hero_image_url( $slider );
				}
			)
		);
	}

	return $sliders;
}

/**
 * Sanitize the posted slider list.
 *
 * @param mixed $raw Raw $_POST value.
 * @return array
 */
function sf_hero_sanitize_sliders( $raw ) {
	if ( ! is_array( $raw ) ) {
		return array();
	}

	$styles = array_keys( sf_hero_button_styles() );
	$clean  = array();

	foreach ( $raw as $slider ) {
		if ( ! is_array( $slider ) ) {
			continue;
		}

		$buttons = array();
		if ( ! empty( $slider['buttons'] ) && is_array( $slider['buttons'] ) ) {
			foreach ( $slider['buttons'] as $button ) {
				if ( ! is_array( $button ) ) {
					continue;
				}
				$text = isset( $button['text'] ) ? sanitize_text_field( wp_unslash( $button['text'] ) ) : '';
				if ( '' === $text ) {
					continue; // A button with no label is nothing.
				}
				$style = isset( $button['style'] ) ? sanitize_key( $button['style'] ) : 'primary';
				$buttons[] = array(
					'text'  => $text,
					'url'   => isset( $button['url'] ) ? esc_url_raw( wp_unslash( $button['url'] ) ) : '',
					'style' => in_array( $style, $styles, true ) ? $style : 'primary',
				);
				if ( count( $buttons ) >= sf_hero_max_buttons() ) {
					break;
				}
			}
		}

		$products = array();
		if ( ! empty( $slider['products'] ) && is_array( $slider['products'] ) ) {
			foreach ( $slider['products'] as $product ) {
				if ( ! is_array( $product ) ) {
					continue;
				}
				$product_id = isset( $product['id'] ) ? absint( $product['id'] ) : 0;
				if ( ! $product_id ) {
					continue;
				}
				$products[] = array(
					'id'    => $product_id,
					'label' => isset( $product['label'] ) ? sanitize_text_field( wp_unslash( $product['label'] ) ) : '',
				);
			}
		}

		$clean[] = array(
			'active'           => empty( $slider['active'] ) ? 0 : 1,
			'image_id'         => isset( $slider['image_id'] ) ? absint( $slider['image_id'] ) : 0,
			'image_url'        => isset( $slider['image_url'] ) ? esc_url_raw( wp_unslash( $slider['image_url'] ) ) : '',
			'image_mobile_id'  => isset( $slider['image_mobile_id'] ) ? absint( $slider['image_mobile_id'] ) : 0,
			'image_mobile_url' => isset( $slider['image_mobile_url'] ) ? esc_url_raw( wp_unslash( $slider['image_mobile_url'] ) ) : '',
			'show_content' => empty( $slider['show_content'] ) ? 0 : 1,
			'tag'          => isset( $slider['tag'] ) ? sanitize_text_field( wp_unslash( $slider['tag'] ) ) : '',
			'title'        => isset( $slider['title'] ) ? sanitize_text_field( wp_unslash( $slider['title'] ) ) : '',
			'title_em'     => isset( $slider['title_em'] ) ? sanitize_text_field( wp_unslash( $slider['title_em'] ) ) : '',
			'desc'         => isset( $slider['desc'] ) ? sanitize_textarea_field( wp_unslash( $slider['desc'] ) ) : '',
			'show_buttons' => empty( $slider['show_buttons'] ) ? 0 : 1,
			'buttons'      => $buttons,
			'products'     => $products,
		);
	}

	return $clean;
}

/* -------------------------------------------------------------------------
 * Admin menu
 * ---------------------------------------------------------------------- */

/**
 * Register the top-level "Hero" menu.
 */
function sf_hero_admin_menu() {
	add_menu_page(
		__( 'Hero Slider Management', 'snazzy-floret' ),
		__( 'Hero', 'snazzy-floret' ),
		'manage_options',
		'sf-hero-sliders',
		'sf_hero_render_admin_page',
		'dashicons-images-alt2',
		26
	);
}
add_action( 'admin_menu', 'sf_hero_admin_menu' );

/**
 * Enqueue the manager's assets on its own screen only.
 *
 * @param string $hook Current admin page hook.
 */
function sf_hero_admin_assets( $hook ) {
	if ( 'toplevel_page_sf-hero-sliders' !== $hook ) {
		return;
	}

	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_media();
	wp_enqueue_script( 'jquery-ui-sortable' );

	wp_enqueue_style(
		'sf-hero-admin',
		$uri . '/assets/css/hero-admin.css',
		array(),
		filemtime( $dir . '/assets/css/hero-admin.css' )
	);

	wp_enqueue_script(
		'sf-hero-admin',
		$uri . '/assets/js/hero-admin.js',
		array( 'jquery', 'jquery-ui-sortable' ),
		filemtime( $dir . '/assets/js/hero-admin.js' ),
		true
	);

	wp_localize_script(
		'sf-hero-admin',
		'sfHeroAdmin',
		array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'nonce'       => wp_create_nonce( 'sf_hero_admin' ),
			'maxButtons'  => sf_hero_max_buttons(),
			'i18n'        => array(
				'confirmDelete' => __( 'Delete this slider? This cannot be undone once you save.', 'snazzy-floret' ),
				'untitled'      => __( 'Untitled slider', 'snazzy-floret' ),
				'maxButtons'    => sprintf(
					/* translators: %d: maximum number of CTA buttons. */
					__( 'You can add up to %d buttons per slider.', 'snazzy-floret' ),
					sf_hero_max_buttons()
				),
				'searching'     => __( 'Searching…', 'snazzy-floret' ),
				'noResults'     => __( 'No products found.', 'snazzy-floret' ),
				/* translators: 1: products listed, 2: total matching products. */
				'truncated'     => __( 'Showing %1$d of %2$d products — type to narrow the list.', 'snazzy-floret' ),
				/* translators: %d: total number of products. */
				'allShown'      => __( 'All %d products', 'snazzy-floret' ),
				'alreadyAdded'  => __( 'That product is already in this slider.', 'snazzy-floret' ),
				'chooseImage'   => __( 'Select background image', 'snazzy-floret' ),
				'useImage'      => __( 'Use this image', 'snazzy-floret' ),
			),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'sf_hero_admin_assets' );

/* -------------------------------------------------------------------------
 * Save handler
 * ---------------------------------------------------------------------- */

/**
 * Persist the submitted sliders.
 */
function sf_hero_handle_save() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to manage hero sliders.', 'snazzy-floret' ) );
	}

	check_admin_referer( 'sf_hero_save', 'sf_hero_nonce' );

	$raw     = isset( $_POST['sf_hero'] ) ? wp_unslash( $_POST['sf_hero'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized in sf_hero_sanitize_sliders().
	$sliders = sf_hero_sanitize_sliders( $raw );

	update_option( SF_HERO_OPTION, $sliders );

	if ( isset( $_POST['sf_hero_speed'] ) ) {
		$speed = absint( wp_unslash( $_POST['sf_hero_speed'] ) );
		set_theme_mod( 'sf_hero_speed', min( 15000, max( 2000, $speed ) ) );
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'     => 'sf-hero-sliders',
				'sf_saved' => count( $sliders ),
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_sf_hero_save', 'sf_hero_handle_save' );

/* -------------------------------------------------------------------------
 * Product search (featured products picker)
 * ---------------------------------------------------------------------- */

/**
 * Compact, plain-text price for a product.
 *
 * get_price_html() embeds screen-reader spans ("Original price was: …") which
 * turn into noise once tags are stripped, so build the active price directly.
 *
 * @param int $product_id Product ID.
 * @return string
 */
function sf_hero_product_price_text( $product_id ) {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return '';
	}

	$product = wc_get_product( $product_id );
	if ( ! $product ) {
		return '';
	}

	$price = function_exists( 'wc_get_price_to_display' )
		? wc_get_price_to_display( $product )
		: $product->get_price();

	if ( '' === $price || null === $price ) {
		return '';
	}

	return trim( wp_strip_all_tags( wc_price( $price ) ) );
}

/**
 * Build the admin-side payload for one product.
 *
 * @param int $product_id Product ID.
 * @return array|null
 */
function sf_hero_product_payload( $product_id ) {
	$product_id = absint( $product_id );
	$post       = get_post( $product_id );

	if ( ! $post || 'product' !== $post->post_type ) {
		return null;
	}

	$thumb = get_the_post_thumbnail_url( $product_id, 'thumbnail' );
	if ( ! $thumb && function_exists( 'wc_placeholder_img_src' ) ) {
		$thumb = wc_placeholder_img_src( 'thumbnail' );
	}

	$price = sf_hero_product_price_text( $product_id );

	return array(
		'id'    => $product_id,
		'name'  => get_the_title( $product_id ),
		'thumb' => $thumb ? $thumb : '',
		'price' => $price,
		'edit'  => get_edit_post_link( $product_id, 'raw' ),
	);
}

/**
 * AJAX: search products for the featured-products picker.
 */
function sf_hero_ajax_product_search() {
	check_ajax_referer( 'sf_hero_admin', 'nonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => __( 'Not allowed.', 'snazzy-floret' ) ), 403 );
	}

	$term = isset( $_GET['term'] ) ? sanitize_text_field( wp_unslash( $_GET['term'] ) ) : '';

	/*
	 * Every published product, every time — no cap and no caching, so a product
	 * published a moment ago shows up here on the next search without any
	 * further action. Only IDs are queried; the display payload is built after.
	 */
	$args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'posts_per_page'      => -1,
		'fields'              => 'ids',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'orderby'             => 'title',
		'order'               => 'ASC',
	);

	if ( '' !== $term ) {
		$args['s'] = $term;
	}

	$query   = new WP_Query( $args );
	$results = array();

	foreach ( $query->posts as $product_id ) {
		$payload = sf_hero_product_payload( $product_id );
		if ( $payload ) {
			$results[] = $payload;
		}
	}

	wp_send_json_success(
		array(
			'items' => $results,
			'total' => count( $results ),
			'shown' => count( $results ),
		)
	);
}
add_action( 'wp_ajax_sf_hero_product_search', 'sf_hero_ajax_product_search' );

/* -------------------------------------------------------------------------
 * Screen markup
 * ---------------------------------------------------------------------- */

/**
 * Render one CTA button row.
 *
 * @param string $slider_index Slider index or template placeholder.
 * @param string $index        Button index or template placeholder.
 * @param array  $button       Button data.
 */
function sf_hero_render_button_row( $slider_index, $index, $button ) {
	$base = 'sf_hero[' . $slider_index . '][buttons][' . $index . ']';
	?>
	<div class="sf-hero-btn">
		<span class="sf-hero-btn__handle dashicons dashicons-menu-alt" aria-hidden="true"></span>
		<label class="sf-hero-btn__field">
			<span class="sf-hero-field__label"><?php esc_html_e( 'Button text', 'snazzy-floret' ); ?></span>
			<input type="text" data-sf-btn="text" name="<?php echo esc_attr( $base . '[text]' ); ?>"
				value="<?php echo esc_attr( $button['text'] ); ?>"
				placeholder="<?php esc_attr_e( 'Shop Now', 'snazzy-floret' ); ?>">
		</label>
		<label class="sf-hero-btn__field sf-hero-btn__field--url">
			<span class="sf-hero-field__label"><?php esc_html_e( 'Destination URL', 'snazzy-floret' ); ?></span>
			<input type="url" data-sf-btn="url" name="<?php echo esc_attr( $base . '[url]' ); ?>"
				value="<?php echo esc_attr( $button['url'] ); ?>"
				placeholder="<?php esc_attr_e( 'https://…  (empty = Shop page)', 'snazzy-floret' ); ?>">
		</label>
		<label class="sf-hero-btn__field sf-hero-btn__field--style">
			<span class="sf-hero-field__label"><?php esc_html_e( 'Style', 'snazzy-floret' ); ?></span>
			<select data-sf-btn="style" name="<?php echo esc_attr( $base . '[style]' ); ?>">
				<?php foreach ( sf_hero_button_styles() as $key => $label ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $button['style'], $key ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</label>
		<button type="button" class="sf-hero-btn__remove" title="<?php esc_attr_e( 'Remove button', 'snazzy-floret' ); ?>">
			<span class="dashicons dashicons-no-alt"></span>
		</button>
	</div>
	<?php
}

/**
 * Render one media picker (used for both the desktop and mobile backgrounds).
 *
 * @param string $base   Field name base for the slider, e.g. "sf_hero[0]".
 * @param array  $slider Slider data.
 * @param string $key    'image' or 'image_mobile'.
 * @param string $label  Heading shown above the picker.
 * @param string $note   Helper text under the buttons.
 * @param bool   $is_key Whether this image drives the collapsed row thumbnail.
 * @param string $spec   Exact size guidance, shown in a highlighted line.
 */
function sf_hero_render_media_field( $base, $slider, $key, $label, $note, $is_key = false, $spec = '' ) {
	$image = sf_hero_image_url( $slider, 'medium', $key );
	?>
	<div class="sf-hero-media" data-sf-media="<?php echo esc_attr( $key ); ?>"
		data-sf-primary="<?php echo $is_key ? '1' : '0'; ?>">
		<h5 class="sf-hero-media__label"><?php echo esc_html( $label ); ?></h5>
		<div class="sf-hero-media__preview <?php echo $image ? '' : 'is-empty'; ?>">
			<?php if ( $image ) : ?>
				<img src="<?php echo esc_url( $image ); ?>" alt="">
			<?php endif; ?>
		</div>
		<div class="sf-hero-media__actions">
			<button type="button" class="button sf-hero-media__pick"><?php esc_html_e( 'Choose image', 'snazzy-floret' ); ?></button>
			<button type="button" class="button-link sf-hero-media__clear" <?php echo $image ? '' : 'style="display:none"'; ?>>
				<?php esc_html_e( 'Remove', 'snazzy-floret' ); ?>
			</button>
		</div>
		<input type="hidden" data-sf-field="<?php echo esc_attr( $key . '_id' ); ?>"
			name="<?php echo esc_attr( $base . '[' . $key . '_id]' ); ?>"
			value="<?php echo esc_attr( isset( $slider[ $key . '_id' ] ) ? $slider[ $key . '_id' ] : 0 ); ?>">
		<input type="hidden" data-sf-field="<?php echo esc_attr( $key . '_url' ); ?>"
			name="<?php echo esc_attr( $base . '[' . $key . '_url]' ); ?>"
			value="<?php echo esc_attr( isset( $slider[ $key . '_url' ] ) ? $slider[ $key . '_url' ] : '' ); ?>">
		<?php if ( $spec ) : ?>
			<p class="sf-hero-media__spec">
				<span class="dashicons dashicons-info-outline" aria-hidden="true"></span>
				<?php echo esc_html( $spec ); ?>
			</p>
		<?php endif; ?>
		<p class="description"><?php echo esc_html( $note ); ?></p>
	</div>
	<?php
}

/**
 * Render one featured-product row.
 *
 * @param string $slider_index Slider index or template placeholder.
 * @param string $index        Product index or template placeholder.
 * @param array  $product      Product data ( id, label ).
 */
function sf_hero_render_product_row( $slider_index, $index, $product ) {
	$base    = 'sf_hero[' . $slider_index . '][products][' . $index . ']';
	$payload = $product['id'] ? sf_hero_product_payload( $product['id'] ) : null;
	$name    = $payload ? $payload['name'] : __( '(product no longer exists)', 'snazzy-floret' );
	$thumb   = $payload && $payload['thumb'] ? $payload['thumb'] : '';
	$price   = $payload ? $payload['price'] : '';
	?>
	<div class="sf-hero-prod" data-product-id="<?php echo esc_attr( $product['id'] ); ?>">
		<span class="sf-hero-prod__handle dashicons dashicons-menu-alt" aria-hidden="true"></span>
		<span class="sf-hero-prod__thumb">
			<?php if ( $thumb ) : ?>
				<img src="<?php echo esc_url( $thumb ); ?>" alt="">
			<?php endif; ?>
		</span>
		<span class="sf-hero-prod__meta">
			<span class="sf-hero-prod__name"><?php echo esc_html( $name ); ?></span>
			<span class="sf-hero-prod__price"><?php echo esc_html( $price ); ?></span>
		</span>
		<label class="sf-hero-prod__label">
			<span class="sf-hero-field__label"><?php esc_html_e( 'Display title (optional)', 'snazzy-floret' ); ?></span>
			<input type="text" data-sf-prod="label" name="<?php echo esc_attr( $base . '[label]' ); ?>"
				value="<?php echo esc_attr( $product['label'] ); ?>"
				placeholder="<?php esc_attr_e( 'Falls back to price', 'snazzy-floret' ); ?>">
		</label>
		<input type="hidden" data-sf-prod="id" name="<?php echo esc_attr( $base . '[id]' ); ?>"
			value="<?php echo esc_attr( $product['id'] ); ?>">
		<button type="button" class="sf-hero-prod__remove" title="<?php esc_attr_e( 'Remove product', 'snazzy-floret' ); ?>">
			<span class="dashicons dashicons-no-alt"></span>
		</button>
	</div>
	<?php
}

/**
 * Render one slider row.
 *
 * @param string $index  Slider index or template placeholder.
 * @param array  $slider Slider data.
 */
function sf_hero_render_slider_row( $index, $slider ) {
	$base      = 'sf_hero[' . $index . ']';
	$image     = sf_hero_image_url( $slider, 'medium' );
	$title     = '' !== trim( $slider['title'] ) ? $slider['title'] : __( 'Untitled slider', 'snazzy-floret' );
	$is_active = ! empty( $slider['active'] );
	$row_class = 'sf-hero-slide' . ( $is_active ? '' : ' is-disabled' );
	?>
	<div class="<?php echo esc_attr( $row_class ); ?>">
		<div class="sf-hero-slide__head">
			<span class="sf-hero-slide__drag dashicons dashicons-menu" title="<?php esc_attr_e( 'Drag to reorder', 'snazzy-floret' ); ?>"></span>
			<span class="sf-hero-slide__num"></span>
			<span class="sf-hero-slide__thumb">
				<?php if ( $image ) : ?>
					<img src="<?php echo esc_url( $image ); ?>" alt="">
				<?php endif; ?>
			</span>
			<span class="sf-hero-slide__name"><?php echo esc_html( $title ); ?></span>

			<label class="sf-hero-switch" title="<?php esc_attr_e( 'Enable / disable this slider', 'snazzy-floret' ); ?>">
				<input type="hidden" data-sf-field="active" name="<?php echo esc_attr( $base . '[active]' ); ?>" value="0">
				<input type="checkbox" class="sf-hero-switch__input" data-sf-field="active"
					name="<?php echo esc_attr( $base . '[active]' ); ?>" value="1" <?php checked( $is_active ); ?>>
				<span class="sf-hero-switch__track"><span class="sf-hero-switch__knob"></span></span>
				<span class="sf-hero-switch__text">
					<?php echo $is_active ? esc_html__( 'Active', 'snazzy-floret' ) : esc_html__( 'Disabled', 'snazzy-floret' ); ?>
				</span>
			</label>

			<button type="button" class="sf-hero-slide__toggle" aria-expanded="false" title="<?php esc_attr_e( 'Expand / collapse', 'snazzy-floret' ); ?>">
				<span class="dashicons dashicons-arrow-down-alt2"></span>
			</button>
			<button type="button" class="sf-hero-slide__remove" title="<?php esc_attr_e( 'Delete slider', 'snazzy-floret' ); ?>">
				<span class="dashicons dashicons-trash"></span>
			</button>
		</div>

		<div class="sf-hero-slide__body">

			<div class="sf-hero-cols">
				<!-- Background images -->
				<div class="sf-hero-col sf-hero-col--media">
					<h4 class="sf-hero-subhead"><?php esc_html_e( 'Background image', 'snazzy-floret' ); ?></h4>
					<?php
					sf_hero_render_media_field(
						$base,
						$slider,
						'image',
						__( 'Desktop', 'snazzy-floret' ),
						__( 'Used on screens 768 px and wider. Keep it under 300 KB (JPG or WebP).', 'snazzy-floret' ),
						true,
						__( 'Upload 1920 × 1080 px landscape. Fills the full screen — shows about 1920 × 1050 px on a 1080p monitor.', 'snazzy-floret' )
					);
					sf_hero_render_media_field(
						$base,
						$slider,
						'image_mobile',
						__( 'Mobile (optional)', 'snazzy-floret' ),
						__( 'A wide desktop banner keeps only about a fifth of its width on a phone, so the subject gets cut off. Set a portrait crop here. Leave empty to reuse the desktop image.', 'snazzy-floret' ),
						false,
						__( 'Upload 1080 × 1920 px portrait (9:16). Used below 768 px at 85% of screen height — shows about 390 × 717 px on a typical phone. Minimum 800 px wide, under 400 KB.', 'snazzy-floret' )
					);
					?>
				</div>

				<!-- Content -->
				<?php $show_content = ! empty( $slider['show_content'] ); ?>
				<div class="sf-hero-col sf-hero-col--content sf-hero-section <?php echo $show_content ? '' : 'is-off'; ?>" data-sf-section="content">
					<h4 class="sf-hero-subhead">
						<?php esc_html_e( 'Content', 'snazzy-floret' ); ?>
						<span class="sf-hero-subhead__hint"><?php esc_html_e( 'Every field below is optional', 'snazzy-floret' ); ?></span>
						<label class="sf-hero-switch sf-hero-switch--mini" title="<?php esc_attr_e( 'Show or hide this whole block on the homepage', 'snazzy-floret' ); ?>">
							<input type="hidden" data-sf-field="show_content" name="<?php echo esc_attr( $base . '[show_content]' ); ?>" value="0">
							<input type="checkbox" class="sf-hero-switch__input" data-sf-field="show_content"
								name="<?php echo esc_attr( $base . '[show_content]' ); ?>" value="1" <?php checked( $show_content ); ?>>
							<span class="sf-hero-switch__track"><span class="sf-hero-switch__knob"></span></span>
							<span class="sf-hero-switch__text">
								<?php echo $show_content ? esc_html__( 'Shown', 'snazzy-floret' ) : esc_html__( 'Hidden', 'snazzy-floret' ); ?>
							</span>
						</label>
					</h4>

					<label class="sf-hero-field">
						<span class="sf-hero-field__label">
							<?php esc_html_e( 'Tag / eyebrow', 'snazzy-floret' ); ?>
							<em class="sf-hero-optional"><?php esc_html_e( 'optional', 'snazzy-floret' ); ?></em>
						</span>
						<input type="text" data-sf-field="tag" name="<?php echo esc_attr( $base . '[tag]' ); ?>"
							value="<?php echo esc_attr( $slider['tag'] ); ?>"
							placeholder="<?php esc_attr_e( 'e.g. New Collection', 'snazzy-floret' ); ?>">
					</label>

					<div class="sf-hero-field-row">
						<label class="sf-hero-field">
							<span class="sf-hero-field__label">
								<?php esc_html_e( 'Slider title', 'snazzy-floret' ); ?>
								<em class="sf-hero-optional"><?php esc_html_e( 'optional', 'snazzy-floret' ); ?></em>
							</span>
							<input type="text" data-sf-field="title" class="sf-hero-title-input"
								name="<?php echo esc_attr( $base . '[title]' ); ?>"
								value="<?php echo esc_attr( $slider['title'] ); ?>"
								placeholder="<?php esc_attr_e( 'Main heading', 'snazzy-floret' ); ?>">
						</label>
						<label class="sf-hero-field">
							<span class="sf-hero-field__label">
								<?php esc_html_e( 'Accent word (italic)', 'snazzy-floret' ); ?>
								<em class="sf-hero-optional"><?php esc_html_e( 'optional', 'snazzy-floret' ); ?></em>
							</span>
							<input type="text" data-sf-field="title_em" name="<?php echo esc_attr( $base . '[title_em]' ); ?>"
								value="<?php echo esc_attr( $slider['title_em'] ); ?>"
								placeholder="<?php esc_attr_e( 'Fashion', 'snazzy-floret' ); ?>">
						</label>
					</div>

					<label class="sf-hero-field">
						<span class="sf-hero-field__label">
							<?php esc_html_e( 'Short description', 'snazzy-floret' ); ?>
							<em class="sf-hero-optional"><?php esc_html_e( 'optional', 'snazzy-floret' ); ?></em>
						</span>
						<textarea rows="2" data-sf-field="desc" name="<?php echo esc_attr( $base . '[desc]' ); ?>"
							placeholder="<?php esc_attr_e( 'One or two lines of supporting copy', 'snazzy-floret' ); ?>"><?php echo esc_textarea( $slider['desc'] ); ?></textarea>
					</label>
				</div>
			</div>

			<!-- CTA buttons -->
			<?php $show_buttons = ! empty( $slider['show_buttons'] ); ?>
			<div class="sf-hero-block sf-hero-section <?php echo $show_buttons ? '' : 'is-off'; ?>" data-sf-section="buttons">
				<h4 class="sf-hero-subhead">
					<?php esc_html_e( 'CTA buttons', 'snazzy-floret' ); ?>
					<span class="sf-hero-subhead__hint">
						<?php
						printf(
							/* translators: %d: maximum number of buttons. */
							esc_html__( 'Optional — up to %d per slider', 'snazzy-floret' ),
							(int) sf_hero_max_buttons()
						);
						?>
					</span>
					<label class="sf-hero-switch sf-hero-switch--mini" title="<?php esc_attr_e( 'Show or hide the buttons on the homepage', 'snazzy-floret' ); ?>">
						<input type="hidden" data-sf-field="show_buttons" name="<?php echo esc_attr( $base . '[show_buttons]' ); ?>" value="0">
						<input type="checkbox" class="sf-hero-switch__input" data-sf-field="show_buttons"
							name="<?php echo esc_attr( $base . '[show_buttons]' ); ?>" value="1" <?php checked( $show_buttons ); ?>>
						<span class="sf-hero-switch__track"><span class="sf-hero-switch__knob"></span></span>
						<span class="sf-hero-switch__text">
							<?php echo $show_buttons ? esc_html__( 'Shown', 'snazzy-floret' ) : esc_html__( 'Hidden', 'snazzy-floret' ); ?>
						</span>
					</label>
				</h4>
				<div class="sf-hero-btns">
					<?php foreach ( $slider['buttons'] as $b_index => $button ) : ?>
						<?php sf_hero_render_button_row( $index, $b_index, $button ); ?>
					<?php endforeach; ?>
				</div>
				<button type="button" class="button sf-hero-add-btn">
					<span class="dashicons dashicons-plus-alt2"></span>
					<?php esc_html_e( 'Add button', 'snazzy-floret' ); ?>
				</button>
			</div>

			<!-- Featured products -->
			<div class="sf-hero-block">
				<h4 class="sf-hero-subhead">
					<?php esc_html_e( 'Featured products', 'snazzy-floret' ); ?>
					<span class="sf-hero-subhead__hint"><?php esc_html_e( 'No limit — add as many as you need', 'snazzy-floret' ); ?></span>
				</h4>

				<?php if ( ! class_exists( 'WooCommerce' ) ) : ?>
					<p class="description"><?php esc_html_e( 'WooCommerce is not active, so products cannot be searched.', 'snazzy-floret' ); ?></p>
				<?php else : ?>
					<div class="sf-hero-prod-search">
						<span class="dashicons dashicons-search" aria-hidden="true"></span>
						<input type="text" class="sf-hero-prod-search__input" autocomplete="off"
							placeholder="<?php esc_attr_e( 'Search products by name…', 'snazzy-floret' ); ?>">
						<div class="sf-hero-prod-search__results" hidden></div>
					</div>
				<?php endif; ?>

				<div class="sf-hero-prods">
					<?php foreach ( $slider['products'] as $p_index => $product ) : ?>
						<?php sf_hero_render_product_row( $index, $p_index, $product ); ?>
					<?php endforeach; ?>
				</div>
				<p class="sf-hero-prods__empty" <?php echo empty( $slider['products'] ) ? '' : 'hidden'; ?>>
					<?php esc_html_e( 'No featured products yet — this slider will render without a product strip.', 'snazzy-floret' ); ?>
				</p>
			</div>

			<!-- Per-slider save: submits the whole form, so nothing edited
			     elsewhere on the page is left behind. -->
			<div class="sf-hero-slide__save">
				<span class="sf-hero-slide__save-note">
					<?php esc_html_e( 'Saves every slider on this page, not just this one.', 'snazzy-floret' ); ?>
				</span>
				<button type="submit" class="button button-primary">
					<span class="dashicons dashicons-yes"></span>
					<?php esc_html_e( 'Save changes', 'snazzy-floret' ); ?>
				</button>
			</div>

		</div>
	</div>
	<?php
}

/**
 * Render the Hero Slider Management screen.
 */
function sf_hero_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$sliders = sf_hero_get_sliders();
	$speed   = absint( get_theme_mod( 'sf_hero_speed', 5000 ) );
	$saved   = isset( $_GET['sf_saved'] ) ? absint( $_GET['sf_saved'] ) : -1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only notice flag.
	?>
	<div class="wrap sf-hero-admin">

		<h1 class="sf-hero-admin__title">
			<span class="dashicons dashicons-images-alt2"></span>
			<?php esc_html_e( 'Hero Slider Management', 'snazzy-floret' ); ?>
		</h1>
		<p class="sf-hero-admin__intro">
			<?php esc_html_e( 'Build the homepage hero. Drag a slider to reorder it, toggle it off to hide it without deleting, and give each one its own buttons and featured products.', 'snazzy-floret' ); ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener">
				<?php esc_html_e( 'View homepage', 'snazzy-floret' ); ?> &rarr;
			</a>
		</p>

		<?php if ( $saved >= 0 ) : ?>
			<div class="notice notice-success is-dismissible">
				<p>
					<?php
					printf(
						/* translators: %d: number of sliders saved. */
						esc_html( _n( '%d slider saved.', '%d sliders saved.', $saved, 'snazzy-floret' ) ),
						(int) $saved
					);
					?>
				</p>
			</div>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="sf-hero-form">
			<input type="hidden" name="action" value="sf_hero_save">
			<?php wp_nonce_field( 'sf_hero_save', 'sf_hero_nonce' ); ?>

			<div class="sf-hero-toolbar">
				<label class="sf-hero-speed">
					<span><?php esc_html_e( 'Autoplay speed', 'snazzy-floret' ); ?></span>
					<input type="number" name="sf_hero_speed" value="<?php echo esc_attr( $speed ); ?>"
						min="2000" max="15000" step="500">
					<span class="sf-hero-speed__unit"><?php esc_html_e( 'ms', 'snazzy-floret' ); ?></span>
				</label>
				<button type="button" class="button button-secondary sf-hero-add-slide">
					<span class="dashicons dashicons-plus-alt2"></span>
					<?php esc_html_e( 'Add new slider', 'snazzy-floret' ); ?>
				</button>
			</div>

			<div id="sf-hero-list">
				<?php foreach ( $sliders as $index => $slider ) : ?>
					<?php sf_hero_render_slider_row( $index, wp_parse_args( $slider, sf_hero_empty_slider() ) ); ?>
				<?php endforeach; ?>
			</div>

			<p class="sf-hero-empty" <?php echo empty( $sliders ) ? '' : 'hidden'; ?>>
				<?php esc_html_e( 'No sliders yet. Click “Add new slider” to create your first one.', 'snazzy-floret' ); ?>
			</p>

			<div class="sf-hero-actions">
				<button type="button" class="button button-secondary sf-hero-add-slide">
					<span class="dashicons dashicons-plus-alt2"></span>
					<?php esc_html_e( 'Add new slider', 'snazzy-floret' ); ?>
				</button>
				<button type="submit" class="button button-primary button-hero">
					<?php esc_html_e( 'Save changes', 'snazzy-floret' ); ?>
				</button>
			</div>
		</form>

		<!-- Templates -->
		<script type="text/html" id="tmpl-sf-hero-slide">
			<?php sf_hero_render_slider_row( '__SI__', sf_hero_empty_slider() ); ?>
		</script>
		<script type="text/html" id="tmpl-sf-hero-btn">
			<?php
			sf_hero_render_button_row(
				'__SI__',
				'__BI__',
				array(
					'text'  => '',
					'url'   => '',
					'style' => 'primary',
				)
			);
			?>
		</script>
		<script type="text/html" id="tmpl-sf-hero-prod">
			<?php
			sf_hero_render_product_row(
				'__SI__',
				'__PI__',
				array(
					'id'    => 0,
					'label' => '',
				)
			);
			?>
		</script>
	</div>
	<?php
}
