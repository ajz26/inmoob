<?php

namespace Inmoob\Api\Endpoints\Witei;
use Inmoob\Witei\Translator;
use OBSER\Classes\Helpers;
use function Inmoob\Witei\Functions\get_post_by_id;

class Create extends Endpoint{
    protected static $route     = "create";

    static function callback( \WP_REST_Request $data){

        $body           = $data->get_body();
        
        if(!is_object($body)){
            $body           = Helpers::stripslashes_deep($body);
            $body           = json_decode($body);
        }

        if(!$body){
            error_log('error en body');
            return wp_send_json(array('error' => 'json no válido'), 500);
        } 

        $translation    =   new Translator($body);
        $property       =   $translation->property;
        

        if(!isset($property->witei_event_type) || !in_array($property->witei_event_type,array('create','update'))){
            error_log('hook no válido');
            return wp_send_json_error('hook no válido para esta acción' );
         }

        if($post_id = get_post_by_id($property->witei_id)){
            $property->ID = $post_id; 
        }
        
        $data->set_body($property);

        return \Inmoob\Api\Endpoints\Properties\Create::callback($data);
     
    }

}