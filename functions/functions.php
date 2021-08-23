<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );
require_once INMOOB_CORE_PLUGIN_DIR_PATH ."functions/post_types.php";
require_once INMOOB_CORE_PLUGIN_DIR_PATH ."functions/taxonomies.php";
require_once INMOOB_CORE_PLUGIN_DIR_PATH ."functions/admin/settings.php";
require_once INMOOB_CORE_PLUGIN_DIR_PATH ."functions/admin/mails.php";
require_once INMOOB_CORE_PLUGIN_DIR_PATH ."functions/rest_api.php";
require_once INMOOB_CORE_PLUGIN_DIR_PATH ."functions/rewrite_rules.php";
require_once INMOOB_CORE_PLUGIN_DIR_PATH ."functions/metaboxes.php";
require_once INMOOB_CORE_PLUGIN_DIR_PATH ."functions/shortcodes.php";
require_once INMOOB_CORE_PLUGIN_DIR_PATH ."functions/override_content.php";
require_once INMOOB_CORE_PLUGIN_DIR_PATH ."functions/enqueue.php";
require_once INMOOB_CORE_PLUGIN_DIR_PATH ."functions/attachment_from_url.php";
require_once INMOOB_CORE_PLUGIN_DIR_PATH ."functions/testimonials.php";

add_action('before_delete_post', function ($post_id,$post){

     $post_type = $post->post_type;

    if($post_type !== 'inmoob_properties') return;

    $images = get_post_meta($post_id, 'images');

    foreach($images AS $image){
        wp_delete_attachment( $image ,true);
    }

    $blueprints = get_post_meta($post_id, 'blueprints');

    foreach($blueprints AS $blueprint){
        wp_delete_attachment( $blueprint ,true);
    }

},10,2);
