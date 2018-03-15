<?php

namespace lib\view\parsers;

use \lib\view\Tags;

/**
 * Description of ParseBlock
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 30, 2016
 */
class ParseBlock {

    /**
     * Keep the blocks available
     * @var array
     */
    private static $blocks = [];
    
    /**
     * @var string
     */
    const PATTERN_BLOCKS = "/{@block name='([^']*)'}/";
    
    /**
     * Parse the html looking for blocks and keep they in array $blocks
     * 
     * @param string $output
     * @return string
     */
    public static function parse($output){
        $matches = [];
        if (preg_match(Tags::PATTERN_BLOCKS, $output)) {
            preg_match_all(Tags::PATTERN_BLOCKS, $output, $matches, PREG_SET_ORDER);
            
            foreach ($matches as $match) {
                
                $piece = self::getPiece($output, $match[0]);
                
                $id = $match[1];
                if(isset(self::$blocks[$id])){
                    self::$blocks[$id] .= $piece;
                }else{
                    self::$blocks[$id] = $piece;
                }
               
                $output = str_replace($match[0] . $piece . Tags::PATTERN_ENDBLOCK, '', $output);
            }
            
        }
        return $output;
    }
    
    /**
     * 
     * @param string $output
     * @param string $match
     * @return string
     */
    private static function getPiece($output, $match){
        $piece = substr($output, strpos($output, $match));
        $piece = substr($piece, 0, strpos($piece, Tags::PATTERN_ENDBLOCK));
        return str_replace($match, '', $piece);
    }
    
    
    /**
     * Replace tags form their correspondent blocks
     * 
     * @param string $output
     * @return string
     */
    public static function put($output){
        foreach(self::$blocks as $key => $content){
            
            if($key == 'css'){
                $output = str_replace(Tags::TAG_BLOCK_CSS, $content, $output);
            }else if($key == 'js'){
                $output = str_replace(Tags::TAG_BLOCK_JS, $content, $output);
            }  else {
                
                $tag = str_replace('name', $key, Tags::TAG_PUTBLOCK);
                //function preg_replace ($pattern, $replacement, $subject, $limit = -1, &$count = null) {}
                $output = str_replace($tag, $content, $output);
            }
        }
        
       
        $output = str_replace(Tags::TAG_BLOCK_CSS, '', $output);
        $output = str_replace(Tags::TAG_BLOCK_JS, '', $output);
        if (preg_match(Tags::PATTERN_PUTBLOCK, $output)) {
            $output = preg_replace(Tags::PATTERN_PUTBLOCK, '', $output);
        }
        
        
        return $output;
    }

}
