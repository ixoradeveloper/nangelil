<?php
/*
Plugin Name: MediCenter Theme Departments
Plugin URI: https://1.envato.market/quanticalabs-portfolio
Description: MediCenter Theme Departments Plugin
Author: QuanticaLabs
Author URI: https://1.envato.market/quanticalabs-portfolio
Version: 1.3
Text Domain: medicenter_departments
*/

//translation
function medicenter_departments_load_textdomain()
{
	load_plugin_textdomain("medicenter_departments", false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'medicenter_departments_load_textdomain');
//custom post type - departments
if(is_admin())
{
	function medicenter_departments_admin_menu()
	{
		$permalinks_page = add_submenu_page('edit.php?post_type=departments', __('Permalink', 'medicenter_departments'), __('Permalink', 'medicenter_departments'), 'manage_options', 'departments_permalink', 'medicenter_departments_permalink');
	}
	add_action("admin_menu", "medicenter_departments_admin_menu");
	
	function medicenter_departments_permalink()
	{
		$message = "";
		if(isset($_POST["action"]) && $_POST["action"]=="save_departments_permalink")
			$message = __("Options saved!", "medicenter_departments");
		$departments_permalink = array(
			"slug" => 'departments',
			"label_singular" => __("Department", 'medicenter_departments'),
			"label_plural" => __("Departments", 'medicenter_departments')
		);
		$departments_permalink = array_merge($departments_permalink, (array)get_option("departments_permalink"));
		
		require_once("admin/admin-page-permalink.php");
	}
}
function medicenter_departments_init()
{
	global $blog_id;
	global $wpdb;
	
	$departments_permalink = array(
		"slug" => 'departments',
		"label_singular" => __("Department", 'medicenter_departments'),
		"label_plural" => __("Departments", 'medicenter_departments')
	);
	if(isset($_POST["action"]) && $_POST["action"]=="save_departments_permalink")
	{
		$departments_permalink = array_merge($departments_permalink, (array)get_option("departments_permalink"));
		$slug_old = $departments_permalink["slug"];
		$departments_permalink = array(
			"slug" => (!empty($_POST["slug"]) ? sanitize_title($_POST["slug"]) : "departments"),
			"label_singular" => (!empty($_POST["label_singular"]) ? $_POST["label_singular"] : __("Department", "medicenter_departments")),
			"label_plural" => (!empty($_POST["label_plural"]) ? $_POST["label_plural"] : __("Departments", "medicenter_departments"))
		);
		update_option("departments_permalink", $departments_permalink);
		if($slug_old!=$_POST["slug"])
		{
			delete_option('rewrite_rules');
		}
	}
	$departments_permalink = array_merge($departments_permalink, (array)get_option("departments_permalink"));
	$labels = array(
		'name' => $departments_permalink['label_plural'],
		'singular_name' => $departments_permalink['label_singular'],
		'add_new' => _x('Add New', $departments_permalink["slug"], 'medicenter_departments'),
		'add_new_item' => sprintf(__('Add New %s' , 'medicenter_departments') , $departments_permalink['label_singular']),
		'edit_item' => sprintf(__('Edit %s', 'medicenter_departments'), $departments_permalink['label_singular']),
		'new_item' => sprintf(__('New %s', 'medicenter_departments'), $departments_permalink['label_singular']),
		'all_items' => sprintf(__('All %s', 'medicenter_departments'), $departments_permalink['label_plural']),
		'view_item' => sprintf(__('View %s', 'medicenter_departments'), $departments_permalink['label_singular']),
		'search_items' => sprintf(__('Search %s', 'medicenter_departments'), $departments_permalink['label_plural']),
		'not_found' =>  sprintf(__('No %s found', 'medicenter_departments'), strtolower($departments_permalink['label_plural'])),
		'not_found_in_trash' => sprintf(__('No %s found in Trash', 'medicenter_departments'), strtolower($departments_permalink['label_plural'])), 
		'parent_item_colon' => '',
		'menu_name' => $departments_permalink['label_plural']
	);

	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",  
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => array("slug" => $departments_permalink["slug"]),
		"supports" => array("title", "editor", "excerpt", "thumbnail", "page-attributes")  
	);
	register_post_type("departments", $args);
	
	register_taxonomy("departments_category", array("departments"), array("label" => __("Categories", 'medicenter_departments'), "singular_label" => __("Category", 'medicenter_departments'), "rewrite" => true)); 
	
	if(get_option("medicenter_department_hours_table_installed") && !get_option("medicenter_department_hours_table_renamed"))
	{
		// CHECK IF OLD TABLE NAME EXISTS AND CHANGE IT TO NEW ONE
		if($wpdb->query("SHOW TABLES LIKE 'wp_" . $blog_id . "_department_hours'") && ("wp_" . $blog_id . "_")!=($wpdb->prefix))
		{
			$query = "RENAME TABLE `wp_" . $blog_id . "_department_hours` to `" . $wpdb->prefix . "department_hours` ";
			$wpdb->query($query);
		}
		add_option("medicenter_department_hours_table_renamed", 1);
    }
	
	if(!get_option("medicenter_department_hours_table_installed"))
	{
		//create custom db table
		$query = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "department_hours` (
			`department_hours_id` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`department_id` BIGINT( 20 ) NOT NULL ,
			`weekday_id` BIGINT( 20 ) NOT NULL ,
			`start` TIME NOT NULL ,
			`end` TIME NOT NULL,
			`tooltip` text NOT NULL,
			`before_hour_text` text NOT NULL,
			`after_hour_text` text NOT NULL,
			`doctors` varchar(255) NOT NULL,
			`category` varchar(255) NOT NULL,
			INDEX ( `department_id` ),
			INDEX ( `weekday_id` )
		) ENGINE = MYISAM DEFAULT CHARSET=utf8;";
		$wpdb->query($query);
		//insert sample data
		$query = "INSERT INTO `".$wpdb->prefix."department_hours` (`department_hours_id`, `department_id`, `weekday_id`, `start`, `end`, `tooltip`, `before_hour_text`, `after_hour_text`, `doctors`, `category`) VALUES
			(20, 63, 1213, '06:00:00', '07:00:00', '06.00 - 07.00<br>\r\nAnn Blyumin, Prof.<br>\r\nOffice 367, Hall A', '', 'Office 367, Hall A', '378', ''),
			(77, 112, 1213, '15:00:00', '19:00:00', '15.00 - 19.00<br>\r\nSue Collins<br>\r\nGym Arena', '', 'Gym Arena', '1722', ''),
			(18, 63, 1216, '17:00:00', '20:00:00', '17.00 - 20.00<br>\r\nEarlene Milone, Prof.<br>\r\nOffice 150, Hall B', '', 'Office 150, Hall B', '393', ''),
			(26, 64, 1218, '12:20:00', '13:00:00', '12.20 - 13.00<br>\r\nClare Mitchell, Prof.<br>\r\nOffice 112, Hall C', '', 'Office 112, Hall C', '392', ''),
			(28, 106, 1212, '16:00:00', '17:45:00', '16.00 - 17.45<br>\r\nJohn D. Tom<br>\r\nOffice 6, Hall B', '', 'Office 6, Hall B', '414', ''),
			(25, 64, 1217, '12:20:00', '13:00:00', '12.20 - 13.00<br>\r\nClare Mitchell, Prof.<br>\r\nOffice 112, Hall C', '', 'Office 112, Hall C', '392', ''),
			(71, 64, 1216, '07:00:00', '10:00:00', '07.00 - 10.00<br>\r\nAnn Blyumin, Prof.<br>\r\nOffice 112, Hall C', '', 'Office 112, Hall C', '378', ''),
			(72, 64, 1213, '09:00:00', '11:00:00', '09.00 - 11.00<br>\r\nClare Mitchell, Prof.<br>\r\nOffice 112, Hall C', '', 'Office 112, Hall C', '392', ''),
			(21, 63, 1212, '06:00:00', '07:00:00', '06.00 - 07.00<br>\r\nAnn Blyumin, Prof.<br>\r\nOffice 367, Hall A', '', 'Office 367, Hall A', '378', ''),
			(70, 64, 1215, '07:00:00', '10:00:00', '07.00 - 10.00<br>\r\nAnn Blyumin, Prof.<br>\r\nOffice 112, Hall C', '', 'Office 112, Hall C', '378', ''),
			(29, 106, 1213, '15:00:00', '19:00:00', '15.00 - 19.00<br>\r\nJohn D. Tom<br>\r\nOffice 6, Hall B', '', 'Office 6, Hall B', '414', ''),
			(30, 106, 1215, '06:00:00', '10:00:00', '06.00 - 10.00<br>\r\nJohn D. Tom<br>\r\nOffice 6, Hall B', '', 'Office 6, Hall B', '414', ''),
			(31, 106, 1216, '12:15:00', '16:00:00', '12.15 - 16.00<br>\r\nJohn D. Tom<br>\r\nOffice 6, Hall B', '', 'Office 6, Hall B', '414', ''),
			(32, 106, 1218, '13:00:00', '14:00:00', '13.00 - 14.00<br>\r\nJohn D. Tom<br>\r\nOffice 6, Hall B', '', 'Office 6, Hall B', '414', ''),
			(90, 63, 1217, '09:00:00', '10:00:00', '09.00 - 10.00<br>\r\nRobert van Hex<br>\r\nOffice 207, Hall B', '', 'Office 207, Hall B', '1719', ''),
			(91, 63, 1218, '09:00:00', '10:00:00', '09.00 - 10.00<br>\r\nRobert van Hex<br>\r\nOffice 207, Hall B', '', 'Office 207, Hall B', '1719', ''),
			(89, 106, 1218, '15:00:00', '19:00:00', '15.00 - 19.00<br>\r\nRobert van Hex<br>\r\nOffice 6, Hall B', '', 'Office 6, Hall B', '1719', ''),
			(37, 107, 1212, '07:00:00', '09:00:00', '07.00 - 09.00<br>\r\nRobert Brown, Prof.<br>\r\nOffice 224, Hall B', '', 'Office 224, Hall B', '387', ''),
			(38, 107, 1213, '07:00:00', '09:00:00', '07.00 - 09.00<br>\r\nRobert Brown, Prof.<br>\r\nOffice 224, Hall B', '', 'Office 224, Hall B', '387', ''),
			(39, 107, 1214, '07:00:00', '09:00:00', '07.00 - 09.00<br>\r\nRobert Brown, Prof.<br>\r\nOffice 224, Hall B', '', 'Office 224, Hall B', '387', ''),
			(44, 108, 1214, '14:00:00', '16:00:00', '14.00 - 16.00<br>\r\nJohn D. Tom<br>\r\nOffice 25, Hall A', '', 'Office 25, Hall A', '414', ''),
			(41, 107, 1217, '10:00:00', '11:00:00', '10.00 - 11.00<br>\r\nRobert Brown, Prof.<br>\r\nOffice 224, Hall B', '', 'Office 224, Hall B', '387', ''),
			(42, 107, 1218, '10:00:00', '11:00:00', '10.00 - 11.00<br>\r\nRobert Brown, Prof.<br>\r\nOffice 224, Hall B', '', 'Office 224, Hall B', '387', ''),
			(43, 107, 1216, '07:00:00', '11:00:00', '07.00 - 11.00<br>\r\nRobert Brown, Prof.<br>\r\nOffice 224, Hall B', '', 'Office 224, Hall B', '387', ''),
			(49, 109, 1212, '10:00:00', '12:50:00', '10.00 - 12.50<br>\r\nEarlene Milone, Prof.<br>\r\nOffice 150, Hall B', '', 'Office 150, Hall B', '393', ''),
			(47, 108, 1212, '10:00:00', '13:00:00', '10.00 - 13.00<br>\r\nJohn D. Tom<br>\r\nOffice 25, Hall A', '', 'Office 25, Hall A', '414', ''),
			(48, 108, 1217, '13:00:00', '15:30:00', '13.00 - 15.30<br>\r\nJohn D. Tom<br>\r\nOffice 25, Hall A', '', 'Office 25, Hall A', '414', ''),
			(51, 109, 1217, '13:00:00', '17:00:00', '13.00 - 17.00<br>\r\nEarlene Milone, Prof.<br>\r\nOffice 150, Hall B', '', 'Office 150, Hall B', '393', ''),
			(81, 111, 1215, '16:00:00', '20:00:00', '16.00 - 20.00<br>\r\nNorma Blueman<br>\r\nOffice 8, Hall A', '', 'Office 8, Hall A', '1723', ''),
			(85, 110, 1216, '06:00:00', '07:00:00', '06.00 - 07.00<br>\r\nSue Collins<br>\r\nOffice 114, Hall C', '', 'Office 114, Hall C', '1722', ''),
			(88, 107, 1214, '13:00:00', '14:00:00', '13.00 - 14.00<br>\r\nTim Duncan<br>\r\nOffice 224, Hall B', '', 'Office 224, Hall B', '1721', ''),
			(87, 107, 1215, '12:00:00', '13:00:00', '12.00 - 13.00<br>\r\nTim Duncan<br>\r\nOffice 224, Hall B', '', 'Office 224, Hall B', '1721', ''),
			(86, 107, 1213, '13:00:00', '15:00:00', '13.00 - 15.00<br>\r\nTim Duncan<br>\r\nOffice 224, Hall B', '', 'Office 224, Hall B', '1721', ''),
			(62, 109, 1215, '13:00:00', '16:00:00', '13.00 - 16.00<br>\r\nEarlene Milone, Prof.<br>\r\nOffice 150, Hall B', '', 'Office 150, Hall B', '393', ''),
			(84, 110, 1217, '13:00:00', '17:00:00', '13.00 - 17.00<br>\r\nSue Collins<br>\r\nOffice 114, Hall C', '', 'Office 114, Hall C', '1722', ''),
			(83, 110, 1215, '06:00:00', '07:00:00', '06.00 - 07.00<br>\r\nSue Collins<br>\r\nOffice 114, Hall C', '', 'Office 114, Hall C', '1722', ''),
			(67, 64, 1212, '13:30:00', '16:00:00', '13.30 - 16.00<br>\r\nClare Mitchell, Prof.<br>\r\nOffice 112, Hall C', '', 'Office 112, Hall C', '392', ''),
			(80, 111, 1214, '16:00:00', '17:00:00', '16.00 - 17.00<br>\r\nNorma Blueman<br>\r\nOffice 8, Hall A', '', 'Office 8, Hall A', '1723', ''),
			(75, 63, 1216, '09:00:00', '11:00:00', '09.00 - 11.00\r\nRobert Brown, Prof.\r\nOffice 112, Hall C', '', 'Office 112, Hall C', '387', ''),
			(74, 63, 1214, '09:00:00', '11:00:00', '09.00 - 11.00<br>\r\nRobert Brown, Prof.<br>\r\nOffice 112, Hall C', '', 'Office 112, Hall C', '387', ''),
			(73, 64, 1214, '09:00:00', '11:00:00', '09.00 - 11.00<br>\r\nClare Mitchell, Prof.<br>\r\nOffice 112, Hall C', '', 'Office 112, Hall C', '392', ''),
			(76, 63, 1214, '17:00:00', '20:00:00', '17.00 - 20.00<br>\r\nEarlene Milone, Prof.<br>\r\nOffice 150, Hall B', '', 'Office 150, Hall B', '393', ''),
			(78, 112, 1216, '13:00:00', '16:00:00', '13.00 - 16.00<br>\r\nRobert van Hex<br>\r\nGym Arena', '', 'Gym Arena', '1719', ''),
			(79, 112, 1218, '16:00:00', '19:00:00', '16.00 - 19.00<br>\r\nRobert van Hex<br>\r\nGym Arena', '', 'Gym Arena', '1719', ''),
			(82, 111, 1216, '16:00:00', '20:00:00', '16.00 - 20.00<br>\r\nNorma Blueman<br>\r\nOffice 8, Hall A', '', 'Office 8, Hall A', '1723', '');";
		$wpdb->query($query);
		add_option("medicenter_department_hours_table_installed", 1);
	}
}  
add_action("init", "medicenter_departments_init");

