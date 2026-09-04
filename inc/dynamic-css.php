<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Γραμματοσειρές που είναι ήδη εγκατεστημένες σε κάθε υπολογιστή/κινητό
 * (system fonts) και υποστηρίζουν πλήρως ελληνικά + λατινικά. Δεν χρειάζεται
 * να φορτωθούν από το Google Fonts.
 */
function fl_system_fonts() {
	return array( 'Arial', 'Tahoma', 'Times New Roman', 'Verdana', 'Georgia', 'Trebuchet MS' );
}

/**
 * Φορτώνει τη Google Font που επέλεξε ο χρήστης (Εμφάνιση → Προσαρμογή →
 * Χρώματα & Γραμματοσειρές) αντί για τη σταθερή Oswald/Inter. Αν έχει
 * επιλεγεί system font (π.χ. Arial), δεν χρειάζεται να φορτωθεί τίποτα.
 */
function fl_dynamic_font_url() {
	$heading = fl_opt( 'fl_font_heading' );
	$body    = fl_opt( 'fl_font_body' );
	$system  = fl_system_fonts();

	$families = array();
	if ( ! in_array( $heading, $system, true ) ) {
		$families[] = rawurlencode( $heading ) . ':wght@400;500;600;700';
	}
	if ( ! in_array( $body, $system, true ) ) {
		$families[] = rawurlencode( $body ) . ':wght@400;500;600;700';
	}

	if ( ! $families ) {
		return '';
	}

	return 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', $families ) . '&display=swap';
}

/**
 * Παράγει inline CSS που αντικαθιστά τα χρώματα (CSS variables) και τις
 * γραμματοσειρές του theme με ό,τι έχει επιλέξει ο χρήστης.
 */
function fl_dynamic_css() {
	$primary      = fl_opt( 'fl_color_primary' );
	$primary_dark = fl_opt( 'fl_color_primary_dark' );
	$dark         = fl_opt( 'fl_color_dark' );
	$cream        = fl_opt( 'fl_color_cream' );
	$heading_font = fl_opt( 'fl_font_heading' );
	$body_font    = fl_opt( 'fl_font_body' );
	$heading_bold = fl_opt( 'fl_font_heading_bold' );
	$body_bold    = fl_opt( 'fl_font_body_bold' );
	?>
	<style id="fl-dynamic-css">
		:root{
			--fl-red: <?php echo esc_html( $primary ); ?>;
			--fl-red-dark: <?php echo esc_html( $primary_dark ); ?>;
			--fl-black: <?php echo esc_html( $dark ); ?>;
			--fl-cream: <?php echo esc_html( $cream ); ?>;
		}
		body{ font-family:'<?php echo esc_html( $body_font ); ?>',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif; font-weight: <?php echo $body_bold ? '700' : '400'; ?>; }
		h1,h2,h3,h4{ font-family:'<?php echo esc_html( $heading_font ); ?>',Impact,'Arial Narrow',sans-serif; font-weight: <?php echo $heading_bold ? '700' : '500'; ?>; }
		.fl-logo,.fl-btn,.fl-feature-text strong{ font-family:'<?php echo esc_html( $heading_font ); ?>',Impact,'Arial Narrow',sans-serif; }
	</style>
	<?php
}
add_action( 'wp_head', 'fl_dynamic_css', 20 );
