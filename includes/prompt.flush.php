<?php
if (isset($_POST['cache_id'])):
	require_once("../../../../wp-config.php");
	global $wpdb;
	$cache_id = $_POST['cache_id'];
	if ($wpdb->query("DELETE FROM $wpdb->options WHERE option_id = '$cache_id'")):
		echo 'true';
	else: echo 'false';
	endif;
elseif (isset($_POST['cache_ids'])):
	require_once("../../../../wp-config.php");
	global $wpdb;
	$cache_ids = explode(',', $_POST['cache_ids']);
	$cache_ids = implode("', '", $cache_ids);
	if ($wpdb->query("DELETE FROM $wpdb->options WHERE option_id IN ('$cache_ids')")):
		echo 'true';
	else: echo 'false';
	endif;
else: echo 'false';
endif;
?>