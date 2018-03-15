<?php

namespace lib\view\parsers;

use \lib\view\Template;

/**
 * Description of ParseLoop
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 30, 2016
 */
class ParseLoop {
    
    const PATTERN_WHILE = "/{@while [^}]+\}/";
    
    const PATTERN_ENDWHILE = "{@endwhile;}";

    /**
     * 
     * @param string $output The html to be processed
     * @return string The html processed
      */
    public static function parseWhile($output){
        $matches = [];
        if (preg_match(self::PATTERN_WHILE, $output)) {
            preg_match_all(self::PATTERN_WHILE, $output, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {

                list($vector, $tag) = explode(' in ', self::getCondition($match[0]));
                
                $piece = self::getPiece($output, $match[0]);
                $html = self::buildPieces($tag, $vector, $piece);
                
                $start = strpos($output, $match[0]);
                $strlength = strlen($match[0]) + strlen($piece) + strlen(self::PATTERN_ENDWHILE);
                
                $output = substr_replace($output, $html, $start, $strlength);

            }
        }
        
        return $output;
    }
    
    /**
     * Get the condition to be tested
     * @param string $match The template tag
     * @return string The condition
     */
    private static function getCondition($match){
        $match = strstr($match, '(');
        $match = substr($match, 1, strpos($match, ')') - 1);
        
        return $match;
    }
    
    /**
     * Strip the string to be looped from the html output
     * @param string $output The all HTML
     * @param string $match The template tag
     * @return string The piece to be processed
     */
    private static function getPiece($output, $match){
        $piece = substr($output, strpos($output, $match));
        $piece = substr($piece, 0, strpos($piece, self::PATTERN_ENDWHILE));
        return str_replace($match, '', $piece);
    }
    
    /**
     * Loop the array data $tag[] and process the string
     * @param string $tag The name for the array data
     * @param string $vector The name for each array element
     * @param string $piece The HTML to be processed
     * @return string The all html string looped and process
     */
    private static function buildPieces($tag, $vector, $piece){
        $var = Template::getData($tag);
        $html = '';
        if ($var != null && is_array($var)) {
            foreach ($var as $row) {
                $string = $piece;
 
                foreach ($row as $k => $value) {
                    $string = str_replace('{' . $vector . '.' . $k . '}', $value, $string);
                }
                $html .= $string;
            }
        }
        return $html;
    }

}
