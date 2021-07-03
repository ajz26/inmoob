<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

function override_inmoob_data( $content ) {

    global $post;
    $post_id = (is_object($post))? $post->ID : null;
    $pattern = '/\{\{(?:(?<group>[\w\_\-]+)+(?:\:))?(?:(?<key>[\w\_\-]+))+(?:(?:\:)+(?<alt>[\s\w\_\-]+))?\}\}/';
    
    preg_match_all($pattern,$content,$matches, PREG_SET_ORDER);

    foreach($matches as $match){
        $group  = isset($match['group'])    ? sanitize_key($match['group'])     : null;
        $key    = isset($match['key'])      ? sanitize_key($match['key'])       : null;
        $alt    = isset($match['alt'])      ? sanitize_key($match['alt'])       : null;
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
           
        } 

        $value      = ($alt && !$value) ? $alt : $value; 
        $content    = str_replace($match[0],$value,$content);

    }

    return $content;

} 
add_filter('obser_override_content', 'override_inmoob_data',1000);
add_filter('wp_nav_menu_items', 'override_inmoob_data',1000);
   