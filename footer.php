				<?php do_action( 'after_karakuri_main' ); ?>
			</div><!-- #main -->
			<?php get_sidebar(); ?>
			<footer id="colophon" role="contentinfo">
				<?php do_action( 'before_karakuri_footer' ); ?>
				<?php if ( has_nav_menu( 'footer_menu' ) ) : ?>
				<nav id="footer-nav" class="footer-navigation" role="navigation">
					<h3><?php _e( 'Footer menu', 'karakuri' ); ?></h3>
					<?php karakuri_footer_nav(); ?>
				</nav><!-- #footer-nav -->
				<?php endif; ?>
				<?php karakuri_copyright(); ?>
				<?php do_action( 'after_karakuri_footer' ); ?>
			</footer><!-- #colophon -->
			<?php do_action( 'after_karakuri_page' ); ?>
		</div><!-- #page -->
		<?php wp_footer(); ?>
	</body>
</html>