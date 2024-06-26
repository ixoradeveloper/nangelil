<?php
/*
Plugin Name: MediCenter Theme Doctors
Plugin URI: https://1.envato.market/quanticalabs-portfolio
Description: MediCenter Theme Doctors Plugin
Author: QuanticaLabs
Author URI: https://1.envato.market/quanticalabs-portfolio
Version: 1.5
Text Domain: medicenter_doctors
*/

//translation
function medicenter_doctors_load_textdomain()
{
	load_plugin_textdomain("medicenter_doctors", false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'medicenter_doctors_load_textdomain');
//custom post type - doctors
if(is_admin())
{
	function medicenter_doctors_admin_menu()
	{
		$permalinks_page = add_submenu_page('edit.php?post_type=doctors', __('Permalink', 'medicenter_doctors'), __('Permalink', 'medicenter_doctors'), 'manage_options', 'doctors_permalink', 'medicenter_doctors_permalink');
	}
	add_action("admin_menu", "medicenter_doctors_admin_menu");
	
	function medicenter_doctors_permalink()
	{
		$message = "";
		if(isset($_POST["action"]) && $_POST["action"]=="save_doctors_permalink")
			$message = __("Options saved!", 'medicenter_doctors');
		$doctors_permalink = array(
			"slug" => 'doctors',
			"label_singular" => __("Doctor", 'medicenter_doctors'),
			"label_plural" => __("Doctors", 'medicenter_doctors')
		);
		$doctors_permalink = array_merge($doctors_permalink, (array)get_option("doctors_permalink"));
		
		require_once("admin/admin-page-permalink.php");
	}
}
function medicenter_doctors_init()
{
	$doctors_permalink = array(
		"slug" => 'doctors',
		"label_singular" => __("Doctor", 'medicenter_doctors'),
		"label_plural" => __("Doctors", 'medicenter_doctors')
	);
	if(isset($_POST["action"]) && $_POST["action"]=="save_doctors_permalink")
	{
		$doctors_permalink = array_merge($doctors_permalink, (array)get_option("doctors_permalink"));
		$slug_old = $doctors_permalink["slug"];
		$doctors_permalink = array(
			"slug" => (!empty($_POST["slug"]) ? sanitize_title($_POST["slug"]) : "doctors"),
			"label_singular" => (!empty($_POST["label_singular"]) ? $_POST["label_singular"] : __("Doctor", "medicenter_doctors")),
			"label_plural" => (!empty($_POST["label_plural"]) ? $_POST["label_plural"] : __("Doctors", "medicenter_doctors"))
		);
		update_option("doctors_permalink", $doctors_permalink);
		if($slug_old!=$_POST["slug"])
		{
			delete_option('rewrite_rules');
		}
	}
	$doctors_permalink = array_merge($doctors_permalink, (array)get_option("doctors_permalink"));
	$labels = array(
		'name' => $doctors_permalink['label_plural'],
		'singular_name' => $doctors_permalink['label_singular'],
		'add_new' => _x('Add New', $doctors_permalink["slug"], 'medicenter_doctors'),
		'add_new_item' => sprintf(__('Add New %s' , 'medicenter_doctors') , $doctors_permalink['label_singular']),
		'edit_item' => sprintf(__('Edit %s', 'medicenter_doctors'), $doctors_permalink['label_singular']),
		'new_item' => sprintf(__('New %s', 'medicenter_doctors'), $doctors_permalink['label_singular']),
		'all_items' => sprintf(__('All %s', 'medicenter_doctors'), $doctors_permalink['label_plural']),
		'view_item' => sprintf(__('View %s', 'medicenter_doctors'), $doctors_permalink['label_singular']),
		'search_items' => sprintf(__('Search %s', 'medicenter_doctors'), $doctors_permalink['label_plural']),
		'not_found' =>  sprintf(__('No %s found', 'medicenter_doctors'), strtolower($doctors_permalink['label_plural'])),
		'not_found_in_trash' => sprintf(__('No %s found in Trash', 'medicenter_doctors'), strtolower($doctors_permalink['label_plural'])), 
		'parent_item_colon' => '',
		'menu_name' => $doctors_permalink['label_plural']
	);

	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",  
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => array("slug" => $doctors_permalink["slug"]),
		"supports" => array("title", "editor", "excerpt", "thumbnail", "page-attributes")  
	);
	register_post_type("doctors", $args);
	register_taxonomy("doctors_category", array("doctors"), array("label" => __("Categories", 'medicenter_doctors'), "singular_label" => __("Category", 'medicenter_doctors'), "rewrite" => true));
}  
add_action("init", "medicenter_doctors_init"); 

