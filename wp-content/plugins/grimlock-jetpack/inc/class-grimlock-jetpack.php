<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Grimlock_Jetpack
 *
 * @author  themoasaurus
 * @since   1.0.0
 * @package grimlock-jetpack/inc
 */
class Grimlock_Jetpack {
	/**
	 * Setup class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		load_plugin_textdomain( 'grimlock-jetpack', false, 'grimlock-jetpack/languages' );

		require_once GRIMLOCK_JETPACK_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-jetpack-button-customizer.php';
		require_once GRIMLOCK_JETPACK_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-jetpack-global-customizer.php';
		require_once GRIMLOCK_JETPACK_PLUGIN_DIR_PATH . 'inc/customizer/class-grimlock-jetpack-typography-customizer.php';

		add_action( 'after_setup_theme',                 array( $this, 'setup'                      ), 10    );
		add_filter( 'infinite_scroll_archive_supported', array( $this, 'infinite_scroll_support'    ), 10    );
		add_filter( 'comments_open',                     array( $this, 'remove_attachment_comments' ), 10, 2 );

		add_action( 'wp_enqueue_scripts',                          array( $this, 'wp_enqueue_scripts'                 ), 10    );
		add_action( 'wp_footer',                                   array( $this, 'change_infinite_scroll_button_text' ), 20    );
	}

	/**
	 * Jetpack setup function.
	 *
	 * @since 1.0.0
	 *
	 * @link https://jetpack.me/support/infinite-scroll/
	 * @link https://jetpack.me/support/responsive-videos/
	 */
	public function setup() {

		// Add theme support for Infinite Scroll.
		add_theme_support( 'infinite-scroll', array(
				'container' => 'main',
				'render'    => array( $this, 'infinite_scroll_render' ),
				'footer'    => 'page',
		) );

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );
	}

	/**
	 * Init Jetpack infinite scroll only in some cases.
	 *
	 * @since 2.0.0
	 *
	 * @link https://jetpack.me/support/infinite-scroll/
	 */
	public function infinite_scroll_support() {
		return current_theme_supports('infinite-scroll') && ( is_home() || is_category() || is_tag() || is_author() );
	}


	/**
	 * Custom render function for Infinite Scroll.
	 *
	 * @since 1.0.0
	 */
	public function infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', get_post_format() );
		}
	}

	/**
	 * Remove Comment box on Jetpack Carousel.
	 *
	 * @since 2.0.0
	 */
	function remove_attachment_comments( $open, $post_id ) {
		$post = get_post( $post_id );
		if ( 'attachment' == $post->post_type ) {
			return false;
		}
		return $open;
	}

	/**
	 * Enqueue scripts and stylesheets.
	 *
	 * @since 1.0.0
	 */
	public function wp_enqueue_scripts() {
		if ( apply_filters( 'grimlock_jetpack_js_enqueued', is_home() || is_archive() || is_search() ) ) {
			wp_enqueue_script( 'grimlock-jetpack-infinite-scroll', GRIMLOCK_JETPACK_PLUGIN_DIR_URL . 'assets/js/infinite-scroll.js', array( 'jquery', 'jquery-masonry', 'imagesloaded' ), GRIMLOCK_JETPACK_VERSION, true );
		}
		wp_enqueue_style( 'grimlock-jetpack', GRIMLOCK_JETPACK_PLUGIN_DIR_URL . 'assets/css/style.css', array(), GRIMLOCK_JETPACK_VERSION );

		/*
		 * Load style-rtl.css instead of style.css for RTL compatibility
		 */
		wp_style_add_data( 'grimlock-jetpack', 'rtl', 'replace' );
	}

	/**
	 * Change Jetpack Infinite Scroll module 'Older Posts' button text.
	 *
	 * @since 1.0.2
	 */
	public function change_infinite_scroll_button_text() {
		if ( is_home() || is_archive() || is_search() ) : ?>
			<script type="text/javascript">
                if ( typeof infiniteScroll !== 'undefined' ) {
                    //<![CDATA[
                    infiniteScroll.settings.text = '<?php echo esc_html__( 'Load more', 'grimlock-jetpack' ); ?>';
                    //]]>
                }
			</script>
		<?php
		endif;
	}
}
