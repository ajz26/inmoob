<?php

namespace Inmoob\Shortcodes;

class Swiper extends SearchGrid {




    static $shortcode = "inmoob_props_swiper";
    static $wpb_namespace = "Inmoob\\WPB_Components";




    public static function enquee_styles(){

        $parent = parent::enquee_styles() ?: array();
        return array_merge($parent,array(
            'swiper-js' => array(
                'src'   => OBSER_FRAMEWORK_DIR_URL . 'assets/css/swiper-bundle.min.css',
            ),
        ));
    }
    public static function enquee_scripts(){

        $parent = parent::enquee_scripts();

        return array_merge($parent,array(
            'swiper-js' => array(
                'src'   => OBSER_FRAMEWORK_DIR_URL . 'assets/js/swiper-bundle.min.js',
                'deps'  => array('jquery'),
                'in_footer'   => false,
            ),
        ));
    }



    public static function renderItems(){
        $output         = $items = '';
        $filter_terms   = self::$filter_terms;
        $atts           = self::get_atts();
        $settings       = self::$grid_settings;
        $is_end         = isset(self::$is_end) && self::$is_end;


        if (is_array(self::$items) && !empty(self::$items)) {

            global $post;
            $backup     = $post;
            $grid_item  = new IO_grid_item();
            $grid_item->set_mode('swiper');
            $grid_item->set_item_atts($atts);

            foreach (self::$items as $postItem) {
                self::$WP_Query->setup_postdata($postItem);
                $post           = $postItem;
                $items         .= $grid_item->render_item($post);
            }

            if(count(self::$items) >= 4){
                $items         .= "<div class='swiper-slide'></div>";
            }

            $post = $backup;

        } else {
            $shortcode_id = self::get_atts('shortcode_id');

            $not_results_page_block_id  = self::get_atts('not_results_page_block');

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
            $output     .= self::renderPagination($settings, $items);
        }

        return $output;
    }


