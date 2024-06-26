<?php
global $medicenter_posts_array;
$medicenter_posts_array = array();
$count_posts = wp_count_posts();
if($count_posts->publish<100)
{
	$medicenter_posts_list = get_posts(array(
		'posts_per_page' => -1,
		'nopaging' => true,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => 'post'
	));
	$medicenter_posts_array[__("All", 'medicenter')] = "-";
	foreach($medicenter_posts_list as $post)
		$medicenter_posts_array[$post->post_title . " (id:" . $post->ID . ")"] = $post->ID;
}

global $medicenter_pages_array;
$medicenter_pages_array = array();
$count_pages = wp_count_posts('page');
if($count_pages->publish<100)
{
	$pages_list = get_posts(array(
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => 'page'
	));
	$medicenter_pages_array = array();
	$medicenter_pages_array[__("none", 'medicenter')] = "-";
	foreach($pages_list as $single_page)
		$medicenter_pages_array[$single_page->post_title . " (id:" . $single_page->ID . ")"] = $single_page->ID;
}

//slider
mc_get_theme_file("/shortcodes/slider.php");
//home box
mc_get_theme_file("/shortcodes/home_box.php");
//blog
mc_get_theme_file("/shortcodes/blog.php");
//post
mc_get_theme_file("/shortcodes/single-post.php");
//single doctors
mc_get_theme_file("/shortcodes/single-doctor.php");
mc_get_theme_file("/shortcodes/doctor_box.php");
mc_get_theme_file("/shortcodes/doctor_description_box.php");
//items_list
mc_get_theme_file("/shortcodes/items_list.php");
//columns
mc_get_theme_file("/shortcodes/columns.php");
//timetable
mc_get_theme_file("/shortcodes/timetable.php");
//map
mc_get_theme_file("/shortcodes/map.php");
if(is_plugin_active('ql_services/ql_services.php'))
{
	//service single
	mc_get_theme_file("/shortcodes/single-service.php");
	mc_get_theme_file("/shortcodes/service_box.php");
}
//accordion
//require_once("accordion.php");
//nested tabs
//require_once("nested_tabs.php");
//carousel
mc_get_theme_file("/shortcodes/carousel.php");
//small slider
mc_get_theme_file("/shortcodes/small_slider.php");
//photostream
mc_get_theme_file("/shortcodes/photostream.php");
//announcement box
mc_get_theme_file("/shortcodes/announcement_box.php");
//testimonials
mc_get_theme_file("/shortcodes/testimonials.php");
//notification box
mc_get_theme_file("/shortcodes/notification_box.php");
//icon
mc_get_theme_file("/shortcodes/icon.php");
//cart icon
mc_get_theme_file("/shortcodes/cart_icon.php");
//pricing table
mc_get_theme_file("/shortcodes/pricing_table.php");
//timeline item
mc_get_theme_file("/shortcodes/timeline_item.php");
//counter box
mc_get_theme_file("/shortcodes/counter_box.php");
//our clients box
mc_get_theme_file("/shortcodes/our_clients.php");
//info box
mc_get_theme_file("/shortcodes/info_box.php");

//row inner
$attributes = array(
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Type", 'medicenter'),
		"param_name" => "type",
		"value" => array(__("Default", 'medicenter') => "",  __("Full width", 'medicenter') => "full-width", __("Paralax background", 'medicenter') => "full-width mc-parallax", __("Paralax background with overlay", 'medicenter') => "full-width mc-parallax mc-overlay"),
		"description" => __("Select row type", "medicenter")
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Top margin", 'medicenter'),
		"param_name" => "top_margin",
		"value" => array(__("None", 'medicenter') => "none",  __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section", __("Section (very large)", 'medicenter') => "page-margin-top-section-vlarge"),
		"description" => __("Select top margin value for your row", "medicenter")
	)
);
vc_add_params('vc_row_inner', $attributes);


$attributes = array(
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("MediCenter navigation", 'medicenter'),
		"param_name" => "mc_navigation",
		"value" => array(__("Enable", 'medicenter') => "1",  __("Disable", 'medicenter') => "0")
	)
);
vc_add_params('rev_slider_vc', $attributes);

//additional attributes
$attributes = array(
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Type", 'medicenter'),
		"param_name" => "type",
		"value" => array(__("Default", 'medicenter') => "default",  __("Big", 'medicenter') => "type-big")
	)
);
vc_add_params('vc_tabs', $attributes);
vc_add_params('vc_nested_tabs', $attributes);
$attributes = array(
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Top margin", 'medicenter'),
		"param_name" => "top_margin",
		"value" => array(__("None", 'medicenter') => "none",  __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section")
	)
);
vc_add_params('vc_accordion', $attributes);
vc_add_params('vc_nested_accordion', $attributes);
vc_add_params('vc_tabs', $attributes);
vc_add_params('vc_nested_tabs', $attributes);

