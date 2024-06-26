<?php
//dropcap
function mc_theme_notification_box($atts)
{
	extract(shortcode_atts(array(
		"header" => "Sample Header",
		"info_text" => "",
		"type" => "success",
		"closing_time" => "",
		"close_icon" => 1,
		"custom_background_color" => "",
		"header_color" => "",
		"content_text_color" => "",
		"el_class" => "",
		"top_margin" => "none"
	), $atts));
	
	$output = '<div class="notification-box nb-' . esc_attr($type) . ($type=="success" ? " features-tick" : ($type=="error" ? " features-cross" : " features-pen")) . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . '"' . ($custom_background_color!="" ? ' style="background-color:' . esc_attr($custom_background_color) . ';"' : '') . '><h2' . ($header_color!="" ? ' style="color:' . esc_attr($header_color) . ';"' : '') . '>' . $header . '</h2>';
	if($info_text!="")
		$output .= '<h5' . ($content_text_color!="" ? ' style="color:' . esc_attr($content_text_color) . ';"' : '') . '>' . $info_text . '</h5>';
	$output .= ((int)$close_icon ? '<a href="#" class="nb-close template-remove-1-after">&nbsp;</a>' : '') . '</div>';
	if((int)$closing_time>0)
		$output .= '<div class="clearfix closing-in-container"><span class="closing-in">' . __("Closing in ", 'medicenter') . '<span class="seconds">' . $closing_time . '</span>' . __(" sec...", 'medicenter') . '</span></div>';

	return $output;
}

//visual composer
$mc_colors_arr = array(__("Dark blue", "medicenter") => "#3156a3", __("Blue", "medicenter") => "#0384ce", __("Light blue", "medicenter") => "#42b3e5", __("Black", "medicenter") => "#000000", __("Gray", "medicenter") => "#AAAAAA", __("Dark gray", "medicenter") => "#444444", __("Light gray", "medicenter") => "#CCCCCC", __("Green", "medicenter") => "#43a140", __("Dark green", "medicenter") => "#008238", __("Light green", "medicenter") => "#7cba3d", __("Orange", "medicenter") => "#f17800", __("Dark orange", "medicenter") => "#cb451b", __("Light orange", "medicenter") => "#ffa800", __("Red", "medicenter") => "#db5237", __("Dark red", "medicenter") => "#c03427", __("Light red", "medicenter") => "#f37548", __("Turquoise", "medicenter") => "#0097b5", __("Dark turquoise", "medicenter") => "#006688", __("Light turquoise", "medicenter") => "#00b6cc", __("Violet", "medicenter") => "#6969b3", __("Dark violet", "medicenter") => "#3e4c94", __("Light violet", "medicenter") => "#9187c4", __("White", "medicenter") => "#FFFFFF", __("Yellow", "medicenter") => "#fec110");
vc_map( array(
	"name" => __("Notification box", 'medicenter'),
	"base" => "notification_box",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-notification-box",
	"category" => __('MediCenter', 'medicenter'),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Header", 'medicenter'),
			"param_name" => "header",
			"value" => "Sample Header"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Info text", 'medicenter'),
			"param_name" => "info_text",
			"value" => ""
		),
		array(
            "type" => "dropdown",
            "heading" => __("Type", "medicenter"),
            "param_name" => "type",
            "value" => array(__("Success", 'medicenter') => "success", __("Error", 'medicenter') => "error", __("Info", 'medicenter') => "info")
        ),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Auto closing time (in seconds)", 'medicenter'),
			"param_name" => "closing_time",
			"value" => ""
		),
		array(
            "type" => "dropdown",
            "heading" => __("Close icon", "medicenter"),
            "param_name" => "close_icon",
            "value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => "0")
        ),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Custom background color", 'medicenter'),
			"param_name" => "custom_background_color",
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Header text color", 'medicenter'),
			"param_name" => "header_color",
			"value" => ""
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content text color", 'medicenter'),
			"param_name" => "content_text_color",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Extra class name", 'medicenter'),
			"param_name" => "el_class",
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
?>