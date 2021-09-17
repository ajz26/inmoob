<?php

namespace Inmoob\Shortcodes;

use OBSER\Shortcodes\_Grid;
use Inmoob\Classes\Api;
 
class SearchGrid extends _Grid {

    static $shortcode = "inmoob_search_grid";
    static $wpb_namespace = "Inmoob\\WPB_Components";
    static $grid_settings = null;

    static function set_default_atts(){
        parent::set_default_atts();
        static::$attributes_defaults = array_merge(static::$attributes_defaults,array(
            '_gid'      => '',
            'post_type' => '',
            'filters'   => array(),
        ));
    }


    static function buildQuery(array $atts){
        
        $tax_query = array(
            'relation' => 'AND'
        );
       
        $settings   = parent::buildQuery($atts);


        $order      = static::get_order_atts();
        $meta_query = $settings['meta_query'] ?: [];

        if(in_array($order['orderby'],['price'])){

        $meta_query[] = array(
            'relation' => 'OR',
            $order['orderby'] => array(
                'key'           => $order['orderby'],
                'type'          => 'NUMERIC',
                // 'meta_compare'  => 'NOT IN'
            )
        );
            
        $settings['orderby']    = array($order['orderby'] => $order['order']);
        $settings['meta_query'] = $meta_query;
        
        }

        if($atts['filters']){
            $tax_query_fields = 0;
            foreach((array)$atts['filters'] AS $taxonomy => $value){
                if(\preg_match('/\_taxonomy$/',$taxonomy) && isset($value) && !empty($value)){
                    $tax_query_fields++;
                    if(in_array('-',(array)$value)){
                        $value = array();  
                    }

                    if(empty($value) || !isset($value)) continue;
                    
                    $tax_query[] = array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'slug',
                        'terms'    => $value,
                    ); 
                }
            }


            if($tax_query_fields > 0 ){
                $settings['tax_query'] = $tax_query;
            }



        }

        

        if(isset($atts['filters']['property_price_min']) || isset($atts['filters']['property_price_max'])){
            $gestion_type = $atts['filters']['gestion_types_taxonomy'];
            $gestion_type = get_term_by('slug', $gestion_type ,'gestion_types_taxonomy');
            $data         = Api::get_options_range('price',$gestion_type);
            $property_price_min = isset($atts['filters']['property_price_min']) && $atts['filters']['property_price_min'] != '-' ? intval($atts['filters']['property_price_min']) : intval($data['min']);
            $property_price_max = isset($atts['filters']['property_price_max']) && $atts['filters']['property_price_max'] != '-' ? intval($atts['filters']['property_price_max']) : intval($data['max']);
            
            $settings['meta_query'] = array_merge($settings['meta_query'],array(
                'relation' => 'OR',
                array(
                    'type'      => 'NUMERIC',
                    'key'       => 'price',
                    'value'     => array($property_price_min,$property_price_max),
                    'compare'   => 'BETWEEN'
                ),
                $settings['meta_query'][] = array(
                    'type'      => 'NUMERIC',
                    'key'       => 'sales_price',
                    'value'     => array($property_price_min,$property_price_max),
                    'compare'   => 'BETWEEN'
                ),
            ));
        }


        if(isset($atts['filters']['no_docs']) || isset($atts['filters']['no_docs'])){
           
         
            $settings['meta_query'] = array_merge($settings['meta_query'],array(
                'relation' => 'AND',
                array(
                    'type'      => 'NUMERIC',
                    'key'       => 'no_docs',
                    'value'     => 1,
                    'compare'   => '='
                ),
            ));



        }

