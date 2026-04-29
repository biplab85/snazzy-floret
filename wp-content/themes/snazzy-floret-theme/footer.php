	</main><!-- .sf-main -->

	<!-- Footer -->
	<footer class="sf-footer">

		<!-- Footer Hero: Image + Newsletter Overlay -->
		<div class="sf-footer-hero">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/footernewsletterbackground.png' ); ?>" alt="<?php esc_attr_e( 'Snazzy Floret', 'snazzy-floret' ); ?>" class="sf-footer-hero__img" loading="lazy">
			<div class="sf-footer-hero__newsletter">
				<div class="sf-footer-hero__newsletter-inner">
					<h2 class="sf-footer-hero__newsletter-title"><?php esc_html_e( 'Get 20% off your first order', 'snazzy-floret' ); ?></h2>
					<p class="sf-footer-hero__newsletter-desc"><?php esc_html_e( 'Join our email list for exclusive offers and the latest news.', 'snazzy-floret' ); ?></p>
					<form class="sf-footer-hero__newsletter-form" action="#" method="post">
						<input type="email" class="sf-footer-hero__newsletter-input" placeholder="<?php esc_attr_e( 'Enter your email', 'snazzy-floret' ); ?>" required>
						<button type="submit" class="sf-footer-hero__newsletter-btn" aria-label="<?php esc_attr_e( 'Subscribe', 'snazzy-floret' ); ?>">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
						</button>
					</form>
				</div>
			</div>
		</div>

		<!-- Footer Links -->
		<div class="sf-footer__main">
			<div class="sf-container sf-footer__grid">

				<!-- Column 1 -->
				<div class="sf-footer__col">
					<h3 class="sf-footer__title"><?php esc_html_e( 'Shop', 'snazzy-floret' ); ?></h3>
					<ul class="sf-footer__links">
						<li><a href="<?php echo esc_url( home_url( '/product-category/digital-prints/' ) ); ?>"><?php esc_html_e( 'Digital Prints', 'snazzy-floret' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/handmade/' ) ); ?>"><?php esc_html_e( 'Handmade', 'snazzy-floret' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/saree/' ) ); ?>"><?php esc_html_e( 'Saree', 'snazzy-floret' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/party-wear/' ) ); ?>"><?php esc_html_e( 'Party wear', 'snazzy-floret' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/regular-wear/' ) ); ?>"><?php esc_html_e( 'Regular wear', 'snazzy-floret' ); ?></a></li>
					</ul>
				</div>

				<!-- Column 2 -->
				<div class="sf-footer__col">
					<h3 class="sf-footer__title"><?php esc_html_e( 'Customer Care', 'snazzy-floret' ); ?></h3>
					<ul class="sf-footer__links">
						<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'FAQ', 'snazzy-floret' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/shipping/' ) ); ?>"><?php esc_html_e( 'Shipping', 'snazzy-floret' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'snazzy-floret' ); ?></a></li>
					</ul>
				</div>

				<!-- Column 3 -->
				<div class="sf-footer__col">
					<h3 class="sf-footer__title"><?php esc_html_e( 'Information', 'snazzy-floret' ); ?></h3>
					<ul class="sf-footer__links">
						<li><a href="<?php echo esc_url( home_url( '/returns-refunds/' ) ); ?>"><?php esc_html_e( 'Returns & Refunds', 'snazzy-floret' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy policy', 'snazzy-floret' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About us', 'snazzy-floret' ); ?></a></li>
					</ul>
				</div>

				<!-- Column 4: Contact -->
				<div class="sf-footer__col">
					<h3 class="sf-footer__title"><?php esc_html_e( 'Get in Touch', 'snazzy-floret' ); ?></h3>
					<ul class="sf-footer__links">
						<li>
							<a href="tel:+8801621008533">
								<svg class="sf-footer__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"/></svg>
								+880 1621-008533
							</a>
						</li>
						<li>
							<a href="mailto:snazzyfloret@gmail.com">
								<svg class="sf-footer__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
								snazzyfloret@gmail.com
							</a>
						</li>
					</ul>
					<div class="sf-footer__socials">
						<a href="https://www.facebook.com/snazzyfloret" target="_blank" rel="noopener noreferrer" class="sf-footer__social" aria-label="<?php esc_attr_e( 'Facebook', 'snazzy-floret' ); ?>">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
						</a>
						<a href="https://www.instagram.com/snazzyfloret" target="_blank" rel="noopener noreferrer" class="sf-footer__social" aria-label="<?php esc_attr_e( 'Instagram', 'snazzy-floret' ); ?>">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
						</a>
						<a href="https://wa.me/8801621008533" target="_blank" rel="noopener noreferrer" class="sf-footer__social" aria-label="<?php esc_attr_e( 'WhatsApp', 'snazzy-floret' ); ?>">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
						</a>
					</div>
				</div>

			</div>

			<!-- Watermark Brand Name — continuous right-to-left marquee -->
			<div class="sf-footer__watermark" aria-hidden="true">
				<div class="sf-footer__watermark-track">
					<span class="sf-footer__watermark-item"><?php echo esc_html( strtoupper( get_bloginfo( 'name' ) ) ); ?></span>
					<span class="sf-footer__watermark-item"><?php echo esc_html( strtoupper( get_bloginfo( 'name' ) ) ); ?></span>
				</div>
			</div>
		</div>

		<!-- Footer Bottom -->
		<div class="sf-footer__bottom">
			<div class="sf-container sf-footer__bottom-inner">
				<p class="sf-footer__copyright">
					&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'snazzy-floret' ); ?>
				</p>
			</div>
		</div>

	</footer>

	<!-- Back to Top -->
	<button class="sf-back-to-top" id="sf-back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'snazzy-floret' ); ?>">
		<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<polyline points="18 15 12 9 6 15"/>
		</svg>
	</button>

