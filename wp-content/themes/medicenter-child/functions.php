<?php
function child_theme_enqueue_styles()
{
	wp_enqueue_style("parent-style", get_template_directory_uri() . "/style.css", array("reset", "superfish", "prettyPhoto", "jquery-qtip", "odometer"));
}
add_action("wp_enqueue_scripts", "child_theme_enqueue_styles");
function child_theme_enqueue_rtl_styles() 
{
	if(is_rtl())
		wp_enqueue_style("parent-rtl", get_template_directory_uri() ."/rtl.css");
}
add_action("wp_enqueue_scripts", "child_theme_enqueue_rtl_styles", 11);
?>