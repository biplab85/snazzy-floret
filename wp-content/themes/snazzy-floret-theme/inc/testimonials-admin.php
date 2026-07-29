<?php
/**
 * Testimonials Manager — dedicated admin screen.
 *
 * Adds a top-level "Testimonials" menu where an administrator can create,
 * edit, delete, enable/disable and reorder an unlimited number of customer
 * reviews. Mirrors the Hero Slider Manager's interaction model.
 *
 * Data lives in the `sf_testimonials` option as an ordered array — array order
 * is the rotation order. Section-level settings live in `sf_testimonials_opts`.
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Option keys. */
const SF_TST_OPTION = 'sf_testimonials';
const SF_TST_OPTS   = 'sf_testimonials_opts';

/**
 * Blank testimonial used when the admin adds a new one.
 *
 * @return array
 */
function sf_tst_empty() {
	return array(
		'active'    => 1,
		'image_id'  => 0,
		'image_url' => '',
		'name'      => '',
		'rating'    => '5.0',
		'date'      => '',
		'quote'     => '',
	);
}

/**
 * Section-level defaults.
 *
 * @return array
 */
function sf_tst_default_opts() {
	return array(
		'title' => __( 'Customer Reviews', 'snazzy-floret' ),
		'speed' => 4000,
	);
}

/**
 * Seed content, so the screen and the homepage are not empty on first load.
 *
 * @return array
 */
function sf_tst_defaults() {
	return array(
		array(
			'active'    => 1,
			'image_id'  => 0,
			'image_url' => '',
			'name'      => __( 'Nusrat Jahan', 'snazzy-floret' ),
			'rating'    => '5.0',
			'date'      => __( 'on 12 Jun, 2026', 'snazzy-floret' ),
			'quote'     => __( 'The mother-daughter set arrived stitched beautifully and the fabric is so soft. We wore it for Eid and everyone asked where it was from.', 'snazzy-floret' ),
		),
		array(
			'active'    => 1,
			'image_id'  => 0,
			'image_url' => '',
			'name'      => __( 'Farhana Akter', 'snazzy-floret' ),
			'rating'    => '4.9',
			'date'      => __( 'on 3 May, 2026', 'snazzy-floret' ),
			'quote'     => __( 'I ordered a custom size and it fit perfectly. The team messaged me through the whole process. Easily the best experience I have had shopping online.', 'snazzy-floret' ),
		),
		array(
			'active'    => 1,
			'image_id'  => 0,
			'image_url' => '',
			'name'      => __( 'Rezaul Karim', 'snazzy-floret' ),
			'rating'    => '5.0',
			'date'      => __( 'on 21 Apr, 2026', 'snazzy-floret' ),
			'quote'     => __( 'Bought the panjabi set for my son and me. The stitching and the print quality are excellent for the price. Delivery to Dhaka took two days.', 'snazzy-floret' ),
		),
	);
}

/**
 * Resolve a testimonial's photo URL (attachment first, raw URL fallback).
 *
 * @param array  $item Testimonial data.
 * @param string $size Image size.
 * @return string
 */
function sf_tst_image_url( $item, $size = 'thumbnail' ) {
	if ( ! empty( $item['image_id'] ) ) {
		$url = wp_get_attachment_image_url( (int) $item['image_id'], $size );
		if ( $url ) {
			return $url;
		}
	}
	return ! empty( $item['image_url'] ) ? $item['image_url'] : '';
}

/**
 * Get the testimonials in display order.
 *
 * @param bool $active_only Return only enabled entries that have a quote.
 * @return array
 */
function sf_tst_get( $active_only = false ) {
	$items = get_option( SF_TST_OPTION, null );

	if ( ! is_array( $items ) ) {
		$items = sf_tst_defaults();
	}

	$defaults = sf_tst_empty();
	$items    = array_map(
		static function ( $item ) use ( $defaults ) {
			return is_array( $item ) ? wp_parse_args( $item, $defaults ) : $defaults;
		},
		$items
	);

	if ( $active_only ) {
		$items = array_values(
			array_filter(
				$items,
				static function ( $item ) {
					return ! empty( $item['active'] ) && '' !== trim( $item['quote'] );
				}
			)
		);
	}

	return $items;
}

