<?php
/**
 * Pods Front End is the WordPress plugin for editing and list posts.
 *
 * @package Pods Front End 
 * @author firewolf
 * @copyright 2019 firewolf, LLC. All rights reserved.
 *
 *            @wordpress-plugin
 *            Plugin Name: Pods Front End 
 *            Plugin URI: 
 *            Description: Pods Front End is the WordPress plugin for editing and list posts.
 *            Version: 1.0.1
 *            Author: firewolf
 *            Author URI: 
 *            Text Domain: pods-front-end
 *            Contributors: firewolf
 */

define( 'PODS_FRONT_END_DIR', plugin_dir_path( __FILE__ ) );
 
/**
 * Adding Submenu under Settings Tab
 *
 * @since 1.0.1
 */
function pods_front_end_add_menu() {
	add_submenu_page ( "options-general.php", "Pods Front End", "Pods Front End", "manage_options", "pods-front-end", "pods_front_end_page" );
}
add_action ( "admin_menu", "pods_front_end_add_menu" );
 

/**
 * View All Shortcode List Page
 *
 * @since 1.0.1
 */

require_once( PODS_FRONT_END_DIR . 'page/admin-view.php' );

function pods_front_end_page() {
	?>
	<div class="wrap">
		<h1>Pods Front End Plugin</h1>
	</div> 
	<?php
		admin_shortcode_list_view();

		$service_id = get_pod_detail('service')['id'];
	?>
		<style type="text/css">
			tr#item-<?=$service_id?> {
				display: none;
			}
		</style>
	<?php
}

/**
 * Other Libs
 *
 * @since 1.0.1
 */
require_once( PODS_FRONT_END_DIR . 'lib/get-pods-data.php' );


/**
 * Shortcode Main Functions
 *
 * @since 1.0.1
 */
require_once( PODS_FRONT_END_DIR . 'page/pods-front-edit.php' );
require_once( PODS_FRONT_END_DIR . 'page/pods-front-list.php' );