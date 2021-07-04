<?php
namespace Inmoob\WPB_Components\Properties;
use OBSER\Classes\Component;

class Gallery extends Component {

    public static function map(): array {
        return array(
            'name'                      => __('Galería de propiedad', 'inmoob'),
            'show_settings_on_create'   => true,
            'category'                  => __('Ficha', 'inmoob'),
            'params'                    => array(
                array(                  
                    "type" => "dropdown",
                    "heading"       => __("Mostrar Video en la galería", "mx-plugin"),
                    "param_name"    => "show_video",
                    'group' => __( 'Apariencia', 'mx-plugin' ),
                    'value' => array(
                        'Mostrar'   => 1,
                        'Ocultar'   => 0,
                    )
                ),
            )
        );
    }

}