<?php

//functions 
global $bsp_forum_display ;
global $bsp_login ;
global $bsp_breadcrumb ;
global $bsp_profile ;
global $bsp_style_settings_freshness ;
global $bsp_style_settings_form ;
global $bsp_style_settings_ti ;
global $bsp_style_settings_t ;
global $bsp_style_settings_buttons ;
global $bsp_roles ;
global $bsp_topic_order ;
global $bsp_forum_order ;
global $bsp_style_settings_search ;


if(!function_exists('rclog')){

	function rclog( $data ) {
				if ( is_array( $data ) )
					$output = "<script>console.log('".implode( ',', $data) . "');</script>";
				else
					$output = "<script>console.log('" . $data . "');</script>";
			
				echo $output;
	}
}


/**********forum list create vertical list************/
function bsp_sub_forum_list($args) {
  $args['separator'] = '<br>';
  return $args;
}

if ( !empty ($bsp_forum_display['forum_list'] ))  {
add_filter('bbp_before_list_forums_parse_args', 'bsp_sub_forum_list' );
add_filter('bbp_before_bsp_list_forums_parse_args', 'bsp_sub_forum_list' );
}

/**********remove counts*********************/
function bsp_remove_counts($args) {
$args['show_topic_count'] = false;
$args['show_reply_count'] = false;
$args['count_sep'] = '';
 return $args;
}

if ( !empty ($bsp_forum_display['hide_counts'] ))  {
add_filter('bbp_before_list_forums_parse_args', 'bsp_remove_counts' ) ;
add_filter('bbp_before_bsp_list_forums_parse_args', 'bsp_remove_counts' );
}



/**********removes 'private' and protected prefix for forums ********************/
// we need to remove only for forums, so posts and pages still show private, so we execute the add_filter('private_title_format'... in a filter for bbp_get_forum_title

function bsp_remove_private_title ($title, $forum_id ) {
	$forum_id = bbp_get_forum_id( $forum_id );
	add_filter('private_title_format', 'bsp_remove_private_titleb');
	$title    = get_the_title( $forum_id );
	return apply_filters( 'bsp_remove_private_title', $title, $forum_id );
}

function bsp_remove_private_titleb($title) {
	return '%s';
}


if ( !empty ($bsp_forum_display['remove_private'] ))  {
add_filter('bbp_get_forum_title', 'bsp_remove_private_title', 10, 2);
}



/**********BUTTONS   ********/

//quicker to just add the # in all cases

add_action( 'bbp_theme_before_topic_form', 'bsp_create_new_topicb' ) ;

//First find out if we are using a link or a button for create new topic
if (empty($bsp_style_settings_buttons['Create Topic Buttonactivate'] ) && !empty($bsp_forum_display['create_new_topic'] ) )  {
	//it is just a link so	
	add_action ( 'bbp_template_before_single_forum', 'bsp_create_new_topica' ) ;
}


//then find out if we are using a link or a button for forum subscribe
if (!empty($bsp_style_settings_buttons['Subscribe Buttonactivate'] ) )  {
//then it is a button so set button and add action for name link
//add_filter to take out current subscribe link
	add_filter ('bbp_get_forum_subscribe_link' , 'bsp_remove_forum_subscribe_link', 10 , 2 ) ;
} 

//then we check 





function  bsp_remove_forum_subscribe_link ( $retval, $r) {
	//if we have a button, then in the function below we add a variable to $r called 'button'
	//so if we don't have that then we know to blank the return
	if (empty ($r['button']) ) {
	return '' ;
	}
	else
	return apply_filters( 'bsp_remove_forum_subscribe_link', $retval, $r );
}
	
	
//add this action so that if buttons are active we show them
add_action ( 'bbp_template_before_single_forum', 'bsp_display_buttons' ) ;


function bsp_display_buttons () {
	global $bsp_style_settings_buttons ;
	global $bsp_style_settings_unread ;
	$topic_button = $subscribe_button = $profile_button = $unread_button = 0 ;
	if (!empty($bsp_style_settings_buttons['Create Topic Buttonactivate'] ) )  $topic_button=1 ;
	if (!empty($bsp_style_settings_buttons['Subscribe Buttonactivate'] ) )    $subscribe_button=1 ;	
	if (!empty($bsp_style_settings_buttons['Profile Buttonactivate'] ) )  $profile_button=1 ;
	if (!empty ($bsp_style_settings_unread['unread_activate']))	 $unread_button=1 ;
	$total_buttons = $topic_button + $subscribe_button + $profile_button + $unread_button;
	if ($total_buttons == 0)  return ;
	//first set a new div
	echo '<div style="clear:both;"></div>' ;
	//now display in order
	//if we have 4 buttons, then this is the default order
	$default_topic= 1 ;
	$default_subscribe= 2 ;
	$default_profile = 3 ;
	$default_unread = 4 ;
	//we need to sort out a default order if buttons are 3
	if ($total_buttons == 3) {
		if (empty ($topic_button)) {
			$default_subscribe= 1 ;
			$default_profile = 2 ;
			$default_unread = 3 ;
		}
		if (empty ($subscribe_button)) {
			$default_topic= 1 ;
			$default_profile = 2 ;
			$default_unread = 3 ;
		}
		if (empty ($profile_button)) {
			$default_topic= 1 ;
			$default_subscribe = 2 ;
			$default_unread = 3 ;
		}
		if (empty ($unread_button)) {
			$default_topic= 1 ;
			$default_subscribe = 2 ;
			$default_profile = 3 ;
		}
	}
	//we need to sort out a default order if buttons are 2
	if ($total_buttons == 2) {
		$button_pos = 1 ;
		if (!empty ($topic_button)) {
			$topic_button = $button_pos ;
			$button_pos = 2 ;
		}
		if (!empty ($subscribe_button)) {
			$topic_button = $button_pos ;
			$button_pos = 2 ;
		}
		if (!empty ($profile_button)) {
			$topic_button = $button_pos ;
			$button_pos = 2 ;
		}
		if (!empty ($unread_button)) {
			$topic_button = $button_pos ;
			$button_pos = 2 ;
		}
	
	}
	$order = array() ;
	$i=1 ;
	//set the limit to $total_buttons
		while($i<=$total_buttons)   {
		if ((!empty($bsp_style_settings_buttons["topic_order"]) ? $bsp_style_settings_buttons["topic_order"] : $default_topic) == $i) $order[$i] = 'topic_order' ;
		if ((!empty($bsp_style_settings_buttons["subscribe_order"]) ? $bsp_style_settings_buttons["subscribe_order"] : $default_subscribe) == $i) $order[$i] = 'subscribe_order' ;
		if ((!empty($bsp_style_settings_buttons["profile_order"]) ? $bsp_style_settings_buttons["profile_order"] : $default_profile) == $i)  $order[$i] = 'profile_order' ;
		if ((!empty($bsp_style_settings_buttons["unread_order"]) ? $bsp_style_settings_buttons["unread_order"] : $default_unread) == $i)  $order[$i] = 'unread_order' ;
		//increments $i	
		$i++;	
		}
		if ($total_buttons == 1)  {
		//then just one
		echo '<div class="bsp-center">' ;
		//then work out which is active and call
		if (!empty($bsp_style_settings_buttons['Create Topic Buttonactivate'] ) )  bsp_new_topic_button () ;
		if (!empty($bsp_style_settings_buttons['Subscribe Buttonactivate'] ) )    bsp_subscribe_button () ;
		if (!empty($bsp_style_settings_buttons['Profile Buttonactivate'] ) )  bsp_profile_link () ;
		if (!empty($bsp_style_settings_unread['unread_activate'] ) )  bsp_unread_button () ;
		echo '</div>' ;
		}
		if ($total_buttons == 2)  {
		echo '<div class="bsp-center bsp-one-half">' ;
		//then work out which is active and call in order
		if (!empty($order['1'])) {
		if (!empty($bsp_style_settings_buttons['Create Topic Buttonactivate'] ) && ($order['1'] == 'topic_order')) bsp_new_topic_button () ;
		if (!empty($bsp_style_settings_buttons['Subscribe Buttonactivate'] ) && ($order['1'] == 'subscribe_order')) bsp_subscribe_button () ;
		if (!empty($bsp_style_settings_buttons['Profile Buttonactivate'] ) && ($order['1'] == 'profile_order')) bsp_profile_link () ;
		if (!empty($bsp_style_settings_unread['unread_activate']  ) && ($order['1'] == 'unread_order')) bsp_unread_button  () ;
		}
		echo '</div>' ;
		echo '<div class="bsp-center">' ;
		//then work out which is active and call
		if (!empty($order['1'])) {
		if (!empty($bsp_style_settings_buttons['Create Topic Buttonactivate'] ) && ($order['2'] == 'topic_order')) bsp_new_topic_button () ;
		if (!empty($bsp_style_settings_buttons['Subscribe Buttonactivate'] ) && ($order['2'] == 'subscribe_order')) bsp_subscribe_button () ;
		if (!empty($bsp_style_settings_buttons['Profile Buttonactivate'] ) && ($order['2'] == 'profile_order')) bsp_profile_link () ;
		if (!empty($bsp_style_settings_unread['unread_activate']  ) && ($order['2'] == 'unread_order')) bsp_unread_button  () ;
		}		
		echo '</div>' ;		
		}
		if ($total_buttons == 3)  {
		echo '<div class="bsp-center bsp-one-third">' ;
		//then work out which is active and call
		if (!empty($order['1'])) {
		if (!empty($bsp_style_settings_buttons['Create Topic Buttonactivate'] ) && ($order['1'] == 'topic_order')) bsp_new_topic_button () ;
		if (!empty($bsp_style_settings_buttons['Subscribe Buttonactivate'] ) && ($order['1'] == 'subscribe_order')) bsp_subscribe_button () ;
		if (!empty($bsp_style_settings_buttons['Profile Buttonactivate'] ) && ($order['1'] == 'profile_order')) bsp_profile_link () ;
		if (!empty($bsp_style_settings_unread['unread_activate']  ) && ($order['1'] == 'unread_order')) bsp_unread_button  () ;
		}
		echo '</div>' ;
		echo '<div class="bsp-center bsp-one-third">' ;
		//then work out which is active and call
		if (!empty($order['2'])) {
		if (!empty($bsp_style_settings_buttons['Create Topic Buttonactivate'] ) && ($order['2'] == 'topic_order')) bsp_new_topic_button () ;
		if (!empty($bsp_style_settings_buttons['Subscribe Buttonactivate'] ) && ($order['2'] == 'subscribe_order')) bsp_subscribe_button () ;
		if (!empty($bsp_style_settings_buttons['Profile Buttonactivate'] ) && ($order['2'] == 'profile_order')) bsp_profile_link () ;
		if (!empty($bsp_style_settings_unread['unread_activate']  ) && ($order['2'] == 'unread_order')) bsp_unread_button  () ;
		}
		echo '</div>' ;
		echo '<div class="bsp-center">' ;
		//then work out which is active and call
		if (!empty($order['3'])) {
		if (!empty($bsp_style_settings_buttons['Create Topic Buttonactivate'] ) && ($order['3'] == 'topic_order')) bsp_new_topic_button () ;
		if (!empty($bsp_style_settings_buttons['Subscribe Buttonactivate'] ) && ($order['3'] == 'subscribe_order')) bsp_subscribe_button () ;
		if (!empty($bsp_style_settings_buttons['Profile Buttonactivate'] ) && ($order['3'] == 'profile_order')) bsp_profile_link () ;
		if (!empty($bsp_style_settings_unread['unread_activate']  ) && ($order['3'] == 'unread_order')) bsp_unread_button  () ;
		}
		echo '</div>' ;		
		}
		if ($total_buttons == 4)  {
		echo '<div class="bsp-center">' ;
		//then work out which is active and call
		if (!empty($order['1'])) {
		if (!empty($bsp_style_settings_buttons['Create Topic Buttonactivate'] ) && ($order['1'] == 'topic_order')) bsp_new_topic_button () ;
		if (!empty($bsp_style_settings_buttons['Subscribe Buttonactivate'] ) && ($order['1'] == 'subscribe_order')) bsp_subscribe_button () ;
		if (!empty($bsp_style_settings_buttons['Profile Buttonactivate'] ) && ($order['1'] == 'profile_order')) bsp_profile_link () ;
		if (!empty($bsp_style_settings_unread['unread_activate']  ) && ($order['1'] == 'unread_order')) bsp_unread_button  () ;
		}
		echo '</div>' ;
		echo '<div class="bsp-center bsp-one-third">' ;
		//then work out which is active and call
		if (!empty($order['2'])) {
		if (!empty($bsp_style_settings_buttons['Create Topic Buttonactivate'] ) && ($order['2'] == 'topic_order')) bsp_new_topic_button () ;
		if (!empty($bsp_style_settings_buttons['Subscribe Buttonactivate'] ) && ($order['2'] == 'subscribe_order')) bsp_subscribe_button () ;
		if (!empty($bsp_style_settings_buttons['Profile Buttonactivate'] ) && ($order['2'] == 'profile_order')) bsp_profile_link () ;
		if (!empty($bsp_style_settings_unread['unread_activate']  ) && ($order['2'] == 'unread_order')) bsp_unread_button  () ;
		}
		echo '</div>' ;
		echo '<div class="bsp-center bsp-one-third">' ;
		//then work out which is active and call
		if (!empty($order['3'])) {
		if (!empty($bsp_style_settings_buttons['Create Topic Buttonactivate'] ) && ($order['3'] == 'topic_order')) bsp_new_topic_button () ;
		if (!empty($bsp_style_settings_buttons['Subscribe Buttonactivate'] ) && ($order['3'] == 'subscribe_order')) bsp_subscribe_button () ;
		if (!empty($bsp_style_settings_buttons['Profile Buttonactivate'] ) && ($order['3'] == 'profile_order')) bsp_profile_link () ;
		if (!empty($bsp_style_settings_unread['unread_activate']  ) && ($order['3'] == 'unread_order')) bsp_unread_button  () ;
		}
		echo '</div>' ;		
		echo '<div class="bsp-center">' ;
		//then work out which is active and call
		if (!empty($order['4'])) {
		if (!empty($bsp_style_settings_buttons['Create Topic Buttonactivate'] ) && ($order['4'] == 'topic_order')) bsp_new_topic_button () ;
		if (!empty($bsp_style_settings_buttons['Subscribe Buttonactivate'] ) && ($order['4'] == 'subscribe_order')) bsp_subscribe_button () ;
		if (!empty($bsp_style_settings_buttons['Profile Buttonactivate'] ) && ($order['4'] == 'profile_order')) bsp_profile_link () ;
		if (!empty($bsp_style_settings_unread['unread_activate']  ) && ($order['4'] == 'unread_order')) bsp_unread_button  () ;
		}
		echo '</div>' ;		
		}
		
	
}

