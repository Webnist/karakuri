<div id="comments" class="comments-area">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'karakuri' ); ?></p>
	</div><!-- #comments -->
	<?php
	return;
endif;
?>

<?php if ( have_comments() && $post->comment_count > 0 ) : ?>

	<h2 class="commentlist-title"><?php _e( 'Comment List', 'karakuri' ); ?></h2>
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
		<nav id="comment-nav-above">
			<p class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'karakuri' ) ); ?></p>
			<p class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'karakuri' ) ); ?></p>
		</nav><!-- #comment-nav-above -->
	<?php endif; // check for comment navigation  ?>
	<ol class="commentlist">
		<?php wp_list_comments( array( 'callback' => 'karakuri_comment', 'style' => 'ol' ) ); ?>
	</ol><!-- .commentlist -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
		<nav id="comment-nav-below">
			<p class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'karakuri' ) ); ?></p>
			<p class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'karakuri' ) ); ?></p>
		</nav><!-- #comment-nav-below -->
	<?php endif; // check for comment navigation  ?>

	<?php
elseif ( !comments_open() && !is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	<p class="nocomments"><?php _e( 'Comments are closed.', 'karakuri' ); ?></p>
<?php endif; ?>

<?php comment_form(); ?>
</div>
