// JavaScript Document
jQuery(document).ready(function($) {
	setTimeout('scrollTo(0,1)',100);
	var w = $(window).width();
	var h = $(window).height();
	var h = eval( h ) + 60;
	if ( w < 1024 ) {
		$('div#page').wrap("<div id='viewport'></div>");
		$('div#viewport').append('<div id="side-box"></div>');
		$('div#side-box').css({'height':h});
		$('header#masthead div#header-search-box').appendTo('div#side-box');
		$('nav#main-nav div').appendTo('div#side-box');
		$('div#footer-widget').appendTo('div#side-box');
	}
	$(window).resize(function(){
		var w = $(window).width();
		if ( w < 1024 ) {
			if( !$('div#viewport').size()>0 ) {
				$('div#page').wrap("<div id='viewport'></div>");
			}
			if( !$('div#side-box').size()>0 ) {
				$('div#viewport').append('<div id="side-box"></div>');
			}
			$('div#side-box').css({'height':h});
			if( !$('div#side-box div').size()>0 ) {
				$('nav#main-nav div').prependTo('div#side-box');
			}
			if( !$('div#side-box div#header-search-box').size()>0 ) {
				$('header#masthead div#header-search-box').prependTo('div#side-box');
			}
			if( !$('div#side-box div#footer-widget').size()>0 ) {
				$('div#footer-widget').appendTo('div#side-box');
			}
		} else {
			if( $('div#viewport').size()>0 ) {
				$('div#page').unwrap();
			}
			if( $('div#side-box div#header-search-box').size()>0 ) {
				$('div#side-box div#header-search-box').insertAfter('header#masthead hgroup');
			}
			if( $('div#side-box div#footer-widget').size()>0 ) {
				$('div#side-box div#footer-widget').insertAfter('div#main');
			}
			if( $('div#side-box div').size()>0 ) {
				$('div#side-box div').appendTo('nav#main-nav');
			}
			$('div#page').removeAttr('style');
			$('nav#main-nav').removeAttr('style');
			$('div#side-box').remove();
		}
	});
	$('nav#main-nav h3.menu-toggle').on('click', 'span', function() {
		setTimeout(scrollTo, 100, 0, 1);
		var position = $('nav#main-nav').offset().top;
		var position = eval( -position );
		var scroll = $('div#page').css('margin-top').replace('-','').replace('px','');
		var w = $('div#page').width();
		if ($(this).is('.open')) {
			$(this).removeClass('open');
			$('div#page').animate({
				'marginLeft': '0px'
			});
			$('nav#main-nav').animate({
				'left': '0'
			});
			$('div#side-box').animate({
				'left': '-240px',
				'scrollTop': '0'
			});
			setTimeout(function(){
				$('div#viewport').removeAttr('style');
				$('div#page').removeAttr('style');
				$('div#side-box').removeAttr('style');
				$('div#side-box').scrollTop(0);
				$('body').scrollTop( scroll );
			},500);
		} else {
			$(this).addClass('open');
			$('div#viewport').css({'height':h,'overflow':'hidden'});
			$('div#page').css({'width':w,'margin-top' : position});
			$('div#side-box').css({'height': h, 'display': 'block', 'top': 0});
			$('div#header-search-box, nav#main-nav div, div#footer-widget').css({'display':'block'});
			$('div#page').animate({
				'marginLeft': '240px'
			});
			$('nav#main-nav').animate({
				'left': '240px'
			});
			$('div#side-box').animate({
				'left': 0
			});
		}
	});
	/* pagetop */
	$('div#scrolltop a').click(function() {
		$('html, body').animate({
			'scrollTop': '0'
		}, 200, 'linear');
		return false;
	});
});