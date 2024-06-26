<?php
//author
function mc_theme_doctor_box($atts)
{
	global $themename;
	extract(shortcode_atts(array(
		"title_box" => 1,
		"display_social_icons" => 1,
		"hover_icons" => 1,
		"top_margin" => "none"
	), $atts));
	
	global $post;
	setup_postdata($post);
	
	$output = '';
	$attachment_ids = get_post_meta(get_the_ID(), $themename . "_attachment_ids", true);
	$images = get_post_meta(get_the_ID(), $themename . "_images", true);
	$images_count = count((array)$images);
	$arrayEmpty = true;
	for($i=0; $i<$images_count; $i++)
		if((int)$attachment_ids)
			$arrayEmpty = false;
	$output .= '<div class="gallery-box doctor-box'.((int)$hover_icons==0 ? ' hover-icons-off' : '').'">';
	if(!$arrayEmpty)
		$output .= '<ul class="image-carousel">';
	$features_images_loop = get_post_meta(get_the_ID(), $themename . "_features_images_loop", true);
	if(has_post_thumbnail())
	{
		$image_title = get_post_meta(get_the_ID(), "image_title", true);
		$video_url = get_post_meta(get_the_ID(), "video_url", true);
		if($video_url!="")
			$large_image_url = $video_url;
		else
		{
			$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), "large");
			$large_image_url = $attachment_image[0];
		}
		$external_url = get_post_meta(get_the_ID(), "external_url", true);
		$external_url_target = get_post_meta(get_the_ID(), "external_url_target", true);
		$iframe_url = get_post_meta(get_the_ID(), "iframe_url", true);
		if(!$arrayEmpty)
			$output .= '<li>';
		$output .= '<span class="mc-preloader"></span>
			' . get_the_post_thumbnail(get_the_ID(), $themename . "-gallery-image", array("alt" => get_the_title(), "title" => "", "class" => "mc-preload")) . '
			<ul class="controls">
				<li>
					<a' . ($external_url!="" && $external_url_target=="new_window" ? ' target="_blank"' : '') . ' href="' . ($external_url=="" ? ($iframe_url!="" ? $iframe_url . "?iframe=true" : $large_image_url) : $external_url) . '" class="template-plus-2 fancybox' . ($video_url!="" ? '-video' : ($iframe_url!="" ? '-iframe' : ($external_url!="" ? '-url' : ''))) . ' open' . ($video_url!="" ? '-video' : ($iframe_url!="" ? '-iframe' : ($external_url!="" ? '-url' : ''))) . '-lightbox" rel="featured-doctor' . ($features_images_loop=="yes" && !$arrayEmpty ? '[' . esc_attr(get_the_ID()) . ']' : '') . '"' . ($image_title!="" ? ' title="' . esc_attr($image_title) . '"' : '') . '></a>
				</li>
			</ul>';
		if(!$arrayEmpty)
			$output .= '</li>';
	}
	if(!$arrayEmpty)
	{
		$images_titles = get_post_meta(get_the_ID(), $themename . "_images_titles", true);
		$videos = get_post_meta(get_the_ID(), $themename . "_videos", true);
		$iframes = get_post_meta(get_the_ID(), $themename . "_iframes", true);
		$external_urls = get_post_meta(get_the_ID(), $themename . "_external_urls", true);
		for($i=0; $i<$images_count; $i++)
		{
			if((int)$attachment_ids[$i])
				$output .= '<li>' . ($i==0 && !has_post_thumbnail() ? '<span class="mc-preloader"></span>' : '') .
					wp_get_attachment_image((int)$attachment_ids[$i], $themename . "-gallery-image", array("alt "=> "")) . '
					<ul class="controls">
						<li>
							<a' . ($external_urls[$i]!="" ? ' target="_blank"' : '') . ' href="' . ($external_urls[$i]=="" ? ($iframes[$i]!="" ? $iframes[$i] : ($videos[$i]!="" ? $videos[$i] : $images[$i])) : $external_urls[$i]) . '" title="' . esc_attr($images_titles[$i]) . '" class="template-plus-2 fancybox' . ($videos[$i]!="" ? '-video' : ($iframes[$i]!="" ? '-iframe' : ($external_urls[$i]!="" ? '-url' : ''))) . ' open' . ($videos[$i]!="" ? '-video' : ($iframes[$i]!="" ? '-iframe' : ($external_urls[$i]!="" ? '-url' : ''))) . '-lightbox" rel="featured-doctor' . ($features_images_loop=="yes" ? '[' . esc_attr(get_the_ID()) . ']' : '') . '"></a>
						</li>
					</ul>
				</li>';
		}
	}
	if(!$arrayEmpty)
		$output .= '</ul>';
	if((int)$title_box)
	{
		$output .= '<div class="description">
				<h3>' . get_the_title() . '</h3>
				<h5>' . get_post_meta(get_the_ID(), "subtitle", true) . '</h5>
			</div>';
	}
	$output .= '</div>';
	if((int)$display_social_icons)
	{
		$icon_type = (array)get_post_meta(get_the_ID(), "social_icon_type", true);
		$arrayEmpty = true;
		for($i=0; $i<count($icon_type); $i++)
		{
			if($icon_type[$i]!="")
				$arrayEmpty = false;
		}
		if(!$arrayEmpty)
		{
			$icon_url = get_post_meta(get_the_ID(), "social_icon_url", true);
			$icon_target = get_post_meta(get_the_ID(), "social_icon_target", true);
			$output .= '<ul class="social-icons clearfix">';
			for($i=0; $i<count($icon_type); $i++)
			{
				if($icon_type[$i]!="")
					$output .= '<li><a class="social-' . esc_attr($icon_type[$i]) . '" href="' . esc_url($icon_url[$i]) . '"' . ($icon_target[$i]=='new_window' ? ' target="_blank"' : '') . ' title="">&nbsp;</a></li>';
			}
			$output .= '</ul>';
		}
	}
	return $output;
}

//visual composer
function mc_theme_doctor_box_vc_init()
{
	$params = array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Title box", 'medicenter'),
			"param_name" => "title_box",
			"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Display social icons", 'medicenter'),
			"param_name" => "display_social_icons",
			"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Hover icons", 'medicenter'),
			"param_name" => "hover_icons",
			"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => "0")
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
		"name" => __("Doctor Box", 'medicenter'),
		"base" => "doctor_box",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-custom-post-type",
		"category" => __('MediCenter', 'medicenter'),
		"params" => $params
	));
}
add_action("init", "mc_theme_doctor_box_vc_init");
?>
