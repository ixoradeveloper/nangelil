<?php
//home box container
function mc_theme_home_box_container($atts, $content)
{
	return '<ul class="home_box_container clearfix">' . shortcode_unautop(do_shortcode($content)) . '</ul>';
}

//home box
function mc_theme_home_box($atts, $content)
{
	extract(shortcode_atts(array(
		"color" => "white"
	), $atts));
	
	$output = '<li class="home_box ' . esc_attr($color) . '">' . shortcode_unautop(do_shortcode($content)) . '</li>';
	return $output;
}

//news
function mc_theme_news($atts, $content)
{
	extract(shortcode_atts(array(
		"icon" => "note"
	), $atts));
	
	$output = '<div class="news clearfix">';
	if($icon!="" && $icon!="none")
		$output .= '<span class="banner_icon ' . esc_attr($icon) . '"></span>';
	$output .= '<div class="text">' . do_shortcode($content) . '</div>';
	return $output;
}
?>
