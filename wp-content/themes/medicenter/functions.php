<?php
$themename = "medicenter";
//for is_plugin_active
include_once( ABSPATH . 'wp-admin/includes/plugin.php');
//plugins activator
require_once("plugins_activator.php");

//vc_remove_element("vc_row_inner");
if(function_exists("vc_remove_element"))
{
	vc_remove_element("vc_gmaps");
	vc_remove_element("vc_tour");
}

//theme options
mc_get_theme_file("/theme-options.php");

//custom meta box
mc_get_theme_file("/meta-box.php");

//dropdown menu
mc_get_theme_file("/nav-menu-dropdown-walker.php");
//mobile menu
mc_get_theme_file("/mobile-menu-walker.php");

//gallery functions
mc_get_theme_file("/gallery-functions.php");
if(function_exists("vc_map"))
{
	//contact_form
	mc_get_theme_file("/contact_form.php");
}

//comments
mc_get_theme_file("/comments-functions.php");

//widgets
mc_get_theme_file("/widgets/widget-cart-icon.php");
mc_get_theme_file("/widgets/widget-home-box.php");
mc_get_theme_file("/widgets/widget-departments.php");
mc_get_theme_file("/widgets/widget-appointment.php");
mc_get_theme_file("/widgets/widget-footer-box.php");
mc_get_theme_file("/widgets/widget-contact-details.php");
mc_get_theme_file("/widgets/widget-scrolling-recent-posts.php");
mc_get_theme_file("/widgets/widget-scrolling-most-commented.php");
mc_get_theme_file("/widgets/widget-scrolling-most-viewed.php");

//shortcodes
if(function_exists("vc_map"))
	mc_get_theme_file("/shortcodes/shortcodes.php");

//admin functions
mc_get_theme_file("/admin/functions.php");

function mc_theme_after_setup_theme()
{
	global $themename;
	if(!get_option($themename . "_installed") || !get_option("wpb_js_content_types") || !get_option("medicenter_vc_access_rules"))
	{
		$theme_options = array(
			"favicon_url" => get_template_directory_uri() . "/images/favicon.ico",
			"logo_url" => get_template_directory_uri() . "/images/header_logo.png",
			"logo_text" => __("medicenter", 'medicenter'),
			"footer_text_left" => sprintf(__('© 2024 <a target="_blank" title="%s" href="%s" rel="nofollow">MediCenter Theme</a>. All rights reserved.', 'medicenter'), esc_html__('MediCenter Theme', 'medicenter'), esc_url(__('https://1.envato.market/medicenter-responsive-medical-wordpress-theme', 'medicenter'))),
			//"home_page_top_hint" => "Give us a call: +123 356 123 124",
			"sticky_menu" => 0,
			"responsive" => 1,
			"scroll_top" => 1,
			"direction" => "default",
			"animations" => 1,
			"layout" => "fullwidth",
			"layout_picker" => 0,
			//"home_page_top_hint" => "",
			"collapsible_mobile_submenus" => 1,
			"google_api_code" => "",
			"google_recaptcha" => "",
			"google_recaptcha_comments" => "",
			"recaptcha_site_key" => "",
			"recaptcha_secret_key" => "",
			"ga_tracking_id" => "",
			"ga_tracking_code" => "",
			"color_scheme" => "",
			"primary_color" => "",
			"secondary_color" => "",
			"tertiary_color" => "",
			"header_top_sidebar" => "",
			"accordion_tab_color" => "",
			"tabs_text_color" => "",
			"tabs_border_color" => "",
			"tabs_hover_text_color" => "",
			"tabs_border_hover_color" => "",
			"featured_icon_color" => "",
			"featured_icon_background_color" => "",
			"light_featured_icon_color" => "",
			"light_featured_icon_background_color" => "",
			"simple_featured_icon_color" => "",
			"social_icon_color" => "",
			"social_icon_background_color" => "",
			"social_icon_hover_color" => "",
			"social_icon_hover_background_color" => "",
			"body_background_color" => "",
			"categories_and_pagination_color" => "",
			"categories_and_pagination_hover_color" => "",
			"categories_and_pagination_border_color" => "",
			"categories_and_pagination_border_hover_color" => "",
			"categories_and_pagination_background_color" => "",
			"categories_and_pagination_hover_background_color" => "",
			"light_button_color" => "",
			"light_button_hover_color" => "",
			"light_button_border_color" => "",
			"light_button_border_hover_color" => "",
			"light_button_background_color" => "",
			"light_button_hover_background_color" => "",
			"light_color_button_color" => "",
			"light_color_button_hover_color" => "",
			"light_color_button_border_color" => "",
			"light_color_button_border_hover_color" => "",
			"light_color_button_background_color" => "",
			"light_color_button_hover_background_color" => "",
			"dark_color_button_color" => "",
			"dark_color_button_hover_color" => "",
			"dark_color_button_border_color" => "",
			"dark_color_button_border_hover_color" => "",
			"dark_color_button_background_color" => "",
			"dark_color_button_hover_background_color" => "",
			"body_headers_border_color" => "",
			"body_headers_color" => "",
			"body_text_color" => "",
			"bread_crumb_border_color" => "",
			"comment_reply_button_color" => "",
			"contact_details_box_background_color" => "",
			"date_box_color" => "",
			"date_box_comments_number_color" => "",
			"date_box_comments_number_text_color" => "",
			"date_box_text_color" => "",
			"divider_background_color" => "",
			"dropdownmenu_background_color" => "",
			"dropdownmenu_border_color" => "",
			"dropdownmenu_hover_background_color" => "",
			"mobile_menu_link_color" => "",
			"mobile_menu_position_background_color" => "",
			"mobile_menu_active_link_color" => "",
			"mobile_menu_active_position_background_color" => "",
			"footer_background_color" => "",
			"copyright_area_background_color" => "",
			"scrolling_list_number_color" => "",
			"scrolling_list_number_border_color" => "",
			"scrolling_list_number_hover_color" => "",
			"scrolling_list_number_border_hover_color" => "",
			"scrolling_list_control_arrow_color" => "",
			"scrolling_list_control_border_color" => "",
			"scrolling_list_control_arrow_hover_color" => "",
			"scrolling_list_control_arrow_border_hover_color" => "",
			"footer_scrolling_list_control_arrow_color" => "",
			"footer_scrolling_list_control_border_color" => "",
			"footer_scrolling_list_control_arrow_hover_color" => "",
			"footer_scrolling_list_control_arrow_border_hover_color" => "",
			"footer_headers_border_color" => "",
			"footer_headers_color" => "",
			"footer_link_color" => "",
			"footer_link_hover_color" => "",
			"footer_text_color" => "",
			"footer_timeago_label_color" => "",
			"form_button_background_color" => "",
			"form_button_hover_background_color" => "",
			"form_button_hover_text_color" => "",
			"form_button_text_color" => "",
			"form_field_border_color" => "",
			"form_field_text_color" => "",
			"form_field_background_color" => "",
			"gallery_box_border_color" => "",
			"gallery_box_color" => "",
			"gallery_box_hover_border_color" => "",
			"gallery_box_hover_color" => "",
			"gallery_box_hover_text_first_line_color" => "",
			"gallery_box_hover_text_second_line_color" => "",
			"gallery_box_text_first_line_color" => "",
			"gallery_box_text_second_line_color" => "",
			"gallery_details_box_border_color" => "",
			"gallery_box_control_color" => "",
			"gallery_box_control_hover_color" => "",
			"header_background_color" => "",
			"header_font" => "",
			"header_font_subset" => "",
			"header_layout_type" => "1",
			"header_top_right_sidebar" => "",
			"link_color" => "",
			"link_hover_color" => "",
			"logo_text_color" => "",
			"main-menu" => "",
			"menu_position_background_color" => "",
			"menu_position_hover_background_color" => "",
			"menu_position_hover_text_color" => "",
			"menu_position_text_color" => "",
			"menu_position_childrens_hover_text_color" => "",
			"menu_position_childrens_hover_background_color" => "",
			"post_author_link_color" => "",
			"quote_color" => "",
			"sentence_color" => "",
			"site_background_color" => "",
			"content_font" => "",
			"content_font_subset" => "",
			"blockquote_font" => "",
			"blockquote_font_subset" => "",
			"submenu_position_border_color" => "",
			"submenu_position_hover_border_color" => "",
			"submenu_position_hover_text_color" => "",
			"submenu_position_text_color" => "",
			"timeago_label_color" => "",
			"timetable_box_color" => "",
			"timetable_box_hover_color" => "",
			"timetable_box_hover_text_color" => "",
			"timetable_box_text_color" => "",
			"timetable_tip_box_color" => "",
			//"top_hint_background_color" => "",
			//"top_hint_text_color" => "",
			"cf_admin_name" => get_option("admin_email"),
			"cf_admin_email" => get_option("admin_email"),
			"cf_admin_name_from" => "",
			"cf_admin_email_from" => "",
			"cf_smtp_host" => "",
			"cf_smtp_username" => "",
			"cf_smtp_password" => "",
			"cf_smtp_port" => "",
			"cf_smtp_secure" => "",
			"cf_email_subject" => __("MediCenter WP: Contact from WWW", 'medicenter'),
			"cf_template" => "<html>
	<head>
	</head>
	<body>
		<div><b>First and last name</b>: [first_name] [last_name]</div>
		<div><b>E-mail</b>: [email]</div>
		<div><b>Department</b>: [department]</div>
		<div><b>Date of Birth (mm/dd/yyyy)</b>: [date]</div>
		<div><b>Social Security Number</b>: [social_security_number]</div>
		<div><b>Reason of Appointment</b>: [message]</div>
	</body>
</html>",
			"cf_first_name_message" => __("Please enter your first name.", 'medicenter'),
			"cf_last_name_message" => __("Please enter your last name.", 'medicenter'),
			"cf_date_message" => __("Please enter your date of birth.", 'medicenter'),
			"cf_security_number_message" => __("Please enter social security number.", 'medicenter'),
			"cf_phone_message" => __("Please enter your phone number.", 'medicenter'),
			"cf_email_message" => __("Please enter valid e-mail.", 'medicenter'),
			"cf_message_message" => __("Please enter your message.", 'medicenter'),
			"cf_recaptcha_message" => __("Please verify captcha.", 'medicenter'),
			"cf_terms_message" => __("Checkbox is required.", 'medicenter'),
			"cf_thankyou_message" => __("Thank you for contacting us", 'medicenter'),
			"cf_error_message" => __("Sorry, we can't send this message", 'medicenter'),
			"cf_name_message_comments" => __("Please enter your name.", 'medicenter'),
			"cf_email_message_comments" => __("Please enter valid e-mail.", 'medicenter'),
			"cf_comment_message_comments" => __("Please enter your message.", 'medicenter'),
			"cf_recaptcha_message_comments" => __("Please verify captcha.", 'medicenter'),
			"cf_terms_message_comments" => __("Checkbox is required.", 'medicenter'),
			"cf_thankyou_message_comments" => __("Your comment has been added.", 'medicenter'),
			"cf_error_message_comments" => __("Error while adding comment.", 'medicenter')
		);
		add_option($themename . "_options", $theme_options);
		
		//add_option($themename . "_slider_settings_home-slider", array('slider_image_url' => array (0 => get_template_directory_uri() . "/images/slider/img1.jpg", 1 => get_template_directory_uri() . "/images/slider/img2.jpg", 2 => get_template_directory_uri() . "/images/slider/img3.jpg"), 'slider_image_title' => array(0 => 'Top notch<br>experience', 1 => 'Show your<br>schedule', 2 => 'Build it<br>your way'), 'slider_image_subtitle' => array (0 => 'Medicenter is a responsive template<br>perfect for all screen sizes', 1 => 'Organize and visualize your week<br>with build-in timetable', 2 => 'Limitless possibilities with multiple<br>page layouts and different shortcodes'), 'slider_image_link' => array (), 'slider_autoplay' => '1', 'slider_navigation' => '1', 'slider_pause_on_hover' => NULL, 'slider_height' => 670, 'slide_interval' => 5000, 'slider_effect' => 'scroll', 'slider_transition' => 'easeInOutQuint', 'slider_transition_speed' => 750));
		
		add_option("wpb_js_content_types", array(
			"page",
			"doctors", 
			"medicenter_gallery", 
			"features",
			"ql_services")
		);
		
		$admin_role = get_role("administrator");
		$admin_role->add_cap("vc_access_rules_post_types", "custom" );
		$admin_role->add_cap("vc_access_rules_post_types/post");
		$admin_role->add_cap("vc_access_rules_post_types/page");
		$admin_role->add_cap("vc_access_rules_post_types/doctors");
		$admin_role->add_cap("vc_access_rules_post_types/medicenter_gallery");
		$admin_role->add_cap("vc_access_rules_post_types/features");
		$admin_role->add_cap("vc_access_rules_post_types/ql_services");
		add_option("medicenter_vc_access_rules", 1);
		
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
		add_option($themename . "_installed", 1);
	}
	//Make theme available for translation
	//Translations can be filed in the /languages/ directory
	load_theme_textdomain('medicenter', get_template_directory() . '/languages');
	
	//register blog post thumbnail & portfolio thumbnail
	add_theme_support("post-thumbnails");
	add_image_size("large-thumb", 960, 750, true);
	add_image_size("blog-post-thumb", 670, 446, true);
	add_image_size($themename . "-gallery-image", 600, 400, true);
	add_image_size("medium-thumb", 480, 320, true);
	add_image_size($themename . "-gallery-thumb-type-1", 390, 260, true);
	add_image_size($themename . "-gallery-thumb-type-2", 285, 190, true);
	add_image_size($themename . "-vertical-image", 320, 460, true);
	add_image_size($themename . "-small-thumb", 100, 100, true);
	
	//posts order
	add_post_type_support('post', 'page-attributes');
	
	//woocommerce
	add_theme_support("woocommerce", array(
		'gallery_thumbnail_image_width' => 150)
	);
	add_theme_support("wc-product-gallery-zoom");
	add_theme_support("wc-product-gallery-lightbox");
	add_theme_support("wc-product-gallery-slider");
	//enable custom background
	add_theme_support("custom-background"); //3.4
	//add_custom_background(); //deprecated
	//enable feed links
	add_theme_support("automatic-feed-links");
	//title tag
	add_theme_support("title-tag");
	
	//gutenberg
	add_theme_support("wp-block-styles");
	add_theme_support("align-wide");
	add_theme_support("editor-color-palette", array(
		array(
			'name' => __("medicenter light blue", 'medicenter'),
			'slug' => 'medicenter-light-blue',
			'color' => '#42B3E5',
		),
		array(
			'name' => __("medicenter dark blue", 'medicenter' ),
			'slug' => 'medicenter-dark-blue',
			'color' => '#3156A3',
		),
		array(
			'name' => __("medicenter blue", 'medicenter' ),
			'slug' => 'medicenter-blue',
			'color' => '#0384CE',
		),
		array(
			'name' => __("medicenter green", 'medicenter' ),
			'slug' => 'medicenter-green',
			'color' => '#7CBA3D',
		),
		array(
			'name' => __("medicenter orange", 'medicenter' ),
			'slug' => 'medicenter-orange',
			'color' => '#FFA800',
		),
		array(
			'name' => __("medicenter red", 'medicenter' ),
			'slug' => 'medicenter-red',
			'color' => '#F37548',
		),
		array(
			'name' => __("medicenter turquoise", 'medicenter' ),
			'slug' => 'medicenter-turquoise',
			'color' => '#00B6CC',
		),
		array(
			'name' => __("medicenter violet", 'medicenter' ),
			'slug' => 'medicenter-violet',
			'color' => '#9187C4',
		)
	));
	//register menu
	if(function_exists("register_nav_menu"))
	{
		register_nav_menu("main-menu", "Main Menu");
		register_nav_menu("footer-menu", "Footer Menu");
	}
	
	//custom theme filters
	add_filter('wp_title', 'mc_wp_title_filter', 10, 2);
	add_filter("image_size_names_choose", "mc_theme_image_sizes");
	add_filter('upload_mimes', 'mc_custom_upload_files');
	add_filter('excerpt_more', 'mc_theme_excerpt_more', 99);
	add_filter('site_transient_update_plugins', 'mc_filter_update_vc_plugin', 10, 2);
	//using shortcodes in sidebar
	add_filter("widget_text", "do_shortcode");
	
	//custom theme woocommerce filters
	add_filter('woocommerce_pagination_args' , 'mc_woo_custom_override_pagination_args');
	add_filter('woocommerce_product_single_add_to_cart_text', 'mc_woo_custom_cart_button_text');
	add_filter('woocommerce_product_add_to_cart_text', 'mc_woo_custom_cart_button_text');
	add_filter('loop_shop_columns', 'mc_woo_custom_loop_columns');
	add_filter('woocommerce_product_description_heading', 'mc_woo_custom_product_description_heading');
	add_filter('woocommerce_checkout_fields' , 'mc_woo_custom_override_checkout_fields');
	add_filter('woocommerce_show_page_title', 'mc_woo_custom_show_page_title');
	add_filter('loop_shop_per_page', 'mc_loop_shop_per_page', 20);
	add_filter('woocommerce_review_gravatar_size', 'mc_woo_custom_review_gravatar_size');
	add_filter('theme_page_templates', 'mc_woocommerce_page_templates' , 11, 3);
	
	//custom theme actions
	if(!function_exists('_wp_render_title_tag')) 
		add_action('wp_head', 'mc_theme_slug_render_title');
	add_action("add_meta_boxes", "mc_theme_add_ql_services_custom_box");
	add_action("save_post", "mc_theme_save_ql_services_postdata");
	add_filter("the_password_form", "customize_the_password_form", 10, 3);
	
	//custom theme woocommerce actions
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
	
	//remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
	
	//phpMailer
	add_action('phpmailer_init', 'mc_phpmailer_init');
	
	//content width
	if(!isset($content_width)) 
		$content_width = 1230;
	
	//register sidebars
	if(function_exists("register_sidebar"))
	{
		//register custom sidebars
		$sidebars_list = get_posts(array( 
			'post_type' => $themename . '_sidebars',
			'posts_per_page' => '-1',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC'
		));
		foreach($sidebars_list as $sidebar)
		{
			$before_widget = get_post_meta($sidebar->ID, "before_widget", true);
			$after_widget = get_post_meta($sidebar->ID, "after_widget", true);
			$before_title = get_post_meta($sidebar->ID, "before_title", true);
			$after_title = get_post_meta($sidebar->ID, "after_title", true);
			register_sidebar(array(
				"id" => $sidebar->post_name,
				"name" => $sidebar->post_title,
				'before_widget' => ($before_widget!='' && $before_widget!='empty' ? $before_widget : ''),
				'after_widget' => ($after_widget!='' && $after_widget!='empty' ? $after_widget : ''),
				'before_title' => ($before_title!='' && $before_title!='empty' ? $before_title : ''),
				'after_title' => ($after_title!='' && $after_title!='empty' ? $after_title : '')
			));
		}
	}
}
add_action("after_setup_theme", "mc_theme_after_setup_theme");
function mc_theme_switch_theme($theme_template)
{
	global $themename;
	delete_option($themename . "_installed");
}
add_action("switch_theme", "mc_theme_switch_theme");

