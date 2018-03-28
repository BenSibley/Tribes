<?php

function ct_tribes_register_theme_page() {
	add_theme_page( sprintf( __( '%s Dashboard', 'tribes' ), wp_get_theme( get_template() ) ), sprintf( __( '%s Dashboard', 'tribes' ), wp_get_theme( get_template() ) ), 'edit_theme_options', 'tribes-options', 'ct_tribes_options_content', 'ct_tribes_options_content' );
}
add_action( 'admin_menu', 'ct_tribes_register_theme_page' );

function ct_tribes_options_content() {

	$customizer_url = add_query_arg(
		array(
			'url'    => get_home_url(),
			'return' => add_query_arg( 'page', 'tribes-options', admin_url( 'themes.php' ) )
		),
		admin_url( 'customize.php' )
	);
	?>
	<div id="tribes-dashboard-wrap" class="wrap">
		<h2><?php printf( __( '%s Dashboard', 'tribes' ), wp_get_theme( get_template() ) ); ?></h2>
		<?php do_action( 'ct_tribes_theme_options_before' ); ?>
		<div class="content-boxes">
			<div class="content content-support">
				<h3><?php _e( 'Get Started', 'tribes' ); ?></h3>
				<p><?php printf( __( 'Not sure where to start? The <strong>%1$s Getting Started Guide</strong> will take you step-by-step through every feature in %1$s.', 'tribes' ), wp_get_theme( get_template() ) ); ?></p>
				<p>
					<a target="_blank" class="button-primary"
					   href="https://www.competethemes.com/documentation/tribes-support-center/"><?php _e( 'Visit Support Center', 'tribes' ); ?></a>
				</p>
			</div>
			<?php if ( !function_exists( 'ct_tribes_pro_init' ) ) : ?>
				<div class="content content-premium-upgrade">
					<h3><?php printf( __( '%s Pro', 'tribes' ), wp_get_theme( get_template() ) ); ?></h3>
					<p><?php printf( __( 'Download the %s Pro plugin and unlock custom colors, new layouts, sliders, and more', 'tribes' ), wp_get_theme( get_template() ) ); ?>...</p>
					<p>
						<a target="_blank" class="button-primary"
						   href="https://www.competethemes.com/tribes-pro/"><?php _e( 'See Full Feature List', 'tribes' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
			<div class="content content-review">
				<h3><?php _e( 'Leave a Review', 'tribes' ); ?></h3>
				<p><?php printf( __( 'Help others find %s by leaving a review on wordpress.org.', 'tribes' ), wp_get_theme( get_template() ) ); ?></p>
				<a target="_blank" class="button-primary" href="https://wordpress.org/support/theme/tribes/reviews/"><?php _e( 'Leave a Review', 'tribes' ); ?></a>
			</div>
			<div class="content content-presspad">
				<h3><?php esc_html_e( 'Turn Tribes into a Mobile App', 'tribes' ); ?></h3>
				<p><?php printf( esc_html__( '%s can be converted into a mobile app and listed on the App Store and Google Play Store with the help of PressPad News. Read our tutorial to learn more.', 'tribes' ), wp_get_theme( get_template() ) ); ?></p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/help/convert-mobile-app-tribes/"><?php esc_html_e( 'Read Tutorial', 'tribes' ); ?></a>
			</div>
			<div class="content content-delete-settings">
				<h3><?php _e( 'Reset Customizer Settings', 'tribes' ); ?></h3>
				<p>
					<?php printf( __( '<strong>Warning:</strong> Clicking this button will erase the %1$s theme\'s current settings in the <a href="%2$s">Customizer</a>.', 'tribes' ), wp_get_theme( get_template() ), esc_url( $customizer_url ) ); ?>
				</p>
				<form method="post">
					<input type="hidden" name="tribes_reset_customizer" value="tribes_reset_customizer_settings"/>
					<p>
						<?php wp_nonce_field( 'tribes_reset_customizer_nonce', 'tribes_reset_customizer_nonce' ); ?>
						<?php submit_button( __( 'Reset Customizer Settings', 'tribes' ), 'delete', 'delete', false ); ?>
					</p>
				</form>
			</div>
		</div>
		<?php do_action( 'ct_tribes_theme_options_after' ); ?>
	</div>
<?php }