//row
vc_map( array(
	'name' => __( 'Row', 'medicenter' ),
	'base' => 'vc_row',
	'is_container' => true,
	'icon' => 'icon-wpb-row',
	'show_settings_on_create' => false,
	'category' => __( 'Content', 'medicenter' ),
	'class' => 'vc_main-sortable-element',
	'description' => __( 'Place content elements inside the row', 'medicenter' ),
	'params' => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'medicenter'),
			"param_name" => "type",
			"value" => array(__("Default", 'medicenter') => "", __("Full width", 'medicenter') => "full-width", __("Paralax background", 'medicenter') => "full-width mc-parallax", __("Paralax background with overlay", 'medicenter') => "full-width mc-parallax mc-overlay"),
			"description" => __("Select row type", "medicenter")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'medicenter'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'medicenter') => "none",  __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section", __("Section (very large)", 'medicenter') => "page-margin-top-section-vlarge"),
			"description" => __("Select top margin value for your row", "medicenter")
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Row stretch', 'medicenter' ),
			'param_name' => 'full_width',
			'value' => array(
				__( 'Default', 'medicenter' ) => '',
				__( 'Stretch row', 'medicenter' ) => 'stretch_row',
				__( 'Stretch row and content', 'medicenter' ) => 'stretch_row_content',
				__( 'Stretch row and content (no paddings)', 'medicenter' ) => 'stretch_row_content_no_spaces',
			),
			'description' => __( 'Select stretching options for row and content (Note: stretched may not work properly if parent container has "overflow: hidden" CSS property).', 'medicenter' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Columns gap', 'medicenter' ),
			'param_name' => 'gap',
			'value' => array(
				'0px' => '0',
				'1px' => '1',
				'2px' => '2',
				'3px' => '3',
				'4px' => '4',
				'5px' => '5',
				'10px' => '10',
				'15px' => '15',
				'20px' => '20',
				'25px' => '25',
				'30px' => '30',
				'35px' => '35',
			),
			'std' => '0',
			'description' => __( 'Select gap between columns in row.', 'medicenter' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Full height row?', 'medicenter' ),
			'param_name' => 'full_height',
			'description' => __( 'If checked row will be set to full height.', 'medicenter' ),
			'value' => array( __( 'Yes', 'medicenter' ) => 'yes' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Columns position', 'medicenter' ),
			'param_name' => 'columns_placement',
			'value' => array(
				__( 'Middle', 'medicenter' ) => 'middle',
				__( 'Top', 'medicenter' ) => 'top',
				__( 'Bottom', 'medicenter' ) => 'bottom',
				__( 'Stretch', 'medicenter' ) => 'stretch',
			),
			'description' => __( 'Select columns position within row.', 'medicenter' ),
			'dependency' => array(
				'element' => 'full_height',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Equal height', 'medicenter' ),
			'param_name' => 'equal_height',
			'description' => __( 'If checked columns will be set to equal height.', 'medicenter' ),
			'value' => array( __( 'Yes', 'medicenter' ) => 'yes' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Content position', 'medicenter' ),
			'param_name' => 'content_placement',
			'value' => array(
				__( 'Default', 'medicenter' ) => '',
				__( 'Top', 'medicenter' ) => 'top',
				__( 'Middle', 'medicenter' ) => 'middle',
				__( 'Bottom', 'medicenter' ) => 'bottom',
			),
			'description' => __( 'Select content position within columns.', 'medicenter' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Use video background?', 'medicenter' ),
			'param_name' => 'video_bg',
			'description' => __( 'If checked, video will be used as row background.', 'medicenter' ),
			'value' => array( __( 'Yes', 'medicenter' ) => 'yes' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'YouTube link', 'medicenter' ),
			'param_name' => 'video_bg_url',
			'value' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
			// default video url
			'description' => __( 'Add YouTube link.', 'medicenter' ),
			'dependency' => array(
				'element' => 'video_bg',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Parallax', 'medicenter' ),
			'param_name' => 'video_bg_parallax',
			'value' => array(
				__( 'None', 'medicenter' ) => '',
				__( 'Simple', 'medicenter' ) => 'content-moving',
				__( 'With fade', 'medicenter' ) => 'content-moving-fade',
			),
			'description' => __( 'Add parallax type background for row.', 'medicenter' ),
			'dependency' => array(
				'element' => 'video_bg',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Parallax', 'medicenter' ),
			'param_name' => 'parallax',
			'value' => array(
				__( 'None', 'medicenter' ) => '',
				__( 'Simple', 'medicenter' ) => 'content-moving',
				__( 'With fade', 'medicenter' ) => 'content-moving-fade',
			),
			'description' => __( 'Add parallax type background for row (Note: If no image is specified, parallax will use background image from Design Options).', 'medicenter' ),
			'dependency' => array(
				'element' => 'video_bg',
				'is_empty' => true,
			),
		),
		array(
			'type' => 'attach_image',
			'heading' => __( 'Image', 'medicenter' ),
			'param_name' => 'parallax_image',
			'value' => '',
			'description' => __( 'Select image from media library.', 'medicenter' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Parallax speed', 'medicenter' ),
			'param_name' => 'parallax_speed_video',
			'value' => '1.5',
			'description' => __( 'Enter parallax speed ratio (Note: Default value is 1.5, min value is 1)', 'medicenter' ),
			'dependency' => array(
				'element' => 'video_bg_parallax',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Parallax speed', 'medicenter' ),
			'param_name' => 'parallax_speed_bg',
			'value' => '1.5',
			'description' => __( 'Enter parallax speed ratio (Note: Default value is 1.5, min value is 1)', 'medicenter' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
		),
		vc_map_add_css_animation( false ),
		array(
			'type' => 'el_id',
			'heading' => __( 'Row ID', 'medicenter' ),
			'param_name' => 'el_id',
			'description' => sprintf( __( 'Enter row ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'medicenter' ), 'https://www.w3schools.com/tags/att_global_id.asp' ),
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Disable row', 'medicenter' ),
			'param_name' => 'disable_element',
			// Inner param name.
			'description' => __( 'If checked the row won\'t be visible on the public side of your website. You can switch it back any time.', 'medicenter' ),
			'value' => array( __( 'Yes', 'medicenter' ) => 'yes' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'medicenter' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'medicenter' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'medicenter' ),
			'param_name' => 'css',
			'group' => __( 'Design Options', 'medicenter' ),
		)
	),
	'js_view' => 'VcRowView'
) );

//column
$vc_column_width_list = array(
	__('1 column - 1/12', 'medicenter') => '1/12',
	__('2 columns - 1/6', 'medicenter') => '1/6',
	__('3 columns - 1/4', 'medicenter') => '1/4',
	__('4 columns - 1/3', 'medicenter') => '1/3',
	__('5 columns - 5/12', 'medicenter') => '5/12',
	__('6 columns - 1/2', 'medicenter') => '1/2',
	__('7 columns - 7/12', 'medicenter') => '7/12',
	__('8 columns - 2/3', 'medicenter') => '2/3',
	__('9 columns - 3/4', 'medicenter') => '3/4',
	__('10 columns - 5/6', 'medicenter') => '5/6',
	__('11 columns - 11/12', 'medicenter') => '11/12',
	__('12 columns - 1/1', 'medicenter') => '1/1'
);
vc_map( array(
	'name' => __( 'Column', 'medicenter' ),
	'base' => 'vc_column',
	'icon' => 'icon-wpb-row',
	'is_container' => true,
	'content_element' => false,
	'description' => __( 'Place content elements inside the column', 'medicenter' ),
	'params' => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Column type", 'medicenter'),
			"param_name" => "type",
			"value" => array(__("Default", 'medicenter') => "",  __("Smart (sticky)", 'medicenter') => "mc-smart-column"),
			"dependency" => Array('element' => "width", 'value' => array_map('strval', array_values((array_slice($vc_column_width_list, 0, -1)))))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'medicenter'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'medicenter') => "none",  __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section"),
			"description" => __("Select top margin value for your column", "medicenter")
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Use video background?', 'medicenter' ),
			'param_name' => 'video_bg',
			'description' => __( 'If checked, video will be used as row background.', 'medicenter' ),
			'value' => array( __( 'Yes', 'medicenter' ) => 'yes' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'YouTube link', 'medicenter' ),
			'param_name' => 'video_bg_url',
			'value' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
			// default video url
			'description' => __( 'Add YouTube link.', 'medicenter' ),
			'dependency' => array(
				'element' => 'video_bg',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Parallax', 'medicenter' ),
			'param_name' => 'video_bg_parallax',
			'value' => array(
				__( 'None', 'medicenter' ) => '',
				__( 'Simple', 'medicenter' ) => 'content-moving',
				__( 'With fade', 'medicenter' ) => 'content-moving-fade',
			),
			'description' => __( 'Add parallax type background for row.', 'medicenter' ),
			'dependency' => array(
				'element' => 'video_bg',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Parallax', 'medicenter' ),
			'param_name' => 'parallax',
			'value' => array(
				__( 'None', 'medicenter' ) => '',
				__( 'Simple', 'medicenter' ) => 'content-moving',
				__( 'With fade', 'medicenter' ) => 'content-moving-fade',
			),
			'description' => __( 'Add parallax type background for row (Note: If no image is specified, parallax will use background image from Design Options).', 'medicenter' ),
			'dependency' => array(
				'element' => 'video_bg',
				'is_empty' => true,
			),
		),
		array(
			'type' => 'attach_image',
			'heading' => __( 'Image', 'medicenter' ),
			'param_name' => 'parallax_image',
			'value' => '',
			'description' => __( 'Select image from media library.', 'medicenter' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Parallax speed', 'medicenter' ),
			'param_name' => 'parallax_speed_video',
			'value' => '1.5',
			'description' => __( 'Enter parallax speed ratio (Note: Default value is 1.5, min value is 1)', 'medicenter' ),
			'dependency' => array(
				'element' => 'video_bg_parallax',
				'not_empty' => true,
			),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Parallax speed', 'medicenter' ),
			'param_name' => 'parallax_speed_bg',
			'value' => '1.5',
			'description' => __( 'Enter parallax speed ratio (Note: Default value is 1.5, min value is 1)', 'medicenter' ),
			'dependency' => array(
				'element' => 'parallax',
				'not_empty' => true,
			),
		),
		vc_map_add_css_animation( false ),
		array(
			'type' => 'el_id',
			'heading' => __( 'Element ID', 'medicenter' ),
			'param_name' => 'el_id',
			'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'medicenter' ), 'https://www.w3schools.com/tags/att_global_id.asp' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'medicenter' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'medicenter' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'medicenter' ),
			'param_name' => 'css',
			'group' => __( 'Design Options', 'medicenter' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Width', 'medicenter' ),
			'param_name' => 'width',
			'value' => $vc_column_width_list,
			'group' => __( 'Responsive Options', 'medicenter' ),
			'description' => __( 'Select column width.', 'medicenter' ),
			'std' => '1/1',
		),
		array(
			'type' => 'column_offset',
			'heading' => __( 'Responsiveness', 'medicenter' ),
			'param_name' => 'offset',
			'group' => __( 'Responsive Options', 'medicenter' ),
			'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'medicenter' ),
		)
	),
	'js_view' => 'VcColumnView'
) );

//widgetised sidebar
vc_map( array(
	'name' => __( 'Widgetised Sidebar', 'medicenter' ),
	'base' => 'vc_widget_sidebar',
	'class' => 'wpb_widget_sidebar_widget',
	'icon' => 'icon-wpb-layout_sidebar',
	'category' => __( 'Structure', 'medicenter' ),
	'description' => __( 'WordPress widgetised sidebar', 'medicenter' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'medicenter' ),
			'param_name' => 'title',
			'description' => __( 'Enter text used as widget title (Note: located above content element).', 'medicenter' )
		),
		array(
			'type' => 'widgetised_sidebars',
			'heading' => __( 'Sidebar', 'medicenter' ),
			'param_name' => 'sidebar_id',
			'description' => __( 'Select widget area to display.', 'medicenter' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'medicenter' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'medicenter' )
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'medicenter'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'medicenter') => "none",  __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section"),
			"description" => __("Select top margin value for your sidebar", "medicenter")
		)
	)
) );

$mc_colors_arr = array(__("Dark blue", "medicenter") => "#3156a3", __("Blue", "medicenter") => "#0384ce", __("Light blue", "medicenter") => "#42b3e5", __("Black", "medicenter") => "#000000", __("Gray", "medicenter") => "#AAAAAA", __("Dark gray", "medicenter") => "#444444", __("Light gray", "medicenter") => "#CCCCCC", __("Green", "medicenter") => "#43a140", __("Dark green", "medicenter") => "#008238", __("Light green", "medicenter") => "#7cba3d", __("Orange", "medicenter") => "#f17800", __("Dark orange", "medicenter") => "#cb451b", __("Light orange", "medicenter") => "#ffa800", __("Red", "medicenter") => "#db5237", __("Dark red", "medicenter") => "#c03427", __("Light red", "medicenter") => "#f37548", __("Turquoise", "medicenter") => "#0097b5", __("Dark turquoise", "medicenter") => "#006688", __("Light turquoise", "medicenter") => "#00b6cc", __("Violet", "medicenter") => "#6969b3", __("Dark violet", "medicenter") => "#3e4c94", __("Light violet", "medicenter") => "#9187c4", __("White", "medicenter") => "#FFFFFF", __("Yellow", "medicenter") => "#fec110", __("Light", "medicenter") => "transparent");
$mc_size_arr = array(__("Medium", 'medicenter') => "medium", __("Tiny", 'medicenter') => "tiny", __("Small", 'medicenter') => "small", __("Large", 'medicenter') => "large");
$mc_icons_arr = array(
		__("None", "medicenter") => "none",
		__("Horizontal arrow", "medicenter") => "template-arrow-horizontal-1-after",
		__("Circle arrow", "medicenter") => "template-arrow-circle-after",
		__("Cart", "medicenter") => "template-cart-after",
		__("Search", "medicenter") => "template-search-after",
		__("Mail", "medicenter") => "template-mail-after",
		__("Phone", "medicenter") => "template-phone-after",
		__("Location", "medicenter") => "template-location-after",
		__("Comment", "medicenter") => "template-comment-1-after",
		__("Address book icon", "medicenter") => "wpb_address_book",
		__("Alarm clock icon", "medicenter") => "wpb_alarm_clock",
		__("Anchor icon", "medicenter") => "wpb_anchor",
		__("Application Image icon", "medicenter") => "wpb_application_image",
		__("Arrow icon", "medicenter") => "wpb_arrow",
		__("Asterisk icon", "medicenter") => "wpb_asterisk",
		__("Hammer icon", "medicenter") => "wpb_hammer",
		__("Balloon icon", "medicenter") => "wpb_balloon",
		__("Balloon Buzz icon", "medicenter") => "wpb_balloon_buzz",
		__("Balloon Facebook icon", "medicenter") => "wpb_balloon_facebook",
		__("Balloon Twitter icon", "medicenter") => "wpb_balloon_twitter",
		__("Battery icon", "medicenter") => "wpb_battery",
		__("Binocular icon", "medicenter") => "wpb_binocular",
		__("Document Excel icon", "medicenter") => "wpb_document_excel",
		__("Document Image icon", "medicenter") => "wpb_document_image",
		__("Document Music icon", "medicenter") => "wpb_document_music",
		__("Document Office icon", "medicenter") => "wpb_document_office",
		__("Document PDF icon", "medicenter") => "wpb_document_pdf",
		__("Document Powerpoint icon", "medicenter") => "wpb_document_powerpoint",
		__("Document Word icon", "medicenter") => "wpb_document_word",
		__("Bookmark icon", "medicenter") => "wpb_bookmark",
		__("Camcorder icon", "medicenter") => "wpb_camcorder",
		__("Camera icon", "medicenter") => "wpb_camera",
		__("Chart icon", "medicenter") => "wpb_chart",
		__("Chart pie icon", "medicenter") => "wpb_chart_pie",
		__("Clock icon", "medicenter") => "wpb_clock",
		__("Fire icon", "medicenter") => "wpb_fire",
		__("Heart icon", "medicenter") => "wpb_heart",
		__("Mail icon", "medicenter") => "wpb_mail",
		__("Play icon", "medicenter") => "wpb_play",
		__("Shield icon", "medicenter") => "wpb_shield",
		__("Video icon", "medicenter") => "wpb_video"
	);
$target_arr = array(
	__( 'Same window', 'medicenter' ) => '_self',
	__( 'New window', 'medicenter' ) => '_blank'
);

vc_map( array(
	'name' => __( 'Button', 'medicenter' ) . " 1",
	'base' => 'vc_button',
	'icon' => 'icon-wpb-ui-button',
	'category' => __( 'Content', 'medicenter' ),
	'description' => __( 'Eye catching button', 'medicenter' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Text on the button', 'medicenter' ),
			'holder' => 'button',
			'class' => 'wpb_button',
			'param_name' => 'title',
			'value' => __( 'Text on the button', 'medicenter' ),
			'description' => __( 'Text on the button.', 'medicenter' )
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Label", 'medicenter'),
			"param_name" => "label",
			"value" => ""
		),
		array(
			'type' => 'href',
			'heading' => __( 'URL (Link)', 'medicenter' ),
			'param_name' => 'href',
			'description' => __( 'Button link.', 'medicenter' )
		),
		array(
			"type" => "dropdown",
			"heading" => __("Size", "medicenter"),
			"param_name" => "size",
			"value" => $mc_size_arr,
			"description" => __("Button size.", "medicenter")
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Target', 'medicenter' ),
			'param_name' => 'target',
			'value' => $target_arr,
			'dependency' => array(
				'element' => 'href',
				'not_empty' => true,
				'callback' => 'vc_button_param_target_callback'
			)
		),
		/*array(
			'type' => 'dropdown',
			'heading' => __( 'Color', 'medicenter' ),
			'param_name' => 'color',
			'value' => $colors_arr,
			'description' => __( 'Button color.', 'medicenter' ),
			'param_holder_class' => 'vc-colored-dropdown'
		),*/
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon', 'medicenter' ),
			'param_name' => 'icon',
			'value' => $mc_icons_arr,
			'description' => __( 'Button icon.', 'medicenter' )
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Style", 'medicenter'),
			"param_name" => "style",
			"value" => array(__("Light", 'medicenter') => "light",  __("Light color", 'medicenter') => "light-color", __("Dark color", 'medicenter') => "dark-color", __("Custom...", 'medicenter') => "custom")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text color", 'medicenter'),
			"param_name" => "text_color",
			"value" => "#666666",
			"dependency" => Array('element' => "style", 'value' => 'custom')
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Hover text color", 'medicenter'),
			"param_name" => "hover_text_color",
			"value" => "#FFFFFF",
			"dependency" => Array('element' => "style", 'value' => 'custom')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Color", "medicenter"),
			"param_name" => "color",
			"value" => $mc_colors_arr,
			"description" => __("Button color.", "medicenter"),
			"dependency" => Array('element' => "style", 'value' => 'custom')
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("or pick custom button color", 'medicenter'),
			"param_name" => "custom_button_color",
			"value" => "",
			"dependency" => Array('element' => "style", 'value' => 'custom')
		),
		array(
			"type" => "dropdown",
			"heading" => __("Hover Color", "medicenter"),
			"param_name" => "hover_color",
			"value" => $mc_colors_arr,
			"description" => __("Button hover color.", "medicenter"),
			"dependency" => Array('element' => "style", 'value' => 'custom')
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("or pick custom button hover color", 'medicenter'),
			"param_name" => "custom_button_hover_color",
			"value" => "",
			"dependency" => Array('element' => "style", 'value' => 'custom')
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'medicenter' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'medicenter' )
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'medicenter'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'medicenter') => "none",  __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section")
		)
	),
	'js_view' => 'VcButtonView'
) );

//page layout
function mc_theme_page_layout($atts, $content)
{
	return '<div class="page_layout clearfix">' . do_shortcode($content) . '</div>';
}

//page left
function mc_theme_page_left($atts, $content)
{
	if(is_active_sidebar('left-top'))
	{
		ob_start();
		get_sidebar('left-top');
		$sidebar_left_top = ob_get_contents();
		ob_end_clean();
	}
	return '<div class="page_left">' . $sidebar_left_top . do_shortcode($content) . '</div>';
}

//page right
function mc_theme_page_right($atts, $content)
{
	if(is_active_sidebar('right-top'))
	{
		ob_start();
		get_sidebar('right-top');
		$sidebar_right_top = ob_get_contents();
		ob_end_clean();
	}
	return '<div class="page_right">' . $sidebar_right_top . do_shortcode($content) . '</div>';
}

//button more
function mc_theme_button_more($atts, $content)
{
	extract(shortcode_atts(array(
		"color" => "black",
		"arrow" => "margin_right_white",
		"href" => "#",
		"title" => "More"
	), $atts));
	
	return '<a class="more ' . esc_attr($color) . ($arrow!="" ? ' icon_small_arrow ' . esc_attr($arrow) : '') . '" href="' . esc_url($href) . '" title="' . esc_attr($title) . '">' . do_shortcode($content) . '</a>';
}

//box_header
function mc_theme_box_header($atts)
{
	extract(shortcode_atts(array(
		"title" => "Sample Header",
		"type" => "h3",
		"class" => "",
		"bottom_border" => 1,
		"animation" => 0,
		"top_margin" => "none"
	), $atts));
	return '<' . $type . ' class="box-header' . ($class!="" ? ' ' . esc_attr($class) : '') . (!(int)$bottom_border ? ' no-border' : ((int)$animation ? ' animation-slide' : '')) . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">' . do_shortcode($title) . '</' . $type . '>';
}

//visual composer
vc_map( array(
	"name" => __("Box header", 'medicenter'),
	"base" => "box_header",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-box-header",
	"category" => __('MediCenter', 'medicenter'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'medicenter'),
			"param_name" => "title",
			"value" => "Sample Header"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'medicenter'),
			"param_name" => "type",
			"value" => array(__("H3", 'medicenter') => "h3",  __("H1", 'medicenter') => "h1", __("H2", 'medicenter') => "h2", __("H4", 'medicenter') => "h4", __("H5", 'medicenter') => "h5")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Bottom border", 'medicenter'),
			"param_name" => "bottom_border",
			"value" => array(__("yes", 'medicenter') => 1,  __("no", 'medicenter') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Bottom border animation", 'medicenter'),
			"param_name" => "animation",
			"value" => array(__("no", 'medicenter') => 0,  __("yes", 'medicenter') => 1),
			"dependency" => Array('element' => "bottom_border", 'value' => '1')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Extra class name", 'medicenter'),
			"param_name" => "class",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'medicenter'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'medicenter') => "none", __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section")
		)
	)
));

