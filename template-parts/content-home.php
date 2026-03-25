<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Demierre_mecanique
 */

?>
<?php
$home_post_index = isset( $GLOBALS['demierre_home_post_index'] ) ? (int) $GLOBALS['demierre_home_post_index'] : null;
$is_image_right  = ( null !== $home_post_index && $home_post_index % 2 === 0 );
?>
<article id="post-<?php the_ID(); ?>" <?php
$classes = array( 'home-post' );
if ( $is_image_right ) {
	$classes[] = 'home-post--image-right';
}
post_class( $classes );
?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="home-post__thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'medium_large' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="home-post__content">
		<?php the_title( '<h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<div class="entry-summary">
			<?php the_content(); ?>
		</div>
	</div>
</article>
