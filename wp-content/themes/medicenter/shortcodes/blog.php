<?php
//blog
function mc_theme_blog($atts)
{
	global $themename;
	extract(shortcode_atts(array(
		"mc_pagination" => 1,
		"items_per_page" => 4,
		"featured_image_size" => "default",
		"layout_type" => 1,
		"layout_kind" => "column",
		"ids" => "",
		"category" => "",
		"order_by" => "date",
		"order" => "DESC",
		"show_post_title" => 1,
		"show_post_excerpt" => 1,
		"excerpt_length" => 0,
		"read_more" => 0,
		"show_post_categories" => 1,
		"show_post_author" => 1,
		"show_post_date_box" => 1,
		"show_post_comments_box" => 1,
		"show_post_comments_label" => 0,
		"post_date_animation" => "",
		"post_date_animation_duration" => 600,
		"post_date_animation_delay" => 0,
		"post_comments_animation" => "",
		"post_comments_animation_duration" => 600,
		"post_comments_animation_delay" => 0,
		"show_post_date_footer" => 0,
		"show_post_comments_footer" => 0,
		"is_search_results" => 0,
		"el_class" => "",
		"top_margin" => 'none'
	), $atts));
	
	$featured_image_size = str_replace("mc_", "", $featured_image_size);
	
	$ids = explode(",", $ids);
	if($ids[0]=="-" || $ids[0]=="")
	{
		unset($ids[0]);
		$ids = array_values($ids);
	}	
	$category = explode(",", $category);
	if($category[0]=="-" || $category[0]=="")
	{
		unset($category[0]);
		$category = array_values($category);
	}
	global $paged;
	$paged = (get_query_var((is_front_page() ? 'page' : 'paged'))) ? get_query_var((is_front_page() ? 'page' : 'paged')) : 1;
	$args = array(
		'post__in' => $ids,
		'post_type' => 'post',
		'post_status' => 'publish',
		'paged' => $paged,
		'posts_per_page' => $items_per_page,
		'cat' => (get_query_var('cat')!="" ? get_query_var('cat') : ''),
		'category_name' => (get_query_var('cat')=="" ? implode(",", $category) : ''),
		'tag' => get_query_var('tag'),
		'monthnum' => get_query_var('monthnum'),
		'day' => get_query_var('day'),
		'year' => get_query_var('year'),
		'w' => get_query_var('week'),
		'orderby' => implode(" ", explode(",", $order_by)),
		'order' => $order
	);
	if((int)$is_search_results && !empty(get_query_var('s')))
	{
		$args['s'] = get_query_var('s');
	}
	query_posts($args);
	global $wp_query;
	$post_count = $wp_query->post_count;
	
	$output = '';
	if((int)$layout_type==2)
		$output .= '<div class="columns clearfix layout-' . esc_attr($layout_kind) . '">';
	$i = 0;
	if(have_posts()) : while (have_posts()) : the_post();
		if($layout_kind=="row")
		{
			if($i==0 || $i%2==0)
			{
				if($i%2==0 && $i>0)
				{
					$output .= '</ul>';
				}
				$output .= '<ul class="blog clearfix' . ($i==0 ? ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') : '') . '">';
			}
		}
		else
		{
			if($i==0 || ((int)$layout_type==2 && $i==ceil($post_count/2)))
			{
				if($i==ceil($post_count/2))
					$output .= '</ul>';
				$output .= '<ul class="blog' . ((int)$layout_type==3 ? ' simple' : '') . ((int)$layout_type==2 ? ($i==ceil($post_count/2) ? ' vc_col-sm-6 wpb_column vc_column_container' : ' vc_col-sm-6 wpb_column vc_column_container') : ' clearfix') . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">';
			}
		}
		$post_classes = get_post_class("post");
		$output .= '<li class="' . ((int)$layout_type==3 ? 'item-content ' : ((int)$layout_type==2 && $layout_kind=="row" ? 'vc_col-sm-6 wpb_column vc_column_container ' : ''));
		foreach($post_classes as $key=>$post_class)
			$output .= ' ' . esc_attr($post_class);
		$output .= '">';
		if((int)$layout_type!=3)
		{
			if((int)$layout_type!=2 || (int)$show_post_date_box || (int)$show_post_comments_box)
			{
			$output .= '<ul class="comment-box clearfix">';
							if((int)$layout_type!=2 || (int)$show_post_date_box)
							{
							$output .= '<li class="date' . ((int)$layout_type!=2 ? ' clearfix' : '' ) . ($post_date_animation!='' ? ' animated-element animation-' . esc_attr($post_date_animation) . ((int)$post_date_animation_duration>0 && (int)$post_date_animation_duration!=600 ? ' duration-' . (int)esc_attr($post_date_animation_duration) : '') . ((int)$post_date_animation_delay>0 ? ' delay-' . (int)esc_attr($post_date_animation_delay) : '') : '') . '">
								<div class="value">' . strtoupper(date_i18n(get_option('date_format'), get_post_time())) . '</div>
								<div class="arrow-date"></div>
							</li>';
							}
							if((int)$show_post_comments_box)
							{
							$output .= '<li class="comments-number' . ($post_comments_animation!='' ? ' animated-element animation-' . esc_attr($post_comments_animation) . ((int)$post_comments_animation_duration>0 && (int)$post_comments_animation_duration!=600 ? ' duration-' . (int)esc_attr($post_comments_animation_duration) : '') . ((int)$post_comments_animation_delay>0 ? ' delay-' . (int)esc_attr($post_comments_animation_delay) : '') : '') . '">';
							$comments_count = get_comments_number();
		$output .= '			<a href="' . esc_url(get_comments_link()) . '" title="' . esc_attr($comments_count) . ' ' . ($comments_count==1 ? esc_attr__('COMMENT', 'medicenter') : esc_attr__('COMMENTS', 'medicenter')) . '">' . $comments_count . ((int)$show_post_comments_label ? ' ' . ($comments_count==1 ? __('COMMENT', 'medicenter') : __('COMMENTS', 'medicenter')) : '') . '</a>
							</li>';
							}
			$output .= '</ul>';
			}
			$output .= '<div class="post-content">';
						$show_images_in = get_post_meta(get_the_ID(), $themename . "_show_images_in", true);
						$attachment_ids = get_post_meta(get_the_ID(), $themename . "_attachment_ids", true);
						$images = get_post_meta(get_the_ID(), $themename . "_images", true);
						$images_count = count((array)$images);
						if($images_count>0 && ($show_images_in=="blog" || $show_images_in=="both"))
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
									' . get_the_post_thumbnail(get_the_ID(), ($featured_image_size!="default" ? $featured_image_size : ($layout_type==2 ? $themename . "-gallery-image" : "blog-post-thumb")), array("alt" => get_the_title(), "title" => "")) . '
										<ul class="controls">
											<li>
												<a href="' . esc_url($large_image_url) . '" title="" class="fancybox template-plus-2 open-lightbox" rel="featured-post' . ($features_images_loop=="yes" ? '[' . esc_attr(get_the_ID()) . ']' : '') . '"></a>
											</li>
										</ul>
									</li>';
								}
							for($j=0; $j<$images_count; $j++)
							{
								$output .= '<li>' .
									wp_get_attachment_image((int)$attachment_ids[$j], ($featured_image_size!="default" ? $featured_image_size : ($layout_type==2 ? $themename . "-gallery-image" : "blog-post-thumb")), array("alt "=> "")) . '
										<ul class="controls">
											<li>
												<a' . (isset($external_urls[$j]) && $external_urls[$j]!="" ? ' target="_blank"' : '') . ' href="' . (isset($external_urls[$j]) && $external_urls[$j]!="" ? $external_urls[$j] : (isset($iframes[$j]) && $iframes[$j]!="" ? $iframes[$j] : (isset($videos[$j]) && $videos[$j]!="" ? $videos[$j] : $images[$j]))) . '" title="' . (isset($images_titles[$j]) ? esc_attr($images_titles[$j]) : '') . '" class="template-plus-2 fancybox' . (isset($external_urls[$j]) && $external_urls[$j]!="" ? '-externalurl' : (isset($iframes[$j]) && $iframes[$j]!="" ? '-iframe' : (isset($videos[$j]) && $videos[$j]!="" ? '-video' : '' ))) . ' open-' . ((isset($external_urls[$j]) && $external_urls[$j]!="") || (isset($iframes[$j]) && $iframes[$j]!="") ? 'iframe-' : (isset($videos[$j]) && $videos[$j]!="" ? 'video-' : '' )) . 'lightbox" rel="featured-post' . ($features_images_loop=="yes" && ($images_count>1 || has_post_thumbnail()) ? '[' . esc_attr(get_the_ID()) . ']' : '') . '"></a>
											</li>
										</ul>
									</li>';
							}
							$output .= '</ul>
							</div>';
						}
						else if(has_post_thumbnail())
							$output .= '<a class="post-image" href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '"><span class="mc-preloader"></span>' . get_the_post_thumbnail(get_the_ID(), ($featured_image_size!="default" ? $featured_image_size : ($layout_type==2 ? $themename . "-gallery-image" : "blog-post-thumb")), array("alt" => get_the_title(), "title" => "")) . '</a>';	
		}
		else
		{
			if(has_post_thumbnail())
				$output .= '<a class="thumb-image" href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '">' . get_the_post_thumbnail(get_the_ID(), ($featured_image_size!="default" ? $featured_image_size : $themename . "-small-thumb"), array("alt" => get_the_title(), "title" => "")) . '</a>';	
			else
			{
				$attachment_ids = get_post_meta(get_the_ID(), $themename . "_attachment_ids", true);
				$images = get_post_meta(get_the_ID(), $themename . "_images", true);
				$images_count = count((array)$images);
				if($images_count>0)		
					$output .= '<a class="thumb-image" href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '">' . wp_get_attachment_image((int)$attachment_ids[0], ($featured_image_size!="default" ? $featured_image_size : $themename . "-small-thumb"), array("alt "=> get_the_title(), "title" => "")) . '</a>';	
			}
		}
						if((int)$layout_type==3)
							$output .= '<div class="text">';
						if((int)$show_post_title)
							$output .= ((int)$layout_type==3 ? '<h3> ' : '<h2 class="post-title">' ) . '<a href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '">' . get_the_title() . '</a>' . ((int)$layout_type==3 ? '</h3> ' : '</h2>' );
						if((int)$show_post_excerpt)
						{	
							$excerpt = apply_filters('the_excerpt', get_the_excerpt());
							$output .= apply_filters('the_excerpt', (!has_excerpt() && (int)$excerpt_length && strlen($excerpt)>=(int)$excerpt_length && strpos($excerpt, ' ', (int)$excerpt_length) ? substr($excerpt, 0, strpos($excerpt, ' ', (int)$excerpt_length)) . "..." : get_the_excerpt()) . ((int)$read_more && (int)$layout_type==3 ? '<a title="' . esc_attr__('Read more', 'medicenter') . '" href="' . esc_url(get_permalink()) . '" class="more template-arrow-horizontal-1-after">' . __('Read more', 'medicenter') . '</a>' : ''));
						}
						if((int)$layout_type==3)
							$output .=  '</div>';
							if((int)$read_more && (int)$layout_type!=3)
								$output .= '<a title="' . __('Read more', 'medicenter') . '" href="' . esc_url(get_permalink()) . '" class="more template-arrow-horizontal-1-after">' . __('Read more', 'medicenter') . '</a>';
							if((int)$show_post_categories || (int)$show_post_author || (int)$show_post_date_footer || (int)$show_post_comments_footer)
							{
		$output .= '		<div class="post-footer clearfix">
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
								if((int)$show_post_date_footer)
								{
								$output .= '<li class="post-footer-date">
										' . strtoupper(date_i18n(get_option('date_format'), get_post_time())) . '
									</li>';
								}
								if((int)$show_post_comments_footer)
								{
								$comments_count = get_comments_number();
								$output .= '<li class="post-footer-comments">
										' . __('Comments:', 'medicenter') . ' <a href="' . esc_url(get_comments_link()) . '" title="' . esc_attr($comments_count) . ' ' . ($comments_count==1 ? __('comment', 'medicenter') : __('comments', 'medicenter')) . '">' . $comments_count . '</a>
									</li>';
								}
							$output .= '</ul></div>';
							}
		$output .= ((int)$layout_type!=3 ? '</div>' : '') .	'</li>';
		$i++;
	endwhile; 
	elseif(is_search()):
		$output .= '<div class="vc_row wpb_row vc_row-fluid page-margin-top">' . sprintf(__('No results found for %s', 'medicenter'), esc_attr(get_query_var('s'))) . '</div>';
	endif;
	$output .= '</ul>';
	if((int)$layout_type==2)
		$output .= '</div>';
	
	if($mc_pagination)
	{
		mc_get_theme_file("/pagination.php");
		$output .= mc_pagination(false, '', 2, false, false, '', 'page-margin-top');
	}
	//Reset Query
	wp_reset_query();
	return $output;
}

