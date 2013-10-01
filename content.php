<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'karakuri' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header><!-- .entry-header -->
	<section class="entry-summary">
		<?php the_excerpt(); ?>
		<?php karakuri_entry_more_link(); ?>
	</section><!-- .entry-summary -->
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
