<?php get_header(); ?>

<section class="fl-section fl-section-head">
	<div class="fl-container">
		<span class="fl-eyebrow">404</span>
		<h1><?php esc_html_e( 'Η σελίδα δεν βρέθηκε', 'firewoodleader' ); ?></h1>
		<a class="fl-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Επιστροφή στην Αρχική', 'firewoodleader' ); ?></a>
	</div>
</section>

<?php get_footer(); ?>
