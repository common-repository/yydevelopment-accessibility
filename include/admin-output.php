<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php

$success_message = '';
$error_message = '';

// ====================================================
// Include the file that contains all the info
// ====================================================
include('settings.php');

// ===============================================
// This will allow us to use the media uploader
// ===============================================
wp_enqueue_media();

// ========================================================================================================
// Update the data if it's changed
// ========================================================================================================
    
if( isset($_POST['yydev_accessibility_nonce']) ) {

    if( wp_verify_nonce($_POST['yydev_accessibility_nonce'], 'yydev_accessibility_action') ) {

        // ----------------------------------------------
        // getting all the values and clear data
        // ----------------------------------------------        

        $display_button_checkbox = yydev_accessibility_checkbox_isset('display_button_checkbox');
        $background_color = sanitize_text_field( $_POST['background_color'] );
        $button_width = intval( $_POST['button_width'] );
        $button_height = intval( $_POST['button_height'] );
        $button_movment = sanitize_text_field( $_POST['button_movment'] );
        $horizontal_position = sanitize_text_field( $_POST['horizontal_position'] );
        $horizontal_spacing = sanitize_text_field( $_POST['horizontal_spacing'] );
        $vertical_position = sanitize_text_field( $_POST['vertical_position'] );
        $vertical_spacing = sanitize_text_field( $_POST['vertical_spacing'] );
        $icon_image_url = esc_url_raw( $_POST['icon_image_url'] );
        $hide_on_mobile_checkbox = yydev_accessibility_checkbox_isset('hide_on_mobile_checkbox');
        $hide_on_desktop_checkbox = yydev_accessibility_checkbox_isset('hide_on_desktop_checkbox');
        $mobile_width = intval( $_POST['mobile_width'] );
        $mobile_button_position_checkbox = yydev_accessibility_checkbox_isset('mobile_button_position_checkbox');
        $mobile_horizontal_position = sanitize_text_field( $_POST['mobile_horizontal_position'] );
        $mobile_horizontal_spacing = sanitize_text_field( $_POST['mobile_horizontal_spacing'] );
        $mobile_vertical_position = sanitize_text_field( $_POST['mobile_vertical_position'] );
        $mobile_vertical_spacing = sanitize_text_field( $_POST['mobile_vertical_spacing'] );
        $accessibility_page_checkbox = yydev_accessibility_checkbox_isset('accessibility_page_checkbox');
        $accessibility_background_color = sanitize_text_field( $_POST['accessibility_background_color'] );
        $accessibility_page_url = esc_url_raw( $_POST['accessibility_page_url'] );
        $accessibility_page_text = sanitize_text_field( $_POST['accessibility_page_text'] );
        $z_index = intval( $_POST['z_index'] );

        $exclude_option = sanitize_text_field( $_POST['exclude_option'] );
        $exclude_ids = sanitize_text_field( $_POST['exclude_ids'] );

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

        $array_key_name = '';
        $array_item_value = '';
        
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

        $success_message = "The data was updated successfully";

    } else { // if( wp_verify_nonce($_POST['yydev_accessibility_nonce'], 'yydev_accessibility_action') ) {
        $error_message = "Form nonce was incorrect";
    } // } else { // if( wp_verify_nonce($_POST['yydev_accessibility_nonce'], 'yydev_accessibility_action') ) {

} // if( isset($_POST['yydev_accessibility_nonce']) ) {

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
    	$plugin_data_array[ $item_name[$count_number] ] = $key_name[$count_number];
    } // for($count_number = 0; $count_number < $array_count; $count_number++) {

} // if( !empty($getting_plugin_data) ) {

?>

