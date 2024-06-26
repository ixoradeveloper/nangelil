<?php 
if(comments_open())
{
	global $terms_checkbox;
	global $terms_message;
	global $theme_options;
	?>
<div class="comment-form-container">
	<h3 class="box-header animation-slide">
		<?php _e("Leave a reply", 'medicenter'); ?>
	</h3>
	<form class="comment-form" id="comment_form" method="post" action="">
	<?php
	if(get_option('comment_registration') && !is_user_logged_in())
	{
	?>
	<p><?php printf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'medicenter' ), wp_login_url(get_permalink())); ?></p>
	<?php
	}
	else
	{
	?>
		<div class="vc_row wpb_row vc_inner">
			<fieldset class="vc_col-sm-6 wpb_column vc_column_container">
				<label class="first"><?php echo __('YOUR NAME', 'medicenter'); ?></label>
				<div class="block">
					<input name="name" type="text" value="" />
				</div>
				<label><?php echo __('YOUR EMAIL', 'medicenter'); ?></label>
				<div class="block">
					<input name="email" type="text" value="" />
				</div>
				<label><?php echo __('WEBSITE (optional)', 'medicenter'); ?></label>
				<div class="block">
					<input name="website" type="text" value="" />
				</div>
			</fieldset>
			<fieldset class="vc_col-sm-6 wpb_column vc_column_container">
				<label class="first"><?php echo __('YOUR COMMENT', 'medicenter'); ?></label>
				<div class="block">
					<textarea name="message"></textarea>
				</div>
			</fieldset>
		</div>
		<div class="vc_row wpb_row vc_inner margin-top-30 <?php echo ((int)$theme_options["google_recaptcha_comments"] ? 'fieldset-with-recaptcha' : 'align-right');?>">
			<?php
			if((int)$terms_checkbox)
			{
			?>
				<div class="terms-container block">
					<input type="checkbox" name="terms" id="comment_formterms" value="1"><label for="comment_formterms"><?php echo urldecode(base64_decode($terms_message)); ?></label>
				</div>
				<div class="recaptcha-container">
			<?php
			}
			?>
			<div class="vc_row wpb_row vc_inner<?php echo ((int)$theme_options["google_recaptcha_comments"] ? ' button-with-recaptcha' : '');?>">
				<input name="submit" type="submit" value="<?php esc_attr_e('POST COMMENT', 'medicenter'); ?>" class="more mc-button" />
				<a href="#cancel" id="cancel_comment" title="<?php esc_attr_e('CANCEL REPLY', 'medicenter'); ?>"><?php _e('CANCEL REPLY', 'medicenter'); ?></a>
			</div>
			<?php
			if((int)$theme_options["google_recaptcha_comments"])
			{
				if($theme_options["recaptcha_site_key"]!="" && $theme_options["recaptcha_secret_key"]!="")
				{
					wp_enqueue_script("google-recaptcha-v2");
					?>
					<div class="g-recaptcha-wrapper block"><div class="g-recaptcha" data-sitekey="<?php echo esc_attr($theme_options["recaptcha_site_key"]); ?>"></div></div>
					<?php
				}
				else
				{
				?>
					<p><?php _e("Error while loading reCapcha. Please set the reCaptcha keys under Theme Options in admin area", 'medicenter'); ?></p>
				<?php
				}
			}
			if((int)$terms_checkbox)
			{
			?>
			</div>
			<?php
			}
			?>
			<input type="hidden" name="action" value="theme_comment_form" />
			<input type="hidden" name="comment_parent_id" value="0" />
			<input type="hidden" name="paged" value="1" />
			<input type="hidden" name="prevent_scroll" value="0" />
		</div>
	<?php
	}
	?>
		<fieldset>
			<input type="hidden" name="post_id" value="<?php echo esc_attr(get_the_ID()); ?>" />
			<input type="hidden" name="post_type" value="<?php echo (isset($post) ? esc_attr($post->post_type) : ''); ?>" />
		</fieldset>
	</form>
</div>
<?php
}
?>