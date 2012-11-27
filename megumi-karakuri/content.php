<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'karakuri' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header><!-- .entry-header -->
	<div class="entry-summary">
		<?php the_excerpt(); ?>
		<?php excerpt_more_linl(); ?>
	</div><!-- .entry-summary -->
	<footer class="entry-meta">
		<div class="thumb"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'karakuri' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'archive-thumb' ); ?>
		<?php else : ?>
			<img src="<?php echo get_template_directory_uri(); ?>/images/other/no-image.png" alt="<?php printf( esc_attr__( 'Permalink to %s', 'karakuri' ), the_title_attribute( 'echo=0' ) ); ?>" width="184" height="104">
		<?php endif; ?>
		</a>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<p class="featured-post"><span>
			<?php _e( 'Featured post', 'karakuri' ); ?>
		</span></p>
		<?php endif; ?>
		</div>
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
		<?php if ( comments_open() ) : ?>
			<p class="comments-link">
				<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'karakuri' ) . '</span>', __( '1 Reply', 'karakuri' ), __( '% Replies', 'karakuri' ) ); ?>
			</p><!-- .comments-link -->
		<?php endif; // comments_open() ?>
		<?php excerpt_more_linl(); ?>
		<?php edit_post_link( __( 'Edit', 'karakuri' ), '<p class="edit-link">', '</p>' ); ?>
	</footer>
</article><!-- #post-<?php the_ID(); ?> -->
