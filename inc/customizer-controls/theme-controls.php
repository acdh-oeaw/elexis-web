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
	'home_layout'      => array( esc_attr__( 'Homepage Layout', 'elexis' ), '' ),
	'content_blocks'      => array( esc_attr__( 'Content Blocks Options', 'elexis' ), '' ),
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

/**
 * Hero Type Setting
 */
my_config_kirki_add_field(
	array(
		'type'        => 'select',
		'settings'    => 'hero_type_setting',
		'label'       => esc_attr__( 'Select Hero Type', 'elexis' ),
		'description' => esc_attr__( 'A hero element will be visible on top of your homepage. You may use static hero content or generate your hero from post(s).', 'elexis' ),
		'section'     => 'home_layout_section',
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
		'section'     => 'home_layout_section',
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
		'section'     => 'home_layout_section',
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
		'section'     => 'home_layout_section',
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
		'section'     => 'home_layout_section',
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
		'section'     => 'home_layout_section',
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
		'section'     => 'home_layout_section',
		'default'     => esc_attr__( 'Your Hero Title', 'elexis' ),
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
		'section'     => 'home_layout_section',
		'placeholder'     => esc_attr__( 'Add your static hero text.', 'elexis' ),
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
		'section'     => 'home_layout_section',
		'default'     => esc_attr__( 'Read More', 'elexis' ),
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
		'section'     => 'home_layout_section',
		'default'     => '#',
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
		'section'     => 'home_layout_section',
		'default'     => '',
    'required' => array(
        array(
    			'setting' => 'hero_type_setting', 
    			'operator' => 'contains', 
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
		'section'     => 'home_layout_section',
		'default'     => '#6b757c',
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
/*
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
*/
	)
);


/**
 * Home Layout Repeater Control.
 */
my_config_kirki_add_field(
	array(
		'type'        => 'repeater',
		'settings'    => 'repeater_setting',
		'label'       => esc_attr__( 'Homepage Content Blocks', 'elexis' ),
		'description' => esc_attr__( 'Arrange and define your content blocks for your homepage.', 'elexis' ),
		'section'     => 'home_layout_section',
  	'row_label' => array(
  		'type' => 'text',
  		'value' => esc_attr__('Content Block', 'elexis' ),
  	),
		'default'     => array(
			array(
				'link_text'   => esc_attr__( 'Kirki Site', 'elexis' ),
				'link_url'    => 'https://aristath.github.io/kirki/',
				'link_target' => '_self',
				'number_of_items' => 2,
				'checkbox'    => false,
			),
			array(
				'link_text'   => esc_attr__( 'Kirki Repository', 'elexis' ),
				'link_url'    => 'https://github.com/aristath/kirki',
				'link_target' => '_self',
				'number_of_items' => 4,
				'checkbox'    => false,
			),
		),
		'fields' => array(
			'link_target' => array(
				'type'        => 'select',
				'label'       => esc_attr__( 'Element Type', 'elexis' ),
				'description' => esc_attr__( 'Select the type of this content block element.', 'elexis' ),
				'default'     => 'card',
				'choices'     => array(
					'_blank'  => esc_attr__( 'New Window', 'elexis' ),
					'_self'   => esc_attr__( 'Same Frame', 'elexis' ),
				),
			),
			'link_text' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Element Type', 'elexis' ),
				'description' => esc_attr__( 'This will be the label for your link', 'elexis' ),
				'default'     => '',
			),
			'link_url' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Link URL', 'elexis' ),
				'description' => esc_attr__( 'This will be the link URL', 'elexis' ),
				'default'     => '',
			),
			'link_target' => array(
				'type'        => 'select',
				'label'       => esc_attr__( 'Link Target', 'elexis' ),
				'description' => esc_attr__( 'This will be the link target', 'elexis' ),
				'default'     => '_self',
				'choices'     => array(
					'_blank'  => esc_attr__( 'New Window', 'elexis' ),
					'_self'   => esc_attr__( 'Same Frame', 'elexis' ),
				),
			),
			'number_of_items' => array(
				'type'        => 'number',
				'label'       => esc_attr__( 'Number of Items', 'elexis' ),
				'description' => esc_attr__( 'This will be the link target', 'elexis' ),
				'default'     => 3,
    		'choices'     => array(
    			'min'  => 0,
    			'max'  => 10,
    			'step' => 1,
    		),
			),
			'checkbox' => array(
				'type'			=> 'checkbox',
				'label'			=> esc_attr__( 'Checkbox', 'elexis' ),
				'default'		=> false,
			),
		),
	)
);