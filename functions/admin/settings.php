<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

use OBSER\Classes\Settings;

add_filter('obser_framework_logo',function(){
    return INMOOB_CORE_PLUGIN_DIR_URL.'/assets/images/logo-light.png';
},0);


Settings::set_args('inmoob-settings',array(
    'display_name'  =>  Settings::get_setting('inmoob-settings','business_name') ?: 'Inmoob',
    'menu_title'    => 'Inmoob',
    // 'page_parent'   => '',
    'page_slug'     => 'inmoob-settings'
));

Settings::set_section('inmoob-settings',array(
    'title'   => 'Datos Corporativos',
    'heading' => 'Datos básicos',
    'desc'    => 'Descripción',
    'fields'  => array(
        array(
            'name'          => 'logo',
            'title'         => 'Icono de la empresa',
            'description'   => 'sube el icono de la empresa',
            'type'          => 'media_link',
        ),
        array(
            'name'          => 'business_name',
            'title'         => 'Nombre de la empresa',
            'description'   => 'Indíca el nombre de la empresa',
            'type'          => 'textfield',
        ),
        array(
            'name'          => 'business_nif',
            'title'         => 'NIF de la empresa',
            'description'   => 'Indíca el nombre de la empresa',
            'type'          => 'textfield',
        ),
    )
));

Settings::set_section('inmoob-settings',array(
    'title'   => 'Datos de contacto',
    'heading' => 'Contacto',
    'desc'    => 'Descripción',
    'fields'  => array(

        array(
            'name'          => 'business_phone',
            'title'         => 'Teléfono',
            'description'   => 'Teléfono de la empresa',
            'type'          => 'textfield',
        ),
        array(
            'name'          => 'business_email',
            'title'         => 'Email',
            'description'   => 'Email de la empresa',
            'type'          => 'textfield',
        ),
        array(
            'name'          => 'business_address',
            'title'         => 'Dirección',
            'description'   => 'Dirección de la empresa',
            'type'          => 'textarea',
        ),
    )
));

Settings::set_section('inmoob-settings',array(
    'title'   => 'Redes sociales',
    'heading' => 'Social',
    'desc'    => 'Descripción',
    'fields'  => array(
        array(
            'name'          => 'business_whatsapp',
            'title'         => 'Whatsapp',
            'description'   => 'Whatsapp de la empresa',
            'type'          => 'textfield',
        ),
       
        array(
            'name'          => 'business_facebook_link',
            'title'         => 'Facebook link',
            'description'   => 'Dirección de la empresa',
            'type'          => 'textfield',
        ),
        array(
            'name'          => 'business_instagram_link',
            'title'         => 'Instagram link',
            'description'   => 'Dirección de la empresa',
            'type'          => 'textfield',
        ),
        array(
            'name'          => 'business_whatsapp_link',
            'title'         => 'Whatsapp link',
            'description'   => 'Dirección de la empresa',
            'type'          => 'textfield',
        ),
    )
));

add_action('init', function(){
    Settings::init('inmoob-settings');
},100);