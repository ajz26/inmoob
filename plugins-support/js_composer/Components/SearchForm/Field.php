<?php
namespace CCOM_CORE\Components\SearchForm;
use  CCOM_CORE\Components\Component;
class Field extends Component {

    public static function map(): array {
        
        return array(
            'name'                      => __('', 'ccom'),
            'show_settings_on_create'   => false,
            'icon'                      => CCOM_CORE_PLUGIN_DIR_URL .'/framework/assets/images/wpb_icons/input.png',
            'params'                    => array(
                array(                  
                    "type" => "textfield",
                    "heading" => __("Label", "mx-plugin"),
                    "param_name" => "label",
                    "admin_label" => true,
                ),
    
                array(                  
                    "type" => "checkbox",
                    "heading" => __("Utilizar placeholder personalizado", "mx-plugin"),
                    "param_name" => "custom_placeholder",
                    'value' => array(
                        ''   => 'true',
                    )
                ),
                array(                  
                    "type" => "textfield",
                    "heading" => __("Placeholder personalizado", "mx-plugin"),
                    "param_name" => "placeholder",
                    "dependency" => array(
                        "element" => "custom_placeholder",
                        "value" => "true"
                    )
                ),
                array(                  
                    "type" => "dropdown",
                    "heading" => __("Mostrar siempre", "mx-plugin"),
                    "param_name" => "hidden_when_not_options_avaliables",
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