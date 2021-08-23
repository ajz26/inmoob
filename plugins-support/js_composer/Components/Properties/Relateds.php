<?php
namespace Inmoob\WPB_Components\Properties;

use Inmoob\WPB_Components\Swiper;

class Relateds extends Swiper {


    public static function map(): array {

        $templates  = array();
        $parent     = parent::map();
        $exclude    = array();
        $params     = $parent['params'];

        return array(
            'name'      => "Swiper de Inmuebles relacionados",
            'icon'      =>  INMOOB_CORE_PLUGIN_DIR_URL ."/assets/images/icons/grid.png",
            'params'    =>  $params             
        );
        
    }

}
