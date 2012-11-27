<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
		<![endif]-->
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="page" class="hfeed site">
			<header id="masthead" class="site-header" role="banner">
				<hgroup>
					<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
				</hgroup>
				<div id="header-search-box">
					<?php get_search_form(); ?>
				</div>
				<nav id="main-nav" class="header-navigation" role="navigation">
					<h3 class="menu-toggle"><span>Main menu</span></h3>
					<a class="assistive-text" href="#content" title="Skip to content">Skip to content</a>
					<?php karakuri_main_nav(); ?>
				</nav>
			</header>
			<?php karakuri_main_img(); ?>
			<div id="main" class="wrapper">