    public static function generate_css(){
        
        $style                      = '';
        $parent_id                  = self::get_atts('vc_id');
        $element_width              = (int)self::get_atts('element_width', 4);
        $mx_responsive_1            = (int)self::get_atts('mx_responsive_1', 1200);
        $mx_responsive_val_1        = (int)self::get_atts('mx_responsive_val_1', $element_width);

        $mx_responsive_2            = (int)self::get_atts('mx_responsive_2', 1200);
        $mx_responsive_val_2        = (int)self::get_atts('mx_responsive_val_2', $mx_responsive_val_1);

        $mx_responsive_3            = (int)self::get_atts('mx_responsive_3', 1200);
        $mx_responsive_val_3        = (int)self::get_atts('mx_responsive_val_3', $mx_responsive_val_2);
        $items_gap                  = (int)self::get_atts('items_gap', 10);
        
        $style .= "
        .{$parent_id} .inmoob-swipper {
            margin-left: calc(({$items_gap}px / 2) * (-1));
            margin-right: calc(({$items_gap}px / 2) * (-1));
        }
        .{$parent_id} .inmoob-swipper .grid-nav ,
        .{$parent_id} .inmoob-swipper .obser-grid-item {
            padding-left: calc({$items_gap}px / 2);
            padding-right: calc({$items_gap}px / 2);
        }
        .{$parent_id} .obser-grid-item {
            width: calc(100% / {$element_width});
        }
        ";
        if (!is_null($mx_responsive_1) && $mx_responsive_val_1 > 0) {
            $style .= "@media only screen and (max-width: {$mx_responsive_1}px) {
                .{$parent_id} .obser-grid-item{
                    width: calc(100% / {$mx_responsive_val_1});
                } 
            }";
        }
        if (!is_null($mx_responsive_2) && $mx_responsive_val_2 > 0) {
            $style .= "@media only screen and (max-width: {$mx_responsive_2}px) {
                .{$parent_id} .obser-grid-item{
                    width: calc(100% / {$mx_responsive_val_2});
                }
            }";
        }
        if (!is_null($mx_responsive_3) && $mx_responsive_val_3 > 0) {
            $style .= "@media only screen and (max-width: {$mx_responsive_3}px) {
                .{$parent_id} .obser-grid-item{
                    width: calc(100% / {$mx_responsive_val_3});
                }
            }";
        }

        return $style;
    }


    static function general_styles()
    {
    
        return "

        .inmoob-swiper-pagination {
            margin: 0 auto;
            text-align: center;
        }

        .prev-next-buttons-container {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
        }
        
        .inmoob-swiper-button-prev-next {
            background-color: rgba(255, 255, 255, 0.77);
            z-index: 9999;
            border-radius: .5rem;
            margin-bottom: .5rem;
            width: 35px;
            text-align: center;
            height: 35px;
            font-size: 1.5rem;
            line-height: 2.2rem;
            opacity: .6;
            transition: all .5s;
            -webkit-transition: all .5s;
            top: 10px;
            cursor: pointer;
        }

        .inmoob-swiper-button-prev-next {
            background-color: rgba(255, 255, 255, 0.77);
            border-radius: .5rem;
            margin-bottom: .5rem;
            width: 35px;
            text-align: center;
            height: 35px;
            font-size: 1.5rem;
            line-height: 2.2rem;
            opacity: .6;
            transition: all .5s;
            -webkit-transition: all .5s;
            cursor: pointer;
            border: 1px solid #cccccc;
            visibility: visible;
            opacity: 1;
        }   

        .inmoob-swiper-button-prev-next:nth-child(1){
            margin-right: 1rem;
        }

        .inmoob-swiper-button-prev-next.swiper-button-disabled {
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.5s linear;
        }


        ";

    }



    public static function output($_atts, $content){

        self::buildGridSettings();
        $atts = self::get_atts();

        add_action('wp_footer',function() use ($atts){
            self::generate_script($atts);
        });

        $element_id     = self::get_atts('vc_id');
        self::set_att("_gid",sanitize_title(self::get_atts('_gid')));
        $_gid           = self::get_atts('_gid');
        $shortcode_id   = self::get_atts('shortcode_id');
        self::buildItems();

        $id                 = self::get_atts('el_id');
        $post_type          = esc_attr("obser-grid-".self::get_atts('post_type'));
        $json_data          = esc_attr(wp_json_encode(self::$grid_settings));
        $current_page_id    = esc_attr(get_the_ID());
        $el_class           = esc_attr(self::get_atts('el_class'));
        $el_nonce           = esc_attr(vc_generate_nonce('vc-public-nonce'));
        $items              = self::renderItems();
        $output  = "
        <div id='{$id}' class='contenedor-obser-grid swiper {$el_class} obser-grid-{$post_type} {$element_id}' data-gid='{$_gid}' data-shortcode_id='$shortcode_id' data-obser-grid-settings='$json_data' data-vc-post-id='{$current_page_id}' data-vc-public-nonce='{$el_nonce}' data-vc-post-id='{$current_page_id}' data-vc-public-nonce='{$el_nonce}'>
            <div class='obser-custom-preloader'>
                <!--<span class='preloader-text'>Estamos buscando las mejores alternativas para ti...</span>-->
            </div>
            <div class='swiper-container'>
            <div class='prev-next-buttons-container'>
                <div class='inmoob-swiper-button-prev-next inmoob-swiper-button-prev'>
                    <i class='far fa-angle-left'></i>
                </div>
                <div class='inmoob-swiper-button-prev-next inmoob-swiper-button-next'>
                    <i class='far fa-angle-right'></i>
                </div>
            </div>
           
            <div class='inmoob-swipper swiper-wrapper'>
                {$items}    
            </div>
            <div class='inmoob-swiper-pagination'></div>
            </div>        
        </div>";
        return $output;
    }



    public static function generate_script($atts){
        self::set_atts($atts);
        $show_bullets               = self::get_atts('show_bullets',true);
        $show_arrows                = self::get_atts('show_arrows',true);
        $el_swipper                 = self::get_atts('vc_id');
        $element_width              = (int)self::get_atts('element_width', 4);
        $lazy_preload               = $element_width + $element_width;
        $mx_responsive_1            = (int)self::get_atts('mx_responsive_1', 1200);
        $mx_responsive_val_1        = (int)self::get_atts('mx_responsive_val_1', $element_width);
        $mx_responsive_2            = (int)self::get_atts('mx_responsive_2', 1200);
        $mx_responsive_val_2        = (int)self::get_atts('mx_responsive_val_2', $mx_responsive_val_1);
        $mx_responsive_3            = (int)self::get_atts('mx_responsive_3', 1200);
        $mx_responsive_val_3        = (int)self::get_atts('mx_responsive_val_3', $mx_responsive_val_2);

        $script = "<script>
            jQuery(document).ready(function () {
                var mySwiper = new Swiper ('.{$el_swipper} .swiper-container', {
                    lazy: true,
                    loadPrevNext: true,
                    loadPrevNextAmount: {$lazy_preload},
                    slidesPerView: {$mx_responsive_val_3},";
                    if($show_arrows){
                        $script .= 'navigation: {
                        nextEl: ".inmoob-swiper-button-next",
                        prevEl: ".inmoob-swiper-button-prev"
                        },';
                    };
                    if($show_bullets){
                        $script .= 'pagination: {
                            el: ".inmoob-swiper-pagination",
                            dynamicBullets: true,
                            clickable: true
                        },';
                    };
                    $script .= 'breakpoints: {';

                        if(!is_null($mx_responsive_3)){
                            $script .= '"'.$mx_responsive_3.'": {
                                    slidesPerView: '.$mx_responsive_val_3.',
                                },';
                        }
                        if(!is_null($mx_responsive_2)){
                            $script .= '"'.$mx_responsive_2.'": {
                                    slidesPerView: '.$mx_responsive_val_2.',
                                },';
                        }

                        if(!is_null($mx_responsive_1)){
                            $script .= '"'.$mx_responsive_1.'": {
                                    slidesPerView: '.$mx_responsive_val_1.',
                                }';
                        }
            
                        
            
                       
                        $script .= '}
                })
            });
            </script>';
            echo $script;
    }
}


 