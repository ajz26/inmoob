<?php namespace Inmoob\Shortcodes\Properties;

class Gallery extends Shortcode{

    static $shortcode       = "inmoob_props_gallery";

    public static function generate_css(){
        $style  = '';
        $gallery_mode = self::get_atts('mode','swiper');
        $parent_id                  = static::get_atts('vc_id');
        $element_width              = (int)static::get_atts('element_width', 4);
        $mx_responsive_1            = (int)static::get_atts('mx_responsive_1', 1200);
        $mx_responsive_val_1        = (int)static::get_atts('mx_responsive_val_1', $element_width);

        $mx_responsive_2            = (int)static::get_atts('mx_responsive_2', 1200);
        $mx_responsive_val_2        = (int)static::get_atts('mx_responsive_val_2', $mx_responsive_val_1);

        $mx_responsive_3            = (int)static::get_atts('mx_responsive_3', 1200);
        $mx_responsive_val_3        = (int)static::get_atts('mx_responsive_val_3', $mx_responsive_val_2);
        $items_gap                  = (int)static::get_atts('items_gap', 10);


        if($gallery_mode == 'swiper'){
            
            $style = ".{$parent_id}.swiper-container .inmoob-gallery-wrapper {
                position: absolute !important;
                left: 0;
                right: 0;
                bottom: 0;
                top: 0;
            }
    
            .inmoob-props-gallery {
                max-width: 1024px;
                margin: 0 auto;
                margin-bottom: 2rem;
            }
    
            .{$parent_id}.swiper-container.inmoob-props-gallery::before {
                content: '';
                padding-bottom: 56.25%;
                display: block;
            }
            
            .inmoob-props-gallery .swiper-slide img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                position: absolute;
            }
    
            .inmoob-gallery-swiper-button-prev-next {
                background-color: rgba(255, 255, 255, 0.77);
                z-index: 9999;
                border-radius: .5rem;
                margin-bottom: .5rem;
                position: absolute;
                width: 35px;
                text-align: center;
                height: 35px;
                font-size: 1.5rem;
                line-height: 2.2rem;
                opacity: .6;
                transition: all .5s;
                -webkit-transition: all .5s;
                top: 10px;
            }
    
            .swiper-slide {
                border-radius: 1rem;
                overflow: hidden;
            }
    
            .swiper-pagination-bullet-active {
                opacity: 1;
                background: #ffffff !important;
            }
            
            .inmoob-gallery-swiper-button-next {
                right: 10px;
            }
    
            .inmoob-gallery-swiper-button-prev {
                right: 50px;
            }
    
