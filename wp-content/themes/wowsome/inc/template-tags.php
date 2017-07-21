<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Wowsome
 */

if ( ! function_exists( 'wowsome_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function wowsome_posted_on() {
	$time_string = get_the_time( get_option( 'date_format' ) );

	$posted_on = sprintf(
		'<a href="' . esc_url( get_permalink() ) . '" title="'. the_title_attribute( 'echo=0' ).'">' . $time_string . '</a>'
	);

	$byline = sprintf('<span class="fn"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<div class="date updated">' . $posted_on . '</div><div class="by-author vcard author">' . $byline. '</div>'; // WPCS: XSS OK.

}
endif;
