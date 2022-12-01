// JavaScript Document
jQuery(document).ready(function(){	
	
	// Get the modal
	var modal = document.getElementById("myModal");
	// Get the button that opens the modal
	var btn = document.getElementById("myBtn");
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];
	// When the user clicks on the button, open the modal
	jQuery('.btnabrirmodal').on('click', function () {
		modal.style.display = "block";
		jQuery("#txt-modal").show();
		jQuery("#btnaceptar").show();
		jQuery("#msjcollab").remove();
		var collabid = jQuery(this).data( 'idproyecto' );//obtengo el id del boton que hizo clic
		console.log('El id del proyecto es '+collabid);
		jQuery("#btnaceptar").data( "idproyecto", collabid );	
	});
	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
		modal.style.display = "none";
	  }
	} 
	
	//modal cancelar collab
	// Get the modal
	var modalc = document.getElementById("modalcancelar");
	
	// Get the <span> element that closes the modal
	var spanc = document.getElementsByClassName("closec")[0];
	// When the user clicks on the button, open the modal
	jQuery('.btncancelarmodal').on('click', function () {
		modalc.style.display = "block";
		jQuery("#txt-modalc").show();
		jQuery("#btncancelar").show();
		jQuery("#msjcollabc").remove();
		var collabid = jQuery(this).data( 'idproyecto' );//obtengo el id del boton que hizo clic
		console.log('Entro en cancelar modal El id del proyecto es '+collabid);
		jQuery("#btncancelar").data( "idproyecto", collabid );	
	});
	// When the user clicks on <span> (x), close the modal
	spanc.onclick = function() {
	  modalc.style.display = "none";
	}
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modalc) {
		modalc.style.display = "none";
	  }
	} 
	
	
	//Funcion que llama al ajax para descargar proyecto
	jQuery('.btndescargarproyecto').on('click', function () {
		console.log("Hizo clic en el boton");
		//Creo el nuevo form data que voy a enviar
    	var data = new FormData();
    	//Defino las variables del form        	
    	data.append( 'action', enuo_ajax_adm.actiondescarga);
        data.append( 'nonce', enuo_ajax_adm.ajax_nonce ); 
		data.append( 'idusr', enuo_ajax_adm.idusr );
		
		var collabid = jQuery(this).data( 'idproyecto' );//obtengo el id del boton que hizo clic		
        data.append( 'idcollab', collabid );        
        console.log("El id del collab es ");
		console.log(collabid);

        var spinner = jQuery('#loader-full');            	
    	spinner.show();
    	
        jQuery.ajax({
            type: 'POST',
            url: enuo_ajax_adm.ajax_url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function(result) {
            	spinner.hide();
            	var result = JSON.parse(result);                        	
            	if (result != undefined) {
                	if(result.type != undefined && result.response != undefined && result.type === "ok" ){ 
                		jQuery("#btnaceptar").hide();
						jQuery("#txt-modal").hide();						
                		jQuery(".msjes-enuo").after("<div id=\"msjcollab\" class=\"mensaje-modal\"><p>"+result.response+"</p><a href=\""+result.urlarchivo+"\" class=\"enuo-button\" download>Descargar Proyecto</a></div>");                    	
                    	jQuery('body, html').animate({scrollTop: pos }, 'slow');                      	
                	}else if (result.type != undefined && result.response != undefined && result.type === "error"){    
						jQuery("#btnaceptar").hide();
						jQuery("#txt-modal").hide();
                		jQuery(".msjes-enuo").after("<div id=\"msjcollab\" class=\"mensaje-modal error\"><p>"+result.response+"</p></div>");  
                		var pos = jQuery('#msjcollab').offset().top;
                    	jQuery('body, html').animate({scrollTop: pos }, 'slow');
                	}
                	
                	
            	}           	
            	
            }
        });
	});
	
	//Funcion que llama al ajax para cancelar proyecto
	jQuery('.btncancelarproyecto').on('click', function () {
		console.log("Hizo clic en el boton");
		//Creo el nuevo form data que voy a enviar
    	var data = new FormData();
    	//Defino las variables del form        	
    	data.append( 'action', enuo_ajax_adm.actioncancelar);
        data.append( 'nonce', enuo_ajax_adm.ajax_nonce ); 
		data.append( 'idusr', enuo_ajax_adm.idusr );
		
		var collabid = jQuery(this).data( 'idproyecto' );//obtengo el id del boton que hizo clic		
        data.append( 'idcollab', collabid );        
        console.log("El id del collab es ");
		console.log(collabid);

        var spinner = jQuery('#loader-full');            	
    	spinner.show();
    	
        jQuery.ajax({
            type: 'POST',
            url: enuo_ajax_adm.ajax_url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function(result) {
            	spinner.hide();
            	var result = JSON.parse(result);                        	
            	if (result != undefined) {
                	if(result.type != undefined && result.response != undefined && result.type === "ok" ){ 
                		jQuery("#btncancelar").hide();
						jQuery("#txt-modalc").hide();						
                		jQuery(".msjes-enuoc").after("<div id=\"msjcollabc\" class=\"mensaje-modal\"><p>"+result.response+"</p></div>");                    	
                    	jQuery('body, html').animate({scrollTop: pos }, 'slow');                      	
                	}else if (result.type != undefined && result.response != undefined && result.type === "error"){    
						jQuery("#btncancelar").hide();
						jQuery("#txt-modalc").hide();
                		jQuery(".msjes-enuoc").after("<div id=\"msjcollabc\" class=\"mensaje-modal error\"><p>"+result.response+"</p></div>");  
                		var pos = jQuery('#msjcollabc').offset().top;
                    	jQuery('body, html').animate({scrollTop: pos }, 'slow');
                	}
                	
                	
            	}           	
            	
            }
        });
	});
	
});