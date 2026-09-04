<?php get_header(); ?>

<section class="fl-section">
	<div class="fl-container">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?>>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Δεν βρέθηκε περιεχόμενο.', 'firewoodleader' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
