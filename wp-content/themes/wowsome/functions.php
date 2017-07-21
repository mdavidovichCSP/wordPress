<?php
/**
 * wowsome functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Wowsome
 */

if ( ! function_exists( 'wowsome_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wowsome_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on wowsome, use a find and replace
	 * to change 'wowsome' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'wowsome', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'wowsome' ),
		'social' => esc_html__('Social Navigation', 'wowsome') ,
		'right-section' => esc_html__('Top Right Section Navigation', 'wowsome') ,
		'footer' => esc_html__('Footer Navigation', 'wowsome') ,
	) );

	/* 
	* Enable support for custom logo. 
	* 
	*/ 
	add_theme_support( 'custom-logo', array( 
		'height'      => 100, 
		'width'       => 260, 
		'flex-height' => true,
		'flex-width' => true,
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'quote', 'link'
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wowsome_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Support for WooCommerce Product gallery
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
endif;
add_action( 'after_setup_theme', 'wowsome_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wowsome_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wowsome_content_width', 770 );
}
add_action( 'after_setup_theme', 'wowsome_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function wowsome_scripts() {
	global $wowsome_settings,$wowsome_array_of_default_settings;
	$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults() );
	wp_enqueue_style( 'wowsome-style', get_stylesheet_uri() );
	wp_enqueue_style('font-awesome', get_template_directory_uri().'/font-awesome/css/font-awesome.css');
	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
	wp_register_script('jquery-cycle', get_template_directory_uri().'/js/jquery.cycle.all.js', array('jquery'), '3.0.3', true);
	if ((is_front_page()) && 1 != $wowsome_settings['wowsome_disable_slider']) {
		wp_enqueue_script('wowsome-slider', get_template_directory_uri().'/js/wowsome-slider-setting.js', array('jquery-cycle'), false, true);
	}
	wp_enqueue_style('owl-carousel', get_template_directory_uri().'/owlcarousel/owl.carousel.min.css');
	wp_enqueue_script('owl-carousel', get_template_directory_uri().'/owlcarousel/owl.carousel.min.js', array('jquery'), '2.1.0', true);
	wp_enqueue_script('wowsome-owl-carousel', get_template_directory_uri().'/owlcarousel/owl.carousel-settings.js', array('owl-carousel'), false, true);

	wp_register_style( 'google-fonts', '//fonts.googleapis.com/css?family=Raleway:500|Roboto+Slab:400,700');
  	wp_enqueue_style( 'google-fonts' );

	wp_enqueue_script('wowsome-scripts', get_template_directory_uri().'/js/scripts.js', array('jquery'), true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wowsome_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load inc/functions.php
 */
require get_template_directory() . '/inc/functions.php';

/**
 * Load widgets and sidebar file
 */
require get_template_directory() . '/template-parts/widgets/wowsome-widgets.php';

/**
 * Load footer info page
 */
require get_template_directory() . '/inc/wowsome-footer-info.php';

/**
 * Load wowsome metaboxes
 */
require get_template_directory() . '/inc/wowsome-metaboxes.php';

/** 
	 * Displays the optional custom logo. 
	 * 
	 * Does nothing if the custom logo is not available. 
	 */ 

if ( ! function_exists( 'wowsome_the_custom_logo' ) ) : 
	function wowsome_the_custom_logo() { 
	    if ( function_exists( 'the_custom_logo' ) ) { 
	        the_custom_logo(); 
	    } 
	} 
endif;

add_action( 'after_setup_theme', 'wowsome_woocommerce_support' );
function wowsome_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);


add_action('woocommerce_before_main_content', 'wowsome_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'wowsome_wrapper_end', 10);
function wowsome_wrapper_start() { echo '<div id="primary" class="content-area"> <main id="main" class="site-main" role="main">'; }

function wowsome_wrapper_end() { echo '</div></main>'; }
