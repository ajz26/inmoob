<?php
namespace CCOM_CORE\Components\SearchForm;
class Categories extends Select {

    public static function map(): array {
        $map = array_merge((array)parent::map(),array(
            'name'                      => __('Categorías', 'ccom'),
            'show_settings_on_create'   => false,
            'icon'                      => CCOM_CORE_PLUGIN_DIR_URL .'/framework/assets/images/wpb_icons/input.png',
        ));
        $map['params'][] = array(                  
            "type" => "checkbox",
            "heading" => __("Habilitar selección múltiple", "mx-plugin"),
            "param_name" => "multiple",
            'value' => array( ''   => 'true')
        );
        return $map;
    }

}