//theme options
global $theme_options;
$theme_options = array(
	"favicon_url" => '',
	"logo_url" => '',
	"logo_text" => '',
	"footer_text_left" => '',
	"sticky_menu" => '',
	"responsive" => '',
	"scroll_top" => '',
	"layout" => '',
	"layout_picker" => '',
	"direction" => '',
	"animations" => '',
	"collapsible_mobile_submenus" => '',
	"google_api_code" => '',
	"google_recaptcha" => '',
	"google_recaptcha_comments" => '',
	"recaptcha_site_key" => '',
	"recaptcha_secret_key" => '',
	"ga_tracking_id" => '',
	"ga_tracking_code" => '',
	//"home_page_top_hint" => '',
	"cf_admin_name" => '',
	"cf_admin_email" => '',
	"cf_admin_name_from" => '',
	"cf_admin_email_from" => '',
	"cf_smtp_host" => '',
	"cf_smtp_username" => '',
	"cf_smtp_password" => '',
	"cf_smtp_port" => '',
	"cf_smtp_secure" => '',
	"cf_email_subject" => '',
	"cf_template" => '',
	"cf_first_name_message" => '',
	"cf_last_name_message" => '',
	"cf_date_message" => '',
	"cf_security_number_message" => '',
	"cf_phone_message" => '',
	"cf_email_message" => '',
	"cf_message_message" => '',
	"cf_recaptcha_message" => '',
	"cf_terms_message" => '',
	"cf_thankyou_message" => '',
	"cf_error_message" => '',
	"cf_name_message_comments" => '',
	"cf_email_message_comments" => '',
	"cf_comment_message_comments" => '',
	"cf_recaptcha_message_comments" => '',
	"cf_terms_message_comments" => '',
	"cf_thankyou_message_comments" => '',
	"cf_error_message_comments" => '',
	"color_scheme" => '',
	"primary_color" => '',
	"secondary_color" => '',
	"tertiary_color" => '',
	"site_background_color" => '',
	"header_background_color" => '',
	"body_background_color" => '',
	"footer_background_color" => '',
	"copyright_area_background_color" => '',
	"link_color" => '',
	"link_hover_color" => '',
	"footer_link_color" => '',
	"footer_link_hover_color" => '',
	"body_headers_color" => '',
	"body_headers_border_color" => '',
	"body_text_color" => '',
	"timeago_label_color" => '',
	"footer_headers_color" => '',
	"footer_headers_border_color" => '',
	"footer_text_color" => '',
	"footer_timeago_label_color" => '',
	"sentence_color" => '',
	"quote_color" => '',
	"logo_text_color" => '',
	"categories_and_pagination_color" => '',
	"categories_and_pagination_hover_color" => '',
	"categories_and_pagination_border_color" => '',
	"categories_and_pagination_border_hover_color" => '',
	"categories_and_pagination_background_color" => '',
	"categories_and_pagination_hover_background_color" => '',
	"light_button_color" => '',
	"light_button_hover_color" => '',
	"light_button_border_color" => '',
	"light_button_border_hover_color" => '',
	"light_button_background_color" => '',
	"light_button_hover_background_color" => '',
	"light_color_button_color" => '',
	"light_color_button_hover_color" => '',
	"light_color_button_border_color" => '',
	"light_color_button_border_hover_color" => '',
	"light_color_button_background_color" => '',
	"light_color_button_hover_background_color" => '',
	"dark_color_button_color" => '',
	"dark_color_button_hover_color" => '',
	"dark_color_button_border_color" => '',
	"dark_color_button_border_hover_color" => '',
	"dark_color_button_background_color" => '',
	"dark_color_button_hover_background_color" => '',
	"scrolling_list_number_color" => '',
	"scrolling_list_number_border_color" => '',
	"scrolling_list_number_hover_color" => '',
	"scrolling_list_number_border_hover_color" => '',
	"scrolling_list_control_arrow_color" => '',
	"scrolling_list_control_border_color" => '',
	"scrolling_list_control_arrow_hover_color" => '',
	"scrolling_list_control_arrow_border_hover_color" => '',
	"footer_scrolling_list_control_arrow_color" => '',
	"footer_scrolling_list_control_border_color" => '',
	"footer_scrolling_list_control_arrow_hover_color" => '',
	"footer_scrolling_list_control_arrow_border_hover_color" => '',
	"menu_position_text_color" => '',
	"menu_position_hover_text_color" => '',
	"menu_position_childrens_hover_text_color" => '',
	"menu_position_background_color" => '',
	"menu_position_hover_background_color" => '',
	"menu_position_childrens_hover_background_color" => '',
	"submenu_position_text_color" => '',
	"submenu_position_hover_text_color" => '',
	"submenu_position_border_color" => '',
	"submenu_position_hover_border_color" => '',
	"dropdownmenu_background_color" => '',
	"dropdownmenu_hover_background_color" => '',
	"dropdownmenu_border_color" => '',
	"mobile_menu_link_color" => '',
	"mobile_menu_position_background_color" => '',
	"mobile_menu_active_link_color" => '',
	"mobile_menu_active_position_background_color" => '',
	"form_field_text_color" => '',
	"form_field_border_color" => '',
	"form_field_background_color" => '',
	"form_button_background_color" => '',
	"form_button_hover_background_color" => '',
	"form_button_text_color" => '',
	"form_button_hover_text_color" => '',
	//"top_hint_background_color" => '',
	//"top_hint_text_color" => '',
	"divider_background_color" => '',
	"date_box_color" => '',
	"date_box_text_color" => '',
	"date_box_comments_number_color" => '',
	"date_box_comments_number_text_color" => '',
	"gallery_box_color" => '',
	"gallery_box_text_first_line_color" => '',
	"gallery_box_text_second_line_color" => '',
	"gallery_box_hover_color" => '',
	"gallery_box_hover_text_first_line_color" => '',
	"gallery_box_hover_text_second_line_color" => '',
	"gallery_box_border_color" => '',
	"gallery_box_hover_border_color" => '',
	"gallery_box_control_color" => '',
	"gallery_box_control_hover_color" => '',
	"timetable_box_color" => '',
	"timetable_box_hover_color" => '',
	"timetable_box_text_color" => '',
	"timetable_box_hover_text_color" => '',
	"timetable_tip_box_color" => '',
	"accordion_tab_color" => '',
	"tabs_text_color" => '',
	"tabs_border_color" => '',
	"tabs_hover_text_color" => '',
	"tabs_border_hover_color" => '',
	"featured_icon_color" => '',
	"featured_icon_background_color" => '',
	"light_featured_icon_color" => '',
	"light_featured_icon_background_color" => '',
	"simple_featured_icon_color" => '',
	"social_icon_color" => '',
	"social_icon_background_color" => '',
	"social_icon_hover_color" => '',
	"social_icon_hover_background_color" => '',
	"header_layout_type" => '',
	"header_top_sidebar" => '',
	"header_top_right_sidebar" => '',
	"header_font" => '',
	"header_font_subset" => '',
	"content_font" => '',
	"content_font_subset" => '',
	"blockquote_font" => '',
	"blockquote_font_subset" => ''
);
$theme_options = mc_theme_stripslashes_deep(array_merge($theme_options, (array)get_option($themename . "_options")));

