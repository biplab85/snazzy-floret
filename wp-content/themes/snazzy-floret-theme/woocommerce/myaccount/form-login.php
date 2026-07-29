<?php
/**
 * Login Form - Snazzy Floret premium override.
 *
 * Shows only the login card by default. The register card is toggled
 * via JS when the user clicks "Don't have an account? Register".
 *
 * @package Snazzy_Floret
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_customer_login_form' );

$sf_show_register = 'yes' === get_option( 'woocommerce_enable_myaccount_registration' );
$sf_initial_panel = ( ! empty( $_GET['action'] ) && 'register' === $_GET['action'] ) ? 'register' : 'login'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>

<div class="sf-auth" data-sf-auth data-initial="<?php echo esc_attr( $sf_initial_panel ); ?>">
	<div class="sf-auth__shell">
		<div class="sf-auth__brand">
			<span class="sf-auth__eyebrow"><?php esc_html_e( 'Snazzy Floret', 'snazzy-floret' ); ?></span>
			<h1 class="sf-auth__title" data-sf-title><?php esc_html_e( 'Welcome back', 'snazzy-floret' ); ?></h1>
			<p class="sf-auth__subtitle" data-sf-subtitle><?php esc_html_e( 'Sign in to view your orders, wishlist, and saved addresses.', 'snazzy-floret' ); ?></p>
		</div>

		<!-- LOGIN PANEL -->
		<div class="sf-auth__panel sf-auth__panel--login" data-sf-panel="login">
			<form class="woocommerce-form woocommerce-form-login login sf-form" method="post" novalidate>
				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<div class="sf-form__row">
					<label for="username"><?php esc_html_e( 'Username or email', 'snazzy-floret' ); ?></label>
					<input type="text" class="sf-form__input" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required /><?php // phpcs:ignore ?>
				</div>

				<div class="sf-form__row">
					<label for="password"><?php esc_html_e( 'Password', 'snazzy-floret' ); ?></label>
					<div class="sf-form__pwd">
						<input class="sf-form__input" type="password" name="password" id="password" autocomplete="current-password" required />
						<button type="button" class="sf-form__pwd-toggle" data-sf-pwd-toggle aria-label="<?php esc_attr_e( 'Show password', 'snazzy-floret' ); ?>">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
						</button>
					</div>
				</div>

				<div class="sf-form__meta">
					<label class="sf-form__check">
						<input type="checkbox" name="rememberme" id="rememberme" value="forever" />
						<span><?php esc_html_e( 'Remember me', 'snazzy-floret' ); ?></span>
					</label>
					<a class="sf-form__link" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot password?', 'snazzy-floret' ); ?></a>
				</div>

				<?php do_action( 'woocommerce_login_form' ); ?>
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

				<button type="submit" class="sf-form__submit" name="login" value="<?php esc_attr_e( 'Sign in', 'snazzy-floret' ); ?>"><?php esc_html_e( 'Sign in', 'snazzy-floret' ); ?></button>

				<?php if ( $sf_show_register ) : ?>
					<p class="sf-form__switch">
						<?php esc_html_e( "Don't have an account?", 'snazzy-floret' ); ?>
						<a href="#" data-sf-switch="register"><?php esc_html_e( 'Register here', 'snazzy-floret' ); ?></a>
					</p>
				<?php endif; ?>

				<?php do_action( 'woocommerce_login_form_end' ); ?>
			</form>
		</div>

		<?php if ( $sf_show_register ) : ?>
			<!-- REGISTER PANEL -->
			<div class="sf-auth__panel sf-auth__panel--register" data-sf-panel="register" hidden>
				<form method="post" class="woocommerce-form woocommerce-form-register register sf-form" <?php do_action( 'woocommerce_register_form_tag' ); ?>>
					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
						<div class="sf-form__row">
							<label for="reg_username"><?php esc_html_e( 'Username', 'snazzy-floret' ); ?></label>
							<input type="text" class="sf-form__input" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required /><?php // phpcs:ignore ?>
						</div>
					<?php endif; ?>

					<div class="sf-form__row">
						<label for="reg_email"><?php esc_html_e( 'Email address', 'snazzy-floret' ); ?></label>
						<input type="email" class="sf-form__input" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required /><?php // phpcs:ignore ?>
					</div>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
						<div class="sf-form__row">
							<label for="reg_password"><?php esc_html_e( 'Password', 'snazzy-floret' ); ?></label>
							<div class="sf-form__pwd">
								<input class="sf-form__input" type="password" name="password" id="reg_password" autocomplete="new-password" required />
								<button type="button" class="sf-form__pwd-toggle" data-sf-pwd-toggle aria-label="<?php esc_attr_e( 'Show password', 'snazzy-floret' ); ?>">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
								</button>
							</div>
						</div>
					<?php else : ?>
						<p class="sf-form__hint"><?php esc_html_e( 'A link to set a new password will be sent to your email address.', 'snazzy-floret' ); ?></p>
					<?php endif; ?>

					<p class="sf-form__hint sf-form__hint--privacy">
						<?php
						printf(
							/* translators: %s: privacy policy link */
							esc_html__( 'Your data is used to support your experience and is governed by our %s.', 'snazzy-floret' ),
							'<a href="' . esc_url( get_privacy_policy_url() ) . '">' . esc_html__( 'privacy policy', 'snazzy-floret' ) . '</a>'
						);
						?>
					</p>

					<?php do_action( 'woocommerce_register_form' ); ?>
					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>

					<button type="submit" class="sf-form__submit" name="register" value="<?php esc_attr_e( 'Create account', 'snazzy-floret' ); ?>"><?php esc_html_e( 'Create account', 'snazzy-floret' ); ?></button>

					<p class="sf-form__switch">
						<?php esc_html_e( 'Already have an account?', 'snazzy-floret' ); ?>
						<a href="#" data-sf-switch="login"><?php esc_html_e( 'Sign in', 'snazzy-floret' ); ?></a>
					</p>

					<?php do_action( 'woocommerce_register_form_end' ); ?>
				</form>
			</div>
		<?php endif; ?>
	</div>

	<aside class="sf-auth__aside" aria-hidden="true">
		<div class="sf-auth__aside-inner">
			<img class="sf-auth__aside-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Logo.svg' ); ?>" alt="<?php esc_attr_e( 'Snazzy Floret', 'snazzy-floret' ); ?>" />
			<span class="sf-auth__aside-eyebrow"><?php esc_html_e( 'Members enjoy', 'snazzy-floret' ); ?></span>
			<h2 class="sf-auth__aside-title"><?php esc_html_e( 'A wardrobe crafted for every occasion.', 'snazzy-floret' ); ?></h2>
			<ul class="sf-auth__perks">
				<li><?php esc_html_e( 'Early access to new collections', 'snazzy-floret' ); ?></li>
				<li><?php esc_html_e( 'Members-only seasonal offers', 'snazzy-floret' ); ?></li>
				<li><?php esc_html_e( 'Free delivery on orders over $75 CAD', 'snazzy-floret' ); ?></li>
				<li><?php esc_html_e( 'Custom sizing & tailoring support', 'snazzy-floret' ); ?></li>
			</ul>
		</div>
	</aside>
