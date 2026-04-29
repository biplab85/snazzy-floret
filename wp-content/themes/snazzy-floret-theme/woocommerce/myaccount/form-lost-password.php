<?php
/**
 * Lost password form - Snazzy Floret premium override.
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="sf-auth sf-auth--lost" data-sf-auth>
	<div class="sf-auth__shell">
		<div class="sf-auth__brand">
			<span class="sf-auth__eyebrow"><?php esc_html_e( 'Snazzy Floret', 'snazzy-floret' ); ?></span>
			<h1 class="sf-auth__title"><?php esc_html_e( 'Reset your password', 'snazzy-floret' ); ?></h1>
			<p class="sf-auth__subtitle">
				<?php echo esc_html( apply_filters( 'woocommerce_lost_password_message', __( 'Enter your username or email and we\'ll send you a secure link to set a new password.', 'snazzy-floret' ) ) ); ?>
			</p>
		</div>

		<div class="sf-auth__panel">
			<form method="post" class="woocommerce-ResetPassword lost_reset_password sf-form">
				<div class="sf-form__row">
					<label for="user_login"><?php esc_html_e( 'Username or email', 'snazzy-floret' ); ?></label>
					<input class="sf-form__input" type="text" name="user_login" id="user_login" autocomplete="username" required />
				</div>

				<?php do_action( 'woocommerce_lostpassword_form' ); ?>

				<input type="hidden" name="wc_reset_password" value="true" />
				<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

				<button type="submit" class="sf-form__submit" value="<?php esc_attr_e( 'Send reset link', 'snazzy-floret' ); ?>"><?php esc_html_e( 'Send reset link', 'snazzy-floret' ); ?></button>

				<p class="sf-form__switch">
					<?php esc_html_e( 'Remembered your password?', 'snazzy-floret' ); ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Back to sign in', 'snazzy-floret' ); ?></a>
				</p>
			</form>
		</div>
	</div>

	<aside class="sf-auth__aside" aria-hidden="true">
		<div class="sf-auth__aside-inner">
			<img class="sf-auth__aside-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Logo.svg' ); ?>" alt="<?php esc_attr_e( 'Snazzy Floret', 'snazzy-floret' ); ?>" />
			<span class="sf-auth__aside-eyebrow"><?php esc_html_e( 'Need a hand?', 'snazzy-floret' ); ?></span>
			<h2 class="sf-auth__aside-title"><?php esc_html_e( 'We\'ll get you back in, in moments.', 'snazzy-floret' ); ?></h2>
			<ul class="sf-auth__perks">
				<li><?php esc_html_e( 'Secure, single-use reset link', 'snazzy-floret' ); ?></li>
				<li><?php esc_html_e( 'Delivered straight to your inbox', 'snazzy-floret' ); ?></li>
				<li><?php esc_html_e( 'Expires for your safety', 'snazzy-floret' ); ?></li>
				<li><?php esc_html_e( 'Support: snazzyfloret@gmail.com', 'snazzy-floret' ); ?></li>
			</ul>
		</div>
	</aside>
</div>

<?php
do_action( 'woocommerce_after_lost_password_form' );
