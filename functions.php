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
		'header-text'   => true,
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

	add_theme_support( 'infinite-scroll', array(
			'container'  => 'content',
			'footer'     => 'page',
		) );
	remove_action( 'get_footer', 'footer' );

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
	wp_enqueue_script( 'common-script', get_template_directory_uri() . '/js/common.min.js', array( 'jquery' ), get_file_time( 'js/common.min.js' ), true );

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'karakuri-style', get_template_directory_uri() . '/style.css' , array(), get_file_time( 'style.css' ) );

}

/* Header
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/* karakuri_main_nav */
function karakuri_main_nav() {
	echo get_karakuri_main_nav();
}

/* get_karakuri_main_nav */
function get_karakuri_main_nav() {
	$output = wp_nav_menu( array( 'container_id' => 'main-nav-box', 'echo' => false, 'theme_location' => 'main_menu' ) );
	return $output;
}

/* karakuri_main_img */
function karakuri_main_img() {
	echo get_karakuri_main_img();
}

/* get_karakuri_main_img */
function get_karakuri_main_img() {
	$header_image = get_header_image();
	if ( is_home() || is_front_page() ) {
		$output = '<p id="main-img"><img src="' . esc_url( $header_image ) . '" alt="' . esc_attr( get_bloginfo( 'description', 'display' ) ) . '"></p>';
		return $output;
	}
}

/* Common
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
function entry_thumbnail() {
	echo get_entry_thumbnail();
}

function get_entry_thumbnail() {
	$id     = get_the_ID();
	$size   = 'archive-thumb';
	$width  = 184;
	$height = 104;
	$output = '<div class="thumb">' . "\n";
	$output .= '<a href="' . get_permalink( $id ) . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'karakuri' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark">' . "\n";
	if ( has_post_thumbnail( $id ) ) {
		$output .= get_the_post_thumbnail( $id, 'archive-thumb' ) . "\n";
	} else {
		$output .= '<img src="' . get_template_directory_uri() . '/images/other/no-image.png" alt="' . the_title_attribute( 'echo=0' ) . '" width="' . $width . '" height="' . $height . '">' . "\n";
	}
	$output .= '</a>' . "\n";
	if ( is_sticky() && is_home() && ! is_paged() ) {
		$output .= '<p class="featured-post"><span>' . __( 'Featured post', 'karakuri' ) . '</span></p>' . "\n";
	}
	$output .= '</div>' . "\n";
	return apply_filters( 'entry_thumbnail', $output, $size, $width, $height );
}

function entry_data() {
	echo get_entry_data();
}
function get_entry_data() {
	$output = '<p class="entry-date"><time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time></p>';
	return apply_filters( 'entry_date', $output );
}

function entry_terms( $term_name = 'category' ) {
	echo get_entry_terms( $term_name );
}
function get_entry_terms( $term_name = 'category' ) {
	$id = get_the_ID();
	$terms = get_the_terms( $id, $term_name );
	if ( $term_name == 'post_tag' )
		$term_name = 'tags';

	$separator  = ', ';
	$output     = '';
	$html        = '';
	if ( $terms ) {
		$output .= '<p class="posted-in-' . $term_name . '">' . "\n";
		foreach ( $terms as $term ) {
			$html .= '<a href="' . get_term_link( (int) $term->term_id, $term->taxonomy ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'karakuri' ), $term->name ) ) . '" rel="' . esc_attr( $term_name ) . '">' . esc_html( $term->name ) . '</a>' . $separator;
		}
		$output .= trim( $html, $separator );
		$output .= '</p>' . "\n";
		return $output;
	}

}

function entry_author() {
	echo get_entry_author();
}
function get_entry_author() {
	$output = '<p class="entry-author">' . "\n";
	$output .= '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . "\n";
	$output .= get_the_author() . "\n";
	$output .= '</a></p>' . "\n";
	return apply_filters( 'entry_author', $output );
}

function entry_comments() {
	if ( comments_open() ) {
		echo '<p class="comments-link">' . "\n";
		echo comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'karakuri' ) . '</span>', __( '1 Reply', 'karakuri' ), __( '% Replies', 'karakuri' ) ) . "\n";
		echo '</p>' . "\n";
	}
}

function entry_more_link( $post_id = null ) {
	echo get_entry_more_link( $post_id );
}

function get_entry_more_link( $post_id = null ) {
	if ( ! $post_id )
		$post_id = get_the_ID();

	return '<p class="entry-more"><a href="'. get_permalink( $post_id ) . '">' . __( 'Read more &raquo;', 'themes' ) . '</a></p>';
}

function entry_edit_post_link() {
	edit_post_link( __( 'Edit', 'karakuri' ), '<p class="edit-link">', '</p>' );
}

function karakuri_content_nav() {
	echo get_karakuri_content_nav();
}
function get_karakuri_content_nav() {
	global $wp_query;
	$output = '';
	if ( $wp_query->max_num_pages > 1 ) {
		$separator = ( get_next_posts_link() && get_previous_posts_link() ) ? ' / ' : '';

		$output .= '<nav id="archive-nav">' . "\n";
		if ( get_previous_posts_link() )
			$output .= '<p class="nav-previous">' . get_previous_posts_link( __( 'Prev', 'karakuri' ) ) . $separator . '</p>' . "\n";

		if ( get_next_posts_link() )
			$output .= '<p class="nav-next">' . get_next_posts_link( __( 'Next', 'karakuri' ) ) . '</p>' . "\n";

		$output .= '</nav>' . "\n";
	} elseif ( is_single() ) {
		$next = get_adjacent_post();
		$previous = get_adjacent_post( false, '', false );
		$separator = ( $next && $previous ) ? ' / ' : '';
		$output .= '<nav id="single-nav">' . "\n";
		if ( $previous )
			$output .= '<p class="nav-previous"><a href="' . esc_url( get_permalink( $previous->ID ) ) . '">' . esc_html( __( 'Prev', 'karakuri' ) ) . '</a>' . $separator . '</p>' . "\n";

		if ( $next )
			$output .= '<p class="nav-next"><a href="' . esc_url( get_permalink( $next->ID ) ) . '">' . esc_html( __( 'Next', 'karakuri' ) ) . '</a></p>' . "\n";

		$output .= '</nav>' . "\n";
	}
	return $output;
}

/* Archive
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/* archive_title */
function archive_title() {
	echo get_archive_title();
}

