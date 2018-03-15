<?php

namespace lib\view;

use \lib\register\Monitor;

/**
 * Description of TemplateTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 19, 2016
 */
class TemplateTools {

    /**
     * Get a needle string stripped from haystack string
     * based on start and end of needle string
     * 
     * @param string $string Haystack
     * @param string $start the start of the needle
     * @param string $end the end of the needle
     * @param boolean $trim should trim the needle
     * 
     * @return string Needle
     */
    public static function getTagArgument($string, $start, $end = Tags::TAG_END, $trim = true){
        //strip common tags
        $string = substr($string, strpos($string, $start) + strlen($start));
        if(strpos($string, $end)){
            $string = substr($string, 0, strpos($string, $end));
        }
        
        return ($trim == true)? trim($string) : $string;
    }
    
    /**
     * 
     * @param string $string Haystack
     * @param string $start the start of the needle
     * @param string $end the end of the needle
     * @param boolean $trim should trim the needle
     * 
     * @return string Needle
     */
    public static function getFileInInclude($string, $start, $trim = true){
        //strip common tags
        $string = substr($string, strpos($string, $start) + strlen($start));
        $string = substr($string, 0, strpos($string, "'"));
        
        
        return ($trim == true)? trim($string) : $string;
    }
    
    /**
     * Look for the template file over the framework folders
     * 
     * @param string $file
     * @return string The path form the file
     */
    public static function lookForTemplate($file){
        $folders = ['', 'apps' . DS, 'layout' . DS];
        $exts = ['', '.htm', '.html'];
        foreach ($folders as $folder) {
            foreach ($exts as $ext) {
                if (is_file(ROOT . DS . $folder . $file . $ext)) {
                    return $folder . $file . $ext;
                }
            }
        }
        Monitor::setErrorMessages(null, 'Wrong path or unknow file for ' . ROOT . DS . 'layout|apps' . DS . $file);
        return null;
    }

}
