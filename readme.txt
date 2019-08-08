=== Pods Font End Plugin ===
Contributors: Firewolf
Tags: Pods Front End Plugin, WordPress Plugin
Requires at least: 4.5
Tested up to: 4.7.4
Stable tag: 3.0
  
== Description ==
 
Pods Front End is the WordPress plugin for editing and list posts.

== Installation ==
1. Unpack the `download-package`.
2. Upload the file to the `/wp-content/plugins/` directory.
3. Activate the plugin through the `Plugins` menu in WordPress.
4. Done and Ready.
 
== Frequently Asked Questions ==
 
= How to add PAGE =

1. Shortcode Rules ( Required )
	Add / Edit Shortcode =>	[post-edit slug='{$pods_slug}']
	List Shortcode 		 => [post-list slug='{$pods_slug}']

2. Page Urls ( Required )
	Add / Edit Page Url => home_url() . '/{$pods_slug}-edit
	List Page Url 		=> home_url() . '/{$pods_slug}-list
	
