<?php
//author
function mc_theme_doctor_description_box($atts)
{
	extract(shortcode_atts(array(
		"el_class" => "",
		"top_margin" => "none"
	), $atts));
	
	global $post;
	setup_postdata($post);
	
	$output = '<div class="wpb_wrapper">
	<div class="wpb_raw_code wpb_content_element wpb_raw_html' . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">
		<div class="wpb_wrapper">' . get_post_meta(get_the_ID(), "doctor_description", true) . '</div></div></div>';
	return $output;
}

//visual composer
function mc_theme_doctor_description_box_vc_init()
{
	$params = array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'medicenter' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'medicenter' ),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'medicenter'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'medicenter') => "none", __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section")
		)
	);
	
	vc_map( array(
		"name" => __("Doctor Description Box", 'medicenter'),
		"base" => "doctor_description_box",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-custom-post-type",
		"category" => __('MediCenter', 'medicenter'),
		"params" => $params
	));
}
add_action("init", "mc_theme_doctor_description_box_vc_init");
?>