function bsp_new_topic_button () {
	global $bsp_style_settings_buttons;
	if (!empty ($bsp_style_settings_buttons['new_topic_description'] )) $text=$bsp_style_settings_buttons['new_topic_description'] ;
	else $text=__('Create New Topic', 'bbp-style-pack') ;
	if ($bsp_style_settings_buttons['button_type'] == 2)  $class=$bsp_style_settings_buttons['Buttonclass'] ;
	else $class='bsp_button1' ;
	if ( bbp_current_user_can_access_create_topic_form() && !bbp_is_forum_category() ) {
	$href = apply_filters ('bsp_new_topic_button' , '#bsptopic' ) ;
	echo '<a class="'.$class.'" href ="'.$href.'">'.$text.'</a>' ;
	}
}

function bsp_unread_button () {
	global $bsp_style_settings_unread ;
	global $bsp_style_settings_buttons;
	if (!empty ($bsp_style_settings_unread['unread_description'] )) $text=$bsp_style_settings_unread['unread_description'] ;
	else $text=__('Mark all topics as read', 'bbp-style-pack') ;
	if ($bsp_style_settings_buttons['button_type'] == 2)  $class=$bsp_style_settings_buttons['Buttonclass'] ;
	else $class='bsp_button1' ;
		$forum_id = bbp_get_forum_id ();
		$html = '
					<form action="" method="post" >
							<input type="hidden" name="bsp_ur_mark_all_topic_as_read" value="1"/>
							<input type="hidden" name="bsp_ur_mark_id" value="' . $forum_id . '"/>
					';
			$html .= '
					<input class="'.$class.'"type="submit" value="' . $text . '"/></form>
				';
		echo $html ;	
}




function bsp_subscribe_button () {
	global $bsp_style_settings_buttons;
	if (!empty ($bsp_style_settings_buttons['subscribe_button_description'] )) $textsub=$bsp_style_settings_buttons['subscribe_button_description'] ;
	else $textsub=__('Subscribe', 'bbpress') ;
	if (!empty ($bsp_style_settings_buttons['unsubscribe_button_description'] )) $textunsub=$bsp_style_settings_buttons['unsubscribe_button_description'] ;
	else $textunsub=__('Unsubscribe', 'bbpress') ;
	if ($bsp_style_settings_buttons['button_type'] == 2)  $class=$bsp_style_settings_buttons['Buttonclass'] ;
	else $class='bsp_button1' ;
	$link = bbp_get_forum_subscription_link ( array( 'before' => '', 'button' => 1 ) );
	//alter class 
	$pattern = '/subscription-toggle/' ;
	$link = preg_replace($pattern, $class, $link);
	$pattern = '/subscription-toggle/' ;
	//alter subscribe/unsubscribe word
	$pattern ='/'.  __( 'Subscribe',   'bbpress' ).'/' ;
	$replace = $textsub ;		
	$link = preg_replace($pattern, $replace, $link);
	$pattern = '/'. __( 'Unsubscribe',   'bbpress' ).'/' ;
	$replace = $textunsub ;		
	$link = preg_replace($pattern, $replace, $link);
	echo $link ;
	}


	
//for those using the 'show topics by freshness' rather than 'show forums' in the bbpress setup, then modify the create topic button in forum display
if (get_option('_bbp_show_on_root') == 'topics') {
	global $bsp_forum_display ;
	if (!empty ($bsp_forum_display['create_new_topic'] )) {
		add_action ( 'bbp_template_before_topics_index', 'bsp_create_new_topica' ) ;
		add_action ('bbp_template_after_topics_index' , 'bsp_add_new_topic_form' ) ;
	}
}
	
	
	
function bsp_create_new_topica () {
	global $bsp_forum_display ;
	if (!empty ($bsp_forum_display['Create New Topic Description'])) $text=$bsp_forum_display['Create New Topic Description'] ;
	else $text=__('Create New Topic', 'bbp-style-pack') ;
	if ( bbp_current_user_can_access_create_topic_form() && !bbp_is_forum_category() ) {
	$href = apply_filters ('bsp_create_new_topica' , '#bsptopic' ) ;
	echo '<div class="bsp-new-topic">  <a href ="'.$href.'">'.$text.'</a></div>' ;
	}
}
	
function bsp_create_new_topicb () {
	echo '<div><a class="bsptopic" name="bsptopic"></a></div>' ;
	}
	
	
function bsp_add_new_topic_form () {
	echo '<div><a class="bsptopic" name="bsptopic"></a></div>' ;
	//adds the new topic form to the end of the topics list
	bbp_get_template_part( 'form', 'topic'    ); 
}

function bsp_profile_link () {
	if (!is_user_logged_in())  return ;
	global $bsp_style_settings_buttons;
	if (!empty ($bsp_style_settings_buttons['profile_description'] )) $text=$bsp_style_settings_buttons['profile_description'] ;
	else $text=__('Profile', 'bbp-style-pack') ;
	if ($bsp_style_settings_buttons['button_type'] == 2)  $class=$bsp_style_settings_buttons['Buttonclass'] ;
	else $class='bsp_button1' ;
	$current_user = wp_get_current_user();
	$user=$current_user->ID  ;
	echo '<a class="'.$class.'" href="' . esc_url( bbp_get_user_profile_url( $user) ) . '">' . $text . '</a>';
	}
	

