<?php

namespace Inmoob\Shortcodes;

use Obser\Shortcodes\_Grid;
use Inmoob\Classes\Api;

class SearchGrid extends _Grid {

    static $shortcode = "inmoob_search_grid";
    static $wpb_namespace = "Inmoob\\WPB_Components";

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

        if($atts['filters']){
            $tax_query_fields = 0;
            foreach((array)$atts['filters'] AS $taxonomy => $value){
                if(\preg_match('/\_taxonomy$/',$taxonomy) && isset($value) && !empty($value)){
                    $tax_query_fields++;
                    $tax_query[] = array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'slug',
                        'terms'    => $value,
                    ); 
                }
            }


            if($tax_query_fields >0){
                $settings['tax_query'] = $tax_query;
            }

        }

        

        if(isset($atts['filters']['property_price_min']) || isset($atts['filters']['property_price_max'])){
            $gestion_type = $atts['filters']['gestion_types_taxonomy'];
            $gestion_type = get_term_by('slug', $gestion_type ,'gestion_types_taxonomy');
            $data         = Api::get_options_range('price',$gestion_type);
            $property_price_min = isset($atts['filters']['property_price_min']) ? intval($atts['filters']['property_price_min']) : intval($data['min']);
            $property_price_max = isset($atts['filters']['property_price_max']) ? intval($atts['filters']['property_price_max']) : intval($data['max']);
            
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

        if(isset($atts["filters"]["heuristic"]) && !empty($atts["filters"]["heuristic"])){
            $heuristic = $atts["filters"]["heuristic"];
            $settings['s'] = $heuristic;
        }

        
        if(isset($atts["filters"]["start_with"]) && !empty($atts["filters"]["start_with"])){
            $start_with = $atts["filters"]["start_with"];
            switch($start_with){
                case  "all" :
                    $start_with = null;
                break;
                case "num" :
                    $start_with = "[0-9]";
                break;
            }
            if(isset($start_with)){
                $settings['starts_with'] = "^{$start_with}+";
            }
        }

        return $settings;
    }

    private static function extract_taxonomy_from_search_form(){
        $post_type = self::get_atts('post_type',null);
        return "{$post_type}_category";
  
    }

    static function buildAtts($atts = array(), $content = null){



        parent::buildAtts($atts, $content);

        $shortcode_id   = self::get_atts('shortcode_id');
        $post_type      = self::get_atts('post_type',array());
        self::set_att('post_type',$post_type[0]);
        $cookie         = self::get_cookie_data($shortcode_id);

        if (!defined('DOING_AJAX') || !DOING_AJAX) {
            $cookie       = self::get_cookie_data($id_to_save);
            if (isset($cookie['paged'])) {
                self::set_att('paged', $cookie['paged']);
            }
        }


        // $filters = self::get_atts('filters');
        // $filters = array_merge((array)$filters,$atts['filters']);
        // self::set_att('filters',$filters);

        // $taxonomy = self::extract_taxonomy_from_search_form();
        $property_type_var  = get_query_var('property_type') ?: null;
        $property_type_var  = get_query_var('property_type') ?: null;
        $gestion_type_var   = get_query_var('gestion_type')  ?: null;
        $property_zone_var  = get_query_var('property_zone') ?: null;
        
        
        if(isset($property_type_var) && !empty($property_type_var)){
            $filters            = self::get_atts('filters');
            $filters['property_types_taxonomy'] = $property_type_var;
            self::$grid_settings['filters']['property_types_taxonomy'] = $property_type_var;
            self::set_att('filters',$filters);
        }

        if(isset($gestion_type_var) && !empty($gestion_type_var)){
            $filters            = self::get_atts('filters');
            $filters['gestion_types_taxonomy'] = $gestion_type_var;
            self::$grid_settings['filters']['gestion_types_taxonomy'] = $gestion_type_var;

            self::set_att('filters',$filters);
        }

        if(isset($property_zone_var) && !empty($property_zone_var)){
            $filters            = self::get_atts('filters');
            $filters['property_zones_taxonomy'] = $property_zone_var;
            self::$grid_settings['filters']['property_zones_taxonomy'] = $property_zone_var;
            self::set_att('filters',$filters);
        }

    }


    public static function renderItems(){
        $output         = $items = '';
        $filter_terms   = self::$filter_terms;
        $atts           = self::get_atts();
        $settings       = self::$grid_settings;
        $is_end         = isset(self::$is_end) && self::$is_end;


        if (is_array(self::$items) && !empty(self::$items)) {

            global $post;
            $backup = $post;
            $grid_item = new IO_grid_item();
            $grid_item->set_item_atts($atts);

            foreach (self::$items as $postItem) {
                self::$WP_Query->setup_postdata($postItem);
                $post           = $postItem;
                $mx_item        = $grid_item->render_item($post);
                $cclass         = self::get_atts('cclass');
                $items         .= preg_replace('/(?!vc_grid-item ) vc_col.\w{2}.\d{1,2}/'," {$cclass} ", $mx_item);
            }
            wp_reset_postdata();
            $post = $backup;
        } else {
            $shortcode_id = self::get_atts('shortcode_id');

            $output .= "aqui va una busqueda desierta
            <script>
            window.onload = function() {
                obser_grid.delete_cookie('{$shortcode_id}')   
            };
            </script>";
        }
        if ($items != "") {
            $output     .= self::renderPagination($settings, $items);
        }

        return $output;
    }


    public static function output($_atts, $content){

        self::buildGridSettings();

        $element_id     = self::get_atts('vc_id');
        self::set_att("_gid",sanitize_title(self::get_atts('_gid')));
        $_gid           = self::get_atts('_gid');
        $shortcode_id   = self::get_atts('shortcode_id');
        self::buildItems();

        $id                 = self::get_atts('el_id');
        $post_type          = esc_attr("obser-grid-".self::get_atts('post_type'));
        $json_data          = esc_attr(wp_json_encode(self::$grid_settings));
        $current_page_id    =  esc_attr(get_the_ID());
        $el_class           = esc_attr(self::get_atts('el_class'));
        $el_nonce           = esc_attr(vc_generate_nonce('vc-public-nonce'));
        $items              = self::renderItems();
        $output  = "
        <div id='{$id}' class='contenedor-obser-grid {$el_class} obser-grid-{$post_type} {$element_id}' data-gid='{$_gid}' data-shortcode_id='$shortcode_id' data-obser-grid-settings='$json_data' data-vc-post-id='{$current_page_id}' data-vc-public-nonce='{$el_nonce}' data-vc-post-id='{$current_page_id}' data-vc-public-nonce='{$el_nonce}'>
            <div class='obser-custom-preloader'>
                <!--<span class='preloader-text'>Estamos buscando las mejores alternativas para ti...</span>-->
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

    public function set_item_atts($atts){
        self::$atts = $atts;
    }

    static function get_value($post_id,$field_name,$label,$field_type){
        $value = '';
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
        }


        
        if(!$value)return false;

        if($field_name == 'price'){
            $sales_price    = get_post_meta($post_id,'sales_price',true);
            $price_preffix  = get_post_meta($post_id,'price_preffix',true);
            $price_suffix   = get_post_meta($post_id,'price_suffix',true);
            $price          = $value;

            $value = ((isset($sales_price) && !empty($sales_price)) &&  $sales_price < $price) ? '<span class="price">'.$price_preffix .' '.$sales_price.' € '.$price_suffix .'</span> <span class="old_price"> Antes '.$price.' € </span>'  : '<span class="price">'.$price_preffix .' '.$price.' € '.$price_suffix .'</span>';
        }

        if($field_name == 'property_size') $value .= ' m2';


        $label =    !empty($label) ? "<span class='label--$field_name'> $label </span>" : false;
        $value =    "<div class='field--$field_name'> $label  $value </div>";

        return $value;

    }

    public function get_taxonomy_value($post_id,$taxonomy){

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


    public function render_item($post){
        $atts       = self::$atts;
        $item       = self::$item = $post;
        $css_class  = self::$css_class;
        $post_id    = self::$item->ID;
        $css_class .= ' main-color';



        $title                  = $item->post_title;
        $location               = self::get_value($post_id,'property_zones_taxonomy',false,'taxonomy');
        $rooms                  = self::get_value($post_id,'property_rooms_taxonomy','<i class="fas fa-bed"></i> ','taxonomy');
        $bathrooms              = self::get_value($post_id,'property_bathrooms_taxonomy','<i class="fas fa-shower"></i> ','taxonomy');
        $price                  = self::get_value($post_id,'price',false,'meta_value');
        $property_size          = self::get_value($post_id,'property_size','<i class="far fa-home-lg"></i> ','meta_value');
        
        $image                  = get_the_post_thumbnail_url( $post_id,'property_list');
        $image                  = ($image) ? $image : INMOOB_CORE_PLUGIN_DIR_URL.'/assets/images/placeholder-alt.jpg';
        $status                 = self::get_taxonomy_value($post_id,'gestion_states_taxonomy');
        $link                   = get_the_permalink($post_id);


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
            default :
            $flag_status = false;
        }


        $on_sale                = get_post_meta($post_id,'on_sale',true);
        $featured               = get_post_meta($post_id,'featured',true);
        $no_docs                = get_post_meta($post_id,'no_docs',true);
        $tags = '';

        if ($featured == '1') $tags .= ' <span class="tag featured">'.__('Destacado','obser').'</span>';
        if ($on_sale == '1') $tags .= ' <span class="tag on_sale" data-tooltip="'.__('Este Inmueble está rebajado de precio','obser').'">'.__('Oferta','obser').'</span>';
        if ($no_docs == '1') $tags .= ' <span class="tag no_docs" data-tooltip="'.__('¿Aún no tienes DNI, NIE o Contrato?, Alquila este inmuebel sin documentación.','obser').'">'.__('Sin papeles','obser').'</span>';

        $output =
        "<div class='obser-grid-item property-item-$item->ID $css_class'>
        <div  class='obser-grid-item-content property-item'>
            $flag_status 
            ".(!empty($tags) ? '<div class="tags-container">'.$tags.'</div>': false)."

            <div class='property-picture'>
                <a href='$link'>
                    <img src='$image' alt='$title'>
                </a>
            </div>
            <div class='property-data'>
                <div class='row location-prices-row justify-content-between'>
                   ".$location."
                   ".$price."
                </div>

                <div class='row info-row justify-content-between'>
                ".$rooms."
                ".$bathrooms."
                ".$property_size."
                </div>

                <div class='row title-row'>
                    <div class='title'><a href='$link'>
                        <span class='property-title'>$title</span>
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </div>";

        return $output;
    }



}


 