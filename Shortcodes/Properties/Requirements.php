<?php namespace Inmoob\Shortcodes\Properties;

class Requirements extends Shortcode{

    static $shortcode       = "inmoob_requirements_list";
   
    public static function generate_css(){

    }

    public static function general_styles(){
    }

    public static function output($atts,$content){
        global $post;

        $el_id           = self::get_atts('el_id',null);
        $el_class        = self::get_atts('el_class',null);
        $no_docs_text    = self::get_atts('no_docs_text',__('¿Aún no tienes documentación? Contáctanos para saber mas sobre cómo alquilar esta propiedad.','Inmoob'));
        $html       = $preffix = null;
        $metas      = get_post_meta($post->ID,'requirements',true);
        $no_docs    = get_post_meta($post->ID,'no_docs',true);
        
        // var_dump($requirements);
        if($no_docs){
            $preffix = "<div class='no-docs-info'> <i class='fas fa-check'></i> {$no_docs_text} </div>";
        }
        if(!$metas) return null;
            
        foreach($metas AS $meta){
            $key    = sanitize_key($meta);
            $html  .= "<li id='$key' class='$key'>{$meta}</li>";
        }

        return "<div id='{$el_id}' class='{$el_class} inmoob-requirements-list'>{$preffix} <ul>$html</ul></div>";
    }

} 