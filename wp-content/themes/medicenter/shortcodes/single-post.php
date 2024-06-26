<?php
//post
function mc_theme_single_post($atts)
{
	global $themename;
	global $terms_checkbox, $terms_message, $comments_form_animation, $comments_form_animation_duration, $comments_form_animation_delay;
	extract(shortcode_atts(array(
		"featured_image_size" => "default",
		"columns" => 1,
		"show_post_title" => 1,
		"show_post_featured_image" => 1,
		"featured_image_action" => 'lightbox',
		"show_post_categories" => 1,
		"show_post_author" => 1,
		"comments" => 1,
		"terms_checkbox" => 0,
		"terms_message" => "UGxlYXNlJTIwYWNjZXB0JTIwdGVybXMlMjBhbmQlMjBjb25kaXRpb25z",
		"comments_form_animation" => "",
		"comments_form_animation_duration" => 600,
		"comments_form_animation_delay" => 0,
		"show_post_date_box" => 1,
		"show_post_comments_box" => 1,
		"show_post_comments_label" => 0,
		"post_date_animation" => "",
		"post_date_animation_duration" => 600,
		"post_date_animation_delay" => 0,
		"post_comments_animation" => "",
		"post_comments_animation_duration" => 600,
		"post_comments_animation_delay" => 0,
		"el_class" => "",
		"top_margin" => 'none'
	), $atts));
	
	$featured_image_size = str_replace("mc_", "", $featured_image_size);
	
	global $post;
	setup_postdata($post);
	
	$output = "";
	if((int)$columns==2)
		$output .= '<div class="columns clearfix">';
	$output .= '<ul class="blog clearfix' . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">';
	$post_classes = get_post_class("post");
	$output .= '<li class="single ';
	foreach($post_classes as $key=>$post_class)
		$output .= ($key>0 ? ' ' : '') . esc_attr($post_class);
	$output .= '">';
				if((int)$columns!=2 || (int)$show_post_date_box || (int)$show_post_comments_box)
				{
				$output .= '<ul class="comment-box clearfix">';
					if((int)$columns!=2 || (int)$show_post_date_box)
					{
					$output .= '<li class="date' . ((int)$columns!=2 ? ' clearfix' : '' ) . ($post_date_animation!='' ? ' animated-element animation-' . esc_attr($post_date_animation) . ((int)$post_date_animation_duration>0 && (int)$post_date_animation_duration!=600 ? ' duration-' . (int)esc_attr($post_date_animation_duration) : '') . ((int)$post_date_animation_delay>0 ? ' delay-' . (int)esc_attr($post_date_animation_delay) : '') : '') . '">
						<div class="value">' . strtoupper(date_i18n(get_option('date_format'), get_post_time())) . '</div>
						<div class="arrow-date"></div>
					</li>';
					}
	if((int)$comments && ((int)$columns!=2 || (int)$show_post_comments_box))
	{
			$output .= '<li class="comments-number' . ($post_comments_animation!='' ? ' animated-element animation-' . esc_attr($post_comments_animation) . ((int)$post_comments_animation_duration>0 && (int)$post_comments_animation_duration!=600 ? ' duration-' . (int)esc_attr($post_comments_animation_duration) : '') . ((int)$post_comments_animation_delay>0 ? ' delay-' . (int)esc_attr($post_comments_animation_delay) : '') : '') . '">';
					$comments_count = get_comments_number();
	$output .= '		<a href="' . esc_url(get_comments_link()) . '" title="' . esc_attr($comments_count) . ' ' . ($comments_count==1 ? __('COMMENT', 'medicenter') : __('COMMENTS', 'medicenter')) . '">' . $comments_count . ((int)$show_post_comments_label ? ' ' . ($comments_count==1 ? __('COMMENT', 'medicenter') : __('COMMENTS', 'medicenter')) : '') . '</a>
					</li>';
	}
	$output .= '</ul>';
				}
				$output .= '<div class="post-content">';
				$show_images_in = get_post_meta(get_the_ID(), $themename . "_show_images_in", true);
				$attachment_ids = get_post_meta(get_the_ID(), $themename . "_attachment_ids", true);
				$images = get_post_meta(get_the_ID(), $themename . "_images", true);
				$images_count = count((array)$images);
				if($images_count>0 && ($show_images_in=="post" || $show_images_in=="both")  && $show_post_featured_image)
				{
					$images_titles = get_post_meta(get_the_ID(), $themename . "_images_titles", true);
					$videos = get_post_meta(get_the_ID(), $themename . "_videos", true);
					$iframes = get_post_meta(get_the_ID(), $themename . "_iframes", true);
					$external_urls = get_post_meta(get_the_ID(), $themename . "_external_urls", true);
					$features_images_loop = get_post_meta(get_the_ID(), $themename . "_features_images_loop", true);
					$hover_icons = get_post_meta(get_the_ID(), $themename . "_hover_icons", true);
					$output .= '<div class="gallery-box' . ($hover_icons=='no' ? ' hover-icons-off' : '') . '">
						<ul class="image-carousel">';
						if(has_post_thumbnail())
						{
							$thumb_id = get_post_thumbnail_id(get_the_ID());
							$attachment_image = wp_get_attachment_image_src($thumb_id, "large");
							$large_image_url = $attachment_image[0];
							$thumbnail_image = get_posts(array('p' => $thumb_id, 'post_type' => 'attachment'));
							$output .= '<li>
							' . get_the_post_thumbnail(get_the_ID(), ($featured_image_size!="default" ? $featured_image_size : ($columns==2 ? $themename . "-gallery-image" : "blog-post-thumb")), array("alt" => get_the_title(), "title" => "")) . '
								<ul class="controls">
									<li>
										<a href="' . esc_url($large_image_url) . '" title="" class="fancybox template-plus-2 open-lightbox" rel="featured-single-post' . ($features_images_loop=="yes" ? '[' . esc_attr(get_the_ID()) . ']' : '') . '"></a>
									</li>
								</ul>
							</li>';
						}
					for($j=0; $j<$images_count; $j++)
					{
						$output .= '<li>' .
							wp_get_attachment_image((int)$attachment_ids[$j], ($featured_image_size!="default" ? $featured_image_size : ($columns==2 ? $themename . "-gallery-image" : "blog-post-thumb")), array("alt "=> "")) . '
								<ul class="controls">
									<li>
										<a' . (!empty($external_urls[$j]) ? ' target="_blank"' : '') . ' href="' . (!empty($external_urls[$j]) ? $external_urls[$j] : (!empty($iframes[$j]) ? $iframes[$j] : (!empty($videos[$j]) ? $videos[$j] : $images[$j] ))) . '" title="' . (!empty($images_titles[$j]) ? esc_attr($images_titles[$j]) : "") . '" class="template-plus-2 fancybox' . (!empty($external_urls[$j]) ? '-externalurl' : (!empty($iframes[$j]) ? '-iframe' : (!empty($videos[$j]) ? '-video' : '' ))) . ' open-' . (!empty($external_urls[$j]) || !empty($iframes[$j]) ? 'iframe-' : (!empty($videos[$j]) ? 'video-' : '' )) . 'lightbox" rel="featured-single-post' . ($features_images_loop=="yes" && ($images_count>1 || has_post_thumbnail()) ? '[' . esc_attr(get_the_ID()) . ']' : '') . '"></a>	
									</li>
								</ul>
							</li>';
					}
					$output .= '</ul>
					</div>';
				}
				else if(has_post_thumbnail() && $show_post_featured_image)
				{
					if($featured_image_action=="lightbox")
					{
						$thumb_id = get_post_thumbnail_id(get_the_ID());
						$attachment_image = wp_get_attachment_image_src($thumb_id, "large");
						$large_image_url = $attachment_image[0];
					}
					$output .= '<a class="post-image' . ($featured_image_action=="lightbox" ? ' fancybox' : '') . '" href="' . ($featured_image_action=="lightbox" ? esc_url($large_image_url) : '#') . '" title="' . esc_attr(get_the_title()) . '"><span class="mc-preloader"></span>' . get_the_post_thumbnail(get_the_ID(), ($featured_image_size!="default" ? $featured_image_size : ($columns==2 ? $themename . "-gallery-image" : "blog-post-thumb")), array("alt" => "", "title" => "")) . '</a>';	
				}
	if($show_post_title) {
		$output .= '<h2 class="post-title">
						<a href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '">' . get_the_title() . '</a>
					</h2>';
	}
	if(get_post_type()=="post" || get_post_type()=="features" || get_post_type()=="departments")
		$output .= (function_exists("wpb_js_remove_wpautop") ? wpb_js_remove_wpautop(apply_filters('the_content', get_the_content())) : apply_filters('the_content', get_the_content()));
	
	$output .= wp_link_pages(array(
		"before" => '<ul class="pagination post-pagination page-margin-top"><li>',
		"after" => '</li></ul>',
		"link_before" => '<span>',
		"link_after" => '</span>',
		"separator" => '</li><li>',
		"echo" => 0
	));
					if((int)$comments)
					{
						$output .= '<a title="' . esc_attr__('Leave a reply', 'medicenter') . '" href="#comment_form" class="more template-arrow-horizontal-1-after reply-button">'
							. __('Leave a reply', 'medicenter') . '</a>';
					}
					if((int)$show_post_categories || (int)$show_post_author)
					{
	$output .= '	<div class="post-footer clearfix">
						<ul class="post-footer-details">';
						if((int)$show_post_author)
						{
						$output .= '<li class="post-footer-author">
								' . (get_the_author_meta("user_url")!="" ? '<a class="author" href="' . esc_url(get_the_author_meta("user_url")) . '" title="' . esc_attr(get_the_author()) . '">' . get_the_author() . '</a>' : get_the_author()) . '
							</li>';
						}
						if((int)$show_post_categories)
						{
							$categories = get_the_category();
							foreach($categories as $key=>$category)
							{
								$output .= '<li class="post-footer-category">
									<a href="' . esc_url(get_category_link($category->term_id )) . '" ';
								if(empty($category->description))
									$output .= 'title="' . sprintf(__('View all posts filed under %s', 'medicenter'), $category->name) . '"';
								else
									$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
								$output .= '>' . $category->name . '</a>' . ($category != end($categories) ? ', ' : '') . '
								</li>';
							}
						}
					$output .= '</ul></div>';
					}
	$output .= '</div>
			</li>
		</ul>';
	if((int)$columns==2)
		$output .= '</div>';
	if((int)$comments)
	{
		$output .= '<div class="comments clearfix' . (get_comments_number() ? ' page-margin-top' : '') . '">';
		ob_start();
		comments_template();	
		$output .= ob_get_contents();
		ob_end_clean();
		$output .= '</div>';
		ob_start();
		mc_get_theme_file("/comments-form.php");
		$output .= ob_get_contents();
		ob_end_clean();
	}
	return $output;
}

