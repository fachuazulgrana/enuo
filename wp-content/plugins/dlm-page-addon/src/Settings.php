<?php

class DLM_PA_Settings {

	/**
	 * setup
	 */
	public function setup() {
		add_filter( 'download_monitor_settings', array( $this, 'add_settings' ) );
		$this->register_lazy_load_callbacks();
	}

	/**
	 * Add settings to DLM settings
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function add_settings( $settings ) {

		$settings['page_addon'] = array(
			__( 'Page Addon', 'dlm-page-addon' ),
			array(
				array(
					'name'     => 'dlm_pa_search_results_page',
					'std'      => '',
					'label'    => __( 'Search -> Page Addon Page', 'dlm-page-addon' ),
					'cb_label' => __( 'Enable', 'dlm-page-addon' ),
					'desc'     => sprintf( __( 'Select a page to have downloads in search results link to your Page Addon page. Select the page that the search results should link to. Note that this page should have the %s shortcode.', 'dlm-page-addon' ), "<code>[download_page]</code>" ),
					'type'    => 'lazy_select',
					'options' => array()
				),
			)
		);

		return $settings;
	}

	/**
	 * Register lazy load setting fields callbacks
	 */
	public function register_lazy_load_callbacks() {
		add_filter( 'dlm_settings_lazy_select_dlm_pa_search_results_page', array( $this, 'lazy_select_dlm_pa_search_results_page' ) );
	}

	/**
	 * Fetch and returns pages on lazy select for dlm_no_access_page option
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function lazy_select_dlm_pa_search_results_page( $options ) {
		return $this->get_pages();
	}

	/**
	 * Return pages with ID => Page title format
	 *
	 * @return array
	 */
	private function get_pages() {

		// pages
		$pages = array( array( 'key' => 0, 'lbl' => __( 'No Page / Disable functionality', 'download-monitor' ) ) );

		// get pages from db
		$db_pages = get_pages();

		// check and loop
		if ( count( $db_pages ) > 0 ) {
			foreach ( $db_pages as $db_page ) {
				$pages[] = array( 'key' => $db_page->ID, 'lbl' => $db_page->post_title );
			}
		}

		// return pages
		return $pages;
	}

}