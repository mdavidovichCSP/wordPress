<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Wowsome
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
/****************************************************************************************/
add_filter('body_class', 'wowsome_body_class');
/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function wowsome_body_class($classes) {
	global $wowsome_site_layout, $wowsome_content_layout, $wowsome_settings,$wowsome_array_of_default_settings;
	$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults() );
	global $post;

	if ($post) {
		$wowsome_layout = get_post_meta($post->ID, 'wowsome_sidebarlayout', true);
	}
	$wowsome_site_layout = $wowsome_settings['wowsome_design_layout'];
	$wowsome_content_layout = $wowsome_settings['wowsome_content_layout'];
	$wowsome_frontpage_id = get_option('page_on_front'); // for front page
	$wowsome_banner = get_post_meta( $wowsome_frontpage_id, 'wowsome_sidebarlayout', true );
	$wowsome_page_id = ( 'page' == get_option( 'show_on_front' ) ? get_option( 'page_for_posts' ) : get_the_ID() );
	$wowsome_home_blog = get_post_meta( $wowsome_page_id, 'wowsome_sidebarlayout', true );
	if (empty($wowsome_layout) || is_archive() || is_search() || is_home()) {
		$wowsome_layout = 'default';
	}
	if ('default' == $wowsome_layout) {
		$wowsome_themeoption_layout = $wowsome_content_layout;
		if ('left' == $wowsome_themeoption_layout) {
			$classes[] = 'left-sidebar-layout';
		}
		elseif ('right' == $wowsome_themeoption_layout) {
			$classes[] = '';
		}
		elseif ('fullwidth' == $wowsome_themeoption_layout) {
			$classes[] = 'full-width-layout';
		}
		elseif ('nosidebar' == $wowsome_themeoption_layout) {
			$classes[] = 'no-sidebar-layout';
		}
	}elseif ('left-sidebar' == $wowsome_layout) {

	$classes[] = 'left-sidebar-layout';
	}
	elseif ('right-sidebar' == $wowsome_layout) {
		$classes[] = '';//css blank
	}
	elseif ('no-sidebar-full-width' == $wowsome_layout) {
		$classes[] = 'full-width-layout';
	}
	elseif ('no-sidebar' == $wowsome_layout) {
		$classes[] = 'no-sidebar-layout';//css for no-sidebar-layout from <body >
	}
	if ($wowsome_site_layout =='off') {

		$classes[] = 'narrow-layout';
	}
	if (is_page_template('page-templates/page-template-business.php')) {
		$classes[] = 'business-template';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if(has_header_video() && has_header_image() ){
		if ( is_front_page() && is_home() ) {
			$classes[] = '';
		}elseif(is_front_page()){
			$classes[] = '';
		}else{
			$classes[] = 'header-image';
		}
	}elseif(has_header_image()){
		$classes[] = 'header-image';
	}
	return $classes;
}
/****************************************************************************************/
add_action( 'wowsome_main_sidebar_content', 'wowsome_sidebar_content');
/**
 * Function to display the content for the single post, single page, archive page, index page etc.
 */
function wowsome_sidebar_content() {
	global $post;
	global $wowsome_site_layout, $wowsome_content_layout, $wowsome_settings,$wowsome_array_of_default_settings;
	$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults() );

	if( $post ) {
		$wowsome_layout = get_post_meta( $post->ID, 'wowsome_sidebarlayout', true );
		$wowsome_frontpage_id = get_option('page_on_front'); // for front page
		$wowsome_content_layout = $wowsome_settings['wowsome_content_layout'];
		$wowsome_banner = get_post_meta( $wowsome_frontpage_id, 'wowsome_sidebarlayout', true );
		$wowsome_page_id = ( 'page' == get_option( 'show_on_front' ) ? get_option( 'page_for_posts' ) : get_the_ID() );
		$wowsome_home_blog = get_post_meta( $wowsome_page_id, 'wowsome_sidebarlayout', true ); 
	}
	if( empty( $wowsome_layout ) || is_archive() || is_search() || is_home() ) {
		$wowsome_layout = 'default';
	}
	if(is_front_page() && $wowsome_banner):
		if( 'default' == $wowsome_banner ) {//checked from the themeoptions.
		$wowsome_themeoption_layout = $wowsome_content_layout;
			if( 'left' == $wowsome_themeoption_layout ) { 
			get_sidebar('left');//used sidebar-left.php
			}
			elseif( 'right' == $wowsome_themeoption_layout ) { 
			get_sidebar();//used sidebar.php
			}
			else {
			return; // doesnot display sidebar content
			}
		}
		elseif( 'left-sidebar' == $wowsome_banner ) { //checked from the particular page / post.
			get_sidebar( 'left' );//used sidebar-left.php
		}
		elseif( 'right-sidebar' == $wowsome_banner ) {
			get_sidebar();//used sidebar.php
		}
		else { 
			return; // doesnot display sidebar content
		}
		elseif(is_front_page()):
		if( 'default' == $wowsome_layout ) {//checked from the themeoptions.
		$wowsome_themeoption_layout = $wowsome_content_layout;
			if( 'left' == $wowsome_themeoption_layout ) { 
			get_sidebar( 'left' );//used sidebar-left.php
			}
			elseif( 'right' == $wowsome_themeoption_layout ) { 
			get_sidebar();//used sidebar.php
			}
			else {
			return; // doesnot display sidebar content
			}
		}
		elseif( 'left-sidebar' == $wowsome_layout ) { //checked from the particular page / post.
			get_sidebar( 'left' );//used sidebar-left.php
		}
		elseif( 'right-sidebar' == $wowsome_layout ) {
			get_sidebar();//used sidebar.php
		}
		else { 
			return; // doesnot display sidebar content
		}
	elseif(is_home()):
		if( 'default' == $wowsome_layout ) {//checked from the themeoptions. 
		$wowsome_themeoption_layout = $wowsome_content_layout;
			if( 'left' == $wowsome_themeoption_layout ) { 
			get_sidebar( 'left' );//used sidebar-left.php
			}
			elseif( 'right' == $wowsome_themeoption_layout ) {
			get_sidebar();//used sidebar.php
			}
			else {
			return; // doesnot display sidebar content
			}
		}
		elseif( 'left-sidebar' == $wowsome_home_blog ) { //checked from the particular page / post.
			get_sidebar( 'left','sidebar' );//used sidebar-left.php
		}
		elseif( 'right-sidebar' == $wowsome_home_blog ) {
			get_sidebar();//used sidebar.php
		}
		else { 
			return; // doesnot display sidebar content
		}
	else:
		if( 'default' == $wowsome_layout ) { //checked from the themeoptions.
		$wowsome_themeoption_layout = $wowsome_content_layout;
			if( 'left' == $wowsome_themeoption_layout ) {

			get_sidebar( 'left','sidebar' );//used sidebar-left.php
			}
			elseif( 'right' == $wowsome_themeoption_layout ) {
			get_sidebar();//used sidebar.php
			}
			else {
			return; // doesnot display sidebar content
			}
		}
		elseif( 'left-sidebar' == $wowsome_layout ) {//checked from the particular page / post.
			get_sidebar( 'left','sidebar' );//used sidebar-left.php
		}
		elseif( 'right-sidebar' == $wowsome_layout ) {
			get_sidebar();//used sidebar.php
		}
		else {
			return; // doesnot display sidebar content
		}
	endif;
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function wowsome_pingback_header() {

	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}

}
add_action( 'wp_head', 'wowsome_pingback_header' );
