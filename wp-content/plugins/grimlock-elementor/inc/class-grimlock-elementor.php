<?php
// Exit if accessed directly
use Elementor\Core\Settings\Manager as SettingsManager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Grimlock_Elementor
 *
 * @author  themosaurus
 * @since   1.0.0
 * @package grimlock-elementor/inc
 */
class Grimlock_Elementor {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		load_plugin_textdomain( 'grimlock-elementor', false, 'grimlock-elementor/languages' );

		add_filter( 'grimlock_custom_header_displayed',       array( $this, 'custom_header_displayed'         ), 10 );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'elementor_after_enqueue_scripts' ), 10 );
		add_action( 'wp_enqueue_scripts',                     array( $this, 'enqueue_scripts'                 ), 10 );
	}

	/**
	 * Filter whether the custom header is displayed or not.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the custom header is displayed, false otherwise.
	 */
	public function custom_header_displayed( $displayed ) {
		if ( get_post_type() === 'page' ) {
			$elementor_page_settings = get_post_meta( get_the_ID(), '_elementor_page_settings', true );

			if ( ! empty( $elementor_page_settings ) ) {
				$displayed = $displayed && empty( $elementor_page_settings['hide_title'] );
			}
		}

		return $displayed;
	}

	/**
	 * Enqueue scripts for Elementor editor
	 */
	public function elementor_after_enqueue_scripts() {
		wp_enqueue_style( 'grimlock-elementor-editor', GRIMLOCK_ELEMENTOR_PLUGIN_DIR_URL . 'assets/css/editor.css', array(), GRIMLOCK_ELEMENTOR_VERSION );

		global $grimlock;
		$grimlock->admin_enqueue_scripts();

		wp_enqueue_script( 'grimlock-elementor-widgets', GRIMLOCK_ELEMENTOR_PLUGIN_DIR_URL . 'assets/js/widgets.js', array( 'grimlock-widgets' ), GRIMLOCK_ELEMENTOR_VERSION, true );
	}

	/**
	 * Enqueue Grimlock for Elementor scripts
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'grimlock-elementor', GRIMLOCK_ELEMENTOR_PLUGIN_DIR_URL . 'assets/css/style.css', array(), GRIMLOCK_ELEMENTOR_VERSION );

		/*
		 * Load style-rtl.css instead of style.css for RTL compatibility
		 */
		wp_style_add_data( 'grimlock-elementor', 'rtl', 'replace' );
	}
}
