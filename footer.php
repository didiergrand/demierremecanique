<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Demierre_mecanique
 */

?>

	<?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
		<div class="footer-widgets">
			<div class="container">
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-footer-secondary' ) ) : ?>
		<div class="footer-widgets footer-widgets--secondary">
			<div class="container">
				<?php dynamic_sidebar( 'sidebar-footer-secondary' ); ?>
			</div>
		</div>
	<?php endif; ?>
	<footer id="colophon" class="site-footer">
	<div class="site-info">
		<div class="container">
		© Demierre Entretien et Mécanique | webdesign & code : Didier Grand - <a href="https://www.digitalgarage.ch?ref=demierre-mecanique">digitalgarage.ch</a>
		</div>
	</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
