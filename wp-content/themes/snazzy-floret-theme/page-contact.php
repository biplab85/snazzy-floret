<?php
/**
 * Template for the Contact page. Auto-loaded for the page with slug "contact".
 *
 * @package Snazzy_Floret
 */

get_header();

$sf_submitted = false;
$sf_error     = '';
$sf_name      = '';
$sf_email     = '';
$sf_phone     = '';
$sf_subject   = '';
$sf_message   = '';

if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['sf_contact_nonce'] ) ) {
	if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sf_contact_nonce'] ) ), 'sf_contact_submit' ) ) {
		$sf_name    = sanitize_text_field( wp_unslash( $_POST['sf_name'] ?? '' ) );
		$sf_email   = sanitize_email( wp_unslash( $_POST['sf_email'] ?? '' ) );
		$sf_phone   = sanitize_text_field( wp_unslash( $_POST['sf_phone'] ?? '' ) );
		$sf_subject = sanitize_text_field( wp_unslash( $_POST['sf_subject'] ?? '' ) );
		$sf_message = sanitize_textarea_field( wp_unslash( $_POST['sf_message'] ?? '' ) );

		if ( $sf_name && $sf_email && $sf_message ) {
			$to      = get_option( 'admin_email' );
			$subject = sprintf( '[Snazzy Floret] %s', $sf_subject ? $sf_subject : __( 'New contact message', 'snazzy-floret' ) );
			$body    = sprintf(
				"Name: %s\nEmail: %s\nPhone: %s\n\nMessage:\n%s",
				$sf_name,
				$sf_email,
				$sf_phone,
				$sf_message
			);
			$headers = array( 'Reply-To: ' . $sf_email );
			wp_mail( $to, $subject, $body, $headers );
			$sf_submitted = true;
		} else {
			$sf_error = __( 'Please fill in your name, email, and message.', 'snazzy-floret' );
		}
	} else {
		$sf_error = __( 'Security check failed. Please try again.', 'snazzy-floret' );
	}
}
?>

<section class="sf-contact-hero">
	<div class="sf-contact-hero__bg" aria-hidden="true">
		<div class="sf-contact-hero__orb sf-contact-hero__orb--a"></div>
		<div class="sf-contact-hero__orb sf-contact-hero__orb--b"></div>
		<div class="sf-contact-hero__grid"></div>
	</div>
	<div class="sf-container">
		<nav class="sf-legal-crumbs" aria-label="<?php esc_attr_e( 'Breadcrumbs', 'snazzy-floret' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'snazzy-floret' ); ?></a>
			<span aria-hidden="true">/</span>
			<span><?php esc_html_e( 'Contact', 'snazzy-floret' ); ?></span>
		</nav>
		<div class="sf-contact-hero__inner">
			<div class="sf-contact-hero__tag">
				<span class="sf-contact-hero__icon" aria-hidden="true">
					<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
				</span>
				<span class="sf-contact-hero__eyebrow"><?php esc_html_e( 'Get in touch', 'snazzy-floret' ); ?></span>
			</div>
			<h1 class="sf-contact-hero__title"><?php esc_html_e( "Let's Talk.", 'snazzy-floret' ); ?><br><em><?php esc_html_e( 'We reply within 24 hours.', 'snazzy-floret' ); ?></em></h1>
		</div>
	</div>
</section>

<section class="sf-contact-info">
	<div class="sf-container">
		<div class="sf-contact-info__grid">
			<div class="sf-contact-card">
				<div class="sf-contact-card__icon" aria-hidden="true">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
				</div>
				<h3><?php esc_html_e( 'Call Us', 'snazzy-floret' ); ?></h3>
				<p><?php esc_html_e( 'Mon-Sat, 10am - 8pm', 'snazzy-floret' ); ?></p>
				<a href="tel:01621008533" class="sf-contact-card__link">01621-008533</a>
			</div>

			<div class="sf-contact-card">
				<div class="sf-contact-card__icon" aria-hidden="true">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
				</div>
				<h3><?php esc_html_e( 'Email Us', 'snazzy-floret' ); ?></h3>
				<p><?php esc_html_e( "We'll reply within 24 hours", 'snazzy-floret' ); ?></p>
				<a href="mailto:snazzyfloret@gmail.com" class="sf-contact-card__link">snazzyfloret@gmail.com</a>
			</div>

			<div class="sf-contact-card">
				<div class="sf-contact-card__icon" aria-hidden="true">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
				</div>
				<h3><?php esc_html_e( 'Visit Us', 'snazzy-floret' ); ?></h3>
				<p><?php esc_html_e( 'Our studio in the capital', 'snazzy-floret' ); ?></p>
				<span class="sf-contact-card__link"><?php esc_html_e( 'Dhaka, Bangladesh', 'snazzy-floret' ); ?></span>
			</div>

			<div class="sf-contact-card">
				<div class="sf-contact-card__icon" aria-hidden="true">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
				</div>
				<h3><?php esc_html_e( 'Social', 'snazzy-floret' ); ?></h3>
				<p><?php esc_html_e( 'DM us on Facebook', 'snazzy-floret' ); ?></p>
				<a href="https://www.facebook.com/snazzyfloret" target="_blank" rel="noopener" class="sf-contact-card__link">@snazzyfloret</a>
			</div>
		</div>
	</div>
