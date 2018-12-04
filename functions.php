<?php
//----------------------------------------------------------------------------------
//	Include all required files
//----------------------------------------------------------------------------------
require_once( trailingslashit( get_template_directory() ) . 'theme-options.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/customizer.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/review.php' );
require_once( trailingslashit( get_template_directory() ) . 'inc/scripts.php' );

//----------------------------------------------------------------------------------
//	Include review request
//----------------------------------------------------------------------------------
require_once( trailingslashit( get_template_directory() ) . 'dnh/handler.php' );
new WP_Review_Me( array(
	'days_after' => 14,
	'type' => 'theme',
	'slug' => 'tribes',
	'message' => __('Hey! Sorry to interrupt, but you\'ve been using Tribes for a little while now. If you\'re happy with this theme, could you take a minute to leave a review? <i>You won\'t see this notice again after closing it.</i>', 'tribes' )
	)
);

if ( ! function_exists( ( 'ct_tribes_set_content_width' ) ) ) {
	function ct_tribes_set_content_width() {
		if ( ! isset( $content_width ) ) {
			$content_width = 891;
		}
	}
}
add_action( 'after_setup_theme', 'ct_tribes_set_content_width', 0 );

if ( ! function_exists( ( 'ct_tribes_theme_setup' ) ) ) {
	function ct_tribes_theme_setup() {

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );
		add_theme_support( 'infinite-scroll', array(
			'container' => 'loop-container',
			'footer'    => 'overflow-container',
			'render'    => 'ct_tribes_infinite_scroll_render'
		) );
		add_theme_support( 'custom-logo', array(
			'height'      => 50,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true
		) );

		register_nav_menus( array(
			'primary' => __( 'Primary', 'tribes' )
		) );

		// Add WooCommerce support
		add_theme_support( 'woocommerce' );

		// Add support for WooCommerce image gallery features
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Gutenberg - wide & full images
		add_theme_support( 'align-wide' );
		add_theme_support( 'align-full' );

		// Gutenberg - load editor stylesheet
		add_theme_support('editor-styles');

		// Gutenberg - modify the font sizes
		add_theme_support( 'editor-font-sizes', array(
			array(
					'name' => __( 'small', 'tribes' ),
					'shortName' => __( 'S', 'tribes' ),
					'size' => 12,
					'slug' => 'small'
			),
			array(
					'name' => __( 'regular', 'tribes' ),
					'shortName' => __( 'M', 'tribes' ),
					'size' => 16,
					'slug' => 'regular'
			),
			array(
					'name' => __( 'large', 'tribes' ),
					'shortName' => __( 'L', 'tribes' ),
					'size' => 28,
					'slug' => 'large'
			),
			array(
					'name' => __( 'larger', 'tribes' ),
					'shortName' => __( 'XL', 'tribes' ),
					'size' => 38,
					'slug' => 'larger'
			)
	) );

		load_theme_textdomain( 'tribes', get_template_directory() . '/languages' );
	}
}
add_action( 'after_setup_theme', 'ct_tribes_theme_setup', 10 );

if ( ! function_exists( ( 'ct_tribes_customize_comments' ) ) ) {
	function ct_tribes_customize_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author">
				<?php
				echo get_avatar( get_comment_author_email(), 36, '', get_comment_author() );
				?>
				<span class="author-name"><?php comment_author_link(); ?></span>
			</div>
			<div class="comment-content">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php esc_html_e( 'Your comment is awaiting moderation.', 'tribes' ) ?></em>
					<br/>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
			<div class="comment-footer">
				<span class="comment-date"><?php comment_date(); ?></span>
				<?php comment_reply_link( array_merge( $args, array(
					'reply_text' => esc_html_x( 'Reply', 'verb: Reply to this comment', 'tribes' ),
					'depth'      => $depth,
					'max_depth'  => $args['max_depth']
				) ) ); ?>
				<?php edit_comment_link( esc_html_x( 'Edit', 'verb: Edit this comment', 'tribes' ) ); ?>
			</div>
		</article>
		<?php
	}
}

