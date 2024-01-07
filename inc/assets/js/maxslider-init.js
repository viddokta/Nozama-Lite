jQuery(function ($) {
	'use strict';

	var $window = $(window);
	var $body = $('body');
	var isRTL = $body.hasClass('rtl');

	$window.on('load', function () {
		/* -----------------------------------------
		 Hero Slideshow
		 ----------------------------------------- */
		var $heroSlideshow = $('.page-hero-slideshow');
		var navigation = $heroSlideshow.data('navigation');
		var effect = $heroSlideshow.data('effect');
		var speed = $heroSlideshow.data('slide-speed');
		var auto = $heroSlideshow.data('autoslide');

		if ($heroSlideshow.length) {
			$heroSlideshow.slick({
				arrows: navigation === 'arrows' || navigation === 'both',
				dots: navigation === 'dots' || navigation === 'both',
				fade: effect === 'fade',
				autoplaySpeed: speed,
				autoplay: auto === true,
				slide: '.page-hero',
				rtl: isRTL,
				appendArrows: '.page-hero-slideshow-nav',
				prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
				nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
				responsive: [
					{
						breakpoint: 992,
						settings: {
							dots: true,
						}
					},
				]
			});
		}
	});
});