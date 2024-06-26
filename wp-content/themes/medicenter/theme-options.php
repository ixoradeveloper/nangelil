<?php
global $themename;
//admin menu
function mc_theme_admin_menu() 
{
	add_theme_page(__("Theme Options", 'medicenter') ,__("Theme Options", 'medicenter'), "edit_theme_options", "ThemeOptions", "mc_theme_options");
}
add_action("admin_menu", "mc_theme_admin_menu");

function mc_theme_stripslashes_deep($value)
{
	$value = is_array($value) ?
				array_map('stripslashes_deep', $value) :
				stripslashes($value);

	return $value;
}

function mc_theme_save_options()
{
	if(current_user_can("edit_theme_options"))
	{
		ob_start();
		global $themename;
		$theme_options = array(
			"favicon_url" => $_POST["favicon_url"],
			"logo_url" => $_POST["logo_url"],
			"logo_text" => $_POST["logo_text"],
			"footer_text_left" => $_POST["footer_text_left"],
			"sticky_menu" => (int)$_POST["sticky_menu"],
			"responsive" => (int)$_POST["responsive"],
			"scroll_top" => (int)$_POST["scroll_top"],
			"layout" => $_POST["layout"],
			"layout_picker" => $_POST["layout_picker"],
			"direction" => $_POST["direction"],
			"animations" => $_POST["animations"],
			"collapsible_mobile_submenus" => $_POST["collapsible_mobile_submenus"],
			"google_api_code" => $_POST["google_api_code"],
			"google_recaptcha" => $_POST["google_recaptcha"],
			"google_recaptcha_comments" => $_POST["google_recaptcha_comments"],
			"recaptcha_site_key" => $_POST["recaptcha_site_key"],
			"recaptcha_secret_key" => $_POST["recaptcha_secret_key"],
			"ga_tracking_id" => $_POST["ga_tracking_id"],
			"ga_tracking_code" => $_POST["ga_tracking_code"],
			//"home_page_top_hint" => $_POST["home_page_top_hint"],
			"cf_admin_name" => $_POST["cf_admin_name"],
			"cf_admin_email" => $_POST["cf_admin_email"],
			"cf_admin_name_from" => $_POST["cf_admin_name_from"],
			"cf_admin_email_from" => $_POST["cf_admin_email_from"],
			"cf_smtp_host" => $_POST["cf_smtp_host"],
			"cf_smtp_username" => $_POST["cf_smtp_username"],
			"cf_smtp_password" => $_POST["cf_smtp_password"],
			"cf_smtp_port" => $_POST["cf_smtp_port"],
			"cf_smtp_secure" => $_POST["cf_smtp_secure"],
			"cf_email_subject" => $_POST["cf_email_subject"],
			"cf_template" => $_POST["cf_template"],
			"cf_first_name_message" => $_POST["cf_first_name_message"],
			"cf_last_name_message" => $_POST["cf_last_name_message"],
			"cf_date_message" => $_POST["cf_date_message"],
			"cf_security_number_message" => $_POST["cf_security_number_message"],
			"cf_phone_message" => $_POST["cf_phone_message"],
			"cf_email_message" => $_POST["cf_email_message"],
			"cf_message_message" => $_POST["cf_message_message"],
			"cf_recaptcha_message" => $_POST["cf_recaptcha_message"],
			"cf_terms_message" => $_POST["cf_terms_message"],
			"cf_thankyou_message" => $_POST["cf_thankyou_message"],
			"cf_error_message" => $_POST["cf_error_message"],
			"cf_name_message_comments" => $_POST["cf_name_message_comments"],
			"cf_email_message_comments" => $_POST["cf_email_message_comments"],
			"cf_comment_message_comments" => $_POST["cf_comment_message_comments"],
			"cf_recaptcha_message_comments" => $_POST["cf_recaptcha_message_comments"],
			"cf_terms_message_comments" => $_POST["cf_terms_message_comments"],
			"cf_thankyou_message_comments" => $_POST["cf_thankyou_message_comments"],
			"cf_error_message_comments" => $_POST["cf_error_message_comments"],
			"color_scheme" => $_POST["color_scheme"],
			"primary_color" => $_POST["primary_color"],
			"secondary_color" => $_POST["secondary_color"],
			"tertiary_color" => $_POST["tertiary_color"],
			"site_background_color" => $_POST["site_background_color"],
			"header_background_color" => $_POST["header_background_color"],
			"body_background_color" => $_POST["body_background_color"],
			"footer_background_color" => $_POST["footer_background_color"],
			"copyright_area_background_color" => $_POST["copyright_area_background_color"],
			"link_color" => $_POST["link_color"],
			"link_hover_color" => $_POST["link_hover_color"],
			"footer_link_color" => $_POST["footer_link_color"],
			"footer_link_hover_color" => $_POST["footer_link_hover_color"],
			"body_headers_color" => $_POST["body_headers_color"],
			"body_headers_border_color" => $_POST["body_headers_border_color"],
			"body_text_color" => $_POST["body_text_color"],
			"timeago_label_color" => $_POST["timeago_label_color"],
			"footer_headers_color" => $_POST["footer_headers_color"],
			"footer_headers_border_color" => $_POST["footer_headers_border_color"],
			"footer_text_color" => $_POST["footer_text_color"],
			"footer_timeago_label_color" => $_POST["footer_timeago_label_color"],
			"sentence_color" => $_POST["sentence_color"],
			"quote_color" => $_POST["quote_color"],
			"logo_text_color" => $_POST["logo_text_color"],
			"categories_and_pagination_color" => $_POST["categories_and_pagination_color"],
			"categories_and_pagination_hover_color" => $_POST["categories_and_pagination_hover_color"],
			"categories_and_pagination_border_color" => $_POST["categories_and_pagination_border_color"],
			"categories_and_pagination_border_hover_color" => $_POST["categories_and_pagination_border_hover_color"],
			"categories_and_pagination_background_color" => $_POST["categories_and_pagination_background_color"],
			"categories_and_pagination_hover_background_color" => $_POST["categories_and_pagination_hover_background_color"],
			"light_button_color" => $_POST["light_button_color"],
			"light_button_hover_color" => $_POST["light_button_hover_color"],
			"light_button_border_color" => $_POST["light_button_border_color"],
			"light_button_border_hover_color" => $_POST["light_button_border_hover_color"],
			"light_button_background_color" => $_POST["light_button_background_color"],
			"light_button_hover_background_color" => $_POST["light_button_hover_background_color"],
			"light_color_button_color" => $_POST["light_color_button_color"],
			"light_color_button_hover_color" => $_POST["light_color_button_hover_color"],
			"light_color_button_border_color" => $_POST["light_color_button_border_color"],
			"light_color_button_border_hover_color" => $_POST["light_color_button_border_hover_color"],
			"light_color_button_background_color" => $_POST["light_color_button_background_color"],
			"light_color_button_hover_background_color" => $_POST["light_color_button_hover_background_color"],
			"dark_color_button_color" => $_POST["dark_color_button_color"],
			"dark_color_button_hover_color" => $_POST["dark_color_button_hover_color"],
			"dark_color_button_border_color" => $_POST["dark_color_button_border_color"],
			"dark_color_button_border_hover_color" => $_POST["dark_color_button_border_hover_color"],
			"dark_color_button_background_color" => $_POST["dark_color_button_background_color"],
			"dark_color_button_hover_background_color" => $_POST["dark_color_button_hover_background_color"],
			"scrolling_list_number_color" => $_POST["scrolling_list_number_color"],
			"scrolling_list_number_border_color" => $_POST["scrolling_list_number_border_color"],
			"scrolling_list_number_hover_color" => $_POST["scrolling_list_number_hover_color"],
			"scrolling_list_number_border_hover_color" => $_POST["scrolling_list_number_border_hover_color"],
			"scrolling_list_control_arrow_color" => $_POST["scrolling_list_control_arrow_color"],
			"scrolling_list_control_border_color" => $_POST["scrolling_list_control_border_color"],
			"scrolling_list_control_arrow_hover_color" => $_POST["scrolling_list_control_arrow_hover_color"],
			"scrolling_list_control_arrow_border_hover_color" => $_POST["scrolling_list_control_arrow_border_hover_color"],
			"footer_scrolling_list_control_arrow_color" => $_POST["footer_scrolling_list_control_arrow_color"],
			"footer_scrolling_list_control_border_color" => $_POST["footer_scrolling_list_control_border_color"],
			"footer_scrolling_list_control_arrow_hover_color" => $_POST["footer_scrolling_list_control_arrow_hover_color"],
			"footer_scrolling_list_control_arrow_border_hover_color" => $_POST["footer_scrolling_list_control_arrow_border_hover_color"],
			"menu_position_text_color" => $_POST["menu_position_text_color"],
			"menu_position_hover_text_color" => $_POST["menu_position_hover_text_color"],
			"menu_position_childrens_hover_text_color" => $_POST["menu_position_childrens_hover_text_color"],
			"menu_position_background_color" => $_POST["menu_position_background_color"],
			"menu_position_hover_background_color" => $_POST["menu_position_hover_background_color"],
			"menu_position_childrens_hover_background_color" => $_POST["menu_position_childrens_hover_background_color"],
			"submenu_position_text_color" => $_POST["submenu_position_text_color"],
			"submenu_position_hover_text_color" => $_POST["submenu_position_hover_text_color"],
			"submenu_position_border_color" => $_POST["submenu_position_border_color"],
			"submenu_position_hover_border_color" => $_POST["submenu_position_hover_border_color"],
			"dropdownmenu_background_color" => $_POST["dropdownmenu_background_color"],
			"dropdownmenu_hover_background_color" => $_POST["dropdownmenu_hover_background_color"],
			"dropdownmenu_border_color" => $_POST["dropdownmenu_border_color"],
			"mobile_menu_link_color" => $_POST["mobile_menu_link_color"],
			"mobile_menu_position_background_color" => $_POST["mobile_menu_position_background_color"],
			"mobile_menu_active_link_color" => $_POST["mobile_menu_active_link_color"],
			"mobile_menu_active_position_background_color" => $_POST["mobile_menu_active_position_background_color"],
			"form_field_text_color" => $_POST["form_field_text_color"],
			"form_field_border_color" => $_POST["form_field_border_color"],
			"form_field_background_color" => $_POST["form_field_background_color"],
			"form_button_background_color" => $_POST["form_button_background_color"],
			"form_button_hover_background_color" => $_POST["form_button_hover_background_color"],
			"form_button_text_color" => $_POST["form_button_text_color"],
			"form_button_hover_text_color" => $_POST["form_button_hover_text_color"],
			//"top_hint_background_color" => $_POST["top_hint_background_color"],
			//"top_hint_text_color" => $_POST["top_hint_text_color"],
			"divider_background_color" => $_POST["divider_background_color"],
			"date_box_color" => $_POST["date_box_color"],
			"date_box_text_color" => $_POST["date_box_text_color"],
			"date_box_comments_number_color" => $_POST["date_box_comments_number_color"],
			"date_box_comments_number_text_color" => $_POST["date_box_comments_number_text_color"],
			"gallery_box_color" => $_POST["gallery_box_color"],
			"gallery_box_text_first_line_color" => $_POST["gallery_box_text_first_line_color"],
			"gallery_box_text_second_line_color" => $_POST["gallery_box_text_second_line_color"],
			"gallery_box_hover_color" => $_POST["gallery_box_hover_color"],
			"gallery_box_hover_text_first_line_color" => $_POST["gallery_box_hover_text_first_line_color"],
			"gallery_box_hover_text_second_line_color" => $_POST["gallery_box_hover_text_second_line_color"],
			"gallery_box_border_color" => $_POST["gallery_box_border_color"],
			"gallery_box_hover_border_color" => $_POST["gallery_box_hover_border_color"],
			"gallery_box_control_color" => $_POST["gallery_box_control_color"],
			"gallery_box_control_hover_color" => $_POST["gallery_box_control_hover_color"],
			"timetable_box_color" => $_POST["timetable_box_color"],
			"timetable_box_hover_color" => $_POST["timetable_box_hover_color"],
			"timetable_box_text_color" => $_POST["timetable_box_text_color"],
			"timetable_box_hover_text_color" => $_POST["timetable_box_hover_text_color"],
			"timetable_tip_box_color" => $_POST["timetable_tip_box_color"],
	//		"gallery_details_box_border_color" => $_POST["gallery_details_box_border_color"],
	//		"bread_crumb_border_color" => $_POST["bread_crumb_border_color"],
			"accordion_tab_color" => $_POST["accordion_tab_color"],
			"tabs_text_color" => $_POST["tabs_text_color"],
			"tabs_border_color" => $_POST["tabs_border_color"],
			"tabs_hover_text_color" => $_POST["tabs_hover_text_color"],
			"tabs_border_hover_color" => $_POST["tabs_border_hover_color"],
			"featured_icon_color" => $_POST["featured_icon_color"],
			"featured_icon_background_color" => $_POST["featured_icon_background_color"],
			"light_featured_icon_color" => $_POST["light_featured_icon_color"],
			"light_featured_icon_background_color" => $_POST["light_featured_icon_background_color"],
			"simple_featured_icon_color" => $_POST["simple_featured_icon_color"],
			"social_icon_color" => $_POST["social_icon_color"],
			"social_icon_background_color" => $_POST["social_icon_background_color"],
			"social_icon_hover_color" => $_POST["social_icon_hover_color"],
			"social_icon_hover_background_color" => $_POST["social_icon_hover_background_color"],
			/*"accordion_item_border_color" => $_POST["accordion_item_border_color"],
			"accordion_item_border_hover_color" => $_POST["accordion_item_border_hover_color"],
			"accordion_item_border_active_color" => $_POST["accordion_item_border_active_color"],*/
	//		"comment_reply_button_color" => $_POST["comment_reply_button_color"],
	//		"post_author_link_color" => $_POST["post_author_link_color"],
	//		"contact_details_box_background_color" => $_POST["contact_details_box_background_color"],
			"header_layout_type" => $_POST["header_layout_type"],
			"header_top_sidebar" => $_POST["header_top_sidebar"],
			"header_top_right_sidebar" => $_POST["header_top_right_sidebar"],
			"header_font" => $_POST["header_font"],
			"header_font_subset" => (isset($_POST["header_font_subset"]) ? $_POST["header_font_subset"] : ""),
			"content_font" => $_POST["content_font"],
			"content_font_subset" => (isset($_POST["content_font_subset"]) ? $_POST["content_font_subset"] : ""),
			"blockquote_font" => $_POST["blockquote_font"],
			"blockquote_font_subset" => (isset($_POST["blockquote_font_subset"]) ? $_POST["blockquote_font_subset"] : "")
		);
		update_option($themename . "_options", $theme_options);
		$system_message = ob_get_clean();
		$_POST["system_message"] = $system_message;
		echo json_encode($_POST);
	}
	else
	{
		$result = array(
			"error" => esc_html("Permission denied!", 'medicenter')
		);
		echo json_encode($result);
	}
	exit();
}
add_action('wp_ajax_' . $themename . '_save', 'mc_theme_save_options');

