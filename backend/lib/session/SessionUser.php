<?php

namespace lib\session;


use \model\querys\UserBaseQuery;
use \model\models\UserBase;
use \apps\User\model\UserGroupModel;
use \lib\session\Session;
use \lib\session\SessionUserTools;
use \lib\mysql\Mysql;
use \lib\register\Monitor;


/**
 * Description of SessionUser
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Feb 19, 2015
 */
class SessionUser extends \lib\session\SessionUserBase
{
    /**
     *
     */
    public static function registSessionUser()
    {
        $session = Session::getSessionVar(Session::SESS_USER);
        if($session != false){
            Monitor::setMonitor(Monitor::SESSION, 'Session is true');
            if($session['time'] > time()){
                $user = SessionUserTools::getUserSession($session[self::KEY_GROUPID])->filterById($session[self::KEY_ID])->findOne();
            }else{
                $user = false;
            }
            //have session registered
            if($user == false){
                $user = SessionUserTools::getUserSession()->findOne();
                $player = $user;

            }else{
                self::$registredUser = true;

            }

        }else{
            // don't have session registered
            Monitor::setMonitor(Monitor::SESSION, 'USER SESSION IS FALSE');
            $user = self::userQuery()
                    ->joinUserGroup()->selectName()->filterByName(UserGroupModel::GROUP_VISITOR)->endUse()->findOne();
            $player = $user;
        }
        $str = self::setUserVarsSession($user, Session::SESS_USER);
        Monitor::setMonitor(Monitor::SESSION, '[<b>USER</b>] ' . $str);
        if(!isset($player)){
            Monitor::setMonitor(Monitor::SESSION, 'No player ');
            $session = Session::getSessionVar(Session::SESS_PLAYER);
            if($session[self::KEY_ID] == self::getUserId() || $session == false){
                $player = $user;
            }else{
                $player = SessionUserTools::getUserSession($session[self::KEY_GROUPID])->filterById($session[self::KEY_ID])->findOne();
            }

        }
        self::registPlayer($player);
    }

    /**
     * @param $email
     * @return bool
     */
    public static function setSessionUserByEmail($email)
    {
        $user = UserBaseQuery::start(ONLY)->filterByUsername($email)->findOne();
        if($user != false){
            self::setUserVarsSession($user, Session::SESS_USER);
            self::registPlayer($user);
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return UserBaseQuery
     */
    private static function userQuery()
    {
        return UserBaseQuery::start(ONLY)->selectName()->selectUserGroupId();
    }


    /**
     * @param $user
     */
    public static function registPlayer($user)
    {
        $keys = [
            self::KEY_ID => UserBase::FIELD_ID,
            self::KEY_GROUPID => UserBase::FIELD_USER_GROUP_ID,
            self::KEY_NAME => UserBase::FIELD_NAME,
            self::KEY_GROUPNAME => \model\models\UserGroup::FIELD_NAME
        ];
        $values = [];
        foreach ($keys as $key => $column) {
            self::$sessionPlayer[$key] = $user->getColumnValue($column);
            $values[$key] = self::$sessionPlayer[$key];
        }
        $values['time'] = time() + self::$sessiontime;
        Session::setSession(Session::SESS_PLAYER, $values);
    }

    /**
     * @param $level
     * @return bool
     */
    public static function getAuth($level)
    {
        if(self::getPlayerLevel() != false && $level >= self::getPlayerLevel()){
            return true;
        }

        return false;
    }


    /**
     *
     */
    public static function unsetUser()
    {
        Session::unsetSession(Session::SESS_USER);
        Session::unsetSession(Session::SESS_PLAYER);
    }

    /**
     * @return bool|mixed
     */
    public static function getPlayer()
    {
        $id = self::getPlayerId();
        if($id == false){
            $id = self::getUserId();
        }
        return $id;
    }

    /**
     *
     * @param string $group
     *
     * @return bool
     */
    public static function isValidGroup($group)
    {
        $check = \model\querys\UserGroupQuery::start()
                ->filterByName($group)
                ->filterById(self::getPlayerLevel(), Mysql::GREATER_EQUAL)
                ->findOne();
        return ($check == FALSE)? false : true;
    }


    public static function warningUser($warning)
    {
        Session::setSession(Session::SESS_WARNING, $warning);

    }

    public static function getWarning()
    {
        return Session::getSessionVar(Session::SESS_WARNING);

    }

    public static function resetWarning()
    {
        return Session::unsetSession(Session::SESS_WARNING);

    }



}
