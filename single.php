<?php get_header(); ?>

<section class="fl-page-hero">
	<h1><?php the_title(); ?></h1>
</section>

<section class="fl-section">
	<div class="fl-container">
		<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
	</div>
</section>

<?php get_footer(); ?>
