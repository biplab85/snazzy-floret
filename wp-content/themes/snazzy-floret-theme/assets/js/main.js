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

		/* ---------- Hero Title Typewriter ----------
		   Each title is split into character spans that start at display:none,
		   so the caret always sits at the typing position instead of the text
		   reserving its full width up front. The <em> accent word keeps its own
		   element, so its gradient text-fill still applies. */
		var TYPE_SPEED = 42; /* ms per character */
		var TYPE_START_DELAY = 420; /* let the slide's fade settle first */
		var typeTimer = null;
		var reduceMotion =
			window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

		function buildTitle(title) {
			if (title.dataset.twReady === '1') return;

			var fullText = title.textContent.replace(/\s+/g, ' ').trim();
			var chars = [];

			function walk(source, target) {
				Array.prototype.forEach.call(source.childNodes, function (node) {
					if (node.nodeType === 3) {
						/* Collapse the template's newlines/tabs down to single spaces */
						var text = node.textContent.replace(/\s+/g, ' ');
						text.split('').forEach(function (ch) {
							var span = document.createElement('span');
							span.className = 'sf-tw__c';
							span.textContent = ch;
							target.appendChild(span);
							chars.push(span);
						});
					} else if (node.nodeType === 1) {
						var clone = node.cloneNode(false);
						target.appendChild(clone);
						walk(node, clone);
					}
				});
			}

			var holder = document.createElement('span');
			walk(title, holder);

			title.innerHTML = '';
			while (holder.firstChild) {
				title.appendChild(holder.firstChild);
			}

			/* Drop the stray spaces the markup's indentation leaves at each end */
			function isSpace(span) {
				return span && span.textContent === ' ';
			}
			while (isSpace(chars[0])) {
				chars[0].parentNode.removeChild(chars[0]);
				chars.shift();
			}
			while (isSpace(chars[chars.length - 1])) {
				var last = chars.pop();
				last.parentNode.removeChild(last);
			}

			var caret = document.createElement('span');
			caret.className = 'sf-tw__caret';
			caret.setAttribute('aria-hidden', 'true');
			title.appendChild(caret);

			/* Screen readers read the whole line, not one letter at a time */
			title.setAttribute('aria-label', fullText);
			Array.prototype.forEach.call(title.children, function (child) {
				child.setAttribute('aria-hidden', 'true');
			});

			title.twChars = chars;
			title.dataset.twReady = '1';
		}

		function resetTitles() {
			var titles = heroSwiperEl.querySelectorAll('.sf-hero2__title');
			Array.prototype.forEach.call(titles, function (title) {
				buildTitle(title);
				(title.twChars || []).forEach(function (span) {
					span.classList.remove('is-in');
				});
				title.classList.remove('is-typing', 'is-typed');
			});
		}

		function typeActiveTitle() {
			window.clearTimeout(typeTimer);
			resetTitles();

			var active = heroSwiperEl.querySelector('.swiper-slide-active');
			var title = active && active.querySelector('.sf-hero2__title');
			if (!title) return;

			var chars = title.twChars || [];

			if (reduceMotion) {
				chars.forEach(function (span) {
					span.classList.add('is-in');
				});
				title.classList.add('is-typed');
				return;
			}

			title.classList.add('is-typing');

			var i = 0;
			function step() {
				if (i >= chars.length) {
					title.classList.remove('is-typing');
					title.classList.add('is-typed');
					return;
				}
				chars[i].classList.add('is-in');
				i++;
				typeTimer = window.setTimeout(step, TYPE_SPEED);
			}
			typeTimer = window.setTimeout(step, TYPE_START_DELAY);
		}

		heroSwiper.on('slideChangeTransitionStart', typeActiveTitle);
		typeActiveTitle();
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

	/* ---------- Homepage: reveal the top bar once the page scrolls ---------- */
	var topbar = document.getElementById('sf-topbar');
	if (topbar && document.body.classList.contains('sf-home')) {
		var TOPBAR_REVEAL_AT = 60;
		var syncTopbar = function () {
			var show = window.pageYOffset > TOPBAR_REVEAL_AT;
			document.body.classList.toggle('sf-topbar-visible', show);
			// Keep the hidden bar out of the tab order so keyboard users are not
			// sent to controls they cannot see.
			topbar.setAttribute('aria-hidden', show ? 'false' : 'true');
			topbar.inert = !show;
		};
		window.addEventListener('scroll', syncTopbar, { passive: true });
		syncTopbar();
	}

	/* ---------- Testimonials: curved carousel ----------
	   Each reviewer gets a slot class based on its distance from the active
	   index, wrapped so the list loops. CSS turns those classes into the arc
	   positions, so the rotation is a single class swap per tick. */
	var tstBody = document.querySelector('.sf-tst__body');
	if (tstBody) {
		var people = Array.prototype.slice.call(tstBody.querySelectorAll('.sf-tst__person'));
		var quotes = Array.prototype.slice.call(tstBody.querySelectorAll('.sf-tst__quote'));
		var total = people.length;

		if (total > 0) {
			var TST_SPEED = parseInt(tstBody.dataset.speed, 10) || 4000;
			var tstIndex = 0;
			var tstTimer = null;
			var tstReduce = window.matchMedia &&
				window.matchMedia('(prefers-reduced-motion: reduce)').matches;

			var applyTst = function () {
				people.forEach(function (person, i) {
					// Signed distance from the active item, wrapped both ways.
					var offset = i - tstIndex;
					if (offset > total / 2) {
						offset -= total;
					}
					if (offset < -total / 2) {
						offset += total;
					}

					person.classList.remove('is-prev', 'is-active', 'is-next', 'is-off-up', 'is-off-down');

					if (offset === 0) {
						person.classList.add('is-active');
					} else if (offset === -1) {
						person.classList.add('is-prev');
					} else if (offset === 1) {
						person.classList.add('is-next');
					} else if (offset < -1) {
						person.classList.add('is-off-up');
					} else {
						person.classList.add('is-off-down');
					}
				});

				quotes.forEach(function (quote, i) {
					quote.classList.toggle('is-active', i === tstIndex);
				});
			};

			var advanceTst = function () {
				tstIndex = (tstIndex + 1) % total;
				applyTst();
			};

			var startTst = function () {
				if (tstReduce || total < 2) {
					return;
				}
				window.clearInterval(tstTimer);
				tstTimer = window.setInterval(advanceTst, TST_SPEED);
			};

			var stopTst = function () {
				window.clearInterval(tstTimer);
			};

			// Clicking a reviewer jumps straight to them.
			people.forEach(function (person, i) {
				person.addEventListener('click', function () {
					tstIndex = i;
					applyTst();
					startTst();
				});
			});

			tstBody.addEventListener('mouseenter', stopTst);
			tstBody.addEventListener('mouseleave', startTst);

			// Only spend cycles while the section is on screen.
			if ('IntersectionObserver' in window) {
				new IntersectionObserver(function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							startTst();
						} else {
							stopTst();
						}
					});
				}, { threshold: 0.2 }).observe(tstBody);
			} else {
				startTst();
			}

			applyTst();
		}
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
