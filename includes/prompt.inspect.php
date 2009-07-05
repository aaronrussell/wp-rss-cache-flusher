<?php
if (isset($_POST['cache_id'])):
	require_once("../../../../wp-config.php");
	global $wpdb;
	$cache_id = $_POST['cache_id'];
	$prev = $wpdb->get_var("SELECT option_value FROM $wpdb->options WHERE option_id = '$cache_id'");
	$prev = unserialize($prev);
endif;
?>

<div class="wrap">
	<div class="wp_rss_cache_flusher-box">
		<h2><?=$prev->channel['title'];?></h2>
		<table>
		<tr>
			<th>Description:</th>
			<td><?=$prev->channel['description'];?></td>
		</tr>
		<tr>
			<th>Source:</th>
			<td><a href="<?=$prev->channel['link'];?>" target="_blank"><?=$prev->channel['link'];?></a></td>
		</tr>
		<?php if(isset($prev->channel['pubdate'])): ?>
			<tr>
				<th>Publication date:</th>
				<td><?=date('j M Y, H:i', strtotime($prev->channel['pubdate']));?></td>
			</tr>
		<?php endif; ?>
		<tr>
			<th>Items:</th>
			<td><?=count($prev->items);?></td>
		</tr>
		</table>
	</div>

	<?php foreach($prev->items as $item): ?>
		<h3><a href="<?=$item['link'];?>" target="_blank"><?=$item['title'];?></a></h3>
		<?php if (isset($item['pubdate'])): ?>
			<p class="date"><?=date('j M Y, H:i', strtotime($item['pubdate']));?></p>
		<?php elseif (isset($item['dc']['date'])): ?>
			<p class="date"><?=date('j M Y, H:i', strtotime($item['dc']['date']));?></p>
		<?php endif; ?>
		<p><?=$wp_rss_cache_flusher->excerpt($item['summary'], 50);?></p>
		<hr />
	<?php endforeach; ?>
</div>