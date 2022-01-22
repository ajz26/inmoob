<?php
namespace Inmoob\Witei;

use stdClass;
use OBSER\Classes\Arr;

class Translator {

    private $object;
    public  $property;

    protected static $status = array(
        'rentend'               => 'Alquilado',
        'sold'                  => 'Vendido',
        'available'             => 'Disponible',
        'available'             => 'Disponible',
        'inactive'              => 'Desactivado',
        'reserved'              => 'Reservado',
        'prospect'              => 'Prospecto',
    );

    protected static $kind = array(
        'flat'                  => 'Piso',
        'chalet'                => 'Chalet',
        'country_house'         => 'Casa de campo',
        'bungalow'              => 'Chalet',
        'room'                  => 'Habitacion',
        'parking'               => 'Parking',
        'shop'                  => 'Local',
        'industrial'            => 'Industral',
        'office'                => 'Oficina',
        'land'                  => 'Terreno',
        'storage'               => 'Trastero',
        'building'              => 'Edificio',
    );

    protected $tags = array(
        'access from street'    =>  'Acceso Desde La Calle',
        'air conditioner'       =>  'Aire Acondicionado',
        'alarm'                 =>  'Alarma',
        'aluminum windows'      =>  'Ventanas De Aluminio',
        'apartment'             =>  'Departamento',
        'attached'              =>  'Adjunto',
        'automated doors'       =>  'Puertas Automatizadas',
        'balcony'               =>  'Balcón',
        'barbecue'              =>  'Parilla',
        'basement'              =>  'Sótano',
        'bohemian'              =>  'Bohemio',
        'bright'                =>  'Brillante',
        'buildable'             =>  'Acumulado',
        'built-in wardrobes'    =>  'Armarios Empotrados',
        'bungalow'              =>  'Bungalow',
        'butane gas'            =>  'Gas Butano',
        'caretaker'             =>  'Vigilante',
        'central heating'       =>  'Calefacción Central',
        'chimney'               =>  'Chimenea',
        'clothes line'          =>  'Tendedero',
        'communal swimming pool'=>  'Piscina Comunitaria',
        'community garden'      =>  'Jardín Comunitario',
        'concrete structure'    =>  'Estructura Concreta',
        'condominium'           =>  'Condominio',
        'corner'                =>  'Esquina',
        'country estate'        =>  'Finca',
        'disabled access'       =>  'Acceso Desactivado',
        'dishwasher'            =>  'Lavavajillas',
        'doorman'               =>  'Portero',
        'double glazing'        =>  'Doble Acristalamiento',
        'downtown'              =>  'Centro',
        'duplex'                =>  'Dúplex',
        'east'                  =>  'Este',
        'electric heating'      =>  'Calefacción Eléctrica',
        'elevator'              =>  'Ascensor',
        'emblematic building'   =>  'Edificio Emblemático',
        'emergency exit'        =>  'Salida De Emergencia',
        'equipped kitchen'      =>  'Cocina Equipada',
        'extinguisher'          =>  'Extintor',
        'false ceiling'         =>  'Techo Falso',
        'farmhouse'             =>  'Casa De Campo',
        'floating floor'        =>  'Piso Flotante',
        'floor tiles'           =>  'Baldosas',
        'from a bank'           =>  'De Un Banco',
        'furnished'             =>  'Amueblado',
        'furnished kitchen'     =>  'Cocina Amueblada',
        'garage'                =>  'Garaje',
        'garage included'       =>  'Garaje Incluido',
        'garden'                =>  'Jardín',
        'golf views'            =>  'Vistas De Golf',
        'green area'            =>  'Area Verde',
        'gym'                   =>  'Gimnasio',
        'half bathroom'         =>  'Medio Baño',
        'heating oil'           =>  'Aceite De Calefaccion',
        'historic'              =>  'Histórico',
        'hotel'                 =>  'Hotel',
        'hotel industry'        =>  'Industria Hotelera',
        'individual heating'    =>  'Calefacción Individual',
        'industrial area'       =>  'Area Industrial',
        'inner courtyard'       =>  'Patio Interior',
        'insurance'             =>  'Seguro',
        'interior'              =>  'Interior',
        'internet'              =>  'Internet',
        'large lightwell'       =>  'Gran Lightwell',
        'laundry'               =>  'Ropa Sucia',
        'lightwell'             =>  'Buenas Luz',
        'loft'                  =>  'Desván',
        'low house'             =>  'Casa Baja',
        'luggage storage room'  =>  'Sala De Guardaequipajes',
        'luxury'                =>  'Lujo',
        'mansion'               =>  'Mansión',
        'marble floor'          =>  'Piso De Mármol',
        'metallic structure'    =>  'Estructura Metálica',
        'mountain views'        =>  'Vistas A La Montaña',
        'natural gas'           =>  'Gas Natural',
        'new'                   =>  'Nuevo',
        'new construction'      =>  'Nueva Construcción',
        'north'                 =>  'Norte',
        'open kitchen'          =>  'Cocina Abierta',
        'open space'            =>  'Espacio Abierto',
        'outdoor'               =>  'Exterior',
        'paddle tennis court'   =>  'Pista De Tenis De Pádel',
        'pantry'                =>  'Despensa',
        'parking'               =>  'Estacionamiento',
        'parquet floor'         =>  'Suelos De Parquet',
        'patio'                 =>  'Patio',
        'penthouse'             =>  'Ático',
        'permanent ford'        =>  'Ford Permanente',
        'pets'                  =>  'Mascotas',
        'playground'            =>  'Patio De Juegos',
        'plot'                  =>  'Gráfico',
        'porch'                 =>  'Porche',
        'private urbanization'  =>  'Urbanización Privada',
        'protected building'    =>  'Edificio Protegido',
        'radiating floor'       =>  'Piso Radiante',
        'raised floor'          =>  'Piso Elevado',
        'reformed'              =>  'Reformado',
        'reinforced door'       =>  'Puerta Reforzada',
        'rooftop terrace'       =>  'Terraza En La Azotea',
        'sauna'                 =>  'Sauna',
        'sea views'             =>  'Vistas Al Mar',
        'security 24h'          =>  'Seguridad 24H',
        'security cameras'      =>  'Cámaras De Seguridad',
        'security door'         =>  'Puerta De Seguridad',
        'semidetached'          =>  'Semi Separado',
        'service bedroom'       =>  'Dormitorio De Servicio',
        'service elevator'      =>  'Ascensor De Servicio',
        'singular'              =>  'Singular',
        'smoke detector'        =>  'Detector De Humo',
        'smoke extractor'       =>  'Extractor De Humo',
        'smooth walls'          =>  'Paredes Lisas',
        'solarium'              =>  'Solárium',
        'south'                 =>  'Sur',
        'squash court'          =>  'Pista De Squash',
        'stairs'                =>  'Escalera',
        'stippled walls'        =>  'Paredes Puntuales',
        'storage room'          =>  'Trastero',
        'storage room included' =>  'Cuarto De Almacenamiento Incluido',
        'students'              =>  'Estudiantes',
        'studio'                =>  'Estudio',
        'subsidised housing'    =>  'Vivienda Subsidiada',
        'sunny'                 =>  'Soleado',
        'swimming pool'         =>  'Alberca',
        'tennis court'          =>  'Pista De Tenis',
        'terrace'               =>  'Terraza',
        'terrazzo floor'        =>  'Piso De Terrazo',
        'to reform'             =>  'Reformar',
        'tourist'               =>  'Turista',
        'townhouse'             =>  'Casa Adosada',
        'transfer'              =>  'Transferir',
        'triplex'               =>  'Triple',
        'TV antenna'            =>  'Antena De Televisión',
        'unfurnished'           =>  'Sin Amueblar',
        'vent'                  =>  'Respiradero',
        'video intercom'        =>  'Intercomunicador De Video',
        'villa'                 =>  'Villa',
        'warehouse'             =>  'Depósito',
        'west'                  =>  'Oeste',
        'wifi'                  =>  'Wifi',
        'wooden structure'      =>  'Estructura De Madera',
        'wooden windows'        =>  'Ventanas De Madera',
        'featured'              =>  'Destacado',
        'free docs'             =>  'Sin nómina',
    );

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
        "floor"                       => 'property_floor',
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
        "area_util"                   => 'util_property_size',
        "area_plot"                   => null,
        "area_terrace"                => null,
        "energy_certificate_display"  => 'property_eacs', // parsear
        "created"                     => 'post_date', // Fecha actualización
        "updated"                     => 'post_modified', // Fecha actualización
        "kind_value"                  => 'property_types_taxonomy',
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
        $this->object     = $object;
        $this->property   = new stdClass;