//Adds a box to the right column and to the main column on the Doctors edit screens
function medicenter_add_doctors_custom_box() 
{
	add_meta_box( 
        "doctors_config",
        __("Options", 'medicenter_doctors'),
        "medicenter_inner_doctors_custom_box_main",
        "doctors",
		"normal",
		"high"
    );
}
add_action("add_meta_boxes", "medicenter_add_doctors_custom_box");

function medicenter_inner_doctors_custom_box_main($post)
{
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "medicenter_doctors_noncename");
	
	//The actual fields for data entry
	$external_url_target = get_post_meta($post->ID, "external_url_target", true);
	$timetable_page = get_post_meta($post->ID, "timetable_page", true);
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
				<label for="doctor_subtitle">' . __('Subtitle', 'medicenter_doctors') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="doctor_subtitle" name="doctor_subtitle" value="' . esc_attr(get_post_meta($post->ID, "subtitle", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="doctor_description">' . __('Description', 'medicenter_doctors') . ':</label>
			</td>
			<td>';
				$doctor_description = get_post_meta($post->ID, "doctor_description", true);
				$settings = array(
					'editor_height' => 150
				);
				wp_editor(!empty($doctor_description) ? $doctor_description : "", "doctor_description", $settings);
		echo '</td>
		</tr>
		<tr>
			<td>
				<label>' . __('Featured image description', 'medicenter_doctors') . '</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="image_title" name="image_title" value="' . esc_attr(get_post_meta($post->ID, "image_title", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="doctors_video_url">' . __('Video URL (optional)', 'medicenter_doctors') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="doctors_video_url" name="doctors_video_url" value="' . esc_attr(get_post_meta($post->ID, "video_url", true)) . '" />
				<span class="description">' . __('For Vimeo please use https://vimeo.com/%video_id% For YouTube: https://www.youtube.com/watch?v=%video_id%', 'medicenter_doctors') . '</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="doctors_iframe_url">' . __('Ifame URL (optional)', 'medicenter_doctors') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="doctors_iframe_url" name="doctors_iframe_url" value="' . esc_attr(get_post_meta($post->ID, "iframe_url", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="doctors_external_url">' . __('External URL (optional)', 'medicenter_doctors') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="doctors_external_url" name="doctors_external_url" value="' . esc_attr(get_post_meta($post->ID, "external_url", true)) . '" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="doctors_external_url_target">' . __('External URL target', 'medicenter_doctors') . ':</label>
			</td>
			<td>
				<select id="doctors_external_url_target" name="doctors_external_url_target">
					<option value="same_window"' . (isset($external_url_target) && $external_url_target=="same_window" ? ' selected="selected"' : '') . '>' . __('same window', 'medicenter_doctors') . '</option>
					<option value="new_window"' . (isset($external_url_target) && $external_url_target=="new_window" ? ' selected="selected"' : '') . '>' . __('new window', 'medicenter_doctors') . '</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for="doctor_timetable_page">' . __('Timetable page', 'medicenter_doctors') . ':</label>
			</td>
			<td>
				<select name="doctor_timetable_page" id="doctor_timetable_page">
					<option value="">-</option>';
				$args = array(
					'post_type' => 'page',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'orderby' => 'title', 
					'order' => 'ASC'
				);
				query_posts($args);
				if(have_posts()) : while (have_posts()) : the_post();
					echo '<option value="' . get_the_ID() . '"' . ($timetable_page==get_the_ID() ? ' selected="selected"' : '') . '>' . get_the_title() . '</option>';
				endwhile;
				endif;
				wp_reset_query();
	echo '</td>
		</tr>
	</table>
	<div class="clearfix">
		<table class="meta_box_options_left">
			<tr valign="top">
				<th colspan="2" scope="row" style="font-weight: bold;">
					' . __('Social icons', 'medicenter_doctors') . '
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
								<label>' . __('Icon type', 'medicenter_doctors') . " " . ($i+1) . ':</label>
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
								<label>' . __('Icon url', 'medicenter_doctors') . " " . ($i+1) . ':</label>
							</td>
							<td>
								<input type="text" class="regular-text" value="' . (isset($icon_url[$i]) ? esc_attr($icon_url[$i]) : "") . '" name="icon_url[]">
							</td>
						</tr>
						<tr>
							<td>
								<label>' . __('Icon target', 'medicenter_doctors') . " " . ($i+1) . ':</label>
							</td>
							<td>
								<select name="icon_target[]">
									<option value="same_window"' . (isset($icon_target[$i]) && $icon_target[$i]=="same_window" ? " selected='selected'" : "") . '>' . __('same window', 'medicenter_doctors') . '</option>
									<option value="new_window"' . (isset($icon_target[$i]) && $icon_target[$i]=="new_window" ? " selected='selected'" : "") . '>' . __('new window', 'medicenter_doctors') . '</option>
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
					<input type="button" class="button medicenter_add_new_repeated_row" name="medicenter_add_new_repeated_row" id="repeated_row_id_1" value="' . __('Add icon', 'medicenter_doctors') . '" />
				</td>
			</tr>
		</table>
		<table class="meta_box_options_right">
			<tr valign="top">
				<th colspan="2" scope="row" style="font-weight: bold;">
					' . __('Additional featured images', 'medicenter_doctors') . '
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
								<label>' . __('Image url', 'medicenter_doctors') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input type="hidden" name="attachment_ids[]" id="medicenter_attachment_id_' . ($i+1) . '" value="' . (isset($attachment_ids[$i]) ? esc_attr($attachment_ids[$i]) : "") . '" />
								<input class="regular-text" type="text" id="medicenter_image_url_' . ($i+1) . '" name="images[]" value="' . (isset($images[$i]) ? esc_attr($images[$i]) : "") . '" />
								<input type="button" class="button" name="medicenter_upload_button" id="medicenter_image_url_button_' . ($i+1) . '" value="' . __('Browse', 'medicenter_doctors') . '" />
							</td>
						</tr>
						<tr class="image_title_row">
							<td>
								<label>' . __('Image description', 'medicenter_doctors') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input class="regular-text" type="text" id="medicenter_image_title_' . ($i+1) . '" name="images_titles[]" value="' . (isset($images_titles[$i]) ? esc_attr($images_titles[$i]) : "") . '" />
							</td>
						</tr>
						<tr class="video_row">
							<td>
								<label>' . __('Video url', 'medicenter_doctors') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input class="regular-text" type="text" id="medicenter_video_' . ($i+1) . '" name="videos[]" value="' . (isset($videos[$i]) ? esc_attr($videos[$i]) : "") . '" />
							</td>
						</tr>
						<tr class="iframe_row">
							<td>
								<label>' . __('Iframe url', 'medicenter_doctors') . " " . ($i+1) . '</label>
							</td>
							<td>
								<input class="regular-text" type="text" id="medicenter_iframe_' . ($i+1) . '" name="iframes[]" value="' . (isset($iframes[$i]) ? esc_attr($iframes[$i]) : "") . '" />
							</td>
						</tr>
						<tr class="external_url_row">
							<td>
								<label>' . __('External url', 'medicenter_doctors') . " " . ($i+1) . '</label>
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
					<input type="button" class="button medicenter_add_new_repeated_row" name="medicenter_add_new_repeated_row" id="repeated_row_id_2" value="' . __('Add image', 'medicenter_doctors') . '" />
				</td>
			</tr>
			<tr>
				<td>
					<br />
					<label for="features_images_loop">' . __('Featured images lightbox loop', 'medicenter_doctors') . ':</label>
				</td>
				<td>
					<select id="features_images_loop" name="features_images_loop">
						<option value="yes"' . ($features_images_loop=="yes" ? ' selected="selected"' : '') . '>' . __('yes', 'medicenter_doctors') . '</option>
						<option value="no"' . ($features_images_loop=="no" ? ' selected="selected"' : '') . '>' . __('no', 'medicenter_doctors') . '</option>
					</select>
				</td>
			</tr>
		</table>
	</div>';
}

//When the post is saved, saves our custom data
function medicenter_save_doctors_postdata($post_id) 
{
	//verify if this is an auto save routine. 
	//if it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if (!isset($_POST['medicenter_doctors_noncename']) || !wp_verify_nonce($_POST['medicenter_doctors_noncename'], plugin_basename( __FILE__ )))
		return;


	//Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;

	//OK, we're authenticated: we need to find and save the data
	update_post_meta($post_id, "subtitle", $_POST["doctor_subtitle"]);
	update_post_meta($post_id, "doctor_description", $_POST["doctor_description"]);
	update_post_meta($post_id, "image_title", $_POST["image_title"]);
	update_post_meta($post_id, "video_url", $_POST["doctors_video_url"]);
	update_post_meta($post_id, "iframe_url", $_POST["doctors_iframe_url"]);
	update_post_meta($post_id, "external_url", $_POST["doctors_external_url"]);
	update_post_meta($post_id, "external_url_target", $_POST["doctors_external_url_target"]);
	update_post_meta($post_id, "timetable_page", $_POST["doctor_timetable_page"]);
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
add_action("save_post", "medicenter_save_doctors_postdata");

function medicenter_doctors_edit_columns($columns)
{
	$new_columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => _x('Title', 'post type singular name', 'medicenter_doctors'),
			"doctors_category" => __('Categories', 'medicenter_doctors'),
			"date" => __('Date', 'medicenter_doctors')
	);

	return array_merge($new_columns, $columns);
}
add_filter("manage_edit-doctors_columns", "medicenter_doctors_edit_columns");

function manage_medicenter_doctors_posts_custom_column($column)
{
	global $post;
	switch ($column)
	{
		case "doctors_category":
			$doctors_category_list = (array)get_the_terms($post->ID, "doctors_category");
			foreach($doctors_category_list as $doctors_category)
			{
				if(empty($doctors_category->slug))
					continue;
				echo '<a href="' . esc_url(admin_url("edit.php?post_type=doctors&doctors_category=" . $doctors_category->slug)) . '">' . $doctors_category->name . '</a>' . (end($doctors_category_list)!=$doctors_category ? ", " : "");;
			}
			break;
	}
}
add_action("manage_doctors_posts_custom_column", "manage_medicenter_doctors_posts_custom_column");

//ajax pagination
add_action("wp_ajax_theme_doctors_pagination", "mc_theme_gallery_shortcode");
add_action("wp_ajax_nopriv_theme_doctors_pagination", "mc_theme_gallery_shortcode");
//shortcode
add_shortcode("doctors", "mc_theme_gallery_shortcode");

//visual composer
function medicenter_doctors_vc_init()
{
	if(is_plugin_active("js_composer/js_composer.php") && function_exists('vc_map'))
	{
		//get doctors list
		$doctors_list = get_posts(array(
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_type' => 'doctors'
		));
		$doctors_array = array();
		$doctors_array[__("All", 'medicenter_doctors')] = "-";
		foreach($doctors_list as $doctor)
			$doctors_array[$doctor->post_title . " (id:" . $doctor->ID . ")"] = $doctor->ID;

		//get doctors categories list
		$doctors_categories = get_terms("doctors_category");
		$doctors_categories_array = array();
		$doctors_categories_array[__("All", 'medicenter_doctors')] = "-";
		foreach($doctors_categories as $doctors_category)
			$doctors_categories_array[$doctors_category->name] =  $doctors_category->slug;
		
		//image sizes
		$image_sizes_array = array();
		$image_sizes_array[__("Default", 'medicenter_doctors')] = "default";
		$image_sizes_array[__("full (original image resolution)", 'medicenter_doctors')] = "full";
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
			"name" => __("Doctors list", 'medicenter_doctors'),
			"base" => "doctors",
			"class" => "",
			"controls" => "full",
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-layer-custom-post-type-list",
			"category" => __('MediCenter', 'medicenter_doctors'),
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Header", 'medicenter_doctors'),
					"param_name" => "header",
					"value" => ""
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Header border animation", 'medicenter_doctors'),
					"param_name" => "animation",
					"value" => array(__("no", 'medicenter_doctors') => 0,  __("yes", 'medicenter_doctors') => 1)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Order by", 'medicenter_doctors'),
					"param_name" => "order_by",
					"value" => array(__("Title, menu order", 'medicenter_doctors') => "title,menu_order", __("Menu order", 'medicenter_doctors') => "menu_order", __("Date", 'medicenter_doctors') => "date")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Order", 'medicenter_doctors'),
					"param_name" => "order",
					"value" => array(__("ascending", 'medicenter_doctors') => "ASC", __("descending", 'medicenter_doctors') => "DESC")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Style", 'medicenter_doctors'),
					"param_name" => "style",
					"value" => array(__("Default", 'medicenter_doctors') => "default", __("Light", 'medicenter_doctors') => "light")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Type", 'medicenter_doctors'),
					"param_name" => "type",
					"value" => array(__("List with details", 'medicenter_doctors') => "list_with_details", __("List", 'medicenter_doctors') => "list", __("Details", 'medicenter_doctors') => "details"),
					"dependency" => Array('element' => "style", 'value' => array('default'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Layout", 'medicenter_doctors'),
					"param_name" => "layout",
					"value" => array(__("4 columns", 'medicenter_doctors') => "gallery-4-columns", __("2 columns", 'medicenter_doctors') => "gallery-2-columns", __("3 columns", 'medicenter_doctors') => "gallery-3-columns"),
					"dependency" => Array('element' => "style", 'value' => array('default'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Featured image size", 'medicenter_doctors'),
					"param_name" => "featured_image_size",
					"value" => $image_sizes_array
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Hover icons", 'medicenter_doctors'),
					"param_name" => "hover_icons",
					"value" => array(__("Yes", 'medicenter_doctors') => 1, __("No", 'medicenter_doctors') => "0"),
					"dependency" => Array('element' => "style", 'value' => array('default'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Title box in details", 'medicenter_doctors'),
					"param_name" => "title_box",
					"value" => array(__("Yes", 'medicenter_doctors') => 1, __("No", 'medicenter_doctors') => 0),
					"dependency" => Array('element' => "type", 'value' => array('list_with_details'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display method", 'medicenter_doctors'),
					"param_name" => "display_method",
					"value" => array(__("Filters", 'medicenter_doctors') => 'dm_filters', __("Carousel", 'medicenter_doctors') => 'dm_carousel', __("Pagination", 'medicenter_doctors') => 'dm_pagination', __("Simple", 'medicenter_doctors') => 'dm_simple'),
					"dependency" => Array('element' => "type", 'value' => array('list_with_details', 'list'))
				),
				//filters options
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("All filter label", 'medicenter_doctors'),
					"param_name" => "all_label",
					"value" => "",
					"dependency" => Array('element' => "display_method", 'value' => 'dm_filters')
				),
				//carousel options
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Id", 'medicenter_doctors'),
					"param_name" => "id",
					"value" => "carousel",
					"description" => __("Please provide unique id for each carousel on the same page/post", 'medicenter_doctors'),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Autoplay", 'medicenter_doctors'),
					"param_name" => "autoplay",
					"value" => array(__("No", 'medicenter_doctors') => 0, __("Yes", 'medicenter_doctors') => 1),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Pause on hover", 'medicenter_doctors'),
					"param_name" => "pause_on_hover",
					"value" => array(__("Yes", 'medicenter_doctors') => 1, __("No", 'medicenter_doctors') => 0),
					"description" => __("Affect only when autoplay is set to yes", 'medicenter_doctors'),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Scroll", 'medicenter_doctors'),
					"param_name" => "scroll",
					"value" => 1,
					"description" => __("Number of items to scroll in one step", 'medicenter_doctors'),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Effect", 'medicenter_doctors'),
					"param_name" => "effect",
					"value" => array(
						__("scroll", 'medicenter_doctors') => "scroll", 
						__("none", 'medicenter_doctors') => "none", 
						__("directscroll", 'medicenter_doctors') => "directscroll",
						__("fade", 'medicenter_doctors') => "_fade",
						__("crossfade", 'medicenter_doctors') => "crossfade",
						__("cover", 'medicenter_doctors') => "cover",
						__("uncover", 'medicenter_doctors') => "uncover"
					),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Sliding easing", 'medicenter_doctors'),
					"param_name" => "easing",
					"value" => array(
						__("swing", 'medicenter_doctors') => "swing", 
						__("linear", 'medicenter_doctors') => "linear", 
						__("easeInQuad", 'medicenter_doctors') => "easeInQuad",
						__("easeOutQuad", 'medicenter_doctors') => "easeOutQuad",
						__("easeInOutQuad", 'medicenter_doctors') => "easeInOutQuad",
						__("easeInCubic", 'medicenter_doctors') => "easeInCubic",
						__("easeOutCubic", 'medicenter_doctors') => "easeOutCubic",
						__("easeInOutCubic", 'medicenter_doctors') => "easeInOutCubic",
						__("easeInQuart", 'medicenter_doctors') => "easeInQuart",
						__("easeOutQuart", 'medicenter_doctors') => "easeOutQuart",
						__("easeInOutQuart", 'medicenter_doctors') => "easeInOutQuart",
						__("easeInSine", 'medicenter_doctors') => "easeInSine",
						__("easeOutSine", 'medicenter_doctors') => "easeOutSine",
						__("easeInOutSine", 'medicenter_doctors') => "easeInOutSine",
						__("easeInExpo", 'medicenter_doctors') => "easeInExpo",
						__("easeOutExpo", 'medicenter_doctors') => "easeOutExpo",
						__("easeInOutExpo", 'medicenter_doctors') => "easeInOutExpo",
						__("easeInQuint", 'medicenter_doctors') => "easeInQuint",
						__("easeOutQuint", 'medicenter_doctors') => "easeOutQuint",
						__("easeInOutQuint", 'medicenter_doctors') => "easeInOutQuint",
						__("easeInCirc", 'medicenter_doctors') => "easeInCirc",
						__("easeOutCirc", 'medicenter_doctors') => "easeOutCirc",
						__("easeInOutCirc", 'medicenter_doctors') => "easeInOutCirc",
						__("easeInElastic", 'medicenter_doctors') => "easeInElastic",
						__("easeOutElastic", 'medicenter_doctors') => "easeOutElastic",
						__("easeInOutElastic", 'medicenter_doctors') => "easeInOutElastic",
						__("easeInBack", 'medicenter_doctors') => "easeInBack",
						__("easeOutBack", 'medicenter_doctors') => "easeOutBack",
						__("easeInOutBack", 'medicenter_doctors') => "easeInOutBack",
						__("easeInBounce", 'medicenter_doctors') => "easeInBounce",
						__("easeOutBounce", 'medicenter_doctors') => "easeOutBounce",
						__("easeInOutBounce", 'medicenter_doctors') => "easeInOutBounce"
					),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Sliding transition speed (ms)", 'medicenter_doctors'),
					"param_name" => "duration",
					"value" => 500,
					"dependency" => Array('element' => "display_method", 'value' => 'dm_carousel')
				),
				//pagination options
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Items per page", 'medicenter_doctors'),
					"param_name" => "items_per_page",
					"value" => 4,
					"dependency" => Array('element' => "display_method", 'value' => 'dm_pagination')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Ajax pagination", 'medicenter_doctors'),
					"param_name" => "ajax_pagination",
					"value" => array(__("Yes", 'medicenter_doctors') => 1, __("No", 'medicenter_doctors') => 0),
					"dependency" => Array('element' => "display_method", 'value' => 'dm_pagination')
				),
				array(
					"type" => "dropdownmulti",
					"class" => "",
					"heading" => __("Display selected", 'medicenter_doctors'),
					"param_name" => "ids",
					"value" => $doctors_array
				),
				array(
					"type" => "dropdownmulti",
					"class" => "",
					"heading" => __("Display from Category", 'medicenter_doctors'),
					"param_name" => "category",
					"value" => $doctors_categories_array
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display headers in details", 'medicenter_doctors'),
					"param_name" => "display_headers",
					"value" => array(__("Yes", 'medicenter_doctors') => 1, __("No", 'medicenter_doctors') => 0),
					"dependency" => Array('element' => "type", 'value' => array('list_with_details', 'details'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Headers type", 'medicenter_doctors'),
					"param_name" => "headers_type",
					"value" => array(__("H2", 'medicenter_doctors') => "h2", __("H1", 'medicenter_doctors') => "h1", __("H3", 'medicenter_doctors') => "h3", __("H4", 'medicenter_doctors') => "h4", __("H5", 'medicenter_doctors') => "h5"),
					"dependency" => Array('element' => "type", 'value' => array('list_with_details', 'details'))
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Display social icons", 'medicenter_doctors'),
					"param_name" => "display_social_icons",
					"value" => array(__("Yes", 'medicenter_doctors') => 1, __("No", 'medicenter_doctors') => 0)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Lightbox images loop", 'medicenter_doctors'),
					"param_name" => "images_loop",
					"value" => array(__("No", 'medicenter_doctors') => 0, __("Yes", 'medicenter_doctors') => 1),
					"dependency" => Array('element' => "type", 'value' => array('list_with_details', 'list'))
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'medicenter_doctors' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'medicenter_doctors' )
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Top margin", 'medicenter_doctors'),
					"param_name" => "top_margin",
					"value" => array(__("None", 'medicenter_doctors') => "none", __("Page (small)", 'medicenter_doctors') => "page-margin-top", __("Section (large)", 'medicenter_doctors') => "page-margin-top-section")
				)
			)
		));
	}
}
add_action("init", "medicenter_doctors_vc_init");
?>