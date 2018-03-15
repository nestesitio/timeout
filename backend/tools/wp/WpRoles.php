<?php

namespace tools\wp;

use \lib\session\WordpressSession;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WpRoles
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 18, 2016
 */
class WpRoles {
    
    private static $roles = ['subscriber'=>'user',  'contributor'=>'user', 'author'=>'editor', 
        'editor'=>'editor', 'administrator'=>'admin'];

    public static function getRole(){
        foreach(array_keys(self::$roles) as $role){
            if(current_user_can( $role ) == 1){
                return $role;
            }
        }
    }
    
    public static function getLevel(){
        foreach(self::$roles as $role=>$level){
            //if(current_user_can( $role ) == 1){
            if($role == WordpressSession::getRole()){
                return $level;
            }
        }
    }

}
