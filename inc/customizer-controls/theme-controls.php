<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Do not proceed if Kirki does not exist.
if ( ! class_exists( 'Kirki' ) ) {
	return;
}

/**
 * First of all, add the config.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/config.html
 */
Kirki::add_config(
	'elexis_options', array(
		'capability'  => 'edit_theme_options',
		'option_type' => 'theme_mod',
	)
);

/**
 * Add a panel.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/panels.html
 */
Kirki::add_panel(
	'elexis_options_panel', array(
		'priority'    => 10,
		'title'       => esc_attr__( 'Theme Options', 'elexis' ),
		'description' => esc_attr__( 'Contains all controls related to this theme.', 'elexis' ),
	)
);

/**
 * Add Sections.
 *
 * We'll be doing things a bit differently here, just to demonstrate an example.
 * We're going to define 1 section per control-type just to keep things clean and separate.
 *
 * @link https://aristath.github.io/kirki/docs/getting-started/sections.html
 */
$sections = array(
	'typography'      => array( esc_attr__( 'Typography', 'elexis' ), '' ),
	'navbar'      => array( esc_attr__( 'Top Navigation', 'elexis' ), '' ),
	'theme_layout'      => array( esc_attr__( 'Theme Layout', 'elexis' ), '' ),
	'content_blocks'      => array( esc_attr__( 'Content Blocks', 'elexis' ), '' ),
);
foreach ( $sections as $section_id => $section ) {
	$section_args = array(
		'title'       => $section[0],
		'description' => $section[1],
		'panel'       => 'elexis_options_panel',
	);
	if ( isset( $section[2] ) ) {
		$section_args['type'] = $section[2];
	}
	Kirki::add_section( str_replace( '-', '_', $section_id ) . '_section', $section_args );
}

/**
 * A proxy function. Automatically passes-on the config-id.
 *
 * @param array $args The field arguments.
 */
function my_config_kirki_add_field( $args ) {
	Kirki::add_field( 'elexis_options', $args );
}

/**
 * Body Typography Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'typography_body',
		'label'       => esc_attr__( 'Primary Font', 'elexis' ),
		'description' => esc_attr__( 'This is the main font which is used in all elements except headings and article content. It is often a sans-serif font with regular weight.', 'elexis' ),
		'section'     => 'typography_section',
		'priority'    => 10,
		'transport'   => 'refresh',
		'default'     => array(
			'font-family'     => 'Asap',
			'variant'         => '400',
			'color'           => '#212529',
		),
		'output'      => array(
			array(
				'element' => array( 'body' ),
			),
		),
		'choices' => array(
			'fonts' => array(
				'google' => array( 'alpha' ),
			),
		),
	)
);

/**
 * Heading Typography Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'typography_heading',
		'label'       => esc_attr__( 'Heading Font', 'elexis' ),
		'description' => esc_attr__( 'This is the font which is used in all headings. It is often a sans-serif font with semi-bold or bold weight.', 'elexis' ),
		'section'     => 'typography_section',
		'priority'    => 10,
		'transport'   => 'refresh',
		'default'     => array(
			'font-family'     => 'Asap',
			'variant'         => '600',
			'color'           => '#212529',
		),
		'output'      => array(
			array(
				'element' => array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', '.navbar-brand' ),
			),
		),
		'choices' => array(
			'fonts' => array(
				'google' => array( 'alpha' ),
			),
		),
	)
);

/**
 * Article Typography Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'typography',
		'settings'    => 'typography_article',
		'label'       => esc_attr__( 'Article Font', 'elexis' ),
		'description' => esc_attr__( 'This font is used in the actual content of single articles and comments. It is often a serif font with regular weight.', 'elexis' ),
		'section'     => 'typography_section',
		'priority'    => 10,
		'transport'   => 'refresh',
		'default'     => array(
			'font-family'     => 'Lora',
			'variant'         => '400',
			'color'           => '#212529',
			'font-size'       => '1.3rem',
			'line-height'     => '1.55',
		),
		'output'      => array(
			array(
				'element' => array( '.single article .entry-content' ),
			),
		),
		'choices' => array(
			'fonts' => array(
				'google' => array( 'alpha' ),
			),
		),
	)
);

/**
 * Navbar Logo Height
 */
