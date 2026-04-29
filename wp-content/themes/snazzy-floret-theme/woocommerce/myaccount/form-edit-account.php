<?php
/**
 * My Account — Edit Account form (Snazzy Floret premium override).
 *
 * @package Snazzy_Floret
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' );
?>

<div class="sf-account-section">
	<div class="sf-account-section__head">
		<h2 class="sf-account-section__title"><?php esc_html_e( 'Account Details', 'snazzy-floret' ); ?></h2>
		<p class="sf-account-section__sub"><?php esc_html_e( 'Update your personal information and password.', 'snazzy-floret' ); ?></p>
	</div>

	<form class="sf-account-form woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?>>
		<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

		<fieldset class="sf-account-form__group">
			<legend class="sf-account-form__legend"><?php esc_html_e( 'Personal Information', 'snazzy-floret' ); ?></legend>

			<div class="sf-account-form__row">
				<div class="sf-field">
					<label for="account_first_name"><?php esc_html_e( 'First name', 'snazzy-floret' ); ?> <span aria-hidden="true">*</span></label>
					<input type="text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" required />
				</div>
				<div class="sf-field">
					<label for="account_last_name"><?php esc_html_e( 'Last name', 'snazzy-floret' ); ?> <span aria-hidden="true">*</span></label>
					<input type="text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" required />
				</div>
			</div>

			<div class="sf-field">
				<label for="account_display_name"><?php esc_html_e( 'Display name', 'snazzy-floret' ); ?> <span aria-hidden="true">*</span></label>
				<input type="text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" required />
				<small><?php esc_html_e( 'How your name appears in your account and reviews.', 'snazzy-floret' ); ?></small>
			</div>

			<div class="sf-field">
				<label for="account_email"><?php esc_html_e( 'Email address', 'snazzy-floret' ); ?> <span aria-hidden="true">*</span></label>
				<input type="email" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" required />
			</div>

			<?php do_action( 'woocommerce_edit_account_form_fields' ); ?>
		</fieldset>

		<fieldset class="sf-account-form__group">
			<legend class="sf-account-form__legend"><?php esc_html_e( 'Change Password', 'snazzy-floret' ); ?></legend>
			<p class="sf-account-form__hint"><?php esc_html_e( 'Leave the fields blank to keep your current password.', 'snazzy-floret' ); ?></p>

			<div class="sf-field">
				<label for="password_current"><?php esc_html_e( 'Current password', 'snazzy-floret' ); ?></label>
				<input type="password" name="password_current" id="password_current" autocomplete="current-password" />
			</div>

			<div class="sf-account-form__row">
				<div class="sf-field">
					<label for="password_1"><?php esc_html_e( 'New password', 'snazzy-floret' ); ?></label>
					<input type="password" name="password_1" id="password_1" autocomplete="new-password" />
				</div>
				<div class="sf-field">
					<label for="password_2"><?php esc_html_e( 'Confirm new password', 'snazzy-floret' ); ?></label>
					<input type="password" name="password_2" id="password_2" autocomplete="new-password" />
				</div>
			</div>
		</fieldset>

		<?php do_action( 'woocommerce_edit_account_form' ); ?>

		<div class="sf-account-form__actions">
			<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
			<button type="submit" class="sf-btn sf-btn--primary" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'snazzy-floret' ); ?>"><?php esc_html_e( 'Save Changes', 'snazzy-floret' ); ?></button>
			<a class="sf-btn sf-btn--ghost" href="<?php echo esc_url( wc_get_endpoint_url( 'dashboard' ) ); ?>"><?php esc_html_e( 'Cancel', 'snazzy-floret' ); ?></a>
			<input type="hidden" name="action" value="save_account_details" />
		</div>

		<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
	</form>
</div>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
