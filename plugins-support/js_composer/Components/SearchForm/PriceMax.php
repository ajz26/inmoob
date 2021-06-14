<?php
namespace Inmoob\WPB_Components\SearchForm;
class PriceMax extends Select {

    public static function map(): array {
        $map = array_merge((array)parent::map(),array(
            'name'      => __('Précio máximo', 'ccom'),
            'category'  => __('Buscador Inmoob', 'ccom'),
        ));
        
        return $map;
    }

}