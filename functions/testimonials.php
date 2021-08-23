<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

add_filter( 'wp_insert_post_data' ,function ( $data , $postarr ) {
    if($data['post_type'] == 'inmoob_testimonials') {
      $name                 = (isset($postarr['name']) ? $postarr['name'] : '');
      $title                = 'Testimonio de '.$name;
      $post_slug            = sanitize_title_with_dashes ($title,'','save');
      $post_slugsan         = sanitize_title($post_slug);
      $data['post_title']   = $title;
      $data['post_name']    = $post_slugsan;
    }
    return $data;
} , '500', 2 );
