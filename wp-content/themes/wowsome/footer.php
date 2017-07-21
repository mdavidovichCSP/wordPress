<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Wowsome
 */

global $wowsome_settings,$wowsome_array_of_default_settings;
$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults() );
	if (!is_page_template('page-templates/page-template-business.php')) { ?>
		</div><!-- .container -->
	<?php } ?>
	</div><!-- #content .site-content-->

	<footer id="colophon" class="site-footer clearfix" role="contentinfo">

	<?php if( is_active_sidebar( 'wowsome_footer_sidebar' ) || is_active_sidebar( 'wowsome_footer_column2' ) || is_active_sidebar( 'wowsome_footer_column3' ) || is_active_sidebar( 'wowsome_footer_column4' ) ) {
		?>
		<div class="widget-wrap">
			<div class="container">
				<div class="widget-area column-area column-fourth clearfix">
					<div class="column-item">
						<?php
							// Calling the footer column 1 sidebar
							if ( is_active_sidebar( 'wowsome_footer_sidebar' ) ) :
								dynamic_sidebar( 'wowsome_footer_sidebar' );
							endif;
						?>
					</div><!-- .column-item -->
					<div class="column-item">
						<?php
							// Calling the footer column 2 sidebar
							if ( is_active_sidebar( 'wowsome_footer_column2' ) ) :
								dynamic_sidebar( 'wowsome_footer_column2' );
							endif;
						?>
					</div><!-- .column-item -->
					<div class="column-item clearfix-half">
						<?php
							// Calling the footer column 3 sidebar
							if ( is_active_sidebar( 'wowsome_footer_column3' ) ) :
								dynamic_sidebar( 'wowsome_footer_column3' );
							endif;
						?>
					</div><!-- .column-item -->
					<div class="column-item clearfix-third">
						<?php
							// Calling the footer column 4 sidebar
							if ( is_active_sidebar( 'wowsome_footer_column4' ) ) :
								dynamic_sidebar( 'wowsome_footer_column4' );
							endif;
						?>
					</div><!-- .column-item -->
				</div><!-- .widget-area --> 
			</div><!-- .container --> 
		</div><!-- .widget-wrap -->
	<?php } ?>

		<?php 
		if ( has_nav_menu( 'footer' ) ){ ?>
		<div class="footer-navigation">
			<div class="container clearfix">
					<?php wp_nav_menu( array(
							'theme_location' 	=> 'footer',
							'container' 		=> '',
							'depth'          	=> 1,
							'items_wrap'      => '<ul>%3$s</ul>',
						) );
					?>
			</div><!-- .container -->
		</div><!-- .footer-navigation -->
		<?php }
		?>

		<div class="site-info">
		<?php if($wowsome_settings['wowsome_hide_sitetitle'] ==0){ ?>
			<div class="branding-social">
				<div class="container">
					<div class="site-branding clearfix">
						<?php wowsome_the_custom_logo();?>
						<p class="site-title"><a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'));?>"><?php bloginfo('name');?></a></p>
						<?php $wowsome_site_description = get_bloginfo( 'description', 'display' );
						if($wowsome_site_description){?>
							<p class="site-description"><?php bloginfo('description');?></p>
						<?php } ?>
					</div><!-- .site-branding -->
				</div><!-- .container -->
			</div><!-- .branding-social -->
		<?php } ?>
			<div class="copyright-social <?php if ($wowsome_settings['wowsome_copyright_social_display']==0 ){ echo 'centred'; } ?> clearfix">
				<div class="container">
					<?php wowsome_display_social_icons(); ?>
					<div class="copyright">
						<?php esc_html_e('Copyright &copy; ','wowsome'); echo wowsome_the_year();  echo wowsome_site_link(); ?> | <?php echo wowsome_themehorse_link(); ?> | <?php echo wowsome_wp_link(); ?>
					</div><!-- .copyright -->
				</div><!-- .container -->
			</div><!-- .copyright-social -->
		</div><!-- .site-info -->

		<div class="back-to-top"><a title="<?php esc_html_e('Go to Top','wowsome');?>" href="#masthead"></a></div>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
