<?php
add_filter( 'maxslider_enqueue_slider_css', 'nozama_lite_front_page_replace_maxslider_enqueue_slider_css', 10, 2 );
function nozama_lite_front_page_replace_maxslider_enqueue_slider_css( $css, $slider ) {
	if ( 'home' !== $slider['template'] ) {
		return $css;
	}

	$css = str_replace( '.maxslider-btn', '.btn', $css );
	$css = str_replace( '.maxslider-slide-', '.page-hero-', $css );

	return $css;
}

add_filter( 'maxslider_slider_classes', 'nozama_lite_front_page_replace_maxslider_slider_classes', 10, 2 );
function nozama_lite_front_page_replace_maxslider_slider_classes( $classes, $slider ) {
	if ( 'home' !== $slider['template'] ) {
		return $classes;
	}

	$maxslider = array_search( 'maxslider', $classes, true );
	if ( false !== $maxslider ) {
		unset( $classes[ $maxslider ] );
		$classes[] = 'page-hero-slideshow';
		$classes[] = 'nozama-lite-slick-slider';
	}

	$new_classes = array();
	foreach ( $classes as $class ) {
		$new_classes[] = str_replace( 'maxslider-', 'page-hero-', $class );
	}

	return $new_classes;
}


add_filter( 'maxslider_default_slide_values', 'nozama_lite_change_maxslider_default_slide_values' );
function nozama_lite_change_maxslider_default_slide_values( $defaults ) {
	$defaults['content_align']  = 'maxslider-align-left';
	$defaults['content_valign'] = 'maxslider-align-bottom';

	return $defaults;
}

add_filter( 'maxslider_additional_templates', 'nozama_lite_maxslider_additional_templates' );
/**
 * Appends the theme's MaxSlider templates to the list of available templates.
 *
 * @since 1.6.0
 *
 * @param array $templates
 *
 * @return array
 */
function nozama_lite_maxslider_additional_templates( $templates ) {
	return array_merge( $templates, array(
		'home' => array(
			'label' => _x( 'Home', 'maxslider template', 'nozama-lite' ),
		),
	) );
}

