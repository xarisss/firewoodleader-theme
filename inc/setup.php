<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Αυτόματη δημιουργία σελίδων + μενού όταν ενεργοποιείται το theme,
 * ώστε να μη χρειάζεται καμία χειροκίνητη ρύθμιση ή εισαγωγή αρχείου.
 * Τρέχει μόνο μία φορά (ελέγχει αν υπάρχουν ήδη οι σελίδες/το μενού).
 */
/**
 * Αρχικό (πλήρως επεξεργάσιμο) περιεχόμενο για τη σελίδα "Η Εταιρεία".
 * Χρησιμοποιεί τον κανονικό επεξεργαστή του WordPress (blocks), ώστε ο
 * χρήστης να μπορεί να αλλάξει ή να αφαιρέσει οποιοδήποτε κομμάτι θέλει.
 */
function fl_about_page_default_content() {
	$img = get_template_directory_uri() . '/assets/img/';
	return <<<HTML
<!-- wp:heading --><h2>Firewood Leader - Θεσσαλονίκη</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Η Firewood Leader δραστηριοποιείται στη Θεσσαλονίκη προσφέροντας καυσόξυλα, pellet, κάρβουνα και προσανάμματα υψηλής ποιότητας. Στόχος μας είναι κάθε σπίτι και επιχείρηση να έχει αξιόπιστη πρόσβαση σε προϊόντα θέρμανσης, με άμεση εξυπηρέτηση και δίκαιες τιμές.</p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>Προσθέστε εδώ την ιστορία της επιχείρησής σας, από πότε δραστηριοποιείστε και τι σας κάνει να ξεχωρίζετε.</p><!-- /wp:paragraph -->
<!-- wp:image {"sizeSlug":"large"} --><figure class="wp-block-image size-large"><img src="{$img}about-facility.jpg" alt="Εγκαταστάσεις"/></figure><!-- /wp:image -->
<!-- wp:heading --><h2>Οι αξίες μας</h2><!-- /wp:heading -->
<!-- wp:list --><ul><li><strong>Ποιότητα:</strong> Επιλέγουμε προσεκτικά κάθε προϊόν για σταθερή ποιότητα σε κάθε παραγγελία.</li><li><strong>Άμεση Παράδοση:</strong> Οργανωμένη εξυπηρέτηση για γρήγορη παράδοση όπου κι αν βρίσκεσαι στη Θεσσαλονίκη.</li><li><strong>Φυσικά Προϊόντα:</strong> 100% φυσικά προϊόντα, φιλικά προς το περιβάλλον.</li><li><strong>Εξυπηρέτηση:</strong> Είμαστε δίπλα σου πριν και μετά την παραγγελία σου.</li></ul><!-- /wp:list -->
<!-- wp:heading --><h2>Θέλεις να μάθεις περισσότερα;</h2><!-- /wp:heading -->
<!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/epikoinonia/">Επικοινώνησε μαζί μας</a></div><!-- /wp:button --></div><!-- /wp:buttons -->
HTML;
}

function fl_create_page_if_missing( $slug, $title, $template, $content = '' ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		return $existing->ID;
	}

	$page_id = wp_insert_post( array(
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_content' => $content,
	) );

	if ( $page_id && ! is_wp_error( $page_id ) && $template ) {
		update_post_meta( $page_id, '_wp_page_template', $template );
	}

	return $page_id;
}

/**
 * Εισάγει μια εικόνα από το theme (assets/img) στη Βιβλιοθήκη Πολυμέσων,
 * ώστε να μπορεί να χρησιμοποιηθεί σαν featured image σε ένα post.
 * Αν έχει ήδη εισαχθεί (ίδιο filename), επιστρέφει το υπάρχον attachment ID.
 */
