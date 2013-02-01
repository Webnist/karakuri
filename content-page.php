<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<section class="entry-content">
		<?php the_content(); ?>
		<?php karakuri_link_pages(); ?>
	</section>
</article>
