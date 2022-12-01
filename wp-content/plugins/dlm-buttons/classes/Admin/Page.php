<?php

class DLM_Buttons_Admin_Page {

	private function run_delete() {

		if ( empty( $_GET['dlm_buttons_button_delete_nonce'] ) || ! wp_verify_nonce( $_GET['dlm_buttons_button_delete_nonce'], 'dlm-buttons-delete-config-wow' ) ) {
			// This nonce is not valid.
			wp_die( __( "Request to delete a Buttons template didn't pass our security checks. If you requested this yourself, please try again. If the request fails again, please contact support.", 'dlm-buttons' ) );
		}


		// delete config
		$repo = new DLM_Buttons_Config_Repository();
		$repo->delete( $_GET['dlm_buttons_button_delete'] );

	}

	/**
	 * Display the overview of all templates
	 */
	private function page_overview() {
		if ( ! class_exists( 'WP_List_Table' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
		}

		$list_table = new DLM_Buttons_Admin_Page_List_Table();
		$list_table->prepare_items();
		?>
        <div class="wrap dlm-buttons-admin-wrap">
            <div id="icon-edit" class="icon32 icon32-posts-dlm_download"><br/></div>

            <h1><?php _e( 'Download Monitor - Buttons', 'dlm-buttons' ); ?></h1><br/>

            <h2><?php _e( 'Create a new template', 'dlm-buttons' ); ?></h2>
            <p><?php _e( "Add a new template by entering a unique name in the form below and clicking the 'Add Template' button.", 'dlm-buttons' ); ?></p>
            <form id="dlm_buttons_new" method="post">
                <input type="text" name="dlm_buttons_new_template_name" class="dlm_buttons_new_template_name" value=""/>
                <input name="save" type="submit" class="button button-primary button-large"
                       id="dlm_buttons_new_form_button"
                       value="<?php _e( 'Add Template', 'dlm-buttons' ); ?>">
            </form>

            <h2><?php _e( 'Existing Templates', 'dlm-buttons' ); ?></h2>
            <p><?php _e( 'Below is an overview of your existing templates. You can edit or delete the template by hovering the row you wish to edit/delete.', 'dlm-buttons' ); ?></p>
            <form id="dlm_buttons" method="post">
				<?php $list_table->display() ?>
            </form>
        </div>
		<?php
	}

	/**
	 * Displays the detail page of one template
	 */
	private function page_detail() {
		$repo   = new DLM_Buttons_Config_Repository();
		$config = $repo->retrieve_single( $_GET['dlm_buttons_button'] );

		download_monitor()->service( 'view_manager' )->display(
			'button-configurator',
			array(
				'config' => $config
			),
			plugin_dir_path( DLM_Buttons::get_plugin_file() ) . 'assets/views/'
		);
	}

	public function setup() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ), 10 );
	}

	/**
	 * Add submenu to page
	 */
	public function add_admin_menu() {
		// Settings page
		add_submenu_page( 'edit.php?post_type=dlm_download', __( 'Buttons', 'dlm-buttons' ), __( 'Buttons', 'dlm-buttons' ), 'manage_downloads', 'dlm-buttons', array(
			$this,
			'view'
		) );
	}

	/**
	 * Display content of page
	 */
	public function view() {

		// check if user is allowed to do this
		if ( ! current_user_can( 'manage_downloads' ) ) {
			wp_die( __( "You're not allowed to view this page. If you think you should be able to see this page, please contact support.", 'dlm-buttons' ) );
		}

		if ( isset( $_GET['dlm_buttons_button_delete'] ) && ! empty( $_GET['dlm_buttons_button_delete'] ) ) {
			$this->run_delete();
		}

		if ( ! empty( $_GET['dlm_buttons_button'] ) ) {
			$this->page_detail();
		} else {
			$this->page_overview();
		}

		return;
	}

}
