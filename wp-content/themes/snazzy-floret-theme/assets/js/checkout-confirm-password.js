/**
 * Snazzy Floret — Guest checkout confirm-password.
 *
 * Wraps the WC Blocks password input together with an injected
 * "Confirm password" field inside a single flex row, and adds a
 * show/hide eye toggle to each. Only loaded on checkout for guests.
 */
( function () {
	'use strict';

	var EYE_OPEN =
		'<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
	var EYE_OFF =
		'<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a19.7 19.7 0 0 1 5.06-5.94"/><path d="M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 8 11 8a19.7 19.7 0 0 1-3.22 4.19"/><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';

	function getPasswordInput() {
		var inputs = document.querySelectorAll(
			'.wp-block-woocommerce-checkout input[type="password"]:not(#sf-confirm-password)'
		);
		return inputs.length ? inputs[ inputs.length - 1 ] : null;
	}

	function addToggle( input ) {
		if ( ! input || input.dataset.sfToggle ) {
			return;
		}
		input.dataset.sfToggle = '1';
		var wrapper = input.closest( '.wc-block-components-text-input, .sf-confirm-password-wrapper' );
		if ( ! wrapper ) {
			return;
		}
		wrapper.classList.add( 'sf-has-toggle' );
		var btn = document.createElement( 'button' );
		btn.type = 'button';
		btn.className = 'sf-pw-toggle';
		btn.setAttribute( 'aria-label', 'Show password' );
		btn.innerHTML = EYE_OPEN;
		btn.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			var isPw = input.getAttribute( 'type' ) === 'password';
			input.setAttribute( 'type', isPw ? 'text' : 'password' );
			btn.innerHTML = isPw ? EYE_OFF : EYE_OPEN;
			btn.setAttribute( 'aria-label', isPw ? 'Hide password' : 'Show password' );
		} );
		wrapper.appendChild( btn );
	}

	function inject() {
		var pw = getPasswordInput();
		if ( ! pw ) {
			return;
		}
		var pwWrapper = pw.closest( '.wc-block-components-text-input' );
		if ( ! pwWrapper ) {
			return;
		}

		// Already wrapped?
		if ( pwWrapper.parentElement && pwWrapper.parentElement.classList.contains( 'sf-password-row' ) ) {
			addToggle( pw );
			var existingCf = document.getElementById( 'sf-confirm-password' );
			if ( existingCf ) {
				addToggle( existingCf );
			}
			return;
		}

		// Build confirm field.
		var confirmWrap = document.createElement( 'div' );
		confirmWrap.className = 'wc-block-components-text-input sf-confirm-password-wrapper';
		confirmWrap.innerHTML =
			'<input type="password" id="sf-confirm-password" autocomplete="new-password" required aria-label="Confirm password" />' +
			'<label for="sf-confirm-password">Confirm password</label>';

		// Build the row wrapper and move both wrappers into it.
		var row = document.createElement( 'div' );
		row.className = 'sf-password-row';
		pwWrapper.parentElement.insertBefore( row, pwWrapper );
		row.appendChild( pwWrapper );
		row.appendChild( confirmWrap );

		// Error message under the row.
		var errorEl = document.createElement( 'p' );
		errorEl.className = 'sf-confirm-password-error';
		errorEl.textContent = 'Passwords do not match.';
		errorEl.style.display = 'none';
		row.parentElement.insertBefore( errorEl, row.nextSibling );

		var confirmInput = confirmWrap.querySelector( '#sf-confirm-password' );

		function validate() {
			var match = pw.value === confirmInput.value;
			var bothFilled = pw.value.length > 0 && confirmInput.value.length > 0;
			if ( bothFilled && ! match ) {
				errorEl.style.display = 'block';
				confirmInput.setCustomValidity( 'Passwords do not match.' );
				return false;
			}
			errorEl.style.display = 'none';
			confirmInput.setCustomValidity( '' );
			return true;
		}
		pw.addEventListener( 'input', validate );
		confirmInput.addEventListener( 'input', validate );

		addToggle( pw );
		addToggle( confirmInput );

		pw.setAttribute( 'placeholder', '••••••••' );
		confirmInput.setAttribute( 'placeholder', '••••••••' );
	}

	function blockPlaceOrderIfMismatch( e ) {
		var pw = getPasswordInput();
		var cf = document.getElementById( 'sf-confirm-password' );
		if ( ! pw || ! cf ) {
			return;
		}
		if ( pw.value.length < 6 ) {
			e.preventDefault();
			e.stopPropagation();
			alert( 'Please enter a password (at least 6 characters).' );
			pw.focus();
			return false;
		}
		if ( pw.value !== cf.value ) {
			e.preventDefault();
			e.stopPropagation();
			var errorEl = document.querySelector( '.sf-confirm-password-error' );
			if ( errorEl ) {
				errorEl.style.display = 'block';
			}
			cf.focus();
			return false;
		}
	}

	function bindPlaceOrder() {
		document.addEventListener(
			'click',
			function ( e ) {
				var btn = e.target.closest( '.wc-block-components-checkout-place-order-button' );
				if ( btn ) {
					blockPlaceOrderIfMismatch( e );
				}
			},
			true
		);
	}

	function init() {
		inject();
		bindPlaceOrder();
		var observer = new MutationObserver( function () {
			if ( ! document.getElementById( 'sf-confirm-password' ) ) {
				inject();
			}
		} );
		var target = document.querySelector( '.wp-block-woocommerce-checkout' );
		if ( target ) {
			observer.observe( target, { childList: true, subtree: true } );
		}
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
