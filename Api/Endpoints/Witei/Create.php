<?php

namespace Inmoob\Api\Endpoints\Witei;
use Inmoob\Witei\Translator;
use OBSER\Classes\Helpers;
use function Inmoob\Witei\Functions\get_post_by_id;

class Create extends Endpoint{
    protected static $route     = "create";


    protected static  function gen_random_key($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    static function callback( \WP_REST_Request $data){

        $body           = $data->get_body();
        
        if(!is_object($body)){
            // $body           = Helpers::stripslashes_deep($body);
            $body           = json_decode($body);
        }

        $saving = true;
        $tries  = 0;
        $key    = self::gen_random_key(); 
        error_log('inicio' .'-->'. $key);

        do {
            $prop_saving = get_transient('saving_property') ?: null;
            
            error_log(" paso {$tries}  = $prop_saving");

            if($prop_saving == 'saving'){
                error_log(microtime(true));
                error_log('waiting for save' .'-->'. $key);
                sleep(3);
                $saving = true;
            }else{
                error_log('pass to save');
                $saving = false;
            }
            $tries++;
        } while ($saving && $tries < 4);
        
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
            error_log('actualizado');
        }else{
            error_log('nuevo');
        }

        
        $data->set_body($property);

        $callback = \Inmoob\Api\Endpoints\Properties\Create::callback($data);

        error_log('fin' .'-->'. $key);
        return $callback;

     
    }

}