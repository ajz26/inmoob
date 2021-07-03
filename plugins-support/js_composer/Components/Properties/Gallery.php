<?php
namespace Inmoob\WPB_Components\Properties;
use OBSER\Classes\Component;

class Gallery extends Component {

    public static function map(): array {
        return array(
            'name'                      => __('Gallery', 'inmoob'),
            'show_settings_on_create'   => true,
            'category'                  => __('Ficha', 'inmoob'),
            'params'                    => array(
                array(                  
                    "type" => "textfield",
                    "heading" => __("Label", "mx-plugin"),
                    "param_name" => "label",
                    "admin_label" => true,
                ),
                array(                  
                    "type" => "textfield",
                    "heading" => __("Placeholder", "mx-plugin"),
                    "param_name" => "placeholder",
                ),
                array(                  
                    "type" => "dropdown",
                    "heading" => __("Mostrar siempre", "mx-plugin"),
                    "param_name" => "hidden_if",
                    'group' => __( 'Apariencia', 'mx-plugin' ),
                    'value' => array(
                        'Mostrar siempre'   => 0,
                        'Ocultar si no hay opciones disponibles'   => 1,
                    )
                ),
            )
        );
    }

}