jQuery( function ( $ ) {

    $.each( $( '.dlm-aam-rules' ), function ( k, v ) {
        new DLM_AAM_Rules_Table( $( v ) );
    } );

} );

/*
 DLM_AAM_Rules_Table
 */

var DLM_AAM_Rules_Table = function ( tgt ) {
    this.tgt = tgt;
    this.table = this.tgt.find( 'table:first' );
    this.download_id = this.table.data( 'id' );
    this.loadRules();
    this.bindNewRulClick();
    this.makeSortable();
};

DLM_AAM_Rules_Table.prototype.loadRules = function () {
    var instance = this;

    // @todo block table

    jQuery.post( ajaxurl, {
        action: 'dlm_aam_get_rules',
        nonce: this.table.data( 'nonce' ),
        download_id: this.download_id
    }, function ( response ) {
        jQuery.each( response, function ( k, v ) {
            instance.addRow( v );
        } );
    } );
};

DLM_AAM_Rules_Table.prototype.bindNewRulClick = function () {
    var instance = this;
    this.tgt.find( '.add_rule' ).click( function () {
        instance.addRow( {
            'download_id': instance.download_id,
            'can_download': false,
            'group': '',
            'group_value': '',
            'restriction': '',
            'restriction_value': ''
        } );
        return false;
    } );
};

DLM_AAM_Rules_Table.prototype.sortHelper = function ( e, ui ) {
    ui.children().each( function () {
        jQuery( this ).width( jQuery( this ).width() );
    } );
    return ui;
};

DLM_AAM_Rules_Table.prototype.makeSortable = function () {
    this.table.find( 'tbody' ).sortable( {
        helper: this.sortHelper,
        update: function ( event, ui ) {
        }
    } );

};

DLM_AAM_Rules_Table.prototype.addRow = function ( data ) {

    // setup DLM_AAM_Rules_Table_Row
    var row = new DLM_AAM_Rules_Table_Row( data, this.table.find( 'tbody tr' ).length );

    // attach DLM_AAM_Rules_Table_Row DOM to table
    this.table.append( row.getDOM() );
};

/*
 DLM_AAM_Rules_Table_Row
 */

var DLM_AAM_Rules_Table_Row = function ( data, id ) {
    this.data = data;
    this.dom = null;

    this.id = id;

    if ( this.data.group == '' ) {
        this.data.group = 'null';
    }

    if ( this.data.restriction == '' ) {
        this.data.restriction = 'null';
    }

    this.createDOM();
    this.setupData();
};

DLM_AAM_Rules_Table_Row.prototype.getDOM = function () {
    return this.dom;
};

DLM_AAM_Rules_Table_Row.prototype.createDOM = function () {
    this.dom = jQuery( '<tr>' );

    this.dom.append( jQuery( '<td>' ).attr( 'valign', 'top' ).addClass( 'dlm-aam-group' ).append( this.getGroupSelect() ) );
    this.dom.append( jQuery( '<td>' ).attr( 'valign', 'top' ).addClass( 'dlm-aam-group-sub' ).html( '-' ) );
    this.dom.append( jQuery( '<td>' ).attr( 'valign', 'top' ).addClass( 'dlm-aam-can-download' ).append( this.getCanDownloadSelect() ) );
    this.dom.append( jQuery( '<td>' ).attr( 'valign', 'top' ).addClass( 'dlm-aam-restriction' ).append( this.getRestrictionSelect() ) );
    this.dom.append( jQuery( '<td>' ).attr( 'valign', 'top' ).addClass( 'dlm-aam-restriction-sub' ).html( '-' ) );
    this.dom.append( jQuery( '<td>' ).attr( 'valign', 'top' ).addClass( 'dlm-aam-actions' ).append( this.getRemoveButton() ) );
};

DLM_AAM_Rules_Table_Row.prototype.setupData = function () {
    // check if group is set
    if ( this.data.group != '' ) {

        // set correct group
        this.dom.find( '.dlm-aam-group select option[value=' + this.data.group + ']' ).prop( 'selected', true )

        // set sub group
        this.setSubGroup();

        this.updateRestrictionSelect();
        this.setSubRestriction();
    }

};

