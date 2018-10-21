<?php
/**
 * Plugin Name: WP Core Update Cleaner
 * Description: This plugin automatically removes some files in the root folder, like wp-config-sample.php, readme and license files, when WordPress is manually or automatically updated.
 * Version: 1.1.0
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
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( '_core_updated_successfully', array( $this, 'manual_update_cleaner' ), 0, 1 );
		add_action( 'pre_auto_update', array( $this, 'auto_update_cron_setup' ) );
		add_action( 'wp_core_update_cleaner_auto_update_cron', array( $this, 'auto_update_cleaner' ) );
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
	 * Schedule single event for cleaning up after auto core updates.
	 *
	 * @since 1.1.0
	 */
	function auto_update_cron_setup() {
		wp_schedule_single_event( time() + 900, 'wp_core_update_cleaner_auto_update_cron' );
	}
	
	/**
	 * Remove files
	 *
	 * @since 1.1.0
	 */
	function remove_files( $show_message = false ) {
		
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
	
	/**
	 * Manual core update cleaner
	 * 
	 * @since 1.0
	 * @since 1.1.0 Rename function. Move actual removal of files to separate function.
	 * @param string New version of updated WordPress. 
	 */
	function manual_update_cleaner( $new_version ) {

		global $pagenow, $action;

		if ( 'update-core.php' !== $pagenow ) {
			return;
		}

		if ( 'do-core-upgrade' !== $action && 'do-core-reinstall' !== $action ) {
			return;
		}

		// Remove files
		$this->remove_files( $show_message = true );

		// Load the updated default text localization domain for new strings
		load_default_textdomain();

		// See do_core_upgrade()
		show_message( __( 'WordPress updated successfully' ) . '.' );
		show_message( '<span>' . sprintf( __( 'Welcome to WordPress %1$s. <a href="%2$s">Learn more</a>.' ), $new_version, esc_url( self_admin_url( 'about.php?updated' ) ) ) . '</span>' );
    	echo '</div>';

		// Include admin-footer.php and exit
		include( ABSPATH . 'wp-admin/admin-footer.php' );

		exit();
	}
	
	/**
	 * Auto update cleaner
	 * 
	 * @since 1.1.0
	 */
	function auto_update_cleaner() {
		$this->remove_files();
	}
}

$wp_core_update_cleaner = new WPCoreUpdateCleaner();