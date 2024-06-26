<?php
function mc_theme_testimonials_shortcode($atts)
{
	global $theme_options;
	extract(shortcode_atts(array(
		"id" => "testimonials",
		"header" => "",
		"animation" => 0,
		"layout" => "sm-6",
		"testimonials_count" => 1,
		"controls_position" => "default",
		"icon" => 1,
		"autoplay" => 0,
		"pause_on_hover" => 1,
		"scroll" => 1,
		"effect" => "scroll",
		"easing" => "swing",
		"duration" => 500,
		"ontouch" => 0,
		"onmouse" => 0,
		"el_class" => "",
		"top_margin" => "none"
	), $atts));
	if($effect=="_fade")
		$effect = "fade";
	if(strpos($easing, 'ease')!==false)
	{
		$newEasing = 'ease';
		if(strpos($easing, 'inout')!==false)
			$newEasing .= 'InOut';
		else if(strpos($easing, 'in')!==false)
			$newEasing .= 'In';
		else if(strpos($easing, 'out')!==false)
			$newEasing .= 'Out';
		$newEasing .= ucfirst(substr($easing, strlen($newEasing), strlen($easing)-strlen($newEasing)));
	}
	else
		$newEasing = $easing;
	
	$output = '';
	if($controls_position!="bottom")
	{
		$output .= '<div class="clearfix scrolling-controls' . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . '">
			<div class="header-left">' . ($header!="" ? '<h3 class="box-header ' . ((int)$animation ? ' animation-slide' : '') . '">' . $header . '</h3>' : '') . '</div>
			<div class="header-right"><a href="#" id="' . esc_attr($id) . '_prev" class="scrolling-list-control-left template-arrow-horizontal-3"></a><a href="#" id="' . esc_attr($id) . '_next" class="scrolling-list-control-right template-arrow-horizontal-3"></a></div></div>';
	}
	$output .= '<ul class="columns full-width horizontal-carousel testimonials ' . esc_attr($id) . ' id-' . esc_attr($id) . ' autoplay-' . esc_attr($autoplay) . ' pause_on_hover-' . esc_attr($pause_on_hover) . ' scroll-' . esc_attr($scroll) . ' effect-' . esc_attr($effect) . ' easing-' . esc_attr($newEasing) . ' duration-' . esc_attr($duration) . ((int)$ontouch ? ' ontouch' : '') . ((int)$onmouse ? ' onmouse' : ''). ($layout=='sm-12' ? ' testimonials-full-width' : '') . ($controls_position=='bottom' ? ' testimonials-bottom-controls' : '') . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . '">';
	if(is_rtl())
	{
		for($i=$testimonials_count-1; $i>=0; $i--)
		{
			$output .= '<li class="wpb_column vc_column_container vc_col-' . esc_attr($layout) . ((int)$icon ? ' template-quote-2' : '') . '">
				<h3 class="sentence">' . $atts["testimonials_title" . $i] . '</h3>
				' . ($atts["testimonials_author" . $i]!="" ? '<div class="clearfix"><span class="sentence-author">' . $atts["testimonials_author" . $i] . '</span></div>' : '') . '
			</li>';
		}
	}
	else
	{
		for($i=0; $i<$testimonials_count; $i++)
		{
			$output .= '<li class="wpb_column vc_column_container vc_col-' . esc_attr($layout) . ((int)$icon ? ' template-quote-2' : '') . '">
				<h3 class="sentence">' . (isset($atts["testimonials_title" . $i]) ? $atts["testimonials_title" . $i] : __("Sample Sentence Text", 'medicenter')) . '</h3>
				' . (isset($atts["testimonials_author" . $i]) && $atts["testimonials_author" . $i]!="" ? '<div class="clearfix"><span class="sentence-author">' . $atts["testimonials_author" . $i] . '</span></div>' : '') . '
			</li>';
		}
	}
	$output .= '</ul>';
	if($controls_position=="bottom")
	{
		$output .= '<ul class="clearfix scrolling-controls page-margin-top-section">
			<li><a href="#" id="' . esc_attr($id) . '_prev" class="scrolling-list-control-left template-arrow-horizontal-3"></a></li>
			<li><a href="#" id="' . esc_attr($id) . '_next" class="scrolling-list-control-right template-arrow-horizontal-3"></a></li>
		</ul>';
	}
	return $output;
}

$count = array();
for($i=1; $i<=30; $i++)
	$count[$i] = $i;
	
