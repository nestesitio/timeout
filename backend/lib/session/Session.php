<?php

namespace lib\session;


use \lib\register\Monitor;
use \lib\session\SessionUser;
use \lib\register\Vars;

/**
 * Description of Session
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 14, 2014
 */
class Session
{
    /**
     * @var
     */
    private static $id;

    /**
     * @var array
     */
    private static $session = [];

    /**
     * @var array
     */
    private static $sessionFilters = [];

    /**
     * @var array
     */
    private static $sessionShop = [];

    /**
     * @var array
     */
    private static $sessionConf = [];
    
    /**
     * 
     */
    const SESS_LANG = 'lang';
    /**
     *
     */
    const SESS_USER = 'user';
    /**
     *
     */
    const SESS_PLAYER = 'player';
    /**
     *
     */
    const SESS_FILTER = 'filters';
    /**
     *
     */
    const SESS_SHOP = 'shop';
    /**
     *
     */
    const SESS_PAGE = 'page';
    /**
     *
     */
    const SESS_WARNING = 'warning';
    /**
     *
     */
    const SESS_INFO = 'info';
    /**
     *
     */
    const SESS_PAGERETURN = 'return';
    /**
     *
     */
    const SESS_CONFIG = 'config';


    /**
     * Session constructor.
     */
    public function __construct()
    {
        if (session_id() === '') {
            session_start();
            self::$id = session_id();
            #session_unset ();
        }
        return $this;
    }
    
    /**
     * 
     * @return \lib\session\Session
     */
    public static function start(){
        $obj = new Session;
        return $obj;
    }
    
    /**
     * 
     * @return \lib\session\Session
     */
    public static function run(){
        $obj = new Session;
        $obj->registry();
        return $obj;
    }

    public function registry() {
        $this->registSessionVars();
        $this->registIp();
        \lib\guard\Guard::generateSessToken();
    }

    /* regist specific session vars */
    /**
     *
     */
    private function registSessionVars()
    {
        SessionUser::registSessionUser();
        $this->registSessionFilters();
        $this->registSessionShop();
        $this->registSessionConfig();
    }

    /**
     * @param $key
     * @return bool
     */
    public static function getSessionVar($key)
    {
        if (isset($_SESSION[$key])) {
            if(!isset(self::$session[$key])){
                self::setSession($key, $_SESSION[$key]);
            }
            return $_SESSION[$key];
        }
        return false;
    }

    /* regist and refresh session vars */
    /**
     * @param $key
     * @param $value
     */
    public static function setSession($key, $value)
    {
        if(is_array($value)){
            foreach($value as $k => $val){
                self::$session[$key][$k] = $val;
                $_SESSION[$key][$k] = $val;
            }
        }else{
            self::$session[$key] = $value;
            $_SESSION[$key] = $value;
        }
    }


    /**
     * @param $key
     */
    public static function unsetSession($key)
    {
        if (isset(self::$session[$key])) {
            unset(self::$session[$key]);
        }
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
    }



    /* $_SESSION['FILTERS']*/
    /**
     *
     */
    private function registSessionFilters()
    {
        $filters = self::getSessionVar(self::SESS_FILTER);
        if ($filters != false) {
            foreach ($filters as $app => $session) {
                foreach ($session as $type => $values) {
                    self::$sessionFilters[$app][$type] = $values;
                }
            }
            self::setSession(self::SESS_FILTER, $filters);
        }
    }

    /**
     * @param $app
     * @param $type
     */
    public static function removeSessionFilter($app, $type)
    {
        if(isset($_SESSION[self::SESS_FILTER][$app][$type])){
            unset($_SESSION[self::SESS_FILTER][$app][$type]);
        }

    }

    /**
     * @param $app
     * @param $type
     * @param $field
     */
    public static function unsetFilter($app, $type, $field = null)
    {
        if($field == null){
            if (isset(self::$sessionFilters[$app][$type])) {
                unset(self::$sessionFilters[$app][$type]);
                unset($_SESSION[self::SESS_FILTER][$app][$type]);
            }
        } else {
            if (isset(self::$sessionFilters[$app][$type][$field])) {
                unset(self::$sessionFilters[$app][$type][$field]);
                unset($_SESSION[self::SESS_FILTER][$app][$type][$field]);
            }
        }
    }

    /**
     * @param $app
     * @param $type
     * @param $value
     * @param $field
     */
    public static function setSessionFilter($app, $type, $value, $field = null)
    {
        if($field == null){
            $_SESSION[self::SESS_FILTER][$app][$type] = $value;
            self::$sessionFilters[$app][$type] = $value;
            Monitor::setMonitor(Monitor::SESSION, self::SESS_FILTER . ': ' . $app . ' - ' . $type . ': ' . $value);
        }else{
            $_SESSION[self::SESS_FILTER][$app][$type][$field] = $value;
            self::$sessionFilters[$app][$type][$field] = $value;
            Monitor::setMonitor(Monitor::SESSION, self::SESS_FILTER . ': ' . $app . ' - ' . $type . ': ' . $field . ' = ' . $value);
        }
    }

    /**
     * @param $app
     * @param $type
     * @return bool
     */
    public static function getSessionFilter($app, $type)
    {
        if(isset(self::$sessionFilters[$app][$type])){
            return self::$sessionFilters[$app][$type];
        }
        return false;
    }


    /* $_SESSION['page']
     * allows user to return to the same page after
     * some interaction like logout / login
     */
    /**
     * @param $page
     */
    public static function setSessionPage($page)
    {
        self::setSession(self::SESS_PAGE, $page);
    }

    /**
     * @return bool
     */
    public static function getSessionPage()
    {
        return self::getSessionVar(self::SESS_PAGE);
    }

    /**
     * @param string $page The url to return later, after login
     */
    public static function setPageReturn($page)
    {
        self::setSession(self::SESS_PAGERETURN, $page);
    }

    /**
     * @return string The url to return
     */
    public static function getPageReturn()
    {
        return self::getSessionVar(self::SESS_PAGERETURN);
    }


    /* $_SESSION['SHOP']
     * E-Commerce tool
     */
    /**
     *
     */
    private function registSessionShop()
    {
        $session = self::getSessionVar(self::SESS_SHOP);
        if ($session != false) {
            foreach ($session as $key => $value) {
                self::$sessionShop[$key] = $value;
            }
            self::setSession(self::SESS_SHOP, $session);
        }
    }

    /* $_SESSION['CONFIG']
     * Configs
     */
    /**
     *
     */
    private function registSessionConfig()
    {
        $session = self::getSessionVar(self::SESS_CONFIG);
        if ($session != false) {
            foreach ($session as $key => $value) {
                self::$sessionConf[$key] = $value;
            }
            self::setSession(self::SESS_CONFIG, $session);
        }
    }

    /**
     *
     */
    private function registIp()
    {
        $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        $ip = filter_var($ip, FILTER_VALIDATE_IP);
        Vars::setIp($ip);

    }


    /**
     *
     */
    public static function close()
    {
        session_write_close();
    }

    /**
     *
     */
    private function __clone() {}



}
