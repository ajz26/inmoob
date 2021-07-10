<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

add_action( 'wp_enqueue_scripts',function() {


    if( is_user_logged_in() && current_user_can( 'administrator' ) ) {
        wp_enqueue_script( 'ccom-admin',INMOOB_CORE_PLUGIN_DIR_URL . "/assets/js/admin.js",array('jquery'), false, false );
    }

    $inmoob_icos = apply_filters('inmoob-font-url',INMOOB_CORE_PLUGIN_DIR_URL . "/assets/css/inmoob-font.css");
    wp_register_style( 'inmoob-icons', $inmoob_icos);
    wp_enqueue_style( 'inmoob-icons', $inmoob_icos);

}, 0 );

    
add_action( 'admin_enqueue_scripts',function() {

    wp_register_script( 'ccom-admin',INMOOB_CORE_PLUGIN_DIR_URL . "/assets/js/admin.js",array('jquery'), false, true );
    wp_enqueue_script( 'ccom-admin');

}, 0 );
    