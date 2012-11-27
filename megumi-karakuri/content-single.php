<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php the_content(); ?>
		<?php karakuri_link_pages(); ?>
	</div><!-- .entry-summary -->
	<footer class="entry-meta">
		<p class="thumb">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'archive-thumb' ); ?>
		<?php else : ?>
			<img src="<?php echo get_template_directory_uri(); ?>/images/other/no-image.png" alt="<?php printf( esc_attr__( 'Permalink to %s', 'karakuri' ), the_title_attribute( 'echo=0' ) ); ?>" width="184" height="104">
		<?php endif; ?>
		</p>
		<p class="entry-date"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
		<?php if ( get_the_category() ) : ?>
			<p class="posted-in-category"><?php the_category( ', ' ); ?></p>
		<?php endif; ?>
		<?php if ( get_the_tags() ) : ?>
			<p class="posted-in-tags"><?php the_tags( '', ', ' ); ?></p>
		<?php endif; ?>
		<p class="entry-author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
		<?php the_author(); ?>
		</a></p>
		<?php edit_post_link( __( 'Edit', 'karakuri' ), '<p class="edit-link">', '</p>' ); ?>
	</footer>
</article><!-- #post-<?php the_ID(); ?> -->
