<?php

class Dlm_Aam_Views {

	/**
	 * Returns view directory
	 *
	 * @return string
	 */
	private static function get_views_dir() {
		return plugin_dir_path( DLM_AAM_FILE ) . '/view/';
	}

	/**
	 * Display a view
	 *
	 * @param String $view
	 * @param array $vars
	 */
	public static function display( $view, $vars ) {

		// setup variables
		extract( $vars );

		// setup full view path
		$view = self::get_views_dir() . $view . '.php';

		// check if view exists
		if ( file_exists( $view ) ) {

			// load view
			include( $view );
		}
	}

}