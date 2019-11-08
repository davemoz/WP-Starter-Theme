<?php

/**
 * WPSS functions and definitions
 *
 * @package WPSS
 */

if (!function_exists('WPSS_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function WPSS_setup()
	{
		/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on WPSS, use a find and replace
	 * to change 'WPSS' to the name of your theme in all the template files
	 */
		load_theme_textdomain('WPSS', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
		add_theme_support('title-tag');

		/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
		add_theme_support('post-thumbnails');

		// Register Nav Menus
		register_nav_menus(array(
			'primary' => esc_html__('Primary Menu', 'WPSS'),
			'cart' => esc_html__('Cart Menu', 'WPSS'),
			'footer' => esc_html__('Footer Menu', 'WPSS'),
		));

		/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		/*
	 * Add Editor Style for adequate styling in text editor.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_editor_style
	 */
		add_editor_style('editor-style.css');
	}
endif; // WPSS_setup
add_action('after_setup_theme', 'WPSS_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function WPSS_content_width()
{
	$GLOBALS['content_width'] = apply_filters('WPSS_content_width', 640);
}
add_action('after_setup_theme', 'WPSS_content_width', 0);

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function WPSS_widgets_init()
{
	register_sidebar(array(
		'name' => esc_html__('Sidebar', 'WPSS'),
		'id' => 'sidebar-1',
		'description' => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	));
}
add_action('widgets_init', 'WPSS_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function WPSS_scripts()
{
	wp_enqueue_style('WPSS-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
	
	wp_enqueue_style('paymentfont-css', get_template_directory_uri() . '/inc/paymentfont/css/paymentfont.min.css', array(), '1.2.5' );

	wp_enqueue_script('font-awesome', 'https://use.fontawesome.com/releases/v5.7.2/js/all.js', array(), null);

	wp_enqueue_script('WPSS-navigation', get_template_directory_uri() . '/js/navigation-min.js', array(), filemtime( get_template_directory() . '/js/navigation-min.js' ), true);

	wp_enqueue_script('WPSS-site-scripts', get_template_directory_uri() . '/js/site-scripts-min.js', array('jquery'), filemtime( get_template_directory() . '/js/site-scripts-min.js' ), true);

	wp_enqueue_script('WPSS-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), filemtime( get_template_directory() . '/js/skip-link-focus-fix.js' ), true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'WPSS_scripts');

/**
 * Filter the HTML script tags to add attributes.
 *
 * @param string $tag    The <script> tag for the enqueued script.
 * @param string $handle The script's registered handle.
 * @param string $src    The script's uri source.
 *
 * @return   Filtered HTML script tag.
 */
add_filter('script_loader_tag', 'add_attribs_to_scripts', 10, 3);

function add_attribs_to_scripts($tag, $handle, $src)
{

	// The handles of the enqueued scripts we want to defer
	$async_scripts = array(
		'WPSS-scripts',
	);

	$defer_scripts = array(
		'WPSS-scripts',
	);

	$fontawesome = array(
		'font-awesome',
	);

	$jquery = array(
		'jquery'
	);

	if (in_array($handle, $defer_scripts)) {
		return '<script defer src="' . $src . '" type="text/javascript"></script>' . "\n";
	}
	if (in_array($handle, $async_scripts)) {
		return '<script async src="' . $src . '" async="async" type="text/javascript"></script>' . "\n";
	}
	if (in_array($handle, $fontawesome)) {
		return '<script defer src="' . $src . '" integrity="sha384-0pzryjIRos8mFBWMzSSZApWtPl/5++eIfzYmTgBBmXYdhvxPc+XcFEk+zJwDgWbP" crossorigin="anonymous"></script>' . "\n";
	}
	if (in_array($handle, $jquery)) {
		return '<script src="' . $src . '" crossorigin="anonymous" type="text/javascript"></script>' . "\n";
	}
	return $tag;
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**************************************************************************
 *
 *  WooCommerce
 *
 *  Uncomment the block below to include WooCommerce functions
 * 
 **************************************************************************/

/**
 * Include WooCommerce functions
 */
// require_once __DIR__ . '/inc/WPSS-functions/woocommerce-functions.php';


/**************************************************************************
 *
 *  Add some reusable SVGs when wp_head loads
 *
 *  Uncomment the block below to use the SVG sprites.
 * 
 *  Add your own <symbol>'s to use with <use> tags
 * 
 **************************************************************************/
/*
function WPSS_svg_sprites() {
	echo '<div id="svg-icons" class="visually-hidden">
			
			<svg xmlns="http://www.w3.org/2000/svg">
			
				<symbol id="play-button" viewBox="0 0 145 109"><path fill="#9800FF" style="fill: var(--pill-color);" d="M54.5 0h36C120.6 0 145 24.4 145 54.5S120.6 109 90.5 109h-36C24.4 109 0 84.6 0 54.5S24.4 0 54.5 0z"/><path fill="#fff" style="fill: var(--triangle-color);" d="M103.004 58.454L58.002 84.462a4.003 4.003 0 0 1-5.464-1.454 3.986 3.986 0 0 1-.538-2V28.992A3.995 3.995 0 0 1 55.999 25c.703 0 1.394.185 2.003.537l45.002 26.008a3.988 3.988 0 0 1 0 6.91v-.001z"/></symbol>
				
				<symbol id="instagram-gradient-logo" viewBox="0 0 552 552" width="552" height="552">
				    <defs>
				        <linearGradient x1="50%" y1="99.709%" x2="50%" y2="0.777%" id="linearGradient-1">
				            <stop stop-color="#E09B3D" offset="0%"></stop>
				            <stop stop-color="#C74C4D" offset="30%"></stop>
				            <stop stop-color="#C21975" offset="60%"></stop>
				            <stop stop-color="#7024C4" offset="100%"></stop>
				        </linearGradient>
				        <linearGradient x1="50%" y1="146.099%" x2="50%" y2="-45.16%" id="linearGradient-2">
				            <stop stop-color="#E09B3D" offset="0%"></stop>
				            <stop stop-color="#C74C4D" offset="30%"></stop>
				            <stop stop-color="#C21975" offset="60%"></stop>
				            <stop stop-color="#7024C4" offset="100%"></stop>
				        </linearGradient>
				        <linearGradient x1="50%" y1="658.141%" x2="50%" y2="-140.029%" id="linearGradient-3">
				            <stop stop-color="#E09B3D" offset="0%"></stop>
				            <stop stop-color="#C74C4D" offset="30%"></stop>
				            <stop stop-color="#C21975" offset="60%"></stop>
				            <stop stop-color="#7024C4" offset="100%"></stop>
				        </linearGradient>
				    </defs>
				    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				        <path d="M386.878,0 L164.156,0 C73.64,0 0,73.64 0,164.156 L0,386.878 C0,477.394 73.64,551.034 164.156,551.034 L386.878,551.034 C477.394,551.034 551.034,477.394 551.034,386.878 L551.034,164.156 C551.033,73.64 477.393,0 386.878,0 Z M495.6,386.878 C495.6,446.923 446.923,495.6 386.878,495.6 L164.156,495.6 C104.111,495.6 55.434,446.923 55.434,386.878 L55.434,164.156 C55.434,104.11 104.111,55.434 164.156,55.434 L386.878,55.434 C446.923,55.434 495.6,104.11 495.6,164.156 L495.6,386.878 Z" id="Shape" fill="url(#linearGradient-1)" fill-rule="nonzero"></path>
				        <path d="M275.517,133 C196.933,133 133,196.933 133,275.516 C133,354.099 196.933,418.033 275.517,418.033 C354.101,418.033 418.034,354.1 418.034,275.516 C418.034,196.932 354.101,133 275.517,133 Z M275.517,362.6 C227.422,362.6 188.434,323.612 188.434,275.517 C188.434,227.422 227.423,188.434 275.517,188.434 C323.612,188.434 362.6,227.422 362.6,275.517 C362.6,323.611 323.611,362.6 275.517,362.6 Z" id="Shape" fill="url(#linearGradient-2)" fill-rule="nonzero"></path>
				        <circle id="Oval" fill="url(#linearGradient-3)" cx="418.31" cy="134.07" r="34.15"></circle>
				    </g>
				</symbol>
			
			</svg>
			
		</div>';
}
add_action( 'wp_head', 'WPSS_svg_sprites' );
*/
