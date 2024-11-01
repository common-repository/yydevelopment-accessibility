<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

// include_once( dirname(__FILE__) . '/../include/settings.php');
// require_once( dirname(__FILE__) . '/../include/functions.php');

// ========================================================================================================
// Get all the data and ouput it into the page
// ========================================================================================================

$getting_plugin_data = get_option($wp_options_name);

if( !empty($getting_plugin_data) ) {


    // ----------------------------------------------
    // breaking the string into to 2 variables. the array namd and vakue  
    // ----------------------------------------------  
    
    $break_array = explode("***", $getting_plugin_data);

    $item_name = explode("####", $break_array[0]);
    $key_name = explode("####", $break_array[1]);

    $array_count = count($key_name);

    // ----------------------------------------------
    // creating an organized array with all values
    // ----------------------------------------------      

    for($count_number = 0; $count_number < $array_count; $count_number++) {
    	$accessibility_plugin_data_array[ $item_name[$count_number] ] = $key_name[$count_number];
    } // for($count_number = 0; $count_number < $array_count; $count_number++) {

    // ----------------------------------------------
    // dealing with exclude or include pages
    // ----------------------------------------------
    
    $accessibility_exclude_option = esc_attr($accessibility_plugin_data_array['exclude_option']);
    $exclude_ids = esc_attr($accessibility_plugin_data_array['exclude_ids']);
    
    // creating an array with all the ids
    $accessibility_exclude_ids_array = [];
    $exclude_ids_explode = explode( ',', $exclude_ids);
    
    foreach($exclude_ids_explode as $exclude_id) {
    
            $exclude_id = intval( trim($exclude_id) );
            
            if( !empty($exclude_id) ) {
                $accessibility_exclude_ids_array[] = $exclude_id;
            } // if( !empty($exclude_id) ) {
    
    } // foreach($exclude_ids_explode as $exclude_id) {

    // making sure the back to top button active 
    if( $accessibility_plugin_data_array['display_button_checkbox'] == 1 ) {

        // ----------------------------------------------
        // add css code to header
        // ---------------------------------------------- 

        add_action( 'wp_head', function() use ($accessibility_plugin_data_array, $accessibility_exclude_option, $accessibility_exclude_ids_array) {
            
           $page_id = yydev_accessibility_find_page_id();
           $accessibility_exclude_option = $accessibility_exclude_option; // checking if we should exclude or include pages
           $exclude_ids = $accessibility_exclude_ids_array; // pages we should display on or ignore
           $output_button_now = 1;
           
           // incase we exclude pages
           if( $accessibility_exclude_option === 'exclude' ) {
           
           // incase we choose to exclude an id
           if( in_array( $page_id, $exclude_ids) ) {
               $output_button_now = 0;
           } // if( in_array( $page_id, $exclude_ids) ) {
           
           } // if( $accessibility_exclude_option === 'exclude' ) {
           
           // incase we exclude pages
           if( $accessibility_exclude_option === 'include' ) {
           
           // incase we choose to include only on some pages
           if( !in_array( $page_id, $exclude_ids) ) {
               $output_button_now = 0;
           } // if( !in_array( $page_id, $exclude_ids) ) {
           
           } // if( $accessibility_exclude_option === 'exclude' ) {
           
           
           // checking if we should output the button
           if( $output_button_now ) {

                // ----------------------------------------------
                // gettting all the plugin data
                // ----------------------------------------------   

                $display_button_checkbox = intval($accessibility_plugin_data_array['display_button_checkbox']);
                $background_color = esc_attr($accessibility_plugin_data_array['background_color']);
                $button_width = esc_attr($accessibility_plugin_data_array['button_width']);
                $button_height = esc_attr($accessibility_plugin_data_array['button_height']);
                $button_movment = esc_attr($accessibility_plugin_data_array['button_movment']);
                $horizontal_position = esc_attr($accessibility_plugin_data_array['horizontal_position']);
                $horizontal_spacing = esc_attr($accessibility_plugin_data_array['horizontal_spacing']);
                $vertical_position = esc_attr($accessibility_plugin_data_array['vertical_position']);
                $vertical_spacing = esc_attr($accessibility_plugin_data_array['vertical_spacing']);
                $icon_image_url = esc_url($accessibility_plugin_data_array['icon_image_url']);
                $hide_on_desktop_checkbox = intval($accessibility_plugin_data_array['hide_on_desktop_checkbox']);
                $hide_on_mobile_checkbox = intval($accessibility_plugin_data_array['hide_on_mobile_checkbox']);
                $mobile_width = esc_attr($accessibility_plugin_data_array['mobile_width']);
                $mobile_button_position_checkbox = intval($accessibility_plugin_data_array['mobile_button_position_checkbox']);
                $mobile_horizontal_position = esc_attr($accessibility_plugin_data_array['mobile_horizontal_position']);
                $mobile_horizontal_spacing = esc_attr($accessibility_plugin_data_array['mobile_horizontal_spacing']);
                $mobile_vertical_position = esc_attr($accessibility_plugin_data_array['mobile_vertical_position']);
                $mobile_vertical_spacing = esc_attr($accessibility_plugin_data_array['mobile_vertical_spacing']);
                $accessibility_background_color = esc_attr($accessibility_plugin_data_array['accessibility_background_color']);
                $accessibility_page_url = esc_url($accessibility_plugin_data_array['accessibility_page_url']);
                $accessibility_page_text = esc_attr($accessibility_plugin_data_array['accessibility_page_text']);
                $z_index = intval($accessibility_plugin_data_array['z_index']);

                        // ----------------------------------------------
                        // dealing with admin bar showing up on top
                        // ----------------------------------------------

                        $add_css_desktop_margin = '';
                        $add_css_mobile_margin = '';

                        if( is_admin_bar_showing() && ($button_movment === 'fixed') ) {
        
                                if( $vertical_position === 'top' ) {
                                        $add_css_desktop_margin = 'margin-top: 32px;';
                                } // if( $vertical_position === 'top' ) {

                                if( $mobile_vertical_position === 'top' ) {
                                        $add_css_mobile_margin = 'margin-top: 46px;';
                                } // if( $mobile_vertical_position === 'top' ) {

                        } // if( is_admin_bar_showing() && ($button_movment === 'fixed') ) {

                        // ----------------------------------------------
                        // create button css code
                        // ----------------------------------------------

                        $yydev_accessibility_style = '';
                        $icons_img = plugin_dir_url(dirname(__FILE__)) . 'images/accessibility-icons.png';

                        // dealing with button style
                        $yydev_accessibility_style .= '<style>';

                            $yydev_accessibility_style .= '.yydev-accessibility {';
                                    $yydev_accessibility_style .= 'position: ' . $button_movment . ';';
                                    $yydev_accessibility_style .= $horizontal_position . ':' . $horizontal_spacing . ';';
                                    $yydev_accessibility_style .= $vertical_position . ':' . $vertical_spacing . ';';
                                    $yydev_accessibility_style .= 'z-index: ' . $z_index . ';';
                                    $yydev_accessibility_style .= $add_css_desktop_margin;
                                    
                                    // if the button is showed only on desktop
                                    if($hide_on_desktop_checkbox == 1) {
                                        $yydev_accessibility_style .= 'display: none';
                                    } // if($hide_on_desktop_checkbox == 1) {

                            $yydev_accessibility_style .= '}';

                            $yydev_accessibility_style .= '.yydev-accessibility .yydev-warp {';
                                    $yydev_accessibility_style .= 'position: relative;';
                                    $yydev_accessibility_style .= 'font-family: Arial, Helvetica, sans-serif;';

                            $yydev_accessibility_style .= '}';

                            $yydev_accessibility_style .= '.yydev-accessibility .yy-button {';
                                    $yydev_accessibility_style .= 'width:' . $button_width . 'px;';
                                    $yydev_accessibility_style .= 'height:' . $button_height . 'px;';
                                    $yydev_accessibility_style .= 'background:' . $background_color . ' url(' . $icon_image_url .') no-repeat 45% 50%;';
                                    $yydev_accessibility_style .= 'padding: 0px;';
                                    $yydev_accessibility_style .= 'margin: 0px;';
                                    $yydev_accessibility_style .= 'position: absolute;';
                                    $yydev_accessibility_style .= 'top: 0px;';
                                    $yydev_accessibility_style .= $horizontal_position . ': 0px;';
                            $yydev_accessibility_style .= '}';

                            $yydev_accessibility_style .= '.yydev-accessibility .yy-box {';
                                    $yydev_accessibility_style .= 'position: relative;';
                                    $yydev_accessibility_style .= 'top: '. $button_height . 'px;';
                                    $yydev_accessibility_style .=  $horizontal_position . ': 0px;';
                                    $yydev_accessibility_style .= 'margin: 0px 0px 0px 0px;';
                                    $yydev_accessibility_style .= 'width: 180px;';
                                    $yydev_accessibility_style .= 'border: 1px solid #aeaeae;';
                                    $yydev_accessibility_style .= 'text-align: center;';
                                    $yydev_accessibility_style .= 'background: #fff;';
                                    $yydev_accessibility_style .= 'display: none;';
                            $yydev_accessibility_style .= '}';

                            $yydev_accessibility_style .= '.yydev-accessibility .yy-box .yy-title {';
                                    $yydev_accessibility_style .= 'font-size: 20px;';
                                    $yydev_accessibility_style .= 'font-weight: bold;';
                                    $yydev_accessibility_style .= 'color: #494949;';
                                    $yydev_accessibility_style .= 'padding: 8px 0px 8px 0px;';
                                    $yydev_accessibility_style .= 'margin: 0px 0px 0px 0px;';
                            $yydev_accessibility_style .= '}';

                            $yydev_accessibility_style .= '.yydev-accessibility .yy-box .yy-title span {';
                                    $yydev_accessibility_style .= 'width: 20px;';
                                    $yydev_accessibility_style .= 'height: 20px;';
                                    $yydev_accessibility_style .= 'display: inline-block;';
                                    $yydev_accessibility_style .= 'padding: 0px 0px 0px 0px;';
                                    $yydev_accessibility_style .= 'margin: 0px 5px -2px 5px;';
                                    $yydev_accessibility_style .= 'background: ' . ' url(' . $icons_img .') no-repeat 0px 50%;';
                            $yydev_accessibility_style .= '}';

                            $yydev_accessibility_style .= '.yydev-accessibility .yy-box a {';
                                    $yydev_accessibility_style .= 'display: block;';
                                    $yydev_accessibility_style .= 'padding: 10px 0px 10px 0px;';
                                    $yydev_accessibility_style .= 'margin: 0px 0px 0px 0px;';
                                    $yydev_accessibility_style .= 'color: #5c5c5c;';
                                    $yydev_accessibility_style .= 'font-weight: bold;';
                                    $yydev_accessibility_style .= 'font-size: 14px;';
                                    $yydev_accessibility_style .= 'line-height: 17px;'; 
                                    $yydev_accessibility_style .= 'border-top: 1px solid #ededed;';
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.yydev-accessibility .yy-box a:hover {';
                                    $yydev_accessibility_style .= 'text-decoration: none;';
                                    $yydev_accessibility_style .= 'background: #f2f8fa;';
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.yydev-accessibility .yy-box a:hover {';
                                    $yydev_accessibility_style .= 'text-decoration: none;';
                                    $yydev_accessibility_style .= 'background: #f2f8fa;';
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.yydev-accessibility a.not-active {';
                                    $yydev_accessibility_style .= 'color: #a4a4a4;';
                                    $yydev_accessibility_style .= 'cursor: not-allowed;';
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.yydev-accessibility a.not-active:hover  {';
                                    $yydev_accessibility_style .= 'background: transparent;';
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.yydev-accessibility a.rest-accessibility {';
                                    $yydev_accessibility_style .= 'color: #00addf;';
                                    $yydev_accessibility_style .= 'padding-left: 4px;';
                            $yydev_accessibility_style .= '}';

                            $yydev_accessibility_style .= '.yydev-accessibility a.rest-accessibility span {';
                                    $yydev_accessibility_style .= 'width: 20px;';
                                    $yydev_accessibility_style .= 'height: 20px;';
                                    $yydev_accessibility_style .= 'display: inline-block;';
                                    $yydev_accessibility_style .= 'padding: 0px 0px 0px 0px;';
                                    $yydev_accessibility_style .= 'margin: 0px 0px -6px -8px;';
                                    $yydev_accessibility_style .= 'background: ' . ' url(' . $icons_img .') no-repeat -35px -5px';
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.yydev-accessibility a.accessibility-notice {';
                                    $yydev_accessibility_style .= 'font-size: 13px;';
                                    $yydev_accessibility_style .= 'padding: 6px 0px 6px 0px;';
                                    $yydev_accessibility_style .= 'margin: 0px 0px 0px 0px;';
                                    $yydev_accessibility_style .= 'background: ' . $accessibility_background_color . ';';
                                    $yydev_accessibility_style .= 'text-decoration: underline;';
                                    $yydev_accessibility_style .= 'color: #fff;';                                        
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.yydev-accessibility a.accessibility-notice:hover {';
                                    $yydev_accessibility_style .= 'background: ' . $accessibility_background_color . ';';
                                    $yydev_accessibility_style .= 'text-decoration: underline;';                                  
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.accessibility-high-contrast-color {';
                                    $yydev_accessibility_style .= 'background-color: #000 !important;';
                                    $yydev_accessibility_style .= 'color: #fff !important;';
                                    $yydev_accessibility_style .= 'border-color: #fff !important;';
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.accessibility-high-contrast-color:not(span) {';
                                    $yydev_accessibility_style .= 'background-image: none !important;';
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.accessibility-light-contrast-color {';
                                    $yydev_accessibility_style .= 'background-color: #fff !important;';
                                    $yydev_accessibility_style .= 'color: #000 !important;';
                                    $yydev_accessibility_style .= 'border-color: #000 !important;';
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.accessibility-light-contrast-color:not(span) {';
                                    $yydev_accessibility_style .= 'background-image: none !important;';
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.yydev-highlight-links a {';
                                    $yydev_accessibility_style .= 'border: 5px dashed blue !important;';
                                    $yydev_accessibility_style .= 'display: inline-block;';
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.yydev-highlight-links a:focus,';
                             $yydev_accessibility_style .= '.yydev-highlight-links input:focus,';
                             $yydev_accessibility_style .= '.yydev-highlight-links textarea:focus,';
                             $yydev_accessibility_style .= '.yydev-highlight-links select:focus,';
                             $yydev_accessibility_style .= '.yydev-highlight-links button:focus {';
                                    $yydev_accessibility_style .= 'border: 7px solid red !important;';
                            $yydev_accessibility_style .= '}';

                             $yydev_accessibility_style .= '.yydev-highlight-links a, .yydev-highlight-links a {';
                                    $yydev_accessibility_style .= 'border: 3px dashed blue !important;';
                                    $yydev_accessibility_style .= 'display: inline-block;';
                            $yydev_accessibility_style .= '}';

/*

                             $yydev_accessibility_style .= '.yydev-accessibility a, .yydev-accessibility a:focus {';
                                    $yydev_accessibility_style .= 'border: none !important;';
                            $yydev_accessibility_style .= '}';
*/

                            // ----------------------------------------------
                            // dealing with rtl and ltr
                            // ----------------------------------------------

                            // dealing with ltr
                            // ---------------------------------

                            $yydev_accessibility_style .= '.yydev_ltr .yy-box .yy-title span {';
                                    $yydev_accessibility_style .= 'margin-left: -9px;';
                            $yydev_accessibility_style .= '}';


                            // dealing with rtl
                            // ---------------------------------

                            $yydev_accessibility_style .= '.yydev_rtl .yy-box .yy-title span {';
                                    $yydev_accessibility_style .= 'margin: 0px 3px -2px 0px;';
                            $yydev_accessibility_style .= '}';

                            $yydev_accessibility_style .= '.yydev_rtl a.rest-accessibility span {';
                                    $yydev_accessibility_style .= 'margin: 0px 0px -6px 2px';
                            $yydev_accessibility_style .= '}';

                           // dealing with button mobile style
                           // ---------------------------------

                           $yydev_accessibility_style .= '@media only screen and (max-width: ' . $mobile_width . 'px) {';

                                $yydev_accessibility_style .= '.yydev-accessibility {';

                                    if( $mobile_button_position_checkbox == 1 ) {
                                        $yydev_accessibility_style .= $horizontal_position . ':auto;';
                                        $yydev_accessibility_style .= $vertical_position . ':auto;';
                                        $yydev_accessibility_style .= $mobile_horizontal_position . ':' . $mobile_horizontal_spacing . ';';
                                        $yydev_accessibility_style .= $mobile_vertical_position . ':' . $mobile_vertical_spacing . ';';
                                    } // if( $mobile_button_position_checkbox == 1 ) {

                                    $yydev_accessibility_style .= $add_css_mobile_margin;
                                    $yydev_accessibility_style .= 'display: block;';

                                    // if the button is showed only on desktop
                                    if($hide_on_mobile_checkbox == 1) {
                                        $yydev_accessibility_style .= 'display: none';
                                    } // if($hide_on_mobile_checkbox == 1) {

                                $yydev_accessibility_style .= '}';


                                if( $mobile_button_position_checkbox == 1 ) {
                                    $yydev_accessibility_style .= '.yydev-accessibility .yy-button {';
                                            $yydev_accessibility_style .=  $horizontal_position . ': auto;';
                                            $yydev_accessibility_style .=  $mobile_horizontal_position . ': 0px;';
                                    $yydev_accessibility_style .= '}';
                                } // if( $mobile_button_position_checkbox == 1 ) {

                           $yydev_accessibility_style .= '}';
                       $yydev_accessibility_style .= '</style>';
                       $yydev_accessibility_style .= "\n";

                    // echo css code to page
                    echo $yydev_accessibility_style;

           } // if( $output_button_now ) {

        }); // add_action( 'wp_head', function() use ($accessibility_plugin_data_array) {

        // =============================================================
        // add the button html to footer
        // =============================================================

        add_action( 'wp_footer', function() use ($accessibility_plugin_data_array, $accessibility_exclude_option, $accessibility_exclude_ids_array) {
        	 
                $page_id = yydev_accessibility_find_page_id();
                $accessibility_exclude_option = $accessibility_exclude_option; // checking if we should exclude or include pages
                $exclude_ids = $accessibility_exclude_ids_array; // pages we should display on or ignore
                $output_button_now = 1;

                // incase we exclude pages
                if( $accessibility_exclude_option === 'exclude' ) {

                // incase we choose to exclude an id
                if( in_array( $page_id, $exclude_ids) ) {
                    $output_button_now = 0;
                } // if( in_array( $page_id, $exclude_ids) ) {

                } // if( $accessibility_exclude_option === 'exclude' ) {

                // incase we exclude pages
                if( $accessibility_exclude_option === 'include' ) {

                // incase we choose to include only on some pages
                if( !in_array( $page_id, $exclude_ids) ) {
                    $output_button_now = 0;
                } // if( !in_array( $page_id, $exclude_ids) ) {

                } // if( $accessibility_exclude_option === 'exclude' ) {


                // checking if we should output the button
                if( $output_button_now ) {

                        // ----------------------------------------------
                        // create button css code
                        // ----------------------------------------------
                        
                        $yydev_accessibility_html = "";

                        $direction_code = 'yydev_ltr';                
                         if( is_rtl() ) {
                                $direction_code = 'yydev_rtl';
                         } //  if( is_rtl() ) {

                        $yydev_accessibility_html .= "<div class='yydev-accessibility no-accessibility " . $direction_code . "'>";
                            $yydev_accessibility_html .= "<div class='yydev-warp'>";

                                $yydev_accessibility_html .= "<a class='yy-button' href='#'><span class='screen-reader-text'>" . __('Accessibility', 'yydevelopment-accessibility') . "</span></a>";

                                $yydev_accessibility_html .= "<div class='yy-box'>";
                                    $yydev_accessibility_html .= "<p class='yy-title'><span class='rtl'></span>" . __('Accessibility', 'yydevelopment-accessibility') . "</p>";
                                    $yydev_accessibility_html .= "<a href='#' class='increase-font-size'>" . __('Increase Font Size', 'yydevelopment-accessibility') . "</a>";
                                    $yydev_accessibility_html .= "<a href='#' class='decrease-font-size'>" . __('Decrease Font Size', 'yydevelopment-accessibility') . "</a>";
                                    $yydev_accessibility_html .= "<a href='#' class='light-contrast-color'>" . __('Light contrast', 'yydevelopment-accessibility') . "</a>";
                                    $yydev_accessibility_html .= "<a href='#' class='high-contrast-color'>" . __('High contrast', 'yydevelopment-accessibility') . "</a>";
                                    $yydev_accessibility_html .= "<a href='#' class='highlight-links'>" . __('Highlight Links', 'yydevelopment-accessibility') . "</a>";
                                    $yydev_accessibility_html .= "<a href='#' class='rest-accessibility'><span class='rtl'></span>" . __('Reset Settings', 'yydevelopment-accessibility') . "</a>";

                                    // getting the accessibility page url
                                    if( !empty($accessibility_plugin_data_array['accessibility_page_url']) ) {
                                        $yydev_accessibility_html .= "<a href='" . $accessibility_plugin_data_array['accessibility_page_url'] . "' target='_blank' class='accessibility-notice'><span></span>" . $accessibility_plugin_data_array['accessibility_page_text'] . "</a>";
                                    } // if( !empty($accessibility_plugin_data_array['accessibility_page_url']) ) {

                               $yydev_accessibility_html .= "</div><!--yy-box-->";

                            $yydev_accessibility_html .= "</div><!--yydev-warp-->";
                        $yydev_accessibility_html .= "</div><!--yydev-accessibility-->";

                        
                        echo __($yydev_accessibility_html, 'yydev_accessibility');

                } // if( $output_button_now ) {

        }); // add_action( 'wp_footer', function() use ($yydev_accessibility_html) {


        // ----------------------------------------------
        // adding javascript code to the site
        // ----------------------------------------------   

        add_action( 'wp_enqueue_scripts', function($content) use ($accessibility_exclude_option, $accessibility_exclude_ids_array) {

                $page_id = yydev_accessibility_find_page_id();
                $accessibility_exclude_option = $accessibility_exclude_option; // checking if we should exclude or include pages
                $exclude_ids = $accessibility_exclude_ids_array; // pages we should display on or ignore
                $output_button_now = 1;

                // incase we exclude pages
                if( $accessibility_exclude_option === 'exclude' ) {

                // incase we choose to exclude an id
                if( in_array( $page_id, $exclude_ids) ) {
                    $output_button_now = 0;
                } // if( in_array( $page_id, $exclude_ids) ) {

                } // if( $accessibility_exclude_option === 'exclude' ) {

                // incase we exclude pages
                if( $accessibility_exclude_option === 'include' ) {

                // incase we choose to include only on some pages
                if( !in_array( $page_id, $exclude_ids) ) {
                    $output_button_now = 0;
                } // if( !in_array( $page_id, $exclude_ids) ) {

                } // if( $accessibility_exclude_option === 'exclude' ) {


                // checking if we should output the button
                if( $output_button_now ) {

                        $js_file_path = esc_url( plugin_dir_url(dirname(__FILE__)) ) . 'front-end/yydev-accessibility.js?2.2.1';
                        wp_enqueue_script( 'yydev_accessibility_js', $js_file_path, array('jquery'), false, true);

                } // if( $output_button_now ) {

        }); // function yydev_accessibility_registe_js( $content ) {


    } // if( $accessibility_plugin_data_array['display_button_checkbox'] == 1 ) {


} // if( !empty($getting_plugin_data) ) {

