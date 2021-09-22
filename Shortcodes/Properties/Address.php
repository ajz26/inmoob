<?php namespace Inmoob\Shortcodes\Properties;
use OBSER\Classes\Settings;
class Address extends Shortcode{

    static $shortcode       = "inmoob_prop_address";

    public static function generate_css(){

    }

    public static function general_styles()
    {
        return ".address-block-container {
            margin-bottom: 2rem;
        }";
    }

    protected static function get_zone($post){

        $terms =  get_the_terms($post->ID,'property_zones_taxonomy');

        if(!$terms) return null;
        $i = 0;

        $zones = null;

        $zones = array_column($terms, 'name');


        $zones = implode(', ', $zones);

        // foreach($terms AS $term){
        //     $zones .= ($i >= 1) ? ' ,'. $term->name : $term->name;
        //     $i ++;
        // }

        return $zones;
    }

    public static function output($atts, $content){

        global $post;
        $vc_id      = self::get_atts('vc_id');
        $el_id      = self::get_atts('el_id',$vc_id);
        $el_class   = self::get_atts('el_class');

        $city       = get_post_meta($post->ID,'city',true);
        $zone       = self::get_zone($post);
        $zip_code   = get_post_meta($post->ID,'zip_code',true);
        $address    = get_post_meta($post->ID,'address',true);
        
        
        if($zone){
            $content .= "<div class='zone-container'><b>Zona:</b> {$zone}</div>";
        }
        
        if($city){
            $content .= "<div class='city-container'><b>Ciudad:</b> {$city}</div>";
        }

        if($address){
            $content .= "<div class='address-container'><b>Dirección:</b> {$address}</div>";
        }
        if($zip_code){
            $content .= "<div class='zipcode-container'><b>Código Postal:</b> {$zip_code}</div>";
        }

        return (isset($content) && !empty($content)) ? "<div id='{$el_id}' class='{$el_class} el--{$el_id} {$vc_id} address-block-container'>{$content}</div>" : null;
    }

}