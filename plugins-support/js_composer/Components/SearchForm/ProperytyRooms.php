<?php
namespace Inmoob\WPB_Components\SearchForm;
class ProperytyRooms extends Select {

    public static function map(): array {
        $map = array_merge((array)parent::map(),array(
            'name'      => __('Habitaciones', 'ccom'),
            'category'  => __('Buscador Inmoob', 'ccom'),
        ));
        
        return $map;
    }

}