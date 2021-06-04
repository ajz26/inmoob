<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );
/*
 * Plugin Name: Inmoob | Gestión de proyectos inmobiliarios
 * Description: Gestión de proyectos inmobiliarios
 * Version:     1.0
 * Author: A Zambrano | Obser.co
 * Author URI: https://obser.co
 * Domain Path: /languages
*/

class INMOOB_CORE{

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) self::$instance = new self;
        return self::$instance;
    }

    private function __construct() {
        self::define_const();
        self::load_autoload();
        self::load_framework();
        self::load_functions();
        self::load_plugins_support();
    }

    private static function define_const(){

        if ( ! defined( 'INMOOB_CORE_PLUGIN_NAME' ) OR ! defined( 'INMOOB_CORE_PLUGIN_VERSION' ) ) {
            
            if ( ! defined( 'INMOOB_CORE_PLUGIN_DIR_PATH' ) ) {
                define('INMOOB_CORE_PLUGIN_DIR_PATH',plugin_dir_path( __file__ ) );
            }
    
            if ( ! defined( 'INMOOB_CORE_PLUGIN_DIR_URL' ) ) {
                define('INMOOB_CORE_PLUGIN_DIR_URL',plugin_dir_url( __file__ ) );
            }
            
            if ( ! defined( 'INMOOB_CORE_PLUGIN_NAME' ) ) {
                define('INMOOB_CORE_PLUGIN_NAME', plugin_basename( __DIR__  ) );
            }

            if ( ! defined( 'INMOOB_CORE_PLUGIN_VERSION' ) ) {
                define('INMOOB_CORE_PLUGIN_VERSION', get_file_data(__FILE__, array('Version'), 'plugin'));
            }

            unset($plugin_data);    

        }

    }

    private static function load_autoload(){
        require_once  INMOOB_CORE_PLUGIN_DIR_PATH . '/vendor/autoload.php';
    }

    private static function load_framework(){
        if(!class_exists('OBSER')){
            require_once  INMOOB_CORE_PLUGIN_DIR_PATH . '/framework/obser.php';

            if (!defined('RWMB_VER')) require_once INMOOB_CORE_PLUGIN_DIR_PATH .'/libs/meta-box/meta-box.php';
            if(defined('RWMB_VER')){
                require_once INMOOB_CORE_PLUGIN_DIR_PATH .'libs/meta-box-addons/meta-box-tabs/meta-box-tabs.php';
                require_once INMOOB_CORE_PLUGIN_DIR_PATH .'libs/meta-box-addons/meta-box-group/meta-box-group.php';
                require_once INMOOB_CORE_PLUGIN_DIR_PATH .'libs/meta-box-addons/meta-box-conditional-logic/meta-box-conditional-logic.php';
                require_once INMOOB_CORE_PLUGIN_DIR_PATH .'libs/meta-box-addons/meta-box-columns/meta-box-columns.php';
            }
        }
    }

    private static function load_functions(){
        require_once  INMOOB_CORE_PLUGIN_DIR_PATH . '/functions/configs/config.php';
        require_once  INMOOB_CORE_PLUGIN_DIR_PATH . '/functions/functions.php';
    }

    private static function load_plugins_support(){
        require_once INMOOB_CORE_PLUGIN_DIR_PATH ."plugins-support/js_composer/js_composer.php";
    }
}

INMOOB_CORE::instance();
