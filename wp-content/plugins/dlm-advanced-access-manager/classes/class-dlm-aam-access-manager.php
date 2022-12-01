<?php

class Dlm_Aam_Access_Manager {

	/**
	 * Check if requester has access to download
	 *
	 * @param DLM_Download $download
	 *
	 * @return bool
	 */
	public function has_access_to_download( $download ) {

		// default has_access to true
		$has_access = true;

		// rules manager
		$rules_manager = new Dlm_Aam_Rule_Manager();

		// get rules for download
		$rules = array_merge( $rules_manager->get_rules( $download->get_id() ), $rules_manager->get_global_rules( $download->get_id() ) );

		/** @var Dlm_Aam_Rule $rule */
		foreach ( $rules as $rule ) {

			// check if rule applies
			if ( $rule->applies() ) {

				// check if rule allows download
				if ( $rule->is_can_download() ) {

					// check if there are restrictions
					if ( $rule->meets_restriction() ) {
						$has_access = true;
						break; // we've found a matching rule, so break
					}

				} else {
					// matches rule forbids downloads, always set to false
					$has_access = false;

					break; // we've found a matching rule, so break
				}
			}
		}

		return $has_access;
	}

	/**
	 * Callback for our 'dlm_can_download' filter
	 *
	 * @param boolean $can_download
	 * @param DLM_Download $download
	 * @param DLM_Download_Version $version
	 *
	 * @return mixed
	 */
	public function dlm_can_download_callback( $can_download, $download, $version ) {

		// only do checks if $can_download is still true
		if ( true === $can_download ) {
			$can_download = $this->has_access_to_download( $download );
		}

		// return
		return $can_download;
	}

	/**
	 * Setup filter
	 */
	public function setup_filter() {
		add_filter( 'dlm_can_download', array( $this, 'dlm_can_download_callback' ), 11, 3 );
	}
}