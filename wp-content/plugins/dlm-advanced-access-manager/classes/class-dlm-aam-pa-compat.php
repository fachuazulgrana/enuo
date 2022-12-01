<?php

/**
 * Class Dlm_Aam_Pa_Compat
 */
class Dlm_Aam_Pa_Compat {

	/**
	 * Setup Page Addon compatibility
	 */
	public function setup() {

		// check if Page Addon class exists
		if ( class_exists( 'WP_DLM_Page_Addon' ) ) {

			// add settings
			add_filter( 'download_monitor_settings', array( $this, 'add_setting' ) );

			// check if compatibility has been enabled
			if ( '1' == get_option( 'dlm_aam_pa_hide_no_access', 0 ) ) {

				// filter downloads
				add_filter( 'dlm_page_addon_featured_downloads', array( $this, 'filter_downloads' ) );
				add_filter( 'dlm_page_addon_category_downloads', array( $this, 'filter_downloads' ) );
				add_filter( 'dlm_page_addon_downloads_term_list', array( $this, 'filter_downloads' ) );
				add_filter( 'dlm_page_addon_search_results', array( $this, 'filter_downloads' ) );

				// filter detail info page
				add_filter( 'dlm_page_addon_download_info', array( $this, 'filter_download_info' ) );

				// filter tags
				add_filter( 'dlm_page_addon_tags', array( $this, 'filter_tags' ) );
			}

		}
	}

	/**
	 * Add PA compat setting
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function add_setting( $settings ) {
		$settings['access'][1][] = array(
			'name'     => 'dlm_aam_pa_hide_no_access',
			'std'      => '',
			'label'    => __( 'Hide PA Downloads?', 'dlm-advanced-access-manager' ),
			'cb_label' => __( 'Hide downloads in Page Addon overview that user has not access to.', '' ),
			'desc'     => __( "Note that this only works with the 'normal' Page Addon downloads and e.g. not with featured downloads or tags.", 'dlm-advanced-access-manager' ),
			'type'     => 'checkbox',
		);

		return $settings;
	}

	/**
	 * Filter downloads
	 *
	 * @param array $downloads
	 *
	 * @return array
	 */
	public function filter_downloads( $downloads ) {

		if ( count( $downloads ) > 0 ) {

			$access_manager = new Dlm_Aam_Access_Manager();

			foreach ( $downloads as $d_key => $download ) {
				if ( ! $access_manager->has_access_to_download( $download ) ) {
					unset( $downloads[ $d_key ] );
				}
			}

		}

		return $downloads;
	}

	/**
	 * Filter tags
	 *
	 * @param array $tags
	 *
	 * @return array
	 */
	public function filter_tags( $tags ) {
		if ( count( $tags ) > 0 ) {

			// access manager object
			$access_manager = new Dlm_Aam_Access_Manager();

			/** @var DLM_Download_Repository $repo */
			$repo = download_monitor()->service( 'download_repository' );

			// loop tags
			foreach ( $tags as $t_key => $tag ) {

				// fetch all downloads of this tag
				$downloads = $repo->retrieve( array(
					'tax_query' => array(
						array(
							'taxonomy' => 'dlm_download_tag',
							'field'    => 'slug',
							'terms'    => $tag->slug
						)
					)
				) );

				// loop and check access per download
				if ( count( $downloads ) > 0 ) {
					/** @var DLM_Download $download */
					foreach ( $downloads as $d_key => $download ) {
						if ( ! $access_manager->has_access_to_download( $download ) ) {
							unset( $downloads[ $d_key ] );
						}
					}
				}

				// update new count
				$tag->count = count( $downloads );

				// remove tag if there are no download left
				if ( 0 == count( $downloads ) ) {
					unset( $tags[ $t_key ] );
				}
			}
		}

		return $tags;
	}

	/**
	 * Filter download of download info page
	 *
	 * @param DLM_Download $download
	 *
	 * @throws Exception
	 *
	 * @return DLM_Download
	 */
	public function filter_download_info( $download ) {

		// access manager
		$access_manager = new Dlm_Aam_Access_Manager();

		// check access
		if ( ! $access_manager->has_access_to_download( $download ) ) {
			// we can throw an exception here because this is in a try/catch block in PA
			throw new Exception( "No access due to rule restriction" );
		}

		return $download;
	}

}