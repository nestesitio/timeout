<?php

namespace lib\routing;

use \lib\xml\XmlFile;
use \lib\session\SessionUser;
use \lib\url\Redirect;

/**
 * Description of XmlRouting
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Apr 27, 2016
 */
class XmlRouting
{
    private static $controller = null;

    private function __construct() {}

    /**
     * Check if routing is provided by file config/routing.xml
     * @param array $params
     * @param string $config_file The path for xml file
     * @return boolean
     */
    public static function check($params, $config_file = 'config/routing.xml')
    {
        $url = self::getRoute($params);
        $xml = XmlFile::getXmlSimpleFromFile($config_file);
        foreach ($xml->route as $route) {
            if ($route['url'] == $url) {
                self::$controller = $route->controller['class'];
                $controller_auth = $route->access['group'];
                if($controller_auth == 'all' || $controller_auth == SessionUser::getPlayerGroup()){
                    return true;
                }elseif(SessionUser::isValidGroup($controller_auth) == true){
                    return true;
                }elseif($route->access['redirect'] != null){
                    Redirect::redirectToUrl($route->access['redirect']);
                }
            }
        }

        return false;
    }

    /**
     * Check if routing is provided by file routing.xml
     * @param array $params
     * @return boolean
     */
    public static function checkInFolder($params, $level, $config_file = 'config/routing.xml')
    {
        $url = self::getRoute($params);
        $xml = XmlFile::getXmlSimpleFromFile($config_file);
        foreach ($xml->route as $route) {
            if ($route['url'] == $url) {
                self::$controller = $route->controller['class'];
                $controller_auth = $route->access['group'];
                
                if($controller_auth == 'all'){
                    return true;
                }else{
                    if (\tools\general\UserUtilities::getAuth($level, $controller_auth) == true) {
                        return true;
                    } elseif ($route->access['redirect'] != null) {
                        Redirect::redirectToUrl($route->access['redirect']);
                        die('No route found');
                        
                    }
                }
            }
        }
        return false;
    }
    
    
    

    public static function getApp()
    {
        return self::$controller;
    }

    /**
     *
     * @param array $params
     * @return string
     */
    private static function getRoute($params)
    {
        if($params['controller'] == 'index'){
            $url = $params['appslug'];
        }else{
            $url = $params['appslug'] . '/' . $params['controller'];
        }
        return $url;
    }

}
