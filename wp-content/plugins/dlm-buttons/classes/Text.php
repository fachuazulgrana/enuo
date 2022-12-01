<?php

class DLM_Buttons_Text {

	/**
	 * Returns the available text variables. Filterable via 'dlm_buttons_text_available_variables'.
	 *
	 * @return array
	 */
	public static function get_available_variables() {
		return apply_filters( 'dlm_buttons_text_available_variables', array(
			'name',
			'version',
			'download_count',
			'filename',
			'filesize'
		) );
	}

	/**
	 * Returns the allowed HTML tags in button text. Filterable via 'dlm_buttons_text_allowed_html_tags'.
	 *
	 * @return array
	 */
	public static function get_allowed_html_tags() {
		return apply_filters( 'dlm_buttons_text_allowed_html_tags', array(
			'b',
			'strong',
			'i',
			'em',
			'u',
			'small',
			'br'
		) );
	}

	/**
	 * Process the button text. This includes variable replacement, cleaning unwanted tags and proper escaping
	 * Replace the variables in config text with download data
	 *
	 * @param string $text
	 * @param DLM_Download $download
	 *
	 * @return string
	 */
	public static function process_text( $text, $download ) {

		// replace variables
		$text = str_replace( '%name%', $download->get_title(), $text );
		$text = str_replace( '%version%', $download->get_version()->get_version(), $text );
		$text = str_replace( '%download_count%', $download->get_download_count(), $text );
		$text = str_replace( '%filename%', $download->get_version()->get_filename(), $text );
		$text = str_replace( '%filesize%', $download->get_version()->get_filesize_formatted(), $text );

		// remove unwanted tags
		$text = strip_tags( $text, '<' . implode( '><', DLM_Buttons_Text::get_allowed_html_tags() ) . '>' );

		return $text;
	}

}