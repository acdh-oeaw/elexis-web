<?php
/**
 * elexis enqueue scripts
 *
 * @package elexis
 */

if ( ! function_exists( 'elexis_scripts' ) ) {

	/**
	 * Load theme's resources.
	 */
	function elexis_scripts() {
		// Get the theme data.
		$the_theme = wp_get_theme();

		wp_enqueue_style( 'theme-asset-styles', get_stylesheet_directory_uri() . '/css/assets.min.css', array(), $the_theme->get( 'Version' ), false );
		wp_enqueue_style( 'theme-styles', get_stylesheet_directory_uri() . '/style.css', array(), $the_theme->get( 'Version' ), false );
    wp_enqueue_style( 'theme-google-fonts', elexis_google_fonts(), array(), null );
		wp_enqueue_script( 'jquery');
		wp_enqueue_script( 'theme-asset-scripts', get_template_directory_uri() . '/js/assets.min.js', array(), $the_theme->get( 'Version' ), true );
		wp_enqueue_script( 'theme-scripts', get_template_directory_uri() . '/js/theme.min.js', array(), $the_theme->get( 'Version' ), true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}
} // endif function_exists( 'elexis_scripts' ).

	/**
	 * Function to load the selected Google fonts.
	 */
  function elexis_google_fonts() {
    $fonts_body = get_theme_mod( 'typography_body', array() );
    if ($fonts_body) {
      $font_body_family = $fonts_body['font-family'];
      $font_body_variant = $fonts_body['variant'];
      $fonts_embed[] = $font_body_family . ':' . $font_body_variant;
    }

    $fonts_heading = get_theme_mod( 'typography_heading', array() );
    if ($fonts_heading) {
      $font_heading_family = $fonts_heading['font-family'];
      $font_heading_variant = $fonts_heading['variant'];
      $fonts_embed[] = $font_heading_family . ':' . $font_heading_variant;
    }

    $fonts_article = get_theme_mod( 'typography_article', array() );
    if ($fonts_article) {
      $font_article_family = $fonts_article['font-family'];
      $font_article_variant = $fonts_article['variant'];
      $fonts_embed[] = $font_article_family . ':' . $font_article_variant . ',italic,bold';
    }

    if ($fonts_embed) {

    	$query_args = array(
    	  'family' => urlencode( implode( '|', $fonts_embed ) ),
        'subset' => urlencode( 'cyrillic,cyrillic-ext,devanagari,greek,greek-ext,khmer,latin,latin-ext,vietnamese,hebrew,arabic,bengali,gujarati,tamil,telugu,thai' ),
    	);
  
    	$embed_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    	 
    	return esc_url_raw( $embed_url );

    } else { return false; }

  }


add_action( 'wp_enqueue_scripts', 'elexis_scripts' );


