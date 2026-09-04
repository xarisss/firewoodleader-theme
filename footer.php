<footer class="fl-footer">
	<div class="fl-container">
		<div class="fl-footer-grid">
			<div>
				<a class="fl-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if ( fl_opt( 'fl_footer_logo_image', fl_opt( 'fl_logo_image' ) ) ) : ?>
						<img class="fl-logo-img" src="<?php echo esc_url( fl_opt( 'fl_footer_logo_image', fl_opt( 'fl_logo_image' ) ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" style="height:<?php echo (int) fl_opt( 'fl_footer_logo_height', fl_opt( 'fl_logo_height' ) ); ?>px;">
					<?php else : ?>
						<span class="fl-logo-flame"><?php echo fl_icon( 'flame' ); ?></span>
						<?php echo esc_html( fl_opt( 'fl_logo_part1' ) ); ?><span><?php echo esc_html( fl_opt( 'fl_logo_part2' ) ); ?></span>
					<?php endif; ?>
				</a>
				<p><?php echo esc_html( fl_opt( 'fl_footer_tagline' ) ); ?></p>
				<?php if ( fl_opt( 'fl_facebook' ) || fl_opt( 'fl_instagram' ) ) : ?>
				<div class="fl-social">
					<?php if ( fl_opt( 'fl_facebook' ) ) : ?>
						<a href="<?php echo esc_url( fl_opt( 'fl_facebook' ) ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php echo fl_icon( 'fb' ); ?></a>
					<?php endif; ?>
					<?php if ( fl_opt( 'fl_instagram' ) ) : ?>
						<a href="<?php echo esc_url( fl_opt( 'fl_instagram' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo fl_icon( 'ig' ); ?></a>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>

			<div>
				<h4><?php esc_html_e( 'Γρήγοροι Σύνδεσμοι', 'firewoodleader' ); ?></h4>
				<nav aria-label="<?php esc_attr_e( 'Μενού Footer', 'firewoodleader' ); ?>">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'container'      => false,
						'items_wrap'     => '<ul>%3$s</ul>',
						'fallback_cb'    => 'fl_default_footer_menu',
					) );
					?>
				</nav>
			</div>

			<div>
				<h4><?php esc_html_e( 'Επικοινωνία', 'firewoodleader' ); ?></h4>
				<ul class="fl-footer-contact">
					<?php if ( fl_opt( 'fl_address' ) ) : ?><li><?php echo fl_icon( 'pin' ); ?><span><?php echo esc_html( fl_opt( 'fl_address' ) ); ?></span></li><?php endif; ?>
					<?php if ( fl_opt( 'fl_phone' ) ) : ?><li><?php echo fl_icon( 'phone' ); ?><span><?php echo esc_html( fl_opt( 'fl_phone' ) ); ?></span></li><?php endif; ?>
					<?php if ( fl_opt( 'fl_phone2' ) ) : ?><li><?php echo fl_icon( 'phone' ); ?><span><?php echo esc_html( fl_opt( 'fl_phone2' ) ); ?></span></li><?php endif; ?>
					<?php if ( fl_opt( 'fl_email' ) ) : ?><li><?php echo fl_icon( 'mail' ); ?><span><?php echo esc_html( fl_opt( 'fl_email' ) ); ?></span></li><?php endif; ?>
				</ul>
			</div>

			<div>
				<h4><?php esc_html_e( 'Ωράριο Λειτουργίας', 'firewoodleader' ); ?></h4>
				<ul class="fl-footer-contact">
					<?php if ( fl_opt( 'fl_hours_weekday' ) ) : ?><li><?php echo fl_icon( 'clock' ); ?><span><?php echo esc_html( fl_opt( 'fl_hours_weekday' ) ); ?></span></li><?php endif; ?>
					<?php if ( fl_opt( 'fl_hours_saturday' ) ) : ?><li><?php echo fl_icon( 'clock' ); ?><span><?php echo esc_html( fl_opt( 'fl_hours_saturday' ) ); ?></span></li><?php endif; ?>
					<?php if ( fl_opt( 'fl_hours_sunday' ) ) : ?><li><?php echo fl_icon( 'clock' ); ?><span><?php echo esc_html( fl_opt( 'fl_hours_sunday' ) ); ?></span></li><?php endif; ?>
				</ul>
			</div>
		</div>

		<div class="fl-footer-bottom">
			<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( fl_opt( 'fl_footer_legal' ) ); ?></span>
			<?php $footer_location_url = fl_opt( 'fl_footer_location_url' ); ?>
			<?php if ( $footer_location_url ) : ?>
				<a href="<?php echo esc_url( $footer_location_url ); ?>"><?php echo esc_html( fl_opt( 'fl_footer_location' ) ); ?></a>
			<?php else : ?>
				<span><?php echo esc_html( fl_opt( 'fl_footer_location' ) ); ?></span>
			<?php endif; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