</div>

<script>
(function(){
	var root = document.querySelector('[data-sf-auth]');
	if(!root) return;
	var panels = root.querySelectorAll('[data-sf-panel]');
	var title = root.querySelector('[data-sf-title]');
	var subtitle = root.querySelector('[data-sf-subtitle]');
	var copy = {
		login: { t: <?php echo wp_json_encode( __( 'Welcome back', 'snazzy-floret' ) ); ?>, s: <?php echo wp_json_encode( __( 'Sign in to view your orders, wishlist, and saved addresses.', 'snazzy-floret' ) ); ?> },
		register: { t: <?php echo wp_json_encode( __( 'Create your account', 'snazzy-floret' ) ); ?>, s: <?php echo wp_json_encode( __( 'Join Snazzy Floret for early access and members-only offers.', 'snazzy-floret' ) ); ?> }
	};
	function show(name){
		panels.forEach(function(p){
			var match = p.getAttribute('data-sf-panel') === name;
			if(match){ p.removeAttribute('hidden'); } else { p.setAttribute('hidden',''); }
		});
		if(copy[name]){ if(title) title.textContent = copy[name].t; if(subtitle) subtitle.textContent = copy[name].s; }
		root.setAttribute('data-active', name);
	}
	root.querySelectorAll('[data-sf-switch]').forEach(function(a){
		a.addEventListener('click', function(e){ e.preventDefault(); show(a.getAttribute('data-sf-switch')); });
	});
	root.querySelectorAll('[data-sf-pwd-toggle]').forEach(function(btn){
		btn.addEventListener('click', function(){
			var input = btn.previousElementSibling;
			if(!input) return;
			input.type = input.type === 'password' ? 'text' : 'password';
		});
	});
	show(root.getAttribute('data-initial') || 'login');
})();
</script>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
