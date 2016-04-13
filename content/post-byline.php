<div class="post-byline">
	<span class="post-author">
		<span><?php _e( 'By', 'tribes' ); ?></span>
		<?php the_author(); ?>
	</span>
    <span class="post-date">
	    <span><?php _e( 'on', 'tribes' ); ?></span>
		<?php
		$date = date_i18n( get_option( 'date_format' ), strtotime( get_the_date( 'r' ) ) );
		echo $date;
		?>
	</span>
</div>