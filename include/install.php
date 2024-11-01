<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

include('settings.php'); // Load the files to get the databse info

// ----------------------------------------------
// checking if the data existing on the db and 
// if not we will create it with initial settings
// ----------------------------------------------    

if( !get_option($wp_options_name) ) {

    // ----------------------------------------------
    // getting all the values and clear data
    // ----------------------------------------------    

    $display_button_checkbox = 1;
    
    $background_color = '#09547c';
    $button_width = 45;
    $button_height = 45;
    $button_movment = 'fixed';
    
    $horizontal_position = 'left';
    $horizontal_spacing = '0px';
    $vertical_position = 'top';
    $vertical_spacing = '50px';

    // getting the image arrow icon
    $icon_image_url = plugin_dir_url(dirname(__FILE__)) . 'images/accessibility-icon.png';

    $hide_on_mobile_checkbox = 0;
    $hide_on_desktop_checkbox = 0;
    $mobile_width = 960;
    $mobile_button_position_checkbox = 0;
    $mobile_horizontal_position = 'left';
    $mobile_horizontal_spacing = '0px';
    $mobile_vertical_position = 'top';
    $mobile_vertical_spacing = '0px';
    $accessibility_background_color = '#157cb0';
    $accessibility_page_url = '';
    $accessibility_page_text = __('Accessibility Statement', 'yydevelopment-accessibility');

    $z_index = 99999;

    $exclude_option = '';
    $exclude_ids = '';

    // ----------------------------------------------
    // insert the data into an array
    // ----------------------------------------------  

    $plugin_data_array = array(
        'display_button_checkbox' => $display_button_checkbox,
        'background_color' => $background_color,
        'button_width' => $button_width,
        'button_height' => $button_height,
        'button_movment' => $button_movment,
        'horizontal_position' => $horizontal_position,
        'horizontal_spacing' => $horizontal_spacing,
        'vertical_position' => $vertical_position,
        'vertical_spacing' => $vertical_spacing,
        'icon_image_url' => $icon_image_url,
        'hide_on_mobile_checkbox' => $hide_on_mobile_checkbox,
        'hide_on_desktop_checkbox' => $hide_on_desktop_checkbox,
        'mobile_width' => $mobile_width,
        'mobile_button_position_checkbox' => $mobile_button_position_checkbox,
        'mobile_horizontal_position' => $mobile_horizontal_position,
        'mobile_horizontal_spacing' => $mobile_horizontal_spacing,
        'mobile_vertical_position' => $mobile_vertical_position,
        'mobile_vertical_spacing' => $mobile_vertical_spacing,
        'accessibility_background_color' => $accessibility_background_color,
        'accessibility_page_url' => $accessibility_page_url,
        'accessibility_page_text' => $accessibility_page_text,
        'z_index' => $z_index,

        'exclude_option' => $exclude_option,
        'exclude_ids' => $exclude_ids,
    ); // $creating_data_array = array(

    // ----------------------------------------------
    // creating a value with all the array data
    // ----------------------------------------------  
    
    $array_key_name = "";
    $array_item_value = "";
    
    foreach($plugin_data_array as $key=>$item) {
        $array_key_name .= "####" . $key;
    	$array_item_value .= "####" . $item;
    } // foreach($medical_form_array as $key=>$item) {

    // ----------------------------------------------
    // inserting all the data to datbase
    // ----------------------------------------------  

    $plugin_data = $array_key_name . "***" . $array_item_value;
    $plugin_data = sanitize_text_field($plugin_data);

    // update optuon on the database into wp_options
    update_option($wp_options_name, $plugin_data);    

} // if( !get_option($wp_options_name) ) {