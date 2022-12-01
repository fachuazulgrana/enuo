jQuery( function ( $ ) {

	var buttonsFormNew;

	if ( $( '#dlm_buttons_new' ) ) {
		buttonsFormNew = new DLM_Buttons_Form_New( $( '#dlm_buttons_new' ) );
	}
} );

var DLM_Buttons_Form_New = function ( c ) {
	this.container = c;

	this.templateNameInput = null
	this.saveButton = null;

	this.isBusy = false;

	this.setup = function () {
		var instance = this;

		this.templateNameInput = jQuery( this.container ).find( '.dlm_buttons_new_template_name:first' );
		this.saveButton = jQuery( this.container ).find( '.dlm_buttons_new_form_button:first' );

		// setup save button
		jQuery( this.container ).submit( function () {
			instance.save();
			return false;
		} );

	};

	this.setup();
};

DLM_Buttons_Form_New.prototype.save = function () {

	// can't save when busy
	if ( this.isBusy ) {
		return;
	}

	// check if there's a template name set
	if ( this.templateNameInput.val() === "" ) {
		alert( dlm_buttons_overview_strings.error_empty_template_name );
		return;
	}

	var instance = this;

	this.isBusy = true;

	var data = {
		action: 'dlm_buttons_add_template',
		template_name: instance.templateNameInput.val(),
		security: dlm_buttons_overview_strings.nonce_add_template
	};

	console.log( data );

	jQuery.post( ajaxurl, data, function ( response ) {

		instance.isBusy = false;

		if ( response.success === true ) {
			// redirect to edit screen
			window.location = dlm_buttons_overview_strings.button_edit_url_base + "&dlm_buttons_button=" + response.template_name;
		} else {
			// show error
			if ( response.errorMessage ) {
				alert( response.errorMessage );
			}
		}

	} );
};