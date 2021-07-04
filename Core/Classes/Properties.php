<?php
namespace Inmoob\Classes;
use OBSER\Classes\Helpers;

class Properties {

    private $data           = null;
    private $post_type      = 'inmoob_properties';

    function __construct(array $_data = array()){
        $_data      = apply_filters('inmoob_properties', $_data); 
        $model      = \Inmoob\Config\Properties::get_model(); 
        $_data      = array_merge($model,$_data);
        $this->data = Helpers::array_to_object($_data);
    }

    function get_data(){
        return $this->data;
    }

}


