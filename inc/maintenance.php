<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Λειτουργία "Υπό Κατασκευή". Ενεργοποιείται από Εμφάνιση → Προσαρμογή →
 * Υπό Κατασκευή. Οι συνδεδεμένοι διαχειριστές βλέπουν πάντα το κανονικό site,
 * ώστε να μπορούν να συνεχίσουν την επεξεργασία του.
 */
function fl_maintenance_mode_check() {
	if ( ! get_theme_mod( 'fl_maintenance_mode', false ) ) {
		return;
	}

	if ( current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	status_header( 503 );
	nocache_headers();
	header( 'Retry-After: 3600' );

	$img      = get_template_directory_uri() . '/assets/img/';
	$logo     = fl_opt( 'fl_logo_image' );
	$title    = fl_opt( 'fl_maintenance_title', get_bloginfo( 'name' ) );
	$message  = fl_opt( 'fl_maintenance_message' );
	$phone    = fl_opt( 'fl_phone' );
	$email    = fl_opt( 'fl_email' );
	$facebook = fl_opt( 'fl_facebook' );
	$instagram = fl_opt( 'fl_instagram' );
	$primary  = fl_opt( 'fl_color_primary' );
	$dark     = fl_opt( 'fl_color_dark' );
	$heading_font = fl_opt( 'fl_font_heading' );
	$body_font    = fl_opt( 'fl_font_body' );
	?>
	<!DOCTYPE html>
	<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="noindex, nofollow">
		<title><?php echo esc_html( $title ); ?> — <?php esc_html_e( 'Υπό Κατασκευή', 'firewoodleader' ); ?></title>
		<link rel="stylesheet" href="<?php echo esc_url( fl_dynamic_font_url() ); ?>">
		<style>
			:root{--fl-red:<?php echo esc_html( $primary ); ?>;--fl-black:<?php echo esc_html( $dark ); ?>;}
			*{box-sizing:border-box;}
			body{
				margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;
				background:radial-gradient(circle at 50% 20%, color-mix(in srgb, var(--fl-black) 80%, #fff 10%) 0%, var(--fl-black) 60%);
				font-family:'<?php echo esc_html( $body_font ); ?>',sans-serif;color:#fff;text-align:center;padding:24px;
			}
			.wrap{max-width:560px;}
			.flame{width:64px;height:64px;margin:0 auto 24px;}
			.flame svg{width:100%;height:100%;fill:var(--fl-red);}
			.flame img{width:100%;height:100%;object-fit:contain;}
			img.logo{max-height:60px;margin:0 auto 28px;display:block;margin-left:auto;margin-right:auto;}
			h1{font-family:'<?php echo esc_html( $heading_font ); ?>',sans-serif;font-weight:700;text-transform:uppercase;font-size:clamp(1.6rem,5vw,2.4rem);letter-spacing:.5px;margin:0 0 18px;}
			p{color:#cfc7bf;font-size:1.05rem;line-height:1.6;margin:0 0 30px;white-space:pre-line;}
			.contact{display:flex;gap:24px;justify-content:center;flex-wrap:wrap;font-weight:600;font-size:.95rem;margin-bottom:22px;}
			.contact a{color:#fff;text-decoration:none;border-bottom:1px solid var(--fl-red);padding-bottom:2px;}
			.social{display:flex;gap:12px;justify-content:center;}
			.social a{width:38px;height:38px;border-radius:50%;border:1px solid rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;}
			.social a:hover{background:var(--fl-red);border-color:var(--fl-red);}
			.social svg{width:16px;height:16px;fill:#fff;}
		</style>
	</head>
	<body>
		<div class="wrap">
			<?php if ( $logo ) : ?>
				<img class="logo" src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $title ); ?>">
			<?php else : ?>
				<div class="flame"><?php echo fl_icon( 'flame' ); ?></div>
				<h1><?php echo esc_html( $title ); ?></h1>
			<?php endif; ?>
			<p><?php echo esc_html( $message ); ?></p>
			<?php if ( $phone || $email ) : ?>
			<div class="contact">
				<?php if ( $phone ) : ?><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a><?php endif; ?>
				<?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a><?php endif; ?>
			</div>
			<?php endif; ?>
			<?php if ( $facebook || $instagram ) : ?>
			<div class="social">
				<?php if ( $facebook ) : ?><a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php echo fl_icon( 'fb' ); ?></a><?php endif; ?>
				<?php if ( $instagram ) : ?><a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo fl_icon( 'ig' ); ?></a><?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</body>
	</html>
	<?php
	exit;
}
add_action( 'template_redirect', 'fl_maintenance_mode_check' );

/**
 * Μικρή ειδοποίηση στην κορυφή για τον συνδεδεμένο admin, ώστε να θυμάται
 * ότι η λειτουργία "Υπό Κατασκευή" είναι ενεργή (οι επισκέπτες δεν βλέπουν αυτό).
 */
function fl_maintenance_admin_notice() {
	if ( ! get_theme_mod( 'fl_maintenance_mode', false ) || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	?>
	<div style="background:#c8102e;color:#fff;text-align:center;padding:10px 16px;font-size:.85rem;font-weight:700;letter-spacing:.3px;">
		<?php esc_html_e( '⚠ Η λειτουργία "Υπό Κατασκευή" είναι ΕΝΕΡΓΗ — οι επισκέπτες βλέπουν τη σελίδα "Υπό Κατασκευή" αντί για το site. Μόνο εσύ βλέπεις κανονικά. Απενεργοποίησέ το από Εμφάνιση → Προσαρμογή → Υπό Κατασκευή.', 'firewoodleader' ); ?>
	</div>
	<?php
}
add_action( 'wp_body_open', 'fl_maintenance_admin_notice' );
