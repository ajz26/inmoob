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

    static function general_styles()
    {
        return "

        .inmmoob-searchform * + * {
            margin-top: 1rem !important;
        }

        .field-list > div {
            padding: 0 .5rem;
        }

        .field-list > span {
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #cccccc;
            padding: .5rem 1rem;
            border-radius: .5rem;
        }
        
        .inmmoob-searchform label > span {
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .inmmoob-searchform label > span + div {
            margin-top: 1rem;
        }
        
        span.label:not(.show) + .inmoob-select {
            display: none !important;
        }

        .label i {
            float: right;
        }

        .label.show > i::before {
            content: '\\f106';
        }

        .label:not(.show) > i::before {
            content: '\\f107';
        }


        ";
    }

    static function gen_options_html($options = array()){

        $options = (array)$options;

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
        $type = self::get_atts('type');


        $opt_def = new \stdClass();
        $opt_def->val = '-';
        $opt_def->label = __('Todas','Inmoob');
        $vals[] = $opt_def;
        $vals = (count(self::get_atts('values',array())) > 1 ) ?  array_merge($vals,self::get_atts('values',array())) : array();

        self::set_att('values',$vals);


        if($type == 'list'){
            $atts = self::get_atts();
            FieldList::set_atts($atts);
            $atts = FieldList::get_atts();
            return FieldList::output($atts,$content);
        }

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