<?php

/**
 * Default Option
 */

add_filter( 'bloglo_default_option_values', 'bloglo_default_options', 11 );
function bloglo_default_options( $defaults ) {

	$defaults['bloglo_accent_color']     = '#C26148';
	$defaults['bloglo_text_color']       = '#333333';
	$defaults['bloglo_link_hover_color'] = '#94979e';
	$defaults['bloglo_headings_color']   = '#333333';

	$defaults['bloglo_site_layout'] = 'fw-contained';

	$defaults['bloglo_body_font'] = bloglo_typography_defaults(
		array(
			'font-family'         => 'Outfit',
			'font-weight'         => 400,
			'font-size-desktop'   => '1.7',
			'font-size-unit'      => 'rem',
			'line-height-desktop' => '1.75',
		)
	);

	$defaults['bloglo_primary_button_bg_color']           = '';
	$defaults['bloglo_primary_button_hover_bg_color']     = '';
	$defaults['bloglo_primary_button_text_color']         = '#fff';
	$defaults['bloglo_primary_button_hover_text_color']   = '#fff';
	$defaults['bloglo_primary_button_border_radius']      = array(
		'top-left'     => '',
		'top-right'    => '',
		'bottom-right' => '',
		'bottom-left'  => '',
		'unit'         => 'rem',
	);
	$defaults['bloglo_primary_button_border_width']       = 0.1;
	$defaults['bloglo_primary_button_border_color']       = '#ff4c60';
	$defaults['bloglo_primary_button_hover_border_color'] = '#ff4c60';

	$defaults['bloglo_secondary_button_border_radius'] = array(
		'top-left'     => '',
		'top-right'    => '',
		'bottom-right' => '',
		'bottom-left'  => '',
		'unit'         => 'rem',
	);
	$defaults['bloglo_secondary_button_border_width']  = 0.1;

	$defaults['bloglo_text_button_hover_text_color'] = '#1E293B';

	$defaults['bloglo_blog_layout'] = 'blog-horizontal';

	$defaults['bloglo_sidebar_widget_title_font_size'] = array(
		'desktop' => 2,
		'unit'    => 'rem',
	);

	$defaults['bloglo_top_bar_enable'] = false;

	$defaults['bloglo_header_background'] = bloglo_design_options_defaults(
		array(
			'background' => array(
				'color'    => array(
					'background-color' => '#ffffff',
				),
				'gradient' => array(),
			),
		)
	);

	$defaults['bloglo_header_border'] = bloglo_design_options_defaults(
		array(
			'border' => array(
				'border-bottom-width' => 1,
				'border-color'        => 'rgba(39,39,39,.75)',
				'separator-color'     => '#cccccc',
			),
		)
	);

	$defaults['bloglo_header_layout']  = 'layout-5';
	$defaults['bloglo_header_widgets'] = array(

		array(
			'classname' => 'bloglo_customizer_widget_socials',
			'type'      => 'socials',
			'values'    => array(
				'style'      => 'rounded-fill',
				'size'       => 'mideum',
				'location'   => 'right',
				'visibility' => 'hide-mobile-tablet',
			),
		),
		array(
			'classname' => 'bloglo_customizer_widget_darkmode',
			'type'      => 'darkmode',
			'values'    => array(
				'location'   => 'right',
				'visibility' => 'hide-mobile-tablet',
			),
		),
		array(
			'classname' => 'bloglo_customizer_widget_search',
			'type'      => 'search',
			'values'    => array(
				'location'   => 'right',
				'visibility' => 'hide-mobile-tablet',
			),
		),
		array(
			'classname' => 'bloglo_customizer_widget_button',
			'type'      => 'button',
			'values'    => array(
				'text'       => 'Subscribe',
				'url'        => '#',
				'class'      => 'btn-small',
				'target'     => true,
				'location'   => 'right',
				'visibility' => 'hide-mobile-tablet',
			),
		),
	);

	$defaults['bloglo_header_widgets_separator'] = 'none';

	$defaults['bloglo_page_header_enable'] = false;

	$defaults['bloglo_breadcrumbs_position']   = 'below-header';
	$defaults['bloglo_breadcrumbs_background'] = bloglo_design_options_defaults(
		array(
			'background' => array(
				'color'    => array(
					'background-color' => '#ffffff',
				),
				'gradient' => array(),
				'image'    => array(),
			),
		)
	);
	$defaults['bloglo_breadcrumbs_border']     = bloglo_design_options_defaults(
		array(
			'border' => array(
				'border-top-width'    => 1,
				'border-bottom-width' => 1,
				'border-style'        => 'solid',
				'border-color'        => 'rgba(39,39,39,.75)',
			),
		)
	);

	$defaults['bloglo_sidebar_style'] = '3';
	$defaults['bloglo_sidebar_width'] = 30;

	$defaults['bloglo_blog_entry_meta_elements']  = array(
		'author'   => false,
		'date'     => false,
		'category' => false,
		'tag'      => false,
		'comments' => false,
	);
	$defaults['bloglo_blog_horizontal_read_more'] = true;

	$defaults['bloglo_section_heading_style'] = '1';

	$defaults['bloglo_enable_ticker'] = true;
	$defaults['bloglo_enable_hero']   = false;

	$defaults['bloglo_boxed_content_background_color'] = '#ffffff';

	$defaults['bloglo_footer_layout']               = 'layout-2';
	$defaults['bloglo_footer_widget_heading_style'] = '1';
	$defaults['bloglo_footer_background']           = bloglo_design_options_defaults(
		array(
			'background' => array(
				'color'    => array(
					'background-color' => '#ffffff',
				),
				'gradient' => array(),
				'image'    => array(),
			),
		)
	);
	$defaults['bloglo_footer_text_color']           = bloglo_design_options_defaults(
		array(
			'color' => array(
				'text-color'         => '#94979e',
				'link-color'         => '#44464b',
				'link-hover-color'   => '#ff4c60',
				'widget-title-color' => '#131315',
			),
		)
	);
	$defaults['bloglo_footer_border']               = bloglo_design_options_defaults(
		array(
			'border' => array(
				'border-top-width'    => 1,
				'border-bottom-width' => 0,
				'border-color'        => '#333333',
				'border-style'        => 'solid',
			),
		)
	);

	$defaults['bloglo_copyright_separator'] = 'fw-separator';

	$defaults['bloglo_copyright_background'] = bloglo_design_options_defaults(
		array(
			'background' => array(
				'color'    => array(
					'background-color' => '#f7f6f5',
				),
				'gradient' => array(),
				'image'    => array(),
			),
		)
	);
	
	$defaults['bloglo_copyright_text_color'] = bloglo_design_options_defaults(
		array(
			'color' => array(
				'text-color'       => '#333333',
				'link-color'       => '#333333',
				'link-hover-color' => '#C26148',
			),
		)
	);

	return $defaults;
}
