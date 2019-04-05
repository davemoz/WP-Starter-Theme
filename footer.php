<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WPSS
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<div class="content-width">
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'WPSS' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'WPSS' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'WPSS' ), 'WPSS', '<a href="http://underscores.me/" rel="designer">Underscores.me</a>' ); ?>
			</div><!-- .content-width -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
