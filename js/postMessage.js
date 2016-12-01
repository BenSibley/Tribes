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

    // logo
    wp.customize( 'custom_logo', function( value ) {
        value.bind( function( to ) {
            if ( to == '' ) {
                var title = panel.find('#customize-control-blogname').find('input').val();
                var link = '<a href="' + ct_tribes_postmessage.siteURL  + '">' + title + '</a>';
                siteTitle.append(link);
            } else {
                siteTitle.empty();
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

    var setting = 'custom_css';
    if ( panel.find('#sub-accordion-section-custom_css').length ) {
        setting = 'custom_css[tribes]';
    }
    // Custom CSS
    wp.customize( setting, function( value ) {
        value.bind( function( to ) {
            $('#style-inline-custom-css').remove();
            if ( to != '' ) {
                to = '<style id="style-inline-custom-css" type="text/css">' + to + '</style>';
                body.append( to );
            }
        } );
    } );

} )( jQuery );