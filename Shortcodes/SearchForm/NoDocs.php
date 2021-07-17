<?php

namespace Inmoob\Shortcodes\SearchForm;
use Inmoob\Classes\Api;

class NoDocs extends Field {
    static  $shortcode   = "inmoob_sf_property_no_docs_switch";

    static function get_values()
    {
        
    }

    static function generate_css(){

    }

    static function general_styles()
    {
        return "

        .switches {
            display: flex !important;
        }

        .switches span {
            margin-top: 0 !important;
        }

        .switches input {
            display: none;
        }

        span.switch {
            width: 3rem;
            height: 1.7rem;
            background-color: #f3f6f9;
            border-radius: 2rem;
            display: inline-block !important;
            border: 1px solid #cccccc;
            position: relative;
            margin-right: 1rem;
        }

        span.switch + span {
            display: inline-block;
        }

        .switches input[type='checkbox']:checked + span.switch {
            background-color: #00d084;
        }

        .switches input[type=\"checkbox\"]:checked + span.switch::before {
            transition: transform .1s linear;
            background-color: #fff !important;
            transform: translateX(1.3rem);
        }

        .switches input[type='checkbox'] + span.switch::before {
            transition: transform .1s linear;
            content: '';
            border-color: #ffffff;
            width: 1.2rem;
            height: 1.2rem;
            background-color: #cccccc;
            display: block;
            border-radius: 1rem;
            position: absolute;
            top: .16rem;
            left: .2rem;
        }   
        
        
        ";
    }

    static function set_default_atts(){
        $atts = self::get_atts();
        parent::set_default_atts();
        self::$attributes_defaults = array_merge(static::$attributes_defaults,array(
            'type'      => 'switch',
            'name'      => 'no_docs',
        ));
    }


    static function output($atts, $content = null){
        $name  = self::get_atts('name','no_docs');
        $label = self::get_atts('label','Sin Documentación');

        return "<label for='field-{$name}' class='switches'><input type='checkbox' class='switch fake-switch' name='$name' id='field-{$name}' value='1'><span class='switch'></span> <span class='label-text'>{$label}</span></label>";

    }

}