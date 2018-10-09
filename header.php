<!DOCTYPE html>

<!--[if gte IE 9]>
<html class="ie9" <?php language_attributes(); ?>>
<![endif]-->
<html <?php language_attributes(); ?>>

<head>
	<?php wp_head(); ?>
</head>

<body id="<?php print get_stylesheet(); ?>" <?php body_class(); ?>>
<?php do_action( 'ct_tribes_body_top' ); ?>
<a class="skip-content" href="#main"><?php esc_html_e( 'Press "Enter" to skip to content', 'tribes' ); ?></a>
<div id="overflow-container" class="overflow-container">
	<div id="theme-container" class="theme-container">
		<div id="max-width" class="max-width">
			<?php do_action( 'ct_tribes_before_header' ); ?>
			<header class="site-header" id="site-header" role="banner">
				<div id="title-container" class="title-container">
					<?php get_template_part( 'logo' ) ?>
				</div>
				<button id="toggle-navigation" class="toggle-navigation" name="toggle-navigation" aria-expanded="false">
					<span class="screen-reader-text"><?php echo esc_html_x( 'open menu', 'verb: open the menu', 'tribes' ); ?></span>
					<?php echo ct_tribes_svg_output( 'toggle-navigation' ); ?>
				</button>
				<div id="menu-primary-container" class="menu-primary-container">
					<div class="max-width">
						<div id="scroll-container" class="scroll-container">
							<?php if ( get_bloginfo( 'description' ) ) {
								echo '<p class="tagline">' . esc_html( get_bloginfo( 'description' ) ) . '</p>';
							} ?>
							<?php get_template_part( 'menu', 'primary' ); ?>
							<?php get_template_part( 'content/search-bar' ); ?>
							<?php ct_tribes_social_icons_output(); ?>
						</div>
					</div>
				</div>
			</header>
			<?php do_action( 'ct_tribes_after_header' ); ?>
			<section id="main" class="main" role="main">
				<?php do_action( 'ct_tribes_main_top' );
				if ( function_exists( 'yoast_breadcrumb' ) ) {
					yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
				}
