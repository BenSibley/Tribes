<?php

// Front-end scripts
function ct_tribes_load_scripts_styles() {

	$font_args = array(
		'family' => urlencode( 'Open Sans:400,400italic,700|Damion:400' ),
		'subset' => urlencode( 'latin,latin-ext' )
	);
	$fonts_url = add_query_arg( $font_args, '//fonts.googleapis.com/css' );
	wp_enqueue_style( 'ct-tribes-google-fonts', $fonts_url );

	wp_enqueue_script( 'ct-tribes-js', get_template_directory_uri() . '/js/build/production.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'ct-tribes-js', 'ct_tribes_objectL10n', array(
		'openMenu'       => esc_html_x( 'open menu', 'verb: open the menu', 'tribes' ),
		'closeMenu'      => esc_html_x( 'close menu',' verb: close the menu', 'tribes' ),
		'openChildMenu'  => esc_html_x( 'open dropdown menu', 'open the dropdown menu', 'tribes' ),
		'closeChildMenu' => esc_html_x( 'close dropdown menu', 'close the dropdown menu', 'tribes' )
	) );

	wp_enqueue_style( 'ct-tribes-font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/all.min.css' );

	wp_enqueue_style( 'ct-tribes-style', get_stylesheet_uri() );

	// enqueue comment-reply script only on posts & pages with comments open ( included in WP core )
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_tribes_load_scripts_styles' );

// Back-end scripts
function ct_tribes_enqueue_admin_styles( $hook ) {

	if ( $hook == 'appearance_page_tribes-options' ) {
		wp_enqueue_style( 'ct-tribes-admin-styles', get_template_directory_uri() . '/styles/admin.min.css' );
	}
	if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
		$font_args = array(
			'family' => urlencode( 'Open Sans:400,400italic,700|Damion:400' ),
			'subset' => urlencode( 'latin,latin-ext' )
		);
		$fonts_url = add_query_arg( $font_args, '//fonts.googleapis.com/css' );
		wp_enqueue_style( 'ct-tribes-google-fonts', $fonts_url );
	}
}
add_action( 'admin_enqueue_scripts', 'ct_tribes_enqueue_admin_styles' );

// Customizer scripts
function ct_tribes_enqueue_customizer_scripts() {
	wp_enqueue_script( 'ct-tribes-customizer-js', get_template_directory_uri() . '/js/build/customizer.min.js', array( 'jquery' ), '', true );
	wp_enqueue_style( 'ct-tribes-customizer-styles', get_template_directory_uri() . '/styles/customizer.min.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'ct_tribes_enqueue_customizer_scripts' );

/*
 * Script for live updating with customizer options. Has to be loaded separately on customize_preview_init hook
 * transport => postMessage
 */
function ct_tribes_enqueue_customizer_post_message_scripts() {
	wp_enqueue_script( 'ct-tribes-customizer-post-message-js', get_template_directory_uri() . '/js/build/postMessage.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'ct-tribes-customizer-post-message-js', 'ct_tribes_postmessage', array(
		'siteURL'       => esc_url( get_home_url() )
	) );

}
add_action( 'customize_preview_init', 'ct_tribes_enqueue_customizer_post_message_scripts' );