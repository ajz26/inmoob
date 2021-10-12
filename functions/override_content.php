<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );
use Obser\Classes\Settings;

function override_inmoob_data( $content ) {

    global $post;
    $post_id = (is_object($post))? $post->ID : null;
    $pattern = '/[\[\{]{2}(?:(?<group>[\w\_\-]+)+(?:\:))?(?:(?<key>[\w\_\-]+))+(?:(?:\:)+(?<alt>[\s\w\_\-\,]+))?[\]\}]{2}/';
    
    preg_match_all($pattern,$content,$matches, PREG_SET_ORDER);

    foreach($matches as $match){
        $group  = isset($match['group'])    ? sanitize_key($match['group'])     : null;
        $key    = isset($match['key'])      ? sanitize_key($match['key'])       : null;
        $alt    = isset($match['alt'])      ? $match['alt']                     : null;
        $value  = null;

        
        switch($group){
            case 'current_term':
                $term            = get_queried_object();
                switch ($key){
                    case 'count':
                        $value  = $term->count;
                    break;
                    case 'name':
                        $value  = $term->name;
                    break;
                    case 'label':
                        $key  = ($term->count == 1) ? 'singular_label' : 'plural_label';
                        $value  = get_term_meta($term->term_id,$key,true);
                    break;
                    default:
                    $value  = get_term_meta($term->term_id,$key,true);
                }

            break;

            case 'gestion_types':
            
            if($gestion_type  = get_query_var('gestion_types_taxonomy') ? get_query_var('gestion_types_taxonomy') : (get_query_var('gestion_type') ?: null)){
                

                $gestion_types_taxonomy = get_term_by('slug', $gestion_type ,'gestion_types_taxonomy');


                switch ($key){
                    case 'count':
                        $value  = $gestion_types_taxonomy->count;
                    break;
                    case 'name':
                        $value  = $gestion_types_taxonomy->name;
                    break;
                    case 'label':
                        $key    = ($gestion_types_taxonomy->count == 1) ? 'singular_label' : 'plural_label';
                        $value  = get_term_meta($gestion_types_taxonomy->term_id,$key,true);
                        $value  = (isset($value) && !empty($value)) ? $value : (($key == 'singular_label') ? 'oferta' : 'Oferta');
                    break;
                    default:
                    $value  = get_term_meta($gestion_types_taxonomy->term_id,$key,true);
                }

            }
            break;
            case 'property_type':
            
                if($property_type  = get_query_var('property_types_taxonomy') ? get_query_var('property_types_taxonomy') : (get_query_var('property_type') ?: null)){
                    
                    $property_types_taxonomy = get_term_by('slug', $property_type ,'property_types_taxonomy');

                    if(!$property_types_taxonomy || is_wp_error( $property_types_taxonomy )){
                        continue(2);
                    }
    
                    switch ($key){
                        case 'count':
                            $value  = $property_types_taxonomy->count;
                        break;
                        case 'name':
                            $value  = $property_types_taxonomy->name;
                        break;
                        case 'label':
                            $key    = ($property_types_taxonomy->count == 1) ? 'singular_label' : 'plural_label';
                            $value  = get_term_meta($property_types_taxonomy->term_id,$key,true);
                            $value  = (isset($value) && !empty($value)) ? $value : (($key == 'singular_label') ? 'Propiedad' : 'Propiedades');
                        break;
                        default:
                        $value  = get_term_meta($property_types_taxonomy->term_id,$key,true);
                    }
                }
            
            break;
            case 'property_zone':
            
                if($property_zone  = get_query_var('property_zones_taxonomy') ? get_query_var('property_zones_taxonomy') : (get_query_var('property_zone') ?: null)){
                    
                    $property_zones_taxonomy = get_term_by('slug', $property_zone ,'property_zones_taxonomy');
                    if(!$property_zones_taxonomy || is_wp_error( $property_zones_taxonomy )){
                        continue(2);
                    }
                    switch ($key){
                        case 'count':
                            $value  = $property_zones_taxonomy->count;
                        break;
                        case 'name':
                            $value  = $property_zones_taxonomy->name;
                        break;
                        case 'label':
                            $key    = ($property_zones_taxonomy->count == 1) ? 'singular_label' : 'plural_label';
                            $value  = get_term_meta($property_zones_taxonomy->term_id,$key,true);
                        break;
                        default:
                        $value  = get_term_meta($property_zones_taxonomy->term_id,$key,true);
                    }
                }
            
            break;
    

            case 'post':
                global $post;
                if(!$post){
                    continue(2);
                }
                switch ($key){
                    case 'title':
                        $value  = get_the_title($post);
                    break;
                    case 'content':
                         $value  = $post->content;

                    break;
                    default:
                    $value  = get_post_meta($post->ID,$key,true);
                }
            break; 

            case 'post':
                global $post;
                switch ($key){
                    case 'title':
                        $value  = get_the_title($post);
                    break;
                    case 'content':
                         $value  = get_the_content($post);
                    break;
                    default:
                    $value  = get_post_meta($post->ID,$key,true);
                }
            break; 

            case 'settings':

            $value      = isset($key) ? Settings::get_setting('inmoob-settings',$key) : null;

            break;
           
        } 

        $value      = ($alt && !$value) ? $alt : $value; 
        $content    = str_replace($match[0],$value,$content);

    }

    return $content;

} 
add_filter('obser_override_content', 'override_inmoob_data',1000);
add_filter('wp_nav_menu_items', 'override_inmoob_data',1000);
   


