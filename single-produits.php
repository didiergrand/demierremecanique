<?php
/**
 * Template for displaying single products.
 *
 * @package Demierre_mecanique
 */
get_header();
?>

<?php
// Product header (uses featured image / default header image like posts/pages).
demierre_mecanique_display_header_image();
?>

<main id="primary" class="site-main">
	<div class="container container-small">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'product' );
		endwhile;
		?>
	</div>
</main><!-- #main -->

<?php
get_footer();

