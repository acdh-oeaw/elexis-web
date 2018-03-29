<?php
/**
 * elexis Theme Customizer
 *
 * @package elexis
 */


/**
 * Remove unneeded sections from the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists( 'elexis_remove_customizer_settings' ) ) {
  function elexis_remove_customizer_settings( $wp_customize ){
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('background_image');
  }
}
add_action( 'customize_register', 'elexis_remove_customizer_settings', 20 );








/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists( 'elexis_customize_register' ) ) {
	/**
	 * Register basic customizer support.
	 *
	 * @param object $wp_customize Customizer reference.
	 */
	function elexis_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'elexis_customize_register' );

if ( ! function_exists( 'elexis_theme_customize_register' ) ) {
	/**
	 * Register individual settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function elexis_theme_customize_register( $wp_customize ) {

		// Theme layout settings.
		$wp_customize->add_section( 'elexis_theme_layout_options', array(
			'title'       => __( 'Theme Layout Settings', 'elexis' ),
			'capability'  => 'edit_theme_options',
			'description' => __( 'Container width and sidebar defaults', 'elexis' ),
			'priority'    => 160,
		) );

		 //select sanitization function
        function elexis_theme_slug_sanitize_select( $input, $setting ){
         
            //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
            $input = sanitize_key($input);
 
            //get the list of possible select options 
            $choices = $setting->manager->get_control( $setting->id )->choices;
                             
            //return input if valid or return default option
            return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
             
        }



	}
} // endif function_exists( 'elexis_theme_customize_register' ).
add_action( 'customize_register', 'elexis_theme_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if ( ! function_exists( 'elexis_customize_preview_js' ) ) {
	/**
	 * Setup JS integration for live previewing.
	 */
	function elexis_customize_preview_js() {
		wp_enqueue_script( 'elexis_customizer', get_template_directory_uri() . '/js/customizer.js',
			array( 'customize-preview' ), '20130508', true );
	}
}
add_action( 'customize_preview_init', 'elexis_customize_preview_js' );
