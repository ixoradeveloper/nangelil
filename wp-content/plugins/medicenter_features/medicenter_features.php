<?php
/*
Plugin Name: MediCenter Theme Features
Plugin URI: https://1.envato.market/quanticalabs-portfolio
Description: MediCenter Theme Features Plugin
Author: QuanticaLabs
Author URI: https://1.envato.market/quanticalabs-portfolio
Version: 1.4
Text Domain: medicenter_features
*/

//translation
function medicenter_features_load_textdomain()
{
	load_plugin_textdomain("medicenter_features", false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'medicenter_features_load_textdomain');
//custom post type - features
if(is_admin())
{
	function medicenter_features_admin_menu()
	{
		$permalinks_page = add_submenu_page('edit.php?post_type=features', __('Permalink', 'medicenter_features'), __('Permalink', 'medicenter_features'), 'manage_options', 'features_permalink', 'medicenter_features_permalink');
	}
	add_action("admin_menu", "medicenter_features_admin_menu");
	
	function medicenter_features_permalink()
	{
		$message = "";
		if(isset($_POST["action"]) && $_POST["action"]=="save_features_permalink")
			$message = __("Options saved!", 'medicenter_features');
		$features_permalink = array(
			"slug" => 'features',
			"label_singular" => __("Feature", 'medicenter_features'),
			"label_plural" => __("Features", 'medicenter_features')
		);
		$features_permalink = array_merge($features_permalink, (array)get_option("features_permalink"));
		
		require_once("admin/admin-page-permalink.php");
	}
}
function medicenter_features_init()
{
	$features_permalink = array(
		"slug" => 'features',
		"label_singular" => __("Feature", 'medicenter_features'),
		"label_plural" => __("Features", 'medicenter_features')
	);
	if(isset($_POST["action"]) && $_POST["action"]=="save_features_permalink")
	{
		$features_permalink = array_merge($features_permalink, (array)get_option("features_permalink"));
		$slug_old = $features_permalink["slug"];
		$features_permalink = array(
			"slug" => (!empty($_POST["slug"]) ? sanitize_title($_POST["slug"]) : "features"),
			"label_singular" => (!empty($_POST["label_singular"]) ? $_POST["label_singular"] : __("Feature", "medicenter_features")),
			"label_plural" => (!empty($_POST["label_plural"]) ? $_POST["label_plural"] : __("Features", "medicenter_features"))
		);
		update_option("features_permalink", $features_permalink);
		if($slug_old!=$_POST["slug"])
		{
			delete_option('rewrite_rules');
		}
	}
	$features_permalink = array_merge($features_permalink, (array)get_option("features_permalink"));
	$labels = array(
		'name' => $features_permalink['label_plural'],
		'singular_name' => $features_permalink['label_singular'],
		'add_new' => _x('Add New', $features_permalink["slug"], 'medicenter_features'),
		'add_new_item' => sprintf(__('Add New %s' , 'medicenter_features') , $features_permalink['label_singular']),
		'edit_item' => sprintf(__('Edit %s', 'medicenter_features'), $features_permalink['label_singular']),
		'new_item' => sprintf(__('New %s', 'medicenter_features'), $features_permalink['label_singular']),
		'all_items' => sprintf(__('All %s', 'medicenter_features'), $features_permalink['label_plural']),
		'view_item' => sprintf(__('View %s', 'medicenter_features'), $features_permalink['label_singular']),
		'search_items' => sprintf(__('Search %s', 'medicenter_features'), $features_permalink['label_plural']),
		'not_found' =>  sprintf(__('No %s found', 'medicenter_features'), strtolower($features_permalink['label_plural'])),
		'not_found_in_trash' => sprintf(__('No %s found in Trash', 'medicenter_features'), strtolower($features_permalink['label_plural'])), 
		'parent_item_colon' => '',
		'menu_name' => $features_permalink['label_plural']
	);
	
	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",  
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => array("slug" => $features_permalink["slug"]),
		"supports" => array("title", "editor", "excerpt", "thumbnail", "page-attributes", "comments")  
	);
	register_post_type("features", $args);
	register_taxonomy("features_category", array("features"), array("label" => __("Categories", 'medicenter_features'), "singular_label" => __("Category", 'medicenter_features'), "rewrite" => true));
}  
add_action("init", "medicenter_features_init"); 

//Adds a box to the right column and to the main column on the Features edit screens
function medicenter_add_features_custom_box() 
{
	add_meta_box( 
        "features_config",
        __("Options", 'medicenter_features'),
        "medicenter_inner_features_custom_box_main",
        "features",
		"normal",
		"high"
    );
}
add_action("add_meta_boxes", "medicenter_add_features_custom_box");

