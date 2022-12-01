<?php

class DLM_Buttons_Template_Handler {

	/**
	 * Setup actions
	 */
	public function setup() {
		add_filter( 'dlm_get_template_part', array( $this, 'inject_template' ), 10, 3 );
		add_action( 'dlm_get_template_part_args', array( $this, 'inject_variables' ), 10, 4 );
	}

	/**
	 * Checks if given template name is a DLM_Buttons template
	 *
	 * @param $name
	 *
	 * @return bool
	 */
	private function is_buttons_template( $name ) {
		if ( "dlm-buttons-" === substr( $name, 0, 12 ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Strips the 'dlm-buttons-' part of from the template name, what is left is the real template name
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	private function get_button_template_name( $name ) {
		return substr( $name, 12 );
	}

	/**
	 * Inject our custom template into
	 *
	 * @param $template
	 * @param $slug
	 * @param $name
	 *
	 * @return string
	 */
	public function inject_template( $template, $slug, $name ) {
		if ( $this->is_buttons_template( $name ) ) {
			return plugin_dir_path( DLM_Buttons::get_plugin_file() ) . 'templates/button.php';
		}

		return $template;
	}

	/**
	 * Inject custom button variables so they are available in our template file
	 *
	 * @param $args
	 * @param $template
	 * @param $slug
	 * @param $name
	 *
	 * @return $args
	 */
	public function inject_variables( $args, $template, $slug, $name ) {
		if ( $this->is_buttons_template( $name ) ) {

			// fetch the config
			$button_repo = new DLM_Buttons_Config_Repository();

			try {
				$config                     = $button_repo->retrieve_single( $this->get_button_template_name( $name ) );
				$args['dlm_buttons_config'] = $config;
			} catch ( Exception $e ) {
				// no action needed, the template will thrown an error because 'dlm_buttons_config' is missing
			}

		}

		return $args;

	}

}