<?php

function bst_enqueues() {

	/* Styles */
	
	wp_register_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', false, '3.3.4', null);
	wp_enqueue_style('bootstrap-css');

	wp_register_style('font', 'https://fonts.googleapis.com/css?family=Raleway:300,400', false, '3.3.4', null);
	wp_enqueue_style('font');

	wp_register_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', false, '4.7.0', null);
	wp_enqueue_style('font-awesome');
	
	wp_register_style('slickcss', '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css', false, '1.8.1', null);
	wp_enqueue_style('slickcss');
	
	wp_register_style('slick-theme', '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css', false, '1.8.1', null);
	wp_enqueue_style('slick-theme');

	wp_register_style('lity', get_template_directory_uri() . '/css/lity.css', false, '2.2.2', null);
	wp_enqueue_style('lity');

  	wp_register_style('bst-css', get_template_directory_uri() . '/css/custom.css', false, '1.0', null);
	wp_enqueue_style('bst-css');

	/* Scripts */
	
	wp_enqueue_script( 'jquery' );
	/* Note: this above uses WordPress's onboard jQuery. You can enqueue other pre-registered scripts from WordPress too. See:
	https://developer.wordpress.org/reference/functions/wp_enqueue_script/#Default_Scripts_Included_and_Registered_by_WordPress */
	
	wp_register_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', false, null, true);
	wp_enqueue_script('bootstrap-js');

  	wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr-2.8.3.min.js', false, null, true);
	wp_enqueue_script('modernizr');

	wp_register_script('lity-js', get_template_directory_uri() . '/js/lity.js', false, null, true);
	wp_enqueue_script('lity-js');

	wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyB698WiIS3dhy6VlfkW_1TGwqmcHM0PZw8', false, null, true);
	wp_enqueue_script('googlemaps');

	wp_register_script('parallax', get_template_directory_uri() . '/js/parallax.min.js', '3', null, true);
	wp_enqueue_script('parallax');
	
	wp_register_script('slickjs', '//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js', '1.8.1', null, true);
	wp_enqueue_script('slickjs');

	wp_register_script('bst-js', get_template_directory_uri() . '/js/custom.js', false, null, true);
	wp_enqueue_script('bst-js');

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'bst_enqueues', 100);