if ( ! function_exists( 'ct_tribes_update_fields' ) ) {
	function ct_tribes_update_fields( $fields ) {

		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$label     = $req ? '*' : ' ' . esc_html__( '(optional)', 'tribes' );
		$aria_req  = $req ? "aria-required='true'" : '';

		$fields['author'] =
			'<p class="comment-form-author">
	            <label for="author">' . esc_html_x( "Name", "noun", "tribes" ) . $label . '</label>
	            <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="30" ' . $aria_req . ' />
	        </p>';

		$fields['email'] =
			'<p class="comment-form-email">
	            <label for="email">' . esc_html_x( "Email", "noun", "tribes" ) . $label . '</label>
	            <input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) .
			'" size="30" ' . $aria_req . ' />
	        </p>';

		$fields['url'] =
			'<p class="comment-form-url">
	            <label for="url">' . esc_html__( "Website", "tribes" ) . '</label>
	            <input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size="30" />
	            </p>';

		return $fields;
	}
}
add_filter( 'comment_form_default_fields', 'ct_tribes_update_fields' );

if ( ! function_exists( 'ct_tribes_update_comment_field' ) ) {
	function ct_tribes_update_comment_field( $comment_field ) {

		// don't filter the WooCommerce review form
		if ( function_exists( 'is_woocommerce' ) ) {
			if ( is_woocommerce() ) {
				return $comment_field;
			}
		}
		
		$comment_field =
			'<p class="comment-form-comment">
	            <label for="comment">' . esc_html_x( "Comment", "noun", "tribes" ) . '</label>
	            <textarea required id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
	        </p>';

		return $comment_field;
	}
}
add_filter( 'comment_form_field_comment', 'ct_tribes_update_comment_field' );

if ( ! function_exists( 'ct_tribes_remove_comments_notes_after' ) ) {
	function ct_tribes_remove_comments_notes_after( $defaults ) {
		$defaults['comment_notes_after'] = '';
		return $defaults;
	}
}
add_action( 'comment_form_defaults', 'ct_tribes_remove_comments_notes_after' );

if ( ! function_exists( 'ct_tribes_filter_read_more_link' ) ) {
	function ct_tribes_filter_read_more_link( $custom = false ) {
		global $post;
		$ismore             = strpos( $post->post_content, '<!--more-->' );
		$read_more_text     = get_theme_mod( 'read_more_text' );
		$new_excerpt_length = get_theme_mod( 'excerpt_length' );
		$excerpt_more       = ( $new_excerpt_length === 0 ) ? '' : '&#8230;';
		$output = '';

		// add ellipsis for automatic excerpts
		if ( empty( $ismore ) && $custom !== true  ) {
			$output .= $excerpt_more;
		}
		// Because i18n text cannot be stored in a variable
		if ( empty( $read_more_text ) ) {
			$output .= '<div class="more-link-wrapper"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Continue reading', 'tribes' ) . '<span class="screen-reader-text">' . esc_html( get_the_title() ) . '</span></a></div>';
		} else {
			$output .= '<div class="more-link-wrapper"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . esc_html( $read_more_text ) . '<span class="screen-reader-text">' . esc_html( get_the_title() ) . '</span></a></div>';
		}
		return $output;
	}
}
add_filter( 'the_content_more_link', 'ct_tribes_filter_read_more_link' ); // more tags
add_filter( 'excerpt_more', 'ct_tribes_filter_read_more_link', 10 ); // automatic excerpts

// handle manual excerpts
if ( ! function_exists( 'ct_tribes_filter_manual_excerpts' ) ) {
	function ct_tribes_filter_manual_excerpts( $excerpt ) {
		$excerpt_more = '';
		if ( has_excerpt() ) {
			$excerpt_more = ct_tribes_filter_read_more_link( true );
		}
		return $excerpt . $excerpt_more;
	}
}
add_filter( 'get_the_excerpt', 'ct_tribes_filter_manual_excerpts' );

