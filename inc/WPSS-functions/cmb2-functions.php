<?php
/**
 * Remove main textarea on pages & posts
 *
 */
function remove_editors_on_custom_pages()
{
	if (isset($_GET['post'])) {
		$id = $_GET['post'];
		$template = get_post_meta($id, '_wp_page_template', true);

		if (($template == 'page-home.php') || ($template == 'page-adventure.php')) {
			remove_post_type_support('page', 'editor');
		}
	}
}
add_action('init', 'remove_editors_on_custom_pages');



/**
 * Get the bootstrap!
 * (Update path to use cmb2 or CMB2, depending on the name of the folder.
 * Case-sensitive is important on some systems.)
 */
require_once get_template_directory() . '/inc/cmb2/init.php';
require_once get_template_directory() . '/inc/cmb2-attached-posts/cmb2-attached-posts-field.php';


// Sanitization function to strip value of any HTML, etc.
function sanitize_strip_cb($value, $field_args, $field)
{
	/*
     * Do your custom sanitization. 
     * strip_tags can allow whitelisted tags
     * http://php.net/manual/en/function.strip-tags.php
     */
	$value = strip_tags($value, '<p><a><br><br/>');

	return $value;
}

// Sanitization function to keep original value (all HTML, etc)
function sanitize_keep_cb($original_value, $field_args, $field)
{
	return $original_value; // Unsanitized value.
}



/**
 * Enqueue custom admin dashboard styles
 */
function WPSS_admin_styles()
{
	wp_enqueue_style('admin-styles', get_template_directory_uri() . '/css/admin-css-min.css', array(), false, false);
}
add_action('admin_enqueue_scripts', 'WPSS_admin_styles');




/**************************************************************************
 *
 *  Meta Boxes
 *
 **************************************************************************/
/*****************************
 * Videos Post Type Metaboxes
 *****************************/
add_action('cmb2_admin_init', 'WPSS_videos_metaboxes');

function WPSS_videos_metaboxes()
{

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_WPSS_videos_';

	/**
	 * Initiate the Video URL metabox
	 */
	$cmb_WPSS_videos = new_cmb2_box(array(
		'id'           => $prefix . 'url_metabox',
		'title'         => __('Video', 'cmb2'),
		'object_types'  => array('video',), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		'closed'     => false, // Keep the metabox closed by default
	));

	// Video URL
	$cmb_WPSS_videos->add_field(array(
		'name' => esc_html__('Video URL', 'cmb2'),
		'desc' => esc_html__('Eg. https://vimeo.com/XXXXXXXX', 'cmb2'),
		'id'   => $prefix . 'url_oembed',
		'type' => 'oembed',
	));

	/**
	 * Initiate the Video featured text metabox
	 */
	$cmb_WPSS_videos_featured_text = new_cmb2_box(array(
		'id'           => $prefix . 'featured_text_metabox',
		'title'         => __('Featured Text', 'cmb2'),
		'object_types'  => array('video',), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		'closed'     => false, // Keep the metabox closed by default
	));

	$cmb_WPSS_videos_featured_text->add_field(array(
		'name' => 'Video - Featured Text Intro',
		'id'   => $prefix . 'featured_text_intro',
		'type' => 'text',
	));

	$cmb_WPSS_videos_featured_text->add_field(array(
		'name' => 'Video - Featured Text Title',
		'id'   => $prefix . 'featured_text_title',
		'type' => 'text',
	));

	$cmb_WPSS_videos_featured_text->add_field(array(
		'name' => 'Video - Featured Text Description',
		'id'   => $prefix . 'featured_text_description',
		'type' => 'text',
	));
}



/*****************************
 * Video Category Metaboxes
 *****************************/
add_action('cmb2_admin_init', 'WPSS_register_vid_cat_metabox');
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function WPSS_register_vid_cat_metabox()
{
	$prefix = '_google_video_category_image_';
	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_video_cat_image = new_cmb2_box(array(
		'id'               => $prefix . 'metabox',
		'title'            => esc_html__('Video Category Image Metabox', 'cmb2'), // Doesn't output for term boxes
		'object_types'     => array('term'), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array('video_category'), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	));
	$cmb_video_cat_image->add_field(array(
		'name'     => esc_html__('Image', 'cmb2'),
		'desc'     => esc_html__('Enter a URL or choose an image for this video category.', 'cmb2'),
		'id'       => $prefix . 'url',
		'type'     => 'file',
		'on_front' => false,
		'column'   => true,
	));
}



