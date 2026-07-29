/**
 * Testimonials manager screen.
 *
 * Add / delete / reorder / show-hide, plus the photo picker. Field `name`
 * attributes are rebuilt from DOM order on submit, so dragging a row is all
 * that is needed to change the rotation order.
 */
( function ( $ ) {
	'use strict';

	var cfg = window.sfTstAdmin || {};
	var i18n = cfg.i18n || {};
	var uid = 0;

	var $form = $( '#sf-tst-form' );
	var $list = $( '#sf-tst-list' );

	if ( ! $form.length || ! $list.length ) {
		return;
	}

	function template( id, token, value ) {
		var html = $( '#' + id ).html() || '';
		return $( $.parseHTML( $.trim( html.split( token ).join( value ) ) ) );
	}

	function nextUid() {
		uid += 1;
		return 'n' + uid;
	}

	/** Rebuild every field name from current DOM order. */
	function reindex() {
		$list.find( '.sf-tst-item' ).each( function ( i ) {
			var $item = $( this );
			$item.find( '.sf-tst-item__num' ).text( i + 1 );
			$item.find( '[data-sf-field]' ).each( function () {
				$( this ).attr( 'name', 'sf_tst[' + i + '][' + $( this ).data( 'sf-field' ) + ']' );
			} );
		} );
		$( '.sf-tst-empty' ).prop( 'hidden', $list.find( '.sf-tst-item' ).length > 0 );
	}

	/* ---------------- Add / delete / collapse / toggle ---------------- */

	$( document ).on( 'click', '.sf-tst-add', function ( e ) {
		e.preventDefault();
		var $item = template( 'tmpl-sf-tst-item', '__I__', nextUid() );
		$list.append( $item );
		$item.addClass( 'is-open' );
		$item.find( '.sf-tst-item__toggle' ).attr( 'aria-expanded', 'true' );
		reindex();
		$( 'html, body' ).animate( { scrollTop: $item.offset().top - 60 }, 250 );
		$item.find( '.sf-tst-name-input' ).trigger( 'focus' );
	} );

	$( document ).on( 'click', '.sf-tst-item__remove', function ( e ) {
		e.preventDefault();
		if ( ! window.confirm( i18n.confirmDelete ) ) {
			return;
		}
		$( this ).closest( '.sf-tst-item' ).slideUp( 150, function () {
			$( this ).remove();
			reindex();
		} );
	} );

	$( document ).on( 'click', '.sf-tst-item__toggle', function ( e ) {
		e.preventDefault();
		var $item = $( this ).closest( '.sf-tst-item' );
		var open = ! $item.hasClass( 'is-open' );
		$item.toggleClass( 'is-open', open );
		$( this ).attr( 'aria-expanded', open ? 'true' : 'false' );
	} );

	$( document ).on( 'click', '.sf-tst-item__head', function ( e ) {
		if ( $( e.target ).closest( 'button, label, input, .sf-tst-item__drag' ).length ) {
			return;
		}
		$( this ).find( '.sf-tst-item__toggle' ).trigger( 'click' );
	} );

	$( document ).on( 'input', '.sf-tst-name-input', function () {
		var value = $.trim( $( this ).val() );
		$( this ).closest( '.sf-tst-item' )
			.find( '.sf-tst-item__name' )
			.text( value || i18n.unnamed );
	} );

	$( document ).on( 'change', '.sf-tst-switch__input', function () {
		var on = $( this ).is( ':checked' );
		$( this ).closest( '.sf-tst-item' ).toggleClass( 'is-disabled', ! on );
		$( this ).closest( '.sf-tst-switch' )
			.find( '.sf-tst-switch__text' )
			.text( on ? 'Active' : 'Hidden' );
	} );

	/* ---------------- Photo ---------------- */

	$( document ).on( 'click', '.sf-tst-media__pick', function ( e ) {
		e.preventDefault();
		var $media = $( this ).closest( '.sf-tst-media' );
		var frame = window.wp.media( {
			title: i18n.choosePhoto,
			button: { text: i18n.usePhoto },
			library: { type: 'image' },
			multiple: false
		} );

		frame.on( 'select', function () {
			var att = frame.state().get( 'selection' ).first().toJSON();
			var preview = att.url;
			if ( att.sizes && att.sizes.thumbnail ) {
				preview = att.sizes.thumbnail.url;
			}

			$media.find( '[data-sf-field="image_id"]' ).val( att.id );
			$media.find( '[data-sf-field="image_url"]' ).val( att.url );
			$media.find( '.sf-tst-media__preview' )
				.removeClass( 'is-empty' )
				.html( $( '<img>' ).attr( 'src', preview ) );
			$media.find( '.sf-tst-media__clear' ).show();
			$media.closest( '.sf-tst-item' ).find( '.sf-tst-item__avatar' )
				.html( $( '<img>' ).attr( 'src', preview ) );
		} );

		frame.open();
	} );

	$( document ).on( 'click', '.sf-tst-media__clear', function ( e ) {
		e.preventDefault();
		var $media = $( this ).closest( '.sf-tst-media' );
		$media.find( '[data-sf-field="image_id"]' ).val( '0' );
		$media.find( '[data-sf-field="image_url"]' ).val( '' );
		$media.find( '.sf-tst-media__preview' ).addClass( 'is-empty' ).empty();
		$( this ).hide();
		$media.closest( '.sf-tst-item' ).find( '.sf-tst-item__avatar' ).empty();
	} );

	/* ---------------- Sortable + submit ---------------- */

	$list.sortable( {
		handle: '.sf-tst-item__drag',
		axis: 'y',
		placeholder: 'sf-tst-item__placeholder',
		forcePlaceholderSize: true,
		update: reindex
	} );

	$form.on( 'submit', reindex );

	reindex();
} )( window.jQuery );
