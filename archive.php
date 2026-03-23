<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Garage_Girard
 */

get_header();
?>

<?php
// Display archive header with background image
if ( have_posts() ) {
	demierre_mecanique_display_archive_header_image();
}
?>

	<main id="primary" class="site-main">
		<div class="container container-small">
			<?php if ( have_posts() ) : ?>

					<div id="news">
					<div class="news-content">
						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/*
							 * Include the Post-Type-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'home');

						endwhile;

						the_posts_navigation();
						?>
					</div>
				</div>

			<?php else :

				get_template_part( 'template-parts/content', 'none' );

				endif;
			?>
		</div>
	</main><!-- #main -->

<?php
get_footer();
