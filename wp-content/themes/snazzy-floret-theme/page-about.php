<?php
/**
 * Template for the About page. Auto-loaded for the page with slug "about".
 * All text content is editable via Appearance → Customize → About Page.
 *
 * @package Snazzy_Floret
 */

get_header();
$theme_uri = get_stylesheet_directory_uri();
?>

<section class="sf-about-hero">
	<div class="sf-about-hero__bg" aria-hidden="true">
		<div class="sf-about-hero__orb sf-about-hero__orb--a"></div>
		<div class="sf-about-hero__orb sf-about-hero__orb--b"></div>
		<div class="sf-about-hero__grid"></div>
	</div>
	<div class="sf-container">
		<nav class="sf-legal-crumbs" aria-label="<?php esc_attr_e( 'Breadcrumbs', 'snazzy-floret' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'snazzy-floret' ); ?></a>
			<span aria-hidden="true">/</span>
			<span><?php echo esc_html( sf_about_get( 'crumb_label' ) ); ?></span>
		</nav>
		<div class="sf-about-hero__inner">
			<div class="sf-about-hero__tag">
				<span class="sf-about-hero__icon" aria-hidden="true">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
				</span>
				<span class="sf-about-hero__eyebrow"><?php echo esc_html( sf_about_get( 'hero_eyebrow' ) ); ?></span>
			</div>
			<h1 class="sf-about-hero__title">
				<?php echo esc_html( sf_about_get( 'hero_title_1' ) ); ?>
				<br><em><?php echo esc_html( sf_about_get( 'hero_title_2' ) ); ?></em>
			</h1>
			<p class="sf-about-hero__desc"><?php echo esc_html( sf_about_get( 'hero_desc' ) ); ?></p>
		</div>
	</div>
</section>

