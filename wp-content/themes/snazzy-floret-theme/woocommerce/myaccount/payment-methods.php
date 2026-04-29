<?php
/**
 * My Account — Payment Methods (Snazzy Floret premium override).
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

$saved_methods = wc_get_customer_saved_methods_list( get_current_user_id() );
$has_methods   = (bool) WC_Payment_Tokens::get_customer_tokens( get_current_user_id() );
?>

<div class="sf-account-section">
	<div class="sf-account-section__head">
		<h2 class="sf-account-section__title"><?php esc_html_e( 'Payment Methods', 'snazzy-floret' ); ?></h2>
		<p class="sf-account-section__sub"><?php esc_html_e( 'Securely manage cards and other saved payment methods.', 'snazzy-floret' ); ?></p>
	</div>

	<?php if ( $has_methods ) : ?>
		<?php
		// Render default WC table for tokens.
		$columns = apply_filters(
			'woocommerce_payment_methods_list_columns',
			array(
				'method'  => __( 'Method', 'woocommerce' ),
				'expires' => __( 'Expires', 'woocommerce' ),
				'actions' => '&nbsp;',
			)
		);
		?>
		<div class="sf-orders-table-wrap">
			<table class="sf-orders-table">
				<thead>
					<tr>
						<?php foreach ( $columns as $column_id => $column_name ) : ?>
							<th class="sf-orders-table__th"><?php echo esc_html( $column_name ); ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $saved_methods as $type => $methods ) : ?>
						<?php foreach ( $methods as $method ) : ?>
							<tr class="sf-orders-table__row">
								<?php foreach ( $columns as $column_id => $column_name ) : ?>
									<td class="sf-orders-table__td">
										<?php if ( has_action( 'woocommerce_account_payment_methods_column_' . $column_id ) ) : ?>
											<?php do_action( 'woocommerce_account_payment_methods_column_' . $column_id, $method ); ?>
										<?php elseif ( 'method' === $column_id ) : ?>
											<?php if ( ! empty( $method['method']['last4'] ) ) : ?>
												<?php echo esc_html( sprintf( __( '%s ending in %s', 'woocommerce' ), esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) ), esc_html( $method['method']['last4'] ) ) ); ?>
											<?php else : ?>
												<?php echo esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) ); ?>
											<?php endif; ?>
										<?php elseif ( 'expires' === $column_id ) : ?>
											<?php echo esc_html( $method['expires'] ); ?>
										<?php elseif ( 'actions' === $column_id ) : ?>
											<div class="sf-orders-table__actions">
												<?php foreach ( $method['actions'] as $key => $action ) : ?>
													<a class="sf-btn sf-btn--ghost sf-btn--sm" href="<?php echo esc_url( $action['url'] ); ?>"><?php echo esc_html( $action['name'] ); ?></a>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
									</td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php else : ?>
		<div class="sf-empty-state">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/><line x1="6" y1="15" x2="10" y2="15"/></svg>
			<h3><?php esc_html_e( 'No saved payment methods found', 'snazzy-floret' ); ?></h3>
			<p><?php esc_html_e( 'Save a card during checkout to reuse it next time.', 'snazzy-floret' ); ?></p>
			<a class="sf-btn sf-btn--primary" href="<?php echo esc_url( wc_get_endpoint_url( 'add-payment-method' ) ); ?>"><?php esc_html_e( 'Add Payment Method', 'snazzy-floret' ); ?></a>
		</div>
	<?php endif; ?>
</div>