//dropcap
function mc_theme_dropcap($atts, $content)
{
	extract(shortcode_atts(array(
		"id" => "",
		"label" => "1",
		"label_background_color" => "",
		"custom_label_background_color" => "",
		"label_color" => "",
		"content_text_color" => "",
		"class" => "",
		"top_margin" => "none"
	), $atts));
	
	$label_background_color = ($custom_label_background_color!="" ? $custom_label_background_color : $label_background_color);
	return ($content_text_color!="" && $id!="" ? '<style type="text/css">#' . $id . ' p{color:' . $content_text_color . ';}</style>': '') . '<div' . ($id!="" ? ' id="' . esc_attr($id) . '"' : '') . ' class="dropcap' . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ($class!="" ? ' '. esc_attr($class) : '') . '"><div class="dropcap-label"' . ($label_background_color!="" ? ' style="background-color:' . esc_attr($label_background_color) . ';"' : '') . '><h3' . ($label_color!="" ? ' style="color:' . esc_attr($label_color) . ';"' : '') . '>' . $label . '</h3></div>' . wpb_js_remove_wpautop($content) . '</div>';
}

//visual composer
$mc_colors_arr = array(__("Dark blue", "medicenter") => "#3156a3", __("Blue", "medicenter") => "#0384ce", __("Light blue", "medicenter") => "#42b3e5", __("Black", "medicenter") => "#000000", __("Gray", "medicenter") => "#AAAAAA", __("Dark gray", "medicenter") => "#444444", __("Light gray", "medicenter") => "#CCCCCC", __("Green", "medicenter") => "#43a140", __("Dark green", "medicenter") => "#008238", __("Light green", "medicenter") => "#7cba3d", __("Orange", "medicenter") => "#f17800", __("Dark orange", "medicenter") => "#cb451b", __("Light orange", "medicenter") => "#ffa800", __("Red", "medicenter") => "#db5237", __("Dark red", "medicenter") => "#c03427", __("Light red", "medicenter") => "#f37548", __("Turquoise", "medicenter") => "#0097b5", __("Dark turquoise", "medicenter") => "#006688", __("Light turquoise", "medicenter") => "#00b6cc", __("Violet", "medicenter") => "#6969b3", __("Dark violet", "medicenter") => "#3e4c94", __("Light violet", "medicenter") => "#9187c4", __("White", "medicenter") => "#FFFFFF", __("Yellow", "medicenter") => "#fec110");
vc_map( array(
	"name" => __("Dropcap text", 'medicenter'),
	"base" => "dropcap",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-dropcap",
	"category" => __('MediCenter', 'medicenter'),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Id", 'medicenter'),
			"param_name" => "id",
			"value" => "",
			"description" => __("Please provide unique id for each dropcap on the same page/post if you would like to have custom content color for each one", 'medicenter')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Label", 'medicenter'),
			"param_name" => "label",
			"value" => "1"
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content", 'medicenter'),
			"param_name" => "content",
			"value" => ""
		),
		array(
            "type" => "dropdown",
            "heading" => __("Label background color", "medicenter"),
            "param_name" => "label_background_color",
            "value" => $mc_colors_arr,
            "description" => __("Button color.", "medicenter")
        ),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("or pick custom label background color", 'medicenter'),
			"param_name" => "custom_label_background_color",
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Label text color", 'medicenter'),
			"param_name" => "label_color",
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content text color", 'medicenter'),
			"param_name" => "content_text_color",
			"value" => "",
			"description" => __("If you would like to use 'Content text color', you need to fill 'Id' field", 'medicenter')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Extra class name", 'medicenter'),
			"param_name" => "class",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'medicenter'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'medicenter') => "none", __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section")
		)
	)
));

