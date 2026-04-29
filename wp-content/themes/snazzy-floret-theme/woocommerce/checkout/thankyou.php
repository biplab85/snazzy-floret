<?php
/**
 * Premium Thank You / Order Received page — Snazzy Floret
 *
 * @var WC_Order $order
 */
defined( 'ABSPATH' ) || exit;

// Prevent default WooCommerce duplicate output of order details + customer details on thankyou.
remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );

// Suppress COD gateway "Pay with cash upon delivery." instructions on thankyou page.
$sf_gateways = WC()->payment_gateways() ? WC()->payment_gateways()->payment_gateways() : array();
if ( isset( $sf_gateways['cod'] ) ) {
	remove_action( 'woocommerce_thankyou_cod', array( $sf_gateways['cod'], 'thankyou_page' ) );
}
?>

<div class="sf-thankyou">

	<?php if ( $order ) : do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<div class="sf-thankyou__failed">
				<h2><?php esc_html_e( 'Payment Failed', 'snazzy-floret' ); ?></h2>
				<p><?php esc_html_e( 'Unfortunately your order cannot be processed. Please try again.', 'woocommerce' ); ?></p>
				<p>
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="sf-btn sf-btn--primary"><?php esc_html_e( 'Pay Now', 'woocommerce' ); ?></a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="sf-btn"><?php esc_html_e( 'My Account', 'woocommerce' ); ?></a>
					<?php endif; ?>
				</p>
			</div>

		<?php else : ?>

			<!-- Animated background -->
			<div class="sf-thankyou__bg" aria-hidden="true">
				<svg class="sf-bg-blob sf-bg-blob--1" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
					<defs>
						<linearGradient id="sfGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
							<stop offset="0%" stop-color="#D4A76A" stop-opacity="0.45"/>
							<stop offset="100%" stop-color="#8B6F4E" stop-opacity="0.15"/>
						</linearGradient>
					</defs>
					<path fill="url(#sfGrad1)">
						<animate attributeName="d" dur="18s" repeatCount="indefinite"
							values="
M421.5,316Q399,382,338,419.5Q277,457,210,425Q143,393,109.5,329.5Q76,266,108,200Q140,134,205,98.5Q270,63,335,98Q400,133,425.5,199.5Q451,266,421.5,316Z;
M438,318Q412,386,348,422Q284,458,213,431Q142,404,108,335Q74,266,108,197Q142,128,212,99Q282,70,346,103Q410,136,438,201Q466,266,438,318Z;
M421.5,316Q399,382,338,419.5Q277,457,210,425Q143,393,109.5,329.5Q76,266,108,200Q140,134,205,98.5Q270,63,335,98Q400,133,425.5,199.5Q451,266,421.5,316Z"/>
					</path>
				</svg>
				<svg class="sf-bg-blob sf-bg-blob--2" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
					<defs>
						<linearGradient id="sfGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
							<stop offset="0%" stop-color="#8B6F4E" stop-opacity="0.30"/>
							<stop offset="100%" stop-color="#D4A76A" stop-opacity="0.08"/>
						</linearGradient>
					</defs>
					<path fill="url(#sfGrad2)">
						<animate attributeName="d" dur="22s" repeatCount="indefinite"
							values="
