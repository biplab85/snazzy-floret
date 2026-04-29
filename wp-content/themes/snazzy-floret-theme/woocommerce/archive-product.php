<?php
/**
 * WooCommerce Archive / Category Page — Custom Layout.
 *
 * Category header + filters sidebar + product grid.
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

get_header();

$current_cat   = get_queried_object();
$is_category   = is_product_category();
$cat_name      = $is_category ? $current_cat->name : esc_html__( 'Shop', 'snazzy-floret' );
$cat_thumb_id  = $is_category ? get_term_meta( $current_cat->term_id, 'thumbnail_id', true ) : 0;
$cat_image_url = $cat_thumb_id ? wp_get_attachment_image_url( $cat_thumb_id, 'large' ) : '';
?>

</main>

<!-- ============ CATEGORY HEADER ============ -->
<section class="sf-cat-header <?php echo $cat_image_url ? 'sf-cat-header--has-image' : ''; ?>">
	<?php if ( $cat_image_url ) : ?>
		<img src="<?php echo esc_url( $cat_image_url ); ?>" alt="<?php echo esc_attr( $cat_name ); ?>" class="sf-cat-header__img" loading="eager">
	<?php endif; ?>
	<div class="sf-cat-header__overlay"></div>
	<div class="sf-cat-header__icons" aria-hidden="true">
		<svg class="sf-cat-header__icon sf-cat-header__icon--bag" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
			<path d="M14 22h36l-3 32a4 4 0 0 1-4 3.6H21a4 4 0 0 1-4-3.6L14 22Z"/>
			<path d="M22 22v-4a10 10 0 0 1 20 0v4"/>
			<path d="M24 32c1.5 4 5 6 8 6s6.5-2 8-6"/>
		</svg>
		<svg class="sf-cat-header__icon sf-cat-header__icon--hanger" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
			<path d="M32 22a5 5 0 1 1 5-5"/>
			<path d="M32 22v4l24 14a3 3 0 0 1-1.5 5.6H9.5A3 3 0 0 1 8 40l24-14Z"/>
		</svg>
		<svg class="sf-cat-header__icon sf-cat-header__icon--tag" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
			<path d="M32 6h22a4 4 0 0 1 4 4v22L32 58 6 32 32 6Z"/>
			<circle cx="44" cy="20" r="3.2"/>
		</svg>
		<svg class="sf-cat-header__icon sf-cat-header__icon--needle" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
			<path d="M8 56 56 8"/>
			<circle cx="14" cy="50" r="4"/>
			<path d="M48 8h8v8"/>
		</svg>
		<svg class="sf-cat-header__icon sf-cat-header__icon--sparkle" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
			<path d="M32 8v16M32 40v16M8 32h16M40 32h16"/>
			<path d="M16 16l8 8M40 40l8 8M48 16l-8 8M16 48l8-8"/>
		</svg>
	</div>
	<div class="sf-container sf-cat-header__content">
		<h1 class="sf-cat-header__title"><?php echo esc_html( $cat_name ); ?></h1>
		<?php if ( $is_category && $current_cat->description ) : ?>
			<p class="sf-cat-header__desc"><?php echo esc_html( $current_cat->description ); ?></p>
		<?php endif; ?>
		<span class="sf-cat-header__count">
			<?php
			/* translators: %s: product count */
			printf( esc_html__( '%s Products', 'snazzy-floret' ), esc_html( $is_category ? $current_cat->count : wc_get_loop_prop( 'total' ) ) );
			?>
		</span>
	</div>
</section>

