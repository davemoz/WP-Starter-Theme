<?php
/**
 * Googles WooCommerce functions and definitions
 *
 * @package WPSS
 */

/**
 * Add WooCommerce support.
 */
function WPSS_add_woocommerce_support()
{
	add_theme_support('woocommerce', array(
		'thumbnail_image_width' => 400,
		'single_image_width'    => 1200,

		'product_grid'          => array(
			'default_rows'    => 4,
			'min_rows'        => 2,
			'max_rows'        => 8,
			'default_columns' => 1,
			'min_columns'     => 4,
			'max_columns'     => 4,
		),
	));
}
add_action('after_setup_theme', 'WPSS_add_woocommerce_support');


/* Add other WooCommerce features support. ie. Gallery, Lightbox, Slider */
add_action('after_setup_theme', 'WPSS_woocommerce_setup');

function WPSS_woocommerce_setup()
{
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}


/**
 * Remove WooCommerce stylesheets
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');



/**
 * Move Single Product Description tabs beneath Summary
 */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 35);

// Remove product category meta
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);



/**
 * Rename product data tabs
 */
add_filter('woocommerce_product_tabs', 'WPSS_rename_tabs', 98);
function WPSS_rename_tabs($tabs)
{

	// $tabs['description']['title'] = __( 'More Information' );		// Rename the description tab
	// $tabs['reviews']['title'] = __( 'Ratings' );						// Rename the reviews tab
	// $tabs['additional_information']['title'] = __( 'Details & Fit' );	// Rename the additional information tab
	unset($tabs['additional_information']); // Remove the additional information tab

	return $tabs;
}



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
 * Place a cart icon with number of items and total cost in the menu bar.
 *
 * Source: http://wordpress.org/plugins/woocommerce-menu-bar-cart/
 */
/*
add_filter('wp_nav_menu_items','WPSS_menucart', 10, 2);
function WPSS_menucart($menu, $args) {

	// Check if WooCommerce is active and add a new item to a menu assigned to the Shop Menu location
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || 'shop-menu' !== $args->theme_location )
		return $menu;

		ob_start();
		global $woocommerce;
		$viewing_cart = __('View your shopping cart', 'WPSS');
		$start_shopping = __('Start shopping', 'WPSS');
		$cart_url = $woocommerce->cart->get_cart_url();
		$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
		$cart_contents_count = $woocommerce->cart->cart_contents_count;
		//$cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'WPSS'), $cart_contents_count);
		$cart_total = $woocommerce->cart->get_cart_total();
		// Uncomment the line below to hide nav menu cart item when there are no items in the cart
		// if ( $cart_contents_count > 0 ) {
			if ($cart_contents_count == 0) {
				$menu_item = '<li class="cart-menu-link"><a class="wcmenucart-contents" href="'. $shop_page_url .'" title="'. $start_shopping .'">';
			} else {
				$menu_item = '<li class="cart-menu-link"><a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $viewing_cart .'">';
			}

			$menu_item .= '<i class="fa fa-shopping-cart"></i> ';

			if ($cart_contents_count == 0) {
			} else {
				$menu_item .= '<div class="cart-count-total">'.$cart_contents_count.'</div>';
				//$menu_item .= $cart_contents.' - '. $cart_total;
			}
			$menu_item .= '</a></li>';
		// Uncomment the line below to hide nav menu cart item when there are no items in the cart
		// }
		echo $menu_item;
	$social = ob_get_clean();
	return $menu . $social;

}
*/


/**
 * Customize Shop page structure
 */
// Add "shop" class to WooCommerce Shop page
add_filter('body_class', 'WPSS_shop_body_class');
function WPSS_shop_body_class($classes)
{

	if (is_shop()) {

		$classes[] = 'shop';
	}

	return $classes;
}

// Remove Shop page sections we don't want
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

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
 * Customize Single Product page sections
 */
add_action('woocommerce_before_shop_loop_item_title', 'WPSS_add_product_title_and_price_wrapper_open', 20);
function WPSS_add_product_title_and_price_wrapper_open()
{
	echo '<div class="product-title-and-price">';
}
add_action('woocommerce_after_shop_loop_item_title', 'WPSS_add_product_title_and_price_wrapper_close', 20);
function WPSS_add_product_title_and_price_wrapper_close()
{
	echo '</div>';
}

// Replace default product title H2 with H4
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
