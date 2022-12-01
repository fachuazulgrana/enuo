<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class DLM_DP_Access_Manager {

	private $redirect_to_download_page = false;

	/** @var DLM_Download */
	private $download = null;

	/**
	 * Setup class
	 */
	public function setup() {

		// we're preventing access to all requests that are not from the download page and with correct nonce
		add_filter( 'dlm_can_download', array( $this, 'check_access' ), 100, 3 );


		add_filter( 'dlm_access_denied_redirect', array( $this, 'download_page_redirect' ) );
	}


	/**
	 * Check if requester has access to download
	 *
	 * @param $has_access
	 * @param $download
	 * @param $version
	 *
	 * @return bool
	 */
	public function check_access( $has_access, $download, $version ) {

		// don't continue if access is already false
		if ( false == $has_access ) {
			return $has_access;
		}

		// default to no access
		$has_access                      = false;
		$this->redirect_to_download_page = true;
		$this->download                  = $download;

		// check if the force get is set and the nonce is set
		if ( ! empty( $_GET[ DLM_DP_Constants::GET_KEY_DL_FORCE ] ) && ! empty( $_GET[ DLM_DP_Constants::GET_KEY_NONCE ] ) ) {

			// verify nonce
			if ( wp_verify_nonce( $_GET[ DLM_DP_Constants::GET_KEY_NONCE ], 'dlm-dp-download-nonce' . DLM_Utils::get_visitor_ip() ) ) {

				// all checks out. Set access to true and reset internal variables to default
				$has_access                      = true;
				$this->redirect_to_download_page = false;
				$this->download                  = null;
			}

		}


		// return $has_access
		return $has_access;
	}

	/**
	 * Redirect to download page if we denied access
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	public function download_page_redirect( $url ) {

		// check if we're redirecting
		if ( $this->redirect_to_download_page && ! is_null( $this->download ) ) {

			// get downloading page
			$downloading_page_id = absint( get_option( DLM_DP_Constants::SETTING_PAGE, 0 ) );

			// check if a downloading page is found
			if ( $downloading_page_id > 0 ) {

				// get permalink of downloading page
				$downloading_page_permalink = get_permalink( $downloading_page_id );

				// check if we can find a permalink
				if ( false !== $downloading_page_permalink ) {

					// append download id to no access URL
					$url = add_query_arg( DLM_DP_Constants::GET_KEY_ID, $this->download->get_id(), untrailingslashit( $downloading_page_permalink ) );

					// check if download version is set
					if ( ! empty( $_GET['version'] ) ) {
						$url = add_query_arg( 'version', $_GET['version'], $url );
					}
				}

			}

		}

		return $url;
	}

	/**
	 * Generate download nonce
	 *
	 * @return string
	 */
	public static function generate_nonce() {
		return wp_create_nonce( 'dlm-dp-download-nonce' . DLM_Utils::get_visitor_ip() );
	}

}
