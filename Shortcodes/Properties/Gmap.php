<?php namespace Inmoob\Shortcodes\Properties;

class Gmap extends Shortcode{

    static $shortcode       = "inmoob_gmap_frame";

    public static function generate_css(){

    }

    public static function output($atts, $content){

        global $post;

        if($gmap = get_post_meta($post->ID,'gmaps_link',true)){


            $regex = '/^[\s]*(?:<iframe[^>]*)(?:(?:\/>)|(?:>.*?<\/iframe>))[\s]*$/';
            preg_match_all($regex,  $gmap , $matches, PREG_SET_ORDER, 0);
            if(count($matches) <= 0) return; 
            $gmap     = preg_replace('/(?:width="(\d*)")/m', 'width="100%"', $gmap);
            $content .= "<div class='gmap'>".$gmap."</div>";
        }


        return $content;
    }

}