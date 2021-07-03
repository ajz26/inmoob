<?php
namespace Inmoob\WPB_Components;

use OBSER\Classes\Component;

class Breadcrumbs extends Component {
    
    static $wpb_namespace   = "Inmoob\\WPB_Components";
    
    public static function map(): array {
        return array(
            'name'                      => __('Migas de pan', 'inmoob'),
            'show_settings_on_create'   => false,
            'icon'                      => INMOOB_CORE_PLUGIN_DIR_URL .'/assets/images/icons/searchform.png',
        );
    }
}