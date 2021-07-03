<?php

namespace Inmoob\Shortcodes\SearchForm;

use OBSER\Classes\Shortcode;


abstract class Field extends Shortcode {
    
    static $wpb_namespace       = "Inmoob\\WPB_Components\\SearchForm";
    abstract static function get_values();
    abstract static function set_default_atts();
    
    static $attributes_defaults = array(
        'vc_id'                              => '',
        'uniqid'                             => '',
        'name'                               => '',
        'label'                              => '',
        'placeholder'                        => '',
        'extra_class'                        => '',
        'hidden_if'                          => '',
    );

    static function output($atts, $content){

        $hide = self::get_atts('hidden_if', false); 
         if($hide){
            $values = self::get_atts('values');
            if(is_array($values) && count($values) <= 1) return false; 
            if(!isset($values) || empty($values)) return false;
        }

        return $content;
    }
    
}