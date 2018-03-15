<?php

namespace lib\url;

/**
 * Description of UrlRegister
 * This class process the url query string
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 25, 2014
 */
class UrlRegister
{
    /**
     *
     */
    const KEY = 'dlq0p3c';

    /**
     * @var array
     */
    private static $gets = [];


    /**
     * UrlRegister constructor.
     */
    private function __construct() {}


    /**
     * @return string
     */
    private static function getQuerySring()
    {
        $query = [];
        $query = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        if (!empty($query)) {
            foreach ($query as $key => $value) {
                $qv[$key] = $value;
            }
            $querystring = http_build_query($qv);
            return str_replace(['%2F'], ['/'], $querystring);
        } else {
            return '';
        }
    }

    /**
     * We sanitize the url
     * @return string The url sanitized
     */
    public static function getUrlRequest()
    {
        $get = filter_input(INPUT_GET, '_url', FILTER_SANITIZE_SPECIAL_CHARS);
        $_url = isset($get) ? preg_replace('/^_url=(.*)/','$1',self::getQuerySring()) : '';
        //echo $_url . '+' . $_SERVER['HTTP_REFERER'];
        return $_url;
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function encUrl($string)
    {
        $key = UrlRegister::KEY;
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        return urlencode($encrypted);
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function decUrl($string)
    {
        $key = UrlRegister::KEY;
        $encrypted = $string;
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");

        return json_decode(trim($decrypted));
    }

    /**
     * @param $key
     * @return bool|mixed
     */
    public static function getGets($key)
    {
        return (isset(self::$gets [$key])) ? self::$gets [$key] : false;
    }



}
