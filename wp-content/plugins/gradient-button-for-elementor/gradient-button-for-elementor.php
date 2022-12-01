<?php
/**
 * Plugin Name: Gradient Button for Elementor
 * Description: A simple gradient button addon for Elementor Page Builder
 * Author: BloomPixel
 * Version: 1.0.7
 * Author URI: https://www.bloompixel.com/
 *
 * Text Domain: gradient-button-for-elementor
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'GRADIENT_BUTTON_ELEMENTOR_VERSION', '1.0.7' );

define( 'GRADIENT_BUTTON_ELEMENTOR__FILE__', __FILE__ );
define( 'GRADIENT_BUTTON_ELEMENTOR_PLUGIN_BASE', plugin_basename( GRADIENT_BUTTON_ELEMENTOR__FILE__ ) );
define( 'GRADIENT_BUTTON_ELEMENTOR_PATH', plugin_dir_path( GRADIENT_BUTTON_ELEMENTOR__FILE__ ) );
define( 'GRADIENT_BUTTON_ELEMENTOR_MODULES_PATH', GRADIENT_BUTTON_ELEMENTOR_PATH . 'modules/' );
define( 'GRADIENT_BUTTON_ELEMENTOR_URL', plugins_url( '/', GRADIENT_BUTTON_ELEMENTOR__FILE__ ) );
define( 'GRADIENT_BUTTON_ELEMENTOR_ASSETS_URL', GRADIENT_BUTTON_ELEMENTOR_URL . 'assets/' );
define( 'GRADIENT_BUTTON_ELEMENTOR_MODULES_URL', GRADIENT_BUTTON_ELEMENTOR_URL . 'modules/' );

/**
 * Load gettext translate for our text domain.
 *
 * @since 1.0.0
 *
 * @return void
 */
function gradient_button_elementor_load_plugin() {
	load_plugin_textdomain( 'gradient-button-for-elementor' );

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'gradient_button_elementor_fail_load' );
		return;
	}

	$elementor_version_required = '2.0.0';
	if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
		add_action( 'admin_notices', 'gradient_button_elementor_fail_load_out_of_date' );
		return;
	}

	require( GRADIENT_BUTTON_ELEMENTOR_PATH . 'plugin.php' );
}
add_action( 'plugins_loaded', 'gradient_button_elementor_load_plugin' );

/**
 * Show in WP Dashboard notice about the plugin is not activated.
 *
 * @since 1.0.0
 *
 * @return void
 */
function gradient_button_elementor_fail_load() {
	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	if ( _is_elementor_installed() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );

		$message = '<p>' . __( 'Elementor Gradient Button is not working because you need to activate the Elementor plugin.', 'gradient-button-for-elementor' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, __( 'Activate Elementor Now', 'gradient-button-for-elementor' ) ) . '</p>';
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );

		$message = '<p>' . __( 'Elementor Gradient Button is not working because you need to install the Elemenor plugin', 'gradient-button-for-elementor' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, __( 'Install Elementor Now', 'gradient-button-for-elementor' ) ) . '</p>';
	}

	echo '<div class="error"><p>' . $message . '</p></div>';
}

function gradient_button_elementor_fail_load_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path = 'elementor/elementor.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	$message = '<p>' . __( 'Elementor Gradient Button is not working because you are using an old version of Elementor.', 'gradient-button-for-elementor' ) . '</p>';
	$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, __( 'Update Elementor Now', 'gradient-button-for-elementor' ) ) . '</p>';

	echo '<div class="error">' . $message . '</div>';
}

if ( ! function_exists( '_is_elementor_installed' ) ) {

	function _is_elementor_installed() {
		$file_path = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}

/**
 * Check if WPML String Translation plugin is active
 *
 * @since 1.0.5
 *
 */
if ( ! function_exists( 'is_wpml_string_translation_active' ) ) {
	function is_wpml_string_translation_active() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		return is_plugin_active( 'wpml-string-translation/plugin.php' );
	}
}