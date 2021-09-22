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
            'rewrite'               => array('with_front'=> false, 'slug' => '%gestion_type%/%property_type%/%property_zone%'),
			'query_var'             => false,
		)
	);


	register_post_type(
		'inmoob_testimonials', array(
			'labels' => array(
				'name'              => _x( 'Testimoniales', 'site top area', 'ccom' ),
				'singular_name'     => _x( 'Testimonial', 'site top area', 'ccom' ),
				'add_new'           => _x( 'Agregar Testimonial', 'site top area', 'ccom' ),
				'add_new_item'      => _x( 'Agregar Testimonial', 'site top area', 'ccom' ),
				'edit_item'         => _x( 'Editar Testimonial', 'site top area', 'ccom' ),
			),
			'public'                => true,
            'menu_icon'      		=> 'dashicons-admin-multisite',
            'show_in_menu'          => 'inmoob-settings',
			'exclude_from_search'   => false,
			'show_in_admin_bar'     => true,
			'publicly_queryable'    => false,
			'show_in_nav_menus'     => false,
			'supports'              => array('thumbnail'),
			'query_var'             => false,
		)
	);


	register_post_type(
		'inmoob_leads', array(
			'labels' => array(
				'name'              => _x( 'Leads', 'site top area', 'ccom' ),
				'singular_name'     => _x( 'Leads', 'site top area', 'ccom' ),
				'add_new'           => _x( 'Agregar lead', 'site top area', 'ccom' ),
				'add_new_item'      => _x( 'Agregar lead', 'site top area', 'ccom' ),
				'edit_item'         => _x( 'Editar lead', 'site top area', 'ccom' ),
			),
			'public'                => true,
            'menu_icon'      		=> 'dashicons-admin-multisite',
            'show_in_menu'          => 'inmoob-settings',
			'exclude_from_search'   => false,
			'show_in_admin_bar'     => false,
			'publicly_queryable'    => false,
			'show_in_nav_menus'     => false,
			'supports'              => array(''),
			'query_var'             => false,
			'capability_type' 		=> 'post',
			'map_meta_cap' 			=> false,
			'capabilities' => array(
				'create_posts' => false, 
			),
		)
	);


});


add_action("admin_menu", function () {

    remove_action('admin_menu', '_add_post_type_submenus');
    add_action( 'admin_menu', '_add_post_type_submenus', 200);

}, 1);