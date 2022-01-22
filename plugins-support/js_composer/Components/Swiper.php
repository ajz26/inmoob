<?php
namespace Inmoob\WPB_Components;
use OBSER\WPB_Components\_Grid;

class Swiper extends SearchGrid {


    public static function map(): array {

        $templates  = array();
        $parent     = parent::map();
        $exclude    = array();
        $params     = $parent['params'];

        $params     = array_map(function($param){
            if($param['param_name'] == 'post_type'){
                $param['type']          = 'hidden';
                $param['value']         = 'inmoob_properties';
                $param['admin_label']   = false;
            }

            return $param;
        },$params);

        $params = array_filter($params,function($param){
            if(in_array($param['param_name'],array('_gid','loader_text','show_pagination','items_per_row','posts_per_page'))){
                return false;
            }
            return true;
        });

        $params[] = array(
            'type'                  => 'dropdown',
            'group'                 => __( 'Apariencia', 'ccom' ),
            'heading'               => esc_html__( 'Mostrar flechas', 'js_composer' ),
            'param_name'            => 'arrows',
            'edit_field_class'      => 'vc_col-sm-6',
            'value'                 => array(
                esc_html__( 'Mostrar', 'ccom' ) => 'show',
                esc_html__( 'Ocultar', 'ccom' ) => 'hide',
            ),
            'save_always'       => true
        );

        $params[] = array(
            'type'                  => 'dropdown',
            'group'                 => __( 'Apariencia', 'ccom' ),
            'heading'               => esc_html__( 'Mostrar Bullets', 'js_composer' ),
            'param_name'            => 'bullets',
            'edit_field_class'      => 'vc_col-sm-6',
            'value'                 => array(
                esc_html__( 'Mostrar', 'ccom' ) => 'show',
                esc_html__( 'Ocultar', 'ccom' ) => 'hide',
            ),
            'save_always'       => true
        );

        return array(
            'name'      => "Swiper de inmuebles",
            'icon'      =>  INMOOB_CORE_PLUGIN_DIR_URL ."/assets/images/icons/grid.png",
            'params'    =>  $params             
        );
        
    }

}
