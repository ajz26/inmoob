<?php
namespace Inmoob\WPB_Components;
use OBSER\WPB_Components\_Grid;

class Testimonials extends SearchGrid {


    public static function map(): array {

        $templates  = array();
        $parent     = parent::map();
        $exclude    = array();
        $params     = $parent['params'];

        $params     = array_map(function($param){
            if($param['param_name'] == 'post_type'){
                $param['type']          = 'hidden';
                $param['value']         = 'inmoob_testimonials';
                $param['admin_label']   = false;
            }

            return $param;
        },$params);

        return array(
            'name'      => "Swiper de testimoniales",
            'icon'      =>  INMOOB_CORE_PLUGIN_DIR_URL ."/assets/images/icons/grid.png",
            'params'    =>  $params             
        );
        
    }

}
