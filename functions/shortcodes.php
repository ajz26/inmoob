<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );
class INMOOB_SHORTCODES extends OBSER_SHORTCODES{
    static    $shortcodes_dir       = INMOOB_CORE_PLUGIN_DIR_PATH ."Shortcodes/";
    static    $shortcodes_namespace = 'Inmoob\Shortcodes';

    protected  static function load_shortcodes($shortcodes_dir = null){
        parent::load_shortcodes($shortcodes_dir);
        // $class              = get_called_class();
        // $shortcodes_dir     = self::$shortcodes_dir;
        // self::$_shortcodes  = self::read_folder($class,$shortcodes_dir);
    }


    // protected static function load_shortcodes($shortcodes_dir = NULL){
    //     $class = get_called_class();
    //     $shortcodes_dir  = INMOOB_CORE_PLUGIN_DIR_PATH ."/Shortcodes/";
    //     $scan            = array_diff(scandir($shortcodes_dir), array('..', '.'));
    //     foreach($scan as $file) {
    //         if(preg_match('/(?<filename>[\w\-\d]*)\.php$/',$file, $matches)){
    //             $class_name = $matches['filename'];
    //             $shortcode  = "Inmoob\Shortcodes\\$class_name";
    //             if(!isset($shortcode::$shortcode)) continue;
    //             self::$_shortcodes[$class][$shortcode::$shortcode] = $shortcode;
    //         }
    //     }

    // }

}

INMOOB_SHORTCODES::instance();