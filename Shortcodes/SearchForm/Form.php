<?php
namespace Inmoob\Shortcodes\SearchForm;

use OBSER\Classes\Helpers;
use OBSER\Classes\Shortcode;

class Form extends Shortcode  {

    static $shortcode           = "inmoob_sf";
    static $wpb_namespace       = "Inmoob\\WPB_Components\\SearchForm";
    static $ajax_action         = null;

    public static function after_register(){

        $shortcode      = static::$shortcode;
        $class          = \get_called_class();
        $ajax_action    = self::$ajax_action = "handler_{$shortcode}_submit";
        add_action("admin_post_nopriv_{$ajax_action}", array($class, 'handler_post_submit'));
        add_action("admin_post_{$ajax_action}", array($class, 'handler_post_submit'));
        add_action('pre_get_posts', array($class, 'parse_query_vars'));

    }


    static function handler_post_submit(){

        $gestion_types_taxonomy = null !== sanitize_title($_POST['gestion_types_taxonomy']) ? sanitize_title($_POST['gestion_types_taxonomy']) : null ;
        $url    =   home_url('');

        if(!$gestion_types_taxonomy){
           return wp_safe_redirect($url);

        }


        $term   = get_term_by( 'slug', $gestion_types_taxonomy, 'gestion_types_taxonomy');
        $url    = get_term_link($term,'gestion_types_taxonomy');

        $meta   = $_POST;

        if(isset($meta['action'])){
            unset($meta['action']);
        }

        $meta = array_filter($meta, function($val){
            return ($val != '' && $val != '-') ? true : false;
        });


        $redirect    = add_query_arg( $meta ,$url);

        $url_data = wp_parse_url( $redirect );


        $path = $url_data['path'];

        setcookie('wordpress_inmoob_search', 'buscando', time()+1209600, $path , $url, true);

        wp_safe_redirect($redirect);

        exit;

    }



    static function parse_query_vars( $wp_query ) {

        if(!isset($_GET['post_search']) || empty($_GET['post_search'])){
            return ;
        }
        
        $wp_query->set('post_search', true);
            
        foreach($_GET AS $param => $value){

            if(in_array($value,array('-',''))) continue;

            if($wp_query->get('post_type') == 'inmoob_properties'){
                $wp_query->set($param, $value);
            }
        }

      }

    static function generate_css(){

        $vc_id  = self::get_atts('vc_id');
        $mode   = self::get_atts('view_mode','block');
        $style  = null;


        if($mode == 'modal'){

            $style .= "
            @media(min-width:769px){
                .inmoob-content-sform.$vc_id .toggle-cta{
                    display:none;
                }   
            }
            @media(max-width:768px){

                .inmoob-content-sform.$vc_id .inmmoob-searchform > div:last-child {
                    margin-bottom: 3rem;
                }
                
                .inmoob-content-sform.$vc_id .inmmoob-searchform {
                    padding: .5rem 1rem;
                }

                .inmoob-content-sform.$vc_id {
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

                .inmoob-content-sform.$vc_id  .content-form {
                    background-color: #ffffff;
                    margin: 0px auto;
                    width: 100%;
                    padding-bottom: 2rem;
                    height: 60vh;
                    bottom: 0 !important;
                    position: absolute;
                    padding-top: 2rem;
                    border-radius: 2rem 2rem 0 0;
                    left: 0;
                    right: 0;
                }
                
                .inmoob-content-sform.$vc_id  .content-form:not(.active) {
                    display:none;
                }
                
                .inmoob-content-sform.$vc_id  .toggle-cta {
                    display: block;
                    order: 2;
                    box-shadow: 0px 4px 8px rgba(0,0,0,.18);
                    bottom: 1rem;
                    position: relative;
                }

                .inmoob-content-sform.$vc_id  .toggle-cta.active + .content-form {
                    display: flex;
                }
                

                .inmoob-content-sform.$vc_id  .toggle-cta.active {
                    background-color: var(--color-content-secondary) !important;
                    color: #ffffff;
                    font-weight: bold;
                    box-shadow: 0px 4px 8px rgba(0,0,0,.18);
                }
            }
            ";

        }   


        return $style;


    }


    static function general_styles(){


        $inlinestyles = "

            .inmoob-content-sform .inmmoob-searchform {
                width: 100%;
            }

            .inmmoob-searchform > * + * {
                margin-top: 1rem !important;
            }

            .inmoob-content-sform .groupable-container.row {
                flex-direction: row !important;
                justify-content: space-between;
            }
            
            
            
            .inmoob-content-sform .toggle-cta {
                width: 100%;
                padding: 1rem;
                border-radius: 1.3rem;
                font-size: 1.2rem;
                font-weight: bold;
            }

            .inmoob-content-sform.modal-active {
                position: fixed;
                left: 0;
                r0: ;
                r0: ;
                right: 0;
                display: flex;
                justify-content: end;
                padding: 2rem;
                background-color: rgba(0,0,0,.22);
                bottom: 0;
                top: 0;
            }
            
            ";
            
        return $inlinestyles;

    }

    static function output($atts, $content){


        if(isset($_COOKIE['inmoob_props_search'])){
            var_dump($_COOKIE['inmoob_props_search']);
        }

        $button = $before_html  = $params = $input_defaults = null;


        $vc_grid        = self::get_atts('vc_grid');
        $vc_id          = self::get_atts('vc_id');
        $uniqid         = self::get_atts('searchform_uniqid');
        $customclass    = self::get_atts('searchform_customclass');
        $toggle_text    = self::get_atts('toggle_text','Filtrar');
        $view_mode      = self::get_atts('view_mode','block');
        $cta_text       = self::get_atts('cta_text');

        $method         = self::get_atts('method','POST');
        $ajax_action    = self::$ajax_action;

        if($method == 'POST'){

            $params             = Helpers::array_to_attr(array(
                'method' => 'POST',
                'action' => admin_url( 'admin-post.php' ),
            ));

            $input_defaults    .="<input name='action' value='{$ajax_action}' type='hidden'>";
            $input_defaults    .="<input name='post_search' value='1' type='hidden'>";

            if($gestion_types   = get_query_var('gestion_types_taxonomy') ?: (get_query_var('gestion_type') ?: null)){
                $input_defaults .="<input name='gestion_types_taxonomy' value='{$gestion_types}' type='hidden'>";
            }

            $button = "<button type='submit'><i class='fas fa-search-location'></i> {$cta_text}</button>";
        }

        if($view_mode == 'modal'){
            $before_html .=  "<button class='toggle-cta'><i class=\"far fa-filter\"></i> <span class='toggle-text'>{$toggle_text}</span></button>";
        }

        
        $content        = \do_shortcode($content);

        $output         =  "<div class='{$vc_id} inmoob-content-sform {$vc_id} {$uniqid} {$customclass}'>
                                {$before_html}
                                <div class='content-form'>
                                    <form class='inmmoob-searchform' {$params} data-grid='{$vc_grid}' autocomplete='off'>
                                        {$input_defaults}
                                        {$content}
                                        {$button} 
                                    </form>
                                </div>
                            </div>";

        return $output;

    }
    
} 