function medicenter_inner_features_custom_box_main($post)
{
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "medicenter_features_noncename");
	
	//The actual fields for data entry
	$icon = get_post_meta($post->ID, "icon", true);
	$icons = array(
		"address",
		"ambulance",
		"app",
		"baby",
		"baby-bed",
		"baby-bottle",
		"bacteria",
		"balance",
		"battery",
		"book",
		"box",
		"brain",
		"briefcase",
		"burns",
		"cart",
		"cat",
		"certificate",
		"chart",
		"chat",
		"clock",
		"config",
		"credit-card",
		"cross",
		"dental-shield",
		"dentist",
		"diary",
		"dna",
		"doctor",
		"document",
		"document-missing",
		"dog",
		"drip",
		"ear",
		"email",
		"eye",
		"facebook",
		"first-aid",
		"fitness",
		"frostbite",
		"gallery",
		"glasses",
		"graph",
		"healthcare",
		"heart",
		"heart-beat",
		"home",
		"hospital",
		"id",
		"image",
		"keyboard",
		"lab",
		"laptop",
		"leaf",
		"lifeline",
		"list",
		"location",
		"lock",
		"map",
		"medical-bed",
		"medical-cast",
		"medical-cross",
		"medical-document",
		"medical-results",
		"medical-scissors",
		"medical-staff",
		"minus",
		"mobile",
		"molecule",
		"money",
		"mortar",
		"movie",
		"network",
		"paypal",
		"pen",
		"people",
		"pet-box",
		"phone",
		"piano",
		"pill",
		"pin",
		"plaster",
		"play",
		"plus",
		"printer",
		"pulse",
		"quote",
		"science",
		"screen",
		"signpost",
		"spa",
		"spa-bamboo",
		"spa-lotion",
		"speaker",
		"stethoscope",
		"syringe",
		"tablet",
		"tags",
		"teddy-bear",
		"test-tube",
		"tick",
		"time",
		"toothbrush",
		"twitter",
		"video",
		"wallet",
		"x-ray"
	);
	echo '
	<table>
		<tr>
			<td>
				<label for="icon">' . __('Icon', 'medicenter_features') . ':</label>
			</td>
			<td>
				<select id="features_icon" name="features_icon">
					<option value="-">' . __("none", 'medicenter_features') . '</option>';
					foreach($icons as $single_icon)
					{
						echo '<option class="features-' . esc_attr($single_icon) . '" value="' . esc_attr($single_icon) . '"' . ($single_icon==$icon ? ' selected="selected"' : '') . '>' . $single_icon . '</option>';
					}
				echo '</select>
			</td>
		</tr>
	</table>';
}

//When the post is saved, saves our custom data
function medicenter_save_features_postdata($post_id) 
{
	//verify if this is an auto save routine. 
	//if it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if (!isset($_POST['medicenter_features_noncename']) || !wp_verify_nonce($_POST['medicenter_features_noncename'], plugin_basename( __FILE__ )))
		return;


	//Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;

	//OK, we're authenticated: we need to find and save the data
	update_post_meta($post_id, "icon", $_POST["features_icon"]);
}
add_action("save_post", "medicenter_save_features_postdata");

function medicenter_features_edit_columns($columns)
{
	$new_columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => _x('Title', 'post type singular name', 'medicenter_features'),
			"features_category" => __('Categories', 'medicenter_features'),
			"features_icon" => __('Icon', 'medicenter_features'),
			"date" => __('Date', 'medicenter_features')
	);

	return array_merge($new_columns, $columns);
}
add_filter("manage_edit-features_columns", "medicenter_features_edit_columns");

function manage_medicenter_features_posts_custom_column($column)
{
	global $post;
	switch ($column)
	{
		case "features_category":
			$features_category_list = (array)get_the_terms($post->ID, "features_category");
			foreach($features_category_list as $features_category)
			{
				if(empty($features_category->slug))
					continue;
				echo '<a href="' . esc_url(admin_url("edit.php?post_type=features&features_category=" . $features_category->slug)) . '">' . $features_category->name . '</a>' . (end($features_category_list)!=$features_category ? ", " : "");;
			}
			break;
		case "features_icon":
			echo  get_post_meta($post->ID, "icon", true);
			break;
	}
}
add_action("manage_features_posts_custom_column", "manage_medicenter_features_posts_custom_column");

