<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue frontend styles and scripts.
 */
function sf_enqueue_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );
	$theme_uri     = get_template_directory_uri();

	// Swiper.js
	wp_enqueue_style(
		'swiper',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
		array(),
		'11'
	);

	wp_enqueue_script(
		'swiper',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
		array(),
		'11',
		true
	);

	// Google Fonts
	wp_enqueue_style(
		'sf-google-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&family=Hind+Siliguri:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);

	// Main theme stylesheet
	wp_enqueue_style(
		'sf-main',
		$theme_uri . '/assets/css/main.css',
		array( 'sf-google-fonts' ),
		filemtime( get_template_directory() . '/assets/css/main.css' )
	);

	// WooCommerce overrides
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style(
			'sf-woocommerce',
			$theme_uri . '/assets/css/woocommerce.css',
			array( 'sf-main' ),
			filemtime( get_template_directory() . '/assets/css/woocommerce.css' )
		);

		if ( function_exists( 'is_account_page' ) && is_account_page() ) {
			wp_enqueue_style(
				'sf-account',
				$theme_uri . '/assets/css/account.css',
				array( 'sf-woocommerce' ),
				filemtime( get_template_directory() . '/assets/css/account.css' )
			);

			wp_enqueue_style(
				'sf-auth-premium',
				$theme_uri . '/assets/css/auth-premium.css',
				array( 'sf-account' ),
				filemtime( get_template_directory() . '/assets/css/auth-premium.css' )
			);
		}

		if ( function_exists( 'is_woocommerce' ) && ( is_shop() || is_product_taxonomy() ) ) {
			wp_enqueue_style(
				'sf-shop-premium',
				$theme_uri . '/assets/css/shop-premium.css',
				array( 'sf-woocommerce' ),
				filemtime( get_template_directory() . '/assets/css/shop-premium.css' )
			);

			wp_enqueue_style(
				'sf-card-oos',
				$theme_uri . '/assets/css/card-oos.css',
				array( 'sf-shop-premium' ),
				filemtime( get_template_directory() . '/assets/css/card-oos.css' )
			);
		}

		if ( function_exists( 'is_cart' ) && is_cart() ) {
			wp_enqueue_style(
				'sf-cart-edit',
				$theme_uri . '/assets/css/cart-edit.css',
				array( 'sf-woocommerce' ),
				filemtime( get_template_directory() . '/assets/css/cart-edit.css' )
			);
			wp_enqueue_script(
				'sf-cart-edit',
				$theme_uri . '/assets/js/cart-edit.js',
				array(),
				filemtime( get_template_directory() . '/assets/js/cart-edit.js' ),
				true
			);
			wp_localize_script( 'sf-cart-edit', 'sfCartEdit', array(
				'ajax'    => admin_url( 'admin-ajax.php' ),
				'tooltip' => __( 'This size is out of stock', 'snazzy-floret' ),
			) );
		}

		if ( function_exists( 'is_product' ) && is_product() ) {
			wp_enqueue_style(
				'sf-pdp-premium',
				$theme_uri . '/assets/css/pdp-premium.css',
				array( 'sf-woocommerce' ),
				filemtime( get_template_directory() . '/assets/css/pdp-premium.css' )
			);

			wp_enqueue_style(
				'sf-pdp-multi',
				$theme_uri . '/assets/css/pdp-multi.css',
				array( 'sf-pdp-premium' ),
				filemtime( get_template_directory() . '/assets/css/pdp-multi.css' )
			);
		}
	}

	// Theme style.css (last for overrides)
	wp_enqueue_style(
		'sf-style',
		get_stylesheet_uri(),
		array( 'sf-main' ),
		$theme_version
	);

	// Main JavaScript
	wp_enqueue_script(
		'sf-main',
		$theme_uri . '/assets/js/main.js',
		array( 'swiper' ),
		filemtime( get_template_directory() . '/assets/js/main.js' ),
		true
	);

	// Localize AJAX data on main script so quick view & slider work everywhere
	if ( class_exists( 'WooCommerce' ) ) {
		wp_localize_script( 'sf-main', 'sf_ajax', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'sf_ajax_nonce' ),
		) );

		wp_enqueue_script(
			'sf-ajax-cart',
			$theme_uri . '/assets/js/ajax-cart.js',
			array( 'sf-main', 'jquery' ),
			filemtime( get_template_directory() . '/assets/js/ajax-cart.js' ),
			true
		);

		// Single product page
		if ( is_product() ) {
			wp_enqueue_style(
				'fancybox',
				'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css',
				array(),
				'5.0'
			);
			wp_enqueue_script(
				'fancybox',
				'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js',
				array(),
				'5.0',
				true
			);
			wp_enqueue_script(
				'sf-single-product',
				$theme_uri . '/assets/js/single-product.js',
				array( 'sf-main', 'fancybox' ),
				filemtime( get_template_directory() . '/assets/js/single-product.js' ),
				true
			);
		}

		// Shop filters (only on shop/category pages)
		if ( is_shop() || is_product_category() || is_product_tag() ) {
			wp_enqueue_script(
				'sf-shop-filters',
				$theme_uri . '/assets/js/shop-filters.js',
				array(),
				$theme_version,
				true
			);
			wp_localize_script(
				'sf-shop-filters',
				'sfShopFilters',
				array(
					'currencySymbol' => function_exists( 'get_woocommerce_currency_symbol' )
						? html_entity_decode( get_woocommerce_currency_symbol() )
						: '',
				)
			);
		}

		// Checkout: confirm-password field for guest signup.
		if ( is_checkout() && ! is_user_logged_in() ) {
			wp_enqueue_script(
				'sf-checkout-confirm-password',
				$theme_uri . '/assets/js/checkout-confirm-password.js',
				array(),
				$theme_version,
				true
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'sf_enqueue_assets' );

/**
 * Remove default WooCommerce styles we're overriding.
 */
function sf_dequeue_wc_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );
	unset( $enqueue_styles['woocommerce-layout'] );
	unset( $enqueue_styles['woocommerce-smallscreen'] );
	return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'sf_dequeue_wc_styles' );

