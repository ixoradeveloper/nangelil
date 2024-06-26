<?php get_header(); ?>
<div class="theme-page relative">
	<div class="vc_row wpb_row vc_row-fluid page-header vertical-align-table full-width">
		<div class="vc_row wpb_row vc_inner vc_row-fluid">
			<div class="page-header-left">
				<h1 class="page-title"><?php echo __("Latest Posts", 'medicenter'); ?></h1>
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
						<?php echo __("Latest Posts", 'medicenter');?>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="clearfix">
		<?php
		if(function_exists("vc_map"))
			echo do_shortcode(apply_filters('the_content', '[vc_row top_margin="page-margin-top" el_position="first last"][vc_column width="2/3"][box_header title="Latest News" bottom_border="1" animation="1" el_position="first"][blog mc_pagination="0" items_per_page="' . esc_attr(get_option('posts_per_page')) . '" layout_type="2" ids="-" category="-" order_by="date" show_post_title="1" read_more="0" show_post_categories="1" show_post_author="0" show_post_date_box="1" show_post_comments_box="1" show_post_comments_label="0" show_post_date_footer="0" show_post_comments_footer="0"][show_all_button title="Show all" el_position="last"][/vc_column][vc_column width="1/3"][vc_widget_sidebar sidebar_id="sidebar-home-right" el_position="first last"][/vc_column][/vc_row]'));	
		else
		{
			mc_get_theme_file("/shortcodes/blog.php");
			echo '<div class="vc_row wpb_row vc_row-fluid page-margin-top"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="wpb_wrapper"><h3 class="box-header animation-slide">' . __("Latest News", 'medicenter') . '</h3>' .
			mc_theme_blog(array(
				"mc_pagination" => 0,
				"items_per_page" => esc_attr(get_option('posts_per_page')),
				"layout_type" => 2,
				"ids" => "-",
				"category" => "-",
				"order_by" => "date",
				"show_post_title" => 1,
				"read_more" => 0,
				"show_post_categories" => 1,
				"show_post_author" => 0,
				"show_post_date_box" => 1,
				"show_post_comments_box" => 1,
				"show_post_comments_label" => 0,
				"show_post_comments_footer" => 0
			)) . '</div></div></div>';
		}
		paginate_links();
		?>
	</div>
</div>
<?php get_footer(); ?>