DLM_AAM_Rules_Table_Row.prototype.getGroupSelect = function () {

    // select el
    var select = jQuery( '<select>' ).attr( 'name', 'dlm-aam-rules[' + this.id + '][group]' );

    // add options
    select.append( jQuery( '<option>' ).val( 'null' ).html( dlm_aam_rules.str_anyone ) );
    select.append( jQuery( '<option>' ).val( 'role' ).html( dlm_aam_rules.str_role ) );
    select.append( jQuery( '<option>' ).val( 'user' ).html( dlm_aam_rules.str_user ) );
    select.append( jQuery( '<option>' ).val( 'ip' ).html( dlm_aam_rules.str_ip ) );

    // set change callback
    var table_row = this;
    select.change( function () {
        table_row.onGroupChange();
    } );

    // -
    return select;
};

DLM_AAM_Rules_Table_Row.prototype.onGroupChange = function () {
    this.data.group = this.dom.find( '.dlm-aam-group select option:selected' ).val();
    this.data.group_value = '';
    this.setSubGroup();
};

DLM_AAM_Rules_Table_Row.prototype.getRolesSelect = function ( value ) {
    var select = jQuery( '<select>' ).attr( 'name', 'dlm-aam-rules[' + this.id + '][group_value]' );

    jQuery.each( JSON.parse( dlm_aam_rules.roles ), function ( k, v ) {
        var option = jQuery( '<option>' ).val( v.key ).html( v.name );
        if ( v.key == value ) {
            option.prop( 'selected', true );
        }
        select.append( option );
    } );

    return select;
};

DLM_AAM_Rules_Table_Row.prototype.setSubGroup = function () {
    // set correct sub group
    switch ( this.data.group ) {
        case 'role':
            this.dom.find( '.dlm-aam-group-sub' ).empty().append( this.getRolesSelect( this.data.group_value ) );
            break;
        case 'user':
        case 'ip':
            this.dom.find( '.dlm-aam-group-sub' ).empty().append( jQuery( '<input>' ).attr( 'name', 'dlm-aam-rules[' + this.id + '][group_value]' ).attr( 'type', 'text' ).val( this.data.group_value ) );
            break;
        default:
            this.dom.find( '.dlm-aam-group-sub' ).empty().html( '-' );
            break;
    }
};

DLM_AAM_Rules_Table_Row.prototype.getCanDownloadSelect = function () {
    var select = jQuery( '<select>' ).attr( 'name', 'dlm-aam-rules[' + this.id + '][can_download]' );
    select.append( jQuery( '<option>' ).val( '0' ).html( dlm_aam_rules.str_no ) );
    select.append( jQuery( '<option>' ).val( '1' ).html( dlm_aam_rules.str_yes ) );

    if ( this.data.can_download == 1 ) {
        select.find( 'option[value=1]' ).prop( 'selected', true );
    }

    // set change callback
    var table_row = this;
    select.change( function () {
        table_row.onCanDownloadChange();
    } );

    return select;
};

DLM_AAM_Rules_Table_Row.prototype.onCanDownloadChange = function () {
    this.data.can_download = this.dom.find( '.dlm-aam-can-download select option:selected' ).val();
    this.data.restriction = 'null';
    this.data.restriction_value = '';
    this.updateRestrictionSelect();
    this.setSubRestriction();
};

DLM_AAM_Rules_Table_Row.prototype.updateRestrictionSelect = function () {

    this.dom.find( '.dlm-aam-restriction select option[value=' + this.data.restriction + ']' ).prop( 'selected', true )

    if ( this.data.can_download == 1 ) {
        this.data.can_download = this.dom.find( '.dlm-aam-restriction select' ).prop( 'disabled', false );
    } else {
        this.data.can_download = this.dom.find( '.dlm-aam-restriction select' ).prop( 'disabled', true );
    }
};

