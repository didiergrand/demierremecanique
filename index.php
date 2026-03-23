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
$carousel_images = demierre_mecanique_get_header_carousel_images( $header_image );
?>
<div class="header-image" <?php echo count( $carousel_images ) > 1 ? 'data-carousel-images="' . esc_attr( wp_json_encode( $carousel_images ) ) . '"' : ''; ?>>
	<img src="<?php echo esc_url( $header_image ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" alt="" />
	<div class="container">
		<div class="header-image-content">
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
