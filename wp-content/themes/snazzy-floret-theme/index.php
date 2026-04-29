<?php
/**
 * The main template file.
 *
 * @package Snazzy_Floret
 */

get_header();
?>

<div class="sf-container" style="padding-top: var(--sf-space-2xl); padding-bottom: var(--sf-space-3xl);">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No posts found.', 'snazzy-floret' ); ?></p>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
