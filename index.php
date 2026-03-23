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
$is_home_page = is_front_page() && is_home();

if ( $is_home_page ) {
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
			<?php if ( $is_home_page ) : ?>
				<?php
				$get_cta_data = static function( $post_id ) {
					$text_keys = array( 'button_text', 'bouton_texte', 'cta_text', 'lien_texte' );
					$link_keys = array( 'button_link', 'bouton_lien', 'cta_link', 'lien_url' );

					$button_text = '';
					$button_link = '';

					foreach ( $text_keys as $key ) {
						$value = get_post_meta( $post_id, $key, true );
						if ( ! empty( $value ) ) {
							$button_text = $value;
							break;
						}
					}

					foreach ( $link_keys as $key ) {
						$value = get_post_meta( $post_id, $key, true );
						if ( ! empty( $value ) ) {
							$button_link = $value;
							break;
						}
					}

					return array(
						'text' => $button_text,
						'link' => $button_link,
					);
				};
				?>

				<?php
				$welcome_query = new WP_Query(
					array(
						'post_type'      => 'post',
						'posts_per_page' => 10,
						'category_name' => 'bienvenue',
						'orderby'        => 'date',
						'order'          => 'DESC',
					)
				);
				?>
				<?php if ( $welcome_query->have_posts() ) : ?>
					<section class="home-welcome-section">
						<?php while ( $welcome_query->have_posts() ) : $welcome_query->the_post(); ?>
							<article class="home-welcome-item">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="home-welcome-image">
										<?php the_post_thumbnail( 'large' ); ?>
									</div>
								<?php endif; ?>
								<h2 class="home-welcome-title"><?php the_title(); ?></h2>
								<div class="home-welcome-content">
									<?php the_content(); ?>
								</div>
							</article>
						<?php endwhile; ?>
					</section>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>

				<?php
				$encart_query = new WP_Query(
					array(
						'post_type'      => 'post',
						'posts_per_page' => 3,
						'category_name' => 'encart',
						'orderby'        => 'date',
						'order'          => 'DESC',
					)
				);
				?>
				<?php if ( $encart_query->have_posts() ) : ?>
					<section class="home-cards-section home-cards-section--encart">
						<div class="home-cards-grid home-cards-grid--3">
							<?php while ( $encart_query->have_posts() ) : $encart_query->the_post(); ?>
								<?php $encart_cta = $get_cta_data( get_the_ID() ); ?>
								<article class="home-card home-card--left">
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="home-card-image">
											<?php the_post_thumbnail( 'large' ); ?>
										</div>
									<?php endif; ?>
									<div class="home-card-content">
										<h3 class="home-card-title"><?php the_title(); ?></h3>
										<div class="home-card-text"><?php the_content(); ?></div>
										<?php if ( ! empty( $encart_cta['text'] ) && ! empty( $encart_cta['link'] ) ) : ?>
											<a class="btn-default home-card-button" href="<?php echo esc_url( $encart_cta['link'] ); ?>">
												<?php echo esc_html( $encart_cta['text'] ); ?>
											</a>
										<?php endif; ?>
									</div>
								</article>
							<?php endwhile; ?>
						</div>
					</section>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>

				<?php
				$service_intro_query = new WP_Query(
					array(
						'post_type'      => 'post',
						'posts_per_page' => 1,
						'category_name' => 'service_intro',
						'orderby'        => 'date',
						'order'          => 'DESC',
					)
				);
				?>
				<?php if ( $service_intro_query->have_posts() ) : ?>
					<section class="home-service-intro">
						<?php while ( $service_intro_query->have_posts() ) : $service_intro_query->the_post(); ?>
							<h2 class="home-service-intro-title"><?php the_title(); ?></h2>
							<div class="home-service-intro-text"><?php the_content(); ?></div>
						<?php endwhile; ?>
					</section>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>

				<?php
				$service_query = new WP_Query(
					array(
						'post_type'      => 'post',
						'posts_per_page' => 4,
						'category_name' => 'service',
						'orderby'        => 'date',
						'order'          => 'DESC',
					)
				);
				?>
				<?php if ( $service_query->have_posts() ) : ?>
					<section class="home-cards-section home-cards-section--service">
						<div class="home-cards-grid home-cards-grid--4">
							<?php while ( $service_query->have_posts() ) : $service_query->the_post(); ?>
								<?php $service_cta = $get_cta_data( get_the_ID() ); ?>
								<article class="home-card home-card--center">
									<div class="home-card-content">
										<?php if ( has_post_thumbnail() ) : ?>
											<div class="home-service-image">
												<?php the_post_thumbnail( 'large' ); ?>
											</div>
										<?php endif; ?>
										<h3 class="home-card-title"><?php the_title(); ?></h3>
										<div class="home-card-text"><?php the_content(); ?></div>
										<?php if ( ! empty( $service_cta['text'] ) && ! empty( $service_cta['link'] ) ) : ?>
											<a class="btn-default home-card-button" href="<?php echo esc_url( $service_cta['link'] ); ?>">
												<?php echo esc_html( $service_cta['text'] ); ?>
											</a>
										<?php endif; ?>
									</div>
								</article>
							<?php endwhile; ?>
						</div>
					</section>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

			<div class="content-wrapper">
				<div id="news">
					<div class="news-content">
					<?php
					global $wp_query;

					if ( $is_home_page ) {
						$news_args = array(
							'post_type'      => 'post',
							'posts_per_page' => 3,
							'category_name' => 'actualites',
							'orderby'        => 'date',
							'order'          => 'DESC',
						);

						$news_query = new WP_Query( $news_args );
					} else {
						$news_query = $wp_query;
					}

					if ( $news_query->have_posts() ) :
						if ( is_home() && ! is_front_page() ) :
							?>
							<header>
								<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
							</header>
							<?php
						else :
							?>
							<header>
								<h2 class="page-title screen-reader-text"><?php single_post_title(); ?></h2>
							</header>
							<?php
						endif;

						while ( $news_query->have_posts() ) :
							$news_query->the_post();
							get_template_part( 'template-parts/content', 'home' );
						endwhile;
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif;

					if ( $is_home_page && $news_query->found_posts > 4 ) :
						?>
						<div class="news-button-wrapper">
							<a href="<?php echo esc_url( home_url( '/categorie/actualites/' ) ); ?>" class="btn-default"><?php esc_html_e( 'Voir toutes les actualités', 'demierre-mecanique' ); ?></a>
						</div>
						<?php
					endif;

					if ( $is_home_page ) {
						wp_reset_postdata();
					}
					?>
					</div>
				</div>
				<div id="right-sidebar">
					<?php dynamic_sidebar( 'sidebar-right' );?>
				</div>
			</div>
		</div>
	</main><!-- #main -->


<?php
get_footer();