/* get_archive_title */
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
		elseif ( is_tax() ) :
			$output .= sprintf( __( 'Taxonomy Archives: %s', 'karakuri' ), '<span>' . single_term_title( '', false ) . '</span>' );
		elseif ( is_post_type_archive() ) :
			$output .= sprintf( __( 'Post Type Archives: %s', 'karakuri' ), '<span>' . post_type_archive_title( '', false ) . '</span>' );
		elseif ( is_search() ) :
			$output .= sprintf( __( 'Search Results for: %s %s', 'karakuri' ), get_search_query(), $wp_query->found_posts );
		elseif ( is_author() ) :
			$user_id = get_query_var( 'author' );
			$user_name = get_userdata( $user_id );
			$user_name = $user_name->display_name;
			$user_avatar = get_avatar( $user_id, 18 );
			$output .= '<span class="avatar">' . $user_avatar . '</span>';
			$output .= sprintf( __( 'Author Archives: %s', 'karakuri' ), $user_name );
		else :
			$output = __( 'Archives', 'karakuri' );
		endif;
		$output .= '</h1>' . "\n";
		$output .= '</header>' . "\n";
	}
	return $output;
}

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
			$output .= _wp_link_page( $i );
			$output .= ' &laquo;</a>';
		}
		$i = $page + 1;
		$output .= wp_link_pages( array( 'before' => '', 'after' => '', 'link_before' => '<span>', 'link_after' => '</span>', 'echo' => 0 ) );
		if ( $i <= $numpages && $more ) {
			$output .= _wp_link_page( $i );
			$output .= ' &raquo;</a>';
		}
		$output .= '</div>' ."\n";
	}
	return $output;
}

/* Page
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* Comment
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/**
 * Comment Template
 *
 * @Referring to Twenty Twelve 1.0
 */
function karakuri_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'karakuri' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'karakuri' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 62 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'karakuri' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'karakuri' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'karakuri' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'karakuri' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply &darr;', 'karakuri' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}

/* HOME
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* Footer
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/* karakuri_footer_nav */
function karakuri_footer_nav() {
	echo get_karakuri_footer_nav();
}

/* get_karakuri_footer_nav */
function get_karakuri_footer_nav() {
	$output = wp_nav_menu( array( 'container_id' => 'footer-nav-box', 'echo' => false, 'theme_location' => 'footer_menu' ) );
	return $output;
}

/* copyright */
function copyright( $year = null ) {
	echo get_copyright( $year );
}

/* get_copyright */
function get_copyright( $year = null ) {
	$output = '<p id="copyright"><small>&copy; ' . get_copyright_year( $year ) . ' ' . esc_html( get_bloginfo( 'name', 'display' ) ) . '</small></p>' . "\n";
	return $output;
}

/* copyright_year */
function copyright_year( $year = null ) {
	echo get_copyright_year( $year );
}

/* get_copyright_year */
function get_copyright_year( $year = null ) {
	$year = (int) apply_filters( 'copyright_year', $year );
	if ( !$year )
		$year = (int) date_i18n( 'Y' );

	$get_year = (int) date_i18n( 'Y' );
	if ( $get_year == $year ) {
		$output = $year;
	} else {
		$output = $year . ' - ' . date_i18n( 'Y' );
	}
	return $output;
}

/* Other
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/**
 * get_file_time
 * Browser cache file protection.
 *
 * @since Karakuri 1.0
 */
function get_file_time( $file = null, $path = null ) {
	if ( !$path )
		$path = get_template_directory();

	$value = filemtime( $path . '/' . $file );
	return $value;
}

/**
 * Widget list filter
 *
 * @since Karakuri 1.0
 */
add_filter( 'wp_list_categories', 'wp_count_span_list' );
function wp_count_span_list( $links ) {
	return preg_replace( '/(<a.+\))/u', '<span>$1</span>', $links );
}

add_filter( 'widget_archives_args', 'widget_archives_count_span' );
function widget_archives_count_span( $args ) {
	$args['before'] = '<span>';
	$args['after'] = '</span>';
	return $args;
}

add_filter( 'wp_list_bookmarks', 'wp_link_rating_span_list' );
function wp_link_rating_span_list( $output ) {
	$output = str_replace('<li>', '<li><span>', $output);
	$output = str_replace('</li>', '</span></li>', $output);
	return $output;
}

