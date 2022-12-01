<?php

/**
 * DLM_Logging_List_Table class.
 *
 * @extends WP_List_Table
 */
class DLM_Buttons_Admin_Page_List_Table extends WP_List_Table {

	private $items_per_page = 25;

	/**
	 * __construct function.
	 *
	 * @access public
	 */
	public function __construct() {

		parent::__construct( array(
			'singular' => 'button',
			'plural'   => 'buttons',
			'ajax'     => false
		) );

		$this->items_per_page = ! empty( $_REQUEST['items_per_page'] ) ? intval( $_REQUEST['items_per_page'] ) : 25;

		if ( $this->items_per_page < 1 ) {
			$this->items_per_page = 9999999999999;
		}
	}

	/**
	 * Add bulk actions
	 *
	 * @return array
	 */
	protected function get_bulk_actions() {
		return array();
	}

	private function get_buttons_admin_url() {
		return admin_url( 'edit.php?post_type=dlm_download&page=dlm-buttons' );
	}

	/**
	 * column_default function.
	 *
	 * @access public
	 *
	 * @param DLM_Buttons_Config $config
	 * @param mixed $column_name
	 *
	 * @return string
	 */
	public function column_default( $config, $column_name ) {
		switch ( $column_name ) {
			case 'template' :
				$return = "
				<strong><a class='row-title' href='" . add_query_arg( 'dlm_buttons_button', $config->get_template_name(), $this->get_buttons_admin_url() ) . "'>" . $config->get_template_name() . "</a></strong>
				<div class='row-actions'>
                    <span class='edit'>
                        <a href='" . add_query_arg( 'dlm_buttons_button', $config->get_template_name(), $this->get_buttons_admin_url() ) . "'>Edit</a> |
                    </span>
                    <span class='trash'>
                        <a href='" . add_query_arg( array(
						'dlm_buttons_button_delete'       => $config->get_template_name(),
						'dlm_buttons_button_delete_nonce' => wp_create_nonce( 'dlm-buttons-delete-config-wow' )
					), $this->get_buttons_admin_url() ) . "'>Delete</a>
                    </span>
				</div>
				";

				return $return;
				break;
			case 'shortcode':
				return '<code>[download id="DOWNLOAD_ID" template="dlm-buttons-' . $config->get_template_name() . '"]</code>';
				break;
			default:
				return '';
				break;
		}
	}

	/**
	 * get_columns function.
	 *
	 * @access public
	 * @return array
	 */
	public function get_columns() {
		$columns = array(
			'template'  => __( 'Template Name', 'dlm-buttons' ),
			'shortcode' => __( 'Shortcode', 'dlm-buttons' )
		);

		return $columns;
	}

	/**
	 * Sortable columns
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		return array(
			'template' => array( 'template_name', false )
		);
	}

	/**
	 * Generate the table navigation above or below the table
	 */
	public function display_tablenav( $which ) {
		?>
        <div class="tablenav <?php echo esc_attr( $which ); ?>">
			<?php
			$this->extra_tablenav( $which );
			$this->pagination( $which );
			?>
            <br class="clear"/>
        </div>
		<?php
	}

	/**
	 * prepare_items function.
	 *
	 * @access public
	 * @return void
	 */
	public function prepare_items() {

		// Init headers
		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );

		$per_page     = absint( $this->items_per_page );
		$current_page = absint( $this->get_pagenum() );

		// setup filters

		// check for order
		$order_by = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'template_name';
		$order    = ( ! empty( $_GET['order'] ) ) ? $_GET['order'] : 'ASC';

		$repository = new DLM_Buttons_Config_Repository();

		$total_items = $repository->num_rows();
		$this->items = $repository->retrieve( $per_page, ( ( $current_page - 1 ) * $per_page ), $order_by, $order );

		// Pagination
		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
			'total_pages' => ( ( $total_items > 0 ) ? ceil( $total_items / $per_page ) : 1 )
		) );
	}

}