</section>

<section class="sf-contact-form-section">
	<div class="sf-container">
		<div class="sf-contact-form-grid">
			<div class="sf-contact-form-aside">
				<span class="sf-contact-form-aside__eyebrow"><?php esc_html_e( 'Send a message', 'snazzy-floret' ); ?></span>
				<h2><?php esc_html_e( 'Tell us how we can help.', 'snazzy-floret' ); ?></h2>
				<p><?php esc_html_e( 'Whether it is a custom order, sizing advice, or feedback about your recent purchase — we read every message.', 'snazzy-floret' ); ?></p>
				<ul class="sf-contact-form-aside__list">
					<li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><?php esc_html_e( 'Custom tailoring & sizing help', 'snazzy-floret' ); ?></li>
					<li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><?php esc_html_e( 'Order status & tracking', 'snazzy-floret' ); ?></li>
					<li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><?php esc_html_e( 'Bulk & wholesale enquiries', 'snazzy-floret' ); ?></li>
					<li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><?php esc_html_e( 'Returns & exchanges', 'snazzy-floret' ); ?></li>
				</ul>
			</div>

			<form class="sf-contact-form" method="post" action="<?php echo esc_url( get_permalink() ); ?>">
				<?php wp_nonce_field( 'sf_contact_submit', 'sf_contact_nonce' ); ?>

				<?php if ( $sf_submitted ) : ?>
					<div class="sf-contact-alert sf-contact-alert--success">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
						<div>
							<strong><?php esc_html_e( 'Message sent!', 'snazzy-floret' ); ?></strong>
							<span><?php esc_html_e( 'Thanks for reaching out — we will get back to you within 24 hours.', 'snazzy-floret' ); ?></span>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $sf_error ) : ?>
					<div class="sf-contact-alert sf-contact-alert--error">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
						<div><span><?php echo esc_html( $sf_error ); ?></span></div>
					</div>
				<?php endif; ?>

				<div class="sf-contact-form__row">
					<div class="sf-contact-field">
						<label for="sf_name"><?php esc_html_e( 'Full Name', 'snazzy-floret' ); ?> <span aria-hidden="true">*</span></label>
						<input type="text" id="sf_name" name="sf_name" required value="<?php echo esc_attr( $sf_name ); ?>" placeholder="<?php esc_attr_e( 'Your name', 'snazzy-floret' ); ?>">
					</div>
					<div class="sf-contact-field">
						<label for="sf_email"><?php esc_html_e( 'Email', 'snazzy-floret' ); ?> <span aria-hidden="true">*</span></label>
						<input type="email" id="sf_email" name="sf_email" required value="<?php echo esc_attr( $sf_email ); ?>" placeholder="you@example.com">
					</div>
				</div>

				<div class="sf-contact-form__row">
					<div class="sf-contact-field">
						<label for="sf_phone"><?php esc_html_e( 'Phone', 'snazzy-floret' ); ?></label>
						<input type="tel" id="sf_phone" name="sf_phone" value="<?php echo esc_attr( $sf_phone ); ?>" placeholder="01XXX-XXXXXX">
					</div>
					<div class="sf-contact-field">
						<label for="sf_subject"><?php esc_html_e( 'Subject', 'snazzy-floret' ); ?></label>
						<input type="text" id="sf_subject" name="sf_subject" value="<?php echo esc_attr( $sf_subject ); ?>" placeholder="<?php esc_attr_e( 'How can we help?', 'snazzy-floret' ); ?>">
					</div>
				</div>

				<div class="sf-contact-field">
					<label for="sf_message"><?php esc_html_e( 'Message', 'snazzy-floret' ); ?> <span aria-hidden="true">*</span></label>
					<textarea id="sf_message" name="sf_message" rows="5" required placeholder="<?php esc_attr_e( 'Tell us a bit more…', 'snazzy-floret' ); ?>"><?php echo esc_textarea( $sf_message ); ?></textarea>
				</div>

				<button type="submit" class="sf-contact-form__submit">
					<span><?php esc_html_e( 'Send Message', 'snazzy-floret' ); ?></span>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
				</button>
			</form>
		</div>
	</div>
</section>

<?php get_footer(); ?>