if ( ! function_exists( 'ct_tribes_excerpt' ) ) {
	function ct_tribes_excerpt() {
		global $post;
		$show_full_post = get_theme_mod( 'full_post' );
		$ismore         = strpos( $post->post_content, '<!--more-->' );

		if ( $show_full_post === 'yes' || $ismore ) {
			the_content();
		} else {
			the_excerpt();
		}
	}
}

if ( ! function_exists( 'ct_tribes_custom_excerpt_length' ) ) {
	function ct_tribes_custom_excerpt_length( $length ) {

		$new_excerpt_length = get_theme_mod( 'excerpt_length' );

		if ( ! empty( $new_excerpt_length ) && $new_excerpt_length != 25 ) {
			return $new_excerpt_length;
		} elseif ( $new_excerpt_length === 0 ) {
			return 0;
		} else {
			return 25;
		}
	}
}
add_filter( 'excerpt_length', 'ct_tribes_custom_excerpt_length', 99 );

if ( ! function_exists( 'ct_tribes_remove_more_link_scroll' ) ) {
	function ct_tribes_remove_more_link_scroll( $link ) {
		$link = preg_replace( '|#more-[0-9]+|', '', $link );
		return $link;
	}
}
add_filter( 'the_content_more_link', 'ct_tribes_remove_more_link_scroll' );

// Yoast OG description has "Read the postContinue reading" due to its use of get_the_excerpt(). This fixes that.
function ct_tribes_update_yoast_og_description( $ogdesc ) {
	$read_more_text = get_theme_mod( 'read_more_text' );
	if ( empty( $read_more_text ) ) {
		$read_more_text = esc_html__( 'Continue reading', 'tribes' );
	}
	$ogdesc = substr( $ogdesc, 0, strpos( $ogdesc, $read_more_text ) );

	return $ogdesc;
}
add_filter( 'wpseo_opengraph_desc', 'ct_tribes_update_yoast_og_description' );

if ( ! function_exists( 'ct_tribes_featured_image' ) ) {
	function ct_tribes_featured_image() {

		global $post;
		$featured_image = '';

		if ( has_post_thumbnail( $post->ID ) ) {

			if ( is_singular() ) {
				$featured_image = '<div class="featured-image">' . get_the_post_thumbnail( $post->ID, 'full' ) . '</div>';
			} else {
				$featured_image = '<div class="featured-image"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . get_the_post_thumbnail( $post->ID, 'full' ) . '</a></div>';
			}
		}

		$featured_image = apply_filters( 'ct_tribes_featured_image', $featured_image );

		if ( $featured_image ) {
			echo $featured_image;
		}
	}
}

