<?php
/**
 * My Account — Orders (Snazzy Floret premium override).
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

// Re-query with a smaller per-page so the numbered pagination is meaningful.
$sf_per_page = 5;
$sf_paged    = max( 1, (int) $current_page );
$sf_query    = wc_get_orders(
	array(
		'customer' => get_current_user_id(),
		'page'     => $sf_paged,
		'paginate' => true,
		'limit'    => $sf_per_page,
		'type'     => 'shop_order',
		'status'   => array_keys( wc_get_order_statuses() ),
	)
);
$customer_orders = $sf_query;
$has_orders      = 0 < $customer_orders->total;
?>
<?php do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<div class="sf-account-section">
	<div class="sf-account-section__head">
		<h2 class="sf-account-section__title"><?php esc_html_e( 'My Orders', 'snazzy-floret' ); ?></h2>
		<p class="sf-account-section__sub"><?php esc_html_e( 'Track every purchase and revisit past orders any time.', 'snazzy-floret' ); ?></p>
	</div>

	<?php if ( $has_orders ) : ?>

		<div class="sf-orders-table-wrap">
			<table class="sf-orders-table">
				<thead>
					<tr>
						<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
							<th class="sf-orders-table__th sf-orders-table__th--<?php echo esc_attr( $column_id ); ?>"><?php echo esc_html( $column_name ); ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $customer_orders->orders as $customer_order ) :
						$order      = wc_get_order( $customer_order );
						$item_count = $order->get_item_count() - $order->get_item_count_refunded();
					?>
						<tr class="sf-orders-table__row">
							<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
								<td class="sf-orders-table__td sf-orders-table__td--<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
									<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
										<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>
									<?php elseif ( 'order-number' === $column_id ) : ?>
										<a class="sf-orders-table__num" href="<?php echo esc_url( $order->get_view_order_url() ); ?>">#<?php echo esc_html( $order->get_order_number() ); ?></a>
									<?php elseif ( 'order-date' === $column_id ) : ?>
										<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>
									<?php elseif ( 'order-status' === $column_id ) : ?>
										<?php
											$sf_status       = $order->get_status();
											$sf_status_name  = wc_get_order_status_name( $sf_status );
											$sf_status_icons = array(
												'pending'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
												'processing' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-3-6.7"/><polyline points="21 4 21 10 15 10"/></svg>',
												'on-hold'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="10" y1="9" x2="10" y2="15"/><line x1="14" y1="9" x2="14" y2="15"/></svg>',
												'completed'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>',
												'cancelled'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
												'refunded'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>',
												'failed'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
											);
											$sf_tooltips = array(
												'cancelled' => __( 'Order was cancelled by the customer or admin.', 'snazzy-floret' ),
												'refunded'  => __( 'Payment was refunded to the customer.', 'snazzy-floret' ),
												'failed'    => __( 'Payment attempt failed or was declined.', 'snazzy-floret' ),
											);
											?>
											<span class="sf-status-wrap">
												<span class="sf-status sf-status--has-icon sf-status--<?php echo esc_attr( $sf_status ); ?>">
													<span class="sf-status__icon" aria-hidden="true"><?php echo isset( $sf_status_icons[ $sf_status ] ) ? $sf_status_icons[ $sf_status ] : ''; // phpcs:ignore ?></span>
													<span class="sf-status__label"><?php echo esc_html( $sf_status_name ); ?></span>
												</span>
												<?php if ( isset( $sf_tooltips[ $sf_status ] ) ) : ?>
													<span class="sf-status-info" tabindex="0" aria-label="<?php echo esc_attr( $sf_tooltips[ $sf_status ] ); ?>">
														<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
														<span class="sf-status-info__tip"><?php echo esc_html( $sf_tooltips[ $sf_status ] ); ?></span>
													</span>
												<?php endif; ?>
											</span>
									<?php elseif ( 'order-total' === $column_id ) : ?>
										<?php echo wp_kses_post( $order->get_formatted_order_total() ); ?>
										<small class="sf-orders-table__items">(<?php echo esc_html( $item_count ); ?> <?php echo esc_html( _n( 'item', 'items', $item_count, 'snazzy-floret' ) ); ?>)</small>
									<?php elseif ( 'order-actions' === $column_id ) : ?>
										<?php
											$sf_actions = wc_get_account_orders_actions( $order );
											$sf_menu = array(
												'view' => array(
													'url'  => $order->get_view_order_url(),
													'name' => __( 'View', 'snazzy-floret' ),
												),
											);
											if ( ! empty( $sf_actions ) ) {
												foreach ( $sf_actions as $sf_k => $sf_a ) {
													if ( 'view' === $sf_k ) { continue; }
													$sf_menu[ $sf_k ] = $sf_a;
												}
											}
											$sf_action_icons = array(
												'view'   => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>',
												'pay'    => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>',
												'cancel' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
											);
										?>
										<div class="sf-actions-menu" data-sf-menu>
											<button type="button" class="sf-actions-menu__trigger" aria-haspopup="true" aria-expanded="false" aria-label="<?php esc_attr_e( 'Order actions', 'snazzy-floret' ); ?>">
												<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
											</button>
											<div class="sf-actions-menu__panel" role="menu">
												<?php foreach ( $sf_menu as $sf_k => $sf_a ) : ?>
													<a class="sf-actions-menu__item sf-actions-menu__item--<?php echo esc_attr( $sf_k ); ?>" role="menuitem" href="<?php echo esc_url( $sf_a['url'] ); ?>">
														<span class="sf-actions-menu__icon"><?php echo isset( $sf_action_icons[ $sf_k ] ) ? $sf_action_icons[ $sf_k ] : $sf_action_icons['view']; // phpcs:ignore ?></span>
														<span><?php echo esc_html( $sf_a['name'] ); ?></span>
													</a>
												<?php endforeach; ?>
											</div>
										</div>
									<?php endif; ?>
								</td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

		<?php
		$sf_total_pages = (int) $customer_orders->max_num_pages;
		if ( 1 < $sf_total_pages ) :
			$sf_cur = (int) $current_page;

			// Build the list of page numbers to render, with ellipses.
			$sf_pages = array();
			if ( $sf_total_pages <= 7 ) {
				for ( $i = 1; $i <= $sf_total_pages; $i++ ) {
					$sf_pages[] = $i;
				}
			} else {
				$sf_pages[] = 1;
				$sf_start   = max( 2, $sf_cur - 1 );
				$sf_end     = min( $sf_total_pages - 1, $sf_cur + 1 );
				if ( $sf_cur <= 3 ) {
					$sf_start = 2;
					$sf_end   = 4;
				}
				if ( $sf_cur >= $sf_total_pages - 2 ) {
					$sf_start = $sf_total_pages - 3;
					$sf_end   = $sf_total_pages - 1;
				}
				if ( $sf_start > 2 ) {
					$sf_pages[] = '...';
				}
				for ( $i = $sf_start; $i <= $sf_end; $i++ ) {
					$sf_pages[] = $i;
				}
				if ( $sf_end < $sf_total_pages - 1 ) {
					$sf_pages[] = '...';
				}
				$sf_pages[] = $sf_total_pages;
			}
			?>
			<nav class="sf-pager" aria-label="<?php esc_attr_e( 'Orders pagination', 'snazzy-floret' ); ?>">
				<a class="sf-pager__btn sf-pager__btn--arrow <?php echo 1 === $sf_cur ? 'is-disabled' : ''; ?>"
					<?php echo 1 === $sf_cur ? 'aria-disabled="true" tabindex="-1"' : 'href="' . esc_url( wc_get_endpoint_url( 'orders', $sf_cur - 1 ) ) . '"'; ?>
					aria-label="<?php esc_attr_e( 'Previous page', 'snazzy-floret' ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
				</a>
				<?php foreach ( $sf_pages as $sf_p ) : ?>
					<?php if ( '...' === $sf_p ) : ?>
						<span class="sf-pager__ellipsis" aria-hidden="true">…</span>
					<?php elseif ( (int) $sf_p === $sf_cur ) : ?>
						<span class="sf-pager__btn is-active" aria-current="page"><?php echo esc_html( $sf_p ); ?></span>
					<?php else : ?>
						<a class="sf-pager__btn" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $sf_p ) ); ?>"><?php echo esc_html( $sf_p ); ?></a>
					<?php endif; ?>
				<?php endforeach; ?>
				<a class="sf-pager__btn sf-pager__btn--arrow <?php echo $sf_cur === $sf_total_pages ? 'is-disabled' : ''; ?>"
					<?php echo $sf_cur === $sf_total_pages ? 'aria-disabled="true" tabindex="-1"' : 'href="' . esc_url( wc_get_endpoint_url( 'orders', $sf_cur + 1 ) ) . '"'; ?>
					aria-label="<?php esc_attr_e( 'Next page', 'snazzy-floret' ); ?>">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
				</a>
			</nav>
		<?php endif; ?>

	<?php else : ?>

		<div class="sf-empty-state">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
			<h3><?php esc_html_e( 'No orders yet', 'snazzy-floret' ); ?></h3>
			<p><?php esc_html_e( 'When you place your first order, it will appear here.', 'snazzy-floret' ); ?></p>
			<a class="sf-btn sf-btn--primary" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Browse Products', 'snazzy-floret' ); ?></a>
		</div>

	<?php endif; ?>
</div>

<script>
(function(){
	var menus = document.querySelectorAll('[data-sf-menu]');
	if (!menus.length) return;
	function closeAll(except){
		menus.forEach(function(m){
			if (m === except) return;
			m.classList.remove('is-open');
			var t = m.querySelector('.sf-actions-menu__trigger');
			if (t) t.setAttribute('aria-expanded','false');
		});
	}
	menus.forEach(function(menu){
		var trigger = menu.querySelector('.sf-actions-menu__trigger');
		if (!trigger) return;
		trigger.addEventListener('click', function(e){
			e.stopPropagation();
			var open = menu.classList.toggle('is-open');
			trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
			if (open) closeAll(menu);
		});
	});
	document.addEventListener('click', function(){ closeAll(null); });
	document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeAll(null); });
})();
</script>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