        $this->parse_object();
        return $this->property;
    }



    static function parse_groups($groups){

        $data   = [];
        $groups = json_encode($groups);


        preg_match_all('/(?<group>\w+)[\s\n]*\:[\s*\n*]*\((?<values>[^()]*[^()]*)\)/i',$groups,$matches,PREG_SET_ORDER);

        foreach($matches AS $match){
            $group  = isset($match['group'])    ? $match['group'] : null;


            $values = isset($match['values'])   ? $match['values'] : null;
            $data[$group] = explode('|',$values);
        }

        array_walk($data,array(__CLASS__,'walk_extras'));

        return $data;
        
    }


    static function walk_extras($value){
            if(is_array($value)){
                array_walk($value,array(__CLASS__,'walk_extras'));
            }

            
            $value = is_array($value) ? $value : trim($value);
    }

    static function gen_title($object){

        $kind       = Arr::get(self::$kind,$object->kind_value,'Inmueble');
        $address    = $object->street ?: null;

        return "{$kind} en $address";
    }

    function parse_object(){
        $object = $this->object;

        if(isset($object->tags) && is_array($object->tags)){
            $object->tags = array_map(function($tag){
                return Arr::get($this->tags, $tag,$tag);
            },$object->tags);
        }
 

        foreach($object AS $key => $val){ 

            $translation = isset($this->dictionary[$key]) ? $this->dictionary[$key] : null;

            if(is_null($translation) || empty($translation)) continue;

            switch($key){
                case "renting":
                case "selling":
                    if($key == 'selling' && $val){
                        $val = 'venta';
                        $this->property->price = $object->selling_cost; 
                        $this->property->price_sufix = '';

                    // }else if ($key == 'renting' && $val ){
                    }else{
                        $val = 'alquiler';

                        $this->property->price = $object->renting_cost; 
                        $this->property->price_sufix = '/mes';

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
                        $val =  Arr::get(self::$status,$val,$val);
                    }
                break;

                case "kind_value":
                    $val =  $val ? Arr::get(self::$kind,$val,$val) : $val;
                break;

                case "title":
                    if($val == "" || !$val){
                        $val = self::gen_title($object);
                    }
                break;
                case "street":
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

                            switch($note_group){
                                case 'requisitos':
                                    $note_group = 'requirements';
                                case 'requirements':
                                case 'extras':
                                    $this->property->$note_group = $note_value;
                                break;
                                case 'gmaps_link':
                                    $this->property->$note_group = $note_value[0];
                                break;

                            }
                        }
                        continue(2);
                    }
                break;

                case "tags":
                    $val = (array)$val;
                    $this->property->no_docs        = (Arr::exists($val,'Sin Nómina'))                                      ? 1 : 0;
                    $this->property->pets           = (Arr::exists($val,'animales'))                                        ? 1 : 0;
                    $this->property->ascensor       = (Arr::exists($val,'ascensor') || Arr::exists($val,'elevator'))        ? 1 : 0;
                    $this->property->terrace        = (Arr::exists($val,'terraza')  || Arr::exists($val,'terrace'))         ? 1 : 0;
                    $this->property->garage         = (Arr::exists($val,'garaje')   || Arr::exists($val,'garage'))          ? 1 : 0;
                    $this->property->featured       = (Arr::exists($val,'Destacado'))                                       ? 1 : 0;

                    $val = array_diff_key(array_flip($val) ,array_flip(['animales','ascensor','terraza','garaje']));
                    $val = array_keys($val);
                break;
            }
            $this->property->$translation = $val;
        }

    }

}



