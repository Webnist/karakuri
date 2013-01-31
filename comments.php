<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'karakuri' ); ?></p>
	</div><!-- #comments -->
	<?php
	return;
endif;
?>

<?php if ( have_comments() && $post->comment_count > 0 ) : ?>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
		<nav id="comment-nav-above">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'karakuri' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'karakuri' ) ); ?></div>
		</nav>
	<?php endif; // check for comment navigation  ?>
	<h2 class="commentlist-title"><?php _e( 'Comment List', 'karakuri' ); ?></h2>
	<ol class="commentlist">
		<?php wp_list_comments(); ?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through  ?>
		<nav id="comment-nav-below">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'karakuri' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'karakuri' ) ); ?></div>
		</nav>
	<?php endif; // check for comment navigation  ?>

	<?php
elseif ( !comments_open() && !is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	<p class="nocomments"><?php _e( 'Comments are closed.', 'karakuri' ); ?></p>
<?php endif; ?>

<?php comment_form(); ?>
</div>
