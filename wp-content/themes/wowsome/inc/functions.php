<?php
/**
 * Wowsome functions and definitions
 *
 * This file contains all the functions and it's defination that particularly can't be
 * in other files.
 *
 * @package Wowsome
 */
/****************************************************************************************/
function wowsome_get_option_defaults() {
	global $wowsome_array_of_default_settings;
	$wowsome_array_of_default_settings = array(
		'wowsome_disable_slider' =>1,
		'wowsome_featured_post_slider'	=> array(),
		'wowsome_slider_quantity'	=> '4',
		'wowsome_slider_type'	=> 'post-slider',
		'wowsome_transition_effect' => 'fade',
		'wowsome_transition_delay' => '4',
		'wowsome_transition_duration' => '1',
		'wowsome_disable_setting'	=>0,
		'wowsome_categories'	=>array(),
		'wowsome_exclude_slider_post'	=> 0,
		'wowsome_hide_sitetitle'	=>0,
		'wowsome_copyright_social_display'	=>0,
		'wowsome_design_layout' =>'on',
		'wowsome_content_layout' => 'right',
		'wowsome_hide_search' =>0,
		'wowsome_phone_no'	=>'',
		'wowsome_email_id'	=>'',
		'wowsome_location'	=>'',
		'wowsome_location_url'	=>'',
		'wowsome_skype'	=>'',
		'wowsome_contact_info_bar_top'	=>0,
		'wowsome_infobar_socialprofiles'	=>0

	);
	return apply_filters( 'wowsome_get_option_defaults', $wowsome_array_of_default_settings );
}
/****************************************************************************************/
add_action('pre_get_posts', 'wowsome_alter_home');
/**
 * Alter the query for the main loop in home page
 *
 * @uses pre_get_posts hook
 */
function wowsome_alter_home($query) {
	global $wowsome_settings,$wowsome_array_of_default_settings;
	$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults() );
	$wowsome_disable_setting = $wowsome_settings['wowsome_disable_setting'];

	if ($wowsome_settings['wowsome_exclude_slider_post'] != 0 && !empty($wowsome_settings['wowsome_featured_post_slider'])) {
		if ($query->is_main_query() && $query->is_home()) {
			$query->query_vars['post__not_in'] = $wowsome_settings['wowsome_featured_post_slider'];
		}
	}

	if ( $wowsome_disable_setting == 0 ) {
		$catID = $wowsome_settings['wowsome_categories'];
			if ( is_array( $catID ) && !in_array( '0', $catID ) ) {
				if( $query->is_main_query() && $query->is_home() ) {
					$query->query_vars['category__in'] = $wowsome_settings['wowsome_categories'];
				}
			}
	}

}
/****************************************************************************************/
add_filter('excerpt_length', 'wowsome_excerpt_length');
/**
 * Sets the post excerpt length to 20 words.
 *
 * @uses filter excerpt_length
 */
function wowsome_excerpt_length($length) {
	if(!is_admin()){
		return 20;// this will return 20 words in the excerpt
	}
}

add_filter('excerpt_more', 'wowsome_continue_reading');
/**
 * Returns a "Continue Reading" link for excerpts
 */
function wowsome_continue_reading() {
	if(!is_admin()){
		return '&hellip; ';
	}
}
/****************************************************************************************/
if (!function_exists('wowsome_pass_slider_effect_cycle_parameters')):
/**
 *Functions that Passes slider effect  parameters from php files to jquery file.
 */
function wowsome_pass_slider_effect_cycle_parameters() {
	global $wowsome_settings,$wowsome_array_of_default_settings;
	$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults() );
	$transition_effect   = $wowsome_settings['wowsome_transition_effect'];
	$transition_delay    = $wowsome_settings['wowsome_transition_delay']*1000;
	$transition_duration = $wowsome_settings['wowsome_transition_duration']*1000;

	wp_localize_script(
		'wowsome-slider',
		'wowsome_slider_value',
		array(
			'transition_effect'   => $transition_effect,
			'transition_delay'    => $transition_delay,
			'transition_duration' => $transition_duration,
		)
	);

}
endif;
/****************************************************************************************/