$params = array(
	array(
		"type" => "textfield",
		"class" => "",
		"heading" => __("Id", 'medicenter'),
		"param_name" => "id",
		"value" => "testimonials",
		"description" => __("Please provide unique id for each testimonials carousel on the same page/post", 'medicenter')
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Controls position", 'medicenter'),
		"param_name" => "controls_position",
		"value" => array(__("Default", 'medicenter') => "default",  __("Bottom", 'medicenter') => "bottom")
	),
	array(
		"type" => "textfield",
		"class" => "",
		"heading" => __("Header", 'medicenter'),
		"param_name" => "header",
		"value" => "",
		"dependency" => Array('element' => "controls_position", 'value' => 'default')
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Header border animation", 'medicenter'),
		"param_name" => "animation",
		"value" => array(__("no", 'medicenter') => 0,  __("yes", 'medicenter') => 1),
		"dependency" => Array('element' => "controls_position", 'value' => 'default')
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Layout", 'medicenter'),
		"param_name" => "layout",
		"value" => array(__("2 columns", 'medicenter') => "sm-6",  __("1 column", 'medicenter') => "sm-12")
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Number of testimonials", 'medicenter'),
		"param_name" => "testimonials_count",
		"value" => $count
	)
);
for($i=0; $i<30; $i++)
{
	$params[] = array(
		"type" => "textfield",
		"heading" => __("Title", 'medicenter') . " " . ($i+1),
		"param_name" => "testimonials_title" . $i,
		"value" => __("Sample Sentence Text", 'medicenter')
	);
	$params[] = array(
		"type" => "textfield",
		"class" => "",
		"heading" => __("Author", 'medicenter') . " " . ($i+1),
		"param_name" => "testimonials_author" . $i,
		"value" => __("&#8212;  Sample Author", 'medicenter')
	);
}
$params = array_merge($params, array(
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Quote icon", 'medicenter'),
		"param_name" => "icon",
		"value" => array(__("Yes", 'medicenter') => 1,  __("No", 'medicenter') => 0)
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Autoplay", 'medicenter'),
		"param_name" => "autoplay",
		"value" => array(__("No", 'medicenter') => 0, __("Yes", 'medicenter') => 1)
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Pause on hover", 'medicenter'),
		"param_name" => "pause_on_hover",
		"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
		"dependency" => Array('element' => "autoplay", 'value' => '1')
	),
	array(
		"type" => "textfield",
		"class" => "",
		"heading" => __("Scroll", 'medicenter'),
		"param_name" => "scroll",
		"value" => 1,
		"description" => __("Number of items to scroll in one step", 'medicenter')
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Effect", 'medicenter'),
		"param_name" => "effect",
		"value" => array(
			__("scroll", 'medicenter') => "scroll", 
			__("none", 'medicenter') => "none", 
			__("directscroll", 'medicenter') => "directscroll",
			__("fade", 'medicenter') => "_fade",
			__("crossfade", 'medicenter') => "crossfade",
			__("cover", 'medicenter') => "cover",
			__("uncover", 'medicenter') => "uncover"
		)
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Sliding easing", 'medicenter'),
		"param_name" => "easing",
		"value" => array(
			__("swing", 'medicenter') => "swing", 
			__("linear", 'medicenter') => "linear", 
			__("easeInQuad", 'medicenter') => "easeInQuad",
			__("easeOutQuad", 'medicenter') => "easeOutQuad",
			__("easeInOutQuad", 'medicenter') => "easeInOutQuad",
			__("easeInCubic", 'medicenter') => "easeInCubic",
			__("easeOutCubic", 'medicenter') => "easeOutCubic",
			__("easeInOutCubic", 'medicenter') => "easeInOutCubic",
			__("easeInQuart", 'medicenter') => "easeInQuart",
			__("easeOutQuart", 'medicenter') => "easeOutQuart",
			__("easeInOutQuart", 'medicenter') => "easeInOutQuart",
			__("easeInSine", 'medicenter') => "easeInSine",
			__("easeOutSine", 'medicenter') => "easeOutSine",
			__("easeInOutSine", 'medicenter') => "easeInOutSine",
			__("easeInExpo", 'medicenter') => "easeInExpo",
			__("easeOutExpo", 'medicenter') => "easeOutExpo",
			__("easeInOutExpo", 'medicenter') => "easeInOutExpo",
			__("easeInQuint", 'medicenter') => "easeInQuint",
			__("easeOutQuint", 'medicenter') => "easeOutQuint",
			__("easeInOutQuint", 'medicenter') => "easeInOutQuint",
			__("easeInCirc", 'medicenter') => "easeInCirc",
			__("easeOutCirc", 'medicenter') => "easeOutCirc",
			__("easeInOutCirc", 'medicenter') => "easeInOutCirc",
			__("easeInElastic", 'medicenter') => "easeInElastic",
			__("easeOutElastic", 'medicenter') => "easeOutElastic",
			__("easeInOutElastic", 'medicenter') => "easeInOutElastic",
			__("easeInBack", 'medicenter') => "easeInBack",
			__("easeOutBack", 'medicenter') => "easeOutBack",
			__("easeInOutBack", 'medicenter') => "easeInOutBack",
			__("easeInBounce", 'medicenter') => "easeInBounce",
			__("easeOutBounce", 'medicenter') => "easeOutBounce",
			__("easeInOutBounce", 'medicenter') => "easeInOutBounce"
		)
	),
	array(
		"type" => "textfield",
		"class" => "",
		"heading" => __("Sliding transition speed (ms)", 'medicenter'),
		"param_name" => "duration",
		"value" => 500
	),
	/*array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Slide on touch", 'medicenter'),
		"param_name" => "ontouch",
		"value" => array(__("No", 'medicenter') => 0, __("Yes", 'medicenter') => 1)
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Slide on mouse", 'medicenter'),
		"param_name" => "onmouse",
		"value" => array(__("No", 'medicenter') => 0, __("Yes", 'medicenter') => 1)
	),*/
	array(
		"type" => "textfield",
		"heading" => __("Extra class name", 'medicenter'),
		"param_name" => "el_class",
		"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'medicenter')
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Top margin", 'medicenter'),
		"param_name" => "top_margin",
		"value" => array(__("None", 'medicenter') => "none", __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section")
	)
));
vc_map( array(
	"name" => __("Testimonials", 'medicenter'),
	"base" => "mc_testimonials",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-testimonials",
	"category" => __('MediCenter', 'medicenter'),
	"params" => $params
));
?>