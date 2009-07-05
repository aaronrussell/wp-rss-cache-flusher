=== WP RSS Cache Flusher ===

Contributors: Aaron Russell
URL: http://github.com/aaronrussell/wp_rss_cache_flusher/
Tested up to: 2.8
Stable tag: 0.1
Tags: rss, magpie, cache

A simple WordPress plugin for flushing the Magpie RSS cache.

== Description ==

WP RSS Cache Flusher is a simple plugin for flushing the Magpie RSS cache from WordPress' database.

Before you install this plugin ask yourself, do you need it? Chances are, you dont!

WordPress uses Magpie to parse various RSS. Magpie caches the output from feeds directly in the WordPress database to save overhead. However, it is not unheard of for this cache to occasionally get 'stuck' or corrupted - effectively locking the cache into an old state and preventing it from being refreshed.

This plugin is for anyone who has experienced issues with the Magpie RSS cache getting 'stuck'. It allows a simple way to flush the cache and all the cogs to start turning again.

== Installation ==

1. Same as any other WordPress plugin.
2. Upload the entire 'wp_rss_cache_flusher' directory to the 'plugins' directory.
3. Activate this plugin via the WordPress 'Plugins' menu.

== Changelog ==

= 0.1 =
* Initial build, allows flushing of individual cache items or the entire cache.

== Known issues ==

* The plugin relies on JavaScript. If you've got it switched off, you won't have much joy.