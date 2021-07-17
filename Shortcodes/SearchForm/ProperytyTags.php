<?php

namespace Inmoob\Shortcodes\SearchForm;
use Inmoob\Classes\Api;

class ProperytyTags extends Field {
    static  $shortcode   = "inmoob_sf_property_tags_select";

    static function get_values(){

        $values     = Api::get_terms_select('property_tags_taxonomy');
        $options    = array_map(array('Inmoob\Shortcodes\SearchForm\Select','parse_options'),$values);
        $options    = array_filter($options,array(__CLASS__,'filter_options'));
        return $options;
    }

    static function filter_options($value){
        
        return in_array($value->val,self::get_atts('fields',array())) ? true : false;
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
        }";
    }

    static function set_default_atts(){
        self::$attributes_defaults = array_merge(static::$attributes_defaults,array(
            'type'      => 'switch',
            'values'    => array(),
            'fields'    => null,
            'multiple'  => false,
            'name'      => 'property_tags_taxonomy',
        ));
    }

    static function buildAtts($_atts = array(), $content = null){
        self::set_default_atts();
        $default    = static::$attributes_defaults;
        $atts       = shortcode_atts($default, $_atts);
        self::set_atts($atts);
        $fields     = explode(',',self::get_atts('fields'));
        self::set_att('fields',$fields);
        $values     = self::get_values();
        self::set_att('values',$values);
    }


    static function output($atts, $content = null){

        $values         = self::get_atts('values');
        $name           = self::get_atts('name');
        $label          = self::get_atts('label');
        $options_html   = null;

        foreach($values AS $option){
            $val    = $option->val;
            $id     = sanitize_key( $val );
            $opt_label  = $option->label;
            $options_html .= "<label for='field-{$id}' class='switches'><input type='checkbox' class='switch fake-switch' name='{$name}' id='field-{$id}' value='{$val}'><span class='switch'></span> <span class='label-text'>{$opt_label}</span></label>";

        }

        if(!$options_html) return null;



        return "<label for='' class='field-list'><span class='label show'>{$label} <i class=\"far \"></i></span></span><div class='inmoob-select'> {$options_html}</div></label>";
                 // return parent::output($atts,$content);
    }

}