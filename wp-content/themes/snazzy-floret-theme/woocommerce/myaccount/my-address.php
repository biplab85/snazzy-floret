<?php
/**
 * My Account — Addresses (Snazzy Floret premium override).
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing Address', 'snazzy-floret' ),
			'shipping' => __( 'Shipping Address', 'snazzy-floret' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array( 'billing' => __( 'Billing Address', 'snazzy-floret' ) ),
		$customer_id
	);
}
?>

<div class="sf-account-section">
	<div class="sf-account-section__head">
		<h2 class="sf-account-section__title"><?php esc_html_e( 'My Addresses', 'snazzy-floret' ); ?></h2>
		<p class="sf-account-section__sub"><?php esc_html_e( 'These addresses are used by default at checkout.', 'snazzy-floret' ); ?></p>
	</div>

	<div class="sf-address-grid">
		<?php foreach ( $get_addresses as $name => $address_title ) :
			$address = wc_get_account_formatted_address( $name );
		?>
			<article class="sf-address-card-acc">
				<div class="sf-address-card-acc__head">
					<div class="sf-address-card-acc__icon">
						<?php if ( 'billing' === $name ) : ?>
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
						<?php else : ?>
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13v10H3zM16 10h4l1 3v4h-5z"/><circle cx="7" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></svg>
						<?php endif; ?>
					</div>
					<h3 class="sf-address-card-acc__title"><?php echo esc_html( $address_title ); ?></h3>
				</div>
				<address class="sf-address-card-acc__body">
					<?php echo $address ? wp_kses_post( $address ) : '<span class="sf-address-card-acc__empty">' . esc_html__( 'You have not set up this address yet.', 'snazzy-floret' ) . '</span>'; ?>
				</address>
				<a class="sf-btn sf-btn--ghost sf-btn--sm" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
					<?php echo $address ? esc_html__( 'Edit', 'snazzy-floret' ) : esc_html__( 'Add', 'snazzy-floret' ); ?>
				</a>
				<?php do_action( 'woocommerce_my_account_after_my_address', $name ); ?>
			</article>
		<?php endforeach; ?>
	</div>
</div>
