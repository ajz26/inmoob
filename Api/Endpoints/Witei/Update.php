<?php

namespace Inmoob\Api\Endpoints\Witei;

class Update extends Endpoint{
    protected static $route     = "update";

    static function callback( \WP_REST_Request $data){
        $body = stripslashes($data->get_body());
        return json_decode($body);
    }
    
}

