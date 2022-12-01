<?php

class Dlm_Aam_Ajax {

	/**
	 * Bind AJAX actions
	 */
	public function bind() {
		add_action( 'wp_ajax_dlm_aam_get_rules', array( $this, 'get_rules' ) );
	}

	/**
	 * AJAX callback for 'dlm_aam_get_rules'
	 */
	public function get_rules() {

		// nonce
		check_ajax_referer( Dlm_Aam_Constants::NONCE_AJAX, 'nonce' );

		// check if download ID is set
		if ( ! isset( $_POST['download_id'] ) ) {
			exit;
		}

		// download ID
		$download_id = absint( $_POST['download_id'] );

		// get rules
		$rule_manager = new Dlm_Aam_Rule_Manager();
		$rules        = $rule_manager->get_rules( $download_id );

		// format rules to JSON
		$rules_arr = array();

		// check & loop
		if ( count( $rules ) > 0 ) {
			foreach ( $rules as $rule ) {
				$rules_arr[] = $rule->to_array();
			}
		}

		// send JSON
		wp_send_json( $rules_arr );
		exit;
	}

}