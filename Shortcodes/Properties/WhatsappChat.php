<?php

namespace Inmoob\Shortcodes\Properties;

use OBSER\Classes\Helpers;
use OBSER\Classes\Settings;

class WhatsappChat extends Shortcode {

    static $shortcode   = "inmoob_whatsapp_link";

    public static function generate_css(){}


    public static function general_styles(){
        return "
        
        .inmoob-Whatsapp-cta {
            width: 100%;
            /* max-width: 120px; */
            display: block;
            background-color: #3ad775;
            padding: 1rem;
            border-radius: 2rem;
            text-align: center;
            color: #fff;
            font-weight: bold;
            box-shadow: 0 1px 6px rgba(0, 0, 0, .06), 0 2px 20px rgba(0, 0, 0, .16);
            cursor: pointer;
            user-select: none;
            width: -moz-max-content;    /* Firefox/Gecko */
            width: -webkit-max-content; /* Chrome */
            width: max-content;
            transition: all .3s;
            opacity: .7;

        }

        .inmoob-Whatsapp-cta.w-100 {
            width: 100%;
        }

        .inmoob-Whatsapp-cta:hover {
            box-shadow:0 2px 8px rgba(0, 0, 0, .09), 0 4px 20px rgba(0, 0, 0, .24);
            opacity: 1;
        }
        
        
        ";
    }


    static function generate_link(){
        $query = [];
        
        $query['phone']  = Settings::get_setting('inmoob-settings','business_whatsapp') ?: null;
        $query['text']   = override_inmoob_data(self::get_atts('message',null)); 

        if(!$query['phone']) return null;
        $link = "https://api.whatsapp.com/send";

        return esc_url( add_query_arg($query ,  $link));
    }

    public static function output($atts, $content){

        $vc_id = self::get_atts('vc_id');
        $el_id = self::get_atts('el_id');
        $el_class = self::get_atts('el_class');

        $link = self::generate_link();

        $content = "<a id='{$el_id}' class='inmoob-Whatsapp-cta {$el_class}' href='{$link}' target='_blank'> <i class='inmoob inmoob-whatsapp'></i> <span>Whatsapp</span></a>";
        return $content;
    }

}
 