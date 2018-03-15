<?php

namespace apps\Editor\tools;

use \lib\register\Vars;
use \lib\media\Image;

/**
 * Description of ZoneTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 5, 2017
 */
class ZoneTools {
    
    const ZONE_MIDDLE_NORTH_WEST = 'middle-north-west';
    const ZONE_MIDDLE_SOUTH_WEST = 'middle-south-west';
    const ZONE_MIDDLE_EAST = 'middle-east';
    const ZONE_ACADEMY = 'academy';
    const ZONE_STUDIO = 'studio';
    const ZONE_BOTTOM_NORTH_WEST = 'bottom-north-west';
    const ZONE_BOTTOM_SOUTH_WEST = 'bottom-south-west';
    const ZONE_BOTTOM_EAST = 'studio';

    public static function switchZone($zone, $post_id){
        $area = '';
        if(strpos($zone, 'middle') === 0){
            $area = 'middle';
            $buttons = ['north-west', 'south-west', 'east'];
        }
        
        if(strpos($zone, 'bottom') === 0){
            $area = 'bottom';
            $buttons = ['north-west', 'south-west', 'studio'];
        }
        
        if(strpos($zone, 'studio') === 0){
            $area = 'studio';
            $buttons = ['west', 'studio'];
        }
        
        if(!isset($buttons)){
            return '';
        }
        
        $string = '';
        foreach($buttons as $btn){
            $url = '/backend/editor/switchzone_' . Vars::getCanonical(). DS . $post_id . DS . '?js=1';
            $class = 'zone-switcher-btn btn-' . $btn;
            if($zone == $area . '-' . $btn){
                $class .= ' disabled';
            }
            $string .= '<a class="' . $class . '" '
                    . 'data-action="' . $url . '" '
                    . 'data-source="' . $zone . '" data-destinity="' . $area . '-' . $btn . '">'
                    . '<i>...</i></a>';
        }
        return $string;
    }
    
    public static function getZoneImageArgs($zone){
        $params['folder'] = '/wp-content/uploads/editor';
        if($zone == self::ZONE_MIDDLE_EAST){
            $params[Image::MIN_RATIO] = 0.5;
            $params[Image::MAX_RATIO] = 0.6;
            $params[Image::MIN_HEIGHT] = 510;
        }
        if($zone == self::ZONE_MIDDLE_NORTH_WEST || $zone == self::ZONE_MIDDLE_SOUTH_WEST){
            $params[Image::MIN_RATIO] = 2.8;
            $params[Image::MAX_RATIO] = 3.5;
            $params[Image::MIN_WIDTH] = 700;
        }
        if($zone==self::ZONE_ACADEMY){
            //$params[Image::MIN_RATIO] = 1.2;
            $params[Image::MIN_WIDTH] = 800;
        }
        if($zone==self::ZONE_STUDIO){
            //$params[Image::MIN_RATIO] = 1.2;
            $params[Image::MIN_WIDTH] = 800;
        }
        if($zone == self::ZONE_BOTTOM_NORTH_WEST || $zone == self::ZONE_BOTTOM_SOUTH_WEST){
            $params[Image::MIN_RATIO] = 1.0;
            $params[Image::MIN_WIDTH] = 700;
        }
        
        
        return $params;
    }

}
