<?php namespace Inmoob\Shortcodes\Properties;

class Gallery extends Shortcode{

    static $shortcode       = "inmoob_props_gallery";

    public static function generate_css(){

    }


    public static function generateContentLoop(){
        global $post;
        $post_id                = $post->ID;
        $images                 = get_post_meta($post_id,'images');
      
        $loopResult = '';

        foreach($images AS $image){
            $imageUrl   = wp_get_attachment_image_src($image,'full');
            $link   = $imageUrl[0];
            $width  = $imageUrl[1];
            $height = $imageUrl[2];

            $galleryUrl = wp_get_attachment_image_src($image,'full');

            $src    = $galleryUrl[0];
            $img = '<a href="' . $link. '" data-pid="'.$image.'" data-size="' . $width . 'x' . $height . '">
                        <img class="" src="'.$src.'">
                    </a>';
            $loopResult .= "<div class='swiper-slide '>$img</div>";
        }

        return $loopResult;

    }

    public static function enquee_styles()
    {
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
    public static function enquee_scripts()
    {
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


    public static function output($atts,$content){
        add_action('wp_footer', array(__CLASS__,'psw_body_bottom'));

        $loopResult             = self::generateContentLoop();        
        $output = "<div class=\"inmoob-props-gallery swiper-container\">
                        <div class=\"swiper-button-next\"></div>
                        <div class=\"swiper-button-prev\"></div>
                        <div class=\"swiper-wrapper\">
                            $loopResult
                        </div>
                        <div class=\"swiper-pagination\"></div>

                    </div>";

        $output .= "<script>jQuery(document).ready(function($){

            const swiper = new Swiper('.inmoob-props-gallery', {
                loop: true,
                slidesPerView: 1,
                centeredSlides: true,
                spaceBetween: 10,
                pagination: {
                    el: \".swiper-pagination\",
                    clickable: true,
                  },
                navigation: {
                    nextEl: \".swiper-button-next\",
                    prevEl: \".swiper-button-prev\",
                }
                });

          });</script>";
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
        
                        <!--  Controls are self-explanatory. Order can be changed. -->
        
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

        $script ='var initPhotoSwipeFromDOM = function(gallerySelector) {

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
            };
        
            var galleryElements = document.querySelectorAll( gallerySelector );

            for(var i = 0, l = galleryElements.length; i < l; i++) {
                galleryElements[i].setAttribute("data-pswp-uid", i+1);
                galleryElements[i].onclick = onThumbnailsClick;
            }
        };
        initPhotoSwipeFromDOM(".inmoob-props-gallery");
        ';
        

        $script = '<script>'.$script.'</script>';

        echo $content;
        echo $script;
    }



}