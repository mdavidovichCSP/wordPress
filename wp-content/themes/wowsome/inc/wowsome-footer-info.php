<?php
/**
 * Contains all current date, yaer link of the theme
 *
 *
 * @package Wowsome
 */
?>
<?php
	/**
	 * To display the current year.
	 *
	 */
	function wowsome_the_year() {
	   return date_i18n( 'Y' );
	}
	/**
	 * To display a link back to the site.
	 *
	 */
	function wowsome_site_link() {
	   return ' <a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
	}
	/**
	 * To display a link to WordPress.org.
	 *
	 */
	function wowsome_wp_link() {
	   return sprintf( __('Proudly Powered by: %s', 'wowsome'), '<a href="' . esc_url( 'http://wordpress.org/', 'wowsome' ). '" target="_blank" title="' . esc_attr__( 'WordPress', 'wowsome' ). '"><span>' . __( 'WordPress', 'wowsome' ) . '</span></a>');
	}
	/**
	 * To display a link to wowsome.com.
	 *
	 */
	function wowsome_themehorse_link() {
	   return sprintf( __('Theme by: %s', 'wowsome'), '<a href="'.esc_url( 'https://www.themehorse.com','wowsome' ).'" target="_blank" title="' . esc_attr__( 'Theme Horse', 'wowsome' ).'" ><span>'. __( 'Theme Horse', 'wowsome' ) .'</span></a>');
	}
