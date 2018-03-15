<?php

namespace lib\session;

use \lib\session\Session;
use \model\models\UserBase;

/**
 * Description of SessionUserBase
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 18, 2015
 */
class SessionUserBase
{
    /**
     *
     */
    const KEY_ID = 'id';
    /**
     *
     */
    const KEY_GROUPID = 'groupid';
    /**
     *
     */
    const KEY_GROUPNAME = 'group';
    /**
     *
     */
    const KEY_NAME = 'name';

    /**
     * @var array
     */
    protected static $sessionUser = [];
    /**
     * @var array
     */
    protected static $sessionPlayer = [];
    /**
     * @var bool
     */
    protected static $registredUser = false;

    /**
     * @var bool
     */
    protected static $authUser = false;
    /**
     * @var int
     */
    protected static $sessiontime = 7200;


    /**
     * @param $user
     * @param $sesskey
     * @return string
     */
    public static function setUserVarsSession($user, $sesskey)
    {
        $str = '';
        $keys = [
            self::KEY_ID => UserBase::FIELD_ID,
            self::KEY_GROUPID => UserBase::FIELD_USER_GROUP_ID,
            self::KEY_NAME => UserBase::FIELD_NAME,
            self::KEY_GROUPNAME => \model\models\UserGroup::FIELD_NAME
        ];
        foreach ($keys as $key => $column) {
            $values[$key] = $user->getColumnValue($column);
            if ($sesskey == Session::SESS_USER) {
                self::$sessionUser[$key] = $user->getColumnValue($column);
            } elseif ($sesskey == Session::SESS_PLAYER) {
                self::$sessionPlayer[$key] = $user->getColumnValue($column);
            }
            $str .= '[' . $key . ']=>' . $user->getColumnValue($column) . ', ';
        }
        $values['time'] = time() + self::$sessiontime;
        Session::setSession($sesskey, $values);
        return $str;
    }

    /**
     * @return bool|mixed
     */
    public static function getUserId()
    {
        return (isset(self::$sessionUser[self::KEY_ID]))? self::$sessionUser[self::KEY_ID] : false;
    }

    /**
     * @return bool|mixed
     */
    public static function getPlayerId()
    {
        return (isset(self::$sessionPlayer[self::KEY_ID]))? self::$sessionPlayer[self::KEY_ID] : false;
    }


    /**
     * @return mixed
     */
    public static function getUserName()
    {
        return self::$sessionUser[self::KEY_NAME];
    }

    /**
     * @return mixed
     */
    public static function getPlayerName()
    {
        return self::$sessionPlayer[self::KEY_NAME];
    }


    /**
     * @return bool|mixed
     */
    public static function getUserGroup()
    {
        return (isset(self::$sessionUser[self::KEY_GROUPNAME]))? self::$sessionUser[self::KEY_GROUPNAME] : false;
    }

    /**
     * @return bool|mixed
     */
    public static function getPlayerGroup()
    {
        return (isset(self::$sessionPlayer[self::KEY_GROUPNAME]))? self::$sessionPlayer[self::KEY_GROUPNAME] : false;
    }


    /**
     * @return bool|mixed
     */
    public static function getUserLevel()
    {
        return (isset(self::$sessionUser[self::KEY_GROUPID]))? self::$sessionUser[self::KEY_GROUPID] : false;
    }

    /**
     * @return bool|mixed
     */
    public static function getPlayerLevel()
    {
        return (isset(self::$sessionPlayer[self::KEY_GROUPID]))? self::$sessionPlayer[self::KEY_GROUPID] : false;
    }


    /**
     *
     */
    public static function setAuthUser()
    {
        self::$authUser = true;
    }

    /**
     * @return bool
     */
    public static function getAuthUser()
    {
        return self::$authUser;
    }


    /**
     * @return bool
     */
    public static function haveUser()
    {
        return self::$registredUser;
    }

    /**
     * @return bool
     */
    public static function getIsRegisterd()
    {
        return self::$registredUser;
    }

}
