<?php

namespace lib\form\input;

/**
 * Description of FileInput
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jun 16, 2016
 */
class FileInput extends \lib\form\Input {

    protected $type = self::TYPE_FILE;
    
    protected $url = '';
    
    private $allowed = [];

    /**
     * 
     * @param string $field
     * @return \lib\form\input\FileInput
     */
    public static function create($field = null)
    {
        $obj = new FileInput($field, $field);
        $obj->setAllowed(['png', 'jpg']);
        return $obj;
    }
    
    public function setuploadUrl($url){
        $this->url = $url;
        return $this;
    }
    
    public function setAllowed($extensions = []){
        $this->allowed = $extensions;
        return $this;
    }
    
    private $filetype = 'image';
    
    public function setFileType($type){
        $this->filetype = $type;
        return $this;
    }
    
    public function parseInput(){
        /*
         * <input id="input-700" name="kartik-input-700[]" type="file" multiple class="file-loading">
         */
        $this->attributes();
        
        $this->attributes['class'] = 'class="' . $this->class . ' file-input"';
        $this->attributes['value'] = 'value="' . $this->value . '"';
        $this->attributes['data-file'] = 'data-file="' . $this->filetype . '"';
        $this->attributes['data-url'] = 'data-url="'.$this->url.'&default=' . $this->value . '"';
        $this->attributes['data-allowed'] = 'data-allowed="'. implode(',', $this->allowed) . '"';
        //data-allowed-file-extensions='["csv", "txt"]'

        $this->input = '<input '.implode(' ', $this->attributes).'>';
        return $this->input;
    }

}
