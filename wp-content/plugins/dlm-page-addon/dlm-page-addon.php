<?php
/*
	Plugin Name: Download Monitor Page Addon
	Plugin URI: https://www.download-monitor.com/extensions/page-addon/
	Description: Adds a [download_page] shortcode for showing off your available downloads, tags and categories.
	Version: 4.1.1
	Author: Download Monitor
	Author URI: https://www.download-monitor.com
	Requires at least: 3.8
	Tested up to: 4.9.4

	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WP_DLM_Page_Addon class.
 */
class WP_DLM_Page_Addon {

	const VERSION = '4.1.1';

	private $page_id = '';

	/** @var  WP_DLM_Page_Addon */
	private static $instance = null;

	/**
	 * Singleton getter
	 *
	 * @return WP_DLM_Page_Addon
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new WP_DLM_Page_Addon();
		}

		return self::$instance;
	}

	/**
	 * Prevent cloning
	 */
	protected function __clone() {
		// no cloning allowed
	}

	/**
	 * Private constructor, only run once
	 */
	private function __construct() {
		$this->setup();
	}

	/**
	 * Runs on plugin activation
	 */
	public static function activation() {
		$rewrite = new DLM_PA_Rewrite();
		$rewrite->add_endpoint();
		$rewrite->flush();
	}

	/**
	 * Setup plugin
	 */
	public function setup() {

		// Actions
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );

		// Request
		$request = new DLM_PA_Request();
		$request->setup();

		// Shortcodes
		add_shortcode( 'download_page', array( $this, 'download_page' ) );

		// add endpoints
		$rewrite = new DLM_PA_Rewrite();
		add_action( 'init', array( $rewrite, 'add_endpoint' ) );

		// Register Extension
		add_filter( 'dlm_extensions', array( $this, 'register_extension' ) );

