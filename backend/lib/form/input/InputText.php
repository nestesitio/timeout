<?php

namespace lib\form\input;

/**
 * Description of InputText
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 5, 2014
 */
class InputText extends \lib\form\Input
{
    /**
     * @var null
     */
    private $disabled = null;

    /**
     * @param String $field The db table field name for reerence to input
     * @return InputText
     */
    public static function create($field = null)
    {
        $obj = new InputText($field, $field);
        return $obj;
    }

    /**
     * @return $this
     */
    public function setDisabled()
    {
        $this->disabled = true;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setDisabledValue($value)
    {
        $this->disabledvalue = $value;
        $this->value = $value;
        return $this;
    }


    /**
     * @return string
     */
    private function parseEnabled()
    {
        $this->attributes();

        $this->input = '<input ' . implode(' ', $this->attributes) . ' />';
        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        return $this->input;
    }

    /**
     * @return string
     */
    private function parseDisabled()
    {
        $this->attributes();
        $class = $this->attributes['class'];
        unset($this->attributes['class']);
        $this->input = '<input type="hidden" ' . implode(' ', $this->attributes) . '>';
        unset($this->attributes['type']);
        unset($this->attributes['id']);
        unset($this->attributes['name']);
        unset($this->attributes['value']);
        $this->input .= '<input id="'.$this->name.'_disabled" '
                . $class . ' type="text" ' . implode(' ', $this->attributes)
                . ' value="' . $this->disabledvalue . '" disabled />';

        return $this->input;
    }


    /**
     * @return string
     */
    public function parseInput()
    {
        if($this->disabled == true){
            return $this->addon_l . $this->parseDisabled() . $this->addon_r;
        }else{
            return $this->addon_l . $this->parseEnabled() . $this->addon_r;
        }
    }



}
