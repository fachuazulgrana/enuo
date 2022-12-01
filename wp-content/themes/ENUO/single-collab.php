<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package gwangi
 */

get_header();
?>
<style>
	.enuo-button{border-radius: 50px !important; background: rgb(197,0,130);background: -moz-linear-gradient(90deg, rgba(197,0,130,1) 0%, rgba(192,0,57,1) 100%);background: -webkit-linear-gradient(90deg, rgba(197,0,130,1) 0%, rgba(192,0,57,1) 100%);background: linear-gradient(90deg, rgba(197,0,130,1) 0%, rgba(192,0,57,1) 100%);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#c50082",endColorstr="#c00039",GradientType=1); border: none !important;font-family: Poppins !important;color: #FFF;	text-align: center;text-decoration: none;padding: .75em 1em;font-size: 16px;line-height: 1.5em;box-shadow: 0 2px 4px rgba(0,0,0,.3),inset 0 1px 0 rgba(255,255,255,.4);border: 0;cursor: pointer;font-weight: 500;}
	.enuo-button:hover{color: #FFF !important;box-shadow: 0 2px 4px rgba(0,0,0,.7),inset 0 1px 0 rgba(255,255,255,.6);}
	.enuo-button img{width: 20px; height: 19px;}
</style>

	<div id="primary" class="region__col region__col--2 content-area">
		<main id="main" class="site-main">
			<div><a class="enuo-button" href="<?php echo get_site_url(); ?>/collab">Ver Collabs</a></div>
			<?php
			/* Start the Loop 
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'single' ); ?>
				<?php do_action( 'gwangi_the_post_navigation' ); ?>
				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			
			*/
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
