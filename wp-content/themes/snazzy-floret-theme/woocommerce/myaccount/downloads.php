<?php
/**
 * My Account — Downloads (Snazzy Floret premium override).
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

$downloads = WC()->customer->get_downloadable_products();
?>

<div class="sf-account-section">
	<div class="sf-account-section__head">
		<h2 class="sf-account-section__title"><?php esc_html_e( 'Downloads', 'snazzy-floret' ); ?></h2>
		<p class="sf-account-section__sub"><?php esc_html_e( 'Access digital files from your purchased products.', 'snazzy-floret' ); ?></p>
	</div>

	<?php if ( ! empty( $downloads ) ) : ?>
		<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>
	<?php else : ?>
		<div class="sf-empty-state">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>
			<h3><?php esc_html_e( 'No downloads available yet', 'snazzy-floret' ); ?></h3>
			<p><?php esc_html_e( 'Your purchased downloadable files will appear here.', 'snazzy-floret' ); ?></p>
			<a class="sf-btn sf-btn--primary" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Browse Products', 'snazzy-floret' ); ?></a>
		</div>
	<?php endif; ?>
</div>
