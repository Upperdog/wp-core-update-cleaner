# WP Core Update Cleaner

When WordPress is updated, it re-installs wp-config-sample.php, readme files, and license files even though you may have deleted them before. This plugin automatically removes these files when WordPress is manually or automatically updated. It also removes these files when activating the plugin for the first time. Removing these files is not mandatory, but you may want to if you don't want them to expose your WordPress version or if you just like to keep things neat and clean. 

Files that are removed:

* License files, both default and localized
* Readme files, both default and localized
* wp-config-sample.php
* wp-admin/install.php

___You may not want to install this plugin if you're using a plugin or service to scans your site to verify checksums on the core files. When the removed files are missing it might result in warnings.___

## Installation

1. Upload the `wp-core-update-cleaner` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Frequently Asked Questions

### Why does this plugin exist?

We found ourselves manually deleting wp-config-sample.php, readme.html, and license.txt every time we updated a WordPress site. If you're maintaining multiple WordPress sites like us, this can get tedious. So instead, we developed this plugin to take care of deleting these files for us.

### Why should I delete these files?

You don't have to delete these files if you want to keep them for some reason. However, the readme file contains the version number of the WordPress version you're running. This may be used by bots or evil people trying to hurt your site by taking advantage of security exploits in your version if you've not installed security patches. Also, there's no reason to have wp-config-sample.php and the license files just laying around.

## Changelog

### 1.2.0 (2018-10-27)

* Remove files when plugin is activated so site admins don't have to wait for the next core update for the files to be removed.

### 1.1.0 (2018-10-22)

* Add wp-admin/install.php to the list of files to remove.
* Add support for running the plugin on automatic core updates.
* Enable installation with Composer.

### 1.0

* Initial release.