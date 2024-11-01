<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/*
Plugin Name: YYDevelopment - Accessibility
Plugin URI:  https://www.yydevelopment.com/yydevelopment-wordpress-plugins/
Description: Simple plugin that allow you add accessibility button to your website
Version:     2.2.2
Author:      YYDevelopment
Author URI:  https://www.yydevelopment.com/
Text Domain: yydevelopment-accessibility
*/

// ================================================
// Adding lanagues support to the plugin
// ================================================

function yydev_accessibility_lang() {
  load_plugin_textdomain( 'yydevelopment-accessibility', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
} // function yydev_portfolio_boxes() {
	
add_action( 'plugins_loaded', 'yydev_accessibility_lang' );

// ================================================
// Loading plugin main files
// ================================================

include_once('include/settings.php');
require_once('include/functions.php');

// ================================================
// Creating Database when the plugin is activated
// ================================================

function yydev_accessibility_create_database() {
    
    load_plugin_textdomain( 'yydevelopment-accessibility', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
    require_once('include/install.php');
        
} // function yydev_accessibility_create_database() {

register_activation_hook(__FILE__, 'yydev_accessibility_create_database');

// ================================================
// display the plugin we have create on the wordpress
// post blog and pages
// ================================================

// function that will output the code to the page
function output_yydev_accessibility() {

    include('include/style.php');
    include('include/scripts.php');
    include('include/admin-output.php');

} // function output_yydev_accessibility() {

// -----------------------------------------------
// load the page into settings page
// -----------------------------------------------

// in case of settings menu loading
function register_yydev_accessibility_page() {
    add_options_page( 'YYDevelopment Accessibility', "YYDevelopment Accessibility", 'manage_options', 'yydev-accessibility', 'output_yydev_accessibility');
} // function register_yydev_accessibility_page() {

add_action('admin_menu', 'register_yydev_accessibility_page');

// ================================================
// Add settings page to the plugin menu info
// ================================================

function yydev_accessibility_add_settings_link( $actions, $plugin_file ) {

	static $plugin;

    if (!isset($plugin)) { $plugin = plugin_basename(__FILE__); }

	if ($plugin == $plugin_file) {

            $admin_page_url = esc_url( menu_page_url( 'yydev-accessibility', false ) );
			$settings = array('settings' => '<a href="' . $admin_page_url . '">Settings</a>');
            $donate = array('donate' => '<a target="_blank" href="https://www.yydevelopment.com/coffee-break/?plugin=yydevelopment-accessibility">Donate</a>');
            $actions = array_merge($settings, $donate, $actions);

    } // if ($plugin == $plugin_file) {

    return $actions;

} //function yydev_accessibility_add_settings_link( $actions, $plugin_file ) {

add_filter( 'plugin_action_links', 'yydev_accessibility_add_settings_link', 10, 5 );

// ================================================
// output the data into the page front end
// ================================================

if( !is_admin() ) {
    include('front-end/front-end-output.php');
} // if( !is_admin() ) {

// ================================================
// including admin notices flie
// ================================================

if( is_admin() ) {
	include_once('notices.php');
} // if( is_admin() ) {