if (!function_exists('wowsome_featured_sliders')):
/**
 * displaying the featured image in home page
 *
 */
function wowsome_featured_sliders() { 
	global $post;
	global $wowsome_settings,$wowsome_array_of_default_settings;
	$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults() );
	$wowsome_featured_sliders = '';
	$get_featured_posts 		= new WP_Query(array(
		'posts_per_page'      	=> $wowsome_settings['wowsome_slider_quantity'],
		'post_type'           	=> array('post'),
		'post__in'            	=> $wowsome_settings['wowsome_featured_post_slider'],
		'orderby'             	=> 'post__in',
		'ignore_sticky_posts' 	=> 1
	));

	if($get_featured_posts->have_posts() || $wowsome_featured_sliders !=''){
		$slider_size = 'slider';
		$wowsome_featured_sliders 	.= '<div class="featured-slider"><div class="slider-cycle">';
		$i = 0;
		while ($get_featured_posts->have_posts()):$get_featured_posts->the_post();
					$i++;
					$title_attribute       	 	 = apply_filters('the_title', get_the_title($post->ID));
			if (1 == $i) {$classes = "slides displayblock";} else { $classes = "slides displaynone"; }
				$wowsome_featured_sliders    	.= '<div class="'.$classes.'">';
				if ( has_post_thumbnail() ) {
					$wowsome_featured_sliders 	.= '<a title="'.esc_html($title_attribute).'" href="'.esc_url(get_permalink()).'">';
					$wowsome_featured_sliders 	.= get_the_post_thumbnail( $post->ID) .'</a>';
				}
				$wowsome_featured_sliders 	.= '<article class="featured-text">';
				$wowsome_featured_sliders 	.= '<div class="container">';
				$wowsome_featured_sliders .= '<div class="featured-title"><a href="'.esc_url(get_permalink()).'" title="'.the_title('', '', false).'">'.esc_html(get_the_title()).'</a></div><!-- .featured-title -->';
				$wowsome_featured_sliders 	.= '</div><!-- .container -->';
				$wowsome_featured_sliders 	.= '</article><!-- .featured-text -->';
				$wowsome_featured_sliders 	.= '</div><!-- .slides -->';
		endwhile;
			wp_reset_postdata();
			$wowsome_featured_sliders .= '</div><!-- .slider-cycle -->';
			$wowsome_featured_sliders .= '<a class="fs-prev" href="#">'. esc_html('Prev','wowsome').'</a><a class="fs-next" href="#">'.esc_html('Next','wowsome').'</a>';
	}

			echo $wowsome_featured_sliders;
}
endif;
/****************************************************************************************/
if (!function_exists('wowsome_breadcrumb')):
/**
 * Display breadcrumb on header.
 *
 * If the page is home or front page, slider is displayed.
 * In other pages, breadcrumb will display if breadcrumb NavXT plugin exists.
 */
function wowsome_breadcrumb() {
	if (function_exists('bcn_display')) { ?>
		<div class="breadcrumb">
			<?php bcn_display(); ?>
		</div> <!-- .breadcrumb -->
	<?php }
}
endif;
/****************************************************************************************/
if (!function_exists('wowsome_header_title')):
/**
 * Show the title in header
 *
 */
