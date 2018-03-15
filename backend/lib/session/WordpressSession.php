<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lib\session;


/**
 * Description of WordpressSession
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Feb 17, 2018
 */
class WordpressSession extends \lib\session\Session
{

    private static $role = 'wp_role';
    
    private static $user = 'wp_user';
    
    public static function setUserLogged($user)
    {
        self::setSession(self::$user, $user);
        self::setSession(self::$role, $user->roles[0]);
        
                
    }
    
    public static function getRole()
    {
        return self::getSessionVar(self::$role);
    }

}