M450,300Q430,370,370,410Q310,450,240,420Q170,390,130,320Q90,250,140,185Q190,120,260,100Q330,80,395,120Q460,160,470,225Q480,290,450,300Z;
M460,310Q420,380,355,415Q290,450,225,420Q160,390,125,325Q90,260,135,190Q180,120,255,105Q330,90,395,130Q460,170,475,230Q490,290,460,310Z;
M450,300Q430,370,370,410Q310,450,240,420Q170,390,130,320Q90,250,140,185Q190,120,260,100Q330,80,395,120Q460,160,470,225Q480,290,450,300Z"/>
					</path>
				</svg>
				<div class="sf-bg-grain"></div>
			</div>

			<!-- Hero / confirmation -->
			<header class="sf-thankyou__hero">
				<div class="sf-success-mark">
					<svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
						<circle class="sf-success-mark__ring" cx="60" cy="60" r="54" fill="none" stroke="#D4A76A" stroke-width="3"/>
						<circle class="sf-success-mark__circle" cx="60" cy="60" r="48" fill="none" stroke="#8B6F4E" stroke-width="4"/>
						<path class="sf-success-mark__check" d="M38 62 L54 78 L84 46" fill="none" stroke="#8B6F4E" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>
				<p class="sf-thankyou__eyebrow"><?php esc_html_e( 'Order Confirmed', 'snazzy-floret' ); ?></p>
				<h1 class="sf-thankyou__title"><?php esc_html_e( 'Thank you for your order', 'snazzy-floret' ); ?></h1>
				<p class="sf-thankyou__subtitle">
					<?php
					printf(
						/* translators: %s: customer first name */
						esc_html__( '%s, your order has been received and is being prepared with care.', 'snazzy-floret' ),
						esc_html( $order->get_billing_first_name() ?: __( 'Dear customer', 'snazzy-floret' ) )
					);
					?>
				</p>
			</header>

			<!-- Order overview cards -->
			<section class="sf-order-overview">
				<div class="sf-overview-card sf-overview-card--pink">
					<div class="sf-overview-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M9 13h6M9 17h6"/></svg>
					</div>
					<div>
						<span class="sf-overview-card__label"><?php esc_html_e( 'Order Number', 'snazzy-floret' ); ?></span>
						<strong class="sf-overview-card__value">#<?php echo esc_html( $order->get_order_number() ); ?></strong>
					</div>
				</div>
				<div class="sf-overview-card sf-overview-card--sky">
					<div class="sf-overview-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
					</div>
					<div>
						<span class="sf-overview-card__label"><?php esc_html_e( 'Date', 'snazzy-floret' ); ?></span>
						<strong class="sf-overview-card__value"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></strong>
					</div>
				</div>
				<div class="sf-overview-card sf-overview-card--green">
					<div class="sf-overview-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
					</div>
					<div>
						<span class="sf-overview-card__label"><?php esc_html_e( 'Total', 'snazzy-floret' ); ?></span>
						<strong class="sf-overview-card__value"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong>
					</div>
				</div>
				<?php if ( $order->get_payment_method_title() ) : ?>
				<div class="sf-overview-card sf-overview-card--lavender">
					<div class="sf-overview-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20M6 15h4"/></svg>
					</div>
					<div>
						<span class="sf-overview-card__label"><?php esc_html_e( 'Payment', 'snazzy-floret' ); ?></span>
						<strong class="sf-overview-card__value"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</div>
				</div>
				<?php endif; ?>
			</section>

			<!-- Order details (items + totals) -->
			<section class="sf-order-details-wrap">
				<?php wc_get_template( 'order/order-details.php', array(
					'order_id'       => $order->get_id(),
					'show_downloads' => $order->has_downloadable_item() && $order->is_download_permitted(),
				) ); ?>
			</section>

			<!-- Addresses side by side -->
			<?php
			$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
			?>
			<section class="sf-addresses<?php echo $show_shipping ? ' sf-addresses--two' : ''; ?>">
				<article class="sf-address-card">
					<div class="sf-address-card__head">
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#8B6F4E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10l9-7 9 7v10a2 2 0 0 1-2 2h-4v-7H9v7H5a2 2 0 0 1-2-2z"/></svg>
						<h2><?php esc_html_e( 'Billing Address', 'snazzy-floret' ); ?></h2>
					</div>
					<address><?php echo wp_kses_post( $order->get_formatted_billing_address( __( 'N/A', 'snazzy-floret' ) ) ); ?></address>
					<?php if ( $order->get_billing_phone() ) : ?>
						<p class="sf-address-card__meta"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
					<?php endif; ?>
					<?php if ( $order->get_billing_email() ) : ?>
						<p class="sf-address-card__meta"><?php echo esc_html( $order->get_billing_email() ); ?></p>
					<?php endif; ?>
				</article>

				<?php if ( $show_shipping ) : ?>
				<article class="sf-address-card">
					<div class="sf-address-card__head">
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#8B6F4E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13v10H3zM16 10h4l1 3v4h-5z"/><circle cx="7" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></svg>
						<h2><?php esc_html_e( 'Shipping Address', 'snazzy-floret' ); ?></h2>
					</div>
					<address><?php echo wp_kses_post( $order->get_formatted_shipping_address( __( 'N/A', 'snazzy-floret' ) ) ); ?></address>
				</article>
				<?php endif; ?>
			</section>

			<!-- CTA -->
			<div class="sf-thankyou__cta">
				<?php if ( function_exists( 'sf_get_invoice_url' ) ) : ?>
					<a href="<?php echo esc_url( sf_get_invoice_url( $order ) ); ?>" class="sf-btn sf-btn--primary" target="_blank" rel="noopener">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>
						<?php esc_html_e( 'Download Invoice (PDF)', 'snazzy-floret' ); ?>
					</a>
				<?php endif; ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="sf-btn">
					<?php esc_html_e( 'Continue Shopping', 'snazzy-floret' ); ?>
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
				</a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="sf-btn"><?php esc_html_e( 'View My Orders', 'snazzy-floret' ); ?></a>
				<?php endif; ?>
			</div>

		<?php endif; ?>

		<?php
		do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
		do_action( 'woocommerce_thankyou', $order->get_id() );
		?>

	<?php else : ?>
		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>
	<?php endif; ?>

