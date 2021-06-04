<?php
namespace Inmoob\Classes;
use OBSER\Classes\Shortcode as Obser_shortcode;

abstract  class Shortcode extends Obser_shortcode{
    
    static $shortcode;
    static $atts = [];
    static $wpb_namespace = "Inmoob\\WPB_Components";


}