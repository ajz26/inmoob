<?php
use OBSER\Classes\Settings;
$currency =  Settings::get_setting('inmoob-settings','currency_symbol') ?: '$';



add_filter( 'rwmb_meta_boxes',function ($meta_boxes) use($currency){


    $meta_boxes[] = array(
        'title'     => 'Detalles del Inmueble',
        'post_types' => 'inmoob_properties',
        'tabs'      => array(
            'general'  => array(
                'label' => 'General',
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

        'tab_style' => 'left',
        'tab_wrapper' => true,
        'fields'    => array(

           

            array(
                'tab'        => 'general',
                'name'    => 'Descripción',
                'id'      => 'content',
                'type'    => 'wysiwyg',
                'columns'   => 12,
                'raw'     => false,
                'options' => array(
                    'textarea_rows' => 10,
                    'wpautop'       => false,
                    'media_buttons' => false,
                    'teeny'         => true,
                    'quicktags'     => false,
                    
                ),
            ),

            array(
                'tab'        => 'general',
                'name'    => 'Descripción corta',
                'id'      => 'short_description',
                'type'    => 'textarea',
                'columns'   => 12,
                
            ),
            
            array(
                'tab'       => 'general',
                'type'      => 'divider',
                'columns'   => 12,
            ),
            array(
                'tab'        => 'general',
                'name'       => 'Referencia',
                'id'         => 'property_ref',
                'type'       => 'text',
                'placeholder' => '#ref',
                'columns'     => 3
            ),
            array(
                'tab'        => 'general',
                'name'       => 'Tipo de gestión',
                'id'         => 'gestion_types_taxonomy',
                'type'       => 'taxonomy',
                'taxonomy'   => 'gestion_types_taxonomy',
                'field_type' => 'select',
                'placeholder' => 'Elige una opción',
                'columns'    => 3

            ),

            array(
                'tab'        => 'general',
                'name'       => 'Estado de gestión',
                'id'         => 'gestion_states_taxonomy',
                'type'       => 'taxonomy',
                'taxonomy'   => 'gestion_states_taxonomy',
                'field_type' => 'select',
                'placeholder' => 'Elige una opción',
                'columns'    => 3
            ),

            array(
                'tab'       => 'general',
                'id'        => 'featured',
                'name'      => 'Destacar propiedad',
                'type'      => 'switch',                    
                'style'     => 'rounded',
                'on_label'  => 'Si',
                'off_label' => 'No',
                'columns'    => 3
            ),

            // Features

            array(
                'tab'        => 'features',
                'name'       => 'Tipo de inmueble',
                'id'         => 'property_types',
                'type'       => 'taxonomy',
                'taxonomy'   => 'property_types_taxonomy',
                'field_type' => 'select',
                'placeholder' => 'Elige una opción',
                'columns'    => 3

            ),

            array(
                'tab'        => 'features',
                'name'       => 'Estado de la propiedad',
                'id'         => 'property_state_taxonomy',
                'type'       => 'taxonomy',
                'taxonomy'   => 'property_state_taxonomy',
                'field_type' => 'select',
                'placeholder' => 'Elige una opción',
                'columns'    => 3
            ),

            array(
                'tab'        => 'features',
                'name'       => 'Superficie en m2',
                'id'         => 'property_size',
                'type'       => 'text',
                'placeholder' => 'Indíca el tamaño',
                'columns'    => 3
            ),

            array(
                'tab'        => 'features',
                'name'       => 'Superficie útil en m2',
                'id'         => 'util_property_size',
                'type'       => 'text',
                'placeholder' => 'Indíca el tamaño',
                'columns'    => 3
            ),

            array(
                'tab'           => 'features',
                'type'          => 'divider',
                'columns'       => 12,
            ),
            
            array(
                'tab'        => 'features',
                'name'       => 'Año de contstrucción',
                'id'         => 'property_construction_year',
                'type'       => 'text',
                'columns'    => 3

            ),

            array(
                'tab'        => 'features',
                'name'       => 'Nº de Habitaciones',
                'id'         => 'property_rooms_taxonomy',
                'type'       => 'taxonomy',
                'taxonomy'   => 'property_rooms_taxonomy',
                'field_type' => 'select',
                'placeholder' => 'Elige una opción',
                'columns'    => 3

            ),
            array(
                'tab'        => 'features',
                'name'       => 'Nº de baños',
                'id'         => 'property_bathrooms_taxonomy',
                'type'       => 'taxonomy',
                'taxonomy'   => 'property_bathrooms_taxonomy',
                'field_type' => 'select',
                'placeholder' => 'Elige una opción',
                'columns'    => 3

            ),

            array(
                'tab'        => 'features',
                'name'       => 'Planta',
                'id'         => 'property_floor_taxonomy',
                'type'       => 'text',
                'taxonomy'   => 'property_floor_taxonomy',
                'std'        => '1',
                'columns'    => 3
            ),

            array(
                'tab'        => 'features',
                'type' => 'divider',
                'columns' => 12,
            ),
            
            array(
                'tab'        => 'features',
                'name'       => 'Certificado energético',
                'id'         => 'property_eacs',
                'type'       => 'select',
                'field_type' => 'select',
                'options'    => inmoob_get_recs(),
                'placeholder' => 'Elige una opción',
                'columns'    => 3
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
                'type'          => 'text',
                'size'          => 1000,
                'add_button'    => 'Añadir extra',
                'clone' => true,
            ),
            
            // Prices

            array(
                'tab'  => 'prices',
                'name' => 'Valor',
                'id'   => 'price',
                'type' => 'text',
                'columns' => 4,
            ),

            array(
                'tab'  => 'prices',
                'name' => "Valor en ({$currency}) con descuento",
                'id'   => 'sales_price',
                'type' => 'text',
                'before' => '',
                'columns' => 4,
            ),

            
            array(
                'tab'  => 'prices',
                'name' => 'Mostrar antes del valor',
                'id'   => 'price_preffix',
                'type' => 'text',
                'columns' => 4,
            ),
            array(
                'tab'  => 'prices',
                'name' => 'Mostrar despues del valor',
                'id'   => 'price_suffix',
                'type' => 'text',
                'columns' => 4,
            ),

            array(
                'tab'  => 'prices',
                'id'        => 'on_sale',
                'name'      => 'Mostrar como oferta',
                'type'      => 'switch',                    
                'style'     => 'rounded',
                'on_label'  => 'Si',
                'off_label' => 'No',
            ),

            // requirements

            array(
                'tab'       => 'requirements',
                'id'        => 'no_docs',
                'name'      => '¿ Se puede alquilar si documentación ?',
                'type'      => 'switch',                    
                'style'     => 'rounded',
                'on_label'  => 'Si',
                'off_label' => 'No',
            ),
            array(
                'tab'       => 'requirements',
                'type'      => 'divider',
                'columns'   => 12,
            ),
            array(
                'tab'           => 'requirements',
                'id'            => 'requirements',
                'name'          => 'Requisitos adicionales',
                'type'          => 'text',
                'size'          => 1000,
                'add_button'    => 'Añadir otro',
                'clone' => true,
            ),

            array(
                'tab'              => 'media',
                'id'               => 'images',
                'name'             => 'Galeria',
                'type'             => 'image_advanced',
                'force_delete'     => false,
                'max_status'       => 'false',
                'image_size'       => 'thumbnail'
            ),

            array(
                'tab'   => 'media',
                'id'    => 'video',
                'name'  => 'Adjunta el enlace del video (Youtube)',
                'type'  => 'text',
                'size'  => 1000,
            ),


            // Location

            array(
                'tab'           => 'location',
                'name'          => 'Provincia',
                'id'            => 'province',
                'type'          => 'select',
                'field_type'    => 'select',
                'options'       => inmoob_get_es_provinces(),
                'columns'       => 3,
            ),

            array(
                'tab'           => 'location',
                'name'          => 'Zona',
                'id'            => 'property_zones_taxonomy',
                'type'          => 'taxonomy',
                'taxonomy'      => 'property_zones_taxonomy',
                'field_type'    => 'select_advanced',
                'placeholder'   => 'Elige una opción',
                'columns'       => 3,

            ),

            array(
                'tab'       => 'location',
                'name'      => 'Ciudad',
                'id'        => 'city',
                'type'      => 'text',
                'columns'   => 3,
            ),
            array(
                'tab'       => 'location',
                'name'      => 'Código postal',
                'id'        => 'zip_code',
                'type'      => 'text',
                'columns'   => 3,
            ),

            array(
                'tab'  => 'location',
                'name' => 'Dirección',
                'id'   => 'address',
                'type' => 'textarea',
            ),
            array(
                'tab'  => 'location',
                'name' => 'Google maps',
                'id'   => 'gmaps_link',
                'type' => 'textarea',
                'rows' => 2,
                'columns' => 12
            ),
          
        ),
    );



    return $meta_boxes;

}
);