/*****************************
 * Quiz Post Type Metaboxes
 *****************************/
add_action('cmb2_admin_init', 'WPSS_quiz_metaboxes');

function WPSS_quiz_metaboxes()
{

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_WPSS_quiz_';

	/**
	 * Initiate the Quiz metabox
	 */
	$cmb_WPSS_quiz = new_cmb2_box(array(
		'id'           => $prefix . 'metabox',
		'title'         => __('Quiz', 'cmb2'),
		'object_types'  => array('quiz',), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'show_on'      => array(
		//	'id' => array( 34 ),// Specific post IDs to display this metabox
		// ),
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'closed'     => false, // Keep the metabox closed by default
	));

	$quiz_group_one = $cmb_WPSS_quiz->add_field(array(
		'id'          => 'quiz_group_one',
		'type'        => 'group',
		'description' => __('Quiz Entry #1', 'cmb2'),
		'repeatable'  => false, // use false if you want non-repeatable group
		'options'     => array(
			'group_title'       => __('Quiz Entry #1', 'cmb2'), // since version 1.1.4, {#} gets replaced by row number
			'add_button'        => __('Add Another Entry', 'cmb2'),
			'remove_button'     => __('Remove Entry', 'cmb2'),
			'sortable'          => true, // beta
			// 'closed'         => true, // true to have the groups closed by default
			// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
		),
	));

	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb_WPSS_quiz->add_group_field($quiz_group_one, array(
		'name' => 'Quiz Entry #1 Title',
		'id'   => 'title',
		'type' => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	));

	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb_WPSS_quiz->add_group_field($quiz_group_one, array(
		'name' => 'Quiz Entry #1 Subtitle',
		'id'   => 'subtitle',
		'type' => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	));

	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb_WPSS_quiz->add_group_field($quiz_group_one, array(
		'name' => 'Quiz Entry #1 Additional Info',
		'description' => __('This text is only shown when the quiz answer is revealed.', 'cmb2'),
		'id'   => 'info',
		'type' => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	));

	$cmb_WPSS_quiz->add_group_field($quiz_group_one, array(
		'name' => 'Quiz Entry #1 Image',
		'id'   => 'image',
		'type' => 'file',
	));

	$cmb_WPSS_quiz->add_group_field($quiz_group_one, array(
		'name' => __("Quiz Entry #1 - Is Correct?", 'cmb2'),
		'description' => __("Check the box if this entry is the correct answer to this quiz. Only check one entry!", 'cmb2'),
		'id'   => 'isCorrect',
		'type' => 'checkbox',
	));

	$quiz_group_two = $cmb_WPSS_quiz->add_field(array(
		'id'          => 'quiz_group_two',
		'type'        => 'group',
		'description' => __('Quiz Entry #2', 'cmb2'),
		'repeatable'  => false, // use false if you want non-repeatable group
		'options'     => array(
			'group_title'       => __('Quiz Entry #2', 'cmb2'), // since version 1.1.4, {#} gets replaced by row number
			'add_button'        => __('Add Another Entry', 'cmb2'),
			'remove_button'     => __('Remove Entry', 'cmb2'),
			'sortable'          => true, // beta
			// 'closed'         => true, // true to have the groups closed by default
			// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
		),
	));

	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb_WPSS_quiz->add_group_field($quiz_group_two, array(
		'name' => 'Quiz Entry #2 Title',
		'id'   => 'title',
		'type' => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	));

	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb_WPSS_quiz->add_group_field($quiz_group_two, array(
		'name' => 'Quiz Entry #2 Subtitle',
		'id'   => 'subtitle',
		'type' => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	));

	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb_WPSS_quiz->add_group_field($quiz_group_two, array(
		'name' => 'Quiz Entry #2 Additional Info',
		'description' => __('This text is only shown when the quiz answer is revealed.', 'cmb2'),
		'id'   => 'info',
		'type' => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	));

	$cmb_WPSS_quiz->add_group_field($quiz_group_two, array(
		'name' => 'Quiz Entry #2 Image',
		'id'   => 'image',
		'type' => 'file',
	));

	$cmb_WPSS_quiz->add_group_field($quiz_group_two, array(
		'name' => __("Quiz Entry #2 - Is Correct?", 'cmb2'),
		'description' => __("Check the box if this entry is the correct answer to this quiz. Only check one entry!", 'cmb2'),
		'id'   => 'isCorrect',
		'type' => 'checkbox',
	));
}


/***************************
 * Homepage Metaboxes
 ***************************/
add_action('cmb2_admin_init', 'WPSS_homepage_metaboxes');

function WPSS_homepage_metaboxes()
{

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_WPSS_homepage_';

	/***********************
	 * Featured Video Box
	 ***********************/
	/**
	 * Initiate the Featured Video(s) metabox
	 */
	$cmb_homepage_featured_vids = new_cmb2_box(array(
		'id'           => $prefix . 'featured_vids_metabox',
		'title'         => __('Featured Videos', 'cmb2'),
		'object_types'  => array('page',), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'), // Specific post IDs to display this metabox
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'closed'     => false, // Keep the metabox closed by default
	));

	// Featured Video(s) posts
	$cmb_homepage_featured_vids->add_field(array(
		'name' => esc_html__('Featured Videos', 'cmb2'),
		'desc' => esc_html__('Drag video posts from the left column to the right column to set it as the featured video. The first video in the list will be the large featured video on the homepage.', 'cmb2'),
		'id'   => $prefix . 'featured_videos',
		'type' => 'custom_attached_posts',
		// 'column'	 => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options'	 => array(
			'show_thumbnails' => true, // Show thumbnails on the left
			// 'filter_boxes'	  => true, // Show a text box for filtering the results
			'query_args'	  => array(
				'posts_per_page' => -1,
				'post_type'		 => 'video',
			), // override the get_posts args
		),
	));

	$cmb_homepage_featured_vids->add_field(array(
		'name' => esc_html__('Large Featured Video Badge', 'cmb2'),
		'desc' => esc_html__('Upload an image or enter a URL.', 'cmb2'),
		'id'   => $prefix . 'featured_video_badge',
		'type' => 'file',
	));

	/***********************
	 * Video Slider Box
	 ***********************/
	/**
	 * Initiate the Video Slider metabox
	 */
	$cmb_homepage_video_slider = new_cmb2_box(array(
		'id'           => $prefix . 'vid_slider_metabox',
		'title'         => __('Video Slider', 'cmb2'),
		'object_types'  => array('page',), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'), // Specific post IDs to display this metabox
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'closed'     => false, // Keep the metabox closed by default
	));

	$cmb_homepage_video_slider->add_field(array(
		'name'       => __('Video Slider Posts', 'cmb2'),
		'desc'       => __('Drag video posts from the left column to the right column to add them to the video slider.', 'cmb2'),
		'id'         => $prefix . 'video_slider_posts',
		'type'       => 'custom_attached_posts',
		// 'column'	 => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options'	 => array(
			'show_thumbnails' => true, // Show thumbnails on the left
			// 'filter_boxes'	  => true, // Show a text box for filtering the results
			'query_args'	  => array(
				'posts_per_page' => -1,
				'post_type'		 => 'video',
			), // override the get_posts args
		),
	));

	/***********************
	 * Quiz Box
	 ***********************/
	/**
	 * Initiate the Quiz metabox
	 */
	$cmb_homepage_quiz = new_cmb2_box(array(
		'id'           => $prefix . 'quiz_metabox',
		'title'         => __('Quiz', 'cmb2'),
		'object_types'  => array('page',), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'), // Specific post IDs to display this metabox
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'closed'     => false, // Keep the metabox closed by default
	));

	// Quiz Badge
	$cmb_homepage_quiz->add_field(array(
		'name' => esc_html__('Quiz Badge image', 'cmb2'),
		'desc' => esc_html__('Upload an image or enter a URL.', 'cmb2'),
		'id'   => $prefix . 'quiz_badge_image',
		'type' => 'file',
	));

	$cmb_homepage_quiz->add_field(array(
		'name'       => __('Quiz Post', 'cmb2'),
		'desc'       => __('Drag a quiz post from the left column to the right column to add it to the homepage quiz box.', 'cmb2'),
		'id'         => $prefix . 'quiz_post',
		'type'       => 'custom_attached_posts',
		// 'column'	 => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options'	 => array(
			'show_thumbnails' => false, // Show thumbnails on the left
			// 'filter_boxes'	  => true, // Show a text box for filtering the results
			'query_args'	  => array(
				'posts_per_page' => -1,
				'post_type'		 => 'quiz',
			), // override the get_posts args
		),
	));

	/***********************
	 * Badges Box
	 ***********************/
	/**
	 * Initiate the Badges metabox
	 */
	$cmb_homepage_badges = new_cmb2_box(array(
		'id'           => $prefix . 'badges_metabox',
		'title'         => __('Badges', 'cmb2'),
		'object_types'  => array('page',), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		'show_on'      => array('key' => 'page-template', 'value' => 'page-home.php'), // Specific post IDs to display this metabox
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'closed'     => false, // Keep the metabox closed by default
	));

	$badges_group = $cmb_homepage_badges->add_field(array(
		'id'          => 'badges_group',
		'type'        => 'group',
		'description' => __('Badges Box', 'cmb2'),
		'repeatable'  => true, // use false if you want non-repeatable group
		'options'     => array(
			'group_title'       => __('Badge {#}', 'cmb2'), // since version 1.1.4, {#} gets replaced by row number
			'add_button'        => __('Add Another Badge', 'cmb2'),
			'remove_button'     => __('Remove Badge', 'cmb2'),
			'sortable'          => true, // beta
			// 'closed'         => true, // true to have the groups closed by default
			// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
		),
	));

	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb_homepage_badges->add_group_field($badges_group, array(
		'name' => 'Badge Image',
		'id'   => 'image',
		'type' => 'file',
	));

	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb_homepage_badges->add_group_field($badges_group, array(
		'name' => 'Badge ID (Optional)',
		'desc' => 'Email newsletter badge should have id: newsletter-button',
		'id'   => 'id',
		'type' => 'text',
	));

	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb_homepage_badges->add_group_field($badges_group, array(
		'name' => 'Badge Link URL',
		'id'   => 'link_url',
		'type' => 'text_url',
	));
}

