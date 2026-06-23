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

	// Detect and extract a gallery from the post content.
	$post_content = get_the_content();
	$gallery_html = '';
	$content_html = '';

	if ( has_blocks( $post_content ) ) {
		// Match the first wp:gallery block including its inner blocks.
		if ( preg_match( '/<!--\s*wp:gallery[\s\S]*?<!--\s*\/wp:gallery\s*-->/i', $post_content, $gallery_match ) ) {
			/*
			 * WordPress uses uniqid() (without extra entropy) for galleryId.
			 * On fast servers, two galleries rendered in the same microsecond
			 * can receive the same ID, causing their lightbox navigations to merge.
			 * Override with a post-specific ID to guarantee isolation.
			 */
			$post_id             = get_the_ID();
			$gallery_id_filter   = static function ( $context, $parsed_block ) use ( $post_id ) {
				if ( 'core/gallery' === $parsed_block['blockName'] ) {
					$context['galleryId'] = 'post' . $post_id . '_' . uniqid( '', true );
				}
				return $context;
			};

			add_filter( 'render_block_context', $gallery_id_filter, 15, 2 );
			$gallery_html = do_blocks( $gallery_match[0] );
			remove_filter( 'render_block_context', $gallery_id_filter, 15 );

			$remaining    = str_replace( $gallery_match[0], '', $post_content );
			$content_html = apply_filters( 'the_content', $remaining );
		}
	}

	if ( empty( $gallery_html ) && has_shortcode( $post_content, 'gallery' ) ) {
		if ( preg_match( '/\[gallery[^\]]*\]/', $post_content, $gallery_match ) ) {
			$gallery_html = do_shortcode( $gallery_match[0] );
			$remaining    = str_replace( $gallery_match[0], '', $post_content );
			$content_html = apply_filters( 'the_content', $remaining );
		}
	}

	$has_gallery = ! empty( $gallery_html );
	?>

	<?php if ( $has_gallery ) : ?>
		<div class="home-post__thumbnail home-post__thumbnail--gallery">
			<?php echo $gallery_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php if ( ! empty( $badge_label ) && ! empty( $badge_type ) ) : ?>
				<span class="product-badge product-badge--<?php echo esc_attr( $badge_type ); ?>">
					<?php echo esc_html( $badge_label ); ?>
				</span>
			<?php endif; ?>
		</div>
	<?php elseif ( has_post_thumbnail() ) : ?>
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
			<?php if ( $has_gallery ) : ?>
				<?php echo $content_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php else : ?>
				<?php the_content(); ?>
			<?php endif; ?>
		</div>

		<?php if ( is_active_sidebar( 'sidebar-product' ) ) : ?>
			<div class="product-widget">
				<?php dynamic_sidebar( 'sidebar-product' ); ?>
			</div>
		<?php endif; ?>
	</div>
</article>
