<?php

class Dlm_Aam_Shortcode_Filter {

	/**
	 * Setup shortcode filter class
	 */
	public function setup() {

		// add settings
		add_filter( 'download_monitor_settings', array( $this, 'add_setting' ) );

		// check if compatibility has been enabled
		if ( '1' == get_option( 'dlm_aam_shortcode_hide_no_access', 0 ) ) {
			add_filter( 'dlm_shortcode_downloads_downloads', array( $this, 'filter_downloads' ), 10, 1 );
		}

	}

	/**
	 * Add settings
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function add_setting( $settings ) {
		$settings['access'][1][] = array(
			'name'     => 'dlm_aam_shortcode_hide_no_access',
			'std'      => '',
			'label'    => __( 'Hide Downloads?', 'dlm-advanced-access-manager' ),
			'cb_label' => sprintf( __( 'Hide downloads in %s overview that user has no access to.', '' ), '<code>[downloads]</code>' ),
			'desc'     => sprintf( __( "Let Advanced Access Manager filter your downloads displayed by %s and remove downloads that the current user has no access to", 'dlm-advanced-access-manager' ), '<code>[downloads]</code>' ),
			'type'     => 'checkbox',
		);

		return $settings;
	}

	/**
	 * Filter download
	 *
	 * @param DLM_Download $downloads
	 *
	 * @return DLM_Download
	 */
	public function filter_downloads( $downloads ) {

		$access_manager = new Dlm_Aam_Access_Manager();

		if ( ! empty( $downloads ) ) {
			foreach ( $downloads as $dk => $download ) {
				if ( ! $access_manager->has_access_to_download( $download ) ) {
					unset( $downloads[ $dk ] );
				}
			}
		}

		return $downloads;
	}

}