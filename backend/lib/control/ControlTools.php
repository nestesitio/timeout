<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lib\control;

/**
 * Description of ControlTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 28, 2015
 */
class ControlTools
{
    /**
     * ControlTools constructor.
     */
    private function __construct() {}

    /**
     * @param $obj
     * @param String $xmlfile
     * @return mixed
     */
    public static function getFielsAndLabelsFromXml($obj, $xmlfile)
    {
        $config = new \lib\bkegenerator\DataEdit($obj, $xmlfile);
        return $config->getFielsAndLabels();
    }

    /**
     * @param $obj
     * @param $file
     * @param $type
     * @param $ext
     * @return null|string
     */
    public static function validateFile($obj, $file, $type, $ext)
    {
        if(!is_file(ROOT . DS . $file)){
            $file .= '.' . $ext;
        }
        if(!is_file(ROOT . DS . $file) && $obj != null){
            $class = substr(strrchr(get_class($obj) , '\\'),1);
            $folder = str_replace(['\\', $class, 'control', (DS . DS)], [DS, '', '', DS], get_class($obj));
            $file = $folder . $type . DS . $file;
        }
        if(!is_file(ROOT . DS . $file)){
            return null;
        }
        return $file;
    }

    /**
     * Test if file exist in the site directory
     * @param $file
     * @param String $ext
     *
     * @return string
     */
    public static function isFile($file, $ext = null)
    {
        if(!is_file(ROOT . DS . $file)){
            if(null != $ext){
                $file .= '.' . $ext;
            }else{
                die('no file to ' . $file);
            }

        }
        return ROOT . DS . $file;
    }

}
