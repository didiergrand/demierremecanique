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
	<?php
	$badge_type = get_post_meta( get_the_ID(), 'badge_type', true );
	if ( empty( $badge_type ) ) {
		$badge_type = get_post_meta( get_the_ID(), 'badge', true );
	}
	if ( empty( $badge_type ) ) {
		$badge_type = get_post_meta( get_the_ID(), 'produit_badge', true );
	}

	$badge_type = ! empty( $badge_type ) ? sanitize_title( (string) $badge_type ) : '';

	$badge_label = get_post_meta( get_the_ID(), 'badge_label', true );
	if ( empty( $badge_label ) ) {
		$badge_label = get_post_meta( get_the_ID(), 'badge_texte', true );
	}

	if ( empty( $badge_label ) ) {
		if ( $badge_type === 'nouveau' ) {
			$badge_label = 'Nouveau';
		} elseif ( $badge_type === 'promo' ) {
			$badge_label = 'Promo';
		}
	}
	?>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="home-post__thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'medium_large' ); ?>
			</a>

			<?php if ( ! empty( $badge_label ) && ! empty( $badge_type ) ) : ?>
				<span class="product-badge product-badge--<?php echo esc_attr( $badge_type ); ?>">
					<?php echo esc_html( $badge_label ); ?>
				</span>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="home-post__content">
		<?php the_title( '<h3>', '</h3>' ); ?>

		<div class="entry-summary">
			<?php the_content(); ?>
		</div>

		<?php if ( is_active_sidebar( 'sidebar-product' ) ) : ?>
			<div class="product-widget">
				<?php dynamic_sidebar( 'sidebar-product' ); ?>
			</div>
		<?php endif; ?>
	</div>
</article>

