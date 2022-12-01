<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class DLM_Buttons_Installer {

	/**
	 * Install all requirements for Download Monitor
	 */
	public function install() {
		// Create Database Table
		$this->install_tables();
	}


	/**
	 * install_tables function.
	 *
	 * @return void
	 */
	private function install_tables() {
		global $wpdb;

		$wpdb->hide_errors();

		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
		}

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$dlm_tables = "
	CREATE TABLE `" . $wpdb->prefix . "dlm_buttons` 
	( 
	  `template_name` VARCHAR(191) NOT NULL , 
	  `bg_color_1` VARCHAR(6) NOT NULL , 
	  `bg_color_2` VARCHAR(6) NOT NULL , 
	  `border_thickness` INT(3) NOT NULL , 
	  `border_color` VARCHAR(6) NOT NULL , 
	  `border_radius` INT(3) NOT NULL , 
	  `font` VARCHAR(255) NOT NULL , 
	  `font_color` VARCHAR(6) NOT NULL , 
	  `font_size` INT(3) NOT NULL , 
	  `text` TEXT NOT NULL ,
	  `text_shadow` INT(1) NOT NULL,
	  PRIMARY KEY (`template_name`)
	) $collate;
	";
		dbDelta( $dlm_tables );
	}

}