if ( ! function_exists( 'ct_tribes_social_array' ) ) {
	function ct_tribes_social_array() {

		$social_sites = array(
			'twitter'       => 'tribes_twitter_profile',
			'facebook'      => 'tribes_facebook_profile',
			'instagram'     => 'tribes_instagram_profile',
			'linkedin'      => 'tribes_linkedin_profile',
			'pinterest'     => 'tribes_pinterest_profile',
			'youtube'       => 'tribes_youtube_profile',
			'rss'           => 'tribes_rss_profile',
			'email'         => 'tribes_email_profile',
			'phone'					=> 'tribes_phone_profile',
			'email-form'    => 'tribes_email_form_profile',
			'amazon'        => 'tribes_amazon_profile',
			'bandcamp'      => 'tribes_bandcamp_profile',
			'behance'       => 'tribes_behance_profile',
			'bitbucket'     => 'tribes_bitbucket_profile',
			'codepen'       => 'tribes_codepen_profile',
			'delicious'     => 'tribes_delicious_profile',
			'deviantart'    => 'tribes_deviantart_profile',
			'digg'          => 'tribes_digg_profile',
			'discord'    		=> 'tribes_discord_profile',
			'dribbble'      => 'tribes_dribbble_profile',
			'etsy'          => 'tribes_etsy_profile',
			'flickr'        => 'tribes_flickr_profile',
			'foursquare'    => 'tribes_foursquare_profile',
			'github'        => 'tribes_github_profile',
			'goodreads'   	=> 'tribes_goodreads_profile',
			'google-plus'   => 'tribes_googleplus_profile',
			'google-wallet' => 'tribes_google_wallet_profile',
			'hacker-news'   => 'tribes_hacker-news_profile',
			'medium'        => 'tribes_medium_profile',
			'meetup'        => 'tribes_meetup_profile',
			'mixcloud'      => 'tribes_mixcloud_profile',
			'ok-ru'         => 'tribes_ok_ru_profile',
			'patreon'       => 'tribes_patreon_profile',
			'paypal'        => 'tribes_paypal_profile',
			'podcast'       => 'tribes_podcast_profile',
			'qq'            => 'tribes_qq_profile',
			'quora'         => 'tribes_quora_profile',
			'ravelry'       => 'tribes_ravelry_profile',
			'reddit'        => 'tribes_reddit_profile',
			'skype'         => 'tribes_skype_profile',
			'slack'         => 'tribes_slack_profile',
			'slideshare'    => 'tribes_slideshare_profile',
			'soundcloud'    => 'tribes_soundcloud_profile',
			'spotify'       => 'tribes_spotify_profile',
			'snapchat'      => 'tribes_snapchat_profile',
			'stack-overflow' => 'tribes_stack_overflow_profile',
			'steam'         => 'tribes_steam_profile',
			'stumbleupon'   => 'tribes_stumbleupon_profile',
			'telegram'      => 'tribes_telegram_profile',
			'tencent-weibo' => 'tribes_tencent_weibo_profile',
			'tumblr'        => 'tribes_tumblr_profile',
			'twitch'        => 'tribes_twitch_profile',
			'vimeo'         => 'tribes_vimeo_profile',
			'vine'          => 'tribes_vine_profile',
			'vk'            => 'tribes_vk_profile',
			'wechat'        => 'tribes_wechat_profile',
			'weibo'         => 'tribes_weibo_profile',
			'whatsapp'      => 'tribes_whatsapp_profile',
			'xing'          => 'tribes_xing_profile',
			'yahoo'         => 'tribes_yahoo_profile',
			'yelp'          => 'tribes_yelp_profile',
			'500px'         => 'tribes_500px_profile',
		);

		return apply_filters( 'ct_tribes_social_array_filter', $social_sites );
	}
}

