<?php

// Front-end scripts
function ct_tribes_load_scripts_styles() {

	wp_enqueue_style( 'ct-tribes-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,400italic,700|Damion:400' );

	wp_enqueue_script( 'ct-tribes-js', get_template_directory_uri() . '/js/build/production.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'ct-tribes-js', 'ct_tribes_objectL10n', array(
		'openMenu'       => esc_html__( 'open menu', 'tribes' ),
		'closeMenu'      => esc_html__( 'close menu', 'tribes' ),
		'openChildMenu'  => esc_html__( 'open dropdown menu', 'tribes' ),
		'closeChildMenu' => esc_html__( 'close dropdown menu', 'tribes' )
	) );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css' );

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

}
add_action( 'customize_preview_init', 'ct_tribes_enqueue_customizer_post_message_scripts' );