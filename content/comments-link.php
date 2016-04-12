<span class="comments-link">
	<i class="fa fa-comment" title="<?php _e( 'comment icon', 'tribes' ); ?>"></i>
	<?php
	if ( ! comments_open() && get_comments_number() < 1 ) :
		comments_number( __( 'Comments closed', 'tribes' ), __( '1 Comment', 'tribes' ), __( '% Comments', 'tribes' ) );
	else :
		echo '<a href="' . esc_url( get_comments_link() ) . '">';
		comments_number( __( 'Leave a Comment', 'tribes' ), __( '1 Comment', 'tribes' ), __( '% Comments', 'tribes' ) );
		echo '</a>';
	endif;
	?>
</span>