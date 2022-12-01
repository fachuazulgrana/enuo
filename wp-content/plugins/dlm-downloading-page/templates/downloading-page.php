<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
?>
<p class="dlm-downloading-page"><?php printf( __( "Your download should start automatically in a few seconds... If it doesn't, %splease click here to start it manually%s</a>", 'dlm-downloading-page' ), '<a href="' . $url . '">', '</a>' ); ?>.</p>