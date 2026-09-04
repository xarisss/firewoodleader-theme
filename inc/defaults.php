<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Μία κεντρική λίστα με τις προεπιλεγμένες τιμές των γενικών ρυθμίσεων
 * (στοιχεία εταιρίας, hero, Η Εταιρεία). Χρησιμοποιείται και από το
 * Customizer (inc/customizer.php) και από το fl_opt() (functions.php).
 * Προϊόντα/Υπηρεσίες/Κριτικές πλέον είναι custom post types (inc/cpt.php).
 */
function fl_get_defaults() {
	$img = get_template_directory_uri() . '/assets/img/';

	return array(
		'fl_color_primary'      => '#c8102e',
		'fl_color_primary_dark' => '#9c0c22',
		'fl_color_dark'         => '#171412',
		'fl_color_cream'        => '#f6f1ea',
		'fl_font_heading'       => 'Roboto Slab',
		'fl_font_body'          => 'Inter',
		'fl_font_heading_bold'  => true,
		'fl_font_body_bold'     => false,

		'fl_phone'          => '2310 808 111',
		'fl_phone2'         => '6970 760 283',
		'fl_email'          => 'firewoodleader@gmail.com',
		'fl_address'        => '1,4 χλμ. Συμμαχικής οδού, Ωραιόκαστρο',
		'fl_hours_weekday'  => 'Δευτέρα - Παρασκευή: 08:00 - 17:00',
		'fl_hours_saturday' => 'Σάββατο: 08:00 - 14:00',
		'fl_hours_sunday'   => 'Κυριακή: Κλειστά',
		'fl_facebook'       => '',
		'fl_instagram'      => '',
		'fl_maps_query'     => '1,4 χλμ. Συμμαχικής οδού, Ωραιόκαστρο',

		'fl_maintenance_title'   => get_bloginfo( 'name' ),
		'fl_maintenance_message' => 'Ετοιμάζουμε κάτι νέο για σένα. Το site μας θα είναι σύντομα ξανά online!',

		'fl_map_embed_code'   => '',
		'fl_map_address_text' => '1,4 χλμ. Συμμαχικής οδού, Ωραιόκαστρο',

		// Σελίδα Επικοινωνίας
		'fl_contact_hero_eyebrow'  => 'Επικοινωνία',
		'fl_contact_hero_title'    => 'Μίλα μαζί μας',
		'fl_contact_info_eyebrow'  => 'Στοιχεία',
		'fl_contact_info_heading'  => 'Στοιχεία Επικοινωνίας',
		'fl_contact_form_eyebrow'  => 'Φόρμα',
		'fl_contact_form_heading'  => 'Ζήτησε προσφορά',
		'fl_contact_submit_text'   => 'Αποστολή',
		'fl_contact_success_text'  => 'Ευχαριστούμε! Το μήνυμά σου στάλθηκε επιτυχώς.',
		'fl_contact_error_text'    => 'Κάτι πήγε στραβά. Δοκίμασε ξανά ή καλέσε μας απευθείας.',

		// Σελίδες Προϊόντων & Υπηρεσιών - CTA πάνω από το footer
		'fl_products_cta_heading'     => 'Θέλεις προσφορά για την παραγγελία σου;',
		'fl_products_cta_button_text' => 'Επικοινώνησε μαζί μας',
		'fl_services_cta_heading'     => 'Θέλεις να κλείσεις κάποια υπηρεσία;',
		'fl_services_cta_button_text' => 'Επικοινώνησε μαζί μας',

		'fl_hero_image'        => $img . 'hero-visual.jpg',
		'fl_hero_image_height' => 460,

		// Header / Footer
		'fl_logo_part1'         => 'FIREWOOD',
		'fl_logo_part2'         => 'LEADER',
		'fl_logo_height'        => 40,
		'fl_footer_logo_height' => 44,
		'fl_footer_tagline'  => 'Καυσόξυλα Παναγιωτίδη - καυσόξυλα, pellet, μπρικέτες και προσανάμματα υψηλής ποιότητας στη Θεσσαλονίκη.',
		'fl_footer_legal'    => 'Firewood Leader | Καυσόξυλα Παναγιωτίδη. Με επιφύλαξη παντός δικαιώματος.',
		'fl_footer_location' => 'Ωραιόκαστρο, Θεσσαλονίκη',

		// Αρχική σελίδα
		'fl_hero_cta_text'        => 'Δείτε τα Προϊόντα',
		'fl_feature_1_title'      => 'Άμεση Παράδοση',
		'fl_feature_1_desc'       => 'Στον χώρο σας',
		'fl_feature_2_title'      => 'Υψηλή Ποιότητα',
		'fl_feature_2_desc'       => 'Ελεγμένα προϊόντα',
		'fl_feature_3_title'      => '100% Φυσικά Προϊόντα',
		'fl_feature_3_desc'       => 'Χωρίς χημικά πρόσθετα',
		'fl_feature_4_title'      => 'Ανταγωνιστικές Τιμές',
		'fl_feature_4_desc'       => 'Αξιοπιστία & οικονομία',
		'fl_products_eyebrow'     => 'Τα Προϊόντα Μας',
		'fl_products_heading'     => 'Ποιοτικά προϊόντα για κάθε ανάγκη θέρμανσης',
		'fl_home_products_count'  => 8,
		'fl_services_eyebrow'     => 'Οι Υπηρεσίες Μας',
		'fl_services_heading'     => 'Οργανωμένες λύσεις και άψογη εξυπηρέτηση',
		'fl_home_services_count'  => 6,
		'fl_testimonials_eyebrow' => 'Κριτικές',
		'fl_testimonials_heading' => 'Τι Λένε οι Πελάτες Μας',
		'fl_gallery_eyebrow'      => 'Gallery',
		'fl_gallery_heading'      => 'Φωτογραφίες από τη Δουλειά Μας',
		'fl_map_eyebrow'          => 'Βρείτε Μας',
		'fl_map_heading'          => 'Πού θα μας Βρείτε',

		// Αρχική - Γιατί Εμάς (selling points)
		'fl_sellingpoints_eyebrow' => 'Γιατί Εμάς',
		'fl_sellingpoints_heading' => 'Γιατί να μας Επιλέξεις',

		'fl_sellingpoint_1_title' => 'Εγγυημένη ποιότητα ξύλου',
		'fl_sellingpoint_1_desc'  => 'Σωστά στεγνωμένα, καθαρά και επιλεγμένα από σκληρές ελληνικές ξυλείες.',
		'fl_sellingpoint_2_title' => 'Ασφαλής & οργανωμένη παράδοση',
		'fl_sellingpoint_2_desc'  => 'Με συνέπεια στην ώρα και προσοχή στον χώρο σας.',
		'fl_sellingpoint_3_title' => 'Εξειδικευμένος εξοπλισμός',
		'fl_sellingpoint_3_desc'  => 'Γερανός και ηλεκτρικό παλετοφόρο για άνετη ανύψωση Big Bag και παλετών σε ορόφους.',
		'fl_sellingpoint_4_title' => 'Ποικιλία συσκευασιών',
		'fl_sellingpoint_4_desc'  => 'Τσουβαλάκια, Big Bag, παλέτες στοιβαγμένες ή χύμα, ανάλογα με τις ανάγκες σας.',
		'fl_sellingpoint_5_title' => 'Μεγάλη γκάμα προϊόντων',
		'fl_sellingpoint_5_desc'  => 'Καυσόξυλα, πέλλετ, κάρβουνα, μπρικέτες, προσανάμματα και δαδί.',
		'fl_sellingpoint_6_title' => 'Σωστές ποσότητες & καθαρή εργασία',
		'fl_sellingpoint_6_desc'  => 'Παραδίδουμε αυτό που συμφωνήθηκε, χωρίς υπολείψεις και χωρίς ακαταστασία.',
		'fl_sellingpoint_7_title' => 'Επαγγελματικές τιμές & προτεραιότητα',
		'fl_sellingpoint_7_desc'  => 'Ειδικές προσφορές για καταστήματα εστίασης και επαγγελματίες.',
		'fl_sellingpoint_8_title' => 'Φιλική και άμεση εξυπηρέτηση',
		'fl_sellingpoint_8_desc'  => 'Ανθρώπινη επαφή, ειλικρίνεια και πραγματικό ενδιαφέρον για κάθε πελάτη.',
	);
}
