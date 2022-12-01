jQuery( function ( $ ) {

	var buttonsPreview;

	if ( $( '.dlm-buttons-wrap' ) ) {
		buttonsPreview = new DLM_Buttons_Preview( $( '.dlm-buttons-wrap:first' ) );
	}

	$.each( $( '.dlm-buttons-color-picker' ), function ( k, v ) {
		$( v ).wpColorPicker( {
			change: function ( event, ui ) {
				buttonsPreview.restartPreviewTimer();
			}
		} );
	} );
} );

var DLM_Buttons_Preview = function ( c ) {
	this.container = c;

	this.config_wrap = null;
	this.iframe = null;

	this.previewTimer = null;

	this.templateName = null;

	this.isSaving = false;

	this.setup = function () {
		var instance = this;

		this.config_wrap = jQuery( this.container ).find( '.dlm-buttons-config:first' );
		this.iframe = jQuery( this.container ).find( '#dlm-buttons-preview-frame:first' );

		this.templateName = jQuery( this.config_wrap ).data( 'template_name' );

		// setup save button
		jQuery( '#dlm-buttons-save' ).click( function () {
			instance.save();
		} );

		this.setupChangeListener();

		this.loadPreview();

	};

	this.setup();
};

DLM_Buttons_Preview.prototype.getConfigElements = function () {
	return jQuery( this.config_wrap ).find( '.dlm-buttons-config-field' );
};

DLM_Buttons_Preview.prototype.setupChangeListener = function () {
	var instance = this;
	jQuery.each( instance.getConfigElements(), function ( k, v ) {
		jQuery( v ).change( function () {
			instance.restartPreviewTimer();
		} );
	} );
};

DLM_Buttons_Preview.prototype.restartPreviewTimer = function () {
	var instance = this;
	clearTimeout( this.previewTimer );
	this.previewTimer = setTimeout( function () {
		instance.loadPreview();
	}, 750 );
};

DLM_Buttons_Preview.prototype.loadPreview = function () {

	var url = dlm_buttons_strings.button_preview_url_base;
	jQuery.each( this.getConfigElements(), function ( k, v ) {
		var tmpVal = jQuery( v ).val();

		if ( jQuery( v ).hasClass( 'dlm-buttons-color-picker' ) ) {
			tmpVal = tmpVal.replace( '#', '' );
		}

		if ( jQuery( v ).is( ':checkbox' ) ) {
			tmpVal = 0;
			if ( jQuery( v ).prop( 'checked' ) ) {
				tmpVal = 1;
			}
		}

		url += "&" + jQuery( v ).attr( 'name' ) + "=" + tmpVal;
	} );

	url = encodeURI( url );

	this.iframe.attr( 'src', url );
};

DLM_Buttons_Preview.prototype.startSaving = function () {
	this.isSaving = true;

	// remove any previous success messages to prevent clutter
	jQuery( '.dlm-buttons-successIcon' ).remove();

	jQuery( '#dlm-buttons-save' ).parent().append(
		jQuery( '<img>' ).attr( 'src', dlm_buttons_strings.img_loader ).addClass( 'dlm-buttons-loader' )
	);
};

DLM_Buttons_Preview.prototype.endSaving = function ( isSuccess ) {
	jQuery( '.dlm-buttons-loader' ).remove();

	var successMessage = jQuery( '<div>' ).addClass( 'dlm-buttons-successIcon' ).html( dlm_buttons_strings.lbl_button_saved );
	jQuery( '#dlm-buttons-save' ).parent().append( successMessage );
	successMessage.delay( 800 ).fadeOut( 'slow', function () {
		successMessage.remove();
	} );

	this.isSaving = false;
};

DLM_Buttons_Preview.prototype.save = function () {

	// already saving? Go away
	if ( this.isSaving ) {
		return;
	}

	var instance = this;

	// set isSaving
	this.startSaving();

	// grab options, set into object for AJAX post
	var options = {};
	jQuery.each( this.getConfigElements(), function ( k, v ) {
		var tmpVal = jQuery( v ).val();

		if ( jQuery( v ).hasClass( 'dlm-buttons-color-picker' ) ) {
			tmpVal = tmpVal.replace( '#', '' );
		}

		if ( jQuery( v ).is( ':checkbox' ) ) {
			tmpVal = 0;
			if ( jQuery( v ).prop( 'checked' ) ) {
				tmpVal = 1;
			}
		}

		options[jQuery( v ).attr( 'name' )] = tmpVal;
	} );

	var data = {
		action: 'dlm_buttons_save_template',
		template_name: this.templateName,
		security: dlm_buttons_strings.nonce_save_template,
		options: options
	};

	jQuery.post( ajaxurl, data, function ( response ) {

		if ( response.success === true ) {

		}

		instance.endSaving( response.success );
	} );

};