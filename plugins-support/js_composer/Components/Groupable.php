<?php
namespace Inmoob\WPB_Components;

use OBSER\Classes\Component;

class Groupable extends Component {
    
    static $shortcode = "inmoob_grupable";
    static $wpb_namespace = "Inmoob\\WPB_Components";


    public static function map(): array {
        return array(
            'name'                      => __('Contenido agrupable', 'inmoob'),
            'show_settings_on_create'   => false,
            'icon'                      => INMOOB_CORE_PLUGIN_DIR_URL .'/assets/images/icons/searchform.png',
            'js_view'                   => 'VcColumnView',
            'is_container'              => true,
            'content_element'           => true,
            'params' => array(
                array(                  
                    "type"          => "dropdown",
                    "heading"       => __("Mostrar cómo", "mx-plugin"),
                    "param_name"    => "align",
                    'save_always'   => true,
                    'value'         => array(
                        'Columna' => 'column',
                        'Fila'    => 'row',
                    )
                ),
            )
        );
    }
}