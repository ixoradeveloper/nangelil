<form class="search" action="<?php echo esc_url(get_home_url()); ?>">
	<input name="s" class="search-input template-search" type="text" value="<?php esc_attr_e('Search...', 'medicenter'); ?>" placeholder="<?php esc_attr_e('Search...', 'medicenter'); ?>" />
	<div class="search-submit-container">
		<input type="submit" class="search-submit" value="">
		<span class="template-search"></span>
	</div>
</form>