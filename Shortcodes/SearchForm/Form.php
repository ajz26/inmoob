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

            .inmmoob-searchform {
                width: 100%;
            }

            .inmmoob-searchform label{
                display: block;
            }
            .inmmoob-searchform label + label {
                margin-top: 1rem;
            }

            .inmmoob-searchform label > select, label input{
                    margin-top : 1rem;
            }

            .contenedor-obser-grid.loading > .obser-custom-grid-items {
                opacity: .6;
            }
            .obser-custom-preloader {
                position: fixed;
                left: 0;
                right: 0;
                width: 100%;
                background-color: rgb(255,255,255,.25);
                z-index: 100000;
                text-align: center;
                top: 0;
                boto: 0;
                bottom: 0;
            }


            .groupable-container.row {
                flex-direction: row !important;
                justify-content: space-between;
            }

            .groupable-container.row.cols-2 > * {
                width: 47%;
                flex: 0 0 47%;
            }

            .groupable-container.row.cols-2 > * > .label {
                font-size: .75rem !important;
                padding: .5rem .5rem;
            }


            .groupable-container.row > label + label {
                margin: 0 !important;
            }
            
            .obser-custom-preloader > * {
                position: relative;
                top: 50%;
            }
            
            .preloader-text {
                font-size: 1.5rem;
                padding: 0;
                display: block;
                padding: 10px;
            }

            .field-list > .inmoob-select {
                max-height: 250px;
                overflow-y: auto;
            }
            

            .toggle-cta {
                width: 100%;
                padding: 1rem;
                border-radius: 1.3rem;
                font-size: 1.2rem;
                font-weight: bold;
            }


            @media(min-width:769px){
                .toggle-cta{
                    display:none;
                }   
            }
            @media(max-width:768px){

                .inmmoob-searchform > div:last-child {
                    margin-bottom: 3rem;
                }
                
                .inmmoob-searchform {
                    padding: .5rem 1rem;
                }

                .inmoob-content-sform {
                    position: fixed;
                    bottom: 0;
                    left: 5%;
                    right: 5%;
                    bottom: 2%;
                    z-index: 100000;
                    display: flex;
                    flex-direction: column;
                    flex-wrap: wrap;
                }

                .content-form {
                    background-color: #ffffff;
                    left: 0;
                    right: 0 !important;
                    margin: 0 auto;
                    width: 100%;
                    padding: .5rem;
                    margin-bottom: 1rem;
                    box-shadow: 0px 4px 8px rgba(0,0,0,.18);
                    border-radius: .5rem;
                    overflow: hidden;
                    overflow-y: scroll;
                    height: 80vh;
                }
                
               
            
                .inmoob-content-sform .content-form:not(.active) {
                    display:none;
                }
                
                .toggle-cta {
                    display: block;
                    order: 2;
                    box-shadow: 0px 4px 8px rgba(0,0,0,.18);
                    bottom: 1rem;
                    position: relative;
                }

                .toggle-cta.active + .content-form {
                    display: flex;
                }
                

                .toggle-cta.active {
                    background-color: var(--color-content-secondary) !important;
                    color: #ffffff;
                    font-weight: bold;
                    box-shadow: 0px 4px 8px rgba(0,0,0,.18);
                }

            }

            

            ";
        return $inlinestyles;

    }

    static function output($atts, $content){

        $vc_grid        = self::get_atts('vc_grid');
        $vc_id          = self::get_atts('vc_id');
        $uniqid         = self::get_atts('searchform_uniqid');
        $customclass    = self::get_atts('searchform_customclass');
        $toggle_text    = self::get_atts('toggle_text');
        $content        = do_shortcode($content);
        $output         =  "<div class='{$vc_id} inmoob-content-sform {$vc_id} {$uniqid} {$customclass}'>
                            <button class='toggle-cta'><i class=\"far fa-filter\"></i> <span class='toggle-text'>{$toggle_text}</span></button>
                            <div class='content-form'>
                            <form class='inmmoob-searchform' data-grid='{$vc_grid}' autocomplete='off'>
                                {$content}
                            </form>
                            </div>
                            </div>";
        return $output;

    }
    
}