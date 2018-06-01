<?php

//freshness display style settings page

function bsp_style_settings_freshness () {
	global $bsp_style_settings_freshness ;
	//test if this is the first time accessing the settings, and if so set $check = 1
	$check = (!empty($bsp_style_settings_freshness) ? 0 : 1);
	?> 
	<Form method="post" action="options.php">
	<?php wp_nonce_field( 'style-settings_freshness', 'style-settings-nonce' ) ?>
	<?php settings_fields( 'bsp_style_settings_freshness' );
	?>
	
	<table>
		<tr>
			<td>
				<p>
					<?php _e('This section allows you to amend freshness', 'bbp-style-pack'); ?>
				</p>
			</td>
			<td>	
				<?php echo '<img src="' . plugins_url( 'images/freshness_display.JPG',dirname(__FILE__)  ) . '" > '; ?>
			</td>
		</tr>
	</table>
	<!-- save the options -->
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e( 'Save changes', 'bsp_style_settings_freshness' ); ?>" />
	</p>
			
	<table class="form-table">
	
	<!-- checkbox to activate  -->
		<tr valign="top">  
			<th>
				<?php _e('Activate Freshness display', 'bbp-style-pack'); ?>
			</th>
			<td>
				<?php $item = (!empty( $bsp_style_settings_freshness['activate'] ) ?  $bsp_style_settings_freshness['activate'] : '');
				echo '<input name="bsp_style_settings_freshness[activate]" id="bsp_style_settings_freshness[activate]" type="checkbox" value="1" class="code" ' . checked( 1,$item, false ) . ' />' ;
				?>
			</td>
		</tr>
<!-------------------------------Heading---------------------------------------->
		<tr valign="top">
			<th>
				1. <?php _e('Heading Name', 'bbp-style-pack'); ?>
			</th>
			<td colspan="2">
				<?php 
				$item1 = (!empty ($bsp_style_settings_freshness['heading_name'] ) ? $bsp_style_settings_freshness['heading_name']  : '' ) ?>
				<input id="bsp_style_settings_freshness[heading_name]" class="large-text" name="bsp_style_settings_freshness[heading_name]" type="text" value="<?php echo esc_html( $item1 ) ;?>" /><br/>
				<label class="description" for="bsp_settings[heading_label]"><?php _e( 'Default : Freshness - if you wish to change enter the heading description eg "Last Post", "Last updated", "Freshness" "Last activity" etc.', 'bbp-style-pack' ); ?></label><br/>
			</td>
		</tr>

		<tr>
			<th style="width:250px">
				2. <?php _e('Topic Title', 'bbp-style-pack'); ?> 
			</th>
			<td>
				<?php
				$item =  'bsp_style_settings_freshness[show_title]' ;
				$item1 = (!empty($bsp_style_settings_freshness['show_title']) ? $bsp_style_settings_freshness['show_title'] : '');
				echo '<input name="'.$item.'" id="'.$item.'" type="checkbox" value="1" class="code" ' . checked( 1,$item1, false ) . ' />' ;
				_e('Click to show Title on forums pages', 'bbp-style-pack');
				?>
			</td>
		</tr>
		
		<tr>
			<th>
				3. <?php _e('Topic Freshness', 'bbp-style-pack'); ?>
			</th>
			<td>
				<?php
				$item =  'bsp_style_settings_freshness[show_date]' ;
				$item1 = (!empty($bsp_style_settings_freshness['show_date']) ? $bsp_style_settings_freshness['show_date'] : '');
				if ($check == 1) $item1 = 1 ;
				echo '<input name="'.$item.'" id="'.$item.'" type="checkbox" value="1" class="code" ' . checked( 1,$item1, false ) . ' />' ;
				_e('Click to show Freshness (see 6. below for format)', 'bbp-style-pack');
				?>
			</td>
		</tr>
		
		<tr>
			<th>
				4.<?php _e('Topic Author name', 'bbp-style-pack'); ?>
			</th>
			<td>
				<?php
				$item =  'bsp_style_settings_freshness[show_name]' ;
				$item1 = (!empty($bsp_style_settings_freshness['show_name']) ? $bsp_style_settings_freshness['show_name'] : '');
				if ($check == 1) $item1 = 1 ;
				echo '<input name="'.$item.'" id="'.$item.'" type="checkbox" value="1" class="code" ' . checked( 1,$item1, false ) . ' />' ;
				_e('Click to show Author name', 'bbp-style-pack');
				?>
			</td>
		</tr>
		
		<tr>
			<th>
				5.<?php _e('Topic Author avatar', 'bbp-style-pack'); ?> 
			</th>
			<td>
				<?php
				$item =  'bsp_style_settings_freshness[show_avatar]' ;
				$item1 = (!empty($bsp_style_settings_freshness['show_avatar']) ? $bsp_style_settings_freshness['show_avatar'] : '');
				if ($check == 1) $item1 = 1 ;
				echo '<input name="'.$item.'" id="'.$item.'" type="checkbox" value="1" class="code" ' . checked( 1,$item1, false ) . ' />' ;
				_e('Click to show author avatar', 'bbp-style-pack');
				?>
			</td>
		</tr>
		
		<tr>
			<th>
				6. <?php _e('Freshness format', 'bbp-style-pack'); ?> 
			</th>
			<td>
				<?php echo '<img src="' . plugins_url( 'images/freshness.JPG',dirname(__FILE__)  ) . '" > '; ?>
			</td>
			<td>
				<?php echo '<img src="' . plugins_url( 'images/date.JPG',dirname(__FILE__)  ) . '" > '; ?>
			</td>
		</tr>
		
		<tr>	
			<td>
			</td>
			<td style="width:250px;vertical-align:top">
				<?php
				$item0='bsp_style_settings_freshness[date_format]' ;
				$value0 = (!empty($bsp_style_settings_freshness['date_format']) ? $bsp_style_settings_freshness['date_format'] : 1) ; 
				echo '<input name="'.$item0.'" id="'.$value0.'" type="radio" value="1" class="code"  ' . checked( 1,$value0, false ) . ' />' ;
				_e ('Click to show time since last post' , 'bbp-style-pack' ) ;?>
				<br/>
					<label class="description">
						<?php _e( '<i>Default</i>' , 'bbp-style-pack' ); ?>
					</label>
			
			</td>
			<td style="width:250px;vertical-align:top">
				<?php
				echo '<input name="'.$item0.'" id="'.$value0.'" type="radio" value="2" class="code"  ' . checked( 2,$value0, false ) . ' />' ;
				_e ('Click to show date of last post' , 'bbp-style-pack' ) ;?>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
			</td>
			<td>
				<?php
				$name =  'bsp_style_settings_freshness[date_order]' ;
				$item = (!empty($bsp_style_settings_freshness['date_order']) ? $bsp_style_settings_freshness['date_order'] : '0');
				echo '<input name="'.$name.'" id="'.$item.'" type="radio" value="0" class="code"  ' . checked( 0,$item, false ) . ' />' ;
				_e ('Date First' , 'bbp-style-pack' ) ;?>
			
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
			</td>
			<td>
				<?php
				echo '<input name="'.$name.'" id="'.$item.'" type="radio" value="1" class="code"  ' . checked( 1,$item, false ) . ' />' ;
				_e ('Time First' , 'bbp-style-pack' ) ;?>
			</td>
		</tr>
		
		<tr valign="top">
			<td>
			</td>
			<td>
			</td>
			<td>
				<?php 
				_e('Separator', 'bbp-style-pack'); 
				$item1 = (!empty ($bsp_style_settings_freshness['date_separator'] ) ? $bsp_style_settings_freshness['date_separator']  : ' at ' ) ?>
				<input id="bsp_style_settings_freshness[date_separator]" class="large-text" name="bsp_style_settings_freshness[date_separator]" type="text" value="<?php echo esc_html( $item1 ) ;?>" /><br/>
					<label class="description" for="bsp_style_settings_freshness[date_separator]">
						<?php _e( 'eg " at " "," ":" - do not forget to include any spaces needed', 'bbp-style-pack' ); ?>
					</label>
					<br/>
			</td>
		</tr>
	
		<tr>
			<td>
			</td>
			</td>
			<td>
			<th scope="row">
				<?php _e('Date Format') ?>
			</th>
			<td>
			</td>
		</tr>
		
		<tr>
			<fieldset>
				<legend class="screen-reader-text">
					<span>
						<?php _e('Date Format') ?>
					</span>
				</legend>
				
		<tr>
			<td>
			</td>
			<td>
			</td>
			<td>
				<?php
				//Filters the default date formats.
				$date_formats = array_unique( apply_filters( 'date_formats', array( __( 'F j, Y' ), 'Y-m-d', 'm/d/Y', 'd/m/Y' ) ) );
				$custom = true;
	
				$date = (!empty($bsp_style_settings_freshness['bsp_date_format']) ? $bsp_style_settings_freshness['bsp_date_format'] : get_option('date_format'));
				$name =  'bsp_style_settings_freshness[bsp_date_format]' ;
	
				foreach ( $date_formats as $format ) {
					echo "\t<label><input type='radio' name=".$name." value='" . esc_attr( $format ) . "'";
						if ( $date === $format ) { // checked() uses "==" rather than "==="
							echo " checked='checked'";
							$custom = false;
						}
					echo ' /> <span class="date-time-text format-i18n">' . date_i18n( $format ) . '</span><code>' . esc_html( $format ) . "</code></label><br />\n";
				}
				
				echo '<label><input type="radio" name="bsp_style_settings_freshness[bsp_date_format]" id="date_format_custom_radio" value="'. $date .'"';
				if ($custom == true) echo " checked='checked'";
					echo '/> <span class="date-time-text date-time-custom-text">' . __( 'Custom:' ) . '<span class="screen-reader-text"> ' . __( 'enter a custom date format in the following field' ) . '</span></label>' .
					'<label for="date_format_custom" class="screen-reader-text">' . __( 'Custom date format:' ) . '</label>' .
					'<input type="text" name="bsp_style_settings_freshness[bsp_date_format]" id="date_format_custom" value="' . $date . '" class="medium-text" /></span>' .
					'<span class="screen-reader-text">' . __( 'example:' ) . ' </span> <span class="example">' . $date . '</span>' .
					"<span class='spinner'></span>\n";
				?>
			</fieldset>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			</td>
			<td>
			<th scope="row">
				<?php _e('Time Format') ?>
			</th>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
			</td>
			<td>
				<fieldset>
					<legend class="screen-reader-text">
						<span>
							<?php _e('Time Format') ?>
						</span>
					</legend>
				<?php
				//Filters the default time formats.
				$time_formats = array_unique( apply_filters( 'time_formats', array( __( 'g:i a' ), 'g:i A', 'H:i' ) ) );

				$custom = true;
	
				$time = (!empty($bsp_style_settings_freshness['bsp_time_format']) ? $bsp_style_settings_freshness['bsp_time_format'] : get_option('time_format'));
				$name =  'bsp_style_settings_freshness[bsp_time_format]' ;

				foreach ( $time_formats as $format ) {
					echo "\t<label><input type='radio' name=".$name." value='" . esc_attr( $format ) . "'";
						if ( $time === $format ) { // checked() uses "==" rather than "==="
							echo " checked='checked'";
							$custom = false;
						}
					echo ' /> <span class="date-time-text format-i18n">' . date_i18n( $format ) . '</span><code>' . esc_html( $format ) . "</code></label><br />\n";
				}

				echo '<label><input type="radio" name="bsp_style_settings_freshness[bsp_time_format]" id="time_format_custom_radio" value="'. $time .'"';
				if ($custom == true) echo " checked='checked'";
				echo '/> <span class="date-time-text date-time-custom-text">' . __( 'Custom:' ) . '<span class="screen-reader-text"> ' . __( 'enter a custom time format in the following field' ) . '</span></label>' .
				'<label for="time_format_custom" class="screen-reader-text">' . __( 'Custom time format:' ) . '</label>' .
				'<input type="text" name="bsp_style_settings_freshness[bsp_time_format]" value="' . $time . '" class="medium-text" /></span>' .
				'<span class="screen-reader-text">' . __( 'example:' ) . ' </span> <span class="example">' . $time . '</span>' .
				"<span class='spinner'></span>\n";

				echo "\t<p class='date-time-doc'>" . __('<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Documentation on date and time formatting</a>.') . "</p>\n";
				?>
			</fieldset>
			</td>
		</tr>
	
	</table>
					
<!-- save the options -->
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e( 'Save changes', 'bsp_style_settings_freshness' ); ?>" />
	</p>
</form>
		
</div><!--end sf-wrap-->

</div><!--end wrap-->
	
	 
<?php
}
		

	
