<?php
/**
 * My Account navigation — Snazzy Floret premium override.
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

global $wp;

do_action( 'woocommerce_before_account_navigation' );

$sf_account_icons = array(
	'dashboard'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>',
	'orders'          => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/><path d="M14 2v6h6"/><path d="M9 13h6M9 17h6"/></svg>',
	'downloads'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>',
	'edit-address'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
	'payment-methods' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>',
	'edit-account'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>',
	'customer-logout' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>',
);
?>

<nav class="woocommerce-MyAccount-navigation sf-account-nav" aria-label="<?php esc_attr_e( 'Account pages', 'snazzy-floret' ); ?>">
	<div class="sf-account-nav__header">
		<div class="sf-account-nav__avatar"><?php echo get_avatar( get_current_user_id(), 56 ); ?></div>
		<div class="sf-account-nav__user">
			<span class="sf-account-nav__hello"><?php esc_html_e( 'Welcome back', 'snazzy-floret' ); ?></span>
			<strong class="sf-account-nav__name"><?php echo esc_html( wp_get_current_user()->display_name ); ?></strong>
		</div>
	</div>

	<?php
	// Ensure all standard endpoints are always present, regardless of WC's
	// conditional filtering (e.g. payment-methods being hidden when no
	// tokenization gateway is enabled). This prevents menu items from
	// flickering or disappearing between page loads.
	$sf_menu_items = wc_get_account_menu_items();
	$sf_default_items = array(
		'dashboard'       => __( 'Dashboard', 'snazzy-floret' ),
		'orders'          => __( 'Orders', 'snazzy-floret' ),
		'downloads'       => __( 'Downloads', 'snazzy-floret' ),
		'edit-address'    => __( 'Addresses', 'snazzy-floret' ),
		'payment-methods' => __( 'Payment methods', 'snazzy-floret' ),
		'edit-account'    => __( 'Account details', 'snazzy-floret' ),
		'customer-logout' => __( 'Log out', 'snazzy-floret' ),
	);
	$sf_merged = array();
	foreach ( $sf_default_items as $sf_ep => $sf_lbl ) {
		$sf_merged[ $sf_ep ] = isset( $sf_menu_items[ $sf_ep ] ) ? $sf_menu_items[ $sf_ep ] : $sf_lbl;
	}

	// Determine the active endpoint strictly from the current request, not
	// from navigation history. Sub-endpoints (e.g. view-order, order-received)
	// must map back to their parent menu item so only one item is highlighted.
	$sf_endpoint_alias = array(
		'view-order'      => 'orders',
		'order-received'  => 'orders',
		'orders'          => 'orders',
		'downloads'       => 'downloads',
		'edit-address'    => 'edit-address',
		'payment-methods' => 'payment-methods',
		'add-payment-method' => 'payment-methods',
		'delete-payment-method' => 'payment-methods',
		'set-default-payment-method' => 'payment-methods',
		'edit-account'    => 'edit-account',
		'customer-logout' => 'customer-logout',
		'lost-password'   => 'edit-account',
	);
	$sf_current_endpoint = '';
	foreach ( $sf_endpoint_alias as $sf_qv => $sf_target ) {
		if ( isset( $wp->query_vars[ $sf_qv ] ) ) {
			$sf_current_endpoint = $sf_target;
			break;
		}
	}
	if ( '' === $sf_current_endpoint && is_account_page() ) {
		$sf_current_endpoint = 'dashboard';
	}
	?>
	<ul>
		<?php foreach ( $sf_merged as $endpoint => $label ) : ?>
			<?php
			$sf_is_active = ( $endpoint === $sf_current_endpoint );
			$sf_classes   = trim( wc_get_account_menu_item_classes( $endpoint ) );
			if ( $sf_is_active && false === strpos( $sf_classes, 'is-active' ) ) {
				$sf_classes .= ' is-active';
			}
			?>
			<li class="<?php echo esc_attr( $sf_classes ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" <?php echo $sf_is_active ? 'aria-current="page"' : ''; ?>>
					<span class="sf-account-nav__icon">
						<?php echo isset( $sf_account_icons[ $endpoint ] ) ? $sf_account_icons[ $endpoint ] : $sf_account_icons['dashboard']; // phpcs:ignore ?>
					</span>
					<span class="sf-account-nav__label"><?php echo esc_html( $label ); ?></span>
					<svg class="sf-account-nav__arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
