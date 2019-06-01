<?php
/**
 * @package MyAdPlugin
 */
/*
Plugin Name: MyAd Plugin
Plugin URI: https://github.com/afmejia/ad-plugin
Description: Plugin for adding customs ads to a Post
Version: 1.0.0
Author: Felipe Mejia
Author URI: http://github.com/afmejia
License: GPLv2 or later
Text Domain: Ad-plugin
 */

 // If this file is called directly, abort!
 if ( ! defined( 'ABSPATH' ) ) {
     die;
 }

 // Require once the Composer Autoload
 if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
     require_once dirname( __FILE__ ) . '/vendor/autoload.php';
 }

 /**
  * The code that runs during plugin activation
  */
 function activate_ad_plugin() {
    Inc\Base\Activate::activate();
 }
 register_activation_hook( __FILE__, 'activate_ad_plugin' );

 /**
  * The code that runs during plugin deactivation
  */
 function deactivate_ad_plugin() {
    Inc\Base\Deactivate::deactivate();
 }
 register_deactivation_hook( __FILE__, 'deactivate_ad_plugin' );

 /**
  * Initialize all the core classes of the plugin
  */
 if ( class_exists( 'Inc\\Init' ) ) {
     Inc\Init::register_services();
 }
