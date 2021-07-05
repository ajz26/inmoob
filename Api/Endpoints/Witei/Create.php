<?php

namespace Inmoob\Api\Endpoints\Witei;
use Inmoob\Witei\Translator;
use OBSER\Classes\Helpers;

class Create extends Endpoint{
    protected static $route     = "create";

    static function callback( \WP_REST_Request $data){

        $body           = $data->get_body();
        $body           = Helpers::stripslashes_deep($body);
        $body           = json_decode($body);
        $translation    = new Translator($body);
        $data->set_body($translation->property);
        return \Inmoob\Api\Endpoints\Properties\Create::callback($data);
     
    }

}