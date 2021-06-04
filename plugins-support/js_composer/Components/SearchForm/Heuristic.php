<?php
namespace CCOM_CORE\Components\SearchForm;
use  CCOM_CORE\Components\Component;

class Heuristic extends Component {

    public static function map(): array {
        return array(
            'name'                      => __('Heuristico', 'ccom'),
            'show_settings_on_create'   => false,
            'icon'                      => CCOM_CORE_PLUGIN_DIR_URL .'/framework/assets/images/wpb_icons/input.png',
            'params'                    => array(
                array(                  
                    'type'          => 'textfield',
                    'heading'       => __('Placeholder', 'ccom'),
                    'param_name'    => 'placeholder',
                ),
            )
        );

    }

}