</div><!-- .sf-site -->

<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<!-- Mini Cart Drawer -->
<div class="sf-cart-drawer" id="sf-cart-drawer" aria-hidden="true">
	<div class="sf-cart-drawer__overlay"></div>
	<div class="sf-cart-drawer__panel">

		<!-- Header -->
		<div class="sf-cart-drawer__header">
			<h3 class="sf-cart-drawer__title">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
				<?php esc_html_e( 'Your Cart', 'snazzy-floret' ); ?>
				<span class="sf-cart-drawer__count" id="sf-drawer-count">(<?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>)</span>
			</h3>
			<button class="sf-cart-drawer__close" id="sf-cart-drawer-close" aria-label="<?php esc_attr_e( 'Close cart', 'snazzy-floret' ); ?>">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
			</button>
		</div>

		<!-- Body (items or empty state) -->
		<div class="sf-cart-drawer__body" id="sf-cart-drawer-body">
			<?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
				<!-- Cart items -->
				<div class="sf-cart-drawer__items">
					<?php foreach ( WC()->cart->get_cart() as $cart_key => $cart_item ) :
						$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_key );
						if ( ! $_product || ! $_product->exists() ) { continue; }
						$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_key );
						$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_key );
						$product_qty   = $cart_item['quantity'];
						$product_link  = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';
						$thumb_id      = $_product->get_image_id();
					?>
					<div class="sf-cart-drawer__item" data-cart-key="<?php echo esc_attr( $cart_key ); ?>">
						<div class="sf-cart-drawer__item-img">
							<?php if ( $thumb_id ) : ?>
								<?php echo wp_get_attachment_image( $thumb_id, 'thumbnail' ); ?>
							<?php else : ?>
								<img src="<?php echo esc_url( wc_placeholder_img_src( 'thumbnail' ) ); ?>" alt="">
							<?php endif; ?>
						</div>
						<div class="sf-cart-drawer__item-info">
							<?php if ( $product_link ) : ?>
								<a href="<?php echo esc_url( $product_link ); ?>" class="sf-cart-drawer__item-name"><?php echo esc_html( wp_trim_words( $product_name, 5 ) ); ?></a>
							<?php else : ?>
								<span class="sf-cart-drawer__item-name"><?php echo esc_html( wp_trim_words( $product_name, 5 ) ); ?></span>
							<?php endif; ?>
							<span class="sf-cart-drawer__item-meta"><?php echo wp_kses_post( $product_price ); ?> &times; <?php echo esc_html( $product_qty ); ?></span>
						</div>
						<button class="sf-cart-drawer__item-remove" data-cart-key="<?php echo esc_attr( $cart_key ); ?>" aria-label="<?php esc_attr_e( 'Remove item', 'snazzy-floret' ); ?>">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
						</button>
					</div>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<!-- Empty state -->
				<div class="sf-cart-drawer__empty">
					<svg class="sf-cart-drawer__empty-icon" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
						<path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
						<line x1="3" y1="6" x2="21" y2="6"/>
						<path d="M16 10a4 4 0 01-8 0"/>
					</svg>
					<p class="sf-cart-drawer__empty-text"><?php esc_html_e( 'Your cart is empty', 'snazzy-floret' ); ?></p>
					<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="sf-btn sf-btn--primary sf-cart-drawer__shop-btn">
						<?php esc_html_e( 'Start Shopping', 'snazzy-floret' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<!-- Footer -->
		<?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
		<div class="sf-cart-drawer__footer" id="sf-cart-drawer-footer">
			<div class="sf-cart-drawer__subtotal">
				<span><?php esc_html_e( 'Subtotal', 'snazzy-floret' ); ?></span>
				<span class="sf-cart-drawer__subtotal-val" id="sf-drawer-subtotal"><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></span>
			</div>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="sf-btn sf-btn--primary sf-btn--full sf-cart-drawer__view-btn">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
				<?php esc_html_e( 'View Cart', 'snazzy-floret' ); ?>
			</a>
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="sf-btn sf-btn--brand sf-btn--full sf-cart-drawer__checkout-btn">
				<?php esc_html_e( 'Checkout', 'snazzy-floret' ); ?>
			</a>
		</div>
		<?php endif; ?>

	</div>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