//show all
function mc_theme_show_all_button($atts)
{
	extract(shortcode_atts(array(
		"url" => "blog",
		"title" => __("show all", 'medicenter')
	), $atts));
	return '<div class="show-all clearfix"><a class="template-arrow-horizontal-1-after" href="' . esc_url($url) . '" title="' . esc_attr($title) . '">' . $title . '</a></div>';
}

//visual composer
vc_map( array(
	"name" => __("Show all button", 'medicenter'),
	"base" => "show_all_button",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-shape-text",
	"category" => __('MediCenter', 'medicenter'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'medicenter'),
			"param_name" => "title",
			"value" => __("Show all &rarr;", 'medicenter')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Url", 'medicenter'),
			"param_name" => "url",
			"value" => "blog"
		)
	)
));

//sentence
function mc_theme_sentence($atts)
{
	extract(shortcode_atts(array(
		"title" => "Sample Sentence Text",
		"author" => "",
		"title_animation" => "",
		"title_animation_duration" => 600,
		"title_animation_delay" => 0,
		"author_animation" => "",
		"author_animation_duration" => 600,
		"author_animation_delay" => 0
	), $atts));
	
	return '<h3 class="sentence template-quote-2' . ($title_animation!='' ? ' animated-element animation-' . esc_attr($title_animation) . ((int)$title_animation_duration>0 && (int)$title_animation_duration!=600 ? ' duration-' . (int)esc_attr($title_animation_duration) : '') . ((int)$title_animation_delay>0 ? ' delay-' . (int)esc_attr($title_animation_delay) : '') : '') . '">' . do_shortcode($title) . '</h3>' . ($author!="" ? '<div class="clearfix"><span class="sentence-author' . ($author_animation!='' ? ' animated-element animation-' . esc_attr($author_animation) . ((int)$author_animation_duration>0 && (int)$author_animation_duration!=600 ? ' duration-' . (int)esc_attr($author_animation_duration) : '') . ((int)$author_animation_delay>0 ? ' delay-' . (int)esc_attr($author_animation_delay) : '') : '') . '">' . $author . '</span></div>' : '');
}

