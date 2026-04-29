<?php
/**
 * Template for the Blog listing page (slug: blog).
 * Renders dynamic posts with a premium magazine-style layout.
 *
 * @package Snazzy_Floret
 */

get_header();

$sf_blog_query = new WP_Query( array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 12,
	'paged'          => max( 1, (int) get_query_var( 'paged' ) ),
	'orderby'        => 'date',
	'order'          => 'DESC',
) );
?>

<section class="sf-blog-hero">
	<div class="sf-blog-hero__bg" aria-hidden="true">
		<div class="sf-blog-hero__orb sf-blog-hero__orb--a"></div>
		<div class="sf-blog-hero__orb sf-blog-hero__orb--b"></div>
		<div class="sf-blog-hero__grid"></div>
	</div>
	<div class="sf-container">
		<div class="sf-blog-hero__inner">
			<div class="sf-blog-hero__tag">
				<span class="sf-blog-hero__icon" aria-hidden="true">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
				</span>
				<span class="sf-blog-hero__eyebrow"><?php esc_html_e( 'The Journal', 'snazzy-floret' ); ?></span>
			</div>
			<h1 class="sf-blog-hero__title">
				<?php esc_html_e( 'Stories, Style, and', 'snazzy-floret' ); ?>
				<br><em><?php esc_html_e( 'Thoughtful Wear.', 'snazzy-floret' ); ?></em>
			</h1>
			<p class="sf-blog-hero__desc"><?php esc_html_e( 'Fabric deep-dives, family styling guides, and quiet notes from our Dhaka studio.', 'snazzy-floret' ); ?></p>
		</div>
	</div>
</section>

<section class="sf-blog-list">
	<div class="sf-container">

		<?php if ( $sf_blog_query->have_posts() ) : ?>

			<?php
			// Featured post: first post of the first page only.
			$is_first_page = 1 === max( 1, (int) get_query_var( 'paged' ) );
			$post_counter  = 0;
			?>

			<div class="sf-blog-list__grid">
				<?php while ( $sf_blog_query->have_posts() ) : $sf_blog_query->the_post();
					$post_counter++;
					$is_featured = $is_first_page && 1 === $post_counter;
					$cats        = get_the_category();
					$primary_cat = ! empty( $cats ) ? $cats[0] : null;
					$card_class  = $is_featured ? 'sf-blog-card sf-blog-card--featured' : 'sf-blog-card';
				?>
					<article class="<?php echo esc_attr( $card_class ); ?>">
						<a class="sf-blog-card__media" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( $is_featured ? 'large' : 'medium_large', array(
									'class'   => 'sf-blog-card__img',
									'loading' => $is_featured ? 'eager' : 'lazy',
									'alt'     => esc_attr( get_the_title() ),
								) ); ?>
							<?php else : ?>
								<div class="sf-blog-card__placeholder" aria-hidden="true">
									<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
								</div>
							<?php endif; ?>
							<?php if ( $primary_cat ) : ?>
								<span class="sf-blog-card__chip"><?php echo esc_html( $primary_cat->name ); ?></span>
							<?php endif; ?>
						</a>
						<div class="sf-blog-card__body">
							<div class="sf-blog-card__meta">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								<span class="sf-blog-card__dot" aria-hidden="true"></span>
								<span><?php echo esc_html( sf_blog_reading_time( get_the_content() ) ); ?></span>
							</div>
							<h2 class="sf-blog-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h2>
							<p class="sf-blog-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
							<a class="sf-blog-card__cta" href="<?php the_permalink(); ?>">
								<span><?php esc_html_e( 'Read article', 'snazzy-floret' ); ?></span>
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php
			$big       = 999999999;
			$paginate  = paginate_links( array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, (int) get_query_var( 'paged' ) ),
				'total'     => $sf_blog_query->max_num_pages,
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type'      => 'array',
			) );
			if ( ! empty( $paginate ) ) :
			?>
				<nav class="sf-blog-pagination" aria-label="<?php esc_attr_e( 'Blog pagination', 'snazzy-floret' ); ?>">
					<?php foreach ( $paginate as $link ) { echo wp_kses_post( $link ); } ?>
				</nav>
			<?php endif; ?>

		<?php else : ?>
			<div class="sf-blog-empty">
				<h2><?php esc_html_e( 'No posts yet.', 'snazzy-floret' ); ?></h2>
				<p><?php esc_html_e( 'We\'re writing. Check back soon for fabric guides, family styling tips, and notes from the studio.', 'snazzy-floret' ); ?></p>
			</div>
		<?php endif; wp_reset_postdata(); ?>

	</div>
</section>

<?php get_footer(); ?>
