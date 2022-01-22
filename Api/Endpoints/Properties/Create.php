<?php
namespace Inmoob\Api\Endpoints\Properties;
use Obser\Classes\Helpers;
use stdClass;

class Create extends Endpoint{
    protected static $route     = "create";
    private static $data;
    private static $post;
    private static $meta_input  = [];
    private static $tax_input   = [];
    

    static function callback( \WP_REST_Request $data){
        
        set_transient('saving_property','saving');
        $body           = $data->get_body();
 
        if(!$body){
            return false;
        }

        if(!is_object($body)){
            $body               = Helpers::stripslashes_deep($body);
            $body               = !is_array($body) ? json_decode($body) : $body;
        }

        self::$data             = $body;

        $post                   = self::parse();
        $post->ID               = wp_insert_post($post);

        if( !isset($post->ID) || $post->ID == 0){
            return wp_send_json(array('error' => 'json no válido'), 500);
        }

        self::$post = $post;
       
        self::manage_meta();
        self::managet_terms();
        error_log('propiedad almacenada guardado');

        delete_transient('saving_property');
        return $post;
    }

    static function managet_terms(){

        $terms = self::$tax_input;
        $post  = self::$post;

        foreach($terms AS $taxonomy => $value){
            Helpers::set_term_by_slug($post,$value,$taxonomy);
        }
    }

    static function manage_meta(){
        $metas = self::$meta_input;
        $post  = self::$post;



        foreach($metas AS $meta_key => $meta_value){
            


            switch($meta_key){

                case 'images':

                    $meta_value = Helpers::upload_external_media($meta_value);
                    $multiple   = get_post_meta( $post->ID, $meta_key);

                    foreach((array)$meta_value AS $array_key => $value) {

                        if(!add_post_meta( $post->ID, $meta_key, $value,true)){
                            
                            if(!in_array($value,$multiple)){
                                add_post_meta( $post->ID, $meta_key, $value);
                            }
                            
                            $multiple = array_filter($multiple,function($val) use ($value){
                                return ($val != $value) ? true : false; 
                            });

                        }else{
                            update_post_meta( $post->ID, $meta_key, $value);
                        }
                    }

                    foreach($multiple AS $value){
                        delete_post_meta( $post->ID, $meta_key, $value);
                    }

                    if($meta_value){
                        $thumnbail = is_array($meta_value) ? $meta_value[0] : $meta_value;
                        set_post_thumbnail( $post->ID, $thumnbail );
                    }

                break;
                default:

                if(!add_post_meta( $post->ID, $meta_key, $meta_value ,true )){
                    update_post_meta ( $post->ID, $meta_key, $meta_value);
                }

            }
        }
    }


    static function parse(){
        $object                 = self::$data;
        $post                   = new \WP_Post(new stdClass);
        $post->post_type        = 'inmoob_properties';
        $post->comment_status   = "closed";
        $post->ping_status      = "closed";

        unset($post->post_excerpt);
        unset($post->post_password);
        unset($post->to_ping);
        unset($post->pinged);
        unset($post->post_content_filtered);
        unset($post->guid);
        unset($post->post_mime_type);
        unset($post->comment_count);
        unset($post->menu_order);
        unset($post->post_parent);


        foreach ( get_object_vars( $post ) as $key => $value ) {
            $post->$key = isset($object->$key) ? $object->$key : $value ;
        }



        foreach ( get_object_vars( $object ) as $key => $value ) {
           

            switch(true){
                case (preg_match("/taxonomy$/",$key) ? true : false ):
                    if(!isset($post->$key)){
                        self::$tax_input[$key] = $value;
                    }
                break;
                default :
                    if(!isset($post->$key) || $post->$key != $value ){
                        self::$meta_input[$key] = $value;
                    }
            }
            
        }

        if(isset($object->ID)){
            $post->ID           = $object->ID;
        }else{
            $post->ID           = 0;
        }

        return $post;
    }

}