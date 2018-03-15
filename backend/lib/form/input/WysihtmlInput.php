<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lib\form\input;

/**
 * Description of WysihtmlInput
 * https://github.com/summernote/summernote
 * 
 * http://summernote.org/deep-dive/
 * $('#summernote').summernote({
  toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']]
  ]
});
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 27, 2015
 */
class WysihtmlInput extends \lib\form\input\TextAreaInput
{
    /**
     * @param String $field The db table field name for reerence to input
     * @return WysihtmlInput
     */
    public static function create($field = null)
    {
        $obj = new WysihtmlInput($field, $field);
        return $obj;
    }
    
    const TOOLBAR_DEFAULT = 'default';
    
    const TOOLBAR_MEDIA = 'withmedia';
    
    const TOOLBAR_RICHTEXT = 'richtext';
    
    const TOOLBAR_SIMPLE = 'simple';
    
    const TOOLBAR_ALL = 'all';

    /**
     * @return string
     */
    public function parseInput()
    {
        $this->class = 'wysihtml';
        $this->attributes();


        $this->input = '<textarea data-toolbar="'.$this->toolbar.'" class="wysihtml" '
                . 'name="'.$this->elemid.'" id="'.$this->elemid.'"'
                . 'style="width:100%">' . $this->value . '</textarea>';
        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        return $this->input;
    }
    
    private $toolbar = 'default';
    
    public function setToolbar($toolbar){
        $this->toolbar = $toolbar;
    }
    
    public function getValue() {
        $value = filter_input(INPUT_POST, $this->getPostKey(), FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW);
        //$value = strip_tags($value, $allowable_tags);
        return $value;
    }

}
