<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom Post Types: Προϊόντα, Υπηρεσίες, Κριτικές.
 * Ο χρήστης μπορεί να προσθέτει/διαγράφει/αναδιατάσσει όσα θέλει από το
 * wp-admin, ακριβώς όπως τα άρθρα (τίτλος, περιγραφή, φωτογραφία).
 */
function fl_register_cpts() {

	register_post_type( 'fl_product', array(
		'labels' => array(
			'name'               => __( 'Προϊόντα', 'firewoodleader' ),
			'singular_name'      => __( 'Προϊόν', 'firewoodleader' ),
			'add_new_item'       => __( 'Προσθήκη Προϊόντος', 'firewoodleader' ),
			'edit_item'          => __( 'Επεξεργασία Προϊόντος', 'firewoodleader' ),
			'all_items'          => __( 'Όλα τα Προϊόντα', 'firewoodleader' ),
			'featured_image'     => __( 'Φωτογραφία Προϊόντος', 'firewoodleader' ),
		),
		'public'       => true,
		'has_archive'  => false,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-admin-post',
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'rewrite'      => array( 'slug' => 'proion' ),
	) );

	register_post_type( 'fl_service', array(
		'labels' => array(
			'name'               => __( 'Υπηρεσίες', 'firewoodleader' ),
			'singular_name'      => __( 'Υπηρεσία', 'firewoodleader' ),
			'add_new_item'       => __( 'Προσθήκη Υπηρεσίας', 'firewoodleader' ),
			'edit_item'          => __( 'Επεξεργασία Υπηρεσίας', 'firewoodleader' ),
			'all_items'          => __( 'Όλες οι Υπηρεσίες', 'firewoodleader' ),
			'featured_image'     => __( 'Φωτογραφία Υπηρεσίας', 'firewoodleader' ),
		),
		'public'       => true,
		'has_archive'  => false,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-admin-tools',
		'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		'rewrite'      => array( 'slug' => 'ypiresia' ),
	) );

	register_post_type( 'fl_testimonial', array(
		'labels' => array(
			'name'               => __( 'Κριτικές Πελατών', 'firewoodleader' ),
			'singular_name'      => __( 'Κριτική', 'firewoodleader' ),
			'add_new_item'       => __( 'Προσθήκη Κριτικής', 'firewoodleader' ),
			'edit_item'          => __( 'Επεξεργασία Κριτικής', 'firewoodleader' ),
			'all_items'          => __( 'Όλες οι Κριτικές', 'firewoodleader' ),
			'title_placeholder'  => __( 'Όνομα πελάτη', 'firewoodleader' ),
		),
		'public'       => true,
		'has_archive'  => false,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-testimonial',
		'supports'     => array( 'title', 'editor' ),
		'rewrite'      => false,
	) );

	register_post_type( 'fl_gallery', array(
		'labels' => array(
			'name'               => __( 'Φωτογραφίες (Gallery)', 'firewoodleader' ),
			'singular_name'      => __( 'Φωτογραφία', 'firewoodleader' ),
			'add_new_item'       => __( 'Προσθήκη Φωτογραφίας', 'firewoodleader' ),
			'edit_item'          => __( 'Επεξεργασία Φωτογραφίας', 'firewoodleader' ),
			'all_items'          => __( 'Όλες οι Φωτογραφίες', 'firewoodleader' ),
			'featured_image'     => __( 'Η Φωτογραφία', 'firewoodleader' ),
			'title_placeholder'  => __( 'Περιγραφή φωτογραφίας (προαιρετικό)', 'firewoodleader' ),
		),
		'public'       => true,
		'has_archive'  => false,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-format-gallery',
		'supports'     => array( 'title', 'thumbnail', 'page-attributes' ),
		'rewrite'      => false,
	) );
}
add_action( 'init', 'fl_register_cpts' );

/**
 * Meta box: αξιολόγηση 1-5 αστεριών για κάθε κριτική.
 */
function fl_testimonial_rating_meta_box() {
	add_meta_box( 'fl_rating', __( 'Αξιολόγηση (αστέρια)', 'firewoodleader' ), 'fl_render_rating_meta_box', 'fl_testimonial', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'fl_testimonial_rating_meta_box' );

function fl_render_rating_meta_box( $post ) {
	wp_nonce_field( 'fl_save_rating', 'fl_rating_nonce' );
	$rating = get_post_meta( $post->ID, 'fl_rating', true );
	if ( '' === $rating ) {
		$rating = 5;
	}
	echo '<select name="fl_rating" style="width:100%;">';
	for ( $i = 5; $i >= 1; $i-- ) {
		printf( '<option value="%1$d"%2$s>%1$d ★</option>', $i, selected( $rating, $i, false ) );
	}
	echo '</select>';
}

function fl_save_rating_meta( $post_id ) {
	if ( ! isset( $_POST['fl_rating_nonce'] ) || ! wp_verify_nonce( $_POST['fl_rating_nonce'], 'fl_save_rating' ) ) {
		return;
	}
	if ( isset( $_POST['fl_rating'] ) ) {
		update_post_meta( $post_id, 'fl_rating', absint( $_POST['fl_rating'] ) );
	}
}
add_action( 'save_post_fl_testimonial', 'fl_save_rating_meta' );
