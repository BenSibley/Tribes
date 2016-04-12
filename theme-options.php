<?php

function ct_tribes_register_theme_page() {
	add_theme_page( __( 'Tribes Dashboard', 'tribes' ), __( 'Tribes Dashboard', 'tribes' ), 'edit_theme_options', 'tribes-options', 'ct_tribes_options_content', 'ct_tribes_options_content' );
}
add_action( 'admin_menu', 'ct_tribes_register_theme_page' );

function ct_tribes_options_content() {

	$customizer_url = add_query_arg(
		array(
			'url'    => site_url(),
			'return' => add_query_arg( 'page', 'tribes-options', admin_url( 'themes.php' ) )
		),
		admin_url( 'customize.php' )
	);
	?>
	<div id="tribes-dashboard-wrap" class="wrap">
		<h2><?php _e( 'Tribes Dashboard', 'tribes' ); ?></h2>
		<?php do_action( 'theme_options_before' ); ?>
		<div class="content content-customization">
			<h3><?php _e( 'Customization', 'tribes' ); ?></h3>
			<p><?php _e( 'Click the "Customize" link in your menu, or use the button below to get started customizing Tribes', 'tribes' ); ?>.</p>
			<p>
				<a class="button-primary"
				   href="<?php echo esc_url( $customizer_url ); ?>"><?php _e( 'Use Customizer', 'tribes' ) ?></a>
			</p>
		</div>
		<div class="content content-support">
			<h3><?php _e( 'Support', 'tribes' ); ?></h3>
			<p><?php _e( "You can find the knowledgebase, changelog, support forum, and more in the Tribes Support Center", "tribes" ); ?>.</p>
			<p>
				<a target="_blank" class="button-primary"
				   href="https://www.competethemes.com/documentation/tribes-support-center/"><?php _e( 'Visit Support Center', 'tribes' ); ?></a>
			</p>
		</div>
		<div class="content content-premium-upgrade">
			<h3><?php _e( 'Tribes', 'tribes' ); ?></h3>
			<p><?php _e( 'Download the Tribes Pro plugin and unlock custom colors, new layouts, sliders, and more', 'tribes' ); ?>...</p>
			<p>
				<a target="_blank" class="button-primary"
				   href="https://www.competethemes.com/tribes-pro/"><?php _e( 'See Full Feature List', 'tribes' ); ?></a>
			</p>
		</div>
		<div class="content content-resources">
			<h3><?php _e( 'WordPress Resources', 'tribes' ); ?></h3>
			<p><?php _e( 'Save time and money searching for WordPress products by following our recommendations', 'tribes' ); ?>.</p>
			<p>
				<a target="_blank" class="button-primary"
				   href="https://www.competethemes.com/wordpress-resources/"><?php _e( 'View Resources', 'tribes' ); ?></a>
			</p>
		</div>
		<div class="content content-review">
			<h3><?php _e( 'Leave a Review', 'tribes' ); ?></h3>
			<p><?php _e( 'Help others find Tribes by leaving a review on wordpress.org.', 'tribes' ); ?></p>
			<a target="_blank" class="button-primary" href="https://wordpress.org/support/view/theme-reviews/tribes"><?php _e( 'Leave a Review', 'tribes' ); ?></a>
		</div>
		<div class="content content-delete-settings">
			<h3><?php _e( 'Reset Customizer Settings', 'tribes' ); ?></h3>
			<p>
				<?php printf( __( "<strong>Warning:</strong> Clicking this button will erase the Tribes theme's current settings in the <a href='%s'>Customizer</a>.", 'tribes' ), esc_url( $customizer_url ) ); ?>
			</p>
			<form method="post">
				<input type="hidden" name="tribes_reset_customizer" value="tribes_reset_customizer_settings"/>
				<p>
					<?php wp_nonce_field( 'tribes_reset_customizer_nonce', 'tribes_reset_customizer_nonce' ); ?>
					<?php submit_button( __( 'Reset Customizer Settings', 'tribes' ), 'delete', 'delete', false ); ?>
				</p>
			</form>
		</div>
		<?php do_action( 'theme_options_after' ); ?>
	</div>
<?php }