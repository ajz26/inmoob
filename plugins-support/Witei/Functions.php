<?php namespace Inmoob\Witei {

    require_once INMOOB_CORE_PLUGIN_DIR_PATH ."plugins-support/Witei/importer.php";

}


namespace Inmoob\Witei\Functions {
    
    function get_post_by_id($witei_id = null){

        if(!$witei_id) return null;

        global $wpdb;

            $sql = "SELECT pm.post_id 
            FROM {$wpdb->postmeta} pm 
            JOIN {$wpdb->posts} p 
            ON p.ID = pm.post_id 
            AND post_type = \"inmoob_properties\"
            WHERE meta_key = \"witei_id\" 
            AND meta_value = $witei_id 
            ";

        $post_id    = $wpdb->get_var( $sql );

        return isset($post_id) ? (int)$post_id : null;
    }

}

