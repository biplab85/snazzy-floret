<?php
/**
 * Generic page template.
 *
 * @package Snazzy_Floret
 */

get_header();

$sf_page_slug = get_post_field( 'post_name', get_the_ID() );

$sf_premium_pages = array(
	'faq'             => array(
		'eyebrow' => __( 'Help Center', 'snazzy-floret' ),
		'title'   => __( 'Frequently Asked Questions', 'snazzy-floret' ),
		'desc'    => __( 'Quick answers to common questions about orders, shipping, sizing, and returns.', 'snazzy-floret' ),
		'icon'    => 'help',
	),
	'shipping'        => array(
		'eyebrow' => __( 'Delivery Info', 'snazzy-floret' ),
		'title'   => __( 'Shipping & Delivery', 'snazzy-floret' ),
		'desc'    => __( 'Fast, tracked delivery across all 64 districts of Bangladesh.', 'snazzy-floret' ),
		'icon'    => 'truck',
	),
	'returns-refunds' => array(
		'eyebrow' => __( 'Customer Care', 'snazzy-floret' ),
		'title'   => __( 'Returns & Refunds', 'snazzy-floret' ),
		'desc'    => __( 'A clear, hassle-free policy designed around your peace of mind.', 'snazzy-floret' ),
		'icon'    => 'refresh',
	),
	'privacy-policy'  => array(
		'eyebrow' => __( 'Legal', 'snazzy-floret' ),
		'title'   => __( 'Privacy Policy', 'snazzy-floret' ),
		'desc'    => __( 'How we collect, use, and protect your personal information.', 'snazzy-floret' ),
		'icon'    => 'shield',
	),
);

$sf_is_premium = isset( $sf_premium_pages[ $sf_page_slug ] );
?>

<?php if ( $sf_is_premium ) :
	$meta = $sf_premium_pages[ $sf_page_slug ];
	?>
	<section class="sf-legal-hero sf-legal-hero--<?php echo esc_attr( $sf_page_slug ); ?>">
		<div class="sf-legal-hero__bg" aria-hidden="true">
			<div class="sf-legal-hero__orb sf-legal-hero__orb--a"></div>
			<div class="sf-legal-hero__orb sf-legal-hero__orb--b"></div>
			<div class="sf-legal-hero__grid"></div>
		</div>
		<div class="sf-container">
			<nav class="sf-legal-crumbs" aria-label="<?php esc_attr_e( 'Breadcrumbs', 'snazzy-floret' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'snazzy-floret' ); ?></a>
				<span aria-hidden="true">/</span>
				<span><?php echo esc_html( $meta['title'] ); ?></span>
			</nav>
			<div class="sf-legal-hero__inner">
				<div class="sf-legal-hero__tag">
					<span class="sf-legal-hero__icon" aria-hidden="true">
						<?php if ( 'help' === $meta['icon'] ) : ?>
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
						<?php elseif ( 'truck' === $meta['icon'] ) : ?>
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
						<?php elseif ( 'refresh' === $meta['icon'] ) : ?>
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><polyline points="23 20 23 14 17 14"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4-4.64 4.36A9 9 0 0 1 3.51 15"/></svg>
						<?php else : ?>
							<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
						<?php endif; ?>
					</span>
					<span class="sf-legal-hero__eyebrow"><?php echo esc_html( $meta['eyebrow'] ); ?></span>
				</div>
				<h1 class="sf-legal-hero__title"><?php echo esc_html( $meta['title'] ); ?></h1>
				<p class="sf-legal-hero__desc"><?php echo esc_html( $meta['desc'] ); ?></p>
				<p class="sf-legal-hero__updated">
					<?php
					printf(
						/* translators: %s: last updated date */
						esc_html__( 'Last updated: %s', 'snazzy-floret' ),
						esc_html( get_the_modified_date() )
					);
					?>
				</p>
			</div>
		</div>
	</section>

	<section class="sf-legal-body">
		<div class="sf-container">
			<article class="sf-legal-card">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="sf-legal-content">
						<?php the_content(); ?>
					</div>
				<?php endwhile; ?>

				<div class="sf-legal-help">
					<div class="sf-legal-help__icon" aria-hidden="true">
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
					</div>
					<div>
						<h3><?php esc_html_e( 'Still have questions?', 'snazzy-floret' ); ?></h3>
						<p><?php esc_html_e( 'Our customer care team is happy to help — reach out any time.', 'snazzy-floret' ); ?></p>
					</div>
					<a class="sf-legal-help__cta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
						<?php esc_html_e( 'Contact Us', 'snazzy-floret' ); ?>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
					</a>
				</div>
			</article>
		</div>
	</section>
<?php else : ?>
	<div class="sf-container" style="padding-top: var(--sf-space-2xl); padding-bottom: var(--sf-space-3xl);">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="sf-section__title"><?php the_title(); ?></h1>
				<div class="sf-page-content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
