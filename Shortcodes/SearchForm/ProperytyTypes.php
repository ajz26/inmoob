<?php

namespace Inmoob\Shortcodes\SearchForm;
use Inmoob\Classes\Api;
use stdClass;

class ProperytyTypes extends Select {
    static  $shortcode   = "inmoob_sf_property_types_select";

    static function get_values(){
        
        $values     = Api::get_terms_select('property_types_taxonomy');
        $options    = array_map(array(__CLASS__,'parse_options'),$values);
        $options    =  array_map(array(__CLASS__,'set_selected'),$options);
        return $options;
    }


    private static function set_selected(&$option): object{
        $category = get_query_var('property_types_taxonomy') ?:  get_query_var('property_type');

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
            'name'      => 'property_types_taxonomy',
        ));
    }


    static function output($atts, $content = null){
        self::get_values();
        return parent::output($atts,$content);
    }



}