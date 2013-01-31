			</div>
			<?php get_sidebar(); ?>
			<footer id="colophon" role="contentinfo">
				<div id="in-footer">
					<?php if ( has_nav_menu( 'footer_menu' ) ) : ?>
					<nav id="footer-nav" class="footer-navigation" role="navigation">
						<h3><?php esc_html( _e( 'Footer menu', 'karakuri' ) ); ?></h3>
						<?php karakuri_footer_nav(); ?>
					</nav>
					<?php endif; ?>
					<?php copyright(); ?>
				</div>
			</footer>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>