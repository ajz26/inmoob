<?php

function inmoob_get_es_provinces($province = null, $key_val = true){
  $provinces = array (
        array (
          'cc-aa'       => 'Andalucía',
          'province'  => 'Almería',
          'label'       => 'Almería'
        ),
        array (
          'cc-aa'       => 'Andalucía',
          'province'  => 'Cádiz',
          'label'       => 'Cádiz'
        ),
        array (
          'cc-aa'       => 'Andalucía',
          'province'  => 'Córdoba',
          'label'       => 'Córdoba'
        ),
        array (
          'cc-aa'       => 'Andalucía',
          'province'  => 'Granada',
          'label'       => 'Granada'
        ),
        array (
          'cc-aa'       => 'Andalucía',
          'province'  => 'Huelva',
          'label'       => 'Huelva'
        ),
        array (
          'cc-aa'       => 'Andalucía',
          'province'  => 'Jaén',
          'label'       => 'Jaén'
        ),
        array (
          'cc-aa'       => 'Andalucía',
          'province'  => 'Málaga',
          'label'       => 'Málaga'
        ),
        array (
          'cc-aa'       => 'Andalucía',
          'province'  => 'Sevilla',
          'label'       => 'Sevilla'
        ),
        array (
          'cc-aa'       => 'Aragón',
          'province'  => 'Huesca',
          'label'       => 'Huesca'
        ),
        array (
          'cc-aa'       => 'Aragón',
          'province'  => 'Teruel',
          'label'       => 'Teruel'
        ),
        array (
          'cc-aa'       => 'Aragón',
          'province'  => 'Zaragoza',
          'label'       => 'Zaragoza'
        ),
        array (
          'cc-aa'       => 'Asturias, Principado de',
          'province'  => 'Asturias',
          'label'       => 'Asturias'
        ),
        array (
          'cc-aa'       => 'Canarias',
          'province'  => 'Las Palmas',
          'label'       => 'Las Palmas'
        ),
        array (
          'cc-aa'       => 'Canarias',
          'province'  => 'Santa Cruz de Tenerife',
          'label'       => 'Santa Cruz de Tenerife'
        ),
        array (
          'cc-aa'       => 'Cantabria',
          'province'  => 'Cantabria',
          'label'       => 'Cantabria'
        ),
        array (
          'cc-aa'       => 'Castilla - La Mancha',
          'province'  => 'Albacete',
          'label'       => 'Albacete'
        ),
        array (
          'cc-aa'       => 'Castilla - La Mancha',
          'province'  => 'Ciudad Real',
          'label'       => 'Ciudad Real'
        ),
        array (
          'cc-aa'       => 'Castilla - La Mancha',
          'province'  => 'Cuenca',
          'label'       => 'Cuenca'
        ),
        array (
          'cc-aa'       => 'Castilla - La Mancha',
          'province'  => 'Guadalajara',
          'label'       => 'Guadalajara'
        ),
        array (
          'cc-aa'       => 'Castilla - La Mancha',
          'province'  => 'Toledo',
          'label'       => 'Toledo'
        ),
        array (
          'cc-aa'       => 'Castilla y León',
          'province'  => 'Ávila',
          'label'       => 'Ávila'
        ),
        array (
          'cc-aa'       => 'Castilla y León',
          'province'  => 'Burgos',
          'label'       => 'Burgos'
        ),
        array (
          'cc-aa'       => 'Castilla y León',
          'province'  => 'León',
          'label'       => 'León'
        ),
        array (
          'cc-aa'       => 'Castilla y León',
          'province'  => 'Palencia',
          'label'       => 'Palencia'
        ),
        array (
          'cc-aa'       => 'Castilla y León',
          'province'  => 'Salamanca',
          'label'       => 'Salamanca'
        ),
        array (
          'cc-aa'       => 'Castilla y León',
          'province'  => 'Segovia',
          'label'       => 'Segovia'
        ),
        array (
          'cc-aa'       => 'Castilla y León',
          'province'  => 'Soria',
          'label'       => 'Soria'
        ),
        array (
          'cc-aa'       => 'Castilla y León',
          'province'  => 'Valladolid',
          'label'       => 'Valladolid'
        ),
        array (
          'cc-aa'       => 'Castilla y León',
          'province'  => 'Zamora',
          'label'       => 'Zamora'
        ),
        array (
          'cc-aa'       => 'Cataluña',
          'province'  => 'Barcelona',
          'label'       => 'Barcelona'
        ),
        array (
          'cc-aa'       => 'Cataluña',
          'province'  => 'Girona',
          'label'       => 'Gerona'
        ),
        array (
          'cc-aa'       => 'Cataluña',
          'province'  => 'Lleida',
          'label'       => 'Lleida'
        ),
        array (
          'cc-aa'       => 'Cataluña',
          'province'  => 'Tarragona',
          'label'       => 'Tarragona'
        ),
        array (
          'cc-aa'       => 'Ceuta',
          'province'  => 'Ceuta',
          'label'       => 'Ceuta'
        ),
        array (
          'cc-aa'       => 'Comunidad de Madrid',
          'province'  => 'Madrid',
          'label'       => 'Madrid'
        ),
        array (
          'cc-aa'       => 'Comunidad Foral de Navarra',
          'province'  => 'Navarra',
          'label'       => 'Navarra'
        ),
        array (
          'cc-aa'       => 'Comunitat Valenciana',
          'province'  => 'Alacant',
          'label'       => 'Alicante'
        ),
        array (
          'cc-aa'       => 'Comunitat Valenciana',
          'province'  => 'Castelló',
          'label'       => 'Castellón'
        ),
        array (
          'cc-aa'       => 'Comunitat Valenciana',
          'province'  => 'València',
          'label'       => 'Valencia'
        ),
        array (
          'cc-aa'       => 'Extremadura',
          'province'  => 'Badajoz',
          'label'       => 'Badajoz'
        ),
        array (
          'cc-aa'       => 'Extremadura',
          'province'  => 'Cáceres',
          'label'       => 'Cáceres'
        ),
        array (
          'cc-aa'       => 'Galicia',
          'province'  => 'A Coruña',
          'label'       => 'La Coruña'
        ),
        array (
          'cc-aa'       => 'Galicia',
          'province'  => 'Lugo',
          'label'       => 'Lugo'
        ),
        array (
          'cc-aa'       => 'Galicia',
          'province'  => 'Ourense',
          'label'       => 'Orense'
        ),
        array (
          'cc-aa'       => 'Galicia',
          'province'  => 'Pontevedra',
          'label'       => 'Pontevedra'
        ),
        array (
          'cc-aa'       => 'Illes Balears',
          'province'  => 'Illes Balears',
          'label'       => 'Islas Baleares'
        ),
        array (
          'cc-aa'       => 'Melilla',
          'province'  => 'Melilla',
          'label'       => 'Melilla'
        ),
        array (
          'cc-aa'       => 'País Vasco',
          'province'  => 'Araba',
          'label'       => 'Álava'
        ),
        array (
          'cc-aa'       => 'País Vasco',
          'province'  => 'Bizkaia',
          'label'       => 'Vizcaya'
        ),
        array (
          'cc-aa'       => 'País Vasco',
          'province'  => 'Gipuzcoa',
          'label'       => 'Guipúzcoa'
        ),
        array (
          'cc-aa'       => 'Región de Murcia',
          'province'  => 'Murcia',
          'label'       => 'Murcia'
        ),
        array (
          'cc-aa'       => 'Rioja, La',
          'province'  => 'La Rioja',
          'label'       => 'La Rioja'
        ),
    );

    if(isset($province) && !empty($province)){
      $provinces = array_filter($provinces, function($prov) use ($province){
        return ($prov['province'] == $province) ? true : false;
      });
    }

    if($key_val){
      $provinces  = array_map(function($province){
        $copy       = $province;
        $province   = array();
        $key        =  sanitize_key($copy['province']);
        $province[$key] = $copy['label'];
        return $province;
      },$provinces);

      $clone = [];

      foreach($provinces AS $province){
        $clone = array_merge($clone,$province);
      }

      $provinces = $clone;
      
  }



  return $provinces;
}

$test = inmoob_get_es_provinces(true);

