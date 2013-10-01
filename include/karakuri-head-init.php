<?php
/**
 * Name: KARAKURI wp_head load
 * Description: load the wp_head function settings
 * Author: Webnist
 * Version: 0.7.1.0
 * @package WordPress
 * @subpackage Karakuri
**/

/* Head
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/**
 * karakuri_wp_title
 *
 * @Filter to wp_title
 * @Referring to Twenty Twelve 1.0
 */
add_filter( 'wp_title', 'karakuri_wp_title', 10, 2 );
function karakuri_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = $site_description . $sep . $title;

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = sprintf( __( 'Page %s', 'karakuri' ), max( $paged, $page ) ) . $sep . $title;

	return $title;
}

/**
 * karakuri_head_mobile_meta
 *
 * @Action to wp_head
 */
add_action( 'wp_head', 'karakuri_head_mobile_meta' );
function karakuri_head_mobile_meta() {
	echo <<< EOT
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
EOT;
}

/**
 * karakuri_head_script
 *
 * @Action to wp_head
 */
add_action( 'wp_head', 'karakuri_head_script' );
function karakuri_head_script() {
	$template_directory_uri = get_template_directory_uri();
	echo <<< EOT
<!--[if lt IE 9]>
	<script src="{$template_directory_uri}/js/html5shiv.js" type="text/javascript"></script>
<![endif]-->
EOT;
}

/**
 * Enqueues scripts and styles for front-end.
 *
 * @Referring to Twenty Twelve 1.0
 */
add_action( 'wp_enqueue_scripts', 'karakuri_scripts_styles' );
function karakuri_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Loads our main theme common script.
	 */
	wp_enqueue_script( 'common-script', get_template_directory_uri() . '/js/common.min.js', array( 'jquery' ), karakuri_file_time_stamp( 'js/common.min.js' ), true );

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'karakuri-style', get_template_directory_uri() . '/style.css' , array(), karakuri_file_time_stamp( 'style.css' ) );

}