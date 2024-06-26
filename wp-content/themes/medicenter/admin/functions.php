<?php
function mc_theme_admin_init()
{
	wp_register_script("theme-colorpicker", get_template_directory_uri() . "/admin/js/colorpicker.js", array("jquery"));
	wp_register_script("theme-admin", get_template_directory_uri() . "/admin/js/theme_admin.js", array("jquery", "theme-colorpicker"));
	wp_register_script("jquery-bqq", get_template_directory_uri() . "/admin/js/jquery.ba-bbq.min.js", array("jquery"));
	wp_register_script("theme-admin-widgets", get_template_directory_uri() . "/admin/js/theme_admin_widgets.js", array("jquery"));
	wp_register_style("theme-colorpicker", get_template_directory_uri() . "/admin/style/colorpicker.css");
	wp_register_style("theme-admin-style", get_template_directory_uri() . "/admin/style/style.css");
	wp_register_style("theme-admin-style-rtl", get_template_directory_uri() . "/admin/style/rtl.css");
}
add_action("admin_init", "mc_theme_admin_init");

function mc_theme_admin_print_scripts()
{
	wp_enqueue_script('jquery-bqq');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('theme-admin');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_style("google-font-open-sans", "//fonts.googleapis.com/css?family=Open+Sans:400,600");
	wp_enqueue_style("google-font-source-sans-pro", "//fonts.googleapis.com/css?family=Source+Sans+Pro:400&amp;subset=latin,latin-ext");
	wp_enqueue_style("google-font-pt-serif", "//fonts.googleapis.com/css?family=PT+Serif:400italic&amp;subset=latin,latin-ext");
	wp_enqueue_style("mc-social", get_template_directory_uri() ."/fonts/social/style.css");
	wp_enqueue_style("mc-features", get_template_directory_uri() ."/fonts/features/style.css");
	
	$sidebars = array(
		"default" => array(
			array(
				"name" => "header",
				"label" => __("header", 'medicenter')
			),
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'medicenter')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'medicenter')
			)
		),
		"template-blog.php" => array(
			array(
				"name" => "header",
				"label" => __("header", 'medicenter')
			),
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'medicenter')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'medicenter')
			)
		),
		"single.php" => array(
			array(
				"name" => "header",
				"label" => __("header", 'medicenter')
			),
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'medicenter')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'medicenter')
			)
		),
		"single-features.php" => array(
			array(
				"name" => "header",
				"label" => __("header", 'medicenter')
			),
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'medicenter')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'medicenter')
			)
		),
		"single-doctors.php" => array(
			array(
				"name" => "header",
				"label" => __("header", 'medicenter')
			),
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'medicenter')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'medicenter')
			)
		),
		"single-ql_services.php" => array(
			array(
				"name" => "header",
				"label" => __("header", 'medicenter')
			),
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'medicenter')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'medicenter')
			)
		),
		"search.php" => array(
			array(
				"name" => "header",
				"label" => __("header", 'medicenter')
			),
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'medicenter')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'medicenter')
			)
		),
		"template-default-without-breadcrumbs.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'medicenter')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'medicenter')
			)
		),
		"template-home.php" => array(
			array(
				"name" => "top",
				"label" => __("top", 'medicenter')
			),
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'medicenter')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'medicenter')
			)
		),
		"404.php" => array(
			array(
				"name" => "header",
				"label" => __("header", 'medicenter')
			),
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'medicenter')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'medicenter')
			)
		),
		"template-empty.php" => array(),
		"template-empty-with-footer.php" => array(
			array(
				"name" => "footer_top",
				"label" => __("footer top", 'medicenter')
			),
			array(
				"name" => "footer_bottom",
				"label" => __("footer bottom", 'medicenter')
			)
		)
	);
	//get theme sidebars
	$theme_sidebars = array();
	$theme_sidebars_array = get_posts(array(
		'post_type' => 'medicenter_sidebars',
		'posts_per_page' => '-1',
		'nopaging' => true,
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'ASC'
	));
	$theme_sidebars[0]["id"] = -1;
	$theme_sidebars[0]["title"] = __("None", 'medicenter');
	for($i=1; $i<=count($theme_sidebars_array); $i++)
	{
		$theme_sidebars[$i]["id"] = $theme_sidebars_array[$i-1]->ID;
		$theme_sidebars[$i]["title"] = $theme_sidebars_array[$i-1]->post_title;
	}
	//get theme sliders
	$sliderAllShortcodeIds = array();
	$allOptions = wp_load_alloptions();
	foreach($allOptions as $key => $value)
	{
		if(substr($key, 0, 26)=="medicenter_slider_settings")
			$sliderAllShortcodeIds[] = $key;
	}
	//get revolution sliders
	if(is_plugin_active('revslider/revslider.php'))
	{
		global $wpdb;
		$rs = $wpdb->get_results( 
		"
		SELECT id, title, alias
		FROM ".$wpdb->prefix."revslider_sliders
		ORDER BY id ASC LIMIT 100
		"
		);
		if($rs) 
		{
			foreach($rs as $slider)
			{
				$sliderAllShortcodeIds[] = "revolution_slider_settings_" . $slider->alias;
			}
		}
	}
	//get layer sliders
	if(is_plugin_active('LayerSlider/layerslider.php'))
	{
		global $wpdb;
		$ls = $wpdb->get_results(
		"
		SELECT id, name, date_c
		FROM ".$wpdb->prefix."layerslider
		WHERE flag_hidden = '0' AND flag_deleted = '0'
		ORDER BY date_c ASC LIMIT 999
		"
		);
		$layer_sliders = array();
		if($ls)
		{
			foreach($ls as $slider)
			{
				$sliderAllShortcodeIds[] = "aaaaalayer_slider_settings_" . $slider->id;
			}
		}
	}
	//sort slider ids
	sort($sliderAllShortcodeIds);
	$data = array(
		'img_url' =>  get_template_directory_uri() . "/images/",
		'admin_img_url' =>  get_template_directory_uri() . "/admin/images/",
		'sidebar_label' => __('Sidebar', 'medicenter'),
		'slider_label' => __('Main Slider', 'medicenter'),
		'sidebars' => $sidebars,
		'theme_sidebars' => $theme_sidebars,
		'page_sidebars' => get_post_meta(get_the_ID(), "medicenter_page_sidebars", true),
		'theme_sliders' => $sliderAllShortcodeIds,
		'main_slider' => get_post_meta(get_the_ID(), "main_slider", true),
		'create_slider_text' => (is_plugin_active('revslider/revslider.php') ? sprintf(__("Create slider <a href='%s'>here</a>", 'medicenter'), esc_url(admin_url("admin.php?page=revslider"))) : sprintf(__("Activate Revolution Slider <a href='%s'>here</a>", 'medicenter'), esc_url(admin_url("themes.php?page=install-required-plugins&plugin_status=activate")))),
		'themename' => 'medicenter',
		'import_confirmation_message' => __('Please confirm the dummy data import.', 'medicenter'),
		'shop_import_confirmation_message' => __('Please confirm the shop dummy data import.', 'medicenter'),
		'import_in_progress_message' => __("Please wait and don't reload the page when import is in progress!", 'medicenter'),
		'import_error_message' => __('Error during import:', 'medicenter')
	);
	//pass data to javascript
	$params = array(
		'l10n_print_after' => 'config = ' . json_encode($data) . ';'
	);
	wp_localize_script("theme-admin", "config", $params);
}

