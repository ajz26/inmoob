<?php

add_action('init',function(){


    
register_taxonomy( 'gestion_types', array( 'inmoob_properties' ), array(
    'labels'            => array(
        'name'                  => _x( 'Tipos de Gestión', 'Taxonomy plural name', 'obser' ),
        'singular_name'         => _x( 'Gestión', 'Taxonomy singular name', 'obser' ),
        'search_items'          => __( 'Buscar gestión', 'obser' ),
        'popular_items'         => __( 'Gestiones populares', 'obser' ),
        'all_items'             => __( 'Todas las gestiones', 'obser' ),
        'edit_item'             => __( 'Editar', 'obser' ),
        'update_item'           => __( 'Actualizar', 'obser' ),
        'add_new_item'          => __( 'Agregar nueva', 'obser' ),
        'new_item_name'         => __( 'Nueva', 'obser' ),
        'add_or_remove_items'   => __( 'Agregar o eliminar gestiones', 'obser' ),
        'choose_from_most_used' => __( 'Escoger desde las mas usadas', 'obser' ),
        'menu_name'             => __( 'Tipos de Gestión', 'obser' ),
    ),
    'public'            => true,
    'show_in_nav_menus' => false,
    'show_admin_column' => true,
    'hierarchical'      => false,
    'show_tagcloud'     => false,
    'show_ui'           =>  current_user_can('administrator') ? true : false,
    'query_var'         => true,
    'rewrite'           => false,
    'query_var'         => true,
    // 'meta_box_cb'       => false,
    'capabilities'      => array('manage_options'),
));

$GLOBALS['wp_rewrite']->use_verbose_page_rules = true;

register_taxonomy( 'gestion_states', array( 'inmoob_properties' ), array(
    'labels'            => array(
        'name'                  => _x( 'Estado de Gestión', 'Taxonomy plural name', 'obser' ),
        'singular_name'         => _x( 'Estado', 'Taxonomy singular name', 'obser' ),
        'search_items'          => __( 'Buscar estado', 'obser' ),
        'popular_items'         => __( 'Estados populares', 'obser' ),
        'all_items'             => __( 'Todas los estados', 'obser' ),
        'edit_item'             => __( 'Editar', 'obser' ),
        'update_item'           => __( 'Actualizar', 'obser' ),
        'add_new_item'          => __( 'Agregar nueva', 'obser' ),
        'new_item_name'         => __( 'Nueva', 'obser' ),
        'add_or_remove_items'   => __( 'Agregar o eliminar estados', 'obser' ),
        'choose_from_most_used' => __( 'Escoger desde las mas usadas', 'obser' ),
        'menu_name'             => __( 'Estados de gestión', 'obser' ),
    ),
    'public'            => false,
    'show_in_nav_menus' => false,
    'show_admin_column' => true,
    'hierarchical'      => false,
    'show_tagcloud'     => false,
    'show_ui'           =>  current_user_can('administrator') ? true : false,
    'query_var'         => true,
    'rewrite'           => true,
    'query_var'         => true,
    // 'meta_box_cb'       => false,
    'capabilities'      => array('manage_options'),
));


register_taxonomy( 'property_types', array( 'inmoob_properties' ), array(
    'labels'            => array(
        'name'                  => _x( 'Tipo de Inmueble', 'Taxonomy plural name', 'obser' ),
        'singular_name'         => _x( 'Tipo de inmuebles', 'Taxonomy singular name', 'obser' ),
        'search_items'          => __( 'Buscar tipo', 'obser' ),
        'popular_items'         => __( 'Tipos populares', 'obser' ),
        'all_items'             => __( 'Todas los tipos', 'obser' ),
        'edit_item'             => __( 'Editar', 'obser' ),
        'update_item'           => __( 'Actualizar', 'obser' ),
        'add_new_item'          => __( 'Agregar nuevo', 'obser' ),
        'new_item_name'         => __( 'Nuevo', 'obser' ),
        'add_or_remove_items'   => __( 'Agregar o eliminar tipo', 'obser' ),
        'choose_from_most_used' => __( 'Escoger desde las mas usadas', 'obser' ),
        'menu_name'             => __( 'Tipos de Inmuebles', 'obser' ),
    ),
    'public'            => true,
    'show_in_nav_menus' => false,
    'show_admin_column' => true,
    'hierarchical'      => false,
    'show_tagcloud'     => false,
    'show_ui'           =>  current_user_can('administrator') ? true : false,
    'query_var'         => true,
    'rewrite'               => array('slug' => '%gestion_type%', 'with_front' => false),
    'query_var'         => true,
    // 'meta_box_cb'       => false,
    'capabilities'      => array('manage_options'),
));


register_taxonomy( 'property_zones', array( 'inmoob_properties' ), array(
    'labels'            => array(
        'name'                  => _x( 'Zona', 'Taxonomy plural name', 'obser' ),
        'singular_name'         => _x( 'Zona', 'Taxonomy singular name', 'obser' ),
        'search_items'          => __( 'Buscar zona', 'obser' ),
        'popular_items'         => __( 'Zonas populares', 'obser' ),
        'all_items'             => __( 'Todas las zonas', 'obser' ),
        'edit_item'             => __( 'Editar', 'obser' ),
        'update_item'           => __( 'Actualizar', 'obser' ),
        'add_new_item'          => __( 'Agregar nueva', 'obser' ),
        'new_item_name'         => __( 'Nueva', 'obser' ),
        'add_or_remove_items'   => __( 'Agregar o eliminar zonas', 'obser' ),
        'choose_from_most_used' => __( 'Escoger desde las mas usadas', 'obser' ),
        'menu_name'             => __( 'Zonas', 'obser' ),
    ),
    'public'            => true,
    'show_in_nav_menus' => false,
    'show_admin_column' => true,
    'hierarchical'      => true,
    'show_tagcloud'     => false,
    'show_ui'           => true,
    'query_var'         => true,
    'rewrite'           => array('slug' => '%gestion_type%/%property_type%', 'with_front' => false),
    'query_var'         => true,
    // 'meta_box_cb'       => false,
    'capabilities'      => array('manage_options'),
));

register_taxonomy( 'property_rooms', array( 'inmoob_properties' ), array(
    'labels'            => array(
        'name'                  => _x( 'Habitaciones', 'Taxonomy plural name', 'obser' ),
        'singular_name'         => _x( 'Habitación', 'Taxonomy singular name', 'obser' ),
        'search_items'          => __( 'Buscar habitaciones', 'obser' ),
        'popular_items'         => __( 'Habitaciones populares', 'obser' ),
        'all_items'             => __( 'Todas las habitaciones', 'obser' ),
        'edit_item'             => __( 'Editar', 'obser' ),
        'update_item'           => __( 'Actualizar', 'obser' ),
        'add_new_item'          => __( 'Agregar nueva', 'obser' ),
        'new_item_name'         => __( 'Nueva', 'obser' ),
        'add_or_remove_items'   => __( 'Agregar o eliminar habitaciones', 'obser' ),
        'choose_from_most_used' => __( 'Escoger desde las mas usadas', 'obser' ),
        'menu_name'             => __( 'Habitaciones', 'obser' ),
    ),
    'public'            => false,
    'show_in_nav_menus' => false,
    'show_admin_column' => true,
    'hierarchical'      => false,
    'show_tagcloud'     => false,
    'show_ui'           =>  current_user_can('administrator') ? true : false,
    'query_var'         => true,
    'rewrite'           => true,
    'query_var'         => true,
    // 'meta_box_cb'       => false,
    'capabilities'      => array('manage_options'),
));


register_taxonomy( 'property_bathrooms', array( 'inmoob_properties' ), array(
    'labels'            => array(
        'name'                  => _x( 'Baños', 'Taxonomy plural name', 'obser' ),
        'singular_name'         => _x( 'Baño', 'Taxonomy singular name', 'obser' ),
        'search_items'          => __( 'Buscar baños', 'obser' ),
        'popular_items'         => __( 'Baños populares', 'obser' ),
        'all_items'             => __( 'Todas las habitaciones', 'obser' ),
        'edit_item'             => __( 'Editar', 'obser' ),
        'update_item'           => __( 'Actualizar', 'obser' ),
        'add_new_item'          => __( 'Agregar nuevo', 'obser' ),
        'new_item_name'         => __( 'Nueva', 'obser' ),
        'add_or_remove_items'   => __( 'Agregar o eliminar Baños', 'obser' ),
        'choose_from_most_used' => __( 'Escoger desde los mas usadas', 'obser' ),
        'menu_name'             => __( 'Baños', 'obser' ),
    ),
    'public'            => false,
    'show_in_nav_menus' => false,
    'show_admin_column' => true,
    'hierarchical'      => false,
    'show_tagcloud'     => false,
    'show_ui'           =>  current_user_can('administrator') ? true : false,
    'query_var'         => true,
    'rewrite'           => true,
    'query_var'         => true,
    // 'meta_box_cb'       => false,
    'capabilities'      => array('manage_options'),
));


register_taxonomy( 'property_state', array( 'inmoob_properties' ), array(
    'labels'            => array(
        'name'                  => _x( 'Estado de la propiedad', 'Taxonomy plural name', 'obser' ),
        'singular_name'         => _x( 'Estado', 'Taxonomy singular name', 'obser' ),
        'search_items'          => __( 'Buscar estado', 'obser' ),
        'popular_items'         => __( 'Estados populares', 'obser' ),
        'all_items'             => __( 'Todas los estados', 'obser' ),
        'edit_item'             => __( 'Editar', 'obser' ),
        'update_item'           => __( 'Actualizar', 'obser' ),
        'add_new_item'          => __( 'Agregar nuevo', 'obser' ),
        'new_item_name'         => __( 'Nuevo', 'obser' ),
        'add_or_remove_items'   => __( 'Agregar o eliminar estados', 'obser' ),
        'choose_from_most_used' => __( 'Escoger desde los mas usados', 'obser' ),
        'menu_name'             => __( 'Estado de la propiedad', 'obser' ),
    ),
    'public'            => false,
    'show_in_nav_menus' => false,
    'show_admin_column' => true,
    'hierarchical'      => false,
    'show_tagcloud'     => false,
    'show_ui'           =>  current_user_can('administrator') ? true : false,
    'query_var'         => true,
    'rewrite'           => true,
    'query_var'         => true,
    // 'meta_box_cb'       => false,
    'capabilities'      => array('manage_options'),
));



});