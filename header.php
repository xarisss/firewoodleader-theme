<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="fl-header">
	<div class="fl-header-inner">
		<a class="fl-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( fl_opt( 'fl_logo_image' ) ) : ?>
				<img class="fl-logo-img" src="<?php echo esc_url( fl_opt( 'fl_logo_image' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" style="height:<?php echo (int) fl_opt( 'fl_logo_height' ); ?>px;">
			<?php else : ?>
				<span class="fl-logo-flame"><?php echo fl_icon( 'flame' ); ?></span>
				<?php echo esc_html( fl_opt( 'fl_logo_part1' ) ); ?><span><?php echo esc_html( fl_opt( 'fl_logo_part2' ) ); ?></span>
			<?php endif; ?>
		</a>

		<nav class="fl-nav" aria-label="<?php esc_attr_e( 'Κύριο μενού', 'firewoodleader' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'fallback_cb'    => 'fl_default_menu',
			) );
			?>
		</nav>

		<div class="fl-header-right">
			<?php $phone = fl_opt( 'fl_phone' ); ?>
			<a class="fl-phone" href="<?php echo $phone ? 'tel:' . esc_attr( preg_replace( '/\s+/', '', $phone ) ) : '#'; ?>">
				<?php echo fl_icon( 'phone' ); ?>
				<span class="fl-phone-label"><?php echo $phone ? esc_html( $phone ) : esc_html__( 'Τηλέφωνο σύντομα', 'firewoodleader' ); ?></span>
			</a>
			<?php if ( fl_opt( 'fl_facebook' ) || fl_opt( 'fl_instagram' ) ) : ?>
			<div class="fl-social fl-social-header">
				<?php if ( fl_opt( 'fl_facebook' ) ) : ?>
					<a href="<?php echo esc_url( fl_opt( 'fl_facebook' ) ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php echo fl_icon( 'fb' ); ?></a>
				<?php endif; ?>
				<?php if ( fl_opt( 'fl_instagram' ) ) : ?>
					<a href="<?php echo esc_url( fl_opt( 'fl_instagram' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo fl_icon( 'ig' ); ?></a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<button class="fl-burger" aria-label="<?php esc_attr_e( 'Μενού', 'firewoodleader' ); ?>"><?php echo fl_icon( 'menu' ); ?></button>
		</div>
	</div>

	<nav class="fl-nav-mobile">
		<div class="fl-nav-mobile-links">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'fallback_cb'    => 'fl_default_menu',
			) );
			?>
		</div>
		<div class="fl-nav-mobile-cta">
			<div class="fl-nav-mobile-top-row">
				<a class="fl-nav-mobile-phone" href="<?php echo $phone ? 'tel:' . esc_attr( preg_replace( '/\s+/', '', $phone ) ) : '#'; ?>">
					<?php echo fl_icon( 'phone' ); ?>
					<?php echo $phone ? esc_html( $phone ) : esc_html__( 'Τηλέφωνο σύντομα', 'firewoodleader' ); ?>
				</a>
				<?php if ( fl_opt( 'fl_facebook' ) || fl_opt( 'fl_instagram' ) ) : ?>
				<div class="fl-social-header">
					<?php if ( fl_opt( 'fl_facebook' ) ) : ?>
						<a href="<?php echo esc_url( fl_opt( 'fl_facebook' ) ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php echo fl_icon( 'fb' ); ?></a>
					<?php endif; ?>
					<?php if ( fl_opt( 'fl_instagram' ) ) : ?>
						<a href="<?php echo esc_url( fl_opt( 'fl_instagram' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo fl_icon( 'ig' ); ?></a>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
			<a class="fl-btn" href="<?php echo esc_url( home_url( '/epikoinonia/' ) ); ?>"><?php esc_html_e( 'Ζητήστε Προσφορά', 'firewoodleader' ); ?> →</a>
		</div>
	</nav>
</header>

<?php
function fl_default_menu() {
	$items = array(
		'Αρχική'      => home_url( '/' ),
		'Προϊόντα'    => home_url( '/proionta/' ),
		'Υπηρεσίες'   => home_url( '/ypiresies/' ),
		'Η Εταιρεία'  => home_url( '/i-etaireia/' ),
		'Επικοινωνία' => home_url( '/epikoinonia/' ),
	);
	foreach ( $items as $label => $url ) {
		printf( '<a href="%s">%s</a>', esc_url( $url ), esc_html( $label ) );
	}
}

function fl_default_footer_menu() {
	$items = array(
		'Προϊόντα'    => home_url( '/proionta/' ),
		'Υπηρεσίες'   => home_url( '/ypiresies/' ),
		'Η Εταιρεία'  => home_url( '/i-etaireia/' ),
		'Επικοινωνία' => home_url( '/epikoinonia/' ),
	);
	echo '<ul>';
	foreach ( $items as $label => $url ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}
?>
