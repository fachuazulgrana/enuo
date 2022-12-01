<?php
/*
 * Plugin name: Grimlock for Elementor
 * Plugin URI:  http://www.themosaurus.com
 * Description: Adds integration features for Grimlock and Elementor.
 * Author:      Themosaurus
 * Author URI:  http://www.themosaurus.com
 * Version:     1.0.4
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: grimlock-elementor
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GRIMLOCK_ELEMENTOR_VERSION',         '1.0.4' );
define( 'GRIMLOCK_ELEMENTOR_PLUGIN_FILE',     __FILE__ );
define( 'GRIMLOCK_ELEMENTOR_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'GRIMLOCK_ELEMENTOR_PLUGIN_DIR_URL',  plugin_dir_url( __FILE__ ) );

// Initialize update checker
require 'libs/plugin-update-checker/plugin-update-checker.php';
Puc_v4_Factory::buildUpdateChecker(
	'http://files.themosaurus.com/grimlock-elementor/version.json',
	__FILE__,
	'grimlock-elementor'
);

/**
 * Load plugin.
 */
function grimlock_elementor_loaded() {
	require_once 'inc/class-grimlock-elementor.php';

	global $grimlock_elementor;
	$grimlock_elementor = new Grimlock_Elementor();

	do_action( 'grimlock_elementor_loaded' );
}
add_action( 'grimlock_loaded', 'grimlock_elementor_loaded' );

/**
 * Add support for Grimlock Hero.
 *
 * @since 1.0.0
 */
function grimlock_elementor_hero_loaded() {
	require_once 'inc/hero/class-grimlock-elementor-hero.php';

	global $grimlock_elementor_hero;
	$grimlock_elementor_hero = new Grimlock_Elementor_Hero();

	do_action( 'grimlock_elementor_hero_loaded' );
}
add_action( 'grimlock_hero_loaded', 'grimlock_elementor_hero_loaded' );
