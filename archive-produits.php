<?php
/**
 * Template for displaying a products archive (CPT).
 *
 * @package Demierre_mecanique
 */
get_header();
?>

<?php
if ( have_posts() ) {
	demierre_mecanique_display_archive_header_image();
}
?>

<main id="primary" class="site-main">
	<div class="container container-small">
		<?php if ( have_posts() ) : ?>
			<div id="news">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'product' );
				endwhile;
				?>
				<?php the_posts_navigation(); ?>
			</div>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>
</main><!-- #main -->

<?php
get_footer();

