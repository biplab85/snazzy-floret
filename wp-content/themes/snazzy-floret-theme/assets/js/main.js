/**
 * Snazzy Floret - Main JavaScript (Premium)
 */
(function () {
	'use strict';

	/* ---------- Hero Slider (Cinematic Fade) ---------- */
	var heroSwiperEl = document.getElementById('sf-hero-swiper');
	if (heroSwiperEl && typeof Swiper !== 'undefined') {
		var heroSection = document.getElementById('sf-hero');
		var HERO_DURATION = heroSection ? parseInt(heroSection.dataset.speed, 10) || 5000 : 5000;

		/* Counter elements */
		var counterEl = document.getElementById('sf-hero-counter');
		var progressEl = document.getElementById('sf-hero-progress');
		var currentEl = document.getElementById('sf-hero-current');
		var totalSlides = counterEl ? parseInt(counterEl.dataset.total, 10) : 0;
		var CIRCUMFERENCE = 2 * Math.PI * 27; /* r=27 → ~169.646 */
		var FULL_DURATION = HERO_DURATION + 1200; /* delay + transition speed */

		function resetProgress() {
			if (!progressEl) return;
			/* Reset: jump to empty */
			progressEl.classList.remove('is-animating');
			progressEl.style.strokeDashoffset = CIRCUMFERENCE;
			/* Force reflow so the reset takes effect before the animation starts */
			progressEl.getBoundingClientRect();
			/* Animate to full */
			progressEl.style.transitionDuration = FULL_DURATION + 'ms';
			progressEl.classList.add('is-animating');
			progressEl.style.strokeDashoffset = '0';
		}

		function updateCounter(swiper) {
			if (!currentEl || !totalSlides) return;
			currentEl.textContent = swiper.realIndex + 1;
		}

		var heroSwiper = new Swiper('#sf-hero-swiper', {
			effect: 'fade',
			fadeEffect: { crossFade: true },
			loop: true,
			speed: 1200,
			autoplay: {
				delay: HERO_DURATION,
				disableOnInteraction: false,
			},
			pagination: {
				el: '.sf-hero2__pagination',
				clickable: true,
			},
			navigation: {
				nextEl: '.sf-hero2__next',
				prevEl: '.sf-hero2__prev',
			},
			on: {
				init: function () {
					updateCounter(this);
					resetProgress();
				},
				slideChange: function () {
					updateCounter(this);
					resetProgress();
				},
			},
		});
	}

	/* ---------- Announcement Bar Close ---------- */
	var announcement = document.getElementById('sf-announcement');
	if (announcement) {
		var closeBtn = announcement.querySelector('.sf-announcement__close');
		if (closeBtn) {
			closeBtn.addEventListener('click', function () {
				announcement.classList.add('is-hidden');
				sessionStorage.setItem('sf_announcement_closed', '1');
			});
		}
		if (sessionStorage.getItem('sf_announcement_closed') === '1') {
			announcement.classList.add('is-hidden');
		}
	}

	/* ---------- Header Scroll Effect ---------- */
	var header = document.getElementById('sf-header');
	if (header) {
		window.addEventListener('scroll', function () {
			if (window.pageYOffset > 50) {
				header.classList.add('is-scrolled');
			} else {
				header.classList.remove('is-scrolled');
			}
		}, { passive: true });
	}

	/* ---------- Mobile Menu Drawer ---------- */
	var menuToggle = document.getElementById('sf-menu-toggle');
	var drawer = document.getElementById('sf-mobile-drawer');

	if (menuToggle && drawer) {
		var overlay = drawer.querySelector('.sf-mobile-drawer__overlay');
		var drawerClose = drawer.querySelector('.sf-mobile-drawer__close');

		function openDrawer() {
			drawer.classList.add('is-active');
			drawer.setAttribute('aria-hidden', 'false');
			menuToggle.setAttribute('aria-expanded', 'true');
			document.body.classList.add('sf-drawer-open');
		}

		function closeDrawer() {
			drawer.classList.remove('is-active');
			drawer.setAttribute('aria-hidden', 'true');
			menuToggle.setAttribute('aria-expanded', 'false');
			document.body.classList.remove('sf-drawer-open');
		}

		menuToggle.addEventListener('click', openDrawer);
		if (drawerClose) drawerClose.addEventListener('click', closeDrawer);
		if (overlay) overlay.addEventListener('click', closeDrawer);

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && drawer.classList.contains('is-active')) {
				closeDrawer();
			}
		});
	}

	/* ---------- Search Overlay ---------- */
	var searchToggle = document.querySelector('.sf-header__search-toggle');
	var searchOverlay = document.getElementById('sf-search-overlay');

	if (searchToggle && searchOverlay) {
		searchToggle.addEventListener('click', function () {
			var isActive = searchOverlay.classList.contains('is-active');
			searchOverlay.classList.toggle('is-active');
			searchOverlay.setAttribute('aria-hidden', isActive ? 'true' : 'false');
			if (!isActive) {
				searchOverlay.querySelector('.sf-search-form__input').focus();
			}
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && searchOverlay.classList.contains('is-active')) {
				searchOverlay.classList.remove('is-active');
				searchOverlay.setAttribute('aria-hidden', 'true');
			}
		});
	}

	/* ---------- Back to Top ---------- */
	var backToTop = document.getElementById('sf-back-to-top');
	if (backToTop) {
		window.addEventListener('scroll', function () {
			if (window.pageYOffset > 400) {
				backToTop.classList.add('is-visible');
			} else {
				backToTop.classList.remove('is-visible');
			}
		}, { passive: true });

		backToTop.addEventListener('click', function () {
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	}

	/* ---------- Featured Products Infinite Slider ---------- */
	var featuredSlider = document.getElementById('sf-featured-slider');
	var featuredTrack = document.getElementById('sf-featured-track');

	if (featuredSlider && featuredTrack) {
		var slides = featuredTrack.querySelectorAll('.sf-featured-slider__slide');
		var totalSlides = slides.length;
		var halfCount = totalSlides / 2;

		if (halfCount > 0) {
			// Calculate the width of the first half (original items)
			function getHalfWidth() {
				var width = 0;
				for (var i = 0; i < halfCount; i++) {
					width += slides[i].offsetWidth + 20; // 20px gap
				}
				return width;
			}

			var halfWidth = getHalfWidth();
			var speed = 40; // pixels per second
			var duration = halfWidth / speed;

			// Create the keyframe animation dynamically
			var styleSheet = document.createElement('style');
			styleSheet.textContent = '@keyframes sf-slide-left { 0% { transform: translateX(0); } 100% { transform: translateX(-' + halfWidth + 'px); } }';
			document.head.appendChild(styleSheet);

			featuredTrack.style.animationDuration = duration + 's';
			featuredSlider.classList.add('is-animating');

			// Recalculate on resize
			var resizeTimer;
			window.addEventListener('resize', function () {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function () {
					halfWidth = getHalfWidth();
					duration = halfWidth / speed;
					styleSheet.textContent = '@keyframes sf-slide-left { 0% { transform: translateX(0); } 100% { transform: translateX(-' + halfWidth + 'px); } }';
					featuredTrack.style.animationDuration = duration + 's';
				}, 200);
			});
		}
	}

	/* ---------- Collection Banner Swiper (Fade) ---------- */
	var cbSwiperEl = document.getElementById('sf-cb-swiper');
	if (cbSwiperEl && typeof Swiper !== 'undefined') {
		new Swiper('#sf-cb-swiper', {
			effect: 'fade',
			fadeEffect: { crossFade: true },
			loop: true,
			speed: 1200,
			autoplay: {
				delay: 4000,
				disableOnInteraction: false,
			},
		});
	}

	/* ---------- Offer Countdown Timer ---------- */
	var countdownEl = document.getElementById('sf-offer-countdown');
	if (countdownEl) {
		var endDate = new Date(countdownEl.dataset.end).getTime();
		var daysEl = document.getElementById('sf-cd-days');
		var hoursEl = document.getElementById('sf-cd-hours');
		var minsEl = document.getElementById('sf-cd-mins');
		var secsEl = document.getElementById('sf-cd-secs');

		function pad(n) { return n < 10 ? '0' + n : n; }

		function updateCountdown() {
			var now = Date.now();
			var diff = endDate - now;
			if (diff <= 0) {
				daysEl.textContent = '00';
				hoursEl.textContent = '00';
				minsEl.textContent = '00';
				secsEl.textContent = '00';
				return;
			}
			var d = Math.floor(diff / 86400000);
			var h = Math.floor((diff % 86400000) / 3600000);
			var m = Math.floor((diff % 3600000) / 60000);
			var s = Math.floor((diff % 60000) / 1000);
			daysEl.textContent = pad(d);
			hoursEl.textContent = pad(h);
			minsEl.textContent = pad(m);
			secsEl.textContent = pad(s);
		}

		updateCountdown();
		setInterval(updateCountdown, 1000);
	}

	/* ---------- Quick View Modal ---------- */
	var qvModal = document.getElementById('sf-quick-view-modal');
	var qvContent = document.getElementById('sf-qv-content');

	if (qvModal && qvContent) {
		var qvOverlay = qvModal.querySelector('.sf-qv__overlay');
		var qvClose = qvModal.querySelector('.sf-qv__close');

		function openQuickView(productId) {
			qvModal.classList.add('is-active');
			qvModal.setAttribute('aria-hidden', 'false');
			document.body.style.overflow = 'hidden';

			// Show loading
			qvContent.innerHTML = '<div class="sf-qv__loading"><div class="sf-qv__spinner"></div></div>';

			// Fetch product data
			var formData = new FormData();
			formData.append('action', 'sf_quick_view');
			formData.append('product_id', productId);
			formData.append('nonce', typeof sf_ajax !== 'undefined' ? sf_ajax.nonce : '');

			fetch(typeof sf_ajax !== 'undefined' ? sf_ajax.ajax_url : '/wp-admin/admin-ajax.php', {
				method: 'POST',
				body: formData,
			})
				.then(function (res) { return res.json(); })
				.then(function (data) {
					if (data.success) {
						qvContent.innerHTML = data.data.html;
						initQvThumbs();
					} else {
						qvContent.innerHTML = '<div class="sf-qv__loading"><p>Could not load product.</p></div>';
					}
				})
				.catch(function () {
					qvContent.innerHTML = '<div class="sf-qv__loading"><p>Could not load product.</p></div>';
				});
		}

		function closeQuickView() {
			qvModal.classList.remove('is-active');
			qvModal.setAttribute('aria-hidden', 'true');
			document.body.style.overflow = '';
		}

		function initQvThumbs() {
			var thumbs = qvContent.querySelectorAll('.sf-qv__thumb');
			var mainImg = qvContent.querySelector('.sf-qv__img');
			if (!mainImg || thumbs.length === 0) return;

			thumbs.forEach(function (thumb) {
				thumb.addEventListener('click', function () {
					thumbs.forEach(function (t) { t.classList.remove('is-active'); });
					thumb.classList.add('is-active');
					mainImg.src = thumb.dataset.img;
				});
			});
		}

		// Delegate click on quick view buttons
		document.addEventListener('click', function (e) {
			var btn = e.target.closest('.sf-quick-view-btn');
			if (btn) {
				e.preventDefault();
				e.stopPropagation();
				openQuickView(btn.dataset.productId);
			}
		});

		// AJAX add to cart from quick view
		document.addEventListener('click', function (e) {
			var btn = e.target.closest('.sf-qv__add-btn');
			if (btn) {
				e.preventDefault();
				var productId = btn.dataset.product_id;
				if (!productId) return;

				btn.style.opacity = '0.6';
				btn.style.pointerEvents = 'none';

				var formData = new FormData();
				formData.append('action', 'sf_add_to_cart');
				formData.append('product_id', productId);
				formData.append('quantity', 1);
				formData.append('nonce', typeof sf_ajax !== 'undefined' ? sf_ajax.nonce : '');

				fetch(typeof sf_ajax !== 'undefined' ? sf_ajax.ajax_url : '/wp-admin/admin-ajax.php', {
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
						btn.textContent = 'Added!';
						setTimeout(function () {
							closeQuickView();
						}, 800);
					})
					.catch(function () {
						btn.style.opacity = '1';
						btn.style.pointerEvents = '';
					});
			}
		});

		if (qvClose) qvClose.addEventListener('click', closeQuickView);
		if (qvOverlay) qvOverlay.addEventListener('click', closeQuickView);

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && qvModal.classList.contains('is-active')) {
				closeQuickView();
			}
		});
	}

	/* ---------- Scroll Reveal Animation ---------- */
	var revealElements = document.querySelectorAll('.sf-reveal');
	if (revealElements.length > 0 && 'IntersectionObserver' in window) {
		var revealObserver = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					revealObserver.unobserve(entry.target);
				}
			});
		}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

		revealElements.forEach(function (el) {
			revealObserver.observe(el);
		});
	}

})();