DLM_AAM_Rules_Table_Row.prototype.getRestrictionSelect = function () {
    var select = jQuery( '<select>' ).attr( 'name', 'dlm-aam-rules[' + this.id + '][restriction]' );

    // options
    select.append( jQuery( '<option>' ).val( 'null' ).html( dlm_aam_rules.str_none ) );
    select.append( jQuery( '<option>' ).val( 'amount' ).html( dlm_aam_rules.str_download_limit ) );
	
	if ( this.data.download_id == 0 ) {
		select.append( jQuery( '<option>' ).val( 'global_amount' ).html( dlm_aam_rules.str_global_download_limit ) );
	}

    select.append( jQuery( '<option>' ).val( 'daily_amount' ).html( dlm_aam_rules.str_daily_amount ) );

    if ( this.data.download_id == 0 ) {
        select.append( jQuery( '<option>' ).val( 'daily_global_amount' ).html( dlm_aam_rules.str_daily_global_amount ) );
    }

    select.append( jQuery( '<option>' ).val( 'date' ).html( dlm_aam_rules.str_date_limit ) );

    // disable restriction if can_download is false
    if ( this.data.can_download == 0 ) {
        select.prop( 'disabled', true );
    }

    // set change callback
    var table_row = this;
    select.change( function () {
        table_row.onRestrictionChange();
    } );

    return select;
};

DLM_AAM_Rules_Table_Row.prototype.onRestrictionChange = function () {
    this.data.restriction = this.dom.find( '.dlm-aam-restriction select option:selected' ).val();
    this.data.restriction_value = '';
    this.setSubRestriction();
};

DLM_AAM_Rules_Table_Row.prototype.getDatePickerFields = function () {
    var dp_wrapper = jQuery( '<div>' ).addClass( 'dlm-aam-date-picker-fields' );
    var start_date = '';
    var end_date = '';
    if ( this.data.restriction_value.indexOf( '|' ) > 0 ) {
        var dates = this.data.restriction_value.split( '|' );
        if ( dates.length == 2 ) {
            start_date = dates[ 0 ];
            end_date = dates[ 1 ];
        }
    }

    dp_wrapper.append( jQuery( '<label>' ).attr( 'for', 'datestart' + this.id ).html( dlm_aam_rules.str_start_date ).append( jQuery( '<input>' ).attr( 'type', 'text' ).attr( 'id', 'datestart' + this.id ).attr( 'name', 'dlm-aam-rules[' + this.id + '][restriction_value][]' ).attr( 'placeholder', 'yy-mm-dd' ).datepicker( { dateFormat: 'yy-mm-dd' } ).val( start_date ) ) );
    dp_wrapper.append( jQuery( '<label>' ).attr( 'for', 'dateend' + this.id ).html( dlm_aam_rules.str_end_date ).append( jQuery( '<input>' ).attr( 'type', 'text' ).attr( 'id', 'dateend' + this.id ).attr( 'name', 'dlm-aam-rules[' + this.id + '][restriction_value][]' ).attr( 'placeholder', 'yy-mm-dd' ).datepicker( { dateFormat: 'yy-mm-dd' } ).val( end_date ) ) );

    return dp_wrapper;
};

DLM_AAM_Rules_Table_Row.prototype.setSubRestriction = function () {
    // set correct sub group
    switch ( this.data.restriction ) {
        case 'amount':
        case 'global_amount':
        case 'daily_amount':
        case 'daily_global_amount':
            this.dom.find( '.dlm-aam-restriction-sub' ).empty().append( jQuery( '<input>' ).attr( 'name', 'dlm-aam-rules[' + this.id + '][restriction_value]' ).attr( 'type', 'text' ).val( this.data.restriction_value ) );
            break;
        case 'date':
            this.dom.find( '.dlm-aam-restriction-sub' ).empty().append( this.getDatePickerFields() );
            break;
        default:
            this.dom.find( '.dlm-aam-restriction-sub' ).empty().html( '-' );
            break;
    }
};

DLM_AAM_Rules_Table_Row.prototype.removeRow = function () {
    this.dom.remove();
};

DLM_AAM_Rules_Table_Row.prototype.getRemoveButton = function () {
    var btn = jQuery( '<button>' ).addClass( 'button' ).html( dlm_aam_rules.str_remove )

    // set change callback
    var table_row = this;
    btn.click( function () {
        table_row.removeRow();
    } );

    return btn;
};