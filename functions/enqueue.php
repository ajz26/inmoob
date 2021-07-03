<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

add_action( 'wp_enqueue_scripts',function() {
    $inmoob_icos = apply_filters('inmoob-font-url',INMOOB_CORE_PLUGIN_DIR_URL . "/assets/css/inmoob-font.css");
    wp_register_style( 'inmoob-icons', $inmoob_icos);
    wp_enqueue_style( 'inmoob-icons', $inmoob_icos);

}, 0 );

