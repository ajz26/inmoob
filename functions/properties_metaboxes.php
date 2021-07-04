<?php

add_filter( 'rwmb_meta_boxes',function ($meta_boxes){

    $meta_boxes[] = array(
        'title'         => 'Detalles del Inmueble',
        'post_types'    => 'inmoob_properties',
        'tabs'          => Inmoob\Config\Properties::get_tabs(),
        'tab_style'     => 'left',
        'tab_wrapper'   => true,
        'fields'        => \Inmoob\Config\Properties::get_fields(),
    );  
    return $meta_boxes;
    
});