function medicenter_features_shortcode($atts)
{
	extract(shortcode_atts(array(
		"category" => "",
		"ids" => "",
		"order_by" => "title menu_order",
		"order" => "ASC",
		"type" => "large",
		"style" => "default",
		"spacing" => "default",
		"columns" => 0,
		"headers" => 0,
		"headers_links" => 1,
		"headers_size" => "small",
		"show_excerpt" => 1,
		"excerpt_length" => 100,
		"read_more" => 1,
		"icon_links" => 1,
		"animation" => "",
		"animation_duration" => "",
		"animation_delay" => "",
		"top_margin" => "none",
		"el_class" => ""
	), $atts));
	
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
	query_posts(array(
		'post__in' => $ids,
		'post_type' => 'features',
		'posts_per_page' => '-1',
		'post_status' => 'publish',
		'features_category' => implode(",", $category),
		'orderby' => implode(" ", explode(",", $order_by)),
		'order' => $order
	));
	
	global $wp_query; 
	$post_count = $wp_query->post_count;
	
	$output = "";
	if(have_posts())
	{
		$i=0;
		$output .= '<ul class="clearfix mc-features mc-features-' . esc_attr($type) . ' mc-features-style-' . esc_attr($style) . ($spacing!="default" ? ' mc-features-spacing-' . esc_attr($spacing) : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ($el_class!="" ? ' ' . esc_attr($el_class) : '') . '">';
		while(have_posts()): the_post();
		if((int)$columns && ($i==0 || ($type=="large" && $i==ceil($post_count/2)) || ($type=="small" && $i==ceil($post_count/3)) || ($type=="small" && $i==ceil($post_count/3*2))))
		{
			if(($type=="large" && $i==ceil($post_count/2)) || ($type=="small" && $i==ceil($post_count/3)) || ($type=="small" && $i==ceil($post_count/3*2)))
				$output .= '</ul>';
			$output .= '<ul class="mc-features mc-features-' . esc_attr($type) . ' mc-features-style-' . esc_attr($style) . ' column' . ($type=="large" ? ($i==ceil($post_count/2) ? '_right' : '_left') : '') . '">';
		}
		$icon = get_post_meta(get_the_ID(), "icon", true);
		$excerpt_display = "";
		if((int)$show_excerpt)
		{
			$excerpt = preg_replace("/\[[^\]]+\]/", '', get_the_content());
			$excerpt_display = (!has_excerpt() && (int)$excerpt_length && strlen($excerpt)>=(int)$excerpt_length && strpos($excerpt, ' ', (int)$excerpt_length) ? substr($excerpt, 0, strpos($excerpt, ' ', (int)$excerpt_length)) . "..." : (has_excerpt() ? get_the_excerpt() : $excerpt));
		}
		$output .= '<li class="item-content clearfix' . (!isset($icon) || $icon=="-" ? ' no-icon' : '') . '">
				' . (isset($icon) && $icon!="-" ? '<' . ($icon_links==1 ? 'a' : 'span') . ' class="' . ($type=="circle" || $type=="circle circle-small" ? 'circle' : 'hexagon') . ($type=="small" ? ' small' : '') . ($animation!='' ? ' animated-element animation-' . $animation . ((int)$animation_duration>0 && (int)$animation_duration!=600 ? ' duration-' . (int)$animation_duration : '') . ((int)$animation_delay>0 ? ' delay-' . (int)$animation_delay : '') : '') . '" ' . ($icon_links==1 ? 'href="' . get_permalink() . '"' : '') . ' title="' . esc_attr(get_the_title()) . '"><span class="features-' . esc_attr($icon) . '"></span></' . ($icon_links==1 ? 'a' : 'span') . '>' : '') . '<div class="text">'
				. ((int)$headers==1 ? '<h' . ($headers_size=="large" ? '2' : '3') . '><' . ($headers_links==1 ? 'a' : 'span') . ' ' . ($headers_links==1 ? 'href="' . get_permalink() . '"' : '') . '  title="' . esc_attr(get_the_title()) . '">' . get_the_title() . '</' . ($headers_links==1 ? 'a' : 'span') . '></h' . ($headers_size=="large" ? '2' : '3') . '>' : '')
				. ((int)$show_excerpt ? apply_filters('the_excerpt', $excerpt_display) : '') . 
				((int)$read_more==1 ? '<div class="item-footer clearfix"><a title="' . __("Read more", 'medicenter_features') . '" href="' . get_permalink() . '" class="more template-arrow-horizontal-1-after">' . __("Read more", 'medicenter_features') . '</a></div>' : '') .
				'</div>
			</li>';
		$i++;
		endwhile;
		$output .= '</ul>' . ((int)$columns ? '</div>' : '');
	}
	//Reset Query
	wp_reset_query();
	return $output;
}
add_shortcode("features", "medicenter_features_shortcode");

//visual composer
function medicenter_features_vc_init()
{
	if(is_plugin_active("js_composer/js_composer.php") && function_exists('vc_map'))
	{
		//get features list
		$features_list = get_posts(array(
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_type' => 'features'
		));
		$features_array = array();
		$features_array[__("All", 'medicenter_features')] = "-";
		foreach($features_list as $feature)
			$features_array[$feature->post_title . " (id:" . $feature->ID . ")"] = $feature->ID;

		//get features categories list
		$features_categories = get_terms("features_category");
		$features_categories_array = array();
		$features_categories_array[__("All", 'medicenter_features')] = "-";
		foreach($features_categories as $features_category)
			$features_categories_array[$features_category->name] =  $features_category->slug;

		vc_map( array(
			"name" => __("Features list", 'medicenter_features'),
			"base" => "features",
			"class" => "",
			"controls" => "full",
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-layer-features-list",
			"category" => __('MediCenter', 'medicenter_features'),
			"params" => array(
				array(
					"type" => "dropdownmulti",
					"class" => "",
					"heading" => __("Display selected", 'medicenter_features'),
					"param_name" => "ids",
					"value" => $features_array
				),
				array(
					"type" => "dropdownmulti",
					"class" => "",
					"heading" => __("Display from Category", 'medicenter_features'),
					"param_name" => "category",
					"value" => $features_categories_array
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Type", 'medicenter_features'),
					"param_name" => "type",
					"value" => array(__("Hexagon Large", 'medicenter_features') => "large", __("Hexagon Small", 'medicenter_features') => "small", __("Circle Large", 'medicenter_features') => "circle", __("Circle Small", 'medicenter_features') => "circle circle-small")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Style", 'medicenter_features'),
					"param_name" => "style",
					"value" => array(__("Default", 'medicenter_features') => "default", __("Light", 'medicenter_features') => "light", __("Light white", 'medicenter_features') => "light light-white", __("Light colored", 'medicenter_features') => "light light-colored")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Items spacing", 'medicenter_features'),
					"param_name" => "spacing",
					"value" => array(__("Default", 'medicenter_features') => "default", __("Large", 'medicenter_features') => "large")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Order by", 'medicenter_features'),
					"param_name" => "order_by",
					"value" => array(__("Title, menu order", 'medicenter_features') => "title,menu_order", __("Menu order", 'medicenter_features') => "menu_order", __("Date", 'medicenter_features') => "date")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Order", 'medicenter_features'),
					"param_name" => "order",
					"value" => array(__("ascending", 'medicenter_features') => "ASC", __("descending", 'medicenter_features') => "DESC")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Headers", 'medicenter_features'),
					"param_name" => "headers",
					"value" => array(__("No", 'medicenter_features') => 0, __("Yes", 'medicenter_features') => 1)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Headers links", 'medicenter_features'),
					"param_name" => "headers_links",
					"value" => array(__("Yes", 'medicenter_features') => 1, __("No", 'medicenter_features') => 0),
					"dependency" => Array('element' => "headers", 'value' => '1')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Headers size", 'medicenter_features'),
					"param_name" => "headers_size",
					"value" => array(__("Small", 'medicenter_features') => "small", __("Large", 'medicenter_features') => "large"),
					"dependency" => Array('element' => "headers", 'value' => '1')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Show excerpt", 'medicenter_features'),
					"param_name" => "show_excerpt",
					"value" => array(__("Yes", 'medicenter_features') => 1, __("No", 'medicenter_features') => 0)
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Excerpt length", 'medicenter_features'),
					"param_name" => "excerpt_length",
					"value" => 100,
					"description" => __("The excerpt length. Set 0 to use default WordPress excerpt length.", 'medicenter_features'),
					"dependency" => Array('element' => "show_excerpt", 'value' => "1")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Read more button", 'medicenter_features'),
					"param_name" => "read_more",
					"value" => array(__("No", 'medicenter_features') => 0, __("Yes", 'medicenter_features') => 1)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Icon links", 'medicenter_features'),
					"param_name" => "icon_links",
					"value" => array(__("Yes", 'medicenter_features') => 1, __("No", 'medicenter_features') => 0)
				),
				array(
					"type" => "dropdown",
					"heading" => __("Icon animation", "medicenter"),
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
					"heading" => __("Icon animation duration", 'medicenter_features'),
					"param_name" => "animation_duration",
					"value" => "600"
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Icon animation delay", 'medicenter_features'),
					"param_name" => "animation_delay",
					"value" => "0"
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Top margin", 'medicenter_features'),
					"param_name" => "top_margin",
					"value" => array(__("None", 'medicenter_features') => "none", __("Page (small)", 'medicenter_features') => "page-margin-top", __("Section (large)", 'medicenter_features') => "page-margin-top-section")
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", "medicenter"),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'medicenter_features' )
				)
			)
		));
	}
}
add_action("init", "medicenter_features_vc_init");
?>