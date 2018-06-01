<?php

function bsp_new() {
 ?>
			
						<table class="form-table">
					
					<tr valign="top">
						<th colspan="2">
						
						<h3>
						<?php _e ("What's New?" , 'bbp-style-pack' ) ; ?>
						</h3>  

						<h4><span style="color:blue"><?php _e('Version 3.8.7/3.8.8', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("1. I've fixed issues with the unread posts function, where 'mark all topics as read' was not working correctly." , 'bbp-style-pack') ; ?>
</p>
<p>
<?php _e("2. For unread posts, I've added the ability to hide the 'Mark as read' button on the main index - on large sites marking everything as read may be slow, so just adding the option for those that want it." , 'bbp-style-pack') ; ?>
</p>

<h4><span style="color:blue"><?php _e('Version 3.8.6', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("I've added the ability to export and import settings.  This may be useful if you want to move settings between sites, say from a test to a live site, or juts to save a configuration that you can come back to." , 'bbp-style-pack') ; ?>
</p>
						
<h4><span style="color:blue"><?php _e('Version 3.8.5', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("I've added the ability to hide the 'Oh bother! No topics were found here!' and 'Your account has the ability to post unrestricted HTML content' messages see 'topic/reply form' and 'Topics Index Styling' tabs" , 'bbp-style-pack') ; ?>
</p>
						
<h4><span style="color:blue"><?php _e('Version 3.8.4', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("1. This release fixes an issue for new topics when using the plugin gd bbpress attachments" , 'bbp-style-pack') ; ?>
</p>
<p>
<?php _e("2. Where sites allow non-registered users to post topics and replies, they are asked for their email address, but this is not shown anywhere.  I've added an option to show this for administrators underneath the author on topics and replies to help with administration." , 'bbp-style-pack') ; ?>
</p>
						
<h4><span style="color:blue"><?php _e('Version 3.8.2', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("1. I've added url options to breadcrumbs.  For most users the breadcrumbs work fine, but occasionally users want to 'home' and/or 'root' breadcrumbs to go to somewhere specific.  There are now options in the 'Breadcrumbs' tab to change these." , 'bbp-style-pack') ; ?>
</p>
<p>
<?php _e("2. Where sites allow non-registered users to post topics and replies, they are asked for their email address, but this is not shown anywhere.  I've added an option to show this for administrators underneath the author on topics and replies to help with administration." , 'bbp-style-pack') ; ?>
</p>					
	
						
<h4><span style="color:blue"><?php _e('Version 3.8.0', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("I've fixed an issue in the topic/reply form where the visual editor was not working, and added options for which editors show see tab 'Topic/Reply Form' item 9." , 'bbp-style-pack') ; ?>
</p>
						
<h4><span style="color:blue"><?php _e('Version 3.7.8', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("I've added the option of forum created date to the sort orders in the 'Forum Order' tab.  This might suit a site where say new products are being launched and a forum for each is created, or say events are held and you want a forum for each." , 'bbp-style-pack') ; ?>
</p>
						
<h4><span style="color:blue"><?php _e('Version 3.7.7', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("1. A small correction to take out links for @mentions in topic and reply content where the user has set profile links to not show." , 'bbp-style-pack') ; ?>
</p>
<p>
<?php _e("2. I've added a new shortcode [bsp-forum-subscriber-count].  This lets you display the number of current subscribers to a specific forum" , 'bbp-style-pack') ; ?>
</p>					
						
						<h4><span style="color:blue"><?php _e('Version 3.7.6', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("In the shortcode 'bsp-display-forum-index' I've added the ability to change forum in the header to another title.  This may be useful if say you are using this shortcode to call a number of forums, and want a group name for them.  See 'Shortcodes' tab for details." , 'bbp-style-pack') ; ?>
</p>						
						
						
						
						<h4><span style="color:blue"><?php _e('Version 3.7.5', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("A fix for cases where author role is not setting correctly - all a bit technical so hopefully you'll see no change !" , 'bbp-style-pack') ; ?>
</p>

						<h4><span style="color:blue"><?php _e('Version 3.7.4', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("A fix for those who are hiding 'Private:' before the forum name.  This was taking out the whole forum name in the bbpress forum widget when used on a non-forum page." , 'bbp-style-pack') ; ?>
</p>
		
						
<h4><span style="color:blue"><?php _e('Version 3.7.3', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("I added the ability to change the 'Oh bother! No search results were found here!' message - see 'Search Styling' tab " , 'bbp-style-pack') ; ?>
</p>
						
<h4><span style="color:blue"><?php _e('Version 3.7.2', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("A fix to correctly show subscription forums if you have freshness order " , 'bbp-style-pack') ; ?>
</p>

<h4><span style="color:blue"><?php _e('Version 3.7.1', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("An update to keep style pack in line with the latest private groups plugin" , 'bbp-style-pack') ; ?>
</p>
						
<h4><span style="color:blue"><?php _e('Version 3.7.0', 'bbp-style-pack' ) ; ?></span></h4>
<p>
<?php _e("1. A technical change to allow filtering of href for create new topic button, for users with wordpress on a sub-folder  " , 'bbp-style-pack'); ?>
</p>
<p>
<?php _e("2. In bbpress, if a user is blocked they still receive subscriptions - I've added an automatic block to this",  'bbp-style-pack'); ?>
</p>	
						


 <?php
}
