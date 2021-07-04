<?php
namespace Inmoob\WPB_Components\Properties;
use OBSER\Classes\Component;

class PriceBlock extends Component {

   

    public static function map(): array {
        return array(
            'name'                      => __('Bloque de precios', 'inmoob'),
            'show_settings_on_create'   => true,
            'category'                  => __('Ficha', 'inmoob'),
            'params'                    => array(
                array(                  
                    "type"          => "textfield",
                    "heading"       => __("Texto antes del precio", "mx-plugin"),
                    "param_name"    => "price_prefix",
                    'edit_field_class'  => "vc_col-xs-6",
                    'save_always'   => true,
                ),
                array(                  
                    "type"          => "textfield",
                    "heading"       => __("Texto despues del precio", "mx-plugin"),
                    "param_name"    => "price_sufix",
                    'edit_field_class'  => "vc_col-xs-6",
                    'save_always'   => true,
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