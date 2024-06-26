<?php
class mc_footer_box_widget extends WP_Widget 
{
	/** constructor */
    function __construct()
	{
		$widget_options = array(
			'classname' => 'mc-footer-box-widget',
			'description' => 'Displays Box with some content'
		);
		$control_options = array('width' => 430);
        parent::__construct('medicenter_footer_box', __('Footer Box', 'medicenter'), $widget_options, $control_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
        extract($args);

		//these are our widget options
		$title = isset($instance['title']) ? $instance['title'] : "";
		$title_color = isset($instance['title_color']) ? $instance['title_color'] : "";
		$icon = isset($instance['icon']) ? $instance['icon'] : "";
		$url = isset($instance['url']) ? $instance['url'] : "";
		$more_label = isset($instance['more_label']) ? $instance['more_label'] : "";
		$content = isset($instance['content']) ? $instance['content'] : "";
		$text_color = isset($instance['text_color']) ? $instance['text_color'] : "";
		$color = isset($instance['color']) ? $instance['color'] : "";
		$custom_color = isset($instance['custom_color']) ? $instance['custom_color'] : "";
		$animation = isset($instance['animation']) ? $instance['animation'] : "";
		$animation_duration = isset($instance['animation_duration']) ? $instance['animation_duration'] : "";
		$animation_delay = isset($instance['animation_delay']) ? $instance['animation_delay'] : "";
		echo $before_widget;
		?>
		<li class="footer-banner-box<?php echo ($icon!='' ? ' features-' . esc_attr($icon) : '') . ($animation!='' ? ' animated-element animation-' . esc_attr($animation) . ((int)$animation_duration>0 && (int)$animation_duration!=600 ? ' duration-' . (int)esc_attr($animation_duration) : '') . ((int)$animation_delay>0 ? ' delay-' . (int)esc_attr($animation_delay) : '') : ''); ?>"<?php echo ($custom_color!="" ? ' style="background-color: #' . esc_attr($custom_color) . '"' : ''); ?>>
			<?php
			if($title) 
			{
				if($title_color!="")
					$before_title = str_replace(">", " style='color: #" . esc_attr($title_color) . ";'>",$before_title);
				echo $before_title . ($url!="" ? '<a href="' . esc_attr($url) . '"' . ($title_color!="" ? ' style="color: #' . esc_attr($title_color) . ';"' : '') . ' title="' . apply_filters("widget_title", $title) . '">' : '') . apply_filters("widget_title", $title) . ($url!="" ? '</a>' : '') . $after_title;
			}
			?>
			<?php if($content!="" || $url!=""):	?>
			<p<?php echo ($icon!='' ? ' class="content-margin"' : '') . ($text_color!="" ? " style='color: #" . esc_attr($text_color) . ";'" : ""); ?>>	
			<?php 
			if($content!="")
				echo do_shortcode(apply_filters("widget_text", $content)); 
			if($url!=""): ?>
			<a title="<?php echo esc_attr($more_label); ?>" href="<?php echo esc_attr($url); ?>" class="mc-button more light icon-small-arrow template-arrow-horizontal-1-after"><?php echo $more_label; ?></a>
			<?php endif;
			endif; ?>
			</p>
		</li>
		<?php
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? strip_tags($new_instance['title']) : "";
		$instance['title_color'] = isset($new_instance['title_color']) ? strip_tags($new_instance['title_color']) : "";
		$instance['icon'] = isset($new_instance['icon']) ? strip_tags($new_instance['icon']) : "";
		$instance['url'] = isset($new_instance['url']) ? strip_tags($new_instance['url']) : "";
		$instance['more_label'] = isset($new_instance['more_label']) ? strip_tags($new_instance['more_label']) : "";
		$instance['content'] = isset($new_instance['content']) ? $new_instance['content'] : "";
		$instance['text_color'] = isset($new_instance['text_color']) ? $new_instance['text_color'] : "";
		$instance['color'] = isset($new_instance['color']) ? strip_tags($new_instance['color']) : "";
		$instance['custom_color'] = isset($new_instance['custom_color']) ? strip_tags($new_instance['custom_color']) : "";
		$instance['animation'] = isset($new_instance['animation']) ? strip_tags($new_instance['animation']) : "";
		$instance['animation_duration'] = isset($new_instance['animation_duration']) ? strip_tags($new_instance['animation_duration']) : "";
		$instance['animation_delay'] = isset($new_instance['animation_delay']) ? strip_tags($new_instance['animation_delay']) : "";
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{	
		$title = isset($instance['title']) ? esc_attr($instance['title']) : "";
		$title_color = isset($instance['title_color']) ? esc_attr($instance['title_color']) : "";
		$icon = isset($instance['icon']) ? esc_attr($instance["icon"]) : "";
		$url = isset($instance['url']) ? esc_attr($instance['url']) : "";
		$more_label = isset($instance['more_label']) ? esc_attr($instance['more_label']) : "";
		$content = isset($instance['content']) ? esc_attr($instance['content']) : "";
		$text_color = isset($instance['text_color']) ? esc_attr($instance['text_color']) : "";
		$color = isset($instance['color']) ? esc_attr($instance['color']) : "";
		$custom_color = isset($instance['custom_color']) ? esc_attr($instance['custom_color']) : "";
		$animation = isset($instance['animation']) ? esc_attr($instance['animation']) : "";
		$animation_duration = isset($instance['animation_duration']) ? esc_attr($instance['animation_duration']) : "";
		$animation_delay = isset($instance['animation_delay']) ? esc_attr($instance['animation_delay']) : "";
		$icons = array(
			"address",
			"ambulance",
			"app",
			"baby",
			"baby-bed",
			"baby-bottle",
			"bacteria",
			"balance",
			"battery",
			"book",
			"box",
			"brain",
			"briefcase",
			"burns",
			"cart",
			"cat",
			"certificate",
			"chart",
			"chat",
			"clock",
			"config",
			"credit-card",
			"cross",
			"dental-shield",
			"dentist",
			"diary",
			"dna",
			"doctor",
			"document",
			"document-missing",
			"dog",
			"drip",
			"ear",
			"email",
			"eye",
			"facebook",
			"first-aid",
			"fitness",
			"frostbite",
			"gallery",
			"glasses",
			"graph",
			"healthcare",
			"heart",
			"heart-beat",
			"home",
			"hospital",
			"id",
			"image",
			"keyboard",
			"lab",
			"laptop",
			"leaf",
			"lifeline",
			"list",
			"location",
			"lock",
			"map",
			"medical-bed",
			"medical-cast",
			"medical-cross",
			"medical-document",
			"medical-results",
			"medical-scissors",
			"medical-staff",
			"minus",
			"mobile",
			"molecule",
			"money",
			"mortar",
			"movie",
			"network",
			"paypal",
			"pen",
			"people",
			"pet-box",
			"phone",
			"piano",
			"pill",
			"pin",
			"plaster",
			"play",
			"plus",
			"printer",
			"pulse",
			"quote",
			"science",
			"screen",
			"signpost",
			"spa",
			"spa-bamboo",
			"spa-lotion",
			"speaker",
			"stethoscope",
			"syringe",
			"tablet",
			"tags",
			"teddy-bear",
			"test-tube",
			"tick",
			"time",
			"toothbrush",
			"twitter",
			"video",
			"wallet",
			"x-ray"
		);
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
			<label for="<?php echo esc_attr($this->get_field_id('icon')); ?>"><?php _e('Icon', 'medicenter'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('icon')); ?>" name="<?php echo esc_attr($this->get_field_name('icon')); ?>">
				<option value="">-</option>
				<?php for($i=0; $i<count($icons); $i++)
				{
				?>
				<option value="<?php echo esc_attr($icons[$i]); ?>"<?php echo (isset($icon) && $icons[$i]==$icon ? " selected='selected'" : "") ?>><?php echo $icons[$i]; ?></option>
				<?php
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php _e('Content', 'medicenter'); ?></label>
			<textarea rows="10" class="widefat" id="<?php echo esc_attr($this->get_field_id('content')); ?>" name="<?php echo esc_attr($this->get_field_name('content')); ?>"><?php echo $content; ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('text_color')); ?>"><?php _e('Text color', 'medicenter'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($text_color!="" ? esc_attr($text_color) : 'FFFFFF'); ?>;"></span>
			<input class="regular-text color" id="<?php echo esc_attr($this->get_field_id('text_color')); ?>" name="<?php echo esc_attr($this->get_field_name('text_color')); ?>" type="text" value="<?php echo esc_attr($text_color); ?>" data-default-color="FFFFFF" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('url')); ?>"><?php _e('More link url', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('url')); ?>" name="<?php echo esc_attr($this->get_field_name('url')); ?>" type="text" value="<?php echo esc_attr($url); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('more_label')); ?>"><?php _e('More link label', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('more_label')); ?>" name="<?php echo esc_attr($this->get_field_name('more_label')); ?>" type="text" value="<?php echo esc_attr($more_label); ?>" />
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
function mc_footer_box_widget_init()
{
	return register_widget("mc_footer_box_widget");
}
add_action('widgets_init', 'mc_footer_box_widget_init');
?>