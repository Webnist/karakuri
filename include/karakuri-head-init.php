<?php
/**
 * Name: KARAKURI wp_head load
 * Description: load the wp_head function settings
 * Author: Webnist
 * Version: 0.7.1.0
 *
 * @package WordPress
 * @subpackage Karakuri
 * */

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
// karakuri_head_viewport_meta
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
// Add the viewport meta tag
add_action( 'wp_head', 'karakuri_head_viewport_meta' );
function karakuri_head_viewport_meta() {
	echo <<< EOT
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
EOT;
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
// karakuri_head_conditional_comment
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
// Conditional comment
add_action( 'wp_head', 'karakuri_head_conditional_comment' );
function karakuri_head_conditional_comment() {
	$template_directory_uri = get_template_directory_uri();
	echo <<< EOT
<!--[if lt IE 9]>
	<script src="{$template_directory_uri}/js/html5shiv.js" type="text/javascript"></script>
<![endif]-->
EOT;
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
// karakuri_scripts_styles
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
// Set the loading of scripts and styles
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
	 * Loads our main theme script.
	 */
	wp_enqueue_script( 'karakuri-script', get_template_directory_uri() . '/js/karakuri-script.js', array( 'jquery' ), karakuri_file_time_stamp( 'js/karakuri-script.js' ), true );

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'karakuri-style', get_template_directory_uri() . '/style.css' , array(), karakuri_file_time_stamp( 'style.css' ) );

}
