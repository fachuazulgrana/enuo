<?php

class DLM_Buttons_Config {

	/** @var string */
	private $template_name;

	/** @var string */
	private $bg_color_1;

	/** @var string */
	private $bg_color_2;

	/** @var int */
	private $border_thickness;

	/** @var string */
	private $border_color;

	/** @var int */
	private $border_radius;

	/** @var string */
	private $font;

	/** @var string */
	private $font_color;

	/** @var int */
	private $font_size;

	/** @var string */
	private $text;

	/** @var int */
	private $text_shadow;

	/**
	 * @return string
	 */
	public function get_template_name() {
		return $this->template_name;
	}

	/**
	 * @param string $template_name
	 */
	public function set_template_name( $template_name ) {
		$this->template_name = $template_name;
	}

	/**
	 * @return string
	 */
	public function get_bg_color_1() {
		return $this->bg_color_1;
	}

	/**
	 * @param string $bg_color_1
	 */
	public function set_bg_color_1( $bg_color_1 ) {
		$this->bg_color_1 = $bg_color_1;
	}

	/**
	 * @return string
	 */
	public function get_bg_color_2() {
		return $this->bg_color_2;
	}

	/**
	 * @param string $bg_color_2
	 */
	public function set_bg_color_2( $bg_color_2 ) {
		$this->bg_color_2 = $bg_color_2;
	}

	/**
	 * @return int
	 */
	public function get_border_thickness() {
		return $this->border_thickness;
	}

	/**
	 * @param int $border_thickness
	 */
	public function set_border_thickness( $border_thickness ) {
		$this->border_thickness = $border_thickness;
	}

	/**
	 * @return string
	 */
	public function get_border_color() {
		return $this->border_color;
	}

	/**
	 * @param string $border_color
	 */
	public function set_border_color( $border_color ) {
		$this->border_color = $border_color;
	}

	/**
	 * @return int
	 */
	public function get_border_radius() {
		return $this->border_radius;
	}

	/**
	 * @param int $border_radius
	 */
	public function set_border_radius( $border_radius ) {
		$this->border_radius = $border_radius;
	}

	/**
	 * @return string
	 */
	public function get_font() {
		return $this->font;
	}

	/**
	 * @param string $font
	 */
	public function set_font( $font ) {
		$this->font = $font;
	}

	/**
	 * @return string
	 */
	public function get_font_color() {
		return $this->font_color;
	}

	/**
	 * @param string $font_color
	 */
	public function set_font_color( $font_color ) {
		$this->font_color = $font_color;
	}

	/**
	 * @return int
	 */
	public function get_font_size() {
		return $this->font_size;
	}

	/**
	 * @param int $font_size
	 */
	public function set_font_size( $font_size ) {
		$this->font_size = $font_size;
	}

	/**
	 * @return string
	 */
	public function get_text() {
		return $this->text;
	}

	/**
	 * @param string $text
	 */
	public function set_text( $text ) {
		$this->text = $text;
	}

	/**
	 * @return int
	 */
	public function get_text_shadow() {
		return $this->text_shadow;
	}

	/**
	 * @param int $text_shadow
	 */
	public function set_text_shadow( $text_shadow ) {
		$this->text_shadow = intval( $text_shadow );
	}

}