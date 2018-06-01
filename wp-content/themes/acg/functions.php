<?php
/*
All the functions are in the PHP pages in the functions/ folder.
*/

require_once locate_template('/functions/cleanup.php');
require_once locate_template('/functions/setup.php');
require_once locate_template('/functions/enqueues.php');
require_once locate_template('/functions/navbar.php');
require_once locate_template('/functions/widgets.php');
require_once locate_template('/functions/search.php');
require_once locate_template('/functions/feedback.php');

add_action('after_setup_theme', 'true_load_theme_textdomain');

function true_load_theme_textdomain(){
    load_theme_textdomain( 'bst', get_template_directory() . '/languages' );
}

function my_acf_google_map_api( $api ){
	
	$api['key'] = 'AIzaSyB698WiIS3dhy6VlfkW_1TGwqmcHM0PZw8';
	
	return $api;
	
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

// function my_acf_init() {
    
//     acf_update_setting('google_api_key', 'AIzaSyB698WiIS3dhy6VlfkW_1TGwqmcHM0PZw8');
// }
// add_action('acf/init', 'my_acf_init');

add_filter( 'single_template', 'single_directory' );
function single_directory($single_template)
{
    if (in_category(5)) { // category 3 is "guide" category
        $file = get_template_directory().'/single-directory.php';
        if ( file_exists($file) ) {
            return $file;
        }
    }
    return $single_template;
}

function side_search() {
    $form = '
        <form class="dir-form" role="search" method="get" id="searchform" action="'.site_url('/').'">
            <input type="hidden" name="cat" id="cat" value="5">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Directory" name="s">
                <span class="input-group-btn">
                    <button class="btn btn-danger" type="button"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
    ';

    return $form;
}
add_shortcode( 'side_search', 'side_search' );

function dump($data) {
   // echo '<pre>';
    print_r($data);
    //echo '</pre>';
}