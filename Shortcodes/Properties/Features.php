<?php namespace Inmoob\Shortcodes\Properties;

class Features extends Shortcode{

    static $shortcode       = "inmoob_featured_data";
    static $options         = array(
        'property_ref' => array(
            'label'     => 'Referencia',
            'prefix'    => '',
            'sufix'     => '',
            'type'      => 'string',
        ),
        'property_size' => array(
            'label'     => 'Superficie',
            'prefix'    => '',
            'sufix'     => '',
            'type'      => 'string',
        ),
        'util_property_size' => array(
            'label'    => 'Superficie útil',
            'prefix'    => '',
            'sufix'     => '',
            'type'      => 'string',
        ),
        'property_construction_year' => array(
            'label'    => 'Año de construcción',
            'prefix'    => '',
            'sufix'     => '',
            'type'      => 'string',
        ),
        'property_rooms_taxonomy' => array(
            'label'    => 'Habitaciones',
            'prefix'    => '',
            'sufix'     => '',
            'type'      => 'taxonomy',
        ),
        'property_bathrooms_taxonomy' => array(
            'label'    => 'Baños',
            'prefix'    => '',
            'sufix'     => '',
            'type'      => 'taxonomy',
        ),
        'property_eacs' => array(
            'label'    => 'Certificado',
            'prefix'    => '',
            'sufix'     => '',
            'type'      => 'string',
        ),
        'pets' => array(
            'label'    => 'se aceptan mascotas',
            'prefix'    => '',
            'sufix'     => '',
            'type'      => 'bool',
        ),
        'childrens' => array(
            'label'    => 'se aceptan niños',
            'prefix'    => '',
            'sufix'     => '',
            'type'      => 'bool',
        ),
        'terrace' => array(
            'label'     => 'Tiene terraza',
            'prefix'    => '',
            'sufix'     => '',
            'type'      => 'bool',
        ),
        'ascensor' => array(
            'label'     => 'Tiene ascensor',
            'prefix'    => '',
            'sufix'     => '',
            'type'      => 'bool',
        ),
        'extras' => array(
            'label'     => 'Extras',
            'prefix'    => '',
            'sufix'     => '',
            'type'      => 'array',
        )
    );


    public static function generate_css(){

    }

    public static function general_styles(){
        return "
        .inmoob-feature-list {
            columns: 3;
            -webkit-columns: 3;
            -moz-columns: 3;
        }
        .inmoob-feature-list li {
            margin-bottom: 0;
        }
        @media(max-width:768px){
            .inmoob-feature-list {
                columns: 1;
                -webkit-columns: 1;
                -moz-columns: 1;
            }
        }
        ";
    }


    public static function get_val($field){
        global $post;

        $type  = isset(self::$options[$field]['type'])    ? self::$options[$field]['type'] : null;

        $value = '';
        switch($type){
            case 'taxonomy':
               $terms =  get_the_terms($post->ID,$field);

               if(!$terms) return null;
                $i = 0;
               foreach($terms AS $term){

                   $value .= ($i >= 1) ? ' ,'. $term->name : $term->name;
                   $i ++;
               }
            break;
            case 'array':
                $metas =  get_post_meta($post->ID,$field,true);
                if(!$metas) return null;
                 $i = 0;
                foreach($metas AS $meta){
                    $value .= ($i >= 1) ? ', '. $meta : $meta;
                    $i ++;
                }
             break;
            case 'bool':
                $value = (get_post_meta($post->ID,$field,true) == 1) ? 'Si' : 'No';
            break;
            default :
                $value = get_post_meta($post->ID,$field,true);
            break;
        }

        if( in_array($field,array('property_size','util_property_size'))  && $value) $value .= ' m²';


        return $value;

    }

    public static function output($atts,$content){

        $fields  = explode(',',self::get_atts('fields'));
        $el_id = self::get_atts('el_id',null);
        $el_class = self::get_atts('el_class',null);
        $html   = null;

        foreach($fields AS $field ){
            $key    = sanitize_key($field );
            $label  = isset(self::$options[$field]['label'])    ? self::$options[$field]['label'] : null;
            $prefix = isset(self::$options[$field]['prefix'])   ? self::$options[$field]['prefix'] : null;
            $sufix  = isset(self::$options[$field]['sufix'])    ? self::$options[$field]['sufix'] : null;
            $value  = self::get_val($field);

            if( $value == "" || empty($value) || is_null($value) ) continue;

            foreach( (array)$value AS $val ){
                $html .= "<li id='$key' class='$key'>{$label} : {$prefix} {$val} {$sufix}</li>";
            }

        }

        return "<ul id='{$el_id}' class='{$el_class} inmoob-feature-list'>$html</ul>";
    }

}