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
				'element' => array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ),
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

