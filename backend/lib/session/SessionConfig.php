<?php

namespace lib\session;

use \lib\session\Session;

/**
 * Description of SessionConfig
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 24, 2015
 */
class SessionConfig
{
    /**
     *
     */
    const KEY_XML = 'xml';
    /**
     *
     */
    const KEY_ID = 'id';


    /**
     * @param $xml
     */
    public static function setXml($xml)
    {
        Session::setSession(Session::SESS_CONFIG, [self::KEY_XML => $xml]);
    }


    /**
     * @return bool
     */
    public static function getXml()
    {
        $session = Session::getSessionVar(Session::SESS_CONFIG);
        if(isset($session[self::KEY_XML])){
            return $session[self::KEY_XML];
        }
        return false;
    }

    /**
     * @param int $id
     */
    public static function addId($id)
    {
        $xml = self::getXml();
        Session::setSession(Session::SESS_CONFIG, [self::KEY_XML => $xml, self::KEY_ID => $id]);
    }

    /**
     * @return bool
     */
    public static function getId()
    {
        $session = Session::getSessionVar(Session::SESS_CONFIG);
        if(isset($session[self::KEY_ID])){
            return $session[self::KEY_ID];
        }
        return false;
    }

}
