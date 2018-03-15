<?php

namespace lib\form\input;

/**
 * Description of CheckInput
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 11, 2015
 */
class CheckBoxInput extends \lib\form\Input
{
    /**
     * @param String $field The db table field name for reerence to input
     * @return CheckBoxInput
     */
    public static function create($field = null)
    {
        $obj = new CheckBoxInput($field, $field);
        return $obj;
    }

    /**
     * @return string
     */
    public function parseInput()
    {
        $this->attributes();
        /*' <input type="checkbox" name="vehicle" value="Bike">I have a bike<br> '*/

        $this->input = '<input type="checkbox" ' . implode(' ', $this->attributes) . ' />' . $this->value;
        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        return $this->input;
    }

}
