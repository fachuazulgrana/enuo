<?php
/*This file is part of ENUO, gwangi child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

if ( ! function_exists( 'suffice_child_enqueue_child_styles' ) ) {
	function ENUO_enqueue_child_styles() {
	    // loading parent style
	    wp_register_style(
	      'parente2-style',
	      get_template_directory_uri() . '/style.css'
	    );

	    wp_enqueue_style( 'parente2-style' );
	    // loading child style
	    wp_register_style(
	      'childe2-style',
	      get_stylesheet_directory_uri() . '/style.css'
	    );
	    wp_enqueue_style( 'childe2-style');
	 }
}
add_action( 'wp_enqueue_scripts', 'ENUO_enqueue_child_styles' );

/*Write here your own functions */

// Change Profile menu/tab order 
function rt_change_profile_tab_order() {
global $bp;

$bp->bp_nav['buddydrive']['name'] = 'Mastering';

$bp->bp_nav['profile']['position'] = 10;
$bp->bp_nav['collab']['position'] = 20;
$bp->bp_nav['project-templates']['position'] = 30;
$bp->bp_nav['mastering']['position'] = 40;


}
add_action( 'bp_setup_nav', 'rt_change_profile_tab_order', 999 );

// añadir soporte para svg
function add_file_types_to_uploads($file_types){
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');



/********Nuevo Codigo*********/
//Declaro variables
if ( ! defined( 'ENUO_THEME_FILE' ) ) {
    define( 'ENUO_THEME_FILE', __FILE__ );
}
define( 'ENUO_ABSPATH', dirname( ENUO_THEME_FILE ) . '/' );
define( 'ENUO_TEMPLATE_PATH', ENUO_ABSPATH . 'template-parts' );

//Creo Post Type Collab
if ( ! function_exists('collab_post_type') ) {
	// Register Custom Post Type
	function collab_post_type() {
		$labels = array(
			'name'                  => _x( 'Collab', 'Post Type General Name', 'enuo_domain' ),
			'singular_name'         => _x( 'Collab', 'Post Type Singular Name', 'enuo_domain' ),
			'menu_name'             => __( 'Collab', 'enuo_domain' ),
			'name_admin_bar'        => __( 'Collab', 'enuo_domain' ),
			/*'archives'              => __( 'Item Archives', 'enuo_domain' ),
			'attributes'            => __( 'Item Attributes', 'enuo_domain' ),
			'parent_item_colon'     => __( 'Parent Item:', 'enuo_domain' ),
			'all_items'             => __( 'All Items', 'enuo_domain' ),
			'add_new_item'          => __( 'Add New Item', 'enuo_domain' ),
			'add_new'               => __( 'Add New', 'enuo_domain' ),
			'new_item'              => __( 'New Item', 'enuo_domain' ),
			'edit_item'             => __( 'Edit Item', 'enuo_domain' ),
			'update_item'           => __( 'Update Item', 'enuo_domain' ),
			'view_item'             => __( 'View Item', 'enuo_domain' ),
			'view_items'            => __( 'View Items', 'enuo_domain' ),
			'search_items'          => __( 'Search Item', 'enuo_domain' ),
			'not_found'             => __( 'Not found', 'enuo_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'enuo_domain' ),
			'featured_image'        => __( 'Featured Image', 'enuo_domain' ),
			'set_featured_image'    => __( 'Set featured image', 'enuo_domain' ),
			'remove_featured_image' => __( 'Remove featured image', 'enuo_domain' ),
			'use_featured_image'    => __( 'Use as featured image', 'enuo_domain' ),
			'insert_into_item'      => __( 'Insert into item', 'enuo_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'enuo_domain' ),
			'items_list'            => __( 'Items list', 'enuo_domain' ),
			'items_list_navigation' => __( 'Items list navigation', 'enuo_domain' ),
			'filter_items_list'     => __( 'Filter items list', 'enuo_domain' ),*/
		);
		$args = array(
			'label'                 => __( 'Collab', 'enuo_domain' ),
			'description'           => __( 'Collaborate on a project', 'enuo_domain' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'author' ),
			'taxonomies'            => array( 'genero' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 20,
			//'menu_icon'             => 'ame-fa-headphones',
			'menu_icon'             => 'data:image/svg+xml;base64,' . base64_encode('<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 393.2 393.2" style="enable-background:new 0 0 393.2 393.2;" xml:space="preserve"><g><g><g><path d="M296.8,217c-9.6,0-17.6,8-17.6,17.6v126.8c0,9.6,8,17.6,17.6,17.6c9.6,0,17.6-8,17.6-17.6V235
				C314.8,225,306.8,217,296.8,217z"/>
			<path d="M392,225.8c0-23.2-4-46-12-67.2c-6.8-18.8-16.8-36.8-29.2-52.8c1.6-3.6,2.8-7.6,2.8-11.2c0-6.8-2.4-13.2-7.6-18.4
				c-20.4-20.4-43.6-35.6-68.8-46c-26-10.8-53.6-16-81.2-16c-27.6,0-55.2,5.2-81.2,16C89.6,40.6,66.4,55.8,46,76.2
				c-5.2,5.2-7.6,11.6-7.6,18.4c0,4,0.8,7.6,2.8,11.2c-12.4,16-22.4,34-29.2,52.8c-7.6,21.2-12,44-12,67.2v72.4
				c0,18,7.2,34.4,19.2,46.4c9.6,9.6,22,16,36,18.4V233.8v-0.4c-13.6,2-25.6,8.4-34.8,17.2v-25.2c0-20.8,3.6-41.2,10.8-60.4
				c6-16.8,14.8-32.4,25.6-46.4c2.8,0.8,5.6,1.2,8.4,1.2c6.4,0,12.8-2.4,17.6-6.8c0.4-0.4,0.4-0.4,0.8-0.8
				c15.2-15.2,32.8-26.8,51.6-34.8c19.6-8,40.4-12,61.2-12c20.8,0,41.6,4,61.2,12c18.8,7.6,36.4,19.2,51.6,34.8l0.4,0.4
				c5.2,4.8,11.6,7.6,18.4,7.6c2.8,0,5.6-0.4,8.4-1.2c10.8,14,19.2,30,25.6,46.4c6.8,19.2,10.8,39.6,10.8,60.4V251
				c-9.6-8.8-21.6-15.2-34.8-17.2v0.4V363c14-2,26.4-8.8,36-18.4c12-12,19.2-28,19.2-46.4v-72.4H392z"/>
			<path d="M95.2,217c-9.6,0-17.6,8-17.6,17.6v126.8c0,9.6,8,17.6,17.6,17.6c9.6,0,17.6-8,17.6-17.6V235
				C112.8,225,104.8,217,95.2,217z"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>'),
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'collab', $args );

	}
	add_action( 'init', 'collab_post_type', 0 );
}

/***TAXONOMIA GENEROS***/
// Register Custom Taxonomy
function generos_taxonomy() {
	$labels = array(
		'name'                       => _x( 'Generos', 'Taxonomy General Name', 'enuo_domain' ),
		'singular_name'              => _x( 'Genero', 'Taxonomy Singular Name', 'enuo_domain' ),
		'menu_name'                  => __( 'Generos', 'enuo_domain' ),
		'all_items'                  => __( 'All Items', 'enuo_domain' ),
		'parent_item'                => __( 'Genero Superior', 'enuo_domain' ),
		'parent_item_colon'          => __( 'Genero Superior:', 'enuo_domain' ),
		'new_item_name'              => __( 'Nombre Nuevo Genero', 'enuo_domain' ),
		'add_new_item'               => __( 'Añadir Genero', 'enuo_domain' ),
		'edit_item'                  => __( 'Editar Genero', 'enuo_domain' ),
		'update_item'                => __( 'Actualizar Genero', 'enuo_domain' ),
		'view_item'                  => __( 'Ver Genero', 'enuo_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'enuo_domain' ),
		'add_or_remove_items'        => __( 'Agregar o eliminar generos', 'enuo_domain' ),
		'choose_from_most_used'      => __( 'Elegir entre los más elegidos', 'enuo_domain' ),
		'popular_items'              => __( 'Generos Populares', 'enuo_domain' ),
		'search_items'               => __( 'Buscar Generos', 'enuo_domain' ),
		'not_found'                  => __( 'No se encontro', 'enuo_domain' ),
		'no_terms'                   => __( 'No hay generos', 'enuo_domain' ),
		'items_list'                 => __( 'Lista de generos', 'enuo_domain' ),
		'items_list_navigation'      => __( 'Navegacion de lista de generos', 'enuo_domain' ),		
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'genero', array( 'collab' ), $args );

}
add_action( 'init', 'generos_taxonomy', 0 );
/***TAXONOMIA GENEROS***/

/****METABOX COLLAB****/
//Metabox Datos Contacto
add_action( 'init', 'collab_registrar_meta_fields' );
function collab_registrar_meta_fields() {
  	register_meta( 'post',
               'collab_audio',
               [
                 'description'      => _x( 'Archivo de audio muestra para collab', 'meta description', 'enuo_domain' ),
                 'single'           => true,
                 'sanitize_callback' => null,
                 'auth_callback'     => 'metabox_sanatize_auth_calback'
               ]
	); 
	register_meta( 'post',
               'collab_zip',
               [
                 'description'      => _x( 'Archivo con proyecto completo de collab', 'meta description', 'enuo_domain' ),
                 'single'           => true,
                 'sanitize_callback' => null,
                 'auth_callback'     => 'metabox_sanatize_auth_calback'
               ]
	); 
}

function metabox_sanatize_auth_calback( $allowed, $meta_key, $post_id, $user_id, $cap, $caps ) {  
  $allowed = true;
  if( 'post' == get_post_type( $post_id ) && current_user_can( 'edit_post', $post_id ) ) {
    $allowed = true;
  } else {
    $allowed = false;
  }
  return $allowed;
}

//Metabox datos Contacto
add_action( 'add_meta_boxes_collab', 'collab_meta_boxes' );
function collab_meta_boxes() {
    add_meta_box( 'collab-meta-box-audio', __( 'Audio Muestra', 'enuo_domain' ), 'collab_meta_box_callback_audio', 'collab' );
	add_meta_box( 'collab-meta-box-zip', __( 'Proyecto Completo', 'enuo_domain' ), 'collab_meta_box_callback_zip', 'collab' );
}

function collab_meta_box_callback_audio( $post ) {
     // El nonce es opcional pero recomendable. Vea http://codex.wordpress.org/Function_Reference/wp_nonce_field
     wp_nonce_field( 'collab_meta_box_audio', 'collab_meta_box_audio_noncename' );
    
     // Obtenermos los meta data actuales para rellenar los custom fields
     // en caso de que ya tenga valores
     $post_meta = get_post_custom( $post->ID );

     // El input text
     ?>
     <p>
         <label class="datosleft" for="collab_audio"><?php _e( 'Audio de muestra: ', 'enuo_domain' ); ?></label>
         <span class="datosleft2"><input  name="collab_audio" id="collab_audio" type="text" value="<?php echo esc_attr( get_post_meta( $post->ID, 'collab_audio', true ) ); ?>"></span>
     </p>    
   <?php
}

function collab_meta_box_callback_zip( $post ) {    
     wp_nonce_field( 'collab_meta_box_zip', 'collab_meta_box_zip_noncename' ); 
     $post_meta = get_post_custom( $post->ID );
     ?>
     <p>
         <label class="datosleft" for="collab_zip"><?php _e( 'Archivo Completo ZIP: ', 'enuo_domain' ); ?></label>
         <span class="datosleft2"><input  name="collab_zip" id="collab_zip" type="text" value="<?php echo esc_attr( get_post_meta( $post->ID, 'collab_zip', true ) ); ?>"></span>
         </span>
     </p>   
   <?php	
	
}

//Guardar los datos de los metabox
add_action( 'save_post', 'enuo_guardar_post_types', 10, 2 );
function enuo_guardar_post_types( $post_id, $post ){		
	/*Guardo los datos del Collab*/
	if ( $post->post_type == 'collab' ) {
		// Primero, comprobamos el nonce como medida de segurida
		if ( ! isset( $_POST['collab_meta_box_audio_noncename'] ) || ! wp_verify_nonce( $_POST['collab_meta_box_audio_noncename'], 'collab_meta_box_audio' ) ) {
			return;
		}
		if ( ! isset( $_POST['collab_meta_box_zip_noncename'] ) || ! wp_verify_nonce( $_POST['collab_meta_box_zip_noncename'], 'collab_meta_box_zip' ) ) {
			return;
		}
		//Guardo los metadatos
		if( isset( $_POST['collab_audio'] ) && $_POST['collab_audio'] != "" ) {
			update_post_meta( $post_id, 'collab_audio', $_POST['collab_audio'] );
		} else {delete_post_meta( $post_id, 'collab_audio' );}		
		if( isset( $_POST['collab_zip'] ) && $_POST['collab_zip'] != "" ) {
			update_post_meta( $post_id, 'collab_zip', $_POST['collab_zip'] );
		} else {delete_post_meta( $post_id, 'collab_zip' );	}
					
	}/**End If collab**/	
}

/****FIN METABOX COLLAB****/

//Hago que los mails se manden con html
function wp_mail_set_content_type(){
	return "text/html";
}
//Doy formato a los mails
function enviar_mail_formato_html($maildire, $asunto, $titulo, $contenido, $firma = "", $adjuntos = array(), $headers = ''){	    
	if($firma == ""){
		$firma = '<div style="color: #858585; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 11px; line-height: 150%; text-align: center; padding: 24px 0"><p>Saludos!!!<br>ENUO</p></div>';
	}
	//Doy formato al cuerpo del mail agregando el header y el footer
	ob_start();
	include(ENUO_TEMPLATE_PATH.'/email-header.php');
	echo $contenido;
	echo '<div style="color: #858585; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 11px; line-height: 150%; text-align: center; padding: 24px 0">'.$firma.'</div>';
	include(ENUO_TEMPLATE_PATH.'/email-footer.php');
	$html = ob_get_contents();
	ob_end_clean();	    
	//envio el mail
	$enviomail = wp_mail( $maildire, $asunto, $html, $headers, $adjuntos);	    
	return $enviomail;
}	

/***Funciones Consultas BD***/
function get_config_enuo($campo) {
	global $wpdb;
	$respuesta = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT valor
			 FROM en0722_enuo_configs
			 WHERE campo = %s", $campo ));
	return $respuesta;
}
/***Funciones Consultas BD***/

/***Funciones Ajax Collab ****/
add_action( 'wp_ajax_enuo_descargar_archivo', 'fn_btndescargar_ajax' );
add_action( 'wp_ajax_nopriv_enuo_descargar_archivo', 'fn_btndescargar_ajax' );

function fn_btndescargar_ajax(){	    
	$nonce = sanitize_text_field( $_POST['nonce'] );
	if ( ! wp_verify_nonce( $nonce, 'enuo-dw-pro-nonce' ) ) {	        
		$result['type'] = "error";
		$result['response'] = "Ha pasado demasiado tiempo y ha vencido la sesi&oacute;n del navegador. Por favor, actualice la pantalla.";
		$result = json_encode($result);
		die ($result);
	}
	
	//Obtengo todos los datos que necesito
	$idcollab = sanitize_text_field( $_POST['idcollab']);	
	$idusr = sanitize_text_field( $_POST['idusr']);	
	if($idusr != get_current_user_id()){
		$result['type'] = "error";
		$result['response'] = "Hubo un error al comprobar tu usuario!";
		$result = json_encode($result);
		die ($result);
	}
	//obtengo el titulo
	$titulocollab = get_the_title( $idcollab );
	$descripcioncollab = get_the_content( $idcollab );
	$urlarchivozip = get_post_meta($idcollab, 'collab_zip', true);	
	$colaboradoractivo = get_post_meta( $idcollab, 'colaborador_activo', true );
	//Verifico que el collab este disponible y que este usuario no haya superado el maximo de proyectos simultaneos
	
	$collabs_activos = get_user_meta( $idusr, 'collabs_activos', true ); 
	if(isset($collabs_activos) && !empty($collabs_activos) && is_numeric($collabs_activos) && $colaboradoractivo!=$idusr){
		$collabs_activos = intval($collabs_activos) + 1;	
		$maximo = get_config_enuo('max_collab_activos');//Luego cambiar por funcion global
		$maximo = intval($maximo);
		if($collabs_activos > $maximo){
			//Ya tiene suficientes proyectos simultaneos devuelvo error
			$result['type'] = "error";
			$result['response'] = "Tienes el máximo de proyectos simultáneos (".$maximo.")! Una vez que finalices los proyectos actuales podrás aceptar nuevos proyectos.";
			$result = json_encode($result);
			die ($result);			
		}
		
	}else{
		$collabs_activos = 1;
	}
	
	
	//Verifico si es que lo esta volviendo a descargar o si es la primera vez	
	if(isset($colaboradoractivo) && !empty($colaboradoractivo) && $colaboradoractivo == $idusr){
		//Ya lo descargo porque esta activo, vuelvo a permitir que lo descargue pero no envio mails ni modifico los datos 
		$result['type'] = "ok";
		$result['response'] = "Puedes volver a descargar el Proyecto ".$titulocollab."!!!";
		$result['urlarchivo'] = $urlarchivozip;
		$result = json_encode($result);
		die ($result);	  
	}
	
	//Verifico si alguien ya o solicito y no esta disponible
	
	$fechadescargacollab = get_post_meta( $idcollab, 'fecha_descarga', true ); 		
	$rangocollab = get_config_enuo('cant_dias_bloqueo_collab');//Luego cambiar por funcion global
	$rangocollab = intval($rangocollab);
	$fechadescargacollabd = new DateTime($fechadescargacollab);
	$fechadesde = new DateTime();
	date_sub($fechadesde, date_interval_create_from_date_string( $rangocollab.' days'));
	if($fechadescargacollabd < $fechadesde){
		//Fecha del collab es mas vieja	
		$vigente = false;
	}else{
		//Fecha del collab es mas nueva
		$vigente = true;							
	}		
	
	
	if(isset($colaboradoractivo) && !empty($colaboradoractivo) && $colaboradoractivo != "" && $colaboradoractivo != $idusr && $vigente){
		//Ya tiene suficientes proyectos simultaneos devuelvo error
			$result['type'] = "error";
			$result['response'] = "Este Collab ".$titulocollab." ya no se encuentra disponible.";
			$result = json_encode($result);
			die ($result);
	}
	
	//Verifico si lo esta bajando otro usuario por vencimiento de plazo
	if(isset($colaboradoractivo) && !empty($colaboradoractivo) && $colaboradoractivo != "" && $colaboradoractivo != $idusr && !$vigente){
		//Lo esta descargando otro usuario diferente al actual porque pasaron n dias
		//Quito el collab de la lista del usuario
		$lista_id_collabs_usr = get_user_meta( $colaboradoractivo, 'collabs_activos_ids', true );
		$buscar = $idcollab.',';
		$nuevalista = str_replace($buscar, '', $lista_id_collabs_usr);
		update_user_meta( $colaboradoractivo, 'collabs_activos_ids', $nuevalista );

		//Actualizo los meta del usuario que descarga el archivo
		$collabs_activos = get_user_meta( $colaboradoractivo, 'collabs_activos', true ); 
		if(isset($collabs_activos) && !empty($collabs_activos) && is_numeric($collabs_activos)){
			$collabs_activos = intval($collabs_activos) - 1;		
		}
		update_user_meta( $colaboradoractivo, 'collabs_activos', $collabs_activos );	
	}
	
	//Seteo la fecha y hora del momento en que se descarga el collab
	$fecha = new DateTime();
	$fecha = $fecha->format("Y-m-d H:i:s");		
	update_post_meta( $idcollab, 'fecha_descarga', $fecha );
	
	
	
	$colaboradores = get_post_meta( $idcollab, 'lista_colaboradores', true ); 
	if(isset($colaboradores) && !empty($colaboradores)){
		//verifico si ya esta el codigo de este usuario en la lista, si esta no hago nada. Si no esta lo agrego		
		$esta = false;
		if (strpos($colaboradores, ','.$idusr.',') !== false) {
			$esta = 'true';
		}		
		if(!$esta){
			//si no esta lo agrego
			$colaboradores .= $idusr.',';
		}			
	}else{
		$colaboradores = ','.$idusr.',';
	}
	update_post_meta( $idcollab, 'lista_colaboradores', $colaboradores );	
	update_post_meta( $idcollab, 'colaborador_activo', $idusr );
	
	//Actualizo los meta del usuario que descarga el archivo
	$collabs_activos = get_user_meta( $idusr, 'collabs_activos', true ); 
	if(isset($collabs_activos) && !empty($collabs_activos) && is_numeric($collabs_activos)){
		$collabs_activos = intval($collabs_activos) + 1;		
	}else{
		$collabs_activos = 1;
	}
	update_user_meta( $idusr, 'collabs_activos', $collabs_activos );
	
	
	$lista_id_collabs_usr = get_user_meta( $idusr, 'collabs_activos_ids', true ); 
	if(isset($lista_id_collabs_usr) && !empty($lista_id_collabs_usr)){
		//verifico si ya esta el codigo de este usuario en la lista, si esta no hago nada. Si no esta lo agrego		
		$estaid = false;
		if (strpos($lista_id_collabs_usr, ','.$idcollab.',') !== false) {
			$estaid = 'true';
		}		
		if(!$estaid){
			//si no esta lo agrego
			$lista_id_collabs_usr .= $idcollab.',';
		}			
	}else{
		$lista_id_collabs_usr = ','.$idcollab.',';
	}
	update_user_meta( $idusr, 'collabs_activos_ids', $lista_id_collabs_usr );	
	
	//Envio mail al dueño del collab
	$collab_author_id = get_post_field( 'post_author', $idcollab );
	$user_info = get_userdata($collab_author_id);
	$proda_name = $user_info->display_name;
	$mailproda = $user_info->user_email;//obtengo el mail del usuario autor del collab	
	
	
	$user_info = get_userdata($idusr);
	$prodb_name = $user_info->display_name;
	$mailproda = $user_info->user_email;//obtengo el mail del usuario autor del collab	
	
	$contenidoa = "<p>Hola ".$proda_name.", ".$prodb_name." descargo tu proyecto ".$titulocollab." para más informacion ingresa en tu cuenta de http://enuo.com</p>";
	enviar_mail_formato_html($mailproda, "Han descargado tu proyecto", "Collab", $contenidoa);
	
	//Envio mail a quien lo descargo
	$contenidob = '<p>Hola '.$prodb_name.', gracias por colaborar en el proyecto de '.$proda_name.' - '.$titulocollab.' si aun no lo descargaste hazlo haciendo clic aqui <a href="'.$urlarchivozip.'" ></a>Descargar Proyecto</p>';
	$mailprodb = "";//obtengo el mail del usuario logueado
	enviar_mail_formato_html($mailprodb, "Collab ", "Collab", $contenidob);
	
	$result['type'] = "ok";
	$result['response'] = "Gracias por aceptar el proyecto ".$titulocollab."!!!";
	$result['urlarchivo'] = $urlarchivozip;
	
	$result = json_encode($result);
	die ($result);	  
	// Importante terminar la funcion con el die
	wp_die();
}


//Funcion para liberar/cancelar Collab y vuelva a estar disponible para descarga
add_action( 'wp_ajax_enuo_cancelar_collab', 'fn_btncancelarcollab_ajax' );
add_action( 'wp_ajax_nopriv_enuo_cancelar_collab', 'fn_btncancelarcollab_ajax' );

function fn_btncancelarcollab_ajax(){	    
	$nonce = sanitize_text_field( $_POST['nonce'] );
	if ( ! wp_verify_nonce( $nonce, 'enuo-dw-pro-nonce' ) ) {	        
		$result['type'] = "error";
		$result['response'] = "Ha pasado demasiado tiempo y ha vencido la sesi&oacute;n del navegador. Por favor, actualice la pantalla.";
		$result = json_encode($result);
		die ($result);
	}
	
	//Obtengo todos los datos que necesito
	$idcollab = sanitize_text_field( $_POST['idcollab']);	
	$idusr = sanitize_text_field( $_POST['idusr']);	
	if($idusr != get_current_user_id()){
		$result['type'] = "error";
		$result['response'] = "Hubo un error al comprobar tu usuario!";
		$result = json_encode($result);
		die ($result);
	}
	//obtengo el titulo
	$titulocollab = get_the_title( $idcollab );
	$descripcioncollab = get_the_content( $idcollab );
	
	$colaboradoractivo = get_post_meta( $idcollab, 'colaborador_activo', true );	
	$collab_author_id = get_post_field( 'post_author', $idcollab );
	
	if($idusr != $colaboradoractivo && $idusr != $collab_author_id){
		//El id de usuario no corresponde ni con el creador ni con el colaborador activo
		$result['type'] = "error";
		$result['response'] = "El Collab que intentas cancelar no corresponde a tu usuario!";
		$result = json_encode($result);
		die ($result);
	}
	
	//Quien dio la orden es uno de los dos usuarios involucrados
	//Elimino el colaborador activo y vuelve a estar disponible para descarga		
	delete_post_meta( $idcollab, 'colaborador_activo' );
	
	//Quito el collab de la lista del usuario
	$lista_id_collabs_usr = get_user_meta( $colaboradoractivo, 'collabs_activos_ids', true );
	$buscar = $idcollab.',';
	$nuevalista = str_replace($buscar, '', $lista_id_collabs_usr);
	update_user_meta( $colaboradoractivo, 'collabs_activos_ids', $nuevalista );
	
	
	
	//Actualizo los meta del usuario que descarga el archivo.
	$collabs_activos = get_user_meta( $colaboradoractivo, 'collabs_activos', true ); 
	if(isset($collabs_activos) && !empty($collabs_activos) && is_numeric($collabs_activos)){
		$collabs_activos = intval($collabs_activos) - 1;		
	}
	update_user_meta( $colaboradoractivo, 'collabs_activos', $collabs_activos );
	
	
	//Envio mail al dueño del collab
	$collab_author_id = get_post_field( 'post_author', $idcollab );
	$user_info = get_userdata($collab_author_id);
	$proda_name = $user_info->display_name;
	$mailproda = $user_info->user_email;//obtengo el mail del usuario autor del collab	
	
	
	$user_info = get_userdata($idusr);
	$prodb_name = $user_info->display_name;
	$mailproda = $user_info->user_email;//obtengo el mail del usuario autor del collab	
	
	$contenidoa = "<p>Hola ".$proda_name.", se ha cancelado el Collab en el proyecto '.$titulocollab.' para ver otros proyectos ingresa a tu cuenta de ENUO.</p>";
	enviar_mail_formato_html($mailproda, "Collab '.$titulocollab.' cancelado", "Collab", $contenidoa);
	
	//Envio mail a quien lo descargo
	$contenidob = '<p>Hola '.$prodb_name.', se ha cancelado el Collab en el proyecto '.$titulocollab.' para ver otros proyectos ingresa a tu cuenta de ENUO.</p>';
	$mailprodb = "";//obtengo el mail del usuario logueado
	enviar_mail_formato_html($mailprodb, "Collab '.$titulocollab.' cancelado", "Collab", $contenidob);
	
	$result['type'] = "ok";
	$result['response'] = "Se ha cancelado el Collab ".$titulocollab." de manera exitosa!!!";
	$result['urlarchivo'] = $urlarchivozip;
	
	$result = json_encode($result);
	die ($result);	  
	// Importante terminar la funcion con el die
	wp_die();
}


/*** Fin Funciones Ajax Collab****/
