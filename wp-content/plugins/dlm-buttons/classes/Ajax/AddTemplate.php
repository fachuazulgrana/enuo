<?php

class DLM_Buttons_Add_Template {

	public function setup() {
		add_action( 'wp_ajax_dlm_buttons_add_template', array( $this, 'run' ) );
	}

	public function run() {

		// check ajax referer
		check_ajax_referer( 'dlm-buttons-add-template-nonce', 'security' );

		// check if user is allowed to do this
		if ( ! current_user_can( 'manage_downloads' ) ) {
			die();
		}

		// sanitize title
		$template_name = sanitize_title( $_POST['template_name'] );

		// get default config object
		$config_factory = new DLM_Buttons_Config_Factory();
		$config         = $config_factory->create_new_config();
		$config->set_template_name( $template_name );

		// button repository
		$button_repo = new DLM_Buttons_Config_Repository();

		// try to persist
		try {
			$button_repo->persist( $config );
		} catch ( Exception $e ) {
			wp_send_json( array(
				'success'      => false,
				'errorMessage' => _( 'Error saving button template.', 'dlm-buttons' )
			) );
		}


		wp_send_json( array( 'success' => true, 'template_name' => $template_name ) );

		// the end
		die();

	}

}