<?php
/**
 /**
 * Register widget area and Sidebar.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @package Wowsome
 */
/****************************************************************************************/

add_action('widgets_init', 'wowsome_widgets_init');
/**
 * Function to register the widget areas(sidebar) and widgets.
 */
function wowsome_widgets_init()
{
	// Registering main left sidebar
	register_sidebar(array(
		'name' => __('Left Sidebar', 'wowsome') ,
		'id' => 'wowsome_left_sidebar',
		'description' => __('Shows widgets at Left side.', 'wowsome') ,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	// Registering main right sidebar
	register_sidebar(array(
		'name' => __('Right Sidebar', 'wowsome') ,
		'id' => 'wowsome_right_sidebar',
		'description' => __('Shows widgets at Right side.', 'wowsome') ,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	// Registering Business Template Section
	register_sidebar(array(
		'name' => __('Business Template Section', 'wowsome') ,
		'id' => 'wowsome_business_template',
		'description' => __('Shows widgets on Business Template Page.', 'wowsome') ,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));

	// Registering footer sidebar 1
	register_sidebar(array(
		'name' => __('Footer - Column1', 'wowsome') ,
		'id' => 'wowsome_footer_sidebar',
		'description' => __('Shows widgets at footer Column 1.', 'wowsome') ,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	// Registering footer sidebar 2
	register_sidebar(array(
		'name' => __('Footer - Column2', 'wowsome') ,
		'id' => 'wowsome_footer_column2',
		'description' => __('Shows widgets at footer Column 2.', 'wowsome') ,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	// Registering footer sidebar 3
	register_sidebar(array(
		'name' => __('Footer - Column3', 'wowsome') ,
		'id' => 'wowsome_footer_column3',
		'description' => __('Shows widgets at footer Column 3.', 'wowsome') ,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	
	// Registering footer sidebar 4
	register_sidebar(array(
		'name' => __('Footer - Column4', 'wowsome') ,
		'id' => 'wowsome_footer_column4',
		'description' => __('Shows widgets at footer Column 4.', 'wowsome') ,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	// Registering widgets
	register_widget("wowsome_service_widget");
	register_widget("wowsome_ourclient_widget");
}

/****************************************************************************************/
/**
 * Widget for business layout that shows selected page content,title and featured image.
 * Construct the widget.
 * i.e. Name, description and control options.
 */
class wowsome_service_widget extends WP_Widget

{
	function __construct()
	{
		$widget_ops = array(
			'classname' => 'widget_services clearfix',
			'description' => __('Display Services', 'wowsome')
		);
		$control_ops = array(
			'width' => 200,
			'height' => 250
		);
		parent::__construct(false, $name = __('TH: Services', 'wowsome') , $widget_ops, $control_ops);
	}
	function form($instance)
	{
		$instance = wp_parse_args((array) $instance, array( 'icon_no1' =>'', 'icon_no2' =>'', 'icon_no3' =>'', 'icon_no4' =>'', 'icon_no5' =>'', 'icon_no6' =>'','page_id1'=>'','page_id2'=>'','page_id3'=>'', 'page_id4'=>'', 'page_id5'=>'', 'page_id6'=>'', 'service_button_text'=>'','service_title'=>'', 'service_content'=>'', 'service_button_link'=>''));
		for ($i = 1; $i <= 6; $i++) {
			$var = 'page_id' . $i;
			$icon_no  = 'icon_no'.$i;
			$defaults[$var] = '';
			$instance[ $icon_no ] = strip_tags( $instance[ $icon_no ] );
		}
		$service_title = strip_tags($instance['service_title']);
		$service_content = esc_textarea($instance['service_content']);
		$service_button_text = strip_tags($instance['service_button_text']);
		$service_button_link = esc_url($instance['service_button_link']);
		$display_design = ( isset( $instance['display_design'] ) && is_numeric( $instance['display_design'] ) ) ? (int) $instance['display_design'] : 1;
		$service_align = ( isset( $instance['service_align'] ) && is_numeric( $instance['service_align'] ) ) ? (int) $instance['service_align'] : 1; ?>
		<p>
			<legend><strong><?php _e('Select Design:','wowsome');?></strong></legend>
			<i> <?php _e('Click on Save button after you change the design below. Make sure some previous settings will be reset while changing the design. ','wowsome'); ?></i> <br><br>
			<input type="radio" id="<?php echo ($this->get_field_id( 'display_design' ) . '-1') ?>" name="<?php echo ($this->get_field_name( 'display_design' )) ?>" value="1" <?php checked( $display_design == 1, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'display_design' ) . '-1' ) ?>"><?php _e('Page with Icon/ Featured Image', 'wowsome') ?></label> <br>
			<input type="radio" id="<?php echo ($this->get_field_id( 'display_design' ) . '-2') ?>" name="<?php echo ($this->get_field_name( 'display_design' )) ?>" value="2" <?php checked( $display_design == 2, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'display_design' ) . '-2' ) ?>"><?php _e('Page with Featured Image', 'wowsome') ?></label><br>
			<input type="radio" id="<?php echo ($this->get_field_id( 'display_design' ) . '-3') ?>" name="<?php echo ($this->get_field_name( 'display_design' )) ?>" value="3" <?php checked( $display_design == 3, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'display_design' ) . '-3' ) ?>"><?php _e('Promotional Bar', 'wowsome') ?></label>
		</p>
		<p>
			<legend><strong><?php _e('Display Content Align:','wowsome');?></strong></legend>
			<input type="radio" id="<?php echo ($this->get_field_id( 'service_align' ) . '-1') ?>" name="<?php echo ($this->get_field_name( 'service_align' )) ?>" value="1" <?php checked( $service_align == 1, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'service_align' ) . '-1' ) ?>"><?php _e('Left Align', 'wowsome') ?></label> &nbsp;&nbsp;
			<input type="radio" id="<?php echo ($this->get_field_id( 'service_align' ) . '-2') ?>" name="<?php echo ($this->get_field_name( 'service_align' )) ?>" value="2" <?php checked( $service_align == 2, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'service_align' ) . '-2' ) ?>"><?php _e('Center Align', 'wowsome') ?></label> &nbsp;&nbsp;
		</p>
		<hr>
		<p>
			<label for="<?php echo $this->get_field_id('service_title'); ?>">
				<?php _e('Title:', 'wowsome'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('service_title'); ?>" name="<?php echo $this->get_field_name('service_title'); ?>" type="text" value="<?php echo esc_attr($service_title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('service_content'); ?>">
				<?php _e('Content:', 'wowsome'); ?>
			</label>
			<textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('service_content'); ?>" name="<?php echo $this->get_field_name('service_content'); ?>"><?php echo esc_attr($service_content);?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('service_button_text'); ?>">
				<?php _e('Button Text:', 'wowsome'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('service_button_text'); ?>" name="<?php echo $this->get_field_name('service_button_text'); ?>" type="text" value="<?php echo esc_attr($service_button_text); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('service_button_link'); ?>">
				<?php _e('Button Link:', 'wowsome'); ?>
			</label>
			<input id="<?php echo $this->get_field_id('service_button_link'); ?>" name="<?php echo $this->get_field_name('service_button_link'); ?>" type="text" value="<?php echo esc_url($service_button_link); ?>" />
		</p>
		<hr>
		<?php $instance = wp_parse_args((array)$instance, $defaults);
		if($display_design !=3 ){
			for ($i = 1; $i <= 6; $i++) {
			$var = 'page_id' . $i;
			$icon_no  = 'icon_no'.$i;
			$var = absint($instance[$var]);
			$instance[ $icon_no ] = strip_tags( $instance[ $icon_no ] );
			if($display_design ==1 ){ ?>
				<p>
					<label for="<?php echo $this->get_field_id('name'); ?>">
						<?php _e( 'Font Awesome Icon class: ', 'wowsome' ); ?>
					</label>
					<input id="<?php echo $this->get_field_id($icon_no); ?>" name="<?php echo $this->get_field_name($icon_no); ?>" type="text" value="<?php if(isset ( $instance[$icon_no] ) ) echo esc_attr( $instance[$icon_no] ); ?>" />
				</p>
			<?php } ?>
				<p>
					<label for="<?php echo $this->get_field_id(key($defaults)); ?>">
						<?php _e('Page', 'wowsome'); ?>
					:</label>
						<?php wp_dropdown_pages(array(
									'show_option_none' => ' ',
									'name' => $this->get_field_name(key($defaults)) ,
									'selected' => $instance[key($defaults) ]
								)); ?>
				</p>
				<hr>
			<?php next($defaults); // forwards the key of $defaults array
			}
		}
	}
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['display_design'] = ( isset( $new_instance['display_design'] ) && $new_instance['display_design'] > 0 && $new_instance['display_design'] <= 3 ) ? (int) $new_instance['display_design'] : 0;
		$instance['service_align'] = ( isset( $new_instance['service_align'] ) && $new_instance['service_align'] > 0 && $new_instance['service_align'] <= 2 ) ? (int) $new_instance['service_align'] : 0;
		$instance['number'] = absint( $new_instance['number'] );
		$instance['service_title'] = strip_tags($new_instance['service_title']);
		$instance['service_content'] = esc_attr($new_instance['service_content']);
		$instance['service_button_text'] = strip_tags($new_instance['service_button_text']);
		$instance['service_button_link'] = esc_url($new_instance['service_button_link']);
		for ($i = 1; $i <=6; $i++) {
			$var = 'page_id' . $i;
			$icon_no  = 'icon_no'.$i;
			$instance[$var] = absint($new_instance[$var]);
			$instance[ $icon_no ] = strip_tags( $new_instance[ $icon_no ] );
		}
		return $instance;
	}
	function widget($args, $instance)
	{
		extract($args);
		extract($instance);
		$service_title = empty( $instance['service_title'] ) ? '' : $instance['service_title'];
		$service_content = apply_filters('service_content', empty($instance['service_content']) ? '' : $instance['service_content'], $instance, $this->id_base);
		$service_button_text = empty( $instance['service_button_text'] ) ? '' : $instance['service_button_text'];
		$service_button_link = empty( $instance['service_button_link'] ) ? '' : $instance['service_button_link'];
		global $post;
		global $wowsome_settings, $array_of_default_settings;
		$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults() );
		$page_array = array();
		$icon_array = array();
		for ($i = 1; $i <= 6; $i++) {
			$var = 'page_id' . $i;
			$icon_no  = 'icon_no'.$i;
			$page_id = isset($instance[$var]) ? $instance[$var] : '';
			$icon_no = isset( $instance[ $icon_no ] ) ? $instance[ $icon_no ] : '';
			if( !empty( $icon_no ) || !empty($page_id) ){
				if( !empty( $icon_no )){
						array_push( $icon_array, $icon_no ); // Push the page id in the array
					} else { 
						array_push($icon_array, "");
					}
				if (!empty($page_id)) {
					array_push($page_array, $page_id);
				}
			}
			// Push the page id in the array
		}
		$get_featured_pages = new WP_Query(array(
			'posts_per_page' => - 1,
			'post_type' => array(
				'page'
			) ,
			'post__in' => $page_array,
			'orderby' => 'post__in'
		));
		echo $before_widget; ?>
		<div class="<?php if($display_design == 1){ echo 'design_a'; } elseif($display_design == 2){ echo 'design_b'; }else{ echo 'design_c'; }  if($service_align == 2){ echo ' align-center'; }?>">
			<div class="container clearfix">
			<?php if(!empty($service_title) || ($service_content) ){ ?>
				<div class="widget-branding clearfix">
				<?php if(!empty($service_title)){ ?>
					<h2 class="widget-title"><?php echo esc_attr($service_title);?></h2>
					<?php }
					if(!empty($service_content)){ ?>
					<p class="widget-desc"><?php echo esc_attr($service_content);?> </p>
					<?php }
					if(!empty($service_content)){ ?>
					<a class="readmore" href="<?php echo esc_url($service_button_link); ?>" title="Readmore"><?php echo esc_attr($service_button_text); ?></a>
					<?php } ?>
				</div><!-- .widget-branding -->
				<?php } 
				if($display_design != 3){?>
					<div class="column-area column-third clearfix">
						<?php
						$j = 1; 
						$i=0; // array value starts from 0
 						$service_class='';
		 				while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();
		 					if( $j % 12 == 1 && $j > 2) {
		 						$service_class = "clearfix-half clearfix-third clearfix-fourth";
		 					}elseif( $j % 6 == 1 && $j > 2) {
		 						$service_class = "clearfix-half clearfix-third";
		 					}elseif($j % 4 == 1 && $j > 2) {
	 							$service_class = "clearfix-half clearfix-fourth";
			 				}elseif( $j % 3 == 1 && $j > 2) {
		 						$service_class = "clearfix-third";
		 					}elseif( $j % 2 == 1 && $j > 2) {
		 						$service_class = "clearfix-half";
		 					}else{
		 						$service_class = "";
		 					} ?>
							<div class="column-item <?php echo $service_class; ?>">
							<?php
							if(has_post_thumbnail() ){ ?>
								<a title="<?php the_title_attribute(); ?>" class="item-image" href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail(); ?>
								</a><!-- .item-image -->
							<?php }elseif( $display_design == 1 && !empty($icon_array[$i])){ ?>
								<a title="<?php the_title_attribute(); ?>" class="item-image" href="<?php the_permalink(); ?>">
								<i class="fa <?php echo esc_attr($icon_array[$i]);?>" aria-hidden="true"></i>
								</a><!-- .item-image -->
							<?php }
								if($display_design == 1) { ?>
									<h3 class="item-title"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<?php the_excerpt();
									if(strlen(get_the_content()) > strlen(get_the_excerpt()) ){
									?>
										<a title="<?php esc_html_e('Read More','wowsome'); ?>" href="<?php the_permalink();?>" class="more-link"><?php esc_html_e('Read More','wowsome');?> </a>
									<?php }
									} elseif($display_design == 2) { ?>
									<div class="item-wrap">
									<h3 class="item-title"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<?php the_excerpt(); ?>
									</div><!-- .item-wrap -->
								<?php } ?>
							</div><!-- .column-item -->
						<?php $i++;
						$j++;
						endwhile;
						// Reset Post Data
						wp_reset_postdata(); ?>
					</div><!-- .column-area -->
				<?php } ?>
			</div><!-- .container -->
		</div>
	<?php echo $after_widget.'<!-- .widget_service -->';
	}
}

/****************************************************************************************/
/**
 * Widget for business layout that shows selected page content,title and featured image.
 * Construct the widget.
 * i.e. Name, description and control options.
 */
class wowsome_ourclient_widget extends WP_Widget

{
	function __construct()
	{
		$widget_ops = array(
			'classname' => 'widget_ourclients',
			'description' => __('Display Our Clients', 'wowsome')
		);
		$control_ops = array(
			'width' => 200,
			'height' => 250
		);
		parent::__construct(false, $name = __('TH: Our Clients', 'wowsome') , $widget_ops, $control_ops);
	}
	function form($instance)
	{
		$instance = wp_parse_args((array) $instance, array( 'page_id1'=>'','page_id2'=>'','page_id3'=>'', 'page_id4'=>'', 'page_id5'=>''));
		for ($i = 1; $i <= 5; $i++) {
			$var = 'page_id' . $i;
			$defaults[$var] = '';
		} ?>
		<?php $instance = wp_parse_args((array)$instance, $defaults);
		for ($i = 1; $i <= 5; $i++) {
			$var = 'page_id' . $i;
			$var = absint($instance[$var]); ?>
				<p>
					<label for="<?php echo $this->get_field_id(key($defaults)); ?>">
						<?php _e('Page', 'wowsome'); ?>
					:</label>
						<?php wp_dropdown_pages(array(
									'show_option_none' => ' ',
									'name' => $this->get_field_name(key($defaults)) ,
									'selected' => $instance[key($defaults) ]
								)); ?>
				</p>
			<?php next($defaults); // forwards the key of $defaults array
			}
	}
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		for ($i = 1; $i <=5; $i++) {
			$var = 'page_id' . $i;
			$instance[$var] = absint($new_instance[$var]);
		}
		return $instance;
	}
	function widget($args, $instance)
	{
		extract($args);
		extract($instance);
		global $post;
		global $wowsome_settings, $array_of_default_settings;
		$wowsome_settings = wp_parse_args(  get_option( 'wowsome_theme_settings', array() ),  wowsome_get_option_defaults() );
		$page_array = array();
		for ($i = 1; $i <= 5; $i++) {
			$var = 'page_id' . $i;
			$page_id = isset($instance[$var]) ? $instance[$var] : '';
				if (!empty($page_id)) {
					array_push($page_array, $page_id);
				}
			// Push the page id in the array
		}
		$get_featured_pages = new WP_Query(array(
			'posts_per_page' => - 1,
			'post_type' => array(
				'page'
			) ,
			'post__in' => $page_array,
			'orderby' => 'post__in'
		));
		echo $before_widget; ?>
		<div class="container clearfix">
			<div class="owl-carousel clearfix">
				<?php while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();
					if(has_post_thumbnail() ){ ?>
						<a title="<?php the_title_attribute(); ?>" class="item-image" href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail(); ?>
						</a><!-- .item-image -->
					<?php }
				endwhile; ?>
			</div>
		</div>
		<?php // Reset Post Data
		wp_reset_postdata();
		echo $after_widget.'<!-- .widget_ourclients -->';
	}
}