<?php

namespace lib\lang;

use \lib\register\Vars;
use \lib\session\Session;

use \lib\loader\Configurator;


/**
 * Description of Language
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jun 30, 2016
 */
class Language {

    private static $lang = null;
    
    private static $locale;
    
    private static $langs = [];

    private function __construct() { }
    
    /**
     * 
     * @param string $lang
     */
    public static function setLang($default, $lang = null){

        // look in the requests
        if($lang == null){
            $lang = Vars::getRequests(Session::SESS_LANG);
        }
        
        //look in the url
        if($lang == false){
            $lang = Vars::getLang();
        }
        
        // look in the session
        if($lang == false){
            $lang = Session::getSessionVar(Session::SESS_LANG);
        }
        
        if ($lang == false) {
            $lang = $default;
        }
        
        if ($lang == false) {
            $lang = self::getHttpLanguage();
        }
        
        Vars::setLang($lang);
        
        return $lang;
        
    }
    
    public static function registry($lang){
        Session::setSession(Session::SESS_LANG, $lang);
        setlocale(LC_ALL, self::$locale); 
        
        Vars::setLang($lang);
        
    }
    
    private static function getHttpLanguage() {
        $accept = filter_input(INPUT_SERVER, 'HTTP_ACCEPT_LANGUAGE');
        if ($accept == null) {
            return false;
        } else {
            //string(14) "en-US,en;q=0.5" 
            list($http_str, ) = explode(';', filter_input(INPUT_SERVER, 'HTTP_ACCEPT_LANGUAGE'));

            list(, $lang) = explode(',', $http_str);
        }
        return $lang;
    }

    /**
     * Validate lang along langs table or xml config default lang
     * 
     * @param string $lang
     */
    public static function checkLang($lang = null){
        
        $langs = \model\querys\LangsQuery::start()->find();
 
        foreach($langs as $l){
            
            if($l->getTld() == $lang){
                self::$langs = self::setToBegin(self::$langs, $l->getTld(), $l->getName());
                self::$lang = $l->getTld();
                self::$locale = $l->getLocale();
                if(null == self::$langdefault){
                    self::$langdefault = $l->getTld();
                }
            }elseif($l->getTld() == Configurator::getLangDefault()){
                if(self::$lang == null){
                    self::$lang = $l->getTld();
                    self::$langs = self::setToBegin(self::$langs, $l->getTld(), $l->getName());
                    self::$locale = $l->getLocale();
                }else{
                    $arr1 = array_slice(self::$langs, 0, 1);
                    self::$langs = self::setToBegin(array_slice(self::$langs, 1), $l->getTld(), $l->getName());
                    self::$langs = self::setToBegin(self::$langs, key($arr1), $arr1[key($arr1)]);
                }
                self::$langdefault = $l->getTld();
            }else{
                self::$langs[$l->getTld()] = $l->getName();
            }
        }

    }
    
    private static $langdefault = null;

    public static function getLangDefault(){
        return self::$langdefault;
    }

    public static function getLangsArray(){
        return self::$langs;
    }
    
    public static function getTldArray(){
        return array_keys(self::$langs);
    }
    
    private static function setToBegin($arr, $key, $value){
        $arr = array_reverse($arr, true);
        $arr[$key] = $value;
        
        return array_reverse($arr, true);
    }
    
    /**
     * 
     * @return lang
     */
    public static function getLang(){
        return self::$lang;
    }

}
