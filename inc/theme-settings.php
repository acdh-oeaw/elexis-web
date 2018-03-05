<?php
/**
 * Check and setup theme's default settings
 *
 * @package elexis
 *
 */

if ( ! function_exists( 'elexis_setup_theme_default_settings' ) ) :
	function elexis_setup_theme_default_settings() {

		// check if settings are set, if not set defaults.
		// Caution: DO NOT check existence using === always check with == .
		// Latest blog posts style.
		$elexis_posts_index_style = get_theme_mod( 'elexis_posts_index_style' );
		if ( '' == $elexis_posts_index_style ) {
			set_theme_mod( 'elexis_posts_index_style', 'default' );
		}

		// Sidebar position.
		$elexis_sidebar_position = get_theme_mod( 'elexis_sidebar_position' );
		if ( '' == $elexis_sidebar_position ) {
			set_theme_mod( 'elexis_sidebar_position', 'right' );
		}

		// Container width.
		$elexis_container_type = get_theme_mod( 'elexis_container_type' );
		if ( '' == $elexis_container_type ) {
			set_theme_mod( 'elexis_container_type', 'container' );
		}
	}
endif;
