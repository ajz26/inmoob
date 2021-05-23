<?php
use OBSER\Classes\Metabox\Metabox;

new Metabox(
   array(
    'ID'        =>'prices',
    'title'     =>  'Detalles de servicio',
    'post_types' => 'inmoob_properties',
    'tabs'      => array(
        'type'  => array(
            'label' => 'Tipo',
            'icon'  => 'dashicons-admin-settings',
        ),
        'features'  => array(
            'label' => 'Caracterísiticas',
            'icon'  => 'dashicons-admin-settings',
        ),
        'requirements'  => array(
            'label' => 'Requisitos',
            'icon'  => 'dashicons-admin-settings',
        ),
        'media' => array(
            'label' => 'Medios',
            'icon'  => 'dashicons-images-alt2', 
        ),
        'prices'  => array(
            'label' => 'Precio',
            'icon'  => 'dashicons-money-alt',
        ),
        'location' => array(
            'label' => 'Ubicación',
            'icon'  => 'dashicons-admin-site-alt', 
        )
    ),
    'fields' => array(
        array(
            'tab'           => 'features',
            'title'         => 'Tamaño del inmueble en m2',
            'name'          => 'property_size',
            'placeholder'   => 'Tamaño en m2',
        ),
    )
    )
);