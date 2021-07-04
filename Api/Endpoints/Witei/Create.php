<?php

namespace Inmoob\Api\Endpoints\Witei;
use Inmoob\Witei\Translator;

class Create extends Endpoint{
    protected static $route     = "create";

    static function callback( \WP_REST_Request $data){

        $json       = stripslashes($data->get_body());
        $property   = new Translator($json);

        return $property;
    }

}