/**********Add forum description    ********/

/** filter to add description after forums titles on forum index */
function bsp_add_display_forum_description() {
    echo '<div class="bsp-forum-content">' ;
    bbp_forum_content() ;
    echo '</div>';
    }
	
	

if ( !empty($bsp_forum_display['add_forum_description'] ) ) {
//if ($bsp_forum_display['add_forum_description'] == true ) {
add_action( 'bbp_template_before_single_forum' , 'bsp_add_display_forum_description' );
}




/**********BSP LOGIN*******************/
		
/**********adds login/logout to menu*******************/
if (!empty ($bsp_login['add_login'] )) {
add_filter( 'wp_nav_menu_items', 'bsp_nav_menu_login_link' , 10, 2);
}

function bsp_nav_menu_login_link($menu, $args) {
	global $bsp_login ;
	//if primary set and not primary then return
	if (!empty ($bsp_login['only_primary'] ) && $args->theme_location !== 'primary' )   {
		return $menu ;
	}
	//if primary set and is primary  or if primary is not set
	elseif (!empty ($bsp_login['only_bbpress'] )) {
	if(is_bbpress()) {
    $loginlink = bsp_login() ;
    }
    else {
    $loginlink="" ;
    }
	}
	
	else {
	$loginlink = bsp_login();
	}
        $menu = $menu . $loginlink ;
		return apply_filters( 'bsp_nav_menu_login_link', $menu );
       	
}

function bsp_login () {
global $bsp_login ;
if (is_user_logged_in()) {
		if (!empty($bsp_login['Login/logoutLogout page'] )) {
        $url=$bsp_login['Login/logoutLogout page'] ;
		}
		else {
		$url=site_url();
		}		
		$url2=wp_logout_url($url) ;
		//add  menu item name
		$link = (!empty($bsp_login['Add login/logout to menu itemslogout']) ? $bsp_login['Add login/logout to menu itemslogout'] : 'Logout') ;
		//if we have a logout class add it here
		$start = (!empty($bsp_login['Add login/logout to menu itemslogoutcss']) ? '<li class="'.$bsp_login['Add login/logout to menu itemslogoutcss'].'">' :'<li>') ;
		//$end = (!empty($bsp_login['Add login/logout to menu itemslogoutcss']) ? '</span>' :'') ;
		$loginlink = $start.'<a href="'.$url2.'">'.$link.'</a></li>';
		return $loginlink ;
        }
    else {
        if (!empty($bsp_login['Login/logoutLogin page'] )) {
		$url = $bsp_login['Login/logoutLogin page'] ;
		}
		else {
		$url=site_url().'/wp-login.php' ;
		}
		//add  menu item name
		$link = (!empty($bsp_login['Add login/logout to menu itemslogin']) ? $bsp_login['Add login/logout to menu itemslogin'] : 'Login') ;
		//if we have a login class add it here
		$start = (!empty($bsp_login['Add login/logout to menu itemslogincss']) ? '<li class="'.$bsp_login['Add login/logout to menu itemslogincss'].'">' :'<li>') ;
		//$end = (!empty($bsp_login['Add login/logout to menu itemslogincss']) ? '</span>' :'') ;
		$loginlink = $start.'<a href="'.$url.'">'.$link.'</a></li>';
		return $loginlink ;
		
	}
		
}


if (!empty ($bsp_login['edit_profile'] )) {
add_filter( 'wp_nav_menu_items', 'bsp_edit_profile', 10,2 );
}

function bsp_edit_profile ($menu, $args) { 
global $bsp_login ;		
if (!is_user_logged_in())
		return $menu;
	//if primary set and not primary then return
	if (!empty ($bsp_login['profile_only_primary'] ) && $args->theme_location !== 'primary' )   {
		return $menu ;
	}
	//else if it's set to bbpress only and it's not bbpress - then return
	elseif(!empty($bsp_login['profile_only_bbpress'] ) && (!is_bbpress())) {
		return $menu ;	
	}
	else
		$current_user = wp_get_current_user();
		$user=$current_user->user_nicename  ;
		$user_slug =  get_option( '_bbp_user_slug' ) ;
			if (get_option( '_bbp_include_root' ) == true  ) {	
			$forum_slug = get_option( '_bbp_root_slug' ) ;
			$slug = $forum_slug.'/'.$user_slug.'/' ;
			}
			else {
			$slug=$user_slug . '/' ;
			}
			if (!empty($bsp_login['edit profileMenu Item Description'] )) {
			$edit_profile=$bsp_login['edit profileMenu Item Description'] ;
			}
			else $edit_profile = __('Edit Profile', 'bbp-style-pack') ;
			//get url
			$url = get_site_url(); 
			$start = (!empty($bsp_login['edit profilecss']) ? '<li class="'.$bsp_login['edit profilecss'].'">' :'<li>') ;
			//$end = (!empty($bsp_login['edit profilecss']) ? '</span>' :'') ;
			$profilelink = $start.'<a href="'. $url .'/' .$slug. $user . '/edit">'.$edit_profile.'</a></li>';
			

			
		$menu = $menu . $profilelink;
		return apply_filters( 'bsp_edit_profile', $menu );
}

if (!empty ($bsp_login['register'] ) ) {
add_filter( 'wp_nav_menu_items', 'bsp_register', 10,2 );
}

function bsp_register ($menu, $args) { 
global $bsp_login ;	
if (is_user_logged_in())
		return $menu;
	//if primary set and not primary then return
	if (!empty ($bsp_login['register_only_primary'] ) && $args->theme_location !== 'primary' )   {
		return $menu ;
	}
	//else if it's set to bbpress only and it's not bbpress - then return
	elseif(!empty($bsp_login['register_only_bbpress'] ) && (!is_bbpress())) {
		return $menu ;	
	}
	else
	$url = $bsp_login['Register PageRegister page'] ;
	if (!empty($bsp_login['Register PageMenu Item Description'] )) {
        $desc=$bsp_login['Register PageMenu Item Description'] ;
		}
	else $desc=__('Register', 'bbp-style-pack') ;
	$start = (!empty($bsp_login['Register Pagecss']) ? '<li class="'.$bsp_login['Register Pagecss'].'">' :'<li>') ;
	//$end = (!empty($bsp_login['Register Pagecss']) ? '</span>' :'') ;
	$registerlink = $start.'<a href="'.$url.'">'.$desc.'</a></li>';
	$menu = $menu . $registerlink;
		return apply_filters( 'bsp_register', $menu );
		
	
}


function bsp_login_redirect ()  {
	global $bsp_login ;	
	//find out whether we need to do a redirect
	
	$login_page = $bsp_login['Login/logoutLogin page'] ;
	$login_redirect = $bsp_login['Login/logoutLogged in redirect'] ; 
	$length1 = strlen ( site_url() ) ;
	$length2 = strlen ( $login_page ) ;
	$loginslug = substr( $login_page, $length1, $length2 ) ;
	//if the page that we're on ($_SERVER['REQUEST_URI']) is the one that is used for login ($loginslug) then we know that it is a redirect from our login not a widget redirect, so can do our redirect
		if ($_SERVER['REQUEST_URI']   ==  $loginslug) {
		$redirect_to = $login_redirect ;
		return $redirect_to ;
		}
}


if (!empty ($bsp_login['Login/logoutLogged in redirect'] )) {	
add_filter ('bbp_user_login_redirect_to' , 'bsp_login_redirect') ;
}


/**********breadcrumbs    ********/

//no breadcrumbs
function bsp_no_breadcrumb ($param) { 
return true;
}

if ( !empty( $bsp_breadcrumb['no_breadcrumb'] ) ) {
//if ($bsp_breadcrumb['no_breadcrumb'] == true ) {
add_filter ('bbp_no_breadcrumb', 'bsp_no_breadcrumb');
}



function bsp_breadcrumbs ($args) {
	global $bsp_breadcrumb ;
	if ( !empty( $bsp_breadcrumb['no_home_breadcrumb'] ) ) $args['include_home'] = false;
	if ( !empty( $bsp_breadcrumb['no_root_breadcrumb'] ) ) $args['include_root'] = false;
	if ( !empty( $bsp_breadcrumb['no_current_breadcrumb'] ) ) $args['include_current'] = false;
	if (!empty ($bsp_breadcrumb['Breadcrumb HomeText'] )) $args['home_text'] = $bsp_breadcrumb['Breadcrumb HomeText'];
	//but set home icon if this is set
	if (!empty ($bsp_breadcrumb['home_icon'] )) $args['home_text'] = '<span class="bsp-home-icon"></span>' ;		
	if (!empty ($bsp_breadcrumb['Breadcrumb RootText'] )) $args['root_text'] = $bsp_breadcrumb['Breadcrumb RootText'];
	if (!empty ($bsp_breadcrumb['Breadcrumb CurrentText'] )) $args['current_text'] = $bsp_breadcrumb['Breadcrumb CurrentText'];
	return $args ;
	
	
}


//add the filter - if no args set then this does nothing
add_filter('bbp_before_get_breadcrumb_parse_args', 'bsp_breadcrumbs');


//change breadcrumb urls if set

add_filter ('bbp_breadcrumbs', 'bsp_breadcrumb_urls') ;

function bsp_breadcrumb_urls ($crumbs ) {
	global $bsp_breadcrumb ;
	$pattern = '/(?<=href\=")[^]]+?(?=")/';
	//home is $crumbs[0] root is $crumbs[1] ;
	$home = (!empty($bsp_breadcrumb['Breadcrumb HomeURL']) ? $bsp_breadcrumb['Breadcrumb HomeURL']  : '') ;
	$root = (!empty($bsp_breadcrumb['Breadcrumb RootURL']) ? $bsp_breadcrumb['Breadcrumb RootURL']  : '') ;
	if (!empty ($home)) {
		$crumbs[0] = preg_replace($pattern, $home, $crumbs[0]);
	}
	if (!empty ($root) && !empty ($crumbs[1])) {
		$crumbs[1] = preg_replace($pattern, $root, $crumbs[1]);
	}
return $crumbs ;	
}



