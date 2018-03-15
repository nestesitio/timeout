<?php

namespace lib\routing;

use \lib\register\Vars;

use \lib\register\Monitor;
use \lib\session\Session;
use \lib\routing\ParseRoute;

/**
 * Description of Router
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Apr 27, 2016
 */
class Router
{
    private function __construct() {}

    private static $folder;
    
    private static $actionclass;

    /**
     *
     * @param string $controller
     *
     * @return boolean | string
     */
    public static function getClass($controller)
    {

        list($app, $control) = explode('/', $controller);
        Vars::setApp($app);

        self::$folder = ucfirst($app);
        $namespace = '\apps\\' . self::$folder . '\\';

        // assign controller full name
        $class = self::getControlClass($app, $control, $namespace);
        self::$actionclass = $control;
        // if we have extended controller
        if (!class_exists($class)) {
            //try with name of app
            $class = self::getControlClass($app, $app, $namespace);
            Vars::setAction($app);
            self::$actionclass = $app;
            if (!class_exists($class)) {
                return false;
            }
            
        }
        return $class;
    }

    /**
     *
     * @param string $app
     * @param string $control
     * @param string $namespace
     *
     * @return string
     */
    private static function getControlClass($app, $control, $namespace)
    {
        $actions_class = $control;
        if(strpos($actions_class, '_')){
            $actions_class = substr(strrchr($actions_class, '_'), 1 );
        }elseif($actions_class == 'default'){
            $actions_class = $app;
        }
        $class = $namespace . 'control\\' . ucfirst($actions_class) . 'Actions';
        $class = str_replace('ActionsActions', 'Actions', $class);
        return $class;
    }


    /**
     * @param string $class
     * @return bool|string
     */
    public static function getMethod($class, $params = [])
    {
        // prepare Action
        $str = 'x' . str_replace('_', ' ', $params[ParseRoute::PART_ACTION]);
        $action = str_replace(' ', '', substr(ucwords($str), 1));
        
        
        Monitor::setMonitor(Monitor::ACTION, 'Action is ' . $action . ' for ' . $params[ParseRoute::PART_ACTION]);
        
        $hasActionFunction = (int) method_exists($class, $action . 'Action');
        if ($hasActionFunction == 0) {
            $hasActionFunction = (int) method_exists($class, self::$actionclass . 'Action');
            Monitor::setMonitor(Monitor::ACTION, 'Action is ' . self::$actionclass . ' for ' . $params[ParseRoute::PART_ACTION]);
            if ($hasActionFunction == 0) {
                return false;
            }
            $method = self::$actionclass . 'Action';
        }else{
           $method = $action . 'Action';
           Vars::setAction($action); 
        }

        Monitor::setMonitor(Monitor::ACTION, $method);
        return $method;
    }
    
    /**
     * Get class name to embed in view
     * 
     * @param string $route 'App/Control'
     * @return boolean|string
     */
    public static function getEmbed($route){
        list($app, $control) = explode('/', $route);
        $namespace = '\apps\\' . ucfirst($app) . '\\';
        
        
        // assign controller full name
        $class = self::getControlClass($app, $control, $namespace);
        // if we have extended controller
        if (!class_exists($class)) {
            return false;
        }
        
        return $class;
    }    
    
    public static function getEmbedAction($class, $action_name){
        // prepare Action
        $str = 'x' . str_replace('_', ' ', $action_name);
        $action = str_replace(' ', '', substr(ucwords($str), 1));
        
        $hasActionFunction = (int) method_exists($class, $action . 'Action');
        if ($hasActionFunction == 0) {
            return false;
        }

        $method = $action . 'Action';

        return $method;
    }

    public static function getFolder()
    {
        return self::$folder;
    }

    /**
     * @param object $controller
     * @return bool
     */
    public static function aboutExtended($controller, $page = '0')
    {
        $extend = $controller->getExtended();
        if(!empty($extend)){
            Monitor::setMonitor(Monitor::TPL, $extend);
            /* if is not a ajax call,
             * update SessionPage
             * else
             * this var is already refreshed
             */
            Session::setSessionPage($page);
            Monitor::setMonitor(Monitor::PAGID, $page);
            return true;
        }else{
            return false;
        }
    }
    
    const STR_PAGE = 'page';
    
    const STR_DEFAULT = 'default';


}
