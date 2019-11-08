<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package OG
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<style>html{visibility: hidden;opacity:0;}</style>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'OG' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="content-width">
			<div class="site-branding">
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			</div><!-- .site-branding -->
		
			<nav id="site-navigation" class="main-navigation" aria-label="Primary">
				<div id="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<div class="menu-icon hover-target">
						<span class="menu-icon__line menu-icon__line-left"></span>
						<span class="menu-icon__line"></span>
						<span class="menu-icon__line menu-icon__line-right"></span>
					</div>
				</div>
				<div id="primary-menu-wrap">
					<?php 
				if( class_exists( 'WPSS_Nav_Walker', false ) ) {
					wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container' => 'div', 'container_id' => 'primary-menu-wrap', 'items_wrap' => '<ul id="%1$s" class="%2$s"><div class="content-width">%3$s</div></ul>', 'walker' => new WPSS_Nav_Walker(), ) );
				}
				else {
					wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container' => 'div', 'container_id' => 'primary-menu-wrap', 'items_wrap' => '<ul id="%1$s" class="%2$s"><div class="content-width">%3$s</div></ul>' ) );
				}
			?>
			</nav><!-- #site-navigation -->
			<div class="cart-navigation">
				<?php 
					if( class_exists( 'WPSS_Nav_Walker', false ) ) {
						wp_nav_menu( array( 'theme_location' => 'cart', 'menu_id' => 'cart-menu', 'walker' => new WPSS_Nav_Walker(), ) );
					}
					else {
						wp_nav_menu( array( 'theme_location' => 'cart', 'menu_id' => 'cart-menu' ) );
					}
				?>
			</div><!-- .cart-navigation -->
		</div><!-- .content-width -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
