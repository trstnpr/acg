<?php
/*
Plugin Name: Custom Fields Search by BestWebSoft
Plugin URI: https://bestwebsoft.com/products/wordpress/plugins/custom-fields-search/
Description: Add custom fields to WordPress website search results.
Author: BestWebSoft
Text Domain: custom-fields-search
Domain Path: /languages
Version: 1.3.4
Author URI: https://bestwebsoft.com/
License: GPLv2 or later
*/

/*  © Copyright 2017  BestWebSoft  ( https://support.bestwebsoft.com )

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

/* Add BWS menu */
if ( ! function_exists( 'cstmfldssrch_add_admin_menu' ) ) {
	function cstmfldssrch_add_admin_menu() {
		$settings = add_menu_page(
			__( 'Custom Fields Search Settings', 'custom-fields-search' ),
			'Custom Fields Search',
			'manage_options',
			'custom-fields-search.php',
			'cstmfldssrch_page_of_settings',
			'none'
		 );
		add_submenu_page(
			'custom-fields-search.php',
			__( 'Custom Fields Search Settings','custom-fields-search' ),
			__( 'Settings', 'custom-fields-search' ),
			'manage_options',
			'custom-fields-search.php',
			'cstmfldssrch_page_of_settings'
		);

		add_submenu_page(
			'custom-fields-search.php',
			'BWS Panel',
			'BWS Panel',
			'manage_options',
			'cstmfldssrch-bws-panel',
			'bws_add_menu_render'
		);

		add_action( 'load-' . $settings, 'cstmfldssrch_add_tabs' );
	}
}

/**
 * Internationalization
 */
