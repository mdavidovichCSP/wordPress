<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Wowsome
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php 
global $wowsome_settings,$wowsome_array_of_default_settings;
$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults() ); ?>

<div id="page" class="site">
<?php if (has_header_video() || has_header_image())  {
			the_custom_header_markup();
	} ?>
	<header id="masthead" class="site-header" role="banner">

		<?php
		$wowsome_phone_no = $wowsome_settings['wowsome_phone_no'];
		$wowsome_email_id = $wowsome_settings['wowsome_email_id'];
		$wowsome_location = $wowsome_settings['wowsome_location'];
		$wowsome_skype = $wowsome_settings['wowsome_skype'];
		if ((has_nav_menu( 'right-section' ) || has_nav_menu( 'social' ) || $wowsome_phone_no !='' || $wowsome_email_id!='' || $wowsome_location != '' || $wowsome_skype !='') &&  ($wowsome_settings['wowsome_contact_info_bar_top'] ==0)){ ?>
		<div class="info-bar">
			<div class="container clearfix">

				<?php
				wowsome_top_infoblog();
				if ( has_nav_menu( 'right-section' ) || (has_nav_menu( 'social' )) ){ ?>
					<div class="right-section clearfix">
						<button class="info-bar-menu-toggle-right"><?php esc_html_e('Responsive Menu', 'wowsome' ); ?></button>
						<?php 
						if($wowsome_settings['wowsome_infobar_socialprofiles']==0){
							wowsome_display_social_icons();
						}
						if ( has_nav_menu( 'right-section' ) ){
							wp_nav_menu( array(
								'theme_location' 	=> 'right-section',
								'container' 		=> '',
								'depth'          	=> 1,
								'items_wrap'      => '<ul class="nav-menu-right">%3$s</ul>',
							) );
						}
						?>
					</div><!-- .right-section -->
				<?php }
				?>

			</div><!-- .container -->
		</div><!-- .info-bar -->
		<?php 
		} ?>

		<div class="hgroup-wrap headernav clearfix">
			<div class="container clearfix">
				<div class="site-branding clearfix">
					<?php wowsome_the_custom_logo();?>

					<?php if(is_single() || (!is_page_template('page-templates/page-template-business.php' )) && !is_home()){ ?>
						<h2 class="site-title">
							<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a> 
						</h2><!-- #site-title -->
						<?php } else { ?>

						<h1 class="site-title">
							<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a> 
						</h1><!-- #site-title -->
						<?php }

						$wowsome_site_description = get_bloginfo( 'description', 'display' );
						if($wowsome_site_description){?>
							<h2 class="site-description"><?php bloginfo('description');?> </h2>
						<?php }
						?>

				</div><!-- .site-branding -->
				<button class="menu-toggle"><?php esc_html_e('Responsive Menu','wowsome');?></button>
				<div class="hgroup-right">
					<nav id="site-navigation" class="main-navigation clearfix" role="navigation">

						<?php  
						if (has_nav_menu('primary')) { ?>
						<?php $args = array(
									'theme_location' => 'primary',
									'container'      => '',
									'items_wrap'     => '<ul class="nav-menu">%3$s</ul>',
								); 
							wp_nav_menu($args);
						} else {
							wp_page_menu(array('menu_class' => 'nav-menu'));
						}

						if($wowsome_settings['wowsome_hide_search']==0){?>
							<div class="search-toggle"></div><!-- .search-toggle -->
							<div id="search-box" class="hide">
								<?php get_search_form();?>
								<span class="arrow"></span>
							</div><!-- #search-box -->
						<?php }
						?>
					</nav><!-- #site-navigation .main-navigation -->
				</div>
			</div><!-- .container -->
		</div><!-- .hgroup-wrap .headernav -->

		<?php
		if (is_front_page()) {
			$wowsome_disable_slider = $wowsome_settings['wowsome_disable_slider'];
			if ($wowsome_disable_slider ==0) {
				if (function_exists('wowsome_pass_slider_effect_cycle_parameters')) {
					wowsome_pass_slider_effect_cycle_parameters();
				}
				if (function_exists('wowsome_featured_sliders')) {
					wowsome_featured_sliders();
				}
			}
		} else {
			if (('' != wowsome_header_title()) || function_exists('bcn_display_list')) {?>
				<div class="page-title-wrap" >
					<div class="container clearfix">
					<?php if(is_home()){?>
						<h2 class="page-title"><?php echo wowsome_header_title();?></h2><!-- .page-title -->
					<?php } else { ?>
						<h1 class="page-title"><?php echo wowsome_header_title();?></h1><!-- .page-title -->
					<?php }
						if (function_exists('wowsome_breadcrumb')) {
							wowsome_breadcrumb();
						} ?>
					</div><!-- .container -->
				</div><!-- .page-title-wrap -->
			<?php
			}
		} ?>

	</header><!-- #masthead -->
	<div id="content" class="site-content">
	<?php if (!is_page_template('page-templates/page-template-business.php')) { ?>
		<div class="container clearfix">
	<?php }
