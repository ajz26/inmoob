<?php
namespace Inmoob\WPB_Components\SearchForm;
class NoDocs extends Field {

    public static function map(): array {
        $map = array_merge((array)parent::map(),array(
            'name'      => __('Switch (Sin documentos)', 'ccom'),
            'category'  => __('Buscador Inmoob', 'ccom'),
        ));
        
        return $map;
    }

}