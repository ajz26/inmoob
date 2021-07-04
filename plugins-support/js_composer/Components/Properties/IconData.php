<?php
namespace Inmoob\WPB_Components\Properties;
use OBSER\Classes\Component;

class IconData extends Component {

    public static function map(): array {
        return array(
            'name'                      => __('Icon Data', 'inmoob'),
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
                    "type"      => "textfield",
                    "heading"   => __("Icon", "mx-plugin"),
                    "param_name" => "icon",
                ),
                array(                  
                    "type"          => "dropdown",
                    "heading"       => __("Valor", "mx-plugin"),
                    "param_name"    => "value",
                    "admin_label"   => true,
                    "save_always"   => true,
                    "value"       => array(
                        'Tipo de propiedad' => 'property_types_taxonomy' ,
                        'Habitaciones'      => 'property_rooms_taxonomy' ,
                        'Baños'             => 'property_bathrooms_taxonomy',
                        'Tamaño'            => 'property_size',
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