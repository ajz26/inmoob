<?php

namespace Inmoob\Api\Endpoints\Witei;

class Delete extends Endpoint{
    protected static $route     = "delete";

    static function callback( \WP_REST_Request $data){
        return "eliminar";
    }
    
}

