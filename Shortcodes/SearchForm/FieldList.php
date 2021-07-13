<?php

namespace Inmoob\Shortcodes\SearchForm;
abstract class FieldList extends Select {

   

    static function gen_options_html($options = array()){

        $options = (array)$options;

        $html = null;
        $name       = sanitize_key(self::get_atts('name'));

        foreach($options AS $option){

            $val        = $option->val;
            $label      = $option->label;

            $selected   = isset($option->selected ) && $option->selected  ? "checked=\"checked\"" : null;
            $type       = self::get_atts('multiple',false) ? 'checkbox' : 'radio'; 
            $html      .= "<label for=\"opt-{$name}-{$val}\"><input type=\"{$type}\" name=\"$name\" value=\"{$val}\" id=\"opt-{$name}-{$val}\" {$selected}>{$label}</label>";
        }

        return $html;
 
    }

    static function gen_placeholder($placeholder){
        return "<label value=\"\">{$placeholder}</label>";
    }

    static function output($atts, $content){
        $values         = self::get_atts('values');


        $vc_id          = self::get_atts('vc_id');
        $type           = self::get_atts('type');
        $name           = sanitize_key(self::get_atts('name'));
        $options_html   = self::gen_options_html($values);
        $show           = self::get_atts('opened',0) == '1' ? 'show' : null;


        $label          = self::get_atts('label') ? "<span class='label {$show}'>".self::get_atts('label')." <i class=\"far \"></i></span>" : null;
        $content        = "<label for='select-{$name}' class='field-{$type}'>{$label}<div id='select-{$name}' name='{$name}' class='inmoob-select {$vc_id}'>{$options_html}</div></label>";
      
        return  Field::output($atts, $content);
    }

}