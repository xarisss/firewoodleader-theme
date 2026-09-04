<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Πίνακας Ελέγχου > Εμφάνιση > Προσαρμογή.
 * Προϊόντα, Υπηρεσίες και Κριτικές διαχειρίζονται πλέον από τα δικά τους
 * μενού στο wp-admin (βλ. inc/cpt.php) — εδώ μένουν μόνο τα γενικά στοιχεία.
 */
function fl_customize_register( $wp_customize ) {
	$d = fl_get_defaults();

	// ---------- Χρώματα & Γραμματοσειρές ----------
	$wp_customize->add_section( 'fl_design_section', array(
		'title'    => __( 'Χρώματα & Γραμματοσειρές', 'firewoodleader' ),
		'priority' => 2,
	) );

	$color_fields = array(
		'fl_color_primary'      => array( 'label' => 'Κύριο Χρώμα (κόκκινο)', 'default' => $d['fl_color_primary'] ),
		'fl_color_primary_dark' => array( 'label' => 'Κύριο Χρώμα - Σκούρα απόχρωση (hover)', 'default' => $d['fl_color_primary_dark'] ),
		'fl_color_dark'         => array( 'label' => 'Σκούρο Χρώμα (μαύρο/φόντα)', 'default' => $d['fl_color_dark'] ),
		'fl_color_cream'        => array( 'label' => 'Ανοιχτό Χρώμα Φόντου', 'default' => $d['fl_color_cream'] ),
	);
	foreach ( $color_fields as $id => $field ) {
		$wp_customize->add_setting( $id, array(
			'default'           => $field['default'],
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
			'label'   => __( $field['label'], 'firewoodleader' ),
			'section' => 'fl_design_section',
		) ) );
	}

	/*
	 * Μόνο γραμματοσειρές που έχουν ελεγχθεί ότι περιλαμβάνουν πραγματικά
	 * ελληνικούς χαρακτήρες στο Google Fonts (πολλές δημοφιλείς όπως η
	 * Oswald, Montserrat, Poppins, Raleway, Lato ΔΕΝ έχουν ελληνικά, οπότε
	 * αποκλείστηκαν — αλλιώς τα ελληνικά κείμενα εμφανίζονται σε άλλη
	 * γραμματοσειρά από τα αγγλικά).
	 */
	$system_font_choices = array(
		'Arial'           => 'Arial (system)',
		'Tahoma'          => 'Tahoma (system)',
		'Times New Roman' => 'Times New Roman (system)',
		'Verdana'         => 'Verdana (system)',
		'Georgia'         => 'Georgia (system)',
		'Trebuchet MS'    => 'Trebuchet MS (system)',
	);
	$font_choices = $system_font_choices + array(
		'Roboto Slab'     => 'Roboto Slab',
		'Noto Serif'      => 'Noto Serif',
		'Alegreya'        => 'Alegreya',
		'Cardo'           => 'Cardo',
		'Tinos'           => 'Tinos',
		'Comfortaa'       => 'Comfortaa',
		'EB Garamond'     => 'EB Garamond',
		'Vollkorn'        => 'Vollkorn',
		'GFS Didot'       => 'GFS Didot (ελληνική)',
		'GFS Neohellenic' => 'GFS Neohellenic (ελληνική)',
		'Noto Sans'       => 'Noto Sans',
		'IBM Plex Sans'   => 'IBM Plex Sans',
	);
	$body_font_choices = $system_font_choices + array(
		'Inter'         => 'Inter',
		'Roboto'        => 'Roboto',
		'Open Sans'     => 'Open Sans',
		'Source Sans 3' => 'Source Sans 3',
		'Manrope'       => 'Manrope',
		'Fira Sans'     => 'Fira Sans',
		'Noto Sans'     => 'Noto Sans',
		'IBM Plex Sans' => 'IBM Plex Sans',
		'Arimo'         => 'Arimo',
		'Ubuntu'        => 'Ubuntu',
		'Alegreya Sans' => 'Alegreya Sans',
	);

	$wp_customize->add_setting( 'fl_font_heading', array(
		'default'           => $d['fl_font_heading'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'fl_font_heading', array(
		'label'   => __( 'Γραμματοσειρά Τίτλων', 'firewoodleader' ),
		'section' => 'fl_design_section',
		'type'    => 'select',
		'choices' => $font_choices,
	) );

	$wp_customize->add_setting( 'fl_font_body', array(
		'default'           => $d['fl_font_body'],
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'fl_font_body', array(
		'label'   => __( 'Γραμματοσειρά Κειμένου', 'firewoodleader' ),
		'section' => 'fl_design_section',
		'type'    => 'select',
		'choices' => $body_font_choices,
	) );

	$wp_customize->add_setting( 'fl_font_heading_bold', array(
		'default'           => $d['fl_font_heading_bold'],
		'sanitize_callback' => 'rest_sanitize_boolean',
	) );
	$wp_customize->add_control( 'fl_font_heading_bold', array(
		'label'   => __( 'Έντονοι (bold) τίτλοι', 'firewoodleader' ),
		'section' => 'fl_design_section',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'fl_font_body_bold', array(
		'default'           => $d['fl_font_body_bold'],
		'sanitize_callback' => 'rest_sanitize_boolean',
	) );
	$wp_customize->add_control( 'fl_font_body_bold', array(
		'label'   => __( 'Έντονο (bold) κείμενο', 'firewoodleader' ),
		'section' => 'fl_design_section',
		'type'    => 'checkbox',
	) );

	// ---------- Εικονίδια ----------
	$wp_customize->add_section( 'fl_icons_section', array(
		'title'    => __( 'Εικονίδια', 'firewoodleader' ),
		'priority' => 3,
	) );

	foreach ( fl_icon_override_keys() as $key => $label ) {
		$preview = '<span class="fl-icon-current-preview">' . fl_icon( $key ) . '</span>'
			. '<span class="fl-icon-current-label">' . esc_html__( 'Τρέχον εικονίδιο - ανέβασε παρακάτω για να το αντικαταστήσεις', 'firewoodleader' ) . '</span>';
		fl_add_image_control( $wp_customize, "fl_icon_override_{$key}", $label, 'fl_icons_section', '', $preview );
	}

	// ---------- Υπό Κατασκευή ----------
	$wp_customize->add_section( 'fl_maintenance_section', array(
		'title'    => __( 'Υπό Κατασκευή', 'firewoodleader' ),
		'priority' => 1,
	) );

	$wp_customize->add_setting( 'fl_maintenance_mode', array(
		'default'           => false,
		'sanitize_callback' => 'rest_sanitize_boolean',
	) );
	$wp_customize->add_control( 'fl_maintenance_mode', array(
		'label'       => __( 'Ενεργοποίηση λειτουργίας "Υπό Κατασκευή"', 'firewoodleader' ),
		'description' => __( 'Οι επισκέπτες θα βλέπουν μια σελίδα "Υπό Κατασκευή" αντί για το site. Εσύ (συνδεδεμένος ως admin) συνεχίζεις να βλέπεις κανονικά το site.', 'firewoodleader' ),
		'section'     => 'fl_maintenance_section',
		'type'        => 'checkbox',
	) );

	fl_add_text_control( $wp_customize, 'fl_maintenance_title', 'Τίτλος στη σελίδα "Υπό Κατασκευή" (όταν δεν υπάρχει λογότυπο εικόνας)', 'fl_maintenance_section', $d['fl_maintenance_title'] );
	fl_add_textarea_control( $wp_customize, 'fl_maintenance_message', 'Μήνυμα στη σελίδα "Υπό Κατασκευή"', 'fl_maintenance_section', $d['fl_maintenance_message'] );

	// ---------- Στοιχεία Εταιρίας ----------
	$wp_customize->add_section( 'fl_company_info', array(
		'title'    => __( 'Στοιχεία Εταιρίας', 'firewoodleader' ),
		'priority' => 30,
	) );

	$text_labels = array(
		'fl_phone'          => 'Τηλέφωνο',
		'fl_phone2'         => 'Κινητό',
		'fl_email'          => 'Email',
		'fl_address'        => 'Διεύθυνση',
		'fl_hours_weekday'  => 'Ωράριο Δευτέρα-Παρασκευή',
		'fl_hours_saturday' => 'Ωράριο Σάββατο',
		'fl_hours_sunday'   => 'Ωράριο Κυριακή',
		'fl_facebook'       => 'Facebook URL',
		'fl_instagram'      => 'Instagram URL',
		'fl_maps_query'     => 'Διεύθυνση για Google Maps',
	);

	foreach ( $text_labels as $id => $label ) {
		fl_add_text_control( $wp_customize, $id, $label, 'fl_company_info', isset( $d[ $id ] ) ? $d[ $id ] : '' );
	}

	// ---------- Hero Εικόνα ----------
	$wp_customize->add_section( 'fl_hero_section', array(
		'title'    => __( 'Κεντρική Φωτογραφία (Hero)', 'firewoodleader' ),
		'priority' => 31,
	) );

	fl_add_image_control( $wp_customize, 'fl_hero_image', 'Κεντρική φωτογραφία αρχικής σελίδας', 'fl_hero_section', $d['fl_hero_image'] );
	fl_add_range_control( $wp_customize, 'fl_hero_image_height', 'Μέγιστο ύψος φωτογραφίας (px)', 'fl_hero_section', $d['fl_hero_image_height'], 200, 900 );

	// ---------- Header & Footer ----------
	$wp_customize->add_section( 'fl_header_footer_section', array(
		'title'    => __( 'Header & Footer', 'firewoodleader' ),
		'priority' => 29,
	) );

	fl_add_image_control( $wp_customize, 'fl_logo_image', 'Λογότυπο Header (εικόνα) - αν το ανεβάσεις, αντικαθιστά το παρακάτω κείμενο', 'fl_header_footer_section', '' );
	fl_add_range_control( $wp_customize, 'fl_logo_height', 'Ύψος λογότυπου Header (px)', 'fl_header_footer_section', $d['fl_logo_height'], 20, 150 );
	fl_add_image_control( $wp_customize, 'fl_footer_logo_image', 'Λογότυπο Footer (εικόνα) - αν μείνει κενό, χρησιμοποιείται το λογότυπο του Header', 'fl_header_footer_section', '' );
	fl_add_range_control( $wp_customize, 'fl_footer_logo_height', 'Ύψος λογότυπου Footer (px)', 'fl_header_footer_section', $d['fl_footer_logo_height'], 20, 150 );
	fl_add_text_control( $wp_customize, 'fl_logo_part1', 'Λογότυπο κειμένου - Μέρος 1 (μαύρο)', 'fl_header_footer_section', $d['fl_logo_part1'] );
	fl_add_text_control( $wp_customize, 'fl_logo_part2', 'Λογότυπο κειμένου - Μέρος 2 (κόκκινο)', 'fl_header_footer_section', $d['fl_logo_part2'] );
	fl_add_textarea_control( $wp_customize, 'fl_footer_tagline', 'Footer - Σύντομη περιγραφή εταιρίας', 'fl_header_footer_section', $d['fl_footer_tagline'] );
	fl_add_text_control( $wp_customize, 'fl_footer_legal', 'Footer - Κείμενο πνευματικών δικαιωμάτων (μετά τη χρονολογία)', 'fl_header_footer_section', $d['fl_footer_legal'] );
	fl_add_text_control( $wp_customize, 'fl_footer_location', 'Footer - Τοποθεσία (κάτω δεξιά)', 'fl_header_footer_section', $d['fl_footer_location'] );
	fl_add_text_control( $wp_customize, 'fl_footer_location_url', 'Footer - Σύνδεσμος τοποθεσίας (προαιρετικό - κάνει το κείμενο πάνω clickable link)', 'fl_header_footer_section', '' );

	// ---------- Αρχική Σελίδα ----------
	$wp_customize->add_section( 'fl_homepage_section', array(
		'title'    => __( 'Αρχική Σελίδα - Κείμενα', 'firewoodleader' ),
		'priority' => 36,
	) );

	fl_add_text_control( $wp_customize, 'fl_hero_cta_text', 'Κείμενο κουμπιού κάτω από το Hero', 'fl_homepage_section', $d['fl_hero_cta_text'] );

	$wp_customize->add_setting( 'fl_features_bar_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
	) );
	$wp_customize->add_control( 'fl_features_bar_enabled', array(
		'label'       => __( 'Εμφάνιση μπάρας πλεονεκτημάτων (κάτω από το Hero)', 'firewoodleader' ),
		'description' => __( 'Απενεργοποίησέ το αν θεωρείς ότι επικαλύπτεται με την ενότητα "Γιατί Εμάς" παρακάτω.', 'firewoodleader' ),
		'section'     => 'fl_homepage_section',
		'type'        => 'checkbox',
	) );

	for ( $i = 1; $i <= 4; $i++ ) {
		fl_add_text_control( $wp_customize, "fl_feature_{$i}_title", "Πλεονέκτημα {$i} - Τίτλος", 'fl_homepage_section', $d["fl_feature_{$i}_title"] );
		fl_add_text_control( $wp_customize, "fl_feature_{$i}_desc", "Πλεονέκτημα {$i} - Υπότιτλος", 'fl_homepage_section', $d["fl_feature_{$i}_desc"] );
	}

	$section_headings = array(
		'products'     => 'Ενότητα Προϊόντων',
		'services'     => 'Ενότητα Υπηρεσιών',
		'testimonials' => 'Ενότητα Κριτικών',
		'gallery'      => 'Ενότητα Gallery',
		'map'          => 'Ενότητα Χάρτη',
	);
	foreach ( $section_headings as $key => $label ) {
		fl_add_text_control( $wp_customize, "fl_{$key}_eyebrow", "{$label} - Μικρός τίτλος (πάνω)", 'fl_homepage_section', $d["fl_{$key}_eyebrow"] );
		fl_add_text_control( $wp_customize, "fl_{$key}_heading", "{$label} - Κύριος τίτλος", 'fl_homepage_section', $d["fl_{$key}_heading"] );
	}

	fl_add_range_control( $wp_customize, 'fl_home_products_count', 'Ενότητα Προϊόντων - Πόσα προϊόντα να φαίνονται στο carousel', 'fl_homepage_section', $d['fl_home_products_count'], 1, 20 );
	fl_add_range_control( $wp_customize, 'fl_home_services_count', 'Ενότητα Υπηρεσιών - Πόσες υπηρεσίες να φαίνονται στο carousel', 'fl_homepage_section', $d['fl_home_services_count'], 1, 20 );

	fl_add_html_control( $wp_customize, 'fl_map_embed_code', 'Ενότητα Χάρτη - Κώδικας Google Maps (επικόλλησε εδώ το <iframe> από Google Maps → Κοινοποίηση → Ενσωμάτωση χάρτη)', 'fl_homepage_section', $d['fl_map_embed_code'] );
	fl_add_text_control( $wp_customize, 'fl_map_address_text', 'Ενότητα Χάρτη - Κείμενο διεύθυνσης δίπλα στον χάρτη', 'fl_homepage_section', $d['fl_map_address_text'] );
	fl_add_text_control( $wp_customize, 'fl_map_directions_url', 'Ενότητα Χάρτη - Σύνδεσμος κουμπιού "Οδηγίες" (επικόλλησε link Google Maps)', 'fl_homepage_section', '' );

	// ---------- Αρχική - Γιατί Εμάς ----------
	$wp_customize->add_section( 'fl_sellingpoints_section', array(
		'title'    => __( 'Αρχική - Γιατί Εμάς', 'firewoodleader' ),
		'priority' => 36,
	) );

	fl_add_text_control( $wp_customize, 'fl_sellingpoints_eyebrow', 'Μικρός τίτλος (πάνω)', 'fl_sellingpoints_section', $d['fl_sellingpoints_eyebrow'] );
	fl_add_text_control( $wp_customize, 'fl_sellingpoints_heading', 'Κύριος τίτλος', 'fl_sellingpoints_section', $d['fl_sellingpoints_heading'] );

	for ( $i = 1; $i <= 8; $i++ ) {
		fl_add_text_control( $wp_customize, "fl_sellingpoint_{$i}_title", "Σημείο {$i} - Τίτλος (άδειασέ το για να μη φαίνεται καθόλου)", 'fl_sellingpoints_section', $d["fl_sellingpoint_{$i}_title"] );
		fl_add_textarea_control( $wp_customize, "fl_sellingpoint_{$i}_desc", "Σημείο {$i} - Περιγραφή", 'fl_sellingpoints_section', $d["fl_sellingpoint_{$i}_desc"] );
	}

	// ---------- Σελίδα Επικοινωνίας ----------
	$wp_customize->add_section( 'fl_contact_page_section', array(
		'title'    => __( 'Σελίδα Επικοινωνίας', 'firewoodleader' ),
		'priority' => 37,
	) );

	$contact_fields = array(
		'fl_contact_hero_eyebrow' => 'Πάνω μέρος - Μικρός τίτλος',
		'fl_contact_hero_title'   => 'Πάνω μέρος - Κύριος τίτλος',
		'fl_contact_info_eyebrow' => 'Στοιχεία - Μικρός τίτλος',
		'fl_contact_info_heading' => 'Στοιχεία - Κύριος τίτλος',
		'fl_contact_form_eyebrow' => 'Φόρμα - Μικρός τίτλος',
		'fl_contact_form_heading' => 'Φόρμα - Κύριος τίτλος',
		'fl_contact_submit_text'  => 'Κείμενο κουμπιού αποστολής',
		'fl_contact_success_text' => 'Μήνυμα επιτυχούς αποστολής',
		'fl_contact_error_text'   => 'Μήνυμα αποτυχίας αποστολής',
	);
	foreach ( $contact_fields as $id => $label ) {
		fl_add_text_control( $wp_customize, $id, $label, 'fl_contact_page_section', $d[ $id ] );
	}

	fl_add_text_control(
		$wp_customize,
		'fl_contact_form_shortcode',
		'Shortcode εξωτερικής φόρμας (π.χ. από Contact Form 7 ή WPForms) - αν το συμπληρώσεις, αντικαθιστά την ενσωματωμένη φόρμα',
		'fl_contact_page_section',
		''
	);

	// ---------- Σελίδες Προϊόντων & Υπηρεσιών ----------
	$wp_customize->add_section( 'fl_products_services_cta_section', array(
		'title'    => __( 'Προϊόντα & Υπηρεσίες - CTA πάνω από το footer', 'firewoodleader' ),
		'priority' => 38,
	) );

	fl_add_text_control( $wp_customize, 'fl_products_cta_heading', 'Προϊόντα - Κείμενο (άδειασέ το για να μη φαίνεται καθόλου η ενότητα)', 'fl_products_services_cta_section', $d['fl_products_cta_heading'] );
	fl_add_text_control( $wp_customize, 'fl_products_cta_button_text', 'Προϊόντα - Κείμενο κουμπιού (άδειασέ το για να φύγει μόνο το κουμπί)', 'fl_products_services_cta_section', $d['fl_products_cta_button_text'] );
	fl_add_text_control( $wp_customize, 'fl_services_cta_heading', 'Υπηρεσίες - Κείμενο (άδειασέ το για να μη φαίνεται καθόλου η ενότητα)', 'fl_products_services_cta_section', $d['fl_services_cta_heading'] );
	fl_add_text_control( $wp_customize, 'fl_services_cta_button_text', 'Υπηρεσίες - Κείμενο κουμπιού (άδειασέ το για να φύγει μόνο το κουμπί)', 'fl_products_services_cta_section', $d['fl_services_cta_button_text'] );
}
add_action( 'customize_register', 'fl_customize_register' );

function fl_add_text_control( $wp_customize, $id, $label, $section, $default ) {
	$wp_customize->add_setting( $id, array(
		'default'           => $default,
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( $id, array(
		'label'   => __( $label, 'firewoodleader' ),
		'section' => $section,
		'type'    => 'text',
	) );
}

function fl_add_textarea_control( $wp_customize, $id, $label, $section, $default ) {
	$wp_customize->add_setting( $id, array(
		'default'           => $default,
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( $id, array(
		'label'   => __( $label, 'firewoodleader' ),
		'section' => $section,
		'type'    => 'textarea',
	) );
}

function fl_add_html_control( $wp_customize, $id, $label, $section, $default ) {
	$wp_customize->add_setting( $id, array(
		'default'           => $default,
		'sanitize_callback' => 'fl_kses_iframe',
	) );
	$wp_customize->add_control( $id, array(
		'label'   => __( $label, 'firewoodleader' ),
		'section' => $section,
		'type'    => 'textarea',
	) );
}

function fl_add_range_control( $wp_customize, $id, $label, $section, $default, $min, $max ) {
	$wp_customize->add_setting( $id, array(
		'default'           => $default,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( $id, array(
		'label'       => __( $label, 'firewoodleader' ),
		'section'     => $section,
		'type'        => 'range',
		'input_attrs' => array( 'min' => $min, 'max' => $max, 'step' => 1 ),
	) );
}

function fl_add_image_control( $wp_customize, $id, $label, $section, $default, $preview = '' ) {
	$wp_customize->add_setting( $id, array(
		'default'           => $default,
		'sanitize_callback' => 'esc_url_raw',
	) );
	$args = array(
		'label'    => __( $label, 'firewoodleader' ),
		'section'  => $section,
		'settings' => $id,
	);
	if ( $preview ) {
		$args['description'] = $preview;
	}
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, $args ) );
}

/**
 * Μικρό CSS μέσα στο πάνελ του Customizer, ώστε το preview του τρέχοντος
 * εικονιδίου (βλ. fl_icon_override_* πεδία) να εμφανίζεται σε λογικό μέγεθος.
 */
function fl_customize_controls_css() {
	?>
	<style>
		.fl-icon-current-preview{display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;padding:6px;margin-bottom:4px;border:1px solid #ddd;border-radius:6px;background:#fff;box-sizing:border-box;}
		.fl-icon-current-preview svg{width:100%;height:100%;fill:#23282d;}
		.fl-icon-current-preview img{width:100%;height:100%;object-fit:contain;}
		.fl-icon-current-label{display:block;font-size:11px;color:#666;}
	</style>
	<?php
}
add_action( 'customize_controls_print_styles', 'fl_customize_controls_css' );
