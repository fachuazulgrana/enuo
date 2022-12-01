<?php

class DLM_DP_Settings {

	/**
	 * Add settings to DLM settings
	 *
	 * @param $settings
	 *
	 * @return mixed
	 */
	public static function add_settings( $settings ) {

		$settings['downloading_page'] = array(
			__( 'Downloading Page', 'dlm-downloading-page' ),
			array(
				array(
					'name'    => DLM_DP_Constants::SETTING_PAGE,
					'std'     => '',
					'label'   => __( 'Downloading Page', 'dlm-downloading-page' ),
					'desc'    => __( "Select what page should be displayed as the 'downloading page'.", 'dlm-downloading-page' ),
					'type'    => 'select',
					'options' => self::get_pages()
				),
			)
		);

		return $settings;
	}

	/**
	 * Get Pages for settings
	 *
	 * @return array
	 */
	private static function get_pages() {
		// pages
		$pages = array( 0 => __( 'Select Page', 'download-monitor' ) );

		// get pages from db
		$db_pages = get_pages();

		// check and loop
		if ( count( $db_pages ) > 0 ) {
			foreach ( $db_pages as $db_page ) {
				$pages[ $db_page->ID ] = $db_page->post_title;
			}
		}

		// return pages
		return $pages;
	}

}