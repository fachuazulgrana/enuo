<?php

class DLM_Buttons_Assets {

	/**
	 * Setup enqueue actions
	 */
	public function setup() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend' ) );
	}

	/**
	 * Enqueue admin assets
	 */
	public function enqueue_admin() {
		global $pagenow;

		if ( 'edit.php' == $pagenow && isset( $_GET['page'] ) && 'dlm-buttons' === $_GET['page'] ) {

			// Enqueue admin CSS
			wp_enqueue_style(
				'dlm_buttons_admin',
				plugins_url( '/assets/css/dlm-buttons-admin.css', DLM_Buttons::get_plugin_file() ),
				array(),
				DLM_Buttons::VERSION
			);

			// JS for editing buttons
			if ( isset( $_GET['dlm_buttons_button'] ) ) {
				// enqueue dat color picker
				wp_enqueue_style( 'wp-color-picker' );

				// enqueue admin JS
				wp_enqueue_script(
					'dlm_buttons_admin_js',
					plugins_url( '/assets/js/dlm-buttons-admin' . ( ( ! SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', DLM_Buttons::get_plugin_file() ),
					array( 'jquery', 'wp-color-picker' ),
					DLM_Buttons::VERSION
				);

				// js vars
				wp_localize_script( 'dlm_buttons_admin_js', 'dlm_buttons_strings', array(
					'button_preview_url_base' => add_query_arg( array(
						'dlm_buttons_preview' => '1',
					), site_url( '/', 'admin' ) ),
					'nonce_save_template'     => wp_create_nonce( 'dlm-buttons-save-template-nonce' ),
					'img_loader'              => plugins_url( '/assets/images/ajax-loader.gif', download_monitor()->get_plugin_file() ),
					'lbl_button_saved'        => __( 'Button saved', 'dlm-buttons' )
				) );
			} else {
				// overview page
				// enqueue admin JS
				wp_enqueue_script(
					'dlm_buttons_admin_overview_js',
					plugins_url( '/assets/js/dlm-buttons-overview' . ( ( ! SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', DLM_Buttons::get_plugin_file() ),
					array( 'jquery' ),
					DLM_Buttons::VERSION
				);

				wp_localize_script( 'dlm_buttons_admin_overview_js', 'dlm_buttons_overview_strings', array(
					'button_edit_url_base'      => admin_url( 'edit.php?post_type=dlm_download&page=dlm-buttons' ),
					'nonce_add_template'        => wp_create_nonce( 'dlm-buttons-add-template-nonce' ),
					'error_empty_template_name' => __( 'Please enter a template name', 'dlm-buttons' )
				) );
			}


		}

	}

	/**
	 * Enqueue frontend assets
	 */
	public function enqueue_frontend() {

		// only enqueue preview stylesheet when we're in the preview
		if ( isset( $_GET['dlm_buttons_preview'] ) ) {
			// Enqueue admin css
			wp_enqueue_style(
				'dlm_buttons_admin',
				plugins_url( '/assets/css/dlm-buttons-preview.css', DLM_Buttons::get_plugin_file() ),
				array(),
				DLM_Buttons::VERSION
			);
		}
	}

}