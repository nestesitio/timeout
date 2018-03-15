<?php

namespace lib\loader;

use \lib\register\Vars;
use \lib\routing\XmlRouting;
use \lib\routing\Router;
use \lib\register\Monitor;
use \lib\lang\Language;

/**
 * Description of WPBoot
 * Boot MVC to work with wordpress
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 18, 2016
 */
class BootInFolder extends \lib\routing\Dispatcher {
    
    private static $folder = '';
    

    public static function run($folder, $level)
    {
        
        
        self::$folder = $folder;
        
        new \lib\loader\Configurator;
        
        /*
         * The routing url, we need to use original 'QUERY_STRING'
         * from server parameter because php has parsed the url if we use $_GET
         */
        $url = \lib\url\UrlRegister::getUrlRequest();
        
        Vars::setRoute($url);

        //parse the url and get $params
        $querystring = self::parseUrl($url);
        
        //regist vars GET and POST
        self::registParams(self::$params);
        self::registVars($querystring);
        
        $lang = Language::setLang(Configurator::getLangDefault(), Configurator::getSingleLang());
        Language::registry($lang);
        

        //set the action for the page
        $controller = false;
        $route = self::checkRoute(self::$params, $level);
        
        
        if($route != false){
            $controller = self::fireController(self::$params, $route);
            $controller = self::fireView($controller);
        }
        self::output($controller);


    }
    
    
    


    private static function checkRoute($params, $level)
    {
        $route = null;
        
        if(XmlRouting::checkInFolder($params, $level) == true){
            $route = XmlRouting::getApp();
        }

        if($route == null){
            \lib\url\Redirect::redirectToUrl('/' . self::$folder);
        }
        
        return $route;

    }


    /**
     * 
     * @param object $controller
     */
    private static function output($controller)
    {
        if ($controller != false) {
            
            $extend = Router::aboutExtended($controller);
            //output
            $output = $controller->dispatch();
            if ($controller->messages == false) {
                echo $output;
            } elseif ($controller->layout == false) {
                exit;
            } elseif (empty($output)) {
                echo self::displayError();
            } elseif ($controller->messages == true) {
                echo \lib\control\ControlMessages::write($output, $extend);
            }
            
        } else {
            echo \lib\routing\ErrorPage::execute(true);
        }
    }

    private static function displayError()
    {
        $errors = Monitor::getErrorMessages();
        echo 'EMPTY FILE - '.count($errors).' Errors<hr />';
        foreach ($errors as $error) {
            echo '<br />' . $error;
        }
        $msgs = Monitor::getMonitor();
        foreach ($msgs as $msg) {
            echo $msg->write();
        }
    }
    
    public static function getFolder(){
        return self::$folder;
    }
    
    
    
    

}