function mc_theme_admin_print_scripts_colorpicker()
{	
	wp_enqueue_script('theme-admin');
	wp_enqueue_script('theme-colorpicker');
	wp_enqueue_style('theme-colorpicker');
}

function mc_theme_admin_print_scripts_widgets()
{	
	wp_enqueue_script('theme-admin-widgets');
}

function mc_theme_admin_print_scripts_all()
{
	global $theme_options;
	wp_enqueue_style('theme-admin-style');
		
	if((is_rtl() || (isset($theme_options['direction']) && $theme_options["direction"]=='rtl')) && ((isset($_COOKIE["mc_direction"]) && $_COOKIE["mc_direction"]!="LTR") || !isset($_COOKIE["mc_direction"])))
		wp_enqueue_style('theme-admin-style-rtl');
}

function mc_theme_admin_menu_theme_options() 
{
	add_action("admin_print_scripts", "mc_theme_admin_print_scripts_all");
	add_action("admin_print_scripts-post-new.php", "mc_theme_admin_print_scripts");
	add_action("admin_print_scripts-post.php", "mc_theme_admin_print_scripts");
	add_action("admin_print_scripts-appearance_page_ThemeOptions", "mc_theme_admin_print_scripts");
	add_action("admin_print_scripts-widgets.php", "mc_theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-appearance_page_ThemeOptions", "mc_theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-post-new.php", "mc_theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-post.php", "mc_theme_admin_print_scripts_colorpicker");
	add_action("admin_print_scripts-widgets.php", "mc_theme_admin_print_scripts_widgets");
}
add_action("admin_menu", "mc_theme_admin_menu_theme_options");

