<?php

class Dlm_Aam_Meta_Box {

	/**
	 * Setup actions
	 */
	public function setup() {
		// setup meta box hook
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_meta_box' ), 10, 2 );
	}

	/**
	 * Add meta box to download edit screen
	 */
	public function add_meta_box() {

		// add meta box
		add_meta_box( 'dlm-aam-rules', __( 'Advanced Access Rules', 'dlm-advanced-access-manager' ),
			array( $this, 'meta_box_output' ), 'dlm_download', 'normal', 'high' );

	}

	/**
	 * The meta box output
	 *
	 * @param WP_Post $post
	 */
	public function meta_box_output( $post ) {

		// create rules table object
		$rules_table = new Dlm_Aam_Rules_Table( $post->ID );

		// display that table \o/
		$rules_table->display();
	}

	/**
	 * Save meta box data
	 *
	 * @param int $post_id
	 * @param WP_Post $post
	 */
	public function save_meta_box( $post_id, $post ) {

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

		// post type check
		if ( 'dlm_download' != $post->post_type ) {
			return;
		}

		// capabilities
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// rules manager
		$rules_manager = new Dlm_Aam_Rule_Manager();

		// remove old rules
		$rules_manager->delete_rules( $post_id );

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
				$rules_manager->add_rule( $post_id, $new_rule['can_download'], $new_rule['group'], $new_rule['group_value'], $new_rule['restriction'], $new_rule['restriction_value'] );
			}
		}
	}

}