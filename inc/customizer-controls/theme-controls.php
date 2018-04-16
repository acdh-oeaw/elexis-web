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
	'home_hero'      => array( esc_attr__( 'Homepage Hero Block', 'elexis' ), '' ),
	'home_blocks'      => array( esc_attr__( 'Homepage Content Blocks', 'elexis' ), '' ),
	'single_posts'      => array( esc_attr__( 'Single Posts', 'elexis' ), '' ),
	'footer'      => array( esc_attr__( 'Footer', 'elexis' ), '' ),
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

/* Get Categories for Query Selectors */
$categories = get_categories( array('orderby' => 'name','order' => 'ASC') );
$category_choices = array();
foreach ( $categories as $category ) {
	$category_choices[ $category->term_id ] = $category->name;
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
				'element' => array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', '.navbar-brand', '.btn-round' ),
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
				'element' => array( '.single main > article .entry-content', '.page main > article .entry-content' ),
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
 * Navbar Padding
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
 * Navbar Placement
 */
my_config_kirki_add_field(
	array(
		'type'        => 'radio',
		'settings'    => 'navbar_placement',
		'label'       => esc_attr__( 'Navbar Placement', 'elexis' ),
		'description' => esc_attr__( 'Choose between a static or fixed-to-top navbar.', 'elexis' ),
		'section'     => 'navbar_section',
		'default'     => 'static-navbar',
		'choices'     => array(
			'static-navbar' => esc_attr__( 'Static Navbar', 'elexis' ),
			'sticky-navbar' => esc_attr__( 'Fixed-Top Navbar', 'elexis' ),
		),
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
 * Sidebar Positioning
 */
my_config_kirki_add_field(
	array(
		'type'        => 'select',
		'settings'    => 'theme_layout_sidebar',
		'label'       => esc_attr__( 'Sidebar Positioning', 'elexis' ),
		'description' => esc_attr__( 'Set the position of your sidebar. Can either be: right, left, both or none. After defining this setting, please go to Widgets section to add widgets to different sidebars. Note: this can be overridden on individual pages.', 'elexis' ),
		'section'     => 'theme_layout_section',
		'default'     => 'right',
		'choices'     => array(
			'right' => esc_attr__( 'Right sidebar', 'elexis' ),
			'left' => esc_attr__( 'Left sidebar', 'elexis' ),
			'both' => esc_attr__( 'Right & Left sidebar', 'elexis' ),
			'none' => esc_attr__( 'No sidebar', 'elexis' ),
		),
		'transport'   => 'refresh',
	)
);

/**
 * HTML Background Color
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
		'transport'   => 'postMessage',
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
        'property' => 'border-right-width',
        'units'    => 'rem',
      ),
      array(
				'element' => 'body',
        'property' => 'border-left-width',
        'units'    => 'rem',
      ),
      array(
				'element' => 'body',
        'property' => 'border-bottom-width',
        'units'    => 'rem',
      ),
			array(
				'element' => '#wrapper-navbar',
        'property' => 'border-top-width',
        'units'    => 'rem',
			),
		),
    'js_vars'     => array(
      array(
				'element' => 'body',
        'property' => 'border-right-width',
        'units'    => 'rem',
      ),
      array(
				'element' => 'body',
        'property' => 'border-left-width',
        'units'    => 'rem',
      ),
      array(
				'element' => 'body',
        'property' => 'border-bottom-width',
        'units'    => 'rem',
      ),
			array(
				'element' => '#wrapper-navbar',
        'property' => 'border-top-width',
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
		'default'     => '#6c757d',
		'choices'     => array(
			'alpha' => true,
		),
    'output'    => array(
    	array(
    		'element'         => 'body',
    		'property'        => 'border-color',
      ),
			array(
				'element' => '#wrapper-navbar',
        'property' => 'border-top-color',
			),
    ),
		'transport'   => 'postMessage',
    'js_vars'     => array(
      array(
    		'element'         => 'body',
    		'property'        => 'border-color',
      ),
			array(
				'element' => '#wrapper-navbar',
        'property' => 'border-top-color',
			),
    ),
	)
);

/**
 * Hero Type Setting
 */
my_config_kirki_add_field(
	array(
		'type'        => 'select',
		'settings'    => 'hero_type_setting',
		'label'       => esc_attr__( 'Select Hero Type', 'elexis' ),
		'description' => esc_attr__( 'A hero element will be visible on top of your homepage. You may use static hero content or generate your hero from post(s).', 'elexis' ),
		'section'     => 'home_hero_section',
		'default'     => 'none',
		'choices'     => array(
			'none' => esc_attr__( 'No Hero', 'elexis' ),
			'static-hero' => esc_attr__( 'Static Hero', 'elexis' ),
			'post-hero' => esc_attr__( 'Hero with Post Items', 'elexis' ),
		),
		'transport'   => 'refresh',
	)
);

/**
 * Post Hero Query Type
 */
my_config_kirki_add_field(
	array(
		'type'        => 'radio',
		'settings'    => 'hero_post_query_type',
		'label'       => esc_attr__( 'Hero Posts Query Source', 'elexis' ),
		'description' => esc_attr__( 'Query posts from categories, tags or some selected posts.', 'elexis' ),
		'section'     => 'home_hero_section',
		'default'     => 'categories',
		'choices'     => array(
			'categories' => esc_attr__( 'Categories', 'elexis' ),
			'tags' => esc_attr__( 'Tags', 'elexis' ),
			'posts' => esc_attr__( 'Specific posts', 'elexis' ),
		),
		'transport'   => 'refresh',
    'required' => array(
        array(
    			'setting' => 'hero_type_setting', 
    			'operator' => '==', 
    			'value' => 'post-hero'
        )
    ),
	)
);

/**
 * Post Hero Category Query
 */
my_config_kirki_add_field(
	array(
		'type'        => 'select',
		'settings'    => 'hero_post_category_query',
		'label'       => esc_attr__( 'Select Categories to Query', 'elexis' ),
		'description' => esc_attr__( 'You may select multiple categories to query your content from.', 'elexis' ),
		'section'     => 'home_hero_section',
		'transport'   => 'refresh',
		'default'     => 'option-1',
		'multiple'    => 10,
		'choices'     => array(
			'option-1' => esc_attr__( 'Option 1', 'elexis' ),
			'option-2' => esc_attr__( 'Option 2', 'elexis' ),
			'option-3' => esc_attr__( 'Option 3', 'elexis' ),
			'option-4' => esc_attr__( 'Option 4', 'elexis' ),
			'option-5' => esc_attr__( 'Option 5', 'elexis' ),
		),
    'required' => array(
      array(
  			'setting' => 'hero_type_setting', 
  			'operator' => '==', 
  			'value' => 'post-hero'
      ),
      array(
  			'setting' => 'hero_post_query_type', 
  			'operator' => '==', 
  			'value' => 'categories'
      )
    ),
	)
);

/**
 * Post Hero Tag Query
 */
my_config_kirki_add_field(
	array(
		'type'        => 'select',
		'settings'    => 'hero_post_tag_query',
		'label'       => esc_attr__( 'Select Tags to Query', 'elexis' ),
		'description' => esc_attr__( 'You may select multiple tags to query your content from.', 'elexis' ),
		'section'     => 'home_hero_section',
		'transport'   => 'refresh',
		'default'     => 'option-1',
		'multiple'    => 10,
		'choices'     => array(
			'option-1' => esc_attr__( 'Option 1', 'elexis' ),
			'option-2' => esc_attr__( 'Option 2', 'elexis' ),
			'option-3' => esc_attr__( 'Option 3', 'elexis' ),
			'option-4' => esc_attr__( 'Option 4', 'elexis' ),
			'option-5' => esc_attr__( 'Option 5', 'elexis' ),
		),
    'required' => array(
      array(
  			'setting' => 'hero_type_setting', 
  			'operator' => '==', 
  			'value' => 'post-hero'
      ),
      array(
  			'setting' => 'hero_post_query_type', 
  			'operator' => '==', 
  			'value' => 'tags'
      )
    ),
	)
);

/**
 * Post Hero Posts Query
 */
my_config_kirki_add_field(
	array(
		'type'        => 'select',
		'settings'    => 'hero_post_posts_query',
		'label'       => esc_attr__( 'Select Posts to Query', 'elexis' ),
		'description' => esc_attr__( 'You may select multiple posts to query your content from.', 'elexis' ),
		'section'     => 'home_hero_section',
		'transport'   => 'refresh',
		'default'     => 'option-1',
		'multiple'    => 10,
		'choices'     => array(
			'option-1' => esc_attr__( 'Option 1', 'elexis' ),
			'option-2' => esc_attr__( 'Option 2', 'elexis' ),
			'option-3' => esc_attr__( 'Option 3', 'elexis' ),
			'option-4' => esc_attr__( 'Option 4', 'elexis' ),
			'option-5' => esc_attr__( 'Option 5', 'elexis' ),
		),
    'required' => array(
      array(
  			'setting' => 'hero_type_setting', 
  			'operator' => '==', 
  			'value' => 'post-hero'
      ),
      array(
  			'setting' => 'hero_post_query_type', 
  			'operator' => '==', 
  			'value' => 'posts'
      )
    ),
	)
);

/**
 * Post Hero Number of Items
 */
my_config_kirki_add_field(
	array(
		'type'        => 'number',
		'settings'    => 'hero_post_number_of_items',
		'label'       => esc_attr__( 'Number of Items', 'elexis' ),
		'section'     => 'home_hero_section',
		'transport'   => 'refresh',
		'choices'     => array(
			'min'  => 1,
			'max'  => 10,
			'step' => 1,
		),
    'required' => array(
        array(
    			'setting' => 'hero_type_setting', 
    			'operator' => '==', 
    			'value' => 'post-hero'
        )
    ),
	)
);

/**
 * Static Hero: Title.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'text',
		'settings'    => 'hero_static_title',
		'label'       => esc_attr__( 'Hero Title', 'elexis' ),
		'description' => esc_attr__( 'The heading of your static hero content.', 'elexis' ),
		'section'     => 'home_hero_section',
		'transport'   => 'refresh',
    'required' => array(
        array(
    			'setting' => 'hero_type_setting', 
    			'operator' => '==', 
    			'value' => 'static-hero'
        )
    ),
	)
);

/**
 * Static Hero: Text.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'textarea',
		'settings'    => 'hero_static_text',
		'label'       => esc_attr__( 'Hero Text', 'elexis' ),
		'description' => esc_attr__( 'Add your static hero text.', 'elexis' ),
		'section'     => 'home_hero_section',
		'transport'   => 'refresh',
    'required' => array(
        array(
    			'setting' => 'hero_type_setting', 
    			'operator' => '==', 
    			'value' => 'static-hero'
        )
    ),
	)
);

/**
 * Hero: Button.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'text',
		'settings'    => 'hero_button',
		'label'       => esc_attr__( 'Hero Button', 'elexis' ),
		'description' => esc_attr__( 'Add your hero button label. Leave empty for no button.', 'elexis' ),
		'section'     => 'home_hero_section',
		'transport'   => 'refresh',
    'required' => array(
        array(
    			'setting' => 'hero_type_setting', 
    			'operator' => 'contains', 
    			'value' => array('static-hero', 'post-hero')
        )
    ),
	)
);

/**
 * Static Hero: URL.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'text',
		'settings'    => 'hero_static_url',
		'label'       => esc_attr__( 'Hero URL', 'elexis' ),
		'description' => esc_attr__( 'Enter the URL where you want to link your hero to. Leave empty for no linking.', 'elexis' ),
		'transport'   => 'refresh',
		'section'     => 'home_hero_section',
    'required' => array(
        array(
    			'setting' => 'hero_type_setting', 
    			'operator' => '==', 
    			'value' => 'static-hero'
        )
    ),
	)
);

/**
 * Static Hero: Background Image
 */
my_config_kirki_add_field(
	array(
		'type'        => 'image',
		'settings'    => 'hero_static_image',
		'label'       => esc_attr__( 'Hero Background Image', 'elexis' ),
		'description' => esc_attr__( 'Select the image you want to use in the background of your hero.', 'elexis' ),
		'section'     => 'home_hero_section',
		'transport'   => 'refresh',
		'default'     => '',
    'required' => array(
        array(
    			'setting' => 'hero_type_setting', 
    			'operator' => '==', 
    			'value' => 'static-hero'
        )
    ),
	)
);

/**
 * Hero: Background Color
 */
my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'hero_bg_color',
		'label'       => __( 'Hero Background Color', 'elexis' ),
		'description' => esc_attr__( 'Define the background color of your hero content. If the hero has a background image, you can decrease the opacity of this color to make a color overlay on the image.', 'elexis' ),
		'section'     => 'home_hero_section',
		'default'     => 'rgba(108,117,125,0.75)',
		'choices'     => array(
			'alpha' => true,
		),
    'required' => array(
        array(
    			'setting' => 'hero_type_setting', 
    			'operator' => 'contains', 
    			'value' => array('static-hero', 'post-hero')
        )
    ),
    'output'    => array(
    	array(
    		'element'         => '#wrapper-hero-content::after',
    		'property'        => 'background-color',
      ),
    ),
		'transport'   => 'postMessage',
    'js_vars'     => array(
      array(
    		'element'         => '#wrapper-hero-content::after',
    		'property'        => 'background-color',
      ),
    ),
	)
);

/**
 * Hero Color Scheme
 */
my_config_kirki_add_field(
	array(
		'type'        => 'radio',
		'settings'    => 'hero_color_scheme',
		'label'       => esc_attr__( 'Hero Text Color Scheme', 'elexis' ),
		'description' => esc_attr__( 'Use the light scheme with a bright background color and the dark scheme with a dark background.', 'elexis' ),
		'section'     => 'home_hero_section',
		'default'     => 'hero-dark',
		'choices'     => array(
			'hero-light' => esc_attr__( 'Light Hero', 'elexis' ),
			'hero-dark' => esc_attr__( 'Dark Hero', 'elexis' ),
		),
		'transport'   => 'refresh',
    'required' => array(
        array(
    			'setting' => 'hero_type_setting', 
    			'operator' => 'contains', 
    			'value' => array('static-hero', 'post-hero')
        )
    ),
	)
);

/**
 * Hero Content Width
 */
my_config_kirki_add_field(
	array(
		'type'        => 'slider',
		'settings'    => 'hero_content_width',
		'label'       => esc_attr__( 'Hero Content Width', 'elexis' ),
		'description' => esc_attr__( 'Define the width of the text content on the hero.', 'elexis' ),
		'section'     => 'home_hero_section',
		'default'     => '50',
		'choices'     => array(
			'min'  => 25,
			'max'  => 100,
			'step' => 1,
			'suffix' => '%',
		),
		'output'      => array(
			array(
				'element' => array( '#wrapper-hero-inner h1', '#wrapper-hero-inner p' ),
        'property' => 'width',
        'units'    => '%',
			),
		),
		'transport'   => 'postMessage',
    'js_vars'     => array(
      array(
				'element' => array( '#wrapper-hero-inner h1', '#wrapper-hero-inner p' ),
        'property' => 'width',
        'units'    => '%',
      ),
    ),
    'required' => array(
        array(
    			'setting' => 'hero_type_setting', 
    			'operator' => 'contains', 
    			'value' => array('static-hero', 'post-hero')
        )
    ),
	)
);

/**
 * Homepage Content Blocks Repeater Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'repeater',
		'settings'    => 'home_content_blocks',
		'label'       => esc_attr__( 'Homepage Content Blocks', 'elexis' ),
		'description' => esc_attr__( 'Arrange and define your content blocks for your homepage.', 'elexis' ),
		'section'     => 'home_blocks_section',
		'transport'   => 'refresh',
  	'row_label' => array(
  		'type' => 'text',
  		'value' => esc_attr__('Content Block', 'elexis' ),
  	),
		'default'     => array(
			array(
  			'block_title' => '',
				'blocks_per_row'   => '2',
				'number_of_blocks'    => '',
				'blocks_post_query_type' => 'categories',
				'blocks_post_category_query' => '',
			),
		),
		'fields' => array(
			'block_title' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Content Block Title', 'elexis' ),
				'description' => esc_attr__( 'This will be the heading above your content block. Leave empty for no heading.', 'elexis' ),
				'default'     => '',
			),
			'blocks_per_row' => array(
				'type'        => 'select',
				'label'       => esc_attr__( 'Elements per Row', 'elexis' ),
				'description' => esc_attr__( 'Select number of content blocks per row.', 'elexis' ),
				'default'     => 'col-12',
				'choices'     => array(
					'col-md-12'  => esc_attr__( '1', 'elexis' ),
					'col-md-6'   => esc_attr__( '2', 'elexis' ),
					'col-md-4'   => esc_attr__( '3', 'elexis' ),
					'col-md-3'   => esc_attr__( '4', 'elexis' ),
					'col-md-2'   => esc_attr__( '6', 'elexis' ),
				),
			),
			'number_of_blocks' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Total Number of Blocks', 'elexis' ),
				'description' => esc_attr__( 'Set max limit for items or leave empty to display all (limited to 1000).', 'elexis' ),
				'default'     => '12',
			),
			'blocks_layout_type' => array(
				'type'        => 'select',
				'label'       => esc_attr__( 'Blocks Layout Type', 'elexis' ),
				'description' => esc_attr__( 'Select type of layout for these blocks.', 'elexis' ),
				'default'     => 'card-vertical',
				'choices'     => array(
					'card-vertical'  => esc_attr__( 'Cards with Image on Top', 'elexis' ),
					'card-horizontal card-horizontal-left'   => esc_attr__( 'Cards with Image on Left', 'elexis' ),
					'card-horizontal card-horizontal-right'   => esc_attr__( 'Cards with Image on Right', 'elexis' ),
					'card-no-image'   => esc_attr__( 'Cards with no Image', 'elexis' )
				),
			),
			'blocks_post_query_type' => array(
				'type'        => 'radio',
				'label'       => esc_attr__( 'Blocks Post Query Source', 'elexis' ),
				'description' => esc_attr__( 'Query posts from categories, tags or some selected posts.', 'elexis' ),
				'default'     => 'categories',
    		'choices'     => array(
    			'categories' => esc_attr__( 'Categories', 'elexis' ),
    			'tags' => esc_attr__( 'Tags', 'elexis' ),
    			'posts' => esc_attr__( 'Specific posts', 'elexis' ),
    		),
			),
			'blocks_post_category_query' => array(
				'type'        => 'select',
				'label'       => esc_attr__( 'Select Categories to Query', 'elexis' ),
				'description' => esc_attr__( 'You may select multiple categories to query your content from.', 'elexis' ),
				'default'     => 'categories',
    		'multiple'    => 10,
    		'choices'     => $category_choices,
			),
		),
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
		'section'     => 'home_blocks_section',
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
		'section'     => 'home_blocks_section',
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
		'section'     => 'home_blocks_section',
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
		'section'     => 'home_blocks_section',
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
		'section'     => 'home_blocks_section',
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
		'section'     => 'home_blocks_section',
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
		'section'     => 'home_blocks_section',
		'default'     => false,
		'transport'   => 'refresh',
	)
);

/**
 * Display Post Categories on Posts
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'post_category_toggle',
		'label'       => esc_attr__( 'Display Post Categories on Posts', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the post categories on post items.', 'elexis' ),
		'section'     => 'single_posts_section',
		'default'     => true,
		'transport'   => 'refresh',
	)
);

/**
 * Display Author Avatar on Posts
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'post_avatar_toggle',
		'label'       => esc_attr__( 'Display Author Avatar on Posts', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the author avatar on post items.', 'elexis' ),
		'section'     => 'single_posts_section',
		'default'     => true,
		'transport'   => 'refresh',
	)
);

/**
 * Display Author Name on Posts
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'post_author_toggle',
		'label'       => esc_attr__( 'Display Author Name on Posts', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the author name on post items.', 'elexis' ),
		'section'     => 'single_posts_section',
		'default'     => true,
		'transport'   => 'refresh',
	)
);

/**
 * Display Author Bio on Posts
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'post_authorbio_toggle',
		'label'       => esc_attr__( 'Display Author Bio on Posts', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the author bio on post items.', 'elexis' ),
		'section'     => 'single_posts_section',
		'default'     => true,
		'transport'   => 'refresh',
	)
);

/**
 * Display Post Date on Posts
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'post_postdate_toggle',
		'label'       => esc_attr__( 'Display Post Date on Posts', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the post date on post items.', 'elexis' ),
		'section'     => 'single_posts_section',
		'default'     => true,
		'transport'   => 'refresh',
	)
);

/**
 * Display Estimated Reading Time on Posts
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'post_readingtime_toggle',
		'label'       => esc_attr__( 'Display Estimated Reading Time on Posts', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the estimated reading time on post items.', 'elexis' ),
		'section'     => 'single_posts_section',
		'default'     => false,
		'transport'   => 'refresh',
	)
);

/**
 * Display Meta Icons on Posts
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'post_icons_toggle',
		'label'       => esc_attr__( 'Display Meta Icons on Posts', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the meta icons on post items.', 'elexis' ),
		'section'     => 'single_posts_section',
		'default'     => false,
		'transport'   => 'refresh',
	)
);

/**
 * Display Post Tags on Posts
 */
my_config_kirki_add_field(
	array(
		'type'        => 'toggle',
		'settings'    => 'post_tags_toggle',
		'label'       => esc_attr__( 'Display Post Tags on Posts', 'elexis' ),
		'description' => esc_attr__( 'Select if you want to display the post tags on post items.', 'elexis' ),
		'section'     => 'single_posts_section',
		'default'     => true,
		'transport'   => 'refresh',
	)
);

/**
 * Primary Footer Background Color
 */
my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'footer_primary_bg_color',
		'label'       => __( 'Primary Footer Background Color', 'elexis' ),
		'description' => esc_attr__( 'Define the background color of your primary footer. This footer block will be visible if you add some widgets to this area.', 'elexis' ),
		'section'     => 'footer_section',
		'default'     => '#e9ecef',
		'choices'     => array(
			'alpha' => true,
		),
    'output'    => array(
    	array(
    		'element'         => '#wrapper-footer-full',
    		'property'        => 'background-color',
      ),
    ),
		'transport'   => 'postMessage',
    'js_vars'     => array(
    	array(
    		'element'         => '#wrapper-footer-full',
    		'property'        => 'background-color',
      ),
    ),
	)
);