function mc_theme_enqueue_scripts()
{
	global $themename;
	global $theme_options;
	//style
	if(!empty($theme_options["header_font"]))
		wp_enqueue_style("google-font-header", "//fonts.googleapis.com/css?family=" . urlencode($theme_options["header_font"]) . (!empty($theme_options["header_font_subset"]) ? "&subset=" . implode(",", $theme_options["header_font_subset"]) : ""));
	else
		wp_enqueue_style("google-font-source-sans-pro", "//fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,300,600,700&amp;subset=latin,latin-ext");
	if(!empty($theme_options["content_font"]))
		wp_enqueue_style("google-font-content", "//fonts.googleapis.com/css?family=" . urlencode($theme_options["content_font"]) . (!empty($theme_options["content_font_subset"]) ? "&subset=" . implode(",", $theme_options["content_font_subset"]) : ""));
	else
		wp_enqueue_style("google-font-open-sans", "//fonts.googleapis.com/css?family=Open+Sans:400,300&amp;subset=latin,latin-ext");
	if(!empty($theme_options["blockquote_font"]))
		wp_enqueue_style("google-font-blockquote", "//fonts.googleapis.com/css?family=" . urlencode($theme_options["blockquote_font"]) . (!empty($theme_options["blockquote_font_subset"]) ? "&subset=" . implode(",", $theme_options["blockquote_font_subset"]) : ""));
	else
		wp_enqueue_style("google-font-pt-serif", "//fonts.googleapis.com/css?family=PT+Serif:400italic&amp;subset=latin,latin-ext");
	wp_enqueue_style("reset", get_template_directory_uri() . "/style/reset.css");
	wp_enqueue_style("superfish", get_template_directory_uri() ."/style/superfish.css");
	wp_enqueue_style("prettyPhoto", get_template_directory_uri() ."/style/prettyPhoto.css");
	//wp_enqueue_style("jquery-fancybox", get_template_directory_uri() ."/style/fancybox/jquery.fancybox.css");
	wp_enqueue_style("jquery-qtip", get_template_directory_uri() ."/style/jquery.qtip.css");
	wp_enqueue_style("odometer", get_template_directory_uri() ."/style/odometer-theme-default.css");
	if(((int)$theme_options["animations"] || !isset($theme_options["animations"])) && (isset($_COOKIE["mc_animations"]) && $_COOKIE["mc_animations"]==1 || !isset($_COOKIE["mc_animations"])))
	{
		wp_enqueue_style("animations", get_template_directory_uri() ."/style/animations.css");
		if(is_rtl())
			wp_enqueue_style("animations", get_template_directory_uri() ."/style/animations_rtl.css");
	}
	wp_enqueue_style("main-style", get_stylesheet_uri());
	if((int)$theme_options["responsive"])
		wp_enqueue_style("responsive", get_template_directory_uri() ."/style/responsive.css");
	else
		wp_enqueue_style("no-responsive", get_template_directory_uri() ."/style/no_responsive.css");
	
	if(function_exists("is_plugin_active") && is_plugin_active('woocommerce/woocommerce.php'))
	{
		wp_enqueue_style("woocommerce-custom", get_template_directory_uri() ."/woocommerce/style.css");
		if((int)$theme_options["responsive"])
			wp_enqueue_style("woocommerce-responsive", get_template_directory_uri() ."/woocommerce/responsive.css");
		else
			wp_dequeue_style("woocommerce-smallscreen");
		if(is_rtl())
			wp_enqueue_style("woocommerce-rtl", get_template_directory_uri() ."/woocommerce/rtl.css");
	}
	wp_enqueue_style("mc-features", get_template_directory_uri() ."/fonts/features/style.css");
	wp_enqueue_style("mc-template", get_template_directory_uri() ."/fonts/template/style.css");
	wp_enqueue_style("mc-social", get_template_directory_uri() ."/fonts/social/style.css");
	wp_enqueue_style("custom", get_template_directory_uri() ."/custom.css");
	//js
	wp_enqueue_script("jquery", false, array(), false, true);
	wp_enqueue_script("jquery-ui-core", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-accordion", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-tabs", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-datepicker", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-imagesloaded", get_template_directory_uri() . "/js/jquery.imagesloaded-packed.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-ba-bqq", get_template_directory_uri() ."/js/jquery.ba-bbq.min.js", array("jquery"), false, true);
	if(function_exists("is_checkout") && !is_checkout() || !function_exists("is_checkout"))
	{
		wp_enqueue_script("jquery-history", get_template_directory_uri() ."/js/jquery.history.js", array("jquery"), false, true);
	}
	wp_enqueue_script("jquery-easing", get_template_directory_uri() ."/js/jquery.easing.1.4.1.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-carouFredSel", get_template_directory_uri() ."/js/jquery.carouFredSel-6.2.1-packed.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-sliderControl", get_template_directory_uri() ."/js/jquery.sliderControl.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-timeago", get_template_directory_uri() ."/js/jquery.timeago.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-hint", get_template_directory_uri() ."/js/jquery.hint.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-isotope", get_template_directory_uri() ."/js/jquery.isotope-packed.js", array("jquery"), false, true);
	//if((is_rtl() || (isset($theme_options['direction']) && $theme_options["direction"]=='rtl')) && ((isset($_COOKIE["mc_direction"]) && $_COOKIE["mc_direction"]!="LTR") || !isset($_COOKIE["mc_direction"])))
	//	wp_enqueue_script("rtl-js", get_template_directory_uri() ."/js/rtl.js", array("jquery", "jquery-isotope"), "jquery-isotope-masonry", false, true);
	wp_enqueue_script("jquery-prettyPhoto", get_template_directory_uri() ."/js/jquery.prettyPhoto.js", array("jquery"), false, true);
	//wp_enqueue_script("jquery-fancybox", get_template_directory_uri() ."/js/jquery.fancybox-1.3.4.pack.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-qtip", get_template_directory_uri() ."/js/jquery.qtip.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-block-ui", get_template_directory_uri() ."/js/jquery.blockUI.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-parallax", get_template_directory_uri() ."/js/jquery.parallax.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-odometer", get_template_directory_uri() ."/js/odometer.min.js", array("jquery", "theme-main" ), false, true);
	if(!empty($theme_options['ga_tracking_id']))
	{
		wp_enqueue_script("google-analytics", "https://www.googletagmanager.com/gtag/js?id=" . esc_attr($theme_options["ga_tracking_id"]), array(), false, true);
	}
	wp_register_script("google-maps-v3", "//maps.google.com/maps/api/js" . ($theme_options["google_api_code"]!="" ? "?key=" . esc_attr($theme_options["google_api_code"]) . "&amp;callback=medicenterInitMap" : ""), array(), false, true);
	wp_register_script("google-recaptcha-v2", "https://google.com/recaptcha/api.js", array(), false, true);
	
	wp_enqueue_script("theme-main", get_template_directory_uri() ."/js/main.js", array("jquery", "jquery-ui-core", "jquery-ui-accordion", "jquery-ui-tabs"), false, true);
	if(!empty($theme_options['ga_tracking_id']))
	{
		$inline_script = "window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '" . $theme_options['ga_tracking_id'] . "');";
		wp_add_inline_script("google-analytics", $inline_script);
	}
	if(!empty($theme_options['ga_tracking_code']))
	{
		$inline_script = $theme_options['ga_tracking_code'];
		wp_add_inline_script("jquery", $inline_script);
	}
	
	//ajaxurl
	$data["ajaxurl"] = admin_url("admin-ajax.php");
	//themename
	$data["themename"] = $themename;
	//home url
	$data["home_url"] = get_home_url();
	//is_rtl
	$data["is_rtl"] = ((is_rtl() || $theme_options["direction"]=='rtl') && ((isset($_COOKIE["mc_direction"]) && $_COOKIE["mc_direction"]!="LTR") || !isset($_COOKIE["mc_direction"]))) || (isset($_COOKIE["mc_direction"]) && $_COOKIE["mc_direction"]=="RTL") ? 1 : 0;
	
	//pass data to javascript
	$params = array(
		'l10n_print_after' => 'config = ' . json_encode($data) . ';'
	);
	wp_localize_script("theme-main", "config", $params);
}
add_action("wp_enqueue_scripts", "mc_theme_enqueue_scripts");

