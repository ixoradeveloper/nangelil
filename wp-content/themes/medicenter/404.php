<?php
/*
Template Name: 404 page
*/
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");
get_header();
?>
<div class="theme-page relative">
	<div class="clearfix">
		<?php
		if(function_exists("vc_map"))
		{
			/*get page with 404 page template set*/
			$not_found_template_page_array = get_pages(array(
				'post_type' => 'page',
				'post_status' => 'publish',
				//'number' => 1,
				'meta_key' => '_wp_page_template',
				'meta_value' => '404.php'
			));
			if(count($not_found_template_page_array))
			{
				$not_found_template_page_array = array_values($not_found_template_page_array);
				$not_found_template_page = $not_found_template_page_array[0];
				echo wpb_js_remove_wpautop(apply_filters('the_content', $not_found_template_page->post_content));
				global $post;
				$post = $not_found_template_page;
				setup_postdata($post);
			}
			else
				echo wpb_js_remove_wpautop(apply_filters('the_content', '[vc_row el_position="first last"][vc_column][mc_icon icon_feature="document-missing" top_margin="page-margin-top-section"][box_header title="404. The page you requested was not found." type="h1" bottom_border="0" top_margin="page-margin-top"][vc_column_text el_position="first" el_class="description"]We&#8217;re sorry, but we can&#8217;t seem to find the page you requested.<br>This might be because you have typed the web address incorrectly.[/vc_column_text][vc_button title="BACK TO HOME" hover_text_color="#ffffff" color="transparent" href="' . esc_url(get_home_url()) . '" el_position="last" el_class="margin-top-20"][/vc_column][/vc_row]'));
		}
		else
		{
			?>
			<div class="vc_row wpb_row vc_row-fluid">
				<div class="wpb_column vc_column_container vc_col-sm-12">
					<div class="wpb_wrapper">
						<span class="icon-single mc-icon features-document-missing page-margin-top-section"></span><h1 class="box-header no-border page-margin-top"><?php _e("404. The page you requested was not found.", 'medicenter');?></h1>
						<div class="wpb_text_column wpb_content_element  description">
							<div class="wpb_wrapper">
								<p><?php _e("We&#8217;re sorry, but we can&#8217;t seem to find the page you requested.<br>This might be because you have typed the web address incorrectly.", 'medicenter');?></p>
							</div>
						</div>
						<a title="<?php esc_attr_e("BACK TO HOME", 'medicenter');?>" href="<?php echo esc_url(get_home_url()); ?>" class="mc-button more light margin-top-20"><?php _e("BACK TO HOME", 'medicenter');?></a>
					</div>
				</div>
			</div>
		<?php
		}
		?>
	</div>
</div>
<?php
get_footer(); 
?>
