<span class="comments-link">
	<i class="fas fa-comment" title="<?php esc_attr_e( 'comment icon', 'tribes' ); ?>"></i>
	<?php
	if ( ! comments_open() && get_comments_number() < 1 ) :
		comments_number( esc_html__( 'Comments closed', 'tribes' ), esc_html__( '1 Comment', 'tribes' ), esc_html__( '% Comments', 'tribes' ) );
	else :
		echo '<a href="' . esc_url( get_comments_link() ) . '">';
		comments_number( esc_html__( 'Leave a Comment', 'tribes' ), esc_html__( '1 Comment', 'tribes' ), esc_html__( '% Comments', 'tribes' ) );
		echo '</a>';
	endif;
	?>
</span>