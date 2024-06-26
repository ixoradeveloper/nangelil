<?php
get_header();
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
					$parent_id = wp_get_post_parent_id(get_the_ID());
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
					if(!empty(get_the_title()))
					{
					?>
					<li class="separator template-arrow-horizontal-1">
						&nbsp;
					</li>
					<li>
						<?php the_title(); ?>
					</li>
					<?php
					}
					?>
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
	<div class="clearfix<?php echo (function_exists("has_blocks") && has_blocks() ? ' has-gutenberg-blocks' : '');?>">
		<?php
		if(!function_exists("vc_map") && !has_blocks())
		{
			echo '<div class="vc_row wpb_row vc_row-fluid page-margin-top padding-bottom-70 single-page">';
		}
		if(have_posts()) : while (have_posts()) : the_post();
			the_content();
			wp_link_pages(array(
				'before' => '<div class="vc_row wpb_row vc_row-fluid">',
				'after' => '</div>'
			));
		if(!function_exists("vc_map") && !has_blocks())
		{
			echo '</div>';
		}
		endwhile; endif;
		?>
	</div>
</div>
<?php
get_footer(); 
?>