<?php
/**
 * elexis Theme Customizer
 *
 * @package elexis
 */

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
		$wp_customize->get_setting( 'elexis_theme_fonts_options' )->transport = 'refresh';

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

		$wp_customize->add_setting( 'elexis_container_type', array(
			'default'           => 'container',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'elexis_theme_slug_sanitize_select',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'elexis_container_type', array(
					'label'       => __( 'Container Width', 'elexis' ),
					'description' => __( "Choose between Bootstrap's container and container-fluid", 'elexis' ),
					'section'     => 'elexis_theme_layout_options',
					'settings'    => 'elexis_container_type',
					'type'        => 'select',
					'choices'     => array(
						'container'       => __( 'Fixed width container', 'elexis' ),
						'container-fluid' => __( 'Full width container', 'elexis' ),
					),
					'priority'    => '10',
				)
			) );

		$wp_customize->add_setting( 'elexis_sidebar_position', array(
			'default'           => 'right',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'capability'        => 'edit_theme_options',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'elexis_sidebar_position', array(
					'label'       => __( 'Sidebar Positioning', 'elexis' ),
					'description' => __( "Set sidebar's default position. Can either be: right, left, both or none. Note: this can be overridden on individual pages.",
					'elexis' ),
					'section'     => 'elexis_theme_layout_options',
					'settings'    => 'elexis_sidebar_position',
					'type'        => 'select',
					'sanitize_callback' => 'elexis_theme_slug_sanitize_select',
					'choices'     => array(
						'right' => __( 'Right sidebar', 'elexis' ),
						'left'  => __( 'Left sidebar', 'elexis' ),
						'both'  => __( 'Left & Right sidebars', 'elexis' ),
						'none'  => __( 'No sidebar', 'elexis' ),
					),
					'priority'    => '20',
				)
			) );

    require_once( 'customizer-controls/google-font-dropdown-custom-control.php' );

		// Theme fonts.
		$wp_customize->add_section( 'elexis_theme_fonts_options', array(
			'title'       => __( 'Fonts', 'elexis' ),
			'capability'  => 'edit_theme_options',
			'description' => __( 'Select the fonts for your website.', 'elexis' ),
			'priority'    => 40,
		) );
	
		$wp_customize->add_setting( 'elexis_heading_font_family', array(
			'default'           => 'Roboto',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'capability'        => 'edit_theme_options',
		) );
	
  	$wp_customize->add_control(
  		new Google_Font_Dropdown_Custom_Control(
  			$wp_customize, 'control_heading_font_family', array(
  				'label'       => __( 'Font Family for Headings', 'elexis' ),
  				'section'     => 'elexis_theme_fonts_options',
  				'settings'    => 'elexis_heading_font_family',
  				'input_attrs' => array('font_property' => 'family'),
  				'description' => __( 'Select a Google Font from the list.', 'elexis' ),
  			)
  		)
  	);

		$wp_customize->add_setting( 'elexis_heading_font_weight', array(
			'default'           => '500',
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'capability'        => 'edit_theme_options',
		) );
	
  	$wp_customize->add_control(
  		new Google_Font_Dropdown_Custom_Control(
  			$wp_customize, 'control_heading_font_weight', array(
  				'label'       => __( 'Font Weight for Headings', 'elexis' ),
  				'section'     => 'elexis_theme_fonts_options',
  				'settings'    => 'elexis_heading_font_weight',
  				'input_attrs' => array('font_property' => 'variants'),
  				'description' => __( 'Define a weight for your selected font.', 'elexis' ),
  			)
  		)
  	);








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
