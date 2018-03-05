<?php
/**
 * elexis enqueue scripts
 *
 * @package elexis
 */

if ( ! function_exists( 'elexis_scripts' ) ) {
	/**
	 * Load theme's JavaScript sources.
	 */
	function elexis_scripts() {
		// Get the theme data.
		$the_theme = wp_get_theme();

		wp_enqueue_style( 'theme-asset-styles', get_stylesheet_directory_uri() . '/css/assets.min.css', array(), $the_theme->get( 'Version' ), false );
		wp_enqueue_style( 'theme-styles', get_stylesheet_directory_uri() . '/style.css', array(), $the_theme->get( 'Version' ), false );
		wp_enqueue_script( 'jquery');
		wp_enqueue_script( 'theme-asset-scripts', get_template_directory_uri() . '/js/assets.min.js', array(), $the_theme->get( 'Version' ), true );
		wp_enqueue_script( 'theme-scripts', get_template_directory_uri() . '/js/theme.min.js', array(), $the_theme->get( 'Version' ), true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}
} // endif function_exists( 'elexis_scripts' ).

add_action( 'wp_enqueue_scripts', 'elexis_scripts' );
