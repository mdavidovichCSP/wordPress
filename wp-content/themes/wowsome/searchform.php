<?php
/**
 * The template for displaying search form of the theme
 *
 *
 * @package Wowsome
 */
?>
	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="search-form clearfix">
		<label class="assistive-text"> <?php esc_html_e( 'Search', 'wowsome' ); ?> </label>
		<input type="search" placeholder="<?php esc_attr_e( 'Search', 'wowsome' ); ?>" class="s field" name="s">
		<input type="submit" value="<?php esc_attr_e('Search','wowsome'); ?>" class="search-submit">
	</form><!-- .search-form -->
