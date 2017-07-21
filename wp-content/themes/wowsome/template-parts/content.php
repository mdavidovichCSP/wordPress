<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Wowsome
 */

?>
<div <?php post_class(); ?>">
	<?php if ( has_post_thumbnail() && !is_single() ) { ?>
	<figure class="post-featured-image">
		<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
	</figure><!-- .post-featured-image -->
	<?php } ?>
	<div class="post-featured-content">
		<article>
		<?php if(!has_post_format( 'quote' )){  // for format quote ?>
			<header class="entry-header">
			<?php if(is_single()){ ?>
			<div class="entry-meta">
				<span class="cat-links">
					<?php the_category(', '); ?>
				</span><!-- .cat-links -->
			</div><!-- .entry-meta -->
			<?php
			}else{
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" >', '</a></h2><!-- .entry-title -->' );
			}
				if ( 'post' === get_post_type() ) :
					if(!has_post_format( 'link' )){ // for format link ?>
						<div class="entry-meta clearfix">
							<?php wowsome_posted_on(); ?>
						</div><!-- .entry-meta -->
					<?php }
				endif; ?>
			</header><!-- .entry-header -->
			<?php } ?>
			<div class="entry-content clearfix">
				<?php 
				if(is_single()){
					the_content();
					$tag_list = get_the_tag_list( '', __( ', ', 'wowsome' ) );
					 if( !empty( $tag_list ) ) {  ?>
						<footer class="entry-meta clearfix">
						<?php echo get_the_tag_list( sprintf( '<span class="tag-links"> '), ', ', '</span><!-- .tag-links -->' ); ?>
						</footer><!-- .entry-meta -->
					<?php }
				}else{
					if(!has_post_format( 'link' ) && !has_post_format( 'quote' )){ // for format link
						the_excerpt();
						if(get_the_excerpt() > get_the_content()){?>
							<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e('Read More','wowsome');?></a>
						<?php }
					}else{
						the_content();
					}
				} ?>
			</div><!-- .entry-content -->
			<?php wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wowsome' ),
								'after'  => '</div>',
							) ); ?>
		</article>
	</div>
</div><!-- .post -->
