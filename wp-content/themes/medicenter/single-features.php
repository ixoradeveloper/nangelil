<?php
/*
Template Name: Single features
*/
get_header();
/*get page with single post template set*/
$post_template_page_array = get_pages(array(
	'post_type' => 'page',
	'post_status' => 'publish',
	//'number' => 1,
	'meta_key' => '_wp_page_template',
	'meta_value' => 'single-features.php',
	'hierarchical' => false
));
if(count($post_template_page_array))
{
	$post_template_page_array = array_values($post_template_page_array);
	$post_template_page = $post_template_page_array[0];
}
?>
<div class="theme-page relative">
	<div class="vc_row wpb_row vc_row-fluid page-header vertical-align-table full-width">
		<div class="vc_row wpb_row vc_inner vc_row-fluid">
			<div class="page-header-left">
				<h1 class="page-title"><?php the_title(); ?></h1>
				<ul class="bread-crumb">
					<li>
						<a href="<?php echo esc_url(get_home_url()); ?>" title="<?php esc_attr_e('Home', 'medicenter'); ?>">
							<?php _e('Home', 'medicenter'); ?>
						</a>
					</li>
					<?php
					if(count($post_template_page_array) && isset($post_template_page))
					{
						$parent_id = wp_get_post_parent_id($post_template_page->ID);
						if($parent_id)
						{
							$parent = get_post($parent_id);
							?>
							<li class="separator template-arrow-horizontal-1">
								&nbsp;
							</li>
							<li>
								<a href="<?php echo esc_url(get_permalink($parent)); ?>" title="<?php echo esc_attr($parent->post_title); ?>">
									<?php echo esc_html($parent->post_title); ?>
								</a>
							</li>
							<?php
						}
					}
					?>
					<li class="separator template-arrow-horizontal-1">
						&nbsp;
					</li>
					<li>
						<?php the_title(); ?>
					</li>
				</ul>
			</div>
			<?php
			if(count($post_template_page_array) && isset($post_template_page))
			{
				$sidebar = get_post(get_post_meta($post_template_page->ID, "page_sidebar_header", true));
				if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name)):
				?>
				<div class="page-header-right<?php echo ((int)get_post_meta($sidebar->ID, "hide_on_mobiles", true) ? ' hide-on-mobiles' : ''); ?>">
					<?php
					dynamic_sidebar($sidebar->post_name);
					?>
				</div>
				<?php
				endif;
			}
			?>
		</div>
	</div>
	<div class="clearfix">
		<?php
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
				echo wpb_js_remove_wpautop(apply_filters('the_content', '[vc_row el_position="first last"][vc_column width="2/3"][single_post featured_image_size="mc_blog-post-thumb" columns="2" show_post_title="1" show_post_featured_image="1" show_post_categories="0" show_post_author="0" comments="0" show_post_date_box="0" show_post_comments_box="0" show_post_comments_label="0" top_margin="page-margin-top-section" el_position="first last"][/vc_column][vc_column width="1/3"][box_header title="Features" bottom_border="1" animation="0" top_margin="page-margin-top-section" el_position="first"][features ids="964,963,965,966" headers="0" headers_links="1" read_more="1" icon_links="1" top_margin="page-margin-top"][vc_widget_sidebar top_margin="page-margin-top" sidebar_id="sidebar-departments-2" el_position="last"][/vc_column][/vc_row]'));
		}
		else
		{
			mc_get_theme_file("/shortcodes/single-post.php");
			echo do_shortcode(apply_filters('the_content', '<div class="vc_row wpb_row vc_row-fluid"><div class="vc_col-sm-12 wpb_column vc_column_container">[single_post]</div></div>'));
		}
		?>
	</div>
</div>
<?php
get_footer();
?>