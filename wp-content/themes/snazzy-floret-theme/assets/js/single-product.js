/**
 * Snazzy Floret — Single Product Page
 * Gallery thumbnails, quantity control, accordion, AJAX add to cart.
 */
(function () {
	'use strict';

	/* ---------- Fancybox Gallery ---------- */
	if (typeof Fancybox !== 'undefined') {
		Fancybox.bind('[data-fancybox^="sf-pdp-"]', {
			Toolbar: { display: { left: ['infobar'], middle: [], right: ['slideshow', 'thumbs', 'close'] } },
		});
	}

	/* ---------- Quantity +/- ---------- */
	var qtyInput = document.getElementById('sf-pdp-qty');
	var minusBtn = document.querySelector('.sf-pdp__qty-minus');
	var plusBtn  = document.querySelector('.sf-pdp__qty-plus');

	if (qtyInput && minusBtn && plusBtn) {
		var min = parseInt(qtyInput.min, 10) || 1;
		var max = parseInt(qtyInput.max, 10) || 99;

		minusBtn.addEventListener('click', function () {
			var val = parseInt(qtyInput.value, 10) || 1;
			if (val > min) qtyInput.value = val - 1;
		});

		plusBtn.addEventListener('click', function () {
			var val = parseInt(qtyInput.value, 10) || 1;
			if (val < max) qtyInput.value = val + 1;
		});
	}

	/* ---------- Accordion ---------- */
	var accordionToggles = document.querySelectorAll('.sf-pdp__accordion-toggle');
	accordionToggles.forEach(function (toggle) {
		toggle.addEventListener('click', function () {
			var body = toggle.nextElementSibling;
			var isOpen = body.classList.contains('is-open');

			// Close all others
			accordionToggles.forEach(function (t) {
				t.setAttribute('aria-expanded', 'false');
				t.nextElementSibling.classList.remove('is-open');
			});

			// Toggle current
			if (!isOpen) {
				body.classList.add('is-open');
				toggle.setAttribute('aria-expanded', 'true');
			}
		});
	});

	/* ---------- AJAX Add to Cart ---------- */
	var addBtn = document.querySelector('.sf-pdp__add-btn');
	if (addBtn && typeof sf_ajax !== 'undefined') {
		addBtn.addEventListener('click', function (e) {
			// Defer to the dedicated multi-size handler (inline in single-product.php)
			// whenever any size is selected on the PDP.
			var multi = document.querySelector('.sf-pdp-multi');
			if (multi && multi.querySelector('.sf-pdp-multi__row')) {
				return;
			}

			e.preventDefault();

			var productId = addBtn.dataset.product_id;
			var qty = qtyInput ? parseInt(qtyInput.value, 10) || 1 : 1;

			addBtn.style.opacity = '0.6';
			addBtn.style.pointerEvents = 'none';

			var formData = new FormData();
			formData.append('action', 'sf_add_to_cart');
			formData.append('product_id', productId);
			formData.append('quantity', qty);
			formData.append('nonce', sf_ajax.nonce);

			fetch(sf_ajax.ajax_url, {
				method: 'POST',
				body: formData,
			})
				.then(function (res) { return res.json(); })
				.then(function (data) {
					if (data.fragments) {
						Object.keys(data.fragments).forEach(function (key) {
							var el = document.querySelector(key);
							if (el) {
								var temp = document.createElement('div');
								temp.innerHTML = data.fragments[key];
								el.replaceWith(temp.firstElementChild);
							}
						});
					}
					addBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Added!';
					setTimeout(function () {
						addBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg> Add to Cart';
						addBtn.style.opacity = '1';
						addBtn.style.pointerEvents = '';
					}, 1500);
				})
				.catch(function () {
					addBtn.style.opacity = '1';
					addBtn.style.pointerEvents = '';
				});
		});
	}

})();
