<?php
/* Template Name: Επικοινωνία */
get_header();

$sent = isset( $_GET['fl_sent'] ) ? sanitize_text_field( wp_unslash( $_GET['fl_sent'] ) ) : '';
?>

<section class="fl-page-hero">
	<span class="fl-eyebrow"><?php echo esc_html( fl_opt( 'fl_contact_hero_eyebrow' ) ); ?></span>
	<h1><?php echo esc_html( fl_opt( 'fl_contact_hero_title' ) ); ?></h1>
</section>

<section class="fl-section">
	<div class="fl-container">

		<?php if ( 'ok' === $sent ) : ?>
			<div class="fl-notice"><?php echo esc_html( fl_opt( 'fl_contact_success_text' ) ); ?></div>
		<?php elseif ( 'error' === $sent ) : ?>
			<div class="fl-notice"><?php echo esc_html( fl_opt( 'fl_contact_error_text' ) ); ?></div>
		<?php endif; ?>

		<div class="fl-contact-grid">
			<div>
				<span class="fl-eyebrow"><?php echo esc_html( fl_opt( 'fl_contact_info_eyebrow' ) ); ?></span>
				<h2><?php echo esc_html( fl_opt( 'fl_contact_info_heading' ) ); ?></h2>
				<ul class="fl-contact-info">
					<?php if ( fl_opt( 'fl_phone' ) ) : ?>
					<li>
						<?php echo fl_icon( 'phone' ); ?>
						<div><strong><?php esc_html_e( 'Τηλέφωνο', 'firewoodleader' ); ?></strong><?php echo esc_html( fl_opt( 'fl_phone' ) ); ?></div>
					</li>
					<?php endif; ?>
					<?php if ( fl_opt( 'fl_email' ) ) : ?>
					<li>
						<?php echo fl_icon( 'mail' ); ?>
						<div><strong><?php esc_html_e( 'Email', 'firewoodleader' ); ?></strong><?php echo esc_html( fl_opt( 'fl_email' ) ); ?></div>
					</li>
					<?php endif; ?>
					<?php if ( fl_opt( 'fl_address' ) ) : ?>
					<li>
						<?php echo fl_icon( 'pin' ); ?>
						<div><strong><?php esc_html_e( 'Διεύθυνση', 'firewoodleader' ); ?></strong><?php echo esc_html( fl_opt( 'fl_address' ) ); ?></div>
					</li>
					<?php endif; ?>
					<?php if ( fl_opt( 'fl_hours_weekday' ) || fl_opt( 'fl_hours_saturday' ) || fl_opt( 'fl_hours_sunday' ) ) : ?>
					<li>
						<?php echo fl_icon( 'clock' ); ?>
						<div>
							<strong><?php esc_html_e( 'Ωράρια', 'firewoodleader' ); ?></strong>
							<?php if ( fl_opt( 'fl_hours_weekday' ) ) : ?><?php echo esc_html( fl_opt( 'fl_hours_weekday' ) ); ?><br><?php endif; ?>
							<?php if ( fl_opt( 'fl_hours_saturday' ) ) : ?><?php echo esc_html( fl_opt( 'fl_hours_saturday' ) ); ?><br><?php endif; ?>
							<?php if ( fl_opt( 'fl_hours_sunday' ) ) : ?><?php echo esc_html( fl_opt( 'fl_hours_sunday' ) ); ?><?php endif; ?>
						</div>
					</li>
					<?php endif; ?>
				</ul>
			</div>

			<div>
				<span class="fl-eyebrow"><?php echo esc_html( fl_opt( 'fl_contact_form_eyebrow' ) ); ?></span>
				<h2><?php echo esc_html( fl_opt( 'fl_contact_form_heading' ) ); ?></h2>
				<?php if ( fl_opt( 'fl_contact_form_shortcode' ) ) : ?>
					<div class="fl-form fl-form-shortcode"><?php echo do_shortcode( fl_opt( 'fl_contact_form_shortcode' ) ); ?></div>
				<?php else : ?>
					<form class="fl-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<input type="hidden" name="action" value="fl_contact">
						<?php wp_nonce_field( 'fl_contact_action', 'fl_contact_nonce' ); ?>
						<input type="text" name="fl_company" value="" style="position:absolute;left:-9999px;" tabindex="-1" autocomplete="off">

						<div class="fl-form-row">
							<div>
								<label for="fl_name"><?php esc_html_e( 'Ονοματεπώνυμο', 'firewoodleader' ); ?></label>
								<input type="text" id="fl_name" name="fl_name" required>
							</div>
							<div>
								<label for="fl_phone_field"><?php esc_html_e( 'Τηλέφωνο', 'firewoodleader' ); ?></label>
								<input type="tel" id="fl_phone_field" name="fl_phone_field" required>
							</div>
						</div>
						<div>
							<label for="fl_email_field"><?php esc_html_e( 'Email', 'firewoodleader' ); ?></label>
							<input type="email" id="fl_email_field" name="fl_email_field" required>
						</div>
						<div>
							<label for="fl_message"><?php esc_html_e( 'Μήνυμα', 'firewoodleader' ); ?></label>
							<textarea id="fl_message" name="fl_message" required></textarea>
						</div>
						<button type="submit" class="fl-btn"><?php echo esc_html( fl_opt( 'fl_contact_submit_text' ) ); ?></button>
					</form>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
