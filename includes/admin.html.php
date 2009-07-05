<div class="wrap">
	<h2>WP RSS Cache Flusher</h2>
	<div class="wp_rss_cache_flusher-box">
	<table class="wp_rss_cache_flusher-table">
		<thead>
			<tr>
				<th class="timestamp">Last updated</th>
				<th class="title">Title</th>
				<th class="description">Description</th>
				<th colspan="2">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($cache as $row): ?>
				<tr>
					<td class="timestamp"><?=date('j M Y, H:i', $row->timestamp);?></td>
					<td class="title"><a href="<?=$row->channel['link'];?>" target="_blank"><?=$row->channel['title'];?></a></td>
					<td class="description"><?=$row->channel['description'];?></td>
					<td><input type="button" class="button-secondary inspect" rel="<?=$row->option_id;?>" value="Inspect" /></td>
					<td class="flush"><input type="button" class="button-primary flush" rel="<?=$row->option_id;?>" value="Flush"></td>
				</tr>
			<?php endforeach; ?>
			<tfoot>
				<tr>
					<td colspan="3">&nbsp;</td>
					<td colspan="2" class="flush"><input type="button" class="button-primary flush-all" value="Flush all"></td>
				</tr>
			</tfoot>
		</tbody>
	</table>
	</div>
	<div id="wp_rss_cache_flusher-prompt">Please wait...</div>
</div>