<!-- ============ SHOP BODY ============ -->
<main class="sf-main">
<div class="sf-container sf-shop-layout">

	<!-- Sidebar Filters -->
	<aside class="sf-shop-filters" id="sf-shop-filters">

		<div class="sf-shop-filters__header">
			<h3 class="sf-shop-filters__heading">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
				<?php esc_html_e( 'Filters', 'snazzy-floret' ); ?>
			</h3>
			<button class="sf-shop-filters__close" id="sf-filters-close" aria-label="<?php esc_attr_e( 'Close filters', 'snazzy-floret' ); ?>">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
			</button>
		</div>

		<?php
		// Dynamic fabric filter — only render if pa_fabric taxonomy exists with assigned terms.
		$fabric_terms = array();
		if ( taxonomy_exists( 'pa_fabric' ) ) {
			$fabric_terms = get_terms( array(
				'taxonomy'   => 'pa_fabric',
				'hide_empty' => true,
			) );
			if ( is_wp_error( $fabric_terms ) ) {
				$fabric_terms = array();
			}
		}
		?>
		<?php if ( ! empty( $fabric_terms ) ) : ?>
		<!-- Fabric Filter -->
		<div class="sf-filter-group" data-filter="fabric">
			<button class="sf-filter-group__toggle" aria-expanded="true">
				<span><?php esc_html_e( 'Fabric', 'snazzy-floret' ); ?></span>
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
			</button>
			<div class="sf-filter-group__body is-open">
				<?php foreach ( $fabric_terms as $term ) : ?>
				<label class="sf-filter-check">
					<input type="checkbox" class="sf-filter-check__input" name="fabric" value="<?php echo esc_attr( $term->slug ); ?>">
					<span class="sf-filter-check__box"></span>
					<span class="sf-filter-check__label"><?php echo esc_html( $term->name ); ?></span>
				</label>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<!-- Price Range Filter -->
		<div class="sf-filter-group" data-filter="price">
			<button class="sf-filter-group__toggle" aria-expanded="true">
				<span><?php esc_html_e( 'Price Range', 'snazzy-floret' ); ?></span>
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
			</button>
			<div class="sf-filter-group__body is-open">
				<?php $sf_filter_symbol = function_exists( 'get_woocommerce_currency_symbol' ) ? html_entity_decode( get_woocommerce_currency_symbol() ) : '৳'; ?>
				<div class="sf-filter-price">
					<div class="sf-filter-price__inputs">
						<div class="sf-filter-price__field">
							<label><?php esc_html_e( 'From', 'snazzy-floret' ); ?></label>
							<input type="number" class="sf-filter-price__input" id="sf-price-min" placeholder="<?php echo esc_attr( $sf_filter_symbol . ' 0' ); ?>" min="0">
						</div>
						<span class="sf-filter-price__sep">&mdash;</span>
						<div class="sf-filter-price__field">
							<label><?php esc_html_e( 'To', 'snazzy-floret' ); ?></label>
							<input type="number" class="sf-filter-price__input" id="sf-price-max" placeholder="<?php echo esc_attr( $sf_filter_symbol . ' 10,000' ); ?>" min="0">
						</div>
					</div>
					<button class="sf-filter-price__apply" id="sf-price-apply"><?php esc_html_e( 'Apply', 'snazzy-floret' ); ?></button>
				</div>
			</div>
		</div>

		<!-- Availability Filter -->
		<div class="sf-filter-group" data-filter="availability">
			<button class="sf-filter-group__toggle" aria-expanded="true">
				<span><?php esc_html_e( 'Availability', 'snazzy-floret' ); ?></span>
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
			</button>
			<div class="sf-filter-group__body is-open">
				<label class="sf-filter-check">
					<input type="checkbox" class="sf-filter-check__input" name="availability" value="instock">
					<span class="sf-filter-check__box"></span>
					<span class="sf-filter-check__label"><?php esc_html_e( 'In Stock', 'snazzy-floret' ); ?></span>
				</label>
				<label class="sf-filter-check">
					<input type="checkbox" class="sf-filter-check__input" name="availability" value="outofstock">
					<span class="sf-filter-check__box"></span>
					<span class="sf-filter-check__label"><?php esc_html_e( 'Out of Stock', 'snazzy-floret' ); ?></span>
				</label>
			</div>
		</div>

		<!-- Reset All -->
		<button class="sf-filter-reset" id="sf-filter-reset">
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
			<?php esc_html_e( 'Reset All Filters', 'snazzy-floret' ); ?>
		</button>

	</aside>

	<!-- Main Product Area -->
	<div class="sf-shop-main">

		<!-- Toolbar -->
		<div class="sf-shop-toolbar">
			<div class="sf-shop-toolbar__left">
				<button class="sf-shop-toolbar__filter-btn" id="sf-filter-toggle" aria-label="<?php esc_attr_e( 'Toggle filters', 'snazzy-floret' ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
					<?php esc_html_e( 'Filters', 'snazzy-floret' ); ?>
				</button>
				<?php woocommerce_result_count(); ?>
			</div>
			<div class="sf-shop-toolbar__right">
				<?php woocommerce_catalog_ordering(); ?>
			</div>
		</div>

		<!-- Active Filters -->
		<div class="sf-active-filters" id="sf-active-filters" style="display:none;">
			<div class="sf-active-filters__list" id="sf-active-filters-list"></div>
			<button class="sf-active-filters__clear" id="sf-clear-all-filters">
				<?php esc_html_e( 'Clear all', 'snazzy-floret' ); ?>
			</button>
		</div>

		<!-- Products -->
		<?php
		if ( woocommerce_product_loop() ) {
			woocommerce_product_loop_start();
			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();
					wc_get_template_part( 'content', 'product' );
				}
			}
			woocommerce_product_loop_end();
			woocommerce_pagination();
		} else {
			do_action( 'woocommerce_no_products_found' );
		}
		?>

	</div>

</div>

<?php get_footer(); ?>
