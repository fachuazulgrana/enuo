<?php

class Dlm_Aam_Global_Rules_Page {

	/**
	 * Setup hooks
	 */
	public function setup() {
		add_action( 'admin_menu', array( $this, 'add_global_rules_page' ), 13 );
	}

	/**
	 * Add sub menu page
	 */
	public function add_global_rules_page() {
		// Settings page
		add_submenu_page( 'edit.php?post_type=dlm_download', __( 'Global Rules', 'dlm-advanced-access-manager' ), __( 'Global Rules', 'dlm-advanced-access-manager' ), 'manage_options', 'dlm_aam_global_rules', array(
			$this,
			'page_output'
		) );
	}

	/**
	 * Handle the post action
	 */
	private function handle_post() {
		if ( isset( $_POST['dlm_aam_nonce'] ) ) {

			// nonce check #1
			if ( ! isset( $_POST['dlm_aam_nonce'] ) ) {
				return;
			}

			// nonce check #2
			if ( ! wp_verify_nonce( $_POST['dlm_aam_nonce'], Dlm_Aam_Constants::NONCE_MB ) ) {
				return;
			}

			// autosave check
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// capabilities
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// rules manager
			$rules_manager = new Dlm_Aam_Rule_Manager();

			// remove old rules
			$rules_manager->delete_rules( 0 );

			// add new rules
			if ( isset( $_POST['dlm-aam-rules'] ) && count( $_POST['dlm-aam-rules'] ) > 0 ) {

				// rule properties
				$rule_properties = array(
					'group',
					'group_value',
					'restriction',
					'restriction_value'
				);

				// loop
				foreach ( $_POST['dlm-aam-rules'] as $new_rule ) {

					// set null for unset properties
					foreach ( $rule_properties as $rule_property ) {
						// check if rule isn't set or if rule is 'null' (string)
						if ( ! isset( $new_rule[ $rule_property ] ) || 'null' == $new_rule[ $rule_property ] ) {
							$new_rule[ $rule_property ] = null; // set property to null
						}
					}

					// add rule
					$rules_manager->add_rule( 0, $new_rule['can_download'], $new_rule['group'], $new_rule['group_value'], $new_rule['restriction'], $new_rule['restriction_value'] );
				}
			}

		}
	}

	/**
	 * Page output
	 */
	public function page_output() {


		// handle post
		$this->handle_post();

		// create rules table object
		$rules_table = new Dlm_Aam_Rules_Table( 0 );

		// wrapper
		?>
		<div class="wrap">
			<h2><?php _e( 'Advanced Access Manager - Global Rules', 'dlm-advanced-access-manager' ); ?></h2>

			<form action="" method="post">
				<div id='dlm-aam-rules' class="dlm-aam-general-rules-wrapper">
					<?php $rules_table->display(); ?>
				</div>
				<input type="submit" name="Submit" value="<?php _e( 'Save Rules', 'dlm-advanced-access-manager' ); ?>" class="button button-primary button-large"/>
			</form>
		</div>
		<?php
	}

}