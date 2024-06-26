			<?php global $theme_options; 
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