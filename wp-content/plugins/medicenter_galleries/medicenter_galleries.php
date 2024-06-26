<?php
/*
Plugin Name: MediCenter Theme Galleries
Plugin URI: https://1.envato.market/quanticalabs-portfolio
Description: MediCenter Theme Galleries Plugin
Author: QuanticaLabs
Author URI: https://1.envato.market/quanticalabs-portfolio
Version: 1.5
Text Domain: medicenter_galleries
*/

//translation
function medicenter_galleries_load_textdomain()
{
	load_plugin_textdomain("medicenter_galleries", false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'medicenter_galleries_load_textdomain');
//custom post type - galleries
if(is_admin())
{
	function medicenter_gallery_admin_menu()
	{
		$permalinks_page = add_submenu_page('edit.php?post_type=medicenter_gallery', __('Permalink', 'medicenter_galleries'), __('Permalink', 'medicenter_galleries'), 'manage_options', 'galleries_permalink', 'medicenter_gallery_permalink');
	}
	add_action("admin_menu", "medicenter_gallery_admin_menu");
	
	function medicenter_gallery_permalink()
	{
		$message = "";
		if(isset($_POST["action"]) && $_POST["action"]=="save_galleries_permalink")
			$message = __("Options saved!", 'medicenter_galleries');
		$galleries_permalink = array(
			"slug" => 'medicenter_gallery',
			"label_singular" => __("Gallery Item", 'medicenter_galleries'),
			"label_plural" => __("Gallery Items", 'medicenter_galleries')
		);
		$galleries_permalink = array_merge($galleries_permalink, (array)get_option("galleries_permalink"));
		
		require_once("admin/admin-page-permalink.php");
	}
}
function medicenter_gallery_init()
{
	$galleries_permalink = array(
		"slug" => 'medicenter_gallery',
		"label_singular" => __("Gallery Item", 'medicenter_galleries'),
		"label_plural" => __("Gallery Items", 'medicenter_galleries')
	);
	if(isset($_POST["action"]) && $_POST["action"]=="save_galleries_permalink")
	{
		$galleries_permalink = array_merge($galleries_permalink, (array)get_option("galleries_permalink"));
		$slug_old = $galleries_permalink["slug"];
		$galleries_permalink = array(
			"slug" => (!empty($_POST["slug"]) ? sanitize_title($_POST["slug"]) : "medicenter_gallery"),
			"label_singular" => (!empty($_POST["label_singular"]) ? $_POST["label_singular"] : __("Gallery Item", "medicenter_galleries")),
			"label_plural" => (!empty($_POST["label_plural"]) ? $_POST["label_plural"] : __("Gallery Items", "medicenter_galleries"))
		);
		update_option("galleries_permalink", $galleries_permalink);
		if($slug_old!=$_POST["slug"])
		{
			delete_option('rewrite_rules');
		}
	}
	$galleries_permalink = array_merge($galleries_permalink, (array)get_option("galleries_permalink"));
	$labels = array(
		'name' => $galleries_permalink['label_plural'],
		'singular_name' => $galleries_permalink['label_singular'],
		'add_new' => _x('Add New', $galleries_permalink["slug"], 'medicenter_galleries'),
		'add_new_item' => sprintf(__('Add New %s' , 'medicenter_galleries') , $galleries_permalink['label_singular']),
		'edit_item' => sprintf(__('Edit %s', 'medicenter_galleries'), $galleries_permalink['label_singular']),
		'new_item' => sprintf(__('New %s', 'medicenter_galleries'), $galleries_permalink['label_singular']),
		'all_items' => sprintf(__('All %s', 'medicenter_galleries'), $galleries_permalink['label_plural']),
		'view_item' => sprintf(__('View %s', 'medicenter_galleries'), $galleries_permalink['label_singular']),
		'search_items' => sprintf(__('Search %s', 'medicenter_galleries'), $galleries_permalink['label_plural']),
		'not_found' =>  sprintf(__('No %s found', 'medicenter_galleries'), strtolower($galleries_permalink['label_plural'])),
		'not_found_in_trash' => sprintf(__('No %s found in Trash', 'medicenter_galleries'), strtolower($galleries_permalink['label_plural'])), 
		'parent_item_colon' => '',
		'menu_name' => $galleries_permalink['label_plural']
	);
	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",  
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => array("slug" => $galleries_permalink["slug"]),
		"supports" => array("title", "editor", "excerpt", "thumbnail", "page-attributes")  
	);
	register_post_type("medicenter_gallery", $args);
	register_taxonomy("medicenter_gallery_category", array("medicenter_gallery"), array("label" => __("Categories", 'medicenter_galleries'), "singular_label" => __("Category", 'medicenter_galleries'), "rewrite" => true));
}  
add_action("init", "medicenter_gallery_init");

