<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function fl_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

	register_nav_menus( array(
		'primary' => __( 'Κύριο Μενού', 'firewoodleader' ),
		'footer'  => __( 'Μενού Footer', 'firewoodleader' ),
	) );
}
add_action( 'after_setup_theme', 'fl_setup' );

function fl_scripts() {
	$fl_font_url = fl_dynamic_font_url();
	if ( $fl_font_url ) {
		wp_enqueue_style( 'fl-google-fonts', $fl_font_url, array(), null );
	}
	// filemtime() σαν version: κάθε αλλαγή στο αρχείο σπάει αυτόματα το browser cache.
	wp_enqueue_style( 'fl-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
	wp_enqueue_script( 'fl-main', get_template_directory_uri() . '/inc/main.js', array(), filemtime( get_template_directory() . '/inc/main.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'fl_scripts' );

require get_template_directory() . '/inc/defaults.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/icons.php';
require get_template_directory() . '/inc/cpt.php';
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/maintenance.php';
require get_template_directory() . '/inc/dynamic-css.php';

/**
 * Helper: επιστρέφει theme_mod με fallback.
 *
 * - Αν το πεδίο δεν έχει ΠΟΤΕ αποθηκευτεί, επιστρέφει το fallback (ή την
 *   προεπιλογή από inc/defaults.php), ώστε ένα νέο site να δείχνει καλό
 *   από την αρχή.
 * - Αν ο χρήστης το έχει αδειάσει ρητά (το έσβησε και το αποθήκευσε), το
 *   fl_opt() επιστρέφει κενό string — ΔΕΝ ξαναδείχνει την προεπιλογή. Έτσι,
 *   ό,τι σβήνεις από το Customizer εξαφανίζεται πραγματικά.
 */
function fl_opt( $key, $fallback = null ) {
	if ( null === $fallback ) {
		$defaults = fl_get_defaults();
		$fallback = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	}
	$value = get_theme_mod( $key, null );
	return ( null === $value ) ? $fallback : $value;
}

function fl_register_page_templates_titles() {
	// no-op placeholder to keep template headers documented in one place.
}

/**
 * Επιτρέπει μόνο <iframe> (για το Google Maps embed κείμενο που επικολλά ο
 * χρήστης από Customizer), κόβοντας ό,τι άλλο περιέχει το κείμενο.
 */
function fl_kses_iframe( $html ) {
	$allowed = array(
		'iframe' => array(
			'src'             => true,
			'width'           => true,
			'height'          => true,
			'style'           => true,
			'allowfullscreen' => true,
			'loading'         => true,
			'referrerpolicy'  => true,
			'frameborder'     => true,
			'title'           => true,
		),
	);
	return wp_kses( $html, $allowed );
}

/**
 * Χειρισμός φόρμας επικοινωνίας (χωρίς εξωτερικό plugin).
 * Στέλνει email στο admin email του site. Σε πολλά hosting λειτουργεί άμεσα,
 * αλλιώς συνιστάται plugin SMTP (π.χ. WP Mail SMTP) για αξιόπιστη παράδοση.
 */
function fl_handle_contact_form() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	if (
		empty( $_POST['fl_contact_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['fl_contact_nonce'] ) ), 'fl_contact_action' )
	) {
		wp_safe_redirect( add_query_arg( 'fl_sent', 'error', $redirect ) );
		exit;
	}

	// honeypot
	if ( ! empty( $_POST['fl_company'] ) ) {
		wp_safe_redirect( add_query_arg( 'fl_sent', 'ok', $redirect ) );
		exit;
	}

	$name    = isset( $_POST['fl_name'] ) ? sanitize_text_field( wp_unslash( $_POST['fl_name'] ) ) : '';
	$phone   = isset( $_POST['fl_phone_field'] ) ? sanitize_text_field( wp_unslash( $_POST['fl_phone_field'] ) ) : '';
	$email   = isset( $_POST['fl_email_field'] ) ? sanitize_email( wp_unslash( $_POST['fl_email_field'] ) ) : '';
	$message = isset( $_POST['fl_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['fl_message'] ) ) : '';

	if ( ! $name || ! $phone || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'fl_sent', 'error', $redirect ) );
		exit;
	}

	$to      = fl_opt( 'fl_email', get_option( 'admin_email' ) );
	$subject = sprintf( '[%s] Νέο μήνυμα επικοινωνίας από %s', get_bloginfo( 'name' ), $name );
	$body    = "Όνομα: $name\nΤηλέφωνο: $phone\nEmail: $email\n\nΜήνυμα:\n$message";
	$headers = array( 'Reply-To: ' . $email );

	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'fl_sent', $sent ? 'ok' : 'error', $redirect ) );
	exit;
}
add_action( 'admin_post_nopriv_fl_contact', 'fl_handle_contact_form' );
add_action( 'admin_post_fl_contact', 'fl_handle_contact_form' );
