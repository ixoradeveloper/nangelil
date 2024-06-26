<?php
//post
function mc_theme_counter_box($atts, $content)
{
	extract(shortcode_atts(array(
		"type" => "default",
		"value" => "",
		"value_sign" => "",
		"icon" => "none",
		"style" => "hexagon",
		"duration" => 2000,
		"animation_start" => "",
		"class" => "",
		"top_margin" => "none"
	), $atts));
	
	$output = "";
	$dashoffset = 
	$output .= '<div class="' . ($type=="single" ? 'single-' : '') . 'counter-box' . ($icon!="none" ? ' has-counter-box-path features-' . esc_attr($icon) : '') . ($class!="" ? ' ' . esc_attr($class) : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">';
	if($icon!="none")
	{
		if($style=="circle")
		{
			$output .= '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="140px" height="140px" viewBox="0 0 142 142"><circle class="counter-box-path animated-element" stroke="#FFF" cx="71" cy="71" r="69" fill="none" stroke-width="2"' . ((int)$animation_start>0 ? ' data-animation-start="' . esc_attr((int)$animation_start+160) . '"' : '') . ((int)$duration>0 ? ' data-duration="' . esc_attr((int)$duration) . '"' : '') . '/></svg>';
		}
		else
		{
			$output .= '<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="124px" height="142px" viewBox="0 -2 122 142"><path class="counter-box-path animated-element" stroke="#FFF" d="M 0,103.5 0,34.5 60,0 120,34.5 120,103.5 60,138Z" fill="none" stroke-width="2"' . ((int)$animation_start>0 ? ' data-animation-start="' . esc_attr((int)$animation_start+160) . '"' : '') . ((int)$duration>0 ? ' data-duration="' . esc_attr((int)$duration) . '"' : '') . '></path></svg>';
		}
	}
	//$output .= '<div class="counter-box-icon features-image"></div>';
	$output .= '<span class="number animated-element" data-value="' . esc_attr($value) . '"' . ((int)$animation_start>0 ? ' data-animation-start="' . esc_attr((int)$animation_start) . '"' : '') . '></span>' . ($value_sign!="" ? '<span class="number-sign">' . $value_sign . '</span>' : '');
	if($content!="")
		$output .= '<p>' . wpb_js_remove_wpautop($content) . '</p>';
	$output .= '</div>';
	return $output;
}

//visual composer
function mc_theme_counter_box_vc_init()
{
	$params = array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'medicenter'),
			"param_name" => "type",
			"value" => array(__("Default", 'medicenter') => "default", __("Single", 'medicenter') => "single")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Value", 'medicenter'),
			"param_name" => "value",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Value sign", 'medicenter'),
			"param_name" => "value_sign",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Icon", 'medicenter'),
			"param_name" => "icon",
			"value" => array(
				"none",
				"address",
				"ambulance",
				"app",
				"baby",
				"baby-bed",
				"baby-bottle",
				"bacteria",
				"balance",
				"battery",
				"book",
				"box",
				"brain",
				"briefcase",
				"burns",
				"cart",
				"cat",
				"certificate",
				"chart",
				"chat",
				"clock",
				"config",
				"credit-card",
				"cross",
				"dental-shield",
				"dentist",
				"diary",
				"dna",
				"doctor",
				"document",
				"document-missing",
				"dog",
				"drip",
				"ear",
				"email",
				"eye",
				"facebook",
				"first-aid",
				"fitness",
				"frostbite",
				"gallery",
				"glasses",
				"graph",
				"healthcare",
				"heart",
				"heart-beat",
				"home",
				"hospital",
				"id",
				"image",
				"keyboard",
				"lab",
				"laptop",
				"leaf",
				"lifeline",
				"list",
				"location",
				"lock",
				"map",
				"medical-bed",
				"medical-cast",
				"medical-cross",
				"medical-document",
				"medical-results",
				"medical-scissors",
				"medical-staff",
				"minus",
				"mobile",
				"molecule",
				"money",
				"mortar",
				"movie",
				"network",
				"paypal",
				"pen",
				"people",
				"pet-box",
				"phone",
				"piano",
				"pill",
				"pin",
				"plaster",
				"play",
				"plus",
				"printer",
				"pulse",
				"quote",
				"science",
				"screen",
				"signpost",
				"spa",
				"spa-bamboo",
				"spa-lotion",
				"speaker",
				"stethoscope",
				"syringe",
				"tablet",
				"tags",
				"teddy-bear",
				"test-tube",
				"tick",
				"time",
				"toothbrush",
				"twitter",
				"video",
				"wallet",
				"x-ray"
			)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Style", 'medicenter'),
			"param_name" => "style",
			"value" => array(__("Hexagon", 'medicenter') => "hexagon", __("Circle", 'medicenter') => "circle")
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text", 'medicenter'),
			"param_name" => "content",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Animation duration", 'medicenter'),
			"param_name" => "duration",
			"value" => "2000"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Animation start position", 'medicenter'),
			"param_name" => "animation_start",
			"value" => ""
		),
		array(
			"type" => "textfield",
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
	);
	
	vc_map( array(
		"name" => __("Counter Box", 'medicenter'),
		"base" => "counter_box",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-counter-box",
		"category" => __('MediCenter', 'medicenter'),
		"params" => $params
	));
}
add_action("init", "mc_theme_counter_box_vc_init");
?>
