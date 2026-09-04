<?php
get_header();
$img = get_template_directory_uri() . '/assets/img/';

$products = get_posts( array( 'post_type' => 'fl_product', 'posts_per_page' => (int) fl_opt( 'fl_home_products_count' ), 'orderby' => 'menu_order', 'order' => 'ASC' ) );
$services = get_posts( array( 'post_type' => 'fl_service', 'posts_per_page' => (int) fl_opt( 'fl_home_services_count' ), 'orderby' => 'menu_order', 'order' => 'ASC' ) );
$testimonials = get_posts( array( 'post_type' => 'fl_testimonial', 'posts_per_page' => 6, 'orderby' => 'date', 'order' => 'DESC' ) );
?>

<?php $hero_image = fl_opt( 'fl_hero_image', $img . 'hero-visual.jpg' ); ?>
<?php if ( $hero_image ) : ?>
<section class="fl-hero-visual">
	<img src="<?php echo esc_url( $hero_image ); ?>" alt="Firewood Leader - Καυσόξυλα Παναγιωτίδη" fetchpriority="high" style="max-height:<?php echo (int) fl_opt( 'fl_hero_image_height' ); ?>px;">
</section>
<?php endif; ?>
<div class="fl-hero-cta-bar">
	<a class="fl-btn" href="#proionta"><?php echo esc_html( fl_opt( 'fl_hero_cta_text' ) ); ?> →</a>
</div>

<?php if ( get_theme_mod( 'fl_features_bar_enabled', true ) ) : ?>
<section class="fl-features-light">
	<div class="fl-container">
		<ul>
			<?php
			$feature_icons = array( 'truck', 'medal', 'leaf', 'shield' );
			foreach ( $feature_icons as $fi => $icon ) :
				$n = $fi + 1;
			?>
			<li>
				<?php echo fl_icon( $icon ); ?>
				<div class="fl-feature-text"><strong><?php echo esc_html( fl_opt( "fl_feature_{$n}_title" ) ); ?></strong><span><?php echo esc_html( fl_opt( "fl_feature_{$n}_desc" ) ); ?></span></div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<?php
