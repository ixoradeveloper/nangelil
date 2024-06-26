<?php
class mc_departments_widget extends WP_Widget 
{
	/** constructor */
    function __construct()
	{
		$widget_options = array(
			'classname' => 'mc-departments-widget',
			'description' => 'Displays Departments Accordion'
		);
		$control_options = array('width' => 460);
        parent::__construct('medicenter_departments', __('Departments Accordion', 'medicenter'), $widget_options, $control_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance) 
	{
		global $themename;
        extract($args);

		//these are our widget options
		$title = isset($instance['title']) ? $instance['title'] : "";
		$animation = isset($instance['animation']) ? $instance['animation'] : "";
		$order = isset($instance['order']) ? $instance['order'] : "";
		$categories = isset($instance['categories']) ? $instance['categories'] : "";
		$departments_page = isset($instance['departments_page']) ? $instance['departments_page'] : "";
		$timetable_page = isset($instance['timetable_page']) ? $instance['timetable_page'] : "";
		$active = isset($instance['active']) ? $instance['active'] : "";
		$tab_color = (isset($instance['tab_custom_color']) && $instance['tab_custom_color']!="" ? $instance['tab_custom_color'] : $instance['tab_color']);
		$button_style = isset($instance['button_style']) ? $instance['button_style'] : "";
		$button_color = isset($instance['button_color']) ? $instance['button_color'] : "";
		$button_custom_color = isset($instance['button_custom_color']) ? $instance['button_custom_color'] : "";
		$button_hover_color = isset($instance['button_hover_color']) ? $instance['button_hover_color'] : "";
		$button_custom_hover_color = isset($instance['button_hover_custom_color']) ? $instance['button_hover_custom_color'] : "";
		$button_border_color = $button_color;
		$button_hover_border_color = $button_hover_color;
		$button_text_color = isset($instance['button_text_color']) ? $instance['button_text_color'] : "";
		$button_hover_text_color = isset($instance['button_hover_text_color']) ? $instance['button_hover_text_color'] : "";
		
		$button_text_color = '#' . ($button_text_color!='' ? $button_text_color : '666666');
		$button_hover_text_color = '#' . ($button_hover_text_color!='' ? $button_hover_text_color : 'FFFFFF');
		$button_color = ($button_color!='transparent' ? '#' : '') . ($button_custom_color!='' ? $button_custom_color : $button_color);
		$button_hover_color = ($button_hover_color!='transparent' ? '#' : '') . ($button_custom_hover_color!='' ? $button_custom_hover_color : $button_hover_color);

		echo $before_widget;
		
		query_posts(array( 
			'post_type' => 'departments',
			'posts_per_page' => '-1',
			'post_status' => 'publish',
			'orderby' => 'menu_order', 
			'order' => $order,
			'departments_category' => implode(",", (array)$categories),
		));

		$output = '';
		if($title) 
		{
			$output .= ((int)$animation ? str_replace("box-header", "box-header animation-slide", $before_title) : str_replace("animation-slide", "", $before_title)) . apply_filters("widget_title", $title) . $after_title;
		}
		if(have_posts()):
			if($tab_color!="")
			{
				$output .= '<style type="text/css">
					#' . $this->id . ' .accordion .ui-accordion-header.ui-state-hover h3
					{
						color: #' . $tab_color . ';
					}
					#' . $this->id . ' .accordion .ui-accordion-header.ui-state-active
					{
						background: #' . $tab_color . ';
						border-color: #' . $tab_color . ';
					}
				</style>';
			}
			$output .= '<ul class="accordion" data-active-tab="'.esc_attr($active).'">';
			while(have_posts()): the_post();
				global $post;
				$output .= '<li>
					<div id="accordion-' . urldecode($post->post_name) . '">
						<h3 class="template-plus-2-after">' . get_the_title() . '</h3>
					</div>
					<div class="clearfix">
						<div class="item-content clearfix">';
							if(has_post_thumbnail())
								$output .= '<a class="thumb-image" href="' . esc_url(get_permalink($departments_page) . '#' . urldecode($post->post_name)) . '" title="' . esc_attr(get_the_title()) . '">
									' . get_the_post_thumbnail(get_the_ID(), $themename . "-small-thumb", array("alt" => get_the_title(), "title" => "")) . '
								</a>';
				$output .= apply_filters('the_excerpt', get_the_excerpt()) . '
						</div>
						<div class="item-footer clearfix">
							<a' . (!empty($button_style) && $button_style=="custom" ? ($button_color!="" || $button_text_color!="" ? ' style="' . ($button_color!="" ? 'background-color:' . esc_attr($button_color) . ';border-color:' . esc_attr($button_color) . ';' : '') . ($button_text_color!="" ? 'color:' . esc_attr($button_text_color) . ';': '') . '"' : '') . ($button_hover_color!="" || $button_hover_text_color!="" ? ' onMouseOver="' . ($button_hover_color!="" ? 'this.style.backgroundColor=\''.esc_attr($button_hover_color).'\';this.style.borderColor=\''.esc_attr($button_hover_color).'\';' : '' ) . ($button_hover_text_color!="" ? 'this.style.color=\''.esc_attr($button_hover_text_color).'\';' : '' ) . '" onMouseOut="' . ($button_hover_color!="" ? 'this.style.backgroundColor=\''.esc_attr($button_color).'\';this.style.borderColor=\''.esc_attr($button_color).'\';' : '' ) . ($button_hover_text_color!="" ? 'this.style.color=\''.esc_attr($button_text_color).'\';' : '') . '"' : '') : '') . ' class="mc-button more template-arrow-horizontal-1-after' . (!empty($button_style) && $button_style!="custom" ? ' ' . esc_attr($button_style) : ' light') . '" href="' . esc_url(get_permalink($timetable_page) . '#' . urldecode($post->post_name)) . '" title="' . esc_attr__("TIMETABLE", 'medicenter') . '">' . __("TIMETABLE", 'medicenter') . '</a>
							<a' . (!empty($button_style) && $button_style=="custom" ? ($button_color!="" || $button_text_color!="" ? ' style="' . ($button_color!="" ? 'background-color:' . esc_attr($button_color) . ';border-color:' . esc_attr($button_color) . ';' : '') . ($button_text_color!="" ? 'color:' . esc_attr($button_text_color) . ';': '') . '"' : '') . ($button_hover_color!="" || $button_hover_text_color!="" ? ' onMouseOver="' . ($button_hover_color!="" ? 'this.style.backgroundColor=\''.esc_attr($button_hover_color).'\';this.style.borderColor=\''.esc_attr($button_hover_color).'\';' : '' ) . ($button_hover_text_color!="" ? 'this.style.color=\''.esc_attr($button_hover_text_color).'\';' : '' ) . '" onMouseOut="' . ($button_hover_color!="" ? 'this.style.backgroundColor=\''.esc_attr($button_color).'\';this.style.borderColor=\''.esc_attr($button_color).'\';' : '' ) . ($button_hover_text_color!="" ? 'this.style.color=\''.esc_attr($button_text_color).'\';' : '') . '"' : '') : '') . ' class="mc-button more template-arrow-horizontal-1-after' . (!empty($button_style) && $button_style!="custom" ? ' ' . esc_attr($button_style) : ' light') . '" href="' . esc_url(get_permalink($departments_page) . '#' . urldecode($post->post_name)) . '" title="' . esc_attr__("DETAILS", 'medicenter') . '">' . __("DETAILS", 'medicenter') . '</a>
						</div>
					</div>
				</li>';
			endwhile;
			$output .= '</ul>';
		endif;
		//Reset Query
		wp_reset_query();
		echo do_shortcode($output);
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? strip_tags($new_instance['title']) : "";
		$instance['animation'] = isset($new_instance['animation']) ? strip_tags($new_instance['animation']) : "";
		$instance['order'] = isset($new_instance['order']) ? strip_tags($new_instance['order']) : "";
		$instance['categories'] = isset($new_instance['categories']) ? $new_instance['categories'] : "";
		$instance['departments_page'] = isset($new_instance['departments_page']) ? strip_tags($new_instance['departments_page']) : "";
		$instance['timetable_page'] = isset($new_instance['timetable_page']) ? strip_tags($new_instance['timetable_page']) : "";
		$instance['active'] = isset($new_instance['active']) ? (int)$new_instance['active'] : "";
		$instance['tab_color'] = isset($new_instance['tab_color']) ? strip_tags($new_instance['tab_color']) : "";
		$instance['tab_custom_color'] = isset($new_instance['tab_custom_color']) ? strip_tags($new_instance['tab_custom_color']) : "";
		$instance['button_style'] = isset($new_instance['button_style']) ? strip_tags($new_instance['button_style']) : "";
		$instance['button_color'] = isset($new_instance['button_color']) ? strip_tags($new_instance['button_color']) : "";
		$instance['button_custom_color'] = isset($new_instance['button_custom_color']) ? strip_tags($new_instance['button_custom_color']) : "";
		$instance['button_hover_color'] = isset($new_instance['button_hover_color']) ? strip_tags($new_instance['button_hover_color']) : "";
		$instance['button_hover_custom_color'] = isset($new_instance['button_hover_custom_color']) ? strip_tags($new_instance['button_hover_custom_color']) : "";
		/*$instance['button_border_color'] = strip_tags($new_instance['button_border_color']);
		$instance['button_border_custom_color'] = strip_tags($new_instance['button_border_custom_color']);
		$instance['button_hover_border_color'] = strip_tags($new_instance['button_hover_border_color']);
		$instance['button_hover_border_custom_color'] = strip_tags($new_instance['button_hover_border_custom_color']);*/
		$instance['button_text_color'] = isset($new_instance['button_text_color']) ? strip_tags($new_instance['button_text_color']) : "";
		$instance['button_hover_text_color'] = isset($new_instance['button_hover_text_color']) ? strip_tags($new_instance['button_hover_text_color']) : "";
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{
		if(!isset($instance["button_style"])):
		?>
			<input type="hidden" id="widget-departments-button_style_id" value="<?php echo esc_attr($this->get_field_id('button_style')); ?>">
		<?php
		endif;
		$title = isset($instance['title']) ? esc_attr($instance['title']) : "";
		$animation = isset($instance['animation']) ? esc_attr($instance['animation']) : "";
		$order = isset($instance['order']) ? esc_attr($instance['order']) : "";
		$categories = isset($instance['categories']) ? $instance['categories'] : "";
		$departments_page = isset($instance['departments_page']) ? esc_attr($instance['departments_page']) : "";
		$timetable_page = isset($instance['timetable_page']) ? esc_attr($instance['timetable_page']) : "";
		$active = isset($instance['active']) ? esc_attr($instance['active']) : "";
		$tab_color = isset($instance['tab_color']) ? esc_attr($instance['tab_color']) : "";
		$tab_custom_color = isset($instance['tab_custom_color']) ? esc_attr($instance['tab_custom_color']) : "";
		$button_style = isset($instance['button_style']) ? esc_attr($instance['button_style']) : "";
		$button_color = isset($instance['button_color']) ? esc_attr($instance['button_color']) : "";
		$button_custom_color = isset($instance['button_custom_color']) ? esc_attr($instance['button_custom_color']) : "";
		$button_hover_color = isset($instance['button_hover_color']) ? esc_attr($instance['button_hover_color']) : "";
		$button_hover_custom_color = isset($instance['button_hover_custom_color']) ? esc_attr($instance['button_hover_custom_color']) : "";
		/*$button_border_color = esc_attr($instance['button_border_color']);
		$button_border_custom_color = esc_attr($instance['button_border_custom_color']);
		$button_hover_border_color = esc_attr($instance['button_hover_border_color']);
		$button_hover_border_custom_color = esc_attr($instance['button_hover_border_custom_color']);*/
		$button_text_color = isset($instance['button_text_color']) ? esc_attr($instance['button_text_color']) : "";
		$button_hover_text_color = isset($instance['title']) ? esc_attr($instance['button_hover_text_color']) : "";
		$mc_colors_arr = array(__("Dark blue", "medicenter") => "3156a3", __("Blue", "medicenter") => "0384ce", __("Light blue", "medicenter") => "42b3e5", __("Black", "medicenter") => "000000", __("Gray", "medicenter") => "AAAAAA", __("Dark gray", "medicenter") => "444444", __("Light gray", "medicenter") => "CCCCCC", __("Green", "medicenter") => "43a140", __("Dark green", "medicenter") => "008238", __("Light green", "medicenter") => "7cba3d", __("Orange", "medicenter") => "f17800", __("Dark orange", "medicenter") => "cb451b", __("Light orange", "medicenter") => "ffa800", __("Red", "medicenter") => "db5237", __("Dark red", "medicenter") => "c03427", __("Light red", "medicenter") => "f37548", __("Turquoise", "medicenter") => "0097b5", __("Dark turquoise", "medicenter") => "006688", __("Light turquoise", "medicenter") => "00b6cc", __("Violet", "medicenter") => "6969b3", __("Dark violet", "medicenter") => "3e4c94", __("Light violet", "medicenter") => "9187c4", __("White", "medicenter") => "FFFFFF", __("Yellow", "medicenter") => "fec110");
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('animation')); ?>"><?php _e('Title border animation', 'medicenter'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('animation')); ?>" name="<?php echo esc_attr($this->get_field_name('animation')); ?>">
				<option value="0"><?php _e('no', 'medicenter'); ?></option>
				<option value="1"<?php echo ((int)$animation==1 ? ' selected="selected"' : ''); ?>><?php _e('yes', 'medicenter'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('order')); ?>"><?php _e('Order', 'medicenter'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('order')); ?>" name="<?php echo esc_attr($this->get_field_name('order')); ?>">
				<option <?php echo ($order=='ASC' ? ' selected="selected"':'');?> value='ASC'><?php _e("ASC", 'medicenter'); ?></option>
				<option <?php echo ($order=='DESC' ? ' selected="selected"':'');?> value='DESC'><?php _e("DESC", 'medicenter'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('categories')); ?>"><?php _e('Categories', 'medicenter'); ?></label>
			<select multiple="multiple" id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>[]">
			<?php
			$departments_categories = get_terms("departments_category");
			foreach($departments_categories as $departments_category)
			{
			?>
				<option <?php echo (is_array($categories) && in_array($departments_category->slug, $categories) ? ' selected="selected"':'');?> value='<?php echo esc_attr($departments_category->slug);?>'><?php echo $departments_category->name; ?></option>
			<?php
			}
			?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('departments_page')); ?>"><?php _e('Departments Page', 'medicenter'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('departments_page')); ?>" name="<?php echo esc_attr($this->get_field_name('departments_page')); ?>">
				<?php
				$args = array(
					'post_type' => 'page',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'orderby' => 'title', 
					'order' => 'ASC',
					'suppress_filters' => true,
				);
				query_posts($args);
				if(have_posts()) : while (have_posts()) : the_post();
					global $post;
				?>
					<option <?php echo ($departments_page==get_the_ID() ? ' selected="selected"':'');?> value='<?php echo esc_attr(get_the_ID()); ?>'><?php the_title(); ?></option>
				<?php
				endwhile;
				endif;
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('timetable_page')); ?>"><?php _e('Timetable Page', 'medicenter'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('timetable_page')); ?>" name="<?php echo esc_attr($this->get_field_name('timetable_page')); ?>">
				<?php
				if(have_posts()) : while (have_posts()) : the_post();
				?>
					<option <?php echo ($timetable_page==get_the_ID() ? ' selected="selected"':'');?> value='<?php echo esc_attr(get_the_ID()); ?>'><?php the_title(); ?></option>
				<?php
				endwhile;
				endif;
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('active')); ?>"><?php _e('Active tab number', 'medicenter'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('active')); ?>" name="<?php echo esc_attr($this->get_field_name('active')); ?>" type="text" value="<?php echo esc_attr($active); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('tab_color')); ?>"><?php _e('Tab color', 'medicenter'); ?></label><br>
			<select id="<?php echo esc_attr($this->get_field_id('tab_color')); ?>" name="<?php echo esc_attr($this->get_field_name('tab_color')); ?>">
				<option value=""<?php echo (empty($tab_color) ? ' selected="selected"' : ''); ?>><?php _e('default', 'medicenter'); ?></option>
				<?php
				foreach($mc_colors_arr as $mc_color=>$key)
					echo '<option value="' . esc_attr($key) . '"' . ($tab_color==$key ? ' selected="selected"' : '') . '>' . $mc_color . '</option>';
				?>
			</select>
			<?php _e('or pick custom one: ', 'medicenter'); ?>
			<span class="color_preview" style="background-color: #<?php echo ($tab_custom_color!="" ? esc_attr($tab_custom_color) : '3156A3'); ?>;"></span>
			<input class="regular-text color" id="<?php echo esc_attr($this->get_field_id('tab_custom_color')); ?>" name="<?php echo esc_attr($this->get_field_name('tab_custom_color')); ?>" type="text" value="<?php echo esc_attr($tab_custom_color); ?>" data-default-color="3156A3" />
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
			<span class="color_preview" style="background-color: #<?php echo ($button_text_color!="" ? esc_attr($button_text_color) : '666666'); ?>;"></span>
			<input class="regular-text color" id="<?php echo esc_attr($this->get_field_id('button_text_color')); ?>" name="<?php echo esc_attr($this->get_field_name('button_text_color')); ?>" type="text" value="<?php echo esc_attr($button_text_color); ?>" data-default-color="666666" />
		</p>
		<p class="custom-color-row"<?php echo (empty($button_style) || $button_style!="custom" ? ' style="display: none;"' : ''); ?>>
			<label for="<?php echo esc_attr($this->get_field_id('button_hover_text_color')); ?>"><?php _e('Button hover text color', 'medicenter'); ?></label>
			<span class="color_preview" style="background-color: #<?php echo ($button_hover_text_color!="" ? esc_attr($button_hover_text_color) : 'FFFFFF'); ?>;"></span>
			<input class="regular-text color" id="<?php echo esc_attr($this->get_field_id('button_hover_text_color')); ?>" name="<?php echo esc_attr($this->get_field_name('button_hover_text_color')); ?>" type="text" value="<?php echo esc_attr($button_hover_text_color); ?>" data-default-color="FFFFFF" />
		</p>
		<p class="custom-color-row"<?php echo (empty($button_style) || $button_style!="custom" ? ' style="display: none;"' : ''); ?>>
			<label for="<?php echo esc_attr($this->get_field_id('button_color')); ?>"><?php _e('Button bg color', 'medicenter'); ?></label><br>
			<select id="<?php echo esc_attr($this->get_field_id('button_color')); ?>" name="<?php echo esc_attr($this->get_field_name('button_color')); ?>">
				<?php
				foreach($mc_colors_arr as $mc_color=>$key)
					echo '<option value="' . esc_attr($key) . '"' . ($button_color==$key ? ' selected="selected"' : '') . '>' . $mc_color . '</option>';
				?>
			</select>
			<?php _e('or pick custom one: ', 'medicenter'); ?>
			<span class="color_preview" style="background-color: #<?php echo ($button_custom_color!="" ? esc_attr($button_custom_color) : 'FFFFFF'); ?>;"></span>
			<input class="regular-text color" id="<?php echo esc_attr($this->get_field_id('button_custom_color')); ?>" name="<?php echo esc_attr($this->get_field_name('button_custom_color')); ?>" type="text" value="<?php echo esc_attr($button_custom_color); ?>" data-default-color="FFFFFF" />
		</p>
		<p class="custom-color-row"<?php echo (empty($button_style) || $button_style!="custom" ? ' style="display: none;"' : ''); ?>>
			<label for="<?php echo esc_attr($this->get_field_id('button_hover_color')); ?>"><?php _e('Button hover bg color', 'medicenter'); ?></label><br>
			<select id="<?php echo esc_attr($this->get_field_id('button_hover_color')); ?>" name="<?php echo esc_attr($this->get_field_name('button_hover_color')); ?>">
				<?php
				foreach($mc_colors_arr as $mc_color=>$key)
					echo '<option value="' . esc_attr($key) . '"' . ($button_hover_color==$key ? ' selected="selected"' : '') . '>' . $mc_color . '</option>';
				?>
			</select>
			<?php _e('or pick custom one: ', 'medicenter'); ?>
			<span class="color_preview" style="background-color: #<?php echo ($button_hover_custom_color!="" ? esc_attr($button_hover_custom_color) : 'FFFFFF'); ?>;"></span>
			<input class="regular-text color" id="<?php echo esc_attr($this->get_field_id('button_hover_custom_color')); ?>" name="<?php echo esc_attr($this->get_field_name('button_hover_custom_color')); ?>" type="text" value="<?php echo esc_attr($button_hover_custom_color); ?>" data-default-color="FFFFFF" />
		</p>
		<?php
		/*<p>
			<label for="<?php echo $this->get_field_id('button_border_color'); ?>"><?php _e('Button border color', 'medicenter'); ?></label>
			<select id="<?php echo $this->get_field_id('button_border_color'); ?>" name="<?php echo $this->get_field_name('button_border_color'); ?>">
				<?php
				foreach($mc_colors_arr as $mc_color=>$key)
					echo '<option value="' . $key . '"' . ($button_color==$key ? ' selected="selected"' : '') . '>' . $mc_color . '</option>';
				?>
			</select>
			<?php _e('or pick custom one: ', 'medicenter'); ?>
			<span class="color_preview" style="background-color: #<?php echo ($button_border_custom_color!="" ? $button_border_custom_color : 'FFFFFF'); ?>;"></span>
			<input class="regular-text color" id="<?php echo $this->get_field_id('button_border_custom_color'); ?>" name="<?php echo $this->get_field_name('button_border_custom_color'); ?>" type="text" value="<?php echo $button_border_custom_color; ?>" data-default-color="FFFFFF" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('button_hover_border_color'); ?>"><?php _e('Button hover border color', 'medicenter'); ?></label>
			<select id="<?php echo $this->get_field_id('button_hover_border_color'); ?>" name="<?php echo $this->get_field_name('button_hover_border_color'); ?>">
				<?php
				foreach($mc_colors_arr as $mc_color=>$key)
					echo '<option value="' . $key . '"' . ($button_hover_border_color==$key ? ' selected="selected"' : '') . '>' . $mc_color . '</option>';
				?>
			</select>
			<?php _e('or pick custom one: ', 'medicenter'); ?>
			<span class="color_preview" style="background-color: #<?php echo ($button_hover_border_custom_color!="" ? $button_hover_border_custom_color : 'FFFFFF'); ?>;"></span>
			<input class="regular-text color" id="<?php echo $this->get_field_id('button_hover_border_custom_color'); ?>" name="<?php echo $this->get_field_name('button_hover_border_custom_color'); ?>" type="text" value="<?php echo $button_hover_border_custom_color; ?>" data-default-color="FFFFFF" />
		</p>*/ ?>
		<?php
	}
}
//register widget
function mc_departments_widget_init()
{
	return register_widget("mc_departments_widget");
}
add_action('widgets_init', 'mc_departments_widget_init');
?>