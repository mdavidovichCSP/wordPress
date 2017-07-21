<?php
/**
 * wowsome Theme Customizer
 *
 * @package Wowsome
 */

if ( ! class_exists( 'WP_Customize_Section' ) ) {
	return null;
}
function wowsome_textarea_register($wp_customize){

	class Wowsome_Customize_Wowsome_upgrade extends WP_Customize_Control {
		public function render_content() { ?>
		<div class="theme-info">
			<a title="<?php esc_attr_e( 'Review Wowsome', 'wowsome' ); ?>" href="<?php echo esc_url( 'https://wordpress.org/support/view/theme-reviews/wowsome' ); ?>" target="_blank">
			<?php _e( 'Rate Wowsome', 'wowsome' ); ?>
			</a>
			<a href="<?php echo esc_url( 'https://www.themehorse.com/theme-instruction/wowsome/' ); ?>" title="<?php esc_attr_e( 'Wowsome Theme Instructions', 'wowsome' ); ?>" target="_blank">
			<?php _e( 'Theme Instructions', 'wowsome' ); ?>
			</a>
			<a href="<?php echo esc_url( 'https://www.themehorse.com/support-forum/' ); ?>" title="<?php esc_attr_e( 'Support Forum', 'wowsome' ); ?>" target="_blank">
			<?php _e( 'Support Forum', 'wowsome' ); ?>
			</a>
			<a href="<?php echo esc_url( 'https://www.themehorse.com/preview/wowsome' ); ?>" title="<?php esc_attr_e( 'Wowsome Demo', 'wowsome' ); ?>" target="_blank">
			<?php _e( 'View Demo', 'wowsome' ); ?>
			</a>
		</div>
		<?php
		}
	}

	class Wowsome_Customize_Category_Control extends WP_Customize_Control {
		/**
		* The type of customize control being rendered.
		*/
		public $type = 'multiple-select';
		/**
		* Displays the multiple select on the customize screen.
		*/
		public function render_content() {
		global $wowsome_settings, $wowsome_array_of_default_settings;
		$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults());
		$categories = get_categories(); ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?> multiple="multiple">
				<?php
					foreach ( $categories as $category) :?>
						<option value="<?php echo absint($category->cat_ID); ?>" <?php if ( in_array( $category->cat_ID, $wowsome_settings[ 'wowsome_categories' ]) ) { echo 'selected="selected"';}?>><?php echo esc_attr($category->cat_name); ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		<?php 
		}
	}

}
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wowsome_customize_register( $wp_customize ) {
	$wp_customize->add_panel( 'wowsome_theme_settings', array(
	'priority'       => 10,
	'capability'     => 'edit_theme_options',
	'title'          => __('Wowsome Theme Options', 'wowsome')
	));
	global $wowsome_settings, $wowsome_array_of_default_settings;
	$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults());

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/********************Wowsome Upgrade ******************************************/
	$wp_customize->add_section('wowsome_upgrade', array(
		'title'					=> __('Wowsome Support', 'wowsome'),
		'priority'				=> 500,
	));
	$wp_customize->add_setting( 'wowsome_theme_settings[wowsome_upgrade]', array(
		'default'				=> false,
		'capability'			=> 'edit_theme_options',
		'sanitize_callback'	=> 'wp_filter_nohtml_kses',
	));
	$wp_customize->add_control(
		new Wowsome_Customize_Wowsome_upgrade(
		$wp_customize,
		'wowsome_upgrade',
			array(
				'label'					=> __('Wowsome Upgrade','wowsome'),
				'section'				=> 'wowsome_upgrade',
				'settings'				=> 'wowsome_theme_settings[wowsome_upgrade]',
			)
		)
	);
	/******************** Layout Options ******************************************/
	$wp_customize->add_section('wowsome_layout_options', array(
		'title'					=> __('Layout Options', 'wowsome'),
		'priority'				=> 10,
		'panel'					=>'wowsome_theme_settings'
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_design_layout]', array(
		'default'				=> 'on',
		'sanitize_callback'	=> 'wowsome_sanitize_choices',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('wowsome_theme_settings[wowsome_design_layout]', array(
		'label'					=> __('Site Layout','wowsome'),
		'section'				=> 'wowsome_layout_options',
		'settings'				=> 'wowsome_theme_settings[wowsome_design_layout]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'on'					=> __('Wide Layout','wowsome'),
			'off'					=> __('Narrow Layout','wowsome'),
		),
	));
	/******************** Content Layout ******************************************/
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_content_layout]', array(
		'default'				=> 'right',
		'sanitize_callback'	=> 'wowsome_sanitize_choices',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('wowsome_theme_settings[wowsome_content_layout]', array(
		'label'					=> __('Content Layout','wowsome'),
		'description'			=> __('Below options are global setting. Set individual layout from specific page/ post.','wowsome'),
		'section'				=> 'wowsome_layout_options',
		'settings'				=> 'wowsome_theme_settings[wowsome_content_layout]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'right'				=> __('Right Sidebar','wowsome'),
			'left'				=> __('Left Sidebar','wowsome'),
			'nosidebar'			=> __('No Sidebar','wowsome'),
			'fullwidth'			=> __('No Sidebar Full Width','wowsome'),
		),
	));
	/******************** Header Options******************************************/
	$wp_customize->add_section('wowsome_custom_header_setting', array(
		'title'					=> __('Header Options', 'wowsome'),
		'priority'				=> 20,
		'panel'					=>'wowsome_theme_settings'
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_hide_search]', array(
		'default'					=>0,
		'sanitize_callback'		=>'wowsome_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'wowsome_theme_settings[wowsome_hide_search]', array(
		'priority'					=>70,
		'label'						=> __('Hide Search Icon', 'wowsome'),
		'section'					=> 'wowsome_custom_header_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_hide_search]',
		'type'						=> 'checkbox',
	));
	/********************Contact Info Bar ******************************************/
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_phone_no]', array(
		'default'					=>'',
		'sanitize_callback'		=> 'wowsome_sanitize_phone',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('wowsome_theme_settings[wowsome_phone_no]', array(
		'priority'					=>20,
		'label'						=> __('Contact Info Bar', 'wowsome'),
		'description'				=> __('Enter Phone Number Only', 'wowsome'),
		'section'					=> 'wowsome_custom_header_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_phone_no]',
		'type'						=> 'text',
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_email_id]', array(
		'default'					=>'',
		'sanitize_callback'		=> 'sanitize_email',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('wowsome_theme_settings[wowsome_email_id]', array(
		'priority'					=>30,
		'description'				=> __('Email Address Only', 'wowsome'),
		'section'					=> 'wowsome_custom_header_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_email_id]',
		'type'						=> 'text',
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_location]', array(
		'default'					=>'',
		'sanitize_callback'		=> 'sanitize_text_field',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('wowsome_theme_settings[wowsome_location]', array(
		'priority'					=>40,
		'description'				=> __('Location Only', 'wowsome'),
		'section'					=> 'wowsome_custom_header_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_location]',
		'type'						=> 'text',
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_location_url]', array(
		'default'					=>'',
		'sanitize_callback'		=> 'esc_url_raw',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('wowsome_theme_settings[wowsome_location_url]', array(
		'priority'					=>50,
		'description'				=> __('Location Url Only', 'wowsome'),
		'section'					=> 'wowsome_custom_header_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_location_url]',
		'type'						=> 'text',
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_skype]', array(
		'default'					=>'',
		'sanitize_callback'		=> 'sanitize_text_field',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('wowsome_theme_settings[wowsome_skype]', array(
		'priority'					=>60,
		'description'				=> __('Skype ID Only', 'wowsome'),
		'section'					=> 'wowsome_custom_header_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_skype]',
		'type'						=> 'text',
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_contact_info_bar_top]', array(
		'default'					=>0,
		'sanitize_callback'		=>'wowsome_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'wowsome_theme_settings[wowsome_contact_info_bar_top]', array(
		'priority'					=>90,
		'label'						=> __('Disable Info Bar', 'wowsome'),
		'section'					=> 'wowsome_custom_header_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_contact_info_bar_top]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_infobar_socialprofiles]', array(
		'default'				=> 0,
		'sanitize_callback'	=> 'wowsome_sanitize_integer',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('wowsome_theme_settings[wowsome_infobar_socialprofiles]', array(
		'priority'				=>80,
		'label'					=> __('Disable Social Profiles from Info Bar','wowsome'),
		'section'				=> 'wowsome_custom_header_setting',
		'settings'				=> 'wowsome_theme_settings[wowsome_infobar_socialprofiles]',
		'type'					=> 'checkbox',
	));
	/******************** Home Page Blog Category Setting ******************************************/
	$wp_customize->add_section(
		'wowsome_category_section', array(
		'title' 						=> __('Home Page Blog Category Setting','wowsome'),
		'description'				=> __('Only posts that belong to the categories selected here will be displayed on the front page. ( You may select multiple categories by holding down the Ctrl/Command key. ) ','wowsome'),
		'priority'					=> 160,
		'panel'					=>'wowsome_theme_settings'
	));
	$wp_customize->add_setting( 'wowsome_theme_settings[wowsome_categories]', array(
		'default'					=>array(),
		'sanitize_callback'		=> 'wowsome_sanitize_category',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control(
		new Wowsome_Customize_Category_Control(
		$wp_customize,
			'wowsome_theme_settings[wowsome_categories]',
			array(
			'label'					=> __('Front page posts categories','wowsome'),
			'section'				=> 'wowsome_category_section',
			'settings'				=> 'wowsome_theme_settings[wowsome_categories]',
			'type'					=> 'multiple-select',
			)
		)
	);
	$wp_customize->add_setting( 'wowsome_theme_settings[wowsome_disable_setting]', array(
		'default'					=> 0,
		'sanitize_callback'		=> 'wowsome_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'wowsome_theme_settings[wowsome_disable_setting]', array(
		'label'						=> __('Check to Default Settings', 'wowsome'),
		'section'					=> 'wowsome_category_section',
		'settings'					=> 'wowsome_theme_settings[wowsome_disable_setting]',
		'type'						=> 'checkbox',
	));

	/******************** Featured Slider Options ******************************************************/
	$wp_customize->add_section( 'wowsome_slider_options_setting', array(
		'title'					=> __('Featured Slider Options', 'wowsome'),
		'priority'				=> 100,
		'panel'					=>'wowsome_theme_settings'
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_slider_quantity]', array(
		'default'					=> '4',
		'sanitize_callback'		=> 'wowsome_sanitize_delay_transition',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('wowsome_theme_settings[wowsome_slider_quantity]', array(
		'priority'					=>10,
		'label'						=> __('Number of Slides', 'wowsome'),
		'section'					=> 'wowsome_slider_options_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_slider_quantity]',
		'type'						=> 'text',
	) );
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_transition_effect]', array(
		'default'					=> 'fade',
		'sanitize_callback'		=> 'wowsome_sanitize_effect',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('wowsome_theme_settings[wowsome_transition_effect]', array(
		'priority'					=>20,
		'label'						=> __('Transition Effect', 'wowsome'),
		'section'					=> 'wowsome_slider_options_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_transition_effect]',
		'type'						=> 'select',
		'choices'					=> array(
			'fade'					=> __('Fade','wowsome'),
			'wipe'					=> __('Wipe','wowsome'),
			'scrollUp'				=> __('Scroll Up','wowsome' ),
			'scrollDown'			=> __('Scroll Down','wowsome' ),
			'scrollLeft'			=> __('Scroll Left','wowsome' ),
			'scrollRight'			=> __('Scroll Right','wowsome' ),
			'blindX'					=> __('Blind X','wowsome' ),
			'blindY'					=> __('Blind Y','wowsome' ),
			'blindZ'					=> __('Blind Z','wowsome' ),
			'cover'					=> __('Cover','wowsome' ),
			'shuffle'				=> __('Shuffle','wowsome' ),
		),
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_transition_delay]', array(
		'default'					=> '4',
		'sanitize_callback'		=> 'wowsome_sanitize_delay_transition',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('wowsome_theme_settings[wowsome_transition_delay]', array(
		'priority'					=>30,
		'label'						=> __('Transition Delay', 'wowsome'),
		'section'					=> 'wowsome_slider_options_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_transition_delay]',
		'type'						=> 'text',
	) );
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_transition_duration]', array(
		'default'					=> '1',
		'sanitize_callback'		=> 'wowsome_sanitize_delay_transition',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('wowsome_theme_settings[wowsome_transition_duration]', array(
		'priority'					=>40,
		'label'						=> __('Transition Length', 'wowsome'),
		'section'					=> 'wowsome_slider_options_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_transition_duration]',
		'type'						=> 'text',
	) );
	// featured post
	$wp_customize->add_section( 'wowsome_page_post_slider', array(
		'title' 						=> __('Post Slider Options','wowsome'),
		'priority'					=> 105,
		'panel'					=>'wowsome_theme_settings'
	));
	for ( $i=1; $i <= $wowsome_settings['wowsome_slider_quantity'] ; $i++ ) {
		$wp_customize->add_setting('wowsome_theme_settings[wowsome_featured_post_slider]['. $i.']', array(
			'default'					=>'',
			'sanitize_callback'		=>'wowsome_sanitize_integer',
			'type' 						=> 'option',
			'capability' 				=> 'manage_options'
		));
		$wp_customize->add_control( 'wowsome_theme_settings[wowsome_featured_post_slider]['. $i.']', array(
			'priority'					=> 10 . $i,
			'label'						=> __(' Enter Post ID #', 'wowsome') . $i ,
			'section'					=> 'wowsome_page_post_slider',
			'settings'					=> 'wowsome_theme_settings[wowsome_featured_post_slider]['. $i.']',
			'type'						=> 'text',
		));
	}
	$wp_customize->add_setting( 'wowsome_theme_settings[wowsome_disable_slider]', array(
		'default'					=> 1,
		'sanitize_callback'		=> 'wowsome_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'wowsome_theme_settings[wowsome_disable_slider]', array(
		'priority'					=>50,
		'label'						=> __('Disable Slider', 'wowsome'),
		'section'					=> 'wowsome_slider_options_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_disable_slider]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_exclude_slider_post]', array(
		'default'					=>0,
		'sanitize_callback'		=>'wowsome_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'wowsome_theme_settings[wowsome_exclude_slider_post]', array(
		'priority'					=>60,
		'label'						=> __('Check to exclude', 'wowsome'),
		'description'				=>__('Exclude Slider post from Homepage posts?','wowsome'),
		'section'					=> 'wowsome_slider_options_setting',
		'settings'					=> 'wowsome_theme_settings[wowsome_exclude_slider_post]',
		'type'						=> 'checkbox',
	));
	/******************** Footer section ******************************************/
	$wp_customize->add_section('wowsome_footer_section', array(
		'title'					=> __('Footer Options', 'wowsome'),
		'priority'				=> 490,
		'panel'					=>'wowsome_theme_settings'
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_hide_sitetitle]', array(
		'default'					=>0,
		'sanitize_callback'		=>'wowsome_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'wowsome_hide_sitetitle', array(
		'priority'					=>10,
		'label'						=> __('Hide Site Title', 'wowsome'),
		'section'					=> 'wowsome_footer_section',
		'settings'					=> 'wowsome_theme_settings[wowsome_hide_sitetitle]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('wowsome_theme_settings[wowsome_copyright_social_display]', array(
		'default'					=>0,
		'sanitize_callback'		=>'wowsome_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'wowsome_copyright_social_display', array(
		'priority'					=>20,
		'label'						=> __('Copyright Info/ Social Profile display side by side', 'wowsome'),
		'section'					=> 'wowsome_footer_section',
		'settings'					=> 'wowsome_theme_settings[wowsome_copyright_social_display]',
		'type'						=> 'checkbox',
	));
}
/******************** Sanitize the values ******************************************/
function wowsome_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $setting->id );
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}
function wowsome_sanitize_integer( $input) {
    return absint($input);
}
function wowsome_sanitize_effect( $input ) {
	if ( ! in_array( $input, array( 'fade', 'wipe', 'scrollUp', 'scrollDown', 'scrollLeft', 'scrollRight', 'blindX', 'blindY', 'blindZ', 'cover', 'shuffle' ) ) ) {
		$input = 'fade';
	}
	return $input;
}
function wowsome_sanitize_delay_transition( $input ) {
	if(is_numeric($input)){
	return $input;
	}
}
function wowsome_sanitize_category( $input ) {
	if ( $input != '' ) {
		$args = array(
						'type'			=> 'post',
						'child_of'      => 0,
						'parent'        => '',
						'orderby'       => 'name',
						'order'         => 'ASC',
						'hide_empty'    => 0,
						'hierarchical'  => 0,
						'taxonomy'      => 'category',
					); 
		
		$wowsome_categories = ( get_categories( $args ) );

		$category_list 	=	array();
		
		foreach ( $wowsome_categories as $category )
			$category_list 	=	array_merge( $category_list, array( $category->term_id ) );

		if ( count( array_intersect( $input, $category_list ) ) == count( $input ) ) {
	    	return $input;
	    } 
	    else {
    		return '';
   		}
    }
    else {
    	return '';
    }
}
function wowsome_sanitize_phone( $input ) {
	$input =  preg_replace("/[^() 0-9+-]/", '', $input);
	return $input;
}
function wowsome_customizer_control_scripts() {

	wp_enqueue_style( 'wowsome-customize-controls',
	 get_template_directory_uri() . '/inc/customize-controls.css' );

}

add_action( 'customize_controls_enqueue_scripts', 'wowsome_customizer_control_scripts', 0 );
add_action('customize_register', 'wowsome_textarea_register');
add_action( 'customize_register', 'wowsome_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wowsome_customize_preview_js() {
	wp_enqueue_script( 'wowsome_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'wowsome_customize_preview_js' );
