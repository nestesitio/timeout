<?php

namespace lib\loader;


use \lib\routing\ParseRoute;
use \lib\session\Session;
use \lib\register\Vars;
use \lib\routing\XmlRouting;
use \lib\routing\DBRouting;
use \lib\routing\Router;
use \lib\register\Monitor;
use \lib\lang\Language;


/**
 * Description of MvcBoot
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Apr 27, 2016
 */
class Boot extends \lib\routing\Dispatcher
{
    /**
     * Start some static core classes
     */
    public static function run()
    {
        // initiate configs
        new \lib\loader\Configurator;
        //initiate pdo
        \lib\db\PdoMysql::getConn();
        /*
         * start session and
         * check if user is registered and what user group is
         */
        Session::run();
        /*
         * The routing url, we need to use original 'QUERY_STRING'
         * from server parameter because php has parsed the url if we use $_GET
         */
        $url = \lib\url\UrlRegister::getUrlRequest();
        Vars::setRoute($url);

        //parse the url
        $querystring = self::parseUrl($url);
        
        //regist vars GET and POST
        self::registParams(self::$params);
        self::registVars($querystring);
        
        $lang = Language::setLang(Configurator::getLangDefault(), Configurator::getSingleLang());
        Language::checkLang($lang);
        Language::registry($lang);

        //set the action for the page
        $controller = false;
        $route = self::checkRoute(self::$params);
        
        //open xml file for translations
        new \lib\lang\Labels();
       

        if($route != false){
            $controller = self::fireController(self::$params, $route);
            $controller = self::fireView($controller);
        }
        

        self::output($controller);

        Session::close();


    }
    

    

    private static function checkRoute($params)
    {
        $route = null;
        if(XmlRouting::check($params) == true){
            $route = XmlRouting::getApp();
        }elseif(DBRouting::check($params) == true){
            $route = DBRouting::getApp();
            self::$params[ParseRoute::PART_ACTION] = Vars::getAction();
            
        }

        if($route == null){
            Monitor::setErrorMessages(null, ['message'=>'No page found for url ' . Vars::getRoute()]);
            return false;
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
    
    


}
