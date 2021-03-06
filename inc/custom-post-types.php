<?php
/**************************************************************************
 *
 *  Register Video Post Type
 * 
 **************************************************************************/
function WPSS_videos_post_type()
{
	$labels = array(
		'name'                  => _x('Videos', 'Post Type General Name', 'WPSS'),
		'singular_name'         => _x('Video', 'Post Type Singular Name', 'WPSS'),
		'menu_name'             => __('Videos', 'WPSS'),
		'name_admin_bar'        => __('Video', 'WPSS'),
		'archives'              => __('Video Archives', 'WPSS'),
		'attributes'            => __('Video Attributes', 'WPSS'),
		'parent_item_colon'     => __('Parent Video:', 'WPSS'),
		'all_items'             => __('All Videos', 'WPSS'),
		'add_new_item'          => __('Add New Video', 'WPSS'),
		'add_new'               => __('Add New', 'WPSS'),
		'new_item'              => __('New Video', 'WPSS'),
		'edit_item'             => __('Edit Video', 'WPSS'),
		'update_item'           => __('Update Video', 'WPSS'),
		'view_item'             => __('View Video', 'WPSS'),
		'view_items'            => __('View Videos', 'WPSS'),
		'search_items'          => __('Search Video', 'WPSS'),
		'not_found'             => __('Not found', 'WPSS'),
		'not_found_in_trash'    => __('Not found in Trash', 'WPSS'),
		'featured_image'        => __('Featured Image', 'WPSS'),
		'set_featured_image'    => __('Set featured image', 'WPSS'),
		'remove_featured_image' => __('Remove featured image', 'WPSS'),
		'use_featured_image'    => __('Use as featured image', 'WPSS'),
		'insert_into_item'      => __('Insert into video', 'WPSS'),
		'uploaded_to_this_item' => __('Uploaded to this video', 'WPSS'),
		'items_list'            => __('Videos list', 'WPSS'),
		'items_list_navigation' => __('Videos list navigation', 'WPSS'),
		'filter_items_list'     => __('Filter videos list', 'WPSS'),
	);
	$args = array(
		'label'                 => __('Video', 'WPSS'),
		'description'           => __('The custom Googles video post type.', 'WPSS'),
		'labels'                => $labels,
		'supports'              => array('title', 'revisions', 'thumbnail'),
		'taxonomies'            => array('video_category', 'video_tag'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-format-video',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type('video', $args);
}
add_action('init', 'WPSS_videos_post_type', 0);

/**************************************************************************
 *
 *  Register Video Category Taxonomy
 * 
 **************************************************************************/
function video_category_tax()
{
	$labels = array(
		'name'                       => _x('Categories', 'Taxonomy General Name', 'WPSS'),
		'singular_name'              => _x('Category', 'Taxonomy Singular Name', 'WPSS'),
		'menu_name'                  => __('Categories', 'WPSS'),
		'all_items'                  => __('All Categories', 'WPSS'),
		'parent_item'                => __('Parent Category', 'WPSS'),
		'parent_item_colon'          => __('Parent Category:', 'WPSS'),
		'new_item_name'              => __('New Category Name', 'WPSS'),
		'add_new_item'               => __('Add New Category', 'WPSS'),
		'edit_item'                  => __('Edit Category', 'WPSS'),
		'update_item'                => __('Update Category', 'WPSS'),
		'view_item'                  => __('View Category', 'WPSS'),
		'separate_items_with_commas' => __('Separate categories with commas', 'WPSS'),
		'add_or_remove_items'        => __('Add or remove categories', 'WPSS'),
		'choose_from_most_used'      => __('Choose from the most used', 'WPSS'),
		'popular_items'              => __('Popular Categories', 'WPSS'),
		'search_items'               => __('Search Categories', 'WPSS'),
		'not_found'                  => __('Not Found', 'WPSS'),
		'no_terms'                   => __('No categories', 'WPSS'),
		'items_list'                 => __('Categories list', 'WPSS'),
		'items_list_navigation'      => __('Categories list navigation', 'WPSS'),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy('video_category', array('video'), $args);
}
add_action('init', 'video_category_tax', 0);

/**************************************************************************
 *
 *  Register Quiz Post Type
 * 
 **************************************************************************/
function WPSS_quiz_post_type()
{
	$labels = array(
		'name'                  => _x('Quizzes', 'Post Type General Name', 'WPSS'),
		'singular_name'         => _x('Quiz', 'Post Type Singular Name', 'WPSS'),
		'menu_name'             => __('Quizzes', 'WPSS'),
		'name_admin_bar'        => __('Quiz', 'WPSS'),
		'archives'              => __('Quiz Archives', 'WPSS'),
		'attributes'            => __('Quiz Attributes', 'WPSS'),
		'parent_item_colon'     => __('Parent Quiz:', 'WPSS'),
		'all_items'             => __('All Quizzes', 'WPSS'),
		'add_new_item'          => __('Add New Quiz', 'WPSS'),
		'add_new'               => __('Add New', 'WPSS'),
		'new_item'              => __('New Quiz', 'WPSS'),
		'edit_item'             => __('Edit Quiz', 'WPSS'),
		'update_item'           => __('Update Quiz', 'WPSS'),
		'view_item'             => __('View Quiz', 'WPSS'),
		'view_items'            => __('View Quizzes', 'WPSS'),
		'search_items'          => __('Search Quiz', 'WPSS'),
		'not_found'             => __('Not found', 'WPSS'),
		'not_found_in_trash'    => __('Not found in Trash', 'WPSS'),
		'featured_image'        => __('Featured Image', 'WPSS'),
		'set_featured_image'    => __('Set featured image', 'WPSS'),
		'remove_featured_image' => __('Remove featured image', 'WPSS'),
		'use_featured_image'    => __('Use as featured image', 'WPSS'),
		'insert_into_item'      => __('Insert into video', 'WPSS'),
		'uploaded_to_this_item' => __('Uploaded to this video', 'WPSS'),
		'items_list'            => __('Quizzes list', 'WPSS'),
		'items_list_navigation' => __('Quizzes list navigation', 'WPSS'),
		'filter_items_list'     => __('Filter videos list', 'WPSS'),
	);
	$args = array(
		'label'                 => __('Quiz', 'WPSS'),
		'description'           => __('The custom Googles quiz post type.', 'WPSS'),
		'labels'                => $labels,
		'supports'              => array('title', 'revisions',),
		'taxonomies'            => array('quiz_category', 'quiz_tag'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-chart-bar',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type('quiz', $args);
}
add_action('init', 'WPSS_quiz_post_type', 0);

/**************************************************************************
 *
 *  Register Quiz Category Taxonomy
 * 
 **************************************************************************/
function quiz_category_tax()
{

	$labels = array(
		'name'                       => _x('Categories', 'Taxonomy General Name', 'WPSS'),
		'singular_name'              => _x('Category', 'Taxonomy Singular Name', 'WPSS'),
		'menu_name'                  => __('Categories', 'WPSS'),
		'all_items'                  => __('All Categories', 'WPSS'),
		'parent_item'                => __('Parent Category', 'WPSS'),
		'parent_item_colon'          => __('Parent Category:', 'WPSS'),
		'new_item_name'              => __('New Category Name', 'WPSS'),
		'add_new_item'               => __('Add New Category', 'WPSS'),
		'edit_item'                  => __('Edit Category', 'WPSS'),
		'update_item'                => __('Update Category', 'WPSS'),
		'view_item'                  => __('View Category', 'WPSS'),
		'separate_items_with_commas' => __('Separate categories with commas', 'WPSS'),
		'add_or_remove_items'        => __('Add or remove categories', 'WPSS'),
		'choose_from_most_used'      => __('Choose from the most used', 'WPSS'),
		'popular_items'              => __('Popular Categories', 'WPSS'),
		'search_items'               => __('Search Categories', 'WPSS'),
		'not_found'                  => __('Not Found', 'WPSS'),
		'no_terms'                   => __('No categories', 'WPSS'),
		'items_list'                 => __('Categories list', 'WPSS'),
		'items_list_navigation'      => __('Categories list navigation', 'WPSS'),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy('quiz_category', array('quiz'), $args);
}
add_action('init', 'quiz_category_tax', 0);
