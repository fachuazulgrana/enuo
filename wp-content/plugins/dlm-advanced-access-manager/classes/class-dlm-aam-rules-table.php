<?php

class Dlm_Aam_Rules_Table {

	/** @var int */
	private $download_id;

	/**
	 * Create a Rules Table object for given download ID. If ID is 0, global rules will be loaded.
	 *
	 * @param int $download_id
	 */
	public function __construct( $download_id ) {
		$this->download_id = $download_id;
	}

	/**
	 * Output table
	 */
	public function display() {
		Dlm_Aam_Views::display( 'rules-table', array(
			'download_id' => $this->download_id
		) );
	}

}