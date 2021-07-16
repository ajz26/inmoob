<?php namespace Inmoob\Shortcodes\Properties;
use OBSER\Classes\Settings;
class Address extends Shortcode{

    static $shortcode       = "inmoob_prop_address";

    public static function generate_css(){

    }

    public static function output($atts, $content){

        global $post;
        $el_id = self::get_atts('el_id');
        $el_class = self::get_atts('el_class');

        $city       = get_post_meta($post->ID,'city',true);
        $zip_code   = get_post_meta($post->ID,'zip_code',true);
        $address    = get_post_meta($post->ID,'address',true);
        
        if($city){
            $content .= "<div class='city-container'><b>Ciudad:</b> {$city}</div>";
        }
        if($address){
            $content .= "<div class='address-container'><b>Dirección:</b> {$address}</div>";
        }
        if($zip_code){
            $content .= "<div class='zipcode-container'><b>Código Postal:</b> {$zip_code}</div>";
        }

        return (isset($content) && !empty($content)) ? "<div id='{$el_id}' class='{$el_class} el--{$el_id} address-container'>{$content}</div>" : null;
    }

}