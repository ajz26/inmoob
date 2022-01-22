<?php

namespace Inmoob\Shortcodes;

class Swiper extends SearchGrid {

    static $shortcode       = "inmoob_props_swiper";
    static $wpb_namespace   = "Inmoob\\WPB_Components";


    static function set_default_atts(){
        parent::set_default_atts();
        static::$attributes_defaults = array_merge(static::$attributes_defaults,array(
            'arrows'          => 'hide',
            'bullets'         => 'hide',
        ));
    }

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
        $output         = $items = null;
        $atts           = static::get_atts();
        

        if (is_array(static::$items) && !empty(static::$items)) {

            global $post;
            $backup     = $post;
            $grid_item  = new IO_grid_item();
            $grid_item->set_mode('swiper');
            $grid_item->set_item_atts($atts);

            foreach (static::$items as $postItem) {
                static::$WP_Query->setup_postdata($postItem);
                $post           = $postItem;
                $items         .= $grid_item->render_item($post);
            }

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
        if (isset($items) && !empty($items)) {
            $output     .= static::renderPagination($items);
        }

        return $output;
    }


    public static function generate_css(){
        
        $style                      = '';
        $parent_id                  = static::get_atts('vc_id');
        $element_width              = (int)static::get_atts('element_width', 4);
        $mx_responsive_1            = (int)static::get_atts('mx_responsive_1', 1200);
        $mx_responsive_val_1        = (int)static::get_atts('mx_responsive_val_1', $element_width);

        $mx_responsive_2            = (int)static::get_atts('mx_responsive_2', 1200);
        $mx_responsive_val_2        = (int)static::get_atts('mx_responsive_val_2', $mx_responsive_val_1);

        $mx_responsive_3            = (int)static::get_atts('mx_responsive_3', 1200);
        $mx_responsive_val_3        = (int)static::get_atts('mx_responsive_val_3', $mx_responsive_val_2);
        $items_gap                  = (int)static::get_atts('items_gap', 10);
        
        $style .= "

       /*.{$parent_id} .inmoob-swipper {
            margin-left: calc(({$items_gap}px / 2) * (-1));
            margin-right: calc(({$items_gap}px / 2) * (-1));
        }*/
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
    
        // if(static::$general_encoled) return;

        // static::$general_encoled = true;
        $styles  = parent::general_styles();

        $styles .= "
        
        .inmoob-swiper-pagination {
            position: relative;
        }

        .contenedor-obser-grid.swiper .obser-grid-item.swiper-slide {
            height: auto;
            overflow: visible;
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

        return $styles;

    }



    public static function output($_atts, $content){


        static::buildGridSettings();
        $atts = static::get_atts();

        add_action('wp_footer',function() use ($atts){
            static::generate_script($atts);
        },100);

        $element_id     = static::get_atts('vc_id');
        static::set_att("_gid",sanitize_title(static::get_atts('_gid')));
        $_gid           = static::get_atts('_gid');
        $shortcode_id   = static::get_atts('shortcode_id');
        
        
        $arrows    = static::get_atts('arrows');
        $bullets   = static::get_atts('bullets');
        

        static::buildItems();


        $id                 = static::get_atts('el_id');
        $post_type          = esc_attr("obser-grid-".static::get_atts('post_type'));
        $json_data          = esc_attr(wp_json_encode(static::$grid_settings));
        $current_page_id    = esc_attr(get_the_ID());
        $el_class           = esc_attr(static::get_atts('el_class'));
        $el_nonce           = esc_attr(vc_generate_nonce('vc-public-nonce'));
        $items              = static::renderItems();
        
        if(!isset(static::$items) || empty(static::$items) ){
            return $items;
        }

        $arrows = ($arrows == 'show') ? "<div class='prev-next-buttons-container'>
                        <div class='inmoob-swiper-button-prev-next inmoob-swiper-button-prev {$element_id}'>
                            <i class='far fa-angle-left'></i>
                        </div>
                        <div class='inmoob-swiper-button-prev-next inmoob-swiper-button-next {$element_id}'>
                            <i class='far fa-angle-right'></i>
                        </div>
                    </div>" : null;

        $bullets = ($bullets == 'show') ? "<div class='inmoob-swiper-pagination'></div>" : null;

        $output  = "
        <div id='{$id}' class='contenedor-obser-grid swiper {$el_class} obser-grid-{$post_type} {$element_id}' data-gid='{$_gid}' data-shortcode_id='$shortcode_id' data-obser-grid-settings='$json_data' data-vc-post-id='{$current_page_id}' data-vc-public-nonce='{$el_nonce}' data-vc-post-id='{$current_page_id}' data-vc-public-nonce='{$el_nonce}'>
        {$arrows}    
            <div class='swiper-container'>
                <div class='inmoob-swipper swiper-wrapper'>
                    {$items}    
                </div>
                {$bullets}
            </div>        
        </div>";
        return $output;
    }



    public static function generate_script($atts){
        static::set_atts($atts);
        $show_bullets               = static::get_atts('bullets',true);
        $show_arrows                = static::get_atts('arrows',true);
        $el_swipper                 = static::get_atts('vc_id');
        $element_width              = (int)static::get_atts('element_width', 4);
        $lazy_preload               = $element_width + $element_width;
        $mx_responsive_1            = (int)static::get_atts('mx_responsive_1', 1200);
        $mx_responsive_val_1        = (int)static::get_atts('mx_responsive_val_1', $element_width);
        $mx_responsive_2            = (int)static::get_atts('mx_responsive_2', 1200);
        $mx_responsive_val_2        = (int)static::get_atts('mx_responsive_val_2', $mx_responsive_val_1);
        $mx_responsive_3            = (int)static::get_atts('mx_responsive_3', 1200);
        $mx_responsive_val_3        = (int)static::get_atts('mx_responsive_val_3', $mx_responsive_val_2);

        $script = "<script>
            jQuery(document).ready(function () {
                var mySwiper_{$el_swipper} = new Swiper ('.{$el_swipper} .swiper-container', {
                    lazy: {
                        loadPrevNext: true,
                        checkInView : true,
                        loadPrevNextAmount: {$lazy_preload},
                      },
                    //   autoplay: {
                    //     delay: 2000,
                    //   },
                    slidesPerView: {$mx_responsive_val_3},";
                    if($show_arrows){
                        $script .= 'navigation: {
                        nextEl: ".inmoob-swiper-button-next.'.$el_swipper.'",
                        prevEl: ".inmoob-swiper-button-prev.'.$el_swipper.'"
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


 