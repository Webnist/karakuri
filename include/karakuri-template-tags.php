<?php
/**
 * Name: KARAKURI Template tags
 * Description: Template tags
 * Author: Webnist
 * Version: 0.7.1.0
 * @package WordPress
 * @subpackage Karakuri
 * 1. Header tags
 * 2. Common tags
 * 3. HOME tags
 * 4. Archive tags
 * 5. Single tags
 * 6. Page tags
 * 7. Footer tags
**/

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 1. Header tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
## karakuri_global_nav
function karakuri_global_nav() {
	echo get_karakuri_global_nav();
}

## get_karakuri_global_nav
function get_karakuri_global_nav() {
	$output = wp_nav_menu( array( 'container_id' => 'global-nav-box', 'echo' => false, 'theme_location' => 'global-menu' ) );
	return $output;
}

## karakuri_main_img
function karakuri_main_img() {
	echo get_karakuri_main_img();
}

## get_karakuri_main_img
function get_karakuri_main_img() {
	$header_image = get_header_image();
	if ( $header_image && (is_home() || is_front_page()) ) {
		$output = '<p id="main-img"><img src="' . esc_url( $header_image ) . '" alt="' . esc_attr( get_bloginfo( 'description', 'display' ) ) . '"></p>';
		return $output;
	}
}

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 2. Common tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
## karakuri_entry_thumbnail
function karakuri_entry_thumbnail() {
	echo get_karakuri_entry_thumbnail();
}

## get_karakuri_entry_thumbnail
function get_karakuri_entry_thumbnail() {
	$id     = get_the_ID();
	$size   = 'archive-thumb';
	$width  = 184;
	$height = 104;
	$output = '<div class="thumb">' . "\n";
	$output .= '<a href="' . get_permalink( $id ) . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'karakuri' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark">' . "\n";
	if ( has_post_thumbnail( $id ) ) {
		$output .= get_the_post_thumbnail( $id, $size ) . "\n";
	} else {
		$src = apply_filters('karakuri_no-image', get_template_directory_uri() . '/images/other/no-image.png', $width, $height);
		$output .= '<img src="' . $src . '" alt="' . the_title_attribute( 'echo=0' ) . '" width="' . $width . '" height="' . $height . '">' . "\n";
	}
	$output .= '</a>' . "\n";
	if ( is_sticky() && is_home() && ! is_paged() ) {
		$output .= '<p class="featured-post"><span>' . __( 'Featured post', 'karakuri' ) . '</span></p>' . "\n";
	}
	$output .= '</div>' . "\n";
	return apply_filters( 'entry_thumbnail', $output, $size, $width, $height );
}

## karakuri_entry_data
function karakuri_entry_data() {
	echo get_karakuri_entry_data();
}

## get_karakuri_entry_data
function get_karakuri_entry_data() {
	$output = '<p class="entry-date"><time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time></p>';
	return apply_filters( 'karakuri_entry_date', $output );
}

## karakuri_entry_terms
function karakuri_entry_terms( $term_name = 'category' ) {
	echo get_karakuri_entry_terms( $term_name );
}
## get_karakuri_entry_terms
function get_karakuri_entry_terms( $term_name = 'category' ) {
	$id = get_the_ID();
	if ( $term_name == 'post_tag' ) {
		$terms = get_the_tags( $id );
		$term_name = 'tags';
	} else {
		$terms = get_the_terms( $id, $term_name );
	}

	$separator  = ', ';
	$output     = '';
	$html       = '';
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

## karakuri_entry_author
function karakuri_entry_author() {
	echo get_karakuri_entry_author();
}
## get_karakuri_entry_author
function get_karakuri_entry_author() {
	$output = '<p class="entry-author">' . "\n";
	$output .= '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . "\n";
	$output .= get_the_author() . "\n";
	$output .= '</a></p>' . "\n";
	return apply_filters( 'karakuri_entry_author', $output );
}

## karakuri_entry_comments
function karakuri_entry_comments() {
	if ( comments_open() ) {
		echo '<p class="comments-link">' . "\n";
		echo comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'karakuri' ) . '</span>', __( '1 Reply', 'karakuri' ), __( '% Replies', 'karakuri' ) ) . "\n";
		echo '</p>' . "\n";
	}
}

## karakuri_entry_more_link
function karakuri_entry_more_link( $post_id = null ) {
	echo get_karakuri_entry_more_link( $post_id );
}

## get_karakuri_entry_more_link
function get_karakuri_entry_more_link( $post_id = null ) {
	if ( ! $post_id )
		$post_id = get_the_ID();

	return '<p class="entry-more"><a href="'. get_permalink( $post_id ) . '">' . __( 'Read more &raquo;', 'themes' ) . '</a></p>';
}

## karakuri_entry_edit_post_link
function karakuri_entry_edit_post_link() {
	edit_post_link( __( 'Edit', 'karakuri' ), '<p class="edit-link">', '</p>' );
}

## karakuri_content_nav
function karakuri_content_nav() {
	echo get_karakuri_content_nav();
}

## get_karakuri_content_nav
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
		$next = get_adjacent_post( false, '', false );
		$previous = get_adjacent_post();
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

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 3. HOME tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 4. Archive tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/* karakuri_archive_title */
function karakuri_archive_title() {
	echo get_karakuri_archive_title();
}

/* get_karakuri_archive_title */
function get_karakuri_archive_title() {
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

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 5. Single tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
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

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 6. Page tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
# 7. Footer tags
/* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/* karakuri_footer_nav */
function karakuri_footer_nav() {
	echo get_karakuri_footer_nav();
}

/* get_karakuri_footer_nav */
function get_karakuri_footer_nav() {
	$output = wp_nav_menu( array( 'container_id' => 'footer-nav-box', 'echo' => false, 'theme_location' => 'footer_menu' ) );
	return $output;
}

/* karakuri_copyright */
function karakuri_copyright( $year = null ) {
	echo get_karakuri_copyright( $year );
}

/* get_karakuri_copyright */
function get_karakuri_copyright( $year = null ) {
	$output = '<p id="copyright"><small>&copy; ' . get_karakuri_copyright_year( $year ) . ' ' . esc_html( get_bloginfo( 'name', 'display' ) ) . '</small></p>' . "\n";
	return $output;
}

/* karakuri_copyright_year */
function karakuri_copyright_year( $year = null ) {
	echo get_karakuri_copyright_year( $year );
}

/* get_karakuri_copyright_year */
function get_karakuri_copyright_year( $year = null ) {
	$year = (int) apply_filters( 'karakuri_copyright_year', $year );
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
