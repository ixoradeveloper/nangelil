<?php
/*
Template Name: Empty template with footer
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<?php global $theme_options; ?>
	<head>
		<!--meta-->
		<meta http-equiv="content-type" content="text/html; charset=<?php echo esc_attr(get_bloginfo("charset")); ?>" />
		<meta name="generator" content="WordPress <?php echo esc_attr(get_bloginfo("version")); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<meta name="description" content="<?php echo esc_html(get_bloginfo('description')); ?>" />
		<meta name="format-detection" content="telephone=no" />
		<!--style-->
		<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo esc_url(get_bloginfo("rss2_url")); ?>" />
		<link rel="pingback" href="<?php echo esc_url(get_bloginfo("pingback_url")); ?>" />
		<?php
		if(!function_exists('has_site_icon') || !has_site_icon())
		{
			?>
			<link rel="shortcut icon" href="<?php echo (empty($theme_options["favicon_url"]) ? esc_url(get_template_directory_uri()) . "/images/favicon.ico" : esc_url($theme_options["favicon_url"])); ?>" />
			<?php 
		}
		?>
		<?php
		wp_head();
		?>
		<?php
		mc_get_theme_file("/custom_colors.php");	
		?>
	</head>
	<body <?php body_class(); ?>>
		<div class="site-container<?php echo ($theme_options['layout']=="boxed" || (isset($_COOKIE['mc_layout']) && $_COOKIE['mc_layout']=="boxed") ? ' boxed' : ($theme_options['layout']=="fullwidth" || (isset($_COOKIE['mc_layout']) && $_COOKIE['mc_layout']=="fullwidth") ? ' fullwidth' : '')); ?>">
			<div class="theme-page relative">
				<div class="clearfix">
					<?php
					if(have_posts()) : while (have_posts()) : the_post();
						the_content();
					endwhile; endif;
					?>
				</div>
			</div>
			<?php
			$sidebar_footer_top = get_post(get_post_meta(get_the_ID(), "page_sidebar_footer_top", true));
			$sidebar = get_post(get_post_meta(get_the_ID(), "page_sidebar_footer_bottom", true));
			if((isset($sidebar_footer_top) && !(int)get_post_meta($sidebar_footer_top->ID, "hidden", true) && is_active_sidebar($sidebar_footer_top->post_name)) || (isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name)))
			{
			?>
			<div class="footer-container">
				<div class="footer">
					<?php
					if(isset($sidebar_footer_top) && !(int)get_post_meta($sidebar_footer_top->ID, "hidden", true) && is_active_sidebar($sidebar_footer_top->post_name))
					{
					?>
					<ul class="footer-banner-box-container clearfix<?php echo ((int)get_post_meta($sidebar_footer_top->ID, "hide_on_mobiles", true) ? ' hide-on-mobiles' : ''); ?>">
						<?php
						dynamic_sidebar($sidebar_footer_top->post_name);
						?>
					</ul>
					<?php
					}
					if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name))
					{
					?>
					<div class="footer-box-container vc_row wpb_row vc_row-fluid clearfix<?php echo ((int)get_post_meta($sidebar->ID, "hide_on_mobiles", true) ? ' hide-on-mobiles' : ''); ?>">
						<?php
							dynamic_sidebar($sidebar->post_name);
						?>
					</div>
					<?php
					}
					?>
				</div>
			</div>
			<?php
			}
			$locations = get_nav_menu_locations();
			if(isset($locations["footer-menu"]))
				$footer_menu_object = get_term($locations["footer-menu"], "nav_menu");
			if($theme_options["footer_text_left"]!="" || (has_nav_menu("footer-menu") && $footer_menu_object->count>0) || is_active_sidebar('sidebar-copyright-area')): ?>
			<div class="copyright-area-container">
				<div class="copyright-area clearfix">
					<?php if($theme_options["footer_text_left"]!=""): ?>
					<div class="copyright-text">
					<?php
					echo do_shortcode($theme_options["footer_text_left"]);
					?>
					</div>
					<?php
					endif;
					if(is_active_sidebar('sidebar-copyright-area'))
					{
						$sidebar = mc_get_page_by_title("Sidebar Copyright Area", "medicenter_sidebars");
						if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true))
						{
							if((int)get_post_meta($sidebar->ID, "hide_on_mobiles", true))
							{
							?>
							<div class="hide-on-mobiles">
							<?php
							}
							dynamic_sidebar('sidebar-copyright-area');
							if((int)get_post_meta($sidebar->ID, "hide_on_mobiles", true))
							{
							?>
							</div>
							<?php
							}
						}
					}
					if(has_nav_menu("footer-menu") && $footer_menu_object->count>0) 
					{
						wp_nav_menu(array(
							"theme_location" => "footer-menu",
							"menu_class" => "footer-menu"
						));
					}
					?>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php if((int)$theme_options["scroll_top"]): ?>
		<a href="#top" class="scroll-top animated-element template-arrow-vertical-3" title="<?php esc_attr_e("Scroll to top", 'medicenter'); ?>"></a>
		<?php
		endif;
		if((int)$theme_options["layout_picker"])
			mc_get_theme_file("/style_selector/style_selector.php");		
		wp_footer();
		?>
	</body>
</html>
			