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
		} else if ( $social_site == 'phone' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_tribes_sanitize_phone'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Phone', 'tribes' ),
				'section'     => 'ct_tribes_social_media_icons',
				'priority'    => $priority,
				'type'        => 'text'
			) );
		} else {

			$label = ucfirst( $social_site );

			if ( $social_site == 'google-plus' ) {
				$label = __('Google Plus', 'tribes');
			} elseif ( $social_site == 'rss' ) {
				$label = __('RSS', 'tribes');
			} elseif ( $social_site == 'soundcloud' ) {
				$label = __('SoundCloud', 'tribes');
			} elseif ( $social_site == 'slideshare' ) {
				$label = __('SlideShare', 'tribes');
			} elseif ( $social_site == 'codepen' ) {
				$label = __('CodePen', 'tribes');
			} elseif ( $social_site == 'stumbleupon' ) {
				$label = __('StumbleUpon', 'tribes');
			} elseif ( $social_site == 'deviantart' ) {
				$label = __('DeviantArt', 'tribes');
			} elseif ( $social_site == 'hacker-news' ) {
				$label = __('Hacker News', 'tribes');
			} elseif ( $social_site == 'whatsapp' ) {
				$label = __('WhatsApp', 'tribes');
			} elseif ( $social_site == 'qq' ) {
				$label = __('QQ', 'tribes');
			} elseif ( $social_site == 'vk' ) {
				$label = __('VK', 'tribes');
			} elseif ( $social_site == 'ok-ru' ) {
				$label = __('OK.ru', 'tribes');
			} elseif ( $social_site == 'google-wallet' ) {
				$label = __('Google Wallet', 'tribes');
			} elseif ( $social_site == 'wechat' ) {
				$label = __('WeChat', 'tribes');
			} elseif ( $social_site == 'tencent-weibo' ) {
				$label = __('Tencent Weibo', 'tribes');
			} elseif ( $social_site == 'paypal' ) {
				$label = __('PayPal', 'tribes');
			} elseif ( $social_site == 'stack-overflow' ) {
				$label = __('Stack Overflow', 'tribes');
			} elseif ( $social_site == 'email-form' ) {
				$label = __('Contact Form', 'tribes');
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
		'title'    => _x( 'Blog', 'noun: Blog section', 'tribes' ),
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
		'description' => sprintf( __( 'Want more options like these? Check out the <a target="_blank" href="%1$s"> %2$s Pro plugin</a>.', 'tribes' ), 'https://www.competethemes.com/tribes-pro/', wp_get_theme( get_template() ) )
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

	/***** Scroll-to-stop Arrow  *****/

	// section
	$wp_customize->add_section( 'ct_tribes_scroll_to_stop', array(
		'title'    => __( 'Scroll-to-Top Arrow', 'tribes' ),
		'priority' => 70
	) );
	// setting - scroll-to-top arrow
	$wp_customize->add_setting( 'scroll_to_top', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_tribes_sanitize_yes_no_settings'
	) );
	// control - scroll-to-top arrow
	$wp_customize->add_control( 'scroll_to_top', array(
		'label'    => __( 'Display Scroll-to-top arrow?', 'tribes' ),
		'section'  => 'ct_tribes_scroll_to_stop',
		'settings' => 'scroll_to_top',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'tribes' ),
			'no'  => __( 'No', 'tribes' )
		)
	) );

	/***** Custom CSS *****/

	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		// Migrate any existing theme CSS to the core option added in WordPress 4.7.
		$css = get_theme_mod( 'custom_css' );
		if ( $css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return = wp_update_custom_css_post( $core_css . $css );
			if ( ! is_wp_error( $return ) ) {
				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'custom_css' );
			}
		}
	} else {
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

function ct_tribes_sanitize_phone( $input ) {
	if ( $input != '' ) {
		return esc_url_raw( 'tel:' . $input, array( 'tel' ) );
	} else {
		return '';
	}
}

function ct_tribes_customize_preview_js() {
	if ( !function_exists( 'ct_tribes_pro_init' ) ) {
		$url = 'https://www.competethemes.com/tribes-pro/?utm_source=wp-dashboard&utm_medium=Customizer&utm_campaign=Tribes%20Pro%20-%20Customizer';
		$content = "<script>jQuery('#customize-info').prepend('<div class=\"upgrades-ad\"><a href=\"". $url ."\" target=\"_blank\">Customize Colors with Tribes Pro <span>&rarr;</span></a></div>')</script>";
		echo apply_filters('ct_tribes_customizer_ad', $content);
	}
}
add_action('customize_controls_print_footer_scripts', 'ct_tribes_customize_preview_js');