//visual composer
//if(function_exists("vc_add_shortcode_param"))
//{
	//dropdownmulti
	function mc_dropdownmultiple_settings_field($settings, $value)
	{	
		$value = ($value==null ? array() : $value);
		if(!is_array($value))
			$value = explode(",", $value);
		$output = '<select name="'.esc_attr($settings['param_name']).'" class="wpb_vc_param_value wpb-input wpb-select '.esc_attr($settings['param_name']).' '.esc_attr($settings['type']).'" multiple>';
				foreach ( $settings['value'] as $text_val => $val ) {
					if ( is_numeric($text_val) && is_string($val) || is_numeric($text_val) && is_numeric($val) ) {
						$text_val = $val;
					}
				   // $val = strtolower(str_replace(array(" "), array("_"), $val));
					$selected = '';
					if ( in_array($val,$value) ) $selected = ' selected="selected"';
					$output .= '<option class="'.esc_attr($val).'" value="'.esc_attr($val).'"'.esc_attr($selected).'>'.$text_val.'</option>';
				}
				$output .= '</select>';
		return $output;
	}
	//hidden
	function mc_hidden_settings_field($settings, $value) 
	{
	   return '<input name="'.esc_attr($settings['param_name'])
				 .'" class="wpb_vc_param_value wpb-textinput '
				 .esc_attr($settings['param_name']).' '.esc_attr($settings['type']).'_field" type="hidden" value="'
				 .esc_attr($value).'"/>';
	}
	//readonly
	function mc_readonly_settings_field($settings, $value) 
	{
	   return '<input name="'.esc_attr($settings['param_name'])
				 .'" class="wpb_vc_param_value wpb-textinput '
				 .esc_attr($settings['param_name']).' '.esc_attr($settings['type']).'_field" type="text" readonly="readonly" value="'
				 .esc_attr($value).'"/>';
	}
	//add item button
	function mc_listitem_settings_field($settings, $value)
	{
		$value = explode(",", $value);
		$output = '<input type="button" value="' . esc_attr__('Add list item', 'medicenter') . '" name="'.esc_attr($settings['param_name']).'" class="button '.esc_attr($settings['param_name']).' '.esc_attr($settings['type']).'" style="width: auto; padding: 0 10px 1px;"/>';
		return $output;
	}
	//add item window
	function mc_listitemwindow_settings_field($settings, $value)
	{
		$value = explode(",", $value);
		$output = '<div class="listitemwindow vc_panel vc_shortcode-edit-form" name="'.esc_attr($settings['param_name']).'">
			<div class="vc_panel-heading">
				<a class="vc_close" href="#" title="' . esc_attr__("Close panel", 'medicenter') . '"><i class="vc_icon"></i></a>
				<h3 class="vc_panel-title">' . __('Add New List Item', 'medicenter') . '</h3>
			</div>
			<div class="modal-body wpb-edit-form" style="display: block;min-height: auto;">
				<div class="vc_row-fluid wpb_el_type_dropdown">
					<div class="wpb_element_label">' . __("Type", 'medicenter') . '</div>
					<div class="edit_form_line">
						<select class="wpb_vc_param_value wpb-input wpb-select item_type dropdown" name="item_type">
							<option selected="selected" value="items" class="items">' . __("Items list", 'medicenter') . '</option>
							<option value="info" class="info">' . __("Info list", 'medicenter') . '</option>
							<option value="scrolling" class="scrolling">' . __("Scrolling list", 'medicenter') . '</option>
							<option value="simple" class="simple">' . __("Simple list", 'medicenter') . '</option>
						</select>
					</div>
				</div>
				<div class="vc_row-fluid wpb_el_type_textfield">
					<div class="wpb_element_label">' . __("Text", 'medicenter') . '</div>
					<div class="edit_form_line">
						<input type="text" value="" class="wpb_vc_param_value wpb-textinput textfield" name="item_content">
					</div>
				</div>
				<div class="vc_row-fluid wpb_el_type_textfield">
					<div class="wpb_element_label">' . __("Value", 'medicenter') . '</div>
					<div class="edit_form_line">
						<input type="text" value="" class="wpb_vc_param_value wpb-textinput textfield" name="item_value">
					</div>
				</div>
				<div class="vc_row-fluid wpb_el_type_textfield">
					<div class="wpb_element_label">' . __("Url", 'medicenter') . '</div>
					<div class="edit_form_line">
						<input type="text" value="" class="wpb_vc_param_value wpb-textinput textfield" name="item_url">
					</div>
				</div>
				<div class="vc_row-fluid wpb_el_type_dropdown">
					<div class="wpb_element_label">' . __("Url target", 'medicenter') . '</div>
					<div class="edit_form_line">
						<select class="wpb_vc_param_value wpb-input wpb-select item_url_target dropdown" name="item_url_target">
							<option selected="selected" value="new_window">' . __("new window", 'medicenter') . '</option>
							<option value="same_window">' . __("same window", 'medicenter') . '</option>
						</select>
					</div>
				</div>
				<div class="vc_row-fluid wpb_el_type_dropdown">
					<div class="wpb_element_label">' . __("Icon", 'medicenter') . '</div>
					<div class="edit_form_line">
						<select class="wpb_vc_param_value wpb-input wpb-select item_type dropdown" name="item_icon">
							<option selected="selected" value="">' . __("-", 'medicenter') . '</option>
							<option value="check">' . __("Check", 'medicenter') . '</option>
							<option value="arrow-circle">' . __("Arrow circle", 'medicenter') . '</option>
							<option value="chevron">' . __("Chevron", 'medicenter') . '</option>
							<option value="tick-1">' . __("Tick 1", 'medicenter') . '</option>
							<option value="tick-2">' . __("Tick 2", 'medicenter') . '</option>
							<option value="arrow-horizontal-5">' . __("Horizontal arrow", 'medicenter') . '</option>
							<option value="arrow-horizontal-3">' . __("Horizontal arrow small", 'medicenter') . '</option>
							<option value="arrow-horizontal-1">' . __("Horizontal arrow long", 'medicenter') . '</option>
						</select>
					</div>
				</div>
				<div class="wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column" data-vc-ui-element="panel-shortcode-param" data-vc-shortcode-param-name="item_content_color" data-param_type="colorpicker" data-param_settings="{&quot;type&quot;:&quot;colorpicker&quot;}">
					<div class="wpb_element_label">' . __("Custom text color", 'medicenter') . '</div>
					<div class="edit_form_line">
						<div class="color-group">
							<div class="wp-picker-container vc_color-picker">
								<span class="wp-picker-input-wrap">
									<input name="item_content_color" class="wpb_vc_param_value wpb-textinput item_content_color colorpicker_field vc_color-control wp-color-picker" type="text">
									<input class="button button-small hidden wp-picker-clear" value="Clear" type="button">
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column" data-vc-ui-element="panel-shortcode-param" data-vc-shortcode-param-name="item_content_color" data-param_type="colorpicker" data-param_settings="{&quot;type&quot;:&quot;colorpicker&quot;}">
					<div class="wpb_element_label">' . __("Custom value color", 'medicenter') . '</div>
					<div class="edit_form_line">
						<div class="color-group">
							<div class="wp-picker-container vc_color-picker">
								<span class="wp-picker-input-wrap">
									<input name="item_value_color" class="wpb_vc_param_value wpb-textinput item_value_color colorpicker_field vc_color-control wp-color-picker" type="text">
									<input class="button button-small hidden wp-picker-clear" value="Clear" type="button">
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column" data-vc-ui-element="panel-shortcode-param" data-vc-shortcode-param-name="item_content_color" data-param_type="colorpicker" data-param_settings="{&quot;type&quot;:&quot;colorpicker&quot;}">
					<div class="wpb_element_label">' . __("Custom value background color", 'medicenter') . '</div>
					<div class="edit_form_line">
						<div class="color-group">
							<div class="wp-picker-container vc_color-picker">
								<span class="wp-picker-input-wrap">
									<input name="item_value_background_color" class="wpb_vc_param_value wpb-textinput item_value_background_color colorpicker_field vc_color-control wp-color-picker" type="text">
									<input class="button button-small hidden wp-picker-clear" value="Clear" type="button">
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="wpb_el_type_colorpicker vc_wrapper-param-type-colorpicker vc_shortcode-param vc_column" data-vc-ui-element="panel-shortcode-param" data-vc-shortcode-param-name="item_content_color" data-param_type="colorpicker" data-param_settings="{&quot;type&quot;:&quot;colorpicker&quot;}">
					<div class="wpb_element_label">' . __("Custom border color", 'medicenter') . '</div>
					<div class="edit_form_line">
						<div class="color-group">
							<div class="wp-picker-container vc_color-picker">
								<span class="wp-picker-input-wrap">
									<input name="item_border_color" class="wpb_vc_param_value wpb-textinput item_border_color colorpicker_field vc_color-control wp-color-picker" type="text">
									<input class="button button-small hidden wp-picker-clear" value="Clear" type="button">
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="edit_form_actions" style="padding-top: 20px;">
					<a id="add-item-shortcode" class="button-primary" href="#">' . __("Add Item", 'medicenter') . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="cancel-item-options button" href="#">' . __("Cancel", 'medicenter') . '</a>
				</div>
			</div>
		</div>';
		return $output;
	}
//}
?>