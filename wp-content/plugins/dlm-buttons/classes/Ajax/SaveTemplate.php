<?php

class DLM_Buttons_Save_Template {

	public function setup() {
		add_action( 'wp_ajax_dlm_buttons_save_template', array( $this, 'run' ) );
	}

	public function run() {

		// check ajax referer
		check_ajax_referer( 'dlm-buttons-save-template-nonce', 'security' );

		// check if user is allowed to do this
		if ( ! current_user_can( 'manage_downloads' ) ) {
			die();
		}

		$template_name = sanitize_title( $_POST['template_name'] );
		$options       = $_POST['options'];

		// create config object
		$config = new DLM_Buttons_Config();
		$config->set_template_name( $template_name );
		$config->set_bg_color_1( $options['bg_color_1'] );
		$config->set_bg_color_2( $options['bg_color_2'] );
		$config->set_border_thickness( $options['border_thickness'] );
		$config->set_border_color( $options['border_color'] );
		$config->set_border_radius( $options['border_radius'] );
		$config->set_font( $options['font'] );
		$config->set_font_color( $options['font_color'] );
		$config->set_font_size( $options['font_size'] );
		$config->set_text( str_ireplace( PHP_EOL, "", nl2br( $options['text'] ) ) );
		$config->set_text_shadow( $options['text_shadow'] );

		// persist
		$button_repo = new DLM_Buttons_Config_Repository();
		$button_repo->persist( $config );

		wp_send_json( array( 'success' => true ) );

		// the end
		die();

	}

}