//Adds a box to the right column and to the main column on the Gallery items edit screens
function medicenter_add_gallery_custom_box() 
{
	add_meta_box( 
        "gallery_config",
        __("Options", 'medicenter_galleries'),
        "medicenter_inner_gallery_custom_box_main",
        "medicenter_gallery",
		"normal",
		"high"
    );
}
add_action("add_meta_boxes", "medicenter_add_gallery_custom_box");

function medicenter_inner_gallery_custom_box_main($post)
{
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "medicenter_gallery_noncename");
	
	//The actual fields for data entry
	$external_url_target = get_post_meta($post->ID, "external_url_target", true);
	$icon_type = (array)get_post_meta($post->ID, "social_icon_type", true);
	$icon_url = get_post_meta($post->ID, "social_icon_url", true);
	$icon_target = get_post_meta($post->ID, "social_icon_target", true);
	$attachment_ids = get_post_meta($post->ID, "medicenter_attachment_ids", true);
	$images = (array)get_post_meta($post->ID, "medicenter_images", true);
	$images_titles = get_post_meta($post->ID, "medicenter_images_titles", true);
	$videos = get_post_meta($post->ID, "medicenter_videos", true);
	$iframes = get_post_meta($post->ID, "medicenter_iframes", true);
	$external_urls = get_post_meta($post->ID, "medicenter_external_urls", true);
	$features_images_loop = get_post_meta($post->ID, "medicenter_features_images_loop", true);
	
	$icons = array(
		"angies-list",
		"behance",
		"deviantart",
		"dribbble",
		"email",
		"envato",
		"facebook",
		"flickr",
		"foursquare",
		"github",
		"google-plus",
		"houzz",
		"instagram",
		"linkedin",
		"location",
		"mobile",
		"paypal",
		"pinterest",
		"reddit",
		"rss",
		"skype",
		"soundcloud",
		"spotify",
		"stumbleupon",
		"tumblr",
		"twitter",
		"vimeo",
		"vine",
		"vk",
		"weibo",
		"xing",
		"yelp",
		"youtube"
	);
	
	echo '
	<table>
		<tr>
			<td>
				<label for="gallery_subtitle">' . __('Subtitle', 'medicenter_galleries') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="gallery_subtitle" name="gallery_subtitle" value="' . esc_attr(get_post_meta($post->ID, "subtitle", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label>' . __('Featured image description', 'medicenter_galleries') . '</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="image_title" name="image_title" value="' . esc_attr(get_post_meta($post->ID, "image_title", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="gallery_video_url">' . __('Video URL (optional)', 'medicenter_galleries') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="gallery_video_url" name="gallery_video_url" value="' . esc_attr(get_post_meta($post->ID, "video_url", true)) . '" />
				<span class="description">' . __('For Vimeo please use https://vimeo.com/%video_id% For YouTube: https://www.youtube.com/watch?v=%video_id%', 'medicenter_galleries') . '</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="gallery_iframe_url">' . __('Ifame URL (optional)', 'medicenter_galleries') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="gallery_iframe_url" name="gallery_iframe_url" value="' . esc_attr(get_post_meta($post->ID, "iframe_url", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="gallery_external_url">' . __('External URL (optional)', 'medicenter_galleries') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="gallery_external_url" name="gallery_external_url" value="' . esc_attr(get_post_meta($post->ID, "external_url", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="gallery_external_url_target">' . __('External URL target', 'medicenter_galleries') . ':</label>
			</td>
			<td>
				<select id="gallery_external_url_target" name="gallery_external_url_target">
					<option value="same_window"' . ($external_url_target=="same_window" ? ' selected="selected"' : '') . '>' . __('same window', 'medicenter_galleries') . '</option>
					<option value="new_window"' . ($external_url_target=="new_window" ? ' selected="selected"' : '') . '>' . __('new window', 'medicenter_galleries') . '</option>
				</select>
			</td>
		</tr>
	</table>
	<div class="clearfix">
		<table class="meta_box_options_left">
			<tr valign="top">
				<th colspan="2" scope="row" style="font-weight: bold;">
					' . __('Social icons', 'medicenter_galleries') . '
				</th>
			</tr>';
			for($i=0; $i<(count($icon_type)<4 ? 4 : count($icon_type)); $i++)
			{
			echo '
			<tr class="repeated_row_id_1 repeated_row_' . ($i+1) . '">
				<td colspan="2">
					<table>
						<tr>
							<td>
								<label>' . __('Icon type', 'medicenter_galleries') . " " . ($i+1) . ':</label>
							</td>
							<td>
								<select id="icon_type_' . ($i+1) . '" name="icon_type[]">
									<option value="">-</option>';
									for($j=0; $j<count($icons); $j++)
									{
									echo '<option value="' . esc_attr($icons[$j]) . '"' . (isset($icon_type[$i]) && $icons[$j]==$icon_type[$i] ? " selected='selected'" : "") . '>' . $icons[$j] . '</option>';
									}
							echo '</select>
							</td>
						</tr>
						<tr>
							<td>
								<label>' . __('Icon url', 'medicenter_galleries') . " " . ($i+1) . ':</label>
							</td>
							<td>
								<input type="text" class="regular-text" value="' . esc_attr($icon_url[$i]) . '" name="icon_url[]">
							</td>
						</tr>
						<tr>
							<td>
								<label>' . __('Icon target', 'medicenter_galleries') . " " . ($i+1) . ':</label>
							</td>
							<td>
								<select name="icon_target[]">
									<option value="same_window"' . ($icon_target[$i]=="same_window" ? " selected='selected'" : "") . '>' . __('same window', 'medicenter_galleries') . '</option>
									<option value="new_window"' . ($icon_target[$i]=="new_window" ? " selected='selected'" : "") . '>' . __('new window', 'medicenter_galleries') . '</option>
								</select>
							</td>
						</tr>
					</table>
					<br />
				</td>
			</tr>';
			}
			echo '
			<tr>
				<td colspan="2">
					<input type="button" class="button medicenter_add_new_repeated_row" name="medicenter_add_new_repeated_row" id="repeated_row_id_1" value="' . __('Add icon', 'medicenter_galleries') . '" />
				</td>
			</tr>
		</table>
		<table class="meta_box_options_right">
			<tr valign="top">
				<th colspan="2" scope="row" style="font-weight: bold;">
					' . __('Additional featured images', 'medicenter_galleries') . '
				</th>
			</tr>';
			for($i=0; $i<(count($images)<3 ? 3 : count($images)); $i++)
			{
			echo '
			<tr class="repeated_row_id_2 repeated_row_' . ($i+1) . '">
				<td colspan="2">
					<table>
						<tr class="image_url_row">
							<td>
								<label>' . __('Image url', 'medicenter_galleries') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input type="hidden" name="attachment_ids[]" id="medicenter_attachment_id_' . ($i+1) . '" value="' . (isset($attachment_ids[$i]) ? esc_attr($attachment_ids[$i]) : "") . '" />
								<input class="regular-text" type="text" id="medicenter_image_url_' . ($i+1) . '" name="images[]" value="' . (isset($images[$i]) ? esc_attr($images[$i]) : "") . '" />
								<input type="button" class="button" name="medicenter_upload_button" id="medicenter_image_url_button_' . ($i+1) . '" value="' . __('Browse', 'medicenter_galleries') . '" />
							</td>
						</tr>
						<tr class="image_title_row">
							<td>
								<label>' . __('Image description', 'medicenter_galleries') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input class="regular-text" type="text" id="medicenter_image_title_' . ($i+1) . '" name="images_titles[]" value="' . (isset($images_titles[$i]) ? esc_attr($images_titles[$i]) : "") . '" />
							</td>
						</tr>
						<tr class="video_row">
							<td>
								<label>' . __('Video url', 'medicenter_galleries') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input class="regular-text" type="text" id="medicenter_video_' . ($i+1) . '" name="videos[]" value="' . (isset($videos[$i]) ? esc_attr($videos[$i]) : "") . '" />
							</td>
						</tr>
						<tr class="iframe_row">
							<td>
								<label>' . __('Iframe url', 'medicenter_galleries') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input class="regular-text" type="text" id="medicenter_iframe_' . ($i+1) . '" name="iframes[]" value="' . (isset($iframes[$i]) ? esc_attr($iframes[$i]) : "") . '" />
							</td>
						</tr>
						<tr class="external_url_row">
							<td>
								<label>' . __('External url', 'medicenter_galleries') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input class="regular-text" type="text" id="medicenter_external_url_' . ($i+1) . '" name="external_urls[]" value="' . (isset($external_urls[$i]) ? esc_attr($external_urls[$i]) : "") . '" />
							</td>
						</tr>
					</table>
					<br />
				</td>
			</tr>';
			}
			echo '
			<tr>
				<td colspan="2">
					<input type="button" class="button medicenter_add_new_repeated_row" name="medicenter_add_new_repeated_row" id="repeated_row_id_2" value="' . __('Add image', 'medicenter_galleries') . '" />
				</td>
			</tr>
			<tr>
				<td>
					<br />
					<label for="features_images_loop">' . __('Featured images lightbox loop', 'medicenter_galleries') . ':</label>
				</td>
				<td>
					<select id="features_images_loop" name="features_images_loop">
						<option value="yes"' . ($features_images_loop=="yes" ? ' selected="selected"' : '') . '>' . __('yes', 'medicenter_galleries') . '</option>
						<option value="no"' . ($features_images_loop=="no" ? ' selected="selected"' : '') . '>' . __('no', 'medicenter_galleries') . '</option>
					</select>
				</td>
			</tr>
		</table>
	</div>';
}

//When the post is saved, saves our custom data
function medicenter_save_gallery_postdata($post_id) 
{
	//verify if this is an auto save routine. 
	//if it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if (!isset($_POST['medicenter_gallery_noncename']) || !wp_verify_nonce($_POST['medicenter_gallery_noncename'], plugin_basename( __FILE__ )))
		return;


	//Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;

	//OK, we're authenticated: we need to find and save the data
	update_post_meta($post_id, "subtitle", $_POST["gallery_subtitle"]);
	update_post_meta($post_id, "image_title", $_POST["image_title"]);
	update_post_meta($post_id, "video_url", $_POST["gallery_video_url"]);
	update_post_meta($post_id, "iframe_url", $_POST["gallery_iframe_url"]);
	update_post_meta($post_id, "external_url", $_POST["gallery_external_url"]);
	update_post_meta($post_id, "external_url_target", $_POST["gallery_external_url_target"]);
	$icon_type = (array)$_POST["icon_type"];
	while(end($icon_type)==="")
		array_pop($icon_type);
	update_post_meta($post_id, "social_icon_type", $icon_type);
	update_post_meta($post_id, "social_icon_url", $_POST["icon_url"]);
	update_post_meta($post_id, "social_icon_target", $_POST["icon_target"]);
	update_post_meta($post_id, "medicenter_attachment_ids", $_POST["attachment_ids"]);
	$images = (array)$_POST["images"];
	while(end($images)==="")
		array_pop($images);
	update_post_meta($post_id, "medicenter_images", $images);
	update_post_meta($post_id, "medicenter_images_titles", $_POST["images_titles"]);
	update_post_meta($post_id, "medicenter_videos", $_POST["videos"]);
	update_post_meta($post_id, "medicenter_iframes", $_POST["iframes"]);
	update_post_meta($post_id, "medicenter_external_urls", $_POST["external_urls"]);
	update_post_meta($post_id, "medicenter_features_images_loop", $_POST["features_images_loop"]);
}
add_action("save_post", "medicenter_save_gallery_postdata");

function medicenter_gallery_edit_columns($columns)
{
	$new_columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => _x('Title', 'post type singular name', 'medicenter_galleries'),
			"video_url" => __('Video URL', 'medicenter_galleries'),
			"iframe_url" => __('Iframe URL', 'medicenter_galleries'),
			"external_url" => __('External URL', 'medicenter_galleries'),
			"medicenter_gallery_category" => __('Categories', 'medicenter_galleries'),
			"order" =>  _x('Order', 'post type singular name', 'medicenter_galleries'),
			"date" => __('Date', 'medicenter_galleries')
	);

	return array_merge($new_columns, $columns);
}
add_filter("manage_edit-medicenter_gallery_columns", "medicenter_gallery_edit_columns");

