<?php

/**
 * Class Dlm_Aam_Rule
 *
 * The rule class
 */
class Dlm_Aam_Rule {

	/** @var  int */
	private $download_id;

	/** @var boolean */
	private $can_download;

	/** @var String */
	private $group;

	/** @var String */
	private $group_value;

	/** @var String */
	private $restriction;

	/** @var String */
	private $restriction_value;

	/**
	 * Constructor
	 *
	 * @param int $download_id
	 * @param boolean $can_download
	 * @param String $group
	 * @param String $group_value
	 * @param String $restriction
	 * @param String $restriction_value
	 */
	public function __construct( $download_id, $can_download, $group, $group_value, $restriction, $restriction_value ) {
		$this->download_id       = $download_id;
		$this->can_download      = $can_download;
		$this->group             = (string) $group;
		$this->group_value       = (string) $group_value;
		$this->restriction       = (string) $restriction;
		$this->restriction_value = (string) $restriction_value;
	}

	/**
	 * @return int
	 */
	public function get_download_id() {
		return $this->download_id;
	}

	/**
	 * @param int $download_id
	 */
	public function set_download_id( $download_id ) {
		$this->download_id = $download_id;
	}

	/**
	 * @return String
	 */
	public function get_group_value() {
		return $this->group_value;
	}

	/**
	 * @param String $group_value
	 */
	public function set_group_value( $group_value ) {
		$this->group_value = $group_value;
	}

	/**
	 * @return String
	 */
	public function get_group() {
		return $this->group;
	}

	/**
	 * @param String $group
	 */
	public function set_group( $group ) {
		$this->group = $group;
	}

	/**
	 * @return boolean
	 */
	public function is_can_download() {
		return $this->can_download;
	}

	/**
	 * @param boolean $can_download
	 */
	public function set_can_download( $can_download ) {
		$this->can_download = $can_download;
	}

	/**
	 * @return String
	 */
	public function get_restriction() {
		return $this->restriction;
	}

	/**
	 * @param String $restriction
	 */
	public function set_restriction( $restriction ) {
		$this->restriction = $restriction;
	}

	/**
	 * @return String
	 */
	public function get_restriction_value() {
		return $this->restriction_value;
	}

	/**
	 * @param String $restriction_value
	 */
	public function set_restriction_value( $restriction_value ) {
		$this->restriction_value = $restriction_value;
	}

	/**
	 * Check if a row applies
	 *
	 * @return bool
	 */
	public function applies() {

		/**
		 * Solving this with a simple switch statement now.
		 * This could later be replaced with a Factory pattern that return an extend of an 'Apply' class which contains an `does_apply()` method.
		 */

		// rule doesn't apply by default
		$applies = false;


		switch ( $this->get_group() ) {
			case 'role':
				$current_user = wp_get_current_user();
				if ( ( $current_user instanceof WP_User ) && 0 != $current_user->ID ) {
					if ( in_array( $this->get_group_value(), $current_user->roles ) ) {
						$applies = true;
					}
				}
				break;
			case 'user':
				$current_user = wp_get_current_user();
				if ( ( $current_user instanceof WP_User ) && 0 != $current_user->ID ) {
					if ( $this->get_group_value() == $current_user->user_login ) {
						$applies = true;
					}
				}
				break;
			case 'ip':
				if ( $this->get_group_value() == $_SERVER['REMOTE_ADDR'] ) {
					$applies = true;
				}
				break;
			case '': // empty string = anyone
				$applies = true;
				break;
		}

		return $applies;
	}

	/**
	 * Check if restriction is met
	 *
	 * @return bool
	 */
	public function meets_restriction() {

		// restriction met by default
		$meets_restriction = true;

		if ( '' != $this->get_restriction() ) {

			// return true if restriction is amount, global_amount, daily_amount, daily_global_amount and the user is in the 60 sec download window
			if ( 'date' != $this->get_restriction() ) {
				if ( DLM_Cookie_Manager::exists( new DLM_Download( $this->get_download_id() ) ) ) {
					return true;
				}
			}

			switch ( $this->get_restriction() ) {
				case 'amount':
					global $wpdb;

					// get amount of times this IP address downloaded file
					$amount_downloaded = absint( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(ID) FROM {$wpdb->download_log} WHERE `download_id` = %d AND `user_ip` = %s AND `download_status` IN ( 'completed', 'redirected' )", $this->get_download_id(), DLM_Utils::get_visitor_ip() ) ) );

					// check if times download is equal to or larger than allowed amount
					if ( $amount_downloaded >= $this->get_restriction_value() ) {

						// nope
						$meets_restriction = false;
					}

					break;
				case 'global_amount':
					global $wpdb;

					// get amount of times this IP address downloaded file
					$amount_downloaded = absint( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(ID) FROM {$wpdb->download_log} WHERE `user_ip` = %s AND `download_status` IN ( 'completed', 'redirected' )", DLM_Utils::get_visitor_ip() ) ) );

					// check if times download is equal to or larger than allowed amount
					if ( $amount_downloaded >= $this->get_restriction_value() ) {

						// nope
						$meets_restriction = false;
					}
					break;
				case 'daily_amount':
					global $wpdb;

					// get amount of times this IP address downloaded file
					$amount_downloaded = absint( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(ID) FROM {$wpdb->download_log} WHERE `download_id` = %d AND `user_ip` = %s AND DATE(`download_date`) = DATE(NOW()) AND `download_status` IN ( 'completed', 'redirected' )", $this->get_download_id(), DLM_Utils::get_visitor_ip() ) ) );

					// check if times download is equal to or larger than allowed amount
					if ( $amount_downloaded >= $this->get_restriction_value() ) {

						// nope
						$meets_restriction = false;
					}
					break;
				case 'daily_global_amount':
					global $wpdb;

					// get amount of times this IP address downloaded file
					$amount_downloaded = absint( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(ID) FROM {$wpdb->download_log} WHERE `user_ip` = %s AND DATE(`download_date`) = DATE(NOW()) AND `download_status` IN ( 'completed', 'redirected' )", DLM_Utils::get_visitor_ip() ) ) );

					// check if times download is equal to or larger than allowed amount
					if ( $amount_downloaded >= $this->get_restriction_value() ) {

						// nope
						$meets_restriction = false;
					}
					break;
				case 'date':

					// get value & explode
					$dates = explode( '|', $this->get_restriction_value() );

					// count check
					if ( 2 == count( $dates ) ) {

						// now
						$now = new DateTime();
						$now->setTime( 0, 0, 0 );

						// start date
						$start_date = new DateTime( $dates[0] );

						// end date
						$end_date = new DateTime( $dates[1] );
						$end_date->setTime( 23, 59, 59 );

						// do check
						if ( $start_date > $now || $end_date < $now ) {
							$meets_restriction = false;
						}

					}


					break;
			}

		}

		return $meets_restriction;
	}

	/**
	 * Get JSON string for this object
	 *
	 * @return array
	 */
	public function to_array() {
		return array(
			'download_id'       => $this->get_download_id(),
			'can_download'      => $this->is_can_download(),
			'group'             => $this->get_group(),
			'group_value'       => $this->get_group_value(),
			'restriction'       => $this->get_restriction(),
			'restriction_value' => $this->get_restriction_value()
		);
	}

}