<?php
namespace lib\register;


use \lib\register\Monitor;

/**
 * Description of Vars
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 5, 2014
 */
class Vars extends \lib\register\VarsRegisted
{
    /**
     * @var array
     */
    private static $vars = [];
    /**
     * @var array
     */
    private static $requests = [];
    /**
     * @var array
     */
    private static $posts = [];



    /**
     * Vars constructor.
     */
    private function __construct() {}

    /**
     * @param $key
     * @param $value
     */
    public static function setVars($key, $value)
    {
        self::$vars [$key] = $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public static function getVars($key)
    {
        return (isset(self::$vars [$key])) ? self::$vars [$key] : false;
    }

    /**
     * @param $key
     * @param $value
     */
    public static function setRequests($key, $value)
    {
        self::$requests [$key] = $value;
    }

    /**
     *
     */
    public static function registPosts()
    {
        $inputs = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        Monitor::setMonitor(Monitor::FORM, 'POST inputs: ' . count($inputs));
        if (!empty($inputs)) {
            foreach ($inputs as $key => $value) {
                self::$posts [$key] = $value;
                Monitor::setMonitor(Monitor::FORM, 'POST value: ' . $key . '=' . $value);
            }
        }
        if(isset($inputs['token'])){
            self::parseToken($inputs['token']);
        }
    }

    /**
     *
     */
    public static function registRequests()
    {
        $inputs = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        Monitor::setMonitor(Monitor::FORM, 'GET inputs: ' . count($inputs));
        if (!empty($inputs)) {
            foreach ($inputs as $key => $value) {
                self::$requests [$key] = $value;
                Monitor::setMonitor(Monitor::FORM, 'GET value: ' . $key . '=' . self::$requests [$key]);
            }
        }
        if(isset($inputs['token'])){
            self::parseToken($inputs['token']);
        }
        if(isset($inputs['voken'])){
            self::parseTokenToPost($inputs['voken']);
        }

    }

    /**
     * @param $token
     */
    public static function parseToken($token)
    {
        $vars = \lib\url\UrlRegister::decUrl($token);
        foreach($vars as $key=>$value){
            self::$vars [$key] = $value;
        }
    }

    /**
     * @param $token
     */
    public static function parseTokenToPost($token)
    {
        $vars = \lib\url\UrlRegister::decUrl($token);
        foreach($vars as $key=>$value){
            self::$posts [$key] = $value;
            Monitor::setMonitor(Monitor::FORM, 'POST value: ' . $key . '=' . $value);
        }
    }

    /**
     * @param $key
     * @return array|bool|mixed
     */
    public static function getRequests($key = null)
    {
        if($key == null){
            return self::$requests;
        }
        return (isset(self::$requests [$key])) ? self::$requests [$key] : false;
    }


    /**
     * @param $key
     * @return array|bool|mixed
     */
    public static function getPosts($key = null)
    {
        if($key == null){
            return self::$posts;
        }
        return (isset(self::$posts [$key])) ? self::$posts [$key] : false;
    }




}
