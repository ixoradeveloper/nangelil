<?php
/*
Plugin Name: Theme Twitter Widget
Plugin URI: https://1.envato.market/quanticalabs-portfolio
Description: Theme Twitter Widget
Author: QuanticaLabs
Author URI: https://1.envato.market/quanticalabs-portfolio
Version: 2.1
Text Domain: ql_twitter_widget
*/

//translation
function ql_twitter_widget_load_textdomain()
{
	load_plugin_textdomain("ql_twitter_widget", false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'ql_twitter_widget_load_textdomain');

class ql_twitter_widget extends WP_Widget 
{
	/** constructor */
    function __construct()
	{
		global $themename;
		$widget_options = array(
			'classname' => 'ql_twitter_widget',
			'description' => __('Displays Twitter Feed', 'ql_twitter_widget')
		);
		$control_options = array('width' => 580);
        parent::__construct($themename . '_twitter', __('Twitter Feed', 'ql_twitter_widget'), $widget_options, $control_options);
    }
	
	/** @see WP_Widget::widget */
    function widget($args, $instance)
	{
        extract($args);

		//these are our widget options
		$title = isset($instance['title']) ? $instance['title'] : "";
		$animation = isset($instance['animation']) ? $instance['animation'] : "";
		$api_version = isset($instance['api_version']) ? $instance['api_version'] : 1;
		$login = isset($instance['login']) ? $instance['login'] : "";
		$count = isset($instance['count']) ? $instance['count'] : "";
		$consumer_key = isset($instance['consumer_key']) ? $instance['consumer_key'] : "";
		$consumer_secret = isset($instance['consumer_secret']) ? $instance['consumer_secret'] : "";
		$access_token = isset($instance['access_token']) ? $instance['access_token'] : "";
		$access_token_secret = isset($instance['access_token_secret']) ? $instance['access_token_secret'] : "";

		echo $before_widget;
		require_once("libraries/tmhOAuth/tmhOAuth.php");
		require_once("libraries/tmhOAuth/tmhUtilities.php");
		
		$tmhOAuth = new tmhOAuth(array(
			'consumer_key'    => $consumer_key,
			'consumer_secret' => $consumer_secret,
			'user_token'      => $access_token,
			'user_secret'     => $access_token_secret
		));
		$user_id_error = "";
		if((int)$api_version==1)
		{
			$code = $tmhOAuth->request('GET', $tmhOAuth->url('1.1/statuses/user_timeline'), array(
				'screen_name' => $login,
				'count' => $count,
				'include_rts' => 'true'
			));
			$response = $tmhOAuth->response;
		}
		else if((int)$api_version==2)
		{
			$code = $tmhOAuth->request('GET', $tmhOAuth->url('/2/users/by/username/'.esc_attr($login), ''));
			$response = $tmhOAuth->response;
			
			$user_id = json_decode($response['response']);
			if(is_object($user_id) && isset($user_id->errors) && count((array)$user_id->errors))
			{
				$user_id_error = $user_id->errors[0]->detail;
			}
			else if(is_object($user_id) && isset($user_id->data) && isset($user_id->data->id))
			{
				$code = $tmhOAuth->request('GET', $tmhOAuth->url('/2/users/'.esc_attr($user_id->data->id).'/tweets', ''), array(
					'max_results' => $count,
					'tweet.fields' => 'created_at'
				));
				
				$response = $tmhOAuth->response;
			}
			else
			{
				$user_id_error = esc_html("Twitter API error!", 'ql_twitter_widget');
			}
		}
		?>
		<div class="clearfix scrolling-controls">
			<div class="header-left">
				<?php
				if($title) 
				{
					echo ((int)$animation ? str_replace("box-header", "box-header animation-slide", $before_title) : str_replace("animation-slide", "", $before_title)) . apply_filters("widget_title", $title) . $after_title;
				}
				?>
			</div>
			<div class="header-right">
				<a href="#" id="latest_tweets_prev" class="scrolling-list-control-left template-arrow-horizontal-3"></a>
				<a href="#" id="latest_tweets_next" class="scrolling-list-control-right template-arrow-horizontal-3"></a>
			</div>
		</div>
		<div class="scrolling-list-wrapper">
			<ul class="scrolling-list latest-tweets">
				<?php
				if($user_id_error!="")
				{
					echo '<li><p>' . $user_id_error . '! ' . __('Please check your config under Appearance->Widgets->Twitter Feed!', 'ql_twitter_widget') . '</p></li>';
				}
				else
				{
					require_once("libraries/lib_autolink.php");
					$tweets = json_decode($response['response']);
					if(is_object($tweets) && isset($tweets->errors) && count((array)$tweets->errors))
					{
						echo '<li><p>' . $tweets->errors[0]->message . ' ' . __('Please check your config under Appearance->Widgets->Twitter Feed!', 'ql_twitter_widget') . '</p></li>';
					}
					else
					{
						if((int)$api_version==2)
						{
							if(isset($tweets->data) && count((array)$tweets->data))
							{
								$tweets = $tweets->data;
							}
						}
						foreach($tweets as $tweet)
						{
							echo '<li><p>' .  autolink($tweet->text, 20, ' target="_blank"') . '<abbr title="' . date_i18n(get_option('date_format'),  strtotime($tweet->created_at)) . '" class="timeago">' . date_i18n(get_option('date_format'), strtotime($tweet->created_at)) . '</abbr></p></li>';
						}
					}
				}
				?>
			</ul>
		</div>
		<?php
        echo $after_widget;
    }
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) 
	{
		$instance = $old_instance;
		$instance['title'] = isset($new_instance['title']) ? strip_tags($new_instance['title']) : "";
		$instance['animation'] = isset($new_instance['animation']) ? strip_tags($new_instance['animation']) : "";
		$instance['api_version'] = isset($new_instance['api_version']) ? strip_tags($new_instance['api_version']) : "";
		$instance['login'] = isset($new_instance['login']) ? strip_tags($new_instance['login']) : "";
		$instance['count'] = isset($new_instance['count']) ? strip_tags($new_instance['count']) : "";
		$instance['consumer_key'] = isset($new_instance['consumer_key']) ? strip_tags($new_instance['consumer_key']) : "";
		$instance['consumer_secret'] = isset($new_instance['consumer_secret']) ? strip_tags($new_instance['consumer_secret']) : "";
		$instance['access_token'] = isset($new_instance['access_token']) ? strip_tags($new_instance['access_token']) : "";
		$instance['access_token_secret'] = isset($new_instance['access_token_secret']) ? strip_tags($new_instance['access_token_secret']) : "";
		return $instance;
    }
	
	 /** @see WP_Widget::form */
	function form($instance) 
	{	
		$title = isset($instance['title']) ? esc_attr($instance['title']) : "";
		$animation = isset($instance['animation']) ? esc_attr($instance['animation']) : "";
		$api_version = isset($instance['api_version']) ? esc_attr($instance['api_version']) : 1;
		$login = isset($instance['login']) ? esc_attr($instance['login']) : "";
		$count = isset($instance['count']) ? esc_attr($instance['count']) : "";
		$consumer_key = isset($instance['consumer_key']) ? esc_attr($instance['consumer_key']) : "";
		$consumer_secret = isset($instance['consumer_secret']) ? esc_attr($instance['consumer_secret']) : "";
		$access_token = isset($instance['access_token']) ? esc_attr($instance['access_token']) : "";
		$access_token_secret = isset($instance['access_token_secret']) ? esc_attr($instance['access_token_secret']) : "";
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title', 'ql_twitter_widget'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('animation')); ?>"><?php _e('Title border animation', 'ql_twitter_widget'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('animation')); ?>" name="<?php echo esc_attr($this->get_field_name('animation')); ?>">
				<option value="0"><?php _e('no', 'ql_twitter_widget'); ?></option>
				<option value="1"<?php echo ((int)$animation==1 ? ' selected="selected"' : ''); ?>><?php _e('yes', 'ql_twitter_widget'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('api_version')); ?>"><?php _e('API version', 'ql_twitter_widget'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('api_version')); ?>" name="<?php echo esc_attr($this->get_field_name('api_version')); ?>">
				<option value="1"<?php echo ((int)$api_version==1 ? ' selected="selected"' : ''); ?>><?php _e('v1.1', 'ql_twitter_widget'); ?></option>
				<option value="2"<?php echo ((int)$api_version==2 ? ' selected="selected"' : ''); ?>><?php _e('v2', 'ql_twitter_widget'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('login')); ?>"><?php _e('Login', 'ql_twitter_widget'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('login')); ?>" name="<?php echo esc_attr($this->get_field_name('login')); ?>" type="text" value="<?php echo esc_attr($login); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php _e('Count', 'ql_twitter_widget'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="text" value="<?php echo esc_attr($count); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('consumer_key')); ?>"><?php _e('API token', 'ql_twitter_widget'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('consumer_key')); ?>" name="<?php echo esc_attr($this->get_field_name('consumer_key')); ?>" type="text" value="<?php echo esc_attr($consumer_key); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('consumer_secret')); ?>"><?php _e('API secret', 'ql_twitter_widget'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('consumer_secret')); ?>" name="<?php echo esc_attr($this->get_field_name('consumer_secret')); ?>" type="text" value="<?php echo esc_attr($consumer_secret); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('access_token')); ?>"><?php _e('Access token', 'ql_twitter_widget'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('access_token')); ?>" name="<?php echo esc_attr($this->get_field_name('access_token')); ?>" type="text" value="<?php echo esc_attr($access_token); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('access_token_secret')); ?>"><?php _e('Access token secret', 'ql_twitter_widget'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('access_token_secret')); ?>" name="<?php echo esc_attr($this->get_field_name('access_token_secret')); ?>" type="text" value="<?php echo esc_attr($access_token_secret); ?>">
		</p>
		<p style="line-height: 200%;">
			<?php _e("Directions to get the API token, API secret, Access token and Access token secret:", 'ql_twitter_widget');?><br>
			<?php echo sprintf(__("1. <a href='%s' target='_blank'>Add a new Twitter application</a>", 'ql_twitter_widget'), esc_url("https://dev.twitter.com/apps/new"));?><br>
			<?php _e("2. Fill in Name, Description, and other app details with anything you want", 'ql_twitter_widget');?><br>
			<?php _e("3. Submit your application", 'ql_twitter_widget');?><br>
			<?php echo sprintf(__("4. Select your application and click 'Keys and tokens' tab. Generate authentication tokens under 'Authentication Tokens->Access Token and Secret->Generate' (<a href='%s' target='_blank'>screenshot</a>). Copy the API key, API secret, Access token and Access token secret into the fields above", 'ql_twitter_widget'), esc_url("https://support.quanticalabs.com/wp-content/uploads/2023/01/twitter_access_tokens.jpg"));?><br>
			<?php _e("5. Save widget settings", 'ql_twitter_widget');?>
		</p>
		<?php
	}
}
//register widget
function ql_twitter_widget_init()
{
	return register_widget("ql_twitter_widget");
}
add_action('widgets_init', 'ql_twitter_widget_init');
?>