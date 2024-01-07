<?php
/**
 * Nozama_Lite scripts and styles related functions.
 */

/**
 * Register Google Fonts
 */
function nozama_lite_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese';
	$suffix    = nozama_lite_scripts_styles_suffix();

	/* translators: If there are characters in your language that are not supported by Source Sans Pro, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Source Sans Pro font: on or off', 'nozama-lite' ) ) {
		$fonts[] = 'Source Sans Pro:400,400i,600,700';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	if ( get_theme_mod( 'theme_local_google_fonts' ) ) {
		$fonts_url = get_template_directory_uri() . "/inc/assets/vendor/gfonts/google-fonts{$suffix}.css";
	}

	return $fonts_url;
}

/**
 * Register scripts and styles unconditionally.
 */
function nozama_lite_register_scripts() {
	$theme  = wp_get_theme();
	$suffix = nozama_lite_scripts_styles_suffix();

	if ( function_exists( 'MaxSlider' ) ) {
		wp_register_script( 'maxslider-init', get_template_directory_uri() . "/inc/assets/js/maxslider-init{$suffix}.js", array( 'jquery', 'slick' ), $theme->get( 'Version' ), true );
	}

	if ( ! wp_script_is( 'nozama-lite-post-meta', 'enqueued' ) && ! wp_script_is( 'nozama-lite-post-meta', 'registered' ) ) {
		wp_register_style( 'nozama-lite-post-meta', get_template_directory_uri() . '/inc/assets/css/admin/post-meta.css', array(), $theme->get( 'Version' ) );
		wp_register_script( 'nozama-lite-post-meta', get_template_directory_uri() . '/inc/assets/js/admin/post-meta.js', array(
			'media-editor',
			'jquery',
			'jquery-ui-sortable',
		), $theme->get( 'Version' ), true );

		$settings = array(
			'ajaxurl'        => admin_url( 'admin-ajax.php' ),
			'tSelectFile'    => esc_html__( 'Select file', 'nozama-lite' ),
			'tSelectFiles'   => esc_html__( 'Select files', 'nozama-lite' ),
			'tUseThisFile'   => esc_html__( 'Use this file', 'nozama-lite' ),
			'tUseTheseFiles' => esc_html__( 'Use these files', 'nozama-lite' ),
			'tRemoveImage'   => esc_html__( 'Remove image', 'nozama-lite' ),
		);
		wp_localize_script( 'nozama-lite-post-meta', 'nozama_lite_PostMeta', $settings );
	}

	wp_register_style( 'nozama-lite-repeating-fields', get_template_directory_uri() . '/inc/assets/css/admin/repeating-fields.css', array(), $theme->get( 'Version' ) );
	wp_register_script( 'nozama-lite-repeating-fields', get_template_directory_uri() . '/inc/assets/js/admin/repeating-fields.js', array(
		'jquery',
		'jquery-ui-sortable',
	), $theme->get( 'Version' ), true );

	wp_register_style( 'font-awesome-5', get_template_directory_uri() . '/inc/assets/vendor/fontawesome/css/fontawesome.min.css', array(), '5.15.4' );

	wp_register_style( 'jquery-magnific-popup', get_template_directory_uri() . "/inc/assets/vendor/magnific-popup/magnific{$suffix}.css", array(), '1.0.0' );
	wp_register_script( 'jquery-magnific-popup', get_template_directory_uri() . "/inc/assets/vendor/magnific-popup/jquery.magnific-popup{$suffix}.js", array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'nozama-lite-magnific-init', get_template_directory_uri() . "/inc/assets/js/magnific-init{$suffix}.js", array( 'jquery' ), $theme->get( 'Version' ), true );



	wp_register_style( 'nozama-lite-google-font', nozama_lite_fonts_url(), array(), null );

	wp_register_style( 'nozama-lite-dependencies', false, array(
		'nozama-lite-google-font',
		'font-awesome-5',
	), $theme->get( 'Version' ) );

	if ( is_child_theme() ) {
		wp_register_style( 'nozama-lite-style-parent', get_template_directory_uri() . '/style.css', array(
			'nozama-lite-dependencies',
		), $theme->get( 'Version' ) );
	}

	wp_register_style( 'nozama-lite-style', get_stylesheet_uri(), array(
		'nozama-lite-dependencies',
	), $theme->get( 'Version' ) );

	wp_register_script( 'nozama-lite-dependencies', false, array(
		'jquery',
	), $theme->get( 'Version' ), true );

	wp_register_script( 'nozama-lite-front-scripts', get_template_directory_uri() . "/inc/assets/js/scripts{$suffix}.js", array(
		'nozama-lite-dependencies',
	), $theme->get( 'Version' ), true );

	$vars = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	);
	wp_localize_script( 'nozama-lite-front-scripts', 'nozama_lite_vars', $vars );

}
add_action( 'init', 'nozama_lite_register_scripts' );

