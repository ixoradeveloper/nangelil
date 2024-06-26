<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2024 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();

class RevSliderLoadBalancer {

	public $servers = [];
	public $defaults = ['themepunch.tools', 'themepunch-ext-a.tools', 'themepunch-ext-b.tools', 'themepunch-ext-c.tools'];
	 

	/**
	 * set the server list on construct
	 **/
	public function __construct(){
		$this->servers = get_option('revslider_servers', []);
		if(empty($this->servers)){
			shuffle($this->defaults);
			update_option('revslider_servers', $this->defaults);
		}
		
		$this->servers = (empty($this->servers)) ? $this->defaults : $this->servers;
		
		
	}

	/**
	 * get the url depending on the purpose, here with key, you can switch do a different server
	 **/
	public function get_url($purpose, $key = 0, $force_http = false){
		$url	 = ($force_http ) ? 'http://' : 'https://';
		$use_url = (!isset($this->servers[$key])) ? reset($this->servers) : $this->servers[$key];
		
		switch($purpose){
			case 'updates':
				$url .= 'updates.';
				break;
			case 'templates':
				$url .= 'templates.';
				break;
			case 'library':
				$url .= 'library.';
				break;
			default:
				return false;
		}
		
		$url .= $use_url;
		
		return $url;
	}
	
	/**
	 * refresh the server list to be used, will be done once in a month
	 **/
	public function refresh_server_list($force = false){
		global $wp_version;
		
		$rs_rsl		= (isset($_GET['rs_refresh_server'])) ? true : false;
		$last_check	= get_option('revslider_server_refresh', false);
		if($last_check === false || empty($last_check)) update_option('revslider_server_refresh', time());

		if($force === true || $rs_rsl === true || ($last_check !== false && time() - $last_check > 60 * 60 * 24 * 30)){
			//$url = $this->get_url('updates');
			$url	 = 'https://updates.themepunch.tools';
			$request = wp_safe_remote_post($url.'/get_server_list.php', [
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'body'		 => [
					'item'		=> urlencode(RS_PLUGIN_SLUG),
					'version'	=> urlencode(RS_REVISION)
				],
				'timeout'	 => 45
			]);
			
			if(!is_wp_error($request)){
				if($response = maybe_unserialize($request['body'])){
					$list = json_decode($response, true);
					update_option('revslider_servers', $list);
				}
			}
			
			update_option('revslider_server_refresh', time());
		}
	}
	
	/**
	 * move the server list, to take the next server as the one currently seems unavailable
	 **/
	public function move_server_list(){
		$servers	= $this->servers;
		$a			= array_shift($servers);
		$servers[]	= $a;
		
		$this->servers = $servers;
		update_option('revslider_servers', $servers);
	}
	
	/**
	 * call an themepunch URL and retrieve data
	 **/
	public function call_url($url, $data, $subdomain = 'updates', $force_http = false){
		global $wp_version;
		
		//add version if not passed
		$data['version'] = (!isset($data['version'])) ? urlencode(RS_REVISION) : $data['version'];
		$done	= false;
		$count	= 0;
		
		do{
			if(!preg_match("/^https?:\/\//i", $url)){
				//just a filename passed, lets build an url
				$server	 = $this->get_url($subdomain, 0, $force_http);
				$url = $server . '/' . ltrim($url, '/');
			}else{
				//full URL passed, lets check if we need to force http 
				if($force_http) $url = preg_replace("/^https:\/\//i", "http://", $url);
			}
			$request = wp_safe_remote_post($url, [
				'user-agent' => 'WordPress/'.$wp_version.'; '.get_bloginfo('url'),
				'body'		 => $data,
				'timeout'	 => 45
			]);
			
			$response_code = wp_remote_retrieve_response_code($request);
			if($response_code == 200){
				$done = true;
			}else{
				$this->move_server_list();
			}
			
			$count++;
		}while($done == false && $count < 3);
		
		return $request;
	}
}
