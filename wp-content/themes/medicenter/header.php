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
		<link rel="alternate" type="application/rss+xml" title="<?php esc_attr_e('RSS 2.0', 'medicenter'); ?>" href="<?php echo esc_url(get_bloginfo("rss2_url")); ?>">
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
			<?php
			if(isset($_COOKIE['mc_header_sidebar']) && (int)$_COOKIE['mc_header_sidebar'])
			{
				?>
				<div class="header-top-sidebar-container">
					<div class="header-top-sidebar clearfix">
						<?php
						dynamic_sidebar('sidebar-header-top');
						$header_top_right_sidebar_visible = true;
						?>
					</div>
				</div>
				<?php
			}
			else if(!empty($theme_options["header_top_sidebar"]) && (!isset($_COOKIE['mc_header_sidebar']) || (int)$_COOKIE['mc_header_sidebar']))
			{
				$sidebar = get_post($theme_options["header_top_sidebar"]);
				if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name)):
				?>
				<div class="header-top-sidebar-container<?php echo ((int)get_post_meta($sidebar->ID, "hide_on_mobiles", true) ? ' hide-on-mobiles' : ''); ?>">
					<div class="header-top-sidebar clearfix">
						<?php
						dynamic_sidebar($sidebar->post_name);
						?>
					</div>
				</div>
				<?php
				endif;
			}
			?>
			<!-- Header -->
			<?php
			$header_layout_type = (isset($_COOKIE['mc_header_type']) && (int)$_COOKIE['mc_header_type'] ? (int)$_COOKIE['mc_header_type'] : (isset($theme_options["header_layout_type"]) ? (int)$theme_options["header_layout_type"] : 1));
			$header_top_right_sidebar_visible = false;
			if($header_layout_type==2 && ((isset($_COOKIE['mc_header_sidebar_right']) && (int)$_COOKIE['mc_header_sidebar_right']) || (isset($theme_options["header_top_right_sidebar"]) && $theme_options["header_top_right_sidebar"]!="")))
			{
				$header_top_right_sidebar_visible = true;
			}
			?>
			<div class="header-container <?php echo (($header_layout_type==1) && ((!empty($_COOKIE['mc_sticky_menu']) && (int)$_COOKIE['mc_sticky_menu']==1) || (!empty($theme_options["sticky_menu"]) && (int)$theme_options["sticky_menu"]==1 && (!isset($_COOKIE['mc_sticky_menu']) || (int)$_COOKIE['mc_sticky_menu']==1 ))) ? "sticky" : "")?>">
				<div class="header clearfix<?php echo ($header_top_right_sidebar_visible ? ' top-sidebar-visible' : ''); ?> layout-<?php echo ($header_layout_type==3 ? $header_layout_type . ' layout-2' : $header_layout_type); ?>">
					<?php
					if(is_active_sidebar('header-top')):
					?>
					<div class="header-top-sidebar clearfix">
					<?php
					get_sidebar('header-top');
					?>
					</div>
					<?php
					endif;
					?>
					<div class="header-left">
						<a href="<?php echo esc_url(get_home_url()); ?>" title="<?php echo esc_attr(get_bloginfo("name")); ?>">
							<?php if($theme_options["logo_url"]!=""): 
							$logo_url = $theme_options["logo_url"];
								if(isset($_COOKIE['mc_main_color']))
								{
									if($_COOKIE['mc_main_color']=="green")
									{
										$logo_url = get_template_directory_uri() . "/images/header_logo_green.png";
									}
									else if($_COOKIE['mc_main_color']=="orange")
									{
										$logo_url = get_template_directory_uri() . "/images/header_logo_orange.png";
									}
									else if($_COOKIE['mc_main_color']=="red")
									{
										$logo_url = get_template_directory_uri() . "/images/header_logo_red.png";
									}
									else if($_COOKIE['mc_main_color']=="turquoise")
									{
										$logo_url = get_template_directory_uri() . "/images/header_logo_turquoise.png";
									}
									else if($_COOKIE['mc_main_color']=="violet")
									{
										$logo_url = get_template_directory_uri() . "/images/header_logo_violet.png";
									}
								}
							?>
							<img src="<?php echo esc_url($logo_url); ?>" alt="logo" />
							<?php endif; ?>
							<?php if($theme_options["logo_text"]!=""): ?>
							<span class="logo"><?php echo $theme_options["logo_text"]; ?></span>
							<?php 
							endif;
							?>
						</a>
						<a href="#" class="mobile-menu-switch vertical-align-cell">
							<span class="line"></span>
							<span class="line"></span>
							<span class="line"></span>
							<span class="line"></span>
						</a>
						<?php
						if($header_layout_type==2)
						{
							if(isset($_COOKIE['mc_header_sidebar_right']) && (int)$_COOKIE['mc_header_sidebar_right'])
							{
								?>
								<div class="header-top-right-sidebar-container">
								<div class="header-top-right-sidebar clearfix">
									<?php
									dynamic_sidebar('sidebar-header-top-right');
									?>
								</div>
								</div>
								<?php
							}
							else if(isset($theme_options["header_top_right_sidebar"]) && $theme_options["header_top_right_sidebar"]!="")
							{
								$sidebar = get_post($theme_options["header_top_right_sidebar"]);
								if(!(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name)):
								?>
								<div class="header-top-right-sidebar-container<?php echo ((int)get_post_meta($sidebar->ID, "hide_on_mobiles", true) ? ' hide-on-mobiles' : ''); ?>">
									<div class="header-top-right-sidebar clearfix">
										<?php
										dynamic_sidebar($sidebar->post_name);
										?>
									</div>
								</div>
								<?php
								endif;
							}
						}
						?>
					</div>
					<?php 
					if($header_layout_type!=2 && $header_layout_type!=3 && $header_layout_type!=4)
					{
						//Get menu object
						$locations = get_nav_menu_locations();
						if(isset($locations["main-menu"]))
						{
							$main_menu_object = get_term($locations["main-menu"], "nav_menu");
							if(has_nav_menu("main-menu") && $main_menu_object->count>0) 
							{
								?>
								<div class="menu-container clearfix">
								<?php
									wp_nav_menu(array(
										"container" => "nav",
										"theme_location" => "main-menu",
										"menu_class" => "sf-menu header-right"
									));
								?>
								</div>
								<div class="mobile-menu-container clearfix">
									<div class="mobile-menu-divider"></div>
									<?php
									wp_nav_menu(array(
										'container'			=> 'nav',
										'container_class'	=> 'mobile-menu' . (!isset($theme_options["collapsible_mobile_submenus"]) || (int)$theme_options["collapsible_mobile_submenus"] ? " collapsible-mobile-submenus" : ""),
										'theme_location'	=> 'main-menu',
										"walker" => (!isset($theme_options["collapsible_mobile_submenus"]) || (int)$theme_options["collapsible_mobile_submenus"] ? new Mobile_Menu_Walker_Nav_Menu() : '')
									));
									?>
								</div>
								<?php
								/*
								<select>
									<option value="-">-</option>
									<?php
									$menu_items = wp_get_nav_menu_items($main_menu_object->term_id);
									print_r($menu_items);
									foreach((array)$menu_items as $key => $menu_item ) 
									{
										?>
										<option value="<?php echo $menu_item->url; ?>"><?php echo $menu_item->title; ?></option>
										<?php
									}
									echo count($menu_items);
									?>
								</select>*/
							}
						}
					}
					?>
				</div>
			</div>
			<?php
			if($header_layout_type==2 || $header_layout_type==3 || $header_layout_type==4):
				if($header_layout_type!=4)
				{
			?>
			<div class="header-separator<?php echo ($header_layout_type==2 && $header_top_right_sidebar_visible ? ' padding-top-15' : ''); ?>"></div>
			<?php
				}
			?>
			<div class="header-container header-container-layout-<?php echo esc_attr($header_layout_type); echo ((!empty($_COOKIE['mc_sticky_menu']) && (int)$_COOKIE['mc_sticky_menu']==1) || (!empty($theme_options["sticky_menu"]) && (int)$theme_options["sticky_menu"]==1 && (!isset($_COOKIE['mc_sticky_menu']) || (int)$_COOKIE['mc_sticky_menu']==1)) ? " sticky" : "")?>">
				<div class="header clearfix<?php echo ($header_layout_type!=4 ? ' padding-top-0' : '');?> layout-<?php echo ($header_layout_type==3 ? esc_attr($header_layout_type) . ' layout-2' : esc_attr($header_layout_type)); ?>">
				<?php
				//Get menu object
				$locations = get_nav_menu_locations();
				if(isset($locations["main-menu"]))
				{
					$main_menu_object = get_term($locations["main-menu"], "nav_menu");
					if(has_nav_menu("main-menu") && $main_menu_object->count>0) 
					{
						?>
						<div class="menu-container clearfix">
						<?php
						wp_nav_menu(array(
							"container" => "nav",
							"theme_location" => "main-menu",
							"menu_class" => "sf-menu header-right",
							'walker'         => ($header_layout_type!=4 ? new Walker_Nav_Menu_Layout2() : '')
						));
						?>
						</div>
						<div class="mobile-menu-container clearfix">
							<?php
							wp_nav_menu(array(
								'container'			=> 'nav',
								'container_class'	=> 'mobile-menu' . (!isset($theme_options["collapsible_mobile_submenus"]) || (int)$theme_options["collapsible_mobile_submenus"] ? " collapsible-mobile-submenus" : ""),
								'theme_location'	=> 'main-menu',
								"walker" => (!isset($theme_options["collapsible_mobile_submenus"]) || (int)$theme_options["collapsible_mobile_submenus"] ? new Mobile_Menu_Walker_Nav_Menu() : '')
							));
							?>
						</div>
						<?php
					}
				}
				?>
				</div>
			</div>
			<?php
			endif;
			?>
		<!-- /Header -->