        return $settings;
    }

    static function buildAtts($atts = array(), $content = null){

        static::set_order_methods();

        parent::buildAtts($atts, $content);

        $shortcode_id   = static::get_atts('shortcode_id');
        $post_type      = static::get_atts('post_type',array());
        static::set_att('post_type',$post_type[0]);
        $cookie         = static::get_cookie_data($shortcode_id);

        // if (!defined('DOING_AJAX') || !DOING_AJAX) {
        //     if (isset($cookie['paged'])) {
        //         static::set_att('paged', $cookie['paged']);
        //     }
        // }


        // $filters = static::get_atts('filters');
        // $filters = array_merge((array)$filters,$atts['filters']);
        // static::set_att('filters',$filters);

        // $taxonomy = static::extract_taxonomy_from_search_form();





        $property_type_var      = get_query_var('property_types_taxonomy') ?: get_query_var('property_type') ?: null;
        $gestion_type_var       = get_query_var('gestion_types_taxonomy') ?: get_query_var('gestion_type')  ?: null;
        $property_zone_var      = get_query_var('property_zones_taxonomy') ?: get_query_var('property_zone') ?: null;
        $post_type              = self::get_atts('post_type');

        
        
        $post_type_taxonomies   = get_object_taxonomies($post_type);
            
        if(isset($property_type_var) && !empty($property_type_var)){
    // if(isset($property_type_var) && !empty($property_type_var) && in_array($property_type_var,$post_type_taxonomies)){
            $filters            = static::get_atts('filters');
            $filters['property_types_taxonomy'] = $property_type_var;
            static::$grid_settings['filters']['property_types_taxonomy'] = $property_type_var;
            static::set_att('filters',$filters);
        }

        if(isset($gestion_type_var) && !empty($gestion_type_var)){
            $filters            = static::get_atts('filters');
            $filters['gestion_types_taxonomy'] = $gestion_type_var;
            static::$grid_settings['filters']['gestion_types_taxonomy'] = $gestion_type_var;

            static::set_att('filters',$filters);
        }

        if(isset($property_zone_var) && !empty($property_zone_var)){
            $filters            = static::get_atts('filters');
            $filters['property_zones_taxonomy'] = $property_zone_var;
            static::$grid_settings['filters']['property_zones_taxonomy'] = $property_zone_var;
            static::set_att('filters',$filters);
        }


    }


    public static function renderItems(){
        $output         = $items = '';
        $filter_terms   = static::$filter_terms;
        $atts           = static::get_atts();
        $settings       = static::$grid_settings;
        $is_end         = isset(static::$is_end) && static::$is_end;


        if (is_array(static::$items) && !empty(static::$items)) {

            global $post;
            $backup = $post;
            $grid_item = new IO_grid_item();
            $grid_item->set_item_atts($atts);

            foreach (static::$items as $postItem) {
                static::$WP_Query->setup_postdata($postItem);
                $post           = $postItem;
                $mx_item        = $grid_item->render_item($post);
                $items         .= $mx_item;
            }
            wp_reset_postdata();
            $post = $backup;

        } else {
            $shortcode_id = static::get_atts('shortcode_id');

            $not_results_page_block_id  = static::get_atts('not_results_page_block');

            \WPBMap::addAllMappedShortcodes();

            if($not_results_page_block_id){
                $page_block             = get_post($not_results_page_block_id);
                $page_block_content     = $page_block->post_content;
                $output                .= apply_filters('the_content', $page_block_content);
            }



            $output .= "
            <script>
            window.onload = function() {
                obser_grid.delete_cookie('{$shortcode_id}')   
            };
            </script>";
        }
        if ($items != "") {
            $output     .= static::renderPagination($items);
        }

        return $output;
    }

    public static function buildGridSettings(){

        parent::buildGridSettings();

    }

    protected static function set_order_methods(){

        static::$order_methods = array_merge(static::$order_methods,[
            'price_asc'  => 'Precio (de menor a mayor)',
            'price_desc' => 'Precio (de mayor a menor)'
        ]);

        unset(static::$order_methods['title_asc']);
        unset(static::$order_methods['title_desc']);

    }


    public static function output($_atts, $content){

        static::buildGridSettings();

        $element_id     = static::get_atts('vc_id');
        static::set_att("_gid",sanitize_title(static::get_atts('_gid')));
        $_gid           = static::get_atts('_gid');
        $shortcode_id   = static::get_atts('shortcode_id');
        static::buildItems();

        $id                 = static::get_atts('el_id');
        $post_type          = esc_attr("obser-grid-".static::get_atts('post_type'));
        $json_data          = esc_attr(wp_json_encode(static::$grid_settings));
        $current_page_id    = esc_attr(get_the_ID());
        $el_class           = esc_attr(static::get_atts('el_class'));
        $el_nonce           = esc_attr(vc_generate_nonce('vc-public-nonce'));
        $items              = static::renderItems();
        $output  = "
        <div id='{$id}' class='contenedor-obser-grid {$el_class} obser-grid-{$post_type} {$element_id}' data-gid='{$_gid}' data-shortcode_id='$shortcode_id' data-obser-grid-settings='$json_data' data-vc-post-id='{$current_page_id}' data-vc-public-nonce='{$el_nonce}' data-vc-post-id='{$current_page_id}' data-vc-public-nonce='{$el_nonce}'>
            <div class='obser-custom-preloader'>
                <span class='preloader-text'>Estamos buscando las mejores alternativas para ti...</span>
            </div>
            <div class='obser-custom-grid-items d-flex flex-wrap'>
                {$items}
            </div>        
        </div>";
        return $output;
    }

}



class IO_grid_item{

    static $item;
    static $atts;
    static $css_class;
    static $mode = 'grid';

    public function set_item_atts($atts){
        static::$atts = $atts;
    }

