<?php
//doctor
function mc_theme_single_doctor($atts)
{
	extract(shortcode_atts(array(
		"top_margin" => "none"
	), $atts));
	
	global $post;
	setup_postdata($post);
	
	$output = "";
	if(!empty($top_margin) && $top_margin!="none")
		$output .= '<div class="' . esc_attr($top_margin) . '">';
	if(get_post_type()=="doctors")
		$output .= (function_exists("wpb_js_remove_wpautop") ? wpb_js_remove_wpautop(apply_filters('the_content', get_the_content())) : apply_filters('the_content', get_the_content()));
	if(!empty($top_margin) && $top_margin!="none")
		$output .= '</div>';
		
	return $output;
}

//visual composer
function mc_theme_single_doctor_vc_init()
{
	$params = array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'medicenter'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'medicenter') => "none", __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section")
		)
	);
	
	vc_map( array(
		"name" => __("Doctor", 'medicenter'),
		"base" => "single_doctor",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-custom-post-type",
		"category" => __('MediCenter', 'medicenter'),
		"params" => $params
	));
}
add_action("init", "mc_theme_single_doctor_vc_init");
?>
