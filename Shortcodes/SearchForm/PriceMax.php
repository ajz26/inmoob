<?php

namespace Inmoob\Shortcodes\SearchForm;
use Inmoob\Classes\Api;

class PriceMax extends Select {
    static  $shortcode   = "inmoob_sf_property_price_max_select";

    static function get_values(){
        $gestion_type = get_query_var('gestion_types_taxonomy') ? get_query_var('gestion_types_taxonomy') : get_query_var('gestion_type');
        $gestion_type = get_term_by('slug', $gestion_type ,'gestion_types_taxonomy');
        $gestion_type = isset($gestion_type->term_id) ? $gestion_type->term_id : null;
        $data         = Api::get_options_range('price',$gestion_type);

        $min	    = intval($data['min']);
        $max	    = intval($data['max']);
        
        $increase   = Api::calc_increasement(round($min,-4,PHP_ROUND_HALF_EVEN));
        $options    = Api::create_range_options($min,$max,$increase);
        return $options;
    }

    static function set_default_atts(){
        $atts = self::get_atts();
        parent::set_default_atts();
        self::$attributes_defaults = array_merge(static::$attributes_defaults,array(
            'type'      => 'selector',
            'values'    => array(),
            'multiple'  => false,
            'name'      => 'property_price_max',
        ));
    }


    static function output($atts, $content = null){
        self::get_values();
        return parent::output($atts,$content);
    }

}