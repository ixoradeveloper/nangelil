<?php 
/*
Template Name: Blog
*/
get_header();
?>
<div class="theme-page relative">
	<div class="vc_row wpb_row vc_row-fluid page-header vertical-align-table full-width">
		<div class="vc_row wpb_row vc_inner vc_row-fluid">
			<div class="page-header-left">
				<?php
				if(is_archive())
				{
					if(is_day())
						$archive_header = __("Daily archives: ", 'medicenter') . get_the_date(); 
					else if(is_month())
						$archive_header = __("Monthly archives: ", 'medicenter') . get_the_date('F, Y');
					else if(is_year())
						$archive_header = __("Yearly archives: ", 'medicenter') . get_the_date('Y');
					else
						$archive_header = "Archives";
				}
				?>
				<h1 class="page-title"><?php echo (is_category() || is_archive() ? (is_category() ? single_cat_title("", false) : $archive_header) : get_the_title());?></h1>
				<ul class="bread-crumb">
					<li>
						<a href="<?php echo esc_url(get_home_url()); ?>" title="<?php esc_attr_e('Home', 'medicenter'); ?>">
							<?php _e('Home', 'medicenter'); ?>
						</a>
					</li>
					<li class="separator template-arrow-horizontal-1">
						&nbsp;
					</li>
					<li>
						<?php echo (is_category() || is_archive() ? (is_category() ? single_cat_title("", false) : $archive_header) : get_the_title());?>
					</li>
				</ul>
			</div>
			<?php
			if(is_category() || is_archive())
			{
				/*get page with blog template set*/
				$post_template_page_array = get_pages(array(
					'post_type' => 'page',
					'post_status' => 'publish',
					'number' => 1,
					'meta_key' => '_wp_page_template',
					'meta_value' => 'template-blog.php',
					'sort_order' => 'ASC',
					'sort_column' => 'menu_order',
				));
				if(count($post_template_page_array))
				{
					$post_template_page = $post_template_page_array[0];
					$sidebar = get_post(get_post_meta($post_template_page->ID, "page_sidebar_header", true));
				}
			}
			else
				$sidebar = get_post(get_post_meta(get_the_ID(), "page_sidebar_header", true));
			if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name)):
			?>
			<div class="page-header-right<?php echo ((int)get_post_meta($sidebar->ID, "hide_on_mobiles", true) ? ' hide-on-mobiles' : ''); ?>">
				<?php
					dynamic_sidebar($sidebar->post_name);
				?>
			</div>
			<?php
			endif;
			?>
		</div>
	</div>
	<div class="clearfix">
		<?php
		if(is_category() || is_archive())
		{
			if(function_exists("vc_map"))
			{
				if(count($post_template_page_array) && isset($post_template_page))
				{
					$vcBase = new Vc_Base();
					$vcBase->addShortcodesCustomCss($post_template_page->ID);
					echo wpb_js_remove_wpautop(apply_filters('the_content', $post_template_page->post_content));
					global $post;
					$post = $post_template_page;
					setup_postdata($post);
				}
				else
					echo wpb_js_remove_wpautop(apply_filters('the_content', '[vc_row el_position="first last"][vc_column width="2/3"][blog mc_pagination="1" items_per_page="' . esc_attr(get_option('posts_per_page')) . '" layout_type="1" ids="-" category="-" order_by="date" show_post_title="1" read_more="1" show_post_categories="1" show_post_author="1" show_post_comments_box="1" show_post_comments_label="1" post_date_animation="slideRight" post_comments_animation="slideUp" post_comments_animation_duration="300" post_comments_animation_delay="500" show_post_date_footer="0" show_post_comments_footer="0" top_margin="page-margin-top-section" el_position="first last"][/vc_column][vc_column width="1/3"][vc_widget_sidebar top_margin="page-margin-top-section" sidebar_id="sidebar-blog" el_position="first"][box_header title="Photostream" bottom_border="1" animation="1" top_margin="page-margin-top"][photostream images="21,15,16,17,18,19,1817,1815" images_loop="1"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-blog-2" el_position="last"][/vc_column][/vc_row]'));
			}
			else
			{
				mc_get_theme_file("/shortcodes/blog.php");
				echo do_shortcode(apply_filters('the_content', '<div class="vc_row wpb_row vc_row-fluid"><div class="vc_col-sm-12 wpb_column vc_column_container">[blog]</div></div>'));
			}
		}
		else
		{
			if(have_posts()) : while (have_posts()) : the_post();
				the_content();
			endwhile; endif;
		}
		?>
	</div>		
</div>
<?php
get_footer(); 
?>