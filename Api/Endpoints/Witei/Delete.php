<?php

namespace Inmoob\Api\Endpoints\Witei;
use Inmoob\Witei\Translator;
use OBSER\Classes\Helpers;
use function Inmoob\Witei\Functions\get_post_by_id;

class Delete extends Endpoint{
    protected static $route     = "delete";

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
        

        if($post_id     = get_post_by_id($property->witei_id)){
            $property->ID = $post_id; 
        }

        if(!$post_id){
            return \wp_send_json_error('propiedad no encontrada', 400 );
        }

        if($property->witei_event_type == 'delete' && $post_id){
           $deleted = \wp_delete_post( $post_id, true);
        }

        if(!$deleted){
            return wp_send_json_error('Error al eliminar la propiedad' );
        }


        return wp_send_json_success('Propiedad eliminada', 200 );
     
    }
    
}

