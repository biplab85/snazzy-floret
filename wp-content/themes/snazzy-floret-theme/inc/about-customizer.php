<?php
/**
 * About Page — dynamic content via Page Edit meta boxes.
 * All text on /about/ can be edited from:
 *   wp-admin → Pages → About us → Edit
 * Five meta boxes (Hero, Story, Values, Stats, CTA) with 37 fields in total.
 * The original hardcoded copy is preserved as defaults (and runtime fallbacks).
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slug of the About page. Meta boxes only appear on the page with this slug.
 */
function sf_about_page_slug() {
	return 'about';
}

/**
 * Default content for the About page — mirrors the original hardcoded copy.
 * Used both as the starting value in the edit form and as the runtime fallback.
 */
function sf_about_default_content() {
	return array(
		// Hero
		'crumb_label'        => 'About us',
		'hero_eyebrow'       => 'Our Story',
		'hero_title_1'       => 'Crafted for Every',
		'hero_title_2'       => 'Precious Moment.',
		'hero_desc'          => 'A Dhaka-born fashion house celebrating family, tradition, and modern elegance — one thoughtfully tailored piece at a time.',

		// Story
		'story_badge_value'  => '82K+',
		'story_badge_label'  => 'Happy Followers',
		'story_eyebrow'      => 'Who we are',
		'story_title_1'      => 'A love letter to',
		'story_title_2'      => 'family style.',
		'story_p1'           => 'Snazzy Floret began with a simple idea — that the people we love most deserve clothing made with the same love. What started as a small studio in Dhaka has grown into a trusted name for family matching dresses, mother-daughter combos, and occasion wear across Bangladesh.',
		'story_p2'           => 'Every piece we make is rooted in a belief that quality fabric, considered tailoring, and honest prices shouldn\'t be luxuries. We source materials carefully, fit thoughtfully, and pack every order by hand — because the people wearing our clothes are never just customers.',
		'story_sig_name'     => 'Snazzy Floret',
		'story_sig_location' => 'Dhaka, Bangladesh',

		// Values
		'values_eyebrow' => 'What we stand for',
		'values_title'   => 'Four values, stitched into every piece.',
		'value_1_title'  => 'Premium Fabric',
		'value_1_desc'   => 'Hand-picked cotton, silk, and georgette — sourced for comfort, drape, and longevity.',
		'value_2_title'  => 'Custom Tailoring',
		'value_2_desc'   => 'Your measurements, your fit. We tailor most pieces to order so nothing feels off-the-rack.',
		'value_3_title'  => 'Made for Families',
		'value_3_desc'   => 'Matching sets for every member — from mother-daughter combos to full family looks.',
		'value_4_title'  => 'Proudly Bangladeshi',
		'value_4_desc'   => 'Designed, cut, and sewn in Dhaka. We celebrate local craft with every stitch.',

		// Stats
		'stat_1_value' => '82K+',
		'stat_1_label' => 'Facebook Followers',
		'stat_2_value' => '98%',
		'stat_2_label' => 'Would Recommend',
		'stat_3_value' => '64',
		'stat_3_label' => 'Districts Delivered',
		'stat_4_value' => '100%',
		'stat_4_label' => 'Custom Fit Available',

		// CTA
		'cta_eyebrow'         => 'Join the family',
		'cta_title'           => 'Ready to find your next favourite piece?',
		'cta_desc'            => 'Explore our latest collection or get in touch — we love to chat about custom orders and fit.',
		'cta_primary_label'   => 'Shop Collection',
		'cta_secondary_label' => 'Contact Us',
	);
}

/**
 * Field groups — each becomes one meta box on the edit screen.
 */
function sf_about_field_groups() {
	return array(
		'hero'   => array(
			'title'  => 'About Page — Hero',
			'fields' => array(
				'crumb_label'  => array( 'Breadcrumb label', 'text' ),
				'hero_eyebrow' => array( 'Eyebrow (small label above title)', 'text' ),
				'hero_title_1' => array( 'Hero title — line 1', 'text' ),
				'hero_title_2' => array( 'Hero title — line 2 (italic)', 'text' ),
				'hero_desc'    => array( 'Hero description', 'textarea' ),
			),
		),
		'story'  => array(
			'title'  => 'About Page — Story',
			'fields' => array(
				'story_badge_value'  => array( 'Image badge value (e.g. 82K+)', 'text' ),
				'story_badge_label'  => array( 'Image badge label', 'text' ),
				'story_eyebrow'      => array( 'Story eyebrow', 'text' ),
				'story_title_1'      => array( 'Story title — line 1', 'text' ),
				'story_title_2'      => array( 'Story title — line 2 (italic)', 'text' ),
				'story_p1'           => array( 'Story paragraph 1', 'textarea' ),
				'story_p2'           => array( 'Story paragraph 2', 'textarea' ),
				'story_sig_name'     => array( 'Signature — brand name', 'text' ),
				'story_sig_location' => array( 'Signature — location', 'text' ),
			),
		),
		'values' => array(
			'title'  => 'About Page — Values',
			'fields' => array(
				'values_eyebrow' => array( 'Values eyebrow', 'text' ),
				'values_title'   => array( 'Values section title', 'text' ),
				'value_1_title'  => array( 'Value 1 — title', 'text' ),
				'value_1_desc'   => array( 'Value 1 — description', 'textarea' ),
				'value_2_title'  => array( 'Value 2 — title', 'text' ),
				'value_2_desc'   => array( 'Value 2 — description', 'textarea' ),
				'value_3_title'  => array( 'Value 3 — title', 'text' ),
				'value_3_desc'   => array( 'Value 3 — description', 'textarea' ),
				'value_4_title'  => array( 'Value 4 — title', 'text' ),
				'value_4_desc'   => array( 'Value 4 — description', 'textarea' ),
			),
		),
		'stats'  => array(
			'title'  => 'About Page — Stats',
			'fields' => array(
				'stat_1_value' => array( 'Stat 1 — value', 'text' ),
				'stat_1_label' => array( 'Stat 1 — label', 'text' ),
				'stat_2_value' => array( 'Stat 2 — value', 'text' ),
				'stat_2_label' => array( 'Stat 2 — label', 'text' ),
				'stat_3_value' => array( 'Stat 3 — value', 'text' ),
				'stat_3_label' => array( 'Stat 3 — label', 'text' ),
				'stat_4_value' => array( 'Stat 4 — value', 'text' ),
				'stat_4_label' => array( 'Stat 4 — label', 'text' ),
			),
		),
		'cta'    => array(
			'title'  => 'About Page — Call To Action',
			'fields' => array(
				'cta_eyebrow'         => array( 'CTA eyebrow', 'text' ),
				'cta_title'           => array( 'CTA title', 'text' ),
				'cta_desc'            => array( 'CTA description', 'textarea' ),
				'cta_primary_label'   => array( 'Primary button label', 'text' ),
				'cta_secondary_label' => array( 'Secondary button label', 'text' ),
			),
		),
	);
}