function fl_seed_image( $filename, $title ) {
	$existing = get_page_by_title( $filename, OBJECT, 'attachment' );
	if ( $existing ) {
		return $existing->ID;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$path = get_template_directory() . '/assets/img/' . $filename;
	if ( ! file_exists( $path ) ) {
		return 0;
	}

	$upload = wp_upload_bits( $filename, null, file_get_contents( $path ) );
	if ( $upload['error'] ) {
		return 0;
	}

	$filetype   = wp_check_filetype( $upload['file'], null );
	$attachment_id = wp_insert_attachment( array(
		'post_mime_type' => $filetype['type'],
		'post_title'     => $filename,
		'post_content'   => '',
		'post_status'    => 'inherit',
	), $upload['file'] );

	if ( ! is_wp_error( $attachment_id ) && $attachment_id ) {
		$attach_data = wp_generate_attachment_metadata( $attachment_id, $upload['file'] );
		wp_update_attachment_metadata( $attachment_id, $attach_data );
		update_post_meta( $attachment_id, '_wp_attachment_image_alt', $title );
	}

	return $attachment_id;
}

function fl_create_cpt_if_none_exist( $post_type, $items ) {
	$existing = get_posts( array( 'post_type' => $post_type, 'numberposts' => 1, 'post_status' => 'any' ) );
	if ( ! empty( $existing ) ) {
		return;
	}

	foreach ( $items as $order => $item ) {
		$post_id = wp_insert_post( array(
			'post_type'    => $post_type,
			'post_title'   => $item['title'],
			'post_content' => isset( $item['content'] ) ? $item['content'] : '',
			'post_excerpt' => isset( $item['excerpt'] ) ? $item['excerpt'] : '',
			'post_status'  => 'publish',
			'menu_order'   => $order,
		) );

		if ( $post_id && ! is_wp_error( $post_id ) && ! empty( $item['image'] ) ) {
			$attachment_id = fl_seed_image( $item['image'], $item['title'] );
			if ( $attachment_id ) {
				set_post_thumbnail( $post_id, $attachment_id );
			}
		}
	}
}

function fl_seed_default_content() {
	fl_create_cpt_if_none_exist( 'fl_product', array(
		array(
			'title'   => 'Καυσόξυλα',
			'excerpt' => 'Επιλεγμένα καυσόξυλα άριστης ποιότητας για μέγιστη απόδοση.',
			'content' => 'Τα καυσόξυλα μας κόβονται και ξηραίνονται με φροντίδα ώστε να έχουν χαμηλή υγρασία, καθαρή καύση και μεγάλη θερμαντική απόδοση. Ιδανικά για τζάκι, σόμπα ξύλου και εξωτερικούς χώρους.',
			'image'   => 'product-firewood.jpg',
		),
		array(
			'title'   => 'Pellet',
			'excerpt' => 'Υψηλής θερμογόνου δύναμης pellet για οικονομική και καθαρή θέρμανση.',
			'content' => 'Το pellet μας προσφέρει σταθερή, καθαρή και οικονομική θέρμανση για λέβητες και σόμπες pellet. Χαμηλή στάχτη, υψηλή θερμογόνος δύναμη.',
			'image'   => 'product-pellet.jpg',
		),
		array(
			'title'   => 'Μπρικέτες',
			'excerpt' => 'Φυσικές μπρικέτες για τέλειο ψήσιμο και μεγάλη διάρκεια.',
			'content' => 'Φυσικές μπρικέτες υψηλής ποιότητας, ιδανικές για ψησταριά και μπάρμπεκιου, με μεγάλη διάρκεια καύσης και σταθερή θερμοκρασία.',
			'image'   => 'product-coal.jpg',
		),
		array(
			'title'   => 'Προσανάμματα - Δαδί',
			'excerpt' => 'Προσανάμματα υψηλής ποιότητας για εύκολο και ασφαλές άναμμα.',
			'content' => 'Προσανάμματα υψηλής ποιότητας που ανάβουν γρήγορα και χωρίς κόπο, ιδανικά για τζάκι, σόμπα ή μπάρμπεκιου.',
			'image'   => 'product-kindling.jpg',
		),
	) );

	fl_create_cpt_if_none_exist( 'fl_service', array(
		array( 'title' => 'Μεταφορά στον Χώρο Σας', 'content' => 'Γρήγορη και ασφαλής παράδοση στον χώρο σας.', 'image' => 'service-delivery.jpg' ),
		array( 'title' => 'Ανύψωση Big Bag (Γερανός)', 'content' => 'Ανύψωση και τοποθέτηση Big Bag με γερανό.', 'image' => 'service-crane.jpg' ),
		array( 'title' => 'Κοπή Ξύλων στα Μέτρα Σας', 'content' => 'Κόβουμε τα ξύλα στα μέτρα που θέλετε.', 'image' => 'service-chainsaw.jpg' ),
		array( 'title' => 'Παλέτες & Big Bag', 'content' => 'Διαθέσιμα σε παλέτες και Big Bag για ευκολία.', 'image' => 'service-pallets.jpg' ),
		array( 'title' => 'Ειδικές Τιμές για Επαγγελματίες', 'content' => 'Συνεργασίες με επαγγελματίες σε προνομιακές τιμές.', 'image' => 'service-handshake.jpg' ),
	) );

	fl_create_cpt_if_none_exist( 'fl_gallery', array(
		array( 'title' => 'Μεταφορά', 'image' => 'service-delivery.jpg' ),
		array( 'title' => 'Ανύψωση Big Bag', 'image' => 'service-crane.jpg' ),
		array( 'title' => 'Καυσόξυλα', 'image' => 'product-firewood.jpg' ),
		array( 'title' => 'Εγκαταστάσεις', 'image' => 'about-facility.jpg' ),
		array( 'title' => 'Pellet', 'image' => 'product-pellet.jpg' ),
		array( 'title' => 'Παλέτες & Big Bag', 'image' => 'service-pallets.jpg' ),
		array( 'title' => 'Μπρικέτες', 'image' => 'product-coal.jpg' ),
		array( 'title' => 'Προσανάμματα', 'image' => 'product-kindling.jpg' ),
	) );
}

function fl_theme_activation_setup() {

	fl_seed_default_content();

	$home_id     = fl_create_page_if_missing( 'home', 'Αρχική', '' );
	$products_id = fl_create_page_if_missing( 'proionta', 'Προϊόντα', 'page-templates/products.php' );
	$services_id = fl_create_page_if_missing( 'ypiresies', 'Υπηρεσίες', 'page-templates/services.php' );
	$about_id    = fl_create_page_if_missing( 'i-etaireia', 'Η Εταιρεία', '', fl_about_page_default_content() );
	$contact_id  = fl_create_page_if_missing( 'epikoinonia', 'Επικοινωνία', 'page-templates/contact.php' );

	// Ορισμός στατικής αρχικής σελίδας.
	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	// Favicon = το εικονίδιο του λογότυπου (φλόγα), μόνο αν δεν έχει ήδη οριστεί άλλο.
	if ( ! get_option( 'site_icon' ) ) {
		$favicon_id = fl_seed_image( 'favicon-flame.png', 'Favicon' );
		if ( $favicon_id ) {
			update_option( 'site_icon', $favicon_id );
		}
	}

	// Δημιουργία κύριου μενού, μόνο αν δεν υπάρχει ήδη.
	$menu_name = 'Κύριο Μενού';
	$menu_id   = 0;
	$existing_menu = wp_get_nav_menu_object( $menu_name );

	if ( $existing_menu ) {
		$menu_id = $existing_menu->term_id;
	} else {
		$menu_id = wp_create_nav_menu( $menu_name );
	}

	if ( $menu_id && ! is_wp_error( $menu_id ) ) {
		$current_items = wp_get_nav_menu_items( $menu_id );

		if ( empty( $current_items ) ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'   => 'Αρχική',
				'menu-item-url'     => home_url( '/' ),
				'menu-item-status'  => 'publish',
				'menu-item-type'    => 'custom',
				'menu-item-position'=> 1,
			) );

			$pages_for_menu = array(
				2 => array( $products_id, 'Προϊόντα' ),
				3 => array( $services_id, 'Υπηρεσίες' ),
				4 => array( $about_id, 'Η Εταιρεία' ),
				5 => array( $contact_id, 'Επικοινωνία' ),
			);

			foreach ( $pages_for_menu as $position => $data ) {
				list( $object_id, $title ) = $data;
				if ( ! $object_id ) {
					continue;
				}
				wp_update_nav_menu_item( $menu_id, 0, array(
					'menu-item-title'     => $title,
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $object_id,
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
					'menu-item-position'  => $position,
				) );
			}
		}

		$locations = get_theme_mod( 'nav_menu_locations' );
		$locations['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	// Ξεχωριστό μενού για το footer, μόνο αν δεν υπάρχει ήδη.
	$footer_menu_name = 'Μενού Footer';
	$footer_menu_id    = 0;
	$existing_footer_menu = wp_get_nav_menu_object( $footer_menu_name );

	if ( $existing_footer_menu ) {
		$footer_menu_id = $existing_footer_menu->term_id;
	} else {
		$footer_menu_id = wp_create_nav_menu( $footer_menu_name );
	}

	if ( $footer_menu_id && ! is_wp_error( $footer_menu_id ) ) {
		$footer_current_items = wp_get_nav_menu_items( $footer_menu_id );

		if ( empty( $footer_current_items ) ) {
			$footer_pages = array(
				1 => array( $products_id, 'Προϊόντα' ),
				2 => array( $services_id, 'Υπηρεσίες' ),
				3 => array( $about_id, 'Η Εταιρεία' ),
				4 => array( $contact_id, 'Επικοινωνία' ),
			);

			foreach ( $footer_pages as $position => $data ) {
				list( $object_id, $title ) = $data;
				if ( ! $object_id ) {
					continue;
				}
				wp_update_nav_menu_item( $footer_menu_id, 0, array(
					'menu-item-title'     => $title,
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $object_id,
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
					'menu-item-position'  => $position,
				) );
			}
		}

		$locations = get_theme_mod( 'nav_menu_locations' );
		$locations['footer'] = $footer_menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'fl_theme_activation_setup' );
