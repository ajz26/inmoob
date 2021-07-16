<?php
namespace Inmoob\Witei;

use stdClass;

class Translator {

    private $object;
    public  $property;
    private $dictionary = array(
        "id"                          => 'witei_id',
        "identifier"                  => 'property_ref',
        "town"                        => 'city',
        "province"                    => 'province',
        "zone"                        => 'property_zones_taxonomy',
        "district"                    => null,
        "urbanization"                => null,
        "street"                      => 'address',
        "street_number"               => null,
        "geo_lat"                     => "geo_lat",
        "geo_lng"                     => "geo_lng",
        "renting"                     => 'gestion_types_taxonomy', // PARSEAR
        "selling"                     => 'gestion_types_taxonomy', // PARSEAR
        "renting_cost"                => null,
        "renting_period"              => null, // PARSEAR
        "selling_cost"                => null,
        "kind"                        => 'property_types_taxonomy',
        "floor"                       => null,
        "bedrooms"                    => 'property_rooms_taxonomy',
        "bathrooms"                   => 'property_bathrooms_taxonomy',
        "area"                        => 'property_size',
        "pictures"                    => 'images',
        "description"                 => 'post_content',
        "agency"                      => null,
        "raw_status"                  => 'gestion_states_taxonomy', // parsear
        "is_reserved"                 => 'gestion_states_taxonomy', // parsear,
        "zip_code"                    => 'zip_code',
        "show_cost"                   => null,
        "floor_display"               => 'property_floor',
        "area_util"                   => 'util_property_size',
        "area_plot"                   => null,
        "area_terrace"                => null,
        "energy_certificate_display"  => 'property_eacs', // parsear
        "created"                     => 'post_date', // Fecha actualización
        "updated"                     => 'post_modified', // Fecha actualización
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
        'witei_event_type'            => 'witei_event_type',
        'notes'                       => 'notes', 
    );
    

    function __construct($object){
        $this->object = $object;
        $this->property   = new stdClass;

        $this->parse_object();
        return $this->property;
    }



    static function parse_groups($groups){

        $data = [];
        preg_match_all('/(?<group>\w+)[\s\n]*\:[\s*\n*]*\((?<values>[^()]*[^()]*)\)/i',$groups,$matches,PREG_SET_ORDER);

        foreach($matches AS $match){
            $group  = isset($match['group'])    ? $match['group'] : null;


            $values = isset($match['values'])   ? $match['values'] : null;
            $data[$group] = explode('|',$values);
        }

        array_walk($data,array(__CLASS__,'walk_extras'));

        // var_dump($data);
        
        return $data;
        
    }


    static function walk_extras($value){
            if(is_array($value)){
                array_walk($value,array(__CLASS__,'walk_extras'));
            }

            
            $value = is_array($value) ? $value : trim($value);
    }

    

    static function parse_status($status){
        $texts = array(
            'rentend'   => 'Alquilado',
            'sold'      => 'Vendido',
            'available' => 'Disponible',
            'available' => 'Disponible',
            'inactive'  => 'Desactivado',
            'reserved'  => 'Reservado',
            'prospect'  => 'Prospecto',
        );

        return isset($texts[$status]) ? $texts[$status] : null; 
    }


    static function gen_title($object){
        $kind       = ucwords($object->kind) ?: 'Inmueble';
        $address    = $object->street ?: null;

        return "{$kind} en $address";
    }

    function parse_object(){
        $object = $this->object;    
        foreach($object AS $key => $val){ 

            $translation = isset($this->dictionary[$key]) ? $this->dictionary[$key] : null;
            if(is_null($translation) || empty($translation) || is_null($val)) continue;

            switch($key){
                case "renting":
                case "selling":
                    if($key == 'renting' && $val ){
                        $val = 'alquiler';

                        $this->property->price = $object->renting_cost; 
                        $this->property->price_sufix = '/mes';

                    }else if($key == 'selling' && $val){
                        $val = 'venta';
                        $this->property->price = $object->selling_cost; 
                    }
                    if(!$val){
                        continue(2);
                    }
                break;
                case "is_reserved":
                    if($val ){
                        $val = 'Reservado';
                    }else{
                        continue(2);
                    }
                break;

                case "raw_status":
                    if($val ){
                        if($val == 'inactive'){
                            $this->property->post_status = 'draft';
                        }
                        $val =  self::parse_status($val);
                    }
                break;

                case "title":
                    if($val == "" || !$val){
                        $val = self::gen_title($object);
                    }
                    $this->property->post_name = sanitize_title($val);
                break;
                case "created":
                $this->property->post_date_gmt = $val;
                break;
                case "updated":
                    $this->property->post_modified_gmt = $val;
                break;
                case "notes":
                    if($val){
                        $val = self::parse_groups($val);
                        
                        foreach($val AS $note_group => $note_value){
                            $this->property->$note_group = $note_value;
                        }
                        continue(2);
                    }
                break;

                case "tags":
                    if(is_array($val) && in_array('sin nómina',$val)){
                        $this->property->no_docs = 1;
                    }
                break;
            }
            $this->property->$translation = $val;
        }

    }

}