//This function changes the text wherever it is quoted
function bsp_change_text( $translated_text, $text, $domain ) {
global $bsp_login ;
	if ( $text == 'You are already logged in.' ) {
	$translated_text = $bsp_login['Login/logoutLogged in text'];
	}
	return $translated_text;
}

if (!empty ($bsp_login['Login/logoutLogged in text'] )) add_filter( 'gettext', 'bsp_change_text', 20, 3 );


//this function adds the gravatar thingy to the profile page
if (!empty ($bsp_profile['gravatar'] )) {
add_action( 'bbp_user_edit_after_name', 'bsp_mention_gravatar' );
}


function bsp_mention_gravatar() {
global $bsp_profile ;
$label = (!empty($bsp_profile['ProfileGravatar Label']) ? $bsp_profile['ProfileGravatar Label'] : '');
$gdesc = (!empty($bsp_profile['ProfileItem Description']) ? $bsp_profile['ProfileItem Description'] : '');
$gurl = (!empty($bsp_profile['ProfilePage URL']) ? esc_html ($bsp_profile['ProfilePage URL']) : '');
$gurl = '<a href="'.$gurl.'" title="Gravatar">' ;
$gurldesc = (!empty($bsp_profile['ProfileURL Description']) ? esc_html ($bsp_profile['ProfileURL Description']) : '');

?>
<div>

	<label for="bbp-gravatar-notice"><?php echo $label ?></label>
	<fieldset style="width: 60%;">
		<span style="margin-left: 0; width: 100%;" name="bbp-gravatar-notice" class="description"><?php echo $gdesc ?> <?php echo $gurl?> <?php echo $gurldesc ?></a>.</span>
	</fieldset>
</div>

<?php

}

///////////////////////////////////////////////////FORUM ROLES FUNCTION

add_filter( 'bbp_get_reply_author_role', 'bsp_get_reply_author_role', 10,2); 
add_filter( 'bbp_get_topic_author_role', 'bsp_get_reply_author_role', 10,2); 


function bsp_get_reply_author_role( $author_role, $r ) {
		global $bsp_roles ;
		$roles_show = (!empty($bsp_roles['all_roleswhere_to_display']) ? $bsp_roles['all_roleswhere_to_display'] : '') ;
		if ($roles_show == 2 ) return ;  //2 = show at top, so hide here
		$author_role = bsp_author_role ($r) ;
	return apply_filters( 'bsp_get_reply_author_role', $author_role, $r );
}

$roles_show = (!empty($bsp_roles['all_roleswhere_to_display']) ? $bsp_roles['all_roleswhere_to_display'] : '') ;

if ($roles_show == 2 ) {
	add_action ('bbp_theme_before_reply_author_details' , 'bsp_display_reply_role' ) ;
	add_action ('bbp_theme_before_topic_author_details' , 'bsp_display_topic_role' ) ;
}



function bsp_display_reply_role( $args = array() ) {
	// Parse arguments against default values
		$r = bbp_parse_args( $args, array(
			'reply_id' => 0,
			'class'    => 'bbp-author-role',
			'before'   => '',
			'after'    => ''
		), 'get_reply_author_role' );
	$r['reply_id']   = bbp_get_reply_id( $r['reply_id'] );
	$author_role = bsp_author_role ($r) ;
	echo $author_role ;
}

function bsp_display_topic_role( $args = array() ) {
	// Parse arguments against default values
		$r = bbp_parse_args( $args, array(
			'topic_id' => 0,
			'class'    => 'bbp-author-role',
			'before'   => '',
			'after'    => ''
		), 'get_reply_author_role' );
	$r['topic_id']   = bbp_get_topic_id( $r['topic_id'] );
	$author_role = bsp_author_role ($r) ;
	echo $author_role ;
}

//added function to allow others to call the role
function bsp_get_user_display_role( $user_id = 0  ) {
	if (empty ($user_id) ) $user_id  = bbp_get_user_id( $user_id );
	$r['profile_id']  = $user_id ;
	$r['before']  = '' ;
	$r['after']  = '<br>' ;
	
	$author_role = bsp_author_role ($r) ;
	return $author_role ;
}

	
function bsp_author_role ($r) {
	global $bsp_roles ;
	//check if we are displaying roles at all or if we are not displaying after display name, and bail if appropriate
		$roles_show = (!empty($bsp_roles['all_roleswhere_to_display']) ? $bsp_roles['all_roleswhere_to_display'] : '') ;
		if ($roles_show == 1 ) return ;  //1 = hide
	//if reply set up reply variables
	if (!empty($r['reply_id'] )) {
		$item_id = $r['reply_id'] ;
		$role = bbp_get_user_role( bbp_get_reply_author_id( $item_id ) );
		$roledisplay = bbp_get_user_display_role( bbp_get_reply_author_id( $item_id ) );	
	}
	//if topic set up topic variables
	if (!empty($r['topic_id'] )) {
		$item_id = $r['topic_id'] ;
		$role = bbp_get_user_role( bbp_get_topic_author_id( $item_id ) );
		$roledisplay = bbp_get_user_display_role( bbp_get_topic_author_id( $item_id ) );	
	}
	
	//if profile ...
	if (!empty($r['profile_id'] )) {
	$role = bbp_get_user_role( $r['profile_id']) ;
	$roledisplay = bbp_get_user_display_role($r['profile_id']) ;
	}
	
	
//added in 3.7.5 to get around a case where $role isn't set and the rest of this errors - further work to understand why needed if/when i can replicate
if (!empty ($role)) {
		//now check if we should display this role, and if not just return
		$type = $role.'type' ;
		//bail if doesn't exist (anymore! - may be an old role that's been deleted)
		if (empty($bsp_roles[$type]) ) {
			$author_role = sprintf( '%1$s<div class="%2$s">%3$s</div>%4$s', $r['before'], esc_attr( $r['class'] ), esc_html( $roledisplay ), $r['after'] );
			return apply_filters( 'bsp_get_reply_author_role', $author_role, $r );
		}	

		
	if ($bsp_roles[$type] ==  5) return ;
	
	$r['class'] = 'bsp-author-'.$role ;
	//get which display we are showing
	//if image then...
	if ($bsp_roles[$type] ==  1) {
		$image = (!empty($bsp_roles[$role.'image']) ? $bsp_roles[$role.'image'] : '') ;
		$image_height = (!empty($bsp_roles[$role.'image_height']) ? $bsp_roles[$role.'image_height'] : '') ;
		$image_width = (!empty($bsp_roles[$role.'image_width']) ? $bsp_roles[$role.'image_width'] : '') ;
		$role = '<img src = "'.$image.'" height="'.$image_height.'" width="'.$image_width.'" >' ;
		$author_role = sprintf( '%1$s<div class="%2$s">%3$s</div>%4$s', $r['before'], esc_attr( $r['class'] ),  $role , $r['after'] );		
	}
	
	//if name then...(with either background color if specified or image - styles.php checks which is required)
	if ($bsp_roles[$type] ==  2  || $bsp_roles[$type] ==  3 ) {
		$roledisplay = (!empty($bsp_roles[$role.'name']) ? $bsp_roles[$role.'name'] : $roledisplay) ;
		$author_role = sprintf( '%1$s<div class="%2$s">%3$s</div>%4$s', $r['before'], esc_attr( $r['class'] ), esc_html( $roledisplay ), $r['after'] );
	}
	
	//if name under image
	if ($bsp_roles[$type] ==  4) {
		$image = (!empty($bsp_roles[$role.'image']) ? $bsp_roles[$role.'image'] : '') ;
		$image_height = (!empty($bsp_roles[$role.'image_height']) ? $bsp_roles[$role.'image_height'] : '') ;
		$image_width = (!empty($bsp_roles[$role.'image_width']) ? $bsp_roles[$role.'image_width'] : '') ;
		$role1 = '<img src = "'.$image.'" height="'.$image_height.'" width="'.$image_width.'" >' ;
		$role2 = (!empty($bsp_roles[$role.'name']) ? $bsp_roles[$role.'name'] : $roledisplay) ;
		$author_role = sprintf( '%1$s<div class="%2$s"><ul><li>%3$s</li><li>%4$s</li></ul></div>%5$s', $r['before'], esc_attr( $r['class'] ),  $role1, $role2 , $r['after'] );	 ;
	}
		
	//now add topic author
	$author_show = (!empty($bsp_roles['topic_authortype']) ? $bsp_roles['topic_authortype'] : '') ;
	
	//if this is profile display - bail here
	if (!empty($r['profile_id'] )) {
	return apply_filters( 'bsp_get_reply_author_role', $author_role );	
	}
	
		
	//bail at this point if hide is active or not set
	if (empty ($author_show) ) 
		
	//if this is a topic... (this id matches the topic), then don't display topic author - just bail here
		//either we are using topic_id, so just quit here
		if (!empty($r['topic_id'] )) return apply_filters( 'bsp_get_reply_author_role', $author_role, '' );
		//the line above did read as follows, but this errored in search results
		//if (!empty($r['topic_id'] )) return apply_filters( 'bsp_get_reply_author_role', $reply_id );
		
		//or (this id matches the topic), then don't display topic author - just quit here
		if (!empty($r['reply_id'] )) {
		$topic_id = bbp_get_reply_topic_id( $r['reply_id'] ) ;
		if ($topic_id ==  $r['reply_id'] ) return apply_filters( 'bsp_get_reply_author_role', $author_role, $r['reply_id'] );
		}
		
		//now check if it is the topic author
		$author_topic = bbp_get_reply_author_id( $topic_id ) ;
		$author_reply = bbp_get_reply_author_id( $r['reply_id'] ) ;
		
		//then bail if they don't match
		if ($author_topic != $author_reply ) return apply_filters( 'bsp_get_reply_author_role', $author_role, $r['reply_id'] );
		
		//and if it is ...
		if (empty ($author_role) ) $author_role = '' ;  //allow for no role above being shown
		$r['class'] = 'bsp-author-topic_author';
		$role = 'topic_author' ;
		$type = $role.'type' ;
		//if image then...
		if ($bsp_roles[$type] ==  1) {
			$image = (!empty($bsp_roles[$role.'image']) ? $bsp_roles[$role.'image'] : '') ;
			$image_height = (!empty($bsp_roles[$role.'image_height']) ? $bsp_roles[$role.'image_height'] : '') ;
			$image_width = (!empty($bsp_roles[$role.'image_width']) ? $bsp_roles[$role.'image_width'] : '') ;
			$role = '<img src = "'.$image.'" height="'.$image_height.'" width="'.$image_width.'" >' ;
			$author_role .= sprintf( '%1$s<div class="%2$s">%3$s</div>%4$s', $r['before'], esc_attr( $r['class'] ),  $role , $r['after'] );		
		}
		//if name then...(with either background color if specified or image - styles.php checks which is required)
		if ($bsp_roles[$type] ==  2  || $bsp_roles[$type] ==  3 ) {
			$roledisplay = (!empty($bsp_roles[$role.'name']) ? $bsp_roles[$role.'name'] : $roledisplay) ;
			$author_role .= sprintf( '%1$s<div class="%2$s">%3$s</div>%4$s', $r['before'], esc_attr( $r['class'] ), esc_html( $roledisplay ), $r['after'] );
		}
		//if name under image
		if ($bsp_roles[$type] ==  4) {
			$image = (!empty($bsp_roles[$role.'image']) ? $bsp_roles[$role.'image'] : '') ;
			$image_height = (!empty($bsp_roles[$role.'image_height']) ? $bsp_roles[$role.'image_height'] : '') ;
			$image_width = (!empty($bsp_roles[$role.'image_width']) ? $bsp_roles[$role.'image_width'] : '') ;
			$role1 = '<img src = "'.$image.'" height="'.$image_height.'" width="'.$image_width.'" >' ;
			$role2 = (!empty($bsp_roles[$role.'name']) ? $bsp_roles[$role.'name'] : $roledisplay) ;
		
			$author_role .= sprintf( '%1$s<div class="%2$s"><ul><li>%3$s</li><li>%4$s</li></ul></div>%5$s', $r['before'], esc_attr( $r['class'] ),  $role1, $role2 , $r['after'] );	 ;
		}
		
	return apply_filters( 'bsp_get_reply_author_role', $author_role, $r['reply_id'] );
}
return ; //failsafe if $role is blank
}





