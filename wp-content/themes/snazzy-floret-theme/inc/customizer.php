<?php
/**
 * Theme Customizer — Hero Slider (JSON-based with custom control).
 *
 * Features: collapsible slides, add/remove, drag-to-reorder.
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer settings.
 */
function sf_customizer_hero( $wp_customize ) {

	// --- Panel: Homepage ---
	$wp_customize->add_panel( 'sf_homepage_panel', array(
		'title'    => __( 'Homepage', 'snazzy-floret' ),
		'priority' => 30,
	) );

	// --- Section: Hero Slider ---
	$wp_customize->add_section( 'sf_hero_section', array(
		'title' => __( 'Hero Slider', 'snazzy-floret' ),
		'panel' => 'sf_homepage_panel',
	) );

	// Autoplay speed
	$wp_customize->add_setting( 'sf_hero_speed', array(
		'default'           => 5000,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'sf_hero_speed', array(
		'label'       => __( 'Autoplay Speed (ms)', 'snazzy-floret' ),
		'description' => __( 'Default: 5000 (5 seconds).', 'snazzy-floret' ),
		'section'     => 'sf_hero_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 2000, 'max' => 15000, 'step' => 500 ),
	) );

	// Slides JSON
	$wp_customize->add_setting( 'sf_hero_slides', array(
		'default'           => wp_json_encode( sf_hero_default_slides() ),
		'sanitize_callback' => 'sf_sanitize_hero_slides',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new SF_Hero_Slides_Control( $wp_customize, 'sf_hero_slides', array(
		'label'   => __( 'Slides', 'snazzy-floret' ),
		'section' => 'sf_hero_section',
	) ) );
}
add_action( 'customize_register', 'sf_customizer_hero' );

/**
 * Default slides data.
 */
function sf_hero_default_slides() {
	$uri = get_template_directory_uri();
	return array(
		array(
			'image'    => $uri . '/assets/images/image 30.png',
			'tag'      => 'New Collection',
			'title'    => 'Redefining Everyday',
			'title_em' => 'Fashion',
			'desc'     => 'Step into effortless style with our curated collection of modern essentials',
			'btn'      => 'Explore Collection',
			'link'     => '',
		),
		array(
			'image'    => $uri . '/assets/images/image 28.png',
			'tag'      => 'Eid Collection',
			'title'    => 'Family Matching',
			'title_em' => 'Outfits',
			'desc'     => 'Celebrate togetherness with our exclusive family matching collections',
			'btn'      => 'Explore Collection',
			'link'     => '',
		),
		array(
			'image'    => $uri . '/assets/images/image.png',
			'tag'      => 'Handcrafted',
			'title'    => 'Elevating Everyday',
			'title_em' => 'Style',
			'desc'     => 'Discover handmade artistry in every thread — premium fabrics, timeless designs',
			'btn'      => 'Explore Collection',
			'link'     => '',
		),
	);
}

/**
 * Sanitize the JSON slides data.
 */
function sf_sanitize_hero_slides( $input ) {
	$slides = json_decode( $input, true );
	if ( ! is_array( $slides ) ) {
		return wp_json_encode( array() );
	}

	$clean = array();
	foreach ( $slides as $slide ) {
		$clean[] = array(
			'image'    => isset( $slide['image'] ) ? esc_url_raw( $slide['image'] ) : '',
			'tag'      => isset( $slide['tag'] ) ? sanitize_text_field( $slide['tag'] ) : '',
			'title'    => isset( $slide['title'] ) ? sanitize_text_field( $slide['title'] ) : '',
			'title_em' => isset( $slide['title_em'] ) ? sanitize_text_field( $slide['title_em'] ) : '',
			'desc'     => isset( $slide['desc'] ) ? sanitize_text_field( $slide['desc'] ) : '',
			'btn'      => isset( $slide['btn'] ) ? sanitize_text_field( $slide['btn'] ) : '',
			'link'     => isset( $slide['link'] ) ? esc_url_raw( $slide['link'] ) : '',
		);
	}

	return wp_json_encode( $clean );
}

/**
 * Custom Customizer control: Hero Slides Manager.
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

	class SF_Hero_Slides_Control extends WP_Customize_Control {
		public $type = 'sf_hero_slides';

		public function enqueue() {
			wp_enqueue_media();
			wp_enqueue_script( 'jquery-ui-sortable' );
		}

		public function render_content() {
			$value  = $this->value();
			$slides = json_decode( $value, true );
			if ( ! is_array( $slides ) ) {
				$slides = array();
			}
			?>
			<label class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>

			<div id="sf-hero-slides-wrap" style="margin-top:10px;">
				<?php foreach ( $slides as $i => $slide ) : ?>
					<?php $this->render_slide( $i, $slide ); ?>
				<?php endforeach; ?>
			</div>

			<button type="button" id="sf-hero-add-slide" class="button" style="margin-top:12px;width:100%;">
				+ <?php esc_html_e( 'Add New Slide', 'snazzy-floret' ); ?>
			</button>

			<input type="hidden" <?php $this->link(); ?> id="sf-hero-slides-data" value="<?php echo esc_attr( $value ); ?>">

			<!-- Template for new slides (hidden) -->
			<script type="text/html" id="tmpl-sf-hero-slide">
				<?php $this->render_slide( '__INDEX__', array(
					'image'    => '',
					'tag'      => '',
					'title'    => '',
					'title_em' => '',
					'desc'     => '',
					'btn'      => 'Explore Collection',
					'link'     => '',
				) ); ?>
			</script>

			<style>
				.sf-slide-item {
					border: 1px solid #ddd;
					border-radius: 8px;
					margin-bottom: 10px;
					background: #fff;
					transition: box-shadow 0.2s ease;
				}
				.sf-slide-item.ui-sortable-helper {
					box-shadow: 0 4px 16px rgba(0,0,0,0.15);
				}
				.sf-slide-item.ui-sortable-placeholder {
					visibility: visible !important;
					background: #f0f0f0;
					border: 2px dashed #ccc;
					border-radius: 8px;
					min-height: 48px;
				}
				.sf-slide-header {
					display: flex;
					align-items: center;
					padding: 10px 12px;
					cursor: grab;
					user-select: none;
					gap: 8px;
				}
				.sf-slide-header:active {
					cursor: grabbing;
				}
				.sf-slide-drag {
					color: #999;
					font-size: 16px;
					line-height: 1;
					flex-shrink: 0;
				}
				.sf-slide-order {
					background: #1a1a1a;
					color: #fff;
					font-size: 11px;
					font-weight: 700;
					width: 22px;
					height: 22px;
					display: flex;
					align-items: center;
					justify-content: center;
					border-radius: 50%;
					flex-shrink: 0;
				}
				.sf-slide-header-title {
					flex: 1;
					font-weight: 600;
					font-size: 13px;
					color: #1a1a1a;
					white-space: nowrap;
					overflow: hidden;
					text-overflow: ellipsis;
				}
				.sf-slide-toggle {
					background: none;
					border: none;
					cursor: pointer;
					padding: 4px;
					color: #666;
					font-size: 18px;
					line-height: 1;
					transition: transform 0.2s ease;
				}
				.sf-slide-toggle.is-open {
					transform: rotate(180deg);
				}
				.sf-slide-remove {
					background: none;
					border: none;
					cursor: pointer;
					padding: 4px;
					color: #cc1818;
					font-size: 14px;
					line-height: 1;
				}
				.sf-slide-remove:hover {
					color: #e53935;
				}
				.sf-slide-body {
					display: none;
					padding: 0 12px 14px;
					border-top: 1px solid #eee;
				}
				.sf-slide-body.is-open {
					display: block;
				}
				.sf-slide-field {
					margin-top: 10px;
				}
				.sf-slide-field label {
					display: block;
					font-size: 11px;
					font-weight: 600;
					text-transform: uppercase;
					letter-spacing: 0.5px;
					color: #666;
					margin-bottom: 4px;
				}
				.sf-slide-field input[type="text"],
				.sf-slide-field input[type="url"],
				.sf-slide-field textarea {
					width: 100%;
					padding: 7px 10px;
					border: 1px solid #ddd;
					border-radius: 4px;
					font-size: 13px;
				}
				.sf-slide-field textarea {
					height: 60px;
					resize: vertical;
				}
				.sf-slide-img-preview {
					width: 100%;
					height: 120px;
					border-radius: 6px;
					object-fit: cover;
					display: block;
					margin-bottom: 6px;
					background: #f5f5f5;
				}
				.sf-slide-img-btns {
					display: flex;
					gap: 6px;
				}
				.sf-slide-img-btns .button {
					font-size: 11px;
					padding: 2px 10px;
					min-height: 28px;
				}
				#sf-hero-add-slide {
					font-weight: 600;
					letter-spacing: 0.3px;
				}
				.sf-slide-img-note {
					margin: 6px 0 0;
					font-size: 11px;
					color: #888;
					font-style: italic;
					line-height: 1.4;
				}
			</style>

			<script>
			(function($) {
				var $wrap = $('#sf-hero-slides-wrap');
				var $data = $('#sf-hero-slides-data');

				function getSlides() {
					var slides = [];
					$wrap.find('.sf-slide-item').each(function() {
						var $s = $(this);
						slides.push({
							image:    $s.find('[data-field="image"]').val(),
							tag:      $s.find('[data-field="tag"]').val(),
							title:    $s.find('[data-field="title"]').val(),
							title_em: $s.find('[data-field="title_em"]').val(),
							desc:     $s.find('[data-field="desc"]').val(),
							btn:      $s.find('[data-field="btn"]').val(),
							link:     $s.find('[data-field="link"]').val()
						});
					});
					return slides;
				}

				function saveSlides() {
					$data.val(JSON.stringify(getSlides())).trigger('change');
					updateNumbers();
				}

				function updateNumbers() {
					$wrap.find('.sf-slide-item').each(function(i) {
						$(this).find('.sf-slide-order').text(i + 1);
						var title = $(this).find('[data-field="title"]').val() || 'Untitled Slide';
						$(this).find('.sf-slide-header-title').text('Slide ' + (i + 1) + ' — ' + title);
					});
				}

				// Collapse toggle
				$wrap.on('click', '.sf-slide-toggle', function() {
					var $body = $(this).closest('.sf-slide-item').find('.sf-slide-body');
					$body.toggleClass('is-open');
					$(this).toggleClass('is-open');
				});

				// Remove slide
				$wrap.on('click', '.sf-slide-remove', function() {
					if ($wrap.find('.sf-slide-item').length <= 1) {
						alert('You need at least one slide.');
						return;
					}
					$(this).closest('.sf-slide-item').slideUp(200, function() {
						$(this).remove();
						saveSlides();
					});
				});

				// Field change
				$wrap.on('input change', 'input, textarea', function() {
					saveSlides();
				});

				// Image upload
				$wrap.on('click', '.sf-slide-img-upload', function(e) {
					e.preventDefault();
					var $btn = $(this);
					var $item = $btn.closest('.sf-slide-item');
					var frame = wp.media({ multiple: false, library: { type: 'image' } });
					frame.on('select', function() {
						var url = frame.state().get('selection').first().toJSON().url;
						$item.find('[data-field="image"]').val(url);
						$item.find('.sf-slide-img-preview').attr('src', url).show();
						$item.find('.sf-slide-img-remove').show();
						saveSlides();
					});
					frame.open();
				});

				// Image remove
				$wrap.on('click', '.sf-slide-img-remove', function(e) {
					e.preventDefault();
					var $item = $(this).closest('.sf-slide-item');
					$item.find('[data-field="image"]').val('');
					$item.find('.sf-slide-img-preview').attr('src', '').hide();
					$(this).hide();
					saveSlides();
				});

				// Add slide
				$('#sf-hero-add-slide').on('click', function() {
					var idx = $wrap.find('.sf-slide-item').length;
					var tpl = $('#tmpl-sf-hero-slide').html().replace(/__INDEX__/g, idx);
					var $new = $(tpl).hide();
					$wrap.append($new);
					$new.slideDown(200);
					// Auto-open the new slide
					$new.find('.sf-slide-body').addClass('is-open');
					$new.find('.sf-slide-toggle').addClass('is-open');
					saveSlides();
				});

				// Sortable (drag to reorder)
				$wrap.sortable({
					handle: '.sf-slide-header',
					placeholder: 'sf-slide-item ui-sortable-placeholder',
					tolerance: 'pointer',
					axis: 'y',
					update: function() {
						saveSlides();
					}
				});

				// Init numbers
				updateNumbers();

			})(jQuery);
			</script>
			<?php
		}

		/**
		 * Render a single slide block.
		 */
		private function render_slide( $index, $slide ) {
			$title_display = ! empty( $slide['title'] ) ? $slide['title'] : __( 'Untitled Slide', 'snazzy-floret' );
			$has_image     = ! empty( $slide['image'] );
			?>
			<div class="sf-slide-item" data-index="<?php echo esc_attr( $index ); ?>">
				<div class="sf-slide-header">
					<span class="sf-slide-drag">&#9776;</span>
					<span class="sf-slide-order"><?php echo is_numeric( $index ) ? intval( $index ) + 1 : ''; ?></span>
					<span class="sf-slide-header-title"><?php echo esc_html( 'Slide — ' . $title_display ); ?></span>
					<button type="button" class="sf-slide-toggle" title="<?php esc_attr_e( 'Expand / Collapse', 'snazzy-floret' ); ?>">&#9660;</button>
					<button type="button" class="sf-slide-remove" title="<?php esc_attr_e( 'Remove Slide', 'snazzy-floret' ); ?>">&#10005;</button>
				</div>
				<div class="sf-slide-body">
					<!-- Image -->
					<div class="sf-slide-field">
						<label><?php esc_html_e( 'Image', 'snazzy-floret' ); ?></label>
						<?php if ( $has_image ) : ?>
							<img class="sf-slide-img-preview" src="<?php echo esc_url( $slide['image'] ); ?>" alt="">
						<?php else : ?>
							<img class="sf-slide-img-preview" src="" alt="" style="display:none;">
						<?php endif; ?>
						<div class="sf-slide-img-btns">
							<button type="button" class="button sf-slide-img-upload"><?php esc_html_e( 'Choose Image', 'snazzy-floret' ); ?></button>
							<button type="button" class="button sf-slide-img-remove" <?php echo ! $has_image ? 'style="display:none;"' : ''; ?>><?php esc_html_e( 'Remove', 'snazzy-floret' ); ?></button>
						</div>
						<input type="hidden" data-field="image" value="<?php echo esc_attr( $slide['image'] ); ?>">
						<p class="sf-slide-img-note"><?php esc_html_e( 'Recommended: 1920 x 900 px (landscape). Min 1200 px wide. Use high-quality JPG/WebP under 300 KB for best performance.', 'snazzy-floret' ); ?></p>
					</div>
					<!-- Tag -->
					<div class="sf-slide-field">
						<label><?php esc_html_e( 'Tag', 'snazzy-floret' ); ?></label>
						<input type="text" data-field="tag" value="<?php echo esc_attr( $slide['tag'] ); ?>" placeholder="e.g. New Collection">
					</div>
					<!-- Title -->
					<div class="sf-slide-field">
						<label><?php esc_html_e( 'Title', 'snazzy-floret' ); ?></label>
						<input type="text" data-field="title" value="<?php echo esc_attr( $slide['title'] ); ?>" placeholder="Main heading text">
					</div>
					<!-- Title Accent -->
					<div class="sf-slide-field">
						<label><?php esc_html_e( 'Title Accent Word', 'snazzy-floret' ); ?></label>
						<input type="text" data-field="title_em" value="<?php echo esc_attr( $slide['title_em'] ); ?>" placeholder="Italic highlight word">
					</div>
					<!-- Description -->
					<div class="sf-slide-field">
						<label><?php esc_html_e( 'Description', 'snazzy-floret' ); ?></label>
						<textarea data-field="desc" placeholder="Short description text"><?php echo esc_textarea( $slide['desc'] ); ?></textarea>
					</div>
					<!-- Button Text -->
					<div class="sf-slide-field">
						<label><?php esc_html_e( 'Button Text', 'snazzy-floret' ); ?></label>
						<input type="text" data-field="btn" value="<?php echo esc_attr( $slide['btn'] ); ?>" placeholder="Explore Collection">
					</div>
					<!-- Button Link -->
					<div class="sf-slide-field">
						<label><?php esc_html_e( 'Button Link', 'snazzy-floret' ); ?></label>
						<input type="url" data-field="link" value="<?php echo esc_attr( $slide['link'] ); ?>" placeholder="https:// (empty = Shop page)">
					</div>
				</div>
			</div>
			<?php
		}
	}
}

/**
 * Helper: get hero slides from Customizer.
 *
 * @return array
 */
function sf_get_hero_slides() {
	$raw    = get_theme_mod( 'sf_hero_slides', '' );
	$slides = json_decode( $raw, true );

	// If empty or not saved yet, use defaults
	if ( ! is_array( $slides ) || empty( $slides ) ) {
		$slides = sf_hero_default_slides();
	}

	// Filter out slides with no image
	$slides = array_values( array_filter( $slides, function ( $s ) {
		return ! empty( $s['image'] );
	} ) );

	return $slides;
}
