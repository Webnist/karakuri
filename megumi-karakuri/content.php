<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'karakuri' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header><!-- .entry-header -->
	<div class="entry-summary">
		<?php the_excerpt(); ?>
		<?php entry_more_link(); ?>
	</div><!-- .entry-summary -->
	<footer class="entry-meta">
		<?php do_action( 'entry_footer' ); ?>
	</footer>
</article><!-- #post-<?php the_ID(); ?> -->
