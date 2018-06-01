<?php

// shortcodes functions

add_shortcode('bsp-display-topic-index', 'bsp_display_topic_index');  
add_shortcode('bsp-display-newest-users', 'bsp_display_newest_users'); 
add_shortcode('bsp-display-forum-index', 'bsp_display_selected_forum'); 
add_shortcode ('profile', 'bsp_display_edit_profile_link') ;
add_shortcode ('bsp-forum-subscriber-count', 'bsp_forum_subscriber_count') ;


function bsp_display_topic_index($attr, $content = '' ) {

		// Sanity check required info
		//if ( !empty( $content ) || ( empty( $attr['show'] )  || !is_numeric( $attr['show'] ) ) )
		//	return $content;
			
		
		// Unset globals
		bsp_unset_globals();
		global $show ;
		global $forum ;
		global $stickies ;
		global $display ;
		global $noreply ;
		
		
		if (!empty( $attr['show'])) $show=$attr['show']	;
		if (!empty( $attr['forum'])) $forum=$attr['forum'] ;				
		if (!empty( $attr['show_stickies'])) $stickies=$attr['show_stickies'] ;
		if (!empty( $attr['template'])) $display=$attr['template'] ;
		if (!empty( $attr['noreply'])) $noreply = $attr['noreply'] ;
		
		// Filter the query
		if ( ! bbp_is_topic_archive() ) {
			add_filter( 'bbp_before_has_topics_parse_args', 'bsp_display_topic_index_query' ) ;
		}

		// Start output buffer
		bsp_start( 'bbp_topic_archive' );

		// Output template
		global $display ;
		if ($display== 'short') {
			?>
			<div id="bbpress-forums">
			<?php
			if ( bbp_is_topic_tag() ) bbp_topic_tag_description();
				if ( bbp_has_topics() ) bbp_get_template_part( 'loop',       'topics'    ); 
				else  bbp_get_template_part( 'feedback',   'no-topics' ); ?>
			</div>
		<?php
		}
		else bbp_get_template_part( 'content', 'archive-topic' );

		// Return contents of output buffer
		return bsp_end();
	}
 
	function bsp_start( $query_name = '' ) {

		// Set query name
		bbp_set_query_name( $query_name );

		// Start output buffer
		ob_start();
	}
	
	function bsp_end() {

		// Unset globals
		bsp_unset_globals();

		// Reset the query name
		bbp_reset_query_name();

		// Return and flush the output buffer
		return ob_get_clean();
	}
	
	function bsp_unset_globals() {
		$bbp = bbpress();

		// Unset global queries
		$bbp->forum_query  = new WP_Query();
		$bbp->topic_query  = new WP_Query();
		$bbp->reply_query  = new WP_Query();
		$bbp->search_query = new WP_Query();

		// Unset global ID's
		$bbp->current_view_id      = 0;
		$bbp->current_forum_id     = 0;
		$bbp->current_topic_id     = 0;
		$bbp->current_reply_id     = 0;
		$bbp->current_topic_tag_id = 0;

		// Reset the post data
		wp_reset_postdata();
	}
	
	function bsp_display_topic_index_query( $args = array() ) {
		global $forum ;
		global $stickies ;
		global $show ;
		global $noreply ;
	
		
		
		if (!empty( $forum)) {
		$forums = explode(',', $forum);
				$args['post_parent__in'] = $forums;
				$args['post_parent'] = '' ;
		}
		
		if (!empty ($stickies)) $args['show_stickies'] = $stickies ;
		else $args['show_stickies'] = false ;
		
		if (!empty ($noreply)) {
		$args['meta_query']  = array(
		array(
			'key'       => '_bbp_reply_count',
			'value'     => '0',
			'compare'   => '=',
			'type'      => 'NUMERIC',
			),
		);
		}
		
		if (!empty ($show)) {
			$args['posts_per_page'] = $show ;
			$args['max_num_pages'] = 1;
		}
		else {
			$args['posts_per_page'] = bbp_get_topics_per_page() ;
			$args['max_num_pages'] = false;
		}
		
			
		$args['author']        = 0;
		$args['order']         = 'DESC';
		
		
		

	
		//allow private groups and/or other plugins to filter this query
		return apply_filters( 'bsp_display_topic_index_query', $args );
		
	}
	
	

