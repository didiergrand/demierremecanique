<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Garage_Girard
 */

get_header();
$header_image = get_header_image();
$home_slides = array();

if ( is_front_page() && is_home() ) {
	$home_slides = demierre_mecanique_get_home_slides( 'slides-accueil' );
}

if ( ! empty( $home_slides ) ) {
	$carousel_images       = array_column( $home_slides, 'image' );
	$header_image_to_show  = $carousel_images[0] ?? $header_image;
} else {
	$carousel_images      = demierre_mecanique_get_header_carousel_images( $header_image );
	$header_image_to_show = $header_image;
}
?>
<div class="header-image" <?php echo count( $carousel_images ) > 1 ? 'data-carousel-images="' . esc_attr( wp_json_encode( $carousel_images ) ) . '"' : ''; ?> <?php echo ! empty( $home_slides ) ? 'data-carousel-slides="' . esc_attr( wp_json_encode( $home_slides ) ) . '"' : ''; ?>>
	<div
		class="header-image-bg"
		style="background-image:url('<?php echo esc_url( $header_image_to_show ); ?>');"
		aria-hidden="true"
	></div>
	<img class="header-carousel-fallback-img" src="<?php echo esc_url( $header_image_to_show ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" alt="" aria-hidden="true" />
	<div class="container">
		<div class="header-image-content">
			<?php if ( ! empty( $home_slides ) ) : ?>
				<?php $first_slide = $home_slides[0]; ?>
				<div class="header-carousel-panel">
					<h1 class="header-carousel-title">
						<a class="header-carousel-title-link" href="<?php echo esc_url( $first_slide['link'] ); ?>">
							<?php echo esc_html( $first_slide['title'] ); ?>
						</a>
					</h1>
					<?php if ( ! empty( $first_slide['excerpt'] ) ) : ?>
						<p class="header-carousel-excerpt"><?php echo esc_html( $first_slide['excerpt'] ); ?></p>
					<?php endif; ?>
					<a class="header-carousel-button btn-default" href="<?php echo esc_url( $first_slide['link'] ); ?>">
						<?php echo esc_html__( 'En savoir plus', 'demierre-mecanique' ); ?>
					</a>
				</div>
			<?php else : ?>
				<?php
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				$demierre_mecanique_description = get_bloginfo( 'description', 'display' );
				if ( $demierre_mecanique_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo $demierre_mecanique_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
	<main id="primary" class="site-main">
		<div class="container">
			<div class="content-wrapper">
				<div id="right-sidebar">
					<?php dynamic_sidebar( 'sidebar-right' );?>
				</div>
				<div id="news">
					<div class="news-content">
					<?php
					if ( have_posts() ) :

						if ( is_home() && ! is_front_page() ) :
							?>
							<header>
								<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
							</header>
							<?php
						else:
							?>
							<header>
								<h2 class="page-title screen-reader-text"><?php single_post_title(); ?></h2>
							</header>
							<?php
						endif;

						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/*
							* Include the Post-Type-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Type name) and that will be used instead.
							*/
							get_template_part( 'template-parts/content', 'home' );

						endwhile;
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif;
					?>
					<?php
					global $wp_query;
					if ( $wp_query->found_posts > 4 ) :
						?>
						<div class="news-button-wrapper">
							<a href="<?php echo esc_url( home_url( '/categorie/actualites/' ) ); ?>" class="btn-default"><?php esc_html_e( 'Voir toutes les actualités', 'demierre-mecanique' ); ?></a>
						</div>
						<?php
					endif;
					?>
					</div>
				</div>
			</div>
		</div>
	</main><!-- #main -->


<?php
get_footer();
