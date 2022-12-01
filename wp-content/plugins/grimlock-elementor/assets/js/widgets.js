jQuery( function( $ ) {

    // Initialize Grimlock widgets when they are loaded in Elementor
    if ( window.elementor && window.grimlock && window.grimlock.widgets ) {
        window.elementor.hooks.addAction( 'panel/open_editor/widget', function( panel, model, view ) {
            var widgetType = model.get( 'widgetType' );

            window.elementor.hooks.addAction( 'panel/widgets/' + widgetType + '/controls/wp_widget/loaded', function( widget ) {
                window.grimlock.widgets.init( widget.$el );
            } );
        } );
    }

} );
