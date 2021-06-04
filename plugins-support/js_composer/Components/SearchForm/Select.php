<?php
namespace CCOM_CORE\Components\SearchForm;

abstract class Select extends Field {    

    public static function map(): array {
        $parent     = parent::map();
        $map        =  array_merge($parent,array(
            'name'                      => __('Select de Categorías', 'ccom'),
            'show_settings_on_create'   => false,
            'icon'                      => CCOM_CORE_PLUGIN_DIR_URL .'/framework/assets/images/wpb_icons/input.png',
        ));

        $map['params'] = array_merge($map['params'], array(
                array(                  
                    'type'              => 'dropdown',
                    'heading'           => __('Tipo de campo', 'ccom'),
                    'edit_field_class'  => "vc_col-xs-4",
                    'param_name'        => 'type',
                    'group'             => __( 'Apariencia', 'ccom' ),
                    'value'             => array(
                                            'Selector'  => 'selector',
                                            'Lista'     => 'list',
                    )
                ),
                array(
                    'group'             => __( 'Apariencia', 'ccom' ),
                    'heading'           => __('Selector plegable', 'ccom'),
                    'type'              => 'checkbox',
                    'edit_field_class'  => "vc_col-xs-4",
                    'param_name'        => 'collapsible',
                    'value'             => array( ''   => 'true'),
                    'std'               => 'true',
                    'dependency'        => array(
                                            'element'   => 'type',
                                            'value'     => array('selector')
                    )
                ),
                array(
                    'group'             => __( 'Apariencia', 'ccom' ),
                    'heading'           => __('Inicialmente plegado', 'ccom'),
                    'type'              => 'checkbox',
                    'edit_field_class'  => "vc_col-xs-4",
                    'param_name'        => 'collapsed',
                    'value'             => array( ''   => 'true'),
                    'std'               => 'true',
                    'dependency'        => array(
                                            'element'   => 'collapsible',
                                            'value'     => 'true'
                    )
                )
            )
        );

        return $map;

    }

}