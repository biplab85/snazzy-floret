<?php
/**
 * 404 page template.
 *
 * @package Snazzy_Floret
 */

get_header();
?>

<div class="sf-container" style="padding: var(--sf-space-4xl) 0; text-align: center;">
	<h1 style="font-size: 6rem; font-weight: 300; color: var(--sf-gray-200); margin-bottom: var(--sf-space-md);">404</h1>
	<h2 class="sf-section__title"><?php esc_html_e( 'Page Not Found', 'snazzy-floret' ); ?></h2>
	<p class="sf-section__subtitle" style="margin-bottom: var(--sf-space-xl);">
		<?php esc_html_e( 'The page you are looking for might have been removed or is temporarily unavailable.', 'snazzy-floret' ); ?>
	</p>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="sf-btn sf-btn--primary">
		<?php esc_html_e( 'Back to Home', 'snazzy-floret' ); ?>
	</a>
</div>

<?php get_footer(); ?>
