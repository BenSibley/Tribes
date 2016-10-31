<?php

$logo = get_theme_mod( 'custom_logo' );

if ( $logo ) {
	echo "<div id='site-title' class='site-title'>";
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	echo "</div>";
} else {
	echo "<div id='site-title' class='site-title'>";
		echo "<a href='" . esc_url( home_url() ) . "'>";
			bloginfo( 'name' );
		echo "</a>";
	echo "</div>";
}