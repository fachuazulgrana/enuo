<?php
/*
	Plugin Name: Download Monitor - Buttons
	Plugin URI: https://www.download-monitor.com/
	Description: The Buttons extension for Download Monitor allows you to create custom download buttons without any coding.
	Version: 4.0.1
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

class DLM_Buttons {

	const VERSION = '4.0.1';

	public function __construct() {

		// Admin only classes
		if ( is_admin() ) {

			// The page
			$page = new DLM_Buttons_Admin_Page();
			$page->setup();

			// add settings
			//add_filter( 'download_monitor_settings', array( 'DLM_CA_Settings', 'add_settings' ) );
		}

		// assets
		$assets = new DLM_Buttons_Assets();
		$assets->setup();

		// preview
		$preview = new DLM_Buttons_Preview();
		$preview->setup();

		// template handler
		$template_handler = new DLM_Buttons_Template_Handler();
		$template_handler->setup();

		// ajax
		$ajax_save_template = new DLM_Buttons_Save_Template();
		$ajax_save_template->setup();

		$ajax_add_template = new DLM_Buttons_Add_Template();
		$ajax_add_template->setup();

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
			'file'    => 'dlm-buttons',
			'version' => DLM_Buttons::VERSION,
			'name'    => 'Buttons'
		);

		return $extensions;
	}

}

require_once dirname( __FILE__ ) . '/vendor/autoload_52.php';

function __dlm_buttons() {
	new DLM_Buttons();
}

add_action( 'plugins_loaded', '__dlm_buttons' );

if ( is_admin() && ( false === defined( 'DOING_AJAX' ) || false === DOING_AJAX ) ) {

	// set installer file constant
	define( 'DLM_BUTTONS_PLUGIN_FILE_INSTALLER', __FILE__ );

	// include installer functions
	require_once( 'includes/installer-functions.php' );

	// Activation hook
	register_activation_hook( DLM_BUTTONS_PLUGIN_FILE_INSTALLER, '_dlm_buttons_install' );

	// Multisite new blog hook
	add_action( 'wpmu_new_blog', '_dlm_buttons_mu_new_blog', 10, 6 );

	// Multisite blog delete
	add_filter( 'wpmu_drop_tables', '_dlm_buttons_mu_delete_blog' );
}
