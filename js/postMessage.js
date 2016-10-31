( function( $ ) {

    var panel = $('html', window.parent.document);
    var body = $('body');
    var siteTitle = $('#site-title');
    var tagline = $( '.tagline' );
    var scrollContainer = $('#scroll-container');
    var inlineStyles = $('#ct-tribes-style-inline-css');

    // Site title
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            // if there is a logo, don't replace it
            if( siteTitle.find('img').length == 0 ) {
                siteTitle.children('a').text( to );
            }
        } );
    } );

    // Tagline
    wp.customize( 'blogdescription', function( value ) {
        value.bind( function( to ) {
            var tagline = $('.tagline');
            if( tagline.length == 0 ) {
                scrollContainer.prepend('<p class="tagline"></p>');
            }
            tagline.text( to );
        } );
    } );

    // Custom CSS

    // get current Custom CSS
    var customCSS = panel.find('#customize-control-custom_css').find('textarea').val();

    // get the CSS in the inline element
    var currentCSS = inlineStyles.text();

    // remove the Custom CSS from the other CSS
    currentCSS = currentCSS.replace(customCSS, '');

    // update the CSS in the inline element w/o the custom css
    inlineStyles.text(currentCSS);

    // add custom CSS to its own style element
    body.append('<style id="style-inline-custom-css" type="text/css">' + customCSS + '</style>');

    // Custom CSS
    wp.customize( 'custom_css', function( value ) {
        value.bind( function( to ) {
            $('#style-inline-custom-css').remove();
            if ( to != '' ) {
                to = '<style id="style-inline-custom-css" type="text/css">' + to + '</style>';
                body.append( to );
            }
        } );
    } );

} )( jQuery );