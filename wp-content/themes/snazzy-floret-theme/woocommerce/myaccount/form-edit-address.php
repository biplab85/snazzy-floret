<?php
/**
 * Edit Address — Snazzy Floret premium override.
 *
 * @package Snazzy_Floret
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$is_billing = ( 'billing' === $load_address );
$page_title = $is_billing ? esc_html__( 'Billing address', 'snazzy-floret' ) : esc_html__( 'Shipping address', 'snazzy-floret' );
$page_sub   = $is_billing
	? esc_html__( 'Used for invoicing and order confirmation.', 'snazzy-floret' )
	: esc_html__( 'Where we will deliver your orders.', 'snazzy-floret' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

	<div class="sf-account-section sf-edit-address sf-edit-address--<?php echo esc_attr( $load_address ); ?>">
		<div class="sf-account-section__head">
			<h2 class="sf-account-section__title">
				<span class="sf-edit-address__icon" aria-hidden="true">
					<?php if ( $is_billing ) : ?>
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/><line x1="6" y1="15" x2="10" y2="15"/></svg>
					<?php else : ?>
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h11v10H3z"/><path d="M14 10h4l3 3v4h-7z"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
					<?php endif; ?>
				</span>
				<?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</h2>
			<p class="sf-account-section__sub"><?php echo esc_html( $page_sub ); ?></p>
		</div>

		<form method="post" novalidate class="sf-edit-address__form">
			<div class="woocommerce-address-fields">
				<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

				<div class="woocommerce-address-fields__field-wrapper sf-edit-address__grid">
					<?php
					foreach ( $address as $key => $field ) {
						woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
					}
					?>
				</div>

				<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

				<div class="sf-edit-address__actions">
					<button type="submit" class="sf-btn sf-btn--primary" name="save_address" value="<?php esc_attr_e( 'Save address', 'snazzy-floret' ); ?>">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
						<?php esc_html_e( 'Save Address', 'snazzy-floret' ); ?>
					</button>
					<a class="sf-btn sf-btn--ghost" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>"><?php esc_html_e( 'Cancel', 'snazzy-floret' ); ?></a>
					<?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
					<input type="hidden" name="action" value="edit_address" />
				</div>
			</div>
		</form>
	</div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
