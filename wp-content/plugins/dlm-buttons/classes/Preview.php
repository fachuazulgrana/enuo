<?php

class DLM_Buttons_Preview {

	/**
	 * Setup the preview hooks
	 */
	public function setup() {
		add_action( 'template_redirect', array( $this, 'catch_preview_request' ), 999 );
	}

	/**
	 * This method will setup a new DLM_Buttons_Config object based on parameters in the URL ($_GET)
	 *
	 * @return DLM_Buttons_Config
	 */
	private function get_config_from_url() {
		$config = new DLM_Buttons_Config();

		if ( isset( $_GET['bg_color_1'] ) ) {
			$config->set_bg_color_1( $_GET['bg_color_1'] );
		}

		if ( isset( $_GET['bg_color_2'] ) ) {
			$config->set_bg_color_2( $_GET['bg_color_2'] );
		}

		if ( isset( $_GET['border_thickness'] ) ) {
			$config->set_border_thickness( intval( $_GET['border_thickness'] ) );
		}

		if ( isset( $_GET['border_color'] ) ) {
			$config->set_border_color( $_GET['border_color'] );
		}

		if ( isset( $_GET['border_radius'] ) ) {
			$config->set_border_radius( intval( $_GET['border_radius'] ) );
		}

		if ( isset( $_GET['font'] ) ) {
			$config->set_font( $_GET['font'] );
		}

		if ( isset( $_GET['font_color'] ) ) {
			$config->set_font_color( $_GET['font_color'] );
		}

		if ( isset( $_GET['font_size'] ) ) {
			$config->set_font_size( intval( $_GET['font_size'] ) );
		}

		if ( isset( $_GET['text'] ) ) {
			$config->set_text( nl2br( $_GET['text'] ) );
		}

		if ( isset( $_GET['text_shadow'] ) ) {
			$config->set_text_shadow( intval( $_GET['text_shadow'] ) );
		}

		return $config;
	}

	/**
	 * This method returns a dummy download for preview purposes
	 *
	 * @return DLM_Download
	 */
	private function get_dummy_download() {

		// create download
		$download = new DLM_Download();

		$download->set_title( 'Preview Title' );

		// create version
		$version = new DLM_Download_Version();
		$version->set_version( 'Preview Version' );
		$version->set_filename( 'preview.pdf' );
		$version->set_download_count( 1337 );
		$version->set_filesize( '9000000' );

		// set version
		$download->set_version($version);

		return $download;
	}

	/**
	 * Output the button preview HTML
	 */
	private function output_html() {
		echo '<!DOCTYPE html>
<html lang="en-US" class="no-js">
<head>';
		do_action( 'wp_head' );
		echo '</head>
			<body><table><tr><td valign="middle">';

		// template handler
		$template_handler = new DLM_Template_Handler();

		// load template
		$template_handler->get_template_part(
			'button',
			'',
			plugin_dir_path( DLM_Buttons::get_plugin_file() ) . 'templates/',
			array(
				'dlm_buttons_config' => $this->get_config_from_url(),
				'dlm_download'       => $this->get_dummy_download()
			)
		);

		echo '</td></tr></table></body>
			</html>';
	}


	/**
	 * Catch the preview request. Setup custom HTML but output WordPress head part.
	 */
	public function catch_preview_request() {
		// check if this is a buttons preview request
		if ( isset( $_GET['dlm_buttons_preview'] ) ) {

			// remove the admin bar styling
			remove_action( 'wp_head', '_admin_bar_bump_cb' );

			// it is, output HTML
			$this->output_html();
			exit;
		}
	}

}