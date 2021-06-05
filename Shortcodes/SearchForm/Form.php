<?php
namespace Inmoob\Shortcodes\SearchForm;

use OBSER\Classes\Shortcode;

class Form extends Shortcode  {

    static $shortcode           = "inmoob_sf";
    static $wpb_namespace       = "Inmoob\\WPB_Components\\SearchForm";

    static function generate_css(){

        //$element_id     = self::get_atts('vc_id');
        $uniqid         = self::get_atts('searchform_uniqid');
        $inlinestyles   = '';
        // $color_main     = ColorSchemes::get_color_by_scheme('sch01','main');
        // $color_alter    = ColorSchemes::get_color_by_scheme('sch01','alter');

        // $inlinestyles .= "
        // .{$uniqid} .caja-lista--item input + label .caja-lista--item--txt { color: {$color_main}!important; }
        // .{$uniqid} .caja-lista--item__selector input + label .caja-lista--item--txt:before { background-color: {$color_main}!important; }
        // .{$uniqid} .caja-lista--item input:checked + label .caja-lista--item--txt { color: {$color_alter}!important; }
        // .{$uniqid} .caja-lista--item__selector input:checked + label .caja-lista--item--txt:before { background-color: {$color_alter}!important; }
        // ";
        return $inlinestyles;

    }


    static function general_styles(){

        //$element_id     = self::get_atts('vc_id');
        $uniqid         = self::get_atts('searchform_uniqid');
        $inlinestyles   = '';
        // $color_main     = ColorSchemes::get_color_by_scheme('sch01','main');
        // $color_alter    = ColorSchemes::get_color_by_scheme('sch01','alter');

            $inlinestyles .= "
            .inmmoob-searchform label{
                display: block;
            }
            .inmmoob-searchform label + label {
                margin-top: 1rem;
            }

            .inmmoob-searchform label > select, label input{
                    margin-top : 1rem;
            }
            ";
        return $inlinestyles;

    }

    static function output($atts, $content){

        $vc_grid        = self::get_atts('vc_grid');
        $vc_id          = self::get_atts('vc_id');
        $uniqid         = self::get_atts('searchform_uniqid');
        $customclass    = self::get_atts('searchform_customclass');
        $content        = do_shortcode($content);
        $output         =  "<form id='$vc_id' class='inmmoob-searchform {$vc_id} {$uniqid} {$customclass}' data-grid='{$vc_grid}' autocomplete='off'>
                                {$content}
                            </form>";
        return $output;

    }
    
}