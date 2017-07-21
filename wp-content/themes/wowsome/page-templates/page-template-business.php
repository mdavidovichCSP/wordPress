<?php
/**
 * Template Name: Business Template
 *
 * Displays the Business Template of the theme.
 *
 * @package Wowsome
 */

get_header();

if( is_active_sidebar( 'wowsome_business_template' ) ) : ?>
	<main id="main" class="site-main" role="main">
	<?php
		dynamic_sidebar( 'wowsome_business_template' ); ?>
	</main><!-- #main .site-main -->
	<?php 
endif;

get_footer();