/**
 * Enqueue scripts and styles.
 */
function nozama_lite_enqueue_scripts() {

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( class_exists( 'MaxSlider' ) && ( ( is_page_template( 'templates/front-page.php' ) && get_post_meta( get_queried_object_id(), 'nozama_lite_front_slider_id', true ) ) || is_page_template( 'templates/builder.php' ) ) ) {
		wp_enqueue_script( 'maxslider-init' );
	}

	if ( get_theme_mod( 'theme_lightbox', 1 ) ) {
		wp_enqueue_style( 'jquery-magnific-popup' );
		wp_enqueue_script( 'jquery-magnific-popup' );
		wp_enqueue_script( 'nozama-lite-magnific-init' );
	}

	if ( is_child_theme() ) {
		wp_enqueue_style( 'nozama-lite-style-parent' );
	}

	wp_enqueue_style( 'nozama-lite-style' );
	wp_add_inline_style( 'nozama-lite-style', nozama_lite_get_all_customizer_css() );

	wp_enqueue_script( 'nozama-lite-front-scripts' );

}
add_action( 'wp_enqueue_scripts', 'nozama_lite_enqueue_scripts' );


/**
 * Enqueue admin scripts and styles.
 */
function nozama_lite_admin_scripts( $hook ) {
	$theme = wp_get_theme();

	wp_register_style( 'nozama-lite-widgets', get_template_directory_uri() . '/inc/assets/css/admin/widgets.css', array(
		'nozama-lite-repeating-fields',
		'nozama-lite-post-meta',
	), $theme->get( 'Version' ) );

	wp_register_script( 'nozama-lite-widgets', get_template_directory_uri() . '/inc/assets/js/admin/widgets.js', array(
		'jquery',
		'nozama-lite-repeating-fields',
		'nozama-lite-post-meta',
	), $theme->get( 'Version' ), true );
	$params = array(
		'ajaxurl'                      => admin_url( 'admin-ajax.php' ),
		'widget_post_type_items_nonce' => wp_create_nonce( 'nozama-lite-post-type-items' ),
	);
	wp_localize_script( 'nozama-lite-widgets', 'ThemeWidget', $params );

	//
	// Enqueue
	//
	if ( in_array( $hook, array( 'widgets.php', 'customize.php' ), true ) ) {
		wp_enqueue_style( 'nozama-lite-repeating-fields' );
		wp_enqueue_script( 'nozama-lite-repeating-fields' );

		wp_enqueue_media();
		wp_enqueue_style( 'nozama-lite-widgets' );
		wp_enqueue_script( 'nozama-lite-widgets' );
	}

	if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'nozama-lite-post-meta' );
		wp_enqueue_script( 'nozama-lite-post-meta' );
	}
}
add_action( 'admin_enqueue_scripts', 'nozama_lite_admin_scripts' );

/**
 * Enqueue Google Font for the block editor.
 */
add_action( 'enqueue_block_assets', 'nozama_lite_block_editor_font_family' );
function nozama_lite_block_editor_font_family() {
	if ( ! is_admin() ) {
		return;
	}

	wp_enqueue_style( 'nozama-lite-google-font' );
	wp_enqueue_style( 'font-awesome-5' );
}

add_action( 'init', 'nozama_lite_register_block_editor_block_styles' );
/**
 * Registers custom block styles.
 *
 * @since 1.6.0
 */
function nozama_lite_register_block_editor_block_styles() {
	register_block_style( 'gutenbee/heading', array(
		'name'  => 'nozama-lite-banner-heading',
		'label' => __( 'Banner heading', 'nozama-lite' ),
	) );
}
