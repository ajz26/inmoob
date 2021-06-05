<?php


add_filter( 'post_type_link', function($post_link, $id = 0 ){

    $post = get_post($id);  

    if ( is_object( $post ) && $post->post_type == 'inmoob_properties'){

        $gestion_type = wp_get_object_terms( $post->ID, 'gestion_types_taxonomy' );
        $post_link = str_replace( '%gestion_type%' , ( $gestion_type) ?  $gestion_type[0]->slug : 'oferta' , $post_link );

        $property_type = wp_get_object_terms( $post->ID, 'property_types_taxonomy' );
        $post_link = str_replace( '%property_type%' , ( $property_type) ?  $property_type[0]->slug : 'inmuebles' , $post_link );

        $property_zone = wp_get_object_terms( $post->ID, 'property_zones_taxonomy' );
        $post_link = str_replace( '%property_zone%' , ( $property_zone) ?  $property_zone[0]->slug : 'espana' , $post_link );
    }
        return $post_link;

},0,2);


add_filter( 'term_link', function($term_link,$term, $taxonomy ){
    $slug      = $term->slug;

    switch($taxonomy){
        
        case 'property_zones_taxonomy':
            $term_link = str_replace('%property_type%','inmuebles',$term_link);
        case 'property_types_taxonomy':
            $term_link = str_replace('%gestion_type%','ofertas',$term_link);
        break;

        case 'gestion_types_taxonomy':
            $term_link = str_replace('?gestion_types_taxonomy='.$slug,$slug,$term_link);
        break;
    }
   return $term_link;

},0,3);

add_action('init', function () {

    $gestion_types = get_terms( array(
        'taxonomy'      => 'gestion_types_taxonomy',
        'hide_empty'    => false,
    ));

    foreach($gestion_types AS $gestion_type){
        $gestion_type_slug = $gestion_type->slug;
        add_rewrite_rule( $gestion_type_slug.'\/inmuebles\/?$', 'index.php?gestion_types_taxonomy='.$gestion_type_slug, 'top' );
        add_rewrite_rule( $gestion_type_slug.'\/?$', 'index.php?gestion_types_taxonomy='.$gestion_type_slug, 'top' );
        add_rewrite_rule( $gestion_type_slug.'/(?:[a-z0-9-]+)\/(?:[a-z0-9-]+)\/([a-z0-9-]+)\/?$', 'index.php?post_type=inmoob_properties&name=$matches[1]', 'top');
    }
    add_rewrite_rule('^oferta/(?:[a-z0-9-]+)\/(?:[a-z0-9-]+)\/([a-z0-9-]+)\/?$', 'index.php?post_type=inmoob_properties&name=$matches[1]', 'top' );


    $propery_types = get_terms( array(
        'taxonomy'      => 'property_types_taxonomy',
        'hide_empty'    => false,
    ));

    foreach($propery_types AS $propery_type){
        $propery_type_slug = $propery_type->slug;

        foreach($gestion_types AS $gestion_type){
            $gestion_type_slug = $gestion_type->slug;
            add_rewrite_rule( '^'.$gestion_type_slug.'\/'.$propery_type_slug.'\/?$', 'index.php?property_types_taxonomy='.$propery_type_slug.'&gestion_type='.$gestion_type_slug, 'top' );
        }
        add_rewrite_rule( '^ofertas\/'.$propery_type_slug.'\/?$', 'index.php?property_types_taxonomy='.$propery_type_slug, 'top' );
    
    }


    $property_zones = get_terms( array(
        'taxonomy'      => 'property_zones_taxonomy',
        'hide_empty'    => false,
    ));


    foreach($property_zones AS $property_zone){
        $property_zone_slug = $property_zone->slug;

        foreach($gestion_types AS $gestion_type){
            $gestion_type_slug = $gestion_type->slug;

                foreach($propery_types AS $propery_type){

                    $propery_type_slug = $propery_type->slug;
                    add_rewrite_rule( '^'.$gestion_type_slug.'\/'.$propery_type_slug.'\/'.$property_zone_slug.'\/?$', 'index.php?property_zones_taxonomy='.$property_zone_slug.'&gestion_type='.$gestion_type_slug.'&property_type='.$propery_type_slug, 'top' );
                    add_rewrite_rule( '^'.$gestion_type_slug.'\/inmuebles\/'.$property_zone_slug.'\/?$', 'index.php?property_zones_taxonomy='.$property_zone_slug.'&gestion_type='.$gestion_type_slug, 'top' );
                    add_rewrite_rule( '^ofertas\/'.$propery_type_slug.'\/'.$property_zone_slug.'\/?$', 'index.php?property_zones_taxonomy='.$property_zone_slug.'&gestion_type='.$gestion_type_slug.'&property_type='.$propery_type_slug, 'top' );
                }
        }
        add_rewrite_rule( '^ofertas/inmuebles\/'.$property_zone_slug.'\/?$', 'index.php?property_zones_taxonomy='.$property_zone_slug, 'top' );
    
    }




    // flush_rewrite_rules(); // use only once
});


add_filter('query_vars',function($query_vars){
    return array_merge($query_vars,array(
        'property_types_taxonomy',
        'gestion_types_taxonomy',
        'property_zones_taxonomy',
        'property_type',
        'gestion_type',
        'property_zone',
    ));
},10,1);
