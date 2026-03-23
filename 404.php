<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Garage_Girard
 */

get_header();
?>

	<main id="primary" class="site-main">
		<section class="error-404 not-found">
			<div class="container container-small">
				<div class="error-404-card">
					<p class="error-404-code">404</p>
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Page introuvable', 'demierre-mecanique' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p><?php esc_html_e( 'La page que vous cherchez n\'existe plus ou a ete deplacee. Vous pouvez faire une recherche ou acceder rapidement aux pages principales.', 'demierre-mecanique' ); ?></p>

						<div class="error-404-search">
							<?php get_search_form(); ?>
						</div>

						<div class="error-404-links">
							<h2 class="widget-title"><?php esc_html_e( 'Pages utiles', 'demierre-mecanique' ); ?></h2>
							<ul>
								<?php
								wp_list_pages(
									array(
										'title_li'    => '',
										'depth'       => 1,
										'sort_column' => 'menu_order,post_title',
										'number'      => 6,
									)
								);
								?>
							</ul>
						</div>
					</div><!-- .page-content -->
				</div>
			</div>
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
