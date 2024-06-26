<?php
//post
function mc_theme_our_clients($atts)
{
	global $theme_options;
	extract(shortcode_atts(array(
		"images" => "",
		"onclick" => "link_image",
		"custom_links" => "",
		"custom_links_target" => "",
		"top_margin" => "none",
		"el_class" => ""
	), $atts));
	if ($onclick=="custom_link")
		$custom_links = explode(',', $custom_links);
	$output = "";
	$output .= '<div class="our-clients-list-container' . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . '">
					<ul class="our-clients-list">';
	$images = explode(',', $images);
	$i = 0;
	foreach($images as $attach_id)
	{
		$output .= '<li class="vertical-align">';
		$output .= '<div class="our-clients-item-container"><div class="vertical-align-cell">';
		if($onclick=="link_image")
		{
			$attachment_image = wp_get_attachment_image_src($attach_id, "full");
			if($attachment_image)
			{
				$image_url = $attachment_image[0];
				$output .= '<a href="' . esc_url($image_url) . '" class="fancybox">' . wp_get_attachment_image($attach_id, "full", false, array("alt" => "")) . '</a>';
			}
		}
		else if($onclick=="custom_link" && isset($custom_links[$i]) && $custom_links[$i]!="")
			$output .= '<a href="' . esc_url($custom_links[$i]) . '"' . ($custom_links_target=="_blank" ? ' target="_blank"' : '') . '>' . wp_get_attachment_image($attach_id, "full", false, array("alt" => "")) . '</a>';
		else
			$output .= wp_get_attachment_image($attach_id, "full", false, array("alt" => ""));
		$output .= '</div></div></li>';
		$i++;
	}
	$output .= '</ul></div>';
	return $output;
}

//visual composer
class WPBakeryShortCode_Our_Clients extends WPBakeryShortCode {
	public function content( $atts, $content = null ) {
        return mc_theme_our_clients($atts);
    }
   public function singleParamHtmlHolder($param, $value) {
		$output = '';
        // Compatibility fixes
        $old_names = array('yellow_message', 'blue_message', 'green_message', 'button_green', 'button_grey', 'button_yellow', 'button_blue', 'button_red', 'button_orange');
        $new_names = array('alert-block', 'alert-info', 'alert-success', 'btn-success', 'btn', 'btn-info', 'btn-primary', 'btn-danger', 'btn-warning');
        $value = str_ireplace($old_names, $new_names, $value);

        $param_name = isset($param['param_name']) ? $param['param_name'] : '';
        $type = isset($param['type']) ? $param['type'] : '';
        $class = isset($param['class']) ? $param['class'] : '';

        if ( isset($param['holder']) == true && $param['holder'] !== 'hidden' ) {
            $output .= '<'.$param['holder'].' class="wpb_vc_param_value ' . esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) . '" name="' . esc_attr($param_name) . '">'.$value.'</'.$param['holder'].'>';
        }
        if($param_name == 'images') {
            $images_ids = empty($value) ? array() : explode(',', trim($value));
            $output .= '<ul class="attachment-thumbnails'.( empty($images_ids) ? ' image-exists' : '' ).'" data-name="' . esc_attr($param_name) . '">';
            foreach($images_ids as $image) {
                $img = wpb_getImageBySize(array( 'attach_id' => (int)$image, 'thumb_size' => 'small-thumb' ));
                $output .= ( $img ? '<li>'.$img['thumbnail'].'</li>' : '<li><img width="150" height="150" test="'.esc_attr($image).'" src="' . WPBakeryVisualComposer::getInstance()->assetURL('vc/blank.gif') . '" class="attachment-thumbnail" alt="" title="" /></li>');
            }
            $output .= '</ul>';
            $output .= '<a href="#" class="column_edit_trigger' . ( !empty($images_ids) ? ' image-exists' : '' ) . '">' . __( 'Add images', 'medicenter' ) . '</a>';

        }
        return $output;
	}
}
//visual composer
function mc_theme_our_clients_vc_init()
{
	$target_arr = array(
		__( 'Same window', 'medicenter' ) => '_self',
		__( 'New window', 'medicenter' ) => "_blank"
	);
	$params = array(
		array(
			'type' => 'attach_images',
			'heading' => __( 'Images', 'medicenter' ),
			'param_name' => 'images',
			'value' => '',
			'description' => __( 'Select images from media library.', 'medicenter' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'On click action', 'medicenter' ),
			'param_name' => 'onclick',
			'value' => array(
				__( 'Open prettyPhoto', 'medicenter' ) => 'link_image',
				__( 'None', 'medicenter' ) => 'link_no',
				__( 'Open custom links', 'medicenter' ) => 'custom_link'
			),
			'description' => __( 'Select action for click event.', 'medicenter' )
		),
		array(
			'type' => 'exploded_textarea',
			'heading' => __( 'Custom links', 'medicenter' ),
			'param_name' => 'custom_links',
			'description' => __( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'medicenter' ),
			'dependency' => array(
				'element' => 'onclick',
				'value' => array( 'custom_link' )
			)
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Custom link target', 'medicenter' ),
			'param_name' => 'custom_links_target',
			'description' => __( 'Select how to open custom links.', 'medicenter' ),
			'dependency' => array(
				'element' => 'onclick',
				'value' => array( 'custom_link' )
			),
			'value' => $target_arr
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
		"name" => __("Our Clients List", 'medicenter'),
		"base" => "our_clients",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-carousel",
		"category" => __('MediCenter', 'medicenter'),
		"params" => $params
	));
}
add_action("init", "mc_theme_our_clients_vc_init");
?>
