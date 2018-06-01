<?php
/**
 * Displays the content on the plugin settings page
 */

require_once( dirname( dirname( __FILE__ ) ) . '/bws_menu/class-bws-settings.php' );

if ( ! class_exists( 'Cstmfldssrch_Settings_Tabs' ) ) {
	class Cstmfldssrch_Settings_Tabs extends Bws_Settings_Tabs {
		public $post_types, $upload_dir;

		/**
		 * Constructor.
		 *
		 * @access public
		 *
		 * @see Bws_Settings_Tabs::__construct() for more information on default arguments.
		 *
		 * @param string $plugin_basename
		 */
		public function __construct( $plugin_basename ) {
			global $cstmfldssrch_options, $cstmfldssrch_plugin_info;

			$tabs = array(
				'settings'		=> array( 'label' => __( 'Settings', 'custom-fields-search' ) ),
				'misc'			=> array( 'label' => __( 'Misc', 'custom-fields-search' ) )
			);

			parent::__construct( array(
				'plugin_basename'		=> $plugin_basename,
				'plugins_info'			=> $cstmfldssrch_plugin_info,
				'prefix'				=> 'cstmfldssrch',
				'default_options'		=> cstmfldssrch_get_options_default(),
				'options'				=> $cstmfldssrch_options,
				'is_network_options'	=> is_network_admin(),
				'tabs'					=> $tabs,
				'wp_slug'				=> 'custom-css'
			) );

			add_action( get_parent_class( $this ) . '_display_custom_messages', array( $this, 'display_custom_messages' ) );
		}

		/**
		 * Display custom error\message\notice
		 * @access public
		 * @param $save_results - array with error\message\notice
		 * @return void
		 */
		public function display_custom_messages( $save_results ) {
			$php_version_is_proper = version_compare( PHP_VERSION, '5.3.0', '<' );
			$message = $error = ''; ?>
			<?php if ( $php_version_is_proper ) { ?>
				<div class="error below-h2"><p><strong><?php printf( __( "Custom Fields Search plugin requires PHP %s or higher. Please contact your hosting provider to upgrade PHP version.", 'custom-fields-search' ), '5.3.0' ); ?></strong></p></div>
			<?php } ?>

			<div class="updated below-h2" <?php if ( empty( $message ) || "" != $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
			<div class="error below-h2" <?php if ( "" == $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>
		<?php }

		/**
		 * Save plugin options to the database
		 * @access public
		 * @param  void
		 * @return array    The action results
		 */
		public function save_options() {
			global $cstmfldssrch_plugin_info;
			$this->options['fields'] = isset( $_REQUEST['cstmfldssrch_fields_array'] ) ? $_REQUEST['cstmfldssrch_fields_array'] : array();
			$this->options['plugin_option_version'] = $cstmfldssrch_plugin_info["Version"];
			$this->options['show_hidden_fields'] = isset( $_REQUEST['cstmfldssrch_show_hidden_fields'] ) ? 1 : 0;

			update_option( 'cstmfldssrch_options', $this->options );

			$message = __( "Settings saved" , 'custom-fields-search' );

			return compact( 'message', 'notice', 'error' );
		}

		public function tab_settings() {
			global $wpdb;
			$install_plugins = get_plugins();?>
			<h3 class="bws_tab_label"><?php _e( 'Settings', 'custom-fields-search' ); ?></h3>
			<?php $this->help_phrase(); ?>
			<hr>
			<?php if ( empty( $this->options['show_hidden_fields'] ) ) {
				$meta_key_custom_posts	=	$wpdb->get_col( "SELECT DISTINCT(meta_key) FROM " . $wpdb->postmeta . " JOIN " . $wpdb->posts . " ON " . $wpdb->posts . ".id = " . $wpdb->postmeta . ".post_id WHERE " . $wpdb->posts . ".post_type NOT IN ('revision', 'page', 'post', 'attachment', 'nav_menu_item') AND meta_key NOT LIKE '\_%'" );
				$meta_key_result		=	$wpdb->get_col( "SELECT DISTINCT(meta_key) FROM " . $wpdb->postmeta . " WHERE `meta_key` NOT LIKE '\_%'" );
				/* select all user's meta_key from table `wp_postmeta` */
			} else {
				$meta_key_custom_posts	=	$wpdb->get_col( "SELECT DISTINCT(meta_key) FROM " . $wpdb->postmeta . " JOIN " . $wpdb->posts . " ON " . $wpdb->posts . ".id = " . $wpdb->postmeta . ".post_id WHERE " . $wpdb->posts . ".post_type NOT IN ('revision', 'page', 'post', 'attachment', 'nav_menu_item')" );
				$meta_key_result		=	$wpdb->get_col( "SELECT DISTINCT(meta_key) FROM " . $wpdb->postmeta );
				/* select all meta_key from table `wp_postmeta` */
			} ?>
			<div class="wrap">
				<table class="form-table cstmfldssrch-form-table">
					<tr valign="top">
						<?php if ( 0 < count( $meta_key_result ) ) { ?>
							<th scope="row"><?php _e( 'Enable search for the custom field:', 'custom-fields-search' ); ?></th>
							<?php if ( is_plugin_active( 'custom-search-pro/custom-search-pro.php' ) || is_plugin_active( 'custom-search-plugin/custom-search-plugin.php' ) ) { ?>
								<td>
									<div id="cstmfldssrch_div_select_all" style="display:none;"><label ><input id="cstmfldssrch_select_all" type="checkbox" /><span style="text-transform: capitalize; padding-left: 5px;"><strong><?php _e( 'All', 'custom-fields-search' ); ?></strong></span></label></div>
									<?php foreach ( $meta_key_result as $value ) { ?>
										<label><input type="checkbox" <?php if ( in_array( $value, $this->options['fields'] ) ) echo 'checked="checked"'; ?> name="cstmfldssrch_fields_array[]" value="<?php echo $value; ?>" /><span class="cstmfldssrch_value_of_metakey"><?php echo $value; ?></span></label><br />
									<?php } ?>
								</td>
							<?php } else {
								$i = 1; ?>
								<td>
									<fieldset>
										<div id="cstmfldssrch_div_select_all" style="display:none;"><label ><input id="cstmfldssrch_select_all" type="checkbox" /><span style="text-transform: capitalize; padding-left: 5px;"><strong><?php _e( 'All', 'custom-fields-search' ); ?></strong></span></label></div>
										<?php foreach ( $meta_key_result as $value ) {
											if ( false !== in_array( $value, $meta_key_custom_posts ) ) {
												$list_custom_key[ $i ] = $value;
												$i++;
											} else { ?>
												<label><input type="checkbox" <?php if ( in_array( $value, $this->options['fields'] ) ) echo 'checked="checked"'; ?> name="cstmfldssrch_fields_array[]" value="<?php echo $value; ?>" /><span class="cstmfldssrch_value_of_metakey"><?php echo $value; ?></span></label><br />
											<?php }
										}
										echo "<br />";
										if ( isset( $list_custom_key ) ) {
											foreach ( $list_custom_key as $value ) {
												$post_type_of_mkey = $wpdb->get_col( "SELECT DISTINCT(post_type) FROM " . $wpdb->posts . " JOIN " . $wpdb->postmeta . " ON " . $wpdb->posts . ".id = " . $wpdb->postmeta . ".post_id WHERE " . $wpdb->postmeta . ".meta_key LIKE ('" . $value . "')" ); ?>
												<label><input type="checkbox" disabled="disabled" name="cstmfldssrch_fields_array[]" value="<?php echo $value; ?>" />
												<span class="cstmfldssrch_disable_key">
													<?php echo $value . " (" . $post_type_of_mkey[0] . " " . __( 'custom post type', 'custom-fields-search' ); ?>)
												</span></label><br />
											<?php }
											if ( array_key_exists( 'custom-search-pro/custom-search-pro.php', $install_plugins ) || array_key_exists( 'custom-search-plugin/custom-search-plugin.php', $install_plugins ) ) { ?>
												<span class="bws_info"><?php _e( 'You need to', 'custom-fields-search' ); ?> <a href="<?php echo bloginfo("url"); ?>/wp-admin/plugins.php"><?php _e( 'activate plugin', 'custom-fields-search' ); ?> Custom Search</a></span>
											<?php } else { ?>
												<span class="bws_info"><?php _e( 'If the type of the post is not default - you need to install and activate the plugin', 'custom-fields-search' ); ?> <a href="https://bestwebsoft.com/products/wordpress/plugins/custom-search/">Custom Search</a>.</span>
											<?php }
										} ?>
									</fieldset>
								</td>
							<?php }
						} else { ?>
							<th scope="row" colspan="2"><?php _e( 'Custom fields not found.', 'custom-fields-search' ); ?></th><td></td>
						<?php } ?>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e( 'Show hidden fields', 'custom-fields-search' ); ?></th>
						<td>
							<input type="checkbox" <?php checked( $this->options['show_hidden_fields'] ); ?> name="cstmfldssrch_show_hidden_fields" value="1" />
						</td>
					</tr>
				</table>
			</div>
		<?php }
	}
}