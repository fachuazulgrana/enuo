<?php

class DLM_Buttons_Button_Generator {


	/**
	 * Generate the CSS styling for button with given config
	 *
	 * @param DLM_Buttons_Config $config
	 *
	 * @return string
	 */
	private function generate_styling( $config ) {
		$css = sprintf(
			'display:block;padding:.75em 1em;text-align:center;text-decoration:none;border: %dpx solid #%s;border-radius:%dpx;font-family:%s;font-size:%dpx;color:#%s;background:#%s;background: linear-gradient(to bottom, #%s,#%s);',
			$config->get_border_thickness(),
			$config->get_border_color(),
			$config->get_border_radius(),
			$config->get_font(),
			$config->get_font_size(),
			$config->get_font_color(),
			$config->get_bg_color_1(),
			$config->get_bg_color_1(),
			$config->get_bg_color_2()
		);

		if ( 1 === $config->get_text_shadow() ) {
			$css .= 'text-shadow: 0 -1px 0 rgba(0,0,0,.5);';
		}

		return $css;
	}

	/**
	 * Generates the full button HTML including needed CSS
	 *
	 * @param DLM_Buttons_Config $config
	 * @param DLM_Download $download
	 *
	 * @return string
	 */
	public function generate( $config, $download ) {

		//var_dump( $config );

		$return = '
		<a href="' . $download->get_the_download_link() . '" class="dlm-buttons-button dlm-buttons-button-' . esc_attr( $config->get_template_name() ) . '" style="' . $this->generate_styling( $config ) . '">' . DLM_Buttons_Text::process_text( $config->get_text(), $download ) . '</a>
		';

		return $return;
	}

}