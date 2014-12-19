<?php
/**
 * Plugin Name: WP Core Update Cleaner
 * Description: This plugin automatically removes wp-config-sample.php, readme.html and license files, both default and localized versions, when WordPress is updated.
 * Version: 1.0
 * Author: Upperdog
 * Author URI: http://upperdog.com
 * Author Email: hello@upperdog.com
 * License: GPL2
 */

/*  Copyright 2014 Upperdog (email : hello@upperdog.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * In search of a solution to our problem, we found the following thread on 
 * StackExchange which pointed us in the right direction. 
 * http://wordpress.stackexchange.com/questions/57612/how-to-prevent-redirect-to-about-after-core-upgrade
 */

if (!defined('ABSPATH')) {
	exit;
}

class WPCoreUpdateCleaner {

	/**
	 * Sets up hooks, actions and filters that the plugin responds to.
	 *
	 * @since 1.0
	 */

	function __construct() {
		add_action('admin_init', array($this, 'admin_init'));
		add_action('_core_updated_successfully', array($this, 'update_cleaner'), 0, 1);
	}

	/**
	 * Sets up plugin translations.
	 *
	 * @since 1.0
	 */

	function admin_init() {

		// Load plugin translations
		load_plugin_textdomain('wp-core-update-cleaner', false, dirname(plugin_basename(__FILE__)) . '/languages/');
	}

	/**
	 * Performs the update cleaning. 
	 * 
	 * This function removes the unwanted files when WordPress is updated. The 
	 * cleaning is performed on core update and core re-install. The function removes 
	 * wp-config-sample.php, readme.html and localized versions of the readme and 
	 * license files. If the files are removed successfully, the plugin outputs 
	 * a response message to the core update screen letting you know which files 
	 * that were removed. 
	 * 
	 * @since 1.0
	 * @param string New version of updated WordPress. 
	 */

	function update_cleaner($new_version) {

		global $pagenow, $action;

		if ('update-core.php' !== $pagenow) {
			return;
		}

		if ('do-core-upgrade' !== $action && 'do-core-reinstall' !== $action) {
			return;
		}

		// Remove license, readme files 
		$remove_files = array(
			'license.txt', 
			'licens.html', 
			'licenza.html', 
			'licencia.txt', 
			'licenc.txt', 
			'licencia-sk_SK.txt', 
			'licens-sv_SE.txt', 
			'liesmich.html', 
			'LEGGIMI.txt', 
			'lisenssi.html', 
			'olvasdel.html', 
			'readme.html', 
			'readme-ja.html', 
			'wp-config-sample.php'
		);

		foreach ($remove_files as $file) {
			if (file_exists(ABSPATH . $file)) {
				if (unlink(ABSPATH . $file)) {
					show_message(__('Removing', 'wp-core-update-cleaner') . ' ' . $file . '...');
				}
			}
		}

		// Load the updated default text localization domain for new strings
		load_default_textdomain();

		// See do_core_upgrade()
		show_message(__('WordPress updated successfully') . '.');
		show_message('<span>' . sprintf(__('Welcome to WordPress %1$s. <a href="%2$s">Learn more</a>.'), $new_version, esc_url(self_admin_url('about.php?updated'))) . '</span>');
    	echo '</div>';

		// Include admin-footer.php and exit
		include(ABSPATH . 'wp-admin/admin-footer.php');

		exit();
	}
}

if (is_admin()) {
	$wp_core_update_cleaner = new WPCoreUpdateCleaner();
}