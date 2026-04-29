/**
 * Snazzy Floret — Cart row size editor
 * Opens a popover with the same pill UI as the PDP and updates the cart line
 * via AJAX.
 */
(function () {
	'use strict';

	var openPop = null;

	function buildPop(wrap) {
		var available = JSON.parse(wrap.getAttribute('data-available') || '[]');
		var all = JSON.parse(wrap.getAttribute('data-all') || '[]');
		var current = parseInt(wrap.getAttribute('data-current'), 10);
		var nonce = wrap.getAttribute('data-nonce');
		var key = wrap.getAttribute('data-key');

		var pop = document.createElement('div');
		pop.className = 'sf-cart-size-pop';
		pop.innerHTML =
			'<div class="sf-cart-size-pop__head">' +
				'<span class="sf-cart-size-pop__title">Choose a size</span>' +
				'<button type="button" class="sf-cart-size-pop__close" aria-label="Close">' +
					'<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></svg>' +
				'</button>' +
			'</div>' +
			'<div class="sf-cart-size-pop__grid"></div>';

		var grid = pop.querySelector('.sf-cart-size-pop__grid');
		all.forEach(function (size) {
			var btn = document.createElement('button');
			btn.type = 'button';
			var isAvailable = available.indexOf(size) !== -1;
			btn.className = 'sf-cart-size-pop__pill' + (isAvailable ? '' : ' sf-cart-size-pop__pill--unavailable') + (size === current ? ' is-current' : '');
			if (!isAvailable) {
				btn.setAttribute('data-tooltip', sfCartEdit.tooltip);
				btn.setAttribute('aria-disabled', 'true');
				btn.innerHTML =
					'<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></svg>' +
					'<span class="sf-cart-size-pop__pill-num">' + size + '</span>';
			} else {
				btn.textContent = size;
				btn.addEventListener('click', function () {
					if (size === current) { closePop(); return; }
					updateSize(wrap, key, size, nonce, pop);
				});
			}
			grid.appendChild(btn);
		});

		pop.querySelector('.sf-cart-size-pop__close').addEventListener('click', closePop);

		wrap.appendChild(pop);
		// Force reflow then add open class for transition
		void pop.offsetHeight;
		pop.classList.add('is-open');
		return pop;
	}

	function closePop() {
		if (!openPop) return;
		openPop.classList.remove('is-open');
		var p = openPop;
		setTimeout(function () { if (p && p.parentNode) p.parentNode.removeChild(p); }, 220);
		openPop = null;
	}

	function updateSize(wrap, key, size, nonce, pop) {
		pop.classList.add('is-loading');
		var fd = new FormData();
		fd.append('action', 'sf_update_cart_item_size');
		fd.append('nonce', nonce);
		fd.append('cart_key', key);
		fd.append('size', size);
		fetch(sfCartEdit.ajax, { method: 'POST', body: fd, credentials: 'same-origin' })
			.then(function (r) { return r.json(); })
			.then(function (j) {
				if (j && j.success) {
					window.location.reload();
				} else {
					pop.classList.remove('is-loading');
					alert((j && j.data) ? j.data : 'Could not update size.');
				}
			})
			.catch(function () {
				pop.classList.remove('is-loading');
				alert('Network error.');
			});
	}

	function enhanceQuantityInputs() {
		document.querySelectorAll('.woocommerce-cart .product-quantity .quantity').forEach(function (wrap) {
			if (wrap.classList.contains('sf-qty-enhanced')) return;
			var input = wrap.querySelector('input.qty');
			if (!input) return;
			wrap.classList.add('sf-qty-enhanced');

			var minus = document.createElement('button');
			minus.type = 'button';
			minus.className = 'sf-qty-step sf-qty-step--minus';
			minus.setAttribute('aria-label', 'Decrease');
			minus.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>';

			var plus = document.createElement('button');
			plus.type = 'button';
			plus.className = 'sf-qty-step sf-qty-step--plus';
			plus.setAttribute('aria-label', 'Increase');
			plus.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';

			wrap.insertBefore(minus, input);
			wrap.appendChild(plus);

			function commit() {
				input.dispatchEvent(new Event('change', { bubbles: true }));
				var update = document.querySelector('button[name="update_cart"]');
				if (update) {
					update.disabled = false;
					update.removeAttribute('aria-disabled');
					update.click();
				}
			}

			minus.addEventListener('click', function () {
				var min = parseInt(input.getAttribute('min'), 10) || 0;
				var v = parseInt(input.value, 10) || 0;
				if (v > min) { input.value = v - 1; commit(); }
			});
			plus.addEventListener('click', function () {
				var max = parseInt(input.getAttribute('max'), 10);
				var v = parseInt(input.value, 10) || 0;
				if (isNaN(max) || v < max) { input.value = v + 1; commit(); }
			});
		});
	}

	function relocateEditWraps() {
		document.querySelectorAll('.woocommerce-cart .product-name .sf-cart-size-edit').forEach(function (wrap) {
			var row = wrap.closest('tr.cart_item, tr.woocommerce-cart-form__cart-item');
			if (!row) return;
			var dds = row.querySelectorAll('.product-name dl.variation dd');
			// Find the dd that follows the "Size" dt
			var dts = row.querySelectorAll('.product-name dl.variation dt');
			var target = null;
			dts.forEach(function (dt, i) {
				if (/size/i.test(dt.textContent) && dds[i]) target = dds[i];
			});
			if (target) target.appendChild(wrap);
		});
	}

	var ICON_EDIT = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>';
	var ICON_CLOSE = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></svg>';

	function buildShippingEdit() {
		var label = document.querySelector('.cart_totals .woocommerce-shipping-methods li label');
		var calc = document.querySelector('.cart_totals .shipping-calculator-form');
		var trigger = document.querySelector('.cart_totals .shipping-calculator-button');
		var destination = document.querySelector('.cart_totals .woocommerce-shipping-destination');
		var cartForm = document.querySelector('.woocommerce-cart-form');
		if (!label || !calc || !cartForm) return;
		if (label.querySelector('.sf-ship-edit-btn')) return;

		// Hide native trigger
		if (trigger) trigger.style.display = 'none';

		// Show formatted address by default near the rate label
		if (destination) {
			destination.style.display = 'block';
		}

		// Edit button next to label
		var btn = document.createElement('button');
		btn.type = 'button';
		btn.className = 'sf-ship-edit-btn';
		btn.setAttribute('aria-label', 'Edit shipping address');
		btn.innerHTML = ICON_EDIT;
		label.appendChild(btn);

		// Build inline panel (lives inside .woocommerce-cart-form, replaces the items)
		var panel = document.createElement('div');
		panel.className = 'sf-ship-panel';
		panel.innerHTML =
			'<div class="sf-ship-panel__head">' +
				'<span class="sf-ship-panel__title">Edit shipping address</span>' +
			'</div>' +
			'<div class="sf-ship-panel__body"></div>';
		panel.querySelector('.sf-ship-panel__body').appendChild(calc);
		calc.style.display = 'block';
		cartForm.appendChild(panel);

		function open() {
			cartForm.classList.add('sf-cart-editing');
			btn.innerHTML = ICON_CLOSE;
			btn.setAttribute('aria-label', 'Close shipping editor');
		}
		function close() {
			cartForm.classList.remove('sf-cart-editing');
			btn.innerHTML = ICON_EDIT;
			btn.setAttribute('aria-label', 'Edit shipping address');
		}

		btn.addEventListener('click', function (e) {
			e.preventDefault();
			if (cartForm.classList.contains('sf-cart-editing')) close(); else open();
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') close();
		});
	}

	function init() {
		enhanceQuantityInputs();
		relocateEditWraps();
		buildShippingEdit();
		document.querySelectorAll('.sf-cart-size-edit').forEach(function (wrap) {
			var btn = wrap.querySelector('.sf-cart-size-edit__btn');
			if (!btn) return;
			btn.addEventListener('click', function (e) {
				e.stopPropagation();
				if (openPop && openPop.parentNode === wrap) { closePop(); return; }
				closePop();
				openPop = buildPop(wrap);
			});
		});

		document.addEventListener('click', function (e) {
			if (!openPop) return;
			if (!openPop.contains(e.target) && !e.target.closest('.sf-cart-size-edit__btn')) {
				closePop();
			}
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') closePop();
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