if ( ! function_exists( 'cstmfldssrch_plugins_loaded' ) ) {
	function cstmfldssrch_plugins_loaded() {
		load_plugin_textdomain( 'custom-fields-search', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

if ( ! function_exists( 'cstmfldssrch_init' ) ) {
	function cstmfldssrch_init() {
		global $cstmfldssrch_plugin_info;

		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );

		if ( empty( $cstmfldssrch_plugin_info ) ) {
			if ( ! function_exists( 'get_plugin_data' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$cstmfldssrch_plugin_info = get_plugin_data( __FILE__ );
		}

		/* Function check if plugin is compatible with current WP version */
		bws_wp_min_version_check( plugin_basename( __FILE__ ), $cstmfldssrch_plugin_info, '3.9' );

		/* Call register settings function */
		if ( ! is_admin() || ( isset( $_GET['page'] ) && "custom-fields-search.php" == $_GET['page'] ) )
			cstmfldssrch_register_options();
	}
}

if ( ! function_exists( 'cstmfldssrch_plugin_activate' ) ) {
	function cstmfldssrch_plugin_activate() {
		/* registering uninstall hook */
		if ( is_multisite() ) {
			switch_to_blog( 1 );
			register_uninstall_hook( __FILE__, 'cstmfldssrch_delete_options' );
			restore_current_blog();
		} else {
			register_uninstall_hook( __FILE__, 'cstmfldssrch_delete_options' );
		}
		cstmfldssrch_register_options();
	}
}

/* add help tab */
if ( ! function_exists( 'cstmfldssrch_add_tabs' ) ) {
	function cstmfldssrch_add_tabs() {
		$screen = get_current_screen();
		$args = array(
			'id' 			=> 'cstmfldssrch',
			'section' 		=> '200538819'
		);
		bws_help_tab( $screen, $args );
	}
}

if ( ! function_exists( 'cstmfldssrch_admin_init' ) ) {
	function cstmfldssrch_admin_init() {
		global $bws_plugin_info, $cstmfldssrch_plugin_info;

		if ( empty( $bws_plugin_info ) )
			$bws_plugin_info = array( 'id' => '85', 'version' => $cstmfldssrch_plugin_info["Version"] );
	}
}

if ( ! function_exists( 'cstmfldssrch_get_options_default' ) ) {
	function cstmfldssrch_get_options_default() {
		global $cstmfldssrch_plugin_info;

		$default_options = array(
			'plugin_option_version'		=> $cstmfldssrch_plugin_info["Version"],
			'fields' 					=> array(),
			'show_hidden_fields'		=> 0,
			'display_settings_notice'	=> 1,
			'suggest_feature_banner'	=> 1
		);

		return $default_options;
	}
}

/* Function create column in table wp_options for option of this plugin. If this column exists - save value in variable. */
if ( ! function_exists( 'cstmfldssrch_register_options' ) ) {
	function cstmfldssrch_register_options() {
		global $cstmfldssrch_options, $cstmfldssrch_plugin_info;

		$cstmfldssrch_options_defaults = cstmfldssrch_get_options_default();

		if ( ! get_option( 'cstmfldssrch_options' ) )
			add_option( 'cstmfldssrch_options', $cstmfldssrch_options_defaults );

		$cstmfldssrch_options = get_option( 'cstmfldssrch_options' );

		/* Array merge incase this version has added new options */
		if ( ! isset( $cstmfldssrch_options['plugin_option_version'] ) || $cstmfldssrch_options['plugin_option_version'] != $cstmfldssrch_plugin_info["Version"] ) {
			if ( ! isset( $cstmfldssrch_options['fields'] ) ) {
				$cstmfldssrch_options_array = $cstmfldssrch_options;
				unset( $cstmfldssrch_options_array['plugin_option_version'] );
				$cstmfldssrch_options = array( 'fields' => $cstmfldssrch_options_array );
			}
			$cstmfldssrch_options_defaults['display_settings_notice'] = 0;
			$cstmfldssrch_options = array_merge( $cstmfldssrch_options_defaults, $cstmfldssrch_options );
			$cstmfldssrch_options['plugin_option_version'] = $cstmfldssrch_plugin_info["Version"];
			update_option( 'cstmfldssrch_options', $cstmfldssrch_options );
		}
	}
}

/* Function are using to register script and styles for plugin settings page */
if ( ! function_exists ( 'cstmfldssrch_admin_enqueue_scripts' ) ) {
	function cstmfldssrch_admin_enqueue_scripts() {
		wp_enqueue_style( 'cstmfldssrch_icon', plugins_url( 'css/icon.css', __FILE__ ) );
		if ( isset( $_GET['page'] ) && "custom-fields-search.php" == $_GET['page'] ) {
			bws_enqueue_settings_scripts();
			bws_plugins_include_codemirror();
			wp_enqueue_style( 'cstmfldssrch_style', plugins_url( 'css/style.css', __FILE__ ) );
			wp_enqueue_script( 'cstmfldssrch_script', plugins_url( 'js/script.js' , __FILE__ ) );
		}
	}
}

/* Function exclude records that contain duplicate data in selected fields */
if ( ! function_exists( 'cstmfldssrch_distinct' ) ) {
	function cstmfldssrch_distinct( $distinct ) {
		global $wp_query, $cstmfldssrch_options;
		if ( ! empty( $wp_query->query_vars['s'] ) && ! empty( $cstmfldssrch_options['fields'] ) && is_search() ) {
			$distinct .= "DISTINCT";
		}
		return $distinct;
	}
}

/* Function join table `wp_posts` with `wp_postmeta` */
if ( ! function_exists( 'cstmfldssrch_join' ) ) {
	function cstmfldssrch_join( $join ) {
		global $wp_query, $wpdb, $cstmfldssrch_options;
		if ( ! empty( $wp_query->query_vars['s'] ) && ! empty( $cstmfldssrch_options['fields'] ) && is_search() ) {
			$join .= "JOIN " . $wpdb->postmeta . " ON " . $wpdb->posts . ".ID = " . $wpdb->postmeta . ".post_id ";
		}
		return $join;
	}
}

/* Function adds in request keyword search on custom fields, and list of meta_key, which user has selected */
if( ! function_exists( 'cstmfldssrch_request' ) ) {
	function cstmfldssrch_request( $where ) {
		global $wp_query, $wpdb, $cstmfldssrch_options;
		if ( method_exists($wpdb,'remove_placeholder_escape') ) {
			$where = $wpdb->remove_placeholder_escape( $where );
		}
		$pos = strrpos( $where, '%' );
		if ( false !== $pos && ! empty( $wp_query->query_vars['s'] ) && ! empty( $cstmfldssrch_options['fields'] ) && is_search() ) {
			$end_pos_where = 5 + $pos; /* find position of the end of the request with check the type and status of the post */
			$end_of_where_request = substr( $where, $end_pos_where ); /* save check the type and status of the post in variable */
			/* Exclude for gallery and gallery pro from search - dont show attachment with keywords */
			$flag_gllr_image = array();
			if ( in_array( 'gllr_image_text', $cstmfldssrch_options['fields'] ) || in_array( 'gllr_image_alt_tag', $cstmfldssrch_options['fields'] ) ||
				in_array( 'gllr_link_url', $cstmfldssrch_options['fields'] ) || in_array( 'gllr_image_description', $cstmfldssrch_options['fields'] ) ||
				in_array( 'gllr_lightbox_button_url', $cstmfldssrch_options['fields'] ) ) {
				foreach ( $cstmfldssrch_options['fields'] as $key => $value ) {
					if ( 'gllr_image_text' == $value || 'gllr_link_url' == $value || 'gllr_image_alt_tag' == $value ||
					 'gllr_lightbox_button_url' == $value || 'gllr_image_description' == $value ) {
						unset( $cstmfldssrch_options['fields'][ $key ] );
						$flag_gllr_image[] = $value;
					}
				}
			}

			$user_request = esc_sql( trim( $wp_query->query_vars['s'] ) );
			$user_request_arr = preg_split( "/[\s,]+/", $user_request ); /* The user's regular expressions are used to separate array for the desired keywords */

			if ( ! empty( $cstmfldssrch_options['fields'] ) ) {
				$cusfields_sql_request = "'" . implode( "', '", $cstmfldssrch_options['fields'] ) . "'"; /* forming a string with the list of meta_key, which user has selected */
				$where .= " OR (" . $wpdb->postmeta . ".meta_key IN (" . $cusfields_sql_request . ") "; /* Modify the request */
				foreach ( $user_request_arr as $value ) {
					$where .= "AND " . $wpdb->postmeta . ".meta_value LIKE '%" . $value . "%' ";
				}
				$where .= $end_of_where_request . ") ";
			}

			/* This code special for gallery plugin */
			if ( ! empty( $flag_gllr_image ) ) {
				foreach ( $flag_gllr_image as $flag_gllr_image_key => $flag_gllr_image_value ) {

					$where_new_end = '';
					/* save search keywords */
					foreach ( $user_request_arr as $value ) {
						$where_new_end .= "AND " . $wpdb->postmeta . ".meta_value LIKE '%" . $value . "%' ";
					}
					/* search posts-attachments */
					$id_attachment_arr = $wpdb->get_col( "SELECT " . $wpdb->posts . ".id FROM " . $wpdb->postmeta . " JOIN " . $wpdb->posts . " ON " . $wpdb->posts . ".id = " . $wpdb->postmeta . ".post_id WHERE " . $wpdb->postmeta . ".meta_key = '" . $flag_gllr_image_value . "' " . $where_new_end );
					/* if posts-attachments exists - search gallery post ID */
					if ( ! empty( $id_attachment_arr ) ) {
						$array_id_gallery = array();
						foreach ( $id_attachment_arr as $value ) {
							$id_gallery = $wpdb->get_col( "SELECT DISTINCT(" . $wpdb->posts . ".post_parent) FROM " . $wpdb->posts . " WHERE " . $wpdb->posts . ".ID = " . $value );
							if ( ! in_array( $id_gallery[0],$array_id_gallery ) ) {
								$array_id_gallery[] = $id_gallery[0];
							}
						}
					}
					/* if gallery post ID exists - show on page */
					if ( ! empty( $array_id_gallery ) ) {
						foreach ( $array_id_gallery as $value ) {
							$where .= " OR " . $wpdb->posts . ".ID = " . $value;
						}
					}
				}
			}
		}
		return $where;
	}
}

/* Function is forming page of the settings of this plugin */
if ( ! function_exists( 'cstmfldssrch_page_of_settings' ) ) {
	function cstmfldssrch_page_of_settings() {
		global $wpdb, $cstmfldssrch_options, $cstmfldssrch_plugin_info;
		require_once( dirname( __FILE__ ) . '/includes/class-cstmfldssrch-settings.php' );
		$page = new Cstmfldssrch_Settings_Tabs( plugin_basename( __FILE__ ) ); ?>
		<div class="wrap">
			<h1 class="cstmfldssrch-title"><?php _e( 'Custom Fields Search Settings', 'custom-fields-search' ); ?></h1>
			<?php $page->display_content(); ?>
		</div>
	<?php }
}

/* Function are using to create action-link 'settings' on admin page. */
if ( ! function_exists( 'cstmfldssrch_action_links' ) ) {
	function cstmfldssrch_action_links( $links, $file ) {
		if ( ! is_network_admin() ) {
			$base = plugin_basename( __FILE__ );
			if ( $file == $base ) {
				$settings_link = '<a href="admin.php?page=custom-fields-search.php">' . __( 'Settings', 'custom-fields-search' ) . '</a>';
				array_unshift( $links, $settings_link );
			}
		}
		return $links;
	}
}

/* Function are using to create link 'settings' on admin page. */
if ( ! function_exists ( 'cstmfldssrch_links' ) ) {
	function cstmfldssrch_links( $links, $file ) {
		$base = plugin_basename( __FILE__ );
		if ( $file == $base ) {
			if ( ! is_network_admin() ) {
				$links[] = '<a href="admin.php?page=custom-fields-search.php">' . __( 'Settings', 'custom-fields-search' ) . '</a>';
			}
			$links[] = '<a href="https://support.bestwebsoft.com/hc/en-us/sections/200538819">' . __( 'FAQ', 'custom-fields-search' ) . '</a>';
			$links[] = '<a href="https://support.bestwebsoft.com">' . __( 'Support', 'custom-fields-search' ) . '</a>';
		}
		return $links;
	}
}

/* add admin notices */
if ( ! function_exists ( 'cstmfldssrch_admin_notices' ) ) {
	function cstmfldssrch_admin_notices() {
		global $hook_suffix, $cstmfldssrch_plugin_info;
		if ( 'plugins.php' == $hook_suffix && ! is_network_admin() ) {
			bws_plugin_banner_to_settings( $cstmfldssrch_plugin_info, 'cstmfldssrch_options', 'custom-fields-search', 'admin.php?page=custom-fields-search.php' );
		}
		if ( isset( $_GET['page'] ) && 'custom-fields-search.php' == $_GET['page'] ) {
			bws_plugin_suggest_feature_banner( $cstmfldssrch_plugin_info, 'cstmfldssrch_options', 'custom-fields-search' );
		}
	}
}

/* Function for delete options from table `wp_options` */
if ( ! function_exists( 'cstmfldssrch_delete_options' ) ) {
	function cstmfldssrch_delete_options() {
		global $wpdb;
		/* Delete options */
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {
			$old_blog = $wpdb->blogid;
			/* Get all blog ids */
			$blogids = $wpdb->get_col( "SELECT `blog_id` FROM $wpdb->blogs" );
			foreach ( $blogids as $blog_id ) {
				switch_to_blog( $blog_id );
				delete_option( 'cstmfldssrch_options' );
			}
			switch_to_blog( $old_blog );
		} else {
			delete_option( 'cstmfldssrch_options' );
		}

		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );
		bws_delete_plugin( plugin_basename( __FILE__ ) );
	}
}

register_activation_hook( __FILE__, 'cstmfldssrch_plugin_activate' );
/* Calling a function add administrative menu. */
add_action( 'admin_menu', 'cstmfldssrch_add_admin_menu' );
add_action( 'plugins_loaded', 'cstmfldssrch_plugins_loaded' );
add_action( 'init', 'cstmfldssrch_init' );
add_action( 'admin_init', 'cstmfldssrch_admin_init' );

add_action( 'admin_enqueue_scripts', 'cstmfldssrch_admin_enqueue_scripts' );
/* add admin notices */
add_action( 'admin_notices', 'cstmfldssrch_admin_notices' );

add_filter( 'posts_distinct', 'cstmfldssrch_distinct' );
add_filter( 'posts_join', 'cstmfldssrch_join' );
add_filter( 'posts_where', 'cstmfldssrch_request' );
add_filter( 'plugin_action_links', 'cstmfldssrch_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'cstmfldssrch_links', 10, 2 );