//////////////remove space after the name and before the role


function bsp_break_remove ($author_link) {
$pattern = '#<br /><div class="bsp-author#' ;
$replacement = '<div class="bsp-author' ;
$author_link = preg_replace($pattern, $replacement, $author_link);
return $author_link ;

}


if (!empty ($bsp_roles['removeline'] )) {
	add_filter ('bbp_get_reply_author_link' , 'bsp_break_remove' ) ;
}



////////////////////////////////////////////////////////FRESHNESS DISPLAY

//filter to correctly return last active ID for sub forums
//note : a parent forum or category can get the wrong last active ID if a topic in a sub forum is marked as spam or deleted. This filter ignores the parent and works out the correct sub forum

//don't add if pg filter exists as this will have done it already
if (!function_exists ('private_groups_get_permitted_subforums')) {
	add_filter ('bbp_get_forum_last_active_id' , 'bsp_get_forum_last_active_id', 10 , 2 ) ;
}


function bsp_get_forum_last_active_id ($active_id, $forum_id) {
	$sub_forums = bbp_forum_get_subforums($forum_id) ;
	if ( !empty( $sub_forums ) ) {
		$active_id = 0;
		$show = array();
		//find the latest permissible 
		foreach ( $sub_forums as $sub_forum ) {
			$sub_forum_id =  $sub_forum->ID ;
			$active_id = get_post_meta( $sub_forum_id , '_bbp_last_active_id', true );
			$last_active = get_post_meta( $sub_forum_id, '_bbp_last_active_time', true );
			if ( empty( $active_id ) ) { // not replies, maybe topics ?
				$active_id = bbp_get_forum_last_topic_id( $sub_forum_id );
				if ( !empty( $active_id ) ) {
					$last_active = bbp_get_topic_last_active_time( $active_id );
				}
			}
			if ( !empty( $active_id ) ) {
				$curdate = strtotime($last_active);
				$show[$curdate] = $active_id ;
			}
		}
		//then add the forum itself in case it has the latest
			$active_id = get_post_meta( $forum_id , '_bbp_last_active_id', true );
			$last_active = get_post_meta( $sub_forum_id, '_bbp_last_active_time', true );
			if ( empty( $active_id ) ) { // not replies, maybe topics ?
				$active_id = bbp_get_forum_last_topic_id( $forum_id );
				if ( !empty( $active_id ) ) {
					$last_active = bbp_get_topic_last_active_time( $active_id );
				}
			}
			if ( !empty( $active_id ) ) {
				$curdate = strtotime($last_active);
				$show[$curdate] = $active_id ;
			}
		$mostRecent= 0;
		foreach($show as $date=>$value){
			if ($date > $mostRecent) {
				 $mostRecent = $date;
			}
		}
		if ($mostRecent != 0) {
			$active_id = $show[$mostRecent] ;
		} else {
			$active_id = 0;
		}
	}
	return apply_filters( 'bsp_get_forum_last_active_id', $active_id, $forum_id );
}



//Check they are activated, and add filters if they are
if (!empty ($bsp_style_settings_freshness ['activate'] ))  {
	//heading name
	if (!empty ($bsp_style_settings_freshness ['heading_name'] )) {
		add_filter( 'gettext', 'bsp_change_translate_text', 20, 3 );		
	}
	//show title
	if (!empty ($bsp_style_settings_freshness ['show_title'] ))  {
		add_action( 'bbp_theme_before_forum_freshness_link', 'bsp_freshness_display_title');
	}
	//show (hide!) date
	if (!empty ($bsp_style_settings_freshness) && empty($bsp_style_settings_freshness ['show_date'] ))  {
		add_filter('bbp_get_forum_freshness_link', 'bsp_hide_freshness_link' );
		add_filter('bbp_get_topic_freshness_link', 'bsp_hide_freshness_link' );
	}
	else {
		//if we are showing freshness link, then ensure correct last active ID from sub forum shown if needed
		// & don't add if pg filter exists as this will have done it already
		if (!function_exists ('pg_get_forum_freshness_link')) {
			add_filter('bbp_get_forum_freshness_link', 'bsp_get_forum_freshness_link' , 10 ,2);
		}
	}
	
	//show avatar/name combination as appropriate
	
	if (!empty($bsp_style_settings_freshness)) {
		//firstly filtered if PG is active to ensure we show the correct author
		if (function_exists ('rpg_get_last_active_author')) {
			add_filter ('bbp_before_get_author_link_parse_args' , 'rpg_get_last_active_author' ) ;
		}
		add_filter('bbp_before_get_author_link_parse_args', 'bsp_author_freshness_link' );
	}
	
	
	//change date format if needed
	if (!empty ($bsp_style_settings_freshness ['date_format'] ) && $bsp_style_settings_freshness ['date_format'] == 2)  {
		add_filter( 'bbp_get_forum_last_active', 'bsp_change_freshness_forum', 10, 2 );
		add_filter( 'bbp_get_topic_last_active', 'bsp_change_freshness_topic', 10, 2 );
	}	

}

function bsp_freshness_display_title ($forum_id = 0) {
	//use pg function if private groups plugin active
	if (function_exists ('pg_get_forum_freshness_title')) {
		$anchor = pg_get_forum_freshness_title() ;		
	} 
	else {	
	// Verify forum and get last active meta
	$forum_id  = bbp_get_forum_id( $forum_id );
		$active_id = bbp_get_forum_last_active_id( $forum_id );
		$link_url  = $title = '';

		if ( empty( $active_id ) )
			$active_id = bbp_get_forum_last_reply_id( $forum_id );

		if ( empty( $active_id ) )
			$active_id = bbp_get_forum_last_topic_id( $forum_id );

		if ( bbp_is_topic( $active_id ) ) {
			//then reset forum_id to the forum of the active topic in case it is a sub forum
			$forum_id = bbp_get_topic_forum_id($active_id);
			$link_url = bbp_get_forum_last_topic_permalink( $forum_id );
			$title    = bbp_get_forum_last_topic_title( $forum_id );
		} elseif ( bbp_is_reply( $active_id ) ) {
			//then reset forum_id to the forum of the active topic in case it is a sub forum
			$forum_id = bbp_get_reply_forum_id($active_id);
			$link_url = bbp_get_forum_last_reply_url( $forum_id );
			$title    = bbp_get_forum_last_reply_title( $forum_id );
		}
		
		$anchor = '<a class="bsp_freshness_display_title" href="' . esc_url( $link_url ) . '" title="' . esc_attr( $title ) . '">' . esc_html( $title ) . '</a>';
	}
echo $anchor.'<p/>' ;
}

function bsp_get_forum_freshness_link ($anchor, $forum_id) {
	//amended to reset the forum_id as commented below
	global $rpg_settingsf ;
		$forum_id  = bbp_get_forum_id( $forum_id );
		$active_id = bbp_get_forum_last_active_id( $forum_id );
				
		if ( empty( $active_id ) )
			$active_id = bbp_get_forum_last_reply_id( $forum_id );

		if ( empty( $active_id ) )
			$active_id = bbp_get_forum_last_topic_id( $forum_id );
		
		$link_url  = $title = '';

		if ( bbp_is_topic( $active_id ) ) {
			//then reset forum_id to the forum of the active topic in case it is a sub forum
			$forum_id = bbp_get_topic_forum_id($active_id);
			$link_url = bbp_get_forum_last_topic_permalink( $forum_id );
			$title    = bbp_get_forum_last_topic_title( $forum_id );
			
		} elseif ( bbp_is_reply( $active_id ) ) {
			//then reset forum_id to the forum of the active topic in case it is a sub forum
			$forum_id = bbp_get_reply_forum_id($active_id);
			$link_url = bbp_get_forum_last_reply_url( $forum_id );
			$title    = bbp_get_forum_last_reply_title( $forum_id );
			
		}

		$time_since = bbp_get_forum_last_active_time( $forum_id );
		
		if ( !empty( $time_since ) && !empty( $link_url ) )
			$anchor = '<a href="' . esc_url( $link_url ) . '" title="' . esc_attr( $title ) . '">' . esc_html( $time_since ) . '</a>';
		else
			$anchor = esc_html__( 'No Topics', 'bbpress' );

		return apply_filters( 'rew_get_forum_freshness_link', $anchor, $forum_id, $time_since, $link_url, $title, $active_id );
}

