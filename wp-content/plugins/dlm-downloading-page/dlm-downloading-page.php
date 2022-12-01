<?php

/*
	Plugin Name: Download Monitor - Downloading Page
	Plugin URI: https://www.download-monitor.com/
	Description: The Downloading Page extension for Download Monitor forces your downloads to be served from a separate page.
	Version: 4.0.0
	Author: Never5
	Author URI: http://www.never5.com/
	License: GPL v3
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class DLM_Downloading_Page {

	const VERSION = '4.0.0';

	public function __construct() {

		// Download Access Manager
		$access_manager = new DLM_DP_Access_Manager();
		$access_manager->setup();

		// Register Shortcode
		$shortcode = new DLM_DP_Shortcode();
		$shortcode->setup();

		// Admin only classes
		if ( is_admin() ) {

			// add settings
			add_filter( 'download_monitor_settings', array( 'DLM_DP_Settings', 'add_settings' ) );
		}

		// Register Extension
		add_filter( 'dlm_extensions', array( $this, 'register_extension' ) );
	}

	/**
	 * Get the plugin file
	 *
	 * @static
	 *
	 * @return String
	 */
	public static function get_plugin_file() {
		return __FILE__;
	}

	/**
	 * Register this extension
	 *
	 * @param array $extensions
	 *
	 * @return array $extensions
	 */
	public function register_extension( $extensions ) {

		$extensions[] = array(
			'file'    => 'dlm-downloading-page',
			'version' => self::VERSION,
			'name'    => 'Downloading Page'
		);

		return $extensions;
	}

}

require_once dirname( __FILE__ ) . '/vendor/autoload_52.php';

function __dlm_downloading_page() {
	new DLM_Downloading_Page();
}

add_action( 'plugins_loaded', '__dlm_downloading_page' );
