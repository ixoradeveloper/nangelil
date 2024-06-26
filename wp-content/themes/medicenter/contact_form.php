<?php
//contact form
function mc_theme_contact_form_shortcode($atts)
{
	global $theme_options;
	extract(shortcode_atts(array(
		"id" => "contact_form",
		"header" => __("Online Appointment Form ", 'medicenter'),
		"animation" => 0,
		"department_select_box" => 1,
		"department_select_box_title" => __("Select Department", 'medicenter'),
		"submit_label" => __("SEND", 'medicenter'),
		"display_first_name" => 1,
		"first_name_label" => __("FIRST NAME", 'medicenter'),
		"first_name_required" => 1,
		"display_last_name" => 1,
		"last_name_label" => __("LAST NAME", 'medicenter'),
		"last_name_required" => 1,
		"display_date" => 1,
		"date_label" => __("DATE OF BIRTH (mm/dd/yyyy)", 'medicenter'),
		"date_required" => 0,
		"display_security_number" => 1,
		"security_number_label" => __("SOCIAL SECURITY NUMBER", 'medicenter'),
		"security_number_required" => 0,
		"display_phone" => 1,
		"phone_label" => __("PHONE NUMBER", 'medicenter'),
		"phone_required" => 0,
		"display_email" => 1,
		"email_label" => __("E-MAIL", 'medicenter'),
		"email_required" => 1,
		"display_message" => 1,
		"message_label" => __("REASON OF APPOINTMENT", 'medicenter'),
		"message_required" => 1,
		"description" => __("We will contact you within one business day.", 'medicenter'),
		"terms_checkbox" => 0,
		"terms_message" => "UGxlYXNlJTIwYWNjZXB0JTIwdGVybXMlMjBhbmQlMjBjb25kaXRpb25z",
		"top_margin" => "none"
	), $atts));
	
	$output = "";
	if($header!="")
		$output .= '<h3 class="box-header' . ((int)$animation ? ' animation-slide' : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">' . $header . '</h3>';
	$output .= '<form class="contact-form ' . ($top_margin!="none" && $header!="" ? esc_attr($top_margin) : '') . '" id="' . esc_attr($id) . '" method="post" action="">';
	if((int)$department_select_box)
	{
		//get departments list
		$departments_list = get_posts(array(
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_type' => 'departments'
		));
		if(count($departments_list))
		{
			$output .= '<ul class="clearfix tabs-box-navigation sf-menu">
				<li class="tabs-box-navigation-selected wide template-plus-2-after" aria-haspopup="true">
					<input type="hidden" name="department" value="" />
					<span>' . $department_select_box_title . '</span>
					<ul class="sub-menu">';
			foreach($departments_list as $department)
				$output .= '<li><a href="#' . urldecode($department->post_name) . '" title="' . esc_attr($department->post_title) . '">' . $department->post_title . '</a></li>';
			$output .= '</ul>
				</ul>';
			$output .= '<input type="hidden" id="department_select_box_title" value="' . esc_attr($department_select_box_title) . '">';
		}
	}
	$output .= '<div class="vc_row wpb_row vc_inner">
			<fieldset class="vc_col-sm-6 wpb_column vc_column_container">';
		if((int)$display_first_name)
		{
			$output .= '<label>' . $first_name_label . '</label>
				<div class="block">
					<input class="text_input" name="first_name" type="text" value="" tabindex="1"' . ((int)$first_name_required ? ' data-required="1"' : '') . '>
				</div>';
		}
		if((int)$display_date)
		{
				$output .= '<label>' . $date_label . '</label>
				<div class="block">
					<input class="text_input" name="date_of_birth" type="text" value="" tabindex="3"' . ((int)$date_required ? ' data-required="1"' : '') . '>
				</div>';
		}
		if((int)$display_phone)
		{
			$output .= '<label>' . $phone_label . '</label>
				<div class="block">
					<input class="text_input" name="phone_number" type="text" value="" tabindex="5"' . ((int)$phone_required ? ' data-required="1"' : '') . '>
				</div>';
		}
		$output .= '</fieldset>
			<fieldset class="vc_col-sm-6 wpb_column vc_column_container">';
		if((int)$display_last_name)
		{
			$output .= '<label>' . $last_name_label . '</label>
				<div class="block">
					<input class="text_input" name="last_name" type="text" value="" tabindex="2"' . ((int)$last_name_required ? ' data-required="1"' : '') . '>
				</div>';
		}
		if((int)$display_security_number)
		{
			$output .= '<label>' . $security_number_label. '</label>
				<div class="block">
					<input class="text_input" name="social_security_number" type="text" value="" tabindex="4"' . ((int)$security_number_required ? ' data-required="1"' : '') . '>
				</div>';
		}
		if((int)$display_email)
		{
			$output .= '<label>' . $email_label . '</label>
				<div class="block">
					<input class="text_input" name="email" type="text" value="" tabindex="6"' . ((int)$email_required ? ' data-required="1"' : '') . '>
				</div>';
		}
		$output .= '</fieldset>
		</div>';
		if((int)$display_message)
		{
			$output .= '<div class="vc_row wpb_row vc_inner">
			<fieldset>
				<label>' . $message_label . '</label>
				<div class="block">
					<textarea name="message" tabindex="7"' . ((int)$message_required ? ' data-required="1"' : '') . '></textarea>
				</div>
			</fieldset>
		</div>';
		}
		$output .= '<div class="vc_row wpb_row vc_inner submit-container margin-top-30' . ((int)$theme_options["google_recaptcha"] && empty($description) ? ' fieldset-with-recaptcha' : ((int)$theme_options["google_recaptcha"] && !empty($description) ? ' row-with-recaptcha' : '')) . '">';
			if(!empty($description))
			{
				$output .= '<div class="vc_col-sm-6 wpb_column vc_column_container">
				<p>' . $description . '</p>
			</div>
			<div class="vc_col-sm-6 wpb_column vc_column_container ' . ((int)$theme_options["google_recaptcha"] ? 'column-with-recaptcha' : '') . '">';
			}
			$output .= '<input type="hidden" name="action" value="theme_contact_form" />
				<input type="hidden" name="id" value="' . esc_attr($id) . '" />';
			if((int)$terms_checkbox)
			{
				$output .= '<div class="terms-container block">
					<input type="checkbox" name="terms" id="' . esc_attr($id) . 'terms" value="1"><label for="' . esc_attr($id) . 'terms">' . urldecode(base64_decode($terms_message)) . '</label>
				</div>';
				if((int)$theme_options["google_recaptcha"])
				{
					$output .= '<div class="recaptcha-container">';
				}
			}
			$output .= '<div class="vc_row wpb_row vc_inner' . ((int)$theme_options["google_recaptcha"] ? ' button-with-recaptcha' : '') . '">
				<input type="submit" name="submit" value="' . esc_attr($submit_label) . '" class="more mc-button" />
			</div>';
			if((int)$theme_options["google_recaptcha"])
			{
				if($theme_options["recaptcha_site_key"]!="" && $theme_options["recaptcha_secret_key"]!="")
				{
					wp_enqueue_script("google-recaptcha-v2");
					$output .= '<div class="g-recaptcha-wrapper block"><div class="g-recaptcha" data-sitekey="' . esc_attr($theme_options["recaptcha_site_key"]) . '"></div></div>';
				}
				else
					$output .= '<p>' . __("Error while loading reCapcha. Please set the reCaptcha keys under Theme Options in admin area", 'medicenter') . '</p>';
				if((int)$terms_checkbox)
				{
					$output .= '</div>';
				}
			}
	if(!empty($description))
		$output .= '</div>';
	$output .= '</div>
	</form>';
	return $output;
}

//visual composer
function mc_theme_contact_form_vc_init()
{
	global $theme_options;
	vc_map( array(
		"name" => __("Contact form", 'medicenter'),
		"base" => "medicenter_contact_form",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-contact-form",
		"category" => __('MediCenter', 'medicenter'),
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Id", 'medicenter'),
				"param_name" => "id",
				"value" => "contact_form",
				"description" => __("Please provide unique id for each contact form on the same page/post", 'medicenter')
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Header", 'medicenter'),
				"param_name" => "header",
				"value" => __("Online Appointment Form ", 'medicenter')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Header border animation", 'medicenter'),
				"param_name" => "animation",
				"value" => array(__("no", 'medicenter') => 0,  __("yes", 'medicenter') => 1)
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Display department select box", 'medicenter'),
				"param_name" => "department_select_box",
				"value" => array(__("yes", 'medicenter') => 1, __("no", 'medicenter') => 0)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Department select box title", 'medicenter'),
				"param_name" => "department_select_box_title",
				"value" => __("Select Department", 'medicenter'),
				"dependency" => Array('element' => "department_select_box", 'value' => '1')
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Submit label", 'medicenter'),
				"param_name" => "submit_label",
				"value" => __("SEND", 'medicenter')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Display first name field", 'medicenter'),
				"param_name" => "display_first_name",
				"value" => array(__("yes", 'medicenter') => 1, __("no", 'medicenter') => 0)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("First name label", 'medicenter'),
				"param_name" => "first_name_label",
				"value" => __("FIRST NAME", 'medicenter'),
				"dependency" => Array('element' => "display_first_name", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("First name field required", 'medicenter'),
				"param_name" => "first_name_required",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"dependency" => Array('element' => "display_first_name", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Display last name field", 'medicenter'),
				"param_name" => "display_last_name",
				"value" => array(__("yes", 'medicenter') => 1, __("no", 'medicenter') => 0)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Last name label", 'medicenter'),
				"param_name" => "last_name_label",
				"value" => __("LAST NAME", 'medicenter'),
				"dependency" => Array('element' => "display_last_name", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Last name field required", 'medicenter'),
				"param_name" => "last_name_required",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"dependency" => Array('element' => "display_last_name", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Display date field", 'medicenter'),
				"param_name" => "display_date",
				"value" => array(__("yes", 'medicenter') => 1, __("no", 'medicenter') => 0)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Date of birth label", 'medicenter'),
				"param_name" => "date_label",
				"value" => __("DATE OF BIRTH", 'medicenter'),
				"dependency" => Array('element' => "display_date", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Date of birth field required", 'medicenter'),
				"param_name" => "date_required",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"std" => 0,
				"dependency" => Array('element' => "display_date", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Display security number field", 'medicenter'),
				"param_name" => "display_security_number",
				"value" => array(__("yes", 'medicenter') => 1, __("no", 'medicenter') => 0)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Security number label", 'medicenter'),
				"param_name" => "security_number_label",
				"value" => __("SOCIAL SECURITY NUMBER", 'medicenter'),
				"dependency" => Array('element' => "display_security_number", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Security number field required", 'medicenter'),
				"param_name" => "security_number_required",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"std" => 0,
				"dependency" => Array('element' => "display_security_number", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Display phone field", 'medicenter'),
				"param_name" => "display_phone",
				"value" => array(__("yes", 'medicenter') => 1, __("no", 'medicenter') => 0)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Phone label", 'medicenter'),
				"param_name" => "phone_label",
				"value" => __("PHONE NUMBER", 'medicenter'),
				"dependency" => Array('element' => "display_phone", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Phone field required", 'medicenter'),
				"param_name" => "phone_required",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"std" => 0,
				"dependency" => Array('element' => "display_phone", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Display email field", 'medicenter'),
				"param_name" => "display_email",
				"value" => array(__("yes", 'medicenter') => 1, __("no", 'medicenter') => 0)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Email label", 'medicenter'),
				"param_name" => "email_label",
				"value" => __("E-MAIL", 'medicenter'),
				"dependency" => Array('element' => "display_email", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Email field required", 'medicenter'),
				"param_name" => "email_required",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"dependency" => Array('element' => "display_email", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Display message field", 'medicenter'),
				"param_name" => "display_message",
				"value" => array(__("yes", 'medicenter') => 1, __("no", 'medicenter') => 0)
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Message label", 'medicenter'),
				"param_name" => "message_label",
				"value" => __("REASON OF APPOINTMENT", 'medicenter'),
				"dependency" => Array('element' => "display_message", 'value' => '1')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Message field required", 'medicenter'),
				"param_name" => "message_required",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"dependency" => Array('element' => "display_message", 'value' => '1')
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Description", 'medicenter'),
				"param_name" => "description",
				"value" => __("We will contact you within one business day.", 'medicenter')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Terms and conditions checkbox", 'medicenter'),
				"param_name" => "terms_checkbox",
				"value" => array(__("Yes", 'medicenter') => 1, __("No", 'medicenter') => 0),
				"std" => 0
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
				"value" => ((int)$theme_options["google_recaptcha"] ? __("Yes", 'medicenter') : __("No", 'medicenter')),
				"description" => sprintf(__("You can change this setting under <a href='%s' title='Theme Options'>Theme Options</a>", 'medicenter'), esc_url(admin_url("themes.php?page=ThemeOptions")))
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
add_action("init", "mc_theme_contact_form_vc_init");

//contact form submit
function mc_theme_contact_form()
{
	ob_start();
	global $theme_options;

    $result = array();
	$result["isOk"] = true;
	if(((isset($_POST["terms"]) && (int)$_POST["terms"]) || !isset($_POST["terms"])) && (((int)$theme_options["google_recaptcha"] && !empty($_POST["g-recaptcha-response"])) || !(int)$theme_options["google_recaptcha"]) && ((isset($_POST["first_name_required"]) && (int)$_POST["first_name_required"] && $_POST["first_name"]!="") || (!isset($_POST["first_name_required"]) || !(int)$_POST["first_name_required"])) && ((isset($_POST["last_name_required"]) && (int)$_POST["last_name_required"] && $_POST["last_name"]!="") || (!isset($_POST["last_name_required"]) || !(int)$_POST["last_name_required"])) && ((isset($_POST["date_of_birth_required"]) && (int)$_POST["date_of_birth_required"] && $_POST["date_of_birth"]!="") || (!isset($_POST["date_of_birth_required"]) || !(int)$_POST["date_of_birth_required"])) && ((isset($_POST["social_security_number_required"]) && (int)$_POST["social_security_number_required"] && $_POST["social_security_number"]!="") || (!isset($_POST["social_security_number_required"]) || !(int)$_POST["social_security_number_required"])) && ((isset($_POST["email_required"]) && (int)$_POST["email_required"] && $_POST["email"]!="" && preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,12})$#", $_POST["email"])) || (!isset($_POST["email_required"]) || !(int)$_POST["email_required"])) && ((isset($_POST["phone_number_required"]) && (int)$_POST["phone_number_required"] && $_POST["phone_number"]!="") || (!isset($_POST["phone_number_required"]) || !(int)$_POST["phone_number_required"])) && ((isset($_POST["message_required"]) && (int)$_POST["message_required"] && $_POST["message"]!="") || (!isset($_POST["message_required"]) || !(int)$_POST["message_required"])))
	{
		if((int)$theme_options["google_recaptcha"])
		{
			$data = array(
				"secret" => $theme_options["recaptcha_secret_key"],
				"response" => $_POST["g-recaptcha-response"]
			);			
			$remote_response = wp_remote_post("https://www.google.com/recaptcha/api/siteverify", array(
				"body" => $data,
				"sslverify" => false,
			));
			$verify_recaptcha = json_decode($remote_response["body"], true);
		}
		if(((int)$theme_options["google_recaptcha"] && isset($verify_recaptcha["success"]) && (int)$verify_recaptcha["success"]) || !(int)$theme_options["google_recaptcha"])
		{
			$values = array(
				"department" => $_POST["department"],
				"first_name" => $_POST["first_name"],
				"last_name" => $_POST["last_name"],
				"date_of_birth" => $_POST["date_of_birth"],
				"phone_number" => $_POST["phone_number"],
				"social_security_number" => $_POST["social_security_number"],
				"email" => $_POST["email"],
				"message" => $_POST["message"]
			);
			$values = mc_theme_stripslashes_deep($values);
			$values = array_map("htmlspecialchars", $values);
			
			$headers[] = 'Reply-To: ' . $values["first_name"] . " " . $values["last_name"] . ' <' . $values["email"] . '>' . "\r\n";
			$headers[] = 'From: ' . (!empty($theme_options["cf_admin_name_from"]) ? $theme_options["cf_admin_name_from"] : $theme_options["cf_admin_name"]) . ' <' . (!empty($theme_options["cf_admin_email_from"]) ? $theme_options["cf_admin_email_from"] : $theme_options["cf_admin_email"]) . '>' . "\r\n";
			$headers[] = 'Content-type: text/html';
			$subject = $theme_options["cf_email_subject"];
			$subject = str_replace("[department]", $values["department"], $subject);
			$subject = str_replace("[first_name]", $values["first_name"], $subject);
			$subject = str_replace("[last_name]", $values["last_name"], $subject);
			$subject = str_replace("[date]", $values["date_of_birth"], $subject); 
			$subject = str_replace("[social_security_number]", $values["social_security_number"], $subject);
			$subject = str_replace("[phone_number]", $values["phone_number"], $subject);
			$subject = str_replace("[email]", $values["email"], $subject);
			$subject = str_replace("[message]", $values["message"], $subject);
			$body = $theme_options["cf_template"];
			$body = str_replace("[department]", $values["department"], $body);
			$body = str_replace("[first_name]", $values["first_name"], $body);
			$body = str_replace("[last_name]", $values["last_name"], $body);
			$body = str_replace("[date]", $values["date_of_birth"], $body); 
			$body = str_replace("[social_security_number]", $values["social_security_number"], $body);
			$body = str_replace("[phone_number]", $values["phone_number"], $body);
			$body = str_replace("[email]", $values["email"], $body);
			$body = str_replace("[message]", $values["message"], $body);

			if(wp_mail($theme_options["cf_admin_name"] . ' <' . $theme_options["cf_admin_email"] . '>', $subject, $body, $headers))
				$result["submit_message"] = (!empty($theme_options["cf_thankyou_message"]) ? $theme_options["cf_thankyou_message"] : __("Thank you for contacting us", 'medicenter'));
			else
			{
				$result["isOk"] = false;
				$result["error_message"] = $GLOBALS['phpmailer']->ErrorInfo;
				$result["submit_message"] = (!empty($theme_options["cf_error_message"]) ? $theme_options["cf_error_message"] : __("Sorry, we can't send this message", 'medicenter'));
			}
		}
		else
		{
			$result["isOk"] = false;
			$result["error_captcha"] = (!empty($theme_options["cf_recaptcha_message"]) ? $theme_options["cf_recaptcha_message"] : __("Please verify captcha.", 'medicenter'));
		}
	}
	else
	{
		$result["isOk"] = false;
		if(isset($_POST["first_name_required"]) && (int)$_POST["first_name_required"] && $_POST["first_name"]=="")
			$result["error_first_name"] = (!empty($theme_options["cf_first_name_message"]) ? $theme_options["cf_first_name_message"] : __("Please enter your first name.", 'medicenter'));
		if(isset($_POST["last_name_required"]) && (int)$_POST["last_name_required"] && $_POST["last_name"]=="")
			$result["error_last_name"] = (!empty($theme_options["cf_last_name_message"]) ? $theme_options["cf_last_name_message"] : __("Please enter your last name.", 'medicenter'));
		if(isset($_POST["date_of_birth_required"]) && (int)$_POST["date_of_birth_required"] && $_POST["date_of_birth"]=="")
			$result["error_date_of_birth"] = (!empty($theme_options["cf_date_message"]) ? $theme_options["cf_date_message"] : __("Please enter your date of birth.", 'medicenter'));
		if(isset($_POST["social_security_number_required"]) && (int)$_POST["social_security_number_required"] && $_POST["social_security_number"]=="")
			$result["error_social_security_number"] = (!empty($theme_options["cf_security_number_message"]) ? $theme_options["cf_security_number_message"] : __("Please enter social security number.", 'medicenter'));
		if(isset($_POST["phone_number_required"]) && (int)$_POST["phone_number_required"] && $_POST["phone_number"]=="")
			$result["error_phone_number"] = (!empty($theme_options["cf_phone_message"]) ? $theme_options["cf_phone_message"] : __("Please enter your phone number.", 'medicenter'));
		if(isset($_POST["email_required"]) && (int)$_POST["email_required"] && ($_POST["email"]=="" || !preg_match("#^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,12})$#", $_POST["email"])))
			$result["error_email"] = (!empty($theme_options["cf_email_message"]) ? $theme_options["cf_email_message"] : __("Please enter valid e-mail.", 'medicenter'));
		if(isset($_POST["message_required"]) && (int)$_POST["message_required"] && $_POST["message"]=="")
			$result["error_message"] = (!empty($theme_options["cf_message_message"]) ? $theme_options["cf_message_message"] : __("Please enter your message.", 'medicenter'));
		if((int)$theme_options["google_recaptcha"] && empty($_POST["g-recaptcha-response"]))
			$result["error_captcha"] = (!empty($theme_options["cf_recaptcha_message"]) ? $theme_options["cf_recaptcha_message"] : __("Please verify captcha.", 'medicenter'));
		if(isset($_POST["terms"]) && !(int)$_POST["terms"])
			$result["error_terms"] = (!empty($theme_options["cf_terms_message"]) ? $theme_options["cf_terms_message"] : __("Checkbox is required.", 'medicenter'));
	}
	$system_message = ob_get_clean();
	$result["system_message"] = $system_message;
	echo @json_encode($result);
	exit();
}
add_action("wp_ajax_theme_contact_form", "mc_theme_contact_form");
add_action("wp_ajax_nopriv_theme_contact_form", "mc_theme_contact_form");
?>