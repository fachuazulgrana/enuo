<?php

class DLM_Buttons_Fonts {

	/**
	 * Return available fonts. Filterable via 'dlm_buttons_available_fonts'
	 *
	 * @return array
	 */
	public static function get_available_fonts() {
		return apply_filters( 'dlm_buttons_available_fonts', array(
			'Arial',
			'Helvetica',
			'Times New Roman',
			'Times',
			'Courier New',
			'Courier',
			'Verdana',
			'Georgia',
			'Palatino',
			'Garamond',
			'Bookman',
			'cursive',
			'Impact',
			'Gadget'
		) );
	}
}