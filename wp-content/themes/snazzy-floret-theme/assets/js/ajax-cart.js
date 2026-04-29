/**
 * Snazzy Floret - AJAX Cart + Mini Cart Drawer
 */
(function ($) {
	'use strict';

	if (typeof sf_ajax === 'undefined') return;

	/* Wait for DOM ready so drawer markup (in footer) is available */
	$(function () { sfInitCartDrawer(); });

	function sfInitCartDrawer() {

	var drawer      = document.getElementById('sf-cart-drawer');
	var drawerBody  = document.getElementById('sf-cart-drawer-body');
	var drawerClose = document.getElementById('sf-cart-drawer-close');
	var cartTrigger = document.getElementById('sf-cart-trigger');

	if (!drawer) return;

	var overlay = drawer.querySelector('.sf-cart-drawer__overlay');

	/* ========== Open / Close ========== */

	function openDrawer() {
		drawer.classList.add('is-open');
		drawer.setAttribute('aria-hidden', 'false');
		document.body.classList.add('sf-drawer-open');
		refreshDrawer();
	}

	function closeDrawer() {
		drawer.classList.remove('is-open');
		drawer.setAttribute('aria-hidden', 'true');
		document.body.classList.remove('sf-drawer-open');
	}

	if (cartTrigger) {
		cartTrigger.addEventListener('click', function (e) {
			e.preventDefault();
			openDrawer();
		});
	}

	if (drawerClose) drawerClose.addEventListener('click', closeDrawer);
	if (overlay) overlay.addEventListener('click', closeDrawer);

	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
			closeDrawer();
		}
	});

	/* ========== Refresh Drawer Content via AJAX ========== */

	function refreshDrawer() {
		$.ajax({
			url: sf_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'sf_get_cart_drawer',
				nonce: sf_ajax.nonce,
			},
			success: function (res) {
				if (!res.success) return;
				renderDrawer(res.data);
			},
		});
	}

	function renderDrawer(data) {
		var count = data.count || 0;

		// Update header count
		var drawerCount = document.getElementById('sf-drawer-count');
		if (drawerCount) drawerCount.textContent = '(' + count + ')';

		// Update header badge
		var headerCount = document.querySelector('.sf-header__cart-count');
		if (headerCount) headerCount.textContent = count;

		if (count === 0) {
			// Empty state
			drawerBody.innerHTML =
				'<div class="sf-cart-drawer__empty">' +
					'<svg class="sf-cart-drawer__empty-icon" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">' +
						'<path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>' +
						'<line x1="3" y1="6" x2="21" y2="6"/>' +
						'<path d="M16 10a4 4 0 01-8 0"/>' +
					'</svg>' +
					'<p class="sf-cart-drawer__empty-text">Your cart is empty</p>' +
					'<a href="' + data.shop_url + '" class="sf-btn sf-btn--primary sf-cart-drawer__shop-btn">Start Shopping</a>' +
				'</div>';

			// Remove footer
			var footer = document.getElementById('sf-cart-drawer-footer');
			if (footer) footer.style.display = 'none';
		} else {
			// Build items
			var html = '<div class="sf-cart-drawer__items">';
			data.items.forEach(function (item) {
				var sizeLine = item.size
					? '<span class="sf-cart-drawer__item-size">Size: ' + item.size + '</span>'
					: '';
				html +=
					'<div class="sf-cart-drawer__item" data-cart-key="' + item.key + '">' +
						'<div class="sf-cart-drawer__item-img">' +
							'<img src="' + item.image + '" alt="">' +
						'</div>' +
						'<div class="sf-cart-drawer__item-info">' +
							(item.link
								? '<a href="' + item.link + '" class="sf-cart-drawer__item-name">' + item.name + '</a>'
								: '<span class="sf-cart-drawer__item-name">' + item.name + '</span>') +
							sizeLine +
							'<span class="sf-cart-drawer__item-meta">' + item.price + ' &times; ' + item.qty + '</span>' +
						'</div>' +
						'<button class="sf-cart-drawer__item-remove" data-cart-key="' + item.key + '" aria-label="Remove item">' +
							'<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
						'</button>' +
					'</div>';
			});
			html += '</div>';
			drawerBody.innerHTML = html;

			// Build / show footer
			var footer = document.getElementById('sf-cart-drawer-footer');
			if (footer) {
				footer.style.display = '';
				var subtotalEl = document.getElementById('sf-drawer-subtotal');
				if (subtotalEl) subtotalEl.innerHTML = data.subtotal;
			} else {
				// Create footer if it doesn't exist yet
				var panel = drawer.querySelector('.sf-cart-drawer__panel');
				var footerHtml =
					'<div class="sf-cart-drawer__footer" id="sf-cart-drawer-footer">' +
						'<div class="sf-cart-drawer__subtotal">' +
							'<span>Subtotal</span>' +
							'<span class="sf-cart-drawer__subtotal-val" id="sf-drawer-subtotal">' + data.subtotal + '</span>' +
						'</div>' +
						'<a href="' + data.cart_url + '" class="sf-btn sf-btn--primary sf-btn--full sf-cart-drawer__view-btn">' +
							'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>' +
							'View Cart' +
						'</a>' +
						'<a href="' + data.checkout_url + '" class="sf-btn sf-btn--brand sf-btn--full sf-cart-drawer__checkout-btn">Checkout</a>' +
					'</div>';
				panel.insertAdjacentHTML('beforeend', footerHtml);
			}
		}
	}

	/* ========== Remove Item ========== */

	$(document).on('click', '.sf-cart-drawer__item-remove', function (e) {
		e.preventDefault();
		var $btn  = $(this);
		var $item = $btn.closest('.sf-cart-drawer__item');
		var key   = $btn.data('cart-key');

		$item.css({ opacity: 0.4, pointerEvents: 'none' });

		$.ajax({
			url: sf_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'sf_remove_cart_item',
				cart_key: key,
				nonce: sf_ajax.nonce,
			},
			success: function (res) {
				if (res.fragments) {
					$.each(res.fragments, function (selector, val) {
						$(selector).replaceWith(val);
					});
				}
				refreshDrawer();
			},
			error: function () {
				$item.css({ opacity: 1, pointerEvents: '' });
			},
		});
	});

	/* ========== AJAX Add to Cart (product cards) ========== */

	$(document).on('click', '.sf-card__add-btn', function (e) {
		e.preventDefault();

		var $btn = $(this);
		var productId = $btn.data('product_id');

		if ($btn.hasClass('is-loading')) return;

		var originalHTML = $btn.html();
		$btn.addClass('is-loading');
		$btn.html('<span class="sf-btn-spinner"></span>');

		$.ajax({
			url: sf_ajax.ajax_url,
			type: 'POST',
			data: {
				action: 'sf_add_to_cart',
				product_id: productId,
				quantity: 1,
				nonce: sf_ajax.nonce,
			},
			success: function (response) {
				if (response.fragments) {
					$.each(response.fragments, function (key, value) {
						$(key).replaceWith(value);
					});
				}
				sfShowToast('Product added to cart!', 'success');
			},
			error: function () {
				sfShowToast('Could not add to cart.', 'error');
			},
			complete: function () {
				$btn.html(originalHTML);
				$btn.removeClass('is-loading');
			},
		});
	});

	/* ========== Toast Notification ========== */

	function sfShowToast(message, type) {
		var $existing = $('.sf-toast');
		if ($existing.length) $existing.remove();

		var $toast = $('<div class="sf-toast sf-toast--' + type + '">' + message + '</div>');
		$('body').append($toast);

		setTimeout(function () {
			$toast.addClass('is-active');
		}, 10);

		setTimeout(function () {
			$toast.removeClass('is-active');
			setTimeout(function () {
				$toast.remove();
			}, 300);
		}, 3000);
	}

	} /* end sfInitCartDrawer */

	/* ========== Coupon Apply Button Opacity ========== */
	$(document).on('input', '.wc-block-components-totals-coupon__content input[type="text"]', function () {
		var $btn = $(this).closest('.wc-block-components-totals-coupon__content').find('.wc-block-components-button');
		if ($(this).val().trim().length > 0) {
			$btn.addClass('sf-coupon-active');
		} else {
			$btn.removeClass('sf-coupon-active');
		}
	});

})(jQuery);