my_config_kirki_add_field(
	array(
		'type'        => 'slider',
		'settings'    => 'navbar_logo_height',
		'label'       => esc_attr__( 'Navbar Logo Height', 'elexis' ),
		'description' => esc_attr__( 'Make your logo on the navigation bar bigger or smaller.', 'elexis' ),
		'section'     => 'navbar_section',
		'default'     => '2.5',
		'choices'     => array(
			'min'  => 2.5,
			'max'  => 6.0,
			'step' => 0.1,
			'suffix' => 'rem',
		),
		'output'      => array(
			array(
				'element' => array( '.navbar .navbar-brand' ),
        'property' => 'height',
        'units'    => 'rem',
			),
		),
		'transport'   => 'postMessage',
    'js_vars'     => array(
      array(
				'element' => array( '.navbar .navbar-brand' ),
        'property' => 'height',
        'units'    => 'rem',
      ),
    ),
	)
);

/**
 * Navbar Logo Height
 */
my_config_kirki_add_field(
	array(
		'type'        => 'dimensions',
		'settings'    => 'navbar_padding',
		'label'       => esc_attr__( 'Navbar Padding', 'elexis' ),
		'description' => esc_attr__( 'Define the padding of your top navigation bar.', 'elexis' ),
		'section'     => 'navbar_section',
		'default'     => array(
			'padding-top'    => '0.5rem',
			'padding-bottom' => '0.5rem',
			'padding-left'   => '1rem',
			'padding-right'  => '1rem',
		),
    'output'    => array(
    	array(
    		'element'         => array( '.navbar' ),
    		'property'        => '',
      ),
    ),
		'transport'   => 'postMessage',
    'js_vars'     => array(
      array(
    		'element'         => array( '.navbar' ),
    		'property'        => '',
      ),
    ),
	)
);

/**
 * Navbar Background Color
 */
my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'navbar_bg_color',
		'label'       => __( 'Navbar Background Color', 'elexis' ),
		'description' => esc_attr__( 'Define the background color of your top navigation bar.', 'elexis' ),
		'section'     => 'navbar_section',
		'default'     => '#fff',
		'choices'     => array(
			'alpha' => true,
		),
    'output'    => array(
    	array(
    		'element'         => array( '.navbar' ),
    		'property'        => 'background-color',
      ),
    ),
		'transport'   => 'postMessage',
    'js_vars'     => array(
      array(
    		'element'         => array( '.navbar' ),
    		'property'        => 'background-color',
      ),
    ),
	)
);

/**
 * Navbar Font Color Scheme
 */
my_config_kirki_add_field(
	array(
		'type'        => 'radio',
		'settings'    => 'navbar_color_scheme',
		'label'       => esc_attr__( 'Navbar Font Color Scheme', 'elexis' ),
		'description' => esc_attr__( 'Use the light navbar setting with a bright background color and the dark navbar with a dark background.', 'elexis' ),
		'section'     => 'navbar_section',
		'default'     => 'navbar-light',
		'choices'     => array(
			'navbar-light' => esc_attr__( 'Light Navbar', 'elexis' ),
			'navbar-dark' => esc_attr__( 'Dark Navbar', 'elexis' ),
		),
		'transport'   => 'refresh',
	)
);


