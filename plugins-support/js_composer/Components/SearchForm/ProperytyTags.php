<?php
namespace Inmoob\WPB_Components\SearchForm;

use Exception;
use Inmoob\Classes\Api;


class ProperytyTags extends Field {

    public static function map(): array {

        $tags       = Api::get_terms_select('property_tags_taxonomy');

        $tags       = (is_array($tags)) ? self::parse_tags($tags) : array();


        $map        = array_merge((array)parent::map(),array(
            'name'      => __('Etiquetas', 'ccom'),
            'category'  => __('Buscador Inmoob', 'ccom'),
        ));
        $map['params'] = array_merge($map['params'], array(
                array(                  
                    "type"          => "checkbox",
                    "heading"       => __("Mostrar solo", "mx-plugin"),
                    "param_name"    => "fields",
                    'value'         => $tags,
                ) 
            )
        );
        return $map;
    }

    public static function parse_tags(array $tags){
        $t = [];
        foreach((array)$tags AS $tag){
            $slug  = isset($tag->val)    ? $tag->val : null;
            $label = isset($tag->label) ? $tag->label : null;
            $t[$label] = $slug;
        }
        return $t;
    }

}