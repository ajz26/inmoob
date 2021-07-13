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
            'params' => array(
                array(                  
                    "type"              => "textfield",
                    "heading"           => __("Texto para la home", "mx-plugin"),
                    "param_name"        => "home_text",
                    'edit_field_class'  => "vc_col-xs-6",
                    'save_always'       => true,
                ),
            )
        );
    }
}