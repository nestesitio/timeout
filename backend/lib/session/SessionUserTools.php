<?php

namespace lib\session;

use \lib\session\SessionUser;
use \model\querys\UserBaseQuery;
use \model\models\UserLog;
use \apps\User\model\UserGroupModel;
use \lib\mysql\Mysql;

/**
 * Description of SessionUserTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 17, 2015
 */
class SessionUserTools
{
    /**
     * @param $event
     */
    public static function logUser($event)
    {
        $log = new UserLog();
        $log->setEvent($event);
        $log->setUserId(SessionUser::getUserId());
        $log->save();
    }
    
    /**
     * @param int $id
     */
    public static function logAttempt($id)
    {
        $log = new UserLog();
        $log->setEvent(UserLog::EVENT_ATTEMPT);
        $log->setUserId($id);
        $log->save();
    }

    /**
     * @param $app
     * @return bool
     */
    public static function haveAccess($app)
    {
        if(SessionUser::haveUser() == true){
            $user = UserBaseQuery::start(ONLY)
                    ->joinUserGroup()
                    ->joinUserGroupHasHtmApp()
                    ->joinHtmApp()->filterBySlug($app)->endUse()->endUse()->endUse()
                    ->filterById(SessionUser::getPlayer())->findOne();
            if($user != false){
                return true;
            }
        }
        return false;
    }

    /**
     * @param $groupid
     * @return UserBaseQuery|\model\querys\UserGroupQuery
     */
    public static function getUserSession($groupid = null)
    {
        $query = UserBaseQuery::start(ONLY)->selectName()->selectUserGroupId();
        $query = $query->joinUserGroup()->selectName();

        if($groupid != null){
            $query = $query->filterById($groupid);
            $query = $query->filterByName(UserGroupModel::GROUP_VISITOR, Mysql::ALT_NOT_EQUAL);
        }else{
            $query = $query->filterByName(UserGroupModel::GROUP_VISITOR);
        }
        $query = $query->endUse();

        return $query;
    }



}
