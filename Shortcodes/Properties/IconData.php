<?php namespace Inmoob\Shortcodes\Properties;

class IconData extends Shortcode{

    static $shortcode       = "inmoob_icon_data";

    public static function generate_css(){

    }

    public static function general_styles()
    {
        return "
        
        .inmoob-icon-box {
            display: flex;
        }
        ";
    }


    public static function get_val(){
        global $post;

        $field      = self::get_atts('value',null);
        $value      = null;
        switch($field){
            case 'property_types_taxonomy' :
            case 'property_rooms_taxonomy' :
            case 'property_bathrooms_taxonomy' :
               $terms =  get_the_terms($post->ID,$field);
               if(!$terms) return null;
                $i = 0;
               foreach($terms AS $term){
                   $value .= ($i >= 1) ? ' ,'. $term->name : $term->name;
                   $i ++;
               }
            break;
            default:
                $value = get_post_meta($post->ID,$field,true);
            break;
        }

        if($field == 'property_size') $value .= ' m²';


        return $value;

    }

    public static function output($atts,$content){

        $label      = self::get_atts('label',null);
        $icon       = self::get_atts('icon',null);

        $el_id      = self::get_atts('el_id',null);
        $el_class       = self::get_atts('el_class',null);
        $value      = self::get_val();
        if($icon && !empty($icon)){
            $icon = "<div class='icon'><i class='{$icon}'></i></div>";
        }

        if($label && !empty($label)){
            $label = "<div class='label'>{$label}</div>";
        }

        if($value && !empty($value)){
            $value = "<div class='value'>{$value}</div>";
        }

        $content = "<div id='{$el_id}' class='{$el_class} inmoob-icon-box'>{$icon}{$label}{$value}</div>";


        return $content;
    }

}