//visual composer
vc_map( array(
	"name" => __("Sentence", 'medicenter'),
	"base" => "sentence",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-sentence",
	"category" => __('MediCenter', 'medicenter'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'medicenter'),
			"param_name" => "title",
			"value" => "Sample Sentence Text"
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Author", 'medicenter'),
			"param_name" => "author",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"heading" => __("Title animation", "medicenter"),
			"param_name" => "title_animation",
			"value" => array(
				__("none", "medicenter") => "",
				__("fade in", "medicenter") => "fadeIn",
				__("scale", "medicenter") => "scale",
				__("slide right", "medicenter") => "slideRight",
				__("slide right 200%", "medicenter") => "slideRight200",
				__("slide left", "medicenter") => "slideLeft",
				__("slide left 50%", "medicenter") => "slideLeft50",
				__("slide down", "medicenter") => "slideDown",
				__("slide down 200%", "medicenter") => "slideDown200",
				__("slide up", "medicenter") => "slideUp"
			)
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title animation duration", 'medicenter'),
			"param_name" => "title_animation_duration",
			"value" => "600"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title animation delay", 'medicenter'),
			"param_name" => "title_animation_delay",
			"value" => "0"
		),
		array(
			"type" => "dropdown",
			"heading" => __("Author animation", "medicenter"),
			"param_name" => "author_animation",
			"value" => array(
				__("none", "medicenter") => "",
				__("fade in", "medicenter") => "fadeIn",
				__("scale", "medicenter") => "scale",
				__("slide right", "medicenter") => "slideRight",
				__("slide right 200%", "medicenter") => "slideRight200",
				__("slide left", "medicenter") => "slideLeft",
				__("slide left 50%", "medicenter") => "slideLeft50",
				__("slide down", "medicenter") => "slideDown",
				__("slide down 200%", "medicenter") => "slideDown200",
				__("slide up", "medicenter") => "slideUp"
			)
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Author animation duration", 'medicenter'),
			"param_name" => "author_animation_duration",
			"value" => "600"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Author animation delay", 'medicenter'),
			"param_name" => "author_animation_delay",
			"value" => "0"
		)
	)
));

