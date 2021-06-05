<?php

namespace Inmoob\Shortcodes\SearchForm;
abstract class Select extends Field {


    static function generate_css(){

    }

    static function set_default_atts(){
        self::$attributes_defaults = array_merge(static::$attributes_defaults,array(
            'type'      => 'selector',
            'values'    => array(),
            'multiple'  => false,
            'name'      => 'property_types_taxonomy',
        ));
    }

    static function parse_options($option){

        return $option;
    }


    static function buildAtts($_atts = array(), $content = null){
        static::set_default_atts();
        $default    = static::$attributes_defaults;
        $atts       = shortcode_atts($default, $_atts);
        self::set_atts($atts);
        $values     = static::get_values();
        self::set_att('values',$values);
    }


    static function gen_options_html(array $options = array()){

        $html = null;

        foreach($options AS $option){
            $val        = $option->val;
            $label      = $option->label;
            $selected   = isset($option->selected ) && $option->selected  ? "selected=\"selected\"" : null;
            $html      .= "<option value=\"{$val}\" {$selected}>{$label}</option>";
        }

        return $html;

    }

    static function gen_placeholder($placeholder){
        return "<option value=\"\">{$placeholder}</option>";
    }

    static function output($atts, $content){
        $values         = self::get_atts('values');
        $vc_id          = self::get_atts('vc_id');
        $name           = sanitize_key(self::get_atts('name'));
        $options_html   = self::gen_options_html($values);
        $label          = self::get_atts('label') ? "<span>".self::get_atts('label')."</span>" : null;
        $placeholder    = self::get_atts('label') ? self::gen_placeholder(self::get_atts('label')) : null;
        $content        = "<label for='select-{$name}'>{$label}<select id='select-{$name}' name='{$name}' class='inmoob-select {$vc_id}'>{$placeholder}{$options_html}</select></label>";
      
        return  parent::output($atts, $content);
    }

}