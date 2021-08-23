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
                    'param_name'        => 'method',
                    'save_always'       => true,
                    'value'             => array(
                        'POST'     => 'POST',
                        'Ajax'     => 'Ajax',
                    )
                ),
                array(                  
                    'type'          => 'textfield',
                    'heading'       => __('ID de grid asociado', 'inmoob'),
                    'param_name'    => 'vc_grid',
                    "dependency" => array(
                        "element"   => "method",
                        "value"     => "Ajax"
                    ) 
                ),
                array(                  
                    'type'              => 'textfield',
                    'heading'           => __('Texto del botón', 'inmoob'),
                    'param_name'        => 'cta_text',
                    'save_always'       => true,
                    'edit_field_class'  => 'vc_col-sm-12',
                    'group'             => __( 'Apariencia', 'ccom' ),
                    "dependency"        => array(
                        "element"   => "method",
                        "value"     => "POST"
                    ) 
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
                    'type'              => 'textfield',
                    'heading'           => __('Texto para desplegable', 'inmoob'),
                    'param_name'        => 'toggle_text',
                    'group'             => __( 'Apariencia', 'ccom' ),
                    'edit_field_class'  => 'vc_col-sm-6',        
                    'save_always'       => true,
                    "dependency" => array(
                        "element"   => "view_mode",
                        "value"     => "modal"
                    ) 
                ),

               

                array(                  
                    'type'          => 'textfield',
                    'heading'       => __('ID del formulario', 'inmoob'),
                    'param_name'    => 'el_id',
                    'save_always'   => true,
                    'edit_field_class'  => 'vc_col-sm-6',        
                    'group'             => __( 'Apariencia', 'ccom' ),
                ),
                array(                  
                    'type'          => 'textfield',
                    'heading'       => __('Clases css personalizada', 'inmoob'),
                    'param_name'    => 'el_class',
                    'edit_field_class'  => 'vc_col-sm-6',        
                    'save_always'   => true,
                    'group'             => __( 'Apariencia', 'ccom' ),

                ),
                
            )
        );

    }

} 