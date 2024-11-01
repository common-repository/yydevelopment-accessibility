// ----------------------------------------------
// yydevelopment accessibility js code
// ----------------------------------------------   


jQuery(document).ready(function($){

	// ====================================================================================================
	// Function that work with the accessibility plugin
	// 1) if we want to have an element that won't be effected by the change we will give it the class of class="no-accessibility"
	// ====================================================================================================

	// ====================================================================================================
	// Start the plugin on different pages when saved
	// ====================================================================================================

	// yydev_add_no_accessibility_class();
	// yydev_check_correct_font_size_on_load();
	// yydev_check_for_light_light_contrast();
	// yydev_check_for_height_height_contrast();

	// ====================================================================================================
	// Display and hide the main script when clicking on the accessibility button
	// ====================================================================================================

	// when someone click on the accessibility button
	$(".yy-button").click(function() {

		var accessibilityDisplay = $(".yy-box").css("display");

		if ( (accessibilityDisplay == "none") ) {
			$(".yy-box").css("display", "block");
		} else { // if ( (accessibilityDisplay == "none") ) {
			$(".yy-box").css("display", "none");
		} // } else { // if ( (accessibilityDisplay == "none") ) {


		if( !$('body').hasClass('yydev-active-accessibility') ) {

			// runing a function that will add bigger font size to each element on the page
			$('*').each(function(){

				// if we give an element the class no-accessibility this script won't adjust it
				if( yydev_accessibilityClassCheck($(this)) ) {

					// changing the font size on all the element in the page
					var elementFontSize =  parseInt($(this).css('font-size')); 

					if( !$(this).data('yy-font-size') ) {
						$(this).attr("data-yy-font-size", elementFontSize);
					} // if( !$('div').data('yy-font-size') ) {

					$(this).css("font-size", elementFontSize + "px");

				} // if( yydev_accessibilityClassCheck($(this)) ) {

			}); // $('*').each(function(){

		} // if( $('body').addClass('yydev-active-accessibility') ) {

		$('body').addClass('yydev-active-accessibility');

		return false;
	}); // $(".accessibility-button").click(function() {

	// close the accessibility box if clicked outside of it
	$(document).on('click', function (e) {
		if ($(e.target).closest(".yydev-accessibility").length === 0) {
			$(".yy-box").css("display", "none");
		} // if ($(e.target).closest(".yydev-accessibility").length === 0) {
	});

	// ====================================================================================================
	// Reset all rest-accessibility options
	// ====================================================================================================

	$("a.rest-accessibility").click(function() {

		// function that reset the font size
		accessibility_reset_font_size(); 

		// function that reset the light contrast
		yydev_accessibility_reset_light_contrast();

		// function that reset the high contrast
		yydev_accessibility_reset_height_contrast();

		$('body').removeClass('yydev-highlight-links');

		return false;

	}) // $("a.rest-accessibility").click(function() {

	// ====================================================================================================
	// Add "no-accessibility" class to selected items on the page
	// ====================================================================================================

	function yydev_add_no_accessibility_class() {

		// add no accessibility class to wordpress top admin panel
		$("#wpadminbar").addClass("no-accessibility");

	} // function yydev_add_no_accessibility_class() {

	// ====================================================================================================
	// Function that test if we should make changes on this element
	// ====================================================================================================

	function yydev_accessibilityClassCheck(className) {

		// checking if the element has a "no-accessibility" class, and if it does the element won't be changed
		// the function will also check the element parents and go up to 3 parents back
		if( !( className.hasClass("no-accessibility") || className.parents('.no-accessibility').length) ) {
			return 1;
		} else { // if( !( className.hasClass("no-accessibility") || className.parents('.no-accessibility').length) ) {
			return 0;
		} // } else { // if( !( className.hasClass("no-accessibility") || className.parents('.no-accessibility').length) ) {

	} // function yydev_accessibilityClassCheck(className) {

	// ====================================================================================================
	// Create functions that will allow us to work with cookies
	// ====================================================================================================

	var cookieTime; // allow to set time for the cookie "1 * 60 * 60 * 1000" = 1 hour
	var cookieValue; // allow us to get the value of a cookie
	var newCookieValue // allow us to set new value for the cookie

	function yydev_getCookie(key) {
		var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
		return keyValue ? keyValue[2] : null;
	} // function yydev_getCookie(key) {

	function yydev_setCookie(cookieName, cookievalue, cookieTime) {
		var expires = new Date();
		expires.setTime(expires.getTime() + (cookieTime));
		document.cookie = cookieName + '=' + cookievalue +';path=/'+ ';expires=' + expires.toUTCString();
	} // function yydev_setCookie(cookieName, cookievalue, cookieTime) {


	// ====================================================================================================
	// Changing the document font size
	// ====================================================================================================

	// load the script once when the page is loaded in order to get the right size
	function yydev_check_correct_font_size_on_load(){
		cookieValue = parseInt(yydev_getCookie('accessibility-font-size'));
		if(cookieValue != null) {

			accessiblity_change_size(cookieValue);

		} //if(cookieValue == null) {

	} // function yydev_check_correct_font_size_on_load(){


	// run if the button that increase the font size is clicked
	$(".increase-font-size").click(function(){
		yydev_accessiblity_font_resize(1); // making the font bigger by 1px
		return false;
	}); // $(".increase-font-size").click(function(){


	// run if the button that decrease the font size is clicked
	$(".decrease-font-size").click(function(){
		yydev_accessiblity_font_resize(-1); // making the font smaller by -1px
		return false;
	}); // $(".decrease-font-size").click(function(){


	// function that will set cookie, and check if to resize
	// the font or not 
	function yydev_accessiblity_font_resize(resizeNumber) {

		// setting limit to the big font size and small font size
		var smallestFontSize = -3;
		var biggestFontSize = 3;


		// checking the value of the cookie if exists and create new value to 
		// insert the new cookie
		cookieValue = yydev_getCookie('accessibility-font-size');
		if(cookieValue == null) {
			// if cookie doesn't exists
			cookieValue = 0;
		} //if(cookieValue == null) {

		newCookieValue = parseInt(cookieValue) + parseInt(resizeNumber);

		var dontChangeSize = 0;

		// if the font sizes are ok remove not-active class incase it's set
		if( (newCookieValue < biggestFontSize) && ($("a.increase-font-size").hasClass("not-active")) ) { 
			$("a.increase-font-size").removeClass("not-active");
		} // if( (newCookieValue < biggestFontSize) && (newCookieValue > smallestFontSize)  ) { {

		// if the font sizes are ok remove not-active class incase it's set
		if( (newCookieValue < biggestFontSize) && (newCookieValue > smallestFontSize)  ) { 
			$("a.increase-font-size").removeClass("not-active");
			$("a.decrease-font-size").removeClass("not-active");
		} // if( (newCookieValue < biggestFontSize) && (newCookieValue > smallestFontSize)  ) { {

		// if the font is too big create a class that will stop run it
		if( newCookieValue > biggestFontSize ) {
			dontChangeSize = 1;
			$("a.increase-font-size").addClass("not-active");
		} // if( newCookieValue > biggestFontSize ) {
		
		// if the font is too small create a class that will stop run it
		if ( newCookieValue < smallestFontSize ) {
			dontChangeSize = 1;
			$("a.decrease-font-size").addClass("not-active");
		} //if ( newCookieValue < smallestFontSize ) {

		// if there are no error change the font size and create / update cookie
		if( dontChangeSize == 0 ) {
			accessiblity_change_size(resizeNumber);

			// recreating the cookie and give it value, if the cookie already exists the value
			// will change based on the cookie former value
			cookieTime = 1 * 10 * 60 * 1000; // set cookie to 10 minutes
			yydev_setCookie('accessibility-font-size', newCookieValue, cookieTime);

		} // if( dontChangeSize == 0 ) {

	} // function accessiblity_change_size() {


	// function that will change the font size
	function accessiblity_change_size(resizeNumber) {

		// runing a function that will add bigger font size to each element on the page
	   $('*').each(function(){

			// if we give an element the class no-accessibility this script won't adjust it
			if( yydev_accessibilityClassCheck($(this)) ) {

				// changing the font size on all the element in the page
				var elementFontSize =  parseInt($(this).css('font-size')); 

				var redSize = ( elementFontSize + resizeNumber ) ; // here, you can give the percentage( now it is reduced to 90%)
				$(this).css('font-size', redSize );  

			} // if( yydev_accessibilityClassCheck($(this)) ) {

	   }); // $('*').each(function(){

	} // function accessiblity_change_size() {

	// this function reset the font size
	function accessibility_reset_font_size() {

		cookieValue = parseInt(yydev_getCookie('accessibility-font-size'));
		if(cookieValue != null) {

		// if the font is bigger we will make it smaller
		if(cookieValue > 0) {
			yydev_accessiblity_font_resize(cookieValue * -1)
		} // if(cookieValue > 0) {

		// if the font is smaller we will make it bigger
		if(cookieValue < 0) {
			yydev_accessiblity_font_resize(cookieValue * -1)
		} // if(cookieValue > 0) {

		cookieTime = -1; // set to remove cookie
		yydev_setCookie('accessibility-font-size', 0, cookieTime);

	} //if(cookieValue == null) {

		   $('*').each(function(){

				if( $(this).data('yy-font-size') ) {
					$(this).css('font-size', $(this).data('yy-font-size') );
				} // if( !$('div').data('yy-font-size') ) {

		   }); // $('*').each(function(){

	} //function accessibility_reset_font_size() {

	// ====================================================================================================
	// Create low contrast display
	// ====================================================================================================

	// load the script once when the page is loaded
	function yydev_check_for_light_light_contrast(){
		cookieValue = yydev_getCookie('accessibility-light-contrast-color');
		if(cookieValue != null) {
			yydev_accessibility_light_contrast();
		} //if(cookieValue == null) {

	} // function yydev_check_for_light_light_contrast(){

	// run if the button to light contrast is clicked
	$(".light-contrast-color").click(function(){
		yydev_accessibility_light_contrast(); // making the font bigger by 1px
		return false;
	}); // $(".light-contrast-color").click(function(){


	// function that add class to all element and add them low contrast
	function yydev_accessibility_light_contrast() {

	   $('*').each(function(){
			if( yydev_accessibilityClassCheck($(this)) ) {

				// remove high contrast class if exists
				$(this).removeClass("accessibility-high-contrast-color");

				// add low contrast class to all elements
				$(this).addClass("accessibility-light-contrast-color");  

			} // if( yydev_accessibilityClassCheck($(this)) ) {
	   }); // $('*').each(function(){

		// remove light cookie if exists
		cookieTime = -1; // set to remove cookie
		yydev_setCookie('accessibility-high-contrast-color', "1", -1);

		// create a cookie that will save settings
		cookieTime = 1 * 10 * 60 * 1000; // set cookie to 10 minutes
		yydev_setCookie('accessibility-light-contrast-color', "1", cookieTime);

	} // function yydev_accessibility_light_contrast() {


	// this function reset the light contrast
	function yydev_accessibility_reset_light_contrast() {

		cookieValue = yydev_getCookie('accessibility-light-contrast-color');
		if(cookieValue != null) {

			// remove the cookie if it's set
			cookieTime = -1; // remove cookie
			yydev_setCookie('accessibility-light-contrast-color', "1", cookieTime);

		} //if(cookieValue == null) {

		$('*').each(function(){
			$(this).removeClass("accessibility-light-contrast-color");
		}); // $('*').each(function(){

		// removing the class that add black background to the button
		$(".accessibility-button a").removeClass("accessibility-black-background");

	} //function yydev_accessibility_reset_light_contrast() {

	// ====================================================================================================
	// Create high contrast display
	// ====================================================================================================

	// run if the button to height contrast is clicked
	$(".highlight-links").click(function(){
		$('body').addClass('yydev-highlight-links');
		return false;
	}); // $(".high-contrast-color").click(function(){

	// ====================================================================================================
	// Create high contrast display
	// ====================================================================================================

	// load the script once when the page is loaded
	function yydev_check_for_height_height_contrast(){
		cookieValue = yydev_getCookie('accessibility-high-contrast-color');
		if(cookieValue != null) {
			yydev_accessibility_height_contrast();
		} //if(cookieValue == null) {

	} // function yydev_check_for_height_height_contrast(){


	// run if the button to height contrast is clicked
	$(".high-contrast-color").click(function(){
		yydev_accessibility_height_contrast(); // making the font bigger by 1px
		return false;
	}); // $(".high-contrast-color").click(function(){


	// function that add class to all element and add them high contrast
	function yydev_accessibility_height_contrast() {

	   $('*').each(function(){
			if( yydev_accessibilityClassCheck($(this)) ) {

				// remove low contrast class if exists
				$(this).removeClass("accessibility-light-contrast-color");

				// add high contrast class to all elements
				$(this).addClass("accessibility-high-contrast-color");  

			} // if( yydev_accessibilityClassCheck($(this)) ) {
	   }); // $('*').each(function(){

		// remove light cookie if exists
		cookieTime = -1; // set to remove cookie
		yydev_setCookie('accessibility-light-contrast-color', "1", -1);

		// create a cookie that will save settings
		cookieTime = 1 * 10 * 60 * 1000; // set cookie to 10 minutes
		yydev_setCookie('accessibility-high-contrast-color', "1", cookieTime);

	} // function yydev_accessibility_height_contrast() {


	// this function reset the height contrast
	function yydev_accessibility_reset_height_contrast() {

		cookieValue = yydev_getCookie('accessibility-high-contrast-color');
		if(cookieValue != null) {

			// remove the cookie if it's set
			cookieTime = -1; // remove cookie
			yydev_setCookie('accessibility-high-contrast-color', "1", cookieTime);

		} //if(cookieValue == null) {
		
		$('*').each(function(){
			$(this).removeClass("accessibility-high-contrast-color");
		}); // $('*').each(function(){

	} //function yydev_accessibility_reset_height_contrast() {

});