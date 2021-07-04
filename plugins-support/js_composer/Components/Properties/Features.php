<?php
namespace Inmoob\WPB_Components\Properties;
use OBSER\Classes\Component;

class Features extends Component {

    static $options = array(
        'Referencia'                    => 'property_ref',
        'Tamaño'                        => 'property_size',
        'Tamaño util'                   => 'util_property_size',
        'Planta'                        => 'property_floor',
        'Año de construcción'           => 'property_construction_year',
        'Habitaciones'                  => 'property_rooms_taxonomy',
        'Baños'                         => 'property_bathrooms_taxonomy',
        'Certificado'                   => 'property_eacs',
        'Acepta Mascotas'               => 'pets',
        'Acepta niños'                  => 'childrens',
        'Tiene Terraza'                 => 'terrace',
        'Tiene Ascensor'                => 'ascensor',
        'Extras'                        => 'extras'
    );

    public static function map(): array {
        return array(
            'name'                      => __('Bloque de características', 'inmoob'),
            'show_settings_on_create'   => true,
            'category'                  => __('Ficha', 'inmoob'),
            'params'                    => array(
                array(                  
                    "type"          => "checkbox",
                    "heading"       => __("Mostrar:", "mx-plugin"),
                    "param_name"    => "fields",
                    "admin_label"   => true,
                    "save_always"   => true,
                    "value"       => self::$options
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