function bsp_hide_freshness_link () {
	$anchor = '<b></b>' ;
	return $anchor ;
}

function bsp_author_freshness_link ($args) {
	global $bsp_style_settings_freshness ;
	if (!empty($bsp_style_settings_freshness ['show_name'])  && !empty($bsp_style_settings_freshness ['show_avatar'] ))  $args ['type'] = 'both' ;
	if (empty($bsp_style_settings_freshness ['show_name'])  && !empty($bsp_style_settings_freshness ['show_avatar'] ))  $args ['type'] = 'avatar' ;
	if (!empty($bsp_style_settings_freshness ['show_name'])  && empty($bsp_style_settings_freshness ['show_avatar'] ))  $args ['type'] = 'name' ;
	if (empty($bsp_style_settings_freshness ['show_name'])  && empty($bsp_style_settings_freshness ['show_avatar'] ))   $args['post_id'] = '' ;
	return $args ;
}

//this function changes the bbp freshness data (time since) into a last post date for forums
function bsp_change_freshness_forum ($forum_id = 0 ) {
	global $bsp_style_settings_freshness ;

// Verify forum and get last active meta
		$forum_id    = bbp_get_forum_id( $forum_id );
		$last_active = get_post_meta( $forum_id, '_bbp_last_active_time', true );

		if ( empty( $last_active ) ) {
			$reply_id = bbp_get_forum_last_reply_id( $forum_id );
			if ( !empty( $reply_id ) ) {
				$last_active = get_post_field( 'post_date', $reply_id );
			} else {
				$topic_id = bbp_get_forum_last_topic_id( $forum_id );
				if ( !empty( $topic_id ) ) {
					$last_active = bbp_get_topic_last_active_time( $topic_id );
				}
			}
		}

		$last_active = bbp_convert_date( $last_active ) ;
		$date_format = (!empty ( $bsp_style_settings_freshness['bsp_date_format'] ) ? $bsp_style_settings_freshness['bsp_date_format'] : get_option( 'date_format' ) );
		$time_format = (!empty ( $bsp_style_settings_freshness['bsp_time_format'] ) ? $bsp_style_settings_freshness['bsp_time_format'] : get_option( 'time_format' ));
		if ($date_format == '\c\u\s\t\o\m' )  $date_format = $bsp_style_settings_freshness['bsp_date_format_custom'] ;
		if ($time_format == '\c\u\s\t\o\m' )  $time_format = $bsp_style_settings_freshness['bsp_time_format_custom'] ;
		$date= date_i18n( "{$date_format}", $last_active );
		$time=date_i18n( "{$time_format}", $last_active );
		//check the order
		if (!empty ($bsp_style_settings_freshness['date_order'])) {
			$first = $time ;
			$second = $date ;
		}
		else {
			$first = $date ;
			$second = $time ;
		}
		$separator = (!empty ($bsp_style_settings_freshness['date_separator'] ) ? $bsp_style_settings_freshness['date_separator']  : ' at ' ) ;
		$active_time = $first.$separator.$second ;
		return apply_filters ('bsp_change_freshness_forum' , $active_time) ;
}


//this function changes the bbp freshness data (time since) into a last post date for topics
function bsp_change_freshness_topic ($last_active, $topic_id) {
	global $bsp_style_settings_freshness ;
	$topic_id = bbp_get_topic_id( $topic_id );

		// Try to get the most accurate freshness time possible
		$last_active = get_post_meta( $topic_id, '_bbp_last_active_time', true );
		if ( empty( $last_active ) ) {
		$reply_id = bbp_get_topic_last_reply_id( $topic_id );
		if ( !empty( $reply_id ) ) {
			$last_active = get_post_field( 'post_date', $reply_id );
		} else {
				$last_active = get_post_field( 'post_date', $topic_id );
			}
		}
		
		
		$last_active = bbp_convert_date( $last_active ) ;
		$date_format = (!empty ( $bsp_style_settings_freshness['bsp_date_format'] ) ? $bsp_style_settings_freshness['bsp_date_format'] : get_option( 'date_format' ) );
		$time_format = (!empty ( $bsp_style_settings_freshness['bsp_time_format'] ) ? $bsp_style_settings_freshness['bsp_time_format'] : get_option( 'time_format' ));
		if ($date_format == '\c\u\s\t\o\m' )  $date_format = $bsp_style_settings_freshness['bsp_date_format_custom'] ;
		if ($time_format == '\c\u\s\t\o\m' )  $time_format = $bsp_style_settings_freshness['bsp_time_format_custom'] ;
		$date= date_i18n( "{$date_format}", $last_active );
		$time=date_i18n( "{$time_format}", $last_active );
		//check the order
		if (!empty ($bsp_style_settings_freshness['date_order'])) {
			$first = $time ;
			$second = $date ;
		}
		else {
			$first = $date ;
			$second = $time ;
		}
		$separator = (!empty ($bsp_style_settings_freshness['date_separator'] ) ? $bsp_style_settings_freshness['date_separator']  : ' at ' ) ;
		$active_time = $first.$separator.$second ;
		return apply_filters ('bsp_change_freshness_topic' , $active_time) ;
}
		
//This function changes the heading "Freshness" to the name created in Settings
function bsp_change_translate_text( $translated_text, $text, $domain ) {
	global $bsp_style_settings_freshness ;
	if (empty ($bsp_style_settings_freshness ['heading_name'] )) return $translated_text;
		$testtext = 'Freshness' ;
		$testdomain = 'bbpress' ;
			if ( ($text == $testtext) && ($domain == $testdomain) ) {
			$translated_text = $bsp_style_settings_freshness ['heading_name'];
			}	
	return $translated_text;
}

////////////////////////////////Submitting and spinner
//new version_compare
if (!empty ( $bsp_style_settings_form['SubmittingActivate'])) {
	add_action ('bbp_theme_before_topic_form_submit_button' , 'bsp_load_spinner_topic' ) ;
	add_action ('bbp_theme_before_reply_form_submit_button' , 'bsp_load_spinner_reply' ) ;
}

function bsp_load_spinner_topic () {
	global $bsp_style_settings_form ;
	//preload spinner so it is ready - css hides this
	echo '<div id="bsp-spinner-load"></div>' ;
	//add button - hidden by css
	echo '<button type="submit" id="bsp_topic_submit" name="bbp_topic_submit" class="button submit">' ;
	//leave as is if field is blanked (user may just want spinner)
	$value = (!empty($bsp_style_settings_form['SubmittingSubmitting']) ? $bsp_style_settings_form['SubmittingSubmitting']  : '') ;
	echo $value ;
	//then add spinner if activated
	if (!empty( $bsp_style_settings_form['SubmittingSpinner'])) echo '<span class="bsp-spinner"></span>' ;
	//then finish button
	echo '</button>' ;
}
	
	
function bsp_load_spinner_reply () {
	global $bsp_style_settings_form ;
	//preload spinner so it is ready - css hides this
	echo '<div id="bsp-spinner-load"></div>' ;
	//add button - hidden by css
	echo '<button type="submit" id="bsp_reply_submit" name="bbp_reply_submit" class="button submit">' ;
	//leave as is if field is blanked (user may just want spinner)
	$value = (!empty($bsp_style_settings_form['SubmittingSubmitting']) ? $bsp_style_settings_form['SubmittingSubmitting']  : '') ;
	echo $value ;
	//then add spinner if activated
	if (!empty ( $bsp_style_settings_form['SubmittingSpinner'])) echo '<span class="bsp-spinner"></span>' ;
	//then finish button
	echo '</button>' ;
}
	


	
/////////////////////////////  REPLY SUBSCRIBED
//Add reply subscribed
function bsp_default_reply_subscribed() {

		// Get _POST data  IE is this a first post of a topic?
		if ( bbp_is_post_request() && isset( $_POST['bbp_topic_subscription'] ) ) {
			$topic_subscribed = (bool) $_POST['bbp_topic_subscription'];

		// Get edit data  IE either the author or someone else is editing a topic or reply
		} elseif ( bbp_is_topic_edit() || bbp_is_reply_edit() ) {

			// Get current posts author
			$post_author = bbp_get_global_post_field( 'post_author', 'raw' );

			// Post author is not the current user EG a moderator is altering this. In this case we'll leave the default to blank, 
			//as much of the time mods are correcting or moderating, their not interested in the topic itself !
			if ( bbp_get_current_user_id() !== $post_author ) {
				$topic_subscribed = bbp_is_user_subscribed_to_topic( $post_author );

			// Post author is the current user  IE you're editing your own post, so default should be to see any replies
			} else {
				$topic_subscribed = true ;
				//the next line is what it used to say instead of true
				//bbp_is_user_subscribed_to_topic( bbp_get_current_user_id() );
			}

		// Get current status
		} elseif ( bbp_is_single_topic() ) {
			//the user is writing a new reply ?
			$topic_subscribed = true ;
			//the next line is what it used to say instead of true
			//bbp_is_user_subscribed_to_topic( bbp_get_current_user_id() );

		// No data
		} else {
			$topic_subscribed = true;
			//used to say false !
		}

		// Get checked output
		$checked = checked( $topic_subscribed, true, false );

		return apply_filters( 'default_reply_subscribed', $checked, $topic_subscribed );
}
	
if (!empty ($bsp_style_settings_form ['NotifyActivate'] )) {
add_filter ('bbp_get_form_topic_subscribed', 'bsp_default_reply_subscribed') ;
}

//////////////////////////////  ADD FORUM ID column to admin
if (!function_exists ('rpg_ID_column_add')) {
add_action("manage_edit-forum_columns", 'bsp_column_add');
add_filter("manage_forum_posts_custom_column", 'bsp_column_value', 10, 3);
}

