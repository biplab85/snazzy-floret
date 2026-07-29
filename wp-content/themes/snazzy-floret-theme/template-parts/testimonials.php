<?php
/**
 * Testimonials section — curved carousel.
 *
 * Reviewers sit on an arc; the middle one is active and its quote shows on the
 * right. Managed under wp-admin → Testimonials.
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_tst_items = function_exists( 'sf_tst_get' ) ? sf_tst_get( true ) : array();

if ( empty( $sf_tst_items ) ) {
	return;
}

$sf_tst_opts = sf_tst_opts();
?>
<section class="sf-tst sf-section" id="sf-testimonials">
	<span class="sf-tst__blob" aria-hidden="true"></span>
	<div class="sf-container">
		<div class="sf-tst__card">

		<div class="sf-tst__head">
			<span class="sf-tst__rule" aria-hidden="true"></span>
			<h2 class="sf-tst__title"><?php echo esc_html( $sf_tst_opts['title'] ); ?></h2>
		</div>

		<div class="sf-tst__body" data-speed="<?php echo esc_attr( absint( $sf_tst_opts['speed'] ) ); ?>">

			<!-- Left: reviewers on the arc -->
			<div class="sf-tst__people">
				<svg class="sf-tst__arc" viewBox="0 0 140 340" preserveAspectRatio="none" aria-hidden="true">
					<path d="M18 8 C 108 96, 108 244, 18 332" fill="none" stroke="currentColor" stroke-width="1" />
				</svg>

				<ul class="sf-tst__list">
					<?php foreach ( $sf_tst_items as $sf_i => $sf_item ) :
						$sf_photo = sf_tst_image_url( $sf_item, 'thumbnail' );
						?>
						<li class="sf-tst__person" data-index="<?php echo esc_attr( $sf_i ); ?>">
							<span class="sf-tst__avatar">
								<?php if ( $sf_photo ) : ?>
									<img src="<?php echo esc_url( $sf_photo ); ?>" alt="<?php echo esc_attr( $sf_item['name'] ); ?>" loading="lazy">
								<?php else : ?>
									<span class="sf-tst__avatar-fallback" aria-hidden="true">
										<?php echo esc_html( mb_strtoupper( mb_substr( $sf_item['name'], 0, 1 ) ) ); ?>
									</span>
								<?php endif; ?>
							</span>
							<span class="sf-tst__info">
								<span class="sf-tst__name"><?php echo esc_html( $sf_item['name'] ); ?></span>
								<?php if ( '' !== $sf_item['rating'] || '' !== $sf_item['date'] ) : ?>
									<span class="sf-tst__meta">
										<?php if ( '' !== $sf_item['rating'] ) : ?>
											<svg class="sf-tst__star" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
												<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
											</svg>
											<strong class="sf-tst__rating"><?php echo esc_html( $sf_item['rating'] ); ?></strong>
										<?php endif; ?>
										<?php if ( '' !== $sf_item['date'] ) : ?>
											<span class="sf-tst__date"><?php echo esc_html( $sf_item['date'] ); ?></span>
										<?php endif; ?>
									</span>
								<?php endif; ?>
							</span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<!-- Right: the quote -->
			<div class="sf-tst__quotes">
				<span class="sf-tst__mark" aria-hidden="true">&ldquo;</span>
				<?php foreach ( $sf_tst_items as $sf_i => $sf_item ) :
					$sf_quote   = trim( $sf_item['quote'] );
					$sf_initial = mb_substr( $sf_quote, 0, 1 );
					$sf_rest    = mb_substr( $sf_quote, 1 );
					?>
					<blockquote class="sf-tst__quote" data-index="<?php echo esc_attr( $sf_i ); ?>">
						<span class="sf-tst__quote-initial"><?php echo esc_html( $sf_initial ); ?></span><?php echo esc_html( $sf_rest ); ?>
					</blockquote>
				<?php endforeach; ?>
			</div>

		</div>

		</div><!-- /.sf-tst__card -->
	</div>
</section>
