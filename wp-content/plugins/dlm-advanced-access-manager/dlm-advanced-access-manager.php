<?php
/*
	Plugin Name: Download Monitor - Advanced Access Manager
	Plugin URI: https://www.download-monitor.com/extensions/advanced-access-manager/
	Description: The Advanced Access Manager extension allows you to create more advanced download limitations.
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

function __dlm_advanced_access_manager() {

	// Define
	define( 'DLM_AAM_FILE', __FILE__ );

	// include files
	require_once dirname( __FILE__ ) . '/vendor/autoload_52.php';

	// Instantiate main plugin object
	new DLM_Advanced_Access_Manager();
}

// init extension
add_action( 'plugins_loaded', '__dlm_advanced_access_manager', 11 );

// installation procedure
if ( is_admin() && ( false === defined( 'DOING_AJAX' ) || false === DOING_AJAX ) ) {

	// set installer file constant
	define( 'DLM_AAM_FILE_INSTALLER', __FILE__ );

	// include installer functions
	require_once( 'includes/installer-functions.php' );

	// Activation hook
	register_activation_hook( DLM_AAM_FILE_INSTALLER, '__dlm_aam_install' );

	// Multisite new blog hook
	add_action( 'wpmu_new_blog', '__dlm_aam_mu_new_blog', 10, 6 );

	// Multisite blog delete
	add_filter( 'wpmu_drop_tables', '__dlm__aam_mu_delete_blog' );
}