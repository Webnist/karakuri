<?php if ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) ) : ?>
	<div id="footer-widget" class="widget-area" role="complementary">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="footer-widget-first">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
		<div id="footer-widget-second">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div>
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
		<div id="footer-widget-third">
			<?php dynamic_sidebar( 'sidebar-3' ); ?>
		</div>
	<?php endif; ?>
	</div>
<?php endif; ?>
