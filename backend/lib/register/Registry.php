<?php
/**
 * Description of Registry
 * created in 7/Nov/2014
 * @author $luispinto@nestesitio.net
 */
namespace lib\register;

use \lib\register\Monitor;
use \lib\session\SessionUser;
use \apps\User\model\UserGroupModel;
use \lib\loader\Configurator;

class Registry
{
    /**
     * @var array
     */
    private static $error_messages = [];
    /**
     * @var array
     */
    private static $user_messages = [];
    /**
     * @var array
     */
    private static $custom_messages = [];
    /**
     * @var array
     */
    private static $dev_messages = [];
    /**
     * @var array
     */
    private static $memory_ini = [];



    /**
     *
     */
    private function __clone() {}

    /**
     *
     */
    public static function setMemoryInitial()
  {
      self::$memory_ini['mem'] = \lib\tools\MemoryTools::getMemory();
      self::$memory_ini['time'] = microtime(true);
  }

    /**
     * @return array
     */
    public static function getMemoryInitial()
  {
      return self::$memory_ini;
  }


    /**
     * @param $key
     * @param $value
     */
    public static function setErrorMessages($key, $value)
  {
        if (SessionUser::getUserGroup() == UserGroupModel::GROUP_DEVELOPER ||
                Configurator::getDeveloperMode() == true) {
            if (null == $key) {
                $key = count(self::$error_messages);
            }
            self::$error_messages [$key] = (is_array($value))? $value : ['message'=>$value];
        }
    }

    /**
     * @param $key
     * @return array|bool|mixed
     */
    public static function getErrorMessages($key = null)
  {
        if (SessionUser::getUserGroup() == UserGroupModel::GROUP_DEVELOPER ||
                Configurator::getDeveloperMode() == true) {
            if (null == $key) {
                return self::$error_messages;
            } else {
                return (isset(self::$error_messages [$key])) ? self::$error_messages [$key] : false;
            }
        }
    }

    /**
     * @param $value
     */
    public static function setMessages($value)
    {
        self::$user_messages = [];
        self::$user_messages [0]['msg'] = $value;
    }

    /**
     * @param $key
     * @param $value
     */
    public static function setUserMessages($key, $value)
    {
        if (null == $key) {
            $key = count(self::$user_messages);
        }
        self::$user_messages [$key]['msg'] = $value;
    }

    /**
     * @param $key
     * @return array|bool|mixed
     */
    public static function getUserMessages($key = null)
    {
    if (null == $key){
      return self::$user_messages;
    }else{
      return (isset(self::$user_messages [$key])) ? self::$user_messages [$key] : false;
    }
  }

    /**
     * @param $key
     * @param $value
     */
    public static function setCustomMessages($key, $value)
  {
        if (null == $key) {
            $key = count(self::$custom_messages);
        }
        self::$custom_messages [$key]['msg'] = $value;
    }


    /**
     * @param $key
     * @return array|bool|mixed
     */
    public static function getCustomMessages($key = null)
  {
    if (null == $key){
      return self::$custom_messages;
    }else{
      return (isset(self::$custom_messages [$key])) ? self::$custom_messages [$key] : false;
    }
  }

    /**
     * @param $type
     * @param $value
     * @param $key
     */
    public static function setMonitor($type, $value, $key = null)
  {
    if (null == $key){
      $key = count(self::$dev_messages);
    }
    self::$dev_messages [$key] = Monitor::create($type, $value);
  }

    /**
     * @param $type
     * @return array|bool|mixed
     */
    public static function getMonitor($type = null)
  {
    if (null == $type){
      return self::$dev_messages;
    }else{
      return (isset(self::$dev_messages [$key])) ? self::$dev_messages [$key] : false;
    }
  }

    /**
     * @param $tag
     * @param $data
     */
    public static function setDataDevMessage($tag, $data)
  {
      if(is_array($data)){
          Registry::setMonitor(Monitor::DATA, $tag . ' = Array (' . count($data) . ')');
      }else{
          Registry::setMonitor(Monitor::DATA, $tag . ' = '. gettype($data) .'(' . count($data) . ')');
      }

  }

      /**
     * @var
     */
    private static $key;
    /**
     *
     */
    public function setToken()
  {
      self::$key = md5(uniqid(mt_rand(time()), true));
  }

}
