<?php

namespace lib\view\parsers;

use \lib\view\Template;

/**
 * Description of ParseCondition
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 24, 2016
 */
class ParseCondition {
    
    const PATTERN_STATEMENTS = "/{@(if|elseif|else|endif){1}[^}]*}/";

    public static function parse($output){
        $pieces = [];
        $matches = [];
        if (preg_match(self::PATTERN_STATEMENTS, $output)) {
            
            preg_match_all(self::PATTERN_STATEMENTS, $output, $matches, PREG_OFFSET_CAPTURE);

            $matches = array_reverse($matches[0], true);
            $length = $offset = 0;
            foreach ($matches as $match) {
 
                $parts = self::decompose($match[0]);
                $length = ($match[0] == '{@endif;}') ? 0 : $offset - $match[1];
                $pieces[] = ['string' => $match[0], 'control' => $parts['control'], 'result' => $parts['condition'], 'offset' => $match[1], 'length' => $length];
                $offset = $match[1];
            }

            $pieces = array_reverse($pieces);
            
            $output = self::parseOutput($output, $pieces);
        }

        return $output;
    }
    
    private static function parseOutput($output, $pieces){
        $start = $pieces[0]['offset'];
        
        $i = 0;
        $flag = false;
        foreach($pieces as $piece){
            $strlength = strlen($piece['string']);
            
             if ($piece['result'] == true) {
                $flag = true;
            } elseif ($flag == false && $piece['control'] == 'else') {
                $flag = true;
            }elseif($piece['control'] != 'endif'){
                 $strlength = $piece['length'] ;
            }
            $output = substr_replace($output, '', $start, $strlength);

           if ($piece['control'] == 'endif') {
                if(isset($pieces[$i + 1])){
                    $start += $pieces[$i + 1]['offset'] - $piece['offset'] - $strlength ;
                }
                $flag= false;
            } else {
                $start += $piece['length'] - $strlength ;
            }
            $i++;
        }
        
        return $output;
    }
    
    private static $control = ['if', 'elseif', 'else', 'endif'];
    
    public static function decompose($match){
        $parts = [];
        $match = str_replace(['{', '}'], '', $match);
        foreach(self::$control as $c){
            if(strpos($match, '@'. $c) === 0){
                $parts['control'] = $c;
            }
        }
        $parts['condition'] = '';
        
        if($parts['control'] == 'if' | $parts['control'] == 'elseif' ){
            $condition = strstr($match, '(');
            $condition = str_replace(['(', ')', ':'], '', $condition);
            
            $parts['condition'] = self::testCondition($condition);
        }
        

        return $parts;
        
    }
    
    private static function testCondition($test){
        
        $result = '';
        $var = self::getVar($test);
        
        $test = self::replaceVar($test, $var);
        
        $result = eval('if('. $test .')return true;');
        return ($result == true)? true : false;
    }


    const PATTERN_VAR = "/\\\${1}[^\s=!]+/";
    
    private static function getVar($test){
        $matches = [];
        preg_match(self::PATTERN_VAR, $test, $matches);
        foreach ($matches as $match){
            //$match = str_replace(['[', ']'], ["['", "']"], $match);
            return $match;
        }
    }
    
    
    private static function replaceVar($output, $var){
        $value = self::testVar($var);
        return str_replace($var, $value, $output);
    }
    
    private static function testVar($var){
        $var = str_replace('$', '', $var);
        
        $value = Template::getData($var);
        
        if(is_array($value)){
            return true;
        }elseif($value == null){
            return 'NULL';
        }else{
            if(is_string($var)){
                return "'" . str_replace(["'"], '', $value) . "'";
            }
            return $value;
        }
    }
    
    
    

}