/**
 * Section-level settings.
 *
 * @return array
 */
function sf_tst_opts() {
	$opts = get_option( SF_TST_OPTS, array() );
	return wp_parse_args( is_array( $opts ) ? $opts : array(), sf_tst_default_opts() );
}

/**
 * Sanitize the posted testimonial list.
 *
 * @param mixed $raw Raw $_POST value.
 * @return array
 */
function sf_tst_sanitize( $raw ) {
	if ( ! is_array( $raw ) ) {
		return array();
	}

	$clean = array();

	foreach ( $raw as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$rating = isset( $item['rating'] ) ? sanitize_text_field( wp_unslash( $item['rating'] ) ) : '';
		// Keep it a sensible number with one decimal, or empty to hide it.
		if ( '' !== $rating ) {
			$rating = is_numeric( $rating ) ? number_format( min( 5, max( 0, (float) $rating ) ), 1 ) : '';
		}

		$clean[] = array(
			'active'    => empty( $item['active'] ) ? 0 : 1,
			'image_id'  => isset( $item['image_id'] ) ? absint( $item['image_id'] ) : 0,
			'image_url' => isset( $item['image_url'] ) ? esc_url_raw( wp_unslash( $item['image_url'] ) ) : '',
			'name'      => isset( $item['name'] ) ? sanitize_text_field( wp_unslash( $item['name'] ) ) : '',
			'rating'    => $rating,
			'date'      => isset( $item['date'] ) ? sanitize_text_field( wp_unslash( $item['date'] ) ) : '',
			'quote'     => isset( $item['quote'] ) ? sanitize_textarea_field( wp_unslash( $item['quote'] ) ) : '',
		);
	}

	return $clean;
}

/* -------------------------------------------------------------------------
 * Admin menu
 * ---------------------------------------------------------------------- */

/**
 * Register the top-level "Testimonials" menu.
 */
function sf_tst_admin_menu() {
	add_menu_page(
		__( 'Testimonials', 'snazzy-floret' ),
		__( 'Testimonials', 'snazzy-floret' ),
		'manage_options',
		'sf-testimonials',
		'sf_tst_render_admin_page',
		'dashicons-format-quote',
		27
	);
}
add_action( 'admin_menu', 'sf_tst_admin_menu' );

/**
 * Enqueue the manager's assets on its own screen only.
 *
 * @param string $hook Current admin page hook.
 */
