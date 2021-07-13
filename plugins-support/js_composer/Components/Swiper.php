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

        return array(
            'name'      => "Swiper de inmuebles",
            'icon'      =>  INMOOB_CORE_PLUGIN_DIR_URL ."/assets/images/icons/grid.png",
            'params'    =>  $params             
        );
        
    }

}
