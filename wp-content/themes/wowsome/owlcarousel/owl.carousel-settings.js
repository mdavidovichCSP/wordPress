/* Our Clients Widget */
jQuery('.widget_ourclients .owl-carousel').owlCarousel({
	loop: true,
	margin: 30,
	nav: false,
	dots: false,
	autoplay: true,
	autoplayTimeout: 2000,
	autoplayHoverPause: true,
	responsive: {
		0:			{ items: 1, margin: 14 },
		480:  	{ items: 2, margin: 14 },
		768:  	{ items: 3 },
		1024:  	{ items: 4 }
	}
})