/**
 * Frontend helper — returns the saved post_meta for the About page,
 * falling back to the hardcoded default if empty.
 */
function sf_about_get( $key ) {
	$defaults = sf_about_default_content();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';

	$about = get_page_by_path( sf_about_page_slug() );
	if ( $about ) {
		$val = get_post_meta( $about->ID, '_sf_about_' . $key, true );
		if ( '' !== $val && null !== $val ) {
			return $val;
		}
	}
	return $default;
}

/**
 * Register the meta boxes, but only on the About page edit screen.
 */
function sf_about_register_meta_boxes() {
	global $post;
	if ( ! $post || 'page' !== $post->post_type ) { return; }
	if ( sf_about_page_slug() !== $post->post_name ) { return; }

	foreach ( sf_about_field_groups() as $group_key => $group ) {
		add_meta_box(
			'sf_about_mb_' . $group_key,
			$group['title'],
			'sf_about_render_meta_box',
			'page',
			'normal',
			'high',
			array( 'group_key' => $group_key )
		);
	}
}
add_action( 'add_meta_boxes_page', 'sf_about_register_meta_boxes' );

/**
 * Render a meta box.
 */
function sf_about_render_meta_box( $post, $box ) {
	$group_key = isset( $box['args']['group_key'] ) ? $box['args']['group_key'] : '';
	$groups    = sf_about_field_groups();
	if ( ! isset( $groups[ $group_key ] ) ) { return; }

	wp_nonce_field( 'sf_about_save_meta_' . $post->ID, 'sf_about_meta_nonce' );

	$defaults = sf_about_default_content();
	echo '<div class="sf-about-mb" style="display:grid;grid-template-columns:1fr;gap:14px;padding:6px 0;">';
	foreach ( $groups[ $group_key ]['fields'] as $field_key => $meta ) {
		list( $label, $type ) = $meta;
		$name  = 'sf_about_' . $field_key;
		$saved = get_post_meta( $post->ID, '_sf_about_' . $field_key, true );
		$value = ( '' === $saved || null === $saved )
			? ( isset( $defaults[ $field_key ] ) ? $defaults[ $field_key ] : '' )
			: $saved;

		echo '<div>';
		printf(
			'<label for="%1$s" style="display:block;font-weight:600;margin-bottom:4px;">%2$s</label>',
			esc_attr( $name ),
			esc_html( $label )
		);
		if ( 'textarea' === $type ) {
			printf(
				'<textarea id="%1$s" name="%1$s" rows="3" style="width:100%%;max-width:100%%;">%2$s</textarea>',
				esc_attr( $name ),
				esc_textarea( $value )
			);
		} else {
			printf(
				'<input type="text" id="%1$s" name="%1$s" value="%2$s" style="width:100%%;max-width:100%%;">',
				esc_attr( $name ),
				esc_attr( $value )
			);
		}
		echo '</div>';
	}
	echo '<p style="margin:0;color:#777;font-style:italic;">Leave a field blank and save to restore the built-in default for that field.</p>';
	echo '</div>';
}

/**
 * Save the submitted About fields.
 */
function sf_about_save_meta( $post_id, $post ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( wp_is_post_revision( $post_id ) ) { return; }
	if ( 'page' !== $post->post_type ) { return; }
	if ( sf_about_page_slug() !== $post->post_name ) { return; }
	if ( ! isset( $_POST['sf_about_meta_nonce'] ) ) { return; }
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sf_about_meta_nonce'] ) ), 'sf_about_save_meta_' . $post_id ) ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

	foreach ( sf_about_field_groups() as $group ) {
		foreach ( $group['fields'] as $field_key => $meta ) {
			list( , $type ) = $meta;
			$name = 'sf_about_' . $field_key;
			if ( ! isset( $_POST[ $name ] ) ) { continue; }
			$raw = wp_unslash( $_POST[ $name ] );
			$val = ( 'textarea' === $type )
				? sanitize_textarea_field( $raw )
				: wp_strip_all_tags( $raw );

			// Empty string -> delete meta so the default applies again.
			if ( '' === trim( $val ) ) {
				delete_post_meta( $post_id, '_sf_about_' . $field_key );
			} else {
				update_post_meta( $post_id, '_sf_about_' . $field_key, $val );
			}
		}
	}
}
add_action( 'save_post_page', 'sf_about_save_meta', 10, 2 );