if ( ! function_exists( 'ct_tribes_social_icons_output' ) ) {
	function ct_tribes_social_icons_output() {

		$social_sites = ct_tribes_social_array();

		foreach ( $social_sites as $social_site => $profile ) {

			if ( strlen( get_theme_mod( $social_site ) ) > 0 ) {
				$active_sites[ $social_site ] = $social_site;
			}
		}

		if ( ! empty( $active_sites ) ) {

			echo "<ul class='social-media-icons'>";

			foreach ( $active_sites as $key => $active_site ) {

				if ( $active_site == 'rss' ) {
					$class = 'fas fa-rss';
				} elseif ( $active_site == 'email-form' ) {
					$class = 'far fa-envelope';
				} elseif ( $active_site == 'podcast' ) {
					$class = 'fas fa-podcast';
				} elseif ( $active_site == 'ok-ru' ) {
					$class = 'fab fa-odnoklassniki';
				} elseif ( $active_site == 'wechat' ) {
					$class = 'fab fa-weixin';
				} elseif ( $active_site == 'phone' ) {
					$class = 'fas fa-phone';
				} else {
					$class = 'fab fa-' . $active_site;
				}

				echo '<li>';
				if ( $active_site == 'email' ) { ?>
					<a class="email" target="_blank"
					   href="mailto:<?php echo antispambot( is_email( get_theme_mod( $key ) ) ); ?>">
						<i class="fas fa-envelope" title="<?php echo esc_attr_x( 'email', 'noun', 'tribes' ); ?>"></i>
					</a>
				<?php } elseif ( $active_site == 'skype' ) { ?>
					<a class="<?php echo esc_attr( $active_site ); ?>" target="_blank"
					   href="<?php echo esc_url( get_theme_mod( $key ), array( 'http', 'https', 'skype' ) ); ?>">
						<i class="<?php echo esc_attr( $class ); ?>"
						   title="<?php echo esc_attr( $active_site ); ?>"></i>
					</a>
				<?php } elseif ( $active_site == 'phone' ) { ?>
					<a class="<?php echo esc_attr( $active_site ); ?>" target="_blank"
							href="<?php echo esc_url( get_theme_mod( $active_site ), array( 'tel' ) ); ?>">
						<i class="<?php echo esc_attr( $class ); ?>"></i>
						<span class="screen-reader-text"><?php echo esc_html( $active_site );  ?></span>
					</a>
				<?php } else { ?>
					<a class="<?php echo esc_attr( $active_site ); ?>" target="_blank"
					   href="<?php echo esc_url( get_theme_mod( $key ) ); ?>">
						<i class="<?php echo esc_attr( $class ); ?>"
						   title="<?php echo esc_attr( $active_site ); ?>"></i>
					</a>
					<?php
				}
				echo '</li>';
			}
			echo "</ul>";
		}
	}
}

/*
 * WP will apply the ".menu-primary-items" class & id to the containing <div> instead of <ul>
 * making styling difficult and confusing. Using this wrapper to add a unique class to make styling easier.
 */
if ( ! function_exists( ( 'ct_tribes_wp_page_menu' ) ) ) {
	function ct_tribes_wp_page_menu() {
		wp_page_menu( array(
				"menu_class" => "menu-unset",
				"depth"      => - 1
			)
		);
	}
}
if ( ! function_exists( ( 'ct_tribes_nav_dropdown_buttons' ) ) ) {
	function ct_tribes_nav_dropdown_buttons( $item_output, $item, $depth, $args ) {

		if ( $args->theme_location == 'primary' ) {

			if ( in_array( 'menu-item-has-children', $item->classes ) || in_array( 'page_item_has_children', $item->classes ) ) {
				$item_output = str_replace( $args->link_after . '</a>', $args->link_after . '</a><button class="toggle-dropdown" aria-expanded="false" name="toggle-dropdown"><i class="fas fa-angle-down"></i><span class="screen-reader-text">' . esc_html_x( "open menu", "verb: open the menu", "tribes" ) . '</span></button>', $item_output );
			}
		}

		return $item_output;
	}
}
add_filter( 'walker_nav_menu_start_el', 'ct_tribes_nav_dropdown_buttons', 10, 4 );

if ( ! function_exists( ( 'ct_tribes_sticky_post_marker' ) ) ) {
	function ct_tribes_sticky_post_marker() {

		if ( is_sticky() && !is_archive() && !is_search() ) {
			echo '<div class="sticky-status"><span>' . esc_html__( "Featured", "tribes" ) . '</span></div>';
		}
	}
}
add_action( 'ct_tribes_sticky_post_status', 'ct_tribes_sticky_post_marker' );

