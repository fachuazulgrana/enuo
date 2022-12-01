<?php

class Dlm_Aam_Rule_Manager {

	/**
	 * Get rules of given download ID
	 *
	 * @param int $download_id
	 * @param int $target_download_id
	 *
	 * @return array<Dlm_Aam_Rule>
	 */
	public function get_rules( $download_id, $target_download_id = 0 ) {
		global $wpdb;

		// set $target_download_id to $download_id if 0
		if ( 0 == $target_download_id ) {
			$target_download_id = $download_id;
		}

		// rules
		$rules = array();

		// get rules from DB
		$rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `{$wpdb->dlm_aam_rules}` WHERE `download_id` = %d ORDER BY `ID` ASC;", $download_id ) );

		// check, loop
		if ( count( $rows ) > 0 ) {
			foreach ( $rows as $row ) {
				$rules[] = new Dlm_Aam_Rule( $target_download_id, ( 1 == $row->can_download ), $row->group, $row->group_value, $row->restriction, $row->restriction_value );
			}
		}

		return $rules;
	}

	/**
	 * Get the global rules
	 *
	 * @param int $download_id
	 *
	 * @return array
	 */
	public function get_global_rules( $download_id ) {
		return $this->get_rules( 0, $download_id );
	}

	/**
	 * Deletes all rules of given download
	 *
	 * @param int $download_id
	 */
	public function delete_rules( $download_id ) {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "DELETE FROM `{$wpdb->dlm_aam_rules}` WHERE `download_id` = %d ;", $download_id ) );
	}

	/**
	 * Add a rule
	 *
	 * @param int $download_id
	 * @param int $can_download
	 * @param string $group
	 * @param string $group_value
	 * @param string $restriction
	 * @param string $restriction_value
	 */
	public function add_rule( $download_id, $can_download, $group, $group_value, $restriction, $restriction_value ) {
		global $wpdb;

		// these are always ints
		$download_id  = absint( $download_id );
		$can_download = absint( $can_download );

		// prepare group
		if ( null !== $group ) {
			$group = "'" . esc_sql( $group ) . "'";
		} else {
			$group = 'NULL';
		}

		// prepare group value
		if ( null !== $group_value ) {
			$group_value = "'" . esc_sql( $group_value ) . "'";
		} else {
			$group_value = 'NULL';
		}

		// prepare restriction
		if ( null !== $restriction ) {
			$restriction = "'" . esc_sql( $restriction ) . "'";
		} else {
			$restriction = 'NULL';
		}

		// check for array restriction value
		if ( is_array( $restriction_value ) ) {
			$restriction_value = implode( "|", $restriction_value );
		}

		// prepare restriction value
		if ( null !== $restriction_value ) {
			$restriction_value = "'" . esc_sql( $restriction_value ) . "'";
		} else {
			$restriction_value = 'NULL';
		}

		// build sql
		$sql = sprintf( "INSERT INTO `{$wpdb->dlm_aam_rules}` (`download_id`, `can_download`, `group`, `group_value`, `restriction`, `restriction_value` ) VALUES ( %d, %d, %s, %s, %s, %s ) ;",
			$download_id, $can_download, $group, $group_value, $restriction, $restriction_value );

		// query sql
		$wpdb->query( $sql );
	}

}