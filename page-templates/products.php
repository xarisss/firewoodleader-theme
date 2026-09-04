<?php
/* Template Name: Προϊόντα */
get_header();
$img = get_template_directory_uri() . '/assets/img/';

$products = get_posts( array( 'post_type' => 'fl_product', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
?>

<section class="fl-page-hero">
	<span class="fl-eyebrow"><?php esc_html_e( 'Τα Προϊόντα Μας', 'firewoodleader' ); ?></span>
	<h1><?php esc_html_e( 'Ό,τι χρειάζεσαι για τη θέρμανσή σου', 'firewoodleader' ); ?></h1>
</section>

<?php if ( ! $products ) : ?>
<section class="fl-section">
	<div class="fl-container fl-section-head">
		<p><?php esc_html_e( 'Δεν έχουν προστεθεί προϊόντα ακόμα. Πρόσθεσε το πρώτο από wp-admin → Προϊόντα → Προσθήκη.', 'firewoodleader' ); ?></p>
	</div>
</section>
<?php endif; ?>

<?php foreach ( $products as $index => $p ) :
	$thumb     = get_the_post_thumbnail_url( $p, 'large' );
	$img_first = ( 0 === $index % 2 );

	$photo_block = '<div class="fl-split-media fl-media-placeholder" style="border:0;padding:0;background:none;"><img src="' . esc_url( $thumb ? $thumb : $img . 'product-firewood.jpg' ) . '" alt="' . esc_attr( $p->post_title ) . '" style="border-radius:var(--fl-radius);width:100%;height:320px;object-fit:cover;"></div>';

	$content    = apply_filters( 'the_content', $p->post_content );
	$plain_text = wp_strip_all_tags( $content );
	$is_long    = mb_strlen( $plain_text ) > 240;
	$body_html  = $is_long
		? '<p>' . esc_html( wp_trim_words( $plain_text, 30, '…' ) ) . '</p><button type="button" class="fl-readmore-btn" data-modal-target="fl-product-full-' . (int) $p->ID . '">' . esc_html__( 'Διάβασε περισσότερα', 'firewoodleader' ) . ' →</button>'
		: $content;
	$text_block = '<div class="fl-split-text"><span class="fl-eyebrow">' . esc_html( $p->post_title ) . '</span><h2>' . esc_html( $p->post_title ) . '</h2><div class="fl-rich-text">' . $body_html . '</div></div>';
?>
<section class="fl-section<?php echo ( 1 === $index % 2 ) ? ' fl-bg-cream' : ''; ?>" id="<?php echo esc_attr( $p->post_name ); ?>">
	<div class="fl-container">
		<div class="fl-split">
			<?php echo $img_first ? $photo_block . $text_block : $text_block . $photo_block; ?>
		</div>
	</div>
</section>
<?php if ( $is_long ) : ?>
<div id="fl-product-full-<?php echo (int) $p->ID; ?>" class="fl-modal-source" hidden>
	<h3><?php echo esc_html( $p->post_title ); ?></h3>
	<div class="fl-rich-text"><?php echo $content; ?></div>
</div>
<?php endif; ?>
<?php endforeach; ?>

<div class="fl-modal" id="fl-readmore-modal">
	<div class="fl-modal-overlay" data-modal-close></div>
	<div class="fl-modal-box">
		<button type="button" class="fl-modal-close" data-modal-close aria-label="<?php esc_attr_e( 'Κλείσιμο', 'firewoodleader' ); ?>">&times;</button>
		<div class="fl-modal-body"></div>
	</div>
</div>

<?php
$cta_heading = fl_opt( 'fl_products_cta_heading' );
$cta_button  = fl_opt( 'fl_products_cta_button_text' );
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
