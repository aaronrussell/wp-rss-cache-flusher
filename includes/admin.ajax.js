jQuery(document).ready(function()
{
	jQuery('input.inspect').click(function()
	{
		var cacheTitle = jQuery(this).parent('td').siblings('td.title').text();
		tb_show(cacheTitle, '#TB_inline?width=680&height=400&inlineId=wp_rss_cache_flusher-prompt');
		var cacheId = jQuery(this).attr('rel');
		jQuery.post('/wp-content/plugins/wp_rss_cache_flusher/includes/prompt.inspect.php', 'cache_id='+cacheId, function(txt)
		{
			jQuery('#TB_ajaxContent').html(txt);
		});
	});
	
	jQuery('input.flush').click(function()
	{
		var cacheTitle = jQuery(this).parent('td').siblings('td.title').text();
		var cacheId = jQuery(this).attr('rel');
		var tableRow = jQuery(this).parent('td').parent('tr');
		var warning = 'Warning! This action cannot be undone.\nAre you sure you want to permanently flush the "'+cacheTitle+'" cache?';
		if(confirm(warning, 'No', 'Yes'))
		{
			jQuery.post('/wp-content/plugins/wp_rss_cache_flusher/includes/prompt.flush.php', 'cache_id='+cacheId, function(txt)
			{
				if (txt == 'true')
				{
					tableRow.children('td').wrapInner('<div></div>').children('div').slideUp('slow', function() {tableRow.remove();});
				}
				else alert('Failed');
			});
		}
	});
	
	jQuery('input.flush-all').click(function()
	{
	  var cacheIds = [];
	  var tbody = jQuery('table.wp_rss_cache_flusher-table > tbody');
	  jQuery('tr', tbody).each(function()
	  {
	    cacheIds.push(jQuery(this).children('td.flush').children('input').attr('rel'));
	  });
		var warning = 'Warning! This action cannot be undone.\nAre you sure you want to permanently flush everything in the RSS cache?';
		if(confirm(warning, 'No', 'Yes'))
		{
			jQuery.post('/wp-content/plugins/wp_rss_cache_flusher/includes/prompt.flush.php', 'cache_ids='+cacheIds.join(','), function(txt)
			{
				if (txt == 'true')
				{
				  tbody.children('tr').remove();
				  tbody.html('<tr><td colspan="5">The RSS Cache is empty</td></tr>');
				}
				else alert('Failed');
			});
		}
	});
});