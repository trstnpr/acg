<?php

/*
Plugin Name: bbp style pack
Plugin URI: http://www.rewweb.co.uk/bbp-style-pack/
Description: This plugin adds styling and features to bbPress. <a href="options-general.php?page=bbp-style-pack&tab=new">What's new?</a>
Version: 3.8.8
****and change version below******
Author: Robin Wilson
Text Domain: bbp-style-pack
Domain Path: /languages
Author URI: http://www.rewweb.co.uk

License: GPL2
*/
/*  Copyright 2016  PLUGIN_AUTHOR_NAME  (email : wilsonrobine@btinternet.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

	*/

/*******************************************
* global variables
*******************************************/

// load the plugin options
$bsp_style_settings_f = get_option( 'bsp_style_settings_f' );
$bsp_style_settings_ti = get_option( 'bsp_style_settings_ti' );
$bsp_style_settings_t = get_option( 'bsp_style_settings_t' );
$bsp_style_settings_la = get_option( 'bsp_style_settings_la' );
$bsp_style_settings_form = get_option( 'bsp_style_settings_form' );
$bsp_profile = get_option( 'bsp_profile' );
$bsp_forum_display = get_option( 'bsp_forum_display' );
$bsp_forum_order = get_option( 'bsp_forum_order' );
$bsp_login = get_option( 'bsp_login' );
$bsp_breadcrumb = get_option( 'bsp_breadcrumb' );
$bsp_templates = get_option( 'bsp_templates' );
$bsp_css = get_option( 'bsp_css' );
$bsp_roles = get_option( 'bsp_roles' );
$bsp_css_location = get_option( 'bsp_css_location' );
$bsp_style_settings_freshness = get_option( 'bsp_style_settings_freshness' );
$bsp_style_settings_buttons = get_option( 'bsp_style_settings_buttons' );
$bsp_topic_order = get_option( 'bsp_topic_order' );
$bsp_style_settings_search = get_option( 'bsp_style_settings_search' );
$bsp_style_settings_unread = get_option( 'bsp_style_settings_unread' );


if(!defined('BSP_PLUGIN_DIR'))
	define('BSP_PLUGIN_DIR', dirname(__FILE__));

function bbp_style_pack_init() {
  load_plugin_textdomain('bbp-style-pack', false, basename( dirname( __FILE__ ) ) . '/languages' );
  //load the plugin stuff
  bsp_load_plugin () ;
}
add_action('plugins_loaded', 'bbp_style_pack_init');


//  TEMPLATES - done now as needed when bbpress loads

//register the new templates location
//this just does files in the templates/templates1 directory - set up to allow other variations and only take live those which you need
if (!empty ($bsp_templates['template'] ) && ($bsp_templates['template'] == 1)) {
add_action( 'bbp_register_theme_packages', 'bsp_register_plugin_template1' );
}

//add in the forum search if set
if (!empty ($bsp_style_settings_search['SearchingActivate'] )) {
	add_action( 'bbp_register_theme_packages', 'bsp_register_plugin_search_template' );
}

//add in the topic/reply_form without revisions if set or hide html message
if (!empty ($bsp_style_settings_form['Remove_Edit_LogsActivate'] ) || !empty ($bsp_style_settings_form['Remove_Edit_ReasonActivate']) || !empty ($bsp_style_settings_form['htmlActivate'] )) {
add_action( 'bbp_register_theme_packages', 'bsp_register_plugin_form_topicandreply_template' );
}

//add in the feedback no topics is this is to be blank
if (!empty ($bsp_style_settings_ti['empty_forumActivate'] ) ) {
add_action( 'bbp_register_theme_packages', 'bsp_register_plugin_form_no_feedback_template' );
}

//get the template paths
function bsp_get_template1_path() {
	return BSP_PLUGIN_DIR . '/templates/templates1';
}

function bsp_get_search_template_path() {
	return BSP_PLUGIN_DIR . '/templates/searchform';
}

function bsp_get_form_topicandreply_template_path() {
	return BSP_PLUGIN_DIR . '/templates/topicandreplyform';
}

function bsp_get_form_no_feedback_template_path() {
	return BSP_PLUGIN_DIR . '/templates/feedbacknotopics';
}

//register the templates

function bsp_register_plugin_template1() {
	bbp_register_template_stack( 'bsp_get_template1_path', 12 );
}

function bsp_register_plugin_search_template() {
	bbp_register_template_stack( 'bsp_get_search_template_path', 12 );
}

function bsp_register_plugin_form_topicandreply_template() {
	bbp_register_template_stack( 'bsp_get_form_topicandreply_template_path', 12 );
}

function bsp_register_plugin_form_no_feedback_template() {
	bbp_register_template_stack( 'bsp_get_form_no_feedback_template_path', 12 );
}
	


/*******************************************
* file includes 
*******************************************/