function bsp_column_add($columns)  {
	$new = array();
  foreach($columns as $key => $title) {
    if ($key=='bbp_forum_topic_count') // Put the forum ID column before the Topics column
      $new['bsp_id'] = 'Forum ID';
    $new[$key] = $title;
  }
  return $new;
}
	
function bsp_column_value($column_name, $id) {
		if ($column_name == 'bsp_id') echo $id;
}
			
			
			
///////////////////////////REVISIONS

add_filter( 'bbp_get_reply_revisions', 'bsp_trim_revision_log', 20, 1 );
add_filter( 'bbp_get_topic_revisions', 'bsp_trim_revision_log', 20, 1 );

// Only return one entry for revision log otherwise it gets cluttered
function bsp_trim_revision_log( $r='' ) {
	global $bsp_style_settings_t ;
	//if not set up or 'all' then just return
	$rev = (!empty($bsp_style_settings_t['Revisionsrevisions']) ? $bsp_style_settings_t['Revisionsrevisions']  : 'all' ) ;
	if ($rev== 'all') return $r ;
		//if 0, then return none
	if ($rev == 'none') return ;
	else {
		//show only the last n revisions
		$arr = array_slice($r, -$rev);
		return $arr ;
		}
}
 


///////////////////////////PROFILE
// take out profile links for all or non logged in, or just let users see their own
//annoyingly bbpress puts a filter on bbp_get_author_link using bbp_suppress_private_author_link so you cannot apply filters to the first !!
//so we have to remove the filter AND then let the suppress run after in the return line



//logged in users only
if (!empty ($bsp_profile['profile']) && ($bsp_profile['profile'] == 1)) {
	bsp_profile_filters() ;
	//and make all @mentions unclickable fro non logged in
	if (!is_user_logged_in()) bsp_remove_mentions_clickable() ;
}

//Users own profile only 
if (!empty ($bsp_profile['profile']) && ($bsp_profile['profile'] == 2)) {
	bsp_profile_filters() ;
	//and make all @mentions unclickable
	bsp_remove_mentions_clickable() ;
}
	
//no profile for all users
if (!empty ($bsp_profile['profile']) && ($bsp_profile['profile'] == 3)) {
	bsp_profile_filters() ;
	//and make all @mentions unclickable
	bsp_remove_mentions_clickable() ;
}

Function bsp_profile_filters () {
	//take out the bbpress filters, and run against mine.
		remove_filter( 'bbp_get_author_link',          'bbp_suppress_private_author_link', 10, 2 );
		remove_filter( 'bbp_get_topic_author_link',    'bbp_suppress_private_author_link', 10, 2 );
		remove_filter( 'bbp_get_reply_author_link',    'bbp_suppress_private_author_link', 10, 2 );
		add_filter( 'bbp_get_author_link', 'bsp_no_profile', 10, 2 ) ;
		add_filter( 'bbp_get_topic_author_link', 'bsp_no_profile', 10, 2 ) ;
		add_filter( 'bbp_get_reply_author_link', 'bsp_no_profile', 10, 2 ) ;
		
		
}
function bsp_no_profile ($author_link, $r ) {
	global $bsp_profile ;
	//keymasters can see all
	$current_user = wp_get_current_user()->ID;
	if ( bbp_is_user_keymaster($current_user)) return $author_link ;
	//and check if moderators are allowed to see
	$role = bbp_get_user_role( $current_user );
	if ($role == 'bbp_moderator' && (!empty ($bsp_profile['moderator']))  ) return $author_link ;
	//just logged in
	if ($bsp_profile['profile'] == 1 && (!is_user_logged_in())) {
	$author_link = strip_tags ($author_link, '<img><br>' ) ;
	}
	//just own profile
	elseif ($bsp_profile['profile'] == 2) {
		//next line needed for bbp_get_topic_author_link 
		if (empty ($r['post_id']) ) $r['post_id'] = 0 ;
		$current_profile = get_post_field( 'post_author', $r['post_id'] );
		$current_user = wp_get_current_user()->ID;
		//if not current user...
		if ($current_profile != $current_user) {
			$author_link = strip_tags ($author_link, '<img><br>' ) ;
	}
	}
	// no users see..
	elseif ($bsp_profile['profile'] == 3) {
	$author_link = strip_tags ($author_link, '<img><br>' ) ;
	}
	//then call the suppress function to add it back
	return bbp_suppress_private_author_link( $author_link, $r)  ;
	
}


function bsp_remove_mentions_clickable () {
	//keymasters can see all
	$current_user = wp_get_current_user()->ID;
	if ( bbp_is_user_keymaster($current_user)) return ;
	//bbpress automatically adds a profile link to @mentions - this removes it
	remove_filter( 'bbp_make_clickable', 'bbp_make_mentions_clickable',  8 ) ;
}


//now do some code that works out if url is one we want to filter out
function bsp_supress_profile_pages () {
	global $bsp_profile ;
	$current_user = wp_get_current_user()->ID;
	$test = false ;
		//if only logged in set $test
		if ($bsp_profile['profile'] == 1  && is_user_logged_in() ) $test = true ;
		//if only users own profile
		if ($bsp_profile['profile'] == 2 && is_user_logged_in() ) {
		//see if username is in the url - ie matches
		$current_url = $_SERVER['REQUEST_URI'];
		$current_username = wp_get_current_user()->user_login ;
		if (strpos($current_url,$current_username)==true) $test=true ;
		}
		//if turn off all profiles then set in all cases...
		if ($bsp_profile['profile'] == 3 ) $test = false ;
		//then set true for keymaster
		if ( bbp_is_user_keymaster($current_user)) $test = true ;
		//and check if moderators are allowed to see
		$role = bbp_get_user_role( $current_user );
			if ($role == 'bbp_moderator' && (!empty ($bsp_profile['moderator']))  )	$test = true ;
						
	if ( $test == false && ( bbp_is_favorites() || bbp_is_subscriptions() || bbp_is_single_user_topics() || bbp_is_single_user_replies() || bbp_is_single_user_edit() || bbp_is_single_user_profile()  ) )
		{
		$redirect_url = site_url();
		header( 'Location: ' . $redirect_url );	
		die();			
		}
}
		

global $bsp_profile ;
if (!empty ($bsp_profile['profile'] ) ) {
		if ($bsp_profile['profile'] == 1  || $bsp_profile['profile'] == 2  || $bsp_profile['profile'] == 3 ){
			add_action('wp','bsp_supress_profile_pages');
		} 
}	


/////////////////////////////  Add thumbnail support

if (!empty ($bsp_forum_display ['thumbnail'])) {
//Add featured image box, and custom sizes
add_action('do_meta_boxes', 'bsp_add_featured_image_boxes');  
//saves the data
add_action( 'save_post', 'bsp_forum_save_meta', 1, 2 );
//displays the thumbnail
//if below thumbnail
$forum_location =(!empty($bsp_forum_display['forum_descriptionlocation']) ? $bsp_forum_display['forum_descriptionlocation'] : '') ;
	if (empty ($forum_location )) {
		add_action ('bbp_theme_before_forum_title' , 'bsp_forum_display_thumbnail') ;
		add_action ('bbp_theme_after_forum_title' , 'bsp_forum_display_thumbnail_end1') ;
	}
	if ($forum_location == 1) {
		add_action ('bbp_theme_before_forum_title' , 'bsp_forum_display_thumbnail') ;
		add_action ('bbp_theme_before_forum_title' , 'bsp_forum_display_thumbnail_start') ;
		add_action ('bbp_theme_after_forum_title' , 'bsp_forum_display_description_middle') ;
		add_action ('bbp_theme_after_forum_description' , 'bsp_forum_display_thumbnail_end2') ;
	}





}

function bsp_forum_display_thumbnail () {
	global $bsp_forum_display ;
	if ( has_post_thumbnail() ) {
		$id = get_the_ID() ;
		$meta = get_post_meta( $id , 'bsp_forum_thumbnail', true );
		$metawidth = get_post_meta( $id, 'bsp_forum_thumbnailwidth', true );
		$metaheight = get_post_meta( $id, 'bsp_forum_thumbnailheight', true );
		$item = (!empty($meta) ? $meta : '');
		// What size?
			switch ( $item) {

				case 1   :
					$itemsize = 'thumbnail' ;
					break;

				case 2   :
					$itemsize = 'medium' ;
					break;

				case 3   :
					$itemsize = 'large' ;
					break;
					
				case 4   :
					$itemsize = 'full' ;
					break;

				case 5   :
					$itemsize = 'custom' ;
					break;	
			}
		
		
		
		$itemwidth = (!empty($metawidth) ? $metawidth : '');
		$itemheight = (!empty($metaheight) ? $metaheight : '');
		
		if ($itemsize == 'custom') {
			$itemsize = 'array ('.$itemwidth. ', '.$itemheight.')' ;
			//start by creating a div we can style
			echo '<div class = "bsp_thumbnail">' ;
			echo '<a href="'.get_permalink().'">' ;
			the_post_thumbnail( array ($itemwidth,$itemheight)) ;
			echo '</a>';
			}
		else {
		echo '<div class = "bsp_thumbnail">' ;
		echo '<a href="'.get_permalink().'">' ;
		the_post_thumbnail( $itemsize ) ;
		echo '</a>'; 
		}

	}

}

function bsp_forum_display_thumbnail_end1 () {
	if ( has_post_thumbnail() ) {
//close the div
echo '</div>' ;
	}
}

function bsp_forum_display_thumbnail_end2 () {
	if ( has_post_thumbnail() ) {
//close the div
echo '</li></ul></div>' ;
	}
}

function bsp_forum_display_description_middle () {
	//ends and starts a new li
	if ( has_post_thumbnail() ) {
echo '</li><li style="padding-left: 10px;">' ;
	}
}

function bsp_forum_display_thumbnail_start () {
	if ( has_post_thumbnail() ) {
echo '<ul><li>' ;
	}
}

