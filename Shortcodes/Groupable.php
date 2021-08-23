<?php

namespace Inmoob\Shortcodes;

use OBSER\Classes\Shortcode;

class Groupable extends Shortcode {
    
    static $shortcode = "inmoob_grupable";
    static $wpb_namespace = "Inmoob\\WPB_Components";


    public static function generate_css()
    {   
        $style  = '';
        $atts                       = static::get_atts();
        $parent_id                  = static::get_atts('vc_id');
        $justify                    = static::get_atts('justify', 'space-around');
        $element_width              = (int)static::get_atts('element_width', 1);
        $mx_responsive_1            = (int)static::get_atts('mx_responsive_1', 1200);
        $mx_responsive_val_1        = (int)static::get_atts('mx_responsive_val_1', $element_width);

        $mx_responsive_2            = (int)static::get_atts('mx_responsive_2', 1200);
        $mx_responsive_val_2        = (int)static::get_atts('mx_responsive_val_2', $mx_responsive_val_1);

        $mx_responsive_3            = (int)static::get_atts('mx_responsive_3', 1200);
        $mx_responsive_val_3        = (int)static::get_atts('mx_responsive_val_3', $mx_responsive_val_2);
        $items_gap                  = (int)static::get_atts('items_gap', 10);

        $style .= "

        
        .{$parent_id} {
            justify-content: {$justify};
            display: flex;
            flex-wrap: wrap;
        }

        .{$parent_id}.row  > *{
            margin-left: calc(({$items_gap}px / 2) * (-1));
            margin-right: calc(({$items_gap}px / 2) * (-1));
        }
        .{$parent_id}.row  > * {
            padding-left: calc({$items_gap}px / 2);
            padding-right: calc({$items_gap}px / 2);
        }

        .{$parent_id}.column  > *{
            margin-bottom: {$items_gap}px;
        }



        .{$parent_id}  > * {
            width: calc(100% / {$element_width});
            flex : 0 0 calc(100% / {$element_width});
        }
        ";
        if (!is_null($mx_responsive_1) && $mx_responsive_val_1 > 0) {
            $style .= "@media only screen and (max-width: {$mx_responsive_1}px) {
                .{$parent_id}  > *{
                    width: calc(100% / {$mx_responsive_val_1});
                    flex: 0 0 calc(100% / {$mx_responsive_val_1});
                } 
            }";
        }
        if (!is_null($mx_responsive_2) && $mx_responsive_val_2 > 0) {
            $style .= "@media only screen and (max-width: {$mx_responsive_2}px) {
                .{$parent_id}  > *{
                    width: calc(100% / {$mx_responsive_val_2});
                    flex:  0 0 calc(100% / {$mx_responsive_val_2});
                    margin-bottom: 1rem;

                }
            }";
        }
        if (!is_null($mx_responsive_3) && $mx_responsive_val_3 > 0) {
            $style .= "@media only screen and (max-width: {$mx_responsive_3}px) {
                .{$parent_id}  > *{
                    width: calc(100% / {$mx_responsive_val_3});
                    flex: 0 0 calc(100% / {$mx_responsive_val_3});
                }
            }";
        }

        return $style;
    }

    static function output($atts, $content){
        $vc_id          = self::get_atts('vc_id');
        $uniqid         = self::get_atts('el_id');
        $customclass    = self::get_atts('el_class');
        $align          = self::get_atts('align','column');
        $content        = do_shortcode($content);
        $output         =  "<div id='$vc_id' class='groupable-container {$align} {$vc_id} {$uniqid} {$customclass}'>
                                {$content}
                            </div>";
        return $output;
    }
}