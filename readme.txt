=== WP Core Update Cleaner ===
Contributors: Upperdog, Gesen
Tags: update, upgrade, core, 
Requires at least: 3.3
Tested up to: 4.8
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin automatically removes wp-config-sample.php, readme.html and license files, both default and localized versions, when WordPress is updated.

== Description ==

When WordPress is updated, it re-installs wp-config-sample.php, readme files, and license files even though you may have deleted them before. We found ourselves manually deleting these files every time we updated a WordPress site. If you're maintaining multiple WordPress sites like us, this can get tedious. So instead, we developed this plugin to automatically delete these files every time we update a WordPress site. 

This plugin automatically removes wp-config-sample.php, readme.html, and license.txt, both default versions and localized versions like licens-sv_SE.txt and lisenssi.html, among others, when WordPress is updated.

== Installation ==

1. Upload the `wp-core-update-cleaner` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions == 

= Why does this plugin exist? =

We found ourselves manually deleting wp-config-sample.php, readme.html, and license.txt every time we updated a WordPress site. If you're maintaining multiple WordPress sites like us, this can get tedious. So instead, we developed this plugin to take care of deleting these files for us.

= Why should I delete these files? =

You don't have to delete these files if you want to keep them for some reason. However, the readme file contains your current WordPress version which can be used by evil people or bots trying to hurt your site by taking advantage of security exploits in your version if you've not installed the latest security patches. Also, there's no reason to have wp-config-sample.php and the license files just laying around since you're not using them anyway.

== Screenshots ==

1. The plugin gives you feedback on which files are being removed.

== Changelog ==

= 1.0 =

* Initial release.
