<?php

add_filter( 'bloglo_customizer_options', 'bloglo_customizer_blog_options', 11 );
function bloglo_customizer_blog_options( array $options ) {
	// Layout.
	$options['setting']['bloglo_blog_layout'] = array(
		'transport'         => 'refresh',
		'sanitize_callback' => 'bloglo_sanitize_select',
		'control'           => array(
			'type'        => 'bloglo-select',
			'label'       => esc_html__( 'Layout', 'blogvi' ),
			'description' => esc_html__( 'Choose blog layout. This will affect blog layout on archives, search results and posts page.', 'blogvi' ),
			'section'     => 'bloglo_section_blog_page',
			'choices'     => array(
				'blog-horizontal' => esc_html__( 'Horizontal', 'blogvi' ),
			),
		),
	);

	return $options;
}