//Adds a box to the right column and to the main column on the Departments edit screens
function medicenter_add_departments_custom_box() 
{
    add_meta_box(
        "department_hours",
        __("Department hours", 'medicenter_departments'),
        "medicenter_inner_departments_custom_box_side",
        "departments",
		"normal"
    );
	add_meta_box( 
        "department_config",
        __("Options", 'medicenter_departments'),
        "medicenter_inner_departments_custom_box_main",
        "departments",
		"normal",
		"high"
    );
}
add_action("add_meta_boxes", "medicenter_add_departments_custom_box");

//get department hour details
function medicenter_get_department_hour_details()
{
	global $blog_id;
	global $wpdb;
	$query = "SELECT * FROM `" . $wpdb->prefix . "department_hours` AS t1 LEFT JOIN {$wpdb->posts} AS t2 ON t1.weekday_id=t2.ID WHERE t1.department_id='" . $_POST["post_id"] . "' AND t1.department_hours_id='" . $_POST["id"] . "'";
	$department_hour = $wpdb->get_row($query);
	$department_hour->start = date("H:i", strtotime($department_hour->start));
	$department_hour->end = date("H:i", strtotime($department_hour->end));
	echo "department_hour_start" . json_encode($department_hour) . "department_hour_end";
	exit();
}
add_action('wp_ajax_get_department_hour_details', 'medicenter_get_department_hour_details');