//visual composer
function mc_theme_single_post_vc_init()
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
	global $theme_options;
	vc_map( array(
		"name" => __("Post", 'medicenter'),
		"base" => "single_post",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-post",
		"category" => __('MediCenter', 'medicenter'),
		"params" => array(
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
				"heading" => __("Layout type", 'medicenter'),
				"param_name" => "columns",
				"value" => array(__("Type 1", 'medicenter') => 1, __("Type 2", 'medicenter') => 2)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show post title", 'medicenter'),
				"param_name" => "show_post_title",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show post featured image", 'medicenter'),
				"param_name" => "show_post_featured_image",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Featured image action", 'medicenter'),
				"param_name" => "featured_image_action",
				"value" => array(__("Lightbox", 'medicenter') => 'lightbox', __("No action", 'medicenter') => 'no_action'),
				"dependency" => Array('element' => "show_post_featured_image", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show post categories", 'medicenter'),
				"param_name" => "show_post_categories",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show post author", 'medicenter'),
				"param_name" => "show_post_author",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Comments", 'medicenter'),
				"param_name" => "comments",
				"value" => array(__("Enabled", 'medicenter') => 1, __("Disabled", 'medicenter') => 0)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Terms and conditions checkbox", 'medicenter'),
				"param_name" => "terms_checkbox",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"std" => 0,
				"dependency" => Array('element' => "comments", 'value' => "1")
			),
			array(
				"type" => "textarea_raw_html",
				"class" => "",
				"heading" => __("Terms and conditions message", 'medicenter'),
				"param_name" => "terms_message",
				"value" => "UGxlYXNlJTIwYWNjZXB0JTIwdGVybXMlMjBhbmQlMjBjb25kaXRpb25z",
				"dependency" => Array('element' => "terms_checkbox", 'value' => "1")
			),
			array(
				"type" => "readonly",
				"class" => "",
				"heading" => __("reCaptcha", 'medicenter'),
				"param_name" => "recaptcha",
				"value" => ((int)$theme_options["google_recaptcha_comments"] ? __("Yes", 'medicenter') : __("No", 'medicenter')),
				"description" => sprintf(__("You can change this setting under <a href='%s' title='Theme Options'>Theme Options</a>", 'medicenter'), esc_url(admin_url("themes.php?page=ThemeOptions"))),
				"dependency" => Array('element' => "comments", 'value' => "1")
			),
			array(
				"type" => "dropdown",
				"heading" => __("Comments form box animation", "medicenter"),
				"param_name" => "comments_form_animation",
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
				"dependency" => Array('element' => "comments", 'value' => '1')
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Comments form box animation duration (ms)", 'medicenter'),
				"param_name" => "comments_form_animation_duration",
				"value" => "600",
				"dependency" => Array('element' => "comments", 'value' => '1')
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Comments form box animation delay (ms)", 'medicenter'),
				"param_name" => "comments_form_animation_delay",
				"value" => "0",
				"dependency" => Array('element' => "comments", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show post date in box above post", 'medicenter'),
				"param_name" => "show_post_date_box",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"dependency" => Array('element' => "columns", 'value' => '2')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show comments number in box above post", 'medicenter'),
				"param_name" => "show_post_comments_box",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"dependency" => Array('element' => "columns", 'value' => '2')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show comments number label in box above post", 'medicenter'),
				"param_name" => "show_post_comments_label",
				"value" => array(__("No", 'medicenter') => 0, __("Yes", 'medicenter') => 1)
			),
			array(
				"type" => "dropdown",
				"heading" => __("Post date box animation", "medicenter"),
				"param_name" => "post_date_animation",
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
				"heading" => __("Post date box animation duration (ms)", 'medicenter'),
				"param_name" => "post_date_animation_duration",
				"value" => "600"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Post date box animation delay (ms)", 'medicenter'),
				"param_name" => "post_date_animation_delay",
				"value" => "0"
			),
			array(
				"type" => "dropdown",
				"heading" => __("Post comments box animation", "medicenter"),
				"param_name" => "post_comments_animation",
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
				"heading" => __("Post comments box animation duration (ms)", 'medicenter'),
				"param_name" => "post_comments_animation_duration",
				"value" => "600"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Post comments box animation delay (ms)", 'medicenter'),
				"param_name" => "post_comments_animation_delay",
				"value" => "0"
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'medicenter' ),
				'param_name' => 'el_class',
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'medicenter' ),
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
add_action("init", "mc_theme_single_post_vc_init");
?>
