<?php

namespace lib\form\input;

/**
 * Description of ColorInput
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 23, 2017
 */
class ColorInput extends \lib\form\Input {

    /**
     * Convert input for color picker - jquery plugin $('.input-color').colorpicker();
     * <input type="text" class="input-color" data-color-format="hex" value="GreenYellow">
     * 
     * @param string $field The name and id for the field
     * @return \lib\form\input\ColorInput
     */
    public static function create($field = null)
    {
        $obj = new ColorInput($field, $field);
        $obj->setInputType(self::TYPE_TEXT);
        //$('.input-color').colorpicker();
        $obj->addClass('input-color');
        $obj->setDataAttribute('data-color-format', 'hex');
        
        return $obj;
    }
    
    /**
     * @return string
     */
    public function parseInput()
    {
        $this->attributes();

        $this->input = '<input ' . implode(' ', $this->attributes) . ' />';
        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        return $this->input;
    }

}
