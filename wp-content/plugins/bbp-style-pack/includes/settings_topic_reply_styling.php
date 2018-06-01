<?php

//topic/repy styling tab

function bsp_style_settings_t () {
	global $bsp_style_settings_t ;
	?>
	<Form method="post" action="options.php">
	<?php wp_nonce_field( 'style-settings-t', 'style-settings-nonce' ) ?>
	<?php settings_fields( 'bsp_style_settings_t' );
	//create a style.css on entry and on saving
	generate_style_css() ;
	?>
	
	<table>
		<tr>
			<td>
				<p>
					<?php _e('This section allows you to amend styles.', 'bbp-style-pack'); ?>
				</p>
				<p>
					<?php _e('You only need to enter those styles and elements within a style that you wish to alter', 'bbp-style-pack'); ?>
				</p>
			</td>
			<td>	
				<?php
				//show style image
				echo '<img src="' . plugins_url( 'images/topic.JPG',dirname(__FILE__)  ) . '" > '; ?>
			</td>
		</tr>
	</table>
	<!-- save the options -->
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e( 'Save changes', 'bsp_style_settings_t' ); ?>" />
	</p>
	<table class="form-table">
	

<!--1. Topic/Reply Content background ------------------------------------------------------------------->
		<tr>
			<?php 
			$name = 'Topic/Reply Content' ;
			$name0 = __('Topic/Reply Content', 'bbp-style-pack') ;
			$name1 = __('Background color - odd numbers', 'bbp-style-pack') ;
			$name2 = __('Background color - even numbers', 'bbp-style-pack') ;
			$area1='Background color - odd numbers' ;
			$area2='Background color - even numbers' ;
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$item2="bsp_style_settings_t[".$name.$area2."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '#fff') ;
			$value2 = (!empty($bsp_style_settings_t[$name.$area2]) ? $bsp_style_settings_t[$name.$area2]  : '#fbfbfb') ;
			?>
			<th>
				<?php echo '1. '.$name0 ?>
			</th>
			<td>
				<?php echo $name1 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item1.'" class="bsp-color-picker" name="'.$item1.'" type="text" value="'.esc_html( $value1 ).'"<br>' ; ?> 
					<label class="description">
						<?php _e( 'Click to set color - You can select from palette or enter hex value - see help for further info', 'bbp-style-pack') ; ?>
						<?php _e (' ')._e ('Default', 'bbp-style-pack' )._e(' #fff') ; ?>
					</label><br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td> 
				<?php echo $name2 ; ?> 
			</td>
			<td>
				<?php echo '<input id="'.$item2.'" class="bsp-color-picker" name="'.$item2.'" type="text" value="'.esc_html( $value2 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Click to set color - You can select from palette or enter hex value - see help for further info', 'bbp-style-pack') ; ?>
					<?php _e (' ')._e ('Default', 'bbp-style-pack' )._e(' #fbfbfb') ; ?>
				</label><br/>
			</td>
		</tr>
			
<!--2. Topic/Reply header background ------------------------------------------------------------------->
		<tr>
			<?php 
			$name = 'Topic/Reply Header' ;
			$name0 = __('Topic/Reply Header', 'bbp-style-pack') ;
			$name1 = __('Background color', 'bbp-style-pack') ;
			$area1='Background color' ;
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '#f4f4f4') ;
			?>
			<th>
				<?php echo '2. '.$name0 ?>
			</th>
			<td>
				<?php echo $name1 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item1.'" class="bsp-color-picker" name="'.$item1.'" type="text" value="'.esc_html( $value1 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Click to set color - You can select from palette or enter hex value - see help for further info', 'bbp-style-pack') ; ?>
					<?php _e (' ')._e ('Default', 'bbp-style-pack' )._e(' #f4f4f4') ; ?>
				</label><br/>
			</td>
		</tr>
		
<!--3. Trash/spam background color ------------------------------------------------------------------->
		<tr>
			<?php 
			$name = 'Trash/Spam Content' ;
			$name0 = __('Trash/Spam Content', 'bbp-style-pack') ;
			$name1 = __('Background color - odd numbers', 'bbp-style-pack') ;
			$name2 = __('Background color - even numbers', 'bbp-style-pack') ;
			$area1='Background color - odd numbers' ;
			$area2='Background color - even numbers' ;
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$item2="bsp_style_settings_t[".$name.$area2."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '#fdd') ;
			$value2 = (!empty($bsp_style_settings_t[$name.$area2]) ? $bsp_style_settings_t[$name.$area2]  : '#fee') ;
			?>
			<th>
				<?php echo '3. '.$name0 ?>
			</th>
			<td> 
				<?php echo $name1 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item1.'" class="bsp-color-picker" name="'.$item1.'" type="text" value="'.esc_html( $value1 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Click to set color - You can select from palette or enter hex value - see help for further info', 'bbp-style-pack') ; ?>
					<?php _e (' ')._e ('Default', 'bbp-style-pack' )._e(' #fdd') ; ?>
				</label><br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name2 ; ?> 
			</td>
			<td>
				<?php echo '<input id="'.$item2.'" class="bsp-color-picker" name="'.$item2.'" type="text" value="'.esc_html( $value2 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Click to set color - You can select from palette or enter hex value - see help for further info', 'bbp-style-pack') ; ?>
				<?php _e (' ')._e ('Default', 'bbp-style-pack' )._e(' #fee') ; ?>
				</label><br/>
			</td>
		</tr>

<!--4. Closed background color ------------------------------------------------------------------->
			<tr>
			<?php 
			$name = 'Closed Topic Content' ;
			$name0 = __('Closed Topic Content', 'bbp-style-pack') ;
			$name1 = __('Background color', 'bbp-style-pack') ;
			$area1='Background color' ;
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '#fdd') ;
			?>
			<th>
				<?php echo '4. '.$name0 ?>
			</th>
			<td>
				<?php echo $area1 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item1.'" class="bsp-color-picker" name="'.$item1.'" type="text" value="'.esc_html( $value1 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Click to set color - You can select from palette or enter hex value - see help for further info', 'bbp-style-pack') ; ?>
					<?php _e (' ')._e ('Default', 'bbp-style-pack' )._e(' #ccc') ; ?>
				</label><br/>
			</td>
		</tr>
			
<!--5. Font - topic/reply date  ------------------------------------------------------------------->
		<tr>
			<?php 
			$name = 'Topic/Reply Date Font' ;
			$name0 = __('Topic/Reply Date Font', 'bbp-style-pack') ;
			$name1 = __('Size', 'bbp-style-pack') ;
			$name2 = __('Color', 'bbp-style-pack') ;
			$name3 = __('Font', 'bbp-style-pack') ;
			$name4 = __('Style', 'bbp-style-pack') ;
			$area1='Size' ;
			$area2='Color' ;
			$area3='Font' ;
			$area4='Style';
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$item2="bsp_style_settings_t[".$name.$area2."]" ;
			$item3="bsp_style_settings_t[".$name.$area3."]" ;
			$item4="bsp_style_settings_t[".$name.$area4."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '') ;
			$value2 = (!empty($bsp_style_settings_t[$name.$area2]) ? $bsp_style_settings_t[$name.$area2]  : '') ;
			$value3 = (!empty($bsp_style_settings_t[$name.$area3]) ? $bsp_style_settings_t[$name.$area3]  : '') ;
			$value4 = (!empty($bsp_style_settings_t[$name.$area4]) ? $bsp_style_settings_t[$name.$area4]  : '') ;
			?>
			<th>
				<?php echo '5. '.$name0 ?>
			</th>
			<td>
				<?php echo $name1 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item1.'" class="large-text" name="'.$item1.'" type="text" value="'.esc_html( $value1).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Default 12px - see help for further info', 'bbp-style-pack' ); ?>
				</label><br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name2 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item2.'" class="bsp-color-picker" name="'.$item2.'" type="text" value="'.esc_html( $value2 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Click to set color - You can select from palette or enter hex value - see help for further info', 'bbp-style-pack') ; ?>
				</label><br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name3 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item3.'" class="large-text" name="'.$item3.'" type="text" value="'.esc_html( $value3 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Enter Font eg Arial - see help for further info', 'bbp-style-pack' ); ?>
					</label>
					<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name4 ; ?> 
			</td>
			<td>
				<select name="<?php echo $item4 ; ?>">
					<?php echo '<option value="'.esc_html( $value4).'">'.esc_html( $value4) ; ?> 
					<option value="Normal">Normal</option>
					<option value="Italic">Italic</option>
					<option value="Bold">Bold</option>
					<option value="Bold and Italic">Bold and Italic</option>
				</select>
			</td>
		</tr>
			
<!--6. Font - topic/reply text font  ------------------------------------------------------------------->
			
			<tr>
			<?php 
			$name = 'Topic/Reply Text Font' ;
			$name0 = __('Topic/Reply Text Font', 'bbp-style-pack') ;
			$name1 = __('Size', 'bbp-style-pack') ;
			$name2 = __('Color', 'bbp-style-pack') ;
			$name3 = __('Font', 'bbp-style-pack') ;
			$name4 = __('Style', 'bbp-style-pack') ;
			$area1='Size' ;
			$area2='Color' ;
			$area3='Font' ;
			$area4='Style';
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$item2="bsp_style_settings_t[".$name.$area2."]" ;
			$item3="bsp_style_settings_t[".$name.$area3."]" ;
			$item4="bsp_style_settings_t[".$name.$area4."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '') ;
			$value2 = (!empty($bsp_style_settings_t[$name.$area2]) ? $bsp_style_settings_t[$name.$area2]  : '') ;
			$value3 = (!empty($bsp_style_settings_t[$name.$area3]) ? $bsp_style_settings_t[$name.$area3]  : '') ;
			$value4 = (!empty($bsp_style_settings_t[$name.$area4]) ? $bsp_style_settings_t[$name.$area4]  : '') ;
			?>
			<th>
				<?php echo '6. '.$name0 ?>
			</th>
			<td>
				<?php echo $name1 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item1.'" class="large-text" name="'.$item1.'" type="text" value="'.esc_html( $value1 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Default 12px - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name2; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item2.'" class="bsp-color-picker" name="'.$item2.'" type="text" value="'.esc_html( $value2 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Click to set color - You can select from palette or enter hex value - see help for further info', 'bbp-style-pack') ; ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td> 
				<?php echo $name3 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item3.'" class="large-text" name="'.$item3.'" type="text" value="'.esc_html( $value3 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Enter Font eg Arial - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name4 ; ?>
			</td>
			<td>
				<select name="<?php echo $item4 ; ?>">
					<?php echo '<option value="'.esc_html( $value4).'">'.esc_html( $value4 ) ; ?> 
					<option value="Normal">Normal</option>
					<option value="Italic">Italic</option>
					<option value="Bold">Bold</option>
					<option value="Bold and Italic">Bold and Italic</option>
				</select>
			</td>
		</tr>
			
<!--7. Font - Author name ------------------------------------------------------------------->
		<tr>
			<?php 
			$name = 'Author Name Font' ;
			$name0 = __('Author Name Font', 'bbp-style-pack') ;
			$name1 = __('Size', 'bbp-style-pack') ;
			$name3 = __('Font', 'bbp-style-pack') ;
			$name4 = __('Style', 'bbp-style-pack') ;
			$area1='Size' ;
			$area3='Font' ;
			$area4='Style';
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$item3="bsp_style_settings_t[".$name.$area3."]" ;
			$item4="bsp_style_settings_t[".$name.$area4."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '') ;
			$value3 = (!empty($bsp_style_settings_t[$name.$area3]) ? $bsp_style_settings_t[$name.$area3]  : '') ;
			$value4 = (!empty($bsp_style_settings_t[$name.$area4]) ? $bsp_style_settings_t[$name.$area4]  : '') ;
			?>
			<th>
				<?php echo '7. '.$name0 ?>
			</th>
			<td>
				<?php echo $name1 ; ?> 
			</td>
			<td>
				<?php echo '<input id="'.$item1.'" class="large-text" name="'.$item1.'" type="text" value="'.esc_html( $value1 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Default 12px - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name3 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item3.'" class="large-text" name="'.$item3.'" type="text" value="'.esc_html( $value3 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Enter Font eg Arial - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name4 ; ?>
			</td>
			<td>
				<select name="<?php echo $item4 ; ?>">
					<?php echo '<option value="'.esc_html( $value4).'">'.esc_html( $value4 ) ; ?> 
					<option value="Normal">Normal</option>
					<option value="Italic">Italic</option>
					<option value="Bold">Bold</option>
					<option value="Bold and Italic">Bold and Italic</option>
				</select>
			</td>
		</tr>
			
<!--8. Font - Reply Permalink ------------------------------------------------------------------->
		<tr>
			<?php 
			$name = 'Reply Link Font' ;
			$name0 = __('Reply Link Font', 'bbp-style-pack') ;
			$name1 = __('Size', 'bbp-style-pack') ;
			$name3 = __('Font', 'bbp-style-pack') ;
			$name4 = __('Style', 'bbp-style-pack') ;
			$area1='Size' ;
			$area3='Font' ;
			$area4='Style';
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$item3="bsp_style_settings_t[".$name.$area3."]" ;
			$item4="bsp_style_settings_t[".$name.$area4."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '') ;
			$value3 = (!empty($bsp_style_settings_t[$name.$area3]) ? $bsp_style_settings_t[$name.$area3]  : '') ;
			$value4 = (!empty($bsp_style_settings_t[$name.$area4]) ? $bsp_style_settings_t[$name.$area4]  : '') ;
			?>
			<th>
				<?php echo '8. '.$name0 ?>
			</th>
			<td>
				<?php echo $name1 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item1.'" class="large-text" name="'.$item1.'" type="text" value="'.esc_html( $value1 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Default 12px - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name3 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item3.'" class="large-text" name="'.$item3.'" type="text" value="'.esc_html( $value3 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Enter Font eg Arial - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name4 ; ?> 
			</td>
			<td>
				<select name="<?php echo $item4 ; ?>">
					<?php echo '<option value="'.esc_html( $value4).'">'.esc_html( $value4 ) ; ?> 
					<option value="Normal">Normal</option>
					<option value="Italic">Italic</option>
					<option value="Bold">Bold</option>
					<option value="Bold and Italic">Bold and Italic</option>
				</select>
			</td>
		</tr>
			
<!--9. Font - author role ------------------------------------------------------------------->
		<tr>
			<?php 
			$name = 'Author Role' ;
			$name0 = __('Author Role', 'bbp-style-pack') ;
			$name1 = __('Size', 'bbp-style-pack') ;
			$name2 = __('Color', 'bbp-style-pack') ;
			$name3 = __('Font', 'bbp-style-pack') ;
			$name4 = __('Style', 'bbp-style-pack') ;
			$area1='Size' ;
			$area2='Color' ;
			$area3='Font' ;
			$area4='Style';
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$item2="bsp_style_settings_t[".$name.$area2."]" ;
			$item3="bsp_style_settings_t[".$name.$area3."]" ;
			$item4="bsp_style_settings_t[".$name.$area4."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '') ;
			$value2 = (!empty($bsp_style_settings_t[$name.$area2]) ? $bsp_style_settings_t[$name.$area2]  : '') ;
			$value3 = (!empty($bsp_style_settings_t[$name.$area3]) ? $bsp_style_settings_t[$name.$area3]  : '') ;
			$value4 = (!empty($bsp_style_settings_t[$name.$area4]) ? $bsp_style_settings_t[$name.$area4]  : '') ;
			?>
			<th>
				<?php echo '9. '.$name0 ?>
			</th>
			<td colspan=2>
				<?php _e( 'NOTE : You can also style Author roles and it\'s position more fully using the \'Forum Roles\' Tab', 'bbp-style-pack' ); ?>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td> 
				<?php echo $name1 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item1.'" class="large-text" name="'.$item1.'" type="text" value="'.esc_html( $value1 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Default 12px - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name2 ; ?> 
			</td>
			<td>
				<?php echo '<input id="'.$item2.'" class="bsp-color-picker" name="'.$item2.'" type="text" value="'.esc_html( $value2 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Click to set color - You can select from palette or enter hex value - see help for further info', 'bbp-style-pack') ; ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name3 ; ?> 
			</td>
			<td>
				<?php echo '<input id="'.$item3.'" class="large-text" name="'.$item3.'" type="text" value="'.esc_html( $value3 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Enter Font eg Arial - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name4 ; ?>
			</td>
			<td>
				<select name="<?php echo $item4 ; ?>">
					<?php echo '<option value="'.esc_html( $value4).'">'.esc_html( $value4 ) ; ?> 
					<option value="Normal">Normal</option>
					<option value="Italic">Italic</option>
					<option value="Bold">Bold</option>
					<option value="Bold and Italic">Bold and Italic</option>
				</select>
			</td>
		</tr>
			
<!--10. topic header - author and posts ------------------------------------------------------------------->
		<tr>
			<?php 
			$name = 'Topic Header' ;
			$name0 = __('Topic Header', 'bbp-style-pack') ;
			$name1 = __('Size', 'bbp-style-pack') ;
			$name2 = __('Color', 'bbp-style-pack') ;
			$name3 = __('Font', 'bbp-style-pack') ;
			$name4 = __('Style', 'bbp-style-pack') ;
			$area1='Size' ;
			$area2='Color' ;
			$area3='Font' ;
			$area4='Style';
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$item2="bsp_style_settings_t[".$name.$area2."]" ;
			$item3="bsp_style_settings_t[".$name.$area3."]" ;
			$item4="bsp_style_settings_t[".$name.$area4."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '') ;
			$value2 = (!empty($bsp_style_settings_t[$name.$area2]) ? $bsp_style_settings_t[$name.$area2]  : '') ;
			$value3 = (!empty($bsp_style_settings_t[$name.$area3]) ? $bsp_style_settings_t[$name.$area3]  : '') ;
			$value4 = (!empty($bsp_style_settings_t[$name.$area4]) ? $bsp_style_settings_t[$name.$area4]  : '') ;
			?>
			<th>
				<?php echo '10. '.$name0 ?>
			</th>
			<td> 
				<?php echo $name1 ; ?> 
			</td>
			<td>
				<?php echo '<input id="'.$item1.'" class="large-text" name="'.$item1.'" type="text" value="'.esc_html( $value1 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Default 12px - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name2 ; ?> 
			</td>
			<td>
				<?php echo '<input id="'.$item2.'" class="bsp-color-picker" name="'.$item2.'" type="text" value="'.esc_html( $value2 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Click to set color - You can select from palette or enter hex value - see help for further info', 'bbp-style-pack') ; ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name3 ; ?> 
			</td>
			<td>
				<?php echo '<input id="'.$item3.'" class="large-text" name="'.$item3.'" type="text" value="'.esc_html( $value3).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Enter Font eg Arial - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name4 ; ?>
			</td>
			<td>
				<select name="<?php echo $item4 ; ?>">
					<?php echo '<option value="'.esc_html( $value4).'">'.esc_html( $value4 ) ; ?> 
					<option value="Normal">Normal</option>
					<option value="Italic">Italic</option>
					<option value="Bold">Bold</option>
					<option value="Bold and Italic">Bold and Italic</option>
				</select>
			</td>
		</tr>
		
<!--11. topic admin links ------------------------------------------------------------------->
		<tr>
			<?php 
			$name = 'Topic Admin links' ;
			$name0 = __('Topic Admin links', 'bbp-style-pack') ;
			$name1 = __('Size', 'bbp-style-pack') ;
			$name2 = __('Color', 'bbp-style-pack') ;
			$name3 = __('Font', 'bbp-style-pack') ;
			$name4 = __('Style', 'bbp-style-pack') ;
			$area1='Size' ;
			$area2='Color' ;
			$area3='Font' ;
			$area4='Style';
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$item2="bsp_style_settings_t[".$name.$area2."]" ;
			$item3="bsp_style_settings_t[".$name.$area3."]" ;
			$item4="bsp_style_settings_t[".$name.$area4."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '') ;
			$value2 = (!empty($bsp_style_settings_t[$name.$area2]) ? $bsp_style_settings_t[$name.$area2]  : '') ;
			$value3 = (!empty($bsp_style_settings_t[$name.$area3]) ? $bsp_style_settings_t[$name.$area3]  : '') ;
			$value4 = (!empty($bsp_style_settings_t[$name.$area4]) ? $bsp_style_settings_t[$name.$area4]  : '') ;
			?>
			<th>
				<?php echo '11. '.$name0 ?>
			</th>
			<td> 
				<?php echo $name1 ; ?> 
			</td>
			<td>
				<?php echo '<input id="'.$item1.'" class="large-text" name="'.$item1.'" type="text" value="'.esc_html( $value1 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Default 12px - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name2 ; ?> 
			</td>
			<td>
				<?php echo '<input id="'.$item2.'" class="bsp-color-picker" name="'.$item2.'" type="text" value="'.esc_html( $value2 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Click to set color - You can select from palette or enter hex value - see help for further info', 'bbp-style-pack') ; ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td> 
				<?php echo $name3 ; ?> 
			</td>
			<td>
				<?php echo '<input id="'.$item3.'" class="large-text" name="'.$item3.'" type="text" value="'.esc_html( $value3).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Enter Font eg Arial - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name4 ; ?>
			</td>
			<td>
				<select name="<?php echo $item4 ; ?>">
					<?php echo '<option value="'.esc_html( $value4).'">'.esc_html( $value4 ) ; ?> 
					<option value="Normal">Normal</option>
					<option value="Italic">Italic</option>
					<option value="Bold">Bold</option>
					<option value="Bold and Italic">Bold and Italic</option>
				</select>
			</td>
		</tr>
<!--12. Revisions ------------------------------------------------------------------->		
		<tr>
			<?php
			$name = 'Revisions' ;
			$name0 = __('Revisions', 'bbp-style-pack') ;
			$area1='revisions' ;
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : 'all') ;
			?>
			<th>
				<?php echo '12. '.$name0 ?>
			</th>
			<td colspan = 2>
				<?php echo '<input id="'.$item1.'" class="small-text" name="'.$item1.'" type="text" value="'.esc_html( $value1 ).'"<p>' ; ?> 
				<label class="description">
					<?php _e( 'Type "all" to show all revisions, "none" to hide all revisions, or a number to show the last n revisions eg "1" to just show the last revision.', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>

<!--13. @mentions ------------------------------------------------------------------->
		<tr>
			<?php 
			$name = 'mentions' ;
			$name0 = __('@Mentions', 'bbp-style-pack') ;
			$name1 = __('Size', 'bbp-style-pack') ;
			$name2 = __('Color', 'bbp-style-pack') ;
			$name3 = __('Font', 'bbp-style-pack') ;
			$name4 = __('Style', 'bbp-style-pack') ;
			$area1='Size' ;
			$area2='Color' ;
			$area3='Font' ;
			$area4='Style';
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$item2="bsp_style_settings_t[".$name.$area2."]" ;
			$item3="bsp_style_settings_t[".$name.$area3."]" ;
			$item4="bsp_style_settings_t[".$name.$area4."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '') ;
			$value2 = (!empty($bsp_style_settings_t[$name.$area2]) ? $bsp_style_settings_t[$name.$area2]  : '') ;
			$value3 = (!empty($bsp_style_settings_t[$name.$area3]) ? $bsp_style_settings_t[$name.$area3]  : '') ;
			$value4 = (!empty($bsp_style_settings_t[$name.$area4]) ? $bsp_style_settings_t[$name.$area4]  : '') ;
			?>
			<th>
			<?php echo '13. '.$name0 ?>
			</th>
			<!-- checkbox to activate  -->
			<td>
				<?php _e('Activate @mentions Description', 'bbp-private-groups'); ?>
			</td>
			<td>
				<?php 
				$item = (!empty( $bsp_style_settings_t['mentionsactivate'] ) ?  $bsp_style_settings_t['mentionsactivate'] : '');
				echo '<input name="bsp_style_settings_t[mentionsactivate]" id="bsp_style_settings_t[mentionsactivate]" type="checkbox" value="1" class="code" ' . checked( 1,$item, false ) . ' />' ; ?>
			</td>
		</tr>
		
		<tr valign="top">
			<td colspan=3>
				<label class="description" for="bsp_settings_t[mentionsactivate]">
					<?php _e( 'NOTES ', 'bbp-style-pack' ); ?>
					<br/>
					<?php _e( '1. This ONLY adds the @mention description shown above for the user.  @mentions is available with Buddypress or by using the <a href = "https://wordpress.org/plugins/bbp-mentions-email-notifications/" target="_blank"> bbp-mentions-email-notifications</a> plugin, and either will need to be activated for this to be useful !', 'bbp-style-pack' ); ?>
					<br/>
					<?php _e( '2. This will show the user\'s \'nicename\' which may be different from the display name shown above it. Users can amend their display names in their profile settings or the admin may decide this. Whilst for most sites this is not an issue, you will want to consider whether showing their nicename which is formed from their login name may compromise privacy or reveal information. ', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr valign="top">
			<td>
			</td>
			<td><?php _e('Priority', 'bbp-style-pack'); ?>
			</td>
			<td>
				<?php 
				$item_priority = (!empty ($bsp_style_settings_t['mentions_priority'] ) ? $bsp_style_settings_t['mentions_priority']  : '' ) ?>
				<input id="bsp_style_settings_t[mentions_priority]" class="small-text" name="bsp_style_settings_t[mentions_priority]" type="text" value="<?php echo esc_html( $item_priority ) ;?>" /><br/>
					<label class="description" for="bsp_settings_t[mentions_priority]">
						<?php _e( 'Default : 10  Leave blank unless you want to alter. Explanation: If you have multiple items displaying under the author from say other plugins, then you can use this to change the display order - lower numbers equal higher priority', 'bbp-style-pack' ); ?>
						</label>
						<br/>
			</td>
		</tr>
			
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name1 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item1.'" class="large-text" name="'.$item1.'" type="text" value="'.esc_html( $value1 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Default 12px - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td> 
				<?php echo $name2 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item2.'" class="bsp-color-picker" name="'.$item2.'" type="text" value="'.esc_html( $value2 ).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Click to set color - You can select from palette or enter hex value - see help for further info', 'bbp-style-pack') ; ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td> 
				<?php echo $name3 ; ?>
			</td>
			<td>
				<?php echo '<input id="'.$item3.'" class="large-text" name="'.$item3.'" type="text" value="'.esc_html( $value3).'"<br>' ; ?> 
				<label class="description">
					<?php _e( 'Enter Font eg Arial - see help for further info', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
		<tr>
			<td>
			</td>
			<td>
				<?php echo $name4 ; ?> 
			</td>
			<td>
				<select name="<?php echo $item4 ; ?>">
					<?php echo '<option value="'.esc_html( $value4).'">'.esc_html( $value4 ) ; ?> 
					<option value="Normal">Normal</option>
					<option value="Italic">Italic</option>
					<option value="Bold">Bold</option>
					<option value="Bold and Italic">Bold and Italic</option>
				</select>
			</td>
		</tr>
		
<!--14. anon emails ------------------------------------------------------------------->	
		<tr>
			<?php 
			$name = 'anon_email' ;
			$name0 = __('Show emails for anonymous users', 'bbp-style-pack') ;
			$area1='Show' ;
			$item1="bsp_style_settings_t[".$name.$area1."]" ;
			$value1 = (!empty($bsp_style_settings_t[$name.$area1]) ? $bsp_style_settings_t[$name.$area1]  : '') ;
			?>
			<th>
			<?php echo '14. '.$name0 ?>
			</th>
			<!-- checkbox to activate  -->
			<td>
				<?php _e('Show Anonymous Email addresses', 'bbp-private-groups'); ?>
			</td>
			<td>
				<?php 
				$item = (!empty( $bsp_style_settings_t['anon_emailShow'] ) ?  $bsp_style_settings_t['anon_emailShow'] : 0);
				echo '<input name="bsp_style_settings_t[anon_emailShow]" id="bsp_style_settings_t[anon_emailShow]" type="checkbox" value="1" class="code" ' . checked( 1,$item, false ) . ' />' ; ?>
				<label class="description">
					<?php _e( 'If you allow unregistered users to post, this will show the email address they entered in the topic/reply form to KEYMASTERS only ', 'bbp-style-pack' ); ?>
				</label>
				<br/>
			</td>
		</tr>
		
	</table>
					
<!-- save the options -->
	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e( 'Save changes', 'bsp_style_settings_t' ); ?>" />
	</p>
</form>
</div><!--end sf-wrap-->
</div><!--end wrap-->
	
<?php
}
		

	
