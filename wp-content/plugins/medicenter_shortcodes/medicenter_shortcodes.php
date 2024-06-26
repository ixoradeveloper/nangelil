<?php
/*
Plugin Name: MediCenter Theme Shortcodes
Plugin URI: https://1.envato.market/quanticalabs-portfolio
Description: MediCenter Theme Shortcodes plugin
Author: QuanticaLabs
Author URI: https://1.envato.market/quanticalabs-portfolio
Version: 1.1
*/

function medicenter_shortcodes_vc_init()
{
	if(function_exists("vc_map"))
	{
		add_shortcode("page_layout", "mc_theme_page_layout");
		add_shortcode("page_left", "mc_theme_page_left");
		add_shortcode("page_right", "mc_theme_page_right");
		add_shortcode("button_more", "mc_theme_button_more");
		add_shortcode("box_header", "mc_theme_box_header");
		add_shortcode("dropcap", "mc_theme_dropcap");
		add_shortcode("show_all_button", "mc_theme_show_all_button");
		add_shortcode("sentence", "mc_theme_sentence");
		add_shortcode("sidebar_box", "mc_theme_sidebar_box");
		add_shortcode("scroll_top", "mc_theme_scroll_top");
		add_shortcode("info_text", "mc_theme_info_text");
		add_shortcode("header_icon", "mc_theme_header_icon");
		add_shortcode("accordion", "mc_theme_accordion");
		add_shortcode("accordion_item", "mc_theme_accordion_item");
		add_shortcode("announcement_box", "mc_theme_announcement_box_shortcode");
		add_shortcode("blog", "mc_theme_blog");
		add_shortcode("mc_carousel", "mc_theme_carousel_shortcode");
		add_shortcode("mc_cart_icon", "mc_theme_mc_cart_icon");
		add_shortcode("columns", "mc_theme_columns");
		add_shortcode("column_left", "mc_theme_column_left");
		add_shortcode("column_right", "mc_theme_column_right");
		add_shortcode("counter_box", "mc_theme_counter_box");
		add_shortcode("doctor_box", "mc_theme_doctor_box");
		add_shortcode("doctor_description_box", "mc_theme_doctor_description_box");
		add_shortcode("home_box_container", "mc_theme_home_box_container");
		add_shortcode("home_box", "mc_theme_home_box");
		add_shortcode("news", "mc_theme_news");
		add_shortcode("mc_icon", "mc_theme_mc_icon");
		add_shortcode("info_box", "mc_theme_info_box");
		add_shortcode("items_list", "mc_theme_items_list");
		add_shortcode("item", "mc_theme_item");
		add_shortcode("medicenter_map", "mc_theme_map_shortcode");
		add_shortcode("notification_box", "mc_theme_notification_box");
		add_shortcode("our_clients", "mc_theme_our_clients");
		add_shortcode("photostream", "mc_theme_photostream_shortcode");
		add_shortcode("service_box", "mc_theme_service_box");
		add_shortcode("single_doctor", "mc_theme_single_doctor");
		add_shortcode("single_post", "mc_theme_single_post");
		add_shortcode("single_service", "mc_theme_single_service");
		add_shortcode("slider", "mc_theme_slider");
		add_shortcode("slider_content", "mc_theme_slider_content");
		add_shortcode("mc_small_slider", "mc_theme_small_slider_shortcode");
		add_shortcode("tabs", "mc_theme_tabs");
		add_shortcode("tabs_navigation", "mc_theme_tabs_navigation");
		add_shortcode("tab", "mc_theme_tab");
		add_shortcode("tab_content", "mc_theme_tab_content");
		add_shortcode("mc_testimonials", "mc_theme_testimonials_shortcode");
		add_shortcode("timeline_item", "mc_theme_timeline_item");
		add_shortcode("timetable", "mc_theme_timetable");
		add_shortcode("medicenter_contact_form", "mc_theme_contact_form_shortcode");
		if(function_exists("vc_add_shortcode_param"))
		{
			vc_add_shortcode_param('dropdownmulti' , 'mc_dropdownmultiple_settings_field');
			vc_add_shortcode_param('hidden', 'mc_hidden_settings_field');
			vc_add_shortcode_param('readonly', 'mc_readonly_settings_field');
			vc_add_shortcode_param('listitem' , 'mc_listitem_settings_field');
			vc_add_shortcode_param('listitemwindow' , 'mc_listitemwindow_settings_field');
		}
	}
}
add_action("init", "medicenter_shortcodes_vc_init");
?>