//sidebar box
function mc_theme_sidebar_box($atts, $content)
{
	extract(shortcode_atts(array(
		"first" => false
	), $atts));
	return '<div class="sidebar_box' . ($first ? ' first' : '') . '">' . do_shortcode($content) . '</div>';
}

//scroll top
function mc_theme_scroll_top($atts)
{
	extract(shortcode_atts(array(
		"title" => "Scroll to top",
		"label" => "Top"
	), $atts));
	
	return '<a class="scroll_top icon_small_arrow top_white" href="#top" title="' . esc_attr($title) . '">' . esc_attr($label) . '</a>';
}

//box_header
function mc_theme_info_text($atts, $content)
{
	extract(shortcode_atts(array(
		"color" => "white",
		"class" => ""
	), $atts));
	return '<h4 class="info_' . esc_attr($color) . ' ' . esc_attr($class) . '">' . do_shortcode($content) . '</h4>';
}

//header_icon
function mc_theme_header_icon($atts, $content)
{
	extract(shortcode_atts(array(
		"class" => "",
		"url" => "",
		"url_target" => "new_window",
		"type" => "location"
	), $atts));
	
	return '<' . ($url!="" ? 'a' : 'span') . ($url!="" ? ' href="' . esc_attr($url) . '"' . ($url_target=="new_window" ? ' target="_blank"' : '') : '') . ' class="header-icon template-' . esc_attr($type) . ($content=="" ? ' empty-icon' : '') . ($class!="" ? ' ' . esc_attr($class) : '') . '">' . $content . '</' . ($url!="" ? 'a' : 'span') . '>';
}
?>