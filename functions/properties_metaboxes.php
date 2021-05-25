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
            'label' => 'Precios',
            'icon'  => 'dashicons-money-alt',
        ),
        'location' => array(
            'label' => 'Ubicación',
            'icon'  => 'dashicons-admin-site-alt', 
        )
    ),
    'fields' => array(


        array(
            'tab'           => 'type',
            'id'            => 'cloneable',
            'name'          => 'Cloneable',
            'type'          => 'text',
            'add_button'    => 'Añadir otroa',
            'clone'         => true,
        ),
        

        array(
            'tab'        => 'type',
            'name'       => 'Tipo de gestión',
            'id'         => 'gestion_types',
            'type'       => 'taxonomy',
            'taxonomy'   => 'gestion_types',
            'field_type' => 'select',
            'placeholder' => 'Elige una opción',
            'columns'    => 2

        ),

        array(
            'tab'        => 'type',
            'name'       => 'estado de gestión',
            'id'         => 'gestion_states',
            'type'       => 'taxonomy',
            'taxonomy'   => 'gestion_states',
            'field_type' => 'select',
            'placeholder' => 'Elige una opción',
            'columns'    => 2

        ),

        array(
            'tab'       => 'type',
            'id'        => 'featured',
            'name'      => 'Destacar propiedad',
            'type'      => 'switch',                    
            'style'     => 'rounded',
            'on_label'  => 'Si',
            'off_label' => 'No',
        ),

        // Features

        array(
            'tab'        => 'features',
            'name'       => 'Tipo de inmueble',
            'id'         => 'property_types',
            'type'       => 'taxonomy',
            'taxonomy'   => 'property_types',
            'field_type' => 'select',
            'placeholder' => 'Elige una opción',
            'columns'    => 3

        ),

        array(
            'tab'        => 'features',
            'name'       => 'Estado de la propiedad',
            'id'         => 'property_state',
            'type'       => 'taxonomy',
            'taxonomy'   => 'property_state',
            'field_type' => 'select',
            'placeholder' => 'Elige una opción',
            'columns'    => 3
        ),

        array(
            'tab'        => 'features',
            'name'       => 'Tamaño del inmueble en m2',
            'id'         => 'property_size',
            'type'       => 'text',
            'placeholder' => 'Indíca el tamaño',
            'columns'    => 3
        ),
        
        array(
            'tab'       => 'features',
            'type'      => 'divider',
            'columns'   => 12,
        ),
        

        array(
            'tab'        => 'features',
            'name'       => 'Nº de Habitaciones',
            'id'         => 'property_rooms',
            'type'       => 'taxonomy',
            'taxonomy'   => 'property_rooms',
            'field_type' => 'select',
            'placeholder' => 'Elige una opción',
            'columns'    => 3

        ),
        array(
            'tab'        => 'features',
            'name'       => 'Nº de baños',
            'id'         => 'property_bathrooms',
            'type'       => 'taxonomy',
            'taxonomy'   => 'property_bathrooms',
            'field_type' => 'select',
            'placeholder' => 'Elige una opción',
            'columns'    => 3

        ),

        array(
            'tab'        => 'features',
            'name'       => 'Nº de planta',
            'id'         => 'property_floor',
            'type'       => 'text',
            'taxonomy'   => 'property_floor',
            'placeholder' => 'Elige una opción',
            'default'       => '1',
            'columns'    => 3
        ),

        array(
            'tab'        => 'features',
            'type' => 'divider',
            'columns' => 12,
        ),
        
        array(
            'tab'       => 'features',
            'id'        => 'pets',
            'name'      => 'Permiten mascotas',
            'type'      => 'switch',                    
            'style'     => 'rounded',
            'on_label'  => 'Si',
            'off_label' => 'No',
            'columns'    => 2
        ),
        array(
            'tab'       => 'features',
            'id'        => 'childrens',
            'name'      => 'Permiten niños',
            'type'      => 'switch',                    
            'style'     => 'rounded',
            'on_label'  => 'Si',
            'off_label' => 'No',
            'columns'    => 2
        ),

        array(
            'tab'       => 'features',
            'id'        => 'terrace',
            'name'      => 'Tiene terraza',
            'type'      => 'switch',                    
            'style'     => 'rounded',
            'on_label'  => 'Si',
            'off_label' => 'No',
            'columns'    => 2
        ),

        array(
            'tab'       => 'features',
            'id'        => 'ascensor',
            'name'      => 'Tiene Ascensor',
            'type'      => 'switch',                    
            'style'     => 'rounded',
            'on_label'  => 'Si',
            'off_label' => 'No',
            'columns'    => 2
        ),

        array(
            'tab'        => 'features',
            'type' => 'divider',
            'columns' => 12,
        ),
        
        
        array(
            'tab'           => 'features',
            'id'            => 'extras',
            'name'          => 'Extras',
            'type'          => 'textarea',
            'add_button'    => 'Añadir otro',
            'clone'         => true,
        ),
        
        // Prices

      
        array(
            'tab'           => 'prices',
            'name'          => 'Precio',
            'id'            => 'price',
            'placeholder'   => 'Precio del inmueble',
            'std'           => 'a consultar',
        ),
        array(
            'tab'           => 'prices',
            'name'          => 'Mostrar antes del precio',
            'id'            => 'price_preffix',
            'placeholder'   => 'Prefijo',

        ),
        array(
            'tab'           => 'prices',
            'name'          => 'Mostrar despues del precio',
            'id'            => 'price_suffix',
            'placeholder'   => 'Sufijo',

        ),

        array(
            'tab'        => 'location',
            'name'       => 'Zona',
            'id'         => 'property_zones',
            'type'       => 'taxonomy',
            'taxonomy'   => 'property_zones',
            'field_type' => 'select_advanced',
            'placeholder' => 'Elige una opción',
        ),
        array(
            'tab'  => 'location',
            'name' => 'Dirección',
            'id'   => 'address',
            'type' => 'textarea',
        ),
        array(
            'tab'  => 'location',
            'name' => 'Link de google maps',
            'id'   => 'gmaps_link',
            'type' => 'textarea',
            'rows' => 2,
            'columns' => 12
        ),

    )
    )
);