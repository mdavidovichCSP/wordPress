<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Wowsome
 */
global $wowsome_settings,$wowsome_array_of_default_settings;
$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults() );
$wowsome_content_layout = $wowsome_settings['wowsome_content_layout'];
if( class_exists( 'WooCommerce' ) && is_woocommerce() && $wowsome_content_layout == 'left' ){
	echo '<aside id="secondary" class="widget-area" role="complementary">';
	// Calling the left sidebar
	if ( is_active_sidebar( 'wowsome_left_sidebar' ) ) :
		dynamic_sidebar( 'wowsome_left_sidebar' );
	endif;
	echo '</aside><!-- #secondary -->';
	return;
}elseif( class_exists( 'WooCommerce' ) && is_woocommerce() && $wowsome_content_layout == 'right' ){
	echo '<aside id="secondary" class="widget-area" role="complementary">';
	// Calling the right sidebar
	if ( is_active_sidebar( 'wowsome_right_sidebar' ) ) :
		dynamic_sidebar( 'wowsome_right_sidebar' );
	endif;
	echo '</aside><!-- #secondary -->';
}
if( !class_exists( 'WooCommerce' )){
	echo '<aside id="secondary" class="widget-area" role="complementary">';
	// Calling the right sidebar
	if ( is_active_sidebar( 'wowsome_right_sidebar' ) ) :
		dynamic_sidebar( 'wowsome_right_sidebar' );
	endif;
	echo '</aside><!-- #secondary -->';
}
if( class_exists( 'WooCommerce' ) && !is_woocommerce()){
	echo '<aside id="secondary" class="widget-area" role="complementary">';
	// Calling the right sidebar
	if ( is_active_sidebar( 'wowsome_right_sidebar' ) ) :
		dynamic_sidebar( 'wowsome_right_sidebar' );
	endif;
	echo '</aside><!-- #secondary -->';
}