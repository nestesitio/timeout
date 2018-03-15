<?php

namespace lib\view;

/**
 * Description of LoadToString
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 7, 2016
 */
class LoadToString {

    private $data = [];
    
    private $content = '';
    
    

    function __construct($file, $data = null) {
        if (file_exists(ROOT . DS . $file)) {
            $this->content = \lib\view\Parse::obFile($file);
            if(null != $data){
                $this->content = \lib\view\parsers\ParseData::parse($this->content, $data);
            }
        }
    }
    
    public function getString() {
        return $this->content;
    }
    
    public static function load($file, $data = null){
        $obj = new LoadToString($file, $data);
        
        return $obj->getString();
    }

}
