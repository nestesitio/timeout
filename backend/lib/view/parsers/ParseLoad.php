<?php

namespace lib\view\parsers;

use \lib\view\Tags;

/**
 * Description of ParseLoad
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 5, 2016
 */
class ParseLoad {

    /**
     * 
     * @param string $output
     * @return string
     */
    public static function parse($output){
        $matches = [];
        if (strpos($output, Tags::TAG_LOAD) !== false) {
            preg_match_all(Tags::PATTERN_LOAD, $output, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $output = str_replace($match[0], self::runClass($match[1]), $output);
            }
        }
        return $output;
    }
    
    private static function runClass($argument){

        //'\lib\menu\Authool::render()
        list($class, $method) = explode('::', $argument);
        if (class_exists($class)) {
            $args = strstr($method, '(');
            $method = str_replace($args , '',$method);
            $args = str_replace(['(', ')'], '', $args);
            $hasActionFunction = (int) method_exists($class, $method);
            if ($hasActionFunction == 0) {
                return false;
            }
            return $class::$method($args);
        }

        return false;
        
        
    }

}
