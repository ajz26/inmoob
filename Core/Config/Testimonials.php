<?php
namespace Inmoob\Config;

final class Testimonials {
    
    private static $tabs;
    private static $fields;

    static function set_default_data(){



        self::$fields = array(
            array(
                'name'       => 'Nombre',
                'id'         => 'name',
                'type'       => 'text',
                'placeholder' => 'Nombre y apellido'
            ),
            array(
                'name'       => 'Estrellas',
                'id'         => 'rating',
                'type'       => 'select',
                'options'         => array(
                    '1'       => '1',
                    '2'       => '2',
                    '3'       => '3',
                    '4'       => '4',
                    '5'       => '5',
                ),
                'placeholder' => 'Elige una opción'
            ),

            array(
                'name'       => 'Mensaje',
                'id'         => 'message',
                'type'       => 'textarea',
                'placeholder' => 'Describe el testimonio'
            ),

            array(
                'name'       => 'Link',
                'id'         => 'link',
                'type'       => 'text',
                'placeholder' => 'enlace del testimonio'
            ),

        );
    }


    static function get_fields(){
        return apply_filters('inmoob_testimonials_metaboxes_fields',self::$fields);
    }


}

Testimonials::set_default_data();

