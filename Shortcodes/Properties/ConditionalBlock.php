<?php namespace Inmoob\Shortcodes\Properties;

class ConditionalBlock extends Shortcode{

    static $shortcode       = "inmoob_conditional_block";
   
    public static function generate_css(){

    }

    public static function general_styles(){
    }

    public static function output($atts,$content){
        global $post;
        $show               = true;
        $el_id              = self::get_atts('el_id',null);
        $el_class           = self::get_atts('el_class',null);
        $meta_field         = self::get_atts('meta_field',null);
        $meta_field         = trim($meta_field);
        $meta_field         = explode(",",$meta_field);
        $count_fields       = count($meta_field);
        $count_values       = 0;
        $conditional        = self::get_atts('conditional',null);
        $custom_value       = self::get_atts('custom_value',null);

        if($conditional == 'ever'){
            return null;
        }

        
        for($i = 0; $i < $count_fields; $i++){
            $field  = $meta_field[$i];
            $value  = get_post_meta($post->ID,$field,true);



            switch(true){
                case (!isset($value) || empty($value)) :
                case (empty($value)) :
                case (is_null($value)) :
                case ($conditional == 'like' && $value == $custom_value) :
                break;
                case (isset($value) && !empty($value)) :
                    $count_values++;
                break;
            }
        }


        if($count_values == 0){
            $show = false; 
        }


        if(!$show ){
            return null;
        }

        $content            = do_shortcode($content);

        if(!isset($content) || empty($content)){
            return null;
        }

        return "<div id='{$el_id}' class='{$el_class} inmoob-requirements-list'>{$content}</div>";
    }

} 