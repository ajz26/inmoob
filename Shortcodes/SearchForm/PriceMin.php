<?php

namespace Inmoob\Shortcodes\SearchForm;
use Inmoob\Classes\Api;

class PriceMin extends Select {
    static  $shortcode   = "inmoob_sf_property_price_min_select";

    static function get_values(){
        $gestion_type   = get_query_var('gestion_types_taxonomy') ? get_query_var('gestion_types_taxonomy') : get_query_var('gestion_type');
        $gestion_type   = get_term_by('slug', $gestion_type ,'gestion_types_taxonomy');
        $gestion_type   = isset($gestion_type->term_id) ? $gestion_type->term_id : null;
        $data           = Api::get_options_range('price',$gestion_type);

        
        $min	        = intval($data['min']);
        $max	        = intval($data['max']);
        $minlength      = strlen($min) +1 ;
        $min            = round($min,-$minlength,PHP_ROUND_HALF_EVEN);


        $increase       = Api::calc_increasement($min) ?: $min;

        $options        = Api::create_range_options($min,$max,$increase);
        return $options;
    }

    static function set_default_atts(){
        parent::set_default_atts();
        self::$attributes_defaults = array_merge(static::$attributes_defaults,array(
            'type'      => 'selector',
            'values'    => array(),
            'multiple'  => false,
            'name'      => 'property_price_min',
        ));
    }


    static function output($atts, $content = null){
        self::get_values();
        return parent::output($atts,$content);
    }

}