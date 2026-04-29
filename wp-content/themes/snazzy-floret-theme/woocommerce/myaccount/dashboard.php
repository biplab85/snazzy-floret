<?php
/**
 * My Account Dashboard — Snazzy Floret premium override.
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

$sf_user        = wp_get_current_user();
$sf_orders      = wc_get_orders( array( 'customer' => $sf_user->ID, 'limit' => 1, 'orderby' => 'date', 'order' => 'DESC' ) );
$sf_order_count = wc_get_customer_order_count( $sf_user->ID );
$sf_last_order  = ! empty( $sf_orders ) ? $sf_orders[0] : null;
?>

<section class="sf-dashboard">
	<div class="sf-dashboard__welcome">
		<div>
			<p class="sf-dashboard__eyebrow"><?php esc_html_e( 'My Account', 'snazzy-floret' ); ?></p>
			<h2 class="sf-dashboard__title">
				<?php
				printf(
					/* translators: %s display name */
					esc_html__( 'Hello, %s', 'snazzy-floret' ),
					esc_html( $sf_user->display_name )
				);
				?>
			</h2>
			<p class="sf-dashboard__subtitle"><?php esc_html_e( 'Manage your orders, addresses and account preferences from one place.', 'snazzy-floret' ); ?></p>
		</div>
		<a class="sf-btn sf-btn--primary" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
			<?php esc_html_e( 'Continue Shopping', 'snazzy-floret' ); ?>
		</a>
	</div>

	<div class="sf-dashboard__stats">
		<div class="sf-dashboard-stat sf-dashboard-stat--pink">
			<div class="sf-dashboard-stat__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/><path d="M14 2v6h6"/></svg></div>
			<div>
				<span class="sf-dashboard-stat__label"><?php esc_html_e( 'Total Orders', 'snazzy-floret' ); ?></span>
				<strong class="sf-dashboard-stat__value"><?php echo esc_html( $sf_order_count ); ?></strong>
			</div>
		</div>
		<div class="sf-dashboard-stat sf-dashboard-stat--sky">
			<div class="sf-dashboard-stat__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
			<div>
				<span class="sf-dashboard-stat__label"><?php esc_html_e( 'Saved Addresses', 'snazzy-floret' ); ?></span>
				<strong class="sf-dashboard-stat__value"><?php echo $sf_user->ID && get_user_meta( $sf_user->ID, 'billing_address_1', true ) ? '2' : '0'; ?></strong>
			</div>
		</div>
		<div class="sf-dashboard-stat sf-dashboard-stat--green">
			<div class="sf-dashboard-stat__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-3-3.87"/><path d="M4 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><circle cx="10" cy="7" r="4"/></svg></div>
			<div>
				<span class="sf-dashboard-stat__label"><?php esc_html_e( 'Member Since', 'snazzy-floret' ); ?></span>
				<strong class="sf-dashboard-stat__value"><?php echo esc_html( date_i18n( 'M Y', strtotime( $sf_user->user_registered ) ) ); ?></strong>
			</div>
		</div>
	</div>

	<div class="sf-dashboard__grid">
		<div class="sf-dashboard-card">
			<div class="sf-dashboard-card__head">
				<h3><?php esc_html_e( 'Recent Order', 'snazzy-floret' ); ?></h3>
				<a href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>"><?php esc_html_e( 'View all', 'snazzy-floret' ); ?> →</a>
			</div>
			<?php if ( $sf_last_order ) : ?>
				<div class="sf-dashboard-recent">
					<div class="sf-dashboard-recent__row">
						<span class="sf-dashboard-recent__label"><?php esc_html_e( 'Order #', 'snazzy-floret' ); ?></span>
						<strong>#<?php echo esc_html( $sf_last_order->get_order_number() ); ?></strong>
					</div>
					<div class="sf-dashboard-recent__row">
						<span class="sf-dashboard-recent__label"><?php esc_html_e( 'Date', 'snazzy-floret' ); ?></span>
						<strong><?php echo esc_html( wc_format_datetime( $sf_last_order->get_date_created() ) ); ?></strong>
					</div>
					<div class="sf-dashboard-recent__row">
						<span class="sf-dashboard-recent__label"><?php esc_html_e( 'Status', 'snazzy-floret' ); ?></span>
						<span class="sf-status sf-status--<?php echo esc_attr( $sf_last_order->get_status() ); ?>"><?php echo esc_html( wc_get_order_status_name( $sf_last_order->get_status() ) ); ?></span>
					</div>
					<div class="sf-dashboard-recent__row">
						<span class="sf-dashboard-recent__label"><?php esc_html_e( 'Total', 'snazzy-floret' ); ?></span>
						<strong><?php echo wp_kses_post( $sf_last_order->get_formatted_order_total() ); ?></strong>
					</div>
					<a class="sf-btn sf-btn--ghost" href="<?php echo esc_url( $sf_last_order->get_view_order_url() ); ?>"><?php esc_html_e( 'View order details', 'snazzy-floret' ); ?></a>
				</div>
			<?php else : ?>
				<p class="sf-dashboard-empty"><?php esc_html_e( 'You haven\'t placed any orders yet.', 'snazzy-floret' ); ?></p>
			<?php endif; ?>
		</div>

		<div class="sf-dashboard-card">
			<div class="sf-dashboard-card__head">
				<h3><?php esc_html_e( 'Quick Actions', 'snazzy-floret' ); ?></h3>
			</div>
			<div class="sf-quick-actions">
				<a class="sf-quick-action" href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/><path d="M14 2v6h6"/></svg>
					<span><?php esc_html_e( 'My Orders', 'snazzy-floret' ); ?></span>
				</a>
				<a class="sf-quick-action" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
					<span><?php esc_html_e( 'Addresses', 'snazzy-floret' ); ?></span>
				</a>
				<a class="sf-quick-action" href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
					<span><?php esc_html_e( 'Account Details', 'snazzy-floret' ); ?></span>
				</a>
				<a class="sf-quick-action" href="<?php echo esc_url( wc_logout_url() ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
					<span><?php esc_html_e( 'Logout', 'snazzy-floret' ); ?></span>
				</a>
			</div>
		</div>
	</div>
</section>

<?php
do_action( 'woocommerce_account_dashboard' );
do_action( 'woocommerce_before_my_account' );
do_action( 'woocommerce_after_my_account' );
