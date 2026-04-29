<?php
/**
 * View Order — Snazzy Floret premium override.
 *
 * @package Snazzy_Floret
 * @version 10.6.0
 */

defined( 'ABSPATH' ) || exit;

$notes         = $order->get_customer_order_notes();
$status_slug   = $order->get_status();
$status_name   = wc_get_order_status_name( $status_slug );
$order_number  = $order->get_order_number();
$order_date    = wc_format_datetime( $order->get_date_created() );

$timeline = array(
	'pending'    => __( 'Order Placed', 'snazzy-floret' ),
	'processing' => __( 'Processing', 'snazzy-floret' ),
	'on-hold'    => __( 'On Hold', 'snazzy-floret' ),
	'shipped'    => __( 'Shipped', 'snazzy-floret' ),
	'completed'  => __( 'Delivered', 'snazzy-floret' ),
);
$flow      = array( 'pending', 'processing', 'shipped', 'completed' );
$current   = in_array( $status_slug, $flow, true ) ? array_search( $status_slug, $flow, true ) : 0;
?>

<div class="sf-account-section sf-view-order">
	<div class="sf-account-section__head">
		<h2 class="sf-account-section__title">
			<?php printf( esc_html__( 'Order #%s', 'snazzy-floret' ), esc_html( $order_number ) ); ?>
		</h2>
		<p class="sf-account-section__sub">
			<?php
			printf(
				/* translators: 1: date 2: status */
				esc_html__( 'Placed on %1$s · Status: %2$s', 'snazzy-floret' ),
				'<strong>' . esc_html( $order_date ) . '</strong>',
				'<span class="sf-status sf-status--' . esc_attr( $status_slug ) . '">' . esc_html( $status_name ) . '</span>'
			); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</p>
	</div>

	<?php if ( ! in_array( $status_slug, array( 'cancelled', 'failed', 'refunded' ), true ) ) : ?>
	<div class="sf-vo-timeline">
		<?php foreach ( $flow as $i => $step ) :
			$is_done    = $i <= $current;
			$is_current = $i === $current;
		?>
			<div class="sf-vo-step <?php echo $is_done ? 'is-done' : ''; ?> <?php echo $is_current ? 'is-current' : ''; ?>">
				<div class="sf-vo-step__dot">
					<?php if ( $is_done ) : ?>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
					<?php else : ?>
						<span><?php echo esc_html( $i + 1 ); ?></span>
					<?php endif; ?>
				</div>
				<div class="sf-vo-step__label"><?php echo esc_html( $timeline[ $step ] ); ?></div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<?php if ( $notes ) : ?>
		<div class="sf-vo-card">
			<h3 class="sf-vo-card__title"><?php esc_html_e( 'Order updates', 'snazzy-floret' ); ?></h3>
			<ol class="sf-vo-notes">
				<?php foreach ( $notes as $note ) : ?>
					<li class="sf-vo-note">
						<p class="sf-vo-note__meta"><?php echo esc_html( date_i18n( __( 'l jS \o\f F Y, h:ia', 'snazzy-floret' ), strtotime( $note->comment_date ) ) ); ?></p>
						<div class="sf-vo-note__body"><?php echo wp_kses_post( wpautop( wptexturize( $note->comment_content ) ) ); ?></div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	<?php endif; ?>

	<div class="sf-vo-details">
		<?php do_action( 'woocommerce_view_order', $order_id ); ?>
	</div>
</div>
