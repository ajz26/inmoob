<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );
class INMOOB_SHORTCODES extends OBSER_SHORTCODES{
    static    $shortcodes_dir       = INMOOB_CORE_PLUGIN_DIR_PATH ."Shortcodes/";
    static    $shortcodes_namespace = 'Inmoob\Shortcodes';


}

INMOOB_SHORTCODES::instance();