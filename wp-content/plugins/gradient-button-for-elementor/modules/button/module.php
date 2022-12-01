<?php
namespace GradientButtonElementor\Modules\Button;

use GradientButtonElementor\Base\Module_Base;

class Module extends Module_Base {

	public function __construct() {
		parent::__construct();

		// This is here for extensibility purposes - go to town and make things happen!
	}
	
	public function get_name() {
		return 'bloompixel-gradient-button';
	}

	public function get_widgets() {
		return [
			'Gradient_Button', // What is it goes here. This should match the widget/element class - the file name should also match but in small caps!
		];
	}
	
}