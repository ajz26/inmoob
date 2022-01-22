<?php
namespace Inmoob\WPB_Components;
use Inmoob\WPB_Components\Swiper;

class Testimonials extends Swiper {


    public static function map(): array {

        $templates  = array();
        $parent     = parent::map();
        $exclude    = array();
        $params     = $parent['params'];

        $params = array_filter($params,function($param){
            if(in_array($param['param_name'],array('not_results_page_block'))){
                return false;
            }
            return true;
        });

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
