<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
	<section class="entry-content">
		<?php the_content(); ?>
		<?php karakuri_link_pages(); ?>
	</section><!-- .entry-content -->
	<footer class="entry-meta">
		<?php karakuri_entry_thumbnail(); ?>
		<?php karakuri_entry_data(); ?>
		<?php karakuri_entry_terms(); ?>
		<?php karakuri_entry_terms( 'post_tag' ); ?>
		<?php karakuri_entry_author(); ?>
		<?php karakuri_entry_comments(); ?>
		<?php karakuri_entry_more_link(); ?>
		<?php karakuri_entry_edit_post_link(); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
