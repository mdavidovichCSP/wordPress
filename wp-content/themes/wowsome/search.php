<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Wowsome
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="entry-header">
				<h2 class="entry-title"><?php printf( esc_html__( 'Search Results for: %s', 'wowsome' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
			</header><!-- .entry-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;
			if ( function_exists('wp_pagenavi' ) ) :
				wp_pagenavi();
			else: 
				the_posts_navigation();
			endif;

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action('wowsome_main_sidebar_content');
get_footer();
