<?php
namespace Inmoob\Config;
use OBSER\Classes\Settings;

final class Properties {
    
    private static $tabs;
    private static $fields;
    private static $taxonomies;

    static function set_default_data(){

        $currency   =  Settings::get_setting('inmoob-settings','currency_symbol') ?: '$';
        self::$tabs = array(
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
        );

        self::$fields = array(
            array(
                'tab'       => 'general',
                'name'      => 'Descripción',
                'id'        => 'content',
                'type'      => 'wysiwyg',
                'columns'   => 12,
                'raw'       => false,
                'options' => array(
                    'textarea_rows' => 10,
                    'wpautop'       => false,
                    'media_buttons' => false,
                    'teeny'         => true,
                    'quicktags'     => false,
                ),
            ),
    
            array(
                'tab'     => 'general',
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
                'id'         => 'property_floor',
                'type'       => 'text',
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
                'type'       => 'text',
                'placeholder' => 'Elige una opción',
                'columns'    => 3
            ),
            
            array(
                'tab'       => 'features',
                'id'        => 'pets',
                'name'      => 'Mascotas',
                'type'      => 'switch',                    
                'style'     => 'rounded',
                'on_label'  => 'Si',
                'off_label' => 'No',
                'columns'    => 1
            ),
            array(
                'tab'       => 'features',
                'id'        => 'childrens',
                'name'      => 'Niños',
                'type'      => 'switch',                    
                'style'     => 'rounded',
                'on_label'  => 'Si',
                'off_label' => 'No',
                'columns'    => 1
            ),
    
            array(
                'tab'       => 'features',
                'id'        => 'terrace',
                'name'      => 'Terraza',
                'type'      => 'switch',                    
                'style'     => 'rounded',
                'on_label'  => 'Si',
                'off_label' => 'No',
                'columns'    => 1
            ),
    
            array(
                'tab'       => 'features',
                'id'        => 'ascensor',
                'name'      => 'Ascensor',
                'type'      => 'switch',                    
                'style'     => 'rounded',
                'on_label'  => 'Si',
                'off_label' => 'No',
                'columns'    => 1
            ),
            array(
                'tab'       => 'features',
                'id'        => 'garage',
                'name'      => 'Garaje',
                'type'      => 'switch',                    
                'style'     => 'rounded',
                'on_label'  => 'Si',
                'off_label' => 'No',
                'columns'    => 1
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
                'clone'         => true,
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
                'id'   => 'price_prefix',
                'type' => 'text',
                'columns' => 4,
            ),
            array(
                'tab'  => 'prices',
                'name' => 'Mostrar despues del valor',
                'id'   => 'price_sufix',
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
                'clone_as_multiple' => true,
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
                'tab'       => 'location',
                'name'      => 'Latitud',
                'id'        => 'geo_lat',
                'type'      => 'text',
                'size'      => 1000,
                'columns'   => 6

            ),
            array(
                'tab'       => 'location',
                'name'      => 'Longitud',
                'id'        => 'geo_lng',
                'type'      => 'text',
                'columns'   => 6,
                'size'      => 1000,
            ),
            array(
                'tab'  => 'location',
                'name' => 'Google maps',
                'id'   => 'gmaps_link',
                'type' => 'textarea',
                'sanitize_callback' => 'none',
                'rows' => 2,
                'columns' => 12
            ),
        );
    }

    static function get_tabs(){
        return apply_filters('inmoob_properties_metaboxes_tabs',self::$tabs);
    }


    static function get_fields(){
        return apply_filters('inmoob_properties_metaboxes_fields',self::$fields);
    }


    static function get_model(){
        $model = [];

        $fields = self::get_fields();

        foreach(\Inmoob\Config\Properties::get_fields() AS $field => $data){
            $key = $data['id'];
            if(!isset($model[$key])){
                $model[$key] = "";
            }
        }

        return $model;
    }

}

Properties::set_default_data();