<?php

namespace lib\routing;

use \lib\routing\ParseRoute;
use \lib\register\Vars;
use \lib\register\Monitor;

/**
 * Description of Dispatcher
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 30, 2016
 */
class Dispatcher {

     /**
     *
     * @var array
     */
    protected static $params = [];
    
    public static function getParams(){
        return self::$params;
    }
    
    /**
     * Parse the url and regist GET and POST variables
     * 
     * @param string $url
     * @return string
     */
    protected static function parseUrl($url){
        
        //parse the url
        $parse = new ParseRoute($url);
        $querystring = $parse->getQueryString();
        self::$params = $parse->getRoutePortions();
        Vars::setVars('params', self::$params);
        
        
        return $querystring;
        
    }

    /**
     * Regist all the varables from POST and GET
     * @param array $params
     */
    protected static function registParams($params)
    {
         //regist all post variables
        Vars::registPosts();
        Vars::registRequests();
        $canonical = (isset($params[ParseRoute::PART_CANONICAL]))? $params[ParseRoute::PART_CANONICAL] : 'index';
        Vars::setApp($params[ParseRoute::PART_APPSLUG]);
        Vars::setCanonical($canonical);
        Vars::setAction($params[ParseRoute::PART_ACTION]);
        Vars::setId($params[ParseRoute::PART_ID]);
        Vars::setLang($params[ParseRoute::PART_LANG]);
        Vars::setSlugVar($params[ParseRoute::PART_VAR]);
    }
    
    /** process url query string after ?, but ? was allready deleted by htaccess
     * @param string $querystring
     */
    protected static function registVars($querystring)
    {
        $params = explode('&', substr($querystring, 1));
        if (count($params) > 1) {
            foreach ($params as $param) {
                list($key, $value) = explode('=', $param);
                Vars::setVars($key, $value);
            }
        }
    }
    
    /**
     * 
     * @param array $params
     * @param string $route
     * 
     * @return boolean|object
     */
    protected static function fireController($params, $route)
    {
        $class = Router::getClass($route);
        if($class == false){
            Monitor::setMonitor(Monitor::CONTROL, 'There is no class name ' . $class);
            Monitor::setErrorMessages(null, ['message'=>'No class found for url ' . Vars::getRoute()]);
            return FALSE;
        }
        $controller = new $class();

        $action = Router::getMethod($class, $params);

        if($action == false){
            Monitor::setMonitor(Monitor::ACTION, 'There is no action name for ' . $action);
            Monitor::setErrorMessages(null, ['message'=>'No method found for url ' . Vars::getRoute()]);
            return false;
        }

        $controller->$action();


        return $controller;


    }

    /**
     *
     * @param object $controller
     * @return boolean|object
     */
    protected static function fireView($controller)
    {
        if ($controller != false) {
            //prepare View
            //if action defines view ($this->setView())
            $template = $controller->getTemplate();

            if (null == $template && $controller->layout == true) {
                $view_file = Vars::getAction();
                $template = 'apps' . DS . Router::getFolder() . DS . 'view' . DS . $view_file;
                //else here we define view
                $result = $controller->setView($template);
                if ($result == false) {
                    return false;
                }
            }
            Vars::setView($template);

            return $controller;
        }
        return false;
    }
    
    
    /**
     * 
     * @param type $control
     * @param type $action_name
     * @param type $view
     * @return boolean
     */
    public static function embed($control, $action_name, $view = null){
        
        $class = Router::getEmbed($control);
        if($class == false){
            Monitor::setErrorMessages(null, ['message'=>'No class found for url ' . $control]);
            return FALSE;
        }
        
        $controller = new $class();

        $action = Router::getEmbedAction($class, $action_name);

        if($action == false){
            Monitor::setErrorMessages(null, ['message'=>'No method found as ' . $action_name]);
            return false;
        }
        
        if (null != $view) {
            $controller->setView($view);
        }

        return $controller->$action();
 
    }

}
