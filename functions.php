<?php
/* Set Up
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/* theme_setup */
if ( !function_exists( 'karakuri_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'karakuri_theme_setup' );
	function karakuri_theme_setup() {
		global $content_width;

		if ( !isset( $content_width ) )
			$content_width = 618;

		load_theme_textdomain( 'karakuri', get_template_directory() . '/languages' );

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Add default posts and comments RSS feed links to <head>.
		add_theme_support( 'automatic-feed-links' );

		// Add custom menus.
		register_nav_menus( array(
				'main_menu'   => __( 'Main Menu', 'karakuri' ),
				'footer_menu' => __( 'Footer Menu', 'karakuri' ),
			) );

		// Add support for custom backgrounds.
		add_theme_support( 'custom-background', array(
				'default-color' => 'f2f2f2',
			) );

		// Add support for custom headers.
		$defaults = array(
			'default-image' => get_template_directory_uri() . '/images/headers/nape-beauty.jpg',
			'width'         => apply_filters( 'karakuri_header_image_width', 980 ),
			'height'        => apply_filters( 'karakuri_header_image_height', 300 ),
			'header-text'   => false,
		);
		add_theme_support( 'custom-header', $defaults );

		// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
		register_default_headers( array(
				'nape-beauty' => array(
					'url' => '%s/images/headers/nape-beauty.jpg',
					'thumbnail_url' => '%s/images/headers/nape-beauty-thumbnail.jpg',
					/* translators: header image description */
					'description' => __( 'Nape beauty', 'karakuri' )
				),
				'shukuba' => array(
					'url' => '%s/images/headers/shukuba.jpg',
					'thumbnail_url' => '%s/images/headers/shukuba-thumbnail.jpg',
					/* translators: header image description */
					'description' => __( 'Shukuba', 'karakuri' )
				),
				'water-wheel' => array(
					'url' => '%s/images/headers/water-wheel.jpg',
					'thumbnail_url' => '%s/images/headers/water-wheel-thumbnail.jpg',
					/* translators: header image description */
					'description' => __( 'Water wheel', 'karakuri' )
				),
				'chounai' => array(
					'url' => '%s/images/headers/chounai.jpg',
					'thumbnail_url' => '%s/images/headers/chounai-thumbnail.jpg',
					/* translators: header image description */
					'description' => __( 'Chounai', 'karakuri' )
				),
				'hei' => array(
					'url' => '%s/images/headers/hei.jpg',
					'thumbnail_url' => '%s/images/headers/hei-thumbnail.jpg',
					/* translators: header image description */
					'description' => __( 'Hei', 'karakuri' )
				),
				'noren' => array(
					'url' => '%s/images/headers/noren.jpg',
					'thumbnail_url' => '%s/images/headers/noren-thumbnail.jpg',
					/* translators: header image description */
					'description' => __( 'Noren', 'karakuri' )
				),
			) );

		add_theme_support( 'post-thumbnails' );
		add_image_size( 'archive-thumb', 184, 99999 );

		add_theme_support( 'infinite-scroll', array(
				'container'  => 'content',
				'footer'     => 'page',
			) );

	}
}

if ( !function_exists( 'karakuri_theme_require' ) ) {
	add_action( 'after_setup_theme', 'karakuri_theme_require' );
	function karakuri_theme_require() {
		/* require function */
		$dir = get_template_directory() . '/include/';
		$handle = opendir( $dir );
		while ( false !== ( $ent = readdir( $handle ) ) ) {
			if ( !is_dir( $ent ) && strtolower( substr( $ent, -4 ) ) == ".php" ) {
				require $dir . $ent;
			}
		}
		closedir( $handle );
	}
}

if ( !function_exists( 'karakuri_file_time_stamp' ) ) {
	function karakuri_file_time_stamp( $file = null, $path = null, $child = false ) {
		if ( !$path && $child )
			$path = get_stylesheet_directory();

		if ( !$path && !$child )
			$path = get_template_directory();

		$value = null;
		$file = $path . '/' . $file;
		if ( file_exists( $file ) ) {
			$value = filemtime( $file );
		}
		return $value;
	}
}

/**
 * Widget list filter
 *
 * @since Karakuri 1.0
 */
add_filter( 'wp_list_categories', 'karakuri_count_span_list' );
function karakuri_count_span_list( $links ) {
	return preg_replace( '/(<a.+\))/u', '<span>$1</span>', $links );
}

add_filter( 'widget_archives_args', 'karakuri_widget_archives_count_span' );
function karakuri_widget_archives_count_span( $args ) {
	$args['before'] = '<span>';
	$args['after'] = '</span>';
	return $args;
}

add_filter( 'wp_list_bookmarks', 'karakuri_link_rating_span_list' );
function karakuri_link_rating_span_list( $output ) {
	$output = str_replace('<li>', '<li><span>', $output);
	$output = str_replace('</li>', '</span></li>', $output);
	return $output;
}

