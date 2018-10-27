<?php
/**
 * Plugin Name: WP Core Update Cleaner
 * Description: This plugin automatically removes some files in the root folder, like wp-config-sample.php, readme and license files, when WordPress is manually or automatically updated.
 * Version: 1.2.0
 * Author: Upperdog
 * Author URI: https://upperdog.com
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

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class WPCoreUpdateCleaner {

	/**
	 * Sets up hooks, actions and filters that the plugin responds to.
	 *
	 * @since 1.0
	 */
	function __construct() {
		register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( '_core_updated_successfully', array( $this, 'core_update_cleaner' ) );
	}
	
	/**
	 * Plugin activation
	 *
	 * @since 1.2.0
	 */
	function plugin_activation() {
		$this->core_update_cleaner();
	}

	/**
	 * Sets up plugin translations.
	 *
	 * @since 1.0
	 */
	function admin_init() {
		load_plugin_textdomain( 'wp-core-update-cleaner', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
	
	/**
	 * Core update cleaner
	 *
	 * @since 1.0
	 * @since 1.1.0 Renamed function, refactored and enabled update cleaner for automatic core updates.
	 */
	function core_update_cleaner() {

		global $action;
		
		// Show update feedback for manual updates
		if ( 'do-core-upgrade' == $action || 'do-core-reinstall' == $action ) {	
			$show_message = true;
		} else {
			$show_message = false;
		}

		// Define files to remove
		$files_to_remove = array(
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
			'wp-config-sample.php',
			'wp-admin/install.php'
		);

		foreach ( $files_to_remove as $file ) {
			if ( file_exists( ABSPATH . $file ) ) {
				if ( unlink( ABSPATH . $file ) ) {
					if ( $show_message ) {
						show_message( __( 'Removing', 'wp-core-update-cleaner' ) . ' ' . $file . '...' );
					}
				}
			}
		}
	}
}

$wp_core_update_cleaner = new WPCoreUpdateCleaner();