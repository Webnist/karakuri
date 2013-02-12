<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
	<section class="entry-content">
		<?php the_content(); ?>
		<?php karakuri_link_pages(); ?>
	</section><!-- .entry-content -->
	<footer class="entry-meta">
		<?php entry_thumbnail(); ?>
		<?php entry_data(); ?>
		<?php entry_terms(); ?>
		<?php entry_terms( 'post_tag' ); ?>
		<?php entry_author(); ?>
		<?php entry_comments(); ?>
		<?php entry_more_link(); ?>
		<?php entry_edit_post_link(); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
