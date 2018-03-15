<?php

namespace lib\view\parsers;

use \lib\view\Tags;
use \lib\view\TemplateTools;
use \lib\view\Parse;
use \lib\view\parsers\ParseCondition;

/**
 * Description of ParseInclude
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 18, 2016
 */
class ParseInclude {

    /**
     * Parse the HTML string looking for tag {include 'include'}
     * and replace it for file content.
     * This function is recursive.
     * 
     * @param string $output The HTML to be parsed
     * @return string The HTML to output
     */
    public static function parse($output){
        $matches = [];
        if (strpos($output, Tags::TAG_INCLUDE) !== false) {
            preg_match_all(Tags::PATTERN_INCLUDE, $output, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                
                $file = TemplateTools::getFileInInclude($match[0], Tags::TAG_INCLUDE);
                $file = TemplateTools::lookForTemplate($file);

                if (null != $file) {
                    $content = Parse::obFile($file);
                    $content = self::replaces($content, $match[0]);
                    $content = ParseCondition::parse($content);

                    $content = self::parse($content);
                    $content = ParseInclude::parse($content);
                    $output = str_replace($match[0], $content, $output);

                }
                
            }
        }
        return $output;
    }
    
    private static function replaces($output, $tag) {
        if (strpos($tag, '[')) {
            $tag = substr($tag, strpos($tag, '[') + 1);
            $tag = substr($tag, 0, strpos($tag, "]"));
            $tags = explode(',', $tag);
            foreach ($tags as $replace){
                list($key, $value) = explode('=>', $replace);
                $value = str_replace("'", '', $value);
                $output = str_replace($key, $value, $output);
            }
        }
        return $output;
    }

}
