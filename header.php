<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php do_action( 'before_karakuri_body' ); ?>
		<div id="page" class="hfeed site">
			<?php do_action( 'before_karakuri_page' ); ?>
			<header id="masthead" class="site-header" role="banner">
				<?php do_action( 'before_karakuri_header' ); ?>
				<div id="site-meta">
					<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div>
				<div id="header-search-box">
					<?php get_search_form(); ?>
				</div><!-- #header-search-box -->
				<nav id="global-nav" class="header-navigation" role="navigation">
					<h3 class="menu-toggle"><span><?php esc_html( _e( 'Main menu', 'karakuri' ) ); ?></span></h3>
					<a class="assistive-text" href="#content" title="Skip to content"><span>Skip to content</span></a>
					<?php karakuri_global_nav(); ?>
				</nav><!-- #main-nav -->
				<?php do_action( 'after_karakuri_header' ); ?>
				<?php karakuri_main_img(); ?>
			</header><!-- #masthead -->
			<?php do_action( 'karakuri_header_after' ); ?>
			<div id="main" class="wrapper">
				<?php do_action( 'before_karakuri_main' ); ?>
