<?php
namespace Inmoob\WPB_Components\SearchForm;
class ProperytyZones extends Select {

    public static function map(): array {
        $map = array_merge((array)parent::map(),array(
            'name'      => __('Ubicación', 'ccom'),
            'category'  => __('Buscador Inmoob', 'ccom'),
        ));
        
        return $map;
    }

}