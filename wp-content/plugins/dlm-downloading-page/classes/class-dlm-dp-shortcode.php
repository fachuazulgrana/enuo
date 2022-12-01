<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class DLM_DP_Shortcode {

	private static $js_printed = false;

	public function setup() {
		// Register the shortcode
		add_shortcode( 'dlm_downloading_page', array( $this, 'content' ) );

		// WP frontend styling
		add_action( 'wp_head', array( $this, 'add_meta_to_head' ), 10 );
	}

	/**
	 * The dlm_email_lock shortcode
	 *
	 * @return string
	 */
	public function content( $atts ) {

		// get atts
		$atts = wp_parse_args( $atts, array(
			'template' => dlm_get_default_download_template()
		) );

		// shortcode content
		$content = '';

		// check for GET_KEY_ID
		if ( ! empty( $_GET[ DLM_DP_Constants::GET_KEY_ID ] ) ) {

			// create download object
			try {
				$download = download_monitor()->service( 'download_repository' )->retrieve_single( absint( $_GET[ DLM_DP_Constants::GET_KEY_ID ] ) );


				// Alright, all good. Load the template.
				ob_start();

				// Template handler
				$template_handler = new DLM_Template_Handler();

				// Load template
				$template_handler->get_template_part( 'downloading-page', $atts['template'], plugin_dir_path( DLM_Downloading_Page::get_plugin_file() ) . 'templates/', array(
					'url' => $this->generate_forced_download_url( $download ),
					'download' => $download
				) );

				$content = ob_get_clean();


			} catch ( Exception $exception ) {
				// download not found.
			}


		}

		return $content;
	}

	/**
	 * Print the email lock styles
	 */
	public function add_meta_to_head() {


		if ( isset( $_GET[ DLM_DP_Constants::GET_KEY_ID ] ) && absint( get_option( DLM_DP_Constants::SETTING_PAGE, 0 ) ) == get_the_ID() ) {

			// create download object
			try {
				$download = download_monitor()->service( 'download_repository' )->retrieve_single( absint( $_GET[ DLM_DP_Constants::GET_KEY_ID ] ) );

				$url = $this->generate_forced_download_url( $download );

				$dlm_dp_automated_start_seconds = absint( apply_filters( 'dlm_dp_automated_start_seconds', 3, $download ) );

				echo '<meta http-equiv="refresh" content="' . $dlm_dp_automated_start_seconds . '; url=' . $url . '">' . PHP_EOL;
			} catch ( Exception $exception ) {
				// download not found
			}

		}

	}

	/**
	 * Generate the download URL that will actually download the file instead of redirecting to the downloading page
	 *
	 * @param DLM_Download $download
	 *
	 * @todo add nonce so the DLM_DP_Constants::GET_KEY_DL_FORCE can't be directly linked
	 *
	 * @return string
	 */
	private function generate_forced_download_url( $download ) {
		$url = add_query_arg( array(
			DLM_DP_Constants::GET_KEY_DL_FORCE => 1,
			DLM_DP_Constants::GET_KEY_NONCE    => DLM_DP_Access_Manager::generate_nonce()
		), $download->get_the_download_link() );

		if ( ! empty ( $_GET['version'] ) ) {
			$url = add_query_arg( 'version', $_GET['version'], $url );
		}

		return $url;
	}

}
