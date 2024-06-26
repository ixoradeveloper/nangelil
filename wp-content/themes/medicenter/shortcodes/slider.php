<?php
//slider
function mc_theme_slider($atts)
{
	extract(shortcode_atts(array(
		"id" => ""
	), $atts));
	$slider_options = mc_theme_stripslashes_deep(get_option($id));
	if($slider_options)
	{
		$output = '';
		$slides_count = count($slider_options["slider_image_url"]);
		if($slides_count)
		{
			$output .= '<ul class="slider ' . esc_attr($id) . ' id-' . esc_attr($id) . ' autoplay-' . esc_attr($slider_options['slider_autoplay']) . ' interval-' . esc_attr($slider_options['slide_interval']) . ' effect-' . esc_attr($slider_options['slider_effect']) . ' easing-' . esc_attr($slider_options['slider_transition']) . ' duration-' . esc_attr($slider_options['slider_transition_speed']) . /*((int)$ontouch ? ' ontouch' : '') . ((int)$onmouse ? ' onmouse' : '') .*/ '">';
			for($i=0; $i<$slides_count; $i++)
			{
				
				$output .= '<li id="slide-' . absint($i) . '" style="background-image: url(' . esc_url($slider_options["slider_image_url"][$i]) . ');' . (isset($slider_options["slider_image_link"][$i]) && $slider_options["slider_image_link"][$i]!="" ? ' cursor: pointer;' : '') . '"' . (isset($slider_options["slider_image_link"][$i]) && $slider_options["slider_image_link"][$i]!="" ? ' onclick="javascript:window.location.href=\'' . esc_url($slider_options["slider_image_link"][$i]) . '\'; return false;"' : '') . '>
					&nbsp;</li>';
			}
			$output .= '</ul>';
		}
		
		$output .= '<style>';
		$slider_styles = array();
		if(!empty($slider_options["slider_height"]) && $slider_options["slider_height"]!=670) {
			$proportion = $slider_options["slider_height"]/670;
			$slider_styles = array(				
				"height" => array(
					$slider_options["slider_height"], 
					floor(520*$proportion), 
					floor(315*$proportion), 
					floor(210*$proportion)),
				"margin-top" => array(
					floor(577*$proportion), 
					floor(488*$proportion), 
					floor(285*$proportion), 
					floor(195*$proportion)),
				"min-height" =>array(
					floor((577*$proportion)-210),
					floor((488*$proportion)-200),
					floor((285*$proportion)-55),
					floor((195*$proportion)-20),
				),				
			);
			$output .= '
				.slider li { 
					height: ' . $slider_styles["height"][0] . 'px;
				}
				.slider-content-box
				{
					margin-top: -' . $slider_styles["margin-top"][0] . 'px;
					min-height: ' . $slider_styles["min-height"][0] . 'px;
				}
				@media screen and (max-width: 1009px) {
					.slider li { 
						height: ' . $slider_styles["height"][1] . 'px;
					}
					.slider-content-box
					{
						margin-top: -' . $slider_styles["margin-top"][1] . 'px;
						min-height: ' . $slider_styles["min-height"][1] . 'px;
					}
				}
				@media screen and (max-width: 767px) {
					.slider li { 
						height: ' . $slider_styles["height"][2] . 'px; 
					}
					.slider-content-box
					{
						margin-top: -' . $slider_styles["margin-top"][2] . 'px;
						min-height: ' . $slider_styles["min-height"][2] . 'px;
					}	
				}
				@media screen and (max-width: 479px) {
					.slider li { 
						height: ' . $slider_styles["height"][3] . 'px; 
					}
					.slider-content-box
					{
						margin-top: -' . $slider_styles["margin-top"][3] . 'px;
						min-height: ' . $slider_styles["min-height"][3] . 'px;
					}
				}';
		}
		if(isset($slider_options['slider_navigation'])) {
			$display = $slider_options['slider_navigation']==1 ? "block" : "none";
			$output .= '
				.slider-navigation {
					display: ' . $display . '
				}';
		}
		$output .= '</style>';
	}
	return $output;
}

//slider content
function mc_theme_slider_content($atts)
{
	extract(shortcode_atts(array(
		"id" => ""
	), $atts));
	$slider_options = mc_theme_stripslashes_deep(get_option($id));
	if($slider_options)
	{
		$output = "";
		$slides_count = count($slider_options["slider_image_url"]);
		if($slides_count)
		{
			$output .= '<div class="slider-content-box vc_row clearfix">';
			for($i=0; $i<$slides_count; $i++)
			{
				if(isset($slider_options["slider_image_title"][$i]) || isset($slider_options["slider_image_subtitle"][$i]))
				{
					$output .= '<div id="slide-' . absint($i) . '-content" class="slider-content"' . ($i==0 || (isset($slider_options["slider_image_link"][$i]) && $slider_options["slider_image_link"][$i]!="") ? ' style="' . ($i==0 ? 'display: block;' : '') . (isset($slider_options["slider_image_link"][$i]) && $slider_options["slider_image_link"][$i]!="" ? ' cursor: pointer;' : '') . '"' : '') . (isset($slider_options["slider_image_link"][$i]) && $slider_options["slider_image_link"][$i]!="" ? ' onclick="javascript:window.location.href=\'' . esc_url($slider_options["slider_image_link"][$i]) . '\'; return false;"' : '') . '>';
					if(isset($slider_options["slider_image_title"][$i]))
						$output .= '<h1 class="title">' . $slider_options["slider_image_title"][$i] . '</h1>';
					if(isset($slider_options["slider_image_subtitle"][$i]))
						$output .= '<h2 class="subtitle">' . $slider_options["slider_image_subtitle"][$i] . '</h2>';
					$output .= '</div>';
				}
			}
			$output .= '</div>';
		}
	}
	return $output;
}
?>