function manage_medicenter_gallery_posts_custom_column($column)
{
	global $post;
	switch ($column)
	{
		case "video_url":   
			echo get_post_meta($post->ID, "video_url", true);  
			break;
		case "iframe_url":   
			echo get_post_meta($post->ID, "iframe_url", true);  
			break;
		case "external_url":   
			echo get_post_meta($post->ID, "external_url", true);  
			break;
		case "medicenter_gallery_category":
			$gallery_category_list = (array)get_the_terms($post->ID, "medicenter_gallery_category");
			foreach($gallery_category_list as $gallery_category)
			{
				if(empty($gallery_category->slug))
					continue;
				echo '<a href="' . esc_url(admin_url("edit.php?post_type=medicenter_gallery&medicenter_gallery_category=" . $gallery_category->slug)) . '">' . $gallery_category->name . '</a>' . (end($gallery_category_list)!=$gallery_category ? ", " : "");;
			}
			break;
		case "order":
			echo get_post($post->ID)->menu_order;
			break;
	}
}
add_action("manage_medicenter_gallery_posts_custom_column", "manage_medicenter_gallery_posts_custom_column");

// Register the column as sortable
function medicenter_gallery_sortable_columns($columns) 
{
    $columns = array(
		"title" => "title",
		"order" => "menu_order",
		"date" => "date"
	);

    return $columns;
}
add_filter("manage_edit-medicenter_gallery_sortable_columns", "medicenter_gallery_sortable_columns");