/**
 * Primary Footer Text Color
 */
my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'footer_primary_text_color',
		'label'       => __( 'Primary Footer Text Color', 'elexis' ),
		'description' => esc_attr__( 'Define the text color of your primary footer.', 'elexis' ),
		'section'     => 'footer_section',
		'default'     => '#212529',
		'choices'     => array(
			'alpha' => true,
		),
    'output'    => array(
    	array(
    		'element'         => array('#wrapper-footer-full','#wrapper-footer-full h1','#wrapper-footer-full h2','#wrapper-footer-full h3','#wrapper-footer-full h4','#wrapper-footer-full h5','#wrapper-footer-full h6','#wrapper-footer-full a'),
    		'property'        => 'color',
      ),
    ),
		'transport'   => 'postMessage',
    'js_vars'     => array(
    	array(
    		'element'         => array('#wrapper-footer-full','#wrapper-footer-full h1','#wrapper-footer-full h2','#wrapper-footer-full h3','#wrapper-footer-full h4','#wrapper-footer-full h5','#wrapper-footer-full h6','#wrapper-footer-full a'),
    		'property'        => 'color',
      ),
    ),
	)
);

/**
 * Primary Footer Widget Border Color
 */
my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'footer_primary_border_color',
		'label'       => __( 'Primary Footer Widget Border Color', 'elexis' ),
		'description' => esc_attr__( 'Define the widget border color of your primary footer.', 'elexis' ),
		'section'     => 'footer_section',
		'default'     => 'rgba(0, 0, 0, 0.15)',
		'choices'     => array(
			'alpha' => true,
		),
    'output'    => array(
    	array(
    		'element'         => '#wrapper-footer-full .widget-title',
    		'property'        => 'border-bottom-color',
      ),
    ),
		'transport'   => 'postMessage',
    'js_vars'     => array(
    	array(
    		'element'         => '#wrapper-footer-full .widget-title',
    		'property'        => 'border-bottom-color',
      ),
    ),
	)
);

