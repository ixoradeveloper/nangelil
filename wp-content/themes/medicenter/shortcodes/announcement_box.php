<?php
function mc_theme_announcement_box_shortcode($atts, $content)
{
	extract(shortcode_atts(array(
		"header" => "",
		"bg_image" => "",
		"button_label" => "",
		"button_url" => "",
		"button_size" => "medium",
		"button_style" => "dark-color",
		"button_icon" => "none",
		"button_color" => "#3156a3",
		"button_custom_color" => "",
		"button_hover_color" => "#3156a3",
		"button_hover_custom_color" => "",
		"button_text_color" => "#FFFFFF",
		"button_hover_text_color" => "#FFFFFF",
		"animation" => "",
		"animation_duration" => "600",
		"animation_delay" => "0",
		"top_margin" => "none",
		"el_class" => ""
	), $atts));
	
	if(!empty($bg_image))
	{
		$attachment_image = wp_get_attachment_image_src($bg_image, "full");
		$image_url = $attachment_image[0];
	}
	$button_color = ($button_custom_color!="" ? $button_custom_color : $button_color);
	$button_hover_color = ($button_hover_custom_color!="" ? $button_hover_custom_color : $button_hover_color);
	
	$output = '<div class="announcement clearfix vertical-align-table' . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . (!empty($image_url) ? ' mc-background' : '') . '"' . (!empty($image_url) ? ' style="background-image: url(' . esc_url($image_url) . ');"' : '') . '>
					<ul class="vertical-align">
						<li class="vertical-align-cell">' . ($header!="" ? '<h2>' . $header . '</h2>' : '')	. wpb_js_remove_wpautop(apply_filters('the_content', $content)) . '</li>';
	if($button_label!="")
		$output .= '<li class="vertical-align-cell">
						<a' . (!empty($button_style) && $button_style=="custom" ? ($button_color!="" || $button_text_color!="" ? ' style="' . ($button_color!="" ? 'background-color:' . esc_attr($button_color) . ';border-color:' . esc_attr($button_color) . ';' : '') . ($button_text_color!="" ? 'color:' . esc_attr($button_text_color) . ';': '') . '"' : '') . ($button_hover_color!="" || $button_hover_text_color!="" ? ' onMouseOver="' . ($button_hover_color!="" ? 'this.style.backgroundColor=\''.esc_attr($button_hover_color).'\';this.style.borderColor=\''.esc_attr($button_hover_color).'\';' : '' ) . ($button_hover_text_color!="" ? 'this.style.color=\''.esc_attr($button_hover_text_color).'\';' : '' ) . '" onMouseOut="' . ($button_hover_color!="" ? 'this.style.backgroundColor=\''.esc_attr($button_color).'\';this.style.borderColor=\''.esc_attr($button_color).'\';' : '' ) . ($button_hover_text_color!="" ? 'this.style.color=\''.esc_attr($button_text_color).'\';' : '') . '"' : '') : '') . ' title="' . esc_attr($button_label) . '" href="' . esc_attr($button_url) . '" class="more mc-button' . (!empty($button_style) && $button_style!="custom" ? ' ' . esc_attr($button_style) : '') . ' ' . esc_attr($button_size) . ($button_icon!="none" ? ' ' . esc_attr($button_icon) : '') . ($animation!='' ? ' animated-element animation-' . esc_attr($animation) . ((int)$animation_duration>0 && (int)$animation_duration!=600 ? ' duration-' . (int)esc_attr($animation_duration) : '') . ((int)$animation_delay>0 ? ' delay-' . (int)esc_attr($animation_delay) : '') : '') . '">' . $button_label . ($button_icon!="none" && substr($button_icon, 0, 8)!="template" ? '<i class="icon"></i>' : '') . '</a>
					</li>';
	$output .= '</ul>
			</div>';
	return $output;
}