<section class="sf-about-story">
	<div class="sf-container">
		<div class="sf-about-story__grid">
			<div class="sf-about-story__media">
				<div class="sf-about-story__image">
					<img src="<?php echo esc_url( $theme_uri . '/assets/images/product%20image/5.jpg' ); ?>" alt="<?php esc_attr_e( 'Snazzy Floret collection', 'snazzy-floret' ); ?>" loading="lazy">
				</div>
				<div class="sf-about-story__image sf-about-story__image--offset">
					<img src="<?php echo esc_url( $theme_uri . '/assets/images/product%20image/8.jpg' ); ?>" alt="<?php esc_attr_e( 'Snazzy Floret family matching', 'snazzy-floret' ); ?>" loading="lazy">
				</div>
				<div class="sf-about-story__badge" aria-hidden="true">
					<span class="sf-about-story__badge-value"><?php echo esc_html( sf_about_get( 'story_badge_value' ) ); ?></span>
					<span class="sf-about-story__badge-label"><?php echo esc_html( sf_about_get( 'story_badge_label' ) ); ?></span>
				</div>
			</div>
			<div class="sf-about-story__content">
				<span class="sf-about-story__eyebrow"><?php echo esc_html( sf_about_get( 'story_eyebrow' ) ); ?></span>
				<h2 class="sf-about-story__title"><?php echo esc_html( sf_about_get( 'story_title_1' ) ); ?> <em><?php echo esc_html( sf_about_get( 'story_title_2' ) ); ?></em></h2>
				<p><?php echo esc_html( sf_about_get( 'story_p1' ) ); ?></p>
				<p><?php echo esc_html( sf_about_get( 'story_p2' ) ); ?></p>
				<div class="sf-about-story__sig">
					<div>
						<strong><?php echo esc_html( sf_about_get( 'story_sig_name' ) ); ?></strong>
						<span><?php echo esc_html( sf_about_get( 'story_sig_location' ) ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="sf-about-values">
	<div class="sf-container">
		<div class="sf-about-values__head">
			<span class="sf-about-values__eyebrow"><?php echo esc_html( sf_about_get( 'values_eyebrow' ) ); ?></span>
			<h2 class="sf-about-values__title"><?php echo esc_html( sf_about_get( 'values_title' ) ); ?></h2>
		</div>
		<div class="sf-about-values__grid">
			<div class="sf-about-value">
				<div class="sf-about-value__icon" aria-hidden="true">
					<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
				</div>
				<h3><?php echo esc_html( sf_about_get( 'value_1_title' ) ); ?></h3>
				<p><?php echo esc_html( sf_about_get( 'value_1_desc' ) ); ?></p>
			</div>
			<div class="sf-about-value">
				<div class="sf-about-value__icon" aria-hidden="true">
					<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><line x1="20" y1="4" x2="8.12" y2="15.88"/><line x1="14.47" y1="14.48" x2="20" y2="20"/><line x1="8.12" y1="8.12" x2="12" y2="12"/></svg>
				</div>
				<h3><?php echo esc_html( sf_about_get( 'value_2_title' ) ); ?></h3>
				<p><?php echo esc_html( sf_about_get( 'value_2_desc' ) ); ?></p>
			</div>
			<div class="sf-about-value">
				<div class="sf-about-value__icon" aria-hidden="true">
					<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
				</div>
				<h3><?php echo esc_html( sf_about_get( 'value_3_title' ) ); ?></h3>
				<p><?php echo esc_html( sf_about_get( 'value_3_desc' ) ); ?></p>
			</div>
			<div class="sf-about-value">
				<div class="sf-about-value__icon" aria-hidden="true">
					<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
				</div>
				<h3><?php echo esc_html( sf_about_get( 'value_4_title' ) ); ?></h3>
				<p><?php echo esc_html( sf_about_get( 'value_4_desc' ) ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="sf-about-stats">
	<div class="sf-container">
		<div class="sf-about-stats__grid">
			<div class="sf-about-stat">
				<span class="sf-about-stat__value"><?php echo esc_html( sf_about_get( 'stat_1_value' ) ); ?></span>
				<span class="sf-about-stat__label"><?php echo esc_html( sf_about_get( 'stat_1_label' ) ); ?></span>
			</div>
			<div class="sf-about-stat">
				<span class="sf-about-stat__value"><?php echo esc_html( sf_about_get( 'stat_2_value' ) ); ?></span>
				<span class="sf-about-stat__label"><?php echo esc_html( sf_about_get( 'stat_2_label' ) ); ?></span>
			</div>
			<div class="sf-about-stat">
				<span class="sf-about-stat__value"><?php echo esc_html( sf_about_get( 'stat_3_value' ) ); ?></span>
				<span class="sf-about-stat__label"><?php echo esc_html( sf_about_get( 'stat_3_label' ) ); ?></span>
			</div>
			<div class="sf-about-stat">
				<span class="sf-about-stat__value"><?php echo esc_html( sf_about_get( 'stat_4_value' ) ); ?></span>
				<span class="sf-about-stat__label"><?php echo esc_html( sf_about_get( 'stat_4_label' ) ); ?></span>
			</div>
		</div>
	</div>
</section>

<section class="sf-about-cta">
	<div class="sf-container">
		<div class="sf-about-cta__card">
			<div>
				<span class="sf-about-cta__eyebrow"><?php echo esc_html( sf_about_get( 'cta_eyebrow' ) ); ?></span>
				<h2><?php echo esc_html( sf_about_get( 'cta_title' ) ); ?></h2>
				<p><?php echo esc_html( sf_about_get( 'cta_desc' ) ); ?></p>
			</div>
			<div class="sf-about-cta__actions">
				<a class="sf-about-cta__primary" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">
					<span><?php echo esc_html( sf_about_get( 'cta_primary_label' ) ); ?></span>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
				</a>
				<a class="sf-about-cta__ghost" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
					<?php echo esc_html( sf_about_get( 'cta_secondary_label' ) ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
