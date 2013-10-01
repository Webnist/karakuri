<?php
/**
 * Name: KARAKURI Filter
 * Description: Filter settings
 * Author: Webnist
 * Version: 0.7.1.0
 * @package WordPress
 * @subpackage Karakuri
**/

## wp_title filters
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

## wp_list_categories filters
## I surround it with span tag 
add_filter( 'wp_list_categories', 'karakuri_count_span_list' );
function karakuri_count_span_list( $links ) {
	return preg_replace( '/(<a.+\))/u', '<span>$1</span>', $links );
}

## widget_archives_args filters
add_filter( 'widget_archives_args', 'karakuri_widget_archives_count_span' );
function karakuri_widget_archives_count_span( $args ) {
	$args['before'] = '<span>';
	$args['after'] = '</span>';
	return $args;
}

## wp_list_bookmarks filters
add_filter( 'wp_list_bookmarks', 'karakuri_link_rating_span_list' );
function karakuri_link_rating_span_list( $output ) {
	$output = str_replace('<li>', '<li><span>', $output);
	$output = str_replace('</li>', '</span></li>', $output);
	return $output;
}

