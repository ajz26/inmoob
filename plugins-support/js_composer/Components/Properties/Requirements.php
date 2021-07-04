<?php
namespace Inmoob\WPB_Components\Properties;
use OBSER\Classes\Component;

class Requirements extends Component {

   
    public static function map(): array {
        return array(
            'name'                      => __('Bloque de requisitos', 'inmoob'),
            'show_settings_on_create'   => false,
            'category'                  => __('Ficha', 'inmoob'),
            'params'                    => array(
                array(                  
                    "type"              => "textfield",
                    "heading"           => __("Texto para: documentación flexible", "mx-plugin"),
                    "param_name"        => "no_docs_text",
                    'edit_field_class'  => "vc_col-xs-12",
                ),
                array(                  
                    "type"          => "textfield",
                    "heading"       => __("Id personalizado", "mx-plugin"),
                    "param_name"    => "el_id",
                    'edit_field_class'  => "vc_col-xs-6",
                    'save_always'   => true,
                ),
                array(                  
                    "type"          => "textfield",
                    "heading"       => __("Clase css personalizada", "mx-plugin"),
                    "param_name"    => "el_class",
                    'edit_field_class'  => "vc_col-xs-6",
                    'save_always'   => true,
                ),
            )
        );
    }

}