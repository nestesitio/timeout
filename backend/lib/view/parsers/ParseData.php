<?php

namespace lib\view\parsers;

use \lib\view\Tags;
use \lib\view\Template;

/**
 * Description of ParseData
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 31, 2016
 */
class ParseData {

    public static function parse($output, $data = null){
        
         $matches = [];
        if (preg_match(Tags::PATTERN_DATA, $output)) {
            preg_match_all(Tags::PATTERN_DATA, $output, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                //array(3) { [0]=> string(12) "{$sitetitle}" [1]=> string(9) "sitetitle" [2]=> string(0) "" }
                if($data == null){
                    $value = Template::getData($match[1]);
                }else{
                    $value = self::getData($match[1], $data);
                }
                
                $output = str_replace($match[0], $value, $output);
            }
        }
        
        return $output;
    }
    
    private static function getData($tag, $data){
        $tag = str_replace('$', '', $tag);
        return (isset($data[$tag]))? $data[$tag] : null;
    }

}
