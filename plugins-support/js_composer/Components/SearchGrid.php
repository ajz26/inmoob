<?php
namespace Inmoob\WPB_Components;
use OBSER\WPB_Components\_Grid;

class SearchGrid extends _Grid {


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

        $params[]   = array(
            'heading'           => esc_html__( 'ID para buscador', 'tilo' ),
            'group'             => __("Buscador", "tilo"),
            'type'              => 'textfield',
            'param_name'        => '_gid',
            'save_always'       => true,
            'admin_label'       => true,
            'edit_field_class'  => 'vc_col-sm-12',
        );

        return array(
            'name'      => "Listado de inmuebles",
            'icon'      =>  INMOOB_CORE_PLUGIN_DIR_URL ."/assets/images/icons/grid.png",
            'params'    =>  $params             
        );
        
    }

}
