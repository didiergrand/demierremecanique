<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Demierre_mecanique
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			demierre_mecanique_display_header_image( '', false );
			break; // Only need to display header once
		endwhile;
		rewind_posts();
	endif;
	?>
	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'demierre-mecanique' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
</article><!-- page #post-<?php the_ID(); ?> -->