//only fires after all plugins loaded to ensure bbpress is loaded before we fire bbpress functions and filters
Function bsp_load_plugin () {
	
	if( class_exists( 'bbpress' ) ) {


include(BSP_PLUGIN_DIR . '/includes/settings.php');
include(BSP_PLUGIN_DIR . '/includes/settings_forums_index.php');
include(BSP_PLUGIN_DIR . '/includes/settings_topics_index.php');
include(BSP_PLUGIN_DIR . '/includes/settings_topic_reply_styling.php');
include(BSP_PLUGIN_DIR . '/includes/settings_forum_display.php');
include(BSP_PLUGIN_DIR . '/includes/settings_forum_roles.php');
include(BSP_PLUGIN_DIR . '/includes/settings_custom_css.php');
include(BSP_PLUGIN_DIR . '/includes/settings_topic_order.php');
include(BSP_PLUGIN_DIR . '/includes/settings_forum_order.php');
include(BSP_PLUGIN_DIR . '/includes/settings_freshness_display.php');
include(BSP_PLUGIN_DIR . '/includes/settings_topic_reply_form.php');
include(BSP_PLUGIN_DIR . '/includes/settings_css_location.php');
include(BSP_PLUGIN_DIR . '/includes/settings_login.php');
include(BSP_PLUGIN_DIR . '/includes/settings_search.php');
include(BSP_PLUGIN_DIR . '/includes/settings_forum_templates.php');
include(BSP_PLUGIN_DIR . '/includes/settings_breadcrumbs.php');
include(BSP_PLUGIN_DIR . '/includes/settings_buttons.php');
include(BSP_PLUGIN_DIR . '/includes/settings_profile.php');
include(BSP_PLUGIN_DIR . '/includes/settings_shortcodes.php');
include(BSP_PLUGIN_DIR . '/includes/settings_latest_activity_widget_styling.php');
include(BSP_PLUGIN_DIR . '/includes/settings_widgets.php');
include(BSP_PLUGIN_DIR . '/includes/settings_reset.php');
include(BSP_PLUGIN_DIR . '/includes/not_working.php');
include(BSP_PLUGIN_DIR . '/includes/settings_unread.php');
include(BSP_PLUGIN_DIR . '/includes/settings_export.php');
include(BSP_PLUGIN_DIR . '/includes/settings_import.php');



global $bsp_style_settings_unread ;
//only load functions_unread if activated
if (!empty($bsp_style_settings_unread['unread_activate'])) 
	include(BSP_PLUGIN_DIR . '/includes/functions_unread.php');

include(BSP_PLUGIN_DIR . '/includes/help.php');
include(BSP_PLUGIN_DIR . '/includes/plugins.php');


include(BSP_PLUGIN_DIR . '/includes/shortcodes.php');
include(BSP_PLUGIN_DIR . '/includes/widgets.php');

include(BSP_PLUGIN_DIR . '/includes/plugin-info.php');
include(BSP_PLUGIN_DIR . '/includes/whats_new.php');

include(BSP_PLUGIN_DIR . '/includes/functions.php');
include(BSP_PLUGIN_DIR . '/includes/generate_css.php');

include(BSP_PLUGIN_DIR . '/includes/buddypress.php');
include(BSP_PLUGIN_DIR . '/includes/forum_image_metabox.php');







/**************************************
*Versioning 
***************************************/

$new_version = '3.8.8';

if (!defined('BSP_VERSION_KEY'))
    define('BSP_VERSION_KEY', 'bsp_version');

if (!defined('BSP_VERSION_NUM'))
    define('BSP_VERSION_NUM', $new_version);

add_option(BSP_VERSION_KEY, BSP_VERSION_NUM);
//update is done later


$test = get_option(BSP_VERSION_KEY) ;
//amend how freshness works for early freshness versions

if ($test == '3.1.4' || $test == '3.1.3' || $test == '3.1.2'  || $test == '3.1.1' || $test == '3.1.0') {
	if (!empty ($bsp_style_settings_freshness) ) {
		//Get entire array
		$options = get_option('bsp_style_settings_freshness');
		//Alter the activate array appropriately
		$options['activate'] = '1';
		//Update entire array
		update_option('bsp_style_settings_freshness', $options);
	}
}

//amend how submit activate is saved for version 3.1.7
if ($test == '3.1.7' || $test == '3.2.0') {
	//Get entire array
	$options = get_option('bsp_style_settings_form');
		if (!empty($options['SubmitActivate'])) {
		$submit = __('Submit', 'bbpress') ;
		$options['SubmittingActivate'] = '1';
		$options['SubmittingSubmitting'] = $submit;
		$options['SubmittingSpinner'] = '1';
		//Update entire array
		update_option('bsp_style_settings_form', $options);
		}
}

//amend for searching activate being moved from forum index styling to search styling tab
	//Get entire array
	$options_f= get_option('bsp_style_settings_f') ;
		if (!empty($options_f["SearchingActivate"])) {
				//update bsp_style_settings_search
					$options = get_option('bsp_style_settings_search');
					$options['SearchingActivate'] = '1';
					$options['SearchingSearching'] = $options_f["SearchingSearching"];
					$options['SearchingSpinner'] = $options_f["SearchingSpinner"];
					//Update entire array
					update_option('bsp_style_settings_search', $options);
				//update bsp_style_settings_f
					unset ($options_f ['SearchingActivate']) ;
					unset ($options_f['SearchingSearching']);
					unset ($options_f ['SearchingSpinner']) ;
					//Update entire array
					update_option('bsp_style_settings_f', $options_f);
				
			}
		



if (get_option(BSP_VERSION_KEY) !== $new_version) {
  	//update the version value
    update_option(BSP_VERSION_KEY, $new_version);
}

//if style doesn't exist create it 
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		$path = get_home_path();
if (!empty ($bsp_css_location ['activate css location']) && !empty($bsp_css_location ['location'])) {
		$location = $bsp_css_location ['location'] ;
			// if it starts with '/' -  remove
			if (0 === strpos($location, '/')) {
			$location = substr( $location, 1, strlen($location) ) ;
			}
		// if it doesn't end with a '/' add one
		if (substr( $location, strlen($location)-1, strlen($location) ) !== '/') {
			$location = $location.'/' ;
		}
		$path = $path.'/'.$location ;
		if (!file_exists ($path.'bspstyle.css')) {
		generate_style_css() ;
		}
	}
elseif (!file_exists ($path.'bspstyle.css')) { 
	generate_style_css() ;
	}


	
	} // end of if class exists
} //end of bsp_load_plugin





	