if ( ! function_exists( ( 'ct_tribes_reset_customizer_options' ) ) ) {
	function ct_tribes_reset_customizer_options() {

		if ( empty( $_POST['tribes_reset_customizer'] ) || 'tribes_reset_customizer_settings' !== $_POST['tribes_reset_customizer'] ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['tribes_reset_customizer_nonce'], 'tribes_reset_customizer_nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		$mods_array = array(
			'logo_upload',
			'logo_size',
			'full_post',
			'excerpt_length',
			'read_more_text',
			'display_post_author',
			'display_post_date',
			'custom_css'
		);

		$social_sites = ct_tribes_social_array();

		// add social site settings to mods array
		foreach ( $social_sites as $social_site => $value ) {
			$mods_array[] = $social_site;
		}

		$mods_array = apply_filters( 'ct_tribes_mods_to_remove', $mods_array );

		foreach ( $mods_array as $theme_mod ) {
			remove_theme_mod( $theme_mod );
		}

		$redirect = admin_url( 'themes.php?page=tribes-options' );
		$redirect = add_query_arg( 'tribes_status', 'deleted', $redirect );

		// safely redirect
		wp_safe_redirect( $redirect );
		exit;
	}
}
add_action( 'admin_init', 'ct_tribes_reset_customizer_options' );

if ( ! function_exists( ( 'ct_tribes_delete_settings_notice' ) ) ) {
	function ct_tribes_delete_settings_notice() {

		if ( isset( $_GET['tribes_status'] ) ) {
			if ( $_GET['tribes_status'] == 'deleted' ) {
				?>
				<div class="updated">
					<p><?php esc_html_e( 'Customizer settings deleted.', 'tribes' ); ?></p>
				</div>
				<?php
			} else if ( $_GET['tribes_status'] == 'activated' ) {
				?>
				<div class="updated">
					<p><?php printf( esc_html__( '%s successfully activated!', 'tribes' ), wp_get_theme( get_template() ) ); ?></p>
				</div>
				<?php
			}
		}
	}
}
add_action( 'admin_notices', 'ct_tribes_delete_settings_notice' );