//function to display number of posts
function getPostViews($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='')
	{
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }
    return (int)$count;
}

//function to count views
function setPostViews($postID) 
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='')
	{
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, 1);
    }
	else
	{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
/* --- phpMailer config --- */
function mc_phpmailer_init($mail) 
{
	global $theme_options;
	$mail->CharSet='UTF-8';

	$smtp = $theme_options["cf_smtp_host"];
	if(!empty($smtp))
	{
		$mail->IsSMTP();
		$mail->SMTPAuth = true; 
		//$mail->SMTPDebug = 2;
		$mail->Host = $theme_options["cf_smtp_host"];
		$mail->Username = $theme_options["cf_smtp_username"];
		$mail->Password = $theme_options["cf_smtp_password"];
		if((int)$theme_options["cf_smtp_port"]>0)
			$mail->Port = (int)$theme_options["cf_smtp_port"];
		$mail->SMTPSecure = $theme_options["cf_smtp_secure"];
	}
}
function mc_custom_template_for_vc() 
{
    $data = array();
    $data['name'] = __('Single Post Template', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row el_position="first last"][vc_column width="2/3"][single_post columns="1" show_post_title="1" show_post_featured_image="1" show_post_categories="1" show_post_author="1" comments="1" comments_form_animation="slideRight" show_post_comments_label="1" post_date_animation="slideRight" post_comments_animation="slideUp" post_comments_animation_duration="300" post_comments_animation_delay="500" top_margin="page-margin-top" el_position="first last"][/vc_column][vc_column width="1/3"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog" el_position="first"][box_header title="Photostream" bottom_border="1" animation="1" top_margin="page-margin-top"][photostream images="21,15,16,17,18,19,1816,1817" images_loop="1"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog-2" el_position="last"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Blog Template', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row el_position="first last"][vc_column width="2/3"][blog mc_pagination="1" items_per_page="1" layout_type="1" ids="-" category="-" order_by="date" show_post_title="1" read_more="1" show_post_categories="1" show_post_author="1" show_post_comments_box="1" show_post_comments_label="1" post_date_animation="slideRight" post_comments_animation="slideUp" post_comments_animation_duration="300" post_comments_animation_delay="500" show_post_date_footer="0" show_post_comments_footer="0" top_margin="page-margin-top" el_position="first last"][/vc_column][vc_column width="1/3"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog" el_position="first"][box_header title="Photostream" bottom_border="1" animation="1" top_margin="page-margin-top"][photostream images="21,15,16,17,18,19,1816,1817" images_loop="1"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog-2" el_position="last"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Search Template', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row el_position="first last"][vc_column width="2/3"][blog mc_pagination="1" items_per_page="4" layout_type="1" ids="-" category="-" show_post_title="1" read_more="1" show_post_categories="1" show_post_author="1" show_post_comments_box="1" show_post_comments_label="0" show_post_date_footer="0" show_post_comments_footer="0" is_search_results="1" top_margin="page-margin-top" el_position="first last"][/vc_column][vc_column width="1/3"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog" el_position="first"][box_header title="Photostream" bottom_border="1" animation="0" top_margin="page-margin-top"][photostream images="21,15,16,17,18,19,1816,1817" images_loop="1"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog-2" el_position="last"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Single Doctor Template', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row top_margin="page-margin-top"][vc_column][single_doctor][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Single Features Template', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row el_position="first last"][vc_column width="2/3"][single_post featured_image_size="mc_blog-post-thumb" columns="2" show_post_title="1" show_post_featured_image="1" show_post_categories="0" show_post_author="0" comments="0" show_post_date_box="0" show_post_comments_box="0" show_post_comments_label="0" top_margin="page-margin-top" el_position="first last"][/vc_column][vc_column width="1/3"][box_header title="Features" bottom_border="1" animation="0" top_margin="page-margin-top" el_position="first"][features ids="964,963,965,966" headers="0" headers_links="1" read_more="1" icon_links="1" top_margin="page-margin-top"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-departments-2" el_position="last"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Single Service Template', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row type="full-width" top_margin="page-margin-top-section"][vc_column][single_service][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Doctor Page Layout', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row el_position="first last"][vc_column width="1/3"][doctor_box title_box="1" display_social_icons="1" headers="1" headers_links="1" headers_border="1" show_subtitle="1" show_excerpt="1" show_social_icons="1" show_featured_image="1" featured_image_links="1"][/vc_column][vc_column width="2/3"][box_header title="Ann Blyumin, Prof." type="h2" bottom_border="1" animation="1"][vc_row_inner][vc_column_inner width="1/2"][vc_column_text el_class="description"]Dr. Adams is certified by the American Board in Internal Medicine and in hematology and medical oncology. He currently serves as a consultant in medical oncology at Medicenter Hospital and as the program director for the National Healthcare Group Medical Oncology Residency Program, which is run in collaboration with Medicenter Hospital.[/vc_column_text][vc_button title="TIMETABLE" icon="template-arrow-horizontal-1-after"][/vc_column_inner][vc_column_inner width="1/2"][doctor_description_box][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_margin="page-margin-top"][vc_column][vc_separator][/vc_column][/vc_row][vc_row top_margin="page-margin-top"][vc_column width="1/3"][features ids="936" type="small" headers="1" headers_links="1" read_more="0" icon_links="1"][/vc_column][vc_column width="1/3"][features ids="281" type="small" headers="1" headers_links="1" read_more="0" icon_links="1"][/vc_column][vc_column width="1/3"][features ids="925" type="small" headers="1" headers_links="1" read_more="0" icon_links="1"][/vc_column][/vc_row][vc_row top_margin="page-margin-top"][vc_column][vc_separator][/vc_column][/vc_row][vc_row top_margin="page-margin-top"][vc_column width="2/3"][box_header title="Services" bottom_border="1" animation="1"][vc_column_text el_class="description"]Dr. Adams is certified by the American Board in Internal Medicine and in hematology and medical oncology. He currently serves as a consultant in medical oncology at Medicenter Hospital and as the program director for the National Healthcare Group Medical Oncology Residency Program, which is run in collaboration with Medicenter Hospital.[/vc_column_text][vc_row_inner top_margin="page-margin-top"][vc_column_inner width="1/2"][items_list animation="0" additembutton="" read_more="0"][item type="items" value="$350" url="" url_target="new_window" icon="" text_color="" value_color="" border_color=""]Colonoscopy[/item][item type="items" value="$275" url="" url_target="new_window" icon="" text_color="" value_color="" border_color=""]Gastroscopy[/item][item type="items" value="$175" url="" url_target="new_window" icon="" text_color="" value_color="" border_color=""]Allergy Testing[/item][item type="items" value="$100" url="" url_target="new_window" icon="" text_color="" value_color="" border_color=""]Molecule[/item][/items_list][/vc_column_inner][vc_column_inner width="1/2"][items_list animation="0" additembutton="" read_more="0"][item type="items" value="$350" url="" url_target="new_window" icon="" text_color="" value_color="" border_color=""]CT Scan[/item][item type="items" value="$275" url="" url_target="new_window" icon="" text_color="" value_color="" border_color=""]Bronchoscopy[/item][/items_list][/vc_column_inner][/vc_row_inner][vc_row_inner top_margin="page-margin-top"][vc_column_inner][box_header title="Medical Education" bottom_border="1" animation="1"][timeline_item label="SINCE 2005" label_position="" title="Royal College of Surgeons of Edinburg" subtitle="HEAD OF THE DEPARTMENT" animations="1" top_margin="page-margin-top"]Paetos dignissim at cursus elefeind norma arcu. Pellentesque accumsan est in tempus etos ullamcorper, sem quam suscipit lacus maecenas tortor.[/timeline_item][timeline_item label="SINCE 2002" title="Fellowship, Royal College of Physicians &amp; Surgeons of Glasgow" subtitle="DOCTOR" animations="1"]Paetos dignissim at cursus elefeind norma arcu. Pellentesque accumsan est in tempus etos ullamcorper, sem quam suscipit lacus maecenas tortor.[/timeline_item][timeline_item label="1998 - 2002" title="Residency, St. Vincent's University Hospital" subtitle="INTERN" animations="1"]Paetos dignissim at cursus elefeind norma arcu. Pellentesque accumsan est in tempus etos ullamcorper, sem quam suscipit lacus maecenas tortor.[/timeline_item][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/3"][vc_widget_sidebar sidebar_id="sidebar-home-right-style-2"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Service Page Layout', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row][vc_column width="1/3"][service_box headers="1" headers_links="0" show_excerpt="1" show_featured_image="1" featured_image_links="0"][/vc_column][vc_column width="2/3" el_class="padding-left-30"][box_header title="Simply walk in" bottom_border="1" animation="0"][box_header title="Effective and affordable treatment<br>for non-life threatening illnesses" type="h2" bottom_border="0" class="large margin-top-30"][vc_column_text el_class="large margin-top-10"]When you need treatment for minor injuries and illnesses, but the doctor is not available, Medicenter immediate care services have you covered. Our immediate care locations combine easy-to-access services with our well-known standards for delivering the best care.[/vc_column_text][items_list type="simple" animation="0" additembutton="" read_more="0"][item type="items" value="" url="" url_target="new_window" icon="tick-2" text_color="" value_color="" value_bg_color="" border_color=""]Medicenter is a people centered environment - which means you are at the center of everything we do and every decision we make.[/item][item type="items" value="" url="" url_target="new_window" icon="tick-2" text_color="" value_color="" value_bg_color="" border_color=""]We are your partner for health, helping your live well by bringing the best in medicine and healthcare to your door.[/item][item type="items" value="" url="" url_target="new_window" icon="tick-2" text_color="" value_color="" value_bg_color="" border_color=""]We provide fast, effective and affordable immediate care for non-life threatening illnesses. Most patients are seen, treated and released in about 60 minutes.[/item][/items_list][/vc_column][/vc_row][vc_row type="full-width" top_margin="page-margin-top-section" el_class="flex-box" css=".vc_custom_1539766293556{background-color: #ffffff !important;}"][vc_column width="1/2" css=".vc_custom_1536849658368{background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" el_class="padding-bottom-128 column-limited"][vc_row_inner el_class="padding-right-100"][vc_column_inner][box_header title="Learn why is it worth it" bottom_border="1" animation="0" class="margin-top-92"][box_header title="Medicenter Immediate Care Facilities Provide Quick Care and Relief" type="h2" bottom_border="0" class="large margin-top-30"][vc_column_text el_class="large margin-top-10"]No appointment needed, most patients are seen, treated and released in about 60 minutes. Certified and experienced MD physicians not nurses and on site diagnostic tests with lab.[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_tabs el_class="vc_row margin-top-30 padding-right-100"][vc_tab title="BENEFITS" tab_id="benefits"][vc_column_text]When you are feeling under the weather and can not wait for an appointment with your primary care doctor, our physicians and experienced immediate care staff can help you feel better.[/vc_column_text][/vc_tab][vc_tab title="THE TREATMENT PROCESS" tab_id="the-treatment-process"][vc_column_text]No appointment needed, most patients are seen, treated and released in about 60 minutes. Certified and experienced MD physicians not nurses and on site diagnostic tests with lab.[/vc_column_text][/vc_tab][/vc_tabs][/vc_column][vc_column width="1/2" css=".vc_custom_1540466200596{background-image: url(https://quanticalabs.com/wptest/medicenter-new/files/2018/10/placeholder.jpg?id=3750) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_single_image image="3750" img_size="large-thumb" el_class="flex-hide"][mc_icon style="hexagon" icon_feature="play" url="https://www.youtube.com/watch?v=AivyFZXT2ek" url_target="same_window" class="fancybox"][/vc_column][/vc_row][vc_row el_class="padding-top-89"][vc_column][box_header title="Service Overview" type="h2" bottom_border="1" animation="0" class="large align-center"][vc_column_text el_class="large align-center margin-top-20"]When we or someone we care for is sick or needs medical attention, we want the best care possible in the<br />
shortest amount of time. Simply walk in and you will be seen as quickly as possible.[/vc_column_text][/vc_column][/vc_row][vc_row top_margin="page-margin-top-section"][vc_column width="2/3"][vc_row_inner][vc_column_inner width="1/2"][vc_single_image image="3750" img_size="medium-thumb" onclick="link_image"][/vc_column_inner][vc_column_inner width="1/2"][vc_single_image image="3750" img_size="medium-thumb" onclick="link_image"][/vc_column_inner][/vc_row_inner][vc_column_text el_class="large margin-top-20"]Since its founding we become an integral part of the city, advancing our mission of providing access to compassionate care to our communities. Today patients find care that combines world-class medicine with compassion.[/vc_column_text][vc_column_text]Since its founding we become an integral part of the city, advancing our mission of providing access to compassionate care to our communities. Today patients find care that combines world-class medicine with compassion. Since its founding we become an integral part of the city, advancing our mission of providing access to compassionate care.[/vc_column_text][vc_tabs el_class="margin-top-30"][vc_tab title="SERVICES" tab_id="services"][vc_row_inner top_margin="page-margin-top"][vc_column_inner width="1/2"][features ids="963,965" type="small" headers="1" headers_links="1" read_more="0" icon_links="1"][/vc_column_inner][vc_column_inner width="1/2"][features ids="883,966" type="small" headers="1" headers_links="1" read_more="0" icon_links="1"][/vc_column_inner][/vc_row_inner][/vc_tab][vc_tab title="TREATMENTS" tab_id="treatments"][vc_row_inner top_margin="page-margin-top"][vc_column_inner width="1/2"][features ids="206,966" type="small" headers="1" headers_links="1" read_more="0" icon_links="1"][/vc_column_inner][vc_column_inner width="1/2"][features ids="210,925" type="small" headers="1" headers_links="1" read_more="0" icon_links="1"][/vc_column_inner][/vc_row_inner][/vc_tab][/vc_tabs][/vc_column][vc_column width="1/3" css=".vc_custom_1539768616510{background-color: #f0f0f0 !important;}" el_class="padding-40"][box_header title="Price List of Treatments" bottom_border="1" animation="0"][items_list animation="0" additembutton="" read_more="0" class="margin-top-30"][item type="items" value="$350"]Colonoscopy[/item][item type="items" value="$275"]Gastroscopy[/item][item type="items" value="$175"]Allergy Testing[/item][item type="items" value="$25"]CT Scan[/item][item type="items" value="$50"]Bronchoscopy[/item][item type="items" value="$500"]Colonoscopy[/item][/items_list][box_header title="Prepaid Treatments" bottom_border="1" animation="0" top_margin="page-margin-top"][items_list animation="0" additembutton="" read_more="0" class="margin-top-30"][item type="items" value="$350"]Colonoscopy[/item][item type="items" value="$275"]Gastroscopy[/item][item type="items" value="$175"]Allergy Testing[/item][item type="items" value="$25"]CT Scan[/item][/items_list][/vc_column][/vc_row][vc_row type="full-width" top_margin="page-margin-top-section" css=".vc_custom_1540466332131{background-image: url(https://quanticalabs.com/wptest/medicenter-new/files/2018/10/placeholder.jpg?id=3750) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" el_class="padding-top-89 padding-bottom-100"][vc_column][box_header title="Medical Walk-in Process" type="h2" bottom_border="1" animation="0" class="white align-center large"][vc_row_inner top_margin="page-margin-top-section" el_class="flex-box"][vc_column_inner width="1/3"][info_box title="No Appointment Needed" icon="medical-bed" animation="fadeIn" animation_duration="500" arrow="light" arrow_animation="slideRight" arrow_animation_duration="800" arrow_animation_delay="150"]An appointment is not required in order to receive care. For this reason, patients do not have to plan out when they can come in. Simply walk in and you'll be seen.[/info_box][/vc_column_inner][vc_column_inner width="1/3"][info_box title="Licensed Professionals" icon="dna" animation="slideRight" animation_duration="800" animation_delay="600" arrow="dark" arrow_animation="slideRight" arrow_animation_duration="800" arrow_animation_delay="1050"]Urgent care physicians and nurses offer high-quanlity care. They are licensed and recognized as reputable members of the healthcare industry.[/info_box][/vc_column_inner][vc_column_inner width="1/3"][info_box title="Cost Effective" icon="people" animation="slideRight" animation_duration="800" animation_delay="1500"]The cost of seeing a physician at a medical immediate care facility will be much more affordable than seeing a physician in an emergency room.[/info_box][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row top_margin="page-margin-top-section"][vc_column][box_header title="Please call (510) 210-5225" type="h2" bottom_border="1" animation="0" class="large align-center"][vc_column_text el_class="large align-center margin-top-20"]Or contact us via email form below[/vc_column_text][medicenter_contact_form header="" animation="0" department_select_box="0" submit_label="SEND MESSAGE" display_first_name="1" first_name_required="1" display_last_name="1" last_name_required="1" display_date="0" display_security_number="0" display_phone="1" phone_label="YOUR PHONE (OPTIONAL)" phone_required="0" display_email="1" email_label="YOUR E-MAIL" email_required="1" display_message="1" message_label="YOUR MESSAGE" message_required="1" terms_checkbox="0" top_margin="page-margin-top"][/vc_column][/vc_row][vc_row type="full-width" top_margin="page-margin-top-section" css=".vc_custom_1539781219318{border-top-width: 1px !important;border-top-color: #e5e5e5 !important;border-top-style: solid !important;}"][vc_column][vc_row_inner top_margin="page-margin-top-section"][vc_column_inner][box_header title="Other Services" type="h2" bottom_border="1" animation="0" class="large align-center"][vc_column_text el_class="large align-center margin-top-20"]Since its founding Medicenter has been providing its patients with full medical care, encompassing<br />
outpatients services, laboratory and imaging diagnostics, dentistry, dentistry and immediate care.[/vc_column_text][ql_services items_per_page="3" order_by="date" headers="1" headers_links="1" headers_border="1" show_excerpt="1" show_featured_image="1" featured_image_links="1" top_margin="page-margin-top"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Service Page Layout Style 2', 'medicenter');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row][vc_column width="1/4"][vc_wp_custommenu nav_menu="63" el_class="vertical-menu"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-home-right-style-2"][announcement_box header="2702 Memory Lane Chicago, IL 60605" bg_image="3750" button_label="CONTACT US" button_url="contact" button_size="large" button_style="light" top_margin="page-margin-top" el_class="style-2 align-center"]Please remember we care about your privacy.[/announcement_box][announcement_box header="In Case of Emergency Call (510) 210-5225" button_label="CONTACT US" button_url="contact" button_size="large" button_style="light" el_class="style-2 align-center margin-top-30"]Please remember we care about your privacy.[/announcement_box][/vc_column][vc_column width="3/4"][vc_row_inner][vc_column_inner width="1/2"][vc_single_image image="3750" img_size="medium-thumb" onclick="link_image"][/vc_column_inner][vc_column_inner width="1/2"][vc_single_image image="3750" img_size="medium-thumb" onclick="link_image"][/vc_column_inner][/vc_row_inner][box_header title="Service Overview" type="h2" bottom_border="1" animation="0" class="large margin-top-30"][vc_column_text el_class="large margin-top-20"]Since its founding we become an integral part of the city, advancing our mission of providing access to compassionate care to our communities. Today patients find care that combines world-class medicine with compassion.[/vc_column_text][vc_column_text]Since its founding we become an integral part of the city, advancing our mission of providing access to compassionate care to our communities. Today patients find care that combines world-class medicine with compassion. Since its founding we become an integral part of the city, advancing our mission of providing access to compassionate care.[/vc_column_text][vc_row_inner top_margin="page-margin-top"][vc_column_inner width="1/2"][box_header title="Terminal service" type="h2" bottom_border="0"][vc_column_text el_class="margin-top-20"]Since its founding we become an integral part of the city, advancing our mission of providing access to compassionate care to our communities. Today patients find care that combines world-class medicine with compassion. Since its founding we become an integral part of the city, advancing our mission of providing access to compassionate care.[/vc_column_text][box_header title="Novelty premium" type="h2" bottom_border="0" class="margin-top-30"][vc_column_text el_class="margin-top-20"]Since its founding we become an integral part of the city, advancing our mission of providing access to compassionate care to our communities. Today patients find care that combines world-class medicine with compassion.[/vc_column_text][/vc_column_inner][vc_column_inner el_class="padding-40-inner" width="1/2" css=".vc_custom_1539953479409{background-color: #f0f0f0 !important;}"][box_header title="Price List of Treatments" bottom_border="1" animation="0"][items_list animation="0" additembutton="" read_more="0" class="margin-top-30"][item type="items" value="$350"]Colonoscopy[/item][item type="items" value="$275"]Gastroscopy[/item][item type="items" value="$175"]Allergy Testing[/item][item type="items" value="$25"]CT Scan[/item][item type="items" value="$50"]Bronchoscopy[/item][item type="items" value="$500"]Colonoscopy[/item][/items_list][/vc_column_inner][/vc_row_inner][vc_row_inner top_margin="page-margin-top-section"][vc_column_inner width="1/2"][features ids="958,961" type="small" headers="1" headers_links="1" read_more="0" icon_links="1"][/vc_column_inner][vc_column_inner width="1/2"][features ids="207,926" type="small" headers="1" headers_links="1" read_more="0" icon_links="1"][/vc_column_inner][/vc_row_inner][vc_row_inner top_margin="page-margin-top-section" el_class="flex-box"][vc_column_inner width="1/3"][info_box title="No Appointment Needed" icon="medical-bed" animation="fadeIn" animation_duration="500" arrow="light" arrow_animation="slideRight" arrow_animation_duration="800" arrow_animation_delay="150"]An appointment is not required in order to receive care. For this reason, patients do not have to plan out when they can come in. Simply walk in and you'll be seen.[/info_box][/vc_column_inner][vc_column_inner width="1/3"][info_box title="Licensed Professionals" icon="dna" animation="slideRight" animation_duration="800" animation_delay="600" arrow="dark" arrow_animation="slideRight" arrow_animation_duration="800" arrow_animation_delay="1050"]Urgent care physicians and nurses offer high-quanlity care. They are licensed and recognized as reputable members of the healthcare industry.[/info_box][/vc_column_inner][vc_column_inner width="1/3"][info_box title="Cost Effective" icon="people" animation="slideRight" animation_duration="800" animation_delay="1500"]The cost of seeing a physician at a medical immediate care facility will be much more affordable than seeing a physician in an emergency room.[/info_box][/vc_column_inner][/vc_row_inner][box_header title="Please call (510) 210-5225" type="h2" bottom_border="1" animation="0" class="large align-center" top_margin="page-margin-top-section"][vc_column_text el_class="large align-center margin-top-20"]Or contact us via email form below[/vc_column_text][medicenter_contact_form header="" animation="0" department_select_box="0" submit_label="SEND MESSAGE" display_first_name="1" first_name_required="1" display_last_name="1" last_name_required="1" display_date="0" display_security_number="0" display_phone="1" phone_label="PHONE NUMBER (OPTIONAL)" phone_required="0" display_email="1" email_required="1" display_message="1" message_label="YOUR MESSAGE" message_required="1" terms_checkbox="0" top_margin="page-margin-top"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
}
if(is_plugin_active("js_composer/js_composer.php") && function_exists("vc_set_default_editor_post_types"))
	add_action("vc_load_default_templates_action", "mc_custom_template_for_vc");
//add new mimes for upload dummy content files (code can be removed after dummy content import)
function mc_custom_upload_files($mimes) 
{
    $mimes = array_merge($mimes, array('xml' => 'application/xml'), array('json' => 'application/json'), array('zip' => 'application/zip'), array('gz' => 'application/x-gzip'), array('ico' => 'image/x-icon'));
    return $mimes;
}
function mc_theme_image_sizes($sizes)
{
	global $themename;
	$addsizes = array(
		"large-thumb" => __("Large thumbnail", 'medicenter'),
		"blog-post-thumb" => __("Blog post thumbnail", 'medicenter'),
		$themename . "-gallery-image" => __("Gallery image", 'medicenter'),
		"medium-thumb" => __("Medium thumbnail", 'medicenter'),
		$themename . "-gallery-thumb-type-1" => __("Gallery thumbnail type 1", 'medicenter'),
		$themename . "-gallery-thumb-type-2" => __("Gallery thumbnail type 2", 'medicenter'),
		$themename . "-vertical-image" => __("Vertical thumbnail", 'medicenter'),
		$themename . "-small-thumb" => __("Small thumbnail", 'medicenter')
	);
	$newsizes = array_merge($sizes, $addsizes);
	return $newsizes;
}
if(!function_exists('_wp_render_title_tag')) 
{
    function mc_theme_slug_render_title() 
	{
		echo ''. wp_title('-', true, 'right') . '';
    }
}
function mc_wp_title_filter($title, $sep)
{
	//$title = get_bloginfo('name') . " | " . (is_home() || is_front_page() ? get_bloginfo('description') : $title);
	return $title;
}
//excerpt
function mc_theme_excerpt_more($more) 
{
	return '';
}
function mc_filter_update_vc_plugin($date) 
{
    if(!empty($date->checked["js_composer/js_composer.php"]))
        unset($date->checked["js_composer/js_composer.php"]);
    if(!empty($date->response["js_composer/js_composer.php"]))
        unset($date->response["js_composer/js_composer.php"]);
    return $date;
}

//Adds a box to the main column on the Services edit screens
function mc_theme_add_ql_services_custom_box() 
{
	add_meta_box( 
        "ql_services_config",
        __("Options", 'medicenter'),
        "mc_theme_inner_ql_services_custom_box_main",
        "ql_services",
		"side",
		"core"
    );
}

function mc_theme_inner_ql_services_custom_box_main($post)
{
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "mc_ql_services_noncename");
	
	//The actual fields for data entry
	$icon = get_post_meta($post->ID, "icon", true);
	$custom_url = get_post_meta($post->ID, "ql_services_custom_url", true);
	echo '
	<table>
		<tr>
			<td>
				<label for="icon">' . __('Icon', 'medicenter') . ':</label>
			</td>
			<td>
				<select style="width: 120px;" id="ql_services_icon" name="ql_services_icon">
					<option value="-"' . (empty($icon) || $icon=="-" ? ' selected="selected"' : '') . '>' . __('none', 'medicenter') . '</option>
					<option class="features-address" value="features-address"' . ($icon=="features-address" ? ' selected="selected"' : '') . '>' . __('address', 'medicenter') . '</option>
					<option class="features-ambulance" value="features-ambulance"' . ($icon=="features-ambulance" ? ' selected="selected"' : '') . '>' . __('ambulance', 'medicenter') . '</option>
					<option class="features-app" value="features-app"' . ($icon=="features-app" ? ' selected="selected"' : '') . '>' . __('app', 'medicenter') . '</option>
					<option class="features-baby" value="features-baby"' . ($icon=="features-baby" ? ' selected="selected"' : '') . '>' . __('baby', 'medicenter') . '</option>
					<option class="features-baby-bed" value="features-baby-bed"' . ($icon=="features-baby-bed" ? ' selected="selected"' : '') . '>' . __('baby-bed', 'medicenter') . '</option>
					<option class="features-baby-bottle" value="features-baby-bottle"' . ($icon=="features-baby-bottle" ? ' selected="selected"' : '') . '>' . __('baby-bottle', 'medicenter') . '</option>
					<option class="features-bacteria" value="features-bacteria"' . ($icon=="features-bacteria" ? ' selected="selected"' : '') . '>' . __('bacteria', 'medicenter') . '</option>
					<option class="features-balance" value="features-balance"' . ($icon=="features-balance" ? ' selected="selected"' : '') . '>' . __('balance', 'medicenter') . '</option>
					<option class="features-battery" value="features-battery"' . ($icon=="features-battery" ? ' selected="selected"' : '') . '>' . __('battery', 'medicenter') . '</option>
					<option class="features-book" value="features-book"' . ($icon=="features-book" ? ' selected="selected"' : '') . '>' . __('book', 'medicenter') . '</option>
					<option class="features-box" value="features-box"' . ($icon=="features-box" ? ' selected="selected"' : '') . '>' . __('box', 'medicenter') . '</option>
					<option class="features-brain" value="features-brain"' . ($icon=="features-brain" ? ' selected="selected"' : '') . '>' . __('brain', 'medicenter') . '</option>
					<option class="features-briefcase" value="features-briefcase"' . ($icon=="features-briefcase" ? ' selected="selected"' : '') . '>' . __('briefcase', 'medicenter') . '</option>
					<option class="features-burns" value="features-burns"' . ($icon=="features-burns" ? ' selected="selected"' : '') . '>' . __('burns', 'medicenter') . '</option>
					<option class="features-cart" value="features-cart"' . ($icon=="features-cart" ? ' selected="selected"' : '') . '>' . __('cart', 'medicenter') . '</option>
					<option class="features-cat" value="features-cat"' . ($icon=="features-cat" ? ' selected="selected"' : '') . '>' . __('cat', 'medicenter') . '</option>
					<option class="features-certificate" value="features-certificate"' . ($icon=="features-certificate" ? ' selected="selected"' : '') . '>' . __('certificate', 'medicenter') . '</option>
					<option class="features-chart" value="features-chart"' . ($icon=="features-chart" ? ' selected="selected"' : '') . '>' . __('chart', 'medicenter') . '</option>
					<option class="features-chat" value="features-chat"' . ($icon=="features-chat" ? ' selected="selected"' : '') . '>' . __('chat', 'medicenter') . '</option>
					<option class="features-clock" value="features-clock"' . ($icon=="features-clock" ? ' selected="selected"' : '') . '>' . __('clock', 'medicenter') . '</option>
					<option class="features-config" value="features-config"' . ($icon=="features-config" ? ' selected="selected"' : '') . '>' . __('config', 'medicenter') . '</option>
					<option class="features-credit-card" value="features-credit-card"' . ($icon=="features-credit-card" ? ' selected="selected"' : '') . '>' . __('credit-card', 'medicenter') . '</option>
					<option class="features-cross" value="features-cross"' . ($icon=="features-cross" ? ' selected="selected"' : '') . '>' . __('cross', 'medicenter') . '</option>
					<option class="features-dental-shield" value="features-dental-shield"' . ($icon=="features-dental-shield" ? ' selected="selected"' : '') . '>' . __('dental-shield', 'medicenter') . '</option>
					<option class="features-dentist" value="features-dentist"' . ($icon=="features-dentist" ? ' selected="selected"' : '') . '>' . __('dentist', 'medicenter') . '</option>
					<option class="features-diary" value="features-diary"' . ($icon=="features-diary" ? ' selected="selected"' : '') . '>' . __('diary', 'medicenter') . '</option>
					<option class="features-dna" value="features-dna"' . ($icon=="features-dna" ? ' selected="selected"' : '') . '>' . __('dna', 'medicenter') . '</option>
					<option class="features-doctor" value="features-doctor"' . ($icon=="features-doctor" ? ' selected="selected"' : '') . '>' . __('doctor', 'medicenter') . '</option>
					<option class="features-document" value="features-document"' . ($icon=="features-document" ? ' selected="selected"' : '') . '>' . __('document', 'medicenter') . '</option>
					<option class="features-document-missing" value="features-document-missing"' . ($icon=="features-document-missing" ? ' selected="selected"' : '') . '>' . __('document-missing', 'medicenter') . '</option>
					<option class="features-dog" value="features-dog"' . ($icon=="features-dog" ? ' selected="selected"' : '') . '>' . __('dog', 'medicenter') . '</option>
					<option class="features-drip" value="features-drip"' . ($icon=="features-drip" ? ' selected="selected"' : '') . '>' . __('drip', 'medicenter') . '</option>
					<option class="features-ear" value="features-ear"' . ($icon=="features-ear" ? ' selected="selected"' : '') . '>' . __('ear', 'medicenter') . '</option>
					<option class="features-email" value="features-email"' . ($icon=="features-email" ? ' selected="selected"' : '') . '>' . __('email', 'medicenter') . '</option>
					<option class="features-eye" value="features-eye"' . ($icon=="features-eye" ? ' selected="selected"' : '') . '>' . __('eye', 'medicenter') . '</option>
					<option class="features-facebook" value="features-facebook"' . ($icon=="features-facebook" ? ' selected="selected"' : '') . '>' . __('facebook', 'medicenter') . '</option>
					<option class="features-first-aid" value="features-first-aid"' . ($icon=="features-first-aid" ? ' selected="selected"' : '') . '>' . __('first-aid', 'medicenter') . '</option>
					<option class="features-fitness" value="features-fitness"' . ($icon=="features-fitness" ? ' selected="selected"' : '') . '>' . __('fitness', 'medicenter') . '</option>
					<option class="features-frostbite" value="features-frostbite"' . ($icon=="features-frostbite" ? ' selected="selected"' : '') . '>' . __('frostbite', 'medicenter') . '</option>
					<option class="features-gallery" value="features-gallery"' . ($icon=="features-gallery" ? ' selected="selected"' : '') . '>' . __('gallery', 'medicenter') . '</option>
					<option class="features-glasses" value="features-glasses"' . ($icon=="features-glasses" ? ' selected="selected"' : '') . '>' . __('glasses', 'medicenter') . '</option>
					<option class="features-graph" value="features-graph"' . ($icon=="features-graph" ? ' selected="selected"' : '') . '>' . __('graph', 'medicenter') . '</option>
					<option class="features-healthcare" value="features-healthcare"' . ($icon=="features-healthcare" ? ' selected="selected"' : '') . '>' . __('healthcare', 'medicenter') . '</option>
					<option class="features-heart" value="features-heart"' . ($icon=="features-heart" ? ' selected="selected"' : '') . '>' . __('heart', 'medicenter') . '</option>
					<option class="features-heart-beat" value="features-heart-beat"' . ($icon=="features-heart-beat" ? ' selected="selected"' : '') . '>' . __('heart-beat', 'medicenter') . '</option>
					<option class="features-home" value="features-home"' . ($icon=="features-home" ? ' selected="selected"' : '') . '>' . __('home', 'medicenter') . '</option>
					<option class="features-hospital" value="features-hospital"' . ($icon=="features-hospital" ? ' selected="selected"' : '') . '>' . __('hospital', 'medicenter') . '</option>
					<option class="features-id" value="features-id"' . ($icon=="features-id" ? ' selected="selected"' : '') . '>' . __('id', 'medicenter') . '</option>
					<option class="features-image" value="features-image"' . ($icon=="features-image" ? ' selected="selected"' : '') . '>' . __('image', 'medicenter') . '</option>
					<option class="features-keyboard" value="features-keyboard"' . ($icon=="features-keyboard" ? ' selected="selected"' : '') . '>' . __('keyboard', 'medicenter') . '</option>
					<option class="features-lab" value="features-lab"' . ($icon=="features-lab" ? ' selected="selected"' : '') . '>' . __('lab', 'medicenter') . '</option>
					<option class="features-laptop" value="features-laptop"' . ($icon=="features-laptop" ? ' selected="selected"' : '') . '>' . __('laptop', 'medicenter') . '</option>
					<option class="features-leaf" value="features-leaf"' . ($icon=="features-leaf" ? ' selected="selected"' : '') . '>' . __('leaf', 'medicenter') . '</option>
					<option class="features-lifeline" value="features-lifeline"' . ($icon=="features-lifeline" ? ' selected="selected"' : '') . '>' . __('lifeline', 'medicenter') . '</option>
					<option class="features-list" value="features-list"' . ($icon=="features-list" ? ' selected="selected"' : '') . '>' . __('list', 'medicenter') . '</option>
					<option class="features-location" value="features-location"' . ($icon=="features-location" ? ' selected="selected"' : '') . '>' . __('location', 'medicenter') . '</option>
					<option class="features-lock" value="features-lock"' . ($icon=="features-lock" ? ' selected="selected"' : '') . '>' . __('lock', 'medicenter') . '</option>
					<option class="features-map" value="features-map"' . ($icon=="features-map" ? ' selected="selected"' : '') . '>' . __('map', 'medicenter') . '</option>
					<option class="features-medical-bed" value="features-medical-bed"' . ($icon=="features-medical-bed" ? ' selected="selected"' : '') . '>' . __('medical-bed', 'medicenter') . '</option>
					<option class="features-medical-cast" value="features-medical-cast"' . ($icon=="features-medical-cast" ? ' selected="selected"' : '') . '>' . __('medical-cast', 'medicenter') . '</option>
					<option class="features-medical-cross" value="features-medical-cross"' . ($icon=="features-medical-cross" ? ' selected="selected"' : '') . '>' . __('medical-cross', 'medicenter') . '</option>
					<option class="features-medical-document" value="features-medical-document"' . ($icon=="features-medical-document" ? ' selected="selected"' : '') . '>' . __('medical-document', 'medicenter') . '</option>
					<option class="features-medical-results" value="features-medical-results"' . ($icon=="features-medical-results" ? ' selected="selected"' : '') . '>' . __('medical-results', 'medicenter') . '</option>
					<option class="features-medical-scissors" value="features-medical-scissors"' . ($icon=="features-medical-scissors" ? ' selected="selected"' : '') . '>' . __('medical-scissors', 'medicenter') . '</option>
					<option class="features-medical-staff" value="features-medical-staff"' . ($icon=="features-medical-staff" ? ' selected="selected"' : '') . '>' . __('medical-staff', 'medicenter') . '</option>
					<option class="features-minus" value="features-minus"' . ($icon=="features-minus" ? ' selected="selected"' : '') . '>' . __('minus', 'medicenter') . '</option>
					<option class="features-mobile" value="features-mobile"' . ($icon=="features-mobile" ? ' selected="selected"' : '') . '>' . __('mobile', 'medicenter') . '</option>
					<option class="features-molecule" value="features-molecule"' . ($icon=="features-molecule" ? ' selected="selected"' : '') . '>' . __('molecule', 'medicenter') . '</option>
					<option class="features-money" value="features-money"' . ($icon=="features-money" ? ' selected="selected"' : '') . '>' . __('money', 'medicenter') . '</option>
					<option class="features-mortar" value="features-mortar"' . ($icon=="features-mortar" ? ' selected="selected"' : '') . '>' . __('mortar', 'medicenter') . '</option>
					<option class="features-movie" value="features-movie"' . ($icon=="features-movie" ? ' selected="selected"' : '') . '>' . __('movie', 'medicenter') . '</option>
					<option class="features-network" value="features-network"' . ($icon=="features-network" ? ' selected="selected"' : '') . '>' . __('network', 'medicenter') . '</option>
					<option class="features-paypal" value="features-paypal"' . ($icon=="features-paypal" ? ' selected="selected"' : '') . '>' . __('paypal', 'medicenter') . '</option>
					<option class="features-pen" value="features-pen"' . ($icon=="features-pen" ? ' selected="selected"' : '') . '>' . __('pen', 'medicenter') . '</option>
					<option class="features-people" value="features-people"' . ($icon=="features-people" ? ' selected="selected"' : '') . '>' . __('people', 'medicenter') . '</option>
					<option class="features-pet-box" value="features-pet-box"' . ($icon=="features-pet-box" ? ' selected="selected"' : '') . '>' . __('pet-box', 'medicenter') . '</option>
					<option class="features-phone" value="features-phone"' . ($icon=="features-phone" ? ' selected="selected"' : '') . '>' . __('phone', 'medicenter') . '</option>
					<option class="features-piano" value="features-piano"' . ($icon=="features-piano" ? ' selected="selected"' : '') . '>' . __('piano', 'medicenter') . '</option>
					<option class="features-pill" value="features-pill"' . ($icon=="features-pill" ? ' selected="selected"' : '') . '>' . __('pill', 'medicenter') . '</option>
					<option class="features-pin" value="features-pin"' . ($icon=="features-pin" ? ' selected="selected"' : '') . '>' . __('pin', 'medicenter') . '</option>
					<option class="features-plaster" value="features-plaster"' . ($icon=="features-plaster" ? ' selected="selected"' : '') . '>' . __('plaster', 'medicenter') . '</option>
					<option class="features-play" value="features-play"' . ($icon=="features-play" ? ' selected="selected"' : '') . '>' . __('play', 'medicenter') . '</option>
					<option class="features-plus" value="features-plus"' . ($icon=="features-plus" ? ' selected="selected"' : '') . '>' . __('plus', 'medicenter') . '</option>
					<option class="features-printer" value="features-printer"' . ($icon=="features-printer" ? ' selected="selected"' : '') . '>' . __('printer', 'medicenter') . '</option>
					<option class="features-pulse" value="features-pulse"' . ($icon=="features-pulse" ? ' selected="selected"' : '') . '>' . __('pulse', 'medicenter') . '</option>
					<option class="features-quote" value="features-quote"' . ($icon=="features-quote" ? ' selected="selected"' : '') . '>' . __('quote', 'medicenter') . '</option>
					<option class="features-science" value="features-science"' . ($icon=="features-science" ? ' selected="selected"' : '') . '>' . __('science', 'medicenter') . '</option>
					<option class="features-screen" value="features-screen"' . ($icon=="features-screen" ? ' selected="selected"' : '') . '>' . __('screen', 'medicenter') . '</option>
					<option class="features-signpost" value="features-signpost"' . ($icon=="features-signpost" ? ' selected="selected"' : '') . '>' . __('signpost', 'medicenter') . '</option>
					<option class="features-spa" value="features-spa"' . ($icon=="features-spa" ? ' selected="selected"' : '') . '>' . __('spa', 'medicenter') . '</option>
					<option class="features-spa-bamboo" value="features-spa-bamboo"' . ($icon=="features-spa-bamboo" ? ' selected="selected"' : '') . '>' . __('spa-bamboo', 'medicenter') . '</option>
					<option class="features-spa-lotion" value="features-spa-lotion"' . ($icon=="features-spa-lotion" ? ' selected="selected"' : '') . '>' . __('spa-lotion', 'medicenter') . '</option>
					<option class="features-speaker" value="features-speaker"' . ($icon=="features-speaker" ? ' selected="selected"' : '') . '>' . __('speaker', 'medicenter') . '</option>
					<option class="features-stethoscope" value="features-stethoscope"' . ($icon=="features-stethoscope" ? ' selected="selected"' : '') . '>' . __('stethoscope', 'medicenter') . '</option>
					<option class="features-syringe" value="features-syringe"' . ($icon=="features-syringe" ? ' selected="selected"' : '') . '>' . __('syringe', 'medicenter') . '</option>
					<option class="features-tablet" value="features-tablet"' . ($icon=="features-tablet" ? ' selected="selected"' : '') . '>' . __('tablet', 'medicenter') . '</option>
					<option class="features-tags" value="features-tags"' . ($icon=="features-tags" ? ' selected="selected"' : '') . '>' . __('tags', 'medicenter') . '</option>
					<option class="features-teddy-bear" value="features-teddy-bear"' . ($icon=="features-teddy-bear" ? ' selected="selected"' : '') . '>' . __('teddy-bear', 'medicenter') . '</option>
					<option class="features-test-tube" value="features-test-tube"' . ($icon=="features-test-tube" ? ' selected="selected"' : '') . '>' . __('test-tube', 'medicenter') . '</option>
					<option class="features-tick" value="features-tick"' . ($icon=="features-tick" ? ' selected="selected"' : '') . '>' . __('tick', 'medicenter') . '</option>
					<option class="features-time" value="features-time"' . ($icon=="features-time" ? ' selected="selected"' : '') . '>' . __('time', 'medicenter') . '</option>
					<option class="features-toothbrush" value="features-toothbrush"' . ($icon=="features-toothbrush" ? ' selected="selected"' : '') . '>' . __('toothbrush', 'medicenter') . '</option>
					<option class="features-twitter" value="features-twitter"' . ($icon=="features-twitter" ? ' selected="selected"' : '') . '>' . __('twitter', 'medicenter') . '</option>
					<option class="features-video" value="features-video"' . ($icon=="features-video" ? ' selected="selected"' : '') . '>' . __('video', 'medicenter') . '</option>
					<option class="features-wallet" value="features-wallet"' . ($icon=="features-wallet" ? ' selected="selected"' : '') . '>' . __('wallet', 'medicenter') . '</option>
					<option class="features-x-ray" value="features-x-ray"' . ($icon=="features-x-ray" ? ' selected="selected"' : '') . '>' . __('x-ray', 'medicenter') . '</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label>' . __('Custom url:', 'medicenter') . '</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="ql_services_custom_url" name="ql_services_custom_url" value="' . (!empty($custom_url) ? esc_attr($custom_url) : '') . '">
			</td>
		</tr>
	</table>';
}

//When the post is saved, saves our custom data
function mc_theme_save_ql_services_postdata($post_id) 
{
	//verify if this is an auto save routine. 
	//if it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if (!isset($_POST['mc_ql_services_noncename']) || !wp_verify_nonce($_POST['mc_ql_services_noncename'], plugin_basename( __FILE__ )))
		return;


	//Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;

	//OK, we're authenticated: we need to find and save the data
	update_post_meta($post_id, "icon", $_POST["ql_services_icon"]);
	update_post_meta($post_id, "ql_services_custom_url", $_POST["ql_services_custom_url"]);
}

/* --- Theme WooCommerce Custom Filters Functions --- */
function mc_woo_custom_override_pagination_args($args) 
{
	$args['prev_text'] = __('&lsaquo;', 'medicenter');
	$args['next_text'] = __('&rsaquo;', 'medicenter');
	return $args;
}
function mc_woo_custom_cart_button_text() 
{
	return __('ADD TO CART', 'medicenter');
}
if(!function_exists('loop_columns')) 
{
	function mc_woo_custom_loop_columns() 
	{
		return 3; // 3 products per row
	}
}
function mc_woo_custom_product_description_heading() 
{
    return '';
}
function mc_woo_custom_show_page_title()
{
	return false;
}
function mc_loop_shop_per_page($cols)
{
	return 6;
}
function mc_woo_custom_override_checkout_fields($fields) 
{
	$fields['billing']['billing_first_name']['placeholder'] = __("First Name", 'medicenter');
	$fields['billing']['billing_last_name']['placeholder'] = __("Last Name", 'medicenter');
	$fields['billing']['billing_company']['placeholder'] = __("Company Name", 'medicenter');
	$fields['billing']['billing_email']['placeholder'] = __("Email Address", 'medicenter');
	$fields['billing']['billing_phone']['placeholder'] = __("Phone", 'medicenter');
	return $fields;
}
function mc_woo_custom_review_gravatar_size()
{
	return 100;
}

function mc_woocommerce_page_templates($page_templates, $class, $post)
{
	if(is_plugin_active('woocommerce/woocommerce.php'))
	{
		$shop_page_id = wc_get_page_id('shop');
		if($post && absint($shop_page_id) === absint($post->ID))
		{
			$page_templates["path-to-template/full-width.php"] = "Template Name";
		}
	}
 	return $page_templates;
}

function mc_get_time_iso8601() 
{
	$offset = get_option('gmt_offset');
	$timezone = ($offset < 0 ? '-' : '+') . (abs($offset)<10 ? '0'.abs($offset) : abs($offset)) . '00' ;
	return get_the_time('Y-m-d\TH:i:s') . $timezone;					
}

function mc_theme_direction() 
{
	global $wp_locale, $theme_options;
	if(isset($theme_options['direction']) || (isset($_COOKIE["mc_direction"]) && ($_COOKIE["mc_direction"]=="LTR" || $_COOKIE["mc_direction"]=="RTL")))
	{
		if($theme_options['direction']=='default' && empty($_COOKIE["mc_direction"]))
			return;
		$wp_locale->text_direction = ((!empty($theme_options['direction']) && $theme_options['direction']=='rtl') && (empty($_COOKIE["mc_direction"]) || $_COOKIE["mc_direction"]!="LTR")) || (!empty($_COOKIE["mc_direction"]) && $_COOKIE["mc_direction"]=="RTL") ? 'rtl' : 'ltr';
	}
}
add_action("after_setup_theme", "mc_theme_direction");

function mc_get_theme_file($file)
{
	if(file_exists(get_stylesheet_directory() . $file))
        require_once(get_stylesheet_directory() . $file);
    else
        require_once(get_template_directory() . $file);
}

//medicenter get_font_subsets
function mc_ajax_get_font_subsets()
{
	if($_POST["font"]!="")
	{
		$subsets = '';
		$fontExplode = explode(":", $_POST["font"]);
		$subsets_array = mc_get_google_font_subset($fontExplode[0]);
		
		foreach($subsets_array as $subset)
			$subsets .= '<option value="' . esc_attr($subset) . '">' . $subset . '</option>';
		
		echo "mc_start" . $subsets . "mc_end";
	}
	exit();
}
add_action('wp_ajax_medicenter_get_font_subsets', 'mc_ajax_get_font_subsets');

/**
 * Returns array of Google Fonts
 * @return array of Google Fonts
 */
function mc_get_google_fonts()
{
	//get google fonts
	$fontsArray = get_option("medicenter_google_fonts");
	//update if option doesn't exist or it was modified more than 2 weeks ago
	if($fontsArray===FALSE || count((array)$fontsArray)==0 || (time()-$fontsArray->last_update>2*7*24*60*60))
	{
		$google_api_url = 'https://quanticalabs.com/.tools/GoogleFont/font.txt';
		$fontsJson = wp_remote_retrieve_body(wp_remote_get($google_api_url, array('sslverify' => false )));
		$fontsArray = json_decode($fontsJson);
		if(isset($fontsArray))
		{
			$fontsArray->last_update = time();		
			update_option("medicenter_google_fonts", $fontsArray);
		}
	}
	return $fontsArray;
}

/**
 * Returns array of subsets for provided Google Font
 * @param type $font - Google font
 * @return array of subsets for provided Google Font
 */
function mc_get_google_font_subset($font)
{
	$subsets = array();
	//get google fonts
	$fontsArray = mc_get_google_fonts();		
	$fontsCount = count($fontsArray->items);
	for($i=0; $i<$fontsCount; $i++)
	{
		if($fontsArray->items[$i]->family==$font)
		{
			for($j=0, $max=count($fontsArray->items[$i]->subsets); $j<$max; $j++)
			{
				$subsets[] = $fontsArray->items[$i]->subsets[$j];
			}
			break;
		}
	}
	return $subsets;
}
function customize_the_password_form($post)
{
	$post   = get_post( $post );
    $label  = 'pwbox-' . (empty( $post->ID ) ? rand() : $post->ID);
    $output = '<form action="' . esc_url(site_url( 'wp-login.php?action=postpass', 'login_post')) . '" class="post-password-form vc_row" method="post">
		<p>' . __("This content is password protected. To view it please enter your password below:", 'medicenter') . '</p>
		<p>
			<label for="' . $label . '">' . __("Password:", 'medicenter') . ' <input name="post_password" id="' . $label . '" type="password" size="20" /></label>
			<input type="submit" name="Submit" class="more mc-button margin-top-20" value="' . esc_attr_x("Enter", 'post password form', 'medicenter') . '" />
		</p>
	</form>';
	return $output;
}

function mc_get_page_by_title($title, $post_type = "page")
{
	$posts = get_posts(array(
		'post_type' => $post_type,
		'title' => $title,
		'post_status' => 'all',
		'numberposts' => 1
	));
	if(!empty($posts))
	{
		return $posts[0];
	}
	else 
	{
		return null;
	}
}
?>