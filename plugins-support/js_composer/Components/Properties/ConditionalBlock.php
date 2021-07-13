<?php
namespace Inmoob\WPB_Components\Properties;
use OBSER\Classes\Component;

class ConditionalBlock extends Component {

   
    public static function map(): array {
        return array(
            'name'                      => __('Bloque condicional', 'inmoob'),
            'icon'                      => INMOOB_CORE_PLUGIN_DIR_URL .'/assets/images/icons/searchform.png',
            'js_view'                   => 'VcColumnView',
            'is_container'              => true,
            'content_element'           => true,
            'category'                  => __('Ficha', 'inmoob'),
            'params'                    => array(
                array(                  
                    "type"              => "textfield",
                    "heading"           => __("campo a verificar", "mx-plugin"),
                    "param_name"        => "meta_field",
                    'edit_field_class'  => "vc_col-xs-12",
                ),
                array(                  
                    "type"              => "dropdown",
                    "heading"           => __("Ocultar campo si:", "mx-plugin"),
                    "param_name"        => "conditional",
                    'edit_field_class'  => "vc_col-xs-12",
                    'value'             => array(
                        'Nunca'                     => 'never',
                        'Siempre'                   => 'ever',
                        'No existe'                 => 'null',
                        'Está vacio'                => 'empty',
                        'Está vacio o no existe'    => 'isset_and_null',
                        'Igual a'                   => 'like',
                    )
                ),
                array(                  
                    "type"              => "textfield",
                    "heading"           => __("campo a verificar", "mx-plugin"),
                    "param_name"        => "custom_value",
                    'edit_field_class'  => "vc_col-xs-12",
                    "dependency" => array(
                        "element" => "conditional",
                        "value"     => "like"
                    )
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