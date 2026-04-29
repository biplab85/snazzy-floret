<?php
/**
 * Custom "No products found" empty state.
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="sf-empty-state">
	<div class="sf-empty-state__icon">
		<svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
			<circle cx="11" cy="11" r="8"/>
			<line x1="21" y1="21" x2="16.65" y2="16.65"/>
			<line x1="8" y1="11" x2="14" y2="11"/>
		</svg>
	</div>
	<h2 class="sf-empty-state__title"><?php esc_html_e( 'No products found', 'snazzy-floret' ); ?></h2>
	<p class="sf-empty-state__desc"><?php esc_html_e( "We couldn't find anything matching your filters. Try adjusting your selection or browse our full collection.", 'snazzy-floret' ); ?></p>
	<div class="sf-empty-state__actions">
		<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="sf-btn sf-btn--primary sf-empty-state__btn">
			<?php esc_html_e( 'Browse All Products', 'snazzy-floret' ); ?>
		</a>
		<button class="sf-btn sf-btn--outline sf-empty-state__reset" id="sf-empty-reset" onclick="if(typeof sf_clearAllFilters==='function')sf_clearAllFilters();else window.location.href=window.location.pathname;">
			<?php esc_html_e( 'Clear Filters', 'snazzy-floret' ); ?>
		</button>
	</div>
</div>
