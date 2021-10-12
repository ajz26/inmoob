<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 *  Create a new custom yoast seo sitemap
 */
 
add_filter( 'wpseo_sitemap_index', 'ex_add_sitemap_custom_items' );
add_action( 'init', 'init_wpseo_do_sitemap_actions' );


// Add custom index
function ex_add_sitemap_custom_items(){
	global $wpseo_sitemaps;
	$date = $wpseo_sitemaps->get_last_modified('CUSTOM_POST_TYPE');

	$smp ='';

    	$smp .= '<sitemap>' . "\n";
	$smp .= '<loc>' . site_url() .'/INMOOB_LINKS-sitemap.xml</loc>' . "\n";
	$smp .= '<lastmod>' . htmlspecialchars( $date ) . '</lastmod>' . "\n";
	$smp .= '</sitemap>' . "\n";


	return $smp;
}


function init_wpseo_do_sitemap_actions(){
	add_action( "wpseo_do_sitemap_INMOOB_LINKS", 'ex_generate_origin_combo_sitemap');
}




function ex_generate_origin_combo_sitemap(){


	global $wpseo_sitemaps;
 
	// Generate terms URLs
	$practitioner_terms = get_terms( 'property_types_taxonomy', 'orderby=count&hide_empty=0' );
	

    $output = '';
	$gestion_types_taxonomy      = get_terms( 'gestion_types_taxonomy', 'orderby=count&hide_empty=0' );
	$property_types_taxonomy     = get_terms( 'property_types_taxonomy', 'orderby=count&hide_empty=0' );
    $property_zones_taxonomy     = get_terms( 'property_zones_taxonomy', 'orderby=count&hide_empty=0' );
    if( !empty( $property_types_taxonomy ) ){
        $pri = 1;
        $chf = 'weekly';
        foreach ($gestion_types_taxonomy as $key => $gestion_type ){

            $gestion_type_link = get_term_link($gestion_type, 'gestion_types_taxonomy');

            foreach ($property_types_taxonomy as $key => $property_type ){

                $property_types_taxonomy_link = "$gestion_type_link/{$property_type->slug}";
                $url        = array();
                $url['loc'] = $property_types_taxonomy_link;
                $url['pri'] = $pri;
                $url['chf'] = $chf;
                $output .= $wpseo_sitemaps->renderer->sitemap_url( $url );
                foreach ($property_zones_taxonomy as $key => $property_zones ){
                    $property_zones_taxonomy_link = "$property_types_taxonomy_link/{$property_zones->slug}";
                    $url        = array();
                    $url['loc'] = $property_zones_taxonomy_link;
                    $url['pri'] = $pri;
                    $url['chf'] = $chf;
                $output .= $wpseo_sitemaps->renderer->sitemap_url( $url );
                }
            }
        }
    }


        if ( empty( $output ) ) {
            $wpseo_sitemaps->bad_sitemap = true;
            return;
        }

        // var_export();
        $output = trim($output);
        //Build the full sitemap
        $sitemap  = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
        $sitemap .= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" ';
        $sitemap .= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $sitemap .= $output.'</urlset>';

        //echo $sitemap;
        $wpseo_sitemaps->set_sitemap($sitemap);

}

/*********************************************************
 *  OR we can use $wpseo_sitemaps->register_sitemap( 'INMOOB_LINKS', 'METHOD' );
 ********************************************************/

add_action( 'init', function () {
	global $wpseo_sitemaps;
	$wpseo_sitemaps->register_sitemap( 'INMOOB_LINKS', 'ex_generate_origin_combo_sitemap' );
}, 99 );
/**
 * On init, run the function that will register our new sitemap as well
 * as the function that will be used to generate the XML. This creates an
 * action that we can hook into built around the new
 * sitemap name - 'wp_seo_do_sitemap_my_new_sitemap'
 */


add_action( 'init', function(){
	add_action( 'wp_seo_do_sitemap_our-INMOOB_LINKS', 'ex_generate_origin_combo_sitemap' );
});






// function ex_add_sitemap_custom_items(){
// 	global $wpseo_sitemaps;

// 	$date = $wpseo_sitemaps->get_last_modified('property_types_taxonomy');
// 	$smp ='';
//     	$smp .= '<sitemap>' . "\n";
// 	$smp .= '<loc>' . site_url() .'/property_types_taxonomy_custom-sitemap.xml</loc>' . "\n";
// 	$smp .= '<lastmod>' . htmlspecialchars( $date ) . '</lastmod>' . "\n";
// 	$smp .= '</sitemap>' . "\n";
// 	return $smp;
// }
// function init_wpseo_do_sitemap_actions(){
// 	add_action( "wpseo_do_sitemap_property_types_taxonomy_custom", 'ex_generate_origin_combo_sitemap');
// }
// function ex_generate_origin_combo_sitemap(){
//     global $wpseo_sitemaps;
//     var_export($wpseo_sitemaps->sitemap_url());

//     return;

// 	$output = '';
// 	$property_types_taxonomy = get_terms( 'property_types_taxonomy', 'orderby=count&hide_empty=0' );
//     $property_zones_taxonomy     = get_terms( 'property_zones_taxonomy', 'orderby=count&hide_empty=0' );
//     if( !empty( $property_types_taxonomy ) ){
//         $pri = 1;
//         $chf = 'weekly';
//         foreach ($property_types_taxonomy as $key => $term ){
//             foreach ($property_zones_taxonomy as $key => $terms ){
//                 $url        = array();
//                 $url['loc'] = site_url().'/collection/'.$term->slug.'/product-tag/'.$terms->slug;
//                 $url['pri'] = $pri;
//                 $url['chf'] = $chf;
//                 $output .= $wpseo_sitemaps->sitemap_url( $url );
//             }
//         }
//     }


//     return $output;
// }