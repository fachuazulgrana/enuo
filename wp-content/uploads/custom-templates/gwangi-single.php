<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package gwangi
 */

get_header();
get_sidebar( 'left' ); ?>

	<div id="primary" class="region__col region__col--2 content-area">
		<main id="main" class="site-main">

			<?php
			/* Start the Loop */
			custom_post_types_get_custom_template();
 // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar( 'right' );
get_footer();
