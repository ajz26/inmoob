<?php
namespace Inmoob\Classes;

use stdClass;
use WP_Term;
class Api {


    private static function get_terms($taxonomy,array $args = array()){
        $args  = array_merge(array(
            'hide_empty' => true,
        ),$args);
        $terms = get_terms($taxonomy,$args);
        return $terms;
    }


    static function get_terms_select($taxonomy,$args = array(), string $field ='slug'){
        $terms = self::get_terms($taxonomy,$args);
        $terms = array_map(array(__CLASS__,"reduce_array_by_{$field}"),$terms);
        $terms = array_map(array(__CLASS__,"parse_options"),$terms);

        return $terms;
    }

    private static function parse_options($item){
        $copy = clone $item;
        $item = new stdClass();
        $item->val      = $copy->slug;
        $item->label    = $copy->name;
        $item->meta     = $copy->meta;
        return $item;
    }

    private static function reduce_array_by_slug($item){
        $copy = clone $item;
        $item = new stdClass();
        $item->slug     = $copy->slug;
        $item->name     = $copy->name;
        $item->meta     = array(
            'taxonomy'     => $copy->taxonomy,
            'count'        => $copy->count,
            'description'  => $copy->description,
        );
        return $item;
    }

    private static function custom_sql_query(string $sql){
        global $wpdb;

        $results = $wpdb->get_results($sql);

        return $results;
    }

    private static function sql_parse_in(array $array){
        if(empty($array)) return null;
         return implode(',',array_map(function($option){
            return "'{$option}'";
         },$array));
        
    }

    static function get_meta_options($field  = array(), $taxonomy = array() , array $post_type = array('inmoob_properties') ){
        
        global $wpdb;
        $prefix     = $wpdb->prefix;
        $field      = self::sql_parse_in((array)$field);
        $post_type  = self::sql_parse_in((array)$post_type);
        $taxonomy   = self::sql_parse_in((array)$taxonomy);
        $select     =  "SELECT DISTINCT
                            meta.meta_value AS meta_value";

        $select    .=  " FROM
                            {$prefix}postmeta AS meta
                            INNER JOIN {$prefix}posts ON meta.post_id = {$prefix}posts.ID";
        if(!empty($taxonomy)){
            $select    .=   " INNER JOIN {$prefix}term_relationships AS tr ON (meta.post_id = tr.object_id)
                             INNER JOIN {$prefix}term_taxonomy AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
                             INNER JOIN {$prefix}terms AS t ON (t.term_id = tt.term_id)";
        }

        $select    .=  " WHERE
                            meta_key  IN ({$field}) 
                            AND meta.meta_value <> '' 
                            AND {$prefix}posts.post_type IN ({$post_type}) 
                            AND {$prefix}posts.post_status = 'publish'";
        if(!empty($taxonomy)){
            $select    .=   "AND tt.term_id IN ({$taxonomy})";
        }
        
        $select    .=  " ORDER BY
                        meta.meta_value";

        return self::custom_sql_query($select);
    }


    private static function parse_num_meta($_meta){
        $_meta->meta_value = str_replace('.','',$_meta->meta_value);
        // $_meta->meta_value = number_format($_meta->meta_value,0,'.',',');
        return (array)$_meta;
    }


    private static function min_max($_meta){
        $meta_values    = array_column($_meta, 'meta_value');

        $min_max_array = array(
            'min' => min($meta_values),
            'max' => max($meta_values)
        );

        var_dump($min_max_array);

        return $min_max_array;
    }


    static function get_options_range(string $field, $taxonomy = array() , array $post_type = array('inmoob_properties')){

        $options = self::get_meta_options($field,$taxonomy,$post_type);
        $options = array_map(array(__CLASS__,'parse_num_meta'),$options);
        $options = self::min_max($options);

        // return $options;
    }

    

}