$sellingpoints = array();
for ( $i = 1; $i <= 8; $i++ ) {
	$sp_title = fl_opt( "fl_sellingpoint_{$i}_title" );
	$sp_desc  = fl_opt( "fl_sellingpoint_{$i}_desc" );
	if ( $sp_title || $sp_desc ) {
		$sellingpoints[] = array( 'title' => $sp_title, 'desc' => $sp_desc );
	}
}
?>
<?php if ( $sellingpoints ) : ?>
<section class="fl-section fl-bg-cream">
	<div class="fl-container">
		<div class="fl-section-head">
			<span class="fl-eyebrow"><?php echo esc_html( fl_opt( 'fl_sellingpoints_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( fl_opt( 'fl_sellingpoints_heading' ) ); ?></h2>
		</div>
		<ul class="fl-checklist fl-checklist-grid">
			<?php foreach ( $sellingpoints as $sp ) : ?>
			<li>
				<?php echo fl_icon( 'check' ); ?>
				<div>
					<?php if ( $sp['title'] ) : ?><strong><?php echo esc_html( $sp['title'] ); ?></strong><?php endif; ?>
					<?php if ( $sp['desc'] ) : ?><span><?php echo esc_html( $sp['desc'] ); ?></span><?php endif; ?>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>

<?php if ( $products ) : ?>
<section class="fl-section" id="proionta">
	<div class="fl-container">
		<div class="fl-section-head">
			<span class="fl-eyebrow"><?php echo esc_html( fl_opt( 'fl_products_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( fl_opt( 'fl_products_heading' ) ); ?></h2>
		</div>

		<div class="fl-carousel">
			<button type="button" class="fl-carousel-btn fl-carousel-prev" aria-label="<?php esc_attr_e( 'Προηγούμενα', 'firewoodleader' ); ?>">&#8249;</button>
			<div class="fl-products">
				<?php foreach ( $products as $p ) :
					$thumb = get_the_post_thumbnail_url( $p, 'medium_large' );
				?>
				<article class="fl-product-card">
					<div class="fl-product-media"><img src="<?php echo esc_url( $thumb ? $thumb : $img . 'product-firewood.jpg' ); ?>" alt="<?php echo esc_attr( $p->post_title ); ?>" loading="lazy"></div>
					<div class="fl-product-body">
						<h3><?php echo esc_html( $p->post_title ); ?></h3>
						<p><?php echo esc_html( $p->post_excerpt ? $p->post_excerpt : wp_trim_words( $p->post_content, 18 ) ); ?></p>
						<a class="fl-btn" href="<?php echo esc_url( home_url( '/proionta/#' . $p->post_name ) ); ?>"><?php esc_html_e( 'Δείτε Περισσότερα', 'firewoodleader' ); ?> →</a>
					</div>
				</article>
				<?php endforeach; ?>
			</div>
			<button type="button" class="fl-carousel-btn fl-carousel-next" aria-label="<?php esc_attr_e( 'Επόμενα', 'firewoodleader' ); ?>">&#8250;</button>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( $services ) : ?>
<section class="fl-section fl-bg-cream" id="ypiresies">
	<div class="fl-container">
		<div class="fl-section-head">
			<span class="fl-eyebrow"><?php echo esc_html( fl_opt( 'fl_services_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( fl_opt( 'fl_services_heading' ) ); ?></h2>
		</div>

		<div class="fl-carousel">
			<button type="button" class="fl-carousel-btn fl-carousel-prev" aria-label="<?php esc_attr_e( 'Προηγούμενα', 'firewoodleader' ); ?>">&#8249;</button>
			<div class="fl-services">
				<?php foreach ( $services as $s ) :
					$thumb = get_the_post_thumbnail_url( $s, 'medium' );
				?>
				<article class="fl-service-card">
					<div class="fl-service-media"><img src="<?php echo esc_url( $thumb ? $thumb : $img . 'service-delivery.jpg' ); ?>" alt="<?php echo esc_attr( $s->post_title ); ?>" loading="lazy"></div>
					<div class="fl-service-body">
						<h3><?php echo esc_html( $s->post_title ); ?></h3>
						<p><?php echo esc_html( wp_trim_words( $s->post_content, 16 ) ); ?></p>
					</div>
				</article>
				<?php endforeach; ?>
			</div>
			<button type="button" class="fl-carousel-btn fl-carousel-next" aria-label="<?php esc_attr_e( 'Επόμενα', 'firewoodleader' ); ?>">&#8250;</button>
		</div>
		<div class="fl-gallery-cta">
			<a class="fl-btn fl-btn-outline" href="<?php echo esc_url( home_url( '/ypiresies/' ) ); ?>"><?php esc_html_e( 'Δείτε Όλες τις Υπηρεσίες', 'firewoodleader' ); ?> →</a>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="fl-section">
	<div class="fl-container">
		<div class="fl-section-head">
			<span class="fl-eyebrow"><?php echo esc_html( fl_opt( 'fl_testimonials_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( fl_opt( 'fl_testimonials_heading' ) ); ?></h2>
		</div>
		<div class="fl-carousel">
		<button type="button" class="fl-carousel-btn fl-carousel-prev" aria-label="<?php esc_attr_e( 'Προηγούμενα', 'firewoodleader' ); ?>">&#8249;</button>
		<div class="fl-testimonials">
			<?php if ( $testimonials ) : ?>
				<?php foreach ( $testimonials as $t ) :
					$rating = (int) get_post_meta( $t->ID, 'fl_rating', true );
					if ( ! $rating ) { $rating = 5; }
				?>
				<article class="fl-testimonial-card">
					<div class="fl-testimonial-top">
						<span class="fl-quote-icon"><?php echo fl_icon( 'quote' ); ?></span>
						<span class="fl-stars"><?php echo str_repeat( fl_icon( 'star' ), $rating ); ?></span>
					</div>
					<p><?php echo esc_html( wp_strip_all_tags( $t->post_content ) ); ?></p>
					<div class="fl-testimonial-name"><?php echo esc_html( $t->post_title ); ?></div>
				</article>
				<?php endforeach; ?>
			<?php else : ?>
				<?php for ( $i = 0; $i < 3; $i++ ) : ?>
				<article class="fl-testimonial-card">
					<span class="fl-testimonial-example"><?php esc_html_e( 'Παράδειγμα', 'firewoodleader' ); ?></span>
					<div class="fl-testimonial-top">
						<span class="fl-quote-icon"><?php echo fl_icon( 'quote' ); ?></span>
						<span class="fl-stars"><?php echo str_repeat( fl_icon( 'star' ), 5 ); ?></span>
					</div>
					<p><?php esc_html_e( 'Πρόσθεσε την πρώτη σου κριτική από το wp-admin → Κριτικές Πελατών → Προσθήκη.', 'firewoodleader' ); ?></p>
					<div class="fl-testimonial-name"><?php esc_html_e( 'Όνομα Πελάτη', 'firewoodleader' ); ?></div>
				</article>
				<?php endfor; ?>
			<?php endif; ?>
			</div>
			<button type="button" class="fl-carousel-btn fl-carousel-next" aria-label="<?php esc_attr_e( 'Επόμενα', 'firewoodleader' ); ?>">&#8250;</button>
		</div>
	</div>
</section>

<section class="fl-section fl-bg-cream">
	<div class="fl-container">
		<div class="fl-section-head">
			<span class="fl-eyebrow"><?php echo esc_html( fl_opt( 'fl_gallery_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( fl_opt( 'fl_gallery_heading' ) ); ?></h2>
		</div>
		<div class="fl-gallery" id="fl-lightbox-gallery">
			<?php
			$gallery_items = get_posts( array( 'post_type' => 'fl_gallery', 'posts_per_page' => 12, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
			foreach ( $gallery_items as $gp ) :
				$thumb_id = get_post_thumbnail_id( $gp );
				if ( ! $thumb_id ) { continue; }
				$full = wp_get_attachment_image_url( $thumb_id, 'large' );
			?>
				<a href="<?php echo esc_url( $full ); ?>" class="fl-lightbox-trigger" data-caption="<?php echo esc_attr( $gp->post_title ); ?>">
					<img src="<?php echo esc_url( wp_get_attachment_image_url( $thumb_id, 'medium' ) ); ?>" alt="<?php echo esc_attr( $gp->post_title ); ?>" loading="lazy">
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<div class="fl-lightbox" id="fl-lightbox">
	<button class="fl-lightbox-close" aria-label="<?php esc_attr_e( 'Κλείσιμο', 'firewoodleader' ); ?>">&times;</button>
	<button class="fl-lightbox-prev" aria-label="<?php esc_attr_e( 'Προηγούμενη', 'firewoodleader' ); ?>">&#8249;</button>
	<button class="fl-lightbox-next" aria-label="<?php esc_attr_e( 'Επόμενη', 'firewoodleader' ); ?>">&#8250;</button>
	<figure class="fl-lightbox-content">
		<img src="" alt="">
		<figcaption></figcaption>
	</figure>
</div>

<section class="fl-section">
	<div class="fl-container">
		<div class="fl-section-head">
			<span class="fl-eyebrow"><?php echo esc_html( fl_opt( 'fl_map_eyebrow' ) ); ?></span>
			<h2><?php echo esc_html( fl_opt( 'fl_map_heading' ) ); ?></h2>
		</div>
		<div class="fl-map-wrap">
			<div class="fl-map-card">
				<span class="fl-eyebrow"><?php esc_html_e( 'Διεύθυνση', 'firewoodleader' ); ?></span>
				<?php if ( fl_opt( 'fl_map_address_text' ) ) : ?>
				<div class="fl-map-pin">
					<?php echo fl_icon( 'pin' ); ?>
					<span><?php echo esc_html( fl_opt( 'fl_map_address_text' ) ); ?></span>
				</div>
				<?php endif; ?>
				<?php
				$directions_url = fl_opt( 'fl_map_directions_url' );
				if ( ! $directions_url && fl_opt( 'fl_maps_query' ) ) {
					$directions_url = 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode( fl_opt( 'fl_maps_query' ) );
				}
				?>
				<?php if ( $directions_url ) : ?>
				<a class="fl-btn" target="_blank" rel="noopener" href="<?php echo esc_url( $directions_url ); ?>">
					<?php echo fl_icon( 'route' ); ?> <?php esc_html_e( 'Οδηγίες μέσω Google Maps', 'firewoodleader' ); ?>
				</a>
				<?php endif; ?>
			</div>
			<div class="fl-map-embed">
				<?php if ( fl_opt( 'fl_map_embed_code' ) ) : ?>
					<?php echo fl_kses_iframe( fl_opt( 'fl_map_embed_code' ) ); ?>
				<?php else : ?>
					<iframe
						src="https://maps.google.com/maps?q=<?php echo urlencode( fl_opt( 'fl_maps_query' ) ); ?>&output=embed"
						loading="lazy"
						referrerpolicy="no-referrer-when-downgrade"
						title="<?php esc_attr_e( 'Χάρτης τοποθεσίας', 'firewoodleader' ); ?>">
					</iframe>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
