<?php

namespace lib\view;



/**
 * Description of Parse
 * Parse the template file
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 18, 2016
 */
class Parse {

    /**
     * Stores the contents of the template file
     * (?!\{\/if)
     * @var string
     */
    private static $output = null;
    
    function __construct($output) {
        self::$output = $output;
    }
    
    /**
     * Open file for template
     * @param string $file
     * @return string
     */
    public static function obFile($file){
        if (null != $file) {
            ob_start();
            include(ROOT . DS . $file);
            $content = ob_get_contents();
            ob_end_clean();
            $content = str_replace(["\n", "\r"], '', $content);
            
            return $content;
        }
        return '';
    }
    
    /**
     * 
     * @return string
     */
    public function reparse() {
        
        return self::$output;
    }
    
    

}