//visual composer
$mc_colors_arr = array(__("Dark blue", "medicenter") => "#3156a3", __("Blue", "medicenter") => "#0384ce", __("Light blue", "medicenter") => "#42b3e5", __("Black", "medicenter") => "#000000", __("Gray", "medicenter") => "#AAAAAA", __("Dark gray", "medicenter") => "#444444", __("Light gray", "medicenter") => "#CCCCCC", __("Green", "medicenter") => "#43a140", __("Dark green", "medicenter") => "#008238", __("Light green", "medicenter") => "#7cba3d", __("Orange", "medicenter") => "#f17800", __("Dark orange", "medicenter") => "#cb451b", __("Light orange", "medicenter") => "#ffa800", __("Red", "medicenter") => "#db5237", __("Dark red", "medicenter") => "#c03427", __("Light red", "medicenter") => "#f37548", __("Turquoise", "medicenter") => "#0097b5", __("Dark turquoise", "medicenter") => "#006688", __("Turquoise", "medicenter") => "#00b6cc", __("Light turquoise", "medicenter") => "#00b6cc", __("Violet", "medicenter") => "#6969b3", __("Dark violet", "medicenter") => "#3e4c94", __("Light violet", "medicenter") => "#9187c4", __("White", "medicenter") => "#FFFFFF", __("Yellow", "medicenter") => "#fec110");
$mc_icons_arr = array(
	__("None", "medicenter") => "none",
	__("Horizontal arrow", "medicenter") => "template-arrow-horizontal-1-after",
	__("Circle arrow", "medicenter") => "template-arrow-circle-after",
	__("Cart", "medicenter") => "template-cart-after",
	__("Search", "medicenter") => "template-search-after",
	__("Mail", "medicenter") => "template-mail-after",
	__("Phone", "medicenter") => "template-phone-after",
	__("Location", "medicenter") => "template-location-after",
	__("Comment", "medicenter") => "template-comment-1-after",
	__("Address book icon", "medicenter") => "wpb_address_book",
	__("Alarm clock icon", "medicenter") => "wpb_alarm_clock",
	__("Anchor icon", "medicenter") => "wpb_anchor",
	__("Application Image icon", "medicenter") => "wpb_application_image",
	__("Arrow icon", "medicenter") => "wpb_arrow",
	__("Asterisk icon", "medicenter") => "wpb_asterisk",
	__("Hammer icon", "medicenter") => "wpb_hammer",
	__("Balloon icon", "medicenter") => "wpb_balloon",
	__("Balloon Buzz icon", "medicenter") => "wpb_balloon_buzz",
	__("Balloon Facebook icon", "medicenter") => "wpb_balloon_facebook",
	__("Balloon Twitter icon", "medicenter") => "wpb_balloon_twitter",
	__("Battery icon", "medicenter") => "wpb_battery",
	__("Binocular icon", "medicenter") => "wpb_binocular",
	__("Document Excel icon", "medicenter") => "wpb_document_excel",
	__("Document Image icon", "medicenter") => "wpb_document_image",
	__("Document Music icon", "medicenter") => "wpb_document_music",
	__("Document Office icon", "medicenter") => "wpb_document_office",
	__("Document PDF icon", "medicenter") => "wpb_document_pdf",
	__("Document Powerpoint icon", "medicenter") => "wpb_document_powerpoint",
	__("Document Word icon", "medicenter") => "wpb_document_word",
	__("Bookmark icon", "medicenter") => "wpb_bookmark",
	__("Camcorder icon", "medicenter") => "wpb_camcorder",
	__("Camera icon", "medicenter") => "wpb_camera",
	__("Chart icon", "medicenter") => "wpb_chart",
	__("Chart pie icon", "medicenter") => "wpb_chart_pie",
	__("Clock icon", "medicenter") => "wpb_clock",
	__("Fire icon", "medicenter") => "wpb_fire",
	__("Heart icon", "medicenter") => "wpb_heart",
	__("Mail icon", "medicenter") => "wpb_mail",
	__("Play icon", "medicenter") => "wpb_play",
	__("Shield icon", "medicenter") => "wpb_shield",
	__("Video icon", "medicenter") => "wpb_video"
);
vc_map( array(
	"name" => __("Announcement box", 'medicenter'),
	"base" => "announcement_box",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-announcement-box",
	"category" => __('MediCenter', 'medicenter'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Header", 'medicenter'),
			"param_name" => "header",
			"value" => ""
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content", 'medicenter'),
			"param_name" => "content",
			"value" => ""
		),
		array(
			"type" => "attach_image",
			"heading" => __("Background image", 'medicenter'),
			"param_name" => "bg_image",
			"value" => "",
			"description" => __("Select background image from media library.", 'medicenter')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Button label", 'medicenter'),
			"param_name" => "button_label",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Button url", 'medicenter'),
			"param_name" => "button_url",
			"value" => ""
		),
		/*array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button color", 'medicenter'),
			"param_name" => "button_color",
			"value" => array(__("Dark blue", 'medicenter') => "blue", __("Blue", 'medicenter') => "dark_blue", __("Light", 'medicenter') => "light")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("or pick custom button color", 'medicenter'),
			"param_name" => "custom_button_color",
			"value" => ""
		),*/
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button size", 'medicenter'),
			"param_name" => "button_size",
			"value" => array(__("Medium", 'medicenter') => "medium", __("Tiny", 'medicenter') => "tiny", __("Small", 'medicenter') => "small", __("Large", 'medicenter') => "large")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button style", 'medicenter'),
			"param_name" => "button_style",
			"value" => array(__("Dark color", 'medicenter') => "dark-color", __("Light color", 'medicenter') => "light-color", __("Light", 'medicenter') => "light", __("Custom...", 'medicenter') => "custom")
		),
		array(
			"type" => "dropdown",
			"heading" => __("Button icon", 'medicenter' ),
			"param_name" => "button_icon",
			"value" => $mc_icons_arr
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button text color", 'medicenter'),
			"param_name" => "button_text_color",
			"value" => "#FFFFFF",
			"dependency" => Array('element' => "button_style", 'value' => 'custom')
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button Hover text color", 'medicenter'),
			"param_name" => "button_hover_text_color",
			"value" => "#FFFFFF",
			"dependency" => Array('element' => "button_style", 'value' => 'custom')
		),
        array(
            "type" => "dropdown",
            "heading" => __("Button color", "medicenter"),
            "param_name" => "button_color",
            "value" => $mc_colors_arr,
			"dependency" => Array('element' => "button_style", 'value' => 'custom')
        ),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("or pick custom button color", 'medicenter'),
			"param_name" => "button_custom_color",
			"value" => "",
			"dependency" => Array('element' => "button_style", 'value' => 'custom')
		),
		array(
            "type" => "dropdown",
            "heading" => __("Button hover Color", "medicenter"),
            "param_name" => "button_hover_color",
            "value" => $mc_colors_arr,
			"dependency" => Array('element' => "button_style", 'value' => 'custom')
        ),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => __("or pick custom button hover color", 'medicenter'),
			"param_name" => "button_hover_custom_color",
			"value" => "",
			"dependency" => Array('element' => "button_style", 'value' => 'custom')
		),
		array(
            "type" => "dropdown",
            "heading" => __("Button animation", "medicenter"),
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
			"heading" => __("Button animation duration", 'medicenter'),
			"param_name" => "animation_duration",
			"value" => "600"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Button animation delay", 'medicenter'),
			"param_name" => "animation_delay",
			"value" => "0"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'medicenter'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'medicenter') => "none", __("Page (small)", 'medicenter') => "page-margin-top", __("Section (large)", 'medicenter') => "page-margin-top-section")
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name", "medicenter"),
			"param_name" => "el_class",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'medicenter' )
		)
	)
));
?>
