<?php get_header(); ?>
	<div id="content" role="main">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; ?>
			<?php comments_template( '', true ); ?>
		<?php else : ?>
			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Found article you are looking for.', 'karakuri' ); ?></h1>
				</header><!-- .entry-header -->
				<div class="entry-content">
					<p><?php _e( 'The requested content was not found. You may find if you search for relevant posts.', 'karakuri' ); ?></p>
				<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->
		<?php endif; ?>
	</div><!-- #content -->
<?php get_footer(); ?>
