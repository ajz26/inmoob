<?php namespace Inmoob\Witei {
    use OBSER\Classes\Settings;
    
    $witei_api_key   =  Settings::get_setting('inmoob-settings','witei_api_key') ?: null;

    if(!$witei_api_key) return false;


    require_once INMOOB_CORE_PLUGIN_DIR_PATH ."plugins-support/Witei/importer.php";
    require_once INMOOB_CORE_PLUGIN_DIR_PATH ."plugins-support/Witei/contacts.php";

}


namespace Inmoob\Witei\Functions {

use stdClass;

    function get_post_by_id($witei_id = null){

        if(!$witei_id) return null;

        global $wpdb;

            $sql = "SELECT pm.post_id 
            FROM {$wpdb->postmeta} pm 
            JOIN {$wpdb->posts} p 
            ON p.ID = pm.post_id 
            AND post_type = \"inmoob_properties\"
            WHERE meta_key = \"witei_id\" 
            AND meta_value = $witei_id 
            ";

        $post_id    = $wpdb->get_var( $sql );

        return isset($post_id) ? (int)$post_id : null;
    }


function get_property_types(){
        $property_types = array(
            'flat'               => 'Piso',
            'chalet'             => 'Casa / Chalet',
            'country_house'      => 'Casa rústica',
            'bungalow'           => 'Bungalow',
            'room'               => 'Habitación',
            'parking'            => 'Plaza de parking',
            'shop'               => 'Local',
            'industrial'         => 'Nave industrial',
            'office'             => 'Oficina',
            'land'               => 'Terreno',
            'storage'            => 'Trastero',
            'building'           => 'Edificio'
        );

        $objects = [];
        foreach($property_types AS $key => $val){
            $ob = new stdClass();
            $ob->slug = $key;
            $ob->val  = $key;
            $ob->label = $val;
            $objects[] = $ob;
        }

        return $objects;

    }



function get_property_tags(){
    return array(
        'access-from-street'           =>   array('value' => 'access from street',         'label'  => 'Acceso desde la calle'),
        'air-conditioner'              =>   array('value' => 'air conditioner',            'label'  => 'Aire acondicionado'),
        'alarm'                        =>   array('value' => 'alarm',                      'label'  => 'Alarma'),
        'aluminum-windows'             =>   array('value' => 'aluminum windows',           'label'  => 'Ventanas de aluminio'),
        'apartment'                    =>   array('value' => 'apartment',                  'label'  => 'Departamento'),
        'attached'                     =>   array('value' => 'attached',                   'label'  => 'Adjunto'),
        'automated-doors'              =>   array('value' => 'automated doors',            'label'  => 'Puertas automáticas'),
        'balcony'                      =>   array('value' => 'balcony',                    'label'  => 'Balcón'),
        'barbecue'                     =>   array('value' => 'barbecue',                   'label'  => 'Barbacoa'),
        'basement'                     =>   array('value' => 'basement',                   'label'  => 'Sótano'),
        'bohemian'                     =>   array('value' => 'bohemian',                   'label'  => 'Bohemio'),
        'bright'                       =>   array('value' => 'bright',                     'label'  => 'Brillante'),
        'buildable'                    =>   array('value' => 'buildable',                  'label'  => 'Edificable'),
        'built-in-wardrobes'           =>   array('value' => 'built-in wardrobes',         'label'  => 'Armarios empotrados'),
        'bungalow'                     =>   array('value' => 'bungalow',                   'label'  => 'Bungalow'),
        'butane-gas'                   =>   array('value' => 'butane gas',                 'label'  => 'Gas butano'),
        'caretaker'                    =>   array('value' => 'caretaker',                  'label'  => 'Vigilante'),
        'central-heating'              =>   array('value' => 'central heating',            'label'  => 'Calefacción central'),
        'chimney'                      =>   array('value' => 'chimney',                    'label'  => 'Chimenea'),
        'clothes-line'                 =>   array('value' => 'clothes line',               'label'  => 'Tendedero'),
        'communal-swimming-pool'       =>   array('value' => 'communal swimming pool',     'label'  => 'Piscina comunitaria'),
        'community-garden'             =>   array('value' => 'community garden',           'label'  => 'Jardín comunitario'),
        'concrete-structure'           =>   array('value' => 'concrete structure',         'label'  => 'Estructura de hormigón'),
        'condominium'                  =>   array('value' => 'condominium',                'label'  => 'Condominio'),
        'corner'                       =>   array('value' => 'corner',                     'label'  => 'Esquina'),
        'country-estate'               =>   array('value' => 'country estate',             'label'  => 'Finca'),
        'disabled-access'              =>   array('value' => 'disabled access',            'label'  => 'Acceso desactivado'),
        'dishwasher'                   =>   array('value' => 'dishwasher',                 'label'  => 'Lavaplatos'),
        'doorman'                      =>   array('value' => 'doorman',                    'label'  => 'Portero'),
        'double-glazing'               =>   array('value' => 'double glazing',             'label'  => 'Doble acristalamiento'),
        'downtown'                     =>   array('value' => 'downtown',                   'label'  => 'Centro'),
        'duplex'                       =>   array('value' => 'duplex',                     'label'  => 'Dúplex'),
        'east'                         =>   array('value' => 'east',                       'label'  => 'Este'),
        'electric-heating'             =>   array('value' => 'electric heating',           'label'  => 'Calefacción eléctrica'),
        'elevator'                     =>   array('value' => 'elevator',                   'label'  => 'Ascensor'),
        'emblematic-building'          =>   array('value' => 'emblematic building',        'label'  => 'Edificio emblemático'),
        'emergency-exit'               =>   array('value' => 'emergency exit',             'label'  => 'Salida de emergencia'),
        'equipped-kitchen'             =>   array('value' => 'equipped kitchen',           'label'  => 'Cocina equipada'),
        'extinguisher'                 =>   array('value' => 'extinguisher',               'label'  => 'Extintor'),
        'false-ceiling'                =>   array('value' => 'false ceiling',              'label'  => 'Techo falso'),
        'farmhouse'                    =>   array('value' => 'farmhouse',                  'label'  => 'Casa de campo'),
        'floating-floor'               =>   array('value' => 'floating floor',             'label'  => 'Piso flotante'),
        'floor-tiles'                  =>   array('value' => 'floor tiles',                'label'  => 'Baldosas'),
        'from-a-bank'                  =>   array('value' => 'from a bank',                'label'  => 'De un banco'),
        'furnished'                    =>   array('value' => 'furnished',                  'label'  => 'Amueblado'),
        'furnished-kitchen'            =>   array('value' => 'furnished kitchen',          'label'  => 'Cocina amueblada'),
        'garage'                       =>   array('value' => 'garage',                     'label'  => 'Garaje'),
        'garage-included'              =>   array('value' => 'garage included',            'label'  => 'Garaje incluido'),
        'garden'                       =>   array('value' => 'garden',                     'label'  => 'Jardín'),
        'golf-views'                   =>   array('value' => 'golf views',                 'label'  => 'Vistas al golf'),
        'green-area'                   =>   array('value' => 'green area',                 'label'  => 'Area verde'),
        'gym'                          =>   array('value' => 'gym',                        'label'  => 'Gimnasio'),
        'half-bathroom'                =>   array('value' => 'half bathroom',              'label'  => 'Medio Baño'),
        'heating-oil'                  =>   array('value' => 'heating oil',                'label'  => 'Calefaccion de combustible'),
        'historic'                     =>   array('value' => 'historic',                   'label'  => 'Histórico'),
        'hotel'                        =>   array('value' => 'hotel',                      'label'  => 'Hotel'),
        'hotel-industry'               =>   array('value' => 'hotel industry',             'label'  => 'Industria hotelera'),
        'individual-heating'           =>   array('value' => 'individual heating',         'label'  => 'Calefacción individual'),
        'industrial-area'              =>   array('value' => 'industrial area',            'label'  => 'Area industrial'),
        'inner-courtyard'              =>   array('value' => 'inner courtyard',            'label'  => 'Patio interior'),
        'insurance'                    =>   array('value' => 'insurance',                  'label'  => 'Seguro'),
        'interior'                     =>   array('value' => 'interior',                   'label'  => 'Interior'),
        'internet'                     =>   array('value' => 'internet',                   'label'  => 'Internet'),
        'large-lightwell'              =>   array('value' => 'large lightwell',            'label'  => 'Gran tragaluz'),
        'laundry'                      =>   array('value' => 'laundry',                    'label'  => 'Ropa sucia'),
        'lightwell'                    =>   array('value' => 'lightwell',                  'label'  => 'Buenas luz'),
        'loft'                         =>   array('value' => 'loft',                       'label'  => 'Desván'),
        'low-house'                    =>   array('value' => 'low house',                  'label'  => 'Casa baja'),
        'luggage-storage-room'         =>   array('value' => 'luggage storage room',       'label'  => 'Sala De Almacenamiento De Equipaje'),
        'luxury'                       =>   array('value' => 'luxury',                     'label'  => 'Lujo'),
        'mansion'                      =>   array('value' => 'mansion',                    'label'  => 'Mansión'),
        'marble-floor'                 =>   array('value' => 'marble floor',               'label'  => 'Piso De Mármol'),
        'metallic-structure'           =>   array('value' => 'metallic structure',         'label'  => 'Estructura Metálica'),
        'mountain-views'               =>   array('value' => 'mountain views',             'label'  => 'Vistas A La Montaña'),
        'natural-gas'                  =>   array('value' => 'natural gas',                'label'  => 'Gas Natural'),
        'new'                          =>   array('value' => 'new',                        'label'  => 'Nuevo'),
        'new-construction'             =>   array('value' => 'new construction',           'label'  => 'Nueva Construcción'),
        'north'                        =>   array('value' => 'north',                      'label'  => 'Norte'),
        'open-kitchen'                 =>   array('value' => 'open kitchen',               'label'  => 'Cocina Abierta'),
        'open-space'                   =>   array('value' => 'open space',                 'label'  => 'Espacio Abierto'),
        'outdoor'                      =>   array('value' => 'outdoor',                    'label'  => 'Exterior'),
        'paddle-tennis-court'          =>   array('value' => 'paddle tennis court',        'label'  => 'Pista De Pádel'),
        'pantry'                       =>   array('value' => 'pantry',                     'label'  => 'Despensa'),
        'parking'                      =>   array('value' => 'parking',                    'label'  => 'Estacionamiento'),
        'parquet-floor'                =>   array('value' => 'parquet floor',              'label'  => 'Suelos De Parquet'),
        'patio'                        =>   array('value' => 'patio',                      'label'  => 'Patio'),
        'penthouse'                    =>   array('value' => 'penthouse',                  'label'  => 'Ático'),
        'permanent-ford'               =>   array('value' => 'permanent ford',             'label'  => 'Vado Permanente'),
        'pets'                         =>   array('value' => 'pets',                       'label'  => 'Mascotas'),
        'playground'                   =>   array('value' => 'playground',                 'label'  => 'Patio De Juegos'),
        'plot'                         =>   array('value' => 'plot',                       'label'  => 'Trama'),
        'porch'                        =>   array('value' => 'porch',                      'label'  => 'Porche'),
        'private-urbanization'         =>   array('value' => 'private urbanization',       'label'  => 'Urbanización Privada'),
        'protected-building'           =>   array('value' => 'protected building',         'label'  => 'Edificio Protegido'),
        'radiating-floor'              =>   array('value' => 'radiating floor',            'label'  => 'Piso Irradia'),
        'raised-floor'                 =>   array('value' => 'raised floor',               'label'  => 'Piso Elevado'),
        'reformed'                     =>   array('value' => 'reformed',                   'label'  => 'Reformado'),
        'reinforced-door'              =>   array('value' => 'reinforced door',            'label'  => 'Puerta Blindada'),
        'rooftop-terrace'              =>   array('value' => 'rooftop terrace',            'label'  => 'Terraza En La Azotea'),
        'sauna'                        =>   array('value' => 'sauna',                      'label'  => 'Sauna'),
        'sea-views'                    =>   array('value' => 'sea views',                  'label'  => 'Vistas Al Mar'),
        'security-24h'                 =>   array('value' => 'security 24h',               'label'  => '24H De Seguridad'),
        'security-cameras'             =>   array('value' => 'security cameras',           'label'  => 'Cámaras De Seguridad'),
        'security-door'                =>   array('value' => 'security door',              'label'  => 'Puerta De Seguridad'),
        'semidetached'                 =>   array('value' => 'semidetached',               'label'  => 'Semi Separado'),
        'service-bedroom'              =>   array('value' => 'service bedroom',            'label'  => 'Dormitorio De Servicio'),
        'service-elevator'             =>   array('value' => 'service elevator',           'label'  => 'Ascensor De Servicio'),
        'singular'                     =>   array('value' => 'singular',                   'label'  => 'Singular'),
        'smoke-detector'               =>   array('value' => 'smoke detector',             'label'  => 'Detector De Humo'),
        'smoke-extractor'              =>   array('value' => 'smoke extractor',            'label'  => 'Extractor De Humos'),
        'smooth-walls'                 =>   array('value' => 'smooth walls',               'label'  => 'Paredes Lisas'),
        'solarium'                     =>   array('value' => 'solarium',                   'label'  => 'Solárium'),
        'south'                        =>   array('value' => 'south',                      'label'  => 'Sur'),
        'squash-court'                 =>   array('value' => 'squash court',               'label'  => 'Pista De Squash'),
        'stairs'                       =>   array('value' => 'stairs',                     'label'  => 'Escalera'),
        'stippled-walls'               =>   array('value' => 'stippled walls',             'label'  => 'Paredes Punteadas'),
        'storage-room'                 =>   array('value' => 'storage room',               'label'  => 'Trastero'),
        'storage-room-included'        =>   array('value' => 'storage room included',      'label'  => 'Trastero Incluido'),
        'students'                     =>   array('value' => 'students',                   'label'  => 'Estudiantes'),
        'studio'                       =>   array('value' => 'studio',                     'label'  => 'Estudio'),
        'subsidised-housing'           =>   array('value' => 'subsidised housing',         'label'  => 'Vivienda Protegida'),
        'sunny'                        =>   array('value' => 'sunny',                      'label'  => 'Soleado'),
        'swimming-pool'                =>   array('value' => 'swimming pool',              'label'  => 'Piscina'),
        'tennis-court'                 =>   array('value' => 'tennis court',               'label'  => 'Pista De Tenis'),
        'terrace'                      =>   array('value' => 'terrace',                    'label'  => 'Terraza'),
        'terrazzo-floor'               =>   array('value' => 'terrazzo floor',             'label'  => 'Suelo De Terrazo'),
        'to-reform'                    =>   array('value' => 'to reform',                  'label'  => 'Reformar'),
        'tourist'                      =>   array('value' => 'tourist',                    'label'  => 'Turista'),
        'townhouse'                    =>   array('value' => 'townhouse',                  'label'  => 'Adosado'),
        'transfer'                     =>   array('value' => 'transfer',                   'label'  => 'Transferir'),
        'triplex'                      =>   array('value' => 'triplex',                    'label'  => 'Triple'),
        'TV-antenna'                   =>   array('value' => 'TV antenna',                 'label'  => 'Antena De Televisión'),
        'unfurnished'                  =>   array('value' => 'unfurnished',                'label'  => 'Sin Muebles'),
        'vent'                         =>   array('value' => 'vent',                       'label'  => 'Respiradero'),
        'video-intercom'               =>   array('value' => 'video intercom',             'label'  => 'Video Portero'),
        'villa'                        =>   array('value' => 'villa',                      'label'  => 'Villa'),
        'warehouse'                    =>   array('value' => 'warehouse',                  'label'  => 'Depósito'),
        'west'                         =>   array('value' => 'west',                       'label'  => 'Oeste'),
        'wifi'                         =>   array('value' => 'wifi',                       'label'  => 'Wifi'),
        'wooden-structure'             =>   array('value' => 'wooden structure',           'label'  => 'Estructura De Madera'),
        'wooden-windows'               =>   array('value' => 'wooden windows',             'label'  => 'Ventanas De Madera')
        );
}
}
