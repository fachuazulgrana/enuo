<?php
/**
 * Gradient Button Elementor WPML compatibility.
 *
 * @package GBE
 */

namespace GradientButtonElementor\Compatibility;

/**
 * Class GBE_Wpml.
 */
class GBE_Wpml {

	/**
	 * Member Variable
	 *
	 * @var instance
	 */
	private static $instance;

	/**
	 *  Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		// WPML String Translation plugin exist check.
		if ( is_wpml_string_translation_active() && class_exists( 'WPML_Elementor_Module_With_Items' ) ) {
			$wpml_version = defined( 'ICL_SITEPRESS_VERSION' ) ? true : false;

			if ( $wpml_version ) {
				add_filter( 'wpml_elementor_widgets_to_translate', array( $this, 'translatable_widgets' ) );
			}
		}
	}

	/**
	 * Widgets to translate.
	 *
	 * @since 1.0.4
	 * @param array $widgets Widget array.
	 * @return array
	 */
	public function translatable_widgets( $widgets ) {
		$widgets['bloompixel-gradient-button']   = array(
			'conditions' => array( 'widgetType' => 'bloompixel-gradient-button' ),
			'fields'     => array(
				array(
					'field'       => 'text',
					'type'        => __( 'Gradient Button : Text', 'gradient-button-for-elementor' ),
					'editor_type' => 'LINE',
				),
				'link' => array(
					'field'       => 'url',
					'type'        => __( 'Gradient Button : Link', 'gradient-button-for-elementor' ),
					'editor_type' => 'LINK',
				),
			),
		);
		
		return $widgets;
	}
}

/**
 *  Prepare if class 'GBE_Wpml' exist.
 *  Kicking this off by calling 'get_instance()' method
 */
GBE_Wpml::get_instance();