<?php
/*
Template Name: Empty template
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
			