function sf_tst_admin_assets( $hook ) {
	if ( 'toplevel_page_sf-testimonials' !== $hook ) {
		return;
	}

	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_media();
	wp_enqueue_script( 'jquery-ui-sortable' );

	wp_enqueue_style(
		'sf-tst-admin',
		$uri . '/assets/css/testimonials-admin.css',
		array(),
		filemtime( $dir . '/assets/css/testimonials-admin.css' )
	);

	wp_enqueue_script(
		'sf-tst-admin',
		$uri . '/assets/js/testimonials-admin.js',
		array( 'jquery', 'jquery-ui-sortable' ),
		filemtime( $dir . '/assets/js/testimonials-admin.js' ),
		true
	);

	wp_localize_script(
		'sf-tst-admin',
		'sfTstAdmin',
		array(
			'i18n' => array(
				'confirmDelete' => __( 'Delete this testimonial? This cannot be undone once you save.', 'snazzy-floret' ),
				'unnamed'       => __( 'Unnamed reviewer', 'snazzy-floret' ),
				'choosePhoto'   => __( 'Select reviewer photo', 'snazzy-floret' ),
				'usePhoto'      => __( 'Use this photo', 'snazzy-floret' ),
			),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'sf_tst_admin_assets' );

/* -------------------------------------------------------------------------
 * Save handler
 * ---------------------------------------------------------------------- */

/**
 * Persist the submitted testimonials.
 */
function sf_tst_handle_save() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to manage testimonials.', 'snazzy-floret' ) );
	}

	check_admin_referer( 'sf_tst_save', 'sf_tst_nonce' );

	$raw   = isset( $_POST['sf_tst'] ) ? wp_unslash( $_POST['sf_tst'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized in sf_tst_sanitize().
	$items = sf_tst_sanitize( $raw );

	update_option( SF_TST_OPTION, $items );

	$opts = sf_tst_default_opts();
	if ( isset( $_POST['sf_tst_title'] ) ) {
		$opts['title'] = sanitize_text_field( wp_unslash( $_POST['sf_tst_title'] ) );
	}
	if ( isset( $_POST['sf_tst_speed'] ) ) {
		$speed         = absint( wp_unslash( $_POST['sf_tst_speed'] ) );
		$opts['speed'] = min( 15000, max( 2000, $speed ) );
	}
	update_option( SF_TST_OPTS, $opts );

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'     => 'sf-testimonials',
				'sf_saved' => count( $items ),
			),
			admin_url( 'admin.php' )
		)
	);
	exit;
}
add_action( 'admin_post_sf_tst_save', 'sf_tst_handle_save' );

/* -------------------------------------------------------------------------
 * Screen markup
 * ---------------------------------------------------------------------- */

/**
 * Render one testimonial row.
 *
 * @param string $index Row index or template placeholder.
 * @param array  $item  Testimonial data.
 */
