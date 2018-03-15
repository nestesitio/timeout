<?php

namespace lib\form\input;

use \lib\form\Input;

/**
 * Description of HiddenInput
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 9, 2015
 */
class HiddenInput extends \lib\form\Input
{
    /**
     * @param String $field The db table field name for reerence to input
     * @return HiddenInput
     */
    public static function create($field = null)
    {
        $obj = new HiddenInput($field, $field);
        $obj->setInputType(Input::TYPE_HIDDEN);
        return $obj;
    }

    /**
     * @return string
     */
    public function parseInput()
    {
        $this->attributes();
        unset($this->attributes['class']);

        $this->input = '<input ' . implode(' ', $this->attributes) . '>';
        return $this->input;
    }

}
