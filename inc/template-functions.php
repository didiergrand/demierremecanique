<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Demierre_mecanique
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function demierre_mecanique_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'demierre_mecanique_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function demierre_mecanique_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'demierre_mecanique_pingback_header' );

/**
 * Get default header image URL.
 *
 * @return string Default header image URL.
 */
function demierre_mecanique_get_default_header_image() {
	return 'https://www.demierre-mecanique.ch/wp-content/uploads/2022/10/cropped-banner_demierre_mecanique_2022_3-scaled-1.jpg';
}

/**
 * Get ordered list of header images for carousel.
 * Current image stays first, then the others.
 *
 * @param string $current_image Current header image URL.
 * @return array
 */
function demierre_mecanique_get_header_carousel_images( $current_image = '' ) {
	$images = array();

	if ( $current_image ) {
		$images[] = $current_image;
	}

	$uploaded_headers = get_uploaded_header_images();
	if ( ! empty( $uploaded_headers ) ) {
		foreach ( $uploaded_headers as $uploaded_header ) {
			if ( ! empty( $uploaded_header['url'] ) ) {
				$images[] = $uploaded_header['url'];
			}
		}
	}

	$images = array_values( array_unique( $images ) );

	if ( empty( $images ) ) {
		$images[] = demierre_mecanique_get_default_header_image();
	}

	return $images;
}

/**
 * Get header image for post/page.
 *
 * @param int $post_id Post ID.
 * @return string Header image URL.
 */
function demierre_mecanique_get_header_image( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	// For posts, always use the site header image (same as homepage)
	if ( get_post_type( $post_id ) === 'post' ) {
		$header_image = get_header_image();
		if ( $header_image ) {
			return $header_image;
		}
		return demierre_mecanique_get_default_header_image();
	}

	// For pages, use featured image if available, otherwise default header image
	if ( has_post_thumbnail( $post_id ) ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );
		return $image[0];
	}

	return demierre_mecanique_get_default_header_image();
}

/**
 * Display header image with title for single posts/pages.
 *
 * @param string $title The title to display.
 */
function demierre_mecanique_display_header_image( $title = '', $show_title = true ) {
	$image = demierre_mecanique_get_header_image();
	$carousel_images = array();

	// For posts, use custom header images as a carousel.
	if ( is_singular( 'post' ) ) {
		$carousel_images = demierre_mecanique_get_header_carousel_images( $image );
	}
	?>
	<div class="header-image" <?php echo count( $carousel_images ) > 1 ? 'data-carousel-images="' . esc_attr( wp_json_encode( $carousel_images ) ) . '"' : ''; ?>>
		<div class="header-image-bg" style="background-image: url(<?php echo esc_url( $image ); ?>);"></div>
		<?php if ( $show_title ) : ?>
			<div class="container">
				<div class="header-image-content">
					<?php if ( $title ) : ?>
						<h1 class="entry-title"><?php echo wp_kses_post( $title ); ?></h1>
					<?php else : ?>
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Display header image for archive pages.
 *
 * @param string $title The archive title to display.
 */
function demierre_mecanique_display_archive_header_image( $title = '' ) {
	$image = demierre_mecanique_get_default_header_image();
	
	// Use taxonomy image from "Categories Images" plugin if available
	if ( ( is_category() || is_tax() ) && function_exists( 'z_taxonomy_image_url' ) ) {
		$term_id = get_queried_object_id();
		$taxonomy_image = z_taxonomy_image_url( $term_id, 'full', false );
		if ( $taxonomy_image ) {
			$image = $taxonomy_image;
		}
	}
	
	?>
	<div class="header-image">
		<div class="header-image-bg" style="background-image: url(<?php echo esc_url( $image ); ?>);"></div>
		<div class="container">
			<div class="header-image-content">
				<?php if ( $title ) : ?>
					<h1 class="entry-title"><?php echo wp_kses_post( $title ); ?></h1>
				<?php else : ?>
					<?php the_archive_title( '<h1 class="entry-title">', '</h1>' ); ?>
				<?php endif; ?>
				<?php
				$description = get_the_archive_description();
				if ( $description ) :
					?>
					<div class="archive-description"><?php echo wp_kses_post( $description ); ?></div>
					<?php
				endif;
				?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Get homepage carousel slides from a category slug.
 *
 * Each slide is built from the post featured image and basic post data.
 *
 * @param string $category_slug Category slug (e.g. "slides-accueil").
 * @return array[] Array of slides: [ 'image' => string, 'title' => string, 'excerpt' => string, 'link' => string ].
 */
function demierre_mecanique_get_home_slides( $category_slug = 'slides-accueil' ) {
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => -1,
		'category_name' => $category_slug,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$query = new WP_Query( $args );
	if ( ! $query->have_posts() ) {
		return array();
	}

	$slides = array();

	foreach ( $query->posts as $post ) {
		setup_postdata( $post );

		$image_url = get_the_post_thumbnail_url( $post->ID, 'full' );
		if ( ! $image_url ) {
			// Requirement: use the featured image. If a post has none, skip it.
			continue;
		}

		$title   = get_the_title( $post->ID );
		$excerpt = wp_trim_words(
			wp_strip_all_tags( get_the_excerpt( $post->ID ) ),
			30,
			'...'
		);

		$slides[] = array(
			'image'   => $image_url,
			'title'   => $title,
			'excerpt' => $excerpt,
			'link'    => get_permalink( $post->ID ),
		);
	}

	wp_reset_postdata();

	return $slides;
}
