<?php get_header(); ?>
<div id="content" role="main">
	<?php archive_title(); ?>
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'content', get_post_format() );
			?>
		<?php endwhile; ?>
	<?php else : ?>
		<article id="post-0" class="post no-results not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Found article you are looking for.', 'karakuri' ); ?></h1>
			</header><!-- .entry-header -->
			<div id="entry-content">
				<p><?php _e( 'The requested content was not found. You may find if you search for relevant posts.', 'karakuri' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- #entry-content -->
		</article><!-- #post-0 -->
	<?php endif; ?>
</div><!-- #content -->
<?php karakuri_content_nav(); ?>
<?php get_footer(); ?>
