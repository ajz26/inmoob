<?php
namespace Inmoob\WPB_Components\Properties;
use OBSER\Classes\Component;

class Gmap extends Component {

   
    public static function map(): array {
        return array(
            'name'                      => __('Ubicación en el mapa', 'inmoob'),
            'show_settings_on_create'   => false,
            'category'                  => __('Ficha', 'inmoob'),
            'params'                    => array()
        );
    }

}