<link rel="stylesheet" property='stylesheet' type="text/css" href="<?php echo esc_url(get_template_directory_uri()); ?>/style_selector/style_selector.css">
<?php
global $theme_options;
?>
<script type="text/javascript" src="<?php echo esc_url(get_template_directory_uri() . '/style_selector/style_selector.js'); ?>"></script>
<div class="style-selector<?php echo (isset($_COOKIE['mc_style_selector']) ? ' ' . esc_attr($_COOKIE['mc_style_selector']) : ' opened'); ?>">
	<div class="style-selector-icon">
		&nbsp;
	</div>
	<div class="style-selector-content">
		<h4><?php _e("Style Selector", 'medicenter'); ?></h4>
		<ul>
			<li class="hide-on-mobile clearfix">
				<label><?php _e("Sticky Menu:", 'medicenter'); ?></label>
				<select name="menu_type">
					<option value="1"<?php echo (!isset($_COOKIE['mc_sticky_menu']) || (int)$_COOKIE['mc_sticky_menu']==1 ? ' selected="selected"' : ''); ?>><?php _e("Yes", 'medicenter'); ?></option>
					<option value="0"<?php echo (isset($_COOKIE['mc_sticky_menu']) && (int)$_COOKIE['mc_sticky_menu']==0 ? ' selected="selected"' : ''); ?>><?php _e("No", 'medicenter'); ?></option>
				</select>
			</li>
			<li class="clearfix">
				<label><?php _e("Header Type:", 'medicenter'); ?></label>
				<select name="header_type">
					<option value="1"<?php echo (!isset($_COOKIE['mc_header_type']) || (int)$_COOKIE['mc_header_type']==1 ? ' selected="selected"' : ''); ?>><?php _e("Type 1", 'medicenter'); ?></option>
					<option value="2"<?php echo (isset($_COOKIE['mc_header_type']) && (int)$_COOKIE['mc_header_type']==2 ? ' selected="selected"' : ''); ?>><?php _e("Type 2", 'medicenter'); ?></option>
					<option value="3"<?php echo (isset($_COOKIE['mc_header_type']) && (int)$_COOKIE['mc_header_type']==3 ? ' selected="selected"' : ''); ?>><?php _e("Type 3", 'medicenter'); ?></option>
					<option value="4"<?php echo (isset($_COOKIE['mc_header_type']) && (int)$_COOKIE['mc_header_type']==4 ? ' selected="selected"' : ''); ?>><?php _e("Type 4", 'medicenter'); ?></option>
				</select>
			</li>
			<li class="hide-on-mobile clearfix">
				<label><?php _e("Layout Style:", 'medicenter'); ?></label>
				<select name="layout_style">
					<option value="fullwidth"<?php echo (!isset($_COOKIE['mc_layout']) || (isset($_COOKIE['mc_layout']) && $_COOKIE['mc_layout']=="") ? ' selected="selected"' : ''); ?>><?php _e("Full width", 'medicenter'); ?></option>
					<option value="boxed"<?php echo ((!isset($_COOKIE['mc_layout']) && $theme_options['layout']=="boxed") || (isset($_COOKIE['mc_layout']) && $_COOKIE['mc_layout']=="boxed") ? ' selected="selected"' : ''); ?>><?php _e("Boxed", 'medicenter'); ?></option>
				</select>
			</li>
			<li class="clearfix">
				<label><?php _e("Direction:", 'medicenter'); ?></label>
				<select name="style_selector_direction">
					<option value="LTR"<?php echo (!isset($_COOKIE['mc_direction']) || $_COOKIE['mc_direction']=="LTR" ? ' selected="selected"' : ''); ?>><?php _e("LTR", 'medicenter'); ?></option>
					<option value="RTL"<?php echo ((!isset($_COOKIE['mc_direction']) && $theme_options["direction"]=="rtl") || (isset($_COOKIE['mc_direction']) && $_COOKIE['mc_direction']=="RTL") ? ' selected="selected"' : ''); ?>><?php _e("RTL", 'medicenter'); ?></option>
				</select>
			</li>
			<li class="clearfix">
				<label><?php _e("Animations:", 'medicenter'); ?></label>
				<select name="style_selector_animations">
					<option value="1"<?php echo (!isset($_COOKIE['mc_animations']) || (int)$_COOKIE['mc_animations']==1 ? ' selected="selected"' : ''); ?>><?php _e("Yes", 'medicenter'); ?></option>
					<option value="0"<?php echo (isset($_COOKIE['mc_animations']) && (int)$_COOKIE['mc_animations']==0 ? ' selected="selected"' : ''); ?>><?php _e("No", 'medicenter'); ?></option>
				</select>
			</li>
			<li class="clearfix">
				<label><?php _e("Demo:", 'medicenter'); ?></label>
				<select name="style_selector_demo">
					<option value="-"><?php _e("Choose...", 'medicenter'); ?></option>
					<option value="main"><?php _e("Main", 'medicenter'); ?></option>
					<option value="pregnancy"><?php _e("Pregnancy", 'medicenter'); ?></option>
					<option value="ophthalmologist"><?php _e("Ophthalmologist", 'medicenter'); ?></option>
					<option value="veterinary"><?php _e("Veterinary", 'medicenter'); ?></option>
					<option value="dentist"><?php _e("Dentist", 'medicenter'); ?></option>
				</select>
			</li>
			<li>
				<label class="single-label"><?php _e("Main Color (examples)", 'medicenter'); ?></label>
				<ul class="layout-chooser for-main-color clearfix">
					<li<?php echo (!isset($_COOKIE['mc_main_color']) || (isset($_COOKIE['mc_main_color']) && $_COOKIE['mc_main_color']=='blue') ? ' class="selected"' : '');?>>
						<a href="#" class="color-preview" style="background-color: #42B3E5;" data-color="blue">	
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['mc_main_color']) && $_COOKIE['mc_main_color']=='green' ? ' class="selected"' : '');?>>
						<a href="#" class="color-preview" style="background-color: #7CBA3D;" data-color="green">	
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['mc_main_color']) && $_COOKIE['mc_main_color']=='orange' ? ' class="selected"' : '');?>>
						<a href="#" class="color-preview" style="background-color: #FFA800;" data-color="orange">	
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['mc_main_color']) && $_COOKIE['mc_main_color']=='red' ? ' class="selected"' : '');?>>
						<a href="#" class="color-preview" style="background-color: #F37548;" data-color="red">	
							<span class="tick"></span>
						</a>
					</li>
					<li<?php echo (isset($_COOKIE['mc_main_color']) && $_COOKIE['mc_main_color']=='turquoise' ? ' class="selected"' : '');?>>
						<a href="#" class="color-preview" style="background-color: #00B6CC;" data-color="turquoise">	
							<span class="tick"></span>
						</a>
					</li>
					<li class="last<?php echo (isset($_COOKIE['mc_main_color']) && $_COOKIE['mc_main_color']=='violet' ? ' selected' : '') . '"';?>>
						<a href="#" class="color-preview" style="background-color: #9187C4;" data-color="violet">
							<span class="tick"></span>
						</a>
					</li>
				</ul>
				<div class="align-center">
					<a href="#" class="more light small style-selector-reset-color margin-top-10"><?php _e("Reset color", 'medicenter'); ?></a>
				</div>
			</li>
		</ul>
	</div>
</div>
