<?php

namespace Inmoob\Shortcodes;

use OBSER\Classes\Shortcode;

class Groupable extends Shortcode {
    
    static $shortcode = "inmoob_grupable";
    static $wpb_namespace = "Inmoob\\WPB_Components";


    static function generate_css(){
        
    }

    static function general_styles(){
        
        $styles = "
        .groupable-container {
            display: flex;
            box-sizing: border-box;
            width: 100%;
            clear: both;
            flex-direction: column;
            flex-wrap: wrap;
        }

        .groupable-container.row {
            flex-direction: row !important;
        }

        .groupable-container > div {
            flex: 0 0 auto;
            width: auto;
        }

        ";

        return $styles;
    }


    static function output($atts, $content){
        $vc_id          = self::get_atts('vc_id');
        $uniqid         = self::get_atts('el_id');
        $customclass    = self::get_atts('el_class');
        $align          = self::get_atts('align','column');
        $content        = do_shortcode($content);
        $output         =  "<div id='$vc_id' class='groupable-container {$align} {$vc_id} {$uniqid} {$customclass}'>
                                {$content}
                            </div>";
        return $output;
    }
}