// Prints the box content
function medicenter_inner_departments_custom_box_side($post) 
{
	global $blog_id;
	global $wpdb;
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "medicenter_departments_noncename");

	//The actual fields for data entry
	$query = "SELECT * FROM `" . $wpdb->prefix . "department_hours` AS t1 LEFT JOIN {$wpdb->posts} AS t2 ON t1.weekday_id=t2.ID WHERE t1.department_id='" . $post->ID . "' ORDER BY FIELD(t2.menu_order,2,3,4,5,6,7,1), t1.start, t1.end";
	$department_hours = $wpdb->get_results($query);
	$department_hours_count = count($department_hours);
	
	//get weekdays
	$query = "SELECT ID, post_title FROM {$wpdb->posts}
			WHERE 
			post_type='medicenter_weekdays'
			ORDER BY FIELD(menu_order,2,3,4,5,6,7,1)";
	$weekdays = $wpdb->get_results($query);
	echo '
	<ul id="department_hours_list"' . (!$department_hours_count ? ' style="display: none;"' : '') . '>';
		for($i=0; $i<$department_hours_count; $i++)
		{
			//get day by id
			$current_day = get_post($department_hours[$i]->weekday_id);
			echo '<li id="department_hours_' . $department_hours[$i]->department_hours_id . '">' . $current_day->post_title . ' ' . date("H:i", strtotime($department_hours[$i]->start)) . '-' . date("H:i", strtotime($department_hours[$i]->end)) . '<img class="operation_button delete_button" src="' . esc_url(get_template_directory_uri() . '/admin/images/delete.png') . '" alt="del" /><img class="operation_button edit_button" src="' . esc_url(get_template_directory_uri() . '/admin/images/edit.png') . '" alt="edit" /><img class="operation_button edit_hour_department_loader" src="' . esc_url(get_template_directory_uri() . '/admin/images/ajax-loader.gif') . '" alt="loader" />';
			$doctorsString = "";
			if($department_hours[$i]->doctors!="")
			{
				query_posts(array( 
					'post__in' => explode(",", $department_hours[$i]->doctors),
					'post_type' => 'doctors',
					'posts_per_page' => '-1',
					'post_status' => 'publish',
					'orderby' => 'post_title', 
					'order' => 'DESC'
				));
				while(have_posts()): the_post();
					$doctorsString .= get_the_title() . ", ";
				endwhile;
				if($doctorsString!="")
					$doctorsString = substr($doctorsString, 0, -2);
			}
			if($department_hours[$i]->tooltip!="" || $department_hours[$i]->before_hour_text!="" || $department_hours[$i]->after_hour_text!="" || $doctorsString!="" || $department_hours[$i]->category!="")
			{
				echo '<div>';
				if($department_hours[$i]->tooltip!="")
					echo '<br /><strong>' . __('Tooltip', 'medicenter_departments') . ':</strong> ' . $department_hours[$i]->tooltip;
				if($department_hours[$i]->before_hour_text!="")
					echo '<br /><strong>' . __('Before hour text', 'medicenter_departments') . ':</strong> ' . $department_hours[$i]->before_hour_text;
				if($department_hours[$i]->after_hour_text!="")
					echo '<br /><strong>' . __('After hour text', 'medicenter_departments') . ':</strong> ' . $department_hours[$i]->after_hour_text;
				if($doctorsString)
					echo '<br /><strong>' . __('doctors', 'medicenter_departments') . ':</strong> ' . $doctorsString;
				if($department_hours[$i]->category!="")
					echo '<br /><strong>' . __('Category', 'medicenter_departments') . ':</strong> ' . $department_hours[$i]->category;
				echo '</div>';
			}
			echo '</li>';
		}
	echo '
	</ul>
	<table id="department_hours_table">
		<tr>
			<td>
				<label for="weekday_id">' . __('Day', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<select name="weekday_id" id="weekday_id">';
				foreach($weekdays as $weekday)
					echo '<option value="' . $weekday->ID . '">' . $weekday->post_title . '</option>';
	echo '		</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for="start_hour">' . __('Start hour', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<input size="5" maxlength="5" type="text" id="start_hour" name="start_hour" value="" />
				<span class="description">hh:mm</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="end_hour">' . __('End hour', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<input size="5" maxlength="5" type="text" id="end_hour" name="end_hour" value="" />
				<span class="description">hh:mm</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="before_hour_text">' . __('Before hour text', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<textarea id="before_hour_text" name="before_hour_text"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<label for="after_hour_text">' . __('After hour text', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<textarea id="after_hour_text" name="after_hour_text"></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<label for="tooltip">' . __('Tooltip', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<textarea id="tooltip" name="tooltip"></textarea>
			</td>
		</tr>';
		if(wp_count_posts("doctors"))
		{
			echo '
		<tr>
			<td>
				<label for="doctors">' . __('Doctors', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<select id="department_hour_doctors" name="department_hour_doctors[]" multiple="multiple">';
					query_posts(array( 
						'post_type' => 'doctors',
						'posts_per_page' => '-1',
						'post_status' => 'publish',
						'orderby' => 'post_title', 
						'order' => 'DESC'
					));
					while(have_posts()): the_post();
						echo '<option value="' . esc_attr(get_the_ID()) . '"' . (!empty($doctors) && in_array(get_the_ID(), (array)$doctors) ? ' selected="selected"' : '') . '>' . get_the_title() . '</option>';
					endwhile;
			echo '
				</select>
			</td>
		</tr>';
		}
		echo '
		<tr>
			<td>
				<label for="department_hour_category">' . __('Category', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<input type="text" id="department_hour_category" name="department_hour_category" value="" />
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: right;">
				<input id="add_department_hours" type="button" class="button" value="' . esc_attr__("Add", 'medicenter_departments') . '" />
			</td>
		</tr>
	</table>
	';
	//Reset Query
	wp_reset_query();
}

function medicenter_inner_departments_custom_box_main($post)
{
	//Use nonce for verification
	wp_nonce_field(plugin_basename( __FILE__ ), "medicenter_departments_noncename");
	
	//The actual fields for data entry
	$doctors = get_post_meta($post->ID, "medicenter_doctors", true);
	echo '
	<table>';
		if(wp_count_posts("doctors"))
		{
			echo '
		<tr>
			<td>
				<label for="doctors">' . __('Doctors', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<select id="doctors" name="doctors[]" multiple="multiple">';
					query_posts(array( 
						'post_type' => 'doctors',
						'posts_per_page' => '-1',
						'post_status' => 'publish',
						'orderby' => 'post_title', 
						'order' => 'DESC'
					));
					while(have_posts()): the_post();
						echo '<option value="' . esc_attr(get_the_ID()) . '"' . (in_array(get_the_ID(), (array)$doctors) ? ' selected="selected"' : '') . '>' . get_the_title() . '</option>';
					endwhile;
			echo '
				</select>
			</td>
		</tr>';
		}
		echo '
		<tr>
			<td>
				<label for="color">' . __('Timetable box background color', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<span class="color_preview" style="background-color: #' . (get_post_meta($post->ID, "medicenter_color", true)!="" ? esc_attr(get_post_meta($post->ID, "medicenter_color", true)) : 'transparent') . '"></span>
				<input class="regular-text color" type="text" id="color" name="color" value="' . esc_attr(get_post_meta($post->ID, "medicenter_color", true)) . '" data-default-color="transparent" />
				<span class="description">' . __('Required when \'Timetable box hover color\' isn\'t empty', 'medicenter_departments') . '</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="color">' . __('Timetable box hover background color', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<span class="color_preview" style="background-color: #' . (get_post_meta($post->ID, "medicenter_hover_color", true)!="" ? esc_attr(get_post_meta($post->ID, "medicenter_hover_color", true)) : 'transparent') . '"></span>
				<input class="regular-text color" type="text" id="hover_color" name="hover_color" value="' . esc_attr(get_post_meta($post->ID, "medicenter_hover_color", true)) . '" data-default-color="transparent" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="text_color">' . __('Timetable box text color', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<span class="color_preview" style="background-color: #' . (get_post_meta($post->ID, "medicenter_text_color", true)!="" ? esc_attr(get_post_meta($post->ID, "medicenter_text_color", true)) : 'transparent') . '"></span>
				<input class="regular-text color" type="text" id="text_color" name="text_color" value="' . esc_attr(get_post_meta($post->ID, "medicenter_text_color", true)) . '" data-default-color="transparent" />
				<span class="description">' . __('Required when \'Timetable box hover text color\' isn\'t empty', 'medicenter_departments') . '</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="text_color">' . __('Timetable box hover text color', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<span class="color_preview" style="background-color: #' . (get_post_meta($post->ID, "medicenter_hover_text_color", true)!="" ? esc_attr(get_post_meta($post->ID, "medicenter_hover_text_color", true)) : 'transparent') . '"></span>
				<input class="regular-text color" type="text" id="hover_text_color" name="hover_text_color" value="' . esc_attr(get_post_meta($post->ID, "medicenter_hover_text_color", true)) . '" data-default-color="transparent" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="text_color">' . __('Timetable box hours text color', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<span class="color_preview" style="background-color: #' . (get_post_meta($post->ID, "medicenter_hours_text_color", true)!="" ? esc_attr(get_post_meta($post->ID, "medicenter_hours_text_color", true)) : 'transparent') . '"></span>
				<input class="regular-text color" type="text" id="hours_text_color" name="hours_text_color" value="' . esc_attr(get_post_meta($post->ID, "medicenter_hours_text_color", true)) . '" data-default-color="transparent" />
				<span class="description">' . __('Required when \'Timetable box hover hours text color\' isn\'t empty', 'medicenter_departments') . '</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="text_color">' . __('Timetable box hover hours text color', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<span class="color_preview" style="background-color: #' . (get_post_meta($post->ID, "medicenter_hours_hover_text_color", true)!="" ? esc_attr(get_post_meta($post->ID, "medicenter_hours_hover_text_color", true)) : 'transparent') . '"></span>
				<input class="regular-text color" type="text" id="hours_hover_text_color" name="hours_hover_text_color" value="' . esc_attr(get_post_meta($post->ID, "medicenter_hours_hover_text_color", true)) . '" data-default-color="transparent" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="color">' . __('Timetable custom URL', 'medicenter_departments') . ':</label>
			</td>
			<td>
				<input class="regular-text" type="text" id="timetable_custom_url" name="timetable_custom_url" value="' . esc_attr(get_post_meta($post->ID, "medicenter_timetable_custom_url", true)) . '" />
			</td>
		</tr>
	</table>';
}

//When the post is saved, saves our custom data
function medicenter_save_departments_postdata($post_id) 
{
	global $wpdb;
	//verify if this is an auto save routine. 
	//if it is our form has not been submitted, so we dont want to do anything
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		return;

	//verify this came from the our screen and with proper authorization,
	//because save_post can be triggered at other times
	if (!isset($_POST['medicenter_departments_noncename']) || !wp_verify_nonce($_POST['medicenter_departments_noncename'], plugin_basename( __FILE__ )))
		return;


	//Check permissions
	if(!current_user_can('edit_post', $post_id))
		return;

	//OK, we're authenticated: we need to find and save the data
	$hours_count = (!empty($_POST["weekday_ids"]) ? count($_POST["weekday_ids"]) : 0);
	for($i=0; $i<$hours_count; $i++)
	{
		$query = "INSERT INTO `" . $wpdb->prefix . "department_hours` VALUES(
			NULL,
			'" . $post_id . "',
			'" . $_POST["weekday_ids"][$i] . "',
			'" . $_POST["start_hours"][$i] . "',
			'" . $_POST["end_hours"][$i] . "',
			'" . $_POST["tooltips"][$i] . "',
			'" . $_POST["before_hour_texts"][$i] . "',
			'" . $_POST["after_hour_texts"][$i] . "',
			'" . $_POST["department_hours_doctors"][$i] . "',
			'" . $_POST["department_hours_category"][$i] . "'
		);";
		$wpdb->query($query);
	}
	//removing data if needed
	$delete_department_hours_ids_count = (!empty($_POST["delete_department_hours_ids"]) ? count($_POST["delete_department_hours_ids"]) : 0);
	if($delete_department_hours_ids_count)
		$wpdb->query("DELETE FROM `" . $wpdb->prefix . "department_hours` WHERE department_hours_id IN(" . implode(",", esc_sql($_POST["delete_department_hours_ids"])) . ");");
	//post meta
	if(!empty($_POST["doctors"]))
		update_post_meta($post_id, "medicenter_doctors", $_POST["doctors"]);
	update_post_meta($post_id, "medicenter_color", $_POST["color"]);
	update_post_meta($post_id, "medicenter_hover_color", $_POST["hover_color"]);
	update_post_meta($post_id, "medicenter_text_color", $_POST["text_color"]);
	update_post_meta($post_id, "medicenter_hover_text_color", $_POST["hover_text_color"]);
	update_post_meta($post_id, "medicenter_hours_text_color", $_POST["hours_text_color"]);
	update_post_meta($post_id, "medicenter_hours_hover_text_color", $_POST["hours_hover_text_color"]);	
	update_post_meta($post_id, "medicenter_timetable_custom_url", $_POST["timetable_custom_url"]);
}
add_action("save_post", "medicenter_save_departments_postdata");

