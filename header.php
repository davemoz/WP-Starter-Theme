<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package WPSS
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
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'WPSS' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<div class="content-width">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<!--<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>-->
			</div><!-- .content-width -->
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div id="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<div class="menu-icon hover-target">
					<span class="menu-icon__line menu-icon__line-left"></span>
					<span class="menu-icon__line"></span>
					<span class="menu-icon__line menu-icon__line-right"></span>
				</div>
			</div>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container' => 'div', 'container_id' => 'primary-menu-wrap', 'items_wrap' => '<ul id="%1$s" class="%2$s"><div class="content-width">%3$s</div></ul>', 'walker' => new KMC_Walker_Nav_Menu(), ) ); ?>
			<div class="mobile-nav-overlay"></div>
		</nav><!-- #site-navigation -->
		<div class="cart-navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'cart', 'menu_id' => 'cart-menu', 'walker' => new KMC_Walker_Nav_Menu(), ) ); ?>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
