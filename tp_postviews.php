<?php
/*
Plugin Name:  TP PostViews Count & Popular Posts Widgets
Plugin URI:   https://themepacific.com/ 
Description:  PostViews for WordPress in simple Way with Stylish Popular Posts Based on Views Widget.
Version:      1.1.1
Author:       ThemePacific
Author URI:   https://themepacific.com/
Text Domain:  tp_postviews
*/
 
 
// If this file is called directly, then abort Mission :)
if ( ! defined( 'WPINC' ) ) {
    die;
}
/**
 * Include the core class responsible for loading all necessary components of the plugin.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/class_tp_pviews.php';

 register_activation_hook(__FILE__, 'themepacific_wpPviews_activation');

function themepacific_wpPviews_activation() {
    deactivate_plugins('tp_postviews_pro/tp_postviews.php');
}
/**
 * Instantiates the themepacific_pviews_counter class and then
 * calls its run method officially starting up the plugin.
 */
function run_themepacific_pviews_counter() {

	$spmm = new themepacific_pviews_counter();
	$spmm->run();

}

// Call the above function to begin execution of the plugin.
run_themepacific_pviews_counter();