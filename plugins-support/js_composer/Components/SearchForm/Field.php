<?php
namespace Inmoob\WPB_Components\SearchForm;
use OBSER\Classes\Component;
use Inmoob\Shortcodes\SearchForm\Form;

class Field extends Component {

    public static function map(): array {
        $form_shortcode = Form::$shortcode;
        return array(
            'name'                      => __('', 'inmoob'),
            'show_settings_on_create'   => false,
            "as_child"                  => array('only' => $form_shortcode.',inmoob_grupable'),
            'category'                  => __('Buscador Inmoob', 'inmoob'),
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