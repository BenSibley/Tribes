<?php

/* Add customizer panels, sections, settings, and controls */
add_action( 'customize_register', 'ct_tribes_add_customizer_content' );

function ct_tribes_add_customizer_content( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section( 'title_tagline' )->priority = 2;

	// check if exists in case user has no pages
	if ( is_object( $wp_customize->get_section( 'static_front_page' ) ) ) {
		$wp_customize->get_section( 'static_front_page' )->priority = 5;
		$wp_customize->get_section( 'static_front_page' )->title    = __( 'Front Page', 'tribes' );
	}

	/***** Add PostMessage Support *****/

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_setting( 'custom_logo' )->transport     = 'postMessage';

	/***** Tribes Pro Control *****/

	class ct_tribes_pro_ad extends WP_Customize_Control {
		public function render_content() {
			$link = 'https://www.competethemes.com/tribes-pro/';
			echo "<a href='" . $link . "' target='_blank'><img src='" . get_template_directory_uri() . "/assets/images/tribes-pro.png' srcset='" . get_template_directory_uri() . "/assets/images/tribes-pro-2x.png 2x' /></a>";
			echo "<p class='bold'>" . sprintf( __('<a target="_blank" href="%s">Tribes Pro</a> is the plugin that makes advanced customization simple - and fun too!', 'tribes'), $link) . "</p>";
			echo "<p>" . __('Tribes Pro adds the following features to Tribes:', 'tribes') . "</p>";
			echo "<ul>
					<li>" . __('7 new layouts', 'tribes') . "</li>
					<li>" . __('Custom colors', 'tribes') . "</li>
					<li>" . __('New fonts', 'tribes') . "</li>
					<li>" . __('+ 9 more features', 'tribes') . "</li>
				  </ul>";
			echo "<p class='button-wrapper'><a target=\"_blank\" class='tribes-pro-button' href='" . $link . "'>" . __('View Tribes Pro', 'tribes') . "</a></p>";
		}
	}

	/***** Tribes Pro Section *****/

	// don't add if Tribes Pro is active
	if ( !function_exists( 'ct_tribes_pro_init' ) ) {
		// section
		$wp_customize->add_section( 'ct_tribes_pro', array(
			'title'    => __( 'Tribes Pro', 'tribes' ),
			'priority' => 1
		) );
		// Upload - setting
		$wp_customize->add_setting( 'tribes_pro', array(
			'sanitize_callback' => 'absint'
		) );
		// Upload - control
		$wp_customize->add_control( new ct_tribes_pro_ad(
			$wp_customize, 'tribes_pro', array(
				'section'  => 'ct_tribes_pro',
				'settings' => 'tribes_pro'
			)
		) );
	}

	/***** Social Media Icons *****/

	// get the social sites array
	$social_sites = ct_tribes_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'ct_tribes_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'tribes' ),
		'priority'    => 25,
		'description' => __( 'Add the URL for each of your social profiles.', 'tribes' )
	) );

	// create a setting and control for each social site
	foreach ( $social_sites as $social_site => $value ) {
		// if email icon
		if ( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_tribes_sanitize_email'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Email Address', 'tribes' ),
				'section'  => 'ct_tribes_social_media_icons',
				'priority' => $priority
			) );
		} else {

			$label = ucfirst( $social_site );

			if ( $social_site == 'google-plus' ) {
				$label = 'Google Plus';
			} elseif ( $social_site == 'rss' ) {
				$label = 'RSS';
			} elseif ( $social_site == 'soundcloud' ) {
				$label = 'SoundCloud';
			} elseif ( $social_site == 'slideshare' ) {
				$label = 'SlideShare';
			} elseif ( $social_site == 'codepen' ) {
				$label = 'CodePen';
			} elseif ( $social_site == 'stumbleupon' ) {
				$label = 'StumbleUpon';
			} elseif ( $social_site == 'deviantart' ) {
				$label = 'DeviantArt';
			} elseif ( $social_site == 'hacker-news' ) {
				$label = 'Hacker News';
			} elseif ( $social_site == 'whatsapp' ) {
				$label = 'WhatsApp';
			} elseif ( $social_site == 'qq' ) {
				$label = 'QQ';
			} elseif ( $social_site == 'vk' ) {
				$label = 'VK';
			} elseif ( $social_site == 'wechat' ) {
				$label = 'WeChat';
			} elseif ( $social_site == 'tencent-weibo' ) {
				$label = 'Tencent Weibo';
			} elseif ( $social_site == 'paypal' ) {
				$label = 'PayPal';
			} elseif ( $social_site == 'email-form' ) {
				$label = 'Contact Form';
			}

			if ( $social_site == 'skype' ) {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'ct_tribes_sanitize_skype'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'        => 'url',
					'label'       => $label,
					'description' => sprintf( __( 'Accepts Skype link protocol (<a href="%s" target="_blank">learn more</a>)', 'tribes' ), 'https://www.competethemes.com/blog/skype-links-wordpress/' ),
					'section'     => 'ct_tribes_social_media_icons',
					'priority'    => $priority
				) );
			} else {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'esc_url_raw'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'     => 'url',
					'label'    => $label,
					'section'  => 'ct_tribes_social_media_icons',
					'priority' => $priority
				) );
			}
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}

	/***** Blog *****/

	// section
	$wp_customize->add_section( 'tribes_blog', array(
		'title'    => __( 'Blog', 'tribes' ),
		'priority' => 45
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_tribes_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'    => __( 'Show full posts on blog?', 'tribes' ),
		'section'  => 'tribes_blog',
		'settings' => 'full_post',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'tribes' ),
			'no'  => __( 'No', 'tribes' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => '25',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'excerpt_length', array(
		'label'    => __( 'Excerpt word count', 'tribes' ),
		'section'  => 'tribes_blog',
		'settings' => 'excerpt_length',
		'type'     => 'number'
	) );
	// Read More text - setting
	$wp_customize->add_setting( 'read_more_text', array(
		'default'           => __( 'Continue Reading', 'tribes' ),
		'sanitize_callback' => 'ct_tribes_sanitize_text'
	) );
	// Read More text - control
	$wp_customize->add_control( 'read_more_text', array(
		'label'    => __( 'Read More button text', 'tribes' ),
		'section'  => 'tribes_blog',
		'settings' => 'read_more_text',
		'type'     => 'text'
	) );

	/***** Display Controls *****/

	// section
	$wp_customize->add_section( 'tribes_display', array(
		'title'       => __( 'Display Controls', 'tribes' ),
		'priority'    => 55,
		'description' => sprintf( __( 'Want more options like these? Check out the <a target="_blank" href="%s"> Tribes Pro plugin</a>.', 'tribes' ), 'https://www.competethemes.com/tribes-pro/' )
	) );
	// setting - post author
	$wp_customize->add_setting( 'display_post_author', array(
		'default'           => 'show',
		'sanitize_callback' => 'ct_tribes_sanitize_show_hide'
	) );
	// control - post author
	$wp_customize->add_control( 'display_post_author', array(
		'type'    => 'radio',
		'label'   => __( 'Post author name in byline', 'tribes' ),
		'section' => 'tribes_display',
		'setting' => 'display_post_author',
		'choices' => array(
			'show' => __( 'Show', 'tribes' ),
			'hide' => __( 'Hide', 'tribes' )
		)
	) );
	// setting - post date
	$wp_customize->add_setting( 'display_post_date', array(
		'default'           => 'show',
		'sanitize_callback' => 'ct_tribes_sanitize_show_hide'
	) );
	// control - post author
	$wp_customize->add_control( 'display_post_date', array(
		'type'    => 'radio',
		'label'   => __( 'Post date in byline', 'tribes' ),
		'section' => 'tribes_display',
		'setting' => 'display_post_date',
		'choices' => array(
			'show' => __( 'Show', 'tribes' ),
			'hide' => __( 'Hide', 'tribes' )
		)
	) );

	/***** Custom CSS *****/

	// section
	$wp_customize->add_section( 'tribes_custom_css', array(
		'title'    => __( 'Custom CSS', 'tribes' ),
		'priority' => 75
	) );
	// setting
	$wp_customize->add_setting( 'custom_css', array(
		'sanitize_callback' => 'ct_tribes_sanitize_css',
		'transport'         => 'postMessage'
	) );
	// control
	$wp_customize->add_control( 'custom_css', array(
		'type'     => 'textarea',
		'label'    => __( 'Add Custom CSS Here:', 'tribes' ),
		'section'  => 'tribes_custom_css',
		'settings' => 'custom_css'
	) );
}

/***** Custom Sanitization Functions *****/

/*
 * Sanitize settings with show/hide as options
 * Used in: search bar
 */
function ct_tribes_sanitize_all_show_hide_settings( $input ) {

	$valid = array(
		'show' => __( 'Show', 'tribes' ),
		'hide' => __( 'Hide', 'tribes' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

/*
 * sanitize email address
 * Used in: Social Media Icons
 */
function ct_tribes_sanitize_email( $input ) {
	return sanitize_email( $input );
}

// sanitize yes/no settings
function ct_tribes_sanitize_yes_no_settings( $input ) {

	$valid = array(
		'yes' => __( 'Yes', 'tribes' ),
		'no'  => __( 'No', 'tribes' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_tribes_sanitize_show_hide( $input ) {

	$valid = array(
		'show' => __( 'Show', 'tribes' ),
		'hide' => __( 'Hide', 'tribes' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_tribes_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function ct_tribes_sanitize_skype( $input ) {
	return esc_url_raw( $input, array( 'http', 'https', 'skype' ) );
}

function ct_tribes_sanitize_css( $css ) {
	$css = wp_filter_nohtml_kses( $css, array( '\'', '\"' ) );
	$css = str_replace( '&gt;', '>', $css );

	return $css;
}