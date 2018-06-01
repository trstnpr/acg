(function ($) {
	
	"use strict";

	$(document).ready(function() {

		// Comments
		$(".commentlist li").addClass("panel panel-default");
		$(".comment-reply-link").addClass("btn btn-default");
	
		// Forms
		$('select, input[type=text], input[type=email], input[type=password], textarea').addClass('form-control');
		$('input[type=submit]').addClass('btn btn-primary');
		
		// You can put your own code in here

	});

	$('.data-img').each(function() {
		var attr = $(this).attr('data-img');
		if (typeof attr !== typeof undefined && attr !== false) {
			$(this).css('background-image', 'url('+attr+')');
		}
	});

	if (matchMedia) {
		var mq = window.matchMedia('(max-width: 768px)');
		mq.addListener(WidthChange);
		WidthChange(mq);
	}

	function WidthChange(mq) {
		if (mq.matches) {
			$('.bizcat-list').removeClass('in');
			$('.bizadd-list').removeClass('in');
		}
	}

	$('.cat-collapse').click(function() {
		if($('#bizadd-collapse').hasClass('in')) {
			$('#bizadd-collapse').removeClass('in');
		}
	});
	$('.add-collapse').click(function() {
		if($('#bizcat-collapse').hasClass('in')) {
			$('#bizcat-collapse').removeClass('in');
		}
	});

	function new_map( $el ) {
		
		// var
		var $markers = $el.find('.marker');
		
		
		// vars
		var args = {
			zoom		: 16,
			center		: new google.maps.LatLng(0, 0),
			mapTypeId	: google.maps.MapTypeId.ROADMAP
		};
		
		
		// create map	        	
		var map = new google.maps.Map( $el[0], args);
		
		
		// add a markers reference
		map.markers = [];
		
		
		// add markers
		$markers.each(function(){
			
	    	add_marker( $(this), map );
			
		});
		
		
		// center map
		center_map( map );
		
		
		// return
		return map;
		
	}

	function add_marker( $marker, map ) {

		// var
		var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

		// create marker
		var marker = new google.maps.Marker({
			position	: latlng,
			map			: map
		});

		// add to array
		map.markers.push( marker );

		// if marker contains HTML, add it to an infoWindow
		if( $marker.html() )
		{
			// create info window
			var infowindow = new google.maps.InfoWindow({
				content		: $marker.html()
			});

			// show info window when marker is clicked
			google.maps.event.addListener(marker, 'click', function() {

				infowindow.open( map, marker );


			});
		}

	}

	function center_map( map ) {

		// vars
		var bounds = new google.maps.LatLngBounds();

		// loop through all markers and create bounds
		$.each( map.markers, function( i, marker ){

			var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

			bounds.extend( latlng );

		});

		// only 1 marker?
		if( map.markers.length == 1 )
		{
			// set center of map
		    map.setCenter( bounds.getCenter() );
		    map.setZoom( 16 );
		}
		else
		{
			// fit to bounds
			map.fitBounds( bounds );
		}

	}

	var map = null;

	$(document).ready(function() {

		$('a[href="#direction"]').one('shown.bs.tab', function(){
			$('.acf-map').each(function(){
				map = new_map($(this));
				var bounds = new google.maps.LatLngBounds();
			});
		});

	});

	$('.cta-roll').click(function() {
		if($('.gallery-wrap').hasClass('rollin')) {
			$('.gallery-wrap').removeClass('rollin');
			$(this).html('<i class="fa fa-chevron-up fa-lg"></i>');
			$('.overflow-fade').hide();
		} else {
			$('.gallery-wrap').addClass('rollin');
			$(this).html('<i class="fa fa-chevron-down fa-lg"></i>');
			$('.overflow-fade').hide();
		}
	});

	$('.parallax').parallax();
	
	$('.responsive, .feat-carousel').slick({
    //   dots: false,
      infinite: false,
      speed: 500,
       autoplay: true,
       autoplaySpeed: 2000,
      slidesToShow: 3,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });

}(jQuery));
