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
$home_post_index = isset( $GLOBALS['demierre_home_post_index'] ) ? (int) $GLOBALS['demierre_home_post_index'] : 0;
$is_image_right = ( $home_post_index % 2 !== 0 );
?>
<div class="news-content">
<article id="post-<?php the_ID(); ?>" <?php
	$classes = array( 'home-post' );
	if ( $is_image_right ) {
		$classes[] = 'home-post--image-right';
	}
	post_class( $classes );
?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="home-post__thumbnail">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>
	<?php endif; ?>

	<div class="home-post__content">
		<?php the_title( '<h2>', '</h2>' ); ?>


		<div class="entry-summary">
			<?php the_content(); ?>
		</div>
	</div>
</article>
</div>