<?php
/**
 * Name: KARAKURI Widgets init
 * Description: Widget settings
 * Author: Webnist
 * Version: 0.7.1.0
 * @package WordPress
 * @subpackage Karakuri
**/

/* karakuri_widgets_init */
if ( !function_exists( 'karakuri_widgets_init' ) ) :
	add_action( 'widgets_init', 'karakuri_widgets_init' );

function karakuri_widgets_init() {

	register_sidebar( array(
			'name' => __( 'Footer Widget First', 'karakuri' ),
			'id' => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget-content %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

	register_sidebar( array(
			'name' => __( 'Footer Widget Second', 'karakuri' ),
			'id' => 'sidebar-2',
			'before_widget' => '<aside id="%1$s" class="widget-content %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

	register_sidebar( array(
			'name' => __( 'Footer Widget Third', 'karakuri' ),
			'id' => 'sidebar-3',
			'before_widget' => '<aside id="%1$s" class="widget-content %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

}
endif;
