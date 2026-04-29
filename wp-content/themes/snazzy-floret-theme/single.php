<?php
/**
 * Single blog post template.
 *
 * @package Snazzy_Floret
 */

get_header();
?>

<?php while ( have_posts() ) : the_post();
	$cats           = get_the_category();
	$primary_cat    = ! empty( $cats ) ? $cats[0] : null;
	$sf_share_url   = rawurlencode( get_permalink() );
	$sf_share_title = rawurlencode( get_the_title() );
?>
<article class="sf-post">

	<section class="sf-post-hero">
		<div class="sf-post-hero__bg" aria-hidden="true">
			<div class="sf-post-hero__orb sf-post-hero__orb--a"></div>
			<div class="sf-post-hero__orb sf-post-hero__orb--b"></div>
			<div class="sf-post-hero__grid"></div>
		</div>
		<div class="sf-container">
			<div class="sf-post-hero__inner">
				<?php if ( $primary_cat ) : ?>
					<div class="sf-post-hero__tag">
						<span class="sf-post-hero__eyebrow"><?php echo esc_html( $primary_cat->name ); ?></span>
					</div>
				<?php endif; ?>
				<h1 class="sf-post-hero__title"><?php the_title(); ?></h1>
				<div class="sf-post-hero__meta">
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					<span class="sf-post-hero__dot" aria-hidden="true"></span>
					<span><?php echo esc_html( sf_blog_reading_time( get_the_content() ) ); ?></span>
				</div>
			</div>
		</div>
	</section>

	<?php if ( has_post_thumbnail() ) : ?>
		<section class="sf-post-feature">
			<div class="sf-container">
				<div class="sf-post-feature__frame">
					<?php the_post_thumbnail( 'large', array(
						'class'   => 'sf-post-feature__img',
						'loading' => 'eager',
						'alt'     => esc_attr( get_the_title() ),
					) ); ?>

					<div class="sf-post-image-share" data-open="false">
						<div class="sf-post-image-share__items" aria-hidden="true">
							<a class="sf-post-image-share__item sf-post-image-share__item--facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $sf_share_url; ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on Facebook', 'snazzy-floret' ); ?>" tabindex="-1">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
							</a>
							<a class="sf-post-image-share__item sf-post-image-share__item--twitter" href="https://twitter.com/intent/tweet?url=<?php echo $sf_share_url; ?>&text=<?php echo $sf_share_title; ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on X / Twitter', 'snazzy-floret' ); ?>" tabindex="-1">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2H21l-6.547 7.476L22 22h-6.828l-4.83-6.31L4.8 22H2l7.01-8.003L1.75 2h6.999l4.37 5.77L18.244 2zm-1.203 18.29h1.56L7.04 3.6H5.37l11.671 16.69z"/></svg>
							</a>
							<a class="sf-post-image-share__item sf-post-image-share__item--linkedin" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $sf_share_url; ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'snazzy-floret' ); ?>" tabindex="-1">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.852 3.37-1.852 3.601 0 4.267 2.37 4.267 5.455v6.288zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.063 2.063 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
							</a>
							<a class="sf-post-image-share__item sf-post-image-share__item--whatsapp" href="https://api.whatsapp.com/send?text=<?php echo $sf_share_title; ?>%20<?php echo $sf_share_url; ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on WhatsApp', 'snazzy-floret' ); ?>" tabindex="-1">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.84 12.84 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
							</a>
						</div>
						<button type="button" class="sf-post-image-share__toggle" aria-label="<?php esc_attr_e( 'Share this article', 'snazzy-floret' ); ?>" aria-expanded="false">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
						</button>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<section class="sf-post-body">
		<div class="sf-container">
			<div class="sf-post-body__content sf-legal-content">
				<?php the_content(); ?>
			</div>

			<div class="sf-post-share" aria-label="<?php esc_attr_e( 'Share this article', 'snazzy-floret' ); ?>">
				<span class="sf-post-share__label"><?php esc_html_e( 'Share', 'snazzy-floret' ); ?></span>
				<div class="sf-post-share__links">
					<a class="sf-post-share__link sf-post-share__link--facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $sf_share_url; ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on Facebook', 'snazzy-floret' ); ?>">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
					</a>
					<a class="sf-post-share__link sf-post-share__link--twitter" href="https://twitter.com/intent/tweet?url=<?php echo $sf_share_url; ?>&text=<?php echo $sf_share_title; ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on X / Twitter', 'snazzy-floret' ); ?>">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2H21l-6.547 7.476L22 22h-6.828l-4.83-6.31L4.8 22H2l7.01-8.003L1.75 2h6.999l4.37 5.77L18.244 2zm-1.203 18.29h1.56L7.04 3.6H5.37l11.671 16.69z"/></svg>
					</a>
					<a class="sf-post-share__link sf-post-share__link--linkedin" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $sf_share_url; ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'snazzy-floret' ); ?>">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.852 3.37-1.852 3.601 0 4.267 2.37 4.267 5.455v6.288zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.063 2.063 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
					</a>
					<a class="sf-post-share__link sf-post-share__link--whatsapp" href="https://api.whatsapp.com/send?text=<?php echo $sf_share_title; ?>%20<?php echo $sf_share_url; ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Share on WhatsApp', 'snazzy-floret' ); ?>">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.84 12.84 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
					</a>
				</div>
			</div>

			<?php $tags = get_the_tags(); if ( $tags ) : ?>
				<div class="sf-post-tags">
					<?php foreach ( $tags as $tag ) : ?>
						<a class="sf-post-tag" href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>">#<?php echo esc_html( $tag->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="sf-post-back">
				<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="sf-post-back__link">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
					<?php esc_html_e( 'Back to all articles', 'snazzy-floret' ); ?>
				</a>
			</div>
		</div>
	</section>

	<?php
	$related = new WP_Query( array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'post__not_in'   => array( get_the_ID() ),
		'orderby'        => 'rand',
	) );
	if ( $related->have_posts() ) :
	?>
	<section class="sf-post-related">
		<div class="sf-container">
			<div class="sf-post-related__head">
				<span class="sf-post-related__eyebrow"><?php esc_html_e( 'Keep reading', 'snazzy-floret' ); ?></span>
				<h2 class="sf-post-related__title"><?php esc_html_e( 'More from the Journal', 'snazzy-floret' ); ?></h2>
			</div>
			<div class="sf-blog-list__grid sf-blog-list__grid--related">
				<?php while ( $related->have_posts() ) : $related->the_post();
					$r_cats        = get_the_category();
					$r_primary_cat = ! empty( $r_cats ) ? $r_cats[0] : null;
				?>
					<article class="sf-blog-card">
						<a class="sf-blog-card__media" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium_large', array(
									'class'   => 'sf-blog-card__img',
									'loading' => 'lazy',
									'alt'     => esc_attr( get_the_title() ),
								) ); ?>
							<?php endif; ?>
							<?php if ( $r_primary_cat ) : ?>
								<span class="sf-blog-card__chip"><?php echo esc_html( $r_primary_cat->name ); ?></span>
							<?php endif; ?>
						</a>
						<div class="sf-blog-card__body">
							<div class="sf-blog-card__meta">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							</div>
							<h3 class="sf-blog-card__title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<p class="sf-blog-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
						</div>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

</article>
<?php endwhile; ?>

<script>
(function () {
	var wrap = document.querySelector('.sf-post-image-share');
	if (!wrap) { return; }
	var toggle = wrap.querySelector('.sf-post-image-share__toggle');
	var items  = wrap.querySelector('.sf-post-image-share__items');
	function setOpen(open) {
		wrap.setAttribute('data-open', open ? 'true' : 'false');
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		if (items) { items.setAttribute('aria-hidden', open ? 'false' : 'true'); }
		if (items) {
			items.querySelectorAll('.sf-post-image-share__item').forEach(function (el) {
				el.setAttribute('tabindex', open ? '0' : '-1');
			});
		}
	}
	toggle.addEventListener('click', function (e) {
		e.stopPropagation();
		setOpen(wrap.getAttribute('data-open') !== 'true');
	});
	document.addEventListener('click', function (e) {
		if (!wrap.contains(e.target)) { setOpen(false); }
	});
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') { setOpen(false); }
	});
})();
</script>

<?php get_footer(); ?>
