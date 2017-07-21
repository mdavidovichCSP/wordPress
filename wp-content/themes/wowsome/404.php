<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Wowsome
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="error-404 not-found">
				<header class="entry-header">
					<h2 class="entry-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'wowsome' ); ?></h2>
				</header><!-- .entry-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'wowsome' ); ?></p>

					<?php
						get_search_form();
					?>
				</div><!-- .page-content -->
			</div><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action('wowsome_main_sidebar_content');
get_footer();