<div class="wrap yydev-accessibility">

    <h2 class="display-inline">Accessibility Settings</h2>

    <?php yydev_accessibility_echo_message_if_exists(); ?>
    <?php yydev_accessibility_echo_success_message_if_exists($success_message); ?>
    <?php yydev_accessibility_echo_error_message_if_exists($error_message); ?>

    <p>Below you will be able to edit and make change to the accessibility icon output:</p>
    <p style="background:#e6e6e6;padding:10px;"><b>Note: You can stop changes to elements on the site by adding the class <span style="color:#47a3ff">no-accessibility</span> to it</b></p>

    <div class="insert-new">

<form class="edit-form-data" method="POST" action="">

        <br />
        <h2> Basic Settings: </h2>        

        <div class="yydev_accessibility_line">
            <input type="checkbox" id="display_button_checkbox" class="checkbox" name="display_button_checkbox" value="1" <?php if($plugin_data_array['display_button_checkbox'] == 1) {echo "checked";} ?> />
            <label for="display_button_checkbox">Display button on the site (when unselected the button won't show up)</label>
        </div><!--yydev_accessibility_line-->
        
        <div class="yydev_accessibility_line">
            <label for="background_color">Background color hex: </label>
            <input type="text" id="background_color" class="input-very-short" name="background_color" value="<?php echo yydev_accessibility_html_output($plugin_data_array['background_color']); ?>" /> 
            <small>Example: #09547c</small>
        </div><!--yydev_accessibility_line-->


        <div class="yydev_accessibility_line">
            <label for="button_width">Button Width: </label>
            <input type="text" id="button_width" class="input-very-short" name="button_width" value="<?php echo yydev_accessibility_html_output($plugin_data_array['button_width']); ?>" /> PX  
        </div><!--yydev_accessibility_line-->

        <div class="yydev_accessibility_line">
            <label for="button_height">Button Height: </label>
            <input type="text" id="button_height" class="input-very-short" name="button_height" value="<?php echo yydev_accessibility_html_output($plugin_data_array['button_height']); ?>" /> PX  
        </div><!--yydev_accessibility_line-->

        <div class="yydev_accessibility_line">
            <label for="button_movment">Button Movment (Static/Fixed): </label>

            <select name="button_movment">
                <option value="absolute" <?php if($plugin_data_array['button_movment'] == "absolute") {echo "selected";} ?> >Static</option>
                <option value="fixed" <?php if ($plugin_data_array['button_movment'] == "fixed") {echo "selected";} ?> >Fixed</option>
            </select>            

        </div><!--yydev_accessibility_line-->

        <div class="yydev_accessibility_line">
            <label for="horizontal_position">Horizontal Position: </label>

            <select name="horizontal_position">
                <option value="left" <?php if($plugin_data_array['horizontal_position'] == "left") {echo "selected";} ?> >Left</option>
                <option value="right" <?php if ($plugin_data_array['horizontal_position'] == "right") {echo "selected";} ?> >Right</option>
            </select>            

            <label for="horizontal_spacing">Horizontal Spacing: </label>
            <input type="text" id="horizontal_spacing" class="input-very-short" name="horizontal_spacing" value="<?php echo yydev_accessibility_html_output($plugin_data_array['horizontal_spacing']); ?>" />
            <small>Examples: 10px, 50%</small>
        </div><!--yydev_accessibility_line-->


        <div class="yydev_accessibility_line">
            <label for="vertical_position">Vertical Position: </label>

            <select name="vertical_position">
                <option value="top" <?php if($plugin_data_array['vertical_position'] == "top") {echo "selected";} ?> >Top</option>
                <option value="bottom" <?php if ($plugin_data_array['vertical_position'] == "bottom") {echo "selected";} ?> >Bottom</option>
            </select>            

            <label for="vertical_spacing">Vertical Spacing: </label>
            <input type="text" id="vertical_spacing" class="input-very-short" name="vertical_spacing" value="<?php echo $plugin_data_array['vertical_spacing']; ?>" />
            <small>Examples: 10px, 50%</small>
        </div><!--yydev_accessibility_line-->

        <div class="yydev_accessibility_line">
            <label for="z_index">Z-index: </label>
            <input type="text" id="z_index" class="input-very-short" name="z_index" value="<?php echo yydev_accessibility_html_output($plugin_data_array['z_index']); ?>" />
            <small>Choose bigger number if there are element in front the button</small>
        </div><!--yydev_accessibility_line-->

        <div class="yydev_accessibility_line">
            <img class="yydev_light_img_bg" style="background:<?php echo $plugin_data_array['background_color']; ?>" src="<?php echo esc_url($plugin_data_array['icon_image_url']); ?>" alt="" />
            <label for="icon_image_url">Custom Icon Url: </label>
            <input type="text" id="icon_image_url" class="input-very-long yydev_image_input" name="icon_image_url" value="<?php echo esc_url($plugin_data_array['icon_image_url']); ?>" />
            <input type="button" name="yydev_upload_image" class="yydev_upload_image button-secondary" value="Choose Image..." />

            <div class="clear"></div>
        </div><!--yydev_accessibility_line-->


        <br />
        <h2> Mobile Settings: </h2>    

        <div class="yydev_accessibility_line">
            <input type="checkbox" id="hide_on_mobile_checkbox" class="checkbox" name="hide_on_mobile_checkbox" value="1" <?php if($plugin_data_array['hide_on_mobile_checkbox'] == 1) {echo "checked";} ?> />
            <label for="hide_on_mobile_checkbox">Hide the button on mobile (display button only on desktop)</label>
        </div><!--yydev_accessibility_line-->

        <div class="yydev_accessibility_line">
            <input type="checkbox" id="hide_on_desktop_checkbox" class="checkbox" name="hide_on_desktop_checkbox" value="1" <?php if($plugin_data_array['hide_on_desktop_checkbox'] == 1) {echo "checked";} ?> />
            <label for="hide_on_desktop_checkbox">Hide the button on desktop (display button only on mobile)</label>
        </div><!--yydev_accessibility_line-->

        <div class="yydev_accessibility_line">
            <label for="mobile_width">Mobile screen width (will effect the option selected above): </label>
            <input type="text" id="mobile_width" class="input-very-short" name="mobile_width" value="<?php echo yydev_accessibility_html_output($plugin_data_array['mobile_width']); ?>" /> PX  
        </div><!--yydev_accessibility_line-->


        <br />
        <h2> Mobile Positioning: </h2>  


        <div class="yydev_accessibility_line">
            <input type="checkbox" id="mobile_button_position_checkbox" class="checkbox" name="mobile_button_position_checkbox" value="1" <?php if($plugin_data_array['mobile_button_position_checkbox'] == 1) {echo "checked";} ?> />
            <label for="mobile_button_position_checkbox">Choose different button positioning on mobile</label>
        </div><!--yydev_accessibility_line-->

        <div class="yydev_accessibility_line">
            <label for="mobile_horizontal_position">Horizontal Position: </label>

            <select name="mobile_horizontal_position">
                <option value="left" <?php if($plugin_data_array['mobile_horizontal_position'] == "left") {echo "selected";} ?> >Left</option>
                <option value="right" <?php if ($plugin_data_array['mobile_horizontal_position'] == "right") {echo "selected";} ?> >Right</option>
            </select>            

            <label for="mobile_horizontal_spacing">Horizontal Spacing: </label>
            <input type="text" id="mobile_horizontal_spacing" class="input-very-short" name="mobile_horizontal_spacing" value="<?php echo yydev_accessibility_html_output($plugin_data_array['mobile_horizontal_spacing']); ?>" />
            <small>Examples: 10px, 50%</small>
        </div><!--yydev_accessibility_line-->


        <div class="yydev_accessibility_line">
            <label for="mobile_vertical_position">Vertical Position: </label>

            <select name="mobile_vertical_position">
                <option value="top" <?php if($plugin_data_array['mobile_vertical_position'] == "top") {echo "selected";} ?> >Top</option>
                <option value="bottom" <?php if ($plugin_data_array['mobile_vertical_position'] == "bottom") {echo "selected";} ?> >Bottom</option>
            </select>            

            <label for="mobile_vertical_spacing">Vertical Spacing: </label>
            <input type="text" id="mobile_vertical_spacing" class="input-very-short" name="mobile_vertical_spacing" value="<?php echo yydev_accessibility_html_output($plugin_data_array['mobile_vertical_spacing']); ?>" />
            <small>Examples: 10px, 50%</small>
        </div><!--yydev_accessibility_line-->


        <br />
        <h2> Accessibility Page: </h2> 

        <div class="yydev_accessibility_line">
            <label for="accessibility_page_text">Accessibility Page Text: </label>
            <input type="text" id="accessibility_page_text" class="input-short" name="accessibility_page_text" value="<?php echo yydev_accessibility_html_output($plugin_data_array['accessibility_page_text']); ?>" /> 
        </div><!--yydev_accessibility_line-->

        <div class="yydev_accessibility_line">
            <label for="accessibility_page_url">Accessibility Page URL: </label>
            <input type="text" id="accessibility_page_url" class="input-very-long" name="accessibility_page_url" value="<?php echo yydev_accessibility_html_output($plugin_data_array['accessibility_page_url']); ?>" /> 
            <small>The site page with the accessibility statement</small>
        </div><!--yydev_accessibility_line-->

        <div class="yydev_accessibility_line">
            <label for="accessibility_background_color">Accessibility Page Background color hex: </label>
            <input type="text" id="accessibility_background_color" class="input-very-short" name="accessibility_background_color" value="<?php echo yydev_accessibility_html_output($plugin_data_array['accessibility_background_color']); ?>" /> 
            <small>Example: #09547c</small>
        </div><!--yydev_accessibility_line-->


        <br />
        <h2> Include/Exclude Pages By ID: </h2>    

         <p> Insert the pages ID and separate them by comma. You can use <a target="_blank" href="https://wordpress.org/plugins/show-posts-and-pages-id/">Show Pages IDs</a> plugin for help.
         <br /><br />
         Example <small>(one page)</small>: 14 
         <br /> Example <small>(multiple pages)</small>: 14, 16, 23 </p>

        <div class="yydev_accessibility_line">

            <label for="exclude_option">Include/Exclude Option: </label>

            <select name="exclude_option" id='exclude_option'>
                <option value="none" <?php if($plugin_data_array['exclude_option'] == "none") {echo "selected";} ?> >Not Active (Default)</option>
                <option value="exclude" <?php if($plugin_data_array['exclude_option'] == "exclude") {echo "selected";} ?> >Exclude Pages By ID</option>
                <option value="include" <?php if ($plugin_data_array['exclude_option'] == "include") {echo "selected";} ?> >Include Only On Pages</option>
            </select>

            <input type="text" id="exclude_ids" class="input-short" name="exclude_ids" value="<?php echo yydev_accessibility_html_output($plugin_data_array['exclude_ids']); ?>" />

        </div><!--yydev_accessibility_line-->

        <br />

        <?php
            // creating nonce to make sure the form was submitted correctly from the right page
            wp_nonce_field( 'yydev_accessibility_action', 'yydev_accessibility_nonce' ); 
        ?>
        
        <input type="submit" class="edit-form-data yydev-tags-submit" name="insert_accessibility" value="Submit Changes" />

</form>

<br /><br /><br />
<span id="footer-thankyou-code">This plugin was create by <a target="_blank" href="https://www.yydevelopment.com">YYDevelopment</a>. If you liked the plugin please give it a <a target="_blank" href="https://wordpress.org/plugins/yydevelopment-accessibility/#reviews">5 stars review</a>. 
If you want to help support this FREE plugin <a target="_blank" href="https://www.yydevelopment.com/coffee-break/?plugin=yydevelopment-accessibility">buy us a coffee</a>.</span>
</span>
</div><!--wrap-->