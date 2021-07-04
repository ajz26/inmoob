<?php

namespace Inmoob\Api\Endpoints;

use OBSER\Classes\Api\Endpoint;

class Base extends Endpoint{
    protected static $namespace = 'inmoob/v1';
    protected static $route     = "test";
    protected static $method    = 'GET';
    protected static $permission_callback;

    static function callback( \WP_REST_Request $data){
        return "hello";
    }
}

