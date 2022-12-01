<?php

class DLM_Buttons_Config_Repository {

	/**
	 * Craetes a DLM_Buttons_Config object from a DB row
	 *
	 * @param $row
	 *
	 * @return DLM_Buttons_Config
	 */
	private function create_config_object_from_row( $row ) {
		$config = new DLM_Buttons_Config();
		$config->set_template_name( $row->template_name );
		$config->set_bg_color_1( $row->bg_color_1 );
		$config->set_bg_color_2( $row->bg_color_2 );
		$config->set_border_thickness( $row->border_thickness );
		$config->set_border_color( $row->border_color );
		$config->set_border_radius( $row->border_radius );
		$config->set_font( $row->font );
		$config->set_font_color( $row->font_color );
		$config->set_font_size( $row->font_size );
		$config->set_text( $row->text );
		$config->set_text_shadow( $row->text_shadow );

		// return config object
		return $config;
	}

	public function retrieve_single( $template_name ) {
		global $wpdb;

		$row = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM `" . $wpdb->prefix . "dlm_buttons` WHERE `template_name` = %s ;",
				$template_name
			)
		);

		if ( null === $row ) {
			throw new Exception( 'Template not found' );
		}

		return $this->create_config_object_from_row( $row );
	}

	/**
	 * Fetches all templates from DB
	 *
	 * @param int $limit
	 * @param int $offset
	 * @param string $order_by
	 * @param string $order
	 *
	 * @throws Exception
	 *
	 * @return array<DLM_Buttons_Config>
	 */
	public function retrieve( $limit = 0, $offset = 0, $order_by = 'template_name', $order = 'ASC' ) {
		global $wpdb;

		// setup limit & offset
		$limit_str = "";
		$limit     = absint( $limit );
		$offset    = absint( $offset );
		if ( $limit > 0 ) {
			$limit_str = "LIMIT {$offset},{$limit}";
		}

		// escape order_by
		$order_by = esc_sql( $order_by );

		// order can only be ASC or DESC
		$order = ( 'DESC' === strtoupper( $order ) ) ? 'DESC' : 'ASC';

		$items = array();

		$sql = "SELECT * FROM `" . $wpdb->prefix . "dlm_buttons` ORDER BY `{$order_by}` {$order} {$limit_str};";

		// fetch from db
		$rows = $wpdb->get_results( $sql );

		// check for result
		if ( null === $rows ) {
			throw new Exception( 'Error fetching all config' );
		}

		if ( count( $rows ) > 0 ) {
			foreach ( $rows as $row ) {
				$items[] = $this->create_config_object_from_row( $row );
			}
		}

		return $items;
	}

	/**
	 * Persist a config
	 *
	 * @param DLM_Buttons_Config $config
	 *
	 * @return DLM_Buttons_Config
	 */
	public function persist( $config ) {
		global $wpdb;

		// delete old entry
		$delete_sql = $wpdb->prepare(
			"DELETE FROM `" . $wpdb->prefix . "dlm_buttons` WHERE `template_name` = %s ;",
			$config->get_template_name() );
		$wpdb->query( $delete_sql );

		// insert new entry
		$wpdb->insert(
			$wpdb->prefix . "dlm_buttons",
			array(
				'template_name'    => $config->get_template_name(),
				'bg_color_1'       => $config->get_bg_color_1(),
				'bg_color_2'       => $config->get_bg_color_2(),
				'border_thickness' => $config->get_border_thickness(),
				'border_color'     => $config->get_border_color(),
				'border_radius'    => $config->get_border_radius(),
				'font'             => $config->get_font(),
				'font_color'       => $config->get_font_color(),
				'font_size'        => $config->get_font_size(),
				'text'             => $config->get_text(),
				'text_shadow'      => $config->get_text_shadow()
			),
			array(
				'%s',
				'%s',
				'%s',
				'%d',
				'%s',
				'%d',
				'%s',
				'%s',
				'%d',
				'%s',
				'%d',
			)
		);

		return $config;
	}

	/**
	 * Returns number of rows
	 *
	 * @return int
	 */
	public function num_rows() {
		global $wpdb;

		return $wpdb->get_var( "SELECT COUNT(`template_name`) FROM `" . $wpdb->prefix . "dlm_buttons`;" );
	}

	/**
	 * Delete Config row
	 *
	 * @param string $template_name
	 *
	 * @return bool
	 */
	public function delete( $template_name ) {
		global $wpdb;

		return ( false !== $wpdb->delete( $wpdb->prefix . "dlm_buttons", array( 'template_name' => $template_name ), array( '%s' ) ) );
	}

}