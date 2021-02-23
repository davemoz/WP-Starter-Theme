<?php

/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package WPSS
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function WPSS_woocommerce_setup()
{
	add_theme_support('woocommerce');
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'WPSS_woocommerce_setup');



/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function WPSS_woocommerce_scripts()
{
	wp_enqueue_style('WPSS-woocommerce-style', get_template_directory_uri() . '/public/woocommerce.css', array(), filemtime( get_template_directory() . '/public/woocommerce.css' ) );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style('gcm-woocommerce-style', $inline_font);
}
add_action('wp_enqueue_scripts', 'WPSS_woocommerce_scripts');

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function WPSS_woocommerce_active_body_class($classes)
{
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter('body_class', 'WPSS_woocommerce_active_body_class');

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function WPSS_woocommerce_products_per_page()
{
	return 12;
}
add_filter('loop_shop_per_page', 'WPSS_woocommerce_products_per_page');

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function WPSS_woocommerce_thumbnail_columns()
{
	return 4;
}
add_filter('woocommerce_product_thumbnails_columns', 'WPSS_woocommerce_thumbnail_columns');

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function WPSS_woocommerce_loop_columns()
{
	return 3;
}
add_filter('loop_shop_columns', 'WPSS_woocommerce_loop_columns');

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function WPSS_woocommerce_related_products_args($args)
{
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args($defaults, $args);

	return $args;
}
add_filter('woocommerce_output_related_products_args', 'WPSS_woocommerce_related_products_args');

if (!function_exists('WPSS_woocommerce_product_columns_wrapper')) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function WPSS_woocommerce_product_columns_wrapper()
	{
		$columns = WPSS_woocommerce_loop_columns();
		echo '<div class="columns-' . absint($columns) . '">';
	}
}
add_action('woocommerce_before_shop_loop', 'WPSS_woocommerce_product_columns_wrapper', 40);