if ( ! function_exists( ( 'ct_tribes_body_class' ) ) ) {
	function ct_tribes_body_class( $classes ) {

		global $post;
		$full_post = get_theme_mod( 'full_post' );

		if ( $full_post == 'yes' ) {
			$classes[] = 'full-post';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'ct_tribes_body_class' );

if ( ! function_exists( ( 'ct_tribes_post_class' ) ) ) {
	function ct_tribes_post_class( $classes ) {
		$classes[] = 'entry';

		return $classes;
	}
}
add_filter( 'post_class', 'ct_tribes_post_class' );

if ( ! function_exists( ( 'ct_tribes_custom_css_output' ) ) ) {
	function ct_tribes_custom_css_output() {

		if ( function_exists( 'wp_get_custom_css' ) ) {
			$custom_css = wp_get_custom_css();
		} else {
			$custom_css = get_theme_mod( 'custom_css' );
		}
		$logo_size  = get_theme_mod( 'logo_size' );

		if ( $logo_size != 168 && ! empty( $logo_size ) ) {
			$logo_size_css = '.logo {
							width: ' . $logo_size . 'px;
						  }';
			$custom_css .= $logo_size_css;
		}
		if ( ! empty( $custom_css ) ) {
			$custom_css = ct_tribes_sanitize_css( $custom_css );

			wp_add_inline_style( 'ct-tribes-style', $custom_css );
			wp_add_inline_style( 'ct-tribes-style-rtl', $custom_css );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ct_tribes_custom_css_output', 20 );

if ( ! function_exists( ( 'ct_tribes_svg_output' ) ) ) {
	function ct_tribes_svg_output( $type ) {

		$svg = '';

		if ( $type == 'toggle-navigation' ) {

			$svg = '<svg width="24px" height="18px" viewBox="0 0 24 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				        <g transform="translate(-148.000000, -36.000000)" fill="#6B6B6B">
				            <g transform="translate(123.000000, 25.000000)">
				                <g transform="translate(25.000000, 11.000000)">
				                    <rect class="rect1" x="0" y="16" width="24" height="2"></rect>
				                    <rect class="rect2" x="0" y="8" width="24" height="2"></rect>
				                    <rect class="rect3" x="0" y="0" width="24" height="2"></rect>
				                </g>
				            </g>
				        </g>
				    </g>
				</svg>';
		}

		return $svg;
	}
}

if ( ! function_exists( ( 'ct_tribes_add_meta_elements' ) ) ) {
	function ct_tribes_add_meta_elements() {

		$meta_elements = '';

		$meta_elements .= sprintf( '<meta charset="%s" />' . "\n", esc_html( get_bloginfo( 'charset' ) ) );
		$meta_elements .= '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";

		$theme    = wp_get_theme( get_template() );
		$template = sprintf( '<meta name="template" content="%s %s" />' . "\n", esc_attr( $theme->get( 'Name' ) ), esc_attr( $theme->get( 'Version' ) ) );
		$meta_elements .= $template;

		echo $meta_elements;
	}
}
add_action( 'wp_head', 'ct_tribes_add_meta_elements', 1 );

// Move the WordPress generator to a better priority.
remove_action( 'wp_head', 'wp_generator' );
add_action( 'wp_head', 'wp_generator', 1 );

if ( ! function_exists( ( 'ct_tribes_infinite_scroll_render' ) ) ) {
	function ct_tribes_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content', 'archive' );
		}
	}
}

if ( ! function_exists( 'ct_tribes_get_content_template' ) ) {
	function ct_tribes_get_content_template() {

		if ( is_home() || is_archive() ) {
			get_template_part( 'content-archive', get_post_type() );
		} else {
			get_template_part( 'content', get_post_type() );
		}
	}
}

// allow skype URIs to be used
if ( ! function_exists( ( 'ct_tribes_allow_skype_protocol' ) ) ) {
	function ct_tribes_allow_skype_protocol( $protocols ) {
		$protocols[] = 'skype';

		return $protocols;
	}
}
add_filter( 'kses_allowed_protocols' , 'ct_tribes_allow_skype_protocol' );

// trigger theme switch on link click and send to Appearance menu
function ct_tribes_welcome_redirect() {

	$welcome_url = add_query_arg(
		array(
			'page'          => 'tribes-options',
			'tribes_status' => 'activated'
		),
		admin_url( 'themes.php' )
	);
	wp_safe_redirect( esc_url_raw( $welcome_url ) );
}
add_action( 'after_switch_theme', 'ct_tribes_welcome_redirect' );

//----------------------------------------------------------------------------------
// Add paragraph tags for author bio displayed in content/archive-header.php.
// the_archive_description includes paragraph tags for tag and category descriptions, but not the author bio. 
//----------------------------------------------------------------------------------
if ( ! function_exists( 'ct_tribes_modify_archive_descriptions' ) ) {
	function ct_tribes_modify_archive_descriptions( $description ) {

		if ( is_author() ) {
			$description = wpautop( $description );
		}
		return $description;
	}
}
add_filter( 'get_the_archive_description', 'ct_tribes_modify_archive_descriptions' );

//----------------------------------------------------------------------------------
// Registers an editor stylesheet
//----------------------------------------------------------------------------------
function ct_tribes_theme_add_editor_styles() {
	add_editor_style( trailingslashit(get_template_directory_uri()) . 'styles/editor.css' );
}
add_action( 'admin_init', 'ct_tribes_theme_add_editor_styles' );

//----------------------------------------------------------------------------------
// Output the markup for the optional scroll-to-top arrow 
//----------------------------------------------------------------------------------
function ct_tribes_scroll_to_top_arrow() {
	$setting = get_theme_mod('scroll_to_top');
	
	if ( $setting == 'yes' ) {
		echo '<button id="scroll-to-top" class="scroll-to-top"><span class="screen-reader-text">'. esc_html__('Scroll to the top', 'tribes') .'</span><i class="fas fa-arrow-up"></i></button>';
	}
}
add_action( 'ct_tribes_body_bottom', 'ct_tribes_scroll_to_top_arrow');