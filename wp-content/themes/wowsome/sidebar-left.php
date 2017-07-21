<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Wowsome
 */

if ( ! is_active_sidebar( 'wowsome_left_sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'wowsome_left_sidebar' ); ?>
</aside><!-- #secondary -->
