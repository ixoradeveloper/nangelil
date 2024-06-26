<?php
//post
function mc_theme_info_box($atts, $content)
{
	extract(shortcode_atts(array(
		"title" => "",
		"icon" => "none",
		"animation" => "",
		"animation_duration" => "600",
		"animation_delay" => "0",
		"arrow" => "no",
		"arrow_animation" => 0,
		"arrow_animation_duration" => "600",
		"arrow_animation_delay" => "0",
		"top_margin" => "none",
		"el_class" => ""
	), $atts));
	
	$output = "";
	$output .= '<div class="info-box' . ($icon!="none" ? ' features-' . esc_attr($icon) : '') . ($animation!='' ? ' animated-element animation-' . esc_attr($animation) . ((int)$animation_duration>0 && (int)$animation_duration!=600 ? ' duration-' . (int)esc_attr($animation_duration) : '') . ((int)$animation_delay>0 ? ' delay-' . (int)esc_attr($animation_delay) : '') : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . '">';
	
	if($title!="")
		$output .= '<h3>' . $title . '</h3>';
	if($content!="")
		$output .= '<p>' . $content . '</p>';
	$output .= '</div>';
	if($arrow!="no")
		$output .= '<div class="arrow-container' . ($arrow_animation!='' ? ' animated-element animation-' . esc_attr($arrow_animation) . ((int)$arrow_animation_duration>0 && (int)$arrow_animation_duration!=600 ? ' duration-' . (int)esc_attr($arrow_animation_duration) : '') . ((int)$arrow_animation_delay>0 ? ' delay-' . (int)esc_attr($arrow_animation_delay) : '') : '') . '"><span class="arrow template-arrow-horizontal-4-after arrow-' . esc_attr($arrow) . '"></span></div>';
	
	return $output;
}

//visual composer
function mc_theme_info_box_vc_init()
{
	$params = array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title", 'medicenter'),
			"param_name" => "title",
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
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text", 'medicenter'),
			"param_name" => "content",
			"value" => ""
		),
		array(
            "type" => "dropdown",
            "heading" => __("Animation", "medicenter"),
            "param_name" => "animation",
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
			"heading" => __("Animation duration", 'medicenter'),
			"param_name" => "animation_duration",
			"value" => "600"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Animation delay", 'medicenter'),
			"param_name" => "animation_delay",
			"value" => "0"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show box arrow", 'medicenter'),
			"param_name" => "arrow",
			"value" => array(__("No", 'medicenter') => "no", __("Light color", 'medicenter') => "light", __("Dark color", 'medicenter') => "dark")
		),
		array(
            "type" => "dropdown",
            "heading" => __("Arrow animation", "medicenter"),
            "param_name" => "arrow_animation",
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
			),
			"dependency" => Array('element' => "arrow", 'value' => array('light', 'dark'))
        ),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Arrow animation duration", 'medicenter'),
			"param_name" => "arrow_animation_duration",
			"value" => "600",
			"dependency" => Array('element' => "arrow", 'value' => array('light', 'dark'))
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Arrow animation delay", 'medicenter'),
			"param_name" => "arrow_animation_delay",
			"value" => "0",
			"dependency" => Array('element' => "arrow", 'value' => array('light', 'dark'))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'medicenter'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'medicenter') => "none", __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section")
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'medicenter' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'medicenter' )
		)
	);
	
	vc_map( array(
		"name" => __("Info Box", 'medicenter'),
		"base" => "info_box",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-info-box",
		"category" => __('MediCenter', 'medicenter'),
		"params" => $params
	));
}
add_action("init", "mc_theme_info_box_vc_init");
?>
