<?php
/*
Plugin Name: c321go_glift
Description: Create hello world message
Version: 1.0
Author: Author's name
Author URI: http://authorsite.com/
Plugin URI: http://authorsite.com/msp-helloworld
*/


/**
 * Define some useful constants
 **/
define('c321GO_GLIFT_VERSION', '1.0');
define('c321GO_GLIFT_DIR', plugin_dir_path(__FILE__));
define('c321GO_GLIFT_URL', plugin_dir_url(__FILE__));
//define('CONCATENATE_SCRIPTS', false );
//from glift-plugin
define( 'GLIFT_JS_VERSION', '1.0.6' ); // change this number on js upgrade //prevents caching


/** 
*Please note that language files for Plugins ARE NOT automatically loaded. Add this to the Plugin code to make sure the language file(s) are loaded:
*To fetch a string simply use __('String name','your-unique-name'); to return the translation or _e('String name','your-unique-name'); to echo the translation. Translations will then go into your plugin's /languages folder.
*   load_plugin_textdomain('your-unique-name', false, basename( dirname( __FILE__ ) ) . '/languages' );
**/




/**
 * Load files
 * 
 **/
function c321go_glift_load(){

    require_once(c321GO_GLIFT_DIR.'includes/c321go_dbcommunication.php');

    if(is_admin() ) {//load admin files only in admin
        require_once(c321GO_GLIFT_DIR.'includes/admin.php');
        add_action('admin_menu', 'registerAddSGFMenu');
      //  add_action('admin_init', 'init_admin_page');

        }
    require_once(c321GO_GLIFT_DIR.'includes/core.php');
    add_action('init', 'c321go_glift_register_scripts' );
    add_shortcode('c321go' , 'c321go_placeglift'); //register shortcode

    add_action('wp_ajax_nopriv_put_result', 'put_result' );
    add_action('wp_ajax_put_result', 'put_result' );

 }

//on page load?
c321go_glift_load();


/**
 * Activation, Deactivation and Uninstall Functions
 * 
 **/
register_activation_hook(__FILE__, 'c321go_glift_activation');
register_deactivation_hook(__FILE__, 'c321go_glift_deactivation');


function c321go_glift_activation() {
	
	//actions to perform once on plugin activation go here    
    
	
    //register uninstaller
    register_uninstall_hook(__FILE__, 'c321go_glift_uninstall');
}

function c321go_glift_deactivation() {
    
	// actions to perform once on plugin deactivation go here
	    
}

function c321go_glift_uninstall(){
    
    //actions to perform once on plugin uninstall go here
	    
}


?>