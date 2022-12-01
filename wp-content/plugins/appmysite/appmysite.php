<?php
/**
 * Plugin Name: AppMySite
 * Plugin URI: https://www.appmysite.com
 * Description: This plugin enables WordPress & WooCommerce users to sync their websites with native iOS and Android apps, created on <a href="https://www.appmysite.com/"><strong>www.appmysite.com</strong></a>
 * Version: 3.7.1
 * Author: AppMySite
 * Text Domain: appmysite
 * Author URI: https://appmysite.com
 * Tested up to: 6.1
 * WC tested up to: 7.1.0
 * WC requires at least: 3.8.0
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 **/

	// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die( 'No script kiddies please!' );
}

	/******************************************************************************
	 * Show warning to all where WordPress version is below minimum requirement.
	 */

	global $wp_version;
if ( $wp_version <= 4.9 ) {
	function wo_incompatibility_with_wp_version() {
		?>
			<div class="notice notice-error">
				<p><?php esc_html_e( 'AppMySite requires that WordPress 4.9 or greater be used. Update to the latest WordPress version.', 'appmysite' ); ?>
					<a href="<?php echo esc_url( admin_url( 'update-core.php' ) ); ?>"><?php esc_html_e( 'Update Now', 'appmysite' ); ?></a></p>
			</div>
			<?php
	}

	add_action( 'admin_notices', 'wo_incompatibility_with_wp_version' );
}

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-get-plugin-info',
				array(
					'methods'  => 'GET',
					'callback' => 'ams_get_version_info',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	
	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-menu',
				array(
					'methods'  => 'GET',
					'callback' => 'ams_get_menu_items',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-menu-names',
				array(
					'methods'  => 'GET',
					'callback' => 'ams_get_menu_names',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-login',
				array(
					'methods'  => 'POST',
					'callback' => 'ams_login',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-verify-user',
				array(
					'methods'  => 'POST',
					'callback' => 'ams_verify_user',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-profile-meta',
				array(
					'methods'  => 'GET',
					'callback' => 'ams_get_profile_meta',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-order-payment-url',
				array(
					'methods'  => 'POST',
					'callback' => 'ams_get_order_payment_url',
					'permission_callback' => '__return_true',
				)
			);
		}
	);
	
	add_action('rest_api_init', function ()
	{
		register_rest_route('wc/v3', '/ams-verify-application-password', array(
			'methods' => 'GET',
			'callback' => 'ams_verify_application_password',
			'permission_callback' => function() {
				return current_user_can('manage_options');
			},
		));
	});
	
	add_action('rest_api_init', function ()
	{
		register_rest_route('wc/v3', '/ams-wp-get-user-auth-cookies', array(
			'methods' => 'POST',
			'callback' => 'ams_wp_get_user_auth_cookies',
			'permission_callback' => function() {
				return current_user_can('manage_options');
			},
			'args' => array(
				'user_id' => array(
					'required' => true,
					'type' => 'integer',
					'description' => 'User ID',
				)
			) ,
		));
	});
	
	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-order-total',
				array(
					'methods'  => 'POST',
					'callback' => 'ams_get_order_total',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-send-password-reset-link',
				array(
					'methods'  => 'POST',
					'callback' => 'ams_send_password_reset_link',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-applicable-shipping-method',
				array(
					'methods'  => 'POST',
					'callback' => 'ams_applicable_shipping_method',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-product-search',
				array(
					'methods'  => 'GET',
					'callback' => 'ams_product_search',
					'permission_callback' => '__return_true',
				)
			);
		}
	);
	
	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-product-attributes',
				array(
					'methods'  => 'GET',
					'callback' => 'ams_product_attributes',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-verify-cart-items',
				array(
					'methods'  => 'POST',
					'callback' => 'ams_verify_cart_items',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-categories',
				array(
					'methods'  => 'GET',
					'callback' => 'ams_categories',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-post-categories',
				array(
					'methods'  => 'GET',
					'callback' => 'ams_post_categories',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-checkout-fields',
				array(
					'methods'  => 'GET',
					'callback' => 'ams_checkout_fields',
					'permission_callback' => '__return_true',
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-wc-points-rewards-effective-discount',
				array(
					'methods'  => 'POST',
					'callback' => 'ams_wc_points_rewards_effective_discount',
					'permission_callback' => '__return_true',
					'args'     => array(
						'line_items'  => array(
							'required'    => true,
							'type'        => 'array',
							'description' => 'Cart items',
						),
						'customer_id' => array(
							'required'    => true,
							'type'        => 'integer',
							'description' => 'Customer ID',
						),
						'wc_points_rewards_discount_amount' => array(
							'required'    => true,
							'type'        => 'number',
							'description' => 'Requested user discount',
						),
					),
				)
			);
		}
	);

	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-wc-points-rewards-settings',
				array(
					'methods'  => 'GET',
					'callback' => 'ams_wc_points_rewards_settings',
					'permission_callback' => '__return_true',
				)
			);
		}
	);
	
	add_action(
		'rest_api_init',
		function () {
			register_rest_route(
				'wc/v3',
				'/ams-change-password',
				array(
					'methods'  => 'POST',
					'callback' => 'ams_change_password',
					'permission_callback' => '__return_true',
					'args' => array(
							
							'customer_id' => array(
								'required' => true,
								'type' => 'integer',
								'description' => 'Customer ID',
							),
							'old_password' => array(
								'required' => true,
								'type' => 'text',
								'description' => 'Old Password',
							),
							'new_password' => array(
								'required' => true,
								'type' => 'text',
								'description' => 'New Password',
							),
							'confirm_password' => array(
								'required' => true,
								'type' => 'text',
								'description' => 'New Password',
							),
						)
				)
			);
		}
	);
	
		/******
	 * Load customer payment page without the need of customer login.
	 */

	add_filter( 'user_has_cap', 'ams_allow_payment_without_login', 10, 3 );
	function ams_allow_payment_without_login( $allcaps, $caps, $args ) {

		if ( ! isset( $caps[0] ) || $caps[0] != 'pay_for_order' ) {
			return $allcaps;
		}
		if ( ! isset( $_GET['key'] ) ) {
			return $allcaps;
		}
		$order = wc_get_order( $args[2] );
		if ( ! $order ) {
			return $allcaps;
		}
		$order_key                = $order->get_order_key();
		$order_key_check          = sanitize_text_field( wp_unslash( $_GET['key'] ) );
		$allcaps['pay_for_order'] = ( $order_key == $order_key_check );
		return $allcaps;
	}
		/******
	 * Add Default Catalog Orderby Settings in the setting API .
	 */
	add_filter( 'woocommerce_get_settings_products', 'add_subtab_settings', 10, 2 );
	function add_subtab_settings( $settings ) {
		$current_section = get_option( 'woocommerce_default_catalog_orderby' );

		if ( isset( $current_section ) ) {
			$settings[] = array(
				'name'     => __( 'AMS WC Default Catalog Orderby Settings', 'woocommerce' ),
				'id'       => 'woocommerce_default_catalog_orderby',
				'label'    => 'Woocommerce Default Catalog Orderby',
				'type'     => 'select',
				'desc'     => __( 'This setting determines the sorting order of products in the catalog.', 'woocommerce' ),
				'desc_tip' => true,
				'options'  => array(
					'price'      => __( 'Sort by price (asc)', 'woocommerce' ),
					'date'       => __( 'Sort by most recent', 'woocommerce' ),
					'rating'     => __( 'Average rating', 'woocommerce' ),
					'popularity' => __( 'Popularity (sales)', 'woocommerce' ),
					'menu_order' => __( 'Default sorting (custom ordering + name)', 'woocommerce' ),
					'price-desc' => __( 'Sort by price (desc)', 'woocommerce' ),
				),
				'default'  => '',
				'value'    => get_option( 'woocommerce_default_catalog_orderby' ),

			);
			return $settings;
		} else {
			return $settings; // If not, return the standard settings
		}
	}
	
	
	add_filter( 'woocommerce_get_settings_products', 'ams_wc_get_cart_url', 10, 2 );
	function ams_wc_get_cart_url( $settings ) {
		
			$settings[] = array(
				'name'     => __( 'AMS WC Cart Page URL', 'woocommerce' ),
				'id'       => 'ams_wc_cart_url',
				'label'    => 'Woocommerce cart page URL.',
				'type'     => 'select',
				'desc'     => __( 'This setting determines the cart page url of store.', 'woocommerce' ),				
				'default'  => wc_get_cart_url()
			);
			return $settings;
	}	

	/******

	 * Adds post's featured media to REST API.
	 */

	register_rest_field(
		'post',
		'featured_image_src',
		array(
			'get_callback'    => 'ams_get_image_src',
			'update_callback' => null,
			'schema'          => null,
		)
	);
	
	add_action( 'rest_api_init', 'ams_register_rest_field_for_custom_post_type' );
	
	function ams_register_rest_field_for_custom_post_type(){
			$ams_custom_post_types = array_values(get_post_types(array('_builtin' => false),'names','and'));	//'public' => true,'exclude_from_search' => false
			if (($key = array_search('product', $ams_custom_post_types)) !== false) { // We don't need this field for products
				unset($ams_custom_post_types[$key]);
			}
			register_rest_field(
			$ams_custom_post_types, //['product','course','projects']
			'featured_image_src',
			array(
				'get_callback'    => 'ams_get_image_src',
				'update_callback' => null,
				'schema'          => null,
			)
		);
	}
	
	function ams_get_image_src( $object, $field_name, $request ) {
		$feat_img_array = wp_get_attachment_image_src(
			$object['featured_media'], // Image attachment ID
			'large',  // Size.  Ex. "thumbnail", "large", "full", etc..
			false // Whether the image should be treated as an icon.
		);
		return $feat_img_array[0];
	}
	function ams_get_version_info( WP_REST_Request $request ){
		
			if ( ! function_exists( 'plugins_api' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
			}
			
			if( ! function_exists( 'get_plugin_data' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$version_current = get_plugin_data( __FILE__ )['Version'];
			
			$args = array(
				'slug' => 'appmysite',
				'fields' => array(
					'version' => true,
				)
			);

			$call_api = plugins_api( 'plugin_information', $args );

			if ( is_wp_error( $call_api ) ) {

				$api_error = $call_api->get_error_message();

				return( rest_ensure_response([
											"AMS_PLUGIN_LATEST_VERSION"=>"0.0.0",
											"AMS_PLUGIN_CURRENT_VERSION"=>"0.0.0"
											]));							
			} else {

				if ( ! empty( $call_api->version ) ) {

					$version_latest = $call_api->version;
					return( rest_ensure_response( ["AMS_PLUGIN_LATEST_VERSION"=>$version_latest,
												  "AMS_PLUGIN_CURRENT_VERSION"=>$version_current] ) );
				}

			}						
						
	}
	
	function ams_verify_application_password( WP_REST_Request $request ) { 

		$user = get_user_by( 'ID', apply_filters('determine_current_user', false) ); // | User by ID 
		if ( isset( $user->errors ) ) {
			$error_message = strip_tags( ams_convert_error_to_string( $user->errors ) );
			$error         = new WP_Error();
			$error->add( 'message', __( $error_message . '' ) );
			return $error;
		} elseif ( isset( $user->data ) ) {
			$user->data->user_pass = '';
			$user->data->user_activation_key = '';
			$user->data->id = $user->ID; //integer
			$user->data->first_name = get_user_meta( $user->ID, 'first_name', true );
			$user->data->last_name = get_user_meta( $user->ID, 'last_name', true );			
			$user->data->roles = $user->roles;
			####get user wp_generate_auth_cookie####
			
			########################################
			return rest_ensure_response( $user->data );
		} else {
			return new WP_Error('ams_error', 'Something went wrong. Please contact support.', array('status' => 500));
		}
	}
	


	/******

	 * Adds post's medium & large media to REST API.
	 */

	register_rest_field(
		'post',
		'blog_images',
		array(
			'get_callback'    => 'ams_get_images_urls',
			'update_callback' => null,
			'schema'          => null,
		)
	);

	function ams_get_images_urls( $object, $field_name, $request ) {
		$medium     = wp_get_attachment_image_src( get_post_thumbnail_id( $object['id'] ), 'medium' );
		$medium_url = $medium['0'];

		$large     = wp_get_attachment_image_src( get_post_thumbnail_id( $object['id'] ), 'large' );
		$large_url = $large['0'];

		return array(
			'medium' => $medium_url,
			'large'  => $large_url,
		);
	}

	/******

	 * Get default variant in rest api.
	 */
	register_rest_field(
		'product',
		'ams_default_variation_id',
		array(
			'get_callback'    => 'ams_get_default_variant',
			'update_callback' => null,
			'schema'          => null,
		)
	);
	function ams_get_default_variant( $object, $field_name, $request ) {

		$product = wc_get_product( $object['id'] );
		if ( $product->is_type( 'variable' ) ) {
			$default_attributes = $product->get_default_attributes();
			if ( ! empty( $default_attributes ) ) {
				foreach ( $product->get_available_variations() as $variation_values ) {
					foreach ( $variation_values['attributes'] as $key => $attribute_value ) {
						$attribute_name = str_replace( 'attribute_', '', $key );
						$default_value  = $product->get_variation_default_attribute( $attribute_name );
						if ( $default_value == $attribute_value ) {
							$is_default_variation = true;
						} else {
							$is_default_variation = false;
							break;
						}
					}
					if ( $is_default_variation ) {
						$variation_id = $variation_values['variation_id'];
						break;
					}
				}
				return $variation_id;
			} else {
				return 0;
			}
		} else {
			return 0;
		}

	}

	register_rest_field(
		['product','product_variation'],
		'ams_product_points_reward',
		array(
			'get_callback'    => 'ams_get_product_points_reward',
			'update_callback' => null,
			'schema'          => null,
		)
	);
	function ams_get_product_points_reward( $object, $field_name, $request ) {

		$product = wc_get_product( $object['id'] );
		$product_id = $object['id'];
		
		if ( ! is_admin() && ! $product->is_type( 'variable' ) ) {			
			$_wc_max_points_earned = get_post_meta( $product_id, '_wc_max_points_earned' );
			$_wc_min_points_earned = get_post_meta( $product_id, '_wc_min_points_earned' );
			return get_post_meta( $product_id, '_wc_min_points_earned' );
			
		} else {
			return get_post_meta( $product_id, '_wc_points_earned' );
		}

	}

	/******

	 * Get discout percentage in rest api
	 */
	register_rest_field(
		'product',
		'ams_product_discount_percentage',
		array(
			'get_callback'    => 'ams_get_product_discount_percentage',
			'update_callback' => null,
			'schema'          => null,
		)
	);
	function ams_get_product_discount_percentage( $object, $field_name, $request ) {

		$product = wc_get_product( $object['id'] );
		if ( $product->is_on_sale() && ! is_admin() && ! $product->is_type( 'variable' ) ) {
			$regular_price       = (float) $product->get_regular_price(); // Regular price
			$sale_price          = (float) $product->get_price();
			$saving_price        = wc_price( $regular_price - $sale_price );
			$precision           = 2;
			$discount_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 2 );
			return $discount_percentage;
		} else {
			return 0.00;
		}

	}
	
	/******
	 * Added product display price in rest API to support show price inclusive/exclusive of tax.
	 ******/
	 
	register_rest_field(
		['product','product_variation'],
		'ams_price_to_display',
		array(
			'get_callback'    => 'ams_get_product_price_to_display',
			'update_callback' => null,
			'schema'          => null,
		)
	);
	function ams_get_product_price_to_display( $object, $field_name, $request ) {

		$product = wc_get_product( $object['id'] );
		$ams_price_to_display = wc_get_price_to_display($product,[]);
		return $ams_price_to_display;
		
	}
	
	/******
	 * users_can_register settings for wordpress APIs
	 ******/
	 
	add_action('rest_api_init', function ()
	{		
		register_setting('general', 'ams_users_can_register', array(
		 'show_in_rest' => true,
		 'type' => 'boolean',
		 'default' => get_option( 'users_can_register' )
		));
	});

	/******

	 * This adds product's thumbnail and medium images in the rest api for catalog listing.
	 ******/

	function ams_prepare_product_images( $response, $post, $request ) {
		global $_wp_additional_image_sizes;

		if ( empty( $response->data ) ) {
			return $response;
		}
		if (is_array($response->data['images']) || is_object($response->data['images'])) {
			foreach ( $response->data['images'] as $key => $image ) {
					$image_info                                    = wp_get_attachment_image_src( $image['id'], 'thumbnail' );
					$response->data['images'][ $key ]['thumbnail'] = $image_info[0];
					$image_info                                    = wp_get_attachment_image_src( $image['id'], 'medium' );
					$response->data['images'][ $key ]['medium']    = $image_info[0];
			}
		}		
		return $response;
	}

	add_filter( 'woocommerce_rest_prepare_product_object', 'ams_prepare_product_images', 10, 3 );
	
	function ams_prepare_product_attributes( $response, $post, $request ) {
						
		if (is_array($response->data['attributes']) || is_object($response->data['attributes'])) {
			
			if ( empty( $response->data['attributes'] ) ) {
				return $response;
			}
			if ( $post->is_type( 'variable' ) ) { 
				$product_attributes = $post->get_attributes();
				$ams_wc_product_attributes=[];
				
				foreach( $post->get_attributes() as $attr_name => $attr ){				
					$attr->id = $attr->get_id();
					$attr->slug = $attr_name;
					$attr->terms = $attr->get_terms();
					$attr->options_slugs = $attr->get_slugs();
					$ams_wc_product_attributes["attribute_id_".$attr->get_id()] = $attr;	
				}
				
				foreach ( $response->data['attributes'] as $key => $attributes ) {
					if(isset($ams_wc_product_attributes['attribute_id_'.$attributes['id']])){
						$slug = $ams_wc_product_attributes['attribute_id_'.$attributes['id']]->slug;
						$terms = $ams_wc_product_attributes['attribute_id_'.$attributes['id']]->terms;
						$options_slugs = $ams_wc_product_attributes['attribute_id_'.$attributes['id']]->options_slugs;
					}else{
						$slug = '';
						$terms = [];
						$options_slugs = [];
					}

					$response->data['attributes'][ $key ]['slug'] = $slug;
					$response->data['attributes'][ $key ]['options_slugs'] = $options_slugs;
					$response->data['attributes'][ $key ]['terms'] = $terms;
				}
			}			
		}
		return $response;
	}

	add_filter( 'woocommerce_rest_prepare_product_object', 'ams_prepare_product_attributes', 10, 3 );


	/******

	 * Provision for coupon in rest api. This modifies order by applying coupon immediately after creating the order.
	 * Adds checkout payment url in rest order api.
	 * Adds thumbnail image of product in get order api
	 */

	add_filter( 'woocommerce_rest_prepare_shop_order_object', 'ams_rest_apply_coupon', 10, 3 );

	function ams_rest_apply_coupon( $response, $object, $request ) {
				// this section is to apply coupon
		// If Reward point plugin is enabled #################
		if ( in_array(
			'woocommerce-points-and-rewards/woocommerce-points-and-rewards.php',
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		)
		) {
			$already_redeemed                  = get_post_meta( $response->data['id'], '_wc_points_redeemed', true );
			$order                             = wc_get_order( $response->data['id'] );
			$wc_points_rewards_discount_amount = $order->get_meta( '_ams_wc_points_redeemed' );
			if ( !empty( $wc_points_rewards_discount_amount )&& (int)$wc_points_rewards_discount_amount>0){
				$customer_id                       = $request->get_param( 'customer_id' );
				$line_items                        = $request->get_param( 'line_items' );
				$reward_amount                     = ams_get_points_rewards_discount_amount( $customer_id, $wc_points_rewards_discount_amount, $line_items ); // to be calculated
				$reward_coupon_code                = sprintf( 'wc_points_redemption_%s_%s_@%u', $customer_id, date( 'Y_m_d_h_i', current_time( 'timestamp' ) ), $reward_amount );
				// get actual point to be logged on the basis of allowed reward amount.
				$actual_points_to_redeemed = WC_Points_Rewards_Manager::calculate_points_for_discount( $reward_amount );

				// update_post_meta for reference
				if ( empty( $already_redeemed ) && $reward_amount > 0 ) {
					$results = $order->apply_coupon( $reward_coupon_code );
					update_post_meta( $response->data['id'], '_ams_wc_points_redeemed', $actual_points_to_redeemed );
					update_post_meta( $response->data['id'], '_ams_wc_points_rewards_discount_code', $reward_coupon_code );
					update_post_meta( $response->data['id'], '_ams_wc_points_rewards_discount_amount', $reward_amount );

				}
			}
		}
		// If Reward point plugin is enabled #################

		if ( ! empty( $request->get_param( 'coupon_lines' ) ) ) {
			foreach ( $request->get_param( 'coupon_lines' ) as $item ) {
				if ( is_array( $item ) ) {
					if ( isset( $item['id'] ) ) {
						if ( ! isset( $item['code'] ) ) {
							throw new WC_REST_Exception( 'woocommerce_rest_invalid_coupon', __( 'Coupon code is required.', 'woocommerce' ), 400 );
						}
						$order   = wc_get_order( $response->data['id'] );
						$results = $order->apply_coupon( wc_clean( $item['code'] ) );

						if ( is_wp_error( $results ) ) {
							throw new WC_REST_Exception( 'woocommerce_rest_' . $results->get_error_code(), $results->get_error_message(), 400 );
						}
						return $response;
					}
				}
			}
		}
				// this section is to add extra field into order api
				$ams_order_checkout_url                       = ( $value = esc_url( $object->get_checkout_payment_url() ) ) ? $value : '';
				$response->data['order_checkout_payment_url'] = html_entity_decode( $ams_order_checkout_url );
		if ( ! empty( $response->data['line_items'] ) ) {			
			foreach ( $response->data['line_items'] as $key => $lineItem ) {
				$product_id = $lineItem['product_id'];
				$medium_url = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'thumbnail' );
				$response->data['line_items'][ $key ]['ams_order_thumbnail'] = $medium_url[0];
			}
		}

			return $response;

	}


	/******

	 * Get all menu names.
	 ******/

	function ams_get_menu_names() {

		$nav_menu_locations = wp_get_nav_menus();
		$result = [];
		foreach((array)$nav_menu_locations as $item){
			$result[$item->slug]=$item->term_id;
		}
		return( rest_ensure_response( $result ) );

	}

	/******

	 * Get all items of given menu.
	 ******/

	function ams_get_menu_items( WP_REST_Request $request ) {

		$menu_name = 'primary-menu'; // primary-menu, top

		if ( isset( $request['menu_name'] ) ) {
			$menu_name = $request['menu_name'];
		}
		$nav_menu_items     = wp_get_nav_menu_items( $menu_name );  //slug,id
		return( rest_ensure_response( $nav_menu_items ) );

	}

	/******

	 * Get all product and post categories in a binary tree.
	 ******/
	function ams_categories() {

		$orderby    = 'name';
		$order      = 'asc';
		$hide_empty = true;
		$cat_args   = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
		);

		$product_categories             = array_values( get_terms( 'product_cat', $cat_args ) );
		$array_product_categories_items = json_decode( json_encode( $product_categories ), true );
		if ( empty( $array_product_categories_items ) ) {
			return rest_ensure_response( $array_product_categories_items );
		}
		$category_tree = ams_build_category_tree( $array_product_categories_items, 'parent', 'term_id' );
		return rest_ensure_response( $category_tree );

	}

	function ams_post_categories() {

		$orderby    = 'name';
		$order      = 'asc';
		$hide_empty = true;
		$cat_args   = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
		);

		$product_categories             = array_values( get_terms( 'category', $cat_args ) );
		$array_product_categories_items = json_decode( json_encode( $product_categories ), true );
		if ( empty( $array_product_categories_items ) ) {
			return rest_ensure_response( $array_product_categories_items );
		}
		$category_tree = ams_build_category_tree( $array_product_categories_items, 'parent', 'term_id' );
		return rest_ensure_response( $category_tree );

	}


	/******

	 * Cart items verification
	 ******/

	function ams_verify_cart_items( WP_REST_Request $request ) {

		$params   = $request->get_params();
		$validate = ams_basic_validate( $params, array( 'line_items' ) );
		if ( $validate != true ) {
			return $validate;
		}

		$line_items = $params['line_items'];
		$result     = array();
		foreach ( $line_items as $key => $value ) {
			if ( array_key_exists( 'variation_id', $value ) ) {

				$variation = wc_get_product( $value['variation_id'] );

				if ( $variation ) {
					$result[ $key ]['product_id']     = $variation->get_id();
					$result[ $key ]['variation_id']   = $value['variation_id'];
					$result[ $key ]['name']           = $variation->get_name();
					$result[ $key ]['type']           = $variation->get_type();
					$result[ $key ]['status']         = $variation->get_status();
					$result[ $key ]['price']          = $variation->get_price();
					$result[ $key ]['regular_price']  = $variation->get_regular_price();
					$result[ $key ]['sale_price']     = $variation->get_sale_price();
					$result[ $key ]['manage_stock']   = $variation->get_manage_stock();
					$result[ $key ]['stock_quantity'] = $variation->get_stock_quantity();
					if ( $result[ $key ]['stock_quantity'] == null ) {
						$result[ $key ]['stock_quantity'] = '';
					}
					$result[ $key ]['stock_status'] = $variation->get_stock_status();
					$result[ $key ]['on_sale']      = $variation->is_on_sale();
					if ( 1 == $result[ $key ]['on_sale'] ) {

						$result[ $key ]['on_sale'] = true;
					} else {
						$result[ $key ]['on_sale'] = false;
					}
				}
			} else {
				// get product details
				$product = wc_get_product( $value['product_id'] );
				if ( $product ) {
					$result[ $key ]['product_id']        = $product->get_id();
					$result[ $key ]['name']        		 = $product->get_name();
					$result[ $key ]['type']              = $product->get_type();
					$result[ $key ]['status']            = $product->get_status();
					$result[ $key ]['get_price']         = $product->get_price();
					$result[ $key ]['get_regular_price'] = $product->get_regular_price();
					$result[ $key ]['get_sale_price']    = $product->get_sale_price();
					$result[ $key ]['manage_stock']      = $product->get_manage_stock();
					$result[ $key ]['stock_quantity']    = $product->get_stock_quantity();
					if ( $result[ $key ]['stock_quantity'] == null ) {
						$result[ $key ]['stock_quantity'] = '';
					}
					$result[ $key ]['stock_status'] = $product->get_stock_status();
					$result[ $key ]['on_sale']      = $product->is_on_sale();
					if ( 1 == $result[ $key ]['on_sale'] ) {
						$result[ $key ]['on_sale'] = true;
					} else {
						$result[ $key ]['on_sale'] = false;
					}
				}
			}
		}

		return rest_ensure_response( array( 'line_items' => $result ) );
	}


	add_action( 'pre_get_posts', 'ams_catalog_hidden_products_search_query_fix' );
	
	function ams_catalog_hidden_products_search_query_fix( $query = false ) {
		if ( ! is_admin() && isset( $query->query['post_type'] ) && $query->query['post_type'] === 'product' ) {
			$tax_query = $query->get( 'tax_query' );		
			if(!is_array($tax_query)){$tax_query=[];}
			array_push($tax_query,[
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'exclude-from-catalog',
					'operator' => 'NOT IN',
				]);
			array_push($tax_query,[
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'exclude-from-catalog',
					'operator' => '!=',
				]);
			$tax_query['relation']='AND';					
			$query->set( 'tax_query', $tax_query );
		}
	}
	
	/******

	 * Search API with support of multiple sort and order_by parameters .
	 ******/
	function ams_product_search( WP_REST_Request $request ) {

		$param        = $request->get_params();
		$category     = $param['category'];
		$filters      = $param['filter'];
		$per_page     = $param['per_page'];
		$page         = $param['page'];
		$order        = $param['order'];
		$orderby      = $param['orderby'];
		$featured     = $param['featured'];
		$on_sale      = $param['on_sale'];
		$min_price    = $param['min_price'];
		$max_price    = $param['max_price'];
		$stock_status = $param['stock_status'];
		$output       = array();
		// Use default arguments.
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => get_option( 'posts_per_page' ),
			'post_status'    => 'publish',
			'paged'          => 1,

		);
		// Posts per page.
		if ( ! empty( $per_page ) ) {
			$args['posts_per_page'] = $per_page;
		}
		// Pagination, starts from 1.
		if ( ! empty( $page ) ) {
			$args['paged'] = $page;
		}

		// Order condition. ASC/DESC.
		if ( ! empty( $order ) ) {
			$args['order'] = $order;
		}
		// Order condition. ASC/DESC.
		if ( ! empty( $orderby ) ) {
			if ( $orderby == 'price' ) {
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = '_price';

			} elseif ( $orderby == 'popularity' ) {   // For Popularity case, the sort order will always be desc.
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = 'total_sales';

			} else {
				$args['orderby'] = $orderby;
			}
		}

		if ( ! empty( $featured ) ) {
			if ( $featured == true ) {
				$args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
				);
			}
		}

		if ( ! empty( $on_sale ) ) {
			if ( $on_sale == true ) {

				$args['meta_query'][] = array(
					'key'     => '_sale_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'numeric',
				);
			}
		}
		if ( ! empty( $stock_status ) ) {
				$args['meta_query'][] = array(
					'key'   => '_stock_status',
					'value' => $stock_status,
				);
		}
		if ( isset( $min_price ) || isset( $max_price ) ) {

			$price_request = array();
			if ( isset( $min_price ) ) {
				$price_request['min_price'] = $min_price;
			}

			if ( isset( $max_price ) ) {
				$price_request['max_price'] = $max_price;
			}
			$args['meta_query'][] = wc_get_min_max_price_meta_query( $price_request );
		}

		if ( ! empty( $category ) || ! empty( $filters ) ) {

			$args['tax_query']['relation'] = 'AND';
			if ( ! empty( $category ) ) {
				$args['tax_query'][] = array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => explode( ',', $category ),        // [ $category ],
					'include_children' => true,
				);
			}

			if ( ! empty( $filters ) ) {
				foreach ( $filters as $filter_key => $filter_value ) {
					if ( $filter_key === 'min_price' || $filter_key === 'max_price' ) {
						continue;
					}
					$args['tax_query'][] = array(
						'taxonomy' => $filter_key,
						'field'    => 'term_id',
						'terms'    => explode( ',', $filter_value ),
					);
				}
			}
		}

		$the_query = new \WP_Query( $args );

		if ( ! $the_query->have_posts() ) {
			return $output;
		}
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$product_ids[] = $the_query->post->ID;
			$output[]      = get_the_title();
		}
		wp_reset_postdata();

		$request    = new WP_REST_Request( 'GET', '/wc/v3/products' );
		$parameters = array( 'include' => $product_ids );
		if ( ! empty( $order ) ) {
			$parameters += array( 'order' => $order );
		}
		if ( ! empty( $orderby ) ) {
			$parameters += array( 'orderby' => $orderby );
		}
		if ( ! empty( $per_page ) ) {
			$parameters += array( 'per_page' => $per_page );
		}
		$request->set_query_params( $parameters );
		$response = rest_do_request( $request );
		$server   = rest_get_server();
		$data     = $server->response_to_data( $response, false );
		return rest_ensure_response( $data );
	}


	function ams_product_attributes( WP_REST_Request $request ) {

		$param  = $request->get_params();
		
		$args = array(
			'status'    => 'publish',
			'limit' => -1
		);
		
		if(isset( $param['category'] )){
			$cat_name = get_term($param['category'], 'product_cat', ARRAY_A ); 
		
			if(is_wp_error( $cat_name) ){
				status_header( 400 );
				echo ( json_encode(
					array(
						'message' => 'There is a problem with your input.',
						'error'   => $cat_name->get_error_message(),
					),
					JSON_UNESCAPED_UNICODE
				) );
				die();		
			}
			$args['category'] = array($cat_name['slug'] );
		}
		
		if(isset( $param['stock_status'] )){
			$args['stock_status'] = $param['stock_status'];
		}
		
		if(isset( $param['featured'] )){
			$args['featured'] = $param['featured'];			
		}
		
		if(isset( $param['on_sale'] )){
			$args['on_sale'] = $param['on_sale'];
		}
		
		$result = [];
		
		$filter_raw = array(); 
        $attrs_raw  = wc_get_attribute_taxonomy_names(); 
        foreach( wc_get_products($args) as $product ){
            foreach( $product->get_attributes() as $attr_name => $attr ){
            $filter_raw[] = $attr_name;
            if(is_array($attr->get_terms())){    
                foreach( $attr->get_terms() as $term ){
                    $terms_raw[] = $term->name;
                }
            }
            }
        }
        $filters = array_unique(array_intersect((array)$filter_raw,(array)$attrs_raw)); 
		
        if(is_array($filters)){    
			foreach ( $filters as $key=>$filter ){
				$terms = get_terms( $filter );
				if ( ! empty( $terms ) ) {

					$result[$key] = array(
						'id'    => $filter,
						'label' =>  wc_attribute_label( $filter ) , //$this->decode_html
					);
					foreach ( $terms as $term ) {
						if(in_array($term->name,$terms_raw)){
						$result[$key]['values'][] = array(
							'label' =>  $term->name ,
							'value' => $term->slug,
							'term_id' => $term->term_id,
							'count' => $term->count,							
						);
						}
					}
				}
			}
        }
        
		return( rest_ensure_response( array_values($result )) );

	}
	
	/******

	 * Authenticate the user.
	 ******/

	function ams_login( WP_REST_Request $request ) {

		$req = $request->get_json_params();

		$validate = ams_basic_validate( $req, array( 'username', 'password' ) );
		if ( $validate != true ) {
			return $validate;
		}
			$wp_version = get_bloginfo( 'version' );
			$user       = wp_authenticate( sanitize_text_field( $req['username'] ), sanitize_text_field( $req['password'] ) );  // htmlspecialchars

		if ( isset( $user->errors ) ) {
			$error_message = strip_tags( ams_convert_error_to_string( $user->errors ) );
			$error = new WP_Error();
			$error->add( 'message', __( $error_message . '' ) );
			return $error;
		} elseif ( isset( $user->data ) ) {
			$user->data->user_pass  = '';
			$user->data->user_activation_key = '';
			$user->data->id = $user->ID; //integer
			$user->data->first_name = get_user_meta( $user->ID, 'first_name', true );
			$user->data->last_name = get_user_meta( $user->ID, 'last_name', true );						
			$user->data->roles = $user->roles;			
			$user->data->wp_version = $wp_version;
			return rest_ensure_response( $user->data );
		} else {
			return new WP_Error('ams_error', 'Something went wrong. Please contact support.', array('status' => 500));
		}
	}


	/******

	 * Verify the user.
	 ******/
	function ams_verify_user( WP_REST_Request $request ) {

		$req = $request->get_json_params();

		$validate = ams_basic_validate( $req, array( 'username' ) );
		if ( $validate != true ) {
			return $validate;
		}

		$is_email = is_email($req['username']);
		if(!$is_email){
			$user = get_user_by( 'login', $req['username'] ); // | ID | slug | email | login.
		}else{			
			$user = get_user_by( 'email', $req['username'] ); // | ID | slug | email | login.
			if( isset( $user->errors ) ) { 
				$user = get_user_by( 'login', $req['username'] ); // | ID | slug | email | login.
			}
		}
		
		if ( isset( $user->errors ) ) {
			$error_message = strip_tags( ams_convert_error_to_string( $user->errors ) );
			$error = new WP_Error();
			$error->add( 'message', __( $error_message . '' ) );
			return $error;
		} elseif ( isset( $user->data ) ) {
			$user->data->user_pass = '';
			$user->data->user_activation_key = '';
			$user->data->id = $user->ID; //integer
			$user->data->first_name = get_user_meta( $user->ID, 'first_name', true );
			$user->data->last_name = get_user_meta( $user->ID, 'last_name', true );			
			$user->data->roles = $user->roles;						
			return rest_ensure_response( $user->data );
		} else {
			return rest_ensure_response( array() ); // User not found.
		}

	}

	function ams_get_profile_meta( WP_REST_Request $request ) {

		if ( isset( $request['id'] ) ) {
			$user_id = sanitize_text_field( $request['id'] );
		}
		$validate = ams_basic_validate( $req, array( 'id' ) );
		if ( $validate != true ) {
			return $validate;
		}
		$user_meta_data          = get_user_meta( $user_id, 'wp_user_avatar', true );
		$profile_image_full_path = wp_get_attachment_image_src( $user_meta_data );
		return rest_ensure_response( array( 'wp_user_avatar' => $profile_image_full_path ) );
	}

		/******

		 * get check out payment url.
		 * Note: This will be removed in next vesrion.
		 ******/
	function ams_get_order_payment_url( WP_REST_Request $request ) {

		$req      = $request->get_json_params();
		$validate = ams_basic_validate( $req, array( 'order_id' ) );
		if ( $validate != true ) {
			return $validate;
		}
		$order_id = sanitize_text_field( $req['order_id'] );
		$order    = wc_get_order( $order_id );  // Returns WC_Product|null|false
		if ( ! isset( $order ) || $order == false ) {
			$error = new WP_Error();
			$error->add( 'message', __( 'The order ID appears to be invalid. Please try again.' ) );
			return $error;
		}  // Verify Valid Order ID
		$pay_now_url = esc_url( $order->get_checkout_payment_url() );
		return( rest_ensure_response( html_entity_decode( $pay_now_url ) ) );
	}

	function ams_wp_get_user_auth_cookies( WP_REST_Request $request ) {  

		$user_id = sanitize_text_field($request->get_param('user_id'));
		$user = get_user_by( 'ID', $user_id ); // | ID | slug | email | login.
		if ( isset( $user->errors ) ) {
			$error_message = strip_tags( ams_convert_error_to_string( $user->errors ) );
			$error         = new WP_Error();
			$error->add( 'message', __( $error_message . '' ) );
			return $error;
		} elseif ( isset( $user->data ) ) {
			$user->data->user_pass = '';
			$user->data->user_activation_key = '';
			$user->data->id = $user->ID; //integer
			$user->data->first_name = get_user_meta( $user->ID, 'first_name', true );
			$user->data->last_name = get_user_meta( $user->ID, 'last_name', true );			
			$user->data->roles = $user->roles;
			####get user wp_generate_auth_cookie####
				$expiration = time() + apply_filters('auth_cookie_expiration', 14 * DAY_IN_SECONDS , $user->ID, true);
				$site_url = get_site_url();//get_site_option('site_url');
				if($site_url){$cookie_hash=md5($site_url);}else{$cookie_hash='';}
				$user->data->expiration = $expiration;
				//$user->data->expire = $expiration + ( 12 * HOUR_IN_SECONDS );
				$user->data->cookie_hash = $cookie_hash;
				$user->data->wordpress_logged_in_ = wp_generate_auth_cookie($user->ID, $expiration, 'logged_in');
				$user->data->wordpress_ = wp_generate_auth_cookie($user->ID, $expiration, 'secure_auth');						
			########################################
			return rest_ensure_response( $user->data );
		} else {
			return new WP_Error('ams_error', 'Something went wrong. Please contact support.', array('status' => 500));
		}
	}
	
	/******

	 * Sends rest password link on user's email.
	 ******/

	function ams_send_password_reset_link( WP_REST_Request $request ) {
			$req      = $request->get_json_params();
			$validate = ams_basic_validate( $req, array( 'email' ) );
		if ( $validate != true ) {
			return $validate;
		}
			$email = sanitize_email( $req['email'] );
			$user  = get_user_by( 'email', $email );
		if ( ! $user ) {
			$error = new WP_Error();
			$error->add( 'message', __( 'The email address appears to be incorrect. Please try again.' ) );
			return $error;
		}
			$firstname  = $user->first_name;
			$email      = $user->user_email;
			$user_login = $user->user_login;
			$retrieve_password = retrieve_password($user_login);
			
			if ( isset( $retrieve_password->errors ) ) {
				$error_message = strip_tags( ams_convert_error_to_string( $retrieve_password->errors ) );
				$error = new WP_Error();
				$error->add( 'message', __( $error_message . '' ) );
				return $error;
			}
			
			return( rest_ensure_response( array( 'message' => 'Reset Password link sent successfully!' ) ) );

	}


	/******

	 * Calculates shipping methods based on cart-items (line_items) , shipping address and coupon.
	 ******/
	 
	function ams_applicable_shipping_method( WP_REST_Request $request ) {
			
		$req = $request->get_json_params();
		$validate = ams_basic_validate( $req, array( 'shipping', 'line_items' ) );
		if ( $validate != true ) {
			return $validate;
		}

		$shipping                = $req['shipping'];
		$line_items              = $req['line_items'];
		$customer_id = 0 ;
		if(isset( $req[ 'customer_id' ] )){
			$customer_id = sanitize_text_field( $req[ 'customer_id' ] );				
		}
		
		$content = [];
		wc_maybe_define_constant( 'WOOCOMMERCE_CART', true );
		wc()->frontend_includes();
		WC()->session = new WC_Session_Handler();
		WC()->customer = new WC_Customer( $customer_id, true );
		WC()->initialize_cart();
		WC()->cart->empty_cart();
		foreach ( $line_items as $key => $value ) {  // prepare cart content which will be used for table rate plugin
			if ( array_key_exists( 'variation_id', $value ) ) {
				WC()->cart->add_to_cart($value['product_id'], $value['quantity'], $value['variation_id'] );									
			}else{
				WC()->cart->add_to_cart($value['product_id'], $value['quantity'] );				
			}
		}

		WC()->customer->set_shipping_first_name(isset($shipping['first_name'])?$shipping['first_name']:'');
		WC()->customer->set_shipping_last_name(isset($shipping['last_name'])?$shipping['last_name']:'');
		WC()->customer->set_shipping_address_1(isset($shipping['address_1'])?$shipping['address_1']:'');
		WC()->customer->set_shipping_address_2(isset($shipping['address_2'])?$shipping['address_2']:'');
		WC()->customer->set_shipping_city(isset($shipping['city'])?$shipping['city']:'');
		WC()->customer->set_shipping_postcode(isset($shipping['postcode'])?$shipping['postcode']:'');
		WC()->customer->set_shipping_country(isset($shipping['country'])? $shipping['country'] :'');
		WC()->customer->set_shipping_state(isset($shipping['state'])? $shipping['state']: '');
		
		if(isset( $req[ 'coupon_lines' ] )){
			if(!empty( $req[ 'coupon_lines' ] )){
				$coupon_code = sanitize_text_field( $req[ 'coupon_lines' ][0]['code'] );
				WC()->cart->add_discount( $coupon_code );
			}				
		}
		
		WC()->cart->calculate_shipping();
		WC()->cart->calculate_totals();
		
		$packages = apply_filters('woocommerce_cart_shipping_packages', WC()->cart->get_shipping_packages());
		$shipping_packages = WC()->shipping->calculate_shipping($packages);
		
		$all_shipping_packages_rates = array();
		foreach($shipping_packages as $package){
			$pacakage_rates=array();
			foreach($package['rates'] as $rate){

				$pacakage_rate = array();
				$pacakage_rate['id']=(string)$rate->get_instance_id();
				$pacakage_rate['title']=$rate->get_label();
				$pacakage_rate['method_id']=$rate->get_method_id();
				$pacakage_rate['cost']=number_format((float)$rate->get_cost(), 2, '.', '');
				$pacakage_rate['tax']= number_format((float)$rate->get_shipping_tax(), 2, '.', '');
				array_push($pacakage_rates,$pacakage_rate);
			}
			if(empty($pacakage_rates)){
				return( rest_ensure_response( $pacakage_rates ) );
			}
			array_push($all_shipping_packages_rates,$pacakage_rates);
		}
		
		$result_methods=$all_shipping_packages_rates[0];
		for($i=1;$i<count($all_shipping_packages_rates);++$i){
			$result_methods = merge_shipping_methods($result_methods,$all_shipping_packages_rates[$i]);				
		}	
		WC()->cart->empty_cart();
		WC()->session->destroy_session();
		return( rest_ensure_response( $result_methods ) );
	}

	function merge_shipping_methods($methods1,$methods2){
		$result=array();
		foreach($methods1 as $method1){
			foreach($methods2 as $method2){
				$current=$method2;
				if(($method1["method_id"]=="local_pickup"||$method1["method_id"]=="free_shipping")&&(!in_array($methods2["method_id"],
				array("flat_rate","free_shipping","local_pickup")))){
					$current["method_id"]="flat_rate";
				}
				if($method1['method_id']=="local_pickup"&&$methods2["method_id"]=="free_shipping"){
				$current["method_id"]=$method1['method_id'];
				$current["id"]=$method1['id'];
				
				}
				if($method1['method_id']=="flat_rate"){
				$current["method_id"]=$method1['method_id'];
				$current["id"]=$method1['id'];
				
				}
				$current["title"].=" + ".$method1['title'];
				$current["cost"]+=$method1['cost'];				
				array_push($result,$current);
			}
			
		}		
		return $result;		
	}
    

	function ams_checkout_fields() {
		if ( in_array(
			'woocommerce-checkout-field-editor/woocommerce-checkout-field-editor.php',
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		)
		) {
				$result['checkout_shipping_fields']   = ams_object_to_array( get_option( 'wc_fields_shipping', array() ) );
				$result['checkout_billing_fields']    = ams_object_to_array( get_option( 'wc_fields_billing', array() ) );
				$result['checkout_additional_fields'] = ams_object_to_array( get_option( 'wc_fields_additional', array() ) );
				return rest_ensure_response( $result );
		} else {
			return rest_ensure_response( array() );
		}
	}

	function ams_wc_points_rewards_effective_discount( WP_REST_Request $request ) {
		if ( in_array(
			'woocommerce-points-and-rewards/woocommerce-points-and-rewards.php',
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		)
		) {
			$params                            = $request->get_params();
			$line_items                        = $params['line_items'];
			$customer_id                       = $params['customer_id'];
			$wc_points_rewards_discount_amount = $params['wc_points_rewards_discount_amount'];
			$granted_user_discount             = 0;

			// Construct local cart
			if ( is_null( WC()->cart ) ) {
				wc_load_cart();
			}
			WC()->cart->empty_cart();
			foreach ( $line_items as $key => $value ) {
				if(!isset($value['variation'])){$value['variation']= [];}
				if ( array_key_exists( 'variation_id', $value ) ) {
					WC()->cart->add_to_cart( $value['product_id'], $value['quantity'], $value['variation_id'], $value['variation'] );
				} else {
					WC()->cart->add_to_cart( $value['product_id'], $value['quantity'] );
				}
			}

			// Verify Global settings of points and reward plugin
			$available_user_discount = WC_Points_Rewards_Manager::get_users_points_value( $customer_id );

			// no discount
			if ( $available_user_discount <= 0 ) {
				// return 0;
				$error = new WP_Error();
				$error->add( 'message', __( 'No reward point available.' ) );
				return $error;
			}

			if ( 'yes' === get_option( 'wc_points_rewards_partial_redemption_enabled' ) && $wc_points_rewards_discount_amount ) {
				$requested_user_discount = WC_Points_Rewards_Manager::calculate_points_value( $wc_points_rewards_discount_amount );
				if ( $requested_user_discount > 0 && $requested_user_discount < $available_user_discount ) {
					$available_user_discount = $requested_user_discount;
				}
			}

			// Limit the discount available by the global minimum discount if set.
			$minimum_discount = get_option( 'wc_points_rewards_cart_min_discount', '' );
			if ( $minimum_discount > $available_user_discount ) {
				// return 0;
				$error = new WP_Error();
				$error->add( 'message', __( 'Please enter atleast '.$minimum_discount.' points global minimum discount error.' ) );
				return $error;
			}

			// apply product level setting of point and reward plugin.
			$discount_applied = 0;

			if ( ! did_action( 'woocommerce_before_calculate_totals' ) ) {
				WC()->cart->calculate_totals();
			}
			
			$max_points_discount_of_all_products = 0;			
			foreach ( WC()->cart->get_cart() as $item_key => $item ) {

				$discount     = 0;
				$max_discount = WC_Points_Rewards_Product::get_maximum_points_discount_for_product( $item['data'] );

				if ( is_numeric( $max_discount ) ) {

					// adjust the max discount by the quantity being ordered
					$max_discount *= $item['quantity'];


					// if the discount available is greater than the max discount, apply the max discount
					$discount = ( $available_user_discount <= $max_discount ) ? $available_user_discount : $max_discount;

					// Max should be product price. As this will be applied before tax, it will respect other coupons.
				} else {
					/*
					 * Only exclude taxes when configured to in settings and when generating a discount amount for displaying in
					 * the checkout message. This makes the actual discount money amount always tax inclusive.
					 */
					if ( 'exclusive' === get_option( 'wc_points_rewards_points_tax_application', wc_prices_include_tax() ? 'inclusive' : 'exclusive' ) && $for_display ) {
						if ( function_exists( 'wc_get_price_excluding_tax' ) ) {
							$max_discount = wc_get_price_excluding_tax( $item['data'], array( 'qty' => $item['quantity'] ) );
						} elseif ( method_exists( $item['data'], 'get_price_excluding_tax' ) ) {
							$max_discount = $item['data']->get_price_excluding_tax( $item['quantity'] );
						} else {
							$max_discount = $item['data']->get_price( 'edit' ) * $item['quantity'];
						}
					} else {
						if ( function_exists( 'wc_get_price_including_tax' ) ) {
							$max_discount = wc_get_price_including_tax( $item['data'], array( 'qty' => $item['quantity'] ) );
						} elseif ( method_exists( $item['data'], 'get_price_including_tax' ) ) {
							$max_discount = $item['data']->get_price_including_tax( $item['quantity'] );
						} else {
							$max_discount = $item['data']->get_price( 'edit' ) * $item['quantity'];
						}
					}

					// if the discount available is greater than the max discount, apply the max discount
					$discount = ( $available_user_discount <= $max_discount ) ? $available_user_discount : $max_discount;
				}
				
				$max_points_discount_of_all_products += $max_discount ; 
				
				// add the discount to the amount to be applied
				$discount_applied += $discount;

				// reduce the remaining discount available to be applied
				$available_user_discount -= $discount;
			}
			// limit customer if requested amount to avail discount exceeds the product's maximum discount. 
			/*
			if($wc_points_rewards_discount_amount > $max_points_discount_of_all_products){
						$error = new WP_Error();
						$error->add( 'message', __( 'You cannot enter more than '.$max_points_discount_of_all_products.' points on these products.' ) );
						return $error;	
			}
			*/
			
			$existing_discount_amounts = version_compare( WC_VERSION, '3.0.0', '<' )? WC()->cart->discount_total: WC()->cart->get_cart_discount_total();
				
			// if the available discount is greater than the order total, make the discount equal to the order total less any other discounts
			if ( version_compare( WC_VERSION, '3.0.0', '<' ) ) {
				if ( 'no' === get_option( 'woocommerce_prices_include_tax' ) ) {
					$discount_applied = max( 0, min( $discount_applied, WC()->cart->subtotal_ex_tax - $existing_discount_amounts ) );

				} else {
					$discount_applied = max( 0, min( $discount_applied, WC()->cart->subtotal - $existing_discount_amounts ) );

				}
			} else {
				if ( 'no' === get_option( 'woocommerce_prices_include_tax' ) ) {
					$discount_applied = max( 0, min( $discount_applied, WC()->cart->subtotal_ex_tax - $existing_discount_amounts ) );

				} else {
					$discount_applied = max( 0, min( $discount_applied, WC()->cart->subtotal - $existing_discount_amounts ) );
				}
			}
			
			// limit the discount available by the global maximum discount if set
			$max_discount = get_option( 'wc_points_rewards_cart_max_discount' );

			if ( false !== strpos( $max_discount, '%' ) ) {
				$max_discount = ams_ams_calculate_discount_modifier( $max_discount );
			}
			$max_discount = filter_var( $max_discount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

			if ( $max_discount && $max_discount < $discount_applied ) {
				$error = new WP_Error();
				$error->add( 'message', __( 'You cannot enter more than '.$max_discount.' points.' ) );
				return $error;
				//$discount_applied = $max_discount;
			}
			$discount_applied = filter_var( $discount_applied, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			return rest_ensure_response( array( array( 'effective_discount_value' => (float) $discount_applied ) ) );

		} else {
			return rest_ensure_response( array() );
		}
	}

	function ams_wc_points_rewards_settings() {
		if ( in_array(
			'woocommerce-points-and-rewards/woocommerce-points-and-rewards.php',
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		)
		) {

			$result['wc_points_rewards_cart_max_discount']          = get_option( 'wc_points_rewards_cart_max_discount' );
			$result['wc_points_rewards_write_review_points']        = get_option( 'wc_points_rewards_write_review_points' );
			$result['wc_points_rewards_account_signup_points']      = get_option( 'wc_points_rewards_account_signup_points' );
			$result['wc_points_rewards_points_expiry']              = get_option( 'wc_points_rewards_points_expiry' );
			$result['wc_points_rewards_points_expire_points_since'] = get_option( 'wc_points_rewards_points_expire_points_since' );
			$result['wc_points_rewards_version']                    = get_option( 'wc_points_rewards_version' );
			$result['wc_points_rewards_earn_points_ratio']          = get_option( 'wc_points_rewards_earn_points_ratio', '' );
			$result['wc_points_rewards_earn_points_rounding']       = get_option( 'wc_points_rewards_earn_points_rounding' );
			$result['wc_points_rewards_redeem_points_ratio']        = get_option( 'wc_points_rewards_redeem_points_ratio', '' );
			$result['wc_points_rewards_partial_redemption_enabled'] = get_option( 'wc_points_rewards_partial_redemption_enabled' );
			$result['wc_points_rewards_cart_min_discount']          = get_option( 'wc_points_rewards_cart_min_discount' );
			$result['wc_points_rewards_max_discount']               = get_option( 'wc_points_rewards_max_discount' );
			$result['wc_points_rewards_points_tax_application']     = get_option( 'wc_points_rewards_points_tax_application' );
			$result['wc_points_rewards_points_expiry_number']       = get_option( 'wc_points_rewards_points_expiry_number' );
			$result['wc_points_rewards_points_expiry_period']       = get_option( 'wc_points_rewards_points_expiry_period' );
			$result['wc_points_rewards_single_product_message']     = get_option( 'wc_points_rewards_single_product_message' );
			$result['wc_points_rewards_variable_product_message']   = get_option( 'wc_points_rewards_variable_product_message' );
			$result['wc_points_rewards_earn_points_message']        = get_option( 'wc_points_rewards_earn_points_message' );
			$result['wc_points_rewards_redeem_points_message']      = get_option( 'wc_points_rewards_redeem_points_message' );
			$result['wc_points_rewards_thank_you_message']          = get_option( 'wc_points_rewards_thank_you_message' );

			return rest_ensure_response( $result );
		} else {
			return rest_ensure_response( array() );
		}
	}

	add_filter( 'woocommerce_get_shop_coupon_data', 'ams_create_virtual_coupon', 10, 2 );

	function ams_create_virtual_coupon( $false, $data ) {

		// Do not interfere with coupon creation and editing.
		if ( is_admin() ) {
			return $false;
		}
			$coupon_code_valid = false;
			$coupon_settings   = null;
			$coupon_amount     = 0;
		if ( ams_is_coupon_code_valid( $data ) ) {
			$coupon_code_valid = true;
		}
		if ( ( $pos = strpos( $data, '@' ) ) !== false ) {
			$coupon_amount = (float) substr( $data, $pos + 1 );
		}
		// Create a coupon with the properties you need
		if ( $coupon_code_valid ) {
			$coupon_settings = array(
				'id'                         => true,
				'discount_type'              => 'fixed_cart', // 'fixed_cart', 'percent' or 'fixed_product'
				'amount'                     => $coupon_amount, // value or percentage.
				'expiry_date'                => date( 'Y-m-d', strtotime( 'tomorrow' ) ), // YYYY-MM-DD
				'individual_use'             => false,
				'product_ids'                => array(),
				'exclude_product_ids'        => array(),
				'usage_limit'                => '1',
				'usage_limit_per_user'       => '1',
				'limit_usage_to_x_items'     => '',
				'usage_count'                => '',
				'free_shipping'              => false,
				'product_categories'         => array(),
				'exclude_product_categories' => array(),
				'exclude_sale_items'         => false,
				'minimum_amount'             => '',
				'maximum_amount'             => '',
				'customer_email'             => array(),
			);

			return $coupon_settings;
		} else {
			return false;
		}

	}

	add_action( 'rest_api_init', 'ams_create_api_customer_field' );

	function ams_create_api_customer_field() {

		// register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema() )
		register_rest_field(
			'customer',
			'ams-rewards-points-balance',
			array(
				'get_callback' => 'ams_get_rewards_points_balance',
				'schema'       => null,
			)
		);
	}

	function ams_get_rewards_points_balance( $object ) {
		if ( in_array(
			'woocommerce-points-and-rewards/woocommerce-points-and-rewards.php',
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		)
		) {
			// get the value of the user's point balance
			$available_user_discount = WC_Points_Rewards_Manager::get_users_points( $object['id'] );
			// return the post meta
			return (float) $available_user_discount;
		} else {
			return 0;
		}
	}

	add_action( 'woocommerce_order_status_processing', 'ams_order_processing' );
	function ams_order_processing( $order_id ) {

		if ( in_array(
			'woocommerce-points-and-rewards/woocommerce-points-and-rewards.php',
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		)
		) { // order-redeem
			$already_redeemed  = get_post_meta( $order_id, '_wc_points_redeemed', true );
			$logged_redemption = get_post_meta( $order_id, '_wc_points_logged_redemption', true );

			// Points has already been redeemed
			if ( ! empty( $already_redeemed ) ) {
				return;
			}
			$order       = wc_get_order( $order_id );
			$customer_id = version_compare( WC_VERSION, '3.0', '<' ) ? $order->user_id : $order->get_user_id();

			// bail for guest user
			if ( ! $customer_id ) {
				return;
			}

			$discount_code = $order->get_meta( '_ams_wc_points_rewards_discount_code' );

			if ( ! empty( $logged_redemption ) ) {
				$points_redeemed = $logged_redemption['points'];
				$discount_amount = $logged_redemption['amount'];
				$discount_code   = $logged_redemption['discount_code'];
			} else {
				$points_redeemed = $order->get_meta( '_ams_wc_points_redeemed' );
				// bail if ams is not involved
				if ( ! $points_redeemed ) {
					return;
				}
				// Get amount of discount
				$discount_amount = $order->get_meta( '_ams_wc_points_rewards_discount_amount' );

			}
			WC_Points_Rewards_Manager::decrease_points(
				$customer_id,
				$points_redeemed,
				'order-redeem',
				array(
					'discount_code'   => $discount_code,
					'discount_amount' => $discount_amount,
				),
				$order_id
			);
			update_post_meta( $order_id, '_wc_points_redeemed', $points_redeemed );
			update_post_meta(
				$order_id,
				'_wc_points_logged_redemption',
				array(
					'points'        => $points_redeemed,
					'amount'        => $discount_amount,
					'discount_code' => $discount_code,
				)
			);

			// add order note
			/* translators: 1: points earned 2: points label 3: discount amount */
			$order->add_order_note( sprintf( __( '%1$d %2$s redeemed for a %3$s discount.', 'woocommerce-points-and-rewards' ), $points_redeemed, ams_get_points_label( $points_redeemed ), wc_price( $discount_amount ) ) );

		}

	}
	function ams_change_password(WP_REST_Request $request){

		$req = $request->get_json_params();

		$user       = wp_authenticate( sanitize_email( $req['username'] ), sanitize_text_field( $req['password'] ) );  // htmlspecialchars
		$customer_id = sanitize_text_field( $req['customer_id'] );
		$old_password = sanitize_text_field( $req['old_password'] );
		$new_password = sanitize_text_field( $req['new_password'] );
		$confirm_password = sanitize_text_field( $req['confirm_password'] );
		
		$user = get_user_by( 'id', $customer_id );
		if ( isset( $user->errors ) ) {
			$error_message = strip_tags( ams_convert_error_to_string( $user->errors ) );
			$error         = new WP_Error();
			$error->add( 'message', __( $error_message . '' ) );
			return $error;
		}
		
		$x = wp_check_password( $old_password, $user->data->user_pass, $user->data->ID );
		
		if ( isset( $x->errors ) ) {
			$error_message = strip_tags( ams_convert_error_to_string( $x->errors ) );
			$error         = new WP_Error();
			$error->add( 'message', __( $error_message . '' ) );
			return $error;
		}		
		if($x)
		{	 		
			if($new_password == $old_password)
			{
				return new WP_Error( 'ams_error', 'Sorry, your new password and old password can not be the same.', array( 'status' => 422 ) );
			}
			if($new_password == $confirm_password)
			{
				$user_data['ID'] = $user->data->ID;
				$user_data['user_pass'] = $new_password;
				$uid = wp_update_user( $user_data );
				//wp_set_password($new_password , $user_id);
				if($uid) 
				{
					unset($passdata);
					$user->data->user_pass = '';
					$user->data->user_activation_key = '';
					$user->data->id = $user->ID; //integer
					$user->data->first_name = get_user_meta( $user->ID, 'first_name', true );
					$user->data->last_name = get_user_meta( $user->ID, 'last_name', true );														
					$user->data->roles = $user->roles;				
					return rest_ensure_response( $user->data );
				} else {						
					return new WP_Error( 'ams_error', 'Sorry, your account was not updated. Please try again later.', array( 'status' => 422 ) );
				}
			}
			else
			{					
				return new WP_Error( 'ams_error', 'Sorry, both your passwords do not match. Please try again. ', array( 'status' => 422 ) );				
			}			
		} 
		else 
		{			
			return new WP_Error( 'ams_error', 'Sorry, your old password is not correct. Please try again.', array( 'status' => 422 ) );
		}		
		
	}

	// //
	// Other Helping Function ###########################################//
	// //
	function ams_get_points_rewards_discount_amount( $customer_id, $wc_points_rewards_discount_amount, $line_items ) {

		if ( empty( $line_items ) ) {
			return 0;
		}
		
		$granted_user_discount = 0;
		// Construct local cart
		if ( is_null( WC()->cart ) ) {
			wc_load_cart();
		}
		WC()->cart->empty_cart();
		
		foreach ( $line_items as $key => $value ) {
			if ( array_key_exists( 'variation_id', $value ) ) {
				WC()->cart->add_to_cart( $value['product_id'], $value['quantity'], $value['variation_id'] );
			} else {
				WC()->cart->add_to_cart( $value['product_id'], $value['quantity'] );
			}
		}

			$available_user_discount = WC_Points_Rewards_Manager::get_users_points_value( $customer_id );

			// no discount
		if ( $available_user_discount <= 0 ) {
			return 0;
		}
		if ( 'yes' === get_option( 'wc_points_rewards_partial_redemption_enabled' ) && $wc_points_rewards_discount_amount ) {
			$requested_user_discount = WC_Points_Rewards_Manager::calculate_points_value( $wc_points_rewards_discount_amount );
			if ( $requested_user_discount > 0 && $requested_user_discount < $available_user_discount ) {
				$available_user_discount = $requested_user_discount;
			}
		}

			// Limit the discount available by the global minimum discount if set.
			$minimum_discount = get_option( 'wc_points_rewards_cart_min_discount', '' );
		if ( $minimum_discount > $available_user_discount ) {
			return 0;
		}
			$discount_applied = 0;

		if ( ! did_action( 'woocommerce_before_calculate_totals' ) ) {
			WC()->cart->calculate_totals();
		}

		foreach ( WC()->cart->get_cart() as $item_key => $item ) {

			$discount     = 0;
			$max_discount = WC_Points_Rewards_Product::get_maximum_points_discount_for_product( $item['data'] );

			if ( is_numeric( $max_discount ) ) {

				// adjust the max discount by the quantity being ordered
				$max_discount *= $item['quantity'];

				// if the discount available is greater than the max discount, apply the max discount
				$discount = ( $available_user_discount <= $max_discount ) ? $available_user_discount : $max_discount;

				// Max should be product price. As this will be applied before tax, it will respect other coupons.
			} else {
				/*
				 * Only exclude taxes when configured to in settings and when generating a discount amount for displaying in
				 * the checkout message. This makes the actual discount money amount always tax inclusive.
				 */
				if ( 'exclusive' === get_option( 'wc_points_rewards_points_tax_application', wc_prices_include_tax() ? 'inclusive' : 'exclusive' ) && $for_display ) {
					if ( function_exists( 'wc_get_price_excluding_tax' ) ) {
						$max_discount = wc_get_price_excluding_tax( $item['data'], array( 'qty' => $item['quantity'] ) );
					} elseif ( method_exists( $item['data'], 'get_price_excluding_tax' ) ) {
						$max_discount = $item['data']->get_price_excluding_tax( $item['quantity'] );
					} else {
						$max_discount = $item['data']->get_price( 'edit' ) * $item['quantity'];
					}
				} else {
					if ( function_exists( 'wc_get_price_including_tax' ) ) {
						$max_discount = wc_get_price_including_tax( $item['data'], array( 'qty' => $item['quantity'] ) );
					} elseif ( method_exists( $item['data'], 'get_price_including_tax' ) ) {
						$max_discount = $item['data']->get_price_including_tax( $item['quantity'] );
					} else {
						$max_discount = $item['data']->get_price( 'edit' ) * $item['quantity'];
					}
				}

				// if the discount available is greater than the max discount, apply the max discount
				$discount = ( $available_user_discount <= $max_discount ) ? $available_user_discount : $max_discount;
			}

			// add the discount to the amount to be applied
			$discount_applied += $discount;

			// reduce the remaining discount available to be applied
			$available_user_discount -= $discount;
		}
			// limit the discount available by the global maximum discount if set
			$max_discount = get_option( 'wc_points_rewards_cart_max_discount' );

		if ( false !== strpos( $max_discount, '%' ) ) {
			$max_discount = ams_calculate_discount_modifier( $max_discount );
			WC()->cart->empty_cart();
		}
			$max_discount = filter_var( $max_discount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

		if ( $max_discount && $max_discount < $discount_applied ) {
			$discount_applied = $max_discount;
		}
			// clear cart before returning
			WC()->cart->empty_cart();
			$discount_applied = filter_var( $discount_applied, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			return $discount_applied;

	}

	function ams_get_points_label( $count ) {

		list( $singular, $plural ) = explode( ':', get_option( 'wc_points_rewards_points_label' ) );

		return 1 == $count ? $singular : $plural;
	}
	function ams_is_coupon_code_valid( $coupon_code ) {
		if ( 0 === strpos( $coupon_code, 'wc_points_redemption_' ) ) {
			return true;
		}
		return false;
	}

	function ams_calculate_discount_modifier( $percentage ) {

		$percentage = str_replace( '%', '', $percentage ) / 100;

		if ( 'no' === get_option( 'woocommerce_prices_include_tax' ) ) {
			$discount = WC()->cart->subtotal_ex_tax;

		} else {
			$discount = WC()->cart->subtotal;

		}

		return $percentage * $discount;
	}

	function ams_object_to_array( $data ) {
		if ( is_array( $data ) || is_object( $data ) ) {
			$result = array();
			foreach ( $data as $key => $value ) {
				$value['field_name'] = $key;
				$value['options']    = array_values( $value['options'] );
				$result[]            = $value;

			}
			return $result;
		}
		return $data;
	}

	function ams_build_category_tree( $flat, $pidKey, $idKey = null ) {
		$grouped = array();
		foreach ( $flat as $sub ) {
			$grouped[ $sub[ $pidKey ] ][] = $sub;
		}
		$level     = 0;
		$fnBuilder = function( $siblings, $level ) use ( &$fnBuilder, $grouped, $idKey ) {
			foreach ( $siblings as $k => $sibling ) {
				if ( $sibling['slug'] == 'uncategorized' ) {
					unset( $siblings[ $k ] );
					continue;
				}
				$id                     = $sibling[ $idKey ];
				$sibling['description'] = '';
				$level++;
				if ( isset( $grouped[ $id ] ) ) {
					$sibling['depth']    = $level;
					$sibling['children'] = array_values( $fnBuilder( $grouped[ $id ], $level ) );
				} else {
					$sibling['depth']    = $level;
					$sibling['children'] = array();
				}
				$siblings[ $k ] = $sibling;
				$level--;
			}
			return $siblings;
		};

		if ( isset( $grouped[0] ) ) {
			$tree = $fnBuilder( $grouped[0], $level );
		}
		if ( ! empty( $tree ) ) {
			return array_values( $tree );
		} else {
			foreach ( $flat as $key => $value ) {
				if ( $value['slug'] == 'uncategorized' ) {
					unset( $flat[ $key ] );
					continue;
				}
				$flat[ $key ]['children'] = array();
			}
			return array_values( $flat );
		}
	}

	function ams_convert_error_to_string( $er ) {
		 $string = ' ';
		foreach ( $er as $key => $value ) {

			$string = $string . '' . $key . ':';
			foreach ( $value as $newkey => $newvalue ) {

				$string = $string . '' . $newvalue . ' ';
			}
		}
		 $string = str_replace( 'Lost your password?', '', $string );
		 $string = str_replace( 'Error:', '', $string );
		 $string = str_replace( '[message]', '', $string );
		 return( $string );
	}

	function ams_basic_validate( $request, $keys ) {
		foreach ( $keys as $key => $value ) {

			if ( ! isset( $request[ $value ] ) ) {
				status_header( 400 );
				echo ( json_encode(
					array(
						'message' => 'There is a problem with your input!',
						'error'   => $value . ': Field is required!',
					),
					JSON_UNESCAPED_UNICODE
				) );
				die();
			}
			if ( empty( $request[ $value ] ) ) {
				status_header( 400 );
				echo ( json_encode(
					array(
						'message' => 'There is a problem with your input!',
						'error'   => $value . ': Can not be empty!',
					),
					JSON_UNESCAPED_UNICODE
				) );
				die();
			}
		}
		 return true;
	}
	
	require_once untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/ams-plugin-deactivation-survey.php';
				
	add_action( 'wp_ajax_ams_deactivation_form_submit', 'ams_deactivation_form_submit' );
			
	add_action('admin_enqueue_scripts', 'ams_admin_enqueue_scripts'); 
	function ams_admin_enqueue_scripts(){
		
		$current_page = get_current_screen()->base;
		
		if($current_page == 'plugins' || $current_page == 'plugins-network') {
			
			add_action('admin_footer', 'ams_deactivation_popup');
				
			wp_register_script('ams_jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), '3.6.0', true); // jQuery v3
			wp_enqueue_script('ams_jquery');
			wp_script_add_data( 'ams_jquery', array( 'integrity', 'crossorigin' ) , array( 'sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=', 'anonymous' ) );
			
			wp_enqueue_script('ams_plugin_deactivation_survey_js', plugins_url('assets/plugin-deactivation-survey.js', __FILE__), array('ams_jquery'));
			wp_localize_script('ams_plugin_deactivation_survey_js', 'frontend_ajax_object', array('amsDeactivationSurveyNonce' => wp_create_nonce('ajax-nonce')));
			wp_enqueue_style( 'ams_plugin_deactivation_survey_css', plugins_url('assets/plugin-deactivation-survey.css', __FILE__), array());
							
			
		} else { // # if not on plugins, deregister and dequeue styles & scripts

			wp_dequeue_script('ams_jquery');
			wp_dequeue_script('ams_plugin_deactivation_survey_js');
			wp_dequeue_style('ams_plugin_deactivation_survey_css');

		}
	}

