<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

add_action('init',function(){

    register_post_type(
		'inmoob_properties', array(
			'labels' => array(
				'name'              => _x( 'Propiedades', 'site top area', 'ccom' ),
				'singular_name'     => _x( 'Propiedad', 'site top area', 'ccom' ),
				'add_new'           => _x( 'Agregar Propiedad', 'site top area', 'ccom' ),
				'add_new_item'      => _x( 'Agregar Propiedad', 'site top area', 'ccom' ),
				'edit_item'         => _x( 'Editar Propiedad', 'site top area', 'ccom' ),
			),
			'public'                => true,
            'menu_icon'      => 'dashicons-admin-multisite',
            // 'show_in_menu'          => 'inmoob-settings',
			'exclude_from_search'   => false,
			'show_in_admin_bar'     => true,
			'publicly_queryable'    => true,
			'show_in_nav_menus'     => true,
			'map_meta_cap'          => true,
			'supports'              => array('title','thumbnail'),
            'rewrite'               => array('slug' => '%gestion_type%/%property_type%/%property_zone%'),
			'query_var'             => false,
		)
	);

});