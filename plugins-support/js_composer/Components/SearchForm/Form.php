<?php
namespace Inmoob\Components\SearchForm;
use OBSER\Classes\Component;
    
return;
class Form extends Component {
  
    public static function map(): array {
        
        return array(
            'name'                      => __('Buscador', 'ccom'),
            'show_settings_on_create'   => false,
            // 'icon'                      => INMOOB_CORE_PLUGIN_DIR_URL .'/framework/assets/images/wpb_icons/form.png',
            'js_view'                   => 'VcColumnView',
            'is_container'              => true,
            'content_element'           => true,
            'params'                    => array(
                array(                  
                    'type'          => 'textfield',
                    'heading'       => __('ID de grid Asociado', 'ccom'),
                    'param_name'    => 'vc_grid',
                ),
                array(                  
                    'type'          => 'textfield',
                    'heading'       => __('Identificador del formulario', 'ccom'),
                    'param_name'    => 'searchform_uniqid',
                    'save_always'   => true,
                    'std'           => "ccom_uniqid_".uniqid()
                ),
                array(                  
                    'type'          => 'textfield',
                    'heading'       => __('Clase personalizada', 'ccom'),
                    'param_name'    => 'searchform_customclass',
                    'save_always'   => true
                )
            )
        );

    }

} 