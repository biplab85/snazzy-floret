/**
 * Hero Slider Management screen.
 *
 * Handles add / delete / reorder / enable-disable of sliders, the media picker,
 * the CTA button repeater and the featured-product picker. Field `name`
 * attributes are rebuilt from DOM order on submit, so drag-reordering is all
 * that is needed to change the display order.
 */
( function ( $ ) {
	'use strict';

	var cfg = window.sfHeroAdmin || {};
	var i18n = cfg.i18n || {};
	var uid = 0; // Only used to keep template indices unique before submit.

	var $form = $( '#sf-hero-form' );
	var $list = $( '#sf-hero-list' );

	if ( ! $form.length || ! $list.length ) {
		return;
	}

	/* ------------------------------------------------------------------
	 * Helpers
	 * --------------------------------------------------------------- */

	function template( id, replacements ) {
		var html = $( '#' + id ).html() || '';
		$.each( replacements, function ( token, value ) {
			html = html.split( token ).join( value );
		} );
		return $( $.parseHTML( $.trim( html ) ) );
	}

	function nextUid() {
		uid += 1;
		return 'n' + uid;
	}

	/**
	 * Rebuild every field name from current DOM order.
	 * Also refreshes the visible slider numbers.
	 */
	function reindex() {
		$list.find( '.sf-hero-slide' ).each( function ( si ) {
			var $slide = $( this );

			$slide.find( '.sf-hero-slide__num' ).text( si + 1 );

			$slide.find( '[data-sf-field]' ).each( function () {
				var field = $( this ).data( 'sf-field' );
				$( this ).attr( 'name', 'sf_hero[' + si + '][' + field + ']' );
			} );

			$slide.find( '.sf-hero-btn' ).each( function ( bi ) {
				$( this ).find( '[data-sf-btn]' ).each( function () {
					var field = $( this ).data( 'sf-btn' );
					$( this ).attr( 'name', 'sf_hero[' + si + '][buttons][' + bi + '][' + field + ']' );
				} );
			} );

			$slide.find( '.sf-hero-prod' ).each( function ( pi ) {
				$( this ).find( '[data-sf-prod]' ).each( function () {
					var field = $( this ).data( 'sf-prod' );
					$( this ).attr( 'name', 'sf_hero[' + si + '][products][' + pi + '][' + field + ']' );
				} );
			} );
		} );

		$( '.sf-hero-empty' ).prop( 'hidden', $list.find( '.sf-hero-slide' ).length > 0 );
	}

	function refreshProductsEmpty( $slide ) {
		var has = $slide.find( '.sf-hero-prod' ).length > 0;
		$slide.find( '.sf-hero-prods__empty' ).prop( 'hidden', has );
	}

	function refreshAddButtonState( $slide ) {
		var count = $slide.find( '.sf-hero-btn' ).length;
		$slide.find( '.sf-hero-add-btn' ).prop( 'disabled', count >= ( cfg.maxButtons || 3 ) );
	}

	/* ------------------------------------------------------------------
	 * Sliders: add / delete / reorder / collapse / toggle
	 * --------------------------------------------------------------- */

	$( document ).on( 'click', '.sf-hero-add-slide', function ( e ) {
		e.preventDefault();

		var $slide = template( 'tmpl-sf-hero-slide', {
			__SI__: nextUid(),
			__BI__: '0',
			__PI__: '0'
		} );

		$list.append( $slide );
		$slide.addClass( 'is-open is-new' );
		$slide.find( '.sf-hero-slide__toggle' ).attr( 'aria-expanded', 'true' );
		initSlide( $slide );
		reindex();
		refreshAddButtonState( $slide );

		$( 'html, body' ).animate( { scrollTop: $slide.offset().top - 60 }, 250 );
		$slide.find( '.sf-hero-title-input' ).trigger( 'focus' );
	} );

	$( document ).on( 'click', '.sf-hero-slide__remove', function ( e ) {
		e.preventDefault();
		if ( ! window.confirm( i18n.confirmDelete ) ) {
			return;
		}
		$( this ).closest( '.sf-hero-slide' ).slideUp( 150, function () {
			$( this ).remove();
			reindex();
		} );
	} );

	$( document ).on( 'click', '.sf-hero-slide__toggle', function ( e ) {
		e.preventDefault();
		var $slide = $( this ).closest( '.sf-hero-slide' );
		var open = ! $slide.hasClass( 'is-open' );
		$slide.toggleClass( 'is-open', open );
		$( this ).attr( 'aria-expanded', open ? 'true' : 'false' );
	} );

	// Clicking the header (but not a control) also expands.
	$( document ).on( 'click', '.sf-hero-slide__head', function ( e ) {
		if ( $( e.target ).closest( 'button, label, input, .sf-hero-slide__drag' ).length ) {
			return;
		}
		$( this ).find( '.sf-hero-slide__toggle' ).trigger( 'click' );
	} );

	// Live header title preview.
	$( document ).on( 'input', '.sf-hero-title-input', function () {
		var value = $.trim( $( this ).val() );
		$( this ).closest( '.sf-hero-slide' )
			.find( '.sf-hero-slide__name' )
			.text( value || i18n.untitled );
	} );

	// Slider enable / disable switch — scoped to the header so the per-section
	// switches below don't disable the whole slider.
	$( document ).on( 'change', '.sf-hero-slide__head .sf-hero-switch__input', function () {
		var on = $( this ).is( ':checked' );
		var $slide = $( this ).closest( '.sf-hero-slide' );
		$slide.toggleClass( 'is-disabled', ! on );
		$( this ).closest( '.sf-hero-switch' )
			.find( '.sf-hero-switch__text' )
			.text( on ? 'Active' : 'Disabled' );
	} );

	// Per-section show / hide switch (Content, CTA buttons).
	$( document ).on( 'change', '.sf-hero-subhead .sf-hero-switch__input', function () {
		var on = $( this ).is( ':checked' );
		$( this ).closest( '.sf-hero-section' ).toggleClass( 'is-off', ! on );
		$( this ).closest( '.sf-hero-switch' )
			.find( '.sf-hero-switch__text' )
			.text( on ? 'Shown' : 'Hidden' );
	} );

	/* ------------------------------------------------------------------
	 * Background image
	 * --------------------------------------------------------------- */

	$( document ).on( 'click', '.sf-hero-media__pick', function ( e ) {
		e.preventDefault();

		var $media = $( this ).closest( '.sf-hero-media' );
		var frame = window.wp.media( {
			title: i18n.chooseImage,
			button: { text: i18n.useImage },
			library: { type: 'image' },
			multiple: false
		} );

		/* Which pair of hidden fields this picker owns: image_* or image_mobile_* */
		var key = $media.data( 'sf-media' ) || 'image';
		var isPrimary = String( $media.data( 'sf-primary' ) ) === '1';

		frame.on( 'select', function () {
			var att = frame.state().get( 'selection' ).first().toJSON();
			var preview = att.url;

			if ( att.sizes && att.sizes.medium ) {
				preview = att.sizes.medium.url;
			}

			$media.find( '[data-sf-field="' + key + '_id"]' ).val( att.id );
			$media.find( '[data-sf-field="' + key + '_url"]' ).val( att.url );
			$media.find( '.sf-hero-media__preview' )
				.removeClass( 'is-empty' )
				.html( $( '<img>' ).attr( 'src', preview ) );
			$media.find( '.sf-hero-media__clear' ).show();

			/* Only the desktop image drives the collapsed row's thumbnail */
			if ( isPrimary ) {
				$media.closest( '.sf-hero-slide' ).find( '.sf-hero-slide__thumb' )
					.html( $( '<img>' ).attr( 'src', preview ) );
			}
		} );

		frame.open();
	} );

	$( document ).on( 'click', '.sf-hero-media__clear', function ( e ) {
		e.preventDefault();
		var $media = $( this ).closest( '.sf-hero-media' );
		var key = $media.data( 'sf-media' ) || 'image';
		var isPrimary = String( $media.data( 'sf-primary' ) ) === '1';

		$media.find( '[data-sf-field="' + key + '_id"]' ).val( '0' );
		$media.find( '[data-sf-field="' + key + '_url"]' ).val( '' );
		$media.find( '.sf-hero-media__preview' ).addClass( 'is-empty' ).empty();
		$( this ).hide();

		if ( isPrimary ) {
			$media.closest( '.sf-hero-slide' ).find( '.sf-hero-slide__thumb' ).empty();
		}
	} );

	/* ------------------------------------------------------------------
	 * CTA buttons
	 * --------------------------------------------------------------- */

	$( document ).on( 'click', '.sf-hero-add-btn', function ( e ) {
		e.preventDefault();

		var $slide = $( this ).closest( '.sf-hero-slide' );
		var max = cfg.maxButtons || 3;

		if ( $slide.find( '.sf-hero-btn' ).length >= max ) {
			window.alert( i18n.maxButtons );
			return;
		}

		var $btn = template( 'tmpl-sf-hero-btn', {
			__SI__: nextUid(),
			__BI__: nextUid()
		} );

		$slide.find( '.sf-hero-btns' ).append( $btn );
		reindex();
		refreshAddButtonState( $slide );
		$btn.find( 'input' ).first().trigger( 'focus' );
	} );

	$( document ).on( 'click', '.sf-hero-btn__remove', function ( e ) {
		e.preventDefault();
		var $slide = $( this ).closest( '.sf-hero-slide' );
		$( this ).closest( '.sf-hero-btn' ).remove();
		reindex();
		refreshAddButtonState( $slide );
	} );

	/* ------------------------------------------------------------------
	 * Featured products
	 * --------------------------------------------------------------- */

	var searchTimer = null;

	function sprintf( template, values ) {
		var out = String( template );
		$.each( values, function ( i, value ) {
			out = out.split( '%' + ( i + 1 ) + '$d' ).join( value ).split( '%d' ).join( value );
		} );
		return out;
	}

	function renderResults( $box, items, total ) {
		$box.empty();

		if ( ! items.length ) {
			$box.append( $( '<div class="sf-hero-prod-search__empty">' ).text( i18n.noResults ) );
			return;
		}

		// Say plainly whether the list is complete — a capped list that looks
		// complete is worse than no list at all.
		$box.append(
			$( '<div class="sf-hero-prod-search__count">' ).text(
				total > items.length
					? sprintf( i18n.truncated, [ items.length, total ] )
					: sprintf( i18n.allShown, [ total ] )
			)
		);

		$.each( items, function ( _, item ) {
			var $row = $( '<button type="button" class="sf-hero-prod-search__item">' )
				.attr( 'data-id', item.id )
				.attr( 'data-name', item.name )
				.attr( 'data-thumb', item.thumb || '' )
				.attr( 'data-price', item.price || '' );

			if ( item.thumb ) {
				$row.append( $( '<img>' ).attr( 'src', item.thumb ).attr( 'alt', '' ) );
			} else {
				$row.append( $( '<span class="sf-hero-prod-search__noimg">' ) );
			}

			$row.append(
				$( '<span class="sf-hero-prod-search__meta">' )
					.append( $( '<strong>' ).text( item.name ) )
					.append( $( '<span>' ).text( item.price || '' ) )
			);

			$box.append( $row );
		} );
	}

	$( document ).on( 'input focus', '.sf-hero-prod-search__input', function () {
		var $input = $( this );
		var $box = $input.siblings( '.sf-hero-prod-search__results' );
		var term = $.trim( $input.val() );

		window.clearTimeout( searchTimer );

		$box.prop( 'hidden', false ).html(
			$( '<div class="sf-hero-prod-search__empty">' ).text( i18n.searching )
		);

		searchTimer = window.setTimeout( function () {
			$.getJSON( cfg.ajaxUrl, {
				action: 'sf_hero_product_search',
				nonce: cfg.nonce,
				term: term
			} ).done( function ( res ) {
				var data = ( res && res.success && res.data ) ? res.data : null;
				var items = ( data && data.items ) ? data.items : [];
				renderResults( $box, items, data ? data.total : items.length );
			} ).fail( function () {
				renderResults( $box, [], 0 );
			} );
		}, 300 );
	} );

	$( document ).on( 'click', '.sf-hero-prod-search__item', function ( e ) {
		e.preventDefault();

		var $item = $( this );
		var $slide = $item.closest( '.sf-hero-slide' );
		var id = String( $item.data( 'id' ) );
		var exists = false;

		$slide.find( '.sf-hero-prod' ).each( function () {
			if ( String( $( this ).attr( 'data-product-id' ) ) === id ) {
				exists = true;
			}
		} );

		if ( exists ) {
			window.alert( i18n.alreadyAdded );
			return;
		}

		var $prod = template( 'tmpl-sf-hero-prod', {
			__SI__: nextUid(),
			__PI__: nextUid()
		} );

		$prod.attr( 'data-product-id', id );
		$prod.find( '[data-sf-prod="id"]' ).val( id );
		$prod.find( '.sf-hero-prod__name' ).text( $item.attr( 'data-name' ) );
		$prod.find( '.sf-hero-prod__price' ).text( $item.attr( 'data-price' ) );

		var thumb = $item.attr( 'data-thumb' );
		if ( thumb ) {
			$prod.find( '.sf-hero-prod__thumb' ).html( $( '<img>' ).attr( 'src', thumb ).attr( 'alt', '' ) );
		}

		$slide.find( '.sf-hero-prods' ).append( $prod );
		$slide.find( '.sf-hero-prod-search__input' ).val( '' );
		$slide.find( '.sf-hero-prod-search__results' ).prop( 'hidden', true ).empty();

		refreshProductsEmpty( $slide );
		reindex();
	} );

	$( document ).on( 'click', '.sf-hero-prod__remove', function ( e ) {
		e.preventDefault();
		var $slide = $( this ).closest( '.sf-hero-slide' );
		$( this ).closest( '.sf-hero-prod' ).remove();
		refreshProductsEmpty( $slide );
		reindex();
	} );

	// Close the results dropdown when clicking elsewhere.
	$( document ).on( 'click', function ( e ) {
		if ( ! $( e.target ).closest( '.sf-hero-prod-search' ).length ) {
			$( '.sf-hero-prod-search__results' ).prop( 'hidden', true );
		}
	} );

	/* ------------------------------------------------------------------
	 * Sortables
	 * --------------------------------------------------------------- */

	function initSlide( $slide ) {
		$slide.find( '.sf-hero-prods' ).sortable( {
			handle: '.sf-hero-prod__handle',
			axis: 'y',
			update: reindex
		} );
		$slide.find( '.sf-hero-btns' ).sortable( {
			handle: '.sf-hero-btn__handle',
			axis: 'y',
			update: reindex
		} );
		refreshProductsEmpty( $slide );
		refreshAddButtonState( $slide );
	}

	$list.sortable( {
		handle: '.sf-hero-slide__drag',
		axis: 'y',
		placeholder: 'sf-hero-slide__placeholder',
		forcePlaceholderSize: true,
		update: reindex
	} );

	/* ------------------------------------------------------------------
	 * Submit — names are rebuilt from DOM order
	 * --------------------------------------------------------------- */

	$form.on( 'submit', function () {
		reindex();
	} );

	/* ------------------------------------------------------------------
	 * Boot
	 * --------------------------------------------------------------- */

	$list.find( '.sf-hero-slide' ).each( function () {
		initSlide( $( this ) );
	} );
	reindex();
} )( window.jQuery );
