<?php
namespace Inmoob\WPB_Components\SearchForm;
use OBSER\Classes\Component;


// $e = new \Exception();

// var_dump($e->getTraceAsString());


class Form extends Component {
  
    public static function map(): array {
        
        return array(
            'name'                      => __('Buscador', 'inmoob'),
            'category'                  => __('Buscador Inmoob', 'inmoob'),
            'show_settings_on_create'   => false,
            'icon'                      => INMOOB_CORE_PLUGIN_DIR_URL .'/assets/images/icons/searchform.png',
            'js_view'                   => 'VcColumnView',
            'is_container'              => true,
            'content_element'           => true,
            'params'                    => array(
                array(                  
                    'type'              => 'dropdown',
                    'heading'           => __('Tipo de busqueda', 'ccom'),
                    'edit_field_class'  => "vc_col-xs-12",
                    'param_name'        => 'mode',
                    'save_always'       => true,
                    'value'             => array(
                        'POST'     => 'POST',
                        'Ajax'     => 'Ajax',
                    )
                ),
                array(                  
                    'type'          => 'textfield',
                    'heading'       => __('Identificador del formulario', 'inmoob'),
                    'param_name'    => 'el_id',
                    'save_always'   => true,
                    'edit_field_class'  => 'vc_col-sm-6',        
                ),
                array(                  
                    'type'          => 'textfield',
                    'heading'       => __('Clase personalizada', 'inmoob'),
                    'param_name'    => 'el_class',
                    'edit_field_class'  => 'vc_col-sm-6',        
                    'save_always'   => true
                ),
                array(                  
                    'type'              => 'dropdown',
                    'heading'           => __('Mostrar como', 'ccom'),
                    'edit_field_class'  => "vc_col-xs-12",
                    'param_name'        => 'view_mode',
                    'group'             => __( 'Apariencia', 'ccom' ),
                    'save_always'       => true,
                    'value'             => array(
                        'Bloque'    => 'block',
                        'Modal'     => 'modal',
                    )
                ),
                array(                  
                    'type'          => 'textfield',
                    'group'             => __( 'Grid', 'ccom' ),
                    'heading'       => __('ID de grid Asociado', 'inmoob'),
                    'param_name'    => 'vc_grid',
                ),
            )
        );

    }

} 