</div>

<style>
.sf-thankyou{position:relative;max-width:1080px;margin:0 auto;padding:80px 24px 96px;font-family:'Inter',sans-serif;color:#1A1A1A;overflow:hidden}
.sf-thankyou__bg{position:absolute;inset:-10% -10% -10% -10%;z-index:-1;pointer-events:none;overflow:hidden; display: none !important}
.sf-bg-blob{position:absolute;width:760px;height:760px;filter:blur(40px);opacity:.9}
.sf-bg-blob--1{top:-220px;left:-200px;animation:sfFloat1 20s ease-in-out infinite}
.sf-bg-blob--2{bottom:-260px;right:-220px;animation:sfFloat2 26s ease-in-out infinite}
@keyframes sfFloat1{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(40px,30px) scale(1.05)}}
@keyframes sfFloat2{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(-30px,-40px) scale(1.08)}}
.sf-bg-grain{position:absolute;inset:0;background-image:radial-gradient(#2c2c2c 1px,transparent 1px);background-size:3px 3px;opacity:.025}

.sf-thankyou__hero{text-align:center;margin-bottom:56px;animation:sfFadeUp .8s ease both}
.sf-success-mark{width:120px;height:120px;margin:0 auto 24px}
.sf-success-mark svg{width:100%;height:100%}
.sf-success-mark__ring{stroke-dasharray:340;stroke-dashoffset:340;animation:sfDraw 1.4s .1s ease forwards;opacity:.5}
.sf-success-mark__circle{stroke-dasharray:302;stroke-dashoffset:302;animation:sfDraw 1.1s .2s ease forwards}
.sf-success-mark__check{stroke-dasharray:90;stroke-dashoffset:90;animation:sfDraw .6s 1s ease forwards}
@keyframes sfDraw{to{stroke-dashoffset:0}}

.sf-thankyou__eyebrow{font-family:'Poppins',sans-serif;text-transform:uppercase;letter-spacing:.25em;font-size:12px;color:#8B6F4E;margin:0 0 12px;font-weight:600}
.sf-thankyou__title{font-family:'Playfair Display',serif;font-size:clamp(36px,5vw,56px);font-weight:600;margin:0 0 16px;color:#1A1A1A;line-height:1.1}
.sf-thankyou__subtitle{font-size:17px;color:#6B6B6B;max-width:560px;margin:0 auto;line-height:1.6}

.sf-order-overview{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:48px;animation:sfFadeUp .8s .2s ease both}
.sf-overview-card{position:relative;display:flex;align-items:center;gap:16px;border:1px solid rgba(255,255,255,.6);border-radius:16px;padding:22px 20px;transition:transform .3s ease,box-shadow .3s ease;backdrop-filter:blur(8px)}
.sf-overview-card:hover{transform:translateY(-4px);box-shadow:0 16px 36px rgba(44,44,44,.10)}
.sf-overview-card__icon{flex:0 0 48px;width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,.7)}
.sf-overview-card__icon svg{width:24px;height:24px}
.sf-overview-card__label{display:block;font-size:11px;text-transform:uppercase;letter-spacing:.15em;color:#6B6B6B;margin-bottom:6px;font-weight:600}
.sf-overview-card__value{font-family:'Playfair Display',serif;font-size:18px;color:#1A1A1A;font-weight:600;line-height:1.2}
.sf-overview-card--pink{background:linear-gradient(135deg,#FFF0F3 0%,#FFE4EA 100%)}
.sf-overview-card--pink .sf-overview-card__icon{color:#D63864}
.sf-overview-card--sky{background:linear-gradient(135deg,#EAF6FF 0%,#D8ECFB 100%)}
.sf-overview-card--sky .sf-overview-card__icon{color:#1E78C8}
.sf-overview-card--green{background:linear-gradient(135deg,#EAF8EF 0%,#D6F0DE 100%)}
.sf-overview-card--green .sf-overview-card__icon{color:#2E8B57}
.sf-overview-card--lavender{background:linear-gradient(135deg,#F1ECFB 0%,#E3D9F6 100%)}
.sf-overview-card--lavender .sf-overview-card__icon{color:#6E4BB8}

.sf-order-details-wrap{background:rgba(255,255,255,.92);backdrop-filter:blur(12px);border:1px solid #E8E4DF;border-radius:16px;padding:32px;margin-bottom:48px;box-shadow:0 8px 32px rgba(44,44,44,.04);animation:sfFadeUp .8s .35s ease both}
.sf-order-details-wrap h2,.sf-order-details-wrap h3{font-family:'Playfair Display',serif;color:#1A1A1A;font-size:1.5rem}
.sf-order-details-wrap table{width:100%;border-collapse:collapse}
.sf-order-details-wrap th,.sf-order-details-wrap td{padding:14px 12px;border-bottom:1px solid #E8E4DF;text-align:left;font-size:15px}
.sf-order-details-wrap tfoot td,.sf-order-details-wrap tfoot th{font-weight:600}

.sf-addresses{display:grid;grid-template-columns:1fr;gap:20px;margin-bottom:48px;animation:sfFadeUp .8s .5s ease both}
.sf-addresses--two{grid-template-columns:1fr 1fr}
@media (max-width:720px){.sf-addresses--two{grid-template-columns:1fr}}
@media (max-width:767.98px){.sf-thankyou{padding:0}.sf-thankyou__cta{flex-direction:column;align-items:stretch}.sf-thankyou__cta>.sf-btn{width:100%;justify-content:center}.sf-order-details-wrap{padding:15px}}
.sf-address-card{background:rgba(255,255,255,.92);backdrop-filter:blur(12px);border:1px solid #E8E4DF;border-radius:16px;padding:28px;transition:transform .3s,box-shadow .3s}
.sf-address-card:hover{transform:translateY(-3px);box-shadow:0 12px 32px rgba(139,111,78,.10)}
.sf-address-card__head{display:flex;align-items:center;gap:10px;margin-bottom:16px;padding-bottom:14px;border-bottom:1px solid #E8E4DF}
.sf-address-card__head h2{font-family:'Playfair Display',serif;font-size:20px;margin:0;color:#1A1A1A;font-weight:600}
.sf-address-card address{font-style:normal;line-height:1.7;color:#1A1A1A;font-size:15px}
.sf-address-card__meta{margin:8px 0 0;color:#6B6B6B;font-size:14px}

.sf-thankyou__cta{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;animation:sfFadeUp .8s .65s ease both}
.sf-btn{display:inline-flex;align-items:center;gap:8px;padding:14px 28px;border-radius:8px;font-family:'Poppins',sans-serif;font-weight:500;font-size:14px;letter-spacing:.05em;text-decoration:none;transition:all .3s ease;border:1px solid #2C2C2C;color:#2C2C2C;background:transparent;cursor:pointer}
.sf-btn:hover{background:#2C2C2C;color:#fff;transform:translateY(-2px)}
.sf-btn--primary{background:#2C2C2C;color:#fff;border-color:#2C2C2C}
.sf-btn--primary:hover{background:#f03857;border-color:#F18D9E;box-shadow:0 12px 28px rgba(139,111,78,.35)}

@keyframes sfFadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}

/* hide default WC overview list since we render our own */
.woocommerce-order-overview.woocommerce-thankyou-order-details{display:none!important}
.woocommerce-customer-details{display:none!important}
body.woocommerce-order-received .sf-section__title{display:none!important}
</style>
