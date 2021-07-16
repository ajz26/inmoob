<?php

namespace Inmoob\Shortcodes;

use OBSER\Classes\Shortcode;

class BreadCrumbs extends Shortcode {
    
    static $shortcode       = "inmoob_breadcrumbs";
    static $wpb_namespace   = "Inmoob\\WPB_Components";

    static function generate_css(){
        
    }

    static function general_styles(){

        return ".breadcrumbs__link i {
            margin-right: .5rem;
        }
        
        .breadcrumbs {
            font-weight: bold;
        }
        ";
    }


    static function output($atts, $content){
        $el_id              = self::get_atts('el_id');
        $el_class           = self::get_atts('el_class');  
        $text               = [];
        $text['home']       = "<i class='far fa-home'></i> " . self::get_atts('home_text','Inicio');
        $text['404']        = 'Error 404';
        $separator          = '>';
        $wrap_before        = "<div id=\"{$el_id}\" class=\" breadcrumbs breadcrumbs-el--$el_id {$el_class}\" itemscope itemtype=\"http://schema.org/BreadcrumbList\">";
        $wrap_after         = '</div><!-- .breadcrumbs -->';
        $sep                = "<span class='breadcrumbs__separator'> $separator </span>";
        $before             = '<span class="breadcrumbs__current">';
        $after              = '</span>';
         
        $show_home_link     = true;
        $show_current       = self::get_atts('show_current',false);
        $html               = ""; 

    
        global $post;
        $home_url           = home_url('/');
        $link               = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
        $link              .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
        $link              .= '<meta itemprop="position" content="%3$s" />';
        $link              .= '</span>';
        $parent_id          = ( $post ) ? $post->post_parent : '';
        $home_link          = sprintf( $link, $home_url, $text['home'], 1 );
    
        if ( is_home() || is_front_page()) {
            return $wrap_before . $home_link . $wrap_after;
        } 
    
        $position    = 0;
        $html       .= $wrap_before;

        if ( $show_home_link ) {
            $position += 1;
            $html .= $home_link;
        }



        if ( is_single() && ! is_attachment() ) {

            if ( get_post_type() == 'inmoob_properties' ) {
                $position += 1;
                $post_type = get_post_type_object( get_post_type() );

                if ( $position > 1 ) $html .= $sep;
                global $post;

                $gestion_types_taxonomy_slug = 'ofertas';
                if($gestion_types_taxonomy =  get_the_terms($post->ID,'gestion_types_taxonomy')){
                    $gestion_types_taxonomy = $gestion_types_taxonomy[0];
                    $tax_url = get_term_link( $gestion_types_taxonomy, 'gestion_types_taxonomy');
                    $gestion_types_taxonomy_slug = $gestion_types_taxonomy->slug ?: $gestion_types_taxonomy_slug ;
                    $html .= sprintf( $link, $tax_url , $gestion_types_taxonomy->name, $position );
                }
                $property_types_taxonomy_slug   = 'inmuebles' ;

                if($property_types_taxonomy         =  get_the_terms($post->ID,'property_types_taxonomy')){
                    $property_types_taxonomy        = $property_types_taxonomy[0];
                    $property_types_taxonomy_slug   = $property_types_taxonomy->slug ?: $property_types_taxonomy_slug;
                    $tax_url                        = get_term_link( $property_types_taxonomy, 'property_types_taxonomy');
                    $tax_url                        = str_replace('ofertas',$gestion_types_taxonomy_slug,$tax_url);
                    $html                          .= $sep . $before . sprintf( $link, $tax_url , $property_types_taxonomy->name, $position ). $after;
                }

                if($property_zones_taxonomy =  get_the_terms($post->ID,'property_zones_taxonomy')){
                    $property_zones_taxonomy    = $property_zones_taxonomy[0];
                    $tax_url                    = get_term_link( $property_zones_taxonomy, 'property_zones_taxonomy');
                    $tax_url                    = str_replace('ofertas',$gestion_types_taxonomy_slug,$tax_url);
                    $tax_url                    = str_replace('inmuebles',$property_types_taxonomy_slug,$tax_url);
                    $html                      .= $sep . $before . sprintf( $link, $tax_url , $property_zones_taxonomy->name, $position ). $after;
                }

                if ( $show_current ) $html .= $sep . $before . get_the_title() . $after;


            } else {
                $cat     = get_the_category(); $catID = $cat[0]->cat_ID;
                $parents = get_ancestors( $catID, 'category' );
                $parents = array_reverse( $parents );
                $parents[] = $catID;
                foreach ( $parents as $cat ) {
                    $position += 1;
                    if ( $position > 1 ) $html .= $sep;
                   
                }

                $post_type = get_post_type();
                // // $page_list = CORE_HELPERS::get_option("{$post_type}_page_list");
                // // $page_name = get_the_title($page_list);
                // // $page_link = get_permalink($page_list);
                // $html .= $sep;
                // $html .= sprintf( $link, $page_link ,$page_name, $position );
                
                if ( $show_current ) $html .= $sep . $before . get_the_title() . $after;
            }

        } elseif ( is_page() && ! $parent_id ) {
            if ( $show_home_link && $show_current ) $html .= $sep;
            if ( $show_current ) $html .= $before . get_the_title() . $after;

        } elseif ( is_page() && $parent_id ) {
            $parents = get_post_ancestors( get_the_ID() );
            foreach ( array_reverse( $parents ) as $pageID ) {
                $position += 1;
                if ( $position > 1 ) $html .= $sep;
                $html .= sprintf( $link, get_page_link( $pageID ), get_the_title( $pageID ), $position );
            }
            if ( $show_current ) $html .= $sep . $before . get_the_title() . $after;

        }  elseif ( is_archive() ) {
           $name            = get_queried_object()->name;
           if ( $show_current && $name ) $html .= $sep . $before . $name . $after;
        }  elseif ( is_404() ) {
            if ( $show_home_link && $show_current ) $html .= $sep;
            if ( $show_current ) $html .= $before . $text['404'] . $after;
        }

        $html .= $wrap_after;
        return $html;
    }
}