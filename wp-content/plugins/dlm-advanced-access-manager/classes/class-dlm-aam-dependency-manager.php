<?php

class Dlm_Aam_Dependency_Manager {

	private $version_req = '4.0.0';

	/**
	 * Check if Download Monitor exists
	 *
	 * @return bool
	 */
	private function core_exists() {
		// check for Download Monitor
		return defined( 'DLM_VERSION' );
	}

	/**
	 * Check if core version requirement is met, 4.0.0 in this case
	 *
	 * @return bool
	 */
	private function version_requirement_met() {
		return version_compare( DLM_VERSION, $this->version_req, '>=' );
	}

	/**
	 * Check if all dependencies are met
	 *
	 * @return bool
	 */
	public function is_compatible() {

		// check for Download Monitor
		if ( ! $this->core_exists() ) {
			return false;
		}

		// check Download Monitor version
		if ( ! $this->version_requirement_met() ) {
			return false;
		}

		return true;
	}

	/**
	 * Display dependency notices
	 */
	public function display_notices() {

		if ( ! $this->core_exists() ) {
			add_action( 'admin_notices', array( $this, 'notice_core' ) );

			return false;
		}

		if ( ! $this->version_requirement_met() ) {
			add_action( 'admin_notices', array( $this, 'notice_version' ) );

			return false;
		}

	}

	/**
	 * Core notice
	 */
	public function notice_core() {
		?>
		<div class="error">
			<p><?php _e( 'Download Monitor needs to be installed and activated for the Advanced Access Manager!', 'dlm-advanced-access-manager' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Core notice
	 */
	public function notice_version() {
		?>
		<div class="error">
			<p><?php printf( __( 'Download Monitor needs to be updated to at least version %s for the Advanced Access Manager!', 'dlm-advanced-access-manager' ), '<strong>' . $this->version_req . '</strong>' ); ?></p>
		</div>
		<?php
	}

}