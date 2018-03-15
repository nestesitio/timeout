<?php

namespace lib\cart;

use \lib\session\Session;

/**
 * Description of SessionCart
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 24, 2016
 */
class SessionCart {

    
    public static function reset(){
        Session::setSession(Session::SESS_SHOP, null);
    }
    
    public static function addToCart($id, $quantity){
        $session = Session::getSessionVar(Session::SESS_SHOP);
        $session[$id] = $quantity;

        Session::setSession(Session::SESS_SHOP, $session);
    }
    
    public static function getCart(){
        return Session::getSessionVar(Session::SESS_SHOP);
    }
    
    public static function getItemQuantity($id){
        $session = Session::getSessionVar(Session::SESS_SHOP);
        if(isset($session[$id])){
            return $session[$id];
        }
        

        return 0;
    }
    
    public static function setTotalPoints($points){
        Session::setSession('points', $points);
    }
    
    public static function getTotalPoints(){
        Session::getSession('points');
    }

}
