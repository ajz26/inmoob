<?php
namespace Inmoob\WPB_Components;

use OBSER\Classes\Component;

class LeadsPropsForm extends Component {


    public static function map(): array {
        return array(
            'name'      => "Leads Props Form",
            'icon'      =>  INMOOB_CORE_PLUGIN_DIR_URL ."/assets/images/icons/grid.png",
            'params'    => array(
                array(                  
                    "type"              => "textarea",
                    "heading"           => __("Información legal", "mx-plugin"),
                    'edit_field_class'  => "vc_col-xs-12",
                    "param_name"        => "info_legal",
                ),
                array(                  
                    "type"              => "textarea",
                    "heading"           => __("Check legal", "mx-plugin"),
                    'edit_field_class'  => "vc_col-xs-12",
                    "param_name"        => "check_legal",
                ),
                array(                  
                    "type"              => "vc_link",
                    "heading"           => __("Redireccionar", "mx-plugin"),
                    'edit_field_class'  => "vc_col-xs-12",
                    "param_name"        => "redirect",
                ),
            )
        );
        
    }

}
