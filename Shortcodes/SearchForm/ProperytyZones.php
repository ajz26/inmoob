<?php

namespace Inmoob\Shortcodes\SearchForm;
use Inmoob\Classes\Api;

class ProperytyZones extends Select {
    static  $shortcode   = "inmoob_sf_property_zones_select";

    static function get_values(){

        $values     = Api::get_terms_select('property_zones_taxonomy');
        $options    = array_map(array(__CLASS__,'parse_options'),$values);
        $options    =  array_map(array(__CLASS__,'set_selected'),$options);
        return $options;
    }


    private static function set_selected(&$option): object{
        $category = get_query_var('property_zones_taxonomy') ?:  get_query_var('property_zones');

        if($option->val == $category){
            $option->selected = true;
        }
        return $option;
    }

    static function set_default_atts(){
        $atts = self::get_atts();
        parent::set_default_atts();
        self::$attributes_defaults = array_merge(static::$attributes_defaults,array(
            'type'      => 'selector',
            'values'    => array(),
            'multiple'  => false,
            'name'      => 'property_zones_taxonomy',
        ));
    }


    static function output($atts, $content = null){

        $property_zones = get_query_var('property_zones_taxonomy') ?: (get_query_var('property_zones') ?: null);
        $post_search    = (get_query_var('post_search') == 1) ? true : false;

        if($property_zones && !$post_search) return null;

        self::get_values();
        return parent::output($atts,$content);
    }

}