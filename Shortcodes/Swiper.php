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


    public static function generate_css()
    {   
        $style  = '';
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
        .{$parent_id} .obser-custom-grid-items {
            margin-left: calc(({$items_gap}px / 2) * (-1));
            margin-right: calc(({$items_gap}px / 2) * (-1));
        }
        .{$parent_id} .obser-custom-grid-items .grid-nav ,
        .{$parent_id} .obser-custom-grid-items .obser-grid-item {
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
        $current_page_id    =  esc_attr(get_the_ID());
        $el_class           = esc_attr(self::get_atts('el_class'));
        $el_nonce           = esc_attr(vc_generate_nonce('vc-public-nonce'));
        $items              = self::renderItems();
        $output  = "
        <div id='{$id}' class='contenedor-obser-grid swiper {$el_class} obser-grid-{$post_type} {$element_id}' data-gid='{$_gid}' data-shortcode_id='$shortcode_id' data-obser-grid-settings='$json_data' data-vc-post-id='{$current_page_id}' data-vc-public-nonce='{$el_nonce}' data-vc-post-id='{$current_page_id}' data-vc-public-nonce='{$el_nonce}'>
            <div class='obser-custom-preloader'>
                <!--<span class='preloader-text'>Estamos buscando las mejores alternativas para ti...</span>-->
            </div>
            <div class='obser-custom-grid-items d-flex flex-wrap swiper-container'>

            <div class='inmoob-gallery-swiper-button-prev-next inmoob-gallery-swiper-button-next'>
                <i class='far fa-angle-right'></i>
            </div>
            <div class='inmoob-gallery-swiper-button-prev-next inmoob-gallery-swiper-button-prev'>
                <i class='far fa-angle-left'></i>
            </div>
            <div class='swiper-wrapper'>
                {$items}    
            </div>

                
            </div>        
        </div>";

        $output .= "<script>
        
        jQuery(document).ready(function(){
            const InmoobPropsGallery = new Swiper('.obser-custom-grid-items.swiper-container', {
                loop: true,
                slidesPerView: 1,
                centeredSlides: true,
                spaceBetween: 10,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.inmoob-gallery-swiper-button-next',
                    prevEl: '.inmoob-gallery-swiper-button-prev',
                }
            });
        });
        </script>";
        return $output;
    }



    public static function generate_script($atts){
        self::set_atts($atts);
        $show_bullets               = self::get_atts('show_bullets',false);
        $show_arrows                = self::get_atts('show_arrows',false);
        $el_swipper                 = self::get_atts('vc_id');
        $element_width              = (int)self::get_atts('element_width', 4);
        $lazy_preload               = $element_width + $element_width;
        $mx_responsive_1            = (int)self::get_atts('mx_responsive_1', 1200);
        $mx_responsive_val_1        = (int)self::get_atts('mx_responsive_val_1', $element_width);
        $mx_responsive_2            = (int)self::get_atts('mx_responsive_2', 1200);
        $mx_responsive_val_2        = (int)self::get_atts('mx_responsive_val_2', $mx_responsive_val_1);
        $mx_responsive_3            = (int)self::get_atts('mx_responsive_3', 1200);
        $mx_responsive_val_3        = (int)self::get_atts('mx_responsive_val_3', $mx_responsive_val_2);
        $items_gap                  = (int)self::get_atts('items_gap', 10);

        $script = "<script>
            jQuery(document).ready(function () {
                var mySwiper = new Swiper ('.{$el_swipper} .swiper-container', {
                    lazy: true,
                    loadPrevNext: true,
                    loadPrevNextAmount: {$lazy_preload},
                    slidesPerView: {$element_width},";
                    if($show_arrows){
                        $script .= 'navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev"},';
                    };
                    if($show_bullets){
                        $script .= 'pagination: {
                            el: ".swiper-pagination",
                            dynamicBullets: true,
                            clickable: true
                        },';
                    };
                    $script .= 'breakpoints: {';
                        if(!is_null($mx_responsive_1)){
                            $script .= '"'.$mx_responsive_1.'": {
                                    slidesPerView: '.$mx_responsive_val_1.',
                                },';
                        }
            
                        if(!is_null($mx_responsive_2)){
                            $script .= '"'.$mx_responsive_2.'": {
                                    slidesPerView: '.$mx_responsive_val_2.',
                                },';
                        }
            
                        if(!is_null($mx_responsive_3)){
                            $script .= '"'.$mx_responsive_3.'": {
                                    slidesPerView: '.$mx_responsive_val_3.',
                                }';
                        }
                        $script .= '}
                })
            });
            </script>';
            echo $script;
    }
}


 