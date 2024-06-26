<?php
/*
Plugin Name: Theme Dummy Content Importer
Plugin URI: https://1.envato.market/quanticalabs-portfolio
Description: Import posts, pages, comments, custom fields, categories, tags and more from a WordPress export file.
Author: QuanticaLabs
Author URI: https://1.envato.market/quanticalabs-portfolio
Version: 2.0
Text Domain: ql_importer
*/

//translation
function ql_importer_load_textdomain()
{
	load_plugin_textdomain("ql_importer", false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'ql_importer_load_textdomain');
//admin
if(is_admin())
{
	function ql_importer_get_page_by_title($title, $post_type = "page")
	{
		$posts = get_posts(array(
			'post_type' => $post_type,
			'title' => $title,
			'post_status' => 'all',
			'numberposts' => 1
		));
		if(!empty($posts))
		{
			return $posts[0];
		}
		else 
		{
			return null;
		}
	}
	function ql_importer_get_new_widget_name( $widget_name, $widget_index ) 
	{
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array( );
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;
		return $new_widget_name;
	}
	function ql_importer_download_import_file($file, $themename)
	{	
		if($themename=="cleanmate")
			$url = "https://quanticalabs.com/wptest/cleanmate/files/2017/11/" . $file["name"] . "." . $file["extension"];
		else if($themename=="pressroom")
			$url = "https://quanticalabs.com/wptest/pressroom/files/2015/01/" . $file["name"] . "." . $file["extension"];
		else if($themename=="medicenter")
			$url = "https://quanticalabs.com/wptest/medicenter-new/files/2017/02/" . $file["name"] . "." . $file["extension"];
		else if($themename=="renovate")
			$url = "https://quanticalabs.com/wptest/renovate/files/2015/06/" . $file["name"] . "." . $file["extension"];
		else if($themename=="carservice")
			$url = "https://quanticalabs.com/wptest/carservice/files/2015/05/" . $file["name"] . "." . $file["extension"];
		else if($themename=="gymbase")
			$url = "https://quanticalabs.com/wptest/gymbase/files/2014/07/gymbase-" . $file["name"] . "." . $file["extension"];
		else if($themename=="finpeak")
			$url = "https://quanticalabs.com/wptest/finpeak/files/2023/01/finpeak-" . $file["name"] . "." . $file["extension"];
		$attachment = ql_importer_get_page_by_title($file["name"], "attachment");
		if($attachment!=null)
			$id = $attachment->ID;
		else
		{
			$tmp = download_url($url);
			$file_array = array(
				'name' => basename($url),
				'tmp_name' => $tmp
			);

			// Check for download errors
			if(is_wp_error($tmp))
			{
				return $tmp;
			}

			$id = media_handle_sideload($file_array, 0);
			// Check for handle sideload errors.
			if(is_wp_error($id))
			{
				@unlink($file_array['tmp_name']);
				return $id;
			}
		}
		return get_attached_file($id);
	}
	function ql_importer_import_shop_dummy()
	{
		ob_start();
		$result = array("info" => "");
		//import dummy content
		$fetch_attachments = true;
		$file = ql_importer_download_import_file(array(
			"name" => "dummy-shop.xml",
			"extension" => "gz"
		), $_POST["themename"]);
		
		if(is_wp_error($file))
		{
			$file = get_template_directory() . "/dummy_content_files/" . ($themename=="gymbase" ? "gymbase-" : ""). ($themename=="finpeak" ? "finpeak-" : "") . "dummy-shop.xml.gz";
		}
		if(is_file($file))
			require_once('importer.php');
		else
			$result["info"] = __("Import file dummy-shop.xml.gz not found! Please upload import file manually into Media library. You can find this file in 'dummy content files' directory inside zip archive downloaded from ThemeForest.", 'ql_importer');
		if($result["info"]=="")
			$result["info"] = __("dummy-shop.xml file content has been imported successfully!", 'ql_importer');
		$system_message = ob_get_clean();
		$result["system_message"] = $system_message;
		echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
		exit();
	}
	add_action('wp_ajax_ql_importer_import_shop_dummy', 'ql_importer_import_shop_dummy');
	function ql_importer_import_dummy()
	{
		ob_start();
		$themename = $_POST["themename"];
		$result = array("info" => "");
		$import_templates_sidebars = $_POST["import_templates_sidebars"];
		if($import_templates_sidebars)
		{
			echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
			exit();
		}
		//import dummy content
		$fetch_attachments = true;
		$file = ql_importer_download_import_file(array(
			"name" => "dummy-images.xml",
			"extension" => "gz"
		), $_POST["themename"]);
		if(is_wp_error($file))
		{
			$file = get_template_directory() . "/dummy_content_files/" . ($themename=="gymbase" ? "gymbase-" : "") . ($themename=="finpeak" ? "finpeak-" : "") . "dummy-images.xml.gz";
		}
		if(is_file($file))
			require_once('importer.php');
		else
			$result["info"] = __("Import file dummy-images.xml.gz not found! Please upload import file manually into Media library. You can find this file in 'dummy content files' directory inside zip archive downloaded from ThemeForest.", 'ql_importer');
		if($result["info"]=="")
			$result["info"] = __("dummy-images.xml file content has been imported successfully!", 'ql_importer');
		$system_message = ob_get_clean();
		$result["system_message"] = $system_message;
		echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
		exit();
	}
	add_action('wp_ajax_ql_importer_import_dummy', 'ql_importer_import_dummy');

	function ql_importer_import_dummy2()
	{
		ob_start();
		global $wp_filesystem;
		$creds = request_filesystem_credentials(admin_url('themes.php?page=ThemeOptions'), '', false, false, array());
		if(!WP_Filesystem($creds))
		{
			$result["info"] .= __("Filesystem initialization error.", 'ql_importer');
			if(is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->has_errors())
			{
				$error_codes = $wp_filesystem->errors->get_error_codes();
				foreach((array)$error_codes as $error_code)
				{
					if($error_code=="empty_hostname")
					{
						$result["info"] .= __("<br>FTP server details required. Please put below code in your <em>wp-config.php</em> file (replace example details with your FTP server login details):<pre>define('FTP_USER', 'example');<br>define('FTP_PASS', '*******');<br>define('FTP_HOST', 'example.com:21');<br>define('FTP_SSL', false);</pre>", 'ql_importer');
					}
					$result["info"] .= "<br>" . $wp_filesystem->errors->get_error_message($error_code) . " [" . $error_code . "]";
				}
			}
			echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
			exit();
		}
		$themename = $_POST["themename"];
		$demo = (isset($_POST["demo"]) ? $_POST["demo"] : "");
		$theme_prefix = $themename;
		if($themename=="cleanmate")
			$theme_prefix = "cm";
		$result = array("info" => "");
		//import dummy content
		$import_templates_sidebars = (isset($_POST["import_templates_sidebars"]) ? (int)$_POST["import_templates_sidebars"] : 0);
		$fetch_attachments = false;
		if($themename=="medicenter" && isset($demo) && $demo!="main")
		{
			$fetch_attachments = true;
		}
		$file = ql_importer_download_import_file(array(
			"name" => "dummy-data" . ($import_templates_sidebars ? '-templates-sidebars' : '') . ($themename=="medicenter" && isset($demo) && $demo!="main" ? "-" . $demo : "") . ".xml",
			"extension" => "gz"
		), $themename);
		if(is_wp_error($file))
		{
			$file = get_template_directory() . "/dummy_content_files/" . ($themename=="gymbase" ? "gymbase-" : "") . ($themename=="finpeak" ? "finpeak-" : "") . "dummy-data" . ($import_templates_sidebars ? '-templates-sidebars' : '') . ($themename=="medicenter" && isset($demo) && $demo!="main" ? "-" . $demo : "") . ".xml.gz";
		}
		if(is_file($file))
			require_once('importer.php');
		else
		{
			$result["info"] .= sprintf(__("Import file: dummy-data%s.xml.gz not found! Please upload import file manually into Media library. You can find this file in 'dummy content files' directory inside zip archive downloaded from ThemeForest.", 'ql_importer'), ($import_templates_sidebars ? '-templates-sidebars' : '') . ($themename=="medicenter" && isset($demo) && $demo!="main" ? "-" . $demo : ""));
			echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
			exit();
		}
		$fetch_attachments = false;
		if($import_templates_sidebars)
		{
			$result["info"] .= __("Template pages and sidebars has been imported successfully!", 'ql_importer');
			echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
			exit();
		}
		if($themename!="medicenter" || ($themename=="medicenter" && $demo!="pregnancy_home" && $demo!="ophthalmologist_home" && $demo!="veterinary_home" && $demo!="dentist_home"))
		{
			//set menu
			$locations = get_theme_mod('nav_menu_locations');
			$menus = wp_get_nav_menus();
			foreach($menus as $menu)
				$locations[$menu->slug] = $menu->term_id;
			
			set_theme_mod('nav_menu_locations', $locations);
			//set front page
			if($themename=="medicenter" && isset($demo) && $demo!="main")
			{
				if($demo=="pregnancy")
				{
					$home = ql_importer_get_page_by_title('Home Pregnancy');
				}
				else if($demo=="ophthalmologist")
				{
					$home = ql_importer_get_page_by_title('Home Ophthalmologist');
				}
				else if($demo=="veterinary")
				{
					$home = ql_importer_get_page_by_title('Home Veterinary');
				}
				else if($demo=="dentist")
				{
					$home = ql_importer_get_page_by_title('Home Dentist');
				}
			}
			else
			{
				$home = ql_importer_get_page_by_title('HOME');
			}
			update_option('page_on_front', $home->ID);
			update_option('show_on_front', 'page');
			//set blog description
			if($themename=="cleanmate")
				update_option("blogdescription", "Cleaning Theme ");
			else if($themename=="pressroom")
				update_option("blogdescription", "News and Magazine Theme");
			else if($themename=="medicenter")
				update_option("blogdescription", "Health Medical Theme");
			else if($themename=="renovate")
				update_option("blogdescription", "Construction Theme");
			else if($themename=="carservice")
				update_option("blogdescription", "Mechanic Auto Mechanic Car Repair Theme");
			else if($themename=="gymbase")
				update_option("blogdescription", "Gym Fitness Theme");
			else if($themename=="finpeak")
				update_option("blogdescription", "Business Finance Consulting Theme");
			//set top and menu sidebars
			$theme_sidebars_array = get_posts(array(
				'post_type' => $theme_prefix . '_sidebars',
				'posts_per_page' => '-1',
				'nopaging' => true,
				'post_status' => 'publish',
				'orderby' => 'menu_order',
				'order' => 'ASC'
			));
			$theme_options = get_option($theme_prefix . "_options", true);
			$needed_id = 0;
			foreach($theme_sidebars_array as $theme_sidebar)
			{	
				if(($themename=="medicenter" && $theme_sidebar->post_title=="Sidebar Header Top") || (($themename=="cleanmate" || $themename=="pressroom" || $themename=="renovate" || $themename=="carservice" || $themename=="finpeak") && $theme_sidebar->post_title=="Sidebar Header"))
				{
					$needed_id = $theme_sidebar->ID;
					break;
				}
			}
			$theme_options["header_top_sidebar"] = $needed_id;
			if($themename=="cleanmate" || $themename=="finpeak")
			{
				$needed_id = 0;
				foreach($theme_sidebars_array as $theme_sidebar)
				{	
					if($theme_sidebar->post_title=="Sidebar Menu")
					{
						$needed_id = $theme_sidebar->ID;
						break;
					}
				}
				$theme_options["header_menu_sidebar"] = $needed_id;
			}
			else if($themename=="pressroom")
			{
				$needed_id = 0;
				foreach($theme_sidebars_array as $theme_sidebar)
				{	
					if($theme_sidebar->post_title=="Sidebar Header Right")
					{
						$needed_id = $theme_sidebar->ID;
						break;
					}
				}
				$theme_options["header_top_right_sidebar"] = $needed_id;
			}
			if($themename=="medicenter" && isset($demo) && ($demo=="pregnancy" || $demo=="ophthalmologist" || $demo=="veterinary" || $demo=="dentist"))
			{
				if($demo=="pregnancy")
				{
					$theme_options["logo_url"] = get_template_directory_uri() . "/images/logo_pregnancy.png";
					$theme_options["favicon_url"] = get_template_directory_uri() . "/images/favicon_pregnancy.ico";
					$theme_options["primary_color"] = "F4898C";
					$theme_options["secondary_color"] = "606BA2";
					$theme_options["tertiary_color"] = "4B558B";
				}
				else if($demo=="ophthalmologist")
				{
					$theme_options["logo_url"] = get_template_directory_uri() . "/images/logo_ophthalmologist.png";
					$theme_options["favicon_url"] = get_template_directory_uri() . "/images/favicon_ophthalmologist.ico";
					$theme_options["primary_color"] = "F4B73C";
					$theme_options["secondary_color"] = "444F61";
					$theme_options["tertiary_color"] = "59667B";
					$theme_options["blockquote_font"] = "Libre Baskerville:regular";
				}
				else if($demo=="veterinary")
				{
					$theme_options["logo_url"] = get_template_directory_uri() . "/images/logo_veterinary.png";
					$theme_options["favicon_url"] = get_template_directory_uri() . "/images/favicon_veterinary.ico";
					$theme_options["primary_color"] = "26A69A";
					$theme_options["secondary_color"] = "344C70";
					$theme_options["tertiary_color"] = "1D8595";
					$theme_options["blockquote_font"] = "Libre Baskerville:regular";
				}
				else if($demo=="dentist")
				{
					$theme_options["logo_url"] = get_template_directory_uri() . "/images/logo_dentist.png";
					$theme_options["favicon_url"] = get_template_directory_uri() . "/images/favicon_dentist.ico";
					$theme_options["primary_color"] = "C371A3";
					$theme_options["secondary_color"] = "8C9DAD";
					$theme_options["tertiary_color"] = "667889";
					$theme_options["blockquote_font"] = "Libre Baskerville:regular";
				}
			}
			update_option($theme_prefix . "_options", $theme_options);
		}
		if(class_exists("RevSlider") && ($themename=="cleanmate" || $themename=="medicenter" || $themename=="renovate" || $themename=="carservice" || $themename=="gymbase" || $themename=="finpeak"))
		{
			$demo_slider = $demo;
			if($themename=="medicenter" && isset($demo) && ($demo=="pregnancy_home" || $demo=="ophthalmologist_home" || $demo=="veterinary_home" || $demo=="dentist_home"))
			{
				if($demo=="pregnancy_home")
				{
					$demo_slider = "pregnancy";
				}
				else if($demo=="ophthalmologist_home")
				{
					$demo_slider = "ophthalmologist";
				}
				else if($demo=="veterinary_home")
				{
					$demo_slider = "veterinary";
				}
				else if($demo=="dentist_home")
				{
					$demo_slider = "dentist";
				}
			}
			//slider import
			$Slider=new RevSlider();
			$slider_file = ql_importer_download_import_file(array(
				"name" => ($themename=="renovate" || $themename=="carservice" ? "main" : "home" . ($themename=="finpeak" ? "-1" : "") . ($themename=="medicenter" && isset($demo_slider) && $demo_slider!="main" ? "-" . $demo_slider : "")),
				"extension" => "zip"
			), $themename);
			if(is_wp_error($slider_file))
			{
				$slider_file = get_template_directory() . "/dummy_content_files/" . ($themename=="renovate" || $themename=="carservice" ? "main" : ($themename=="gymbase" ? "gymbase-" : "") . ($themename=="finpeak" ? "finpeak-" : "") . "home" . ($themename=="finpeak" ? "-1" : "") . ($themename=="medicenter" && isset($demo_slider) && $demo_slider!="main" ? "-" . $demo_slider : "")) . ".zip";
			}
			if(is_file($slider_file))
			{
				$Slider->importSliderFromPost(true, true, $slider_file);
			}
			if($themename=="cleanmate")
			{
				$slider_file_2 = ql_importer_download_import_file(array(
					"name" => "home-2",
					"extension" => "zip"
				), $themename);
				if(is_wp_error($slider_file_2))
				{
					$slider_file_2 = get_template_directory() . "/dummy_content_files/home-2.zip";
				}
				if(is_file($slider_file_2))
				{
					$Slider->importSliderFromPost(true, true, $slider_file_2);
				}
				//update default global grid size
				$revslider_global_settings = get_option('revslider-global-settings');
				$revslider_grid = array(
					'size' => array(
						'desktop' => 1920,
						'notebook' => 1190,
						'tablet' => 768,
						'mobile' => 480
					)
				);
				update_option('revslider-global-settings', json_encode(array_merge((array)json_decode($revslider_global_settings, true), $revslider_grid)));
			}
			else if($themename=="carservice" || $themename=="renovate")
			{
				//update default global grid size
				$revslider_global_settings = get_option('revslider-global-settings');
				$revslider_grid = array(
					'size' => array(
						'desktop' => 1920,
						'notebook' => 1190,
						'tablet' => 768,
						'mobile' => 480
					)
				);
				update_option('revslider-global-settings', json_encode(array_merge((array)json_decode($revslider_global_settings, true), $revslider_grid)));
			}
			else if($themename=="gymbase")
			{
				//update default global grid size
				$revslider_global_settings = get_option('revslider-global-settings');
				$revslider_grid = array(
					'size' => array(
						'desktop' => 1920,
						'notebook' => 1250,
						'tablet' => 768,
						'mobile' => 480
					)
				);
				update_option('revslider-global-settings', json_encode(array_merge((array)json_decode($revslider_global_settings, true), $revslider_grid)));
			}
			else if($themename=="medicenter")
			{
				if(!isset($demo) || (isset($demo) && ($demo=="pregnancy" || $demo=="ophthalmologist" || $demo=="veterinary" || $demo=="dentist")))
				{
					$slider_file_2 = ql_importer_download_import_file(array(
						"name" => "home",
						"extension" => "zip"
					), $themename);
					if(is_wp_error($slider_file_2))
					{
						$slider_file_2 = get_template_directory() . "/dummy_content_files/home.zip";
					}
					if(is_file($slider_file_2))
					{
						$Slider->importSliderFromPost(true, true, $slider_file_2);
					}
				}
				if(isset($demo) && $demo!="pregnancy_home" && $demo!="ophthalmologist_home" && $demo!="veterinary_home" && $demo!="dentist_home")
				{
					//update default global grid size
					$revslider_global_settings = get_option('revslider-global-settings');
					$revslider_grid = array(
						'size' => array(
							'desktop' => 1920,
							'notebook' => 1250,
							'tablet' => 1010,
							'mobile' => 768
						)
					);
					update_option('revslider-global-settings', json_encode(array_merge((array)json_decode($revslider_global_settings, true), $revslider_grid)));
				}
			}
			else if($themename=="finpeak")
			{
				$slider_file_2 = ql_importer_download_import_file(array(
					"name" => "home-2",
					"extension" => "zip"
				), $themename);
				if(is_wp_error($slider_file_2))
				{
					$slider_file_2 = get_template_directory() . "/dummy_content_files/home-2.zip";
				}
				if(is_file($slider_file_2))
				{
					$Slider->importSliderFromPost(true, true, $slider_file_2);
				}
				$slider_file_3 = ql_importer_download_import_file(array(
					"name" => "home-transparent-header",
					"extension" => "zip"
				), $themename);
				if(is_wp_error($slider_file_3))
				{
					$slider_file_3 = get_template_directory() . "/dummy_content_files/home-transparent-header.zip";
				}
				if(is_file($slider_file_3))
				{
					$Slider->importSliderFromPost(true, true, $slider_file_3);
				}
				//update default global grid size
				$revslider_global_settings = get_option('revslider-global-settings');
				$revslider_grid = array(
					'size' => array(
						'desktop' => 1920,
						'notebook' => 1290,
						'tablet' => 1010,
						'mobile' => 768
					)
				);
				update_option('revslider-global-settings', json_encode(array_merge((array)json_decode($revslider_global_settings, true), $revslider_grid)));
			}
		}
		
		if($themename!="medicenter" || ($themename=="medicenter" && $demo!="pregnancy_home" && $demo!="ophthalmologist_home" && $demo!="veterinary_home" && $demo!="dentist_home"))
		{
			//widget import
			$response = array(
				'what' => 'widget_import_export',
				'action' => 'import_submit'
			);

			$widgets = isset( $_POST['widgets'] ) ? $_POST['widgets'] : false;
			$json_file = ql_importer_download_import_file(array(
				"name" => "widget_data",
				"extension" => "json"
			), $themename);
			if(is_wp_error($json_file))
			{
				$json_file = get_template_directory() . "/dummy_content_files/" . ($themename=="gymbase" ? "gymbase-" : "") . ($themename=="finpeak" ? "finpeak-" : "") . "widget_data.json";
			}
			$json_data = $wp_filesystem->get_contents($json_file);
			if($json_data!=false)
			{
				$json_data = json_decode( $json_data, true );
				$sidebars_data = $json_data[0];
				$widget_data = $json_data[1];
				$current_sidebars = get_option( 'sidebars_widgets' );
				//remove inactive widgets
				$current_sidebars['wp_inactive_widgets'] = array();
				update_option('sidebars_widgets', $current_sidebars);
				$new_widgets = array( );
				foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

					foreach ( $import_widgets as $import_widget ) :
						//if the sidebar exists
						//if ( isset( $current_sidebars[$import_sidebar] ) ) :
							$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
							$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
							$current_widget_data = get_option( 'widget_' . $title );
							$new_widget_name = ql_importer_get_new_widget_name( $title, $index );
							$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

							if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
								while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
									$new_index++;
								}
							}
							$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
							if ( array_key_exists( $title, $new_widgets ) ) {
								$new_widgets[$title][$new_index] = $widget_data[$title][$index];
								$multiwidget = $new_widgets[$title]['_multiwidget'];
								unset( $new_widgets[$title]['_multiwidget'] );
								$new_widgets[$title]['_multiwidget'] = $multiwidget;
							} else {
								$current_widget_data[$new_index] = $widget_data[$title][$index];
								$current_multiwidget = isset($current_widget_data['_multiwidget']) ? $current_widget_data['_multiwidget'] : "";
								$new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : "";
								$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
								unset( $current_widget_data['_multiwidget'] );
								$current_widget_data['_multiwidget'] = $multiwidget;
								$new_widgets[$title] = $current_widget_data;
							}

						//endif;
					endforeach;
				endforeach;
				if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
					update_option( 'sidebars_widgets', $current_sidebars );

					foreach ( $new_widgets as $title => $content ) {
						$content["_multiwidget"] = 1;
						$content = apply_filters( 'widget_data_import', $content, $title );
						update_option( 'widget_' . $title, $content );
					}

				}
			}
			else
			{
				$result["info"] .= __("Widgets data file not found! Please upload widgets data file manually.", 'ql_importer');
				echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
				exit();
			}
		}
		if($result["info"]=="")
		{
			if($themename!="medicenter" || ($themename=="medicenter" && $demo!="pregnancy_home" && $demo!="ophthalmologist_home" && $demo!="veterinary_home" && $demo!="dentist_home"))
			{
				if($themename!="finpeak")
				{
					//set shop page
					$shop = ql_importer_get_page_by_title('Shop');
					update_option('woocommerce_shop_page_id', $shop->ID);
					//set my-account page
					$myaccount = ql_importer_get_page_by_title('My Account');
					update_option('woocommerce_myaccount_page_id', $myaccount->ID);
					//set cart page
					$cart = ql_importer_get_page_by_title('Cart');
					update_option('woocommerce_cart_page_id', $cart->ID);
					//set checkout page
					$checkout = ql_importer_get_page_by_title('Checkout');
					update_option('woocommerce_checkout_page_id', $checkout->ID);
			
					$hide_notice = sanitize_text_field("install");
						$notices = array_diff(get_option('woocommerce_admin_notices', array()), array("install"));
					update_option('woocommerce_admin_notices', $notices);
					do_action('woocommerce_hide_install_notice');
				}
				$result["info"] = sprintf(__("dummy-data%s.xml file content and widgets settings has been imported successfully!", 'ql_importer'), ($import_templates_sidebars ? '-templates-sidebars' : '') . ($themename=="medicenter" && isset($demo) && $demo!="main" ? "-" . $demo : ""));
				
			}
			else
			{
				$hide_notice = sanitize_text_field("install");
				$result["info"] = sprintf(__("dummy-data%s.xml file content has been imported successfully!", 'ql_importer'), ($import_templates_sidebars ? '-templates-sidebars' : '') . ($themename=="medicenter" && isset($demo) && $demo!="main" ? "-" . $demo : ""));
			}
			$system_message = ob_get_clean();
			$result["system_message"] = $system_message;
		}
		echo "dummy_import_start" . json_encode($result) . "dummy_import_end";
		exit();
	}
	add_action('wp_ajax_ql_importer_import_dummy2', 'ql_importer_import_dummy2');
	//add new mimes for upload dummy content files
	function ql_importer_custom_upload_files($mimes) 
	{
		$mimes = array_merge($mimes, array('xml' => 'application/xml'), array('json' => 'application/json'), array('zip' => 'application/zip'), array('gz' => 'application/x-gzip'), array('ico' => 'image/x-icon'));
		return $mimes;
	}
	add_filter('upload_mimes', 'ql_importer_custom_upload_files');
}