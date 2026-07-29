<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="sf-site" id="sf-site">

	<!--
		Top bar wrapper. It is `display: contents` by default, so on every page
		except the homepage the announcement and header lay out exactly as if it
		were not here. On the homepage it becomes a fixed bar that starts hidden
		and slides in once the visitor scrolls.
	-->
	<div class="sf-topbar" id="sf-topbar">

	<!-- Announcement Bar -->
	<div class="sf-announcement" id="sf-announcement">
		<div class="sf-container">
			<p class="sf-announcement__text">
				<?php echo esc_html__( 'Free delivery on orders over $75 CAD | Custom sizing available', 'snazzy-floret' ); ?>
			</p>
			<button class="sf-announcement__close" aria-label="<?php esc_attr_e( 'Close announcement', 'snazzy-floret' ); ?>">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
				</svg>
			</button>
		</div>
	</div>

	<!-- Header -->
	<header class="sf-header<?php echo is_front_page() ? ' sf-header--transparent' : ''; ?>" id="sf-header">
		<div class="sf-container sf-header__inner">

			<!-- Logo -->
			<div class="sf-header__logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sf-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="sf-logo__img" width="156" height="65">
				</a>
			</div>

			<!-- Primary Navigation -->
			<nav class="sf-header__nav" id="sf-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'snazzy-floret' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_class'     => 'sf-nav__list',
					'container'      => false,
					'depth'          => 2,
					'fallback_cb'    => false,
				) );
				?>
			</nav>

			<!-- Header Actions -->
			<div class="sf-header__actions">
				<!-- Search -->
				<button class="sf-header__action-btn sf-header__search-toggle" aria-label="<?php esc_attr_e( 'Search', 'snazzy-floret' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
					</svg>
				</button>

				<!-- Cart (opens drawer) -->
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
				<button type="button" class="sf-header__action-btn sf-header__cart-toggle" id="sf-cart-trigger" aria-label="<?php esc_attr_e( 'Cart', 'snazzy-floret' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
						<path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
						<line x1="3" y1="6" x2="21" y2="6"/>
						<path d="M16 10a4 4 0 01-8 0"/>
					</svg>
					<span class="sf-header__cart-count"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?></span>
				</button>
				<?php endif; ?>

				<!-- Account -->
				<a href="<?php echo class_exists( 'WooCommerce' ) ? esc_url( wc_get_page_permalink( 'myaccount' ) ) : esc_url( wp_login_url() ); ?>" class="sf-header__action-btn sf-header__account-toggle" aria-label="<?php esc_attr_e( 'Account', 'snazzy-floret' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
						<path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
						<circle cx="12" cy="7" r="4"/>
					</svg>
				</a>

				<!-- Mobile Menu Toggle -->
				<button class="sf-header__action-btn sf-header__menu-toggle" id="sf-menu-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'snazzy-floret' ); ?>" aria-expanded="false">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
						<line x1="3" y1="6" x2="21" y2="6"/>
						<line x1="3" y1="12" x2="21" y2="12"/>
						<line x1="3" y1="18" x2="21" y2="18"/>
					</svg>
				</button>
			</div>
		</div>

		<!-- Search Overlay -->
		<div class="sf-search-overlay" id="sf-search-overlay" aria-hidden="true">
			<div class="sf-container">
				<form role="search" method="get" class="sf-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="search" class="sf-search-form__input" placeholder="<?php esc_attr_e( 'Search products...', 'snazzy-floret' ); ?>" name="s" autocomplete="off">
					<input type="hidden" name="post_type" value="product">
					<button type="submit" class="sf-search-form__submit" aria-label="<?php esc_attr_e( 'Search', 'snazzy-floret' ); ?>">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
							<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
						</svg>
					</button>
				</form>
			</div>
		</div>
	</header>

	</div><!-- /.sf-topbar -->

	<!-- Mobile Drawer -->
	<div class="sf-mobile-drawer" id="sf-mobile-drawer" aria-hidden="true">
		<div class="sf-mobile-drawer__overlay"></div>
		<div class="sf-mobile-drawer__panel">
			<div class="sf-mobile-drawer__header">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="sf-logo__img" width="120" height="50">
				<button class="sf-mobile-drawer__close" aria-label="<?php esc_attr_e( 'Close menu', 'snazzy-floret' ); ?>">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
					</svg>
				</button>
			</div>
			<nav class="sf-mobile-drawer__nav">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_class'     => 'sf-mobile-nav__list',
					'container'      => false,
					'depth'          => 2,
					'fallback_cb'    => false,
				) );
				?>
			</nav>
		</div>
	</div>

	<main class="sf-main" id="sf-main">