/***************************
 * Adventure Page Metaboxes
 ***************************/
add_action('cmb2_admin_init', 'WPSS_adventure_metaboxes');

function WPSS_adventure_metaboxes()
{

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_WPSS_adventure_';

	/**
	 * Initiate the Adventure Featured metabox
	 */
	$cmb_adventure_featured_vid = new_cmb2_box(array(
		'id'           => $prefix . 'featured_video_metabox',
		'title'         => __('Adventure Page Featured Video', 'cmb2'),
		'object_types'  => array('page',), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		'show_on'      => array('key' => 'page-template', 'value' => 'page-adventure.php'), // Specific post IDs to display this metabox
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => false, // Keep the metabox closed by default
	));

	// Featured Video(s) posts
	$cmb_adventure_featured_vid->add_field(array(
		'name' => esc_html__('Featured Video', 'cmb2'),
		'desc' => esc_html__('Drag a video post from the left column to the right column to set it as the featured video. Only the first video in the list will be the large featured video.', 'cmb2'),
		'id'   => $prefix . 'featured_video',
		'type' => 'custom_attached_posts',
		// 'column'	 => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
		'options'	 => array(
			'show_thumbnails' => true, // Show thumbnails on the left
			// 'filter_boxes'	  => true, // Show a text box for filtering the results
			'query_args'	  => array(
				'posts_per_page' => -1,
				'post_type'		 => 'video',
			), // override the get_posts args
		),
	));

	/**
	 * Initiate the Adventure Featured Text Fallback metabox
	 */
	$cmb_adventure_featured_text_fallback = new_cmb2_box(array(
		'id'           => $prefix . 'featured_text_fallback_metabox',
		'title'         => __('Adventure Page Featured Text Fallback', 'cmb2'),
		'object_types'  => array('page',), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		'show_on'      => array('key' => 'page-template', 'value' => 'page-adventure.php'), // Specific post IDs to display this metabox
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => false, // Keep the metabox closed by default
	));

	// Featured Text Intro Fallback
	$cmb_adventure_featured_text_fallback->add_field(array(
		'name' => 'Featured Text Intro - Fallback',
		'id'   => $prefix . 'featured_text_fallback_intro',
		'type' => 'text',
	));

	// Featured Text Title Fallback
	$cmb_adventure_featured_text_fallback->add_field(array(
		'name' => 'Featured Text Title - Fallback',
		'id'   => $prefix . 'featured_text_fallback_title',
		'type' => 'text',
	));

	// Featured Text Description Fallback
	$cmb_adventure_featured_text_fallback->add_field(array(
		'name' => 'Featured Text Description - Fallback',
		'id'   => $prefix . 'featured_text_fallback_description',
		'type' => 'text',
	));
}
