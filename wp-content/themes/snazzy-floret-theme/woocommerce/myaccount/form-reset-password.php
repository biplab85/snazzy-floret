<?php
/**
 * Lost password reset form - Snazzy Floret premium override.
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_reset_password_form' );
?>

<div class="sf-auth sf-auth--lost" data-sf-auth>
	<div class="sf-auth__shell">
		<div class="sf-auth__brand">
			<span class="sf-auth__eyebrow"><?php esc_html_e( 'Snazzy Floret', 'snazzy-floret' ); ?></span>
			<h1 class="sf-auth__title"><?php esc_html_e( 'Set a new password', 'snazzy-floret' ); ?></h1>
			<p class="sf-auth__subtitle">
				<?php echo esc_html( apply_filters( 'woocommerce_reset_password_message', __( 'Choose a strong password you don\'t use anywhere else. Mix letters, numbers, and symbols for the best protection.', 'snazzy-floret' ) ) ); ?>
			</p>
		</div>

		<div class="sf-auth__panel">
			<form method="post" class="woocommerce-ResetPassword lost_reset_password sf-form">
				<div class="sf-form__row">
					<label for="password_1"><?php esc_html_e( 'New password', 'snazzy-floret' ); ?></label>
					<div class="sf-form__pwd">
						<input type="password" class="sf-form__input" name="password_1" id="password_1" autocomplete="new-password" required />
						<button type="button" class="sf-form__pwd-toggle" data-sf-pwd-toggle aria-label="<?php esc_attr_e( 'Show password', 'snazzy-floret' ); ?>">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
						</button>
					</div>
				</div>

				<div class="sf-form__row">
					<label for="password_2"><?php esc_html_e( 'Confirm new password', 'snazzy-floret' ); ?></label>
					<div class="sf-form__pwd">
						<input type="password" class="sf-form__input" name="password_2" id="password_2" autocomplete="new-password" required />
						<button type="button" class="sf-form__pwd-toggle" data-sf-pwd-toggle aria-label="<?php esc_attr_e( 'Show password', 'snazzy-floret' ); ?>">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
						</button>
					</div>
				</div>

				<p class="sf-form__hint sf-form__hint--privacy">
					<?php esc_html_e( 'Use at least 8 characters with a mix of uppercase, lowercase, numbers and symbols.', 'snazzy-floret' ); ?>
				</p>

				<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
				<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />
				<input type="hidden" name="wc_reset_password" value="true" />

				<?php do_action( 'woocommerce_resetpassword_form' ); ?>
				<?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>

				<button type="submit" class="sf-form__submit" value="<?php esc_attr_e( 'Save new password', 'snazzy-floret' ); ?>"><?php esc_html_e( 'Save new password', 'snazzy-floret' ); ?></button>

				<p class="sf-form__switch">
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Back to sign in', 'snazzy-floret' ); ?></a>
				</p>
			</form>
		</div>
	</div>

	<aside class="sf-auth__aside" aria-hidden="true">
		<div class="sf-auth__aside-inner">
			<img class="sf-auth__aside-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Logo.svg' ); ?>" alt="<?php esc_attr_e( 'Snazzy Floret', 'snazzy-floret' ); ?>" />
			<span class="sf-auth__aside-eyebrow"><?php esc_html_e( 'Almost there', 'snazzy-floret' ); ?></span>
			<h2 class="sf-auth__aside-title"><?php esc_html_e( 'One last step to secure your account.', 'snazzy-floret' ); ?></h2>
			<ul class="sf-auth__perks">
				<li><?php esc_html_e( 'Choose a unique, strong password', 'snazzy-floret' ); ?></li>
				<li><?php esc_html_e( 'Never share it with anyone', 'snazzy-floret' ); ?></li>
				<li><?php esc_html_e( 'Update it regularly for safety', 'snazzy-floret' ); ?></li>
				<li><?php esc_html_e( 'We never store passwords in plain text', 'snazzy-floret' ); ?></li>
			</ul>
		</div>
	</aside>
</div>

<script>
(function(){
	document.querySelectorAll('[data-sf-pwd-toggle]').forEach(function(btn){
		btn.addEventListener('click', function(){
			var input = btn.previousElementSibling;
			if(!input) return;
			input.type = input.type === 'password' ? 'text' : 'password';
		});
	});
})();
</script>

<?php
do_action( 'woocommerce_after_reset_password_form' );
