<?php

namespace lib\guard;

use \model\querys\UserBaseQuery;
use \model\models\UserBase;
use \model\forms\UserBaseForm;
use \lib\register\Vars;
use \lib\session\SessionUser;
use \lib\session\Session;

/**
 * Description of Guard
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 27, 2015
 */
class Guard
{
    /**
     * Guard constructor.
     */
    private function __construct() {}

    /**
     * @var
     */
    private static $hash;

    /**
     * @param $string
     * @param $salt
     */
    public static function hashIt($string, $salt)
    {
        self::$hash = sha1($salt.$string);
    }

    /**
     * @param $key
     * @return bool
     */
    public static function validate($key)
    {
        if($key == self::$hash){
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public static function validateLogin()
    {
        $user = UserBaseQuery::start()
                //->filterByStatus([UserBase::STATUS_BLOCKED, UserBase::STATUS_VIRTUAL], Mysql::NOT_IN)
                ->filterByUsername(Vars::getPosts('email'))->findOne();
        
        if($user != false && $user->getStatus() == UserBase::STATUS_BLOCKED){
            \lib\session\SessionUserTools::logAttempt($user->getId());
            
        }elseif($user != false){
            self::hashIt(Vars::getPosts('password'), $user->getSalt());
            if(self::validate($user->getUserkey()) == true){
                SessionUser::setUserVarsSession($user, Session::SESS_USER);
                SessionUser::registPlayer($user);
                return true;
            }
        }
        return false;
    }

    /**
     * @param UserBase $user
     */
    public static function setKeys(UserBase $user)
    {
        $user->setSalt(sha1($user->getPassword()));
        $user->setUserkey(sha1($user->getSalt().$user->getPassword()));
        $user->save();
    }

    /**
     * @param UserBaseForm $form
     *
     * @return UserBaseForm
     */
    public static function prepareForm(UserBaseForm $form)
    {
        $form->unsetSaltInput();
        $form->unsetUserkeyInput();
        return $form;
    }

    /**
     *
     */
    const SESS_TOKEN = 'q48pkl';

    /**
     *
     */
    public static function generateSessToken()
    {
        if(Session::getSessionVar(self::SESS_TOKEN) != null){
            // to be compared with post
            Vars::setVars(self::SESS_TOKEN, Session::getSessionVar(self::SESS_TOKEN));
        }
        $token = md5(Vars::getIp() . (string) time());
        // used in form
        Session::setSession(self::SESS_TOKEN, $token);

    }



}
