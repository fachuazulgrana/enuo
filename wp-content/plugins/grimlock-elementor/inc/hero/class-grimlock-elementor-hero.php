<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Grimlock_Elementor_Hero
 *
 * @author  themosaurus
 * @since   1.0.0
 * @package grimlock-elementor
 */
class Grimlock_Elementor_Hero {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'grimlock_hero_displayed', array( $this, 'hero_displayed' ), 20, 1 );
	}

	/**
	 * Add conditions for the hero display.
	 *
	 * @since 1.0.0
	 *
	 * @param  bool $default True when the hero has to be displayed, false otherwise.
	 *
	 * @return bool          True when the hero has to be displayed, false otherwise.
	 */
	public function hero_displayed( $default ) {
		return $default || ( is_page_template( 'elementor_header_footer' ) && is_front_page() );
	}
}