//visual composer
function mc_theme_blog_vc_init()
{
	//get posts list
	global $medicenter_posts_array;

	//get categories
	$post_categories = get_terms("category");
	$post_categories_array = array();
	$post_categories_array[__("All", 'medicenter')] = "-";
	foreach($post_categories as $post_category)
		$post_categories_array[$post_category->name] =  $post_category->slug;
	
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
		"name" => __("Blog", 'medicenter'),
		"base" => "blog",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-blog",
		"category" => __('MediCenter', 'medicenter'),
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Pagination", 'medicenter'),
				"param_name" => "mc_pagination",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Items per page/Post count", 'medicenter'),
				"param_name" => "items_per_page",
				"value" => 4,
				"description" => __("Items per page if pagination is set to 'yes' or post count otherwise. Set -1 to display all.", 'medicenter')
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
				"heading" => __("Layout type", 'medicenter'),
				"param_name" => "layout_type",
				"value" => array(__("Type 1", 'medicenter') => 1, __("Type 2 (2 columns)", 'medicenter') => 2, __("Type 3 (simple)", 'medicenter') => 3)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Layout kind", 'medicenter'),
				"param_name" => "layout_kind",
				"value" => array(__("Columns layout", 'medicenter') => "column", __("Rows layout", 'medicenter') => "row"),
				"description" => __("How posts should be displayed: row by row or column by column", 'medicenter'),
				"dependency" => Array('element' => "layout_type", 'value' => '2')
			),
			array(
				"type" => (count($medicenter_posts_array) ? "dropdownmulti" : "textfield"),
				"type" => "dropdownmulti",
				"class" => "",
				"heading" => __("Display selected", 'medicenter'),
				"param_name" => "ids",
				"value" => (count($medicenter_posts_array) ? $medicenter_posts_array : ''),
				"description" => (count($medicenter_posts_array) ? '' : __("Please provide post ids separated with commas, to display only selected posts", 'medicenter'))
			),
			array(
				"type" => "dropdownmulti",
				"class" => "",
				"heading" => __("Display from Category", 'medicenter'),
				"param_name" => "category",
				"value" => $post_categories_array
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Order by", 'medicenter'),
				"param_name" => "order_by",
				"value" => array(__("Date", 'medicenter') => "date", __("Title, menu order", 'medicenter') => "title menu_order", __("Menu order", 'medicenter') => "menu_order")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Order", 'medicenter'),
				"param_name" => "order",
				"value" => array( __("descending", 'medicenter') => "DESC", __("ascending", 'medicenter') => "ASC")
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
				"heading" => __("Show post excerpt", 'medicenter'),
				"param_name" => "show_post_excerpt",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Excerpt length", 'medicenter'),
				"param_name" => "excerpt_length",
				"value" => 0,
				"description" => __("The excerpt length. Set 0 to use default WordPress excerpt length.", 'medicenter'),
				"dependency" => Array('element' => "show_post_excerpt", 'value' => "1")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Read more button", 'medicenter'),
				"param_name" => "read_more",
				"value" => array(__("No", 'medicenter') => 0, __("Yes", 'medicenter') => 1)
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
				"heading" => __("Show post date in box above post", 'medicenter'),
				"param_name" => "show_post_date_box",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"dependency" => Array('element' => "layout_type", 'value' => '2')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show comments number in box above/beside the post", 'medicenter'),
				"param_name" => "show_post_comments_box",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"dependency" => Array('element' => "layout_type", 'value' => array('1','2'))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show comments number label in box above/beside the post", 'medicenter'),
				"param_name" => "show_post_comments_label",
				"value" => array(__("No", 'medicenter') => 0, __("Yes", 'medicenter') => 1),
				"dependency" => Array('element' => "layout_type", 'value' => array('1','2'))
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
				),
				"dependency" => Array('element' => "layout_type", 'value' =>  array('1', '2'))
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Post date box animation duration (ms)", 'medicenter'),
				"param_name" => "post_date_animation_duration",
				"value" => "600",
				"dependency" => Array('element' => "layout_type", 'value' =>  array('1', '2'))
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Post date box animation delay (ms)", 'medicenter'),
				"param_name" => "post_date_animation_delay",
				"value" => "0",
				"dependency" => Array('element' => "layout_type", 'value' =>  array('1', '2'))
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
				),
				"dependency" => Array('element' => "layout_type", 'value' =>  array('1', '2'))
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Post comments box animation duration (ms)", 'medicenter'),
				"param_name" => "post_comments_animation_duration",
				"value" => "600",
				"dependency" => Array('element' => "layout_type", 'value' =>  array('1', '2'))
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Post comments box animation delay (ms)", 'medicenter'),
				"param_name" => "post_comments_animation_delay",
				"value" => "0",
				"dependency" => Array('element' => "layout_type", 'value' =>  array('1', '2'))
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show post date in post footer", 'medicenter'),
				"param_name" => "show_post_date_footer",
				"value" => array(__("No", 'medicenter') => 0, __("Yes", 'medicenter') => 1)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show comments number in post footer", 'medicenter'),
				"param_name" => "show_post_comments_footer",
				"value" => array(__("No", 'medicenter') => 0, __("Yes", 'medicenter') => 1)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Is search results component", 'medicenter'),
				"param_name" => "is_search_results",
				"value" => array(__("No", 'medicenter') => 0, __("Yes", 'medicenter') => 1)
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
add_action("init", "mc_theme_blog_vc_init");
?>
