<?php
namespace Inmoob\WPB_Components;

use OBSER\Classes\Component;
use function OBSER\Config\Grid\params;

class Groupable extends Component {
    
    static $shortcode = "inmoob_grupable";
    static $wpb_namespace = "Inmoob\\WPB_Components";
    
    

    public static function map(): array {
        return array(
            'name'                      => __('Contenido agrupable', 'inmoob'),
            'show_settings_on_create'   => false,
            'icon'                      => INMOOB_CORE_PLUGIN_DIR_URL .'/assets/images/icons/searchform.png',
            'js_view'                   => 'VcColumnView',
            'is_container'              => true,
            'content_element'           => true,
            'params' => array(
                array(                  
                    "type"          => "dropdown",
                    "heading"       => __("Mostrar cómo", "mx-plugin"),
                    'edit_field_class'  => "vc_col-xs-6",
                    "param_name"    => "align",
                    'save_always'   => true,
                    'value'         => array(
                        'Columna' => 'column',
                        'Fila'    => 'row',
                    )
                ),

                array(                  
                    "type"          => "dropdown",
                    "heading"       => __("Justificación del contenido", "mx-plugin"),
                    'edit_field_class'  => "vc_col-xs-6",
                    "param_name"    => "justify",
                    'save_always'   => true,
                    'value'         => array(
                        'space-around'  => 'space-around',
                        'space-between' => 'space-between',
                        'center'        => 'center',
                        'flex-end'      => 'flex-end',
                        'flex-start'    => 'flex-start',
                    )
                ),

                array(                  
                    "type"              => "textfield",
                    "heading"           => __("Id personalizado", "mx-plugin"),
                    "param_name"        => "el_id",
                    'edit_field_class'  => "vc_col-xs-6",
                    'save_always'       => true,
                ),
                array(                  
                    "type"          => "textfield",
                    "heading"       => __("Clase css personalizada", "mx-plugin"),
                    "param_name"    => "el_class",
                    'edit_field_class'  => "vc_col-xs-6",
                    'save_always'   => true,
                ),

                array(
                    'group'             => __("Opciones Responsive", "ccom"),
                    'heading'           => esc_html__( 'Espacio lateral entre elementos', 'ccom' ),
                    'type'              => 'textfield',
                    'param_name'        => 'items_gap',
                    'save_always'       => true,
                    'edit_field_class'  => 'vc_col-sm-6',
                    'std'               => '10',
                    'dependency'            => array(
                        'element'           => 'align',
                        'value'             => 'row',
                    ),
                ),

             
                array(
                    'heading'           => esc_html__( 'Mostrar por defecto', 'ccom' ),
                    'group'             => __("Opciones Responsive", "ccom"),
                    'type'              => 'dropdown',
                    'edit_field_class'  => 'vc_col-xs-6',
                    'param_name'        => 'element_width',
                    'value'             => params('items_per_row'),
                    'std'               => '4',
                    "save_always"       => true,
                    'dependency'            => array(
                        'element'           => 'align',
                        'value'             => 'row',
                    ),
                ),

                array(                  
                    "type"              => "textfield",
                    "heading"           => __("Por debajo del ancho de la pantalla", "ccom"),
                    'group'             => __("Opciones Responsive", "ccom"),
                    "edit_field_class"  => "vc_col-xs-6",
                    "param_name"        => "mx_responsive_1",
                    "value"             => "1200px",
                    "save_always"       => true,
                    'dependency'            => array(
                        'element'           => 'align',
                        'value'             => 'row',
                    ),
                ),
                array(
                    'heading'           => esc_html__( 'Mostrar', 'ccom' ),
                    'group'             => __("Opciones Responsive", "ccom"),
                    'type'              => 'dropdown',
                    'edit_field_class'  => 'vc_col-xs-6',
                    'param_name'        => 'mx_responsive_val_1',
                    'value'             => params('items_per_row'),
                    'std'               => '3',
                    "save_always"       => true,
                    'dependency'            => array(
                        'element'           => 'align',
                        'value'             => 'row',
                    ),
                ),
                array(                  
                    "type"              => "textfield",
                    "heading"           => __("Por debajo del ancho de la pantalla", "ccom"),
                    'group'             => __("Opciones Responsive", "ccom"),
                    "edit_field_class"  => "vc_col-xs-6",
                    "param_name"        => "mx_responsive_2",
                    "value"             => "992px",
                    "save_always"       => true,
                    'dependency'            => array(
                        'element'           => 'align',
                        'value'             => 'row',
                    ),
                ),
                array(
                    'heading'           => esc_html__( 'Mostrar', 'ccom' ),
                    'group'             => __("Opciones Responsive", "ccom"),
                    'type'              => 'dropdown',
                    'edit_field_class'  => 'vc_col-xs-6',
                    'param_name'        => 'mx_responsive_val_2',
                    'value'             => params('items_per_row'),
                    'std'               => '2',
                    "save_always"       => true,
                    'dependency'            => array(
                        'element'           => 'align',
                        'value'             => 'row',
                    ),
                ),
                array(                  
                    "type"              => "textfield",
                    "heading"           => __("Por debajo del ancho de la pantalla", "ccom"),
                    'group'             => __("Opciones Responsive", "ccom"),
                    "edit_field_class"  => "vc_col-xs-6",
                    "param_name"        => "mx_responsive_3",
                    "value"             => "768px",
                    "save_always"       => true,
                    'dependency'            => array(
                        'element'           => 'align',
                        'value'             => 'row',
                    ),
                ),
                array(
                    'heading'           => esc_html__( 'Mostrar', 'ccom' ),
                    'group'             => __("Opciones Responsive", "ccom"),
                    'type'              => 'dropdown',
                    'edit_field_class'  => 'vc_col-xs-6',
                    'param_name'        => 'mx_responsive_val_3',
                    'value'             => params('items_per_row'),
                    'std'               => '1',
                    "save_always"       => true,
                    'dependency'            => array(
                        'element'           => 'align',
                        'value'             => 'row',
                    ),
                ),
            )
        );
    }
}