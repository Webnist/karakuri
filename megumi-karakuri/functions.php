<?php
/* Set Up
  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/* theme_setup */
if ( !function_exists( 'karakuri_theme_setup' ) ) :
	add_action( 'after_setup_theme', 'karakuri_theme_setup' );

	function karakuri_theme_setup() {
		global $content_width;

		if ( !isset( $content_width ) )
			$content_width = 618;

		load_theme_textdomain( 'karakuri', get_template_directory() . '/languages' );

		// Themes Update Checker
		require( get_template_directory() . '/inc/themes-updater.php' );

		// Themes options
		require( get_template_directory() . '/inc/theme-options.php' );

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Add default posts and comments RSS feed links to <head>.
		add_theme_support( 'automatic-feed-links' );

		// Add custom menus.
		register_nav_menus( array(
			'main_menu' => __( 'Main Menu', 'karakuri' ),
			'footer_menu' => __( 'Footer Menu', 'karakuri' ),
		) );

		// Add support for custom backgrounds.
		add_theme_support( 'custom-background', array(
			'default-color' => 'f2f2f2',
		) );

		// Add support for custom headers.
		$defaults = array(
			'default-image' => get_template_directory_uri() . '/images/headers/nape-beauty.jpg',
			'width' => apply_filters( 'karakuri_header_image_width', 980 ),
			'height' => apply_filters( 'karakuri_header_image_height', 300 ),
			'header-text' => true,
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

		$defaults = array(
			'default-image' => get_template_directory_uri() . '/images/site-logo.png',
		);
		add_theme_support( 'themes-logo', $defaults );

		add_theme_support( 'post-thumbnails' );
		add_image_size( 'archive-thumb', 184, 99999 );
		//set_post_thumbnail_size( 150, 9999 );

	}

endif;

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

/* Head
  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/**
 * karakuri_wp_title
 * @Filter to wp_title
 * @Referring to Twenty Twelve 1.0
 */
add_filter( 'wp_title', 'karakuri_wp_title', 10, 2 );
function karakuri_wp_title( $title, $sep ) {

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
 * head_mobile_meta
 * @Action to wp_head
 */
add_action( 'wp_head', 'head_mobile_meta' );
function head_mobile_meta() {
echo <<< KARAKURI
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
KARAKURI;
}

/**
 * Enqueues scripts and styles for front-end.
 *
 * @Referring to Twenty Twelve 1.0
 */
add_action( 'wp_enqueue_scripts', 'karakuri_scripts_styles' );
function karakuri_scripts_styles() {
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Loads our main stylesheet.
	 */
	//wp_enqueue_style( 'karakuri-style.min', get_template_directory_uri() . '/style.min.css' , array(), get_file_time( 'style.min.css' ) );
	wp_enqueue_style( 'karakuri-style', get_template_directory_uri() . '/style.css' , array(), get_file_time( 'style.css' ) );
}

/* Header
  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/* main_nav */
function karakuri_main_nav() {
	echo get_karakuri_main_nav();
}

/* get_main_nav */
function get_karakuri_main_nav() {
	$output = wp_nav_menu( array( 'container_id' => 'main-nav-box', 'echo' => false, 'theme_location' => 'main_menu' ) );
	return $output;
}

/* main_img */
function karakuri_main_img() {
	echo get_karakuri_main_img();
}

/* get_main_img */
function get_karakuri_main_img() {
	$header_image = get_header_image();
	if ( is_home() || is_front_page() ) {
		$output = '<p id="main-img"><img src="' . esc_url( $header_image ) . '" alt="' . esc_attr( get_bloginfo( 'description', 'display' ) ) . '"></p>';
	}
	return $output;
}

/* Common
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* Archive
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
function archive_title() {
	echo get_archive_title();
}

function get_archive_title() {
	global $wp_query;
	$output = '';
	if ( !is_home() || !is_front_page() ) {
		$output .= '<header class="page-header">' . "\n";
		$output .= '<h1 class="page-title">' . "\n";
		if ( is_day() ) :
			$output .= sprintf( __( 'Daily Archives: %s', 'karakuri' ), '<span>' . get_the_date() . '</span>' );
		elseif ( is_month() ) :
			$output .= sprintf( __( 'Monthly Archives: %s', 'karakuri' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'karakuri' ) ) . '</span>' );
		elseif ( is_year() ) :
			$output .= sprintf( __( 'Yearly Archives: %s', 'karakuri' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'karakuri' ) ) . '</span>' );
		elseif ( is_category() ) :
			$output .= sprintf( __( 'Category Archives: %s', 'karakuri' ), '<span>' . single_cat_title( '', false ) . '</span>' );
		elseif ( is_tag() ) :
			$output .= sprintf( __( 'Tag Archives: %s', 'karakuri' ), '<span>' . single_tag_title( '', false ) . '</span>' );
		elseif ( is_search() ) :
			$output .= sprintf( __( 'Search Results for: %s %s', 'karakuri' ), get_search_query(), $wp_query->found_posts );
		elseif ( is_author() ) :
			$user_id = get_query_var( 'author' );
			$user_name = get_userdata( $user_id );
			$user_name = $user_name->display_name;
			$output .= sprintf( __( 'Author Archives: %s', 'karakuri' ), $user_name );
		else :
			$output = __( 'Blog Archives', 'karakuri' );
		endif;
		$output .= '</h1>' . "\n";
		$output .= '</header>' . "\n";
	}
	return $output;
}

/* excerpt_more_linl */
function excerpt_more_linl( $post_id = Null ) {
	echo get_excerpt_more_linl( $post_id );
}

/* get_excerpt_more_linl */
function get_excerpt_more_linl( $post_id = Null ) {
	if ( ! $post_id )
		$post_id = get_the_ID();
	return '<p class="excerpt_more"><a href="'. get_permalink( $post_id ) . '">' . __( 'Read more &raquo;', 'themes' ) . '</a></p>';	
}

//add_filter( 'excerpt_more', 'new_excerpt_more' );
function new_excerpt_more( $post ) {
	return '...';	
}	

if ( !function_exists( 'karakuri_content_nav' ) ) :

	function karakuri_content_nav() {
		global $wp_query;
		if ( $wp_query->max_num_pages > 1 ) :
			?>
			<nav id="page-nav">
				<?php if ( get_previous_posts_link() ) { ?>
					<div class="nav-next"><?php previous_posts_link( __( '&laquo; Newer posts', 'karakuri' ) ); ?></div>
				<?php } ?>
				<div id="scrolltop"><a href="#page"><?php _e( 'Go TOP', 'karakuri' ); ?></a></div>
				<?php if ( get_next_posts_link() ) { ?>
					<div class="nav-previous"><?php next_posts_link( __( 'Older posts &raquo;', 'karakuri' ) ); ?></div>
				<?php } ?>
			</nav><!-- #nav-above -->
		<?php elseif ( is_single() ) : ?>
			<nav id="nav-single">
				<?php if ( get_adjacent_post() ) { ?>
					<div class="nav-next"><?php previous_post_link( '%link', __( '&laquo; Older posts', 'karakuri' ) ); ?></div>
				<?php } ?>
				<div id="scrolltop"><a href="#page"><?php _e( 'Go TOP', 'karakuri' ); ?></a></div>
				<?php if ( get_adjacent_post( false, '', false ) ) { ?>
					<div class="nav-previous"><?php next_post_link( '%link', __( 'Newer posts &raquo;', 'karakuri' ) ); ?></div>
				<?php } ?>
			</nav><!-- #nav-single -->
			<?php
		endif;
	}

endif;

/* Single
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
function karakuri_link_pages() {
	echo get_karakuri_link_pages();
}
function get_karakuri_link_pages() {
	global $page, $numpages, $multipage, $more, $pagenow;
	$output = '';
	if ( $multipage ) {
		$output .= '<div class="page-links">' ."\n";
		$i = $page - 1;
		if ( $i && $more ) {
			$output .= _wp_link_page($i);
			$output .= ' &laquo;</a>';
		}
		$i = $page + 1;
		$output .= wp_link_pages( array( 'before' => '', 'after' => '', 'link_before' => '<span>', 'link_after' => '</span>', 'echo' => 0 ) );
		if ( $i <= $numpages && $more ) {
			$output .= _wp_link_page($i);
			$output .= ' &raquo;</a>';
		}
		$output .= '</div>' ."\n";
	}
	return $output;
}

/* Page
  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* HOME
  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* Side
  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* Footer
  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* copyright */
function copyright( $year = null ) {
	echo get_copyright( $year );
}

/* get_copyright */

function get_copyright( $year = null ) {
	$output = '<p id="copyright"><small>&copy; ' . get_copyright_year( $year ) . ' ' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '</small></p>' . "\n";
	return $output;
}

/* copyright_year */

function copyright_year( $year = null ) {
	echo get_copyright_year( $year );
}

/* get_copyright_year */

function get_copyright_year( $year = null ) {
	if ( !$year ) {
		$year = date_i18n( 'Y' );
	}
	$get_year = date_i18n( 'Y' );
	if ( $get_year == $year ) {
		$output = $year;
	} else {
		$output = $year . ' - ' . date_i18n( 'Y' );
	}
	return $output;
}

/* add_theme_script_js */
add_action( 'wp_print_scripts', 'add_theme_script_js' );

function add_theme_script_js() {
	if ( !is_admin() ) {
		wp_enqueue_script( 'jquery' );
		//wp_enqueue_script( 'jquery-common', get_template_directory_uri() . '/js/common.js', array( 'jquery' ), '0.7.1.0', true );
		wp_enqueue_script( 'jquery-common', get_template_directory_uri() . '/js/common.js', array( 'jquery' ), get_file_time( 'js/common.js' ), true );
	}
}

/* Other
  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/**
 * get_file_time
 * Browser cache file protection.
 * @since Karakuri 1.0
 */
function get_file_time( $file = null, $path = null ) {
	if ( !$path )
		$path = get_stylesheet_directory();
	
	$value = filemtime( $path . '/' . $file );
	return $value;
}

if ( !function_exists( 'is_mobile_phone' ) ) {
	function is_mobile_phone() {
		if ( preg_match( '/(android |blackberry|\(ip(od|ad|hone);|series |nokia |windows phone os )([0-9\.]+)?/i', $_SERVER['HTTP_USER_AGENT'] ) ) {
			$result = TRUE;
		} else {
			$result = FALSE;
		}
		return $result;
	}
}