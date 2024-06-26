<?php
function mc_theme_gallery_shortcode($atts, $content='', $tag='medicenter_gallery')
{
	global $themename;
	global $post;
	if(isset($_GET["atts"]))//$_GET["action"]=="theme_" . $atts['shortcode_type'] . "_pagination")
		$atts = unserialize(stripslashes($_GET["atts"]));
	extract(shortcode_atts(array(
		"shortcode_type" => "",
		"header" => "",
		"animation" => 0,
		"order_by" => "title,menu_order",
		"order" => "ASC",
		"style" => "default",
		"type" => "list_with_details",
		"layout" => "gallery-4-columns",
		"featured_image_size" => "default",
		"hover_icons" => 1,
		"title_box" => 1,
		"details_page" => "",
		"display_method" => "dm_filters",
		"all_label" => "",
		"id" => "carousel",
		"autoplay" => 0,
		"pause_on_hover" => 1,
		"scroll" => 1,
		"effect" => "scroll",
		"easing" => "swing",
		"duration" => 500,
		"items_per_page" => 4,
		"ajax_pagination" => 1,
		"category" => "",
		"ids" => "",
		"display_headers" => 1,
		"headers_type" => "h2",
		"display_social_icons" => 1,
		"images_loop" => 0,
		"el_class" => "",
		"top_margin" => "none"
	), $atts));

	$featured_image_size = str_replace("mc_", "", $featured_image_size);

	if($tag=="doctors" && $style=="light")
	{
		$type = "list";
		$layout = "gallery-2-columns";
		$hover_icons = 0;
	}
	if($display_method=="dm_carousel")
	{
		if($effect=="_fade")
			$effect = "fade";
		if(strpos('ease', $easing)!==false)
		{
			$newEasing = 'ease';
			if(strpos('InOut'. $easing)!==false)
				$newEasing .= 'InOut';
			else if(strpos('In'. $easing)!==false)
				$newEasing .= 'In';
			else if(strpos('Out'. $easing)!==false)
				$newEasing .= 'Out';
			$newEasing .= ucfirst(substr($easing, strlen($newEasing), strlen($easing)-strlen($newEasing)));
		}
		else
			$newEasing = $easing;
	}
	
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
	if(empty($shortcode_type))
	{
		$shortcode_type = $tag;
		$atts["shortcode_type"] = $shortcode_type;
	}
	$args = array( 
		'post__in' => $ids,
		'post_type' => ($shortcode_type=='gallery' ? 'medicenter_gallery' : $shortcode_type),
		'posts_per_page' => ($display_method=="dm_pagination" ? $items_per_page : '-1'),
		'post_status' => 'publish',
		($shortcode_type=='gallery' ? 'medicenter_gallery' : $shortcode_type) . '_category' => implode(",", $category),
		'orderby' => implode(" ", explode(",", $order_by)), 
		'order' => $order
	);
	if($display_method=="dm_pagination")
	{
		if(isset($_GET["action"]) && $_GET["action"]=="theme_" . $shortcode_type . "_pagination")
			$args['paged'] = (int)$_GET['paged'];
		else
			$args['paged'] = get_query_var('paged');
	}
	query_posts($args);
	global $wp_query; 
	$post_count = $wp_query->post_count;
	if(is_rtl() && $display_method=="dm_carousel")
	{
		$array_rev = array_reverse($wp_query->posts);
		$wp_query->posts = $array_rev;
	}
	
	$output = "";
	if(have_posts())
	{
		if($display_method=="dm_pagination" && ((isset($_GET["action"]) && $_GET["action"]!="theme_" . $shortcode_type . "_pagination") || !isset($_GET["action"])))
			$output .= "<div class='theme_" . esc_attr($shortcode_type) . "_pagination'>";
		//details
		if($type=="list_with_details" || $type=="details")
		{
			$output .= '<ul class="gallery-item-details-list clearfix' . ($type=="details" ? ' not-hidden' : ' margin-bottom') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . '">';
			while(have_posts()): the_post();
			$output .= '<li id="gallery-details-' . esc_attr($post->post_name) . '" class="gallery-item-details clearfix">
					<div class="vc_row wpb_row vc_row-fluid">
						<div class="vc_col-sm-6 wpb_column vc_column_container">';
							$attachment_ids = get_post_meta(get_the_ID(), $themename . "_attachment_ids", true);
							$images = get_post_meta(get_the_ID(), $themename . "_images", true);
							$images_count = count((array)$images);
							$arrayEmpty = true;
							for($i=0; $i<$images_count; $i++)
								if((int)$attachment_ids)
									$arrayEmpty = false;
							$output .= '<div class="gallery-box '.($hover_icons==0 ? 'hover-icons-off' : '').'">';
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
											<a' . ($external_url!="" && $external_url_target=="new_window" ? ' target="_blank"' : '') . ' href="' . ($external_url=="" ? ($iframe_url!="" ? $iframe_url . "?iframe=true" : $large_image_url) : $external_url) . '" class="template-plus-2 fancybox' . ($video_url!="" ? '-video' : ($iframe_url!="" ? '-iframe' : ($external_url!="" ? '-url' : ''))) . ' open' . ($video_url!="" ? '-video' : ($iframe_url!="" ? '-iframe' : ($external_url!="" ? '-url' : ''))) . '-lightbox" rel="featured-gallery' . ($features_images_loop=="yes" && !$arrayEmpty ? '[' . esc_attr(get_the_ID()) . ']' : '') . '"' . ($image_title!="" ? ' title="' . esc_attr($image_title) . '"' : '') . '></a>
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
													<a' . ($external_urls[$i]!="" ? ' target="_blank"' : '') . ' href="' . ($external_urls[$i]=="" ? ($iframes[$i]!="" ? $iframes[$i] : ($videos[$i]!="" ? $videos[$i] : $images[$i])) : $external_urls[$i]) . '" title="' . esc_attr($images_titles[$i]) . '" class="template-plus-2 fancybox' . ($videos[$i]!="" ? '-video' : ($iframes[$i]!="" ? '-iframe' : ($external_urls[$i]!="" ? '-url' : ''))) . ' open' . ($videos[$i]!="" ? '-video' : ($iframes[$i]!="" ? '-iframe' : ($external_urls[$i]!="" ? '-url' : ''))) . '-lightbox" rel="featured-gallery' . ($features_images_loop=="yes" ? '[' . esc_attr(get_the_ID()) . ']' : '') . '"></a>
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
					$output .= '</div>
					<div class="vc_col-sm-6 wpb_column vc_column_container">
						<div class="details-box">';
					if($type!="details")
					{
						$output .= '<ul class="controls' . (!(int)$display_headers ? ' clearfix' : '') . '">';
						if($post_count>1)
							$output .= '
									<li>
										<a href="#" class="prev template-arrow-horizontal-3"></a>
									</li>
									<li>
										<a href="#" class="next template-arrow-horizontal-3"></a>
									</li>
									<li class="separator">&nbsp;</li>';
						$output .= '<li>
										<a href="#gallery-details-close" class="close template-remove-1"></a>
									</li>';
						
						$output .= '
								</ul>';
					}
					if((int)$display_headers)
						$output .= '<' . $headers_type . ' class="box-header' . ((int)$animation ? ' animation-slide' : '') . '"> ' . get_the_title() . '</' . $headers_type . '>';
					if(defined('DOING_AJAX') && DOING_AJAX)
						WPBMap::addAllMappedShortcodes();
					$output .= (function_exists("wpb_js_remove_wpautop") ? wpb_js_remove_wpautop(($shortcode_type=="doctors" ? get_post_meta(get_the_ID(), "doctor_description", true) : get_the_content())) : apply_filters('the_content', get_the_content()));
					if($shortcode_type=="doctors")
					{
						$output .= '<div class="item-footer clearfix">';
						$output .= '<a title="' . esc_attr(get_the_title()) . '" href="' . esc_url(get_permalink()) . '" class="mc-button more light template-arrow-horizontal-1-after">' . __("PROFILE", 'medicenter') . '</a>';
						$timetable_page = get_post_meta(get_the_ID(), "timetable_page", true);
						if($timetable_page!="")
						{
							$output .= '<a title="' . esc_attr(get_the_title($timetable_page)) . '" href="' . esc_url(get_permalink($timetable_page)) . '" class="mc-button more light template-arrow-horizontal-1-after">' . get_the_title($timetable_page) . '</a>';
						}
						$output .= '</div>';
					}
					$output .= '</div></div>
				</div>';
			endwhile;
			$output .= '</ul>';
		}
		
		if($type!="details")
		{
			if($header!="" && $display_method!="dm_carousel")
				$output .= '<h3 class="box-header margin-bottom-30' . ((int)$animation ? ' animation-slide' : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">' . $header . '</h3>';

			//categories filters
			if($display_method=="dm_filters")
			{
				$categories_count = count($category);
				$output .= '<ul class="tabs-navigation isotope-filters clearfix">';
				if($all_label!="")
					$output .= '<li>
							<a class="selected" href="#filter-*" title="' . ($all_label!='' ? esc_attr($all_label) : '') . '">' . ($all_label!='' ? esc_attr($all_label) : '') . '</a>
						</li>';
				for($i=0; $i<$categories_count; $i++)
				{
					$term = get_term_by('slug', $category[$i], ($shortcode_type=='gallery' ? "medicenter_gallery" : $shortcode_type) . "_category");
					$output .= '<li>
							<a href="#filter-' . esc_attr(trim($category[$i])) . '" title="' . esc_attr($term->name) . '">' . $term->name . '</a>
						</li>';
				}
				$output .= '</ul>';
			}

			//list
			if($display_method=="dm_carousel")
				$output .= '<div class="clearfix scrolling-controls' . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">
				<div class="header-left">' . ($header!="" ? '<h3 class="box-header' . ((int)$animation ? ' animation-slide' : '') . '">' . $header . '</h3>' : '') . '</div>
				<div class="header-right"><a href="#" id="' . esc_attr($id) . '_prev" class="scrolling-list-control-left template-arrow-horizontal-3"></a><a href="#" id="' . esc_attr($id) . '_next" class="scrolling-list-control-right template-arrow-horizontal-3"></a></div></div>
				<ul class="mc-gallery ' . esc_attr($layout) . ' ' . esc_attr($display_method) . ' horizontal-carousel ' . esc_attr($id) . ' id-' . esc_attr($id) . ' autoplay-' . esc_attr($autoplay) . ' pause_on_hover-' . esc_attr($pause_on_hover) . ' scroll-' . esc_attr($scroll) . ' effect-' . esc_attr($effect) . ' easing-' . esc_attr($newEasing) . ' duration-' . esc_attr($duration) . ($type=="list" ? ($el_class!="" ? ' ' . esc_attr($el_class) : '') : '') . /*((int)$ontouch ? ' ontouch' : '') . ((int)$onmouse ? ' onmouse' : '') .*/ '">';
			else
				$output .= '<ul class="mc-gallery ' . esc_attr($layout) . ' ' . esc_attr($display_method) . ($type=="list" ? ($style!="default" ? ' style-' . esc_attr($style) : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ($el_class!="" ? ' ' . esc_attr($el_class) : '') : '') . '">';
			$j=1;
			while(have_posts()): the_post();
				$categories = array_filter((array)get_the_terms(get_the_ID(), ($shortcode_type=='gallery' ? "medicenter_gallery" : $shortcode_type) . "_category"));
				$categories_count = count($categories);
				$categories_string = "";
				$i = 0;
				foreach($categories as $category)
				{
					$categories_string .= urldecode($category->slug) . ($i+1<$categories_count ? ' ' : '');
					$i++;
				}
			if($display_method=="dm_filters")
				$output .= '<li class="' . esc_attr($categories_string) . '" id="gallery-item-' . esc_attr($post->post_name) . '">
					<div class="gallery-box gallery-box-' . esc_attr($j) . ($hover_icons==0 ? ' hover-icons-off' : '') . '">';
			else
				$output .= '<li class="gallery-box gallery-box-' . esc_attr($j) . ($hover_icons==0 ? ' hover-icons-off' : '') . '" id="gallery-item-' . esc_attr($post->post_name) . '">';
				if(has_post_thumbnail())
					$output .= ($display_method!="dm_carousel" ? '<span class="mc-preloader"></span>' : '') . get_the_post_thumbnail(get_the_ID(), ($featured_image_size!="default" ? $featured_image_size : $themename . "-gallery-" . ($layout=="gallery-4-columns" ? "thumb-type-2" : ($layout=="gallery-3-columns" ? "thumb-type-1" : "image"))), array("alt" => get_the_title(), "title" => "", "class" => "mc-preload"));
				$output .= '
						<div class="description">
							<h4>' . get_the_title() . '</h4>
							<h5>' . get_post_meta(get_the_ID(), "subtitle", true) . '</h5>
						</div>';
					if(has_excerpt()!="")
						$output .= '<div class="item-details">' . apply_filters('the_excerpt', get_the_excerpt()) . '</div>';
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
										$output .= '<li><a class="social-' . esc_attr($icon_type[$i]) . '" href="' . esc_url($icon_url[$i]) . '"' . (isset($icon_target[$i]) && $icon_target[$i]=='new_window' ? ' target="_blank"' : '') . ' title="">&nbsp;</a></li>';
								}
								$output .= '</ul>';
							}
						}
				$output .= '
						<ul class="controls">';
						if($type!="list" || $shortcode_type=="doctors" || (int)$details_page)
							$output .= '
							<li>
								<a href="' . ($shortcode_type=="doctors" && $type=="list" ? esc_url(get_permalink()) : ($type=="list" && ((int)$details_page) ? esc_url(get_permalink((int)$details_page)) : '') . '#gallery-details-' . esc_attr($post->post_name)) . '" class="template-menu-2 open-details"></a>
							</li>';
				if(has_post_thumbnail())
				{
					$output .= '<li>';
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
					$output .= '<a' . ($external_url!="" && $external_url_target=="new_window" ? ' target="_blank"' : '') . ' href="' . ($external_url=="" ? ($iframe_url!="" ? $iframe_url . "?iframe=true" : $large_image_url) : $external_url) . '" class="template-plus-2 fancybox' . ($video_url!="" ? '-video' : ($iframe_url!="" ? '-iframe' : ($external_url!="" ? '-url' : ''))) . ' open' . ($video_url!="" ? '-video' : ($iframe_url!="" ? '-iframe' : ($external_url!="" ? '-url' : ''))) . '-lightbox" rel="mcgallery' .  ((int)$images_loop ? '[loop]' : '') . '"' . ($image_title!="" ? ' title="' . esc_attr($image_title) . '"' : '') . '></a>
					</li>';
				}
				$output .= '</ul>';
			if($display_method=="dm_filters")
				$output .= '</div>';
			$output .= '</li>';
			$j++;
			endwhile;
			$output .= '</ul>';
			if($display_method=="dm_pagination" && ((isset($_GET["action"]) && $_GET["action"]!="theme_" . $shortcode_type . "_pagination") || !isset($_GET["action"])))
				$output .= "</div>";

			if(isset($_GET["action"]) && $_GET["action"]=="theme_" . $shortcode_type . "_pagination")
			{
				echo "theme_start" . $output . "theme_end";
				//Reset Query
				wp_reset_query();
				exit();
			}
			else
			{
				if($display_method=="dm_pagination")
				{
					mc_get_theme_file("/pagination.php");
					$output .= mc_pagination(((int)$ajax_pagination ? true : false), '', ((int)$ajax_pagination ? 100 : 2), false, false, 'theme_' . $shortcode_type . '_pagination', 'page-margin-top');
					if((int)$ajax_pagination)
						$output .= '<input type="hidden" name="theme_' . esc_attr($shortcode_type) . '_pagination" value="' . htmlentities(serialize($atts)) . '" />';
				}
			}
		}
	}
	//Reset Query
	wp_reset_query();
	return $output;
}
?>
