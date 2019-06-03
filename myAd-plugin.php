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

// Hooks
add_action( 'init', 'register_shortcodes' );
add_action( 'admin_menu', 'ad_admin_menu' );
add_action( 'admin_enqueue_scripts', 'enqueue_my_scripts' );
add_action( 'wp_enqueue_scripts', 'register_plugin_styles' );

// Enqueue scripts
function enqueue_my_scripts() {
    wp_enqueue_script( 'jQuery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', false );
    wp_enqueue_script( 'myScript', '/wp-content/plugins/myAd-plugin/myScript.js', false );
    wp_enqueue_style('my-styles', '/wp-content/plugins/myAd-plugin/css/public/my-styles.css');
}

// Enqueue styles
function register_plugin_styles() {
    wp_register_style( 'myAd-plugin', '/wp-content/plugins/myAd-plugin/css/public/myAd-plugin.css' );
    wp_enqueue_style( 'myAd-plugin' );
}

// Register all shortcodes
function register_shortcodes() {
    add_shortcode( 'sample_ad', 'sample_ad_shortcode' );
}

// Shortcodes
function sample_ad_shortcode( $args, $content="" ) {
    $a = shortcode_atts( array(
        'category' => 'default',
        'title' => 'Title'
    ), $args );

    $template = get_option('template_settings');


    // Set up output variable - the sample add
    $output = '<a href="#" class="ad ';
    if ($template == '1') {
        $output .= 'template-1 ';
    } else {
        $output .= 'template-2';
    }

    if ( $a['category'] == 'MLB' ) {
        $output .= ' mlb">';
    } elseif ( $a['category'] == 'NFL' ) {
        $output .= ' nfl">';
    } elseif ( $a['category'] == 'NBA' ) {
        $output .= ' nba">';
    } else {
        $output .= '<h2>default</h2>';
    }

    $output .= $a['title'] . '</a>';

    return $output;
}

// Filters
function ad_admin_menu() {
    // $top_menu_item = 'ad_admin_page';
    add_menu_page( 'Ad Settings', 'Ad Settings', 'manage_options', 'ad_admin_page', 'ad_admin_page', 'dashicons-admin-settings' );
    add_action( 'admin_init', 'ad_admin_init' );
}

// Admin Pages
function ad_admin_init() {
    // register_setting( 'adPlugin', 'template_settings' );

    add_settings_section(
        'template_section',
        __( 'MyAd Settings', 'wordpress' ),
        'myAdSectionCallback',
        'ad_admin_page'
    );
    
    register_setting( 'ad_admin_page', 'template_settings' );

    add_settings_field(
        'adPlugin_template',
        __( 'Select a template', 'wordpress' ),
        'adPlugin_template_render',
        'ad_admin_page',
        'template_section'
    );
}

function adPlugin_template_render() {
    $options = get_option( 'template_settings' );
    ?>
    <select name="template_settings" class="template">
        <option value="1" <?php selected( get_option('template_settings'), 1 ); ?>>Option 1</option>
        <option value="2" <?php selected( get_option('template_settings'), 2 ); ?>>Option 2</option>
    </select>

    <?php 
    $class = '';
    if ($options == 1) {
        $class = 'template-1';
    } else {
        $class = 'template-2';
    }
    ?>
    <!-- <div class="ad"> -->
    <div id="template" class="<?php echo $class; ?>">
        <svg width="300" height="110">
            <rect class="canvas" width="300" height="100" />
            Sorry, your browser does not support inline SVG.  
        </svg>
    </div>
    <?php
}

function myAdSectionCallback() {
    echo __( 'Select which template do you want', 'wordpress' );
}

function ad_admin_page() {
   ?>
   <form action="options.php" method='post'>
    <h2>MyAd Settings Admin Page</h2>

    <?php 
    settings_fields( 'ad_admin_page' );
    do_settings_sections( 'ad_admin_page' );
    submit_button();
    ?>

   </form>
   <?php
}