function wowsome_header_title() {
	if (is_archive()) {
		if( class_exists( 'WooCommerce' ) && is_woocommerce()){
			$wowsome_header_title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
		}else{
			$wowsome_header_title = get_the_archive_title('', FALSE);
		}
	} elseif (is_home()){
		$wowsome_header_title = get_the_title( get_option( 'page_for_posts' ) );
	} elseif (is_404()) {
		$wowsome_header_title = __('Page NOT Found', 'wowsome');
	} elseif (is_search()) {
		$wowsome_header_title = __('Search Results', 'wowsome');
	} elseif (is_page_template()) {
		$wowsome_header_title = get_the_title();
	} else {
		$wowsome_header_title = get_the_title();
	}
	return $wowsome_header_title;
}
endif;
/****************************************************************************************/
function wowsome_display_social_icons(){
	if ( has_nav_menu( 'social' ) ) : ?>
		<div class="social-profiles clearfix">
		<?php
			// Social links navigation menu.
			wp_nav_menu( array(
				'theme_location' 	=> 'social',
				'container' 		=> '',
				'depth'          	=> 1,
				'items_wrap'      => '<ul>%3$s</ul>',
				'link_before'    	=> '<span class="screen-reader-text">',
				'link_after'     	=> '</span>',
			) );
		?>
		</div><!-- .social-profiles -->
	<?php endif;
}
/****************************************************************************************/
function wowsome_top_infoblog() {
		global $wowsome_phone_no, $wowsome_email_id, $wowsome_location, $wowsome_skype, $wowsome_settings;
		$wowsome_settings = wp_parse_args( get_option( 'wowsome_theme_settings', array() ), wowsome_get_option_defaults());
		$wowsome_phone_no = $wowsome_settings['wowsome_phone_no'];
		$wowsome_email_id = $wowsome_settings['wowsome_email_id'];
		$wowsome_location = $wowsome_settings['wowsome_location'];
		$wowsome_skype = $wowsome_settings['wowsome_skype'];
		$wowsome_top_infoblog 			= '';
		if ($wowsome_phone_no !='' || $wowsome_email_id!='' || $wowsome_location != '' || $wowsome_skype !='') {
				$wowsome_top_infoblog 	  .= '<div class="left-section clearfix"><button class="info-bar-menu-toggle-left">' .__('"Responsive Menu"','wowsome').'</button><ul class="contact-info">';
			if ($wowsome_phone_no !='') {
				$wowsome_top_infoblog .= '<li class='.'"phone-number"'.'><a title='.__('"Call Us"','wowsome').' '.'href='.'"tel:';
				$wowsome_top_infoblog .= preg_replace("/[^0-9+]/", '', $wowsome_settings['wowsome_phone_no']);
				$wowsome_top_infoblog .= '">';
				$wowsome_top_infoblog .= preg_replace("/[^() 0-9+-]/", '', $wowsome_settings['wowsome_phone_no']);
				$wowsome_top_infoblog .= '</a></li>';
			}
			if ($wowsome_email_id!='') {
				$wowsome_top_infoblog .= '<li class='.'"email"'.'><a title='.__('"Mail Us"','wowsome').' '.'href='.'"mailto:';
				$wowsome_top_infoblog .= is_email($wowsome_settings['wowsome_email_id']);
				$wowsome_top_infoblog .= '">';
				$wowsome_top_infoblog .= is_email($wowsome_settings['wowsome_email_id']);
				$wowsome_top_infoblog .= '</a></li>';
			}
			if ($wowsome_location != '') {
				$wowsome_top_infoblog .= '<li class='.'"address"'.'><a title='.__('"My Location"','wowsome').' target ='.'"_blank"'.' '.'href='.'"';
				$wowsome_top_infoblog .= esc_url($wowsome_settings['wowsome_location_url']);
				$wowsome_top_infoblog .= '">';
				$wowsome_top_infoblog .= esc_attr($wowsome_settings['wowsome_location']);
				$wowsome_top_infoblog .= '</a></li>';
			}
			if ($wowsome_skype !='') {
				$wowsome_top_infoblog .= '<li class='.'"skype"'.'><a title='.__('"Connect with Us"','wowsome').' '.'href='.'"skype:';
				$wowsome_top_infoblog .= esc_attr($wowsome_settings['wowsome_skype']);
				$wowsome_top_infoblog .= '?chat">';
				$wowsome_top_infoblog .= esc_attr($wowsome_settings['wowsome_skype']);
				$wowsome_top_infoblog .= '</a></li>';
			}
				$wowsome_top_infoblog .= '</ul></div><!-- .left-section -->';
		}
		echo $wowsome_top_infoblog;
	}