/**
 * Preload key fonts for performance.
 */
function sf_preload_fonts() {
	?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php
}
add_action( 'wp_head', 'sf_preload_fonts', 1 );

/**
 * Hide Stripe Link / express payment block on cart page (printed inline so
 * it cannot be defeated by stylesheet caching).
 */
function sf_hide_express_payment_inline() {
	echo '<style id="sf-hide-express-payment">.wp-block-woocommerce-cart-express-payment-block,.wc-block-cart__payment-options,.wc-block-components-express-payment,.wc-block-components-express-payment-continue-rule{display:none!important}</style>';
	echo '<script id="sf-hide-stripe-devtools">(function(){function strip(){document.querySelectorAll(\'iframe[title="Stripe developer tools frame"]\').forEach(function(f){f.remove();});document.querySelectorAll(\'.wc-block-checkout__payment-method\').forEach(function(e){e.classList.add(\'sf-payment-method\');});}new MutationObserver(strip).observe(document.documentElement,{childList:true,subtree:true});document.addEventListener("DOMContentLoaded",strip);})();</script>';
	// Checkout: payment options side-by-side + radio alignment.
	echo "<style id=\"sf-checkout-payment-grid\">
.wc-block-checkout__payment-method.wp-block-woocommerce-checkout-payment-block.wc-block-components-checkout-step{border:0!important;box-shadow:none!important}
.wc-block-checkout__payment-method .wc-block-components-radio-control-accordion-content > .content{display:none!important}
/* Payment options: only the radio tiles side-by-side, expanded form goes full-width below */
.wc-block-checkout__payment-method .wc-block-components-checkout-step__content .wc-block-components-radio-control--highlight-checked{display:grid!important;grid-template-columns:1fr 1fr;grid-template-rows:auto auto;gap:14px;align-items:start}
.wc-block-checkout__payment-method .wc-block-components-radio-control-accordion-option{display:contents}
.wc-block-checkout__payment-method .wc-block-components-radio-control__option{position:relative;grid-row:1;margin:0!important;padding:16px 16px 16px 48px!important;display:flex!important;align-items:center;min-height:56px;border:1px solid #E8E4DF;border-radius:10px;background:#fff;transition:border-color .2s ease,box-shadow .2s ease;cursor:pointer}
.wc-block-checkout__payment-method .wc-block-components-radio-control-accordion-option--checked-option-highlighted .wc-block-components-radio-control__option{border-color:#8B6F4E;box-shadow:0 4px 16px rgba(139,111,78,.10)}
.wc-block-checkout__payment-method .wc-block-components-radio-control-accordion-content{grid-row:2;grid-column:1 / -1;border:1px solid #E8E4DF;border-radius:10px;padding:18px;background:#fff;margin-top:0}
/* Radio dot alignment */
.wc-block-checkout__payment-method .wc-block-components-radio-control__input{position:absolute!important;top:50%!important;left:16px!important;width:18px!important;height:18px!important;margin:0!important;transform:translateY(-50%)!important}
.wc-block-checkout__payment-method .wc-block-components-radio-control__input:checked::before{content:\"\"!important;position:absolute!important;top:50%!important;left:50%!important;width:10px!important;height:10px!important;border-radius:50%!important;background:#8B6F4E!important;transform:translate(-50%,-50%)!important}
@media (max-width:600px){.wc-block-checkout__payment-method .wc-block-components-checkout-step__content .wc-block-components-radio-control--highlight-checked{grid-template-columns:1fr}}
</style>";
}
add_action( 'wp_head', 'sf_hide_express_payment_inline', 999 );