//custom departments items list
function medicenter_departments_edit_columns($columns)
{
	$new_columns = array(  
		"cb" => "<input type=\"checkbox\" />",  
		"title" => _x('Title', 'post type singular name', 'medicenter_departments'),
		"departments_category" => __('Categories', 'medicenter_departments'),
		"date" => __('Date', 'medicenter_departments')
	);    

	return array_merge($new_columns, $columns);  
}  
add_filter("manage_edit-departments_columns", "medicenter_departments_edit_columns"); 

function manage_medicenter_departments_posts_custom_column($column)
{
	global $post;
	switch ($column)  
	{
		case "departments_category":
			$departments_category_list = (array)get_the_terms($post->ID, "departments_category");
			foreach($departments_category_list as $departments_category)
			{
				if(empty($departments_category->slug))
					continue;
				echo '<a href="' . esc_url(admin_url("edit.php?post_type=departments&departments_category=" . $departments_category->slug)) . '">' . $departments_category->name . '</a>' . (end($departments_category_list)!=$departments_category ? ", " : "");;
			}
			break;
	}  
}
add_action("manage_departments_posts_custom_column", "manage_medicenter_departments_posts_custom_column");

//departments sidebar
function medicenter_departments_sidebar($atts, $content)
{
	extract(shortcode_atts(array(
		"order" => "ASC",
		"departments_url" => get_home_url() . "/departments",
		"timetable_url" => get_home_url() . "/timetable",
		"category" => ""
	), $atts));
	
	query_posts(array(
		'post_type' => 'departments',
		'posts_per_page' => '-1',
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => $order,
		'departments_category' => $category
	));
	
	$output = '';
	if(have_posts()):
		$output .= '<ul class="accordion">';
		while(have_posts()): the_post();
			global $post;
			$output .= '<li>
				<div id="accordion-' . urldecode($post->post_name) . '">
					<h3>' . get_the_title() . '</h3>
				</div>
				<div class="clearfix">
					<div class="item_content clearfix">';
						if(has_post_thumbnail())
							$output .= '<a class="thumb_image" href="' . esc_url($departments_url) . '/#' . urldecode($post->post_name) . '" title="' . get_the_title() . '">
								' . get_the_post_thumbnail(get_the_ID(), "medicenter-small-thumb", array("alt" => get_the_title(), "title" => "")) . '
							</a>';
			$output .= '<div class="text">
							' . get_the_excerpt() . '
						</div>
					</div>
					<div class="item_footer clearfix">
						<a class="more icon_small_arrow margin_right_white" href="' . esc_url($departments_url) . '/#' . urldecode($post->post_name) . '" title="' . esc_attr__("Details", 'medicenter_departments') . '">' . __("Details", 'medicenter_departments') . '</a>
						<a class="more icon_small_arrow margin_right_white" href="' . esc_url($timetable_url) . '/#' . urldecode($post->post_name) . '" title="' . esc_attr__("Timetable", 'medicenter_departments') . '">' . __("Timetable", 'medicenter_departments') . '</a>
					</div>
				</div>
			</li>';
		endwhile;
		$output .= '</ul>';
	endif;
	
	return $output;
}
add_shortcode("departments_sidebar", "medicenter_departments_sidebar");