function mc_theme_options() 
{
	global $themename;
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
		"recaptcha_site_key" =>'',
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
	if(isset($_POST["action"]) && $_POST["action"]==$themename . "_save")
	{
	?>
	<div class="updated"> 
		<p>
			<strong>
				<?php _e('Options saved', 'medicenter'); ?>
			</strong>
		</p>
	</div>
	<?php
	}
	//get google fonts
	$fontsArray = mc_get_google_fonts();
	?>
	<form class="theme_options" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post" id="theme-options-panel">
		<div class="header">
			<div class="header_left">
				<h3>
					<a href="<?php echo esc_url(__('https://1.envato.market/quanticalabs-portfolio-themeforest', 'medicenter')); ?>" title="<?php esc_attr_e("QuanticaLabs", 'medicenter'); ?>">
						<?php _e("QuanticaLabs", 'medicenter'); ?>
					</a>
				</h3>
				<h5><?php _e("Theme Options", 'medicenter'); ?></h5>
			</div>
			<div class="header_right">
				<div class="description">
					<h3>
						<a href="<?php echo esc_url(__('https://1.envato.market/medicenter-responsive-medical-wordpress-theme', 'medicenter')); ?>" title="<?php esc_attr_e("MediCenter - Health Medical Theme", 'medicenter'); ?>" rel="nofollow">
							<?php _e("MediCenter - Health Medical Theme", 'medicenter'); ?>
						</a>
					</h3>
					<h5><?php _e("Version 14.5", 'medicenter'); ?></h5>
					<a class="description_link" target="_blank" href="<?php echo esc_url(get_template_directory_uri() . '/documentation/index.html'); ?>"><?php _e("Documentation", 'medicenter'); ?></a>
					<a class="description_link" target="_blank" href="<?php echo esc_url(__('https://support.quanticalabs.com', 'medicenter')); ?>"><?php _e("Support Forum", 'medicenter'); ?></a>
					<a class="description_link" target="_blank" href="<?php echo esc_url(__('https://1.envato.market/medicenter-responsive-medical-wordpress-theme', 'medicenter')); ?>" rel="nofollow"><?php _e("Theme site", 'medicenter'); ?></a>
				</div>
				<a class="logo" href="<?php echo esc_url(__('https://1.envato.market/quanticalabs-portfolio-themeforest', 'medicenter')); ?>" title="<?php esc_attr_e("QuanticaLabs", 'medicenter'); ?>">
					&nbsp;
				</a>
			</div>
		</div>
		<div class="content clearfix">
			<ul class="menu">
				<li>
					<a href='#tab-main' class="selected">
						<span class="dashicons dashicons-hammer"></span>
						<?php _e('Main', 'medicenter'); ?>
					</a>
				</li>
				<li>
					<a href="#tab-contact-form">
						<span class="dashicons dashicons-email-alt"></span>
						<?php _e('Contact Form', 'medicenter'); ?>
					</a>
				</li>
				<li>
					<a href="#tab-colors">
						<span class="dashicons dashicons-art"></span>
						<?php _e('Colors', 'medicenter'); ?>
					</a>
					<ul class="submenu">
						<li>
							<a href="#tab-colors_general">
								<?php _e('General', 'medicenter'); ?>
							</a>
						</li>
						<li>
							<a href="#tab-colors_text">
								<?php _e('Text', 'medicenter'); ?>
							</a>
						</li>
						<li>
							<a href="#tab-colors_buttons">
								<?php _e('Buttons', 'medicenter'); ?>
							</a>
						</li>
						<li>
							<a href="#tab-colors_menu">
								<?php _e('Menu', 'medicenter'); ?>
							</a>
						</li>
						<li>
							<a href="#tab-colors_forms">
								<?php _e('Forms', 'medicenter'); ?>
							</a>
						</li>
						<li>
							<a href="#tab-colors_miscellaneous">
								<?php _e('Miscellaneous', 'medicenter'); ?>
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#tab-header">
						<span class="dashicons dashicons-welcome-widgets-menus"></span>
						<?php _e('Header', 'medicenter'); ?>
					</a>
				</li>
				<li>
					<a href="#tab-fonts">
						<span class="dashicons dashicons-editor-textcolor"></span>
						<?php _e('Fonts', 'medicenter'); ?>
					</a>
				</li>
			</ul>
			<div id="tab-main" class="settings" style="display: block;">
				<h3><?php _e('Main', 'medicenter'); ?></h3>
				<ul class="form_field_list">
					<?php
					if(is_plugin_active('ql_importer/ql_importer.php'))
					{
					?>
					<li>
						<label for="import_dummy"><?php _e('DUMMY CONTENT IMPORT', 'medicenter'); ?></label>
						<select id="import_dummy_demo" name="import_dummy_demo">
							<optgroup label="Full demos">
								<option value="main"><?php _e('Main Demo', 'medicenter'); ?></option>
								<option value="pregnancy"><?php _e('Pregnancy Demo', 'medicenter'); ?></option>
								<option value="ophthalmologist"><?php _e('Ophthalmologist Demo', 'medicenter'); ?></option>
								<option value="veterinary"><?php _e('Veterinary Demo', 'medicenter'); ?></option>
								<option value="dentist"><?php _e('Dentist Demo', 'medicenter'); ?></option>
							</optgroup>
							<optgroup label="Home pages">
								<option value="pregnancy_home"><?php _e('Pregnancy (Home Page Only)', 'medicenter'); ?></option>
								<option value="ophthalmologist_home"><?php _e('Ophthalmologist (Home Page Only)', 'medicenter'); ?></option>
								<option value="veterinary_home"><?php _e('Veterinary (Home Page Only)', 'medicenter'); ?></option>
								<option value="dentist_home"><?php _e('Dentist (Home Page Only)', 'medicenter'); ?></option>
							</optgroup>
						</select>
						<input type="button" class="button" name="<?php echo esc_attr($themename);?>_import_dummy" id="import_dummy" value="<?php esc_attr_e('Import dummy content', 'medicenter'); ?>" />
						<img id="dummy_content_preloader" src="<?php echo esc_url(get_template_directory_uri() . '/admin/images/ajax-loader.gif'); ?>" />
						<img id="dummy_content_tick" src="<?php echo esc_url(get_template_directory_uri() . '/admin/images/tick.png'); ?>" />
						<div id="dummy_content_info"></div>
						<div class="clearfix"></div>
					</li>
					<?php
					if(is_plugin_active('woocommerce/woocommerce.php')):
					?>
					<li>
						<label for="import_shop_dummy"><?php _e('DUMMY SHOP CONTENT IMPORT', 'medicenter'); ?></label>
						<input type="button" class="button" name="<?php echo esc_attr($themename);?>_import_shop_dummy" id="import_shop_dummy" value="<?php esc_attr_e('Import shop dummy content', 'medicenter'); ?>" />
						<img id="dummy_shop_content_preloader" src="<?php echo esc_url(get_template_directory_uri() . '/admin/images/ajax-loader.gif'); ?>" />
						<img id="dummy_shop_content_tick" src="<?php echo esc_url(get_template_directory_uri() . '/admin/images/tick.png'); ?>" />
						<div id="dummy_shop_content_info"></div>
					</li>
					<?php
					endif;
					}
					else
					{
					?>
					<li>
						<label for="import_dummy"><?php _e('DUMMY CONTENT IMPORT', 'medicenter'); ?></label>
						<label class="small_label"><?php printf(__('Please <a href="%s" title="Install Plugins">install and activate</a> Theme Dummy Content Importer plugin to enable dummy content import option.', 'medicenter'), menu_page_url('install-required-plugins', false)); ?></label>
					</li>
					<?php
					}
					?>
					<li>
						<label for="favicon_url"><?php _e('FAVICON URL', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo (isset($theme_options["favicon_url"]) ? esc_attr($theme_options["favicon_url"]) : ""); ?>" id="favicon_url" name="favicon_url">
							<input type="button" class="button" name="<?php echo esc_attr($themename);?>_upload_button" id="favicon_url_upload_button" value="<?php esc_attr_e('Insert favicon', 'medicenter'); ?>" />
						</div>
					</li>
					<li>
						<label for="logo_url"><?php _e('LOGO URL', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo isset($theme_options["logo_url"]) ? esc_attr($theme_options["logo_url"]) : ""; ?>" id="logo_url" name="logo_url">
							<input type="button" class="button" name="<?php echo esc_attr($themename);?>_upload_button" id="logo_url_upload_button" value="<?php esc_attr_e('Insert logo', 'medicenter'); ?>" />
						</div>
					</li>
					<li>
						<label for="logo_text"><?php _e('LOGO TEXT', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo isset($theme_options["logo_text"]) ? esc_attr($theme_options["logo_text"]) : ""; ?>" id="logo_text" name="logo_text">
						</div>
					</li>
					<li>
						<label for="footer_text_left"><?php _e('FOOTER COPYRIGHT TEXT', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo isset($theme_options["footer_text_left"]) ? esc_attr($theme_options["footer_text_left"]) : ""; ?>" id="footer_text_left" name="footer_text_left">
						</div>
					</li>
					<li>
						<label for="sticky_menu"><?php _e('STICKY MENU', 'medicenter'); ?></label>
						<div>
							<select id="sticky_menu" name="sticky_menu">
								<option value="0"<?php echo (isset($theme_options["sticky_menu"]) && (int)$theme_options["sticky_menu"]==0 ? " selected='selected'" : "") ?>><?php _e('no', 'medicenter'); ?></option>
								<option value="1"<?php echo (isset($theme_options["sticky_menu"]) && (int)$theme_options["sticky_menu"]==1 ? " selected='selected'" : "") ?>><?php _e('yes', 'medicenter'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="responsive"><?php _e('RESPONSIVE', 'medicenter'); ?></label>
						<div>
							<select id="responsive" name="responsive">
								<option value="1"<?php echo (isset($theme_options["responsive"]) && (int)$theme_options["responsive"]==1 ? " selected='selected'" : "") ?>><?php _e('yes', 'medicenter'); ?></option>
								<option value="0"<?php echo (isset($theme_options["responsive"]) && (int)$theme_options["responsive"]==0 ? " selected='selected'" : "") ?>><?php _e('no', 'medicenter'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="scroll_top"><?php _e('SCROLL TO TOP ICON', 'medicenter'); ?></label>
						<div>
							<select id="scroll_top" name="scroll_top">
								<option value="1"<?php echo ((int)$theme_options["scroll_top"]==1 ? " selected='selected'" : "") ?>><?php _e('yes', 'medicenter'); ?></option>
								<option value="0"<?php echo ((int)$theme_options["scroll_top"]==0 ? " selected='selected'" : "") ?>><?php _e('no', 'medicenter'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="layout"><?php _e('LAYOUT', 'medicenter'); ?></label>
						<div>
							<select id="layout" name="layout">
								<option value="fullwidth"<?php echo (isset($theme_options["layout"]) && $theme_options["layout"]=="fullwidth" ? " selected='selected'" : "") ?>><?php _e('full width', 'medicenter'); ?></option>
								<option value="boxed"<?php echo (isset($theme_options["layout"]) && $theme_options["layout"]=="boxed" ? " selected='selected'" : "") ?>><?php _e('boxed', 'medicenter'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="layout_picker"><?php _e('SHOW STYLE SELECTOR', 'medicenter'); ?></label>
						<div>
							<select id="layout_picker" name="layout_picker">
								<option value="0"<?php echo (isset($theme_options["layout_picker"]) && !(int)$theme_options["layout_picker"] ? " selected='selected'" : "") ?>><?php _e('no', 'medicenter'); ?></option>
								<option value="1"<?php echo (isset($theme_options["layout_picker"]) && (int)$theme_options["layout_picker"] ? " selected='selected'" : "") ?>><?php _e('yes', 'medicenter'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="direction"><?php _e('Direction', 'medicenter'); ?></label>
						<div>
							<select id="direction" name="direction">
								<option value="default" <?php echo (isset($theme_options["direction"]) && $theme_options["direction"]=="default" ? " selected='selected'" : "") ?>><?php _e('Default', 'medicenter'); ?></option>
								<option value="ltr" <?php echo (isset($theme_options["direction"]) && $theme_options["direction"]=="ltr" ? " selected='selected'" : "") ?>><?php _e('LTR', 'medicenter'); ?></option>
								<option value="rtl" <?php echo (isset($theme_options["direction"]) && $theme_options["direction"]=="rtl" ? " selected='selected'" : "") ?>><?php _e('RTL', 'medicenter'); ?></option>	
							</select>
						</div>
					</li>
					<li>
						<label for="animations"><?php _e('Animations', 'medicenter'); ?></label>
						<div>
							<select id="animations" name="animations">
								<option value="1" <?php echo (isset($theme_options["animations"]) && (int)$theme_options["animations"]==1 ? " selected='selected'" : "") ?>><?php _e('enabled', 'medicenter'); ?></option>
								<option value="0" <?php echo (isset($theme_options["animations"]) && (int)$theme_options["animations"]==0 ? " selected='selected'" : "") ?>><?php _e('disabled', 'medicenter'); ?></option>	
							</select>
						</div>
					</li>
					<li>
						<label for="collapsible_mobile_submenus"><?php _e('Collapsible mobile submenus', 'medicenter'); ?></label>
						<div>
							<select id="collapsible_mobile_submenus" name="collapsible_mobile_submenus">
								<option value="1"<?php echo (!isset($theme_options["collapsible_mobile_submenus"]) || (int)$theme_options["collapsible_mobile_submenus"]==1 ? " selected='selected'" : "") ?>><?php _e('yes', 'medicenter'); ?></option>
								<option value="0"<?php echo ((int)$theme_options["collapsible_mobile_submenus"]==0 ? " selected='selected'" : "") ?>><?php _e('no', 'medicenter'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="google_recaptcha"><?php _e('Use reCaptcha in contact forms', 'medicenter'); ?></label>
						<div>
							<select id="google_recaptcha" name="google_recaptcha">
								<option value="0"<?php echo (!(int)$theme_options["google_recaptcha"] ? " selected='selected'" : "") ?>><?php _e('no', 'medicenter'); ?></option>
								<option value="1"<?php echo ((int)$theme_options["google_recaptcha"] ? " selected='selected'" : "") ?>><?php _e('yes', 'medicenter'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="google_recaptcha_comments"><?php _e('Use reCaptcha in comment forms', 'medicenter'); ?></label>
						<div>
							<select id="google_recaptcha_comments" name="google_recaptcha_comments">
								<option value="0"<?php echo (!(int)$theme_options["google_recaptcha_comments"] ? " selected='selected'" : "") ?>><?php _e('no', 'medicenter'); ?></option>
								<option value="1"<?php echo ((int)$theme_options["google_recaptcha_comments"] ? " selected='selected'" : "") ?>><?php _e('yes', 'medicenter'); ?></option>
							</select>
						</div>
					</li>
					<li class="google-recaptcha-depends<?php echo (!(int)$theme_options["google_recaptcha"] ? ' hidden' : ''); ?>">
						<label for="recaptcha_site_key"><?php _e('Google reCaptcha Site key', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["recaptcha_site_key"]); ?>" id="recaptcha_site_key" name="recaptcha_site_key">
							<label class="small_label"><?php printf(__('You can generate reCaptcha keys <a href="%s" target="_blank" title="Get reCaptcha keys">here</a>', 'medicenter'), "https://www.google.com/recaptcha/admin"); ?></label>
						</div>
					</li>
					<li class="google-recaptcha-depends"<?php echo (!(int)$theme_options["google_recaptcha"] ? ' hidden' : ''); ?>>
						<label for="recaptcha_secret_key"><?php _e('Google reCaptcha Secret key', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["recaptcha_secret_key"]); ?>" id="recaptcha_secret_key" name="recaptcha_secret_key">
							<label class="small_label"><?php printf(__('You can generate reCaptcha keys <a href="%s" target="_blank" title="Get reCaptcha keys">here</a>', 'medicenter'), "https://www.google.com/recaptcha/admin"); ?></label>
						</div>
					</li>
					<li>
						<label for="google_api_code"><?php _e('Google Maps API Key', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["google_api_code"]); ?>" id="google_api_code" name="google_api_code">
							<label class="small_label"><?php printf(__('You can generate API Key <a href="%s" target="_blank" title="Generate API Key">here</a>', 'medicenter'), "https://developers.google.com/maps/documentation/javascript/get-api-key"); ?></label>
						</div>
					</li>
					<li>
						<label for="ga_tracking_id"><?php _e('Google Analytics tracking id', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["ga_tracking_id"]); ?>" id="ga_tracking_id" name="ga_tracking_id">
							<label class="small_label"><?php esc_html_e('Tracking id format: UA-XXXXXXXX-XX', 'medicenter'); ?></label>
						</div>
					</li>
					<li>
						<label for="ga_tracking_code"><?php _e('Google Analytics tracking code', 'medicenter'); ?></label>
						<div>
							<textarea id="ga_tracking_code" name="ga_tracking_code"><?php echo (isset($theme_options["ga_tracking_code"]) ? esc_attr($theme_options["ga_tracking_code"]) : ""); ?></textarea>
							<label class="small_label"><?php esc_html_e('Optional. If tracking id has been provided, tracking code is not required.', 'medicenter'); ?></label>									
						</div>
					</li>
				</ul>
			</div>
			<div id="tab-contact-form" class="settings">
				<h3><?php _e('Contact Form', 'medicenter'); ?></h3>
				<h4><?php _e('ADMIN EMAIL CONFIG', 'medicenter');	?></h4>
				<ul class="form_field_list">
					<li>
						<label for="cf_admin_name"><?php _e('NAME (SEND TO)', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_admin_name"]); ?>" id="cf_admin_name" name="cf_admin_name">
						</div>
					</li>
					<li>
						<label for="cf_admin_email"><?php _e('EMAIL (SEND TO)', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_admin_email"]); ?>" id="cf_admin_email" name="cf_admin_email">
						</div>
					</li>
					<li>
						<label for="cf_admin_name_from"><?php _e('NAME (SEND FROM) - OPTIONAL', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_admin_name_from"]); ?>" id="cf_admin_name_from" name="cf_admin_name_from">
							<label class="small_label"><?php esc_html_e("If not set, 'NAME (SEND TO)' will be used", 'medicenter'); ?></label>
						</div>
					</li>
					<li>
						<label for="cf_admin_email_from"><?php _e('EMAIL (SEND FROM) - OPTIONAL', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_admin_email_from"]); ?>" id="cf_admin_email_from" name="cf_admin_email_from">
							<label class="small_label"><?php esc_html_e("If not set, 'EMAIL (SEND TO)' will be used", 'medicenter'); ?></label>
						</div>
					</li>
				</ul>
				<h4><?php _e('ADMIN SMTP CONFIG (OPTIONAL)', 'medicenter'); ?></h4>
				<ul class="form_field_list">
					<li>
						<label for="cf_smtp_host"><?php _e('HOST', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo (isset($theme_options["cf_smtp_host"]) ? esc_attr($theme_options["cf_smtp_host"]) : ""); ?>" id="cf_smtp_host" name="cf_smtp_host">
						</div>
					</li>
					<li>
						<label for="cf_smtp_username"><?php _e('USERNAME', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo (isset($theme_options["cf_smtp_username"]) ? esc_attr($theme_options["cf_smtp_username"]) : ""); ?>" id="cf_smtp_username" name="cf_smtp_username">
						</div>
					</li>
					<li>
						<label for="cf_smtp_password"><?php _e('PASSWORD', 'medicenter'); ?></label>
						<div>
							<input type="password" class="regular-text" value="<?php echo (isset($theme_options["cf_smtp_password"]) ? esc_attr($theme_options["cf_smtp_password"]) : ""); ?>" id="cf_smtp_password" name="cf_smtp_password">
						</div>
					</li>
					<li>
						<label for="cf_smtp_port"><?php _e('PORT', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo (isset($theme_options["cf_smtp_port"]) ? esc_attr($theme_options["cf_smtp_port"]) : ""); ?>" id="cf_smtp_port" name="cf_smtp_port">
						</div>
					</li>
					<li>
						<label for="cf_smtp_secure"><?php _e('SMTP SECURE', 'medicenter'); ?></label>
						<div>
							<select id="cf_smtp_secure" name="cf_smtp_secure">
								<option value=""<?php echo (isset($theme_options["cf_smtp_secure"]) && $theme_options["cf_smtp_secure"]=="" ? " selected='selected'" : "") ?>>-</option>
								<option value="ssl"<?php echo (isset($theme_options["cf_smtp_secure"]) && $theme_options["cf_smtp_secure"]=="ssl" ? " selected='selected'" : "") ?>><?php _e('ssl', 'medicenter'); ?></option>
								<option value="tls"<?php echo (isset($theme_options["cf_smtp_secure"]) && $theme_options["cf_smtp_secure"]=="tls" ? " selected='selected'" : "") ?>><?php _e('tls', 'medicenter'); ?></option>
							</select>
						</div>
					</li>
				</ul>
				<h4><?php _e('EMAIL CONFIG', 'medicenter'); ?></h4>
				<ul class="form_field_list">
					<li>
						<label for="cf_email_subject"><?php _e('EMAIL SUBJECT', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo (isset($theme_options["cf_email_subject"]) ? esc_attr($theme_options["cf_email_subject"]) : ""); ?>" id="cf_email_subject" name="cf_email_subject">
						</div>
					</li>
					<li>
						<label for="cf_template"><?php _e('TEMPLATE', 'medicenter'); ?></label>
						<div>
							<?php _e('Available shortcodes:', 'medicenter');?><br><strong>[first_name]</strong>, <strong>[last_name]</strong>, <strong>[date]</strong>, <strong>[social_security_number]</strong>, <strong>[phone_number]</strong>, <strong>[email]</strong>, <strong>[message]</strong><br><br>
							<?php wp_editor(isset($theme_options["cf_template"]) ? $theme_options["cf_template"] : "", "cf_template");?>
						</div>
					</li>
				</ul>
				<h4><?php _e('CONTACT FORM MESSAGES', 'medicenter'); ?></h4>
				<ul class="form_field_list">
					<li>
						<label for="cf_first_name_message"><?php _e('First name field required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_first_name_message"]); ?>" id="cf_first_name_message" name="cf_first_name_message">
						</div>
					</li>
					<li>
						<label for="cf_last_name_message"><?php _e('Last name field required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_last_name_message"]); ?>" id="cf_last_name_message" name="cf_last_name_message">
						</div>
					</li>
					<li>
						<label for="cf_date_message"><?php _e('Date of birth field required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_date_message"]); ?>" id="cf_date_message" name="cf_date_message">
						</div>
					</li>
					<li>
						<label for="cf_security_number_message"><?php _e('Security number field required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_security_number_message"]); ?>" id="cf_security_number_message" name="cf_security_number_message">
						</div>
					</li>
					<li>
						<label for="cf_phone_message"><?php _e('Phone field required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_phone_message"]); ?>" id="cf_phone_message" name="cf_phone_message">
						</div>
					</li>
					<li>
						<label for="cf_email_message"><?php _e('Email field required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_email_message"]); ?>" id="cf_email_message" name="cf_email_message">
						</div>
					</li>
					<li>
						<label for="cf_message_message"><?php _e('Message field required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_message_message"]); ?>" id="cf_message_message" name="cf_message_message">
						</div>
					</li>
					<li>
						<label for="cf_recaptcha_message"><?php _e('reCaptcha required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_recaptcha_message"]); ?>" id="cf_recaptcha_message" name="cf_recaptcha_message">
						</div>
					</li>
					<li>
						<label for="cf_terms_message"><?php _e('Terms and conditions checkbox required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_terms_message"]); ?>" id="cf_terms_message" name="cf_terms_message">
						</div>
					</li>
					<li>
						<label for="cf_thankyou_message"><?php _e('Form thank you message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_thankyou_message"]); ?>" id="cf_thankyou_message" name="cf_thankyou_message">
						</div>
					</li>
					<li>
						<label for="cf_error_message"><?php _e('Form error message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_error_message"]); ?>" id="cf_error_message" name="cf_error_message">
						</div>
					</li>
				</ul>
				<h4><?php _e('COMMENTS FORM MESSAGES', 'medicenter'); ?></h4>
				<ul class="form_field_list">
					<li>
						<label for="cf_name_message_comments"><?php _e('Name field required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_name_message_comments"]); ?>" id="cf_name_message_comments" name="cf_name_message_comments">
						</div>
					</li>
					<li>
						<label for="cf_email_message_comments"><?php _e('Email field required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_email_message_comments"]); ?>" id="cf_email_message_comments" name="cf_email_message_comments">
						</div>
					</li>
					<li>
						<label for="cf_comment_message_comments"><?php _e('Comment field required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_comment_message_comments"]); ?>" id="cf_comment_message_comments" name="cf_comment_message_comments">
						</div>
					</li>
					<li>
						<label for="cf_recaptcha_message_comments"><?php _e('reCaptcha required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_recaptcha_message_comments"]); ?>" id="cf_recaptcha_message_comments" name="cf_recaptcha_message_comments">
						</div>
					</li>
					<li>
						<label for="cf_terms_message_comments"><?php _e('Terms and conditions checkbox required message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_terms_message_comments"]); ?>" id="cf_terms_message_comments" name="cf_terms_message_comments">
						</div>
					</li>
					<li>
						<label for="cf_thankyou_message_comments"><?php _e('Form thank you message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_thankyou_message_comments"]); ?>" id="cf_thankyou_message_comments" name="cf_thankyou_message_comments">
						</div>
					</li>
					<li>
						<label for="cf_error_message_comments"><?php _e('Form error message', 'medicenter'); ?></label>
						<div>
							<input type="text" class="regular-text" value="<?php echo esc_attr($theme_options["cf_error_message_comments"]); ?>" id="cf_error_message_comments" name="cf_error_message_comments">
						</div>
					</li>
				</ul>
			</div>
			<div id="tab-colors" class="settings">
				<h3><?php _e('Colors', 'medicenter'); ?></h3>
				<h4><?php _e('COLOR SCHEME', 'medicenter'); ?></h4>
				<ul class="form_field_list">
					<li>
						<label for="primary_color"><?php _e('Primary color', 'medicenter'); ?></label>
						<div>
							<span class="color_preview" style="background-color: #<?php echo ($theme_options["primary_color"]!="" ? esc_attr($theme_options["primary_color"]) : '42B3E5'); ?>;"></span>
							<input type="text" class="regular-text color short margin_top_0" value="<?php echo esc_attr($theme_options["primary_color"]); ?>" id="primary_color" name="primary_color" data-default-color="42B3E5">
						</div>
					</li>
					<li>
						<label for="secondary_color"><?php _e('Secondary color', 'medicenter'); ?></label>
						<div>
							<span class="color_preview" style="background-color: #<?php echo ($theme_options["secondary_color"]!="" ? esc_attr($theme_options["secondary_color"]) : '3156A3'); ?>;"></span>
							<input type="text" class="regular-text color short margin_top_0" value="<?php echo esc_attr($theme_options["secondary_color"]); ?>" id="secondary_color" name="secondary_color" data-default-color="3156A3">
						</div>
					</li>
					<li>
						<label for="tertiary_color"><?php _e('Tertiary color', 'medicenter'); ?></label>
						<div>
							<span class="color_preview" style="background-color: #<?php echo ($theme_options["tertiary_color"]!="" ? esc_attr($theme_options["tertiary_color"]) : '0384CE'); ?>;"></span>
							<input type="text" class="regular-text color short margin_top_0" value="<?php echo esc_attr($theme_options["tertiary_color"]); ?>" id="tertiary_color" name="tertiary_color" data-default-color="0384CE">
						</div>
						<div>
							<br>
							<label class="small_label"><?php _e("Choose predefined color scheme", 'medicenter'); ?></label>
							<ul class="layout_chooser for_main_color clearfix">
								<li>
									<a href="#" class="color_preview" style="background-color: #42B3E5;" data-color="42B3E5" data-color-secondary="3156A3" data-color-tertiary="0384CE">&nbsp;</a>
								</li>
								<li>
									<a href="#" class="color_preview" style="background-color: #7CBA3D;" data-color="7CBA3D" data-color-secondary="008238" data-color-tertiary="43A140">&nbsp;</a>
								</li>
								<li>
									<a href="#" class="color_preview" style="background-color: #FFA800;" data-color="FFA800" data-color-secondary="CB451B" data-color-tertiary="F17800">&nbsp;</a>
								</li>
								<li>
									<a href="#" class="color_preview" style="background-color: #F37548;" data-color="F37548" data-color-secondary="C03427" data-color-tertiary="DB5237">&nbsp;</a>
								</li>
								<li>
									<a href="#" class="color_preview" style="background-color: #00B6CC;" data-color="00B6CC" data-color-secondary="006688" data-color-tertiary="0097B5">&nbsp;</a>
								</li>
								<li>
									<a href="#" class="color_preview" style="background-color: #9187C4;" data-color="9187C4" data-color-secondary="3E4C94" data-color-tertiary="6969B3">&nbsp;</a>
								</li>
							</ul>
							<input type="hidden" name="color_scheme" id="color_scheme" value="<?php echo (!empty($theme_options['color_scheme']) ? esc_attr($theme_options['color_scheme']) : ''); ?>">
						</div>
					</li>
				</ul>
				<?php
				/*<ul class="form_field_list">
					<li>
						<label for="color_scheme"><?php _e('Color scheme', 'medicenter'); ?></label>
						<div>
							<select id="color_scheme" name="color_scheme">
								<option value="blue"<?php echo (isset($theme_options["color_scheme"]) && $theme_options["color_scheme"]=="blue" ? " selected='selected'" : "") ?>><?php _e('blue (default)', 'medicenter'); ?></option>
								<option value="green"<?php echo (isset($theme_options["color_scheme"]) && $theme_options["color_scheme"]=="green" ? " selected='selected'" : "") ?>><?php _e('green', 'medicenter'); ?></option>
								<option value="orange"<?php echo (isset($theme_options["color_scheme"]) && $theme_options["color_scheme"]=="orange" ? " selected='selected'" : "") ?>><?php _e('orange', 'medicenter'); ?></option>
								<option value="red"<?php echo (isset($theme_options["color_scheme"]) && $theme_options["color_scheme"]=="red" ? " selected='selected'" : "") ?>><?php _e('red', 'medicenter'); ?></option>
								<option value="turquoise"<?php echo (isset($theme_options["color_scheme"]) && $theme_options["color_scheme"]=="turquoise" ? " selected='selected'" : "") ?>><?php _e('turquoise', 'medicenter'); ?></option>
								<option value="violet"<?php echo (isset($theme_options["color_scheme"]) && $theme_options["color_scheme"]=="violet" ? " selected='selected'" : "") ?>><?php _e('violet', 'medicenter'); ?></option>
							</select>
						</div>
					</li>
				</ul>*/
				?>
				<div id="tab-colors_general" class="subsettings">
					<h4><?php _e('GENERAL', 'medicenter'); ?></h4>
					<ul class="form_field_list">
						<li>
							<label for="site_background_color"><?php _e('Site background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["site_background_color"]) ? esc_attr($theme_options["site_background_color"]) : 'E5E5E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["site_background_color"]) ? esc_attr($theme_options["site_background_color"]) : ""); ?>" id="site_background_color" name="site_background_color" data-default-color="E5E5E5">
							</div>
						</li>
						<li>
							<label for="header_background_color"><?php _e('Header background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["header_background_color"]) ? esc_attr($theme_options["header_background_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["header_background_color"]) ? esc_attr($theme_options["header_background_color"]) : ""); ?>" id="header_background_color" name="header_background_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="body_background_color"><?php _e('Body background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["body_background_color"]) ? esc_attr($theme_options["body_background_color"]) : 'F8F8F8'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["body_background_color"]) ? esc_attr($theme_options["body_background_color"]) : ""); ?>" id="body_background_color" name="body_background_color" data-default-color="F8F8F8">
							</div>
						</li>
						<li>
							<label for="footer_background_color"><?php _e('Footer background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["footer_background_color"]) ? esc_attr($theme_options["footer_background_color"]) : '2E3033'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["footer_background_color"]) ? esc_attr($theme_options["footer_background_color"]) : ""); ?>" id="footer_background_color" name="footer_background_color" data-default-color="2e3033">
							</div>
						</li>
						<li>
							<label for="copyright_area_background_color"><?php _e('Copyright area background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["copyright_area_background_color"]) ? esc_attr($theme_options["copyright_area_background_color"]) : '151515'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["copyright_area_background_color"]) ? esc_attr($theme_options["copyright_area_background_color"]) : ""); ?>" id="copyright_area_background_color" name="copyright_area_background_color" data-default-color="151515">
							</div>
						</li>
						<li>
							<label for="link_color"><?php _e('Link color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["link_color"]) ? esc_attr($theme_options["link_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["link_color"]) ? esc_attr($theme_options["link_color"]) : ""); ?>" id="link_color" name="link_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="link_hover_color"><?php _e('Link hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["link_hover_color"]) ? esc_attr($theme_options["link_hover_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["link_hover_color"]) ? esc_attr($theme_options["link_hover_color"]) : ""); ?>" id="link_hover_color" name="link_hover_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="footer_link_color"><?php _e('Footer link color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["footer_link_color"]) ? esc_attr($theme_options["footer_link_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["footer_link_color"]) ? esc_attr($theme_options["footer_link_color"]) : ""); ?>" id="footer_link_color" name="footer_link_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="footer_link_hover_color"><?php _e('Footer link hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["footer_link_hover_color"]) ? esc_attr($theme_options["footer_link_hover_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["footer_link_hover_color"]) ? esc_attr($theme_options["footer_link_hover_color"]) : ""); ?>" id="link_hover_color" name="footer_link_hover_color" data-default-color="FFFFFF">
							</div>
						</li>
					</ul>
				</div>
				<div id="tab-colors_text" class="subsettings">
					<h4><?php _e('TEXT', 'medicenter'); ?></h4>
					<ul class="form_field_list">
						<li>
							<label for="body_headers_color"><?php _e('Body headers color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["body_headers_color"]) ? esc_attr($theme_options["body_headers_color"]) : '000000'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["body_headers_color"]) ? esc_attr($theme_options["body_headers_color"]) : ""); ?>" id="body_headers_color" name="body_headers_color" data-default-color="000000">
							</div>
						</li>
						<li>
							<label for="body_headers_border_color"><?php _e('Body headers border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["body_headers_border_color"]) ? esc_attr($theme_options["body_headers_border_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["body_headers_border_color"]) ? esc_attr($theme_options["body_headers_border_color"]) : ""); ?>" id="body_headers_border_color" name="body_headers_border_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
								<span class="description"><?php _e('Enter \'none\' for no border', 'medicenter'); ?></span>
							</div>
						</li>
						<li>
							<label for="body_text_color"><?php _e('Body text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["body_text_color"]) ? esc_attr($theme_options["body_text_color"]) : '666666'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["body_text_color"]) ? esc_attr($theme_options["body_text_color"]) : ""); ?>" id="body_text_color" name="body_text_color" data-default-color="666666">
							</div>
						</li>
						<li>
							<label for="timeago_label_color"><?php _e('Timeago label color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["timeago_label_color"]) ? esc_attr($theme_options["timeago_label_color"]) : '999999'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["timeago_label_color"]) ? esc_attr($theme_options["timeago_label_color"]) : ""); ?>" id="timeago_label_color" name="timeago_label_color" data-default-color="999999">
							</div>
						</li>
						<li>
							<label for="footer_headers_color"><?php _e('Footer headers color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["footer_headers_color"]) ? esc_attr($theme_options["footer_headers_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["footer_headers_color"]) ? esc_attr($theme_options["footer_headers_color"]) : ""); ?>" id="footer_headers_color" name="footer_headers_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="footer_headers_border_color"><?php _e('Footer headers border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["footer_headers_border_color"]) ? esc_attr($theme_options["footer_headers_border_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["footer_headers_border_color"]) ? esc_attr($theme_options["footer_headers_border_color"]) : ""); ?>" id="footer_headers_border_color" name="footer_headers_border_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
								<span class="description"><?php _e('Enter \'none\' for no border', 'medicenter'); ?></span>
							</div>
						</li>
						<li>
							<label for="footer_text_color"><?php _e('Footer text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["footer_text_color"]) ? esc_attr($theme_options["footer_text_color"]) : 'BAC0C5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["footer_text_color"]) ? esc_attr($theme_options["footer_text_color"]) : ""); ?>" id="footer_text_color" name="footer_text_color" data-default-color="BAC0C5">
							</div>
						</li>
						<li>
							<label for="footer_timeago_label_color"><?php _e('Footer timeago label color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["footer_timeago_label_color"]) ? esc_attr($theme_options["footer_timeago_label_color"]) : '686F78'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["footer_timeago_label_color"]) ? esc_attr($theme_options["footer_timeago_label_color"]) : ""); ?>" id="footer_timeago_label_color" name="footer_timeago_label_color" data-default-color="686F78">
							</div>
						</li>
						<li>
							<label for="sentence_color"><?php _e('Sentence color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["sentence_color"]) ? esc_attr($theme_options["sentence_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["sentence_color"]) ? esc_attr($theme_options["sentence_color"]) : ""); ?>" id="sentence_color" name="sentence_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="quote_color"><?php _e('Quote color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["quote_color"]) ? esc_attr($theme_options["quote_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["quote_color"]) ? esc_attr($theme_options["quote_color"]) : ""); ?>" id="quote_color" name="quote_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="logo_text_color"><?php _e('Logo text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["logo_text_color"]) ? esc_attr($theme_options["logo_text_color"]) : '000000'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["logo_text_color"]) ? esc_attr($theme_options["logo_text_color"]) : ""); ?>" id="logo_text_color" name="logo_text_color" data-default-color="000000">
							</div>
						</li>
					</ul>
				</div>
				<div id="tab-colors_buttons" class="subsettings">
					<h4><?php _e('BUTTONS', 'medicenter');?></h4>
					<ul class="form_field_list">
						<li>
							<label for="light_button_color"><?php _e('Light button text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_button_color"]) ? esc_attr($theme_options["light_button_color"]) : '666666'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_button_color"]) ? esc_attr($theme_options["light_button_color"]) : ""); ?>" id="light_button_color" name="light_button_color" data-default-color="666666">
							</div>
						</li>
						<li>
							<label for="light_button_hover_color"><?php _e('Light button text hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_button_hover_color"]) ? esc_attr($theme_options["light_button_hover_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_button_hover_color"]) ? esc_attr($theme_options["light_button_hover_color"]) : ""); ?>" id="light_button_hover_color" name="light_button_hover_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="light_button_border_color"><?php _e('Light button border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_button_border_color"]) ? esc_attr($theme_options["light_button_border_color"]) : 'E5E5E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_button_border_color"]) ? esc_attr($theme_options["light_button_border_color"]) : ""); ?>" id="light_button_border_color" name="light_button_border_color" data-default-color="E5E5E5">
							</div>
						</li>
						<li>
							<label for="light_button_border_hover_color"><?php _e('Light button border hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_button_border_hover_color"]) ? esc_attr($theme_options["light_button_border_hover_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_button_border_hover_color"]) ? esc_attr($theme_options["light_button_border_hover_color"]) : ""); ?>" id="light_button_border_hover_color" name="light_button_border_hover_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="light_button_background_color"><?php _e('Light button background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_button_background_color"]) ? esc_attr($theme_options["light_button_background_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_button_background_color"]) ? esc_attr($theme_options["light_button_background_color"]) : ""); ?>" id="light_button_background_color" name="light_button_background_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="light_button_hover_background_color"><?php _e('Light button hover background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_button_hover_background_color"]) ? esc_attr($theme_options["light_button_hover_background_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_button_hover_background_color"]) ? esc_attr($theme_options["light_button_hover_background_color"]) : ""); ?>" id="light_button_hover_background_color" name="light_button_hover_background_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="light_color_button_color"><?php _e('Light color button text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_color_button_color"]) ? esc_attr($theme_options["light_color_button_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_color_button_color"]) ? esc_attr($theme_options["light_color_button_color"]) : ""); ?>" id="light_color_button_color" name="light_color_button_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="light_color_button_hover_color"><?php _e('Light color button text hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_color_button_hover_color"]) ? esc_attr($theme_options["light_color_button_hover_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_color_button_hover_color"]) ? esc_attr($theme_options["light_color_button_hover_color"]) : ""); ?>" id="light_color_button_hover_color" name="light_color_button_hover_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="light_color_button_border_color"><?php _e('Light color button border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_color_button_border_color"]) ? esc_attr($theme_options["light_color_button_border_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_color_button_border_color"]) ? esc_attr($theme_options["light_color_button_border_color"]) : ""); ?>" id="light_color_button_border_color" name="light_color_button_border_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="light_color_button_border_hover_color"><?php _e('Light color button border hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_color_button_border_hover_color"]) ? esc_attr($theme_options["light_color_button_border_hover_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_color_button_border_hover_color"]) ? esc_attr($theme_options["light_color_button_border_hover_color"]) : ""); ?>" id="light_color_button_border_hover_color" name="light_color_button_border_hover_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="light_color_button_background_color"><?php _e('Light color button background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_color_button_background_color"]) ? esc_attr($theme_options["light_color_button_background_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_color_button_background_color"]) ? esc_attr($theme_options["light_color_button_background_color"]) : ""); ?>" id="light_color_button_background_color" name="light_color_button_background_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="light_color_button_hover_background_color"><?php _e('Light color button hover background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_color_button_hover_background_color"]) ? esc_attr($theme_options["light_color_button_hover_background_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_color_button_hover_background_color"]) ? esc_attr($theme_options["light_color_button_hover_background_color"]) : ""); ?>" id="light_color_button_hover_background_color" name="light_color_button_hover_background_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="dark_color_button_color"><?php _e('Dark color button text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["dark_color_button_color"]) ? esc_attr($theme_options["dark_color_button_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["dark_color_button_color"]) ? esc_attr($theme_options["dark_color_button_color"]) : ""); ?>" id="dark_color_button_color" name="dark_color_button_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="dark_color_button_hover_color"><?php _e('Dark color button text hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["dark_color_button_hover_color"]) ? esc_attr($theme_options["dark_color_button_hover_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["dark_color_button_hover_color"]) ? esc_attr($theme_options["dark_color_button_hover_color"]) : ""); ?>" id="dark_color_button_hover_color" name="dark_color_button_hover_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="dark_color_button_border_color"><?php _e('Dark color button border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["dark_color_button_border_color"]) ? esc_attr($theme_options["dark_color_button_border_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["dark_color_button_border_color"]) ? esc_attr($theme_options["dark_color_button_border_color"]) : ""); ?>" id="dark_color_button_border_color" name="dark_color_button_border_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="dark_color_button_border_hover_color"><?php _e('Dark color button border hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["dark_color_button_border_hover_color"]) ? esc_attr($theme_options["dark_color_button_border_hover_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["dark_color_button_border_hover_color"]) ? esc_attr($theme_options["dark_color_button_border_hover_color"]) : ""); ?>" id="dark_color_button_border_hover_color" name="dark_color_button_border_hover_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="dark_color_button_background_color"><?php _e('Dark color button background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["dark_color_button_background_color"]) ? esc_attr($theme_options["dark_color_button_background_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["dark_color_button_background_color"]) ? esc_attr($theme_options["dark_color_button_background_color"]) : ""); ?>" id="dark_color_button_background_color" name="dark_color_button_background_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="dark_color_button_hover_background_color"><?php _e('Dark color button hover background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["dark_color_button_hover_background_color"]) ? esc_attr($theme_options["dark_color_button_hover_background_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["dark_color_button_hover_background_color"]) ? esc_attr($theme_options["dark_color_button_hover_background_color"]) : ""); ?>" id="dark_color_button_hover_background_color" name="dark_color_button_hover_background_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="categories_and_pagination_color"><?php _e('Categories and pagination text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["categories_and_pagination_color"]) ? esc_attr($theme_options["categories_and_pagination_color"]) : '666666'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["categories_and_pagination_color"]) ? esc_attr($theme_options["categories_and_pagination_color"]) : ""); ?>" id="categories_and_pagination_color" name="categories_and_pagination_color" data-default-color="666666">
							</div>
						</li>
						<li>
							<label for="categories_and_pagination_hover_color"><?php _e('Categories and pagination text hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["categories_and_pagination_hover_color"]) ? esc_attr($theme_options["categories_and_pagination_hover_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["categories_and_pagination_hover_color"]) ? esc_attr($theme_options["categories_and_pagination_hover_color"]) : ""); ?>" id="categories_and_pagination_hover_color" name="categories_and_pagination_hover_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="categories_and_pagination_border_color"><?php _e('Categories and pagination border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["categories_and_pagination_border_color"]) ? esc_attr($theme_options["categories_and_pagination_border_color"]) : 'E0E0E0'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["categories_and_pagination_border_color"]) ? esc_attr($theme_options["categories_and_pagination_border_color"]) : ""); ?>" id="categories_and_pagination_border_color" name="categories_and_pagination_border_color" data-default-color="E5E5E5">
							</div>
						</li>
						<li>
							<label for="categories_and_pagination_border_hover_color"><?php _e('Categories and pagination border hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["categories_and_pagination_border_hover_color"]) ? esc_attr($theme_options["categories_and_pagination_border_hover_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["categories_and_pagination_border_hover_color"]) ? esc_attr($theme_options["categories_and_pagination_border_hover_color"]) : ""); ?>" id="categories_and_pagination_border_hover_color" name="categories_and_pagination_border_hover_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="categories_and_pagination_background_color"><?php _e('Categories and pagination background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["categories_and_pagination_background_color"]) ? esc_attr($theme_options["categories_and_pagination_background_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["categories_and_pagination_background_color"]) ? esc_attr($theme_options["categories_and_pagination_background_color"]) : ""); ?>" id="categories_and_pagination_background_color" name="categories_and_pagination_background_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="categories_and_pagination_hover_background_color"><?php _e('Categories and pagination hover background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["categories_and_pagination_hover_background_color"]) ? esc_attr($theme_options["categories_and_pagination_hover_background_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["categories_and_pagination_hover_background_color"]) ? esc_attr($theme_options["categories_and_pagination_hover_background_color"]) : ""); ?>" id="categories_and_pagination_hover_background_color" name="categories_and_pagination_hover_background_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="scrolling_list_number_color"><?php _e('Scrolling list number color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["scrolling_list_number_color"]) ? esc_attr($theme_options["scrolling_list_number_color"]) : '666666'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["scrolling_list_number_color"]) ? esc_attr($theme_options["scrolling_list_number_color"]) : ""); ?>" id="scrolling_list_number_color" name="scrolling_list_number_color" data-default-color="666666">
							</div>
						</li>
						<li>
							<label for="scrolling_list_number_border_color"><?php _e('Scrolling list number border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["scrolling_list_number_border_color"]) ? esc_attr($theme_options["scrolling_list_number_border_color"]) : 'E5E5E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["scrolling_list_number_border_color"]) ? esc_attr($theme_options["scrolling_list_number_border_color"]) : ""); ?>" id="scrolling_list_number_border_color" name="scrolling_list_number_border_color" data-default-color="E5E5E5">
							</div>
						</li>
						<li>
							<label for="scrolling_list_number_hover_color"><?php _e('Scrolling list number hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["scrolling_list_number_hover_color"]) ? esc_attr($theme_options["scrolling_list_number_hover_color"]) : '000000'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["scrolling_list_number_hover_color"]) ? esc_attr($theme_options["scrolling_list_number_hover_color"]) : ""); ?>" id="scrolling_list_number_hover_color" name="scrolling_list_number_hover_color" data-default-color="000000">
							</div>
						</li>
						<li>
							<label for="scrolling_list_number_border_hover_color"><?php _e('Scrolling list number border hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["scrolling_list_number_border_hover_color"]) ? esc_attr($theme_options["scrolling_list_number_border_hover_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["scrolling_list_number_border_hover_color"]) ? esc_attr($theme_options["scrolling_list_number_border_hover_color"]) : ""); ?>" id="scrolling_list_number_border_hover_color" name="scrolling_list_number_border_hover_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="scrolling_list_control_arrow_color"><?php _e('Scrolling list control arrow color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["scrolling_list_control_arrow_color"]) ? esc_attr($theme_options["scrolling_list_control_arrow_color"]) : '000000'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["scrolling_list_control_arrow_color"]) ? esc_attr($theme_options["scrolling_list_control_arrow_color"]) : ""); ?>" id="scrolling_list_control_arrow_color" name="scrolling_list_control_arrow_color" data-default-color="000000">
							</div>
						</li>
						<li>
							<label for="scrolling_list_control_border_color"><?php _e('Scrolling list control border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["scrolling_list_control_border_color"]) ? esc_attr($theme_options["scrolling_list_control_border_color"]) : 'E5E5E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["scrolling_list_control_border_color"]) ? esc_attr($theme_options["scrolling_list_control_border_color"]) : ""); ?>" id="scrolling_list_control_border_color" name="scrolling_list_control_border_color" data-default-color="E5E5E5">
							</div>
						</li>
						<li>
							<label for="scrolling_list_control_arrow_hover_color"><?php _e('Scrolling list control arrow hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["scrolling_list_control_arrow_hover_color"]) ? esc_attr($theme_options["scrolling_list_control_arrow_hover_color"]) : '000000'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["scrolling_list_control_arrow_hover_color"]) ? esc_attr($theme_options["scrolling_list_control_arrow_hover_color"]) : ""); ?>" id="scrolling_list_control_arrow_hover_color" name="scrolling_list_control_arrow_hover_color" data-default-color="000000">
							</div>
						</li>
						<li>
							<label for="scrolling_list_control_arrow_border_hover_color"><?php _e('Scrolling list control border hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["scrolling_list_control_arrow_border_hover_color"]) ? esc_attr($theme_options["scrolling_list_control_arrow_border_hover_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["scrolling_list_control_arrow_border_hover_color"]) ? esc_attr($theme_options["scrolling_list_control_arrow_border_hover_color"]) : ""); ?>" id="scrolling_list_control_arrow_border_hover_color" name="scrolling_list_control_arrow_border_hover_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="footer_scrolling_list_control_arrow_color"><?php _e('Footer scrolling list control arrow color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["footer_scrolling_list_control_arrow_color"]) ? esc_attr($theme_options["footer_scrolling_list_control_arrow_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["footer_scrolling_list_control_arrow_color"]) ? esc_attr($theme_options["footer_scrolling_list_control_arrow_color"]) : ""); ?>" id="footer_scrolling_list_control_arrow_color" name="footer_scrolling_list_control_arrow_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="footer_scrolling_list_control_border_color"><?php _e('Footer scrolling list control border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["footer_scrolling_list_control_border_color"]) ? esc_attr($theme_options["footer_scrolling_list_control_border_color"]) : '4E545D'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["footer_scrolling_list_control_border_color"]) ? esc_attr($theme_options["footer_scrolling_list_control_border_color"]) : ""); ?>" id="footer_scrolling_list_control_border_color" name="footer_scrolling_list_control_border_color" data-default-color="4E545D">
							</div>
						</li>
						<li>
							<label for="footer_scrolling_list_control_arrow_hover_color"><?php _e('Footer scrolling list control arrow hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["footer_scrolling_list_control_arrow_hover_color"]) ? esc_attr($theme_options["footer_scrolling_list_control_arrow_hover_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["footer_scrolling_list_control_arrow_hover_color"]) ? esc_attr($theme_options["footer_scrolling_list_control_arrow_hover_color"]) : ""); ?>" id="footer_scrolling_list_control_arrow_hover_color" name="footer_scrolling_list_control_arrow_hover_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="footer_scrolling_list_control_arrow_border_hover_color"><?php _e('Footer scrolling list control border hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["footer_scrolling_list_control_arrow_border_hover_color"]) ? esc_attr($theme_options["footer_scrolling_list_control_arrow_border_hover_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["footer_scrolling_list_control_arrow_border_hover_color"]) ? esc_attr($theme_options["footer_scrolling_list_control_arrow_border_hover_color"]) : ""); ?>" id="footer_scrolling_list_control_arrow_border_hover_color" name="footer_scrolling_list_control_arrow_border_hover_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
					</ul>
				</div>
				<div id="tab-colors_menu" class="subsettings">
					<h4><?php _e('MENU', 'medicenter');?></h4>
					<ul class="form_field_list">
						<li>
							<label for="menu_position_text_color"><?php _e('Position text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["menu_position_text_color"]) ? esc_attr($theme_options["menu_position_text_color"]) : '666666'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["menu_position_text_color"]) ? esc_attr($theme_options["menu_position_text_color"]) : ""); ?>" id="menu_position_text_color" name="menu_position_text_color" data-default-color="666666">
							</div>
						</li>
						<li>
							<label for="menu_position_hover_text_color"><?php _e('Position hover text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["menu_position_hover_text_color"]) ? esc_attr($theme_options["menu_position_hover_text_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["menu_position_hover_text_color"]) ? esc_attr($theme_options["menu_position_hover_text_color"]) : ""); ?>" id="menu_position_hover_text_color" name="menu_position_hover_text_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="menu_position_childrens_hover_text_color"><?php _e('Position with childrens hover text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["menu_position_childrens_hover_text_color"]) ? esc_attr($theme_options["menu_position_childrens_hover_text_color"]) : '000000'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["menu_position_childrens_hover_text_color"]) ? esc_attr($theme_options["menu_position_childrens_hover_text_color"]) : ""); ?>" id="menu_position_childrens_hover_text_color" name="menu_position_childrens_hover_text_color" data-default-color="000000">
							</div>
						</li>
						<li>
							<label for="menu_position_background_color"><?php _e('Position background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["menu_position_background_color"]) ? esc_attr($theme_options["menu_position_background_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["menu_position_background_color"]) ? esc_attr($theme_options["menu_position_background_color"]) : ""); ?>" id="menu_position_background_color" name="menu_position_background_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="menu_position_hover_background_color"><?php _e('Position hover background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["menu_position_hover_background_color"]) ? esc_attr($theme_options["menu_position_hover_background_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["menu_position_hover_background_color"]) ? esc_attr($theme_options["menu_position_hover_background_color"]) : ""); ?>" id="menu_position_hover_background_color" name="menu_position_hover_background_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="menu_position_childrens_hover_background_color"><?php _e('Position with childrens hover background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["menu_position_childrens_hover_background_color"]) ? esc_attr($theme_options["menu_position_childrens_hover_background_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["menu_position_childrens_hover_background_color"]) ? esc_attr($theme_options["menu_position_childrens_hover_background_color"]) : ""); ?>" id="menu_position_childrens_hover_background_color" name="menu_position_childrens_hover_background_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="submenu_position_text_color"><?php _e('Submenu position text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["submenu_position_text_color"]) ? esc_attr($theme_options["submenu_position_text_color"]) : '666666'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["submenu_position_text_color"]) ? esc_attr($theme_options["submenu_position_text_color"]) : ""); ?>" id="menu_position_text_color" name="submenu_position_text_color" data-default-color="666666">
							</div>
						</li>
						<li>
							<label for="submenu_position_hover_text_color"><?php _e('Submenu position hover text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["submenu_position_hover_text_color"]) ? esc_attr($theme_options["submenu_position_hover_text_color"]) : '000000'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["submenu_position_hover_text_color"]) ? esc_attr($theme_options["submenu_position_hover_text_color"]) : ""); ?>" id="submenu_position_hover_text_color" name="submenu_position_hover_text_color" data-default-color="000000">
							</div>
						</li>
						<li>
							<label for="submenu_position_border_color"><?php _e('Submenu position border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["submenu_position_border_color"]) ? esc_attr($theme_options["submenu_position_border_color"]) : 'E5E5E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["submenu_position_border_color"]) ? esc_attr($theme_options["submenu_position_border_color"]) : ""); ?>" id="submenu_position_border_color" name="submenu_position_border_color" data-default-color="E5E5E5">
								<span class="description"><?php _e('Enter \'none\' for no border', 'medicenter'); ?></span>
							</div>
						</li>
						<li>
							<label for="submenu_position_hover_border_color"><?php _e('Submenu position hover border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["submenu_position_hover_border_color"]) ? esc_attr($theme_options["submenu_position_hover_border_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["submenu_position_hover_border_color"]) ? esc_attr($theme_options["submenu_position_hover_border_color"]) : ""); ?>" id="submenu_position_border_color" name="submenu_position_hover_border_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
								<span class="description"><?php _e('Enter \'none\' for no border', 'medicenter'); ?></span>
							</div>
						</li>
						<li>
							<label for="dropdownmenu_background_color"><?php _e('Dropdown menu background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["dropdownmenu_background_color"]) ? esc_attr($theme_options["dropdownmenu_background_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["dropdownmenu_background_color"]) ? esc_attr($theme_options["dropdownmenu_background_color"]) : ""); ?>" id="dropdownmenu_background_color" name="dropdownmenu_background_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="dropdownmenu_hover_background_color"><?php _e('Dropdown menu hover background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["dropdownmenu_hover_background_color"]) ? esc_attr($theme_options["dropdownmenu_hover_background_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["dropdownmenu_hover_background_color"]) ? esc_attr($theme_options["dropdownmenu_hover_background_color"]) : ""); ?>" id="dropdownmenu_hover_background_color" name="dropdownmenu_hover_background_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="dropdownmenu_border_color"><?php _e('Dropdown menu border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["dropdownmenu_border_color"]) ? esc_attr($theme_options["dropdownmenu_border_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["dropdownmenu_border_color"]) ? esc_attr($theme_options["dropdownmenu_border_color"]) : ""); ?>" id="dropdownmenu_border_color" name="dropdownmenu_border_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="mobile_menu_link_color"><?php _e('Mobile menu link color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo !empty($theme_options["mobile_menu_link_color"]) ? esc_attr($theme_options["mobile_menu_link_color"]) : "666666"; ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["mobile_menu_link_color"]); ?>" id="mobile_menu_link_color" name="mobile_menu_link_color" data-default-color="666666">
							</div>
						</li>
						<li>
							<label for="mobile_menu_position_background_color"><?php _e('Mobile menu position background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo !empty($theme_options["mobile_menu_position_background_color"]) ? esc_attr($theme_options["mobile_menu_position_background_color"]) : "FFFFFF"; ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["mobile_menu_position_background_color"]); ?>" id="mobile_menu_position_background_color" name="mobile_menu_position_background_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="mobile_menu_active_link_color"><?php _e('Mobile menu active link color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo !empty($theme_options["mobile_menu_active_link_color"]) ? esc_attr($theme_options["mobile_menu_active_link_color"]) : "FFFFFF"; ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["mobile_menu_active_link_color"]); ?>" id="mobile_menu_active_link_color" name="mobile_menu_active_link_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="mobile_menu_active_position_background_color"><?php _e('Mobile menu active position background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo !empty($theme_options["mobile_menu_active_position_background_color"]) ? esc_attr($theme_options["mobile_menu_active_position_background_color"]) : "42B3E5"; ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["mobile_menu_active_position_background_color"]); ?>" id="mobile_menu_active_position_background_color" name="mobile_menu_active_position_background_color" data-default-color="42B3E5">
							</div>
						</li>
					</ul>
				</div>
				<div id="tab-colors_forms" class="subsettings">
					<h4><?php _e('FORMS', 'medicenter');?></h4>
					<ul class="form_field_list">
						<li>
							<label for="form_field_text_color"><?php _e('Form field text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["form_field_text_color"]) ? esc_attr($theme_options["form_field_text_color"]) : '000000'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["form_field_text_color"]) ? esc_attr($theme_options["form_field_text_color"]) : ""); ?>" id="form_field_text_color" name="form_field_text_color" data-default-color="000000">
							</div>
						</li>
						<li>
							<label for="form_field_border_color"><?php _e('Form field border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: <?php echo (!empty($theme_options["form_field_border_color"]) ? "#" . esc_attr($theme_options["form_field_border_color"]) : 'transparent'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["form_field_border_color"]) ? esc_attr($theme_options["form_field_border_color"]) : ""); ?>" id="form_field_border_color" name="form_field_border_color" data-default-color="transparent">
								<span class="description"><?php _e('Enter \'none\' for no border', 'medicenter'); ?></span>
							</div>
						</li>
						<li>
							<label for="form_field_background_color"><?php _e('Form field background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["form_field_background_color"]) ? esc_attr($theme_options["form_field_background_color"]) : 'F0F0F0'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["form_field_background_color"]) ? esc_attr($theme_options["form_field_background_color"]) : ""); ?>" id="form_field_background_color" name="form_field_background_color" data-default-color="F0F0F0">
							</div>
						</li>
						<li>
							<label for="form_button_background_color"><?php _e('Form button background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["form_button_background_color"]) ? esc_attr($theme_options["form_button_background_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["form_button_background_color"]) ? esc_attr($theme_options["form_button_background_color"]) : ""); ?>" id="form_button_background_color" name="form_button_background_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="form_button_hover_background_color"><?php _e('Form button hover background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["form_button_hover_background_color"]) ? esc_attr($theme_options["form_button_hover_background_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["form_button_hover_background_color"]) ? esc_attr($theme_options["form_button_hover_background_color"]) : ""); ?>" id="form_button_hover_background_color" name="form_button_hover_background_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="form_button_text_color"><?php _e('Form button text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["form_button_text_color"]) ? esc_attr($theme_options["form_button_text_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["form_button_text_color"]) ? esc_attr($theme_options["form_button_text_color"]) : ""); ?>" id="form_button_text_color" name="form_button_text_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="form_button_hover_text_color"><?php _e('Form button hover text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["form_button_hover_text_color"]) ? esc_attr($theme_options["form_button_hover_text_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["form_button_hover_text_color"]) ? esc_attr($theme_options["form_button_hover_text_color"]) : ""); ?>" id="form_button_hover_text_color" name="form_button_hover_text_color" data-default-color="FFFFFF">
							</div>
						</li>
					</ul>
				</div>
				<div id="tab-colors_miscellaneous" class="subsettings">
					<h4><?php _e('MISCELLANEOUS', 'medicenter'); ?></h4>
					<ul class="form_field_list">
						<?php /*<li>
							<label for="top_hint_background_color"><?php _e('Top hint background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["top_hint_background_color"]) ? esc_attr($theme_options["top_hint_background_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["top_hint_background_color"]) ? esc_attr($theme_options["top_hint_background_color"]) : ""); ?>" id="top_hint_background_color" name="top_hint_background_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="top_hint_text_color"><?php _e('Top hint text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["top_hint_text_color"]) ? esc_attr($theme_options["top_hint_text_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["top_hint_text_color"]) ? esc_attr($theme_options["top_hint_text_color"]) : ""); ?>" id="top_hint_text_color" name="top_hint_text_color" data-default-color="FFFFFF">
							</div>
						</li>*/?>
						<li>
							<label for="divider_background_color"><?php _e('Divider background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["divider_background_color"]) ? esc_attr($theme_options["divider_background_color"]) : 'E5E5E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["divider_background_color"]) ? esc_attr($theme_options["divider_background_color"]) : ""); ?>" id="divider_background_color" name="divider_background_color" data-default-color="E5E5E5">
							</div>
						</li>
						<li>
							<label for="date_box_color"><?php _e('Date box background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["date_box_color"]) ? esc_attr($theme_options["date_box_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["date_box_color"]) ? esc_attr($theme_options["date_box_color"]) : ""); ?>" id="date_box_color" name="date_box_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="date_box_text_color"><?php _e('Date box text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["date_box_text_color"]) ? esc_attr($theme_options["date_box_text_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["date_box_text_color"]) ? esc_attr($theme_options["date_box_text_color"]) : ""); ?>" id="date_box_text_color" name="date_box_text_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="date_box_comments_number_color"><?php _e('Date box comments number background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["date_box_comments_number_color"]) ? esc_attr($theme_options["date_box_comments_number_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["date_box_comments_number_color"]) ? esc_attr($theme_options["date_box_comments_number_color"]) : ""); ?>" id="date_box_comments_number_color" name="date_box_comments_number_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="date_box_comments_number_text_color"><?php _e('Date box comments number text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["date_box_comments_number_text_color"]) ? esc_attr($theme_options["date_box_comments_number_text_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["date_box_comments_number_text_color"]) ? esc_attr($theme_options["date_box_comments_number_text_color"]) : ""); ?>" id="date_box_comments_number_text_color" name="date_box_comments_number_text_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="gallery_box_color"><?php _e('Gallery box background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["gallery_box_color"]) ? esc_attr($theme_options["gallery_box_color"]) : 'F0F0F0'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["gallery_box_color"]) ? esc_attr($theme_options["gallery_box_color"]) : ""); ?>" id="gallery_box_color" name="gallery_box_color" data-default-color="F0F0F0">
							</div>
						</li>
						<li>
							<label for="gallery_box_hover_color"><?php _e('Gallery box hover background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["gallery_box_hover_color"]) ? esc_attr($theme_options["gallery_box_hover_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["gallery_box_hover_color"]) ? esc_attr($theme_options["gallery_box_hover_color"]) : ""); ?>" id="gallery_box_hover_color" name="gallery_box_hover_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="gallery_box_text_first_line_color"><?php _e('Gallery box text first line color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["gallery_box_text_first_line_color"]) ? esc_attr($theme_options["gallery_box_text_first_line_color"]) : '000000'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["gallery_box_text_first_line_color"]) ? esc_attr($theme_options["gallery_box_text_first_line_color"]) : ""); ?>" id="gallery_box_text_first_line_color" name="gallery_box_text_first_line_color" data-default-color="000000">
							</div>
						</li>
						<li>
							<label for="gallery_box_text_second_line_color"><?php _e('Gallery box text second line color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["gallery_box_text_second_line_color"]) ? esc_attr($theme_options["gallery_box_text_second_line_color"]) : '666666'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["gallery_box_text_second_line_color"]) ? esc_attr($theme_options["gallery_box_text_second_line_color"]) : ""); ?>" id="gallery_box_text_second_line_color" name="gallery_box_text_second_line_color" data-default-color="666666">
							</div>
						</li>
						<li>
							<label for="gallery_box_hover_text_first_line_color"><?php _e('Gallery box hover text first line color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["gallery_box_hover_text_first_line_color"]) ? esc_attr($theme_options["gallery_box_hover_text_first_line_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["gallery_box_hover_text_first_line_color"]) ? esc_attr($theme_options["gallery_box_hover_text_first_line_color"]) : ""); ?>" id="gallery_box_hover_text_first_line_color" name="gallery_box_hover_text_first_line_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="gallery_box_hover_text_second_line_color"><?php _e('Gallery box hover text second line color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["gallery_box_hover_text_second_line_color"]) ? esc_attr($theme_options["gallery_box_hover_text_second_line_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["gallery_box_hover_text_second_line_color"]) ? esc_attr($theme_options["gallery_box_hover_text_second_line_color"]) : ""); ?>" id="gallery_box_hover_text_second_line_color" name="gallery_box_hover_text_second_line_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="gallery_box_border_color"><?php _e('Gallery box border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["gallery_box_border_color"]) ? esc_attr($theme_options["gallery_box_border_color"]) : 'E5E5E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["gallery_box_border_color"]) ? esc_attr($theme_options["gallery_box_border_color"]) : ""); ?>" id="gallery_box_border_color" name="gallery_box_border_color" data-default-color="E5E5E5">
								<span class="description"><?php _e('Enter \'none\' for no border', 'medicenter'); ?></span>
							</div>
						</li>
						<li>
							<label for="gallery_box_hover_border_color"><?php _e('Gallery box hover border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["gallery_box_hover_border_color"]) ? esc_attr($theme_options["gallery_box_hover_border_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["gallery_box_hover_border_color"]) ? esc_attr($theme_options["gallery_box_hover_border_color"]) : ""); ?>" id="gallery_box_hover_border_color" name="gallery_box_hover_border_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
								<span class="description"><?php _e('Enter \'none\' for no border', 'medicenter'); ?></span>
							</div>
						</li>
						<li>
							<label for="gallery_box_control_color"><?php _e('Gallery box controll background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["gallery_box_control_color"]) ? esc_attr($theme_options["gallery_box_control_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["gallery_box_control_color"]) ? esc_attr($theme_options["gallery_box_control_color"]) : ""); ?>" id="gallery_box_control_color" name="gallery_box_control_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="gallery_box_control_hover_color"><?php _e('Gallery box control hover background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["gallery_box_control_hover_color"]) ? esc_attr($theme_options["gallery_box_control_hover_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["gallery_box_control_hover_color"]) ? esc_attr($theme_options["gallery_box_control_hover_color"]) : ""); ?>" id="gallery_box_control_hover_color" name="gallery_box_control_hover_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="timetable_box_color"><?php _e('Timetable box background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["timetable_box_color"]) ? esc_attr($theme_options["timetable_box_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["timetable_box_color"]) ? esc_attr($theme_options["timetable_box_color"]) : ""); ?>" id="timetable_box_color" name="timetable_box_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="timetable_box_hover_color"><?php _e('Timetable box hover background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["timetable_box_hover_color"]) ? esc_attr($theme_options["timetable_box_hover_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["timetable_box_hover_color"]) ? esc_attr($theme_options["timetable_box_hover_color"]) : ""); ?>" id="timetable_box_hover_color" name="timetable_box_hover_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="timetable_box_text_color"><?php _e('Timetable box text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["timetable_box_text_color"]) ? esc_attr($theme_options["timetable_box_text_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["timetable_box_text_color"]) ? esc_attr($theme_options["timetable_box_text_color"]) : ""); ?>" id="timetable_box_text_color" name="timetable_box_text_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="timetable_box_hover_text_color"><?php _e('Timetable box hover text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["timetable_box_hover_text_color"]) ? esc_attr($theme_options["timetable_box_hover_text_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["timetable_box_hover_text_color"]) ? esc_attr($theme_options["timetable_box_hover_text_color"]) : ""); ?>" id="timetable_box_hover_text_color" name="timetable_box_hover_text_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="timetable_tip_box_color"><?php _e('Timetable tip box background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["timetable_tip_box_color"]) ? esc_attr($theme_options["timetable_tip_box_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["timetable_tip_box_color"]) ? esc_attr($theme_options["timetable_tip_box_color"]) : ""); ?>" id="timetable_tip_box_color" name="timetable_tip_box_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="accordion_tab_color"><?php _e('Accordion tab color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["accordion_tab_color"]) ? esc_attr($theme_options["accordion_tab_color"]) : '3156A3'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["accordion_tab_color"]) ? esc_attr($theme_options["accordion_tab_color"]) : ""); ?>" id="accordion_tab_color" name="accordion_tab_color" data-default-color="3156A3" data-default-color-green="008238" data-default-color-orange="cb451b" data-default-color-red="c03427" data-default-color-turquoise="006688" data-default-color-violet="3e4c94">
							</div>
						</li>
						<li>
							<label for="tabs_text_color"><?php _e('Tabs text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["tabs_text_color"]) ? esc_attr($theme_options["tabs_text_color"]) : '666666'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["tabs_text_color"]) ? esc_attr($theme_options["tabs_text_color"]) : ""); ?>" id="tabs_text_color" name="tabs_text_color" data-default-color="666666">
							</div>
						</li>
						<li>
							<label for="tabs_border_color"><?php _e('Tabs border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["tabs_border_color"]) ? esc_attr($theme_options["tabs_border_color"]) : 'E0E0E0'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["tabs_border_color"]) ? esc_attr($theme_options["tabs_border_color"]) : ""); ?>" id="tabs_border_color" name="tabs_border_color" data-default-color="E0E0E0">
							</div>
						</li>
						<li>
							<label for="tabs_hover_text_color"><?php _e('Tabs hover text color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["tabs_hover_text_color"]) ? esc_attr($theme_options["tabs_hover_text_color"]) : '000000'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["tabs_hover_text_color"]) ? esc_attr($theme_options["tabs_hover_text_color"]) : ""); ?>" id="tabs_hover_text_color" name="tabs_hover_text_color" data-default-color="000000">
							</div>
						</li>
						<li>
							<label for="tabs_border_hover_color"><?php _e('Tabs border hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["tabs_border_hover_color"]) ? esc_attr($theme_options["tabs_border_hover_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["tabs_border_hover_color"]) ? esc_attr($theme_options["tabs_border_hover_color"]) : ""); ?>" id="tabs_border_hover_color" name="tabs_border_hover_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="featured_icon_color"><?php _e('Featured icon color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["featured_icon_color"]) ? esc_attr($theme_options["featured_icon_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["featured_icon_color"]) ? esc_attr($theme_options["featured_icon_color"]) : ""); ?>" id="featured_icon_color" name="featured_icon_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="featured_icon_background_color"><?php _e('Featured icon background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["featured_icon_background_color"]) ? esc_attr($theme_options["featured_icon_background_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["featured_icon_background_color"]) ? esc_attr($theme_options["featured_icon_background_color"]) : ""); ?>" id="featured_icon_background_color" name="featured_icon_background_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="light_featured_icon_color"><?php _e('Light featured icon color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_featured_icon_color"]) ? esc_attr($theme_options["light_featured_icon_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_featured_icon_color"]) ? esc_attr($theme_options["light_featured_icon_color"]) : ""); ?>" id="light_featured_icon_color" name="light_featured_icon_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="light_featured_icon_background_color"><?php _e('Light featured icon background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["light_featured_icon_background_color"]) ? esc_attr($theme_options["light_featured_icon_background_color"]) : 'F0F0F0'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["light_featured_icon_background_color"]) ? esc_attr($theme_options["light_featured_icon_background_color"]) : ""); ?>" id="light_featured_icon_background_color" name="light_featured_icon_background_color" data-default-color="F0F0F0">
							</div>
						</li>
						<li>
							<label for="simple_featured_icon_color"><?php _e('Simple featured icon color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["simple_featured_icon_color"]) ? esc_attr($theme_options["simple_featured_icon_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["simple_featured_icon_color"]) ? esc_attr($theme_options["simple_featured_icon_color"]) : ""); ?>" id="simple_featured_icon_color" name="simple_featured_icon_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<li>
							<label for="social_icon_color"><?php _e('Social icon color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["social_icon_color"]) ? esc_attr($theme_options["social_icon_color"]) : 'AAAAAA'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["social_icon_color"]) ? esc_attr($theme_options["social_icon_color"]) : ""); ?>" id="social_icon_color" name="social_icon_color" data-default-color="AAAAAA">
							</div>
						</li>
						<li>
							<label for="social_icon_background_color"><?php _e('Social icon background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["social_icon_background_color"]) ? esc_attr($theme_options["social_icon_background_color"]) : 'F0F0F0'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["social_icon_background_color"]) ? esc_attr($theme_options["social_icon_background_color"]) : ""); ?>" id="social_icon_background_color" name="social_icon_background_color" data-default-color="F0F0F0">
							</div>
						</li>
						<li>
							<label for="social_icon_hover_color"><?php _e('Social icon hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["social_icon_hover_color"]) ? esc_attr($theme_options["social_icon_hover_color"]) : 'FFFFFF'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["social_icon_hover_color"]) ? esc_attr($theme_options["social_icon_hover_color"]) : ""); ?>" id="social_icon_hover_color" name="social_icon_hover_color" data-default-color="FFFFFF">
							</div>
						</li>
						<li>
							<label for="social_icon_hover_background_color"><?php _e('Social icon hover background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo (!empty($theme_options["social_icon_hover_background_color"]) ? esc_attr($theme_options["social_icon_hover_background_color"]) : '42B3E5'); ?>;"></span>
								<input type="text" class="regular-text color" value="<?php echo (!empty($theme_options["social_icon_hover_background_color"]) ? esc_attr($theme_options["social_icon_hover_background_color"]) : ""); ?>" id="social_icon_hover_background_color" name="social_icon_hover_background_color" data-default-color="42B3E5" data-default-color-green="7CBA3D" data-default-color-orange="ffa800" data-default-color-red="f37548" data-default-color-turquoise="00b6cc" data-default-color-violet="9187c4">
							</div>
						</li>
						<?php /*<li>
							<label for="gallery_details_box_border_color"><?php _e('Gallery details box border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["gallery_details_box_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["gallery_details_box_border_color"]); ?>" id="gallery_details_box_border_color" name="gallery_details_box_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'medicenter'); ?></span>
							</div>
						</li>
						<li>
							<label for="bread_crumb_border_color"><?php _e('Bread crumb border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["bread_crumb_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["bread_crumb_border_color"]); ?>" id="bread_crumb_border_color" name="bread_crumb_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'medicenter'); ?></span>
							</div>
						</li>
						<li>
							<label for="accordion_item_border_color"><?php _e('Accordion item border color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["accordion_item_border_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["accordion_item_border_color"]); ?>" id="accordion_item_border_color" name="accordion_item_border_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'medicenter'); ?></span>
							</div>
						</li>
						<li>
							<label for="accordion_item_border_hover_color"><?php _e('Accordion item border hover color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["accordion_item_border_hover_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["accordion_item_border_hover_color"]); ?>" id="accordion_item_border_hover_color" name="accordion_item_border_hover_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'medicenter'); ?></span>
							</div>
						</li>
						<li>
							<label for="accordion_item_border_active_color"><?php _e('Accordion item border active color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["accordion_item_border_active_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["accordion_item_border_active_color"]); ?>" id="accordion_item_border_active_color" name="accordion_item_border_active_color">
								<span class="description"><?php _e('Enter \'none\' for no border', 'medicenter'); ?></span>
							</div>
						</li>						
						<li>
							<label for="comment_reply_button_color"><?php _e('Comment reply button color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["comment_reply_button_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["comment_reply_button_color"]); ?>" id="comment_reply_button_color" name="comment_reply_button_color">
							</div>
						</li>
						<li>
							<label for="post_author_link_color"><?php _e('Post author link color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["post_author_link_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["post_author_link_color"]); ?>" id="post_author_link_color" name="post_author_link_color">
							</div>
						</li>
						<li>
							<label for="contact_details_box_background_color"><?php _e('Contact details box background color', 'medicenter'); ?></label>
							<div>
								<span class="color_preview" style="background-color: #<?php echo esc_attr($theme_options["contact_details_box_background_color"]); ?>"></span>
								<input type="text" class="regular-text color" value="<?php echo esc_attr($theme_options["contact_details_box_background_color"]); ?>" id="contact_details_box_background_color" name="contact_details_box_background_color">
							</div>
						</li>*/ ?>
					</ul>
				</div>
			</div>
			<div id="tab-header" class="settings">
				<h3><?php _e('Header', 'medicenter'); ?></h3>
				<ul class="form_field_list">
					<li>
						<label for="header_layout_type"><?php _e('Header layout type', 'medicenter'); ?></label>
						<div>
							<select id="header_layout_type" name="header_layout_type">
								<option<?php echo (!empty($theme_options["header_layout_type"]) && (int)$theme_options["header_layout_type"]==1 ? " selected='selected'" : ""); ?>  value="1"><?php _e("Type 1", 'medicenter'); ?></option>
								<option<?php echo (!empty($theme_options["header_layout_type"]) && (int)$theme_options["header_layout_type"]==2 ? " selected='selected'" : ""); ?>  value="2"><?php _e("Type 2", 'medicenter'); ?></option>
								<option<?php echo (!empty($theme_options["header_layout_type"]) && (int)$theme_options["header_layout_type"]==3 ? " selected='selected'" : ""); ?>  value="3"><?php _e("Type 3", 'medicenter'); ?></option>
								<option<?php echo (!empty($theme_options["header_layout_type"]) && (int)$theme_options["header_layout_type"]==4 ? " selected='selected'" : ""); ?>  value="4"><?php _e("Type 4", 'medicenter'); ?></option>
							</select>
						</div>
					</li>
					<li>
						<label for="header_top_sidebar"><?php _e('Header top sidebar', 'medicenter'); ?></label>
						<div>
						<?php
						//get theme sidebars
						$theme_sidebars = array();
						$theme_sidebars_array = get_posts(array(
							'post_type' => 'medicenter_sidebars',
							'posts_per_page' => '-1',
							'nopaging' => true,
							'post_status' => 'publish',
							'orderby' => 'menu_order',
							'order' => 'ASC'
						));
						for($i=0; $i<count($theme_sidebars_array); $i++)
						{
							$theme_sidebars[$i]["id"] = $theme_sidebars_array[$i]->ID;
							$theme_sidebars[$i]["title"] = $theme_sidebars_array[$i]->post_title;
						}
						?>
						<select id="header_top_sidebar" name="header_top_sidebar">
							<option value="" <?php echo (empty($theme_options["header_top_sidebar"]) ? " selected='selected'" : ""); ?>><?php _e("none", 'medicenter'); ?></option>
							<?php
							foreach($theme_sidebars as $theme_sidebar)
							{
								?>
								<option value="<?php echo (!empty($theme_sidebar["id"]) ? esc_attr($theme_sidebar["id"]) : ""); ?>"<?php echo (isset($theme_options["header_top_sidebar"]) && $theme_options["header_top_sidebar"]==$theme_sidebar["id"] ? " selected='selected'" : ""); ?>><?php echo (!empty($theme_sidebar["title"]) ? $theme_sidebar["title"] : ""); ?></option>
								<?php
							}
							?>
						</select>
						</div>
					</li>
					<li id="header_top_right_sidebar_container"<?php echo (isset($theme_options["header_layout_type"]) && (int)$theme_options["header_layout_type"]!=2 ? ' style="display: none;"' : ''); ?>>
						<label for="header_top_right_sidebar"><?php _e('Header top right sidebar', 'medicenter'); ?></label>
						<div>
						<select id="header_top_right_sidebar" name="header_top_right_sidebar">
							<option value="" <?php echo (empty($theme_options["header_top_right_sidebar"]) ? " selected='selected'" : ""); ?>><?php _e("none", 'medicenter'); ?></option>
							<?php
							foreach($theme_sidebars as $theme_sidebar)
							{
								?>
								<option value="<?php echo (!empty($theme_sidebar["id"]) ? esc_attr($theme_sidebar["id"]) : ""); ?>"<?php echo (isset($theme_options["header_top_right_sidebar"]) && $theme_options["header_top_right_sidebar"]==$theme_sidebar["id"] ? " selected='selected'" : ""); ?>><?php echo (!empty($theme_sidebar["title"]) ? $theme_sidebar["title"] : ""); ?></option>
								<?php
							}
							?>
						</select>
						</div>
					</li>
				</ul>
			</div>
			<div id="tab-fonts" class="settings">
				<h3><?php _e('Fonts', 'medicenter'); ?></h3>
				<ul class="form_field_list">
					<li>
						<label for="header_font"><?php _e('Header font', 'medicenter'); ?></label>
						<div>
							<select id="header_font" name="header_font">
								<option<?php echo (empty($theme_options["header_font"]) ? " selected='selected'" : ""); ?>  value=""><?php _e("Default (Source Sans Pro)", 'medicenter'); ?></option>
								<?php
								if(isset($fontsArray))
								{
									$fontsCount = count((array)$fontsArray->items);
									for($i=0; $i<$fontsCount; $i++)
									{
									?>
										
										<?php
										$variantsCount = count($fontsArray->items[$i]->variants);
										if($variantsCount>1)
										{
											for($j=0; $j<$variantsCount; $j++)
											{
											?>
												<option<?php echo (isset($theme_options["header_font"]) && $theme_options["header_font"]==$fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] ? " selected='selected'" : ""); ?> value="<?php echo esc_attr($fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]); ?>"><?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?></option>
											<?php
											}
										}
										else
										{
										?>
										<option<?php echo (isset($theme_options["header_font"]) && $theme_options["header_font"]==$fontsArray->items[$i]->family ? " selected='selected'" : ""); ?> value="<?php echo esc_attr($fontsArray->items[$i]->family); ?>"><?php echo $fontsArray->items[$i]->family; ?></option>
										<?php
										}
									}
								}
								?>
							</select>
							<img class="theme_font_subset_preloader" src="<?php echo esc_url(get_template_directory_uri());?>/admin/images/ajax-loader.gif" />
							<label class="font_subset" for="header_font_subset" style="<?php echo (!empty($theme_options["header_font"]) ? "display: block;" : ""); ?>"><?php _e('Header font subset', 'medicenter'); ?></label>
							<select id="header_font_subset" class="font_subset" name="header_font_subset[]" multiple="multiple" style="<?php echo (!empty($theme_options["header_font"]) ? "display: block;" : ""); ?>">
								<?php
								if(!empty($theme_options["header_font"]))
								{
									$fontExplode = explode(":", $theme_options["header_font"]);
									$font_subset = mc_get_google_font_subset($fontExplode[0]);
									foreach($font_subset as $subset)
										echo "<option value='" . esc_attr($subset) . "' " . (in_array($subset, (array)$theme_options["header_font_subset"]) ? "selected='selected'" : "") . ">" . $subset . "</option>";							
								}
								?>
							</select>
						</div>
					</li>
					<li>
						<label for="content_font"><?php _e('Content font', 'medicenter'); ?></label>
						<div>
							<select id="content_font" name="content_font">
								<option<?php echo (empty($theme_options["content_font"]) ? " selected='selected'" : ""); ?>  value=""><?php _e("Default (Open Sans)", 'medicenter'); ?></option>
								<?php
								if(isset($fontsArray))
								{
									$fontsCount = count((array)$fontsArray->items);
									for($i=0; $i<$fontsCount; $i++)
									{
									?>
										
										<?php
										$variantsCount = count($fontsArray->items[$i]->variants);
										if($variantsCount>1)
										{
											for($j=0; $j<$variantsCount; $j++)
											{
											?>
												<option<?php echo (isset($theme_options["content_font"]) && $theme_options["content_font"]==$fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] ? " selected='selected'" : ""); ?> value="<?php echo esc_attr($fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]); ?>"><?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?></option>
											<?php
											}
										}
										else
										{
										?>
										<option<?php echo (isset($theme_options["content_font"]) && $theme_options["content_font"]==$fontsArray->items[$i]->family ? " selected='selected'" : ""); ?> value="<?php echo esc_attr($fontsArray->items[$i]->family); ?>"><?php echo $fontsArray->items[$i]->family; ?></option>
										<?php
										}
									}
								}
								?>
							</select>
							<img class="theme_font_subset_preloader" src="<?php echo esc_url(get_template_directory_uri());?>/admin/images/ajax-loader.gif" />
							<label class="font_subset" for="content_font_subset" style="<?php echo (!empty($theme_options["content_font"]) ? "display: block;" : ""); ?>"><?php _e('Subheader font subset', 'medicenter'); ?></label>
							<select id="content_font_subset" class="font_subset" name="content_font_subset[]" multiple="multiple" style="<?php echo (!empty($theme_options["content_font"]) ? "display: block;" : ""); ?>">
								<?php
								if(!empty($theme_options["content_font"]))
								{
									$fontExplode = explode(":", $theme_options["content_font"]);
									$font_subset = mc_get_google_font_subset($fontExplode[0]);
									foreach($font_subset as $subset)
										echo "<option value='" . esc_attr($subset) . "' " . (in_array($subset, (array)$theme_options["content_font_subset"]) ? "selected='selected'" : "") . ">" . $subset . "</option>";							
								}
								?>
							</select>
						</div>
					</li>
					<li>
						<label for="blockquote_font"><?php _e('Blockquote font', 'medicenter'); ?></label>
						<div>
							<select id="blockquote_font" name="blockquote_font">
								<option<?php echo (empty($theme_options["blockquote_font"]) ? " selected='selected'" : ""); ?>  value=""><?php _e("Default (PT Serif)", 'medicenter'); ?></option>
								<?php
								if(isset($fontsArray))
								{
									$fontsCount = count((array)$fontsArray->items);
									for($i=0; $i<$fontsCount; $i++)
									{
									?>
										
										<?php
										$variantsCount = count($fontsArray->items[$i]->variants);
										if($variantsCount>1)
										{
											for($j=0; $j<$variantsCount; $j++)
											{
											?>
												<option<?php echo (isset($theme_options["blockquote_font"]) && $theme_options["blockquote_font"]==$fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] ? " selected='selected'" : ""); ?> value="<?php echo esc_attr($fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]); ?>"><?php echo $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j]; ?></option>
											<?php
											}
										}
										else
										{
										?>
										<option<?php echo (isset($theme_options["blockquote_font"]) && $theme_options["blockquote_font"]==$fontsArray->items[$i]->family ? " selected='selected'" : ""); ?> value="<?php echo esc_attr($fontsArray->items[$i]->family); ?>"><?php echo $fontsArray->items[$i]->family; ?></option>
										<?php
										}
									}
								}
								?>
							</select>
							<img class="theme_font_subset_preloader" src="<?php echo esc_url(get_template_directory_uri());?>/admin/images/ajax-loader.gif" />
							<label class="font_subset" for="blockquote_font_subset" style="<?php echo (!empty($theme_options["blockquote_font"]) ? "display: block;" : ""); ?>"><?php _e('Header font subset', 'medicenter'); ?></label>
							<select id="blockquote_font_subset" class="font_subset" name="blockquote_font_subset[]" multiple="multiple" style="<?php echo (!empty($theme_options["blockquote_font"]) ? "display: block;" : ""); ?>">
								<?php
								if(!empty($theme_options["blockquote_font"]))
								{
									$fontExplode = explode(":", $theme_options["blockquote_font"]);
									$font_subset = mc_get_google_font_subset($fontExplode[0]);
									foreach($font_subset as $subset)
										echo "<option value='" . esc_attr($subset) . "' " . (in_array($subset, (array)$theme_options["blockquote_font_subset"]) ? "selected='selected'" : "") . ">" . $subset . "</option>";							
								}
								?>
							</select>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="footer">
			<div class="footer_left">
				<ul class="social-list">
					<li><a target="_blank" href="<?php echo esc_url(__('https://www.facebook.com/QuanticaLabs/', 'medicenter')); ?>" class="social-facebook" title="<?php esc_attr_e('Facebook', 'medicenter'); ?>"></a></li>
					<li><a target="_blank" href="<?php echo esc_url(__('https://twitter.com/quanticalabs', 'medicenter')); ?>" class="social-twitter" title="<?php esc_attr_e('Twitter', 'medicenter'); ?>"></a></li>
					<li><a target="_blank" href="<?php echo esc_url(__('https://www.pinterest.com/quanticalabs/', 'medicenter')); ?>" class="social-pinterest" title="<?php esc_attr_e('Pinterest', 'medicenter'); ?>"></a></li>
					<li><a target="_blank" href="<?php echo esc_url(__('https://1.envato.market/quanticalabs-portfolio-themeforest', 'medicenter')); ?>" class="social-envato" title="<?php esc_attr_e('Envato', 'medicenter'); ?>"></a></li>
					<li><a target="_blank" href="<?php echo esc_url(__('https://www.behance.net/quanticalabs', 'medicenter')); ?>" class="social-behance" title="<?php esc_attr_e('Behance', 'medicenter'); ?>"></a></li>
					<li><a target="_blank" href="<?php echo esc_url(__('https://dribbble.com/QuanticaLabs', 'medicenter')); ?>" class="social-dribbble" title="<?php esc_attr_e('Dribbble', 'medicenter'); ?>"></a></li>
				</ul>
			</div>
			<div class="footer_right">
				<input type="hidden" name="action" value="<?php echo esc_attr($themename); ?>_save" />
				<input type="submit" name="submit" value="<?php esc_attr_e('Save Options', 'medicenter'); ?>" />
				<img id="theme_options_preloader" src="<?php echo esc_url(get_template_directory_uri() . '/admin/images/ajax-loader.gif'); ?>" />
				<img id="theme_options_tick" src="<?php echo esc_url(get_template_directory_uri() . '/admin/images/tick.png'); ?>" />
				<div id="theme_options_info"></div>
			</div>
		</div>
	</form>
<?php
}
?>