if (!function_exists('WPSS_woocommerce_product_columns_wrapper_close')) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function WPSS_woocommerce_product_columns_wrapper_close()
	{
		echo '</div>';
	}
}
add_action('woocommerce_after_shop_loop', 'WPSS_woocommerce_product_columns_wrapper_close', 40);

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('WPSS_woocommerce_wrapper_before')) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function WPSS_woocommerce_wrapper_before()
	{
?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php
		}
	}
	add_action('woocommerce_before_main_content', 'WPSS_woocommerce_wrapper_before');

	if (!function_exists('WPSS_woocommerce_wrapper_after')) {
		/**
		 * After Content.
		 *
		 * Closes the wrapping divs.
		 *
		 * @return void
		 */
		function WPSS_woocommerce_wrapper_after()
		{
			?>
			</main><!-- #main -->
		</div><!-- #primary -->
	<?php
		}
	}
	add_action('woocommerce_after_main_content', 'WPSS_woocommerce_wrapper_after');

	/**
	 * Sample implementation of the WooCommerce Mini Cart.
	 *
	 * You can add the WooCommerce Mini Cart to header.php like so ...
	 *
	<?php
		if ( function_exists( 'WPSS_woocommerce_header_cart' ) ) {
			WPSS_woocommerce_header_cart();
		}
	?>
	 */

	if (!function_exists('WPSS_woocommerce_cart_link_fragment')) {
		/**
		 * Cart Fragments.
		 *
		 * Ensure cart contents update when products are added to the cart via AJAX.
		 *
		 * @param array $fragments Fragments to refresh via AJAX.
		 * @return array Fragments to refresh via AJAX.
		 */
		function WPSS_woocommerce_cart_link_fragment($fragments)
		{
			ob_start();
			WPSS_woocommerce_cart_link();
			$fragments['a.cart-contents'] = ob_get_clean();

			return $fragments;
		}
	}
	add_filter('woocommerce_add_to_cart_fragments', 'WPSS_woocommerce_cart_link_fragment');

	if (!function_exists('WPSS_woocommerce_cart_link')) {
		/**
		 * Cart Link.
		 *
		 * Displayed a link to the cart including the number of items present and the cart total.
		 *
		 * @return void
		 */
		function WPSS_woocommerce_cart_link()
		{
	?>
		<a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', '_s'); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n('%d item', '%d items', WC()->cart->get_cart_contents_count(), '_s'),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span> <span class="count"><?php echo esc_html($item_count_text); ?></span>
		</a>
	<?php
		}
	}

	if (!function_exists('WPSS_woocommerce_header_cart')) {
		/**
		 * Display Header Cart.
		 *
		 * @return void
		 */
		function WPSS_woocommerce_header_cart()
		{
			if (is_cart()) {
				$class = 'current-menu-item';
			} else {
				$class = '';
			}
	?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr($class); ?>">
				<?php WPSS_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget('WC_Widget_Cart', $instance);
				?>
			</li>
		</ul>
<?php
		}
	}



	/**
	 * Remove/Add/Move Stuff
	 */
	function WPSS_remove_add_move_woocommerce_stuff()
	{
		add_filter('woocommerce_enqueue_styles', '__return_empty_array'); // Remove default WooCommerce styles

		remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10); // Remove Single Product Description tab
		add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 35); // Add Single Product Description tab beneath Summary

		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40); 	// Remove product category meta

		// remove_action( '', 'woocommerce_quantity_input', 10 ); // Remove quantity input

		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
		remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
		remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
	}
	add_action('after_setup_theme', 'WPSS_remove_add_move_woocommerce_stuff');

	/**
	 * Rename product data tabs
	 */
	function WPSS_rename_tabs($tabs)
	{
		// $tabs['description']['title'] = __( 'More Information' );		// Rename the description tab
		// $tabs['reviews']['title'] = __( 'Ratings' );						// Rename the reviews tab
		// $tabs['additional_information']['title'] = __( 'Details & Fit' );	// Rename the additional information tab
		unset($tabs['additional_information']); // Remove the additional information tab

		return $tabs;
	}
	add_filter('woocommerce_product_tabs', 'WPSS_rename_tabs', 98);

	/**
	 * Create custom hook to move quantity input
	 *
function WPSS_woocommerce_custom_quantity_hook(){
	do_action('WPSS_woocommerce_custom_quantity_hook');
}
/**
	 * Move quantity input
	 */
	// remove_action( '', 'woocommerce_quantity_input', 10 );
	/*
add_action( 'WPSS_woocommerce_custom_quantity_hook', 'woocommerce_quantity_input' );
*/


	/**
	 * Add "shop" class to WooCommerce Shop page
	 */
	add_filter('body_class', 'WPSS_shop_body_class');
	function WPSS_shop_body_class($classes)
	{

		if (is_shop()) {

			$classes[] = 'shop';
		}

		return $classes;
	}

	/**
	 * Remove Shop page sections we don't want
	 */
	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
	remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
	remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);


	/**
	 * Add '.content-width' div around Shop content
	 */
	add_action('woocommerce_before_main_content', 'WPSS_add_shop_loop_wrapper_open', 40);
	function WPSS_add_shop_loop_wrapper_open()
	{
		echo '<div class="content-width">';
	}
	add_action('woocommerce_after_main_content', 'WPSS_add_shop_loop_wrapper_close', 5);
	function WPSS_add_shop_loop_wrapper_close()
	{
		echo '</div><!-- .content-width -->';
	}

	/**
	 * Replace default product title H2 with H4
	 */
	remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
	add_action('woocommerce_shop_loop_item_title', 'WPSS_product_title_to_h4', 10);
	function WPSS_product_title_to_h4()
	{
		echo '<h4 class="woocommerce-loop-product__title">' . get_the_title() . '</h4>';
	}


	/**
	 * Move Proceed To Checkout Button
	 */
	remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
	add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display', 10);

	add_action('woocommerce_cart_actions', 'woocommerce_button_proceed_to_checkout', 10);



	/**
	 * Ship to a different address opened by default
	 */
	add_filter('woocommerce_ship_to_different_address_checked', '__return_true');



	/**
	 * Remove coupon form & move it to the order review
	 */
	remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);




	/**
	 * Create custom hook for checkout prev button
	 */
	function WPSS_checkout_final_prev_hook()
	{
		do_action('WPSS_checkout_final_prev_hook');
	}
	/**
	 * Add a "Return to shipping method" button after "Submit" payment button in checkout flow page using custom hook above
	 */
	add_action('WPSS_checkout_final_prev_hook', 'add_final_prev_button', 10);

	function add_final_prev_button()
	{
		echo '<div class="checkout-nav"><a href="#shipping-view" class="button white red-text red-outline prev-btn" data-popview>Return to shipping method</a></div>';
	}


	/**
	 * Create custom hook for login form
	 */
	function WPSS_checkout_login_form_hook()
	{
		do_action('WPSS_checkout_login_form_hook');
	}
	/**
	 * @snippet Move Login @ WooCommerce Checkout
	 * @how-to Watch tutorial @ https://businessbloomer.com/?p=19055
	 * @author Rodolfo Melogli
	 * @compatible WC 2.6.13, WP 4.7.1, PHP 5.5.9
	 */
	remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10);
	add_action('WPSS_checkout_login_form_hook', 'woocommerce_checkout_login_form');


	/**
	 * Create custom hook for payment method/form
	 */
	function WPSS_payment_methods_hook()
	{
		do_action('WPSS_payment_methods_hook');
	}
	// Remove the payment options form from default location
	remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
	// Add the payment options form to our custom hook above
	add_action('WPSS_payment_methods_hook', 'woocommerce_checkout_payment', 20);


	/**
	 * @snippet       Move / ReOrder Address Fields @ Checkout Page, WooCommerce version 3.0+
	 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
	 * @sourcecode    https://businessbloomer.com/?p=19571
	 * @author        Rodolfo Melogli
	 * @testedwith    WooCommerce 3.3.4
	 */
	add_filter('woocommerce_default_address_fields', 'WPSS_reorder_checkout_fields');

	function WPSS_reorder_checkout_fields($fields)
	{

		// default priorities: 
		// 'first_name' - 10
		// 'last_name' - 20
		// 'company' - 30
		// 'country' - 40
		// 'address_1' - 50
		// 'address_2' - 60
		// 'city' - 70
		// 'state' - 80
		// 'postcode' - 90

		// e.g. move 'country' above 'first_name':
		// just assign priority less than 10
		$fields['country']['priority'] = 95;

		return $fields;
	}


	/**
	 * Change types and placeholder text for checkout billing fields
	 */
	add_filter('woocommerce_checkout_fields', 'WPSS_set_billing_fields');

	// Our hooked in function - $billing_fields is passed via the filter!
	function WPSS_set_billing_fields($billing_fields)
	{
		unset($billing_fields['billing']['billing_company']);
		unset($billing_fields['billing']['billing_phone']);

		$billing_fields['billing'] = array(
			'billing_first_name' => array(
				'placeholder' => 'First name',
				'required'    => true
			),
			'billing_last_name' => array(
				'placeholder' => 'Last name',
				'required'    => true
			),
			'billing_address_1' => array(
				'placeholder' => 'Address',
				'required'    => true
			),
			'billing_address_2' => array(
				'placeholder' => 'Apartment, suite, unit, etc. (optional)',
				'required'	  => false
			),
			'billing_city' => array(
				'placeholder' => 'City',
				'required'    => true
			),
			'billing_state' => array(
				'placeholder' => 'State',
				'required'    => true
			),
			'billing_postcode' => array(
				'placeholder' => 'ZIP code',
				'type' 	   => 'tel',
				'required'    => true
			),
			'billing_email' => array(
				'placeholder' => 'Email',
				'type' 	      => 'email',
				'required'    => true
			)
		);
		return $billing_fields;
	}


	/**
	 * Change types and placeholder text for checkout shipping fields
	 */
	add_filter('woocommerce_checkout_fields', 'WPSS_set_shipping_fields');

	// Our hooked in function - $shipping_fields is passed via the filter!
	function WPSS_set_shipping_fields($shipping_fields)
	{
		unset($shipping_fields['shipping']['shipping_company']);

		$shipping_fields['shipping'] = array(
			'shipping_first_name' => array(
				'placeholder' => 'First name'
			),
			'shipping_last_name' => array(
				'placeholder' => 'Last name'
			),
			'shipping_address_1' => array(
				'placeholder' => 'Address'
			),
			'shipping_address_2' => array(
				'placeholder' => 'Apartment, suite, unit, etc. (optional)'
			),
			'shipping_city' => array(
				'placeholder' => 'City'
			),
			'shipping_state' => array(
				'placeholder' => 'State'
			),
			'shipping_postcode' => array(
				'placeholder' => 'ZIP code',
				'type' 		  => 'tel',
			),
		);
		return $shipping_fields;
	}




	/**
	 * Hide shipping rates when free shipping is available.
	 * Updated to support WooCommerce 2.6 Shipping Zones.
	 *
	 * @param array $rates Array of rates found for the package.
	 * @return array
	 */
 /*
function WPSS_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'WPSS_hide_shipping_when_free_is_available', 100 );


add_filter( 'http_request_host_is_external', '__return_true' );
*/