// adds a shortcode that displays the latest wordpress registered
	
	
Function bsp_display_newest_users ($attr) {
if ( is_numeric( $attr['show'] ))  $number=$attr['show'] ;
else $number = 5 ;
	$users = get_users( array( 'orderby' => 'registered', 'order' => 'desc', 'number' => $number )); 
	$heading1= __('Newest users','bbp-style-pack')  ; 
	$heading2= __('Date joined','bbp-style-pack')  ; 
	echo '<table><th align=left>'.$heading1.'</th><th align=left>'.$heading2.'</th>' ;
	
	foreach ( $users as $user ) {
		$date=date_i18n("jS M Y", strtotime($user->user_registered )); 
		echo '<tr><td>' . esc_html( $user->display_name ).'</td>' ;
		echo '<td>'.$date.'</td>' ;
		echo '</tr>' ;
	}
	echo '</table>' ;
}


//adds a shortcode to display the index from a single forum
function bsp_display_selected_forum($attr, $content = '' ) {

		// Sanity check required info
		if ( !empty( $content ) || ( empty( $attr['forum'] )  ) )
		//$content = 'no forum(s) set ' ;
		return $content;
		
		// Unset globals
		bsp_unset_globals();
		global $forum ;
		if (!empty( $attr['forum'])) $forum=$attr['forum'] ;
		
		if (!empty( $attr['breadcrumb']) && ($attr['breadcrumb'] == 'no' ) ) {
			add_filter ('bbp_no_breadcrumb', '__return_false');
		}	
		
		if (!empty( $attr['search']) && ($attr['search'] == 'no' ) ) {
			add_filter ('bbp_allow_search', '__return_false');
		}			
		

		// Filter the query
		if ( ! bbp_is_forum_archive() ) {
			add_filter( 'bbp_before_has_forums_parse_args', 'bsp_display_forum_query' ) ;
		}
		
		if (!empty( $attr['title']) ) {
			global $title ;
			$title =  $attr['title'] ;
			add_filter( 'gettext', 'bsp_change_category_text', 20, 3 ) ;
		}		
		
		// Start output buffer
		bsp_start( 'bbp_forum_archive' );
		

		// Output template
		bbp_get_template_part( 'content', 'archive-forum' );

		// Return contents of output buffer
		return bsp_end();
	}
	
function bsp_display_forum_query( $args ) {
		global $forum ;
		
		// split the string into pieces
		$forums = explode(',', $forum);
				
		$args['post__in'] = $forums;
		$args['post_parent'] = '' ;
		$args['orderby'] = 'post__in'  ;
		
		//allow private groups and/or other plugins to filter this query
		return apply_filters( 'bsp_display_forum_query', $args );
		
}



function bsp_no_search () {
return false ;
}




function bsp_display_edit_profile_link ($attr) {
	if (!is_user_logged_in())
		return ;
	else
		$current_user = wp_get_current_user();
		$user=$current_user->user_login ;
		$root = get_option ('_bbp_root_slug', true) ;
		$label = (!empty ($attr['label']) ? $attr['label'] : 'Amend your profile or password') ;
		$profilelink = '<li><a href="/'.$root.'/users/' . $user . '/edit">'.$label.'</a></li>';
		echo $profilelink ;
	
}


function bsp_change_category_text( $translated_text, $text, $domain ) {
	global $title ;
	if ( $text == 'Forum' ) {
	$translated_text = $title ;
	}
	return $translated_text;
}


function bsp_forum_subscriber_count ($attr, $content = '') {
	//bail if no forum set
	if (empty ($attr['forum'] )) return ;
	if (empty ($attr['before'] )) $attr['before']='' ;
	if (empty ($attr['after'] )) $attr['after']='' ;
	
	
	$count = 0 ;
	$users= get_users () ;
	if ( $users ) :
		foreach ( $users as $user ) {
			$user_id = $user->ID ;
			$subscriptions = bbp_get_user_subscribed_forum_ids( $user_id );
			if (in_array ( $attr['forum'], $subscriptions))  $count++ ;
		}
	endif ;
	
	echo $attr['before'].$count.$attr['after'] ;
}
