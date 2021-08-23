<?php

namespace Inmoob\Shortcodes\SearchForm;
use Inmoob\Classes\Api;
use stdClass;

class GestionTypes extends Select {
    static  $shortcode   = "inmoob_sf_gestion_types_select";

    static function get_values(){
        
        $values     = Api::get_terms_select('gestion_types_taxonomy');
        $options    = array_map(array(__CLASS__,'parse_options'),$values);
        return $options;
    }


    static function set_default_atts(){
        parent::set_default_atts();
        self::$attributes_defaults = array_merge(static::$attributes_defaults,array(
            'type'      => 'selector',
            'values'    => array(),
            'multiple'  => false,
            'name'      => 'gestion_types_taxonomy',
        ));
    }


    static function output($atts, $content = null){

        $gestion_types = get_query_var('gestion_types_taxonomy') ?: (get_query_var('gestion_type') ?: null);
        $post_search    = (get_query_var('post_search') == 1) ? true : false;
        if($gestion_types && !$post_search) return null;

        self::get_values();

        return parent::output($atts,$content);
    }



}