    static function get_value($post_id,$field_name,$label,$field_type, $value = null){

        switch($field_type){
            case 'taxonomy':
               $terms =  get_the_terms($post_id,$field_name);
               if(!$terms) return null;
                $i = 0;
               foreach($terms AS $term){
                   $value .= ($i >= 1) ? ' ,'. $term->name : $term->name;
                   $i ++;
               }
            break;
            case 'meta_value':
                $value = get_post_meta($post_id,$field_name,true);
            break;
            case 'meta_boolean':
                $value = (get_post_meta($post_id,$field_name,true) == 1) ? $value : null ;


            break;
        }


        
        if(!$value)return false;

        if($field_name == 'price'){
            $sales_price    = get_post_meta($post_id,'sales_price',true);
            $price_preffix  = get_post_meta($post_id,'price_prefix',true);
            $price_suffix   = get_post_meta($post_id,'price_sufix',true);
            $price          =  number_format($value,0,',','.');

            $value = ((isset($sales_price) && !empty($sales_price)) &&  $sales_price < $price) ? '<span class="price">'.$price_preffix .' '.$sales_price.' € '.$price_suffix .'</span> <span class="old_price"> Antes '.$price.' € </span>'  : '<span class="price">'.$price_preffix .' '.$price.' € '.$price_suffix .'</span>';
        }

        if($field_name == 'property_size') $value .= ' m²';


        $label =    !empty($label) ? "<span class='label--$field_name'> $label </span>" : false;
        $value =    "<div class='field--$field_name'> $label  $value </div>";

        return $value;

    }

    public static function get_taxonomy_value($post_id,$taxonomy){

        $terms = get_the_terms($post_id,$taxonomy);

        if(!$terms) return null;

        foreach($terms AS $term){
            $value = array(
                'term_id' => $term->term_id, 
                'slug' => $term->slug, 
                'name' => $term->name, 
            );
            break;
        }

        return $value;

    }

    public static function get_featured_tags($post_id){

        $tags = get_the_terms($post_id,'property_tags_taxonomy');

        if(!$tags) return null;
        
        $features = [];

        foreach($tags AS $tag){

            $is_fetured = get_term_meta($tag->term_id,'featured',true);

            if($is_fetured != 1) continue;

            $features[] = array(
                'term_id'   => $tag->term_id, 
                'slug'      => $tag->slug, 
                'name'      => $tag->name, 
            );
        }

        return $features;
    }


    public static function set_mode($mode = 'grid'){

        static::$mode = $mode;

    }


    public function render_item($post){
        $atts               = static::$atts;
        $item               = static::$item = $post;
        $css_class          = static::$css_class;
        $post_id            = static::$item->ID;
        $css_class         .= ' main-color';
        $image_class        = null;
        $lazy_src           = null;
        if(static::$mode =='swiper'){
            $css_class   .= ' swiper-slide';
            $image_class .= ' swiper-lazy';
            $lazy_src     = 'data-';
        }

        $title                  = $item->post_title;
        $location               = static::get_value($post_id,'property_zones_taxonomy',false,'taxonomy');
        $rooms                  = static::get_value($post_id,'property_rooms_taxonomy','<i class="inmoob inmoob-bedrooms"></i> ','taxonomy');
        $bathrooms              = static::get_value($post_id,'property_bathrooms_taxonomy','<i class="inmoob inmoob-bathrooms"></i> ','taxonomy');
        $garage                 = static::get_value($post_id,'garage','<i class="inmoob inmoob-garage"></i> ','meta_boolean','Garaje');
        $price                  = static::get_value($post_id,'price',false,'meta_value');
        $property_size          = static::get_value($post_id,'property_size','<i class="inmoob inmoob-m2"></i> ','meta_value');
        
        $image                  = get_the_post_thumbnail_url( $post_id,'property_list');
        $image                  = ($image) ? $image : INMOOB_CORE_PLUGIN_DIR_URL.'/assets/images/placeholder-alt.jpg';
        $status                 = static::get_taxonomy_value($post_id,'gestion_states_taxonomy');
        $tags                   = (array)static::get_featured_tags($post_id);
        $link                   = get_the_permalink($post_id);
        $flag_status            = false;
        
        if(isset($status['slug'])){
            switch($status['slug']){
                case 'reservado' :
                    $flag_status = '<span class="flag">'.__('Reservado','obser').'</span>';
                break;
                case 'alquilado':
                    $flag_status = '<span class="flag">'.__('Alquilado','obser').'</span>';
                break;
                case 'vendido':
                    $flag_status = '<span class="flag">'.__('Vendido','obser').'</span>';
                break;
            }
        }
        
        
        $html_tags = "";
        foreach($tags AS $tag){
            $html_tags .= ' <span class="tag '.$tag['slug'].'">'.$tag['name'].'</span>';
        }

       
        $output =
        "<div class='obser-grid-item property-item-$item->ID $css_class'>
        <div  class='obser-grid-item-content property-item'>
            $flag_status 
            ".(!empty($tags) ? '<div class="tags-container">'.$html_tags.'</div>': false)."

            <div class='property-picture'>
                <a href='{$link}'>
                    <img {$lazy_src}src='{$image}' class='{$image_class}' alt='{$title}'>
                </a>
            </div>
            <div class='property-data'>
                <div class='row info-row justify-content-between icons-data'>
                {$property_size}
                {$rooms}
                {$bathrooms}
                {$garage}
                </div>
                <div class='row location-prices-row justify-content-between'>
                    <span class='price-field'>{$price}</span>
                    <span class='location-field'>{$location}</span>
                </div>
                <div class='row title-row'>
                    <a href='$link'><h3>$title</h3></a>
                </div>
            </div>
            </div>
        </div>";

        return $output;
    }



}


 