//add @mentions
if (!empty( $bsp_style_settings_t['mentionsactivate'] ) ) {
	$priority = (!empty ($bsp_style_settings_t['mentions_priority'] ) ? $bsp_style_settings_t['mentions_priority']  : 10 ) ;
	add_action ('bbp_theme_after_reply_author_details', 'bsp_mentions', $priority ,1);
	add_action ('bbp_theme_after_topic_author_details', 'bsp_mentions', $priority ,1); 
}

function bsp_mentions () {
	$user_id = bbp_get_reply_author_id () ;
	$user_info = get_userdata( $user_id ); 
	//echo '<div class="bsp-mentions">@'. $user_info->user_login .'</div>' ;
	if (!empty ($user_info)) echo '<div class="bsp-mentions">@'. $user_info->user_nicename .'</div>' ;
}


//adds sub forum description
/**********forum list create vertical list************/
function bsp_list_forums( $args = '' ) {

	// Define used variables
	$output = $sub_forums = $topic_count = $reply_count = $counts = '';
	$i = 0;
	$count = array();

	// Parse arguments against default values
	$r = bbp_parse_args( $args, array(
		'before'            => '<ul class="bbp-forums-list">',
		'after'             => '</ul>',
		'link_before'       => '<li class="bbp-forum">',
		'link_after'        => '</li>',
		'count_before'      => ' (',
		'count_after'       => ')',
		'count_sep'         => ', ',
		'separator'         => ', ',
		'forum_id'          => '',
		'show_topic_count'  => true,
		'show_reply_count'  => true,
	), 'bsp_list_forums' );

	// Loop through forums and create a list
	$sub_forums = bbp_forum_get_subforums( $r['forum_id'] );
	if ( !empty( $sub_forums ) ) {

		// Total count (for separator)
		$total_subs = count( $sub_forums );
		foreach ( $sub_forums as $sub_forum ) {
			$i++; // Separator count

			// Get forum details
			$count     = array();
			$show_sep  = $total_subs > $i ? $r['separator'] : '';
			$permalink = bbp_get_forum_permalink( $sub_forum->ID );
			$title     = bbp_get_forum_title( $sub_forum->ID );
			

			// Show topic count
			if ( !empty( $r['show_topic_count'] ) && !bbp_is_forum_category( $sub_forum->ID ) ) {
				$count['topic'] = bbp_get_forum_topic_count( $sub_forum->ID );
			}

			// Show reply count
			if ( !empty( $r['show_reply_count'] ) && !bbp_is_forum_category( $sub_forum->ID ) ) {
				$count['reply'] = bbp_get_forum_reply_count( $sub_forum->ID );
			}

			// Counts to show
			if ( !empty( $count ) ) {
				$counts = $r['count_before'] . implode( $r['count_sep'], $count ) . $r['count_after'];
			}
			
			// Build this sub forums link
			//AMENDED to add sub forum descriptions
			$content = bbp_get_forum_content($sub_forum->ID) ;
			$output .= $r['link_before'] . '<a href="' . esc_url( $permalink ) . '" class="bbp-forum-link">' . $title . $counts . '</a>' . $r['separator'] .$content . $r['separator'] .$r['link_after'];
		}

		// Output the list
		echo apply_filters( 'bsp_list_forums', $r['before'] . $output . $r['after'], $r );
	}
}



if ( !empty ($bsp_forum_display['add_subforum_list_description'] ))  {
	//check if private groups exists, and if so it takes priority to ensure correct filtering and use of PG settings to enable
	if( ! function_exists('private_groups_list_forums') ) add_filter('bbp_list_forums', 'bsp_list_forums' );
}



/////////////////////////////  TOPIC ORDER

function bsp_date_topic_order( $args ) {
	global $bsp_topic_order ;
	//default order
	if (!empty($bsp_topic_order['Default_OrderActivate'])) {
		$orderby = $bsp_topic_order['Default_OrderOrder'] ;
		switch ($orderby)  {
			case "1":
				//latest reply
				$args['orderby']='meta_value';
				$args['meta_key']='_bbp_last_active_time';
				break;
			case "2":
				//topic date
				$args['orderby']='date';
				break;
			case "3":
				//title
				$args['orderby']='title';
				break;
			case "4":
				//author
				$args['orderby']='author';
				break;
		}
		$order = $bsp_topic_order['Default_OrderAsc'] ;
		switch ($order)  {
			case "1":
				$args['order']='ASC';
				break;
			case "2":
				$args['order']='DESC';
				break;
		}
	}
	if (!empty($bsp_topic_order['Forum_Order1Activate']) ) {
		$include = explode (",",($bsp_topic_order['Forum_Order1Forums'])) ;
		if (in_array (bbp_get_forum_id(),$include ) )  {
		$orderby = $bsp_topic_order['Forum_Order1Order'] ;
			switch ($orderby)  {
				case "1":
					//latest reply
					$args['orderby']='meta_value';
					$args['meta_key']='_bbp_last_active_time';
					break;
				case "2":
					//topic date
					$args['orderby']='date';
					break;
				case "3":
					//title
					$args['orderby']='title';
					break;
				case "4":
					//author
					$args['orderby']='author';
					break;
			}
			$order = $bsp_topic_order['Forum_Order1Asc'] ;
			switch ($order)  {
				case "1":
					$args['order']='ASC';
					break;
				case "2":
					$args['order']='DESC';
					break;
			}
		}
	}
	return $args;
}

//add filter if either apply
if (!empty($bsp_topic_order['Default_OrderActivate']) || !empty($bsp_topic_order['Forum_Order1Activate'])) {
	add_filter('bbp_before_has_topics_parse_args','bsp_date_topic_order');
}

//add topic rules
if (!empty($bsp_style_settings_form['topic_posting_rulesactivate_for_topics'])) add_action( 'bbp_theme_before_topic_form_title', 'bsp_topic_rules')  ;
if (!empty($bsp_style_settings_form['topic_posting_rulesactivate_for_replies'])) add_action( 'bbp_theme_before_reply_form_notices', 'bsp_topic_rules')  ;

function bsp_topic_rules () {
global $bsp_style_settings_form ; 
$content = $bsp_style_settings_form['topic_rules_text'] ;
echo '<div class="bsp-topic-rules">'.$content.'</div>' ;
}

//This function changes the text wherever it is quoted
function bsp_change_text2( $translated_text, $text, $domain ) {
	global $bsp_style_settings_ti ;
	if ( $text == 'Oh bother! No topics were found here!' ) {
	$translated_text = $bsp_style_settings_ti['empty_forum'];
	}
	return $translated_text;
}

if (!empty ($bsp_style_settings_ti['empty_forum'] )) add_filter( 'gettext', 'bsp_change_text2', 20, 3 );

//This function changes the text wherever it is quoted
function bsp_change_text3( $translated_text, $text, $domain ) {
	global $bsp_style_settings_search ;
	if ( $text == 'Oh bother! No search results were found here!' ) {
	$translated_text = $bsp_style_settings_search['empty_search'];
	}
	return $translated_text;
}

if (!empty ($bsp_style_settings_search['empty_search'] )) add_filter( 'gettext', 'bsp_change_text3', 20, 3 );


//change forum order if activated
if ( !empty ($bsp_forum_order['Orderactivate'] )) {
	if ($bsp_forum_order['Orderorder'] == 2) add_filter('bbp_before_has_forums_parse_args', 'bsp_forum_order_by_freshness');
	if ($bsp_forum_order['Orderorder'] == 3) add_filter('bbp_before_has_forums_parse_args', 'bsp_forum_order_by_newness_newtop');
	if ($bsp_forum_order['Orderorder'] == 4) add_filter('bbp_before_has_forums_parse_args', 'bsp_forum_order_by_newness_oldtop');
	
}

function bsp_forum_order_by_freshness ($args) {
	$args['meta_key'] = '_bbp_last_active_time' ;
	$args['orderby']    = 'meta_value' ;
	$args['order']     = 'DESC' ;
	return $args ;
}

function bsp_forum_order_by_newness_oldtop ($args) {
	$args['orderby']    = 'date' ;
	$args['order']     = 'ASC' ;
	return $args ;
}

function bsp_forum_order_by_newness_newtop ($args) {
	$args['orderby']    = 'date' ;
	$args['order']     = 'DESC' ;
	return $args ;
}

if (!empty($bsp_style_settings_form['Show_editorsactivate'])) {
	add_filter( 'bbp_after_get_the_content_parse_args', 'bsp_enable_visual_editor' );
	add_filter( 'bbp_get_tiny_mce_plugins', 'bsp_tinymce_paste_plain_text' );
}

//editor bbpress
function bsp_enable_visual_editor( $args = array() ) {
	global $bsp_style_settings_form ;
    $args['tinymce'] = true;
	if ($bsp_style_settings_form['Show_editorsactivate'] == 1)  $args['quicktags'] = false;
	return $args;
}

//clean html when copy and paste into forum
function bsp_tinymce_paste_plain_text( $plugins = array() ) {
    $plugins[] = 'paste';
    return $plugins;
}


//////////This is from Pascal's toolkit, so only execute if needed (ie pascals function doesn't exist)
// Blocked users should NOT get an email to subscribed topics
function bsp_fltr_get_forum_subscribers( $user_ids ) {
        if (!empty( $user_ids ) ) {
                $new_user_ids = array();
                foreach ($user_ids as $uid) {
                        if (bbp_get_user_role($uid) != 'bbp_blocked') {
                                $new_user_ids[] = $uid;
                        }
                }
                return $new_user_ids;
        } else {
                return $user_ids;
        } 
}; 
// add the filter

if(!function_exists('bbptoolkit_fltr_get_forum_subscribers')){
add_filter( 'bbp_forum_subscription_user_ids', 'bsp_fltr_get_forum_subscribers', 10, 1 );
}

if (!empty($bsp_style_settings_t['anon_emailShow'])) {
	$current_user = wp_get_current_user()->ID;
	if ( bbp_is_user_keymaster($current_user)) {
		add_action ('bbp_theme_after_reply_author_admin_details', 'bsp_add_email') ;
	}
}

function bsp_add_email () {
	$email = get_post_meta ( bbp_get_reply_id () , '_bbp_anonymous_email', true ) ;
	if (!empty ($email))
		echo '<p>'.$email ;
}


