<?php

class DLM_Buttons_Config_Factory {

	/**
	 * Create a config object with default values
	 *
	 * @return DLM_Buttons_Config
	 */
	public function create_new_config() {

		// create config with default values
		$config = new DLM_Buttons_Config();
		$config->set_bg_color_1( '009fd4' );
		$config->set_bg_color_2( '0086b2' );
		$config->set_border_thickness( 1 );
		$config->set_border_color( '0086b2' );
		$config->set_border_radius( 5 );
		$config->set_font( 'Helvetica' );
		$config->set_font_color( 'ffffff' );
		$config->set_font_size( 23 );
		$config->set_text( "Download <strong>%name%</strong><br /><small>%filename% - %filesize%</small>" );
		$config->set_text_shadow( 1 );

		return $config;
	}

}