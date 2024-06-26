<?php
class mc_home_box_widget extends WP_Widget 
{
	/** constructor */
    function __construct()
	{
		$widget_options = array(
			'classname' => 'mc-home-box-widget',
			'description' => __('Displays Box with some content', 'medicenter')
		);
		$control_options = array('width' => 430);
        parent::__construct('medicenter_home_box', __('Home Box', 'medicenter'), $widget_options, $control_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
        extract($args);

		//these are our widget options
		$title = isset($instance['title']) ? $instance['title'] : "";
		$title_color = isset($instance['title_color']) ? $instance['title_color'] : "";
		$color = isset($instance['color']) ? $instance['color'] : "";
		$custom_color = (!empty($instance['custom_color']) ? $instance['custom_color'] : "");
		$width = isset($instance['width']) ? $instance['width'] : "";
		$content = isset($instance['content']) ? $instance['content'] : "";
		$text_color = isset($instance['text_color']) ? $instance['text_color'] : "";
		$more_button_url = isset($instance['more_button_url']) ? $instance['more_button_url'] : "";
		$more_button_label = isset($instance['more_button_label']) ? $instance['more_button_label'] : "";
		$button_target = isset($instance['button_target']) ? $instance['button_target'] : "";
		$button_style = isset($instance['button_style']) ? $instance['button_style'] : "";
		$button_text_color = isset($instance['button_text_color']) ? $instance['button_text_color'] : "";
		$button_hover_text_color = isset($instance['button_hover_text_color']) ? $instance['button_hover_text_color'] : "";
		$button_color = isset($instance['button_color']) ? $instance['button_color'] : "";
		$button_custom_color = isset($instance['button_custom_color']) ? $instance['button_custom_color'] : "";
		$button_hover_color = isset($instance['button_hover_color']) ? $instance['button_hover_color'] : "";
		$button_custom_hover_color = isset($instance['button_custom_hover_color']) ? $instance['button_custom_hover_color'] : "";
		$animation = isset($instance['animation']) ? $instance['animation'] : "";
		$animation_duration = isset($instance['animation_duration']) ? $instance['animation_duration'] : "";
		$animation_delay = isset($instance['animation_delay']) ? $instance['animation_delay'] : "";

		echo $before_widget;
		?>
		<li class="home-box-container clearfix<?php echo ($animation!='' ? ' animated-element animation-' . esc_attr($animation) . ((int)$animation_duration>0 && (int)$animation_duration!=600 ? ' duration-' . (int)esc_attr($animation_duration) : '') . ((int)$animation_delay>0 ? ' delay-' . (int)esc_attr($animation_delay) : '') : ''); ?>"<?php echo ($custom_color!="" || (int)$width>0 ? ' style="' . ($custom_color!="" ? 'background-color: #' . esc_attr($custom_color) . ';' : '') . ((int)$width>0!="" ? ($custom_color!="" ? ' ' : '') . 'width: ' . esc_attr($width) . 'px;' : '') . '"' : ''); ?>>
			<div class="home-box">
				<?php
				if($title) 
				{
					if($title_color!="")
						$before_title = str_replace(">", " style='color: #" . esc_attr($title_color) . ";'>",$before_title);
					echo $before_title . apply_filters("widget_title", $title) . $after_title;
				}
				?>
				<div class="news clearfix">
					<?php if($content!=""):	?>
					<div class="text"<?php echo ($text_color!="" ? " style='color: #" . esc_attr($text_color) . ";'" : ""); ?>>	
					<?php echo do_shortcode(apply_filters("widget_text", $content)); ?>
					</div>
					<?php endif; ?>
					<?php if($more_button_url!=""):
					$href = esc_attr($more_button_url);
					$title = esc_attr($more_button_label);
					$target = ($button_target=='new_window' ? ' target="_blank"' : '');
					$button_text_color = '#' . ($button_text_color!='' ? $button_text_color : 'FFFFFF');
					$button_hover_text_color = '#' . ($button_hover_text_color!='' ? $button_hover_text_color : '000000');
					$button_color = ($button_color!='transparent' ? '#' : '') . ($button_custom_color!='' ? $button_custom_color : $button_color);
					$button_hover_color = ($button_hover_color!='transparent' ? '#' : '') . ($button_custom_hover_color!='' ? $button_custom_hover_color : $button_hover_color);
					
					echo '<a' . (!empty($button_style) && $button_style=="custom" ? ($button_color!="" || $button_text_color!="" ? ' style="' . ($button_color!="" ? 'background-color:' . esc_attr($button_color) . ';border-color:' . esc_attr($button_color) . ';' : '') . ($button_text_color!="" ? 'color:' . esc_attr($button_text_color) . ';': '') . '"' : '') . ($button_hover_color!="" || $button_hover_text_color!="" ? ' onMouseOver="' . ($button_hover_color!="" ? 'this.style.backgroundColor=\''.esc_attr($button_hover_color).'\';this.style.borderColor=\''.esc_attr($button_hover_color).'\';' : '' ) . ($button_hover_text_color!="" ? 'this.style.color=\''.esc_attr($button_hover_text_color).'\';' : '' ) . '" onMouseOut="' . ($button_hover_color!="" ? 'this.style.backgroundColor=\''.esc_attr($button_color).'\';this.style.borderColor=\''.esc_attr($button_color).'\';' : '' ) . ($button_hover_text_color!="" ? 'this.style.color=\''.esc_attr($button_text_color).'\';' : '') . '"' : '') : '') . ' title="'.esc_attr($title).'" href="'.esc_url($href).'"'.esc_attr($target).' class="mc-button more template-arrow-horizontal-1-after' . (!empty($button_style) && $button_style!="custom" ? ' ' . esc_attr($button_style) : '') . '">'.$title.'</a>';
					endif; ?>
				</div>
			</div>
		</li>
		<?php
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? $new_instance['title'] : "";
		$instance['title_color'] = isset($new_instance['title_color']) ? strip_tags($new_instance['title_color']) : "";
		$instance['color'] = isset($new_instance['color']) ? strip_tags($new_instance['color']) : "";
		$instance['custom_color'] = isset($new_instance['custom_color']) ? strip_tags($new_instance['custom_color']) : "";
		$instance['width'] = isset($new_instance['width']) ? strip_tags($new_instance['width']) : "";
		$instance['content'] = isset($new_instance['content']) ? $new_instance['content'] : "";
		$instance['text_color'] = isset($new_instance['text_color']) ? strip_tags($new_instance['text_color']) : "";
		$instance['more_button_url'] = isset($new_instance['more_button_url']) ? strip_tags($new_instance['more_button_url']) : "";
		$instance['more_button_label'] = isset($new_instance['more_button_label']) ? strip_tags($new_instance['more_button_label']) : "";
		$instance['button_target'] = isset($new_instance['button_target']) ? strip_tags($new_instance['button_target']) : "";
		$instance['button_style'] = isset($new_instance['button_style']) ? strip_tags($new_instance['button_style']) : "";
		$instance['button_text_color'] = isset($new_instance['button_text_color']) ? strip_tags($new_instance['button_text_color']) : "";
		$instance['button_hover_text_color'] = isset($new_instance['button_hover_text_color']) ? strip_tags($new_instance['button_hover_text_color']) : "";
		$instance['button_color'] = isset($new_instance['button_color']) ? strip_tags($new_instance['button_color']) : "";
		$instance['button_custom_color'] = isset($new_instance['button_custom_color']) ? strip_tags($new_instance['button_custom_color']) : "";
		$instance['button_hover_color'] = isset($new_instance['button_hover_color']) ? strip_tags($new_instance['button_hover_color']) : "";
		$instance['button_custom_hover_color'] = isset($new_instance['button_custom_hover_color']) ? strip_tags($new_instance['button_custom_hover_color']) : "";
		$instance['animation'] = isset($new_instance['animation']) ? strip_tags($new_instance['animation']) : "";
		$instance['animation_duration'] = isset($new_instance['animation_duration']) ? strip_tags($new_instance['animation_duration']) : "";
		$instance['animation_delay'] = isset($new_instance['title_color']) ? strip_tags($new_instance['animation_delay']) : "";
		
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{
		if(!isset($instance["button_style"])):
		?>
			<input type="hidden" id="widget-home-box-button_style_id" value="<?php echo esc_attr($this->get_field_id('button_style')); ?>">
		<?php
		endif;
		$title = isset($instance['title']) ? esc_attr($instance['title']) : "";
		$title_color = isset($instance['title_color']) ? esc_attr($instance['title_color']) : "";
		$color = isset($instance['color']) ? esc_attr($instance['color']) : "";
		$custom_color = isset($instance['custom_color']) ? esc_attr($instance['custom_color']) : "";
		$width = isset($instance['title']) ? (int)($instance['width']) : "";
		$content = isset($instance['content']) ? $instance['content'] : "";
		$text_color = isset($instance['text_color']) ? esc_attr($instance['text_color']) : "";
		$more_button_url = isset($instance['more_button_url']) ? esc_attr($instance['more_button_url']) : "";
		$more_button_label = isset($instance['more_button_label']) ? esc_attr($instance['more_button_label']) : "";
		$button_target = isset($instance['button_target']) ? esc_attr($instance['button_target']) : "";
		$button_style = isset($instance['button_style']) ? esc_attr($instance['button_style']) : "";
		$button_text_color = isset($instance['button_text_color']) ? esc_attr($instance['button_text_color']) : "";
		$button_hover_text_color = isset($instance['button_hover_text_color']) ? esc_attr($instance['button_hover_text_color']) : "";
		$button_color = isset($instance['button_color']) ? esc_attr($instance['button_color']) : "";
		$button_custom_color = isset($instance['button_custom_color']) ? esc_attr($instance['button_custom_color']) : "";
		$button_hover_color = isset($instance['button_hover_color']) ? esc_attr($instance['button_hover_color']) : "";
		$button_custom_hover_color = isset($instance['button_custom_hover_color']) ? esc_attr($instance['button_custom_hover_color']) : "";
		$animation = isset($instance['animation']) ? esc_attr($instance['animation']) : "";
		$animation_duration = isset($instance['animation_duration']) ? esc_attr($instance['animation_duration']) : "";
		$animation_delay = isset($instance['animation_delay']) ? esc_attr($instance['animation_delay']) : "";
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title_color')); ?>"><?php _e('Title color', 'medicenter'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($title_color!="" ? esc_attr($title_color) : 'FFFFFF'); ?>;"></span>
			<input class="regular-text color" id="<?php echo esc_attr($this->get_field_id('title_color')); ?>" name="<?php echo esc_attr($this->get_field_name('title_color')); ?>" type="text" value="<?php echo esc_attr($title_color); ?>" data-default-color="FFFFFF" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('color')); ?>"><?php _e('Color', 'medicenter'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('color')); ?>" name="<?php echo esc_attr($this->get_field_name('color')); ?>">
				<option value=""<?php echo (empty($color) ? ' selected="selected"' : ''); ?>><?php _e('default', 'medicenter'); ?></option>
				<option value="42b3e5"<?php echo ($color=="42b3e5" ? ' selected="selected"' : ''); ?>><?php _e('light blue', 'medicenter'); ?></option>
				<option value="0384ce"<?php echo ($color=="0384ce" ? ' selected="selected"' : ''); ?>><?php _e('blue', 'medicenter'); ?></option>
				<option value="3156a3"<?php echo ($color=="3156a3" ? ' selected="selected"' : ''); ?>><?php _e('dark blue', 'medicenter'); ?></option>
				<option value="000000"<?php echo ($color=="000000" ? ' selected="selected"' : ''); ?>><?php _e('black', 'medicenter'); ?></option>
				<option value="aaaaaa"<?php echo ($color=="aaaaaa" ? ' selected="selected"' : ''); ?>><?php _e('gray', 'medicenter'); ?></option>
				<option value="444444"<?php echo ($color=="444444" ? ' selected="selected"' : ''); ?>><?php _e('dark gray', 'medicenter'); ?></option>
				<option value="cccccc"<?php echo ($color=="cccccc" ? ' selected="selected"' : ''); ?>><?php _e('light gray', 'medicenter'); ?></option>
				<option value="43a140"<?php echo ($color=="43a140" ? ' selected="selected"' : ''); ?>><?php _e('green', 'medicenter'); ?></option>
				<option value="008238"<?php echo ($color=="008238" ? ' selected="selected"' : ''); ?>><?php _e('dark green', 'medicenter'); ?></option>
				<option value="7cba3d"<?php echo ($color=="7cba3d" ? ' selected="selected"' : ''); ?>><?php _e('light green', 'medicenter'); ?></option>
				<option value="f17800"<?php echo ($color=="f17800" ? ' selected="selected"' : ''); ?>><?php _e('orange', 'medicenter'); ?></option>
				<option value="cb451b"<?php echo ($color=="cb451b" ? ' selected="selected"' : ''); ?>><?php _e('dark orange', 'medicenter'); ?></option>
				<option value="ffa800"<?php echo ($color=="ffa800" ? ' selected="selected"' : ''); ?>><?php _e('light orange', 'medicenter'); ?></option>
				<option value="db5237"<?php echo ($color=="db5237" ? ' selected="selected"' : ''); ?>><?php _e('red', 'medicenter'); ?></option>
				<option value="c03427"<?php echo ($color=="c03427" ? ' selected="selected"' : ''); ?>><?php _e('dark red', 'medicenter'); ?></option>
				<option value="f37548"<?php echo ($color=="f37548" ? ' selected="selected"' : ''); ?>><?php _e('light red', 'medicenter'); ?></option>
				<option value="0097b5"<?php echo ($color=="0097b5" ? ' selected="selected"' : ''); ?>><?php _e('turquoise', 'medicenter'); ?></option>
				<option value="006688"<?php echo ($color=="006688" ? ' selected="selected"' : ''); ?>><?php _e('dark turquoise', 'medicenter'); ?></option>
				<option value="00b6cc"<?php echo ($color=="00b6cc" ? ' selected="selected"' : ''); ?>><?php _e('light turquoise', 'medicenter'); ?></option>
				<option value="6969b3"<?php echo ($color=="6969b3" ? ' selected="selected"' : ''); ?>><?php _e('violet', 'medicenter'); ?></option>
				<option value="3e4c94"<?php echo ($color=="3e4c94" ? ' selected="selected"' : ''); ?>><?php _e('dark violet', 'medicenter'); ?></option>
				<option value="9187c4"<?php echo ($color=="9187c4" ? ' selected="selected"' : ''); ?>><?php _e('light violet', 'medicenter'); ?></option>
				<option value="ffffff"<?php echo ($color=="ffffff" ? ' selected="selected"' : ''); ?>><?php _e('white', 'medicenter'); ?></option>
				<option value="fec110"<?php echo ($color=="fec110" ? ' selected="selected"' : ''); ?>><?php _e('yellow', 'medicenter'); ?></option>
			</select>
			<?php _e('or pick custom one: ', 'medicenter');?>
			<span class="color_preview" style="background-color: #<?php echo ($custom_color!="" ? esc_attr($custom_color) : '42b3e5'); ?>;"></span>
			<input type="text" class="regular-text color" value="<?php echo esc_attr($custom_color); ?>" id="<?php echo esc_attr($this->get_field_id('custom_color')); ?>" name="<?php echo esc_attr($this->get_field_name('custom_color')); ?>" data-default-color="42b3e5">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('width')); ?>"><?php _e('Custom width (in px)', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('width')); ?>" name="<?php echo esc_attr($this->get_field_name('width')); ?>" type="text" value="<?php echo ((int)$width>0 ? esc_attr($width) : ''); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php _e('Content', 'medicenter'); ?></label>
			<textarea rows="10" class="widefat" id="<?php echo esc_attr($this->get_field_id('content')); ?>" name="<?php echo esc_attr($this->get_field_name('content')); ?>"><?php echo $content; ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('text_color')); ?>"><?php _e('Content text color', 'medicenter'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($text_color!="" ? esc_attr($text_color) : 'FFFFFF'); ?>;"></span>
			<input class="regular-text color" id="<?php echo esc_attr($this->get_field_id('text_color')); ?>" name="<?php echo esc_attr($this->get_field_name('text_color')); ?>" type="text" value="<?php echo esc_attr($text_color); ?>" data-default-color="FFFFFF" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('more_button_url')); ?>"><?php _e('Button url', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('more_button_url')); ?>" name="<?php echo esc_attr($this->get_field_name('more_button_url')); ?>" type="text" value="<?php echo esc_attr($more_button_url); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('more_button_label')); ?>"><?php _e('Button label', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('more_button_label')); ?>" name="<?php echo esc_attr($this->get_field_name('more_button_label')); ?>" type="text" value="<?php echo esc_attr($more_button_label); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('button_target')); ?>"><?php _e('Button target', 'medicenter'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('button_target')); ?>" name="<?php echo esc_attr($this->get_field_name('button_target')); ?>">
				<option value="same_window"<?php echo ($button_target=="same_window" ? ' selected="selected"' : ''); ?>><?php _e('Same window', 'medicenter'); ?></option>
				<option value="new_window"<?php echo ($button_target=="new_window" ? ' selected="selected"' : ''); ?>><?php _e('New window', 'medicenter'); ?></option>
			</select>	
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('button_style')); ?>"><?php _e('Button style', 'medicenter'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('button_style')); ?>" name="<?php echo esc_attr($this->get_field_name('button_style')); ?>">
				<option value="light"<?php echo (empty($button_style) || $button_style=="light" ? ' selected="selected"' : ''); ?>><?php _e('Light', 'medicenter'); ?></option>
				<option value="light-color"<?php echo ($button_style=="light-color" ? ' selected="selected"' : ''); ?>><?php _e('Light color', 'medicenter'); ?></option>
				<option value="dark-color"<?php echo ($button_style=="dark-color" ? ' selected="selected"' : ''); ?>><?php _e('Dark color', 'medicenter'); ?></option>
				<option value="custom"<?php echo ($button_style=="custom" ? ' selected="selected"' : ''); ?>><?php _e('Custom...', 'medicenter'); ?></option>
			</select>	
		</p>
		<p class="custom-color-row"<?php echo (empty($button_style) || $button_style!="custom" ? ' style="display: none;"' : ''); ?>>
			<label for="<?php echo esc_attr($this->get_field_id('button_text_color')); ?>"><?php _e('Button text color', 'medicenter'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($button_text_color!="" ? esc_attr($button_text_color) : 'FFFFFF'); ?>;"></span>
			<input type="text" class="regular-text color" value="<?php echo esc_attr($button_text_color); ?>" id="<?php echo esc_attr($this->get_field_id('button_text_color')); ?>" name="<?php echo esc_attr($this->get_field_name('button_text_color')); ?>" data-default-color="FFFFFF">
		</p>
		<p class="custom-color-row"<?php echo (empty($button_style) || $button_style!="custom" ? ' style="display: none;"' : ''); ?>>
			<label for="<?php echo esc_attr($this->get_field_id('button_hover_text_color')); ?>"><?php _e('Button hover text color', 'medicenter'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($button_hover_text_color!="" ? esc_attr($button_hover_text_color) : '000000'); ?>;"></span>
			<input type="text" class="regular-text color" value="<?php echo esc_attr($button_hover_text_color); ?>" id="<?php echo esc_attr($this->get_field_id('button_hover_text_color')); ?>" name="<?php echo esc_attr($this->get_field_name('button_hover_text_color')); ?>" data-default-color="000000">
		</p>
		<p class="custom-color-row"<?php echo (empty($button_style) || $button_style!="custom" ? ' style="display: none;"' : ''); ?>>
			<label for="<?php echo esc_attr($this->get_field_id('button_color')); ?>"><?php _e('Button bg color', 'medicenter'); ?></label><br>
			<select id="<?php echo esc_attr($this->get_field_id('button_color')); ?>" name="<?php echo esc_attr($this->get_field_name('button_color')); ?>">
				<option value="transparent"<?php echo ($button_color=="transparent" ? ' selected="selected"' : ''); ?>><?php _e('transparent', 'medicenter'); ?></option>
				<option value="42b3e5"<?php echo ($button_color=="42b3e5" ? ' selected="selected"' : ''); ?>><?php _e('light blue', 'medicenter'); ?></option>
				<option value="0384ce"<?php echo ($button_color=="0384ce" ? ' selected="selected"' : ''); ?>><?php _e('blue', 'medicenter'); ?></option>
				<option value="3156a3"<?php echo ($button_color=="3156a3" ? ' selected="selected"' : ''); ?>><?php _e('dark blue', 'medicenter'); ?></option>
				<option value="000000"<?php echo ($button_color=="000000" ? ' selected="selected"' : ''); ?>><?php _e('black', 'medicenter'); ?></option>
				<option value="aaaaaa"<?php echo ($button_color=="aaaaaa" ? ' selected="selected"' : ''); ?>><?php _e('gray', 'medicenter'); ?></option>
				<option value="444444"<?php echo ($button_color=="444444" ? ' selected="selected"' : ''); ?>><?php _e('dark gray', 'medicenter'); ?></option>
				<option value="cccccc"<?php echo ($button_color=="cccccc" ? ' selected="selected"' : ''); ?>><?php _e('light gray', 'medicenter'); ?></option>
				<option value="43a140"<?php echo ($button_color=="43a140" ? ' selected="selected"' : ''); ?>><?php _e('green', 'medicenter'); ?></option>
				<option value="008238"<?php echo ($button_color=="008238" ? ' selected="selected"' : ''); ?>><?php _e('dark green', 'medicenter'); ?></option>
				<option value="7cba3d"<?php echo ($button_color=="7cba3d" ? ' selected="selected"' : ''); ?>><?php _e('light green', 'medicenter'); ?></option>
				<option value="f17800"<?php echo ($button_color=="f17800" ? ' selected="selected"' : ''); ?>><?php _e('orange', 'medicenter'); ?></option>
				<option value="cb451b"<?php echo ($button_color=="cb451b" ? ' selected="selected"' : ''); ?>><?php _e('dark orange', 'medicenter'); ?></option>
				<option value="ffa800"<?php echo ($button_color=="ffa800" ? ' selected="selected"' : ''); ?>><?php _e('light orange', 'medicenter'); ?></option>
				<option value="db5237"<?php echo ($button_color=="db5237" ? ' selected="selected"' : ''); ?>><?php _e('red', 'medicenter'); ?></option>
				<option value="c03427"<?php echo ($button_color=="c03427" ? ' selected="selected"' : ''); ?>><?php _e('dark red', 'medicenter'); ?></option>
				<option value="f37548"<?php echo ($button_color=="f37548" ? ' selected="selected"' : ''); ?>><?php _e('light red', 'medicenter'); ?></option>
				<option value="0097b5"<?php echo ($button_color=="0097b5" ? ' selected="selected"' : ''); ?>><?php _e('turquoise', 'medicenter'); ?></option>
				<option value="006688"<?php echo ($button_color=="006688" ? ' selected="selected"' : ''); ?>><?php _e('dark turquoise', 'medicenter'); ?></option>
				<option value="00b6cc"<?php echo ($button_color=="00b6cc" ? ' selected="selected"' : ''); ?>><?php _e('light turquoise', 'medicenter'); ?></option>
				<option value="6969b3"<?php echo ($button_color=="6969b3" ? ' selected="selected"' : ''); ?>><?php _e('violet', 'medicenter'); ?></option>
				<option value="3e4c94"<?php echo ($button_color=="3e4c94" ? ' selected="selected"' : ''); ?>><?php _e('dark violet', 'medicenter'); ?></option>
				<option value="9187c4"<?php echo ($button_color=="9187c4" ? ' selected="selected"' : ''); ?>><?php _e('light violet', 'medicenter'); ?></option>
				<option value="ffffff"<?php echo ($button_color=="ffffff" ? ' selected="selected"' : ''); ?>><?php _e('white', 'medicenter'); ?></option>
				<option value="fec110"<?php echo ($button_color=="fec110" ? ' selected="selected"' : ''); ?>><?php _e('yellow', 'medicenter'); ?></option>
			</select>
			<?php _e('or pick custom one: ', 'medicenter');?>
			<span class="color_preview" style="background-color: #<?php echo ($button_custom_color!="" ? esc_attr($button_custom_color) : 'transparent'); ?>;"></span>
			<input type="text" class="regular-text color" value="<?php echo esc_attr($button_custom_color); ?>" id="<?php echo esc_attr($this->get_field_id('button_custom_color')); ?>" name="<?php echo esc_attr($this->get_field_name('button_custom_color')); ?>" data-default-color="transparent">
		</p>
		<p class="custom-color-row"<?php echo (empty($button_style) || $button_style!="custom" ? ' style="display: none;"' : ''); ?>>
			<label for="<?php echo esc_attr($this->get_field_id('button_hover_color')); ?>"><?php _e('Button hover bg color', 'medicenter'); ?></label><br>
			<select id="<?php echo esc_attr($this->get_field_id('button_hover_color')); ?>" name="<?php echo esc_attr($this->get_field_name('button_hover_color')); ?>">
				<option value="ffffff"<?php echo ($button_hover_color=="ffffff" ? ' selected="selected"' : ''); ?>><?php _e('white', 'medicenter'); ?></option>
				<option value="transparent"<?php echo ($button_color=="transparent" ? ' selected="selected"' : ''); ?>><?php _e('transparent', 'medicenter'); ?></option>
				<option value="42b3e5"<?php echo ($button_hover_color=="42b3e5" ? ' selected="selected"' : ''); ?>><?php _e('light blue', 'medicenter'); ?></option>
				<option value="0384ce"<?php echo ($button_hover_color=="0384ce" ? ' selected="selected"' : ''); ?>><?php _e('blue', 'medicenter'); ?></option>
				<option value="3156a3"<?php echo ($button_hover_color=="3156a3" ? ' selected="selected"' : ''); ?>><?php _e('dark blue', 'medicenter'); ?></option>
				<option value="000000"<?php echo ($button_hover_color=="000000" ? ' selected="selected"' : ''); ?>><?php _e('black', 'medicenter'); ?></option>
				<option value="aaaaaa"<?php echo ($button_hover_color=="aaaaaa" ? ' selected="selected"' : ''); ?>><?php _e('gray', 'medicenter'); ?></option>
				<option value="444444"<?php echo ($button_hover_color=="444444" ? ' selected="selected"' : ''); ?>><?php _e('dark gray', 'medicenter'); ?></option>
				<option value="cccccc"<?php echo ($button_hover_color=="cccccc" ? ' selected="selected"' : ''); ?>><?php _e('light gray', 'medicenter'); ?></option>
				<option value="43a140"<?php echo ($button_hover_color=="43a140" ? ' selected="selected"' : ''); ?>><?php _e('green', 'medicenter'); ?></option>
				<option value="008238"<?php echo ($button_hover_color=="008238" ? ' selected="selected"' : ''); ?>><?php _e('dark green', 'medicenter'); ?></option>
				<option value="7cba3d"<?php echo ($button_hover_color=="7cba3d" ? ' selected="selected"' : ''); ?>><?php _e('light green', 'medicenter'); ?></option>
				<option value="f17800"<?php echo ($button_hover_color=="f17800" ? ' selected="selected"' : ''); ?>><?php _e('orange', 'medicenter'); ?></option>
				<option value="cb451b"<?php echo ($button_hover_color=="cb451b" ? ' selected="selected"' : ''); ?>><?php _e('dark orange', 'medicenter'); ?></option>
				<option value="ffa800"<?php echo ($button_hover_color=="ffa800" ? ' selected="selected"' : ''); ?>><?php _e('light orange', 'medicenter'); ?></option>
				<option value="db5237"<?php echo ($button_hover_color=="db5237" ? ' selected="selected"' : ''); ?>><?php _e('red', 'medicenter'); ?></option>
				<option value="c03427"<?php echo ($button_hover_color=="c03427" ? ' selected="selected"' : ''); ?>><?php _e('dark red', 'medicenter'); ?></option>
				<option value="f37548"<?php echo ($button_hover_color=="f37548" ? ' selected="selected"' : ''); ?>><?php _e('light red', 'medicenter'); ?></option>
				<option value="0097b5"<?php echo ($button_hover_color=="0097b5" ? ' selected="selected"' : ''); ?>><?php _e('turquoise', 'medicenter'); ?></option>
				<option value="006688"<?php echo ($button_hover_color=="006688" ? ' selected="selected"' : ''); ?>><?php _e('dark turquoise', 'medicenter'); ?></option>
				<option value="00b6cc"<?php echo ($button_hover_color=="00b6cc" ? ' selected="selected"' : ''); ?>><?php _e('light turquoise', 'medicenter'); ?></option>
				<option value="6969b3"<?php echo ($button_hover_color=="6969b3" ? ' selected="selected"' : ''); ?>><?php _e('violet', 'medicenter'); ?></option>
				<option value="3e4c94"<?php echo ($button_hover_color=="3e4c94" ? ' selected="selected"' : ''); ?>><?php _e('dark violet', 'medicenter'); ?></option>
				<option value="9187c4"<?php echo ($button_hover_color=="9187c4" ? ' selected="selected"' : ''); ?>><?php _e('light violet', 'medicenter'); ?></option>
				<option value="ffffff"<?php echo ($button_hover_color=="ffffff" ? ' selected="selected"' : ''); ?>><?php _e('white', 'medicenter'); ?></option>
				<option value="fec110"<?php echo ($button_hover_color=="fec110" ? ' selected="selected"' : ''); ?>><?php _e('yellow', 'medicenter'); ?></option>
			</select>
			<?php _e('or pick custom one: ', 'medicenter');?>
			<span class="color_preview" style="background-color: #<?php echo ($button_custom_hover_color!="" ? esc_attr($button_custom_hover_color) : 'FFFFFF'); ?>;"></span>
			<input type="text" class="regular-text color" value="<?php echo esc_attr($button_custom_hover_color); ?>" id="<?php echo esc_attr($this->get_field_id('button_custom_hover_color')); ?>" name="<?php echo esc_attr($this->get_field_name('button_custom_hover_color')); ?>" data-default-color="FFFFFF">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('animation')); ?>"><?php _e('Box animation', 'medicenter'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('animation')); ?>" name="<?php echo esc_attr($this->get_field_name('animation')); ?>">
				<option value=""><?php _e('none', 'medicenter'); ?></option>
				<option value="fadeIn"<?php echo ($animation=="fadeIn" ? ' selected="selected"' : ''); ?>><?php _e('fade in', 'medicenter'); ?></option>
				<option value="scale"<?php echo ($animation=="scale" ? ' selected="selected"' : ''); ?>><?php _e('scale', 'medicenter'); ?></option>
				<option value="slideRight"<?php echo ($animation=="slideRight" ? ' selected="selected"' : ''); ?>><?php _e('slide right', 'medicenter'); ?></option>
				<option value="slideRight200"<?php echo ($animation=="slideRight200" ? ' selected="selected"' : ''); ?>><?php _e('slide right 200%', 'medicenter'); ?></option>
				<option value="slideLeft"<?php echo ($animation=="slideLeft" ? ' selected="selected"' : ''); ?>><?php _e('slide left', 'medicenter'); ?></option>
				<option value="slideLeft50"<?php echo ($animation=="slideLeft50" ? ' selected="selected"' : ''); ?>><?php _e('slide left 50%', 'medicenter'); ?></option>
				<option value="slideDown"<?php echo ($animation=="slideDown" ? ' selected="selected"' : ''); ?>><?php _e('slide down', 'medicenter'); ?></option>
				<option value="slideDown200"<?php echo ($animation=="slideDown200" ? ' selected="selected"' : ''); ?>><?php _e('slide down 200%', 'medicenter'); ?></option>
				<option value="slideUp"<?php echo ($animation=="slideUp" ? ' selected="selected"' : ''); ?>><?php _e('slide up', 'medicenter'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('animation_duration')); ?>"><?php _e('Box animation duration (in ms)', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('animation_duration')); ?>" name="<?php echo esc_attr($this->get_field_name('animation_duration')); ?>" type="text" value="<?php echo ((int)$animation_duration>0 ? esc_attr($animation_duration) : '600'); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('animation_delay')); ?>"><?php _e('Box animation delay (in ms)', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('animation_delay')); ?>" name="<?php echo esc_attr($this->get_field_name('animation_delay')); ?>" type="text" value="<?php echo ((int)$animation_delay>0 ? esc_attr($animation_delay) : '0'); ?>" />
		</p>
		<?php
	}
}
//register widget
function mc_home_box_widget_init()
{
	return register_widget("mc_home_box_widget");
}
add_action('widgets_init', 'mc_home_box_widget_init');
?>