<?php

$author_display = get_theme_mod( 'display_post_author' );
$date_display   = get_theme_mod( 'display_post_date' );

if ( $author_display == 'hide' && $date_display == 'hide' ) {
	return;
}

?>

<div class="post-byline">
	<?php if ( $author_display != 'hide' ) : ?>
		<span class="post-author">
			<span><?php echo esc_html_x( 'By', 'blog post BY author name', 'tribes' ); ?></span>
			<?php the_author(); ?>
		</span>
	<?php endif; ?>
	<?php if ( $date_display != 'hide' ) : ?>
	    <span class="post-date">
	        <span>
				<?php
				if ( $author_display != 'hide' ) {
					echo esc_html_x( 'on', 'post published ON date', 'tribes' );
				}
				?>
			</span>
		    <?php
			$date = date_i18n( get_option( 'date_format' ), strtotime( get_the_date( 'r' ) ) );
			echo $date;
			?>
		</span>
	<?php endif; ?>
</div>