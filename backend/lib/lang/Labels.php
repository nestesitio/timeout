<?php

namespace lib\lang;

use \lib\xml\XmlFile;
use \lib\lang\Language;

/**
 * Description of Labels
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 5, 2016
 */
class Labels {

    private static $xml;
    
    
                
    function __construct() {
        self::loadFile();
    }
    
    /**
     *
     */
    private static function loadFile()
    {
        self::$xml = XmlFile::getXmlFromFile('config/labels.xml');

    }
    
    /**
     * 
     * @param string $key
     * @return string
     */
    public static function getLabel($key){

        foreach (self::$xml->getElementsByTagName('word') as $node) {
            
            $attr = XmlFile::getAtribute($node, 'key');
            if($attr != false && $attr == $key){
                
                foreach (Language::getTldArray() as $lang) {
                    foreach ($node->childNodes as $item) {
                        if(XmlFile::getAtribute($item, 'lang') == $lang){
                            return $item->nodeValue;
                        }
                    }
                }

            }
        }
        return ucwords($key);
    }
    
    private static $labels = [];
    
    public static function collectLabels(){
        self::loadFile();
        
        foreach (self::$xml->getElementsByTagName('word') as $node) {
            
            $key = XmlFile::getAtribute($node, 'key');
            
            if($key != false){
                self::$labels[$key] = self::chooseLabel($node);

            }
        }
    }
    
    private static function chooseLabel($node){
        $value = null;
        foreach ($node->childNodes as $item) {
             if(XmlFile::getAtribute($item, 'lang') == Language::getLang()){
                 return $item->nodeValue;
             }
             if(XmlFile::getAtribute($item, 'lang') == Language::getLangDefault() && $value == null){
                 $value = $item->nodeValue;
             }
        }
        return $value;
    }
    
    public static function getLabelBy($key){
        if(isset(self::$labels[$key])){
            return self::$labels[$key];
        }
        return '-';
    }

}
