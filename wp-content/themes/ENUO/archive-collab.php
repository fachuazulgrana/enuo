<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package gwangi
 */

get_header();
/*get_sidebar( 'left' );*/ 

$idusuario = get_current_user_id();

//Importo el js de AJAX
wp_enqueue_script( 'enuo-dw-js', get_stylesheet_directory_uri() . '/assets/js/enuo-ajax.js', array( 'jquery' ) );
wp_localize_script( 'enuo-dw-js', 'enuo_ajax_adm', array(
	'ajax_url'    => admin_url( 'admin-ajax.php' ),
	'ajax_nonce'  => wp_create_nonce( 'enuo-dw-pro-nonce' ),
	'idusr'  => $idusuario,
	'actiondescarga' => 'enuo_descargar_archivo',
	'actioncancelar' => 'enuo_cancelar_collab',
) );


$current_user = wp_get_current_user();

$urlimagenestheme = get_stylesheet_directory_uri().'/assets/images/'; 

$filtros = "";
if(isset($_GET['genero']) && is_tax( 'genero', $_GET['genero'] )){	
 	$filtros .="?genero=".$_GET['genero'];
}


//Calculo de paginacion
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
//opcion 1
$total_post_count = wp_count_posts('collab');
$published_post_count = $total_post_count->publish;


//opcion 2 hay un filtro de genero		
$nombregenero = "";
if(isset($_GET['genero']) && is_tax( 'genero', $_GET['genero'] )){	
	$term = get_term_by('slug', $_GET['genero'], 'genero');				
	$total_in_term = $term->count;
	$published_post_count = $total_in_term;	
	$nombregenero = $term->name;
}			

$total_pages = ceil( $published_post_count / $posts_per_page );

$anterior = $paged-1;
if($anterior > 0 ){
	$urlanterior = get_site_url().'/collab/page/'.$anterior.'/'.$filtros;
}
$siguiente = $paged+1;
if($siguiente <= $total_pages ){
	$urlsiguiente= get_site_url().'/collab/page/'.$siguiente.'/'.$filtros;
}

?>

<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri();?>/assets/css/green-audio-player.css">

