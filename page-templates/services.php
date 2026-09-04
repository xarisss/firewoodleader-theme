<?php
/* Template Name: Υπηρεσίες */
get_header();
$img = get_template_directory_uri() . '/assets/img/';

$services = get_posts( array( 'post_type' => 'fl_service', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
?>

<section class="fl-page-hero">
	<span class="fl-eyebrow"><?php esc_html_e( 'Οι Υπηρεσίες Μας', 'firewoodleader' ); ?></span>
	<h1><?php esc_html_e( 'Οργανωμένες Λύσεις &amp; Άψογη Εξυπηρέτηση', 'firewoodleader' ); ?></h1>
</section>

<?php if ( ! $services ) : ?>
<section class="fl-section">
	<div class="fl-container fl-section-head">
		<p><?php esc_html_e( 'Δεν έχουν προστεθεί υπηρεσίες ακόμα. Πρόσθεσε την πρώτη από wp-admin → Υπηρεσίες → Προσθήκη.', 'firewoodleader' ); ?></p>
	</div>
</section>
<?php endif; ?>

<?php foreach ( $services as $index => $s ) :
	$thumb     = get_the_post_thumbnail_url( $s, 'large' );
	$img_first = ( 0 === $index % 2 );

	$photo_block = '<div class="fl-split-media fl-media-placeholder" style="border:0;padding:0;background:none;"><img src="' . esc_url( $thumb ? $thumb : $img . 'service-delivery.jpg' ) . '" alt="' . esc_attr( $s->post_title ) . '" style="border-radius:var(--fl-radius);width:100%;height:320px;object-fit:cover;"></div>';

	$content = apply_filters( 'the_content', $s->post_content );
	$text_block = '<div class="fl-split-text"><span class="fl-eyebrow">' . esc_html__( 'Υπηρεσία', 'firewoodleader' ) . '</span><h2>' . esc_html( $s->post_title ) . '</h2><div class="fl-rich-text">' . $content . '</div></div>';
?>
<section class="fl-section<?php echo ( 1 === $index % 2 ) ? ' fl-bg-cream' : ''; ?>" id="<?php echo esc_attr( $s->post_name ); ?>">
	<div class="fl-container">
		<div class="fl-split">
			<?php echo $img_first ? $photo_block . $text_block : $text_block . $photo_block; ?>
		</div>
	</div>
</section>
<?php endforeach; ?>

<?php
$cta_heading = fl_opt( 'fl_services_cta_heading' );
$cta_button  = fl_opt( 'fl_services_cta_button_text' );
?>
<?php if ( $cta_heading || $cta_button ) : ?>
<section class="fl-section">
	<div class="fl-container fl-section-head">
		<?php if ( $cta_heading ) : ?>
		<h2><?php echo esc_html( $cta_heading ); ?></h2>
		<?php endif; ?>
		<?php if ( $cta_button ) : ?>
		<a class="fl-btn" href="<?php echo esc_url( home_url( '/epikoinonia/' ) ); ?>"><?php echo esc_html( $cta_button ); ?> →</a>
		<?php endif; ?>
	</div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
