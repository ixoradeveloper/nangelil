<?php
function mc_theme_tabs($atts, $content)
{
	extract(shortcode_atts(array(
		"width" => ""
	), $atts));
	
	$output .= '<div class="tabs"' . ($width!="" ? ' style="width: ' . esc_attr($width) . 'px"' : '') . '>
		' . do_shortcode($content) . '
	</div>';
	return $output;
}

function mc_theme_tabs_navigation($atts, $content)
{	
	$output .= '<ul class="clearfix tabs_navigation">
		' . do_shortcode($content) . '
	</ul>';
	return $output;
}

function mc_theme_tab($atts, $content)
{	
	global $themename;
	extract(shortcode_atts(array(
		"id" => ""
	), $atts));
	if($id!="")
	{
		$output .= '<li>
			<a title="' . esc_attr($content) . '" href="#' . esc_attr($id) . '">
				' . do_shortcode($content) . '
			</a>
		</li>';
	}
	else
		$output .= __("Attribute id is required. For example [tab id='tab-1']", 'medicenter');
	return $output;
}

function mc_theme_tab_content($atts, $content)
{
	global $themename;
	extract(shortcode_atts(array(
		"id" => ""
	), $atts));
	
	if($id!="")
	{
		$output .= '<div id="' . esc_attr($id) . '">
			' . do_shortcode(apply_filters("the_content", $content)) . '
		</div>';
	}
	else
		$output .= __("Attribute id is required. For example [tab_content id='tab-1']", 'medicenter');
	return $output;
}
?>