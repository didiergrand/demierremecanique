<?php
/**
 * Template part for displaying a single "produits" item.
 *
 * Design: same base layout as the home posts (image left / content right).
 *
 * @package Demierre_mecanique
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'home-post produits-post' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="home-post__thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'medium_large' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="home-post__content">
		<?php the_title( '<h3>', '</h3>' ); ?>

		<div class="entry-summary">
			<?php the_content(); ?>
		</div>
	</div>
</article>

