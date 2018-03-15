<?php

namespace tools\general;

/**
 * Description of UserUtilities
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 18, 2016
 */
class UserUtilities {

    function __construct() {}
    
    public static $levels = ['virtual', 'visitor', 'user', 'editor', 'admin'];
    
    public static function getAuth($userlevel, $applevel){
        $auth = false;
        
        $levels = array_reverse(self::$levels);
        foreach($levels as $l){
            if($userlevel == $l){
                $auth = true;
            }
            if($auth == true && $applevel == $l){
                return true;
            }
        }
        
        return false;
    }

}
