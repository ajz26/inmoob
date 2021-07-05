<?php

namespace Inmoob\Api\Endpoints\Properties;
use Obser\Classes\Helpers;

class Create extends Endpoint{
    protected static $route     = "create";
    private static $data;
    static function callback( \WP_REST_Request $data){
        $body           = $data->get_body();
        if(!is_object($body)){
            $body           = Helpers::stripslashes_deep($body);
            $body           = !is_array($body) ? json_decode($body) : $body;
        }
        self::$data     = $body;
        $post           = self::parse();

        
        $post_id        = wp_insert_post($post);


        if(isset($post->meta_input)){
            foreach($post->meta_input AS $meta_key => $meta_value){
                add_post_meta( $post_id, $meta_key, $meta_value, false);
            }
        }


        if(isset($post->tax_input)){
            foreach($post->tax_input AS $taxonomy => $value){
                $term = get_term_by('slug', $value ,$taxonomy);
                $term_id = $term->term_id;
                if(!$term){
                   $term = wp_insert_term( $value, $taxonomy);
                   if ( !is_wp_error( $term ) ) {
                        $term_id = $term['term_id'];
                    }
                }
                try {
                    wp_set_object_terms($post_id,intval($term_id), $taxonomy);
                } catch (\WP_Error $error) {
                    error_log($error->get_error_messages());
                }

                add_post_meta( $post_id, $meta_key, $meta_value, false);
            }
        }


        return $post;
    }


    static function parse(){
        $object             = self::$data;
        $post               = new \WP_Post(null);
        $post->post_type    = 'inmoob_properties';
        $post->meta_single  = true;
        $post->meta_input   = [];
        $post->tax_input    = [];
        foreach ( get_object_vars( $post ) as $key => $value ) {
            $post->$key = isset($object->$key) ? $object->$key : $value ;
        }

        foreach ( get_object_vars( $object ) as $key => $value ) {
            
            if( preg_match("/taxonomy$/",$key)){
                $post->tax_input[$key] = $value;
            }else if(!isset($post->$key)){
                $post->meta_input[$key] = $value;
            }
        }


        if(isset( $post->meta_input['images'])){
            $images = $post->meta_input['images'] ?: array();

            $images = array_map(function($image){
                return Helpers::upload_external_media($image);
            },$images);
            $post->meta_input['images'] = $images;
        };
        $post->ID           = 645;

        return $post;
    }

}