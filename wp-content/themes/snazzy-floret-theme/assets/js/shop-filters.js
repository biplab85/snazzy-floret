/**
 * Snazzy Floret — Shop Filters
 * URL-based filtering: changes checkboxes/price → updates URL → page reloads with filters applied.
 * Also manages active filter chips, mobile drawer, and collapse toggles.
 */
(function () {
	'use strict';

	var filtersPanel = document.getElementById('sf-shop-filters');
	var filterToggle = document.getElementById('sf-filter-toggle');
	var filterClose  = document.getElementById('sf-filters-close');
	var activeWrap   = document.getElementById('sf-active-filters');
	var activeList   = document.getElementById('sf-active-filters-list');
	var clearAllBtn  = document.getElementById('sf-clear-all-filters');
	var resetBtn     = document.getElementById('sf-filter-reset');
	var priceApply   = document.getElementById('sf-price-apply');
	var priceMin     = document.getElementById('sf-price-min');
	var priceMax     = document.getElementById('sf-price-max');

	if (!filtersPanel) return;

	/* ========== URL Helpers ========== */
	function getParams() {
		return new URLSearchParams(window.location.search);
	}

	function setParam(key, value) {
		var params = getParams();
		if (value) {
			params.set(key, value);
		} else {
			params.delete(key);
		}
		params.delete('paged'); // reset to page 1 on filter change
		navigate(params);
	}

	function navigate(params) {
		var qs = params.toString();
		var url = window.location.pathname + (qs ? '?' + qs : '');
		window.location.href = url;
	}

	/* ========== Restore State from URL ========== */
	function restoreState() {
		var params = getParams();

		// Fabric
		var fabrics = params.get('filter_fabric');
		if (fabrics) {
			fabrics.split(',').forEach(function (v) {
				var cb = filtersPanel.querySelector('.sf-filter-check__input[name="fabric"][value="' + v + '"]');
				if (cb) cb.checked = true;
			});
		}

		// Availability
		var avail = params.get('filter_availability');
		if (avail) {
			avail.split(',').forEach(function (v) {
				var cb = filtersPanel.querySelector('.sf-filter-check__input[name="availability"][value="' + v + '"]');
				if (cb) cb.checked = true;
			});
		}

		// Price
		if (params.get('min_price') && priceMin) priceMin.value = params.get('min_price');
		if (params.get('max_price') && priceMax) priceMax.value = params.get('max_price');
	}

	/* ========== Build Active Filter Chips (visual only) ========== */
	function renderChips() {
		if (!activeList || !activeWrap) return;
		activeList.innerHTML = '';
		var hasFilters = false;

		// Checkboxes
		var checked = filtersPanel.querySelectorAll('.sf-filter-check__input:checked');
		checked.forEach(function (input) {
			hasFilters = true;
			var label = input.closest('.sf-filter-check').querySelector('.sf-filter-check__label').textContent;
			var chipLabel = capitalize(input.name) + ': ' + label;
			activeList.appendChild(createChip(chipLabel, function () {
				input.checked = false;
				applyCheckboxFilter(input.name);
			}));
		});

		// Price
		var minVal = priceMin ? priceMin.value.trim() : '';
		var maxVal = priceMax ? priceMax.value.trim() : '';
		if (minVal || maxVal) {
			hasFilters = true;
			var priceLabel = 'Price: ';
			var sym = (typeof sfShopFilters !== 'undefined' && sfShopFilters.currencySymbol) ? sfShopFilters.currencySymbol : '৳';
			if (minVal && maxVal) priceLabel += sym + minVal + ' — ' + sym + maxVal;
			else if (minVal) priceLabel += 'From ' + sym + minVal;
			else priceLabel += 'Up to ' + sym + maxVal;

			activeList.appendChild(createChip(priceLabel, function () {
				if (priceMin) priceMin.value = '';
				if (priceMax) priceMax.value = '';
				applyPriceFilter();
			}));
		}

		activeWrap.style.display = hasFilters ? 'flex' : 'none';
	}

	function createChip(label, onRemove) {
		var chip = document.createElement('span');
		chip.className = 'sf-active-filter-chip';
		chip.innerHTML = label + '<button class="sf-active-filter-chip__remove" aria-label="Remove"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';
		chip.querySelector('.sf-active-filter-chip__remove').addEventListener('click', function (e) {
			e.preventDefault();
			onRemove();
		});
		return chip;
	}

	function capitalize(str) {
		return str.charAt(0).toUpperCase() + str.slice(1);
	}

	/* ========== Apply Filters → URL ========== */
	function applyCheckboxFilter(name) {
		var values = [];
		filtersPanel.querySelectorAll('.sf-filter-check__input[name="' + name + '"]:checked').forEach(function (cb) {
			values.push(cb.value);
		});
		setParam('filter_' + name, values.join(','));
	}

	function applyPriceFilter() {
		var params = getParams();
		var minVal = priceMin ? priceMin.value.trim() : '';
		var maxVal = priceMax ? priceMax.value.trim() : '';

		if (minVal) params.set('min_price', minVal); else params.delete('min_price');
		if (maxVal) params.set('max_price', maxVal); else params.delete('max_price');
		params.delete('paged');
		navigate(params);
	}

	function clearAllFilters() {
		var params = getParams();
		params.delete('filter_fabric');
		params.delete('filter_availability');
		params.delete('min_price');
		params.delete('max_price');
		params.delete('paged');
		// Keep orderby if set
		navigate(params);
	}

	/* ========== Mobile Drawer ========== */
	if (filterToggle) {
		filterToggle.addEventListener('click', function () {
			filtersPanel.classList.add('is-active');
			document.body.style.overflow = 'hidden';
		});
	}
	if (filterClose) {
		filterClose.addEventListener('click', function () {
			filtersPanel.classList.remove('is-active');
			document.body.style.overflow = '';
		});
	}
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && filtersPanel.classList.contains('is-active')) {
			filtersPanel.classList.remove('is-active');
			document.body.style.overflow = '';
		}
	});

	/* ========== Filter Group Toggle ========== */
	filtersPanel.querySelectorAll('.sf-filter-group__toggle').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var body = btn.nextElementSibling;
			var isOpen = body.classList.contains('is-open');
			body.classList.toggle('is-open');
			btn.setAttribute('aria-expanded', !isOpen);
		});
	});

	/* ========== Event Listeners ========== */
	// Checkboxes: navigate on change
	filtersPanel.querySelectorAll('.sf-filter-check__input').forEach(function (cb) {
		cb.addEventListener('change', function () {
			applyCheckboxFilter(cb.name);
		});
	});

	// Price: navigate on apply
	if (priceApply) {
		priceApply.addEventListener('click', function () {
			applyPriceFilter();
		});
	}

	// Clear all
	if (clearAllBtn) clearAllBtn.addEventListener('click', clearAllFilters);
	if (resetBtn) resetBtn.addEventListener('click', clearAllFilters);

	/* ========== Init ========== */
	restoreState();
	renderChips();

})();
