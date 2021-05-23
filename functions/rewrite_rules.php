<?php


add_filter( 'post_type_link', function($post_link, $id = 0 ){

    $post = get_post($id);  

    if ( is_object( $post ) && $post->post_type == 'inmoob_properties'){

        $gestion_type = wp_get_object_terms( $post->ID, 'gestion_types' );
        $post_link = str_replace( '%gestion_type%' , ( $gestion_type) ?  $gestion_type[0]->slug : 'oferta' , $post_link );

        $property_type = wp_get_object_terms( $post->ID, 'property_types' );
        $post_link = str_replace( '%property_type%' , ( $property_type) ?  $property_type[0]->slug : 'inmuebles' , $post_link );

        $property_zone = wp_get_object_terms( $post->ID, 'property_zones' );
        $post_link = str_replace( '%property_zone%' , ( $property_zone) ?  $property_zone[0]->slug : 'espana' , $post_link );
    }
        return $post_link;

},0,2);


add_filter( 'term_link', function($term_link,$term, $taxonomy ){
    
    if($taxonomy == 'gestion_types'){
        $slug      = $term->slug;
        $term_link = str_replace('?gestion_types='.$slug,$slug,$term_link);
    }
   return $term_link;
},0,3);

add_action('init', function () {

    $terms = get_terms( array(
        'taxonomy'      => 'gestion_types',
        'hide_empty'    => false,
    ));

    foreach($terms AS $term){
        $slug = $term->slug;
        add_rewrite_rule( $slug.'\/?$', 'index.php?gestion_types='.$slug, 'top' );
        add_rewrite_rule( $slug.'/(?:[a-z0-9-]+)\/(?:[a-z0-9-]+)\/([a-z0-9-]+)\/?$', 'index.php?post_type=inmoob_properties&name=$matches[1]', 'top' );

    }
    add_rewrite_rule('^oferta/(?:[a-z0-9-]+)\/(?:[a-z0-9-]+)\/([a-z0-9-]+)\/?$', 'index.php?post_type=inmoob_properties&name=$matches[1]', 'top' );


    // flush_rewrite_rules(); // use only once
});