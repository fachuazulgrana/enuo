<?php
/**
 * Grimlock_Login_Navigation_Customizer Class
 *
 * @author  Themosaurus
 * @since   1.0.0
 * @package grimlock
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Grimlock Login Navigation Customizer class.
 */
class Grimlock_Login_Navigation_Customizer extends Grimlock_Navigation_Customizer {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct();
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
	}

	/**
	 * Enqueue custom styles based on theme mods.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {
		$styles = "
		.login #login > h1 a {
			background-color: {$this->get_theme_mod( 'navigation_background_color' )};
		}";
		wp_add_inline_style( 'grimlock-login-login', $styles );
	}
}

return new Grimlock_Login_Navigation_Customizer();