//ajax pagination
add_action("wp_ajax_theme_gallery_pagination", "mc_theme_gallery_shortcode");
add_action("wp_ajax_nopriv_theme_gallery_pagination", "mc_theme_gallery_shortcode");
//shortcode
add_shortcode("medicenter_gallery", "mc_theme_gallery_shortcode");

//visual composer
function medicenter_gallery_vc_init()
{
	if(is_plugin_active("js_composer/js_composer.php") && function_exists('vc_map'))
	{
		//get gallery items list
		$gallery_items_list = get_posts(array(
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_type' => 'medicenter_gallery'
		));
		$gallery_items_array = array();
		$gallery_items_array[__("All", 'medicenter_galleries')] = "-";
		foreach($gallery_items_list as $gallery_item)
			$gallery_items_array[$gallery_item->post_title . " (id:" . $gallery_item->ID . ")"] = $gallery_item->ID;

		//get gallery items categories list
		$gallery_items_categories = get_terms("medicenter_gallery_category");
		$gallery_items_categories_array = array();
		$gallery_items_categories_array[__("All", 'medicenter_galleries')] = "-";
		foreach($gallery_items_categories as $gallery_items_category)
			$gallery_items_categories_array[$gallery_items_category->name] =  $gallery_items_category->slug;
		
		//get all pages
		global $medicenter_pages_array;
		
		//image sizes
		$image_sizes_array = array();
		$image_sizes_array[__("Default", 'medicenter_galleries')] = "default";
		$image_sizes_array[__("full (original image resolution)", 'medicenter_galleries')] = "full";
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
			"name" => __("Gallery items list", 'medicenter_galleries'),
			"base" => "medicenter_gallery",
			"class" => "",
			"controls" => "full",
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-layer-gallery-items-list",
			"category" => __('MediCenter', 'medicenter_galleries'),
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Header", 'medicenter_galleries'),
					"param_name" => "header",
					"value" => ""
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Header border animation", 'medicenter_galleries'),
					"param_name" => "animation",
					"value" => array(__("no", 'medicenter_galleries') => 0,  __("yes", 'medicenter_galleries') => 1)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Order by", 'medicenter_galleries'),
					"param_name" => "order_by",
					"value" => array(__("Title, menu order", 'medicenter_galleries') => "title,menu_order", __("Menu order", 'medicenter_galleries') => "menu_order", __("Date", 'medicenter_galleries') => "date")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Order", 'medicenter_galleries'),
					"param_name" => "order",
					"value" => array(__("ascending", 'medicenter_galleries') => "ASC", __("descending", 'medicenter_galleries') => "DESC")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Type", 'medicenter_galleries'),
					"param_name" => "type",
					"value" => array(__("List with details", 'medicenter_galleries') => "list_with_details", __("List", 'medicenter_galleries') => "list", __("Details", 'medicenter_galleries') => "details")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Layout", 'medicenter_galleries'),
					"param_name" => "layout",
					"value" => array(__("Item width 285px", 'medicenter_galleries') => "gallery-4-columns", __("Item width 600px", 'medicenter_galleries') => "gallery-2-columns", __("Item width 390px", 'medicenter_galleries') => "gallery-3-columns")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Featured image size", 'medicenter_galleries'),
					"param_name" => "featured_image_size",
					"value" => $image_sizes_array
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Hover icons", 'medicenter_galleries'),
					"param_name" => "hover_icons",
					"value" => array(__("Yes", 'medicenter_galleries') => 1, __("No", 'medicenter_galleries') => "0")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Title box in details", 'medicenter_galleries'),
					"param_name" => "title_box",
					"value" => array(__("Yes", 'medicenter_galleries') => 1, __("No", 'medicenter_galleries') => 0),
					"dependency" => Array('element' => "type", 'value' => array('list_with_details'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Details page", 'medicenter_galleries'),
					"param_name" => "details_page",
					"value" => $medicenter_pages_array,
					"dependency" => Array('element' => "type", 'value' => array('list'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display method", 'medicenter_galleries'),
					"param_name" => "display_method",
					"value" => array(__("Filters", 'medicenter_galleries') => 'dm_filters', __("Carousel", 'medicenter_galleries') => 'dm_carousel', __("Pagination", 'medicenter_galleries') => 'dm_pagination', __("Simple", 'medicenter_galleries') => 'dm_simple'),
					"dependency" => Array('element' => "type", 'value' => array('list_with_details', 'list'))
				),
				//filters options
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("All filter label", 'medicenter_galleries'),
					"param_name" => "all_label",
					"value" => "",
					"dependency" => Array('element' => "display_method", 'value' => 'dm_filters')
				),
				//carousel options
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Id", 'medicenter_galleries'),
					"param_name" => "id",
					"value" => "carousel",
					"description" => __("Please provide unique id for each carousel on the same page/post", 'medicenter_galleries'),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Autoplay", 'medicenter_galleries'),
					"param_name" => "autoplay",
					"value" => array(__("No", 'medicenter_galleries') => 0, __("Yes", 'medicenter_galleries') => 1),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Pause on hover", 'medicenter_galleries'),
					"param_name" => "pause_on_hover",
					"value" => array(__("Yes", 'medicenter_galleries') => 1, __("No", 'medicenter_galleries') => 0),
					"description" => __("Affect only when autoplay is set to yes", 'medicenter_galleries'),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Scroll", 'medicenter_galleries'),
					"param_name" => "scroll",
					"value" => 1,
					"description" => __("Number of items to scroll in one step", 'medicenter_galleries'),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect", 'medicenter_galleries'),
					"param_name" => "effect",
					"value" => array(
						__("scroll", 'medicenter_galleries') => "scroll", 
						__("none", 'medicenter_galleries') => "none", 
						__("directscroll", 'medicenter_galleries') => "directscroll",
						__("fade", 'medicenter_galleries') => "_fade",
						__("crossfade", 'medicenter_galleries') => "crossfade",
						__("cover", 'medicenter_galleries') => "cover",
						__("uncover", 'medicenter_galleries') => "uncover"
					),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Sliding easing", 'medicenter_galleries'),
					"param_name" => "easing",
					"value" => array(
						__("swing", 'medicenter_galleries') => "swing", 
						__("linear", 'medicenter_galleries') => "linear", 
						__("easeInQuad", 'medicenter_galleries') => "easeInQuad",
						__("easeOutQuad", 'medicenter_galleries') => "easeOutQuad",
						__("easeInOutQuad", 'medicenter_galleries') => "easeInOutQuad",
						__("easeInCubic", 'medicenter_galleries') => "easeInCubic",
						__("easeOutCubic", 'medicenter_galleries') => "easeOutCubic",
						__("easeInOutCubic", 'medicenter_galleries') => "easeInOutCubic",
						__("easeInQuart", 'medicenter_galleries') => "easeInQuart",
						__("easeOutQuart", 'medicenter_galleries') => "easeOutQuart",
						__("easeInOutQuart", 'medicenter_galleries') => "easeInOutQuart",
						__("easeInSine", 'medicenter_galleries') => "easeInSine",
						__("easeOutSine", 'medicenter_galleries') => "easeOutSine",
						__("easeInOutSine", 'medicenter_galleries') => "easeInOutSine",
						__("easeInExpo", 'medicenter_galleries') => "easeInExpo",
						__("easeOutExpo", 'medicenter_galleries') => "easeOutExpo",
						__("easeInOutExpo", 'medicenter_galleries') => "easeInOutExpo",
						__("easeInQuint", 'medicenter_galleries') => "easeInQuint",
						__("easeOutQuint", 'medicenter_galleries') => "easeOutQuint",
						__("easeInOutQuint", 'medicenter_galleries') => "easeInOutQuint",
						__("easeInCirc", 'medicenter_galleries') => "easeInCirc",
						__("easeOutCirc", 'medicenter_galleries') => "easeOutCirc",
						__("easeInOutCirc", 'medicenter_galleries') => "easeInOutCirc",
						__("easeInElastic", 'medicenter_galleries') => "easeInElastic",
						__("easeOutElastic", 'medicenter_galleries') => "easeOutElastic",
						__("easeInOutElastic", 'medicenter_galleries') => "easeInOutElastic",
						__("easeInBack", 'medicenter_galleries') => "easeInBack",
						__("easeOutBack", 'medicenter_galleries') => "easeOutBack",
						__("easeInOutBack", 'medicenter_galleries') => "easeInOutBack",
						__("easeInBounce", 'medicenter_galleries') => "easeInBounce",
						__("easeOutBounce", 'medicenter_galleries') => "easeOutBounce",
						__("easeInOutBounce", 'medicenter_galleries') => "easeInOutBounce"
					),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Sliding transition speed (ms)", 'medicenter_galleries'),
					"param_name" => "duration",
					"value" => 500,
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				//pagination options
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Items per page", 'medicenter_galleries'),
					"param_name" => "items_per_page",
					"value" => 4,
					"dependency" => Array('element' => "display_method", 'value' => 'dm_pagination')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Ajax pagination", 'medicenter_galleries'),
					"param_name" => "ajax_pagination",
					"value" => array(__("Yes", 'medicenter_galleries') => 1, __("No", 'medicenter_galleries') => 0),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_pagination')
				),
				array(
					"type" => "dropdownmulti",
					"class" => "",
					"heading" => __("Display selected", 'medicenter_galleries'),
					"param_name" => "ids",
					"value" => $gallery_items_array
				),
				array(
					"type" => "dropdownmulti",
					"class" => "",
					"heading" => __("Display from Category", 'medicenter_galleries'),
					"param_name" => "category",
					"value" => $gallery_items_categories_array
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display headers in details", 'medicenter_galleries'),
					"param_name" => "display_headers",
					"value" => array(__("Yes", 'medicenter_galleries') => 1, __("No", 'medicenter_galleries') => 0),
					"dependency" => Array('element' => "type", 'value' => array('list_with_details', 'details'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Headers type", 'medicenter_galleries'),
					"param_name" => "headers_type",
					"value" => array(__("H2", 'medicenter_galleries') => "h2", __("H1", 'medicenter_galleries') => "h1", __("H3", 'medicenter_galleries') => "h3", __("H4", 'medicenter_galleries') => "h4", __("H5", 'medicenter_galleries') => "h5"),
					"dependency" => Array('element' => "type", 'value' => array('list_with_details', 'details'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display social icons", 'medicenter_galleries'),
					"param_name" => "display_social_icons",
					"value" => array(__("Yes", 'medicenter_galleries') => 1, __("No", 'medicenter_galleries') => 0)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Lightbox images loop", 'medicenter_galleries'),
					"param_name" => "images_loop",
					"value" => array(__("No", 'medicenter_galleries') => 0, __("Yes", 'medicenter_galleries') => 1),
					"dependency" => Array('element' => "type", 'value' => array('list_with_details', 'list'))
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'medicenter_galleries' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'medicenter_galleries' )
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Top margin", 'medicenter_galleries'),
					"param_name" => "top_margin",
					"value" => array(__("None", 'medicenter_galleries') => "none", __("Page (small)", 'medicenter_galleries') => "page-margin-top", __("Section (large)", 'medicenter_galleries') => "page-margin-top-section")
				)
			)
		));
	}
}
add_action("init", "medicenter_gallery_vc_init");
?>