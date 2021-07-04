<?php namespace Inmoob\Shortcodes\Properties;

class PriceBlock extends Shortcode{

    static $shortcode = 'inmoob_price_block';

    public static function generate_css(){
        
    }

    public static function output($atts, $content){
        global $post;
        
        $sales_price    = get_post_meta($post->ID,'sales_price',true);
        $price_prefix   = get_post_meta($post->ID,'price_prefix',true)?: self::get_atts('price_prefix',null);
        $price_sufix    = get_post_meta($post->ID,'price_sufix',true)?: self::get_atts('price_sufix',null);
        $price          = get_post_meta($post->ID,'price',true);

        $el_id = self::get_atts('el_id',null);
        $el_class = self::get_atts('el_class',null);
        if((isset($sales_price) && !empty($sales_price)) &&  $sales_price < $price){
            $value = "<span class='price'>{$price_prefix} {$sales_price} {$price_sufix}</span> <span class='old_price'> Antes {$price} </span>";
        }else{
            $value = "<span class='price'>{$price_prefix} {$price} {$price_sufix}</span>";
        }
        
        return "<div id='{$el_id}' class='{$el_class} inmoob-price-block'>$value</div>";
    }

}