<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lib\register;

/**
 * Description of VarsRegisted
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 10, 2016
 */
class VarsRegisted
{
    /**
     * @var string
     */
    protected static $redirect = null;
    /**
     * @var string
     */
    protected static $app = '';
    /**
     * @var string
     */
    protected static $action = '';
    /**
     * @var string
     */
    protected static $view = '';
    /**
     * @var string
     */
    protected static $canonical = '';
    /**
     * @var string
     */
    protected static $lang = 'en';
    /**
     * @var bool
     */
    protected static $id = false;

    /**
     * @var string
     */
    protected static $route = '/';
    /**
     * Regist url
     * @param string $a
     */
    public static function setRoute($a)
    {
        self::$route = $a;
    }
    /**
     * Get url registered
     * @return string
     */
    public static function getRoute()
    {
        return self::$route;
    }

    /**
     * Regist url to redirect
     * @param string $a
     */
    public static function setRedirect($a)
    {
        self::$redirect= $a;
    }

    /**
     * Get url registered
     * @return string
     */
    public static function getRedirect()
    {
        return self::$redirect;
    }

    /**
     * @param string $app
     */
    public static function setApp($app)
    {
        self::$app = $app;
    }

    /**
     * @return string
     */
    public static function getApp()
    {
        return self::$app;
    }

    /**
     * @param string $a
     */
    public static function setAction($a)
    {
        self::$action = $a;
    }

    /**
     * @return string
     */
    public static function getAction()
    {
        return self::$action;
    }

    /**
     * @param string $a
     */
    public static function setView($a)
    {
        self::$view = $a;
    }

    /**
     * @return string
     */
    public static function getView()
    {
        return self::$view;
    }

    /**
     * @return string
     */
    public static function getCanonical()
    {
        return self::$canonical;
    }

    /**
     * @param $a
     */
    public static function setCanonical($a)
    {
        self::$canonical = $a;
    }

    /**
     * @param int $id
     */
    public static function setId($id)
    {
        self::$id = $id;
    }

    /**
     * @return id
     */
    public static function getId()
    {
        return self::$id;
    }

    /**
     * @var bool
     */
    protected static $slugvar = false;
    /**
     * @param string $var
     */
    public static function setSlugVar($var)
    {
        self::$slugvar = $var;
    }
    /**
     * @return string
     */
    public static function getSlugVar()
    {
        return self::$slugvar;
    }

    /**
     * @var
     */
    protected static $title;
    /**
     * @param String $value
     */
    public static function setTitle($value)
    {
        self::$title = $value;
    }
    /**
     * @return string
     */
    public static function getTitle()
    {
        return self::$title;
    }

    /**
     * @var
     */
    protected static $heading;
    /**
     * @param $value
     */
    public static function setHeadin($value)
    {
        self::$heading = $value;
    }
    /**
     * @return mixed
     */
    public static function getHeading()
    {
        return self::$heading;
    }

    /**
     * @var
     */
    protected static $ip;
    /**
     * @param $ip
     */
    public static function setIp($ip)
    {
        self::$ip = $ip;
    }
    /**
     * @return mixed
     */
    public static function getIp()
    {
        return self::$ip;
    }


    /**
     * @var
     */
    protected static $page;
   /**
     * @param int $id
     */
    public static function setPage($id)
    {
        self::$page = $id;
    }
    /**
     * @return int
     */
    public static function getPage()
    {
        return self::$page;
    }
    
   /**
     * @param string $lang
     */
    public static function setLang($lang)
    {
        self::$lang = $lang;
    }
    /**
     * @return string
     */
    public static function getLang()
    {
        return self::$lang;
    }
    
    /**
     * 
     * @return string
     */
    public static function getDomain(){
        return getenv('SERVER_NAME');
    }

}
