<?php
/**
 * Single Product Page — Custom Layout.
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

get_header();

global $product;
?>

</main>
<main class="sf-main">
<div class="sf-container sf-single-product">

<?php while ( have_posts() ) : the_post(); ?>

	<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'sf-product-detail', $product ); ?>>

		<!-- ===== LEFT: Product Images ===== -->
		<div class="sf-product-detail__gallery">
			<?php
			$image_id    = $product->get_image_id();
			$gallery_ids = $product->get_gallery_image_ids();
			$sf_all_ids  = array();
			if ( $image_id ) {
				$sf_all_ids[] = $image_id;
			}
			if ( ! empty( $gallery_ids ) ) {
				$sf_all_ids = array_merge( $sf_all_ids, $gallery_ids );
			}
			$sf_all_ids  = array_slice( array_values( array_unique( $sf_all_ids ) ), 0, 6 );
			$sf_fb_group = 'sf-pdp-' . $product->get_id();
			?>
			<div class="sf-pdp-gallery">
				<?php if ( ! empty( $sf_all_ids ) ) : ?>
					<?php foreach ( $sf_all_ids as $sf_gid ) : ?>
						<a href="<?php echo esc_url( wp_get_attachment_image_url( $sf_gid, 'full' ) ); ?>" data-fancybox="<?php echo esc_attr( $sf_fb_group ); ?>" class="sf-pdp-gallery__item">
							<?php echo wp_get_attachment_image( $sf_gid, 'large', false, array( 'class' => 'sf-pdp-gallery__img' ) ); ?>
						</a>
					<?php endforeach; ?>
				<?php else : ?>
					<a href="<?php echo esc_url( wc_placeholder_img_src( 'large' ) ); ?>" data-fancybox="<?php echo esc_attr( $sf_fb_group ); ?>" class="sf-pdp-gallery__item">
						<img src="<?php echo esc_url( wc_placeholder_img_src( 'large' ) ); ?>" alt="" class="sf-pdp-gallery__img">
					</a>
				<?php endif; ?>
			</div>
		</div>

		<!-- ===== RIGHT: Product Info ===== -->
		<div class="sf-product-detail__info">

			<!-- Category -->
			<?php
			$terms = get_the_terms( $product->get_id(), 'product_cat' );
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
			?>
				<a href="<?php echo esc_url( get_term_link( $terms[0] ) ); ?>" class="sf-pdp__category"><?php echo esc_html( $terms[0]->name ); ?></a>
			<?php endif; ?>

			<!-- Product Name -->
			<h1 class="sf-pdp__title"><?php the_title(); ?></h1>

			<!-- Price -->
			<div class="sf-pdp__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>


			<!-- Size Selector — always show 35-42; unavailable sizes styled as disabled -->
			<?php
			$available_sizes = sf_get_available_sizes( $product->get_id() );
			$all_sizes       = range( 35, 42 );
			$has_any         = ! empty( $available_sizes );
			?>
			<div class="sf-pdp__size-wrap<?php echo $has_any ? '' : ' sf-pdp__size-wrap--empty'; ?>">
				<label class="sf-pdp__field-label"><?php esc_html_e( 'Size', 'snazzy-floret' ); ?></label>
				<?php if ( ! $has_any ) : ?>
					<span class="sf-pdp__size-status"><?php esc_html_e( 'Out of stock', 'snazzy-floret' ); ?></span>
				<?php endif; ?>
				<div class="sf-pdp__size-options" role="radiogroup" aria-label="<?php esc_attr_e( 'Select a size', 'snazzy-floret' ); ?>">
					<?php foreach ( $all_sizes as $size ) :
						$is_available = in_array( $size, $available_sizes, true );
					?>
						<button
							type="button"
							class="sf-pdp__size-pill<?php echo $is_available ? '' : ' sf-pdp__size-pill--unavailable'; ?>"
							data-value="<?php echo esc_attr( sanitize_title( (string) $size ) ); ?>"
							role="radio"
							aria-checked="false"
							<?php echo $is_available ? '' : 'aria-disabled="true" tabindex="-1"'; ?>
							<?php echo $is_available ? '' : 'data-tooltip="' . esc_attr__( 'This size is out of stock', 'snazzy-floret' ) . '"'; ?>
						>
							<?php if ( $is_available ) : ?>
								<?php echo esc_html( $size ); ?>
							<?php else : ?>
								<svg class="sf-pdp__size-pill__x" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></svg>
								<span class="sf-pdp__size-pill__num"><?php echo esc_html( $size ); ?></span>
							<?php endif; ?>
						</button>
					<?php endforeach; ?>
				</div>
				<select class="sf-pdp__size-select" name="attribute_pa_size">
					<option value=""><?php esc_html_e( 'Select a size', 'snazzy-floret' ); ?></option>
					<?php foreach ( $available_sizes as $size ) : ?>
						<option value="<?php echo esc_attr( sanitize_title( (string) $size ) ); ?>"><?php echo esc_html( $size ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php if ( $has_any ) : ?>
				<div class="sf-pdp-multi" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'sf_add_sizes' ) ); ?>" data-ajax="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" hidden>
					<div class="sf-pdp-multi__head">
						<span class="sf-pdp-multi__title"><?php esc_html_e( 'Selected sizes', 'snazzy-floret' ); ?></span>
						<span class="sf-pdp-multi__total"><span class="sf-pdp-multi__total-num">0</span> <?php esc_html_e( 'items', 'snazzy-floret' ); ?></span>
					</div>
					<ul class="sf-pdp-multi__list" role="list"></ul>
				</div>
				<?php endif; ?>
			</div>
			<script>
			(function(){
				var wrap = document.currentScript.previousElementSibling;
				while(wrap && !wrap.classList.contains('sf-pdp__size-wrap')) wrap = wrap.previousElementSibling;
				if(!wrap) return;
				var pills  = wrap.querySelectorAll('.sf-pdp__size-pill');
				var sel    = wrap.querySelector('.sf-pdp__size-select');
				var multi  = wrap.querySelector('.sf-pdp-multi');
				if(!multi) return;
				var list   = multi.querySelector('.sf-pdp-multi__list');
				var totalNum = multi.querySelector('.sf-pdp-multi__total-num');
				var pid    = multi.getAttribute('data-product-id');
				var nonce  = multi.getAttribute('data-nonce');
				var ajax   = multi.getAttribute('data-ajax');
				var state  = {}; // size -> qty

				function render(){
					list.innerHTML = '';
					var total = 0;
					var keys = Object.keys(state).sort(function(a,b){return a-b;});
					keys.forEach(function(size){
						var qty = state[size];
						total += qty;
						var li = document.createElement('li');
						li.className = 'sf-pdp-multi__row';
						li.innerHTML =
							'<span class="sf-pdp-multi__size">'+size+'</span>' +
							'<div class="sf-pdp-multi__stepper">' +
								'<button type="button" class="sf-pdp-multi__step" data-action="dec" aria-label="Decrease">−</button>' +
								'<span class="sf-pdp-multi__qty">'+qty+'</span>' +
								'<button type="button" class="sf-pdp-multi__step" data-action="inc" aria-label="Increase">+</button>' +
							'</div>' +
							'<button type="button" class="sf-pdp-multi__remove" aria-label="Remove">' +
								'<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></svg>' +
							'</button>';
						li.querySelector('[data-action="dec"]').addEventListener('click', function(){
							if(state[size] > 1){ state[size]--; render(); }
							else { delete state[size]; refreshPills(); render(); }
						});
						li.querySelector('[data-action="inc"]').addEventListener('click', function(){
							state[size]++; render();
						});
						li.querySelector('.sf-pdp-multi__remove').addEventListener('click', function(){
							delete state[size]; refreshPills(); render();
						});
						list.appendChild(li);
					});
					totalNum.textContent = total;
					if(keys.length){ multi.removeAttribute('hidden'); }
					else { multi.setAttribute('hidden',''); }
					if(sel){ sel.value = keys.length ? sel.querySelector('option[value="'+keys[0]+'"]') ? keys[0] : '' : ''; }
				}

				function refreshPills(){
					pills.forEach(function(p){
						var v = parseInt(p.getAttribute('data-value'),10);
						if(state[v]){ p.setAttribute('aria-checked','true'); p.classList.add('is-active'); }
						else { p.setAttribute('aria-checked','false'); p.classList.remove('is-active'); }
					});
				}

				pills.forEach(function(p){
					if(p.classList.contains('sf-pdp__size-pill--unavailable')) return;
					p.addEventListener('click', function(){
						var v = parseInt(p.getAttribute('data-value'),10);
						if(state[v]){ delete state[v]; }
						else { state[v] = 1; }
						refreshPills();
						render();
					});
				});

				// Hijack add-to-cart button. Because this inline script runs
				// during HTML parsing (before the add-to-cart row further down is
				// rendered), attach the listener on DOMContentLoaded so the
				// button is guaranteed to exist.
				function bindAddBtn(){
					var addBtn = document.querySelector('.sf-pdp__add-btn[data-product_id="'+pid+'"]');
					if(!addBtn) return;
					addBtn.addEventListener('click', function(e){
						var keys = Object.keys(state);
						if(!keys.length) return; // fall back to default href (single add)
						e.preventDefault();
						if(addBtn.classList.contains('is-loading')) return;
						addBtn.classList.add('is-loading');
						var items = keys.map(function(s){ return { size: s, qty: state[s] }; });
						var fd = new FormData();
						fd.append('action','sf_add_sizes_to_cart');
						fd.append('nonce',nonce);
						fd.append('product_id',pid);
						fd.append('items',JSON.stringify(items));
						fetch(ajax,{method:'POST',body:fd,credentials:'same-origin'})
							.then(function(r){return r.json();})
							.then(function(j){
								addBtn.classList.remove('is-loading');
								if(j && j.success){
									document.body.dispatchEvent(new Event('wc_fragment_refresh'));
									// Update header cart count if present
									var c = document.querySelector('.sf-header__cart-count, [data-cart-count]');
									if(c && j.data && j.data.count !== undefined) c.textContent = j.data.count;
									multi.classList.add('sf-pdp-multi--success');
									setTimeout(function(){ multi.classList.remove('sf-pdp-multi--success'); },1500);
									// Reset
									state = {};
									refreshPills();
									render();
								} else {
									alert((j && j.data) ? j.data : 'Failed to add to cart');
								}
							})
							.catch(function(){ addBtn.classList.remove('is-loading'); alert('Network error'); });
					});
				}
				if (document.readyState === 'loading') {
					document.addEventListener('DOMContentLoaded', bindAddBtn);
				} else {
					bindAddBtn();
				}
			})();
			</script>

			<!-- Add to Cart -->
			<?php if ( $product->is_in_stock() && $product->is_purchasable() && $has_any ) : ?>
			<div class="sf-pdp__cart-row">
				<div class="sf-pdp__qty">
					<button class="sf-pdp__qty-btn sf-pdp__qty-minus" type="button" aria-label="<?php esc_attr_e( 'Decrease quantity', 'snazzy-floret' ); ?>">−</button>
					<input type="number" class="sf-pdp__qty-input" id="sf-pdp-qty" value="1" min="1" max="<?php echo esc_attr( $product->get_max_purchase_quantity() > 0 ? $product->get_max_purchase_quantity() : 99 ); ?>">
					<button class="sf-pdp__qty-btn sf-pdp__qty-plus" type="button" aria-label="<?php esc_attr_e( 'Increase quantity', 'snazzy-floret' ); ?>">+</button>
				</div>
				<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="sf-pdp__add-btn sf-btn sf-btn--primary" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
					<?php esc_html_e( 'Add to Cart', 'snazzy-floret' ); ?>
				</a>
			</div>
			<?php else : ?>
				<div class="sf-pdp__cart-row">
					<div class="sf-pdp__qty">
						<button class="sf-pdp__qty-btn sf-pdp__qty-minus" type="button" disabled aria-disabled="true">−</button>
						<input type="number" class="sf-pdp__qty-input" value="1" min="1" disabled aria-disabled="true">
						<button class="sf-pdp__qty-btn sf-pdp__qty-plus" type="button" disabled aria-disabled="true">+</button>
					</div>
					<span class="sf-pdp__add-btn sf-btn sf-btn--primary sf-pdp__add-btn--disabled" aria-disabled="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
						<?php esc_html_e( 'Add to Cart', 'snazzy-floret' ); ?>
					</span>
				</div>
			<?php endif; ?>

			<!-- Static benefits -->
			<ul class="sf-pdp__benefits">
				<li><?php esc_html_e( 'Timeless Designs That Never Age', 'snazzy-floret' ); ?></li>
				<li><?php esc_html_e( 'Skin-Friendly &amp; Irritation-Free', 'snazzy-floret' ); ?></li>
				<li><?php esc_html_e( 'Breathable Fabrics for All-Day Comfort', 'snazzy-floret' ); ?></li>
				<li><?php esc_html_e( 'Enhances Natural Body Shape', 'snazzy-floret' ); ?></li>
			</ul>

			<!-- Feature Highlights -->
			<div class="sf-pdp__features">
				<div class="sf-pdp__feature">
					<img width="20" height="20" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/features/Fashionable.png' ); ?>" alt="">
					<span><?php esc_html_e( 'Fashionable', 'snazzy-floret' ); ?></span>
				</div>
				<div class="sf-pdp__feature">
					<img width="20" height="20" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/features/Sustainable.png' ); ?>" alt="">
					<span><?php esc_html_e( 'Sustainable', 'snazzy-floret' ); ?></span>
				</div>
				<div class="sf-pdp__feature">
					<img width="20" height="20" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/features/Recyclable.png' ); ?>" alt="">
					<span><?php esc_html_e( 'Recyclable', 'snazzy-floret' ); ?></span>
				</div>
				<div class="sf-pdp__feature">
					<img width="20" height="20" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/features/Fast Delivery.png' ); ?>" alt="">
					<span><?php esc_html_e( 'Fast delivery', 'snazzy-floret' ); ?></span>
				</div>
			</div>

			<!-- Accordion -->
			<div class="sf-pdp__accordions">
				<div class="sf-pdp__accordion">
					<button class="sf-pdp__accordion-toggle" aria-expanded="false">
						<span><?php esc_html_e( 'Description', 'snazzy-floret' ); ?></span>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
					</button>
					<div class="sf-pdp__accordion-body">
						<?php the_content(); ?>
					</div>
				</div>
				<div class="sf-pdp__accordion">
					<button class="sf-pdp__accordion-toggle" aria-expanded="false">
						<span><?php esc_html_e( 'Size & Guide', 'snazzy-floret' ); ?></span>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
					</button>
					<div class="sf-pdp__accordion-body">
						<?php
						$sf_sg_base  = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/images/size-guide/';
						$sf_sg_items = array(
							array(
								'title' => __( 'Size Correspondence', 'snazzy-floret' ),
								'file'  => 'Size Correspondence.png',
							),
							array(
								'title' => __( 'Measurements for Tops, Sweaters, Jackets & Coats', 'snazzy-floret' ),
								'file'  => 'Measurements for Tops, Sweaters, Jackets & Coats.png',
							),
							array(
								'title' => __( 'Measurements for Pants, Skirts, and Jeans', 'snazzy-floret' ),
								'file'  => 'Measurements for Pants, Skirts, and Jeans.png',
							),
						);
						?>
						<div class="sf-size-guide">
							<?php foreach ( $sf_sg_items as $sf_sg_item ) : ?>
								<figure class="sf-size-guide__item">
									<figcaption class="sf-size-guide__title"><?php echo esc_html( $sf_sg_item['title'] ); ?></figcaption>
									<img
										class="sf-size-guide__image"
										src="<?php echo esc_url( $sf_sg_base . rawurlencode( $sf_sg_item['file'] ) ); ?>"
										alt="<?php echo esc_attr( $sf_sg_item['title'] ); ?>"
										loading="lazy"
									/>
								</figure>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<div class="sf-pdp__accordion">
					<button class="sf-pdp__accordion-toggle" aria-expanded="false">
						<span><?php esc_html_e( 'Delivery & Return', 'snazzy-floret' ); ?></span>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
					</button>
					<div class="sf-pdp__accordion-body">
						<h4><?php esc_html_e( 'Delivery', 'snazzy-floret' ); ?></h4>
						<p><?php esc_html_e( 'Deliveries are guaranteed within these timeframes for any order placed before noon:', 'snazzy-floret' ); ?></p>
						<ul>
							<li><?php esc_html_e( 'Standard home delivery: within 2-3 business days. FREE', 'snazzy-floret' ); ?></li>
							<li><?php esc_html_e( 'Home deliveries take place Monday to Friday, excluding public holidays.', 'snazzy-floret' ); ?></li>
						</ul>
						<h4><?php esc_html_e( 'Return', 'snazzy-floret' ); ?></h4>
						<p><?php esc_html_e( 'You have a period of 14 days from the date of receipt of your order to generate your return label and send back one or more items free of charge by mail (excluding Outlet items).', 'snazzy-floret' ); ?></p>
						<p><?php esc_html_e( 'Any returned item must be new, in its original packaging, and with its label attached.', 'snazzy-floret' ); ?></p>
					</div>
				</div>
				<div class="sf-pdp__accordion">
					<button class="sf-pdp__accordion-toggle" aria-expanded="false">
						<span><?php esc_html_e( 'Payment Method', 'snazzy-floret' ); ?></span>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
					</button>
					<div class="sf-pdp__accordion-body">
						<h4><?php esc_html_e( 'Bank Cards', 'snazzy-floret' ); ?></h4>
						<ul>
							<li><?php esc_html_e( 'Accepted: CB, Visa, MasterCard, American Express', 'snazzy-floret' ); ?></li>
						</ul>
						<h4><?php esc_html_e( 'Apple Pay', 'snazzy-floret' ); ?></h4>
						<ul>
							<li><?php esc_html_e( 'A fast and secure payment method for Apple device users (iPhone, Mac, Apple Watch, iPad).', 'snazzy-floret' ); ?></li>
							<li><?php esc_html_e( 'Once the transaction is validated by our payment provider, the amount of your order will be automatically debited via your Apple Pay account.', 'snazzy-floret' ); ?></li>
						</ul>
						<h4><?php esc_html_e( 'PayPal', 'snazzy-floret' ); ?></h4>
						<ul>
							<li><?php esc_html_e( 'Make your payment online directly through PayPal.', 'snazzy-floret' ); ?></li>
							<li><?php esc_html_e( 'You can choose to pay in one go or in three installments without fees for amounts between €30 and €2,000.', 'snazzy-floret' ); ?></li>
							<li><?php esc_html_e( 'The payment will be divided into four installments: a quarter at the time of purchase, followed by the remaining balance in three monthly payments.', 'snazzy-floret' ); ?></li>
						</ul>
					</div>
				</div>
			</div>

		</div><!-- .sf-product-detail__info -->

	</div><!-- .sf-product-detail -->

	<!-- ===== HANDMADE LUXURY FEATURE SECTION (static) ===== -->
	<?php
	$sf_hl_base = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/images/handmade-luxury/';
	?>
	<section class="sf-handmade-luxury" aria-label="<?php esc_attr_e( 'Handmade Luxury', 'snazzy-floret' ); ?>">
		<div class="sf-handmade-luxury__inner">

			<div class="sf-handmade-luxury__col sf-handmade-luxury__col--left">
				<div class="sf-handmade-luxury__feature">
					<img class="sf-handmade-luxury__icon" src="<?php echo esc_url( $sf_hl_base . rawurlencode( 'Precision Stitching.png' ) ); ?>" alt="" loading="lazy" />
					<h3 class="sf-handmade-luxury__title"><?php esc_html_e( 'Precision Stitching', 'snazzy-floret' ); ?></h3>
					<p class="sf-handmade-luxury__desc"><?php esc_html_e( 'Every seam and detail is crafted with expert stitching techniques for flawless structure and fit.', 'snazzy-floret' ); ?></p>
				</div>

				<div class="sf-handmade-luxury__feature">
					<img class="sf-handmade-luxury__icon" src="<?php echo esc_url( $sf_hl_base . rawurlencode( 'Finishing Details.png' ) ); ?>" alt="" loading="lazy" />
					<h3 class="sf-handmade-luxury__title"><?php esc_html_e( 'Finishing Details', 'snazzy-floret' ); ?></h3>
					<p class="sf-handmade-luxury__desc"><?php esc_html_e( 'Buttons, zippers, lace trims, beads, or embroidery — the small accents that elevate the overall design.', 'snazzy-floret' ); ?></p>
				</div>

				<div class="sf-handmade-luxury__feature">
					<img class="sf-handmade-luxury__icon" src="<?php echo esc_url( $sf_hl_base . rawurlencode( 'Tailored Fit & Silhouette.png' ) ); ?>" alt="" loading="lazy" />
					<h3 class="sf-handmade-luxury__title"><?php esc_html_e( 'Tailored Fit & Silhouette', 'snazzy-floret' ); ?></h3>
					<p class="sf-handmade-luxury__desc"><?php esc_html_e( 'A design perfected to complement the natural body shape, ensuring comfort, confidence, and graceful movement.', 'snazzy-floret' ); ?></p>
				</div>
			</div>

			<div class="sf-handmade-luxury__col sf-handmade-luxury__col--center">
				<img
					class="sf-handmade-luxury__hero"
					src="<?php echo esc_url( $sf_hl_base . rawurlencode( 'center image.png' ) ); ?>"
					alt="<?php esc_attr_e( 'Handmade Luxury', 'snazzy-floret' ); ?>"
					loading="lazy"
				/>
			</div>

			<div class="sf-handmade-luxury__col sf-handmade-luxury__col--right">
				<div class="sf-handmade-luxury__feature">
					<img class="sf-handmade-luxury__icon" src="<?php echo esc_url( $sf_hl_base . rawurlencode( 'Premium Fabric.png' ) ); ?>" alt="" loading="lazy" />
					<h3 class="sf-handmade-luxury__title"><?php esc_html_e( 'Premium Fabric', 'snazzy-floret' ); ?></h3>
					<p class="sf-handmade-luxury__desc"><?php esc_html_e( 'The foundation of every dress — soft, durable, and comfortable fabrics like linen, chiffon, or cotton.', 'snazzy-floret' ); ?></p>
				</div>

				<div class="sf-handmade-luxury__feature">
					<img class="sf-handmade-luxury__icon" src="<?php echo esc_url( $sf_hl_base . rawurlencode( 'High-Quality Threads.png' ) ); ?>" alt="" loading="lazy" />
					<h3 class="sf-handmade-luxury__title"><?php esc_html_e( 'High-Quality Threads', 'snazzy-floret' ); ?></h3>
					<p class="sf-handmade-luxury__desc"><?php esc_html_e( 'Strong, smooth threads that hold every stitch together, ensuring durability, clean finishes.', 'snazzy-floret' ); ?></p>
				</div>

				<div class="sf-handmade-luxury__feature">
					<img class="sf-handmade-luxury__icon" src="<?php echo esc_url( $sf_hl_base . rawurlencode( 'Elegant Color Palettes.png' ) ); ?>" alt="" loading="lazy" />
					<h3 class="sf-handmade-luxury__title"><?php esc_html_e( 'Elegant Color Palettes', 'snazzy-floret' ); ?></h3>
					<p class="sf-handmade-luxury__desc"><?php esc_html_e( 'Thoughtfully selected colors and tones that match the design mood — from classic neutrals to vibrant hues.', 'snazzy-floret' ); ?></p>
				</div>
			</div>

		</div>
	</section>

	<!-- ===== RELATED PRODUCTS ===== -->
	<?php woocommerce_output_related_products(); ?>

<?php endwhile; ?>

</div><!-- .sf-single-product -->

<?php get_footer(); ?>
