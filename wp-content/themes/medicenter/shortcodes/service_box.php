<?php
//author
function mc_theme_service_box($atts)
{
	extract(shortcode_atts(array(
		"featured_image" => '',
		"headers" => 1,
		"headers_links" => 1,
		"show_excerpt" => 1,
		"show_featured_image" => 1,
		"featured_image_links" => 1,
		"class" => "",
		"top_margin" => "none"
	), $atts));
	
	global $post;
	setup_postdata($post);
	
	$output = "";
	$output .= '<div class="services-list single' . (!empty($class) ? ' ' . esc_attr($class) : '') . (!empty($top_margin) && $top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '"><div class="service-box">';
	$external_url = get_post_meta(get_the_ID(), "external_url", true);
	$external_url_target = get_post_meta(get_the_ID(), "external_url_target", true);
	if((int)$show_featured_image)
	{
		if((int)$featured_image_links)
			$output .= '<a' . ($external_url!="" && $external_url_target=="new_window" ? ' target="_blank"' : '') . ' href="' . ($external_url!="" ? esc_url($external_url) : esc_url(get_permalink())) . '" title="' . esc_attr(get_the_title()) . '">';
		if(!empty($featured_image))
		{
			$featured_image_id = preg_replace('/[^\d]/', '', $featured_image);
			$output .= wp_get_attachment_image($featured_image_id, "medium-thumb");
		}
		else
			$output .= get_the_post_thumbnail(get_the_ID(), "medium-thumb" , array("alt" => get_the_title(), "title" => ""));
		if((int)$featured_image_links)
			$output .= '</a>';
	}
	$arrayEmpty = true;
	if((int)$headers || ((int)$show_excerpt && has_excerpt()))
		$output .= '<div class="service-details">';
	if((int)$headers)
		$output .= '<h4>' . ((int)$headers ? ((int)$headers_links ? '<a' . ($external_url!="" && $external_url_target=="new_window" ? ' target="_blank"' : '') . ' href="' . ($external_url!="" ? esc_url($external_url) : esc_url(get_permalink())) . '" title="' . esc_attr(get_the_title()) . '">' : '') . get_the_title() .  ((int)$headers_links ? '</a>' : '') : '') . '</h4>';
	if((int)$show_excerpt && has_excerpt())
		$output .= apply_filters('the_excerpt', get_the_excerpt());
	if((int)$headers || ((int)$show_excerpt && has_excerpt()))
		$output .= '</div>';
	if(!$arrayEmpty)
	{
		$icon_url = get_post_meta(get_the_ID(), "social_icon_url", true);
		$icon_target = get_post_meta(get_the_ID(), "social_icon_target", true);
		$output .= '<ul class="social-icons' . (!(int)$show_featured_image ? ' social-static clearfix' : '') . '">';
		for($j=0; $j<count($icon_type); $j++)
		{
			if($icon_type[$j]!="")
				$output .= '<li><a class="social-' . esc_attr($icon_type[$j]) . '" href="' . esc_url($icon_url[$j]) . '"' . ($icon_target[$j]=='new_window' ? ' target="_blank"' : '') . ' title="">&nbsp;</a></li>';
		}
		$output .= '</ul>';
	}
	$output .= '</div></div>';
		
	return $output;
}

//visual composer
function mc_theme_service_box_vc_init()
{
	$params = array(
		array(
			"type" => "attach_image",
			"class" => "",
			"heading" => __("Alternative featured image", 'medicenter'),
			"param_name" => "featured_image",
			"value" => ''
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Header", 'medicenter'),
			"param_name" => "headers",
			"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Header link", 'medicenter'),
			"param_name" => "headers_links",
			"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show excerpt", 'medicenter'),
			"param_name" => "show_excerpt",
			"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show featured image", 'medicenter'),
			"param_name" => "show_featured_image",
			"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Featured image link", 'medicenter'),
			"param_name" => "featured_image_links",
			"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
			"dependency" => Array('element' => "show_featured_image", 'value' => '1')
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
		"name" => __("Service Box", 'medicenter'),
		"base" => "service_box",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-custom-post-type",
		"category" => __('MediCenter', 'medicenter'),
		"params" => $params
	));
}
add_action("init", "mc_theme_service_box_vc_init");
?>