/**
 * Secondary Footer Background Color
 */
my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'footer_secondary_bg_color',
		'label'       => __( 'Secondary Footer Background Color', 'elexis' ),
		'description' => esc_attr__( 'Define the background color of your secondary footer. This footer block will be visible if you add some widgets to this area.', 'elexis' ),
		'section'     => 'footer_section',
		'default'     => '#212529',
		'choices'     => array(
			'alpha' => true,
		),
    'output'    => array(
    	array(
    		'element'         => '#wrapper-footer-secondary',
    		'property'        => 'background-color',
      ),
    ),
		'transport'   => 'postMessage',
    'js_vars'     => array(
    	array(
    		'element'         => '#wrapper-footer-secondary',
    		'property'        => 'background-color',
      ),
    ),
	)
);

/**
 * Secondary Footer Widget Border Color
 */
my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'footer_secondary_border_color',
		'label'       => __( 'Secondary Footer Widget Border Color', 'elexis' ),
		'description' => esc_attr__( 'Define the widget border color of your secondary footer.', 'elexis' ),
		'section'     => 'footer_section',
		'default'     => 'rgba(255, 255, 255, 0.3)',
		'choices'     => array(
			'alpha' => true,
		),
    'output'    => array(
    	array(
    		'element'         => '#wrapper-footer-secondary .widget-title',
    		'property'        => 'border-bottom-color',
      ),
    ),
		'transport'   => 'postMessage',
    'js_vars'     => array(
    	array(
    		'element'         => '#wrapper-footer-secondary .widget-title',
    		'property'        => 'border-bottom-color',
      ),
    ),
	)
);

