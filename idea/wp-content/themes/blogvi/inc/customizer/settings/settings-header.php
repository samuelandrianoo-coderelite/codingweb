<?php

add_filter( 'bloglo_customizer_options', 'bloglo_customizer_header_options', 11 );
function bloglo_customizer_header_options( array $options ) {
	// Header Layout.
	$options['setting']['bloglo_header_layout']['control']['choices'] = array(
		'layout-5' => array(
			'image' => BLOGLO_THEME_URI . '/inc/customizer/assets/images/header-layout-5.svg',
			'title' => esc_html__( 'Header 1', 'blogvi' ),
		),
	);

	return $options;
}
