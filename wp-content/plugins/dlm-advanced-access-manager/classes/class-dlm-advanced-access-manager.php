<?php

class DLM_Advanced_Access_Manager {

	const VERSION = '4.0.0';

	/**
	 * Constructor
	 */
	public function __construct() {

		// Do dependency checks
		$dependency_manager = new Dlm_Aam_Dependency_Manager();
		if ( ! $dependency_manager->is_compatible() ) {
			$dependency_manager->display_notices();

			return;
		}

		// setup the custom database table variable
		$this->setup_db_var();

		// Load plugin text domain
		load_plugin_textdomain( 'dlm-advanced-access-manager', false, dirname( plugin_basename( DLM_AAM_FILE ) ) . '/languages/' );

		// admin only code
		if ( is_admin() ) {

			// add 'global rules' page
			$grp = new Dlm_Aam_Global_Rules_Page();
			$grp->setup();

			// enqueue table scripts & styles
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

			// setup meta box
			$meta_box = new Dlm_Aam_Meta_Box();
			$meta_box->setup();

			// setup delete_post hook to clean up rules on post delete
			$rules_manager = new Dlm_Aam_Rule_Manager();
			add_action( 'delete_post', array( $rules_manager, 'delete_rules' ), 10, 1 );

		} else { // frontend only code

			// setup access manager
			$access_manager = new Dlm_Aam_Access_Manager();
			$access_manager->setup_filter();
		}

		// shortcode filter
		$shortcode_filter = new Dlm_Aam_Shortcode_Filter();
		$shortcode_filter->setup();

		// PA Compatibility
		$pa_compat = new Dlm_Aam_Pa_Compat();
		$pa_compat->setup();

		// AJAX
		$ajax = new Dlm_Aam_Ajax();
		$ajax->bind();

		// Register Extension
		add_filter( 'dlm_extensions', array( $this, 'register_extension' ) );
	}

	/**
	 * Set the custom database table variable in $wpdb
	 */
	private function setup_db_var() {
		global $wpdb;

		// table for rules
		$wpdb->dlm_aam_rules = $wpdb->prefix . 'dlm_aam_rules';
	}

	/**
	 * Enqueue plugin assets
	 */
	public function enqueue_scripts() {
		global $pagenow, $post;

		if (
			( $pagenow == 'post.php' && isset( $post->post_type ) && 'dlm_download' == $post->post_type ) ||
			( $pagenow == 'post-new.php' && isset( $_GET['post_type'] ) && 'dlm_download' == $_GET['post_type'] ) ||
			( isset( $_GET['page'] ) && 'dlm_aam_global_rules' == $_GET['page'] )
		) {

			// jQuery datepicker
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_style( 'jquery-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );

			// rules table CSS
			wp_enqueue_style(
				'dlm_aam_rules_table_css',
				plugins_url( '/assets/css/rules-table.css', DLM_AAM_FILE ),
				array(),
				DLM_Advanced_Access_Manager::VERSION
			);

			// rules table JS
			wp_enqueue_script(
				'dlm_aam_rules_table_js',
				plugins_url( '/assets/js/rules-table' . ( ( ! WP_DEBUG ) ? '.min' : '' ) . '.js', DLM_AAM_FILE ),
				array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-sortable' ),
				DLM_Advanced_Access_Manager::VERSION
			);

			// roles
			$roles = array();

			// get editable roles
			$editable_roles = get_editable_roles();

			// check, loop & add to $roles
			if ( count( $editable_roles ) > 0 ) {
				foreach ( $editable_roles as $role_key => $role ) {
					$roles[] = array(
						'key'  => $role_key,
						'name' => $role['name']
					);
				}
			}

			// localize script
			wp_localize_script( 'dlm_aam_rules_table_js', 'dlm_aam_rules', array(
				'roles'                     => json_encode( $roles ),
				'str_none'                  => __( 'None', 'dlm-advanced-access-manager' ),
				'str_download_limit'        => __( 'Download Limit', 'dlm-advanced-access-manager' ),
				'str_global_download_limit' => __( 'Global Download Limit', 'dlm-advanced-access-manager' ),
				'str_daily_amount'          => __( 'Daily Download Limit', 'dlm-advanced-access-manager' ),
				'str_daily_global_amount'   => __( 'Daily Global Download Limit', 'dlm-advanced-access-manager' ),
				'str_date_limit'            => __( 'Date Limit', 'dlm-advanced-access-manager' ),
				'str_start_date'            => __( 'Start Date', 'dlm-advanced-access-manager' ),
				'str_end_date'              => __( 'End Date', 'dlm-advanced-access-manager' ),
				'str_remove'                => __( 'Remove', 'dlm-advanced-access-manager' ),
				'str_anyone'                => __( 'Anyone', 'dlm-advanced-access-manager' ),
				'str_role'                  => __( 'Role', 'dlm-advanced-access-manager' ),
				'str_user'                  => __( 'User', 'dlm-advanced-access-manager' ),
				'str_ip'                    => __( 'IP', 'dlm-advanced-access-manager' ),
				'str_no'                    => __( 'No', 'dlm-advanced-access-manager' ),
				'str_yes'                   => __( 'Yes', 'dlm-advanced-access-manager' ),

			) );

		}

	}

	/**
	 * Register this extension
	 *
	 * @param array $extensions
	 *
	 * @return array $extensions
	 */
	public function register_extension( $extensions ) {

		$extensions[] = array(
			'file'    => 'dlm-advanced-access-manager',
			'version' => self::VERSION,
			'name'    => 'Advanced Access Manager'
		);

		return $extensions;
	}

}