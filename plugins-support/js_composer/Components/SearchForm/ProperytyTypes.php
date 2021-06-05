<?php
namespace Inmoob\WPB_Components\SearchForm;
class ProperytyTypes extends Select {

    public static function map(): array {
        $map = array_merge((array)parent::map(),array(
            'name'      => __('Tipo de propiedad', 'ccom'),
            'category'  => __('Buscador Inmoob', 'ccom'),
        ));
        
        return $map;
    }

}