<!-- ESTILOS COLLAB -->
<style>	
.enuo-button{border-radius: 50px !important; background: rgb(197,0,130);background: -moz-linear-gradient(90deg, rgba(197,0,130,1) 0%, rgba(192,0,57,1) 100%);background: -webkit-linear-gradient(90deg, rgba(197,0,130,1) 0%, rgba(192,0,57,1) 100%);background: linear-gradient(90deg, rgba(197,0,130,1) 0%, rgba(192,0,57,1) 100%);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#c50082",endColorstr="#c00039",GradientType=1); border: none !important;font-family: Poppins !important;color: #FFF;	text-align: center;text-decoration: none;padding: .75em 1em;font-size: 16px;line-height: 1.5em;box-shadow: 0 2px 4px rgba(0,0,0,.3),inset 0 1px 0 rgba(255,255,255,.4);border: 0;cursor: pointer;font-weight: 500;}
.enuo-button:hover{color: #FFF !important;box-shadow: 0 2px 4px rgba(0,0,0,.7),inset 0 1px 0 rgba(255,255,255,.6);}
.enuo-button img{width: 20px; height: 19px;}
.menu-collab{display: -ms-flexbox;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin: 30px auto !important;width: 100% !important;align-items: center;
	-webkit-flex-basis: 0;-ms-flex-preferred-size: 0;flex-basis: 0;-webkit-box-flex: 1;-webkit-flex-grow: 1;-ms-flex-positive: 1;flex-grow: 1;max-width: 100%;}
.menu-collab .col-1{-ms-flex: 0 0 40%;flex: 0 0 40%;flex-basis: 40%;max-width: 40%;}
.titulo-collab{font-size: 18px;}
.menu-collab .col-2{-ms-flex: 0 0 60%;flex: 0 0 60%;flex-basis: 60%;max-width: 60%;align-items: center;}
.align-right{float: right;}
.align-center{text-align: center;}
form.select-genero{margin: 0 15px;display: inline-flex;}
form.select-genero select{border: 0;color: #FFF;font-family: Poppins !important;cursor: pointer;-webkit-appearance: none;-moz-appearance: none;-ms-appearance: none;appearance: none;outline: 0;background: #242330 url('http://enuo.com/wp-content/themes/ENUO/assets/images/ic-select.png') no-repeat;background-position-x: 0%;background-position-y: 0%;background-position: right;font-size: 16px;padding-right: 34px;}
.collabs{width: 100%;}
.collabs .collab{display: flex;flex-flow: row wrap;justify-content: space-between;align-items: center;padding: 2%;background: #181818; width: 100%;}
.collabs .collab .c-nombre{width: 20%}
.collabs .collab .c-audioprevio{width: 68%; max-width: 750px;}
.collabs .collab .c-accion{width: 12%;display: inline-block;}
.collabs .collab .c-accion a,.collabs .collab .c-accion span{margin: 0 5px;cursor: pointer;}
.collabs .collab .c-accion img{width: 50%;max-width: 27px;}
.btnabrirmodal, .btncancelarmodal{cursor: pointer;}
.btnabrirmodal img, .btncancelarmodal img {width: 100% !important;max-width: 27px!important;}
audio{width: 100%;background:#181818;color: #FFF;filter: opacity(1);}
audio::-webkit-media-controls-panel,audio::-webkit-media-controls-panel,audio::-webkit-media-controls-mute-button,audio::-webkit-media-controls-timeline-container,audio::-webkit-media-controls-current-time-display,audio::-webkit-media-controls-time-remaining-display,audio::-webkit-media-controls-timeline,audio::-webkit-media-controls-volume-slider-container,audio::-webkit-media-controls-volume-slider,audio::-webkit-media-controls-seek-back-button,audio::-webkit-media-controls-seek-forward-button,audio::-webkit-media-controls-fullscreen-button,audio::-webkit-media-controls-rewind-button,audio::-webkit-media-controls-return-to-realtime-button,audio::-webkit-media-controls-toggle-closed-captions-button,audio::-webkit-media-controls-enclosure{background-color: #181818;color: #FFF !important;border: none; 
border-color: #181818 }
audio::-webkit-media-controls-play-button{background-color: #FFF;color: #FFF !important;border: none;}
.paginacion-collab{margin-top: 40px;}
.paginacion-collab .enuo-button-o {border-radius: 50px;border: solid 3px transparent;background-image: linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0)), linear-gradient(101deg, #c50082, #c00039);background-origin: border-box;background-clip: content-box, border-box;box-shadow: 2px 1000px 1px #242330 inset;font-family: Poppins !important;color: #FFF;text-align: center;text-decoration: none;padding: .75em 1em;font-size: 16px;line-height: 1.5em;}
.paginacion-collab a{color: #FFF !important;text-decoration: none;}
	
@media only screen and (max-width: 780px){ 
	.collabs .collab{display: block;border-bottom: 6px solid #242330;}
	.collabs .collab .c-nombre,.collabs .collab .c-audioprevio,.collabs .collab .c-accion{width: 100%;}
	.menu-collab .col-1,.menu-collab .col-2{-ms-flex: 0 0 100%;flex: 0 0 100%;flex-basis: 100%;flex-basis: 100%;max-width: 100%;}
	.menu-collab .col-1{margin-bottom: 30px;}
	.dropbtn,.enuo-button,.menu-collab .col-2{font-size: 14px !important;}
}
@media only screen and (max-width: 480px){ 
	.menu-collab .align-right{float: none;}
	.dropbtn, .enuo-button, .menu-collab .col-2 {display: block;text-align: center;}
	form.select-genero{margin-bottom: 30px;}
	.paginacion-collab .align-center{display: inline-block;min-height: 56px;width: 100%;}
	.paginacion-collab .align-right {float: none;text-align: right;}
	.collabs .collab .c-audioprevio{min-width: 100% !important;padding:0 2%;}
	.collabs .collab .c-accion{text-align: center;margin-bottom: 5px;}
}
	
.post-type-archive-collab .site-content {background: #242330 !important;color: #FFF;font-family: Poppins !important;}
.filtros-collab {text-align: right;margin: 2%;}
 /* The Modal (background) */
.modal {
  display: none;
  position: fixed;
  z-index: 999999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,.5);
}

/* Modal Content/Box */
.modal-content {
  background-color: #181818 !important;
  margin: 15% auto;
  padding: 40px;
  border: none;
  width: 80%;
	max-width: 700px;
	text-align: center;
}

/* The Close Button */
.close, .closec {
  color: #FFF;
  float: right;
  font-size: 28px;
  font-weight: bold;
	text-align: right !important;
}

.close:hover,
.close:focus, .closec:hover, .closec:focus  {
  color: #FFF;
  text-decoration: none;
  cursor: pointer;
} 
	
	
</style>
<!-- ESTILOS COLLAB -->


<!--test css-->
<style>
.dropbtn {border: 0;color: #FFF;font-family: Poppins !important;cursor: pointer;-webkit-appearance: none;-moz-appearance: none;-ms-appearance: none;appearance: none;outline: 0;background: #242330 url('<?php echo $urlimagenestheme;?>ic-select.png') no-repeat;background-position-x: 0%;background-position-y: 0%;background-position: right;font-size: 16px;padding-right: 34px;}

.dropdown {
  position: relative;
  display: inline-block;	
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #2B2A3A;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: white;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #242330;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {/*background-color: #3e8e41;*/}
</style>
<!--test css-->






	<div id="primary" class="content-area region__col region__col--2">
		<main id="main" class="site-main">

			


<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>    
	<div id="content-modal" >
		<p id="txt-modal">Haz clic en Aceptar Collab para colaborar en este proyecto!</p>
		<div class="msjes-enuo"></div>
	  	<button id="btnaceptar" class="btndescargarproyecto enuo-button" data-idproyecto="">Aceptar Collab</button>
	</div>
  </div>
</div> 
			
<div id="modalcancelar" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="closec">&times;</span>    
	<div id="content-modalc" >
		<p id="txt-modalc">Haz clic en Cancelar Collab para cancelar esta colaboraci&oacute;n y liberar la descarga nuevamente!</p>
		<div class="msjes-enuoc"></div>
	  	<button id="btncancelar" class="btncancelarproyecto enuo-button" data-idproyecto="">Cancelar Collab</button>
	</div>
  </div>
</div> 
			
			
			<?php if ( have_posts() ) : ?>

			
			<div class="menu-collab">
		<div class="col-1"><div class="titulo-collab">Últimos Proyectos</div></div>
		<div class="col-2">
			<div class="align-right">
				<form class="select-genero" method="get">
					
					<?php
					
					$taxonomies = get_terms( array(
						'taxonomy' => 'genero',
						'hide_empty' => true
					) );
/*
					if ( !empty($taxonomies) ) :
						$output = '<select>';
						foreach( $taxonomies as $category ) {
							if( $category->parent == 0 ) {
								$output.= '<optgroup label="'. esc_attr( $category->name ) .'">';
								foreach( $taxonomies as $subcategory ) {
									if($subcategory->parent == $category->term_id) {
									$output.= '<option value="'. esc_attr( $subcategory->term_id ) .'">
										'. esc_html( $subcategory->name ) .'</option>';
									}
								}
								$output.='</optgroup>';
							}
						}
						$output.='</select>';
						echo $output;
					endif;*/
					
					?>
					
					
					
					<div class="dropdown">
					  <div class="dropbtn">Filtrar por género</div>
					  <div class="dropdown-content">
						  
							<?php						
						if ( !empty($taxonomies) ){							
							$output = "";
							foreach( $taxonomies as $subcategory ) {								
								$output.= '<a href="'.get_site_url().'/collab/?genero='.esc_attr( $subcategory->slug ) .'">
									'. esc_html( $subcategory->name ) .'</a>';
							}		
							echo $output;
						}	
							?>		
						  <a href="<?php echo get_site_url(); ?>/collab/">Todos</a>
						 </div>
					</div>
					
					
					
					<input type="hidden" name="paged" value="1">
				</form>
				<a class="enuo-button" href="<?php if(is_user_logged_in()) { echo get_site_url().'/miembros/'.esc_html($current_user->user_login).'/collab' ; }else{ echo get_site_url().'/registro/';  }  ?>" rel="nofollow"><img src="<?php echo $urlimagenestheme;?>upload.svg"/> Subir Proyecto</a>
			</div>
			</div>
	</div>
			
			<?php 
			if(isset($_GET['genero']) && is_tax( 'genero', $_GET['genero'] )){	
				?>

			<div class="filtros-collab"><srtong>G&eacute;nero:</srtong>  <small><?php echo $nombregenero; ?></small> <a href="<?php echo get_site_url(); ?>/collab/" class="borrar-filtro close">&times;</a>
			</div>
			
			<?php }	?>
			
			
				
		<div class="collabs">
			
			
				

				<?php
				//do_action( 'gwangi_before_posts' );
			
				$maximo = get_config_enuo('max_collab_activos');//Luego cambiar por funcion global
				$maximo = intval($maximo);
				$rangocollab = get_config_enuo('cant_dias_bloqueo_collab');//Luego cambiar por funcion global
				$rangocollab = intval($rangocollab);
			
				$collabs_activos = get_user_meta( $idusuario, 'collabs_activos', true ); 
				if(isset($collabs_activos) && !empty($collabs_activos) && is_numeric($collabs_activos)){
					$collabs_activos = intval($collabs_activos);	
				}			
			
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					//get_template_part( 'template-parts/content-collab', get_post_format() ); ?>		
			
			
					<div class="collab">
						<div class="c-nombre"><?php echo get_the_title();?></div>
						
						<?php $audio = get_post_meta($post->ID, 'collab_audio', true); 
						$proyectocompleto = get_post_meta($post->ID, 'collab_zip', true);?>
						
						<div class="c-audioprevio player"><audio crossorigin><source src="<?php echo $audio; ?>" type="audio/mpeg"></audio></div>
						<?php if(is_user_logged_in()) {?>
						<div class="c-accion"><a href="#"><img src="<?php echo $urlimagenestheme;?>wishlist.png"></a> <?php 
					   
							
													   
						$disponible = true;	
													   
						//Verifico si supero el maximo de collabs, Obtengo el colaborador del proyecto actual y comparo con el usuario logueado	
						$colaboradoractivo = get_post_meta( $post->ID, 'colaborador_activo', true ); 
						if($collabs_activos >= $maximo && $colaboradoractivo!=$idusuario){
							$disponible = false;	
						}
						
													   
						//verifico si este proyecto ya tiene un colaborador activo y si no supero el tiempo maximo
						$fechadescargacollab = get_post_meta( $post->ID, 'fecha_descarga', true ); 	
									
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
													   
						if(isset($colaboradoractivo) && !empty($colaboradoractivo) && $colaboradoractivo != "" && $colaboradoractivo != $idusuario && $vigente){
							$disponible = false;
						}
													   
						if($disponible) {
						  echo '<span type="button" class="btnabrirmodal" data-idproyecto="'.$post->ID.'"><img src="'.$urlimagenestheme.'download.png"></span>';
						} 
							
													   
						if( isset($colaboradoractivo) && !empty($colaboradoractivo) && $colaboradoractivo != "" && ($colaboradoractivo == $idusuario || $post->post_author == $idusuario)){
							//El usuario logueado es el autor o el colaborador
							echo '<span type="button" class="btncancelarmodal" data-idproyecto="'.$post->ID.'"><img src="'.$urlimagenestheme.'cancel.png"></span>';
						}
							?>
						</div>
						<?php } ?>
					</div>
			<?php

				endwhile; // End of the loop.

				//do_action( 'gwangi_after_posts' );
			
			
			
			
			
			?>
			</div>
			
			<div class="paginacion-collab">
		<div class="">
			<?php if($siguiente <= $total_pages ){ ?>
			
			<div class="align-center">
				<a class="enuo-button-o" href="<?php echo $urlsiguiente;?>" rel="nofollow"><span>Pagina Siguiente</span></a>
			</div>
			
			<?php } ?>
			<div class="align-right">
				Página <?php echo $paged.' de '.$total_pages; if($total_pages != 1){?> <?php if($anterior > 0 ){?><a class="" href="<?php if($anterior > 0 ){echo $urlanterior;}else{echo '#';}?>" rel="nofollow">&lt;</a> <?php } if($siguiente <= $total_pages ){?><a class="" href="<?php if($siguiente <= $total_pages ){echo $urlsiguiente;}else{echo '#';}?>" rel="nofollow">&gt;</a>
				<?php } }?>
			</div>
		</div>
	</div>
			
			<?php
			
			

				else :

					//get_template_part( 'template-parts/content-collab', 'none' );
			
			
			?>
			
			
	
			
			<?php
			

			endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
/*get_sidebar( 'right' );*/
get_footer();

 ?>
<script src="<?php echo get_stylesheet_directory_uri();?>/assets/js/green-audio-player.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            GreenAudioPlayer.init({
                selector: '.player',
                stopOthersOnPlay: true
            });

            GreenAudioPlayer.init({
                selector: '.player-with-download',
                stopOthersOnPlay: true,
                showDownloadButton: true,
                enableKeystrokes: true
            });

            GreenAudioPlayer.init({
                selector: '.player-with-accessibility',
                stopOthersOnPlay: true,
                enableKeystrokes: true
            });
        });
    </script>

<?php
