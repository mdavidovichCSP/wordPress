<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Wowsome
 */

?>

<div class="type-page">

	<?php if(is_front_page()){ ?>
	<header class="entry-header">
		<h2 class="entry-title"><?php the_title(); ?></h2>
	</header>
	<?php }
	?>

	<div class="entry-content">
		<?php
			the_content();
		?>
	</div><!-- .entry-content -->
	<?php wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wowsome' ),
				'after'  => '</div>',
			) ); ?>

</div><!-- .type-page -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'wowsome' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif;