/**
 * Display Post Categories on Cards
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'card_category_toggle',
		'label'       => esc_attr__( 'Display Post Categories on Cards', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the post categories on card items.', 'elexis' ),
		'section'     => 'content_blocks_section',
		'default'     => true,
		'transport'   => 'refresh',
	)
);

/**
 * Display Author Avatar on Cards
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'card_avatar_toggle',
		'label'       => esc_attr__( 'Display Author Avatar on Cards', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the author avatar on card items.', 'elexis' ),
		'section'     => 'content_blocks_section',
		'default'     => true,
		'transport'   => 'refresh',
	)
);

/**
 * Display Author Name on Cards
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'card_author_toggle',
		'label'       => esc_attr__( 'Display Author Name on Cards', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the author name on card items.', 'elexis' ),
		'section'     => 'content_blocks_section',
		'default'     => true,
		'transport'   => 'refresh',
	)
);

/**
 * Display Post Date on Cards
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'card_postdate_toggle',
		'label'       => esc_attr__( 'Display Post Date on Cards', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the post date on card items.', 'elexis' ),
		'section'     => 'content_blocks_section',
		'default'     => true,
		'transport'   => 'refresh',
	)
);

/**
 * Display Estimated Reading Time on Cards
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'card_readingtime_toggle',
		'label'       => esc_attr__( 'Display Estimated Reading Time on Cards', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the estimated reading time on card items.', 'elexis' ),
		'section'     => 'content_blocks_section',
		'default'     => false,
		'transport'   => 'refresh',
	)
);

/**
 * Display Meta Icons on Cards
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'card_icons_toggle',
		'label'       => esc_attr__( 'Display Meta Icons on Cards', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the meta icons on card items.', 'elexis' ),
		'section'     => 'content_blocks_section',
		'default'     => true,
		'transport'   => 'refresh',
	)
);

/**
 * Display Post Tags on Cards
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'card_tags_toggle',
		'label'       => esc_attr__( 'Display Post Tags on Cards', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the post tags on card items.', 'elexis' ),
		'section'     => 'content_blocks_section',
		'default'     => false,
		'transport'   => 'refresh',
	)
);

/**
 * Container Width
 */
my_config_kirki_add_field(
	array(
		'type'        => 'select',
		'settings'    => 'theme_layout_container',
		'label'       => esc_attr__( 'Container Width', 'elexis' ),
		'description' => esc_attr__( 'Choose between a fixed container layout and a full width fluid layout.', 'elexis' ),
		'section'     => 'theme_layout_section',
		'default'     => 'container',
		'choices'     => array(
			'container' => esc_attr__( 'Fixed Width Container', 'elexis' ),
			'container-fluid' => esc_attr__( 'Full Width Container', 'elexis' ),
		),
		'transport'   => 'refresh',
	)
);


/**
 * Outline Border Around Website Color
 */
my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'theme_layout_html_bg_color',
		'label'       => __( 'HTML Document Background Color', 'elexis' ),
		'description' => esc_attr__( 'Define the background color of your HTML document. This color is visible on some browsers where the scrolling can stretch the page further and also on some mobile browsers. It is wise to make this color same as your body/navbar/outline-border background color.', 'elexis' ),
		'section'     => 'theme_layout_section',
		'default'     => '#fff',
		'choices'     => array(
			'alpha' => true,
		),
    'output'    => array(
    	array(
    		'element'         => 'html',
    		'property'        => 'background-color',
      ),
    ),
		'transport'   => 'postMessage',
    'js_vars'     => array(
    	array(
    		'element'         => 'html',
    		'property'        => 'background-color',
      ),
    ),
	)
);

/**
 * Outline Border Around Website
 */
my_config_kirki_add_field(
	array(
		'type'        => 'slider',
		'settings'    => 'theme_layout_body_border',
		'label'       => esc_attr__( 'Outline Border Around Website', 'elexis' ),
		'description' => esc_attr__( 'Add an outline border around your website with the following thickness.', 'elexis' ),
		'section'     => 'theme_layout_section',
		'default'     => '0',
		'choices'     => array(
			'min'  => 0,
			'max'  => 2.0,
			'step' => 0.1,
			'suffix' => 'rem',
		),
		'output'      => array(
			array(
				'element' => 'body',
        'property' => 'border-width',
        'units'    => 'rem',
			),
		),
		'transport'   => 'postMessage',
    'js_vars'     => array(
      array(
				'element' => 'body',
        'property' => 'border-width',
        'units'    => 'rem',
      ),
    ),
	)
);

/**
 * Outline Border Around Website Color
 */
my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'theme_layout_body_border_color',
		'label'       => __( 'Outline Border Around Website Color', 'elexis' ),
		'description' => esc_attr__( 'Define the background color of the outline border around your website.', 'elexis' ),
		'section'     => 'theme_layout_section',
		'default'     => '#6b757c',
		'choices'     => array(
			'alpha' => true,
		),
    'output'    => array(
    	array(
    		'element'         => 'body',
    		'property'        => 'border-color',
      ),
    ),
		'transport'   => 'postMessage',
    'js_vars'     => array(
      array(
    		'element'         => 'body',
    		'property'        => 'border-color',
      ),
    ),
	)
);