/**
 * Secondary Footer Text Color
 */
my_config_kirki_add_field(
	array(
		'type'        => 'color',
		'settings'    => 'footer_secondary_text_color',
		'label'       => __( 'Secondary Footer Text Color', 'elexis' ),
		'description' => esc_attr__( 'Define the text color of your secondary footer.', 'elexis' ),
		'section'     => 'footer_section',
		'default'     => '#fff',
		'choices'     => array(
			'alpha' => true,
		),
    'output'    => array(
    	array(
    		'element'         => array('#wrapper-footer-secondary','#wrapper-footer-secondary h1','#wrapper-footer-secondary h2','#wrapper-footer-secondary h3','#wrapper-footer-secondary h4','#wrapper-footer-secondary h5','#wrapper-footer-secondary h6','#wrapper-footer-secondary a'),
    		'property'        => 'color',
      ),
    ),
		'transport'   => 'postMessage',
    'js_vars'     => array(
    	array(
    		'element'         => array('#wrapper-footer-secondary','#wrapper-footer-secondary h1','#wrapper-footer-secondary h2','#wrapper-footer-secondary h3','#wrapper-footer-secondary h4','#wrapper-footer-secondary h5','#wrapper-footer-secondary h6','#wrapper-footer-secondary a'),
    		'property'        => 'color',
      ),
    ),
	)
);





