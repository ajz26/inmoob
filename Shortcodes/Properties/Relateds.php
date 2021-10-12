<?php

namespace Inmoob\Shortcodes\Properties;
use Inmoob\Shortcodes\Swiper;


class Relateds extends Swiper {

    static $shortcode       = "inmoob_related_props_swiper";
    static $wpb_namespace   = "Inmoob\\WPB_Components\\Properties";


    public static function after_register(){
        // add_filter('posts_clauses',array(__CLASS__,'posts_clauses_orderby_property_zones') , 10, 2 );
    }

    public static function show_first_same_location($order_by,$wp_query){
       
        global $wpdb, $post;
        $custom_order = null;

        if($property_zones_taxonomy         =  get_the_terms($post->ID,'property_zones_taxonomy')){
            $property_zones_taxonomy        = $property_zones_taxonomy[0];
            $term_id                        = $property_zones_taxonomy->term_id;

            if($wp_query->get("post_type") === 'inmoob_properties'){
                $custom_order  = " case WHEN property_zones_taxonomy.term_taxonomy_id IN ({$term_id}) then 0 else 1 end,";
                $custom_order  .=  $order_by;
            };
        }
               
        return $custom_order ?: $order_by;  

    }   

    public static function posts_clauses_orderby_property_zones( $clauses, $wp_query ) {

        global $wpdb;
    
        if(isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'property_zones_taxonomy'){
    
            $property_zones = get_terms( array(
                'taxonomy'      => 'property_zones_taxonomy',
                'hide_empty'    => false,
                'fields'        => 'tt_ids'
            ) );
        
            $gst = implode(',',$property_zones); 
    
            $clauses['join']  .="LEFT JOIN {$wpdb->term_relationships} AS property_zones_taxonomy ON ( {$wpdb->posts}.ID=property_zones_taxonomy.object_id)";
            $clauses['where'] .= "AND property_zones_taxonomy.term_taxonomy_id IN ({$gst})";
        }
    
        return $clauses;
    }



    public static function buildItems()
    {   

        
        // add_filter('posts_orderby', array(__CLASS__,'show_first_same_location'),1, 2);
        // remove_filter('posts_orderby',array(__CLASS__,'show_first_same_location'),2); 
        parent::buildItems();
    }



    static function buildQuery(array $atts){
        
        $settings   = parent::buildQuery($atts);
        
        global $post;

        $tax_query = array();

        if($gestion_types_taxonomy =  get_the_terms($post->ID,'gestion_types_taxonomy')){
            $gestion_types_taxonomy    = $gestion_types_taxonomy[0];
            $tax_query[] = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'gestion_states_taxonomy',
                    'field'    => 'slug',
                    'terms'    => 'disponible',
                ),
                array(
                    'taxonomy' => 'gestion_types_taxonomy',
                    'field'    => 'slug',
                    'terms'    => $gestion_types_taxonomy->slug,
                )
            );
        }
       
        $related_taxs = array(
            'relation' => 'OR',
        );

        if($gestion_types_taxonomy =  get_the_terms($post->ID,'gestion_types_taxonomy')){
            $gestion_types_taxonomy    = $gestion_types_taxonomy[0];
            $related_taxs[] = array(
                'taxonomy' => 'gestion_types_taxonomy',
                'field'    => 'slug',
                'terms'    => $gestion_types_taxonomy->slug,
            );
        }
        
        if($property_zones_taxonomy     =  get_the_terms($post->ID,'property_zones_taxonomy')){
            $property_zones_taxonomy    = $property_zones_taxonomy[0];
            $related_taxs[] = array(
                'taxonomy' => 'property_zones_taxonomy',
                'field'    => 'slug',
                'terms'    => $property_zones_taxonomy->slug,
            );
        }


        if($property_types_taxonomy =  get_the_terms($post->ID,'property_types_taxonomy')){
            $property_types_taxonomy    = $property_types_taxonomy[0];
    
            $related_taxs[] = array(
                'taxonomy' => 'property_types_taxonomy',
                'field'    => 'slug',
                'terms'    => $property_types_taxonomy->slug,
            );
        }

        if(count($related_taxs) >= 1){
            $tax_query[] = $related_taxs;
        }

        



        $settings['tax_query']      = $tax_query;
        $settings['post__not_in']   = (array)$post->ID;
        $settings['orderby']        = 'property_zones_taxonomy';
        
        return $settings;
    }

}


 