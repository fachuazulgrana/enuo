<?php

if ( ! isset( $dlm_buttons_config ) ) {
	echo 'ERROR: Button config not passed to template file.';

	return;
}

// generate button
$generator = new DLM_Buttons_Button_Generator();
echo $generator->generate( $dlm_buttons_config, $dlm_download );