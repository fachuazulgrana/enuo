<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Function that is called on plugin activation
 *
 * @param bool $network_wide
 */
function __dlm_aam_install( $network_wide = false ) {

	// check if it's multisite
	if ( is_multisite() && true == $network_wide ) {

		// get websites
		$sites = wp_get_sites();

		// loop
		if ( count( $sites ) > 0 ) {
			foreach ( $sites as $site ) {

				// switch to blog
				switch_to_blog( $site['blog_id'] );

				// run installer on blog
				__dlm_aam_create_db_table();

				// restore current blog
				restore_current_blog();
			}
		}

	} else {
		// no multisite so do normal install
		__dlm_aam_create_db_table();
	}

}

/**
 * Function to create the DB table
 */
function __dlm_aam_create_db_table() {
	global $wpdb;

	$wpdb->hide_errors();

	// get the DB collate
	$collate = '';

	if ( $wpdb->has_cap( 'collation' ) ) {
		if ( ! empty( $wpdb->charset ) ) {
			$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
		}
		if ( ! empty( $wpdb->collate ) ) {
			$collate .= " COLLATE $wpdb->collate";
		}
	}

	// we need this for dbDelta()
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	// table SQL
	$dlm_aam_table = "
	CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "dlm_aam_rules` (
	  ID BIGINT(20) NOT NULL auto_increment,
	  download_id BIGINT(20) NOT NULL,
	  can_download TINYINT(1) NOT NULL,
	  `group` VARCHAR(200) NULL,
	  group_value VARCHAR(200) NULL,
	  restriction VARCHAR(200) NULL,
	  restriction_value VARCHAR(200) NULL,
	  PRIMARY KEY  (ID)
	) $collate;
	";

	// create table
	dbDelta( $dlm_aam_table );
}

/**
 * Create rules table new blogs on multisite when plugin is network activated
 *
 * @param $blog_id
 * @param $user_id
 * @param $domain
 * @param $path
 * @param $site_id
 * @param $meta
 */
function __dlm_aam_mu_new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {

	// check if plugin is network activated
	if ( is_plugin_active_for_network( 'dlm-advanced-access-manager/dlm-advanced-access-manager.php' ) ) {

		// switch to new blog
		switch_to_blog( $blog_id );

		// create table on blog
		__dlm_aam_create_db_table();

		// restore current blog
		restore_current_blog();
	}
}
/**
 * Delete rules table on multisite when blog is deleted
 *
 * @param $tables
 *
 * @return array
 */
function __dlm__aam_mu_delete_blog( $tables ) {
	global $wpdb;
	$tables[] = $wpdb->prefix . 'dlm_aam_rules';

	return $tables;
}