<?php namespace Inmoob\Shortcodes\Properties;
use OBSER\Classes\Settings;
class Gmap extends Shortcode{

    static $shortcode       = "inmoob_gmap_frame";

    public static function generate_css(){

    }

    public static function output($atts, $content){

        global $post;

        $geo_lat    = get_post_meta($post->ID,'geo_lat',true);
        $geo_lng    = get_post_meta($post->ID,'geo_lng',true);
        $gmap       = get_post_meta($post->ID,'gmaps_link',true);
        $key        = Settings::get_setting('inmoob-settings','embed_gmap_api_key');

        if(!$gmap && $key && $geo_lat && $geo_lng){
            $url        = "https://www.google.com/maps/embed/v1/streetview?key={$key}&location={$geo_lat},{$geo_lng}";
            $gmap       = "<iframe src='$url' width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>";
        }


        $regex = '/^[\s]*(?:<iframe[^>]*)(?:(?:\/>)|(?:>.*?<\/iframe>))[\s]*$/';
        preg_match_all($regex,  $gmap , $matches, PREG_SET_ORDER, 0);
        
        if(count($matches) <= 0) return; 

        $gmap     = preg_replace('/(?:width="(\d*)")/m', 'width="100%"', $gmap);
        $content  = "<div class='gmap'>".$gmap."</div>";

        return $gmap;
    }

}