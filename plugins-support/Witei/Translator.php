<?php
namespace Inmoob\Witei;

use stdClass;

class Translator {

    private $object;
    public  $property;
    private $dictionary = array(
        "id"                          => 'witei_id',
        "identifier"                  => 'reference',
        "town"                        => 'city',
        "province"                    => 'province',
        "zone"                        => 'property_zones_taxonomy',
        "district"                    => null,
        "urbanization"                => null,
        "street"                      => 'address',
        "street_number"               => null,
        "geo_lat"                     => null,
        "geo_lng"                     => null,
        "renting"                     => 'gestion_types_taxonomy', // PARSEAR
        "selling"                     => 'gestion_types_taxonomy', // PARSEAR
        "renting_cost"                => 'price',
        "renting_period"              => 'price_sufix', // PARSEAR
        "selling_cost"                => 'price',
        "kind"                        => 'property_types_taxonomy',
        "floor"                       => 'property_floor',
        "bedrooms"                    => 'property_rooms_taxonomy',
        "bathrooms"                   => 'property_bathrooms_taxonomy',
        "area"                        => 'property_size',
        "pictures"                    => 'images',
        "description"                 => 'post_content',
        "agency"                      => null,
        "status"                      => 'gestion_states_taxonomy', // parsear
        "is_reserved"                 => 'gestion_states_taxonomy', // parsear,
        "zip_code"                    => 'zip_code',
        "show_cost"                   => null,
        "floor_display"               => null,
        "area_util"                   => 'util_property_size',
        "area_plot"                   => null,
        "area_terrace"                => null,
        "energy_certificate_display"  => 'property_eacs', // parsear
        "updated"                     => 'post_date', // Fecha actualización
        "kind_value"                  => 'property_types_taxonomy', // consultar con witei
        "renting_period_display"      => null,
        "tags"                        => 'property_tags_taxonomy',
        "virtual_visit"               => null,
        "description_es"              => 'content', // consultar
        "description_en"              => null,
        "description_ca"              => null,
        "description_fr"              => null,
        "description_ru"              => null,
        "description_nl"              => null,
        "description_nb"              => null,
        "description_fi"              => null,
        "description_de"              => null,
        "description_sv"              => null,
        "is_exclusive"                => '', // consultar con witei
        "year_built"                  => 'property_construction_year',
        "title"                       => 'post_title',
        "contact"                     => null,
        'neighborhood'                => null,
        'public_address'              => null,         
        'transfer'                    => null, 
        'transfer_cost'               => null,     
        'video_url'                   => 'video', 
        'published_web'               => null,     
        'energy_consumption'          => null,             
        'energy_emission'             => null,         
        'owner'                       => null, 
        'second_owner'                => null,     
        'commercial'                  => null,     
        'creator'                     => null, 
    );
    

    function __construct($object){
        $this->object = $object;
        $this->property   = new stdClass;

        $this->parse_object();
        return $this->property;
    }


    function parse_object(){
        $object = $this->object;    
        foreach($object AS $key => $val){ 
            $translation = $this->dictionary[$key];
            if(is_null($translation) || empty($translation) || is_null($val)) continue;

            switch($key){
                case "renting":
                case "selling":
                    if($key == 'renting' && $val ){
                        $val = 'alquiler';
                    }else if($key == 'selling' && $val){
                        $val = 'Venta';
                    }
                break;
            }

            $this->property->$translation = $val;
        }

    }

}