function sf_tst_render_row( $index, $item ) {
	$base      = 'sf_tst[' . $index . ']';
	$photo     = sf_tst_image_url( $item, 'thumbnail' );
	$name      = '' !== trim( $item['name'] ) ? $item['name'] : __( 'Unnamed reviewer', 'snazzy-floret' );
	$is_active = ! empty( $item['active'] );
	?>
	<div class="sf-tst-item <?php echo $is_active ? '' : 'is-disabled'; ?>">
		<div class="sf-tst-item__head">
			<span class="sf-tst-item__drag dashicons dashicons-menu" title="<?php esc_attr_e( 'Drag to reorder', 'snazzy-floret' ); ?>"></span>
			<span class="sf-tst-item__num"></span>
			<span class="sf-tst-item__avatar">
				<?php if ( $photo ) : ?>
					<img src="<?php echo esc_url( $photo ); ?>" alt="">
				<?php endif; ?>
			</span>
			<span class="sf-tst-item__name"><?php echo esc_html( $name ); ?></span>

			<label class="sf-tst-switch" title="<?php esc_attr_e( 'Show or hide this testimonial', 'snazzy-floret' ); ?>">
				<input type="hidden" data-sf-field="active" name="<?php echo esc_attr( $base . '[active]' ); ?>" value="0">
				<input type="checkbox" class="sf-tst-switch__input" data-sf-field="active"
					name="<?php echo esc_attr( $base . '[active]' ); ?>" value="1" <?php checked( $is_active ); ?>>
				<span class="sf-tst-switch__track"><span class="sf-tst-switch__knob"></span></span>
				<span class="sf-tst-switch__text">
					<?php echo $is_active ? esc_html__( 'Active', 'snazzy-floret' ) : esc_html__( 'Hidden', 'snazzy-floret' ); ?>
				</span>
			</label>

			<button type="button" class="sf-tst-item__toggle" aria-expanded="false" title="<?php esc_attr_e( 'Expand / collapse', 'snazzy-floret' ); ?>">
				<span class="dashicons dashicons-arrow-down-alt2"></span>
			</button>
			<button type="button" class="sf-tst-item__remove" title="<?php esc_attr_e( 'Delete testimonial', 'snazzy-floret' ); ?>">
				<span class="dashicons dashicons-trash"></span>
			</button>
		</div>

		<div class="sf-tst-item__body">
			<div class="sf-tst-cols">

				<div class="sf-tst-col sf-tst-col--photo">
					<h4 class="sf-tst-subhead"><?php esc_html_e( 'Photo', 'snazzy-floret' ); ?></h4>
					<div class="sf-tst-media">
						<div class="sf-tst-media__preview <?php echo $photo ? '' : 'is-empty'; ?>">
							<?php if ( $photo ) : ?>
								<img src="<?php echo esc_url( $photo ); ?>" alt="">
							<?php endif; ?>
						</div>
						<div class="sf-tst-media__actions">
							<button type="button" class="button sf-tst-media__pick"><?php esc_html_e( 'Choose photo', 'snazzy-floret' ); ?></button>
							<button type="button" class="button-link sf-tst-media__clear" <?php echo $photo ? '' : 'style="display:none"'; ?>>
								<?php esc_html_e( 'Remove', 'snazzy-floret' ); ?>
							</button>
						</div>
						<input type="hidden" data-sf-field="image_id" name="<?php echo esc_attr( $base . '[image_id]' ); ?>"
							value="<?php echo esc_attr( $item['image_id'] ); ?>">
						<input type="hidden" data-sf-field="image_url" name="<?php echo esc_attr( $base . '[image_url]' ); ?>"
							value="<?php echo esc_attr( $item['image_url'] ); ?>">
						<p class="sf-tst-media__spec">
							<span class="dashicons dashicons-info-outline" aria-hidden="true"></span>
							<?php esc_html_e( 'Square photo, 400 × 400 px. Shown as a circle and converted to black & white, matching the design.', 'snazzy-floret' ); ?>
						</p>
					</div>
				</div>

				<div class="sf-tst-col sf-tst-col--fields">
					<h4 class="sf-tst-subhead"><?php esc_html_e( 'Review', 'snazzy-floret' ); ?></h4>

					<div class="sf-tst-field-row">
						<label class="sf-tst-field">
							<span class="sf-tst-field__label"><?php esc_html_e( 'Name', 'snazzy-floret' ); ?></span>
							<input type="text" class="sf-tst-name-input" data-sf-field="name"
								name="<?php echo esc_attr( $base . '[name]' ); ?>"
								value="<?php echo esc_attr( $item['name'] ); ?>"
								placeholder="<?php esc_attr_e( 'Customer name', 'snazzy-floret' ); ?>">
						</label>
						<label class="sf-tst-field sf-tst-field--rating">
							<span class="sf-tst-field__label"><?php esc_html_e( 'Rating', 'snazzy-floret' ); ?></span>
							<input type="number" step="0.1" min="0" max="5" data-sf-field="rating"
								name="<?php echo esc_attr( $base . '[rating]' ); ?>"
								value="<?php echo esc_attr( $item['rating'] ); ?>"
								placeholder="4.9">
						</label>
						<label class="sf-tst-field">
							<span class="sf-tst-field__label"><?php esc_html_e( 'Date text', 'snazzy-floret' ); ?></span>
							<input type="text" data-sf-field="date"
								name="<?php echo esc_attr( $base . '[date]' ); ?>"
								value="<?php echo esc_attr( $item['date'] ); ?>"
								placeholder="<?php esc_attr_e( 'on 12 Jun, 2026', 'snazzy-floret' ); ?>">
						</label>
					</div>

					<label class="sf-tst-field">
						<span class="sf-tst-field__label"><?php esc_html_e( 'Quote', 'snazzy-floret' ); ?></span>
						<textarea rows="4" data-sf-field="quote" name="<?php echo esc_attr( $base . '[quote]' ); ?>"
							placeholder="<?php esc_attr_e( 'What the customer said…', 'snazzy-floret' ); ?>"><?php echo esc_textarea( $item['quote'] ); ?></textarea>
					</label>
				</div>

			</div>

			<div class="sf-tst-item__save">
				<span class="sf-tst-item__save-note">
					<?php esc_html_e( 'Saves every testimonial on this page, not just this one.', 'snazzy-floret' ); ?>
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
 * Render the Testimonials screen.
 */
function sf_tst_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$items = sf_tst_get();
	$opts  = sf_tst_opts();
	$saved = isset( $_GET['sf_saved'] ) ? absint( $_GET['sf_saved'] ) : -1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only notice flag.
	?>
	<div class="wrap sf-tst-admin">

		<h1 class="sf-tst-admin__title">
			<span class="dashicons dashicons-format-quote"></span>
			<?php esc_html_e( 'Testimonials', 'snazzy-floret' ); ?>
		</h1>
		<p class="sf-tst-admin__intro">
			<?php esc_html_e( 'Customer reviews for the homepage. They rotate through the curved carousel one at a time — drag to reorder, toggle one off to hide it without deleting.', 'snazzy-floret' ); ?>
			<a href="<?php echo esc_url( home_url( '/#sf-testimonials' ) ); ?>" target="_blank" rel="noopener">
				<?php esc_html_e( 'View on homepage', 'snazzy-floret' ); ?> &rarr;
			</a>
		</p>

		<?php if ( $saved >= 0 ) : ?>
			<div class="notice notice-success is-dismissible">
				<p>
					<?php
					printf(
						/* translators: %d: number of testimonials saved. */
						esc_html( _n( '%d testimonial saved.', '%d testimonials saved.', $saved, 'snazzy-floret' ) ),
						(int) $saved
					);
					?>
				</p>
			</div>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="sf-tst-form">
			<input type="hidden" name="action" value="sf_tst_save">
			<?php wp_nonce_field( 'sf_tst_save', 'sf_tst_nonce' ); ?>

			<div class="sf-tst-toolbar">
				<label class="sf-tst-setting">
					<span><?php esc_html_e( 'Section heading', 'snazzy-floret' ); ?></span>
					<input type="text" name="sf_tst_title" value="<?php echo esc_attr( $opts['title'] ); ?>"
						placeholder="<?php esc_attr_e( 'Customer Reviews', 'snazzy-floret' ); ?>">
				</label>
				<label class="sf-tst-setting">
					<span><?php esc_html_e( 'Rotation speed', 'snazzy-floret' ); ?></span>
					<input type="number" name="sf_tst_speed" value="<?php echo esc_attr( $opts['speed'] ); ?>"
						min="2000" max="15000" step="500">
					<span class="sf-tst-setting__unit"><?php esc_html_e( 'ms', 'snazzy-floret' ); ?></span>
				</label>
				<button type="button" class="button button-secondary sf-tst-add">
					<span class="dashicons dashicons-plus-alt2"></span>
					<?php esc_html_e( 'Add testimonial', 'snazzy-floret' ); ?>
				</button>
			</div>

			<div id="sf-tst-list">
				<?php foreach ( $items as $index => $item ) : ?>
					<?php sf_tst_render_row( $index, wp_parse_args( $item, sf_tst_empty() ) ); ?>
				<?php endforeach; ?>
			</div>

			<p class="sf-tst-empty" <?php echo empty( $items ) ? '' : 'hidden'; ?>>
				<?php esc_html_e( 'No testimonials yet. Click “Add testimonial” to create your first one.', 'snazzy-floret' ); ?>
			</p>

			<div class="sf-tst-actions">
				<button type="button" class="button button-secondary sf-tst-add">
					<span class="dashicons dashicons-plus-alt2"></span>
					<?php esc_html_e( 'Add testimonial', 'snazzy-floret' ); ?>
				</button>
				<button type="submit" class="button button-primary button-hero">
					<?php esc_html_e( 'Save changes', 'snazzy-floret' ); ?>
				</button>
			</div>
		</form>

		<script type="text/html" id="tmpl-sf-tst-item">
			<?php sf_tst_render_row( '__I__', sf_tst_empty() ); ?>
		</script>
	</div>
	<?php
}
