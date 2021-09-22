<?php

namespace Inmoob\Shortcodes;

class Testimonials extends Swiper {




    static $shortcode       = "inmoob_testimonials_swiper";
    static $wpb_namespace   = "Inmoob\\WPB_Components";


    public static function renderItems(){
        $output         = $items = '';
        $atts           = static::get_atts();
        $settings       = static::$grid_settings;

        if (is_array(static::$items) && !empty(static::$items)) {

            global $post;
            $backup     = $post;
            $grid_item  = new Inmoob_testimonial_item();
            $grid_item->set_mode('swiper');

            $grid_item->set_item_atts($atts);

            foreach (static::$items as $postItem) {
                static::$WP_Query->setup_postdata($postItem);
                $post           = $postItem;
                $items         .= $grid_item->render_item($post);
            }

            $post = $backup;

        }

        
        if ($items != "") {
            $output     .= static::renderPagination($items);
        }

        return $output;
    }
    

    public static function output($_atts, $content){

        static::buildGridSettings();

        static::set_att('show_arrows',false);

        $atts = static::get_atts();
        

        add_action('wp_footer',function() use ($atts){
            static::generate_script($atts);
        },100);

        $element_id     = static::get_atts('vc_id');
        static::set_att("_gid",sanitize_title(static::get_atts('_gid')));
        $_gid           = static::get_atts('_gid');
        $shortcode_id   = static::get_atts('shortcode_id');
        static::buildItems();

        $post_id                 = static::get_atts('el_id');
        $post_type          = esc_attr("obser-grid-".static::get_atts('post_type'));
        $json_data          = esc_attr(wp_json_encode(static::$grid_settings));
        $current_page_id    = esc_attr(get_the_ID());
        $el_class           = esc_attr(static::get_atts('el_class'));
        $el_nonce           = esc_attr(vc_generate_nonce('vc-public-nonce'));
        $items              = static::renderItems();
        $output  = "
            <div id='{$post_id}' class='contenedor-obser-grid swiper {$el_class} obser-grid-{$post_type} {$element_id}' data-gid='{$_gid}' data-shortcode_id='$shortcode_id' data-obser-grid-settings='$json_data' data-vc-post-id='{$current_page_id}' data-vc-public-nonce='{$el_nonce}' data-vc-post-id='{$current_page_id}' data-vc-public-nonce='{$el_nonce}'>
              
                <div class='swiper-container'>";
        
        if(static::get_atts('show_arrows',false)){

        $output  .= "<div class='prev-next-buttons-container'>
                        <div class='inmoob-swiper-button-prev-next inmoob-swiper-button-prev'>
                            <i class='far fa-angle-left'></i>
                        </div>
                        <div class='inmoob-swiper-button-prev-next inmoob-swiper-button-next'>
                            <i class='far fa-angle-right'></i>
                        </div>
                    </div>";
        
        }
        
        $output  .= "<div class='inmoob-swipper swiper-wrapper'>
                        {$items}    
                    </div>";
                    
        if(static::get_atts('show_bullets',true)){
            $output  .= "<div class='inmoob-swiper-pagination'></div>";
        }


        $output  .= "</div>        
            </div>";
        return $output;
    }


    static function general_styles(){
        $css = parent::general_styles();

        $css .= '
        .obser-grid-item-content.testimonial-item {
            display: flex;
            justify-content: space-between;
            align-items: start;
            flex-wrap: wrap;
            width: 100%;
        }

        
        .testimonial-picture {
            flex: 0 0 20%;
            max-width: 100px;
            max-height: 100px;
            position: relative;
        }

        .testimonial-picture img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            max-width: 100px;
            max-height: 100px;
            border: none;
            border-radius: 100px;
            padding: 2px;
            background-color: #f3f6f9;
        }

        .testimonial-picture + .testimonial-content {
            flex: 0 0 70%;
            width: 70%;
            margin-left: 3%;
        }
        
        .testimonial-content {
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
        }

        .testimonial-content > .first-name {
            font-weight: bold;
            font-size: 1.2rem;
            text-transform: ;
        }

        .testimonial-content > .message {
            font-size: .8rem;
            line-height: 1rem;
        }

        .read-more-button {
            font-style: italic;
            opacity: .6;
        }

        @media(max-width:768px){


            .obser-grid-item-content.testimonial-item {
                flex-direction: column;
                text-align: center;
            }

            .testimonial-picture {
                margin: 0 auto;
            }

            .testimonial-picture + .testimonial-content {
                flex: 0 0 100%;
                width: 100%;
                margin: 0 auto;
            }

        ';

        return $css;
    }

    static function generate_script($atts){

        echo parent::generate_script($atts);

        echo "<script>
        jQuery('.read-more-button').click(function(e){
            let text = jQuery(this).text();
                    text = (text == '...leer más.') ? '... cerrar.': '...leer más.';
                    jQuery(this).text(text);
            jQuery(this).prev().toggleClass('hidden');
            });</script>";
        
    }


}


 


class Inmoob_testimonial_item extends IO_grid_item{

    static $item;
    static $atts;
    static $css_class;
    static $mode = 'grid';

    public function set_item_atts($atts){
        static::$atts = $atts;
    }

    public function render_item($post){
        $atts       = static::$atts;
        $item       = static::$item = $post;
        $css_class  = static::$css_class;
        $post_id    = static::$item->ID;
        $css_class .= ' main-color';
        $mode       = static::$mode;

        if($mode =='swiper'){
            $css_class .= ' swiper-slide';
        }

        $first_name             = \get_post_meta($post_id,'name',true);
        $rating                 = intval(\get_post_meta($post_id,'rating',true));
        $thumbnail              = \get_the_post_thumbnail_url($post_id,'thumbnail');

        $thumbnail              = ($thumbnail) ? "<div class='testimonial-picture '><img data-src='{$thumbnail}' class='swiper-lazy'> <div class='swiper-lazy-preloader'></div></div>" : null;


        $message                = \get_post_meta($post_id,'message',true);
        $link                   = \get_post_meta($post_id,'link',true);
        $num_words              = 20;
        $words                  = array();
        $words                  = explode(" ", $message);
        $readable               = $notreadable = '';
        $rating_html            = '';
        
        for($i = 0; $i < count($words); $i++){

            if($i <= $num_words){
                $readable .= "$words[$i] ";
            }else{
                $notreadable .= "$words[$i] ";
            }

        }
            

        if($thumbnail){
        }

        $message  = $readable;
        $message .= (count($words) > $num_words)? "<span class='no-readable'><span class='content hidden'>$notreadable</span> <span class='read-more-button'>...leer más.</span></span>" : '';

        for($i = 1; $i <= $rating; $i++){
            $rating_html .= '<i class="fas fa-star"></i>';
        }

        if($link){
            $link = "<a class='testimonial-link' href='$link' target='_blank'>Ver testimonio completo</a>";
        }
            
        $output =
                "<div class='obser-grid-item testimonial-item-$item->ID $css_class'>
                    <div  class='obser-grid-item-content testimonial-item'>
                        {$thumbnail}
                        <div class='testimonial-content'>
                        <span class='rating'>{$rating_html}</span>
                        <span class='first-name'>$first_name</span>
                        <span class='message'>$message</span>
                        $link
                        </div>
                    </div>
                </div>";

        return $output;
    }



}


 