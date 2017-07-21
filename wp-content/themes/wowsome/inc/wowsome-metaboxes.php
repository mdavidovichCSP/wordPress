<?php
/**
 * Wowsome Meta Boxes
 *
 * @package Wowsome
 */
// Add only to page and posts
add_action( 'add_meta_boxes_page', 'wowsome_metabox' );
add_action( 'add_meta_boxes_post', 'wowsome_metabox' );

/**
 * Add Meta Boxes.
 *
 */
function wowsome_metabox() {
	add_meta_box(
		'siderbar-layout',
		__( 'Below setting will not reflect on Main Blog Layout', 'wowsome' ),
		'wowsome_sidebar_layout'
	);
}

/**
 * Displays metabox to for sidebar layout
 */
function wowsome_sidebar_layout( $post ) {
	// Crea
	$sidebar_options = array(
	'default-sidebar' => array(
		'id'        => 'wowsome_sidebarlayout',
		'value'     => 'default',
		'label'     => __( 'Default Layout Set in Customizer', 'wowsome' ),
		),
	'no-sidebar' 				=> array(
		'id'    => 'wowsome_sidebarlayout',
		'value' => 'no-sidebar',
		'label' => __( 'No sidebar', 'wowsome' ),
		),
	'no-sidebar-full-width' => array(
		'id'    => 'wowsome_sidebarlayout',
		'value' => 'no-sidebar-full-width',
		'label' => __( 'No sidebar, Full Width', 'wowsome' ),
		),
	'left-sidebar' => array(
		'id'    => 'wowsome_sidebarlayout',
		'value' => 'left-sidebar',
		'label' => __( 'Left sidebar', 'wowsome' ),
		),
	'right-sidebar' => array(
		'id'    => 'wowsome_sidebarlayout',
		'value' => 'right-sidebar',
		'label' => __( 'Right sidebar', 'wowsome' ),
		),
	);

	// Use nonce for verification
	wp_nonce_field( basename( __FILE__ ), 'wowsome_metabox_check' );

	// Begin the field table and loop  ?>
	<table id="sidebar-metabox" class="form-table" width="100%">
		<tbody>
			<tr>
				<?php
				foreach ( $sidebar_options as $field ) {
					$meta = get_post_meta( $post->ID, 'wowsome_sidebarlayout', true );
					if ( empty( $meta ) ) {
						$meta = 'default';
					} ?>
			<td>
				<label class="description">
					<input type="radio" name="<?php echo esc_attr( $field['id'] ); ?>" value="<?php echo esc_attr( $field['value'] ); ?>" <?php checked( esc_attr( $field['value'] ), $meta ); ?>/>
					<?php echo esc_attr( $field['label'] ); ?>
				</label>
			</td>
				<?php
				} // End foreach(). ?>
			</tr>
		</tbody>
	</table>
<?php
}

add_action( 'save_post', 'wowsome_save_custom_meta', 10, 2 );
/**
 * save the custom metabox data
 * @hooked to save_post hook
 */
function wowsome_save_custom_meta( $post_id, $post ) {

	// Verify the nonce before proceeding.
	if ( ! isset( $_POST['wowsome_metabox_check'] ) || ! wp_verify_nonce( $_POST['wowsome_metabox_check'], basename( __FILE__ ) ) ) {
		return;
	}

	// Stop WP from clearing custom fields on autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// If user cannot edit posts/page we return.
	if ( ! current_user_can( 'edit_pages' )  || ! current_user_can( 'edit_posts' ) ) {
		return $post_id;
	}

	// Create a whitelist of accepted values.
	$options = array( 'default', 'no-sidebar', 'right-sidebar', 'left-sidebar', 'no-sidebar-full-width' );

	// We make sure there is something to save.
	if ( isset( $_POST['wowsome_sidebarlayout'] )
		&& ! empty( $_POST['wowsome_sidebarlayout'] )
		&& in_array( $_POST['wowsome_sidebarlayout'], $options, true ) ) {
		update_post_meta( $post_id, 'wowsome_sidebarlayout', $_POST['wowsome_sidebarlayout'] );
	}
}
