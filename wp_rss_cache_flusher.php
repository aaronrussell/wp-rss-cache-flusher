<?php
/*
Plugin Name: WP RSS Cache Flusher
Plugin URI: http://www.aaronrussell.co.uk/wordpress-plugins/wp-rss-cache-flusher/
Version: 0.0.1b
Author: <a href="http://www.aaronrussell.co.uk/">Aaron Russell</a>
Description: WP RSS Cache Flusher - TD add description
*/

/*
Copyright 2007-2008 Aaron Russell (aaron@gc4.co.uk)

WP RSS Cache Flusher is free software: you can redistribute it and/or modify it
under the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this
program.  If not, see <http://www.gnu.org/licenses/>.
*/


if (!class_exists('wp_rss_cache_flusher')):
	class wp_rss_cache_flusher
	{
		function __construct()
		{
			if (!defined('WP_CONTENT_URL')) define('WP_CONTENT_URL', get_bloginfo('wpurl').'/wp-content');
			if (!defined('WP_CONTENT_DIR')) define('WP_CONTENT_DIR', ABSPATH.'wp-content');
			define('WP_RSS_CACHE_FLUSHER_URL', WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)));
			define('WP_RSS_CACHE_FLUSHER_DIR', WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__)));
			include_once(ABSPATH . WPINC . '/rss.php');
		}
		
		
		function admin_menu()
		{
			if (function_exists('add_options_page')):
				add_options_page('WP RSS Cache Flusher', 'WP RSS Cache Flusher', 9, basename(__FILE__), array(&$this, 'admin_page'));
			endif;
		}
		
		function admin_init()
		{
			wp_enqueue_style('wp_rss_cache_flusher', WP_RSS_CACHE_FLUSHER_URL.'/includes/admin.style.css');
			wp_enqueue_script('wp_rss_cache_flusher_js', WP_RSS_CACHE_FLUSHER_URL.'/includes/admin.ajax.js', array('jquery', 'thickbox'), '0.0.1');
			wp_enqueue_style('thickbox');
		}
		
		function admin_page()
		{
			global $wpdb;
			$cache = $wpdb->get_results("SELECT * FROM $wpdb->options WHERE option_name REGEXP '^RSS_[a-zA-z0-9]{32}$'");
			foreach ($cache as $id => $row):
				$row->timestamp = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_name = '".$row->option_name."_ts'");
				$row->channel = unserialize($row->option_value);
				$row->channel = $row->channel->channel;
			endforeach;
			$this->sort_object($cache, 'timestamp');
			include_once(WP_RSS_CACHE_FLUSHER_DIR.'/includes/admin.html.php');
		}
		
		// Function for sorting the query objects
		function sort_object(&$object, $key)
		{
			for ($i = count($object) - 1; $i >= 0; $i--):
				$swapped = false;
				for ($j = 0; $j < $i; $j++):
					if ($object[$j]->$key < $object[$j + 1]->$key):
						$tmp = $object[$j];
						$object[$j] = $object[$j + 1];
						$object[$j + 1] = $tmp;
						$swapped = true;
					endif;
				endfor;
				if (!$swapped) return;
			endfor;
		}
		
		function excerpt($text, $excerpt_length)
		{
			$text = strip_tags(preg_replace('@<script[^>]*?>.*?</script>@si', '', $text));
			$words = explode(' ', $text, $excerpt_length + 1);
			if (count($words)> $excerpt_length):
				array_pop($words);
				array_push($words, '[...]');
				$text = implode(' ', $words);
			endif;
			return $text;
		}
	}
endif;


// Initiate wp_rss_cache_flush class
if (class_exists('wp_rss_cache_flusher')):
	$wp_rss_cache_flusher = new wp_rss_cache_flusher();
endif;


// Add actions and filters
if (isset($wp_rss_cache_flusher)):
	add_action('admin_init', array(&$wp_rss_cache_flusher, 'admin_init'), 1);
	add_action('admin_menu', array(&$wp_rss_cache_flusher, 'admin_menu'), 1);
endif;
?>