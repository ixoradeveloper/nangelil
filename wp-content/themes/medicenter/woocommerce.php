<?php
get_header();
global $post;
$post = get_post(get_option("woocommerce_shop_page_id"));
setup_postdata($post);
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
					<li class="separator template-arrow-horizontal-1">
						&nbsp;
					</li>
					<li>
						<?php the_title(); ?>
					</li>
				</ul>
			</div>
			<?php
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
		<div class="vc_row wpb_row vc_row-fluid page-margin-top">
			<?php
			if(is_active_sidebar('sidebar-shop'))
			{
				$sidebar = mc_get_page_by_title("Sidebar Shop", "medicenter_sidebars");
			}
			?>
			<div class="vc_col-sm-<?php echo (is_active_sidebar('sidebar-shop') && isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) ? '9' : '12'); ?> wpb_column vc_column_container ">
				<div class="wpb_wrapper">
					<?php
					if(have_posts()):
						woocommerce_content();
					endif;
					?>
				</div> 
			</div>
			<?php
			if(is_active_sidebar('sidebar-shop'))
			{
				if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true))
				{
					?>
					<div class="vc_col-sm-3 wpb_column vc_column_container<?php echo ((int)get_post_meta($sidebar->ID, "hide_on_mobiles", true) ? ' hide-on-mobiles' : ''); ?>">
						<div class="wpb_wrapper">
							<div class="wpb_widgetised_column wpb_content_element clearfix">
								<div class="wpb_wrapper">
									<?php dynamic_sidebar('sidebar-shop'); ?>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>
<?php
global $post;
$post = get_post(get_option("woocommerce_shop_page_id"));
setup_postdata($post);
get_footer(); 
?>