		// check if in admin
		if ( is_admin() ) {
			// add settings
			$settings = new DLM_PA_Settings();
			$settings->setup();
		} else {

			/**
			 * Is frontend
			 */

			// fix the title
			$title = new DLM_PA_Title();
			$title->setup();

			// check if search results should go to PA detail page
			if ( 0 !== intval( get_option( 'dlm_pa_search_results_page', 0 ) ) ) {
				$search_support = new DLM_PA_Search();
				$search_support->setup();
			}

		}

	}

	/**
	 * @return int
	 */
	public function get_page_id() {
		return absint( $this->page_id );
	}

	/**
	 * Register this extension
	 *
	 * @param array $extensions
	 *
	 * @return array $extensions
	 */
	public function register_extension( $extensions ) {
		$extensions[] = array(
			'file'    => 'dlm-page-addon',
			'version' => self::VERSION,
			'name'    => 'Page Addon'
		);

		return $extensions;
	}

	/**
	 * Localisation
	 *
	 * @access private
	 * @return void
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'dlm_page_addon', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * frontend_scripts function.
	 *
	 * @access public
	 * @return void
	 */
	public function frontend_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'dlm-page-addon-frontend', $this->plugin_url() . '/assets/css/page.css' );
	}

	/**
	 * Get the plugin url
	 *
	 * @access public
	 * @return string
	 */
	public function plugin_url() {
		return plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) );
	}

	/**
	 * Get the plugin path
	 *
	 * @access public
	 * @return string
	 */
	public function plugin_path() {
		return plugin_dir_path( __FILE__ );
	}

	/**
	 * Get the endpoint link for a tag (to display on the page addon)
	 *
	 * @param  object $tag
	 *
	 * @return string
	 */
	public function get_tag_link( $tag ) {
		if ( get_option( 'permalink_structure' ) ) {
			$link = trailingslashit( get_permalink( $this->page_id ) ) . 'download-tag/' . $tag->slug . '/';
		} else {
			$link = add_query_arg( 'download-tag', $tag->slug );
		}

		return esc_url( $link );
	}

	/**
	 * Get the endpoint link for a category (to display on the page addon)
	 *
	 * @param  object $cat
	 *
	 * @return string
	 */
	public function get_category_link( $cat ) {
		if ( get_option( 'permalink_structure' ) ) {
			$link = trailingslashit( get_permalink( $this->page_id ) ) . 'download-category/' . $cat->slug . '/';
		} else {
			$link = add_query_arg( 'download-category', $cat->slug );
		}

		return esc_url( $link );
	}

	/**
	 * Get the endpoint link for a download (to display on the page addon)
	 *
	 * @param DLM_Download $dlm_download
	 * @param int $page_id base ID for download_info link
	 *
	 * @return string
	 */
	public function get_download_info_link( $dlm_download, $page_id = 0 ) {

		if ( 0 !== $page_id ) {
			$page_url = get_permalink( $page_id );
		} else {
			$page_url = get_permalink( $this->page_id );
		}

		if ( get_option( 'permalink_structure' ) ) {
			$link = trailingslashit( $page_url ) . 'download-info/' . $dlm_download->get_slug() . '/';
		} else {
			$link = add_query_arg( 'download-info', $dlm_download->get_slug(), $page_url );
		}

		return esc_url( $link );
	}

	/**
	 * The download page shortcode
	 *
	 * @param  array $args
	 *
	 * @return string
	 */
	public function download_page( $args = array() ) {
		global $post, $wp;

		$this->page_id = $post->ID;

		ob_start();

		do_action( 'dlm_page_addon_before_download_page' );

		if ( ! empty( $wp->query_vars['download-category'] ) ) {
			$this->download_term( $wp->query_vars['download-category'], 'dlm_download_category', $args );
		} elseif ( ! empty( $wp->query_vars['download-tag'] ) ) {
			$this->download_term( $wp->query_vars['download-tag'], 'dlm_download_tag', $args );
		} elseif ( ! empty( $wp->query_vars['download-info'] ) ) {
			$this->download_info( $wp->query_vars['download-info'], $args );
		} elseif ( ! empty( $_GET['download_search'] ) ) {
			$this->search_results( sanitize_text_field( $_GET['download_search'] ), $args );
		} else {

			// extract shortcode arguments
			extract( shortcode_atts( array(
				'format'             => 'pa',
				'show_search'        => 'true',
				'show_featured'      => 'true',
				'show_tags'          => 'true',
				'featured_limit'     => '4',
				'featured_format'    => 'pa-thumbnail',
				'category_limit'     => '4',
				'front_orderby'      => 'download_count',
				'exclude_categories' => '',
				'include_categories' => ''
			), $args ) );

			$show_search   = ( $show_search === 'true' );
			$show_featured = ( $show_featured === 'true' );
			$show_tags     = ( $show_tags === 'true' );
			$meta_key      = '';

			switch ( $front_orderby ) {
				case 'title' :
				default :
					$order = 'asc';
					break;
				case 'download_count' :
					$order         = 'desc';
					$front_orderby = 'meta_value_num';
					$meta_key      = '_download_count';
					break;
				case 'date' :
					$order = 'desc';
					break;
			}

			// template handler
			$template_handler = new DLM_Template_Handler();

			if ( $show_search ) {
				$template_handler->get_template_part( 'search-downloads', '', $this->plugin_path() . 'templates/' );
			}

			if ( $show_featured ) {

				// fetch downloads
				$downloads = download_monitor()->service( 'download_repository' )->retrieve( array(
					'orderby'    => $front_orderby,
					'order'      => $order,
					'meta_key'   => $meta_key,
					'meta_query' => array(
						array(
							'key'   => '_featured',
							'value' => 'yes'
						)
					)
				), $featured_limit );

				// make featured downloads filterable
				$downloads = apply_filters( 'dlm_page_addon_featured_downloads', $downloads );

				if ( count( $downloads ) > 0 ) {
					$template_handler->get_template_part( 'featured-downloads', '', $this->plugin_path() . 'templates/', array(
						'downloads' => $downloads,
						'format'    => $featured_format
					) );
				}
			}

			if ( $show_tags ) {

				// get tags
				$tags = get_terms( 'dlm_download_tag', apply_filters( 'dlm_page_addon_get_tag_args', array(
					'orderby' => 'count',
					'order'   => 'DESC',
					'number'  => 50
				) ) );

				// make tags filterable
				$tags = apply_filters( 'dlm_page_addon_tags', $tags );

				if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {

					foreach ( $tags as $key => $tag ) {
						$tags[ $key ]->link = $this->get_tag_link( $tag );
						$tags[ $key ]->id   = $tag->term_id;
					}

					$template_handler->get_template_part( 'download-tags', '', $this->plugin_path() . 'templates/', array( 'tags' => $tags ) );
				}
			}

			// Categories
			$include = array_filter( array_map( 'absint', explode( ',', $include_categories ) ) );
			$exclude = array_filter( array_map( 'absint', explode( ',', $exclude_categories ) ) );

			$category_args = apply_filters( 'dlm_page_addon_get_category_args', array(
				'orderby'    => 'name',
				'order'      => 'ASC',
				'hide_empty' => ! empty( $include ) ? false : true,
				'pad_counts' => true,
				'child_of'   => 0,
				'exclude'    => $exclude,
				'include'    => $include
			) );

			$categories = get_terms( 'dlm_download_category', $category_args );

			$categories = apply_filters( 'dlm_page_addon_categories', $categories, $category_args );

			if ( $categories ) {

				echo apply_filters( 'dlm_page_addon_categories_start', '<div class="download-monitor-categories">' );

				foreach ( $categories as $category ) {

					$downloads = download_monitor()->service( 'download_repository' )->retrieve( array(
						'orderby'   => $front_orderby,
						'order'     => $order,
						'meta_key'  => $meta_key,
						'tax_query' => array(
							array(
								'taxonomy' => 'dlm_download_category',
								'field'    => 'slug',
								'terms'    => $category->slug,
							)
						)
					), $category_limit );

					// make downloads filterable
					$downloads = apply_filters( 'dlm_page_addon_category_downloads', $downloads, $category );

					if ( count( $downloads ) > 0 ) {
						$template_handler->get_template_part( 'download-categories', '', $this->plugin_path() . 'templates/', array(
							'category'  => $category,
							'downloads' => $downloads,
							'format'    => $format
						) );
					}

				}

				echo apply_filters( 'dlm_page_addon_categories_end', '</div>' );

			}

		}

		return '<div id="download-page">' . ob_get_clean() . '</div><!-- Download Page powered by WordPress Download Monitor (https://www.download-monitor.com) -->';
	}

	/**
	 * Show a download's info page
	 *
	 * @param  string $slug
	 * @param  array $args
	 */
	public function download_info( $slug, $args ) {
		global $wpdb;

		$download_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_name = '%s' AND post_type = 'dlm_download' AND post_status = 'publish';", sanitize_title( $slug ) ) );

		$template_handler = new DLM_Template_Handler();

		try {

			// fetch download
			$download = download_monitor()->service( 'download_repository' )->retrieve_single( $download_id );

			// fitler download
			$download = apply_filters( 'dlm_page_addon_download_info', $download );

			$template_handler->get_template_part( 'content-download', 'pa-single', $this->plugin_path() . 'templates/', array( 'dlm_download' => $download ) );
		} catch ( Exception $exception ) {
			$template_handler->get_template_part( 'no-downloads-found', '', $this->plugin_path() . 'templates/' );
		}
	}

	/**
	 * Show a term page
	 *
	 * @param  string $slug
	 * @param  string $taxonomy
	 * @param  array $args
	 */
	public function download_term( $slug, $taxonomy, $args ) {
		global $wp;

		$term = get_term_by( 'slug', $slug, $taxonomy );

		if ( is_wp_error( $term ) || ! $term ) {
			return;
		}

		extract( shortcode_atts( array(
			'posts_per_page'     => '20',
			'format'             => 'pa',
			'default_orderby'    => 'title',
			'exclude_categories' => ''
		), $args ) );

		$dlpage          = ! empty( $_GET['dlpage'] ) ? $_GET['dlpage'] : 1;
		$current_orderby = ! empty( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : $default_orderby;
		$meta_key        = '';

		switch ( $current_orderby ) {
			case 'title' :
			default :
				$order = 'asc';
				break;
			case 'download_count' :
				$order           = 'desc';
				$current_orderby = 'meta_value_num';
				$meta_key        = '_download_count';
				break;
			case 'date' :
				$order = 'desc';
				break;
		}

		$args = apply_filters( 'dlm_page_addon_term_query_args', array(
			'orderby'   => $current_orderby,
			'order'     => $order,
			'meta_key'  => $meta_key,
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $slug
				)
			)
		) );

		// fetch downloads
		$downloads = download_monitor()->service( 'download_repository' )->retrieve( $args, $posts_per_page, $posts_per_page * ( $dlpage - 1 ) );

		// make download filterable
		$downloads = apply_filters( 'dlm_page_addon_downloads_term_list', $downloads, $slug, $taxonomy, $term );

		$pages = ceil( download_monitor()->service( 'download_repository' )->num_rows( $args ) / $posts_per_page );

		// template handler
		$template_handler = new DLM_Template_Handler();

		// load template parts
		$template_handler->get_template_part( 'subcategories', '', $this->plugin_path() . 'templates/', array(
			'term'               => $term,
			'taxonomy'           => $taxonomy,
			'exclude_categories' => $exclude_categories
		) );


		// only load order template file if we have the right query_vars
		if ( ! empty( $wp->query_vars['pagename'] ) && ! empty( $wp->query_vars['download-tag'] ) ) {
			$base_url = home_url( '/' . $wp->query_vars['pagename'] . '/download-tag/' . $wp->query_vars['download-tag'] . '/' );
			$template_handler->get_template_part( 'orderby', '', $this->plugin_path() . 'templates/', array(
				'current_orderby' => $current_orderby,
				'base_url'        => $base_url
			) );
		}

		$template_handler->get_template_part( 'download-list', '', $this->plugin_path() . 'templates/', array(
			'format'    => $format,
			'downloads' => $downloads
		) );
		$template_handler->get_template_part( 'pagination', '', $this->plugin_path() . 'templates/', array( 'pages' => $pages ) );

	}

	/**
	 * Show search results
	 *
	 * @param  string $search
	 * @param  array $args
	 */
	public function search_results( $search, $args ) {

		extract( shortcode_atts( array(
			'posts_per_page' => '20',
			'format'         => 'pa'
		), $args ) );

		$dlpage = ! empty( $_GET['dlpage'] ) ? $_GET['dlpage'] : 1;

		$args = apply_filters( 'dlm_page_addon_search_query_args', array(
			'orderby'        => 'post__in',
			'order'          => 'asc',
			'posts_per_page' => $posts_per_page,
			'offset'         => $posts_per_page * ( $dlpage - 1 ),
			's'              => $search,
		) );

		if ( function_exists( 'relevanssi_prevent_default_request' ) ) {
			remove_filter( 'posts_request', 'relevanssi_prevent_default_request', 10, 2 );
		}

		// fetch downloads
		$downloads = download_monitor()->service( 'download_repository' )->retrieve( $args, $posts_per_page, $posts_per_page * ( $dlpage - 1 ) );

		// make downloads filterable
		$downloads = apply_filters( 'dlm_page_addon_search_results', $downloads );

		$pages = ceil( download_monitor()->service( 'download_repository' )->num_rows( $args ) / $posts_per_page );

		if ( function_exists( 'relevanssi_prevent_default_request' ) ) {
			add_filter( 'posts_request', 'relevanssi_prevent_default_request', 10, 2 );
		}

		// template handler
		$template_handler = new DLM_Template_Handler();

		if ( count( $downloads ) > 0 ) {
			$template_handler->get_template_part( 'download-list', '', $this->plugin_path() . 'templates/', array(
				'format'    => $format,
				'downloads' => $downloads
			) );
			$template_handler->get_template_part( 'pagination', '', $this->plugin_path() . 'templates/', array( 'pages' => $pages ) );
		} else {
			$template_handler->get_template_part( 'no-downloads-found', '', $this->plugin_path() . 'templates/' );
		}

	}
}

// include vendor autoload
require_once dirname( __FILE__ ) . '/vendor/autoload_52.php';

function __dlm_page_addon_main() {

	// define plugin file
	define( 'DLM_PA_FILE', __FILE__ );

	$GLOBALS['dlm_page_addon'] = WP_DLM_Page_Addon::instance();
}

add_action( 'plugins_loaded', '__dlm_page_addon_main', 11 );

// run on activation
register_activation_hook( __FILE__, array( 'WP_DLM_Page_Addon', 'activation' ) );

