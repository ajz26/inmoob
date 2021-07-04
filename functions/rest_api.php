<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

class INMOOB_REST_API extends OBSER_REST_API{

    protected   static    $_endpoints;
    private     static    $instance             = [];
                static    $_endpoints_dir       = INMOOB_CORE_PLUGIN_DIR_PATH .'/Api/Endpoints/';
                static    $shortcodes_namespace = 'Inmoob\Api\Endpoints';
}


add_action('rest_api_init',array('INMOOB_REST_API','instance'));