            .inmoob-gallery-swiper-button-prev-next:hover {
                transition: all .5s;
                -webkit-transition: all .5s; 
                opacity: 1;
                cursor:pointer;
            }
    
    
            @media(max-width:768px){
                .inmoob-props-gallery::before {
                    padding-bottom: 110%;
                }
            }";
        }else if($gallery_mode == 'grid' ){


            

            $style .= "
            .{$parent_id}.gallery-grid-mode .inmoob-gallery-wrapper {
                display: flex;
                flex-flow: wrap;
                flex-wrap: wrap;

                margin-left: calc(({$items_gap}px / 2) * (-1));
                margin-right: calc(({$items_gap}px / 2) * (-1));
            }

            .{$parent_id}.gallery-grid-mode .inmoob-gallery-wrapper .gallery-item.gallery-grid-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius:1.5rem;

            }

            .{$parent_id}.gallery-grid-mode .inmoob-gallery-wrapper .gallery-item {
                max-height: 150px;
                margin-bottom: 0.6rem;
            }


            .{$parent_id}.gallery-grid-mode .inmoob-gallery-wrapper .gallery-item {
                padding-left: calc({$items_gap}px / 2);
                padding-right: calc({$items_gap}px / 2);
            }
            .{$parent_id} .gallery-item {
                width: calc(100% / {$element_width});
            }
            ";
            if (!is_null($mx_responsive_1) && $mx_responsive_val_1 > 0) {
                $style .= "@media only screen and (max-width: {$mx_responsive_1}px) {
                    .{$parent_id} .gallery-item{
                        width: calc(100% / {$mx_responsive_val_1});
                    } 
                }";
            }
            if (!is_null($mx_responsive_2) && $mx_responsive_val_2 > 0) {
                $style .= "@media only screen and (max-width: {$mx_responsive_2}px) {
                    .{$parent_id} .gallery-item{
                        width: calc(100% / {$mx_responsive_val_2});
                    }
                }";
            }
            if (!is_null($mx_responsive_3) && $mx_responsive_val_3 > 0) {
                $style .= "@media only screen and (max-width: {$mx_responsive_3}px) {
                    .{$parent_id} .gallery-item{
                        width: calc(100% / {$mx_responsive_val_3});
                    }
                }";
            }
        }

        return $style;

    }

    public static function general_styles()
    {
        return "

        .pswp__button--arrow--left::before, .pswp__button--arrow--right::before {
            content: '';
            top: 35px;
            background-color: rgba(255, 255, 255, 0.3);
            height: 30px;
            width: 32px;
            position: absolute;
            border-radius: 5px;
        }
        
        .swiper-container {
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }";
    }


    public static function generateContentLoop(){
        global $post;
        $post_id                = $post->ID;
        $images                 = get_post_meta($post_id,'images');
      
        $loopResult = '';
        $gallery_mode = self::get_atts('mode','swiper');
        switch($gallery_mode){
            case 'grid':
            $gallery_mode_class = 'gallery-grid-item';
            break;
            case 'swiper':
            default :
            $gallery_mode_class = 'swiper-slide';

        }
        
        foreach($images AS $image){
            $imageUrl   = wp_get_attachment_image_src($image,'full');
            $link   = $imageUrl[0];
            $width  = $imageUrl[1];
            $height = $imageUrl[2];

            $galleryUrl = wp_get_attachment_image_src($image,'full');

            $src    = $galleryUrl[0];

            if(!$src) continue;

            
                $loopResult .= "<div class='gallery-item {$gallery_mode_class}'>
                    <a href='$link' data-pid='{$image}' data-size='{$width}x{$height}' onclick='return false'>
                        <img class='' src='{$src}'>
                    </a>
                </div>";
           
        }
        if((self::get_atts('show_video',0) == 1 ? true : false) && ($url_video = get_post_meta( $post->ID,'video',true))){

            $loopResult .="
                <div class='gallery-item {$gallery_mode_class}'>
                    <iframe width='100%' height='100%' src='{$url_video}?rel=0&modestbranding=1&autohide=1&showinfo=0&controls=0&mute=1' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
                </div>";
        }
                
        return $loopResult;

    }

    public static function enquee_styles(){
        return array(
            'swiper-js' => array(
                'src'   => OBSER_FRAMEWORK_DIR_URL . 'assets/css/swiper-bundle.min.css',
            ),
            'photoswipe' => array(
                'src'   => OBSER_FRAMEWORK_DIR_URL . 'assets/photoswipe/photoswipe.css',
            ),
            'photoswipe-skin' => array(
                'src'   => OBSER_FRAMEWORK_DIR_URL . 'assets/photoswipe/skin/photoswipe-skin.css',
            ),
        );
    }
    public static function enquee_scripts(){
        return array(
            'swiper-js' => array(
                'src'   => OBSER_FRAMEWORK_DIR_URL . 'assets/js/swiper-bundle.min.js',
                'deps'  => array('jquery'),
                'in_footer'   => false,
            ),
            'photoswipe' => array(
                'src'   => OBSER_FRAMEWORK_DIR_URL . 'assets/photoswipe/photoswipe.min.js',
                'deps'  => array('jquery'),
                'in_footer'   => false,
            ),
            'photoswipe-ui' => array(
                'src'   => OBSER_FRAMEWORK_DIR_URL . 'assets/photoswipe/photoswipe-ui-default.min.js',
                'deps'  => array('jquery'),
                'in_footer'   => false,
            ),
        );
    }

    protected static function gen_swiper_container(string $items){

        $vc_id                  = static::get_atts('vc_id');
        $el_id                  = static::get_atts('el_id');
        $arrows                 = static::get_atts('arrows');
        $bullets                = static::get_atts('bullets');

        $el_class               = esc_attr(static::get_atts('el_class'));


        $arrows = ($arrows == 'show') ? "<div class='inmoob-gallery-swiper-button-prev-next inmoob-gallery-swiper-button-next'>
        <i class='far fa-angle-right'></i>
    </div>
    <div class='inmoob-gallery-swiper-button-prev-next inmoob-gallery-swiper-button-prev'>
        <i class='far fa-angle-left'></i>
    </div>" : null;

        $bullets = ($bullets == 'show') ? "<div class='swiper-pagination'></div>" : null;

        $swiper_container = "<div class='inmoob-props-gallery swiper-container {$el_id}  {$el_class}  {$vc_id}'>
                    {$arrows}
                    <div class='inmoob-gallery-wrapper swiper-wrapper'>
                        $items
                    </div>
                    {$bullets}
                </div>";

        return $swiper_container;
    }

    protected static function gen_grid_container(string $items){
        
        $vc_id                  = static::get_atts('vc_id');


        $swiper_container = "<div class='inmoob-props-gallery gallery-grid-mode {$vc_id}'>
                                <div class='inmoob-gallery-wrapper'>
                                    $items
                                </div>
                            </div>";

        return $swiper_container;
    }


    public static function output($atts,$content){
        add_action('wp_footer', array(__CLASS__,'psw_body_bottom'),1000);

        $items = self::generateContentLoop();
        
        if(!isset($items) || empty($items)) return null;

        $gallery_mode = self::get_atts('mode','swiper');

        switch($gallery_mode){
            case 'grid':
                $output = self::gen_grid_container($items);
            break;
            case 'swiper':
            default:
                $output = self::gen_swiper_container($items);
        }

        return $output;

        
    }


    public static function psw_body_bottom() {
        $content = '
        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        
            <div class="pswp__bg"></div>
            <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
        
                <div class="pswp__ui pswp__ui--hidden">
        
                    <div class="pswp__top-bar">
                        <div class="pswp__counter"></div>
                        
                        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
        
                        <div class="pswp__preloader">
                            <div class="pswp__preloader__icn">
                                <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                        <div class="pswp__share-tooltip"></div> 
                    </div>

                    <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                    </button>

                    <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                    </button>
        
                    <div class="pswp__caption">
                        <div class="pswp__caption__center"></div>
                    </div>
        
                </div>
        
            </div>
        
        </div>
        ';                    

        $script ='
        
        const InmoobPropsGallerySwiper = new Swiper(".inmoob-props-gallery", {
                loop: true,
                slidesPerView: 1,
                centeredSlides: true,
                spaceBetween: 10,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                    dynamicBullets: true,
                },
                navigation: {
                    nextEl: ".inmoob-gallery-swiper-button-next",
                    prevEl: ".inmoob-gallery-swiper-button-prev",
                }
            });
        
        var initPhotoSwipeFromDOM = function(gallerySelector) {

            var parseThumbnailElements = function(el) {

                var thumbElements = el.childNodes,
                    numNodes    = thumbElements.length,
                    items       = [],
                    figureEl,
                    linkEl,
                    size,
                    item;
        
                for(var i = 0; i < numNodes; i++) {
        
                    figureEl = thumbElements[i]; // <DIV> element
        
                    if(figureEl.nodeType !== 1) {
                        continue;
                    }
        
                    linkEl = figureEl.children[0]; // <a> element
        
                    size = linkEl.getAttribute("data-size").split("x");
                    pid  = linkEl.getAttribute("data-pid");
        
                    // create slide object
                    item = {
                        src: linkEl.getAttribute("href"),
                        w: parseInt(size[0], 10),
                        h: parseInt(size[1], 10),
                        pid
                    };
        
        
        
                    if(linkEl.children.length > 0) {
                        // <img> thumbnail element, retrieving thumbnail url
                        item.msrc = linkEl.children[0].getAttribute("src");
                    } 
        
                    item.el = figureEl; // save link to element for getThumbBoundsFn
                    items.push(item);
                }
        
                return items;
            };
        
            // find nearest parent element
            var closest = function closest(el, fn) {
                return el && ( fn(el) ? el : closest(el.parentNode, fn) );
            };
        
            // triggers when user clicks on thumbnail
            var onThumbnailsClick = function(e) {
                e = e || window.event;
                e.preventDefault ? e.preventDefault() : e.returnValue = false;
        
                var eTarget = e.target || e.srcElement;
        
                // find root element of slide
                var clickedListItem = closest(eTarget, function(el) {
                    return (el.tagName && el.tagName.toUpperCase() === "DIV");
                });
        
                if(!clickedListItem) {
                    return;
                }
        
                // find index of clicked item by looping through all child nodes
                // alternatively, you may define index via data- attribute
                var clickedGallery  = clickedListItem.parentNode,
                    childNodes      = clickedListItem.parentNode.childNodes,
                    numChildNodes   = childNodes.length,
                    nodeIndex = 0,
                    index;

                for (var i = 0; i < numChildNodes; i++) {
                    if(childNodes[i].nodeType !== 1) { 
                        continue; 
                    }
        
                    if(childNodes[i] === clickedListItem) {
                        index = nodeIndex;
                        break;
                    }
                    nodeIndex++;
                }
        
        
        
                if(index >= 0) {
                    // open PhotoSwipe if valid index found
                    openPhotoSwipe( index, clickedGallery );
                }
                return false;
            };
        
            // parse picture index and gallery index from URL (#&pid=1&gid=2)
            var photoswipeParseHash = function() {
                var hash = window.location.hash.substring(1),
                params = {};
        
                if(hash.length < 5) {
                    return params;
                }
        
                var vars = hash.split("&");
                for (var i = 0; i < vars.length; i++) {
                    if(!vars[i]) {
                        continue;
                    }
                    var pair = vars[i].split("=");  
                    if(pair.length < 2) {
                        continue;
                    }           
                    params[pair[0]] = pair[1];
                }
        
                if(params.gid) {
                    params.gid = parseInt(params.gid, 10);
                }
        
                return params;
            };
        
            var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
                var pswpElement = document.querySelectorAll(".pswp")[0],
                    gallery,
                    options,
                    items;
        
                items = parseThumbnailElements(galleryElement);

                console.log(galleryElement.getAttribute("data-pswp-uid"));

                options = {
                    bgOpacity           : 0.7,
                    index               : parseInt(index, 10),
                    showHideOpacity     : true,
                    galleryUID          : galleryElement.getAttribute("data-pswp-uid"),
                    history             :true,
                    galleryPIDs         :true,
                    getThumbBoundsFn    : function(index) {
                        var thumbnail = items[index].el.getElementsByTagName("img")[0],
                            pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                            rect = thumbnail.getBoundingClientRect(); 
                        return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                    }
                };
            
                // exit if index not found
                if( isNaN(options.index) ) {
                    return;
                }
        
                if(disableAnimation) {
                    options.showAnimationDuration = 0;
                }

                
        
                // Pass data to PhotoSwipe and initialize it
                gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
                gallery.init();


                if(galleryElements.length == 1 ){
                    gallery.listen("unbindEvents", function() {
                        var getCurrentIndex = gallery.getCurrentIndex();
                        InmoobPropsGallerySwiper.slideTo(getCurrentIndex, 0, false);
                    });
                }
                
            };
        
            var galleryElements = document.querySelectorAll( gallerySelector );

            for(var i = 0, l = galleryElements.length; i < l; i++) {
                galleryElements[i].setAttribute("data-pswp-uid", i+1);
                galleryElements[i].onclick = onThumbnailsClick;
            }
        };
        
        initPhotoSwipeFromDOM(".inmoob-props-gallery");';
        

        $script = '<script>'.$script.'</script>';

        echo $content;
        echo $script;
    }



}