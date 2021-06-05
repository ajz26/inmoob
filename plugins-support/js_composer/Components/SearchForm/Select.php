<?php
namespace Inmoob\WPB_Components\SearchForm;

abstract class Select extends Field {    

    public static function map(): array {
        $parent     = parent::map();
        $map        =  array_merge($parent,array(
            'name'                      => __('Select de Categorías', 'ccom'),
            'icon'                      => INMOOB_CORE_PLUGIN_DIR_URL .'/assets/images/icons/searchform-select.png',
            'show_settings_on_create'   => false,
        ));

        $map['params'] = array_merge($map['params'], array(
                array(                  
                    'type'              => 'dropdown',
                    'heading'           => __('Tipo de campo', 'ccom'),
                    'edit_field_class'  => "vc_col-xs-12",
                    'param_name'        => 'type',
                    'group'             => __( 'Apariencia', 'ccom' ),
                    'value'             => array(
                                            'Selector'  => 'selector',
                                            'Lista'     => 'list',
                    )
                ),
                array(                  
                    "type"          => "checkbox",
                    'group'         => __( 'Apariencia', 'ccom' ),
                    "heading"       => __("Habilitar selección múltiple", "mx-plugin"),
                    "param_name"    => "multiple",
                    'value'         => array( ''   => 'true')
                )
            )
        );
        return $map;

    }

}