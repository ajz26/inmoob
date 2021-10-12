<?php
namespace Inmoob\WPB_Components\Properties;
use OBSER\Classes\Component;
use function OBSER\Config\Grid\params;

class Gallery extends Component {

    public static function map(): array {
        return array(
            'name'                      => __('Galería de propiedad', 'inmoob'),
            'show_settings_on_create'   => true,
            'category'                  => __('Ficha', 'inmoob'),
            'params'                    => array(
                array(                  
                    "type"          => "dropdown",
                    "heading"       => __("Mpdo de visualización", "mx-plugin"),
                    'group'         => __( 'Apariencia', 'mx-plugin' ),
                    "param_name"    => "mode",
                    'save_always'   => true,
                    'value'         => array(
                        'Carrusel'      => 'swiper',
                        'Grid'          => 'grid',
                    )
                ),
                array(                  
                    "type" => "dropdown",
                    "heading"       => __("Mostrar Video en la galería", "mx-plugin"),
                    "param_name"    => "show_video",
                    'group' => __( 'Apariencia', 'mx-plugin' ),
                    'save_always' => true,
                    'value' => array(
                        'Mostrar'   => 1,
                        'Ocultar'   => 0,
                    ),
                    'dependency'            => array(
                        'element'           => 'mode',
                        'value'             => 'swiper',
                    ),
                ),
                array(
                    'type'                  => 'dropdown',
                    'group'                 => __( 'Apariencia', 'ccom' ),
                    'heading'               => esc_html__( 'Mostrar flechas', 'js_composer' ),
                    'param_name'            => 'arrows',
                    'edit_field_class'      => 'vc_col-sm-6',
                    'value'                 => array(
                        esc_html__( 'Mostrar', 'ccom' ) => 'show',
                        esc_html__( 'Ocultar', 'ccom' ) => 'hide',
                    ),
                    'save_always'       => true,
                    'dependency'            => array(
                        'element'           => 'mode',
                        'value'             => 'swiper',
                    ),
                ),
                array(
                    'type'                  => 'dropdown',
                    'group'                 => __( 'Apariencia', 'ccom' ),
                    'heading'               => esc_html__( 'Mostrar Bullets', 'js_composer' ),
                    'param_name'            => 'bullets',
                    'edit_field_class'      => 'vc_col-sm-6',
                    'value'                 => array(
                        esc_html__( 'Mostrar', 'ccom' ) => 'show',
                        esc_html__( 'Ocultar', 'ccom' ) => 'hide',
                    ),
                    'save_always'       => true,
                    'dependency'            => array(
                        'element'           => 'mode',
                        'value'             => 'swiper',
                    ),
                ),
                array(
                    'heading'           => esc_html__('ID', 'ccom' ),
                    'group'             => esc_html__( 'Apariencia', 'ccom' ),
                    'edit_field_class'  => 'vc_col-sm-6',
                    'type'              => 'textfield',
                    'param_name'        => 'el_id',
                ),
                array(
                    'heading'           => esc_html__('Extra Class', 'ccom' ),
                    'group'             => esc_html__( 'Apariencia', 'ccom' ),
                    'edit_field_class'  => 'vc_col-sm-6',
                    'type'              => 'textfield',
                    'param_name'        => 'el_class',
                ),
                array(                  
                    "type"              => "separator",
                    'group'             => __("Opciones Responsive", "mx-plugin"),
                    "edit_field_class"  => "vc_col-xs-12",
                    "param_name"        => "separator",
                ),
                array(                  
                    "type"              => "separator",
                    "heading"           => __("Mostrar por defecto ", "mx-plugin"),
                    'group'             => __("Opciones Responsive", "mx-plugin"),
                    "edit_field_class"  => "vc_col-xs-6",
                    "param_name"        => "separator",
                ),
                array(
                    'heading'           => esc_html__( 'Mostrar', 'ccom' ),
                    'group'             => __("Opciones Responsive", "ccom"),
                    'type'              => 'dropdown',
                    'edit_field_class'  => 'vc_col-xs-6',
                    'param_name'        => 'element_width',
                    'value'             => params('items_per_row'),
                    'std'               => '4',
                    "save_always"       => true,

                ),
                array(                  
                    "type"              => "textfield",
                    "heading"           => __("Por debajo del ancho de la pantalla", "ccom"),
                    'group'             => __("Opciones Responsive", "ccom"),
                    "edit_field_class"  => "vc_col-xs-6",
                    "param_name"        => "mx_responsive_1",
                    "value"             => "1200px",
                    "save_always"       => true,
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
                ),
                array(                  
                    "type"              => "textfield",
                    "heading"           => __("Por debajo del ancho de la pantalla", "ccom"),
                    'group'             => __("Opciones Responsive", "ccom"),
                    "edit_field_class"  => "vc_col-xs-6",
                    "param_name"        => "mx_responsive_2",
                    "value"             => "992px",
                    "save_always"       => true,
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
                ),
                array(                  
                    "type"              => "textfield",
                    "heading"           => __("Por debajo del ancho de la pantalla", "ccom"),
                    'group'             => __("Opciones Responsive", "ccom"),
                    "edit_field_class"  => "vc_col-xs-6",
                    "param_name"        => "mx_responsive_3",
                    "value"             => "768px",
                    "save_always"       => true,
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
                )
            )
        );
    }

}