function medicenter_weekdays_init()
{
	$labels = array(
		'name' => _x('Weekdays', 'post type general name', 'medicenter_departments'),
		'singular_name' => _x('Day', 'post type singular name', 'medicenter_departments'),
		'add_new' => _x('Add New', 'medicenter_weekdays', 'medicenter_departments'),
		'add_new_item' => __('Add New Day', 'medicenter_departments'),
		'edit_item' => __('Edit Day', 'medicenter_departments'),
		'new_item' => __('New Day', 'medicenter_departments'),
		'all_items' => __('All Weekdays', 'medicenter_departments'),
		'view_item' => __('View Day', 'medicenter_departments'),
		'search_items' => __('Search Weekdays', 'medicenter_departments'),
		'not_found' =>  __('No weekdays found', 'medicenter_departments'),
		'not_found_in_trash' => __('No weekdays found in Trash', 'medicenter_departments'), 
		'parent_item_colon' => '',
		'menu_name' => __("Weekdays", 'medicenter_departments')
	);
	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",  
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => true,  
		"supports" => array("title", "page-attributes")
	);
	register_post_type("medicenter_weekdays", $args);
}  
add_action("init", "medicenter_weekdays_init"); 

//custom weekdays items list
function medicenter_weekdays_edit_columns($columns)
{
	$columns = array(  
		"cb" => "<input type=\"checkbox\" />",  
		"title" => _x('Day name', 'post type singular name', 'medicenter_departments'),   
		"date" => __('Date', 'medicenter_departments')
	);    

	return $columns;  
}  
add_filter("manage_edit-medicenter_weekdays_columns", "medicenter_weekdays_edit_columns");
?>