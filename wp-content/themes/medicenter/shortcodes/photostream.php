<?php
function mc_theme_photostream_shortcode($atts)
{
	global $themename;
	extract(shortcode_atts(array(
		"id" => "photostream",
		"images" => "",
		"featured_image_size" => "default",
		"images_loop" => 1,
		"hover_icons" => 1,
		"top_margin" => "none"
	), $atts));
	
	$featured_image_size = str_replace("mc_", "", $featured_image_size);
	
	$output = '<ul class="photostream clearfix ' . (!empty($featured_image_size) ? esc_attr($featured_image_size) : 'default') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">';
	$images = explode(',', $images);
	foreach($images as $attach_id)
	{
		
		$attachment = get_posts(array('p' => $attach_id, 'post_type' => 'attachment'));
		if(count($attachment))
		{
			$output .= '<li class="gallery-box' . ((int)$hover_icons==0 ? ' hover-icons-off' : '') . '">' . wp_get_attachment_image($attach_id, ($featured_image_size!="default" ? $featured_image_size : $themename . "-small-thumb"), false, array("alt" => ""/*, "class" => "mc_preload"*/));
			$output .= '<ul class="controls">
					<li>
						<a href="' . (isset($attachment) ? esc_url($attachment[0]->guid) : '') . '" rel=photostream' . ((int)$images_loop ? '[' . esc_attr($id) . ']' : '') . '" class="fancybox open-lightbox template-plus-2"></a>
					</li>
				</ul>
			</li>';
		}		
	}
	$output .= '</ul>';
	return $output;
}

//visual composer
class WPBakeryShortCode_Photostream extends WPBakeryShortCode {
	public function content( $atts, $content = null ) {
        return mc_theme_photostream_shortcode($atts);
    }
   public function singleParamHtmlHolder($param, $value) 
   {
		global $themename;
		$output = '';
        // Compatibility fixes
        $old_names = array('yellow_message', 'blue_message', 'green_message', 'button_green', 'button_grey', 'button_yellow', 'button_blue', 'button_red', 'button_orange');
        $new_names = array('alert-block', 'alert-info', 'alert-success', 'btn-success', 'btn', 'btn-info', 'btn-primary', 'btn-danger', 'btn-warning');
        $value = str_ireplace($old_names, $new_names, $value);
        //$value = __($value, "js_composer");
        //
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
                $img = wpb_getImageBySize(array( 'attach_id' => (int)$image, 'thumb_size' => $themename . '-small-thumb' ));
                $output .= ( $img ? '<li>'.$img['thumbnail'].'</li>' : '<li><img width="150" height="150" test="'.esc_attr($image).'" src="' . WPBakeryVisualComposer::getInstance()->assetURL('vc/blank.gif') . '" class="attachment-thumbnail" alt="" title="" /></li>');
            }
            $output .= '</ul>';
            $output .= '<a href="#" class="column_edit_trigger' . ( !empty($images_ids) ? ' image-exists' : '' ) . '">' . __( 'Add images', 'medicenter' ) . '</a>';

        }
        return $output;
		/*global $themename;
        $output = '';
        // Compatibility fixes
        $old_names = array('yellow_message', 'blue_message', 'green_message', 'button_green', 'button_grey', 'button_yellow', 'button_blue', 'button_red', 'button_orange');
        $new_names = array('alert-block', 'alert-info', 'alert-success', 'btn-success', 'btn', 'btn-info', 'btn-primary', 'btn-danger', 'btn-warning');
        $value = str_ireplace($old_names, $new_names, $value);
        //$value = __($value, "js_composer");
        //
        $param_name = isset($param['param_name']) ? $param['param_name'] : '';
        $type = isset($param['type']) ? $param['type'] : '';
        $class = isset($param['class']) ? $param['class'] : '';

        if ( isset($param['holder']) == false || $param['holder'] == 'hidden' ) {
            $output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.$value.'" />';
        }
        else {
            $output .= '<'.$param['holder'].' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">'.$value.'</'.$param['holder'].'>';
        }
        if($param_name == 'images') {
            $images_ids = empty($value) ? array() : explode(',', trim($value));
            $output .= '<ul class="attachment-thumbnails'.( empty($images_ids) ? ' image-exists' : '' ).'">';
            foreach($images_ids as $image) {
                $img = wpb_getImageBySize(array( 'attach_id' => (int)$image, 'thumb_size' => $themename . '-small-thumb' ));
                $output .= ( $img ? '<li>'.$img['thumbnail'].'</li>' : '<li><img width="150" height="150" test="'.$image.'" src="' . WPBakeryVisualComposer::getInstance()->assetURL('vc/blank.gif') . '" class="attachment-thumbnail" alt="" title="" /></li>');
            }
            $output .= '</ul>';
            $output .= '<a href="#" class="column_edit_trigger' . ( !empty($images_ids) ? ' image-exists' : '' ) . '">' . __( 'Add images', 'js_composer' ) . '</a>';

        }
        return $output;*/
    }
}

//visual composer
function mc_theme_photostream_vc_init()
{
	//image sizes
	$image_sizes_array = array();
	$image_sizes_array[__("Default", 'medicenter')] = "default";
	$image_sizes_array[__("full (original image resolution)", 'medicenter')] = "full";
	global $_wp_additional_image_sizes;
	foreach(get_intermediate_image_sizes() as $s) 
	{
		if(isset($_wp_additional_image_sizes[$s])) 
		{
			$width = intval($_wp_additional_image_sizes[$s]['width']);
			$height = intval($_wp_additional_image_sizes[$s]['height']);
		} 
		else
		{
			$width = get_option($s.'_size_w');
			$height = get_option($s.'_size_h');
		}
		$image_sizes_array[$s . " (" . $width . "x" . $height . ")"] = "mc_" . $s;
	}
	vc_map( array(
		"name" => __("Photostream", 'medicenter'),
		"base" => "photostream",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-photostream",
		"category" => __('MediCenter', 'medicenter'),
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Id", 'medicenter'),
				"param_name" => "id",
				"value" => "photostream",
				"description" => __("Please provide unique id for each photostream on the same page/post", 'medicenter')
			),
			array(
				"type" => "attach_images",
				"class" => "",
				"heading" => __("Images", 'medicenter'),
				"param_name" => "images",
				"value" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Featured image size", 'medicenter'),
				"param_name" => "featured_image_size",
				"value" => $image_sizes_array
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Featured images lightbox loop", 'medicenter'),
				"param_name" => "images_loop",
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
		)
	));
}
add_action("init", "mc_theme_photostream_vc_init");
?>
